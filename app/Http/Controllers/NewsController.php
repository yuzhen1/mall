<?php

namespace App\Http\Controllers;

use App\Goods;
use Illuminate\Support\Facades\Cache;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsController extends Controller
{
    public function news(Request $request){
        $search=$request->input();
//        dump($search);exit;
        $page=$search['page']??'';
        $goods_name=empty($_GET['goods_name'])?"":$_GET['goods_name'];
//        dd($key);
        $key=$page.$goods_name;
        $data=Cache::get($key);
//        Cache::flush();
        dump($data);
        if(!$data){
            echo "没有缓存";
            $where=[];
            if(isset($search['goods_name'])??''){
                $where[]=['goods_name','like',"%$key%"];
            }
            $data=DB::table('Goods')->where($where)->paginate(2);
//                    dd($newsInfo);

            Cache::put($key,$data, 1);
        }

        return view('news/news',compact('data','search'));
    }
}