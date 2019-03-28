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
     <form action="login.html" method="get" class="reg-login">
      <div class="lrBox">
       <div class="lrList"><input type="text" id="address_name" placeholder="收货人" /></div>

       <div class="lrList">
        <select id="province" class="area">
            <option value="" selected="selected">请选择...</option>
            @foreach($areaInfo as $k=>$v)
            <option value="{{$v->id}}">{{$v->name}}</option>
            @endforeach
        </select>

        <select id="city" class="area">
            <option value="" selected="selected">请选择...</option>
        </select>

        <select id="detail" class="area">
            <option value="" selected="selected">请选择...</option>
        </select>
       </div>
       <div class="lrList"><input type="text" id="address_detail" placeholder="详细地址" /></div>
       <div class="lrList"><input type="text" id="address_tel" placeholder="手机" /></div>
       <div class="lrList2">
           <input type="checkbox" placeholder="设为默认地址" id="is_default"/>
           <button>设为默认</button>
       </div>
      </div><!--lrBox/-->
      <div>
          <input type="button" value="提交" id="sub">
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
    <!--jq加减-->
    <script src="/goods/js/jquery.spinner.js"></script>
   <script>
	$('.spinnerExample').spinner({});
   </script>
  </body>
</html>
<script>
    $(function(){
        layui.use('layer',function () {
            var layer=layui.layer;
            $(document).on("change",'.area',function(){
                var _this = $(this);
                var id=_this.val();
                var _option="<option selected value=''>--请选择--</option>";
                $.post(
                    "getArea",
                    {id:id},
                    function(res){
                        if(res.code==1){
                            for(var i in res['areaInfo']){
                                _option+="<option value='"+res['areaInfo'][i]['id']+"'>"+res['areaInfo'][i]['name']+"</option>"
                                _this.nextAll('select').html(_option);
                            }
                        }else{
                            layer.msg(res.font,{icon:res.code});
                        }
                    },'json'
                )

            });

            //点击保存
            $(document).on("click",'#sub',function(){
                var obj={};
                obj.province=$("#province").val();
                obj.city = $("#city").val();
                obj.area = $("#detail").val();
                obj.address_name = $("#address_name").val();
                obj.address_tel = $("#address_tel").val();
                obj.address_detail = $("#address_detail").val();
                obj.is_default = $("#is_default").prop('checked');
//                console.log(obj);
//                return false;
                if(obj.is_default==true){
                    obj.is_default=1;
                }else{
                    obj.is_default=2;
                }
                //验证

                if(obj.address_name==''){
                    layer.msg("请选择收货人");exit;
                }

                if(obj.province==''){
                    layer.msg("请选择完整的收货地址 请选择省级名称");
                    exit;
                }else if(obj.city==''){
                    layer.msg("请选择市级名称");
                    exit;
                }else if(obj.area==''){
                    layer.msg("请选择县/区级");
                    exit;
                }

                if(obj.address_detail==''){
                    layer.msg("请填写详细地址");exit;
                }
//
                if(obj.address_tel=='') {
                    layer.msg("请填写联系方式");exit;
                }


                $.post(
                    "addressDo",
                    obj,
                    function(res){
                        layer.msg(res.font,{icon:res.code});
                        location.href="addresslist";
                    },
                    'json'
                )
            });
        })
    })
</script>