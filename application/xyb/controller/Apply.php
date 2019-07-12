<?php

namespace app\xyb\Controller;


use app\common\Controller\Base;

class Apply extends Base
{
    //代课申请
    public function dk_apply(){
       return $this->fetch();
    }
    //调课申请
    public function tk_apply(){
        return $this->fetch();
    }

}