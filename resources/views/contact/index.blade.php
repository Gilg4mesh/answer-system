@extends('layouts.app')

@section('content')


    <div class="row col-md-8 col-md-offset-2" style="position:relative;height:85%; background:#f0eded ">
        <h4 class="blue">Online Customer Service</h4>
        <div id="chat" class="col-md-12" style="height:70%;overflow:auto; position:absolute">


            <div class="bubbleItem">     <!--左侧的泡泡-->
                    <span class="bubble leftBubble">
                        欢迎您的来访~<br/>
                        <br/>
                        您可能关注以下相关问题：<br/>
                        1:发表意见<br/>
                        2:题目答疑<br/>
                        请直接回复数字进行了解哦<br/>
                    <span class="bottomLevel"></span>
                    <span class="topLevel"></span>
                    </span>
            </div>

            <div id="msg"></div>

        </div>

        <div class="col-md-12 form-group" style=" position:absolute;bottom:0">
            <input type="hidden" name="status" value=0 id="status"> {{--用于存储此时表单在第几级的状态--}}

            <div class="form-group text-right" style="position:relative;top:115px;right:15px">
                <input type="submit" class="btn  btn-lg btn-primary" value="send" onClick="getMessage()">
            </div>
                <textarea class="form-control " id="message" rows="3"
                          style="border: 2px solid #57e6ca ;border-radius:15px"></textarea>


        </div>


    </div>

@endsection

@section('footer')

    <script>
        function getMessage() {
            //获取输入指和指定状态
            var command = $('#message').val();
            $('#message').val('');
            var status = $("#status").val();
            var send = "<div class=\"bubbleItem clearfix\"><span class=\"bubble rightBubble\">" + command + "<span class=\"bottomLevel\"></span><span class=\"topLevel\"></span></span></div>";
            $('#msg').append(send);
            $('#chat').scrollTop($('#chat')[0].scrollHeight);

            $.ajax({
                type: 'get',
                url: '/contact/message',
                data: {command: command, '_token': '{{csrf_token()}}', ss: status},//传送命令和状态

                success: function (data) {
                    var receive = "\<div class=\"bubbleItem\"><span class=\"bubble leftBubble\">" + data.receive + "<span class=\"bottomLevel\"></span><span class=\"topLevel\"></span></span></div>";

                    $("#msg").append(receive);
                    $("#status").val(data.ss);//同时更新状态
                    $('#chat').scrollTop($('#chat')[0].scrollHeight);
                },
                error: function () {
                    alert("异常！");
                }


            });


        }

    </script>
@endsection


