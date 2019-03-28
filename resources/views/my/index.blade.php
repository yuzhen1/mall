@include('/index/header')
  <body>
    <div class="maincont">
     <div class="userName">
      <dl class="names">
       <dt><img src="/goods/images/aaa.jpg" /></dt>
       <dd>
        <h3>柚柚</h3>
       </dd>
       <div class="clearfix"></div>
      </dl>
      <div class="shouyi">
       <dl>
        <dt>我的余额</dt>
        <dd>0.00元</dd>
       </dl>
       <dl>
        <dt>我的积分</dt>
        <dd>0</dd>
       </dl>
       <div class="clearfix"></div>
      </div><!--shouyi/-->
     </div><!--userName/-->
     
     <ul class="userNav">
      <li><span class="glyphicon glyphicon-list-alt"></span><a href="order.html">我的订单</a></li>
      <div class="height2"></div>
      <div class="state">
         <dl>
          <dt><a href="/my/order"><img src="/goods/images/user1.png" /></a></dt>
          <dd><a href="/my/order">待支付</a></dd>
         </dl>
         <dl>
          <dt><a href="/my/order"><img src="/goods/images/user2.png" /></a></dt>
          <dd><a href="/my/order">代发货</a></dd>
         </dl>
         <dl>
          <dt><a href="/my/order"><img src="/goods/images/user3.png" /></a></dt>
          <dd><a href="/my/order">待收货</a></dd>
         </dl>
         <dl>
          <dt><a href="/my/order"><img src="/goods/images/user4.png" /></a></dt>
          <dd><a href="/my/order">全部订单</a></dd>
         </dl>
         <div class="clearfix"></div>
      </div><!--state/-->
      <li><span class="glyphicon glyphicon-usd"></span><a href="/my/quan">我的优惠券</a></li>
      <li><span class="glyphicon glyphicon-map-marker"></span><a href="/address/address">收货地址管理</a></li>
      <li><span class="glyphicon glyphicon-star-empty"></span><a href="/my/collect">我的收藏</a></li>
      <li><span class="glyphicon glyphicon-heart"></span><a href="/my/collect">我的浏览记录</a></li>
      <li><span class="glyphicon glyphicon-usd"></span><a href="/my/deposit">余额提现</a></li>
	 </ul><!--userNav/-->
     
     <div class="lrSub">
       <a href="javascript:;">退出登录</a>
     </div>
     
     <div class="height1"></div>
        @include('/index/footer')
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/goods/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/goods/js/bootstrap.min.js"></script>
    <script src="/goods/js/style.js"></script>
    <!--jq加减-->
    <script src="/goods/js/jquery.spinner.js"></script>
   <script>
	$('.spinnerExample').spinner({});
   </script>
  </body>
</html>