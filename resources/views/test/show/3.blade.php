<input type="hidden" name="qtype_id" value="3">
<div class="form-group">

    <label class="radio">
        <input required="required" type="radio" data-toggle="radio" name="answer" value="对" data-radiocheck-toggle="radio" required
               @if(isset($question)&&($question->answer)=="1")checked=""@endif>
        对
    </label>

    <label class="radio">
        <input required="required" type="radio" data-toggle="radio" name="answer" value="错" data-radiocheck-toggle="radio"
               @if(isset($question)&&($question->answer)=="0")checked=""@endif >
        错
    </label>
</div>