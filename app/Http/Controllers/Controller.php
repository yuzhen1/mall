<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Database\Eloquent\Model;
use App\Address;
use App\Area;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //查询省市区
    public function getAddressInfo(){
        $user_id=session('login')['user_id'];
        $where=[
            'user_id'=>$user_id
        ];
        $address_model = new Address;
        $area_model =new Area;
        $addressInfo = $address_model->where($where)->get();
//        return $addressInfo;die;
        if(!empty($addressInfo)){
            //处理收货地址的省市区
            foreach($addressInfo as $k=>$v){
                $addressInfo[$k]['province']=$area_model->where(['id'=>$v['province']])->value('name');
                $addressInfo[$k]['city']=$area_model->where(['id'=>$v['city']])->value('name');
                $addressInfo[$k]['area']=$area_model->where(['id'=>$v['area']])->value('name');
            }
            return $addressInfo;
        }else{
            return false;
        }
    }
}
