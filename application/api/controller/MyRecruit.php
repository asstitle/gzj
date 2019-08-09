<?php
namespace app\api\controller;
use app\common\controller\ApiBase;
use think\Controller;
use think\Db;

class MyRecruit extends ApiBase
{
    //招聘雇主我的个人中心
    public function my_index()
    {
        if ($this->request->isPost()) {
            $user_id = $this->request->param('user_id');
            $data = Db::name('users')->where(array('id' => $user_id))->field('coins,avater,user_nickname,sh_super_day,mobile')->find();
            if ($data) {
                return json(array('code' => 100, 'info' => '获取成功', 'data' => $data));
            } else {
                return json(array('code' => 101, 'info' => '用户信息不存在', 'data' => []));
            }
        }
    }

    //招聘雇主关闭当前状态
    public function close_status()
    {
        if ($this->request->isPost()) {
            $user_id = $this->request->param('user_id');
            $result = Db::name('recruit_company')->where(array('user_id' => $user_id, 'status' => 1))->update(array('status' => 0));
            if ($result) {
                return json(array('code' => 102, 'info' => '关闭成功'));
            } else {
                return json(array('code' => 103, 'info' => '关闭失败'));
            }
        }
    }

    //招聘雇主查看消息推送
    public function cat_pull_message()
    {
        if ($this->request->isPost()) {
            $user_id = $this->request->param('user_id');
            $result = Db::name('user_post_message')->where(array('to_user' => $user_id))->order('add_time desc')->select();
            $arr = array();
            foreach ($result as $v) {
                $v['uname'] = Db::name('users')->where(array('id' => $v['from_user']))->value('name');
                $arr[] = $v;
                unset($v);
            }
            return json(array('code' => 104, 'data' => $arr, 'info' => '获取成功'));
        }
    }

    //招聘雇主查看消息详情
    public function cat_message_detail()
    {
        if ($this->request->isPost()) {
            $id = $this->request->param('id');
            $data = Db::name('user_post_message')->where(array('id' => $id))->field('content')->find();
            return json(array('code' => 105, 'data' => $data, 'info' => '查看成功'));
        }
    }

    //招聘雇主查看个人简历
    public function cat_person_file()
    {
        if ($this->request->isPost()) {
            $person_file_id = $this->request->param('person_file_id');
            $data = Db::name('user_seek_job')->where(array('id' => $person_file_id))->find();
            $result=Db::name('sh_pull_black')->where(array('user_seek_id'=>$data['user_id']))->find();
            if(empty($result)){
                $is_black=0;//0未拉黑
            }else{
                $is_black=1;//已拉黑
            }
            if (empty($data)) {
                return json(array('code' => 201, 'info' => '数据为空', 'data' => [],'is_black'=>$is_black));
            } else {
                return json(array('code' => 200, 'info' => '获取成功', 'data' => $data,'is_black'=>$is_black));
            }
        }
    }

    //招聘雇主消费明细
    public function consume_detail()
    {
        if ($this->request->isPost()) {
            $user_id = $this->request->param('user_id');
            $p = $this->request->param('p');
            $pageSize = 15;
            $data = Db::name('user_consume_fee_detail')->where(array('user_id' => $user_id))->order('add_time desc')->limit(($p - 1) * $pageSize, $pageSize)->field('add_time,content,coins')->select();
            return json(array('code' => 110, 'info' => '获取成功', 'data' => $data));

        }
    }

    //查看招聘雇主个人信息
    public function cat_authorize_info()
    {
        if ($this->request->isPost()) {
            $user_id = $this->request->param('user_id');
            $data = Db::name('users')->where(array('id' => $user_id))->field('user_nickname,avater')->find();
            return json(array('code' => 111, 'info' => '获取成功', 'data' => $data));
        }
    }

    //招聘雇主发布统计
    public function statistics()
    {
        if ($this->request->isPost()) {
            $user_id = $this->request->param('user_id');
            $data = Db::name('recruit_company')->where(array('user_id' => $user_id))->field('user_id,add_time,seek_job')->select();
            return json(array('code' => 112, 'info' => '获取成功', 'data' => $data));
        }
    }

    //招聘雇主我的举报
    public function my_tip()
    {
        if ($this->request->isPost()) {
            $user_id = $this->request->param('user_id');
            $info = Db::name('sh_pull_black')->where(array('user_id' => $user_id))->order('add_time desc')->select();
            $arr = array();
            if (!empty($info)) {
                foreach ($info as $i) {
                    $res = Db::name('user_seek_job')->where(array('id' => $i['usj_id']))->field('user_name,job_name')->find();
                    $i['user_name'] = $res['user_name'];
                    $i['job_name'] = $res['job_name'];
                    $arr[] = $i;
                    unset($i);
                }
                return json(array('code' => 113, 'info' => '获取成功', 'data' => $arr));
            } else {
                return json(array('code' => 114, 'info' => '数据为空', 'data' => []));
            }
        }
    }

