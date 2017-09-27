@extends('admin.layout')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <h2>
                    <a href="/admin/tag">
                        <i class="fa fa-fw fa-hand-o-left"></i>
                    </a>
                    ID: {{$tag->id}}
                    &nbsp;&nbsp;&nbsp;
                    Tag: {{$tag->name}}
                    <a class="btn btn-lg" href="/admin/tag/{{$tag->id}}/edit"
                       style="padding:0px 4px;font-size:40px">
                        <span class="fa fa-fw fa-pencil"
                              style="position: absolute;top:40px; right: 0px;"></span>
                    </a>
                </h2>
                <h2>Questions:</h2>

                {!! Form::open(['url' => "/admin/tag/operate/$tag->id"]) !!}
                <div class="col-md-10 col-md-offset-1">
                @foreach($questions as $question)


                    <label class="checkbox ">

                        <input type="checkbox" data-toggle="checkbox" value={{$question->id}} name="question_id[]">

                        <a href="/admin/question/{{$question->id}}">
                            <p class="text-muted" style="overflow: hidden; text-overflow:ellipsis;white-space:nowrap;">
                                <strong>{{$question->id}}</strong>
                                &nbsp;
                                {{$question->title}}
                            </p>
                        </a>
                        </label>
                @endforeach
                </div>
                <div class="row form-horizontal">
                    {!! Form::label('type','请选择操作：',['class'=>'col-lg-3 control-label lead']) !!}
                    <div class="col-lg-3">
                        {!! Form::select('type', ($tag->id==1)?[1=>"批量增加Tag"]:[0=>"批量解除当前Tag",1=>"批量增加Tag",2=>"批量重置Tag"], 0, ['onchange'=>"show(this)",'id'=>'type','class' => 'form-control']) !!}
                    </div>
                    <div id="haha" @if($tag->id!=1) style="display: none"@endif>
                        {!! Form::label('tags',"请选择Tag：",['class'=>'col-lg-3 control-label lead']) !!}
                        <div class="col-lg-3">
                            {!! Form::select('tag_list', $tag_list,$tag->id, ['id'=>'testtype','class' => 'form-control']) !!}
                        </div>
                    </div>
                </div>
                <br/>

                <div class="row">
                    <div class="col-md-4 col-md-offset-1">
                        {!! Form::submit('确定', ['class' => 'btn btn-primary btn-block']) !!}
                    </div>
                    <div class="col-md-4 col-md-offset-2">
                        {!! Form::reset('重置', ['class' => 'btn btn-default btn-block ']) !!}
                    </div>
                </div>


                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection

@section('footer')
    <script language=javascript>
        function show(obj) {
            document.getElementById("haha").style.display = (obj.value != 0) ? "" : "none"
        }
    </script>
@endsection