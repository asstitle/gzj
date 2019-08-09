<?php


namespace app\api\controller;


use think\Controller;

class Test extends Controller
{
    public function index(){
        return $this->fetch();
    }

    public function pt(){
       print_r($this->request->param('tel'));
    }
}