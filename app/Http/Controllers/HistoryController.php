<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class HistoryController extends Controller
{
    //
    /**
     * HistoryController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(Request $request)
    {
        $user=$request->user();
        $tests=$user->tests()->where('point','>',-1)->orderby('id','desc')->get()->toArray();//只选取完整的测试。

        if(count($tests)==0)
        {
            flash()->warning("您还没有进行测试");
            return redirect()->back();
        }
        $points=array_column($tests,'point');//由于图表解析的特殊性，必须要转为整型
        $p=[];
        foreach ($points as $point)         
            $p[]=intval($point);
        $points=json_encode($p);
        return view('history.index',compact('tests','points'));
        
    }

}
