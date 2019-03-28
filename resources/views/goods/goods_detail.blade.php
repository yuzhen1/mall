@include('index/header')
  <body>
    <div class="maincont">
     <header>
      <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
      <input type="hidden" id="goods_id" value="{{$goodsInfo->goods_id}}">
      <div class="head-mid">
       <h1>产品详情</h1>
      </div>
     </header>
     <div id="sliderA" class="slider">
         @foreach($goodsInfo['goods_imgs'] as $k=>$v)
            <img src="http://uploads.mall.com/goodsimg/{{$v}}" />
        @endforeach
     </div><!--sliderA/-->
     <table class="jia-len">
      <tr>
       <th><strong class="red">￥{{$goodsInfo['goods_price']}}</strong></th>
       <th style="color:#9bb9ff"> <input type="hidden" id="goods_num" value="{{$goodsInfo['goods_num']}}">{{$goodsInfo['goods_num']}}R</th>
       <td>
        <input type="text" class="spinnerExample" />
       </td>
      </tr>
      <tr>
       <td>
        <strong>{{$goodsInfo['goods_name']}}</strong>
        <p class="hui"></p>
       </td>
       <td align="right">
        <a href="javascript:;" class="shoucang"><span class="glyphicon glyphicon-star-empty"></span></a>
       </td>
      </tr>
     </table>
     <div class="height2"></div>
     <h3 class="proTitle">商品规格</h3>
     <ul class="guige">
      <li class="guigeCur"><a href="javascript:;">50ML</a></li>
      <li><a href="javascript:;">100ML</a></li>
      <li><a href="javascript:;">150ML</a></li>
      <li><a href="javascript:;">200ML</a></li>
      <li><a href="javascript:;">300ML</a></li>
      <div class="clearfix"></div>
     </ul><!--guige/-->
     <div class="height2"></div>
     <div class="zhaieq">
      <a href="javascript:;" class="zhaiCur">商品简介</a>
      <a href="javascript:;">商品参数</a>
      <a href="javascript:;" style="background:none;">订购列表</a>
      <div class="clearfix"></div>
     </div><!--zhaieq/-->
     <div class="proinfoList">
        {{$goodsInfo['goods_desc']}}
     </div><!--proinfoList/-->
     <div class="proinfoList">
      暂无信息....
     </div><!--proinfoList/-->
     <div class="proinfoList">
      暂无信息......
     </div><!--proinfoList/-->
     <table class="jrgwc">
      <tr>
       <th>
        <a href="/index/index"><span class="glyphicon glyphicon-home"></span></a>
       </th>
       <td><button id="cartAdd">加入购物车</button>{{@csrf_field()}}</td>
       <td><a href="/car/index">去购物车结算</a></td>
      </tr>
     </table>
    </div><!--maincont-->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="/goods/js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/goods/js/bootstrap.min.js"></script>
    <script src="/goods/js/style.js"></script>
    <!--焦点轮换-->
    <script src="/goods/js/jquery.excoloSlider.js"></script>
    <script>
		$(function () {
		 $("#sliderA").excoloSlider();
		});
	</script>
     <!--jq加减-->
    <script src="/goods/js/jquery.spinner.js"></script>
   <script>
	$('.spinnerExample').spinner({});
	</script>
  </body>
</html>
<script>
    $(function(){
        layui.use('layer', function(){
            var layer = layui.layer;
            //库存
            var goods_num=$("#goods_num").val();
//            console.log(goods_num);
            //点击+号
            $(".increase").click(function(){
                var buy_num = parseInt($(".spinnerExample").val());
//                console.log(buy_num);
                //判断要买的数量是否大于库存
                if(buy_num>=goods_num){
                    $(this).prop('disabled',true);
                }else{
                    $(".spinnerExample").val(buy_num);
                    $(this).siblings('button').prop('disabled',false);
                }
            });

            //点击-号
            $(".decrease").click(function(){
                var buy_num = parseInt($(".spinnerExample").val());
                if(buy_num<=1){
                    $(this).prop('disabled',true);
                    $(this).siblings('button').prop('disabled',false);
                }else{
                    $(".spinnerExample").val(buy_num);
                    $(this).siblings('button').prop('disabled',false);
                }
            });

            //购买数量失去焦点
            $(".spinnerExample").blur(function(){
                var buy_num = parseInt($(".spinnerExample").val());
                var reg = /^[1-9]\d*$/;
                if(!reg.test(buy_num)){
                    $(".spinnerExample").val(1);
                }else if(buy_num>=goods_num){
                    $(".spinnerExample").val(goods_num);
                }else if(buy_num<=1){
                    $(".spinnerExample").val(1);
                }
            });

            //加入购物车
            $("#cartAdd").click(function(){
                //获取商品id
                var goods_id = $("#goods_id").val();
//                console.log(goods_id);
                //获取购买数量
                var _token=$(this).next().val();
//                console.log(_token);
                var buy_num = parseInt($(".spinnerExample").val());
                $.post(
                    "/car/addcart",
                    {_token:_token,goods_id:goods_id,buy_num:buy_num},
                    function(res){
                        layer.msg(res.font,{icon:res.code});
                    },
                    'json'
                )
            })

        })
    })
</script>