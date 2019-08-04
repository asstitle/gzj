<?php
namespace app\api\controller;
use app\common\controller\ApiBase;
use think\Controller;
use think\Db;
class Car extends Controller
{

    //二手车列表
    public function car_lists()
    {
        $p = $this->request->param('p');
        $pageSize = 10;
        $result = Db::name('car_info')->order('add_time desc')->limit(($p - 1) * $pageSize, $pageSize)->where(array('status'=>1))->select();
        return json(array('code' => 800, 'info' => '获取成功', 'data' => $result));
    }

    //二手车筛选
    public function car_screen()
    {
        if ($this->request->isPost()) {
            $user_id = $this->request->param('user_id');
            //查询该用户是不是超级会员
            $user_info = Db::name('users')->where(array('id' => $user_id))->field('sh_super_member')->find();
            if ($user_info['sh_super_member'] == 0) {
                return json(array('code' => 803, 'info' => '筛选权限针对会员'));
            }
            $area = $this->request->param('area') ? $this->request->param('area') : '';
            $add_time = $this->request->param('add_time') ? $this->request->param('add_time') : '';
            $start = strtotime($add_time);
            $end = strtotime(date('Y-m-d 23:59:59', strtotime($add_time)));
            $where = array();
            if ($area) {
                $where['province'] = $area;
            }

            if ($add_time) {
                $where['add_time'] = array('between', [$start, $end]);
            }
            $data = Db::name('car_info')->where($where)->select();
            return json(array('code' => 804, 'info' => '获取成功', 'data' => $data));
        }
    }

    //二手车信息
    public function used_car_info()
    {
        if ($this->request->isPost()) {
            $user_id = $this->request->param('user_id');
            //商户信息
            $data = Db::name('company')->where(array('user_id' => $user_id, 'select_type' => 3))->field('province,city,open_time,photos,company_name,contact_person,contact_tel')->find();
            //商户所填二手车信息
            $info = Db::name('car_info')->where(array('user_id' => $user_id))->order('add_time desc')->field('id,car_name,car_type,car_age_limit,car_kilometer,car_pic')->select();
            $arr = array();
            foreach ($info as $i) {
                $i['car_type_name'] = Db::name('car_type')->where(array('id' => $i['car_type']))->value('name');
                $i['car_age_limit_name'] = Db::name('car_age_limit')->where(array('id' => $i['car_age_limit']))->value('name');
                $i['car_kilometer_name'] = Db::name('car_kilometer_set')->where(array('id' => $i['car_kilometer']))->value('name');
                $arr[] = $i;
            }
            return json(array('code' => 805, 'info' => '获取数据成功', 'data' => $data, 'arr' => $arr));
        }
    }

    //查看二手车车辆信息
    public function show_car_info()
    {
        if ($this->request->isPost()) {
            $id = $this->request->param('id');
            $info = Db::name('car_info')->where(array('id' => $id))->field('car_brand,car_type,car_age_limit,car_kilometer,car_handle_type,car_color,car_price,car_pic')->find();
            $arr = array();
            $arr['cat_type_name'] = Db::name('car')->where(array('id' => $info['car_type']))->value('name');
            $arr['car_age_limit_name'] = Db::name('car')->where(array('id' => $info['car_age_limit']))->value('name');
            $arr['car_kilometer_name'] = Db::name('car')->where(array('id' => $info['car_kilometer']))->value('name');
            $arr['car_handle_type_name'] = Db::name('car')->where(array('id' => $info['car_handle_type']))->value('name');
            $arr['car_price_name'] = Db::name('car')->where(array('id' => $info['car_price']))->value('name');
            $arr['car_pic'] = $info['pic'];
            return json(array('code' => 806, 'info' => '获取成功', 'data' => $arr));
        }
    }

    //二手车搜索
    public function car_search()
    {
        if ($this->request->isPost()) {
            $user_id = $this->request->param('user_id');
            $search_content = $this->request->param('search_content');
            $result = Db::name('users')->where(array('id' => $user_id))->field('sh_super_member')->find();
            if ($result['sh_super_member'] == 0) {
                return json(array('code' => 807, 'info' => '超级会员才有搜索功能'));
            }

            if ($search_content) {
                $where['car_name'] = array('like', "$search_content%");
            } else {
                $where = array();
            }

            $data = Db::name('car_info')->where($where)->where(array('status' => 1))->order('add_time desc')->select();
            return json(array('code' => 808, 'info' => '获取成功', 'data' => $data));
        }
    }

    //将二手车拉入黑名单
    public function pull_car_black()
    {
        if ($this->request->isPost()) {
            $car_info_id = $this->request->param('car_info_id');
            $user_id = $this->request->param('user_id');
            $result = Db::name('user_pull_car_black')->where(array('car_info_id' => $car_info_id, 'user_id' => $user_id))->find();
            if (empty($result)) {
                $data['car_info_id'] = $car_info_id;
                $data['user_id'] = $user_id;
                $data['add_time'] = time();
                $result = Db::name('user_pull_car_black')->insert($data);
                if ($result) {
                    return json(array('code' => 809, 'info' => '拉黑成功'));
                } else {
                    return json(array('code' => 810, 'info' => '拉黑失败'));
                }
            } else {
                return json(array('code' => 811, 'info' => '该二手车已经被拉黑过了'));
            }

        }
    }

