@include('index/header')
<body>
@if (session('message'))
    <script>
        layui.use(['layer'],function(){
            var layer=layui.layer;
            layer.msg("{{ session('message') }}",{icon:2});
        })
    </script>
@endif
<div class="maincont">
    <header>
        <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
        <div class="head-mid">
            <h1>会员注册</h1>
        </div>
    </header>
    <div class="head-top">
        <img src="/goods/images/head.jpg" />
    </div><!--head-top/-->
    <form action="/index/registerdo" method="post" class="reg-login">
        <h3>已经有账号了？点此<a class="orange" href="/index/login">登陆</a></h3>
        <div class="lrBox">
            <div class="lrList"><input type="text" name="user_name" class="email" placeholder="输入手机号码或者邮箱号" /></div>
            <div class="lrList2"><input type="text" name="code" class="code" placeholder="输入短信验证码" /> <a href="javascript:;" class="code">获取验证码</a>{{@csrf_field()}}</div>
            <div class="lrList"><input type="text" name="user_pwd" class="pwd" placeholder="设置新密码（6-18位数字或字母）" /></div>
            <div class="lrList"><input type="text" name="repwd" class="repwd" placeholder="再次输入密码" /></div>
        </div><!--lrBox/-->
        <div class="lrSub">
            <input type="submit" value="立即注册" />
        </div>
    </form><!--reg-login/-->
    <div class="height1"></div>
    @include('index/footer')
</div><!--maincont-->
<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="/goods/js/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="/goods/js/bootstrap.min.js"></script>
<script src="/goods/js/style.js"></script>
</body>
</html>
<script>
    $(function(){
        layui.use(['layer'],function(){
            var layer=layui.layer;
            $(".code").click(function(){
                var _this=$(this);
                var email=$(".email").val();
                var reg=/^\w+@+\w+\.com$/;
                if(email==''){
                    layer.msg('邮箱必填',{icon:2});
                    return false;
                }else if(!reg.test(email)){
                    layer.msg('邮箱格式不正确',{icon:2});
                    return false;
                }else{
                    var _token=_this.next().val();
                    $.post(
                        "checkEmail",
                        {email:email,_token:_token},
                        function(res){
                            if(res.code==2){
                                layer.msg(res.font,{icon:res.code});
                                return false;
                            }else{
                                layer.msg(res.font,{icon:res.code});
                            }
                        },
                        'json'
                    )
                }
            })
            $(".pwd").blur(function(){
                var _this=$(this);
                var pwd=_this.val();
                var reg=/^\w{6,18}$/;
                if(pwd==''){
                    layer.msg('密码必填',{icon:2});
                }else if(!reg.test(pwd)){
                    layer.msg('密码必须为字母、数字、下划线，6到18位',{icon:2});
                }
            })
            $(".repwd").blur(function(){
                var pwd=$(".pwd").val();
                var _this=$(this);
                var repwd=_this.val();
                if(repwd==''){
                    layer.msg('确认密码必填',{icon:2});
                }else if(repwd!=pwd){
                    layer.msg('确认密码必须与密码一致',{icon:2});
                }
            })
        })
    })
</script>
