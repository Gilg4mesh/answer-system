<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Question;
use App\Tag;
use App\User;
class AdminController extends Controller
{

    private $sidearr=[['1'],['0',['0','0']],['0'],['0']];
    /**
     * AdminController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
        
    }

    /**
     * 
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $sidearr=$this->sidearr;
        return view('admin.index',compact('sidearr'));
    }
    
    
    public function users()
    {
        $sidearr=$this->sidearr;
        $sidearr[0][0]=0;
        $sidearr[2][0]=1;
        $sidearr[3][0]=0;
        $users=User::all()->toArray();
        return view('admin.users',compact('sidearr','users'));
        
    }
}
