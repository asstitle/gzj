<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
//登录
class Login extends Controller
{
    public function login_in(){
        if($this->request->isPost()){
            $mobile=$this->request->param('mobile');
            $passwd=$this->request->param('passwd');
            $type=$this->request->param('type');//1商家 2用户
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
                $info=Db::name('users')->where(array('mobile'=>$mobile,'passwd'=>$new_passwd))->field('id,mobile,passwd,type')->find();
                if($info){
                       session('user_id',$info['id']);
                      return json(array('code'=>305,'info'=>'登录成功','user_id'=>$info['id'],'type'=>$type));
                }else{
                    return json(array('code'=>306,'info'=>'登录失败'));
                }
            }
        }
    }

    //商户第一次登陆完善相关信息
    public function update_info(){

        if($this->request->isPost()){
            $select_type=$this->request->param('select_type');//1-招聘者 2-商铺 3-二手车
            $user_id=$this->request->param('user_id');
            //更新商户当前身份状态
            Db::name('users')->where(array('id'=>$user_id))->update(array('now_select_type'=>$select_type));
            $info=Db::name('user_type_info')->where(array('user_id'=>$user_id,'select_type'=>$select_type))->find();
            if(empty($info)){
               return json(array('code'=>307,'info'=>'信息不存在,请完善相关信息','is_deal'=>-1));
            }else{
                if($info['is_deal']==1){
                    return json(array('code'=>308,'info'=>'信息已完善','is_deal'=>1));
                }else{
                    return json(array('code'=>309,'info'=>'信息已存在,请完善相关信息','is_deal'=>0));
                }
            }
        }
    }

    //退出登录
    public function login_out(){
      if($this->request->isPost()){
          session('user_id',null);
          session(null);
          return json(array('code'=>310,'info'=>'退出成功'));
      }
    }
}