    //商家发布中的二手车
    public function publish_car_having(){
        if($this->request->isPost()){
          $user_id=$this->request->param('user_id');
          $data=Db::name('car_info')->where(array('user_id'=>$user_id,'status'=>1))->select();
          return json(array('code'=>812,'info'=>'获取成功','data'=>$data));
        }
    }

    //发布二手车
    public function publish_car()
    {
        if ($this->request->isPost()) {
            $coins=$this->request->param('coins');
            $user_id = $this->request->param('user_id');
            $add_time = time();
            $contact_user = $this->request->param('contact_user');
            $contact_tel = $this->request->param('contact_tel');
            $car_brand = $this->request->param('car_brand');
            $car_type = $this->request->param('car_type');
            $car_age_limit = $this->request->param('car_age_limit');
            $car_kilometer = $this->request->param('car_kilometer');
            $car_handle_type = $this->request->param('car_handle_type');
            $car_color = $this->request->param('car_color');
            $car_price = $this->request->param('car_price');
            $car_pic = $this->request->param('car_pic');
            $province = $this->request->param('province');
            $city = $this->request->param('city');
            $status = 1;
            //查询该用户是否在同一地址发布过
            $publish_status=Db::name('car_publish_record')->where(array('user_id'=>$user_id,'province'=>$province,'city'=>$city))->field('id,num')->find();
            //查询用户现在账户的金额
            $account=Db::name('users')->where(array('id'=>$user_id))->field('coins')->find();
            if(!empty($publish_status)){
                if($publish_status['num']>=5){
                    if($coins>$account){
                        return json(array('code'=>812,'info'=>'账户金币余额不足,请充值'));
                    }
                }
            }else{
                //先查询用户资料是否审核通过
                $is_check=Db::name('company')->where(array('user_id'=>$user_id,'select_type'=>3,'status'=>1))->find();
                if(!empty($is_check)){

                  if($coins>$account){
                      return json(array('code'=>812,'info'=>'账户金币余额不足,请充值'));
                  }
                }else{
                    return json(array('code'=>813,'info'=>'该用户资料还未审核通过,暂时不能发布'));
              }
            }

            $data['user_id'] = $user_id;
            $data['add_time'] = $add_time;
            $data['contact_user'] = $contact_user;
            $data['contact_tel'] = $contact_tel;
            $data['car_brand'] = $car_brand;
            $data['car_type'] = $car_type;
            $data['car_age_limit'] = $car_age_limit;
            $data['car_kilometer'] = $car_kilometer;
            $data['car_handle_type'] = $car_handle_type;
            $data['car_color'] = $car_color;
            $data['car_price'] = $car_price;
            $data['car_pic'] = $car_pic;
            $data['status'] = $status;
            $data['province']=$province;
            $data['city']=$city;
            $result = Db::name('car_info')->insert($data);
            if ($result) {
                if(empty($publish_status)){
                  //扣除金币
                  Db::name('users')->where(array('id'=>$user_id))->setDec('coins',$coins);
                  //记录消费明细表
                  $consume_record['user_id']=$user_id;
                  $consume_record['content']='发布二手车';
                  $consume_record['select_type']=3;
                  $consume_record['is_merchant']=1;
                  $consume_record['add_time']=time();
                  $consume_record['coins']=-$coins;
                  Db::name('user_consume_fee_detail')->insert($consume_record);
                  //记录二手车发布信息
                  $car_record['user_id']=$user_id;
                  $car_record['province']=$province;
                  $car_record['city']=$city;
                  $car_record['num']=1;
                  Db::name('car_publish_record')->insert($car_record);
                }else{
                    //更新同一地点发布次数
                    Db::name('car_publish_record')->where(array('id'=>$publish_status['id']))->setInc('num',1);
                    if($publish_status['num']>=5){
                        Db::name('users')->where(array('id'=>$user_id))->setDec('coins',$coins);
                        //记录消费明细表
                        $consume_record['user_id']=$user_id;
                        $consume_record['content']='发布二手车';
                        $consume_record['select_type']=3;
                        $consume_record['is_merchant']=1;
                        $consume_record['add_time']=time();
                        $consume_record['coins']=-$coins;
                        Db::name('user_consume_fee_detail')->insert($consume_record);
                    }
                }
                return json(array('code' => 814, 'info' => '发布成功'));
            } else {
                return json(array('code' => 815, 'info' => '发布失败'));
            }
        }
    }

    //二手车删除
    public function delete_car(){
        if($this->request->isPost()){
            $id=$this->request->param('id');
            $result=Db::name('car_info')->where(array('id'=>$id))->delete();
            if($result){
                return json(array('code' => 816, 'info' => '删除成功'));
            }else{
                return json(array('code' => 817, 'info' => '删除失败'));
            }
        }
    }
    //二手车关闭
    public function close_car(){
        if($this->request->isPost()){
            $id=$this->request->param('id');
            $result=Db::name('car_info')->where(array('id'=>$id))->update(array('status'=>0));
            if($result){
                return json(array('code' => 818, 'info' => '关闭成功'));
            }else{
                return json(array('code' => 819, 'info' => '关闭失败'));
            }
        }
    }
    //二手车编辑新发布
    public function edit_new_publish(){
        if($this->request->isPost()){
            $user_id=$this->request->param('user_id');
            $info=Db::name('company')->where(array('user_id'=>$user_id))->field('address,contact_person,contact_tel')->find();
            return json(array('code'=>820,'info'=>'获取成功','data'=>$info));
        }
    }
}