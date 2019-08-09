<?php
namespace app\api\controller;
use app\common\controller\ApiBase;
use think\Controller;
use think\Db;
class MyCar extends ApiBase
{
    //二手车首页
    public function my_index(){
        if($this->request->isPost()){
            $user_id=$this->request->param('user_id');
            $data=Db::name('users')->where(array('user_id'=>$user_id))->field('coins,user_nickname,sh_super_day')->find();
            return json(array('code'=>300,'info'=>'获取成功','data'=>$data));
        }
    }

    //关闭二手车交易
    public function close_shop(){
        if($this->request->isPost()){
            $user_id=$this->request->param('user_id');
            $data=Db::name('car_info')->where(array('user_id'=>$user_id,'status'=>1))->update(array('status'=>0));
            if($data){
                return json(array('code'=>301,'info'=>'关闭成功'));
            }else{
                return json(array('code'=>302,'info'=>'关闭失败'));
            }
        }
    }

    //二手车统计
    public function statistics(){
        if($this->request->isPost()){
            $user_id=$this->request->param('user_id');
            $result=Db::name('car_info')->where(array('user_id'=>$user_id))->field('province,city,car_type,add_time')->order('add_time desc')->select();
            $arr=array();
            if(!empty($result)){
                foreach($result as $v){
                    $v['cat_type_name']=Db::name('cat_type')->where(array('id'=>$v['car_type']))->value('name');
                    $arr[]=$v;
                    unset($v);
                }
                return json(array('code'=>303,'info'=>'获取成功','data'=>$arr));
            }else{
                return json(array('code'=>304,'info'=>'数据为空','data'=>$arr));
            }

        }
    }

}