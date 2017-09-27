@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">

                <div id="container" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
                <br/>



                <table class="table table-hover table-bordered">
                    <tr>
                        <th>测试ID</th>
                        <th>测试时间</th>
                        <th>答题时长</th>
                        <th>题量</th>
                        <th>范围</th>
                        <th>答题类型</th>
                        <th>分数</th>
                        <th>详情</th>
                    </tr>
                    @foreach ($tests as $test)
                        <tr>
                            <th> {{$test['id']}}</th>
                            <th>{{$test['created_at']}}</th>
                            <th>{{gmdate("H:i:s",(strtotime($test['ended_at'])-strtotime($test['created_at'])))}}</th>
                            <th>{{$test['totalnumber']}}</th>
                            <th>{{$test['tagtype']}}</th>
                            <th>
                                @if($test['testtype']==0)
                                    随机
                                @else
                                    顺序
                                @endif

                            </th>
                            <th>{{$test['point']}}</th>
                            <th><a class="text-muted" href={{"/test/".$test['id']."/alldetails"}} >查看答题详情</a></th>
                        </tr>
                    @endforeach
                </table>


            </div>
        </div>
    </div>
@endsection

@section('footer')
    <style type="text/css">
        ${demo.css}
    </style>
    <script type="text/javascript">
        $(function () {
            var xaxis=<?php echo json_encode(array_column($tests,'id')); ?>;
            var points=<?php echo $points; ?>;

            $('#container').highcharts({
                chart: {
                    type: 'line'
                },
                title: {
                    text: '历史得分'
                },
                xAxis: {
                    categories: xaxis
                },
                yAxis: {
                    title: {
                        text: 'Point '
                    },
                    tickPositions: [0, 20,40,60,80,100]
                },
                plotOptions: {
                    line: {
                        dataLabels: {
                            enabled: true
                        },
                        enableMouseTracking: false
                    }
                },
                series: [{
                    name: 'Point',
                    data: points
                }]
            });
        });
    </script>

    <script src="{{URL::asset('assets/highcharts/highcharts.js')}}"></script>
    <script src="{{URL::asset('assets/highcharts/exporting.js')}}"></script>
    <script src="{{URL::asset('assets/highcharts/sand-signika.js')}}"></script>
    @endsection