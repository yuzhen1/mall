<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Car;
use App\Detail;
use App\OrderAddress;
use App\Address;
use App\Good;

use Illuminate\Support\Facades\DB;

class CarController extends Controller
{
    //购物车首页
    public function index(){
        $carInfo=DB::select("select * from goods join cars on goods.goods_id=cars.goods_id and car_status=1");
//        $carInfo['created_at']=date("Y-m-d",$carInfo['created_at']);
        $count=count($carInfo);
//        dd($carInfo);
        return view('car/index',compact('carInfo','count'));
    }

    //加入购物车
    public function addcart(Request $request){
        $goods_id=$request->input('goods_id');
        $buy_num=$request->input('buy_num');
        $token=$request->input('_token');
        $user_id=session('login')['user_id'];
//        dd($user_id);
        if(empty($buy_num)){
            $arr=[
                'font'=>'请选择要购买的商品数量',
                'code'=>2
            ];
            echo json_encode($arr);exit;
        }
        $car_model=new Car;

        //查询数据库中是否有当前用户的商品数据
        $where=[
            'user_id'=>$user_id,
            'goods_id'=>$goods_id
        ];
        $carInfo = $car_model->where($where)->first();
//        dd($carInfo);
        if(!empty($carInfo)){
            //修改
            $updateInfo=[
                'buy_num'=>$carInfo['buy_num']+$buy_num
            ];
            $res = $car_model->where($where)->update($updateInfo);
            if($res){
                $arr=[
                    'font'=>'添加购物车成功',
                    'code'=>1
                ];
            }else{
                $arr=[
                    'font'=>'添加购物车失败',
                    'code'=>2
                ];
            }
            echo json_encode($arr);
        }else{
            //添
            $data=[
                'goods_id'=>$goods_id,
                'buy_num'=>$buy_num,
                'user_id'=>$user_id,
                'created_at'=>time(),
                'updated_at'=>time()
            ];
            unset($token);
            $res=$car_model->insert($data);
            if($res){
                $arr=[
                    'font'=>'添加购物车成功',
                    'code'=>1
                ];
                echo json_encode($arr);
            }
        }


    }

    //修改数据库数量
    public function changeNum(Request $request){
        $goods_id = $request->input('goods_id');
        $buy_num = $request->input('buy_num');
        $user_id=session('login')['user_id'];

        $cart_model = new Car;
        $cartWhere=[
            'user_id'=>$user_id,
            'goods_id'=>$goods_id
        ];
        $cartData=[
            'buy_num'=>$buy_num
        ];
        $res = $cart_model->where($cartWhere)->update($cartData);
        if($res){
            $arr=[
                'font'=>'修改成功',
                'code'=>1
            ];
        }else{
            $arr=[
                'font'=>'修改失败',
                'code'=>2
            ];
        }
        echo json_encode($arr);

    }

    //获取总价格
    public function getCountPrice(Request $request){
        $goods_id=$request->input('goods_id');
        $id=explode(',',$goods_id);
        $user_id=session('login')['user_id'];
//        dd($user_id);
        $where=[
            'user_id'=>$user_id
        ];
        $cartInfo=DB::table('cars')->where($where)->whereIn('goods_id',$id)->get();
        $goodsInfo=DB::table('goods')->whereIn('goods_id',$id)->get();
        $countPrice=0;
        foreach($cartInfo as $k=>$v){
                foreach ($goodsInfo as $key=>$val){
                    if($v->goods_id==$val->goods_id){
                        $countPrice=$countPrice+$v->buy_num*$val->goods_price;
                    }

                }

        }
        return $countPrice;
    }

    //去结算
    public function gopay(Request $request){
        $goods_id=$request->input('goods_id');

        //检测是否选择商品
        if(empty($goods_id)){
            $arr=[
                'code'=>2,
                'font'=>'请选择一个商品'
            ];
            return json_encode($arr);die;
        }
        $id=explode(',',$goods_id);
        $goodsInfo=DB::table('cars')
            ->join('goods','cars.goods_id','=','goods.goods_id')
            ->where('cars.car_status',1)
            ->whereIn('cars.goods_id',$id)
            ->get();
//dd($goodsInfo);
        $countPrice = 0;
        foreach($goodsInfo as $k=>$v){
            $countPrice=$countPrice + $v->buy_num * $v->goods_price;
        }
//        dd($countPrice);
        $address_model=new Address;
        $where=[
            'is_default'=>1
        ];
        $addressInfo=$address_model::where($where)->get();
//        $addressInfo=$this->getAddressInfo();
//        dd($addressInfo);die;
        return view('car/gopay',compact('goodsInfo','countPrice','addressInfo'));
    }


