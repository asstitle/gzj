<?php
namespace app\xyb\Controller;

use app\common\Controller\Base;

class Schedule extends Base
{
   //我的课表
    public function my_course_info(){
        return $this->fetch();
    }
   //调课情况
    public function tk_course_info(){
        return $this->fetch();
    }
}