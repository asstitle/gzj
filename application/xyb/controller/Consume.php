<?php
namespace app\xyb\Controller;


use app\common\controller\Base;

class Consume extends Base
{
     //金额明细
     public function info(){
         return $this->fetch();
     }
}