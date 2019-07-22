<?php

namespace app\xyb\Controller;

use app\common\controller\Base;

class Suggest extends Base
{
    //意见反馈
    public function index(){
        return $this->fetch();
    }
}