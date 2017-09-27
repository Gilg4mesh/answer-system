@if($judges[$i]==1)
<h4>第{{$i+1}}题： 答对</h4>
@else
<h4 class="text-danger">第{{$i+1}}题：答错</h4>
@endif
<p><strong>题目：&nbsp;&nbsp;</strong>{!! $parsedown->text($questions[$i]['title'])!!}</p>
@foreach(explode("\r\n",$questions[$i]['options']) as $option)
        <p>{{ $option}}</p>
@endforeach

<p class="text-danger">
        <strong>
                正确答案: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </strong>
        {!! nl2br($questions[$i]['answer']) !!}
</p>

@if($judges[$i]==0||$questions[$i]['qtype_id']==5)
<p><strong>您的答案: &nbsp;&nbsp;&nbsp;
        &nbsp;&nbsp;&nbsp;</strong>{!! nl2br($useranswer[$questionids[$i+1]]) !!}</p>
@endif
<p><strong>解析: &nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;</strong>{!!  nl2br($questions[$i]['parse']) !!}
</p>