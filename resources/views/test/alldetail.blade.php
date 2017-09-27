@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                @unless($point==100)
                    <a href={{"/test/$test_id/details"}} class="text-warning">点击仅查看错题</a>
                @endunless
                <h2 >答题详情</h2>
                @for($i=0;$i<$total;$i++)
                   @include('test.detail_form')
                @endfor
            </div>
        </div>
    </div>


@endsection