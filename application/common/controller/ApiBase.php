<?php
namespace app\common\Controller;
use think\Controller;
use think\Db;
class ApiBase extends Controller
{
    //验证请求接口是否合法
    public function _initialize(){
        $api_val=api_val;
        $post_api_val=$this->request->param('api_val');
        if($api_val!=$post_api_val){
            json(array('status'=>100,'info'=>'非法请求'))->send();
            exit;
        }
    }
}