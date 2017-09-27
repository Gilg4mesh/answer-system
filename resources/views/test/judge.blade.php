@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="jumbotron">
            <h3>测试结果</h3>
            @if($point==100)
                <h4>Excellent!您得了100分!</h4>
            @elseif($point>=85)
                <h4>Great!您得了{{$point}}分！</h4>
            @elseif($point>=60)
                <h4>Good!您得了{{$point}}分！</h4>
            @else
                <h4>继续努力!您得了{{$point}}分！</h4>
            @endif
            <h4>一共{{$total}}道题，您答对了{{array_sum($answer)}}道</h4>

            @if($point==100)
                <a class="text-warning" href={{"/test/$test_id/alldetails"}}>点击查看答题详情</a>
            @else
                <a class="text-danger" href={{"/test/$test_id/details"}}>点击查看错题详情</a>
            @endif
        </div>
    </div>
@endsection