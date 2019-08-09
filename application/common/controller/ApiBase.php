<?php
namespace app\common\controller;
use think\Controller;
use think\Db;
class ApiBase extends Controller
{
    //验证请求接口是否合法
    public function _initialize(){
        $api_val=api_val;
        $data=input('post.');
        $sign=$data['sign'];
        unset($data['sign']);
        if(isset($data['work_pic'])){
            unset($data['work_pic']);
        }
        $signature=$this->signature($data,$api_val);
        if($sign!==$signature){
            json(array('status'=>100,'info'=>'非法请求,验证签名失败'))->send();
            exit;
        }
    }

    /**
     * 获取签名
     * @param $data 提交的数据
     * @param $key  安全密钥
     * @return bool
     */
    function signature($data, $key) {
        ksort($data);
        $str = '';
        foreach ($data as $k => $v) {
            if ($v === '') continue;
            if ($str !== '') $str .= '&';
            if ('UTF-8' === mb_detect_encoding($v)) {
                $v = rawurlencode($v);
            }
            $str .= "{$k}={$v}";
        }
        $str .= '&key=' . $key;
        $signature = md5($str);
        $signature = strtoupper($signature);
        return $signature;
    }
}