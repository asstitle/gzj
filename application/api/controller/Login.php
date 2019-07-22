<?php
namespace app\api\controller;
use app\common\Controller\ApiBase;
use think\Db;
//登录
class Login extends ApiBase
{
    public function login_in(){
        if($this->request->isPost()){
            $mobile=$this->request->param('mobile');
            $passwd=$this->request->param('passwd');
            $type=$this->request->param('type');
            if(!preg_match('/^1[34578]\d{9}$/',$mobile)){
                return json(array('code'=>300,'info'=>'手机号格式有误'));
            }
            if($type==0){
                return json(array('code'=>301,'info'=>'请选择商家还是普通用户'));
            }
            $key=config('api_KEY');
            $new_passwd=md5($key.$passwd);
            $user_info=Db::name('users')->where(array('mobile'=>$mobile))->field('id,mobile,passwd,type')->find();
            if(empty($user_info)){
                return json(array('code'=>302,'info'=>'该用户不存在'));
            }else{
                if($new_passwd!=$user_info['passwd']){
                 return json(array('code'=>303,'info'=>'密码错误'));
                }
                if($type!=$user_info['type']){
                    return json(array('code'=>304,'info'=>'用户类别错误'));
                }
                $info=Db::name('users')->where(array('mobile'=>$mobile,'passwd'=>$new_passwd,'type'=>$type))->field('id,mobile,passwd,type')->find();
                if($info){
                    return json(array('code'=>305,'info'=>'登录成功','user_id'=>$info['id'],'type'=>$info['type']));
                }else{
                    return json(array('code'=>306,'info'=>'登录失败'));
                }
            }
        }
    }
}