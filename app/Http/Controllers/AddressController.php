<?php

namespace App\Http\Controllers;

use App\Area;
use App\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    //收货地址
    public function index(){

        return view('address/index');
    }

    //收货地址管理
    public  function address(){
        //查询所有的省信息  作为下拉菜单的值
        $areaInfo = $this->getAreaInfo(0);
//        var_dump($areaInfo);die;

        return view('address/address',compact('areaInfo'));
    }
    //获取省级信息
    public function getAreaInfo($pid){
        $area_model =new Area;
        $where=[
            'pid'=>$pid
        ];
        $provInfo = $area_model->where($where)->get();
//        dd($provInfo);
//        var_dump($provInfo);die;
        return $provInfo;
    }

    //获取下一层级的市 区信息
    public function getArea(Request $request){
        $id = $request->input('id');
        $areaInfo = $this->getAreaInfo($id);
//        dd($areaInfo);
        echo json_encode(['areaInfo'=>$areaInfo,'code'=>1]);
    }

    //增加收货地址
    public function addressDo(Request $request){
        $data =$request->input();
//        dd($data);

        //入库
        $address_model =new Address;
        $user_id=session('login')['user_id'];
        $data['user_id']=$user_id;
        $res=$address_model->insert($data);
        if($res){
            $arr=[
                'font'=>'添加成功',
                'code'=>1
            ];
        }else{
            $arr=[
                'font'=>'添加失败',
                'code'=>2
            ];
        }
        echo json_encode($arr);
    }

    //地址管理
    public function addresslist(Request $request){
        //获取收货地址信息
        $addressInfo = $this->getAddressInfo();
        return view('address/addresslist',compact('addressInfo'));
    }

    //删除
//    public function addressDel(){
//        $address_id = input('post.address_id');
//        $address_model = model('Address');
//        $where=[
//            'address_id'=>$address_id
//        ];
//        $res = $address_model->where($where)->delete();
//        if($res){
//            successly("删除成功");
//        }else{
//            fail("删除失败");
//        }
//    }
//
//    //编辑收货地址
//    public function addressEdit(){
//        $address_model = model('Address');
//        if(request()->isPost()&&request()->isAjax()){
//            //执行修改
//            $data = input('post.');
////            dump($data);die;
//            //验证
//
//            $address_model->startTrans();
//            $where=[
//                'address_id'=>$data['address_id']
//            ];
//            if($data['is_default']==1){
//                $addressWhere=[
//                    'user_id'=>$this->getUserId()
//                ];
//                $res1 = $address_model->save(['is_default'=>2],$addressWhere);
//
//                $res2 = $address_model->save($data,$where);
//                if($res1!==false&&$res2!==false){
//                    $address_model->commit();
//                    successly("修改成功");
//                }else{
//                    $address_model->rollback();
//                    fail("修改失败");
//                }
//            }else{
//                $res = $address_model->save($data,$where);
//                if($res){
//                    successly("修改成功");
//                }else{
//                    fail("修改失败");
//                }
//            }
//
//        }else{
//            //展示修改视图
//            $address_id=input('get.address_id',0,'intval');
//            if(empty($address_id)){
//                echo "请选择要编辑的收获地址";
//            }
//            //根据收货地址id查询要修改的一条数据
//
//            $addressWhere=[
//                'address_id'=>$address_id,
//                'address_status'=>1
//            ];
//            $addressInfo = $address_model->where($addressWhere)->find()->toarray();
////        dump($addressInfo);die;
//
//            //查询所有的省 作为下拉菜单的值
//            $provinceInfo = $this->getAreaInfo(0);
//            $cityInfo = $this->getAreaInfo($addressInfo['province']);
//            $areaInfo = $this->getAreaInfo($addressInfo['city']);
//            $this->assign('addressInfo',$addressInfo);
//            $this->assign('provinceInfo',$provinceInfo);
//            $this->assign('cityInfo',$cityInfo);
//            $this->assign('areaInfo',$areaInfo);
//            return view();
//        }
//
//    }

}