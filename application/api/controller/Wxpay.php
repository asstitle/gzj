<?php
namespace app\api\controller;
use app\common\controller\ApiBase;
use think\Db;
class Wxpay extends ApiBase {
    //充值金币
    public function pay()
    {

        if($this->request->isPost()) {
            //用code获取openid
            $code = $this->request->param('code');
            $user_id = $this->request->param('user_id') ? $this->request->param('user_id') : 1;
            $select_type = $this->request->param('select_type') ? $this->request->param('select_type') : 1;
            $is_merchant = $this->request->param('is_merchant') ? $this->request->param('is_merchant') : 2;
            $member_type = $this->request->param('member_type') ? $this->request->param('member_type') : 1;
            $WX_APPID = 'wxfd3f63c9f418f478';//小程序appid
            $WX_SECRET = '45149e892b99aab9b6d1fe7adfc46604';//小程序AppSecret
            $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $WX_APPID . "&secret=" . $WX_SECRET . "&js_code=" . $code . "&grant_type=authorization_code";
            $infos = json_decode(file_get_contents($url));
            $openid = $infos->openid;


            //$fee = I("post.total_fee");
            $fee = $this->request->param('coins');//举例支付0.01
            $appid = 'wxfd3f63c9f418f478';//appid.如果是公众号 就是公众号的appid
            $body = '用户充值';
            $mch_id = '1517166241';  //商户号
            $nonce_str = $this->nonce_str();//随机字符串
            $notify_url = 'http://gzj.majiangyun.com:80/api/Notify/notify'; //回调的url【自己填写】
            $openid = $openid;
            $out_trade_no = $this->order_number($openid);//商户订单号
            $spbill_create_ip = '121.40.148.132';//服务器的ip【自己填写】;
            $total_fee = $fee*100;// 微信支付单位是分，所以这里需要*100
            $trade_type = 'JSAPI';//交易类型 默认
            $key='cai68dar98en12xi56aoche66ng88xun';
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

            //统一接口prepay_id
            $url = 'https://api.mch.weixin.qq.com/pay/unifiedorder';
            $xml = $this->http_request($url, $post_xml);
            $array = $this->xml($xml);//全要大写


            if ($array['RETURN_CODE'] == 'SUCCESS' && $array['RETURN_MSG'] == 'OK') {
                $time = time();
                $tmp = [];//临时数组用于签名
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
                $order_data['user_id']=$user_id;
                $order_data['order_number']=$out_trade_no;
                $order_data['money']=$fee;
                $order_data['add_time']=time();
                $order_data['select_type']=$select_type;
                $order_data['is_merchant']=$is_merchant;
                $order_data['member_type']=$member_type;
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
        $wx_key = 'cai68dar98en12xi56aoche66ng88xun';//申请支付后有给予一个商户账号和密码，登陆后自己设置的key
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
        $data = [];

        foreach ($index as $key=>$value) {
            if($key == 'XML'||$key == 'xml') continue;
            $tag = $vals[$value[0]]['tag'];
            $value = $vals[$value[0]]['value'];
            $data[$tag] = $value;
        }
        return $data;
    }
}