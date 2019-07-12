<?php
namespace app\xyb\Controller;
use app\common\Controller\Base;

class Set extends Base
{
   //班级信息
   public function class_info(){
       return $this->fetch();
   }
   //学年学期
   public function terms(){
       return $this->fetch();
   }
   //作息时间
   public function time_set(){
       return $this->fetch();
   }
   //课程信息
    public function course_info(){
       return $this->fetch();
    }
    //任教信息
    public function teach_info(){
        return $this->fetch();
    }
}