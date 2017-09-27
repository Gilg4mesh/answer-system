@extends('admin.layout')
@section('content')
    <br/>
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h1>Edit Question：{{$question->id." ".$qtypes[$question->qtype_id]}}</h1>
                <hr/>

                {!!  Form::model($question,['method'=>'PATCH','url'=>"/admin/question/$question->id",'class'=>'form-horizontal'])!!}
                @include("admin.question.form.$question->qtype_id",['submitButton'=>'Update Question'])
                {!! Form::close()!!}
                @include('errors.list')
            </div>
        </div>
    </div>


@endsection
