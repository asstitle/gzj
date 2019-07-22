<?php

namespace app\xyb\Controller;


use app\common\controller\Base;

class Car extends Base
{
    //发布中
    public function release(){
        return $this->fetch();
    }
    //已关闭
    public function closed(){
        return $this->fetch();
    }
}