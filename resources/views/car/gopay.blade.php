@include('index/header')
<body>
<div class="maincont">
 <header>
  <a href="javascript:history.back(-1)" class="back-off fl"><span class="glyphicon glyphicon-menu-left"></span></a>
  <div class="head-mid">
   <h1>购物车</h1>
  </div>
 </header>
 <div class="head-top">
  <img src="/goods/images/head.jpg" />
 </div><!--head-top/-->
 <div class="dingdanlist">
  <input type="hidden" id="_token" value="{{csrf_token()}}">
  <table>
   <tr>
    <td class="dingimg" width="75%" colspan="2">新增收货地址</td>
    <td align="right"><a href="/address/index"><img src="/goods/images/jian-new.png" /></a></td>
   </tr>
   <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
   <tr>
    @foreach($addressInfo as $k=>$v)
    <td width="25%" >收货地址</td>
     <input type="hidden" id="address_id" value="{{$v->address_id}}">
     <td width="50%">
      <h3>{{$v->address_name}} {{$v->address_tel}}</h3>
      <time>{{$v->province}}-{{$v->city}}-{{$v->area}}-{{$v->address_detail}}</time>

     </td>
     <td>
      <a href="/address/addressEdit" class="hui">
       <span class="glyphicon glyphicon-check"></span> 修改信息
      </a></td>
     </td>

   @endforeach
   </tr>
   <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
   <tr>
    {{--<td class="dingimg" width="75%" colspan="2" id="pay_way">支付方式</td>--}}
    <td class="dingimg" width="75%" colspan="2">
     <select style="width:500px" id="pay_way">
      <option value=''>--请选择支付方式--</option>
      <option value="1">支付宝</option>
     </select>
    </td>
   </tr>
   <tr><td colspan="3" style="height:10px; background:#efefef;padding:0;"></td></tr>
   <tr>
    <td class="dingimg" width="75%" colspan="2">优惠券</td>
    <td align="right"><span class="hui">无</span></td>
   </tr>
   <tr><td colspan="3" style="height:10px; background:#fff;padding:0;"></td></tr>
   <tr>
    <td class="dingimg" width="75%" colspan="3">商品清单</td>
   </tr>

   @foreach($goodsInfo as $k=>$v)
    <tr goods_id="{{$v->goods_id}}" class="goods_id">
     <td class="dingimg" width="15%"><img src="http://uploads.mall.com/goodsimg/{{$v->goods_img}}" /></td>
     <td width="50%">
      <h3>{{$v->goods_name}}</h3>
      <time>单价：￥ <span style="color:#ff4e00;">{{$v->goods_price}}</span></time>
     </td>
     <td align="right"><span class="qingdan">X {{$v->buy_num}}</span></td>
    </tr>
    <tr>
     <th colspan="3"><strong class="orange">￥{{$v->goods_price*$v->buy_num}}</strong></th>
    </tr>
   @endforeach
  </table>
 </div><!--dingdanlist/-->
</div><!--content/-->
<div class="height1"></div>
<div class="gwcpiao">
 <table>
  <tr>
   <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
   <td width="50%">总计：<strong class="orange">￥{{$countPrice}}</strong></td>
   <td width="40%"><a id="subOrder" class="jiesuan">提交订单</a></td>
  </tr>
 </table>
</div><!--gwcpiao/-->
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
    layui.use('layer',function () {
        var layer = layui.layer;
        //点击确认订单
        $("#subOrder").click(function(){
            var _token=$('#_token').val();
            var address_id=$("#address_id").val();
            var pay_way=$('#pay_way').val();
//        console.log(address_id);
            var goods_id='';
            $('.goods_id').each(function (index) {
                goods_id+=$(this).attr('goods_id')+',';
            });
            goods_id=goods_id.substr(0,goods_id.length-1);
            if(pay_way==''){
                layer.msg('请选择支付方式',{icon:2});
                return false;
            }else if(goods_id==''){
                layer.msg('请选择商品提交订单',{icon:2});
                return false;
            }

            $.post(
                "successdo",
                {_token:_token,goods_id:goods_id,pay_way:pay_way,address_id:address_id},
                function (res) {
//                    console.log(res);
                     if(res.code=1){
                         layer.msg(res.font,{icon:res.code});
                         location.href="/car/success?order_id="+res.order_id;
                     }
                },
                 'json'
            )
        });
    });

</script>
</body>
</html>
