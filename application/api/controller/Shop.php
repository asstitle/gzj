<?php
namespace app\api\controller;
use app\common\controller\ApiBase;
use think\Controller;
use think\Db;
class Shop extends ApiBase
{
    //店铺首页
    public function index(){
     if($this->request->isPost()){
         $province=$this->request->param('province');
         $city=$this->request->param('city');
         $user_id=$this->request->param('user_id');
         $user_info=Db::name('users')->where(array('id'=>$user_id))->field('sh_super_member')->find();
         //判断当前用户是不是超级会员
         if($user_info['sh_super_member']==1){
            $super_member=1;
         }else{
            $super_member=0;
         }
         $result=Db::name('shop_info')->where(array('status'=>1,'province'=>$province,'city'=>$city))->field('province,city,cat_id,shop_mj')->select();
         $arr=array();
         if(!empty($result)){
             foreach($result as $v){
                 $info=Db::name('users')->where(array('id'=>$v['user_id']))->field('user_super_member')->find();
                 //用户是否是超级会员
                 if($info['user_super_member']==1){
                     $v['is_super']=1;
                 }else{
                     $v['is_super']=0;
                 }
                 $v['cat_name']=Db::name('shop_cat')->where(array('id'=>$v['cat_id']))->value('name');
                 $arr[]=$v;
                 unset($v);
             }
             return json(array('code'=>721,'info'=>'获取成功','data'=>$arr,'super_member'=>$super_member));
         }else{
             return json(array('code'=>722,'info'=>'数据为空','data'=>[],'super_member'=>$super_member));
         }
     }
    }
    //发布店铺
    public function publish_shop(){
      if($this->request->isPost()){
          $user_id=$this->request->param('user_id');
          $coins=$this->request->param('coins');
          $info=Db::name('users')->where(array('id'=>$user_id))->field('coins')->find();
          $public_status=Db::name('company')->where(array('user_id'=>$user_id,'select_type'=>2))->find();
          if($public_status['status']==0){
              return json(array('code'=>701,'info'=>'资料还未审核通过,请等待'));
          }
          $publish_record=Db::name('company_publish_record')->where(array('company_name'=>$public_status['company_name'],'work_address'=>$this->request->param('province'),'user_id'=>$user_id,'select_type'=>2))->find();
          if(empty($publish_record)||$publish_record['num']>=5){//同一地址不能超过5次发布，超过5次收费
              if($coins>$info['coins']){
                  return json(array('code'=>702,'info'=>'金币余额不足'));
              }
          }
          $data['province']=$this->request->param('province');
          $data['city']=$this->request->param('city');
          $data['address']=$this->request->param('address');
          $data['cat_id']=$this->request->param('cat_id');
          $data['contact_user']=$this->request->param('contact_user');
          $data['contact_tel']=$this->request->param('contact_tel');
          $data['price']=$this->request->param('price');
          $data['add_time']=time();
          $data['shop_mj']=$this->request->param('shop_mj');
          $data['user_id']=$user_id;
          $data['lat']=$this->request->param('lat');
          $data['lng']=$this->request->param('lng');
          $data['work_pic']=json_encode($this->request->param('work_pic/a'));
          $result=Db::name('shop_info')->insert($data);
          if($result){
              if(empty($publish_record)){
                  Db::name('users')->where(array('id'=>$user_id))->setDec('coins',$coins);
                  $p_data['company_name'] =$public_status['company_name'];
                  $p_data['work_address'] =$this->request->param('address');
                  $p_data['user_id'] =$user_id;
                  $p_data['select_type'] =2;
                  $p_data['num'] =1;
                  Db::name('company_publish_record')->insert($p_data);
              }else{
                  //更新同一地点发布次数
                  Db::name('company_publish_record')->where(array('id'=>$publish_record['id']))->setInc('num',1);
                if($publish_record['num']>=5){
                    Db::name('users')->where(array('id'=>$user_id))->setDec('coins',$coins);
                }
              }
             return json(array('code'=>703,'info'=>'发布成功'));
          }else{
             return json(array('code'=>704,'info'=>'发布失败'));
          }
      }
    }
    //删除店铺
    public function shop_publish_delete(){
        if($this->request->isPost()){
            $id=$this->request->param('id');
            $result=Db::name('shop_info')->where(array('id'=>$id))->delete();
            if($result){
                return json(array('code'=>705,'info'=>'删除成功'));
            }else{
                return json(array('code'=>706,'info'=>'删除失败'));
            }
        }
    }

    //关闭店铺
    public function shop_publish_close(){
        if($this->request->isPost()){
            $id=$this->request->param('id');
            $result=Db::name('shop_info')->where(array('id'=>$id))->update(array('status'=>0,'close_time'=>time()));
            if($result){
                return json(array('code'=>707,'info'=>'关闭成功'));
            }else{
                return json(array('code'=>708,'info'=>'关闭失败'));
            }
        }
    }

