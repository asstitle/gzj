<?php
namespace app\api\controller;
use app\common\controller\ApiBase;
use think\Db;
class Wxpay extends ApiBase{

    public function pay()
    {

        if($this->request->isPost()) {
            //用code获取openid
            $code = $this->request->param('code');
            $WX_APPID = 'wxfd3f63c9f418f478';//小程序appid
            $WX_SECRET = '45149e892b99aab9b6d1fe7adfc46604';//小程序AppSecret
            $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $WX_APPID . "&secret=" . $WX_SECRET . "&js_code=" . $code . "&grant_type=authorization_code";
            $infos = json_decode(file_get_contents($url));
            $openid = $infos->openid;


            //$fee = I("post.total_fee");
            $fee = 0.01;//举例支付0.01
            $appid = 'wxfd3f63c9f418f478';//appid.如果是公众号 就是公众号的appid
            $body = '测试';
            $mch_id = '1517166241';  //商户号
            $nonce_str = $this->nonce_str();//随机字符串
            $notify_url = 'http://gzj.majiangyun.com/api/Wxpay/notify'; //回调的url【自己填写】
            $openid = $openid;
            $out_trade_no = $this->order_number();//商户订单号
            $spbill_create_ip = '121.40.148.132';//服务器的ip【自己填写】;
            $total_fee = $fee;// 微信支付单位是分，所以这里需要*100
            $trade_type = 'JSAPI';//交易类型 默认
            //这里是按照顺序的 因为下面的签名是按照顺序 排序错误 肯定出错
            $post['appid'] = $appid;
            $post['body'] = $body;
            $post['mch_id'] = $mch_id;
            $post['nonce_str'] = $nonce_str;//随机字符串
            $post['notify_url'] = $notify_url;
            $post['openid'] = $openid;
            $post['out_trade_no'] = $out_trade_no;
            $post['spbill_create_ip'] = $spbill_create_ip;//终端的ip
            $post['total_fee'] = $total_fee;//总金额
            $post['trade_type'] = $trade_type;
            $sign = $this->sign($post);//签名
            $post_xml = '<xml>
           <appid>' . $appid . '</appid>
           <body>' . $body . '</body>
           <mch_id>' . $mch_id . '</mch_id>
           <nonce_str>' . $nonce_str . '</nonce_str>
           <notify_url>' . $notify_url . '</notify_url>
           <openid>' . $openid . '</openid>
           <out_trade_no>' . $out_trade_no . '</out_trade_no>
           <spbill_create_ip>' . $spbill_create_ip . '</spbill_create_ip>
           <total_fee>' . $total_fee . '</total_fee>
           <trade_type>' . $trade_type . '</trade_type>
           <sign>' . $sign . '</sign>
        </xml> ';

            //print_r($post_xml);die;
            //统一接口prepay_id
            $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
            $xml = $this->http_request($url, $post_xml);

            $array = $this->xml($xml);//全要大写

            //print_r($array);
            if ($array['RETURN_CODE'] == 'SUCCESS' && $array['RESULT_CODE'] == 'SUCCESS') {
                $time = time();
                $tmp = '';//临时数组用于签名
                $tmp['appId'] = $appid;
                $tmp['nonceStr'] = $nonce_str;
                $tmp['package'] = 'prepay_id=' . $array['PREPAY_ID'];
                $tmp['signType'] = 'MD5';
                $tmp['timeStamp'] = "$time";

                $data['state'] = 200;
                $data['timeStamp'] = "$time";//时间戳
                $data['nonceStr'] = $nonce_str;//随机字符串
                $data['signType'] = 'MD5';//签名算法，暂支持 MD5
                $data['package'] = 'prepay_id=' . $array['PREPAY_ID'];//统一下单接口返回的 prepay_id 参数值，提交格式如：prepay_id=*
                $data['paySign'] = $this->sign($tmp);//签名,具体签名方案参见微信公众号支付帮助文档;
                $data['out_trade_no'] = $out_trade_no;
                //写入数据库
                $order_data['user_id']=1;
                $order_data['order_number']=$out_trade_no;
                $order_data['money']=$total_fee;
                $order_data['add_time']=time();
                $res=Db::name('order')->insert($order_data);
                if($res){
                    return json(array('code' => 200, 'info' => '操作成功', 'data' => $data));
                }else{
                    return json(array('code' => 203, 'info' => '写入支付信息到订单表失败', 'data' => $data));
                }

            } else {
                $data['state'] = 0;
                $data['text'] = "错误";
                $data['RETURN_CODE'] = $array['RETURN_CODE'];
                $data['RETURN_MSG'] = $array['RETURN_MSG'];
                return json(array('code' => 201, 'info' => '有错误', 'data' => $data));
            }
        }

    }

    //随机32位字符串
    private function nonce_str(){
        $result = '';
        $str = 'QWERTYUIOPASDFGHJKLZXVBNMqwertyuioplkjhgfdsamnbvcxz';
        for ($i=0;$i<32;$i++){
            $result .= $str[rand(0,48)];
        }
        return $result;
    }

    //生成订单号
    private function order_number($openid){
        return md5($openid.time().rand(10,99));//32位
    }

    //签名 $data要先排好顺序
    private function sign($data){
        $stringA = '';
        foreach ($data as $key=>$value){
            if(!$value) continue;
            if($stringA) $stringA .= '&'.$key."=".$value;
            else $stringA = $key."=".$value;
        }
        $wx_key = '';//申请支付后有给予一个商户账号和密码，登陆后自己设置的key
        $stringSignTemp = $stringA.'&key='.$wx_key;
        return strtoupper(md5($stringSignTemp));
    }

    //curl请求
    public function http_request($url,$data = null,$headers=array())
    {
        $curl = curl_init();
        if( count($headers) >= 1 ){
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        }
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        $output = curl_exec($curl);
        curl_close($curl);
        return $output;
    }
     //获取xml
    private function xml($xml){
        $p = xml_parser_create();
        xml_parse_into_struct($p, $xml, $vals, $index);
        xml_parser_free($p);
        $data = "";
        foreach ($index as $key=>$value) {
            if($key == 'xml' || $key == 'XML') continue;
            $tag = $vals[$value[0]]['tag'];
            $value = $vals[$value[0]]['value'];
            $data[$tag] = $value;
        }
        return $data;
    }


    /**
     * 支付通知
     */
    public function  notify()
    {
        if (!$xml = file_get_contents('php://input')) {
           return json(array('code'=>205,'info'=>"not found data"));
        }
        // 将服务器返回的XML数据转化为数组
        $data = $this->fromXml($xml);
        // 保存微信服务器返回的签名sign
        $dataSign = $data['paySign'];
        // sign不参与签名算法
        unset($data['paySign']);
        // 生成签名
        $sign = $this->sign($data);
        //$wx_total_fee = $data['total_fee'];
        // 判断签名是否正确  判断支付状态
        if (($sign === $dataSign) && ($data['return_code'] == 'SUCCESS') && ($data['result_code'] == 'SUCCESS')) {
            $order_sn = $data['out_trade_no'];
            $order_info = Db::name('order')->where(['order_number' => "$order_sn"])->find();
            $res=Db::name('order')->where(array('id'=>$order_info['id']))->update(array('status'=>1,'done_time'=>time()));
            if($res){
               return json(array('code'=>200,'info'=>'支付成功'));
            }else{
               return json(array('code'=>201,'info'=>'支付失败'));
            }
        }
    }
    //将XML转化成数组
    public function fromXml($xml){
        // 禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }

}