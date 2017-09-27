<input type="hidden" name="qtype_id" value="3">
<div class="form-group">
    {!! Form::label('title','Question',['class'=>'col-lg-2 control-label lead']) !!}
    <div class="col-lg-10">
        {!! Form::textarea('title',null,['class'=>'form-control',"rows"=>"3",'required'=>'required']) !!}
    </div>
</div>

<div class="form-group">
    {!! Form::label('answer','答案',['class'=>'col-lg-2 control-label lead']) !!}
    <div class="col-lg-10 ">
        <div class="col-sm-2" style="position: relative;top:15px">
            <label class="radio">
                <input type="radio" data-toggle="radio" name="answer"  value="对" data-radiocheck-toggle="radio" required @if(isset($question)&&($question->answer)=="1")checked=""@endif>
                对
            </label>
        </div>
        <div class="col-sm-2" style="position: relative;top:15px">
            <label class="radio">
                <input type="radio" data-toggle="radio" name="answer"  value="错" data-radiocheck-toggle="radio"  @if(isset($question)&&($question->answer)=="0")checked=""@endif >
                错
            </label>
        </div>

    </div>
</div>

<div class="form-group">
    {!! Form::label('parse','解析',['class'=>'col-lg-2 control-label lead']) !!}
    <div class="col-lg-10">

        {!! Form::textarea('parse',null,['class'=>'form-control',"rows"=>"3"]) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('Tag','Tag',['class'=>'col-lg-2 control-label lead']) !!}
    <div class="col-lg-10">
        {!! Form::select('tag_list[]', array_slice($tag_list,1,count($tag_list)-1,true), isset($tag)?$tag:null, ['id'=>'tag_list','class' => 'form-control bg-primary', 'multiple']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::submit($submitButton, ['class' => 'btn btn-primary form-control']) !!}
</div>

@section('footer')
    <script type="text/javascript">
        $('#tag_list').select2();
    </script>

@endsection