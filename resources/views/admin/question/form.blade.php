<div class="form-group">
    {!! Form::label('title','Question',['class'=>'col-lg-2 control-label lead']) !!}
    <div class="col-lg-10">
        {!! Form::textarea('title',null,['class'=>'form-control',"rows"=>"3",'required'=>'required']) !!}
    </div>
</div>
<div class="form-group">
    {!! Form::label('options','选项',['class'=>'col-lg-2 control-label lead']) !!}
    <div class="col-lg-10">
        {!! Form::textarea('options',null,['class'=>'form-control',"rows"=>"4","required"=>"required"]) !!}
    </div>
</div>


<div class="form-group">
    {!! Form::label('answer','答案',['class'=>'col-lg-2 control-label lead']) !!}
    <div class="col-lg-10">
        {!! Form::select('answer', ['A'=>'A','B'=>'B','C'=>'C','D'=>'D'], null, ['id'=>'answer','class' => 'form-control ']) !!}
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