<?php

namespace app\xyb\Controller;
use app\common\Controller\Base;
use think\Db;
class Rbac extends Base
{
     //角色管理界面
    public function index(){
       $data = Db::name('role')->order(["list_order" => "ASC", "id" => "DESC"])->select();
       $this->assign("roles", $data);
       return $this->fetch();
    }
    //角色添加
    public function role_add(){
        return $this->fetch();
    }
    //角色添加提交
    public function role_add_post(){
      if($this->request->isPost()){
          $data['name'] =$this->request->param('name');
          $data['remark']=$this->request->param('remark');
          $data['status']=$this->request->param('status');
          $data['create_time']=time();
          $data['update_time']=time();
          $result = Db::name('role')->insert($data);
          if ($result) {
              $this->success("添加角色成功", url("rbac/index"));
          } else {
              $this->error("添加角色失败");
          }
      }
    }

}