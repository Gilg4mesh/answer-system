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


        <div class="col-lg-12 ">

            <div class="col-md-10 col-md-offset-1">
                <h1>
                    &nbsp;
                    题目列表
                    <a>
                            <span id="add" class="fa fa-fw fa-plus-circle"
                                  style="position: absolute; top:30px;left: 250px;right: 60px;"></span>
                    </a>
                    <a href="/admin/question/create/1">
                        <img id="add1" src="{{URL::asset('assets/dist/img/icons/admin/1.png')}}"
                             style="position: absolute;top:30px;left: 183px;height: 50px;weight:50px;"/>
                    </a>
                    <a href="/admin/question/create/2">
                        <img id="add2" src="{{URL::asset('assets/dist/img/icons/admin/2.png')}}"
                             style="position: absolute;top:-19px;left: 204px;height: 50px;weight:50px;"/>
                    </a>
                    <a href="/admin/question/create/3">
                        <img id="add3" src="{{URL::asset('assets/dist/img/icons/admin/3.png')}}"
                             style="position: absolute;top:-40px;left: 250px;height: 50px;weight:50px;"/>
                    </a>
                    <a href="/admin/question/create/4">
                        <img id="add4" src="{{URL::asset('assets/dist/img/icons/admin/4.png')}}"
                             style="position: absolute;top:-19px;left: 296px;height: 50px;weight:50px;"/>
                    </a>
                    <a href="/admin/question/create/5">
                        <img id="add5" src="{{URL::asset('assets/dist/img/icons/admin/5.png')}}"
                             style="position: absolute;top:30px;left: 310px;height: 50px;weight:50px;"/>
                    </a>
                </h1>
            </div>


            <!--Question内容主体-->
            <div class="container col-lg-12 ">
                <form method="POST" action="/admin/question/delete" accept-charset="UTF-8" >
                    {!! csrf_field() !!}




                    <div class="container form-group row "  >
                        @foreach($questions as $question)

                            <div class="col-md-10 col-md-offset-1">
                                <label class="checkbox ">
                                    <input type="checkbox" data-toggle="checkbox"
                                           value={{$question->id}} name="question_id[]">
                                    <h4 style="overflow: hidden; text-overflow:ellipsis;white-space:nowrap;">
                                        <a href="/admin/question/{{$question->id}}">
                                            <strong>{{$question->id}}</strong>
                                            &nbsp;
                                            {{$question->title}}
                                        </a>
                                    </h4>

                                </label>
                            </div>
                            <div class="col-md-1">
                                <h4>
                                    <a href="/admin/question/{{$question->id}}/edit" class="btn btn-sm"
                                       style="padding:0px 4px;font-size:20px;">
                                                <span class="fa fa-fw fa-pencil "
                                                ></span>
                                    </a>
                                </h4>
                            </div>

                        @endforeach
                    </div>
                    <div class="container row">
                     <div class="row text-center col-md-5 col-md-offset-1 text-center">
                        <button type="submit" class="btn btn-primary btn-block">Delete</button>
                    </div>
                        <div class="container col-md-5 col-md-offset-1 text-center" >
                            {!! $questions->links() !!}
                        </div>
                        </div>


                </form>



            </div>
        </div>
    </section><!-- /.content -->


    <!-- Main content -->


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