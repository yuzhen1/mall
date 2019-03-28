<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//微商城
//首页
Route::get('index/index','IndexController@index');
Route::get('index/login','IndexController@login');
Route::match(['get','post'],'index/logindo','IndexController@logindo');
Route::get('index/register','IndexController@register');
Route::post('index/registerdo','IndexController@registerdo');
Route::post('index/checkEmail','IndexController@checkEmail');

//全部商品
Route::get('goods/allshops','GoodsController@allshops');
Route::get('goods/goods_detail','GoodsController@goods_detail');

//购物车
Route::get('car/index','CarController@index');
Route::match(['get','post'],'car/addcart','CarController@addcart');
Route::post('car/changeNum','CarController@changeNum');
Route::post('car/getCountPrice','CarController@getCountPrice');
Route::match(['get','post'],'car/addcart','CarController@addcart');
Route::get('car/gopay','CarController@gopay');
Route::post('car/successdo','CarController@successdo');//订单数据
Route::any('car/success','CarController@success');
Route::any('car/alipay/{order_no}','CarController@alipay');
Route::any('car/returnpay','CarController@returnpay');//支付成功后跳转  同步
Route::post('car/notifypay','CarController@notifypay');//异步
Route::any('car/phonepay/{order_no}','CarController@phonepay');//手机端支付

//收货地址
Route::get('address/index','AddressController@index');
Route::get('address/address','AddressController@address');//收货地址管理
Route::get('address/getarea','AddressController@getarea');
Route::get('address/getAddressInfo','AddressController@getAddressInfo');
Route::get('address/getAreaInfo','AddressController@getAreaInfo');
Route::post('address/getArea','AddressController@getArea');
Route::post('address/addressDo','AddressController@addressDo');
Route::match(['get','post'],'address/addresslist','AddressController@addresslist');//地址管理



//个人中心
Route::get('my/index','MyController@index');
Route::get('my/order','MyController@order');
Route::get('my/quan','MyController@quan');//优惠劵
Route::get('my/collect','MyController@collect');//收藏
Route::get('my/deposit','MyController@deposit');//提现


//新闻
Route::get('news/news','NewsController@news');