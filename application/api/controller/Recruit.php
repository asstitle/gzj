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
             //先查询该商户是否查看过该简历
             $is_record=Db::name('look_recruit_record')->where(array('usj_id'=>$usj_id,'user_id'=>$user_id))->find();
             if(!empty($is_record)){
               //查看过
                 return json(array('code'=>200,'info'=>'该简历查看过'));
             }else{
                 $user_info=Db::name('user')->where(array('id'=>$user_id))->field('coins')->find();
                 if($coins>$user_info['coins']){
                     return json(array('code'=>401,'info'=>'金币余额不足'));
                 }else{
                     //查看简历记录表
                     $data1['usj_id']=$usj_id;
                     $data1['user_id']=$user_id;
                     $data1['add_time']=time();
                     Db::name('look_recruit_record')->insert($data1);
                     //消费明细
                     $data['user_id']=$user_id;
                     $data['coins']=-$coins;
                     $data['content']='查看简历';
                     $data['type']=1;
                     $data['add_time']=time();
                     Db::name('look_resume_record')->insert($data);
                     //users表中总金额改变
                     Db::name('users')->where(array('id'=>$user_id))->setDec('coins',$coins);
                     return json(array('code'=>402,'info'=>'操作成功'));
                 }
             }

         }
     }
     //商家查看用户找工作列表
     public function user_seek_job_list(){
         if($this->request->isPost()){
             $user_id=$this->request->param('user_id');
             $info=Db::name('user_seek_job')->order('add_time desc')->where(array('status'=>1))->select();
             $arr=array();
             if(!empty($info)){
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
             }
             if(empty($arr)){
                 return json(array('code'=>201,'info'=>'暂无数据','arr'=>$arr));
             }else{
                 return json(array('code'=>200,'info'=>'请求成功','arr'=>$arr));
             }
         }
     }

     //商户把求职者拉入黑名单
     public function pull_user_seek_black(){
         if($this->request->isPost()){
             $user_id=$this->request->param('user_id');//商家id
             $seek_user_id=$this->request->param('seek_user_id');//求职者id
             $usj_id=$this->request->param('usj_id');
             $coins=$this->request->param('coins');
             $info=Db::name('users')->where(array('id'=>$user_id))->field('coins')->find();
             if($coins>$info['coins']){
                 return json(array('code'=>403,'info'=>'金币余额不足'));
             }
             $data['user_id']=$user_id;
             $data['seek_user_id']=$seek_user_id;
             $data['usj_id']=$usj_id;
             $data['add_time']=time();
             $res=Db::name('sh_pull_black')->insert($data);
             if($res){
                return json(array('code'=>404,'info'=>'拉黑成功'));
             }else{
               return json(array('code'=>405,'info'=>'拉黑失败'));
             }
         }
     }

     //商户向某个求职者发送消息
     public function sh_to_message_user(){
        if($this->request->isPost()){
            $user_id=$this->request->param('user_id');//商户ID
            $seek_user_id=$this->request->param('seek_user_id');//求职者id
            $content=$this->request->param('content');
            $data['user_id']=$user_id;
            $data['seek_user_id']=$seek_user_id;
            $data['content']=$content;
            $result=Db::name('sh_post_message')->insert($data);
            if($result){
                return json(array('code'=>406,'info'=>'发送成功'));
            }else{
                return json(array('code'=>407,'info'=>'发送失败'));
            }
        }
     }
     //商户发布招聘需求
     public function employ_require(){
         if($this->request->isPost()){
              $data['company_name']=$this->request->param('company_name');
              $data['seek_job']=$this->request->param('seek_job');//招聘岗位',
              $data['work_time'] =$this->request->param('work_time');//工作时间
              $data['work_address']=$this->request->param('work_address');//工作地址',
              $data['demand_num']=$this->request->param('demand_num');//需求人数',
              $data['salary_rand']=$this->request->param('salary_rand');//薪资范围',
              $data['salary_type']=$this->request->param('salary_type'); //'薪资结算时间',
              $data['work_detail']=$this->request->param('work_detail');//'工作详情',
              $data['work_pic']=$this->request->param('work_pic');// '工作图片',
              $data['contact_user'] =$this->request->param('contact_user');//'联系人',
              $data['tel']=$this->request->param('tel'); //'联系电话',
              $data['status']=1;// '1发布中，0已关闭',
              $data['add_time']=time();// '发布时间',
              $res=Db::name('recruit_company')->insert($data);
              if($res){
                return json(array('code'=>408,'info'=>'发布成功'));
              }else{
                return json(array('code'=>409,'info'=>'发布失败'));
              }
         }
     }
}