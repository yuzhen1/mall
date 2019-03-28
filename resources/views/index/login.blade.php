@include('/index/header')
  <body>
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
     <form action="/index/logindo" method="get" class="reg-login">
      <h3>还没有三级分销账号？点此<a class="orange" href="/index/register">注册</a></h3>
      <div class="lrBox">
       <div class="lrList"><input type="text" name="user_name" placeholder="输入手机号码或者邮箱号" /></div>
       <div class="lrList"><input type="text" name="user_pwd" placeholder="输入密码" /></div>
      </div><!--lrBox/-->
      <div class="lrSub">
       <input type="submit" value="立即登录" />
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
