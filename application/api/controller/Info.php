<?php

namespace app\api\controller;
use app\common\controller\ApiBase;
use think\Controller;
use think\Db;
class Info extends Controller
{

    //商家第一次登录完善信息
    public function update_info_do()
    {
        if ($this->request->isPost()) {
            $user_id = input('post.user_id');
            $select_type = input('post.select_type');
            $open_time = input('post.open_time') ? input('post.open_time') : '';
            $is_company = input('post.is_company') ? input('post.is_company') : 0;
            //1-我要招聘 2-店铺(房)交易 3-二手车
            if ($select_type == 0) {
                return json(array('code' => 400, '请选择从事类型'));
            }
            $contact_person = input('post.contact_person');//联系人
            $contact_tel = input('post.contact_tel');//联系电话
            if (!preg_match('/^1[34578]\d{9}$/', $contact_tel)) {
                return json(array('code' => 403, 'info' => '手机号格式有误'));
            }
            if ($is_company == 1) {//公司
                $company_name = input('post.company_name') ? input('post.company_name') : '';//公司名称
                $province = input('post.province');//省份
                $city = input('post.city');//城市
                $address = input('post.address');//详细地址
                $files = input('post.imgs/a');//上传店铺照
                //print_r($files);
                if ($select_type != 1) {//招聘商户不用上传店铺照
                    if (empty($files)) {
                        return json(array('code' => 404, 'info' => '请选择上传店铺照'));
                    }
                }
                $file_count = count($files);
                if ($file_count) {
                    //查询后台设置的店铺照数量
                    $set_pic_num = Db::name('shop_pic')->find();
                    if ($file_count < $set_pic_num['num']) {
                        return json(array('code' => 411, 'info' => '请上传至少' . $set_pic_num['num'] . '张店铺照'));
                    }
                    $data = json_encode($files);
                } else {
                    $data = '';
                }


                $zz = input('post.Business_img/a');//上传店铺照
                $zz_counts = count($zz);
                if ($zz_counts) {
                    $datas = json_encode($zz);
                } else {
                    $datas = '';
                }


                $add_info['company_name'] = $company_name;
                $add_info['province'] = $province;
                $add_info['city'] = $city;
                $add_info['address'] = $address;
                $add_info['photos'] = $data;
                $add_info['contact_person'] = $contact_person;
                $add_info['contact_tel'] = $contact_tel;
                $add_info['zz_img'] = $datas;
                $add_info['user_id'] = $user_id;
                $add_info['select_type'] = $select_type;
                $add_info['open_time'] = $open_time;
                $add_info['add_time'] = time();
                $result = Db::name('company')->insert($add_info);
            } else {//个人
                $add_info['contact_person'] = $contact_person;
                $add_info['contact_tel'] = $contact_tel;
                $add_info['user_id'] = $user_id;
                $add_info['add_time'] = time();
                $add_info['status'] = 0;
                $result = Db::name('company')->insert($add_info);
            }

            if ($result) {
                Db::name('user_type_info')->where(array('user_id' => $user_id, 'select_type' => $select_type))->update(array('is_deal' => 1));
                return json(array('code' => 409, 'info' => '公司信息提交成功'));
            } else {
                return json(array('code' => 410, 'info' => '公司信息提交失败'));
            }

        }
    }



    //获取省市
    public function get_location(){
      if($this->request->isPost()) {
          $province_code=$this->request->param('province_code') ? $this->request->param('province_code') : 0;
          if($province_code){
              $province=Db::name('province')->where(array('code'=>$province_code))->select();
          }else{
              $province=Db::name('province')->select();
          }
          $arr=array();
          foreach($province as $v){
              $v['next_city']=Db::name('city')->where(array('province_code'=>$v['code']))->select();
              $arr[]=$v;
              unset($v);
          }
          return json(array('code'=>200,'info'=>'获取成功','data'=>$arr));
      }
    }

     //商家搜索求职者信息权限判断
    public function search_auth_judge(){
        if($this->request->isPost()){
            $user_id=$this->request->param('user_id');
            $result=Db::name('users')->where(array('id'=>$user_id))->field('sh_super_member')->find();
            return json(array('code'=>411,'info'=>'操作成功','data'=>$result));
        }
    }
    //商家搜索求职者信息
    public function sh_search_seek_info(){
        if($this->request->isPost()){
            $content=$this->request->param('content');
            $res=Db::name('user_seek_job')->where(array('status'=>1))->where('job_name','like',"$content%")->order('add_time desc')->field('id,sex,job_name,user_name,user_id')->select();
            $arr=array();
            if(!empty($res)){
                foreach($res as $v){
                    $v['avater']=Db::name('users')->where(array('id'=>$v['user_id']))->value('avater');
                    //用户是否被拉黑过
                    $v_info=Db::name('sh_pull_black')->where(array('user_seek_id'=>$v['user_id']))->count();
                    if($v_info==0){
                        $v['is_black']=0;
                    }else{
                        $v['is_black']=1;
                    }
                    //用户是不是超级会员
                    $vs_info=Db::name('users')->where(array('id'=>$v['user_id']))->field('user_super_member')->find();
                    if($vs_info['user_super_member']==0){
                        $v['is_user_super']=0;
                    }else{
                        $v['is_user_super']=1;
                    }
                    $arr[]=$v;
                    unset($v);
                }
                return json(array('code'=>412,'info'=>'操作成功','data'=>$arr));
            }else{
                return json(array('code'=>413,'info'=>'数据为空','data'=>[]));
            }

        }
    }

    //获取发布金币
    public function get_publish_coins(){
        if($this->request->isPost()){
            $res=Db::name('publish_coins')->find();
            return json(array('code'=>415,'info'=>'获取成功','data'=>$res));
        }
    }
}