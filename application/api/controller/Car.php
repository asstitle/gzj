<?php
namespace app\api\controller;
use app\common\controller\ApiBase;
use think\Db;
class Car extends ApiBase
{
       public function car_lists(){
           $p=$this->request->param('p');
           $pageSize=10;
           $user_id=$this->request->param('user_id');
           $result=Db::name('car_info')->order('add_time desc')->where(array('user_id'=>$user_id))->limit(($p-1)*$pageSize,$pageSize)->select();
           return json(array('code'=>800,'info'=>'获取成功','data'=>$result));
       }


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
}