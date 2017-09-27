<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Tag;
use App\Question;

class TagController extends Controller
{

    private   $sidearr=[['0'],['1',['0','1']],['0'],['0']];

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
        $tags=Tag::all();
        $sidearr=$this->sidearr;
        return view('admin.tag',compact('sidearr','tags'));
    }
    
    
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $sidearr=$this->sidearr;
        return view('admin.tag.create',compact('sidearr'));
    }


    /**
     * 显示tag界面
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($id)
    {
        $tag_list = Tag::pluck('name', 'id');
        $tag = Tag::find($id);
        $questions = $tag->questions;
        $sidearr=$this->sidearr;
        return view('admin.tag.show', compact('tag', 'tag_list', 'questions','sidearr'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, ['name' => 'required|unique:tags']);
        Tag::create($request->all());
        flash()->success("Tag新建成功");
        return redirect('admin/tag');

    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $tag = Tag::find($id);
        $sidearr=$this->sidearr;
        return view('admin.tag.edit', compact('tag','sidearr'));
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
        //
        $this->validate($request, ['name' => 'required|unique:tags|max:15']);
        $tag = Tag::find($id);
        $tag->name = $request->get("name");

        if ($tag->save()) {
            flash()->success("Tag更新成功");
            return redirect('/admin/tag');//编辑成功返回article页面
        } else
            return redirect()->back()->withInput()->withErrors('更新失败！');//失败则返回上一个页面，保留用户信息
    }

    /**
     * @param Request $request
     * @return $this
     */
    public function delete(Request $request)
    {
        $tagids = $request->get("tag_id");
        foreach ($tagids as $id) {
            Tag::find($id)->delete();
        }
        flash()->success("Tag删除成功");
        return redirect()->back()->withInput()->withErrors('删除成功！');
    }


    /**
     * 对标签进行批量操作：赋值或者去除关系
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function operate(Request $request, $id)
    {
        $type = $request->get('type');
        $question_ids = $request->get('question_id');
        $questions = Question::find($question_ids);

        switch ($type) {
            case 0:     //0解除标签时，需要判断解除后问题的标签是否为空，如果是的话需要添加默认的default标签
                $tag = Tag::findorFail($id);
                $tag->questions()->detach($question_ids);
                foreach ($questions as $question) {
                    if (count($question->tags) == 0)
                        $question->tags()->attach(1);
                }
                break;
            case 1:       //1新增标签时，需要判断此时的标签是否为defalut，如果是的话选择同步

                $tag_id = $request->get('tag_list');
                if ($id == 1) {
                    foreach ($questions as $question) {
                        $question->tags()->sync([$tag_id]);
                    }
                } else {
                    foreach ($questions as $question) {
                        $question->tags()->attach($tag_id);
                    }
                }
                break;
            case 2:
                $tag_id = $request->get('tag_list');

                foreach ($questions as $question) {
                    $question->tags()->sync([$tag_id]);
                }
                break;
        }
        return redirect()->back();
    }
}
