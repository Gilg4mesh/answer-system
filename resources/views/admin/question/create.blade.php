@extends('admin.layout')
@section('content')
<br/>

    <div class="container">

        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <h1>Wirte a New Question：{{$qtypes[$qtype]}}</h1>
                <hr/>
                {{Form::open(['url'=>"/admin/question",'class'=>'form-horizontal'])}}
                @include("admin.question.form.$qtype",['submitButton'=>'Add Question'])
                {{Form::close()}}
                @include('errors.list')
            </div>
        </div>
    </div>
@endsection

