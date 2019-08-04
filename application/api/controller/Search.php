<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
class Search extends Controller
{

    //招聘商户搜索求职者信息
    public function sh_search_seek_info(){
        if($this->request->isPost()){
            $content=$this->request->param('content');
            $content=trim($content);
            $info=Db::name('user_seek_job')->where('job_name','like',"$content%")->select();
            if(!empty($info)){
                return json(array('code'=>500,'info'=>'搜索成功','data'=>$info));
            }else{
                return json(array('code'=>501,'info'=>'数据为空','data'=>$info));
            }
        }
    }
    //商户筛选求职者信息
    public function sh_screen_user_info(){
      if($this->request->isPost()){
          $area_id=$this->request->param('area_id');//区域id
          $gw_id=$this->request->param('gw_id');//区域id
          $add_time=$this->request->param('add_time');//区域id
          if($area_id){
              $where['area_id']=$area_id;
          }
          if($gw_id){
              $where['gw_id']=$gw_id;
          }
          if($add_time){
              $where['add_time']=array('between',[]);
          }

      }
    }

    //招聘商户搜索求权限判断
    public function search_auth_judge(){
        if($this->request->isPost()){
            $user_id=$this->request->param('user_id');
            $res=Db::name('users')->where(array('id'=>$user_id))->field('sh_super_member')->find();
            if($res['sh_super_member']==1){
                return json(array('code'=>502,'info'=>'有权限搜索'));
            }else{
                return json(array('code'=>503,'info'=>'无权限搜索'));
            }
        }
    }
}