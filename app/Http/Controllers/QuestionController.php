<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Tag;
use Parsedown;
use App\Qtype;

class QuestionController extends Controller
{

    private   $sidearr=[['0'],['1',['1','0']],['0'],['0']];

    /**
     * QuestionController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }


    /**
     * 显示问题主界面
     * 
     */
    public function index()
    {
        $questions=Question::orderBy('id','dsec')->paginate(10);
//        dd($questions);
        $sidearr=$this->sidearr;
        return view('admin.question',compact('sidearr','questions'));
    }
    
    
    
    /**
     * how the form for creating a new resource.
     * 
     * @param $qtype：新建题目类型
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($qtype)
    {
        $tag_list = Tag::pluck('name', 'id')->toArray();
        $qtypes=Qtype::pluck('name','id')->toArray();
        $sidearr=$this->sidearr;

        return view('admin.question.create', compact('tag_list','qtype','qtypes','sidearr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $question = Question::create($request->except(['tag_list','answer']));
        $tags=$request->input('tag_list');

        if($request->qtype_id==2)
            $question->answer=json_encode($request->answer);
        else
            $question->answer=$request->answer;

        $question->save();
        if(is_null($tags))
            $tags[]=1;
        $question->tags()->sync($tags);
        
        flash()->success("问题发布成功");
        return redirect('/admin/question');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $sidearr=$this->sidearr;
        $question = Question::find($id);
        if($question==null)
        {
            flash()->success("已经是第一题/最后一题");
            return redirect()->back();
        }

        $parsedown = new Parsedown();
        $tags = $question->tags->pluck('name');
        $previous=Question::where('id','<',$question->id)->max('id');
        $next=Question::where('id','>',$question->id)->min('id');

        return view('admin.question.show', compact('question', 'tags', 'parsedown','previous','next','sidearr'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $question = Question::findOrFail($id);
        $tag_list = Tag::pluck('name', 'id')->toArray();
        $qtypes=Qtype::pluck('name','id')->toArray();
        $tag = $question->tags()->pluck('id')->toArray();
        $sidearr=$this->sidearr;
        return view('admin.question.edit', compact('question', 'tag_list', 'tag','qtypes','sidearr'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {


        $question = Question::findOrFail($id);
        $question->update($request->except(['tags','answer']));
        if($request->qtype_id==2)
            $question->answer=json_encode($request->answer);
        else
            $question->answer=$request->answer;
        $question->save();
        $tags=$request->input('tag_list');
        if(is_null($tags))
            $tags[]=1;
        $question->tags()->sync($tags);
        flash()->success("问题修改成功");
        return redirect('/admin/question');
    }


    /**
     * @param Request $request
     * @return $this
     */
    public function delete(Request $request)
    {

        $questionids = $request->get("question_id");
        foreach ($questionids as $id) {
            Question::find($id)->delete();
        }
        flash()->success("问题删除成功");
        return redirect()->back()->withInput()->withErrors('删除成功！');
    }


   

}