    //招聘雇主被举报
    public function my_tiped()
    {
        if ($this->request->isPost()) {
            $user_id = $this->request->param('user_id');
            $info = Db::name('seeker_pull_black')->where(array('pull_user_id' => $user_id))->where(array('status' => 0))->field('user_id,id')->order('add_time desc')->select();
            $arr = array();
            if (!empty($info)) {
                foreach ($info as $v) {
                    $v['uname'] = Db::name('users')->where(array('id' => $v['user_id']))->value('mobile');
                    $v['nums'] = Db::name('seeker_pull_black')->where(array('user_id' => $v['user_id']))->count();
                    $arr[] = $v;
                    unset($v);
                }
                return json(array('code' => 115, 'info' => '获取成功', 'data' => $arr));
            } else {
                return json(array('code' => 116, 'info' => '数据为空', 'data' => []));
            }

        }
    }

    //招聘雇主单个清除举报
    public function reset_tip()
    {
        if ($this->request->isPost()) {
            $id = $this->request->param('id');
            $user_id = $this->request->param('user_id');
            $coins = $this->request->param('coins');
            //查询用户的金币情况
            $user_info = Db::name('users')->where(array('id' => $user_id))->field('coins')->find();
            if ($coins > $user_info['coins']) {
                return json(array('code' => 117, 'info' => '金币余额不足,请充值'));
            }
            $result = Db::name('seeker_pull_black')->where(array('id' => $id))->update(array('status' => 1));
            if ($result) {
                //扣除金币
                Db::name('users')->where(array('id' => $user_id))->setDec('coins', $coins);
                //写入消费明细表
                $consume_record['user_id'] =$user_id;
                $consume_record['content'] ='清除举报';
                $consume_record['select_type'] = 1;
                $consume_record['is_merchant'] = 1;
                $consume_record['add_time'] = time();
                $consume_record['coins'] = -$coins;
                Db::name('user_consume_fee_detail')->insert($consume_record);
                return json(array('code' => 118, 'info' => '清除成功'));
            } else {
                return json(array('code' => 119, 'info' => '清除失败'));
            }
        }
    }

    //招聘雇主全部清除举报
    public function reset_all_tips(){
        if($this->request->isPost()){
            $ids=$this->request->param('ids');
            $coins=$this->request->param('coins');
            $user_id = $this->request->param('user_id');
            //查询用户的金币情况
            $user_info = Db::name('users')->where(array('id' => $user_id))->field('coins')->find();
            if ($coins > $user_info['coins']) {
                return json(array('code' => 120, 'info' => '金币余额不足,请充值'));
            }

            $result = Db::name('seeker_pull_black')->where('id','in',$ids)->update(array('status' => 1));
            if ($result) {
                //扣除金币
                Db::name('users')->where(array('id' => $user_id))->setDec('coins', $coins);
                //写入消费明细表
                $ids_arr=explode(',',$ids);
                $count=count($ids_arr);
                $per_coins=$coins/$count;
                $arrs=array();
                for($i=1;$i<=$count;$i++){
                    $consume_record['user_id'] =$user_id;
                    $consume_record['content'] ='清除举报';
                    $consume_record['select_type'] = 1;
                    $consume_record['is_merchant'] = 1;
                    $consume_record['add_time'] = time();
                    $consume_record['coins'] = -$per_coins;
                    $arrs[]=$consume_record;
                }
                Db::name('user_consume_fee_detail')->insertAll($arrs);
                return json(array('code' => 121, 'info' => '清除成功'));
            } else {
                return json(array('code' => 122, 'info' => '清除失败'));
            }
        }
    }
    //商家切换
    public function sh_switch(){
        if($this->request->isPost()){
            $user_id=$this->request->param('user_id');
            $select_type=$this->request->param('select_type');
            $type=1;
            $info=Db::name('user_type_info')->where(array('user_id'=>$user_id,'select_type'=>$select_type,'type'=>$type))->find();
            if(empty($info)){
                return json(array('code' => 123, 'info' => '请完善资料'));
            }else{
                if($info['is_deal']==0){
                return json(array('code' => 124, 'info' => '信息已存在,请完善资料'));
                }
            }
        }
    }
}