<?php
namespace app\api\controller;
use app\common\controller\ApiBase;
use think\Db;
class Shop extends ApiBase
{

    public function index(){

    }

    public function publish_shop(){
      if($this->request->isPost()){
          $user_id=$this->request->param('user_id');
          $coins=$this->request->param('coins');
          $info=Db::name('users')->where(array('id'=>$user_id))->field('coins')->find();
          $public_status=Db::name('company')->where(array('user_id'=>$user_id,'select_type'=>2))->find();
          if($public_status['status']==0){
              return json(array('code'=>701,'info'=>'资料还未审核通过,请等待'));
          }
          $publish_record=Db::name('company_publish_record')->where(array('company_name'=>$public_status['company_name'],'work_address'=>$this->request->param('province')))->find();
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
          $result=Db::name('shop_info')->insert($data);
          if($result){
              if(empty($publish_record)){
                  Db::name('users')->where(array('id'=>$user_id))->setDec('coins',$coins);
                  $p_data['company_name'] =$this->request->param('company_name');
                  $p_data['work_address'] =$this->request->param('work_address');
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


    public function shop_publish_close(){
        if($this->request->isPost()){
            $id=$this->request->param('id');
            $result=Db::name('shop_info')->where(array('id'=>$id))->update(array('status'=>0));
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
                return json(array('code'=>709,'info'=>'获取成功','result'=>$result));
            }else{
                return json(array('code'=>710,'info'=>'获取失败','result'=>[]));
            }
        }
    }

}