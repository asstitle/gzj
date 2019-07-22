<?php


namespace app\xyb\Controller;


use app\common\controller\Base;
//招聘
class Recruit extends Base
{   //招聘中
    public function release(){
        return $this->fetch();
    }
    //已关闭
    public function closed(){
        return $this->fetch();
    }
}