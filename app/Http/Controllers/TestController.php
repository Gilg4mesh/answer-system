<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Question;
use App\Test;
use App\Tag;
use Parsedown;
use App\Qtype;

class TestController extends Controller
{

    /**
     * TestController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * show test.index
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $tags_all = Tag::all();
        $tags[1] = "范围不限";
        foreach($tags_all as $tag)
        {
            if(count($tag->questions)!=0&&$tag->name!="Default")
                $tags[$tag->id]=$tag->name;
        }

        return view('test.index', compact('tags'));
    }


    /**
     * 点击确认答题后的操作，确定试卷上的题目，模型链接等。
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function prepare(Request $request)
    {
        //获取表单中提交的答题数目以及测试方式。
        $tag_list = $request->get('tag_list');
        $testType = $request->get('testtype');
        $totalNumber = $request->get('totalnumber');
        //得到所有要答的题目的id号。
        $questionids = Test::generateQuestion($tag_list, $testType, $totalNumber);

        $totalNumber = count($questionids);//由于现在题量可能不够，实际获取的题目可能不是用户设置的题目。
        $test = new Test;
        $test->user_id = $request->user()->id;
        $test->testtype = $testType;
        $test->totalnumber = $totalNumber;
        if ($tag_list == 0)
            $test->tagtype = "范围不限";
        else {
            $test->tagtype = Tag::find($tag_list)->name;
        }
        $test->save();
        foreach ($questionids as $q_id) {
            $question = Question::find($q_id);
            $test->questions()->attach($question);
        }
        $test->questionids = json_encode($questionids);
        $test->save();
        return redirect("/test/$test->id/1");
    }


    /**
     * 显示每一道题
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Request $request, $test_id, $id)
    {
        $test = Test::find($test_id);
//        if ($test->ended_at != "0000-00-00 00:00:00" || $request->user()->id != $test->user->id)
//            return view('errors.404');
        $question_ids = json_decode($test->questionids, true);
        $parsedown = new Parsedown();
        $qtypes = Qtype::pluck('name', 'id')->toArray();
        $question = Question::find($question_ids[$id]);
        return view('test.show', array_merge($question->toArray(), ['total' => ($test->totalnumber), 'question_id' => $id, 'test_id' => $test_id, 'parsedown' => $parsedown, 'qtypes' => $qtypes]));
    }

    /**
     * 点击next，保存当前结果，显示下一题
     *
     * @param Request $request
     * @param $test_id
     * @param $id
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function next(Request $request, $test_id, $id)
    {

        $test = Test::find($test_id);
        $questionids = json_decode($test->questionids, true);
        $totalNumber = $test->totalnumber;
        $useranswer = json_decode($test->useranswer, true);


        //多选的情况为了方便将数组转为json形式
        if ($request->qtype_id == 2)
            $useranswer[$questionids[$id]] = json_encode($request->get('answer'));
        else
            $useranswer[$questionids[$id]] = $request->get('answer');


        $test->useranswer = json_encode($useranswer);

        $test->save();
        if ($id == $totalNumber)   //达到最后一条了
            return redirect("test/$test_id/judge"); // 转到判断页面
        else {
            $id = $id + 1;
            return redirect("test/$test_id/$id");
        }
    }


    /**
     * 判断答题结果，计算分数并储存
     *
     * @param $test_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function judge($test_id)

    {
        $test = Test::find($test_id);
         if ($test->ended_at != "0000-00-00 00:00:00")
           return view('errors.404');

        $test->ended_at = date("Y-m-d H:i:s");

        $total = $test->totalnumber;
        $questions = $test->questions();
        $referanswer = $questions->pluck('answer', 'id')->toArray();//获取每道题的答案
        $qtypes = $questions->pluck('qtype_id', 'id')->toArray();//获取每道题的类型
        $useranswer = json_decode($test->useranswer, true);//获取每次测试的用户答案
        $questionids = json_decode($test->questionids, true);//获取题号

        $num = 0;

        //对每一道题目，根据不同的类型进行判断
        foreach ($questionids as $q_id) {
            switch ($qtypes[$q_id]) {
                case 2://多选题
                    $ua = json_decode($useranswer[$q_id]);//获取用户答案的数组
                    $ra = json_decode($referanswer[$q_id]);//获取参考答案的数组
                    $ur = array_diff($ua, $ra);
                    $ru = array_diff($ra, $ua);
                    if ($ur == [] && $ru == []) {//全答对得到全部的分数
                        $n = 1;
                        $answer[] = 1;
                    } elseif ($ur == [] && $ua != []) {//不全得一半
                        $answer[] = 0;
                        $n = 1 / 2;
                    } else {//答错不得分
                        $answer[] = 0;
                        $n = 0;
                    }
                    $num = $num + $n;
                    break;
                case 4://填空题
                    $ua = str_replace(" ", "", $useranswer[$q_id]);//去掉所有的空格
                    $ra = str_replace(" ", "", $referanswer[$q_id]);

                    if (strcasecmp($ua, $ra) == 0) {
                        $num++;
                        $answer[] = 1;
                    } else {
                        $answer[] = 0;
                    }
                    break;

                case 5://简答题
                    $num++;
                    $answer[] = 1;
                    break;
                default:    //单选题和判断题，一样的话是对的，否则答题错误
                    if ($useranswer[$q_id] == $referanswer[$q_id]) {
                        $num++;
                        $answer[] = 1;
                    } else
                        $answer[] = 0;
            }

        }
        $test->judges = json_encode($answer);
        $point = round((100 / $total) * $num);
        $test->point = $point;
        $test->save();
        return view('test.judge', compact('total', 'answer', 'point', 'test_id'));
    }


    /**
     * 用于显示所有的错题
     *
     * @param $test_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function detail(Request $request, $test_id)
    {
        return $this->detailBase($request,$test_id,'detail');
    }


    /**
     * 用于显示所有的题目，包括正确的题目与错误的题目
     *
     * @param $test_id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function allDetail(Request $request,$test_id)
    {
        return $this->detailBase($request,$test_id,'alldetail');
    }

    /**
     * detial画图的基础函数,显示所有的错题和显示全部的题目仅是最后调用的模板不一样，其余都是一样的。
     *
     * @param Request $request
     * @param $test_id
     * @param $type
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    private function detailBase($request,$test_id,$type)
    {
        $parsedown = new Parsedown();
        $test = Test::find($test_id);

        if ($request->user()->id != $test->user->id)
            return view('errors.404');
        $total = $test->totalnumber;
        $point = $test->point;
        $questions = $test->questions->toArray();
        $useranswer = json_decode($test->useranswer, true);
        $questionids = json_decode($test->questionids, true);
        $judges = json_decode($test->judges, true);
        return view("test.$type", compact('total', 'questions', 'useranswer', 'questionids', 'test_id', 'parsedown', 'point', 'judges'));

    }



}
