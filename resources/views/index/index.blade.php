@include('index/header')
<body>
<div class="maincont">
    <div class="head-top">
        <img src="/goods/images/head.jpg" />
        <dl>
            <dt><a href="/my/index"><img src="/goods/images/aaa.jpg" height="50px;"/></a></dt>
            <dd>

                <h1 class="username">
                    @if(session('login.user_name')=='')
                    未登录
                    @else
                    欢迎⭐ <samp style="color:#4581ff">{{session('login.user_name')}}</samp>🌙
                    @endif
                        <a href="#">退出登录</a>
                </h1>

                <ul>
                    <li><a href="/goods/allshops"><strong>34</strong><p>全部商品</p></a></li>
                    <li><a href="javascript:;"><span class="glyphicon glyphicon-star-empty"></span><p>收藏本店</p></a></li>
                    <li style="background:none;"><a href="javascript:;"><span class="glyphicon glyphicon-picture"></span><p>二维码</p></a></li>
                    <div class="clearfix"></div>
                </ul>
            </dd>
            <div class="clearfix"></div>
        </dl>
    </div><!--head-top/-->
    <form action="#" method="get" class="search">
        <input type="text" class="seaText fl" />
        <input type="submit" value="搜索" class="seaSub fr" />
    </form><!--search/-->
    <ul class="reg-login-click">
        <li><a href="/index/login">登录</a></li>
        <li><a href="/index/register" class="rlbg">注册</a></li>
        <div class="clearfix"></div>
    </ul><!--reg-login-click/-->
    <div id="sliderA" class="slider">
        <img src="/goods/images/image1.jpg" />
        <img src="/goods/images/image2.jpg" />
        <img src="/goods/images/image3.jpg" />
        <img src="/goods/images/image4.jpg" />
        <img src="/goods/images/image5.jpg" />
    </div><!--sliderA/-->
    <ul class="pronav">
        <li><a href="/goods/allshops">晋恩干红</a></li>
        <li><a href="/goods/allshops">万能手链</a></li>
        <li><a href="/goods/allshops">高级手镯</a></li>
        <li><a href="/goods/allshops">特异戒指</a></li>
        <div class="clearfix"></div>
    </ul><!--pronav/-->
    <div class="index-pro1">
        @foreach($data as $k=>$v)
        <div class="index-pro1-list">
            <dl>
                <dt>
                    <a href="/goods/goods_detail?goods_id={{$v->goods_id}}">
                      <img src="http://uploads.mall.com/goodsimg/{{$v->goods_img}}">
                    </a>
                </dt>
                <dd class="ip-text" style="width:300px;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;-o-text-overflow:ellipsis;">
                    <a href="/goods/goods_detail?goods_id={{$v->goods_id}}">{{$v->goods_name}}</a>
                    <span></span>
                </dd>
                <dd class="ip-price"><strong>¥{{$v->goods_price}}</strong> <span>¥{{$v->market_price}}</span></dd>
            </dl>
        </div>
        @endforeach
        <div class="clearfix"></div>
    </div><!--index-pro1/-->
    <div class="prolist">
        <dl>
            <dt><a href="/goods/goods_detail"><img src="/goods/images/prolist1.jpg" width="100" height="100" /></a></dt>
            <dd>
                <h3><a href="/goods/goods_detail">四叶草</a></h3>
                <div class="prolist-price"><strong>¥299</strong> <span>¥599</span></div>
                <div class="prolist-yishou"><span>5.0折</span> <em>已售：35</em></div>
            </dd>
            <div class="clearfix"></div>
        </dl>
    </div><!--prolist/-->
    <div class="joins"><a href="fenxiao.html"><img src="/goods/images/jrwm.jpg" /></a></div>
    <div class="copyright">Copyright &copy; <span class="blue">这是就是三级分销底部信息</span></div>

    <div class="height1"></div>
    @include('index/footer')
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
</body>
</html>