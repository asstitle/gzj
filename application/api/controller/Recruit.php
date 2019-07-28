<?php

namespace app\api\controller;


use app\common\controller\ApiBase;
use think\Db;
class Recruit extends ApiBase
{
      //招聘雇主首页信息展示
      public function index(){

      }
     //招聘雇主求职者详情
     public function look_recruit(){
         if($this->request->isPost()){
             $user_id=$this->request->param('user_id');//商家id
             $coins=$this->request->param('coins');//金币
             $usj_id=$this->request->param('usj_id');//求职者user_seek_job发布简历的id
             //先查询该商户是否查看过该简历
             $is_record=Db::name('look_recruit_record')->where(array('usj_id'=>$usj_id,'user_id'=>$user_id))->find();
             if(!empty($is_record)){
               //查看过
                 $jl_info=Db::name('user_seek_jon')->where(array('id'=>$usj_id))->find();
                 return json(array('code'=>200,'info'=>'该简历查看过','jl_info'=>$jl_info));
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
                     $data['is_merchant']=1;
                     $data['select_type']=1;
                     $data['add_time']=time();
                     Db::name('user_consume_fee_detail')->insert($data);
                     //users表中总金额改变
                     Db::name('users')->where(array('id'=>$user_id))->setDec('coins',$coins);
                     //返回求职者详细信息
                     $jl_info=Db::name('user_seek_job')->where(array('id'=>$usj_id))->find();
                     return json(array('code'=>402,'info'=>'操作成功','jl_info'=>$jl_info));
                 }
             }

         }
     }
     //商家查看用户找工作列表
     public function user_seek_job_list(){
         if($this->request->isPost()){
             $user_id=$this->request->param('user_id');
             $info=Db::name('users')->where(array('id'=>$user_id))->field('sh_super_member')->find();
             if($info['sh_super_member']){
                $is_super_member=1;//超级会员
             }else{
               $is_super_member=0;//不是超级会员
             }
             $info=Db::name('user_seek_job')->order('add_time desc')->where(array('status'=>1))->select();
             $arr=array();
             if(!empty($info)){
                 foreach($info as $v){
                     $result=Db::name('sh_pull_black')->where(array('usj_id'=>$v['id']))->count();
                     if($result==0){
                         $v['is_black']=0;//0未拉黑
                     }else{
                         $v['is_black']=1;//已拉黑
                     }
                     $arr[]=$v;
                     unset($v);
                 }
             }
             if(empty($arr)){
                 return json(array('code'=>201,'info'=>'暂无数据','arr'=>$arr,'is_super_member'=>$is_super_member));
             }else{
                 return json(array('code'=>200,'info'=>'请求成功','arr'=>$arr,'is_super_member'=>$is_super_member));
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
            date_timezone_set('PRC');
            $start=mktime(0,0,0,date('m'),date('d'),date('Y'));
            $end=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
            $user_id=$this->request->param('user_id');//商户ID
            $type=$this->request->param('type');//1 商户 2 普通用户
            $info_arr=Db::name('users')->where(array('user_id'=>$user_id))->field('sh_super_member')->find();
            if($type==1){
               //商户超级会员每天只能发30条信息,商户普通会员每天只能发10条信息
                if($info_arr['sh_super_member']==1){
                    $count=Db::name('sh_post_message')->where(array('user_id'=>$user_id))->where('add_time','between',[$start,$end])->count();
                    if($count>=30){
                        return json(array('code'=>417,'info'=>'今日发送消息数量已达30条上线'));
                    }
                }else{
                    $count=Db::name('sh_post_message')->where(array('user_id'=>$user_id))->where('add_time','between',[$start,$end])->count();
                    if($count>=10){
                        return json(array('code'=>418,'info'=>'今日发送消息数量已达10条上线'));
                    }
                }

            }
            $seek_user_id=$this->request->param('seek_user_id');//求职者id
            $content=$this->request->param('content');
            //发送内容不能超过60字
            if(strlen($content)>60){
                return json(array('code'=>419,'info'=>'消息内容不能超过60个字符'));
            }
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
              $coins=$this->request->param('coins');
              $user_id=$this->request->param('user_id');
              $info=Db::name('users')->where(array('id'=>$user_id))->field('coins')->find();
              $public_status=Db::name('company')->where(array('user_id'=>$user_id,'select_type'=>1,'status'=>1))->find();
              $publish_record=Db::name('company_publish_record')->where(array('company_name'=>$this->request->param('company_name'),'work_address'=>$this->request->param('work_address')))->find();
              if(empty($publish_record)){
                  if($coins>$info['coins']){
                      return json(array('code'=>410,'info'=>'金币余额不足'));
                  }
              }
              if(empty($public_status)){
                return json(array('code'=>411,'info'=>'资料还未审核通过,请等待'));
               }
              $file_count=0;//实际上传图片的数量
              $recruit=Db::name('recruit_pic')->find();
              if($file_count<$recruit['num']){
                  return json(array('code'=>412,'info'=>'上传图片必须'.$recruit['num'].'张'));
              }
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
              $data['user_id']=$this->request->param('user_id');// '发布人',
              $res=Db::name('recruit_company')->insert($data);
              if($res){
                  if(empty($publish_record)){
                     Db::name('users')->where(array('id'=>$user_id))->setDec('coins',$coins);
                     $p_data['company_name'] =$this->request->param('company_name');
                     $p_data['work_address'] =$this->request->param('work_address');
                     Db::name('company_publish_record')->insert($p_data);
                  }
                  return json(array('code'=>408,'info'=>'发布成功'));
              }else{
                return json(array('code'=>409,'info'=>'发布失败'));
              }
         }
     }
     //商户编辑修改需求
     public function edit_employ(){
         if($this->request->isPost()){
             $coins=$this->request->param('coins');
             $user_id=$this->request->param('user_id');
             $info=Db::name('users')->where(array('id'=>$user_id))->field('coins')->find();
             $publish_record=Db::name('company_publish_record')->where(array('company_name'=>$this->request->param('company_name'),'work_address'=>$this->request->param('work_address')))->find();
             if(empty($publish_record)){
                 if($coins>$info['coins']){
                     return json(array('code'=>410,'info'=>'金币余额不足'));
                 }
             }
             $file_count=0;//实际上传图片的数量
             $recruit=Db::name('recruit_pic')->find();
             if($file_count<$recruit['num']){
                 return json(array('code'=>413,'info'=>'上传图片必须'.$recruit['num'].'张'));
             }
             $id=$this->request->param('id');//招聘简历id
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
             $data['user_id']=$this->request->param('user_id');// '发布人',
             $res=Db::name('recruit_company')->where(array('id'=>$id))->update($data);
             if($res){
                 if(empty($publish_record)){
                     Db::name('users')->where(array('id'=>$user_id))->setDec('coins',$coins);
                     $p_data['company_name'] =$this->request->param('company_name');
                     $p_data['work_address'] =$this->request->param('work_address');
                     Db::name('company_publish_record')->insert($p_data);
                 }
                 return json(array('code'=>411,'info'=>'操作成功'));
             }else{
                 return json(array('code'=>412,'info'=>'操作失败'));
             }

         }

     }
     //商户删除招聘需求
     public function delete_employ(){
         $id=$this->request->param('id');//招聘简历id
         $res=Db::name('recruit_company')->where(array('id'=>$id))->delete();
         if($res){
            return json(array('code'=>413,'info'=>'删除成功'));
         }else{
             return json(array('code'=>414,'info'=>'删除失败'));
         }
     }
     //商户关闭招聘需求
     public function close_employ(){
         $id=$this->request->param('id');//招聘简历id
         $res=Db::name('recruit_company')->where(array('id'=>$id))->update(array('status'=>0));
         if($res){
             return json(array('code'=>415,'info'=>'隐藏成功'));
         }else{
             return json(array('code'=>416,'info'=>'隐藏失败'));
         }
     }
     //招聘者邀请求职者查看岗位
     public function invite_user(){
        if($this->request->isPost()){
            $user_id=$this->request->param('user_id');
            $seek_user_id=$this->request->param('seek_user_id');
            $usj_id=$this->request->param('usj_id');
            $job_info=Db::name('user_seek_job')->where(array('id'=>$usj_id))->field('job_name')->find();
            $c_info=Db::name('company')->where(array('user_id'=>$user_id))->field('company_name')->find();
            $add_time=time();
            $content=$c_info['company_name'].'正在招聘'.$job_info['job_name'].'岗位,充值金币查看吧';
            $data['user_id']=$user_id;
            $data['seek_user_id']=$seek_user_id;
            $data['add_time']=$add_time;
            $data['content']=$content;
            $res=Db::name('sh_post_message')->insert($data);
            if($res){
                return json(array('code'=>415,'info'=>'操作成功'));
            }else{
                return json(array('code'=>416,'info'=>'操作失败'));
            }
        }
     }
     //招聘商户查看一条自己发布的招聘需求
     public function cat_one_info(){

          if($this->request->isPost()){
              $id=$this->request->param('id');
              $info=Db::name('company')->where(array('id'=>$id))->find();
              if($info){
                  return json(array('code'=>417,'info'=>'操作成功'));
              }else{
                  return json(array('code'=>418,'info'=>'操作失败'));
              }
          }

     }

}