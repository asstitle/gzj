<?php
namespace app\api\controller;
use app\common\controller\ApiBase;
use think\Db;
class Car extends ApiBase
{

       //二手车列表
       public function car_lists(){
           $p=$this->request->param('p');
           $pageSize=10;
           $user_id=$this->request->param('user_id');
           $result=Db::name('car_info')->order('add_time desc')->where(array('user_id'=>$user_id))->limit(($p-1)*$pageSize,$pageSize)->select();
           return json(array('code'=>800,'info'=>'获取成功','data'=>$result));
       }

       //发布二手车
       public function publish_car(){
           if($this->request->isPost()){
               $user_id=$this->request->param('user_id');
               $add_time=time();
               $contact_user=$this->request->param('contact_user');
               $contact_tel=$this->request->param('contact_tel');
               $car_brand=$this->request->param('car_brand');
               $car_type=$this->request->param('car_type');
               $car_age_limit=$this->request->param('car_age_limit');
               $car_kilometer=$this->request->param('car_kilometer');
               $car_handle_type=$this->request->param('car_handle_type');
               $car_color=$this->request->param('car_color');
               $car_price=$this->request->param('car_price');
               $car_pic=$this->request->param('car_pic');
               $status=1;
               $data['user_id']=$user_id;
               $data['add_time']=$add_time;
               $data['contact_user']=$contact_user;
               $data['contact_tel']=$contact_tel;
               $data['car_brand']=$car_brand;
               $data['car_type']=$car_type;
               $data['car_age_limit']=$car_age_limit;
               $data['car_kilometer']=$car_kilometer;
               $data['car_handle_type']=$car_handle_type;
               $data['car_color']=$car_color;
               $data['car_price']=$car_price;
               $data['car_pic']=$car_pic;
               $data['status']=$status;
               $result=Db::name('car_info')->insert($data);
               if($result){
                   return json(array('code'=>801,'info'=>'添加成功'));
               }else{
                   return json(array('code'=>802,'info'=>'添加失败'));
               }
           }
       }

       //二手车筛选
       public function car_screen(){
          if($this->request->isPost()){
              $user_id=$this->request->param('user_id');
              //查询该用户是不是超级会员
              $user_info=Db::name('users')->where(array('id'=>$user_id))->field('sh_super_member')->find();
              if($user_info['sh_super_member']==0){
                  return json(array('code'=>803,'info'=>'筛选权限针对会员'));
              }
              $area=$this->request->param('area') ? $this->request->param('area') : '';
              $add_time=$this->request->param('add_time') ? $this->request->param('add_time') : '';
              $start=strtotime($add_time);
              $end=strtotime(date('Y-m-d 23:59:59',strtotime($add_time)));
              $where=array();
              if($area){
                 $where['province']=$area;
              }

              if($add_time){
                  $where['add_time']=array('between',[$start,$end]);
              }
              $data=Db::name('car_info')->where($where)->select();
              return json(array('code'=>804,'info'=>'获取成功','data'=>$data));
          }
       }
       //二手车信息
       public function used_car_info(){
         if($this->request->isPost()){
             $user_id=$this->request->param('user_id');
             //商户信息
             $data=Db::name('company')->where(array('user_id'=>$user_id,'select_type'=>3))->field('province,city,open_time,photos,company_name,contact_person,contact_tel')->find();
             //商户所填二手车信息
             $info=Db::name('car_info')->where(array('user_id'=>$user_id))->order('add_time desc')->field('id,car_name,car_type,car_age_limit,car_kilometer,car_pic')->select();
             $arr=array();
             foreach($info as $i){
                 $i['car_type_name']=Db::name('car_type')->where(array('id'=>$i['car_type']))->value('name');
                 $i['car_age_limit_name']=Db::name('car_age_limit')->where(array('id'=>$i['car_age_limit']))->value('name');
                 $i['car_kilometer_name']=Db::name('car_kilometer_set')->where(array('id'=>$i['car_kilometer']))->value('name');
                 $arr[]=$i;
             }
             return json(array('code'=>805,'info'=>'获取数据成功','data'=>$data,'arr'=>$arr));
         }
       }
       //查看二手车车辆信息
       public function show_car_info(){
           if($this->request->isPost()){
               $id=$this->request->param('id');
               $info=Db::name('car_info')->where(array('id'=>$id))->field('car_brand,car_type,car_age_limit,car_kilometer,car_handle_type,car_color,car_price,car_pic')->find();
               $arr=array();
               $arr['cat_type_name']=Db::name('car')->where(array('id'=>$info['car_type']))->value('name');
               $arr['car_age_limit_name']=Db::name('car')->where(array('id'=>$info['car_age_limit']))->value('name');
               $arr['car_kilometer_name']=Db::name('car')->where(array('id'=>$info['car_kilometer']))->value('name');
               $arr['car_handle_type_name']=Db::name('car')->where(array('id'=>$info['car_handle_type']))->value('name');
               $arr['car_price_name']=Db::name('car')->where(array('id'=>$info['car_price']))->value('name');
               $arr['car_pic']=$info['pic'];
               return json(array('code'=>806,'info'=>'获取成功','data'=>$arr));
           }
       }
       //二手车搜索
       public function car_search(){
           if($this->request->isPost()){
               $user_id=$this->request->param('user_id');
               $search_content=$this->request->param('search_content');
               $result=Db::name('users')->where(array('id'=>$user_id))->field('sh_super_member')->find();
               if($result['sh_super_member']==0){
                   return json(array('code'=>807,'info'=>'超级会员才有搜索功能'));
               }

               if($search_content){
                   $where['car_name']=array('like',"$search_content%");
               }else{
                   $where=array();
               }

               $data=Db::name('car_info')->where($where)->where(array('status'=>1))->order('add_time desc')->select();
               return json(array('code'=>808,'info'=>'获取成功','data'=>$data));
           }
       }
}