    public function shop_publish_info(){
        if($this->request->isPost()){
            $id=$this->request->param('id');
            $result=Db::name('shop_info')->where(array('id'=>$id))->find();
            if($result){
                return json(array('code'=>709,'info'=>'获取成功','data'=>$result));
            }else{
                return json(array('code'=>710,'info'=>'获取失败','data'=>[]));
            }
        }
    }
    //店铺列表
    public function shop_lists(){
      if($this->request->isPost()){
          $user_id=$this->request->param('user_id');
          $res=Db::name('shop_info')->order('add_time desc')->where(array('status'=>1,'user_id'=>$user_id))->select();
          return json(array('code'=>711,'info'=>'获取成功','data'=>$res));
      }
    }
    //搜索商铺
    public function search_shop(){
      if($this->request->isPost()){
          $search_key=$this->request->param('search_key') ? $this->request->param('search_key') : '';
          if($search_key){
              $where['shop_mj']=array('like',"$search_key%");
              $res=Db::name('shop_info')->where($where)->order('add_time desc')->select();
          }else{
              $res=Db::name('shop_info')->order('add_time desc')->select();
          }
          return json(array('code'=>712,'info'=>'获取成功','data'=>$res));
      }
    }
    //商铺筛选
    public function shop_screen(){
       if($this->request->isPost()){
           $area=$this->request->param('area');
           $cat_id=$this->request->param('cat_id');
           $add_time=$this->request->param('add_time');
           $start=strtotime($add_time);
           $end=strtotime(date('Y-m-d 23:59:59',strtotime($add_time)));
           $where=[];
           if($area){
               $where['province']=$area;
           }
           if($cat_id){
               $where['cat_id']=$cat_id;
           }
           if($add_time){
               $where['add_time']=array('between',[$start,$end]);
           }
           $lists=Db::name('shop_info')->where($where)->select();
           return json(array('code'=>713,'info'=>'搜索成功','data'=>$lists));

       }
    }

    //获取商铺类型
    public function get_shop_cat(){
        if($this->request->isPost()){
            $cat_list=Db::name('shop_cat')->select();
            return json(array('code'=>714,'info'=>'获取成功','data'=>$cat_list));
        }
    }

    //已关闭的发布列表
    public function shop_list(){
        if($this->request->isPost()){
            $user_id=$this->request->param('user_id');
            $result=Db::name('shop_info')->where(array('user_id'=>$user_id))->order('add_time desc')->field('work_pic,shop_mj,cat_id,id,address,status,province,city')->select();
            $arr=array();
            foreach($result as $v){
                $v['img']=json_decode($v['work_pic'],true);
                $arr[]=$v;
                unset($v);
            }
            if($arr){
                return json(array('code'=>715,'info'=>'获取成功','data'=>$arr));
            }else{
                return json(array('code'=>716,'info'=>'数据为空','data'=>[]));
            }

        }
    }

    //编辑某个店铺信息
    public function shop_edit_post(){
        if($this->request->isPost()){
            $id=$this->request->param('id');
            $data['province']=$this->request->param('province');
            $data['city']=$this->request->param('city');
            $data['address']=$this->request->param('address');
            $data['cat_id']=$this->request->param('cat_id');
            $data['contact_user']=$this->request->param('contact_user');
            $data['contact_tel']=$this->request->param('contact_tel');
            $data['price']=$this->request->param('price');
            $data['add_time']=time();
            $data['shop_mj']=$this->request->param('shop_mj');
            $data['work_pic']=json_encode($this->request->param('work_pic/a'));
            $data['lat']=$this->request->param('lat');
            $data['lng']=$this->request->param('lng');
            $result=Db::name('shop_info')->where(array('id'=>$id))->update($data);
            if($result){
                return json(array('code'=>719,'info'=>'编辑成功'));
            }else{
                return json(array('code'=>720,'info'=>'编辑失败'));
            }
        }
    }

    //获取设置天数
    public function get_shop_open_day(){
      if($this->request->isPost()){
          $data=Db::name('shop_set_day')->find();
          return json(array('code'=>721,'info'=>'获取成功','data'=>$data));
      }
    }
    //关闭超过X天开启重新续费判断
    public function new_shop_open(){
        $id=$this->request->param('id');
        $day=$this->request->param('day');
        //关闭超过24小时开启就重新收费
        $info=Db::name('shop_info')->where(array('id'=>$id))->field('id,close_time,user_id')->find();
        if($info['close_time']+$day*24*3600<time()){
            return json(array('code'=>722,'info'=>'关闭时间已超过'.$day.'天'));
        }else{
            return json(array('code'=>723,'info'=>'关闭时间未超过'.$day.'天'));
        }
    }


    //未超过X天直接开启
    public function new_open_shop_do_again(){
        if($this->request->isPost()){
            $id=$this->request->param('id');
            $result=Db::name('shop_info')->where(array('id'=>$id))->update(array('status'=>1));
            if($result){
                return json(array('code'=>724,'info'=>'开启成功'));
            }else{
                return json(array('code'=>725,'info'=>'开启失败'));
            }

        }
    }
    //超过X天开启，消费金币
    public function shop_open(){
        if($this->request->isPost()){
            $id=$this->request->param('id');
            $coins=$this->request->param('coins');
            $user_id=$this->request->param('user_id');
                $user_info=Db::name('users')->where(array('id'=>$user_id))->field('coins,id')->find();
                if($coins>$user_info['coins']){
                    return json(array('code'=>716,'info'=>'金币余额不足，请充值'));
                }
                $res=Db::name('shop_info')->where(array('id'=>$id))->update(array('status'=>1));
                $result=Db::name('users')->where(array('id'=>$user_id))->setDec('coins',$coins);
                if($res&&$result){
                    //写入消费记录
                    //写入消费明细表
                    $detail_info['user_id']=$user_id;
                    $detail_info['add_time']=time();
                    $detail_info['content']='超过时间开启商铺租赁,消费金币';
                    $detail_info['select_type']=2;
                    $detail_info['is_merchant']=1;
                    $detail_info['coins']=-$coins;
                    Db::name('user_consume_fee_detail')->insert($detail_info);
                    return json(array('code'=>717,'info'=>'开启成功'));
                }else{
                    return json(array('code'=>718,'info'=>'开启失败'));
                }

        }
    }
}