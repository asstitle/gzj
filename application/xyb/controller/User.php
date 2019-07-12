<?php

namespace app\xyb\Controller;

use app\common\Controller\Base;
use think\Db;
class User extends Base
{
    //系统用户列表
   public function index(){
       $info=Db::name('user')->order('last_login_time desc')->paginate(10);
       $page=$info->render();
       $this->assign('info',$info);
       $this->assign('page',$page);
       return $this->fetch();
   }
   //添加用户
   public function add_user(){
       $roles = Db::name('role')->where(['status' => 1])->order("id DESC")->select();
       $this->assign("roles", $roles);
       return $this->fetch();
   }
   //添加用户提交
   public function add_user_post(){
       if ($this->request->isPost()) {
           if (!empty($_POST['role_id']) && is_array($_POST['role_id'])) {
               $role_ids = $_POST['role_id'];
               unset($_POST['role_id']);
                   $mrt=Config('MD5_KEY');
                   $_data['user_pass'] = Md5($mrt.$_POST['user_pass']);
                   $_data['user_login'] = $this->request->param('user_login');
                   $_data['sex'] = $this->request->param('sex');
                   $_data['mobile'] = $this->request->param('mobile');
                   $_data['create_time'] =time();
                   $_data['user_status'] =$this->request->param('user_status');
                   $result             = Db::name('user')->insertGetId($_data);
                   if ($result !== false) {
                       //$role_user_model=M("RoleUser");
                       foreach ($role_ids as $role_id) {
                           /*if (cmf_get_current_admin_id() != 1 && $role_id == 1) {
                               $this->error("为了网站的安全，非网站创建者不可创建超级管理员！");
                           }*/
                           Db::name('RoleUser')->insert(["role_id" => $role_id, "user_id" => $result]);
                       }
                       $this->success("添加成功！", url("user/index"));
                   } else {
                       $this->error("添加失败！");
                   }
               }
           } else {
               $this->error("请为此用户指定角色！");
           }
   }
}