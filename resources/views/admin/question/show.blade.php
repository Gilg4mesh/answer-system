@extends('admin.layout')
@section('content')
    <div class="container">
        <div class="row">

            <div class="col-md-10 col-md-offset-1">

                <h1></h1>

                <!--显示ID 与上一题下一题-->
                <h2>
                    <a href="/admin/question">
                        <i class="fa fa-fw fa-hand-o-left"></i>
                    </a>
                    ID:
                    @if($next!=null)
                        <a class="btn btn-lg" href="{{url("/admin/question/".$next)}}"
                           style="padding:0px 4px;font-size:40px">
                        <span class="fa fa-fw fa-arrow-circle-left text-info"
                              style="position: relative; left: 10px;"></span>
                        </a>
                    @endif
                    &nbsp;
                    {{$question->id}}
                    @if($previous!=null)
                        <a class="btn btn-lg" href="{{url("/admin/question/".$previous)}}"
                           style="padding:0px 4px;font-size:40px">
                        <span class="fa fa-fw fa-arrow-circle-right text-warning"
                              style="position: relative; left: 20px"></span>
                        </a>
                    @endif

                    <a class="btn btn-lg" href="/admin/question/{{$question->id}}/edit"
                       style="padding:0px 4px;font-size:40px">
                        <span class="fa fa-fw fa-pencil"
                              style="position: absolute;top:40px; right: 0px;"></span>
                    </a>
                </h2>

                <!--如果TAG存在则显示TAG-->
                @if(count($tags)!=0)
                    <div class="row">
                        <div class="col-md-4">
                            <h2 class="text-center">Tags:</h2>
                        </div>
                        <div class="col-md-8">
                            <p class="lead" style="position: absolute;OVERFLOW: auto; CURSOR: default;top:25px;">
                                @foreach($tags as $tag)
                                    {{$tag}}.
                                    &nbsp;
                                @endforeach
                            </p>
                        </div>
                    </div>
                @endif

            <!--显示题目-->
                <div class="row">
                    <div class="col-md-4">
                        <h2 class="text-center">Title:</h2>
                    </div>
                    <div class="col-md-8 ">
                        <p class="lead ">
                            {!! $parsedown->text($question->title) !!}
                        </p>

                    </div>

                </div>
                <p></p>

                <!--显示选项-->
                @foreach(explode("\r\n",$question->options) as $option)
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="text-center">{{substr($option,0,2)}}</h3>
                        </div>
                        <div class="col-md-8">
                            <p class="lead" style="position: absolute;OVERFLOW: auto; CURSOR: default;top:30px;">
                                {{substr($option,2)}}
                            </p>
                        </div>
                    </div>

                @endforeach

            <!--根据不同的类型显示答案-->
                <div class="row">
                    <div class="col-md-4">
                        <h3 class="text-center">答案:</h3>
                    </div>
                    <div class="col-md-8">
                        <p class="lead" style="position: relative;top:20px">
                            @if($question->qtype_id==2)
                                {{implode(", ",json_decode($question->answer))}}
                            @elseif($question->qtype_id==3)
                                @if($question->answer=='0')
                                    错
                                @else
                                    对
                                @endif
                            @elseif($question->qtype_id==4||$question->qtype_id==5)
                                {!! $parsedown->text($question->answer)!!}
                            @else
                                {{$question->answer}}
                            @endif
                        </p>
                    </div>
                </div>

                <!--有解析的时候显示解析-->
                @if($question->parse!=null)
                    <div class="row">
                        <div class="col-md-4">
                            <h3 class="text-center">解析:</h3>
                        </div>
                        <div class="col-md-8">
                            <p class="lead">
                                {!! $parsedown->text($question->parse) !!}
                            </p>
                        </div>
                    </div>
                @endif


            </div>
        </div>
    </div>

@endsection