    //提交订单
    public function successdo(Request $request)
    {
        $data = $request->input();
//        dd($data);die;
        unset($data['_token']);
        //生成订单号
        $order_no = time() . rand(10000000, 99999999);
        //存入订单表
        $goods_id = explode(',', $data['goods_id']);
        $goodsInfo = DB::table('cars')
            ->join('goods', 'goods.goods_id', '=', 'cars.goods_id')
            ->where(['cars.user_id' => session('login')['user_id'], 'cars.car_status' => 1])
            ->wherein('goods.goods_id', $goods_id)
            ->get();
        $order_amount = 0;
        foreach ($goodsInfo as $k => $v) {
            $order_amount = $order_amount + $v->buy_num * $v->goods_price;
        }
        $orderInfo = [
            'order_no' => $order_no,
            'user_id' => session('login')['user_id'],
            'pay_way' => $data['pay_way'],
            'order_amount' => $order_amount,
            'create_time' => time()
        ];
        $res1 = DB::table('order')->insert($orderInfo);
        $order_id = DB::getPdo()->lastInsertId($res1);
        if (!$res1) {
            echo "订单信息写入失败";
        }

        //存入商品收货地址表
        //查询收货地址;
        $addressInfo = DB::table('address')->where('address_id', $data['address_id'])->first();
        $orderAddress = [];
        foreach ($addressInfo as $k => $v) {
            $orderAddress[$k] = $v;
        }
        $orderAddress['order_id'] = $order_id;
        unset($orderAddress['address_status']);
        unset($orderAddress['create_time']);
        $res2 = DB::table('shop_order_address')->insert($orderAddress);

        //存入商品详情
        $detail_model=new Detail;
        // dd($goods_id);
        $detail_model->user_id=session('login.user_id');
        //查询结算的商品
        $goods_model=new Good;
        $car_model=new car;
//        dd($goodsInfo);
        foreach($goodsInfo as $k=>$v){
            $detailInfo=[
                'user_id'=>session('login.user_id'),
                'order_id'=>$order_id,
                'goods_id'=>$v->goods_id,
                'buy_num'=>$v->buy_num,
                'goods_price'=>$v->goods_price,
                'goods_name'=>$v->goods_name,
                'goods_img'=>$v->goods_img,
                'create_time'=>time(),
                'update_time'=>time()
            ];
//            dd($detailInfo);
            $res=DB::table('shop_order_detail')->insert($detailInfo);
            if($res){
                //删除购物车
                $re=$car_model->where('car_id',$v->car_id)->update(['car_status'=>2]);
                //商品库存减少
                $where=[
                    'goods_id'=>$v->goods_id
                ];

                $r=$goods_model->where($where)->update(['goods_num'=>$v->goods_num-$v->buy_num]);
                if($r){
                    $arr=[
                        'font'=>'订单提交成功',
                        'code'=>1,
                        'order_id'=>$order_id
                    ];
                    return json_encode($arr);
                }else{
                    $arr=[
                        'font'=>'订单提交失败',
                        'code'=>2
                    ];
                    return json_encode($arr);
                }
            }
        }

    }

    //订单提交成功  展示数据
    public function success(Request $request){
        $order_id=$request->order_id;
//        dd($order_id);die;
        //根据订单id 插叙订单编号 支付方式 订单总金额
        $where=[
            'order.order_id'=>$order_id
        ];
        $data=DB::table('order')
//            ->join('shop_order_detail','order.order_id','=','shop_order_detail.order_id')
            ->where($where)
            ->get();
//        dd($data);
        return view('car/success',compact('data'));
    }


    //支付宝 pc端支付
    public function alipay( $order_no ){
//        echo $order_no;
    if(!$order_no){
//            return redirect('car/success')->with('没有此订单信息');
    }
    //根据订单号获取订单信息  订单金额
    $orderInfo=DB::table('order')->select(['order_amount','order_no'])->where('order_no',$order_no)->first();
//        dd($orderInfo);
    if(!$orderInfo->order_amount<=0){
//            return redirect('car/success')->with('此订单无效');
    }

//        dd(app_path('libs\alipay\pagepay\service\AlipayTradeService.php'));die;
    require_once app_path('libs\alipay\pagepay\service\AlipayTradeService.php');
    require_once app_path('libs\alipay\pagepay\buildermodel\AlipayTradePagePayContentBuilder.php');

    //商户订单号，商户网站订单系统中唯一订单号，必填
    $out_trade_no = trim($order_no);

    //订单名称，必填
    $subject = '测试';

    //付款金额，必填
    $total_amount = $orderInfo->order_amount;

    //商品描述，可空
    $body = '测试';

    //构造参数
    $payRequestBuilder = new \AlipayTradePagePayContentBuilder();
    $payRequestBuilder->setBody($body);
    $payRequestBuilder->setSubject($subject);
    $payRequestBuilder->setTotalAmount($total_amount);
    $payRequestBuilder->setOutTradeNo($out_trade_no);

    $aop = new \AlipayTradeService(config('alipay'));

    /**
     * pagePay 电脑网站支付请求
     * @param $builder 业务参数，使用buildmodel中的对象生成。
     * @param $return_url 同步跳转地址，公网可以访问
     * @param $notify_url 异步通知地址，公网可以访问
     * @return $response 支付宝返回的信息
     */
    $response = $aop->pagePay($payRequestBuilder,config('alipay.return_url'),config('alipay.notify_url'));

    //输出表单
    var_dump($response);

}

