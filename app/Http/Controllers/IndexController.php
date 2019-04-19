<?php

namespace App\Http\Controllers;

use App\Good;
use App\Users;
use Illuminate\Http\Request;
use App\Email\PHPMailer;
use Illuminate\Support\Facades\Session;

class IndexController extends Controller
{
    public function index(){
        $model=new Good;
        $data=$model->paginate(6);
        //dd($data);
        return view('index/index',compact('data'));
    }
    public function register(){
        return view('index/register');
    }
    //邮箱验证，获取验证码
    public function checkEmail(Request $request){
        $code=rand(1000,9999);
        //dd($code);
        $user_name=$request->input('email');
        //dd($account);
        $model=new Users;
        $info=$model::where('user_name',$user_name)->first();
        //dd($info);
        if($info){
            $arr=[
                'font'=>'该邮箱已注册',
                'code'=>2
            ];
            echo json_encode($arr);exit;
        }
        $res=$this->sendEmail($user_name,$code);
        if($res){
            //return redirect('index/register')->with('message','验证码发送成功');
            session(['code'=>['code'=>$code]]);
            $arr=[
                'font'=>'验证码发送成功',
                'code'=>1
            ];
            echo json_encode($arr);
        }
    }
    //邮箱唯一验证，验证码验证，注册入库
    public function registerdo(Request $request){
        $data=$request->all();
        //dd(session('code'));
        $model=new Users;
        $info=$model::where('user_name',$data['user_name'])->first();
        if($info){
            return redirect('index/register')->with('message','该邮箱已注册');exit;
        }
//        if($data['code']!=session('code')['code']){
//            return redirect('index/register')->with('message','验证码错误');exit;
//        }
        $data['user_pwd']=encrypt($data['user_pwd']);
        unset($data['_token']);
        unset($data['repwd']);
        $res=$model->insert($data);
        if($res){
            return redirect('index/index')->with('message','注册成功');
        }
    }

    // 发送邮件
    function sendEmail($user_email,$code){
        // echo $user_email;
        // echo $code;
        // exit;
        //实例化PHPMailer核心类
        $mail = new PHPMailer();
        // var_dump($mail);exit;

        //是否启用smtp的debug进行调试 开发环境建议开启 生产环境注释掉即可 默认关闭debug调试模式
        $mail->SMTPDebug =0;

        //使用smtp鉴权方式发送邮件
        $mail->isSMTP();

        //smtp需要鉴权 这个必须是true
        $mail->SMTPAuth=true;

        //链接qq域名邮箱的服务器地址
        $mail->Host = ' smtp.163.com';//163邮箱：smtp.163.com

        //设置使用ssl加密方式登录鉴权
        $mail->SMTPSecure = 'ssl';//163邮箱就注释

        //设置ssl连接smtp服务器的远程服务器端口号，以前的默认是25，但是现在新的好像已经不可用了 可选465或587
        $mail->Port = 465;//163邮箱：25

        //设置smtp的helo消息头 这个可有可无 内容任意
        // $mail->Helo = 'Hello smtp.qq.com Server';

        //设置发件人的主机域 可有可无 默认为localhost 内容任意，建议使用你的域名
        //$mail->Hostname = 'http://localhost/';

        //设置发送的邮件的编码 可选GB2312 我喜欢utf-8 据说utf8在某些客户端收信下会乱码
        $mail->CharSet = 'UTF-8';

        //设置发件人姓名（昵称） 任意内容，显示在收件人邮件的发件人邮箱地址前的发件人姓名
        $mail->FromName = 'jennifer';

        //smtp登录的账号 这里填入字符串格式的qq号即可
        $mail->Username ='18612829315@163.com';

        //smtp登录的密码 使用生成的授权码（就刚才叫你保存的最新的授权码）
        $mail->Password = '7788521zyz';//163邮箱也有授权码 进入163邮箱帐号获取

        //设置发件人邮箱地址 这里填入上述提到的“发件人邮箱”
        $mail->From = "$user_email";

        //邮件正文是否为html编码 注意此处是一个方法 不再是属性 true或false
        $mail->isHTML(true);

        //设置收件人邮箱地址 该方法有两个参数 第一个参数为收件人邮箱地址 第二参数为给该地址设置的昵称 不同的邮箱系统会自动进行处理变动 这里第二个参数的意义不大
        $mail->addAddress("18612829315@163.com");

        //添加多个收件人 则多次调用方法即可
        // $mail->addAddress('xxx@163.com','爱代码，爱生活世界');

        //添加该邮件的主题
        $mail->Subject = '您的注册验证码，请及时使用';

        //添加邮件正文 上方将isHTML设置成了true，则可以是完整的html字符串 如：使用file_get_contents函数读取本地的html文件
        $mail->Body = "{$code}";

        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );
        $status = $mail->send();
        // var_dump($status);die;
        //简单的判断与提示信息
        if($status) {
            return true;
        }else{
            return false;
        }
    }

    //登录
    public function login(){
        return view('index/login');
    }

    public function logindo(Request $request){
        $data=$request->input();
//        dd($data);
        $model=new Users;
        $where=[
            'user_name'=>$data['user_name']
        ];
        $info=$model->where($where)->first()->toarray();
//        dd($info);
        if(empty($info)){
            return redirect('index/login')->with('message','账号或密码错误');exit;
        }
        $pwd1=$data['user_pwd'];
        $pwd2=decrypt($info['user_pwd']);
        //dd($pwd2);
        if($pwd1!=$pwd2){
            return redirect('index/login')->with('message','账号或密码错误');exit;
        }else{
            $sendinfo = [
                'user_id'=> $info['user_id'],
                'user_name'=> $info['user_name']
            ];
            session(['login'=>$sendinfo]);
            return redirect('index/index')->with('message','登录成功');
        }
    }

    public function fenxiao(){
        return view('index/fenxiao');
    }
}