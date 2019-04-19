<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class WxPayController extends Controller
{
    public $values=[];
    public $weixin_order_url = "https://api.mch.weixin.qq.com/pay/unifiedorder"; //调用统一下单接口
    public $notify_url = "https://1809zhangyuzhen.comcto.com/wxpay/notify";//支付回调

    /**
     * 微信测试
     */
    public function goes($id){
        $money = 1;
        $order_id=md5(time().mt_rand(111111,999999).'zhangyuzhen');    //随机生成订单号
        $order_info=[
            'appid'=>env('WEIXIN_APPID_0'),                 //微信支付绑定
            'mch_id'=>env('WEIXIN_MCH_ID'),                //商户号
            'nonce_str'=>Str::random(16),                //随机字符串
            'sign_type'=>'MD5',                                 //签名类型
            'body'=>'测试订单-'.$id,        //商品描述
            'out_trade_no'=>$order_id,                          //商户订单号
            'total_fee'=>$money,                                //需要付钱的金额
            'spbill_create_ip'=> $_SERVER['REMOTE_ADDR'],    //终端IP
            'notify_url'=>$this->notify_url,                  //回调地址
            'trade_type'=>'NATIVE'                            //交易类型
        ];
        $this->values = $order_info;
        $this->Setsign();
        $xml=$this->ToXml(); //数组转化成xml格式
        $res=$this->postXmlCurl($xml,$this->weixin_order_url,$useCert=false,$second=30);
        $data = simplexml_load_string($res);
//        echo 'return_code: '.$data->return_code;echo '<br>';
//		echo 'return_msg: '.$data->return_msg;echo '<br>';
//		echo 'appid: '.$data->appid;echo '<br>';
//		echo 'mch_id: '.$data->mch_id;echo '<br>';
//		echo 'nonce_str: '.$data->nonce_str;echo '<br>';
//		echo 'sign: '.$data->sign;echo '<br>';
//		echo 'result_code: '.$data->result_code;echo '<br>';
//		echo 'prepay_id: '.$data->prepay_id;echo '<br>';
//		echo 'trade_type: '.$data->trade_type;echo '<br>';
//        echo 'code_url: '.$data->code_url;echo '<br>';
//die;
//        将 code_url 返回给前端，前端生成 支付二维码
        $data = [
            'code_url'  => $data->code_url
        ];
        return view('wxpay/goes',$data);
    }

    /**
     * 设置签名
     */
    public function Setsign(){
        $sign=$this->makeSign();
        $this->values['sign']=$sign;
        return $sign;

    }

    /**
     * 制作签名
     */
    public function makeSign(){
        //步骤一 ：按字典序排序
        ksort($this->values);
        $string = $this->ToUrlParams();
        //步骤二 ：在string最后拼接上key
        $string = $string."&key=".env('WEIXIN_MCH_KEY');
        //步骤三 ：MD5加密
        $string = md5($string);
        //步骤四 ：所有字符串大写
        $result = strtoupper($string);
        return $result;
    }

    /**
     * 参数格式转化成url格式
     */
    public function ToUrlParams(){
        $buff = '';
        foreach($this->values as $k=>$v){
            if($k!="sign" && $v!="" && !is_array($v)){
                $buff.=$k."=".$v."&";
            }
        }
        $buff=trim($buff,"&");
        return $buff;
    }

    /**
     * 数组转化成xml格式
     */
    public function ToXml(){
        if(!is_array($this->values)||count($this->values)<=0){
            die("数据异常");
        }
        $xml='<xml>';
        foreach ($this->values as $k=>$v){
            if (is_numeric($v)){
                $xml.="<".$k.">".$v."</".$k.">";
            }else{
                $xml.="<".$k."><![CDATA[".$v."]]></".$k.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }

    private  function postXmlCurl($xml, $url, $useCert = false, $second = 30)
    {
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $second);
        curl_setopt($ch,CURLOPT_URL, $url);
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,TRUE);
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,2);//严格校验
        //设置header
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        //要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //post提交方式
        curl_setopt($ch, CURLOPT_POST, TRUE);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        //运行curl
        $data = curl_exec($ch);
        //返回结果
        if($data){
            curl_close($ch);
            return $data;
        } else {
            $error = curl_errno($ch);
            curl_close($ch);
            die("curl出错，错误码:$error");
        }
    }

    /**
     * 微信支付回调
     */
    public function notify(){
        $data=file_get_contents("php://input");
        //日志
        $log_str=date("Y-m-d h:i:s")."\n".$data."\n";
        file_put_contents('logs/wx_pay_notice.log',$log_str,FILE_APPEND);
        $xml=simplexml_load_string($data);
        if($xml->result_code=='SUCCESS' && $xml->return_code=='SUCCESS'){//微信支付回调
            //验证签名
            $sign=true;
            if($sign){//签名验证成功
                //订单状态处理
            }else{
                //验签失败
                echo '验签失败，IP: '.$_SERVER['REMOTE_ADDR'];
            }
        }
        $response = '<xml><return_code><![CDATA[SUCCESS]]></return_code><return_msg><![CDATA[OK]]></return_msg></xml>';
        echo $response;
    }
}
