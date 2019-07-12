<?php
namespace app\xyb\Controller;


use app\common\Controller\Base;

class Grade extends Base
{
    //原始课表
    public function origin_course(){
        return $this->fetch();
    }
    //实时课表
    public function real_course(){
        return $this->fetch();
    }
}