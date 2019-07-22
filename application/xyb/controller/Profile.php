<?php

namespace app\xyb\Controller;


use app\common\controller\Base;

class Profile extends Base
{
    //公司资料审核
    public function enterprise_info(){
        return $this->fetch();
    }

    //个人资料审核
    public function person_info(){
        return $this->fetch();
    }
}