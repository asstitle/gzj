<?php


namespace app\api\controller;
use think\Controller;
use think\Db;
class Cron extends Controller
{
    //查询商铺发布的信息是否超过30天，超过30天就关闭发布的信息
    public function cron_do(){
      //查询开启的
      $info=Db::name('shop_info')->where(array('status'=>1))->field('status,id,add_time')->select();
      foreach($info as $i){
          if(time()>$i['add_time']+2592000){
              Db::name('shop_info')->where(array('id'=>$i['id']))->update(array('status'=>0));
          }
      }
    }

}