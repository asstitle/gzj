<?php
namespace app\api\controller;
use think\Controller;
use think\Db;
class Notify extends Controller
{

    public function notify(){

        if (!$xml = file_get_contents('php://input')) {
            return json(array('code' => 205, 'info' => "not found data"));
        }

        // 将服务器返回的XML数据转化为数组
        $data = $this->fromXml($xml);
        // 保存微信服务器返回的签名sign
        $dataSign = $data['sign'];
        // sign不参与签名算法
        unset($data['sign']);
        // 生成签名
        $sign = $this->sign($data);

        //$wx_total_fee = $data['total_fee'];
        // 判断签名是否正确  判断支付状态
        if (($sign === $dataSign) && ($data['return_code'] == 'SUCCESS') && ($data['result_code'] == 'SUCCESS')) {
            $order_sn = $data['out_trade_no'];
            $order_info = Db::name('order')->where(['order_number' => $order_sn])->find();
            Db::name('order')->where(array('id' => $order_info['id']))->update(array('status' => 1, 'done_time' => time()));

            //现在身份是商户充值超级用户就更新users表中超级用户字段
            $day=Db::name('member_day')->where(array('id'=>$order_info['member_type']))->find();
            if($order_info['is_merchant']==1){
                //用户表金额增加
             Db::name('users')->where(array('id'=>$order_info['user_id']))->setInc('coins',$order_info['coins']);
             Db::name('users')->where(array('id'=>$order_info['user_id']))->update(array('sh_super_member'=>1));
             Db::name('users')->where(array('id'=>$order_info['user_id']))->setInc('sh_super_day',$day['day']);
            }
            //现在身份是普通用户充值超级用户就更新users表中超级用户字段
            if($order_info['is_merchant']==2){
                //用户表金额增加
                Db::name('users')->where(array('id'=>$order_info['user_id']))->setInc('user_coins',$order_info['coins']);
                Db::name('users')->where(array('id'=>$order_info['user_id']))->update(array('user_super_member'=>1));
                Db::name('users')->where(array('id'=>$order_info['user_id']))->setInc('user_super_day',$day['day']);
            }
            //写入消费明细表
            $detail_info['user_id']=$order_info['user_id'];
            $detail_info['add_time']=time();
            $detail_info['content']='充值会员';
            $detail_info['select_type']=$order_info['select_type'];
            $detail_info['is_merchant']=$order_info['is_merchant'];
            $detail_info['member_type']=$order_info['member_type'];
            $detail_info['coins']=$order_info['coins'];
            Db::name('user_consume_fee_detail')->insert($detail_info);
            echo 'SUCCESS';
            exit();
        }

    }



    //将XML转化成数组
    public function fromXml($xml){
        // 禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
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
    //回调充值金币
    public function notify_coins(){
        if (!$xml = file_get_contents('php://input')) {
            return json(array('code' => 205, 'info' => "not found data"));
        }

        // 将服务器返回的XML数据转化为数组
        $data = $this->fromXml($xml);
        // 保存微信服务器返回的签名sign
        $dataSign = $data['sign'];
        // sign不参与签名算法
        unset($data['sign']);
        // 生成签名
        $sign = $this->sign($data);

        //$wx_total_fee = $data['total_fee'];
        // 判断签名是否正确  判断支付状态
        if (($sign === $dataSign) && ($data['return_code'] == 'SUCCESS') && ($data['result_code'] == 'SUCCESS')) {
            $order_sn = $data['out_trade_no'];
            $order_info = Db::name('order')->where(['order_number' => $order_sn])->find();
            Db::name('order')->where(array('id' => $order_info['id']))->update(array('status' => 1, 'done_time' => time()));

            //现在身份是商户充值超级用户就更新users表中超级用户字段
            if($order_info['is_merchant']==1){
                //用户表金额增加
                Db::name('users')->where(array('id'=>$order_info['user_id']))->setInc('coins',$order_info['coins']);
            }
            //现在身份是普通用户充值超级用户就更新users表中超级用户字段
            if($order_info['is_merchant']==2){
                //用户表金额增加
                Db::name('users')->where(array('id'=>$order_info['user_id']))->setInc('user_coins',$order_info['coins']);
            }
            //写入消费明细表
            $detail_info['user_id']=$order_info['user_id'];
            $detail_info['add_time']=time();
            $detail_info['content']='充值金币';
            $detail_info['select_type']=$order_info['select_type'];
            $detail_info['is_merchant']=$order_info['is_merchant'];
            $detail_info['coins']=$order_info['coins'];
            Db::name('user_consume_fee_detail')->insert($detail_info);
            echo 'SUCCESS';
            exit();
        }
    }
}