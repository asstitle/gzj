<?php

namespace app\api\controller;
use app\common\controller\ApiBase;
use think\Controller;
use think\Db;
class Recruit extends ApiBase
{
      //招聘雇主首页信息展示
      public function index(){
          if($this->request->isPost()){
            $province=$this->request->param('province');
            $city=$this->request->param('city');
            $user_id=$this->request->param('user_id');
            $user_info=Db::name('users')->where(array('id'=>$user_id))->field('sh_super_member')->find();
            if($user_info['sh_super_member']==1){
                $super_user=1;
            }else{
                $super_user=0;
            }
            $res=Db::name('user_seek_job')->where(array('status'=>1,'province'=>$province,'city'=>$city))->field('user_name,user_id,job_name,sex,id')->select();
            $arr=array();
            foreach($res as $v){
                //用户是否被拉黑过
                $v_info=Db::name('sh_pull_black')->where(array('user_seek_id'=>$v['user_id']))->count();
                 if($v_info==0){
                     $v['is_black']=0;
                 }else{
                     $v['is_black']=1;
                 }
                 //用户是不是超级会员
                $vs_info=Db::name('users')->where(array('id'=>$v['user_id']))->field('user_super_member')->find();
                if($vs_info['user_super_member']==0){
                    $v['is_user_super']=0;
                }else{
                    $v['is_user_super']=1;
                }
                $arr[]=$v;
                unset($v);
            }
            if($res){
                return json(array('code'=>419,'info'=>'获取成功','data'=>$arr,'super_user'=>$super_user));
            }else{
                return json(array('code'=>420,'info'=>'数据为空','data'=>[],'super_user'=>$super_user));

            }
          }
      }
      //招聘雇主筛选
      public function boss_sx(){
       if($this->request->isPost()){
           $user_id=$this->request->param('user_id');
           $user_info=Db::name('users')->where(array('id'=>$user_id))->field('sh_super_member')->find();
           if($user_info['sh_super_member']==1){
               return json(array('code'=>421,'info'=>'超级会员','super_user'=>1));
           }else{
               return json(array('code'=>422,'info'=>'非超级会员','super_user'=>0));
           }
       }
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
                 $jl_info=Db::name('user_seek_job')->where(array('id'=>$usj_id))->find();
                 return json(array('code'=>200,'info'=>'该简历查看过','jl_info'=>$jl_info));
             }else{
                 $user_info=Db::name('users')->where(array('id'=>$user_id))->field('coins')->find();
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
                     return json(array('code'=>402,'info'=>'操作成功','data'=>$jl_info));
                 }
             }

         }
     }
     //商家是否查看过该简历
     public function cat_look_recruit(){
          if($this->request->isPost()){
              $usj_id=$this->request->param('usj_id');
              $user_id=$this->request->param('user_id');//商家id
              //先查询该商户是否查看过该简历
              $is_record=Db::name('look_recruit_record')->where(array('usj_id'=>$usj_id,'user_id'=>$user_id))->find();
              if(!empty($is_record)){
                  //查看过
                  $jl_info=Db::name('user_seek_job')->where(array('id'=>$usj_id))->find();
                  return json(array('code'=>200,'info'=>'该简历查看过','jl_info'=>$jl_info));
              }else{
                  return json(array('code'=>201,'info'=>'该简历查未查看过','jl_info'=>[]));
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
                     $us=Db::name('users')->where(array('id'=>$v['user_id']))->field('user_super_member')->find();
                     if($us['user_super_member']==1){
                         $v['is_super']=1;
                     }else{
                         $v['is_super']=0;
                     }
                     $v['avater']=Db::name('users')->where(array('id'=>$v['user_id']))->value('avater');

                     $arr[]=$v;
                     unset($v);
                 }
             }
             if(empty($arr)){
                 return json(array('code'=>201,'info'=>'暂无数据','data'=>$arr,'is_super_member'=>$is_super_member));
             }else{
                 return json(array('code'=>200,'info'=>'请求成功','data'=>$arr,'is_super_member'=>$is_super_member));
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
             //查询该求职者是否被该用户拉黑过
             $info=Db::name('sh_pull_black')->where(array('user_id'=>$user_id,'user_seek_id'=>$seek_user_id))->find();
             if(empty($info)){
                 $data['user_id']=$user_id;
                 $data['user_seek_id']=$seek_user_id;
                 $data['usj_id']=$usj_id;
                 $data['add_time']=time();
                 $res=Db::name('sh_pull_black')->insert($data);
                 if($res){
                     return json(array('code'=>404,'info'=>'拉黑成功'));
                 }else{
                     return json(array('code'=>405,'info'=>'拉黑失败'));
                 }
             }else{
                 return json(array('code'=>406,'info'=>'该用户已经被拉黑过'));
             }

         }
     }
     //获取拉黑的金币
     public function pull_user_coins(){
          if($this->request->isPost()){
              $res=Db::name('pull_black_coins')->find();
              return json(array('code'=>200,'info'=>'获取成功','data'=>$res));
          }
     }
     //商户向某个求职者发送消息
     public function sh_to_message_user(){
        if($this->request->isPost()){
            date_default_timezone_set("Asia/Shanghai");
            $start=mktime(0,0,0,date('m'),date('d'),date('Y'));
            $end=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
            $user_id=$this->request->param('user_id');//商户ID
            $type=$this->request->param('type');//1 商户 2 普通用户
            $info_arr=Db::name('users')->where(array('id'=>$user_id))->field('sh_super_member')->find();
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
              $lat =$this->request->param('lat');
              $lng =$this->request->param('lng');
              $province =$this->request->param('province');
              $city =$this->request->param('city');
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
              $file_count=input('post.work_pic/a');//实际上传图片的数量
              $file_counts=count($file_count);
              $recruit=Db::name('recruit_pic')->find();
              if($file_counts<$recruit['num']){
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
              $data['work_pic']=json_encode($file_count);// '工作图片',
              $data['contact_user'] =$this->request->param('contact_user');//'联系人',
              $data['tel']=$this->request->param('tel'); //'联系电话',
              $data['status']=1;// '1发布中，0已关闭',
              $data['add_time']=time();// '发布时间',
              $data['user_id']=$this->request->param('user_id');// '发布人',
              $data['lat']=$lat;// 纬度,
              $data['lng']=$lng;// 经度,
              $data['province']=$province;//省份,
              $data['city']=$city;// 城市,
              $res=Db::name('recruit_company')->insert($data);
              if($res){
                  if(empty($publish_record)){
                     Db::name('users')->where(array('id'=>$user_id))->setDec('coins',$coins);
                     $p_data['company_name'] =$this->request->param('company_name');
                     $p_data['work_address'] =$this->request->param('work_address');
                     $p_data['user_id'] =$user_id;
                     $p_data['select_type'] =1;
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
             $lat =$this->request->param('lat');
             $lng =$this->request->param('lng');
             $province =$this->request->param('province');
             $city =$this->request->param('city');
             $info=Db::name('users')->where(array('id'=>$user_id))->field('coins')->find();
             $publish_record=Db::name('company_publish_record')->where(array('company_name'=>$this->request->param('company_name'),'work_address'=>$this->request->param('work_address')))->find();
             if(empty($publish_record)){
                 if($coins>$info['coins']){
                     return json(array('code'=>410,'info'=>'金币余额不足'));
                 }
             }
             $file_count=input('post.work_pic/a');//实际上传图片的数量
             $file_counts=count($file_count);
             $recruit=Db::name('recruit_pic')->find();
             if($file_counts<$recruit['num']){
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
             $data['work_pic']=json_encode($file_count);// '工作图片',
             $data['contact_user'] =$this->request->param('contact_user');//'联系人',
             $data['tel']=$this->request->param('tel'); //'联系电话',
             $data['status']=1;// '1发布中，0已关闭',
             $data['user_id']=$this->request->param('user_id');// '发布人',
             $data['lat']=$lat;// 纬度,
             $data['lng']=$lng;// 经度,
             $data['province']=$province;//省份,
             $data['city']=$city;// 城市,
             $res=Db::name('recruit_company')->where(array('id'=>$id))->update($data);
             if($res){
                 if(empty($publish_record)){
                     Db::name('users')->where(array('id'=>$user_id))->setDec('coins',$coins);
                     $p_data['company_name'] =$this->request->param('company_name');
                     $p_data['work_address'] =$this->request->param('work_address');
                     $p_data['user_id'] =$user_id;
                     $p_data['select_type'] =1;
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
         $res=Db::name('recruit_company')->where(array('id'=>$id))->update(array('status'=>0,'close_time'=>time()));
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
            //会员商家每天30条消息上限,非会员每天15条消息上限
            $user_info=Db::name('users')->where(array('id'=>$user_id))->field('sh_super_member')->find();
            $start=mktime(0,0,0,date('m'),date('d'),date('Y'));
            $end=mktime(0,0,0,date('m'),date('d')+1,date('Y'))-1;
            $count=Db::name('sh_post_message')->where(array('user_id'=>$user_id))->where('add_time','between',[$start,$end])->count();
            if($user_info['sh_super_member']==1){
                //会员
                if($count>=30){
                  return json(array('code'=>419,'info'=>'今天发送消息已达30条,请明日再试'));
                }
            }else{
                //非会员
                if($count>=15){
                  return json(array('code'=>420,'info'=>'今天发送消息已达15条,请明日再试'));
                }
            }
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
              $info=Db::name('recruit_company')->where(array('id'=>$id))->find();
              if(!empty($info)){
                  return json(array('code'=>417,'info'=>'操作成功','data'=>$info));
              }else{
                  return json(array('code'=>418,'info'=>'数据为空','data'=>[]));
              }
          }

     }

     //获取查看消费金币
     public function get_cat_coins(){
          if($this->request->isPost()){
              $res=Db::name('set_coins')->find();
              return json(array('code'=>200,'info'=>'获取成功','coins'=>$res['coins']));
          }
     }
     //商家再招职位和关闭职位
     public function sh_positions(){
          if($this->request->isPost()){
              $user_id=$this->request->param('user_id');
              $info=Db::name('recruit_company')->where(array('user_id'=>$user_id))->field('work_pic,seek_job,demand_num,work_time,work_address,status,id')->order('add_time desc')->select();
              $arr=array();
              if(!empty($info)){
                  foreach($info as $v){
                      $v['img']=json_decode($v['work_pic'],true);
                      $arr[]=$v;
                      unset($v);
                  }
                  return json(array('code'=>419,'info'=>'获取成功','data'=>$arr));
              }else{
                  return json(array('code'=>420,'info'=>'数据为空','data'=>[]));
              }
          }
     }
     //获取设置天数
     public function get_set_day(){
          if($this->request->isPost()){
             $res= Db::name('set_open_day')->find();
             return json(array('code'=>423,'info'=>'获取成功','data'=>$res));
          }
     }
     //关闭超过30天开启重新续费
     public function new_open(){
          if($this->request->isPost()){
              $id=$this->request->param('id');
              $day=$this->request->param('day');
              $info=Db::name('recruit_company')->where(array('id'=>$id))->field('close_time')->find();
              if($info['close_time']+$day*24*3600<time()){
                 return json(array('code'=>421,'info'=>'关闭时间已超过'.$day.'天'));
              }else{
                  return json(array('code'=>422,'info'=>'关闭时间未超过'.$day.'天'));
              }
          }
     }
     //超过30天开启，消费金币
     public function new_open_do(){
        if($this->request->isPost()){
            $user_id=$this->request->param('user_id');
            $coins=$this->request->param('coins');
            $id=$this->request->param('id');
            $info=Db::name('users')->where(array('id'=>$user_id))->field('coins')->find();
            if($info['coins']<$coins){
                return json(array('code'=>425,'info'=>'金币余额不足'));
            }
            //更新招聘需求状态
            $result=Db::name('recruit_company')->where(array('id'=>$id))->update(array('status'=>1));
            if($result){
                //扣除用户金币
                Db::name('users')->where(array('id'=>$user_id))->setDec('coins',$coins);
                //写入消费明细表
                $detail_info['user_id']=$user_id;
                $detail_info['add_time']=time();
                $detail_info['content']='超过时间开启招聘需求,消费金币';
                $detail_info['select_type']=1;
                $detail_info['is_merchant']=1;
                $detail_info['coins']=-$coins;
                Db::name('user_consume_fee_detail')->insert($detail_info);
                return json(array('code'=>426,'info'=>'开启成功'));
            }else{
                return json(array('code'=>427,'info'=>'开启失败'));
            }
        }
     }
     //未超过30天直接开启
    public function new_open_do_again(){
         if($this->request->isPost()){
             $id=$this->request->param('id');
             $result=Db::name('recruit_company')->where(array('id'=>$id))->update(array('status'=>1));
             if($result){
                 return json(array('code'=>428,'info'=>'开启成功'));
             }else{
                 return json(array('code'=>429,'info'=>'开启失败'));
             }

         }
    }
}