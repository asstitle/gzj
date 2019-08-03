<?php

namespace app\api\controller;
use think\Controller;
use think\Db;
class Register extends Controller
{
    /**
     * 注册操作
     */
    public function registerDo(){
      if($this->request->isPost()){
          $mobile=$this->request->param('mobile');
          $tj_code=$this->request->param('tj_code') ? $this->request->param('tj_code') : 0;
          $input_code=$this->request->param('input_code');
          $correct_code=$this->request->param('correct_code');
          if(!preg_match('/^1[34578]\d{9}$/',$mobile)){
             return json(array('code'=>202,'info'=>'手机号格式有误'));
          }
          if($input_code!=$correct_code){
              return json(array('code'=>203,'info'=>'验证码错误'));
          }
          $info=Db::name('users')->where(array('mobile'=>$mobile))->find();
          if(!empty($info)){
              return json(array('code'=>204,'info'=>'该手机号已存在'));
          }else{
              return json(array('code'=>200,'info'=>'操作成功'));
          }

      }
    }

    /**
     * 设置密码
     */
    public function set_passwd(){
        if($this->request->isPost()){
            $mobile=$this->request->param('mobile');
            $passwd=$this->request->param('passwd');
            $passwd_confirm=$this->request->param('passwd_confirm');
            $tj_code=$this->request->param('tj_code') ? $this->request->param('tj_code') : 0;
            if(!preg_match('/^1[34578]\d{9}$/',$mobile)){
                return json(array('code'=>202,'info'=>'手机号格式有误'));
            }
            if($passwd!=$passwd_confirm){
                return json(array('code'=>205,'info'=>'两次输入密码不一致'));
            }
            $key=config('api_KEY');
            $data['mobile']=$mobile;
            $data['passwd']=md5($key.$passwd);
            $data['tj_code']=$tj_code;
            $user_id=Db::name('users')->insertGetId($data);
            if($user_id){
                return json(array('code'=>200,'info'=>'注册成功','user_id'=>$user_id));
            }else{
                return json(array('code'=>206,'info'=>'注册失败'));
            }
        }
    }

    /**
     * 忘记密码
     */
    public function forget_passwd(){
        if($this->request->isPost()){
            $mobile=$this->request->param('mobile');
            $input_code=$this->request->param('input_code');
            $correct_code=$this->request->param('correct_code');
            if(!preg_match('/^1[34578]\d{9}$/',$mobile)){
                return json(array('code'=>202,'info'=>'手机号格式有误'));
            }
            $info=Db::name('users')->where(array('mobile'=>$mobile))->find();
            if(empty($info)){
                return json(array('code'=>211,'info'=>'该手机尚未注册'));
            }
            if($input_code!=$correct_code){
                return json(array('code'=>207,'info'=>'验证码错误'));
            }else{
                return json(array('code'=>200,'info'=>'操作成功'));
            }
        }
    }

    /**
     * 修改密码操作
     */
    public function change_passwd(){
       if($this->request->isPost()){
           $mobile=$this->request->param('mobile');
           $passwd=$this->request->param('passwd');
           $passwd_confirm=$this->request->param('passwd_confirm');
           if(!preg_match('/^1[34578]\d{9}$/',$mobile)){
               return json(array('code'=>202,'info'=>'手机号格式有误'));
           }
           if($passwd!=$passwd_confirm){
             return json(array('code'=>208,'info'=>'两次输入密码不一致'));
           }
           $key=config('api_KEY');
           $new_passwd=md5($key.$passwd);
           $res=Db::name('users')->where(array('mobile'=>$mobile))->field('mobile,id,passwd')->find();
           if(empty($res)){
               return json(array('code'=>209,'info'=>'该修改密码的手机号不存在'));
           }
           if($new_passwd==$res['passwd']){
               return json(array('code'=>212,'info'=>'新密码不能与原密码一样'));
           }
           $info=Db::name('users')->where(array('id'=>$res['id']))->update(array('passwd'=>$new_passwd));
           if($info){
               return json(array('code'=>200,'info'=>'密码修改成功'));
           }else{
               return json(array('code'=>210,'info'=>'密码修改失败'));
           }
       }
    }
    //获取验证码
    public function get_code(){
        if($this->request->isPost()){
            $mobile=$this->request->param('mobile');
            $clapi = new \info\ChuanglanSmsApi();

            //生成随机数（6位数）
            $code = mt_rand(100000,999999);
            //设置您要发送的内容：其中“【】”中括号为运营商签名符号，多签名内容前置添加提交
            $result = $clapi->sendSMS($mobile,'【253云通讯】您好！验证码是:'.$code);

            if(!is_null(json_decode($result))){
                $output=json_decode($result,true);
                if(isset($output['code'])  && $output['code']=='0'){
                 return json(array('code'=>200,'info'=>'发送成功','code_num'=>$code));
                }else{
                    return json(array('code'=>201,'info'=>$output['errorMsg'],'code_num'=>'')) ;
                }
            }else{
                return json(array('code'=>200,'info'=>'发送成功','code_num'=>$code));
            }
        }
    }
}