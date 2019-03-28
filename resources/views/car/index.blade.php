@include('/index/header')
  <body>
    {{@csrf_field()}}
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
     <table class="shoucangtab">
      <tr>
       <td width="75%"><span class="hui">购物车共有：<strong class="orange">{{$count}}</strong>件商品</span></td>
       <td width="25%" align="center" style="background:#fff url(images/xian.jpg) left center no-repeat;">
        <span class="glyphicon glyphicon-shopping-cart" style="font-size:2rem;color:#666;"></span>
       </td>
      </tr>
     </table>
     
     <div class="dingdanlist">

      <table>
       <tr>
        <td width="100%" colspan="4"><a href="javascript:;"><input type="checkbox" class="boxall" name="1" /> 全选</a></td>
       </tr>
          @foreach($carInfo as $k=>$v)
       <tr>
        <td width="4%"><input type="checkbox" class="box" name="1"/></td>
        <td class="dingimg" width="15%"><img src="http://uploads.mall.com/goodsimg/{{$v->goods_img}}" /></td>
        <td width="50%">
         <h3>{{$v->goods_name}}</h3><p id="goods_price">{{$v->goods_price}}</p>
         <time>{{date("Y-m-d",$v->created_at)}}</time>
        </td>
        <td align="right" class="gets" goods_num="{{$v->goods_num}}" goods_id="{{$v->goods_id}}">
            <input type="text" class="spinnerExample" buy_num="{{$v->buy_num}}"/>

        </td>

       </tr>
       <tr>
        <th colspan="4">￥<strong class="orange" goods_price="{{$v->goods_price*$v->buy_num}}">{{$v->goods_price*$v->buy_num}}</strong></th>
       </tr>
          @endforeach
      </table>

     </div><!--dingdanlist/-->
     <div class="height1"></div>
     <div class="gwcpiao">
     <table>
      <tr>
       <th width="10%"><a href="javascript:history.back(-1)"><span class="glyphicon glyphicon-menu-left"></span></a></th>
       <td width="50%">总计：¥<strong class="orange" id="countPrice">0</strong></td>
       <td width="40%"><a class="jiesuan goget">去结算</a></td>
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
	</script>
  </body>
</html>
<script>
  $(function(){
      layui.use('layer',function(){
          var layer = layui.layer;
          var _token=$("input[name='_token']").val();
          $('.value').each(function(){
              var buy_num=$(this).attr('buy_num');
              //console.log(buy_num);
              $(this).val(buy_num);
          });

          //点击加号
          $(".increase").click(function(){
              var _this = $(this);
              var buy_num = parseInt(_this.siblings("input").val());
              var goods_num = _this.parents('td').attr('goods_num');
              var goods_id = _this.parents('td').attr('goods_id');

              if(buy_num>=goods_num){
                  _this.prop('disabled',true);
              }else{
                  _this.siblings("input").val(buy_num);
                  _this.siblings("input[class='decrease']").prop('disabled',false);
              }

              //改变数据库数量
              $.post(
                  "changeNum",
                  {_token:_token,goods_id:goods_id,buy_num:buy_num},
                  function(res){
                      if(res.code==1){
                          //改变小记
                          var goods_price = parseInt(_this.parents("td").prev("td").find('p').text());
                          var total = goods_price*buy_num;
                          _this.parents("tr").next("tr").find("strong").text(total);
                          layer.msg(res.font,{icon:res.code});
                      }
                  },
                  'json'
              );
          });

          //点击减号
          $(".decrease").click(function(){
              var _this = $(this);
              var buy_num = parseInt(_this.siblings("input").val());
              var goods_num = _this.parents('td').attr('goods_num');
              var goods_id = _this.parents('td').attr('goods_id');

              if(buy_num>=goods_num){
                  _this.prop('disabled',true);
              }else{
                  _this.siblings("input").val(buy_num);
                  _this.siblings("input[class='decrease']").prop('disabled',false);
              }

              //改变数据库数量
              $.post(
                  "changeNum",
                  {_token:_token,goods_id:goods_id,buy_num:buy_num},
                  function(res){
                      if(res.code==1){
                          //改变小记
                          var goods_price = parseInt(_this.parents("td").prev("td").find('p').text());
                          var total = goods_price*buy_num;
                          _this.parents("tr").next("tr").find("strong").text(total);
                          layer.msg(res.font,{icon:res.code});
                      }
                  },
                  'json'
              );
          });

          //失去焦点
          $(document).on("blur",'.spinnerExample',function(){
              var _this = $(this);
              var buy_num = parseInt(_this.val());//购买数量
              var goods_num = _this.parents('td').attr('goods_num');//库存
              var goods_id = _this.parents('td').attr('goods_id');

              //验证是否符合规则
              var reg = /^\d{1,}$/;
              if(!reg.test(buy_num)){
                  _this.val(1);
              }else if(buy_num<=1){
                  _this.val(1);
              }else if(buy_num>=goods_num){
                  _this.val(goods_num);
                  buy_num = goods_num;
              }else{
                  _this.val(buy_num);
              }

              //改变小记
              var goods_price = parseInt(_this.parents("td").prev("td").find('p').text());
              var total = goods_price*buy_num;
              _this.parents("tr").next("tr").find("strong").text(total);
              $.post(
                  "changeNum",
                  {_token:_token,goods_id:goods_id,buy_num:buy_num},
                  function(res){
                      if(res.code==1){
                          //改变小记
                          var goods_price = parseInt(_this.parents("td").prev("td").find('p').text());
                          var total = goods_price*buy_num;
                          _this.parents("tr").next("tr").find("strong").text(total);
                          layer.msg(res.font,{icon:res.code});
                      }
                  },
                  'json'
              );
              //重新计算总价格

          });

          //点击复选框
          $(document).on("click",".box",function(){
              getTotalPrice();
          });

          //点击全选
          $(document).on("click",'.boxall',function(){
              var _this = $(this);
              var status = _this.prop('checked');
              $(".box").prop('checked',status);
              getTotalPrice();
          });

          //获取购物车总价格
          function getTotalPrice(){
              var box = $(".box");
              var goods_id = '';
              box.each(function(index){
                  if($(this).prop("checked")==true){
                      goods_id+=$(this).parents('tr').find("td[class='gets']").attr('goods_id')+',';
                  }
              });

              var goods_id = goods_id.substr(0,goods_id.length-1);
              $.post(
                  "getCountPrice",
                  {goods_id:goods_id},
                  function(res){
                      $("#countPrice").text(res);
                  }
              )
          }

          //确认结算
          $(".goget").click(function(){
              var box = $(".box");
              var goods_id = '';
              box.each(function(index){
                  if($(this).prop("checked")==true){
                      goods_id+=$(this).parents('tr').find("td[class='gets']").attr('goods_id')+',';
                  }
              });

              var goods_id = goods_id.substr(0,goods_id.length-1);
//                        console.log(goods_id);
              if(goods_id==''){
                  layer.msg("请选择一个商品进行结算");
                  return false;
              }
              location.href="gopay?goods_id="+goods_id;
          })

      })
  })
</script>