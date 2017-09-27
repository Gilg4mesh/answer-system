@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            管理员界面
            <small>评论</small>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <div class="col-lg-10 col-lg-offset-1">
            <h1>
                &nbsp;
                评论列表
            </h1>

            <table class="table table-hover table-bordered">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Comment</th>
                    <th>Date</th>

                </tr>
                @foreach( $comments as $comment)
                    <tr>
                        <th>{{$comment['id']}}</th>
                        <th>{{$comment['user_id']}}</th>
                        <th>{{$comment['comment']}}</th>
                        <th>{{$comment['created_at']}}</th>

                    </tr>
                @endforeach
            </table>
        </div>
    </section>
@endsection