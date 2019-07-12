<?php

namespace app\xyb\Controller;
use app\common\Controller\Base;

class Index extends Base
{
    //控制台
    public function index(){
        return $this->fetch();
    }
}