@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            管理员界面
            <small>题库</small>
        </h1>

    </section>

    <!-- Main content -->
    <section class="content">

        <div class="col-lg-10 col-lg-offset-1">
            <h1>
                &nbsp;
                Tag列表
                <a href="/admin/tag/create" class=".btn .btn-lg">
                    <span class="fa fa-fw fa-plus-circle"></span>
                </a>
            </h1>
            <div class="container col-lg-12">
                <form method="POST" action="/admin/tag/delete" accept-charset="UTF-8" >
                    {!! csrf_field() !!}
                    <div class="form-group" style="height: 500px;overflow: auto">


                        @foreach($tags as $tag)
                            <div class="col-md-10 col-md-offset-1">
                                <label class="checkbox ">
                                    <input type="checkbox" class="minimal-red" data-toggle="checkbox" name="tag_id[]" value={{$tag->id}}>
                                    <h4 style="overflow: hidden; text-overflow:ellipsis;white-space:nowrap;">
                                        <a href="/admin/tag/{{$tag->id}}">
                                           <strong>{{$tag->name}}</strong>
                                        </a>
                                        <a href="/admin/tag/{{$tag->id}}/edit" class="btn btn-sm"
                                           style="padding:0px 4px;font-size:20px;">
                                            <span class="fa fa-fw fa-pencil"
                                                  style="position: absolute;OVERFLOW: auto; CURSOR: default;left: 300px;right: 0px;"></span>
                                        </a>
                                    </h4>
                                </label>
                            </div>






                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-lg btn-primary">Delete</button>
                </form>

            </div>
        </div>
    </section><!-- /.content -->
@endsection


@section('footer')
    <script>
        $("#add1").hide();
        $("#add2").hide();
        $("#add3").hide();
        $("#add4").hide();
        $("#add5").hide();
        $("#add").click(function () {
            var t;
            t = 50;
            $("#add1").fadeToggle(t);
            $("#add2").delay(t).fadeToggle(t);
            $("#add3").delay(2 * t).fadeToggle(t);
            $("#add4").delay(3 * t).fadeToggle(t);
            $("#add5").delay(4 * t).fadeToggle(t);
        });
    </script>
@endsection