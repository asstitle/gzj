<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
class Sundry extends Controller
{
    //获取工作时间
    public function get_select_work_time(){
        if($this->request->isPost()){
          $res=Db::name('select_work_time')->select();
          if($res){
           return json(array('code'=>200,'info'=>'获取成功','data'=>$res));
          }else{
           return json(array('code'=>201,'info'=>'获取失败','data'=>[]));
          }
        }

    }
    //获取薪水结算时间
    public function get_select_salary_time(){
        if($this->request->isPost()){
            $res=Db::name('select_salary_time')->select();
            if($res){
                return json(array('code'=>200,'info'=>'获取成功','data'=>$res));
            }else{
                return json(array('code'=>201,'info'=>'获取失败','data'=>[]));
            }
        }
    }
    //获取薪水选择列表
    public function get_select_salary(){
        if($this->request->isPost()){
            $res=Db::name('select_salary')->select();
            if($res){
                return json(array('code'=>200,'info'=>'获取成功','data'=>$res));
            }else{
                return json(array('code'=>201,'info'=>'获取失败','data'=>[]));
            }
        }
    }
}