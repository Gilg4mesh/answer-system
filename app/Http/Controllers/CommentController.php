<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Comment;
class CommentController extends Controller
{

    private $sidearr=[['0'],['0',['0','0']],['0'],['1']];
    public function index()
    {
        $sidearr=$this->sidearr;
        $comments=Comment::orderBy('created_at','desc')->get()->toArray();
        return view('admin.comments',compact('sidearr','comments'));
        
    }
}
