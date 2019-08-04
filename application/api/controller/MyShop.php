<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
class MyShop extends Controller
{
    //商铺雇主首页
   public function my_index(){
     if($this->request->isPost()){
         $user_id=$this->request->param('user_id');
         $data=Db::name('users')->where(array('user_id'=>$user_id))->field('coins,user_nickname,sh_super_day')->find();
         return json(array('code'=>200,'info'=>'获取成功','data'=>$data));
     }
   }
   //商铺雇主明细
    public function shop_detail(){
       if($this->request->isPost()){
           $user_id=$this->request->param('user_id');
           $data=Db::name('user_consume_fee_detail')->where(array('user_id'=>$user_id,'select_type'=>3))->order('add_time desc')->select();
           return json(array('code'=>201,'info'=>'获取成功','data'=>$data));
       }
    }
    //商铺统计
    public function statistics(){
       if($this->request->isPost()){
           $user_id=$this->request->param('user_id');
           $result=Db::name('shop_info')->where(array('user_id'=>$user_id))->field('province,city,cat_id,add_time')->order('add_time desc')->select();
           $arr=array();
           if(!empty($result)){
               foreach($result as $v){
                   $v['cat_name']=Db::name('shop_cat')->where(array('id'=>$v['cat_id']))->value('name');
                   $arr[]=$v;
                   unset($v);
               }
               return json(array('code'=>202,'info'=>'获取成功','data'=>$arr));
           }else{
               return json(array('code'=>203,'info'=>'数据为空','data'=>$arr));
           }

       }
    }
    //关闭店铺交易
    public function close_shop(){
       if($this->request->isPost()){
           $user_id=$this->request->param('user_id');
           $data=Db::name('shop_info')->where(array('user_id'=>$user_id,'status'=>1))->update(array('status'=>0));
           if($data){
               return json(array('code'=>204,'info'=>'关闭成功'));
           }else{
               return json(array('code'=>205,'info'=>'关闭失败'));
           }
       }
    }
}