    public function returnpay(){
        //pc端
//        require_once app_path('libs\alipay\pagepay\service\AlipayTradeService.php');
        //手机端
echo 123;die;
//        $arr=$_GET;
//        dump($arr);
////        $arr['fund_bill_list']=stripslashes($arr['fund_bill_list']);
//        $alipaySevince = new \AlipayTradeService(config('alipay'));
//        $result=$alipaySevince->check($_GET);
//        dump($result)
        $out_trade_no=trim($_GET['out_trade_no']);
        $total_amount=trim($_GET['total_amount']);
        $data=DB::table('order')->where(['order_no'=>$out_trade_no,'order_amount'=>$total_amount])->first();
        if(!$data){
            return redirect('/car/index')->with('付款错误，无此订单');
        }
        if(trim($_GET['seller_id'])!=config('phonepay.seller_id')||trim($_GET['app_id'])!=config('alipay.app_id')){
            return redirect('/car/index')->with('付款错误，商家或买家错误');
        }
//        echo 123;
    }

    //手机支付
    public function phonepay($order_no){
        //根据订单号获取订单信息  订单金额
        $orderInfo=DB::table('order')->select(['order_amount','order_no'])->where('order_no',$order_no)->first();
//        dd($orderInfo);
        if(!$orderInfo->order_amount<=0){
//            return redirect('car/success')->with('此订单无效');
        }
//        dd(app_path('libs\alipay.trade.wap.pay\buildermodel\AlipayTradeWapPayContentBuilder.php'));die;
        require_once app_path('libs\h5\wappay\service\AlipayTradeService.php');
        require_once app_path('libs\h5\wappay\buildermodel\AlipayTradeWapPayContentBuilder.php');
//        require dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'./../config.php';
        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = trim($order_no);

        //订单名称，必填
        $subject = '测试';

        //付款金额，必填
        $total_amount =  $orderInfo->order_amount;

        //商品描述，可空
        $body = '测试';

        //超时时间
        $timeout_express="1m";

        $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($out_trade_no);
        $payRequestBuilder->setTotalAmount($total_amount);
        $payRequestBuilder->setTimeExpress($timeout_express);

        $payResponse = new \AlipayTradeService(config('phonepay'));
        $result=$payResponse->wapPay($payRequestBuilder,config('phonepay.return_url'),config('phonepay.notify_url'));

        return ;
    }

    //支付异步通知
    public function notifypay(){
//        $arr=$_POST;

//        if($res){
//            $out_trade_no=trim($_GET['out_trade_no']);
//            $total_amount=trim($_GET['total_amount']);
//            if($arr['trade_status']=='TRADE_FINISHED'){
//
//            }else if($_POST['trade_status']=='TRADE_SUCCESS'){
//                $orderWhere=[
//                    'order_no'=>$out_trade_no,
//                    'order_amount'=>$total_amount
//                ];
//                $data=DB::table('order')->where($orderWhere)->first();
//                if($data){
//                    //修改订单表的支付状态
//                    $orderUpdate=DB::table('order')->where('order_no',$out_trade_no)->update(['pay_status'=>2]);
//
//                }
//                echo "success";
//
//            }
//        }
//    dd($_POST);
        $arr=json_encode($_POST);
        $str=var_export($arr,true);
        file_put_contents("/tmp/alipay.log",$str,FILE_APPEND);
        Log::channel('pay')->info($arr);

        $out_trade_no=trim($_POST['out_trade_no']);
        $total_amount=trim($_POST['total_amount']);
       $data=DB::table('order')->where(['order_no'=>$out_trade_no,'order_amount'=>$total_amount])->first();
       if(!$data){
           Log::channel('pay')->info($arr.'无此订单');exit;
        }
        if(trim($_GET['seller_id'])!=config('phonepay.seller_id')||trim($_GET['app_id'])!=config('alipay.app_id')){
            Log::channel('pay')->info($arr.'付款错误，商家或买家错误');
       }

    }

}
