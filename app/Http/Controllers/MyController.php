<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyController extends Controller
{
    //我的  首页
    public function index(Request $request){
//        $data=DB::table('');
        return view('my/index');
    }

    //订单状态
    public function order(){
        return view('my/order');
    }

    //优惠券
    public function quan(){
        return view('my/quan');
    }



    //新增收货地址
    public function collect(){
        return view('my/collect');
    }

    //提现
    public function deposit(){
        return view('my/deposit');
    }
}
