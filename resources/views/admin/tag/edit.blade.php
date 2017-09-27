@extends('admin.layout')
@section('content')
    <br/>
    <br/>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">更新一个Tag</div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>更新失败</strong> 输入不符合要求<br><br>
                                {!! implode('<br>', $errors->all()) !!}
                            </div>
                        @endif

                        {!! Form::model($tag,['class'=>'form-horizontal','method'=>'PATCH','action'=>['TagController@update',$tag->id]]) !!}

                            <div class="form-group">
                                <label class="col-sm-2 control-label"><strong>ID : {{$tag->id}}</strong></label>
                                <div class="col-sm-10">
                                    <input type="text" name="name" class="form-control" required="required"
                                           value="{{$tag->name}}">
                                </div>
                            </div>
                        <input type="submit" class="btn btn-lg btn-info" value="更新Tag">
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
