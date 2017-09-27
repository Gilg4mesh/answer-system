@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <h1>测试</h1>
            <p>准备好了么~开始答题吧！</p>
            {!! Form::open(['url' => '/test']) !!}
            <div class="row form-horizontal">
                {!! Form::label('tag_list','请选择范围：',['class'=>'col-lg-2 control-label ']) !!}
                <div class="col-lg-2" >
                    {!! Form::select('tag_list', $tags, 0, ['id'=>'totalnumber','class' => 'form-control']) !!}
                </div>

                {!! Form::label('totalnumber','请选择题量：',['class'=>'col-lg-2 control-label ']) !!}
                <div class="col-lg-2" >
                    {!! Form::select('totalnumber', [5=>5,10=>10,20=>20,0=>'全部'], 0, ['id'=>'totalnumber','class' => 'form-control']) !!}
                </div>

                {!! Form::label('testtype','请选择类型：',['class'=>'col-lg-2 control-label ']) !!}
                <div class="col-lg-2" >
                    {!! Form::select('testtype', ["随机","顺序"], 0, ['id'=>'testtype','class' => 'form-control']) !!}
                </div>
            </div>
            <br/>
            {!! Form::submit('START', ['class' => 'btn btn-primary form-control']) !!}
            {!! Form::close() !!}
        </div>
    </div>
@endsection