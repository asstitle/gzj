<?php

namespace app\api\controller;
use think\Controller;
use think\Db;
//微信授权登录
class Authorize extends Controller
{
    public function login()
    {
        $get = input('get.');
        //获取session_key
        $params['appid']= 'wxfd3f63c9f418f478';
        $params['secret']= '45149e892b99aab9b6d1fe7adfc46604';
        $params['js_code']= $this->define_str_replace($get['code']);
        $params['grant_type']= 'authorization_code';
        $http_key = $this->httpCurl('https://api.weixin.qq.com/sns/jscode2session', $params, 'GET');
        $session_key = json_decode($http_key,true);
        if(!empty($session_key['session_key'])){
            $appid = $params['appid'];
            $encrypteData = urldecode($get['encrypteData']);
            $iv = $this->define_str_replace($get['iv']);
            $errCode =$this-> decryptData($appid, $session_key['session_key'], $encrypteData, $iv);
            //file_put_contents('/p.txt',print_r($errCode,true));
            //把appid写入到数据库中
            $data['openid'] = $errCode['openId'];
            $data['user_nickname'] = $errCode['nickName'];
            $data['sex'] = $errCode['gender'];
            $data['avater'] = $errCode['avatarUrl'];
            if (false == Db::name('users')->where(['openid' => $data['openid']])->find()) {
                Db::name('users')->insert($data);
            } else {
                Db::name('users')->where(['openid' => $data['openid']])->update($data);

            }
            $value = Db::name('users')->where(['openid' => $data['openid']])->field('id,sex,avater,user_nickname,openid')->select();
            $array = array_merge_recursive($errCode, $value);
            session('user_id',$value[0]['id']);
            return json(array('code' => 200, 'info' => '获取成功', 'data' => $array));

        }else{
            return json(array('code' => 201, 'info' => '获取session_key失败！'));
        }
    }

    /**
     * 发送HTTP请求方法
     * @param string $url 请求URL
     * @param array $params 请求参数
     * @param string $method 请求方法GET/POST
     * @return array  $data   响应数据
     */
    public function httpCurl($url, $params, $method = 'POST', $header = array(), $multi = false)
    {
        date_default_timezone_set('PRC');
        $opts = array(
            CURLOPT_TIMEOUT => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER => $header,
            CURLOPT_COOKIESESSION => true,
            CURLOPT_FOLLOWLOCATION => 1,
            CURLOPT_COOKIE => session_name() . '=' . session_id(),
        );
        /* 根据请求类型设置特定参数 */
        switch (strtoupper($method)) {
            case 'GET':
                // $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
                // 链接后拼接参数  &  非？
                $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
                break;
            case 'POST':
                //判断是否传输文件
                $params = $multi ? $params : http_build_query($params);
                $opts[CURLOPT_URL] = $url;
                $opts[CURLOPT_POST] = 1;
                $opts[CURLOPT_POSTFIELDS] = $params;
                break;
            default:
                throw new Exception('不支持的请求方式！');
        }
        /* 初始化并执行curl请求 */
        $ch = curl_init();
        curl_setopt_array($ch, $opts);
        $data = curl_exec($ch);
        $error = curl_error($ch);
        curl_close($ch);
        if ($error) throw new Exception('请求发生错误：' . $error);
        return $data;
    }

    /**
     * 微信信息解密
     * @param string $appid 小程序id
     * @param string $sessionKey 小程序密钥
     * @param string $encryptedData 在小程序中获取的encryptedData
     * @param string $iv 在小程序中获取的iv
     * @return array 解密后的数组
     */
    public function decryptData($appid, $sessionKey, $encryptedData, $iv)
    {
        $OK = 0;
        $IllegalAesKey = -41001;
        $IllegalIv = -41002;
        $IllegalBuffer = -41003;
        $DecodeBase64Error = -41004;

        if (strlen($sessionKey) != 24) {
            return $IllegalAesKey;
        }
        $aesKey = base64_decode($sessionKey);

        if (strlen($iv) != 24) {
            return $IllegalIv;
        }
        $aesIV = base64_decode($iv);

        $aesCipher = base64_decode($encryptedData);

        $result = openssl_decrypt($aesCipher, "AES-128-CBC", $aesKey, 1, $aesIV);
        $dataObj = json_decode($result);
        if ($dataObj == NULL) {
            return $IllegalBuffer;
        }
        if ($dataObj->watermark->appid != $appid) {
            return $DecodeBase64Error;
        }
        $data = json_decode($result, true);

        return $data;
    }

    /**
     * 请求过程中因为编码原因+号变成了空格
     * 需要用下面的方法转换回来
     */
    public function define_str_replace($data)
    {
        return str_replace(' ','+',$data);
    }

    /**
     * 用户授权登录第一选择商家还是普通用户
     */
    public function get_first_authorize_select_type(){
       if($this->request->isPost()){
           $user_id=$this->request->param('user_id');
           $type=$this->request->param('type');//1商家 2用户
           $select_type=$this->request->param('select_type');//1 招聘者 2商户租赁 3 二手车
           $info=Db::name('user_type_info')->where(array('type'=>$type,'user_id'=>$user_id,'select_type'=>$select_type))->find();
           if(empty($info)){
               $datas['user_id']=$user_id;
               $datas['type']=$type;
               $datas['select_type']=$select_type;
               Db::name('user_type_info')->insert($datas);
             return json(array('code'=>201,'info'=>'该商家尚未完善信息','is_deal'=>0));
           }else{
               if($info['is_deal']==0){
                   return json(array('code'=>201,'info'=>'该商家未完善信息','is_deal'=>0));
               }else{
                   return json(array('code'=>200,'info'=>'该商家已完善信息','is_deal'=>1));
               }

           }

       }
    }
}

