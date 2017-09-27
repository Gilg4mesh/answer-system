@extends('admin.layout')
@section('content')
    <div class="container">
        <br/>
        <br/>
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <div class="panel panel-default">
                    <div class="panel-heading">新增一个Tag</div>
                    <div class="panel-body">
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>新增失败</strong> 输入不符合要求<br><br>
                                {!! implode('<br>', $errors->all()) !!}
                            </div>
                        @endif
                        <form action="{{ url('admin/tag') }}" method="POST">

                            {!! csrf_field() !!}
                            <input type="text" name="name" class="form-control" required="required" placeholder="请输入Tag">
                            <br/>
                            <input type="submit" class="btn btn-flat btn-info" value="新增Tag">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection