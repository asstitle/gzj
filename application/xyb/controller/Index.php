<?php

namespace app\xyb\Controller;
use app\common\Controller\Base;
class Index extends Base
{
    public function index(){
        return $this->fetch();
    }
    public function inbox(){
        return $this->fetch();
    }
    public function typography(){
        return $this->fetch();
    }
}