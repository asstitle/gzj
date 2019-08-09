<?php
namespace app\api\controller;
use app\common\controller\ApiBase;
use think\Controller;
use think\Db;
class Recharge extends ApiBase
{
    //充值列表展示
    public function lists(){
      if($this->request->isPost()){
          $lists=Db::name('coin_money_select')->select();
          if($lists){
              return json(array('code'=>600,'info'=>'获取成功','lists'=>$lists));
          }else{
              return json(array('code'=>601,'info'=>'数据为空','lists'=>$lists));
          }
      }
    }

}