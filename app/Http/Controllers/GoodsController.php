<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Good;

class GoodsController extends Controller
{
   //全部商品  首页
    public function allshops(Request $request)
    {
        $goods_model=new Good;
        $goodsInfo=$goods_model->paginate(50);
//        dd($goodsInfo);
       return view('goods/allshops',compact('goodsInfo'));
    }

    //商品详情
    public function goods_detail(Request $request)
    {
        $goods_id=$request->input('goods_id');
//        dd($goods_id);
        $goods_model = new Good;
        $goodsInfo=$goods_model->where('goods_id',$goods_id)->first();
//        dd($goodsInfo);
        $goodsInfo['goods_imgs'] =rtrim($goodsInfo['goods_imgs'],'|');
        $goodsInfo['goods_imgs'] =explode('|',$goodsInfo['goods_imgs'] );
        return view('goods/goods_detail',compact('goodsInfo'));
    }


}
