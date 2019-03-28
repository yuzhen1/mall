@include('index/header')
  <body>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <div class="head-mid">
       <h1>收货地址</h1>
      </div>
     </header>
     <div class="head-top">
      <img src="/goods/images/head.jpg" />
     </div><!--head-top/-->
     <table class="shoucangtab">
      <tr>
       <td width="75%"><a href="/address/address" class="hui"><strong class="">+</strong> 新增收货地址</a></td>
       <td width="25%" align="center" style="background:#fff url(images/xian.jpg) left center no-repeat;"><a href="javascript:;" class="orange">删除信息</a></td>
      </tr>
     </table>
     
     <div class="dingdanlist" onClick="window.location.href='proinfo.html'">
      <table>
          @foreach($addressInfo as $k=>$v)
       <tr>
        <td width="50%">
         <h3>{{$v->address_name}} {{$v->address_tel}}</h3>
         <time>{{$v->province}}{{$v->city}}{{$v->area}}{{$v->address_detail}}</time>
        </td>

        <td align="right">
            <a href="/address/addressEdit" class="hui">
                <span class="glyphicon glyphicon-check"></span> 修改信息
            </a></td>
       </tr>
          @endforeach
      </table>
     </div><!--dingdanlist/-->
     
     <div class="height1"></div>
     @include('index/footer')
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