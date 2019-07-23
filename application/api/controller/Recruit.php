<?php

namespace app\api\controller;


use app\common\controller\ApiBase;
use think\Db;
class Recruit extends ApiBase
{
     //商户查看求职者详情
     public function look_recruit(){
         if($this->request->isPost()){
             $user_id=$this->request->param('user_id');//商家id
             $coins=$this->request->param('coins');//金币
             $usj_id=$this->request->param('usj_id');//求职者user_seek_job发布简历的id
             $user_info=Db::name('user')->where(array('id'=>$user_id))->field('coins')->find();
             if($coins>$user_info['coins']){
                 return json(array('code'=>401,'info'=>'金币余额不足'));
             }else{
                $data['look_user_id']=$user_id;
                $data['coins']=$coins;
                $data['usj_id']=$usj_id;
                $data['content']='查看简历';
                $data['add_time']=time();
                Db::name('look_resume_record')->insert($data);
                return json(array('code'=>402,'info'=>'操作成功'));
             }
         }
     }
     //商家查看用户找工作列表
     public function user_seek_job_list(){
         if($this->request->isPost()){
             $user_id=$this->request->param('user_id');
             $info=Db::name('user_seek_job')->order('add_time desc')->where(array('status'=>1))->select();
             $arr=array();
             foreach($info as $v){
                 $result=Db::name('sh_pull_black')->where(array('usj_id'=>$v['id'],'user_id'=>$user_id))->find();
                 if(empty($result)){
                     $v['is_black']=0;//0未拉黑
                 }else{
                     $v['is_black']=1;//已拉黑
                 }
                 $arr[]=$v;
                 unset($v);
             }
             if(empty($arr)){
                 return json(array('code'=>201,'info'=>'暂无数据'));
             }else{
                 return json(array('code'=>200,'info'=>'请求成功'));
             }
         }
     }

     //商户充值金币
     public function recharge_money(){

     }
}