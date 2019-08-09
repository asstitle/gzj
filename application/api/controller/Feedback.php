<?php
namespace app\api\controller;
use app\common\controller\ApiBase;
use think\Controller;
use think\Db;
class Feedback extends ApiBase
{

    /**
     * 意见反馈提交
     */
    public function post_info(){
      if($this->request->isPost()){
          $data['user_id']=$this->request->param('user_id');
          $data['content']=$this->request->param('content');
          $data['add_time']=$this->request->param('add_time');
          $result=Db::name('user_feedback')->insert($data);
          if($result){
              return json(array('status'=>200,'info'=>'提交成功'));
          }else{
              return json(array('status'=>201,'info'=>'提交失败'));
          }
      }
    }
}