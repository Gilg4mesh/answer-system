@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            管理员界面
            <small>用户</small>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <div class="col-lg-10 col-lg-offset-1">
            <h1>
                &nbsp;
                用户列表
            </h1>

            <table class="table table-hover table-bordered">
                <tr>
                    <th>ID</th>
                    <th>User</th>
                    <th>Email</th>
                    <th>Date</th>

                </tr>
                @foreach( $users as $user)
                    <tr>
                        <th>{{$user['id']}}</th>
                        <th>{{$user['name']}}</th>
                        <th>{{$user['email']}}</th>
                        <th>{{$user['created_at']}}</th>

                    </tr>
           @endforeach
            </table>
    </div>
    </section>
    @endsection