<?php

namespace app\api\controller;
use think\Controller;
use think\Db;
class Personal extends Controller
{
    //招聘首页
    public function recruit_index(){
      if($this->request->isPost()){
          $res=Db::name('recruit_company')->where(array('status'=>1))->order('add_time desc')->field('id,province,city,user_id')->select();
          $arr=array();
          if(!empty($res)){
              foreach($res as $v){
                  $info=Db::name('users')->where(array('user_id'=>$v['user_id']))->field('sh_super_member')->find();
                  if($info['sh_super_member']){
                      $v['is_super']=1;
                  }else{
                      $v['is_super']=0;
                  }

                  $res=Db::name('seeker_pull_black')->where(array('pull_user_id'=>$v['user_id']))->find();
                  if(!empty($res)){
                      $v['is_black']=1;
                  }else{
                      $v['is_black']=0;
                  }
                  $arr[]=$v;
              }
              return json(array('code'=>400,'info'=>'获取成功','data'=>$arr));
          }else{
              return json(array('code'=>401,'info'=>'数据为空','data'=>$arr));
          }
      }
    }
    //首页筛选
    public function index_select(){
      if($this->request->isPost()){
          $user_id=session('user_id');
          $res=Db::name('users')->where(array('id'=>$user_id))->field('user_super_member')->find();
          if($res['user_super_member']==1){
              return json(array('code'=>402,'info'=>'超级会员','is_super'=>1));
          }else{
              return json(array('code'=>403,'info'=>'非超级会员','is_super'=>0));
          }
      }
    }
    //用户发送消息
    public function user_post_message(){
      if($this->request->isPost()){
          $user_id=session('user_id');
          $to_user=$this->request->param('to_user');
          $content=$this->request->param('content');
          if(strlen($content)>60){
              return json(array('code'=>404,'info'=>'发送消息内容不能超过60个'));
          }
          $data['from_user']=$user_id;
          $data['to_user']=$to_user;
          $data['content']=$content;
          $data['add_time']=time();
          $res=Db::name('user_post_message')->insert($data);
          if($res){
              return json(array('code'=>405,'info'=>'发送成功'));
          }else{
              return json(array('code'=>406,'info'=>'发送失败'));
          }
      }
    }
    //搜索提示
    public function search_tip(){
        if($this->request->isPost()){
            $user_id=session('user_id');
            $res=Db::name('users')->where(array('id'=>$user_id))->field('user_super_member')->find();
            if($res['user_super_member']==0){
                return json(array('code'=>407,'info'=>'超级会员才有搜索权限'));
            }
            $search_content=$this->request->param('search_content');
            $data=Db::name('recruit_company')->where('seek_job','like',"$search_content")->where(array('status'=>1))->select();
            return json(array('code'=>408,'info'=>'获取成功','data'=>$data));
        }

    }
    //查看详情
    public function cat_detail(){
      if($this->request->isPost()){
          $id=$this->request->param('id');
          $data=Db::name('recruit_company')->where(array('id'=>$id))->find();
          return json(array('code'=>409,'info'=>'查看成功','data'=>$data));
      }
    }
    //查看公司详情
    public function cat_company_detail(){
      if($this->request->isPost()){
          $user_id=session('user_id');
          $user_coins=$this->request->param('user_coins');
          $id=$this->request->param('id');
          $res=Db::name('users')->where(array('id'=>$user_id))->field('user_coins')->find();
          $info=Db::name('user_cat_recruit_record')->where(array('user_id'=>$user_id,'rc_id'=>$id))->find();
          $data=Db::name('recruit_company')->where(array('id'=>$id))->find();
          if(empty($info)){
              if($user_coins>$res['user_coins']){
                  return json(array('code'=>410,'info'=>'余额不足,请充值'));
              }
              //写入消费明细
              $das['user_id']=$user_id;
              $das['content']='查看公司详情';
              $das['select_type']=1;
              $das['is_merchant']=2;
              $das['add_time']=time();
              $das['coins']=-$user_coins;
              Db::name('user_consume_fee_detail')->insert($das);
              //写入查看记录表
              $cat_record['user_id']=$user_id;
              $cat_record['add_time']=time();
              $cat_record['rc_id']=$id;
              Db::name('user_cat_recruit_record')->insert($cat_record);
              return json(array('code'=>411,'info'=>'查看成功','data'=>$data));
          }else{
              return json(array('code'=>412,'info'=>'查看成功','data'=>$data));
          }

      }
    }

    //公司列表
    public function company_lists(){
        if($this->request->isPost()){
            $data=Db::name('recruit_company')->where(array('status'=>1))->order('add_time desc')->field('id,company_name,work_pic')->select();
            return json(array('code'=>413,'info'=>'操作成功','data'=>$data));
        }
    }
    //搜索
    public function search_text(){
        if($this->request->isPost()){
            $user_id=session('user_id');
            $res=Db::name('users')->where(array('id'=>$user_id))->field('user_super_member')->find();
            if($res['user_super_member']==0){
                return json(array('code'=>407,'info'=>'超级会员才有搜索权限'));
            }
            $search_content=$this->request->param('search_content');
            $data=Db::name('recruit_company')->where('seek_job','like',"$search_content")->where(array('status'=>1))->field('work_pic,seek_job,work_address,work_time,demand_num')->select();
            return json(array('code'=>408,'info'=>'获取成功','data'=>$data));
        }
    }
    //超级用户筛选
    public function search_screen(){
      if($this->request->isPost()){
          $user_id=session('user_id');
          $info=Db::name('users')->where(array('id'=>$user_id))->field('user_super_member')->find();
          if($info['user_super_member']==0){
              return json(array('code'=>409,'info'=>'不是超级会员，无法筛选'));
          }
          $province=$this->request->param('province');
          $seek_job=$this->request->param('seek_job');
          $add_time=$this->request->param('add_time');
          $where=array();
          if($province){
              $where['province']=$province;
          }
          if($seek_job){
              $where['seek_job']=$seek_job;
          }
          if($add_time){
              $where['add_time']=$add_time;
          }
          $lists=Db::name('recruit_company')->where($where)->where(array('status'=>1))->select();
          return json(array('code'=>410,'info'=>'搜索成功','data'=>$lists));
      }
    }

    //用户店铺交易
    public function my_shop(){
        if($this->request->isPost()){
            $res=Db::name('shop_info')->where(array('status'=>1))->order('add_time desc')->select();
            $arr=array();
            if(!empty($res)){
                foreach($res as $v){
                    $result=Db::name('users')->where(array('id'=>$v['user_id']))->field('sh_super_member')->find();
                    if($result['sh_super_member']){
                        $v['is_super']=1;
                    }else{
                        $v['is_super']=0;
                    }
                    $arr[]=$v;
                }
                return json(array('code'=>411,'info'=>'操作成功','data'=>$arr));
            }else{
                return json(array('code'=>412,'info'=>'操作失败','data'=>$arr));
            }

        }
    }

    //店铺交易搜索
    public function shop_search(){
        if($this->request->isPost()){
            $user_id=session('user_id');
            $info=Db::name('users')->where(array('id'=>$user_id))->field('user_super_member')->find();
            if($info['user_super_member']==0){
                return json(array('code'=>413,'info'=>'超级会员才有搜索权限'));
            }
            $search_content=$this->request->param('search_content');
            $datas=Db::name('shop_info')->where('address','like',"$search_content")->where(array('status'=>1))->field('province,city,address,cat_id')->select();
            $arr=array();
            foreach($datas as $v){
                $v['cat_name']=Db::name('shop_cat')->where(array('id'=>$v['cat_id']))->value('name');
                $arr[]=$v;
                unset($v);
            }
            return json(array('code'=>414,'info'=>'获取成功','data'=>$arr));
        }
    }
    //店铺详情
    public function shop_detail(){
      if($this->request->isPost()){
          $id=$this->request->param('id');
          $data=Db::name('shop_info')->where(array('id'=>$id))->find();
          return json(array('code'=>415,'info'=>'获取成功','data'=>$data));
      }
    }

    //店铺筛选
    public function shop_screen(){
        if($this->request->isPost()){
            $user_id=session('user_id');
            $info=Db::name('users')->where(array('id'=>$user_id))->field('user_super_member')->find();
            if($info['user_super_member']==0){
                return json(array('code'=>416,'info'=>'不是超级会员，无法筛选'));
            }
            $province=$this->request->param('province');
            $cat_id=$this->request->param('cat_id');
            $add_time=$this->request->param('add_time');
            $where=array();
            if($province){
                $where['province']=$province;
            }
            if($cat_id){
                $where['cat_id']=$cat_id;
            }
            if($add_time){
                $where['add_time']=$add_time;
            }
            $lists=Db::name('shop_info')->where($where)->where(array('status'=>1))->select();
            return json(array('code'=>417,'info'=>'搜索成功','data'=>$lists));
        }
    }

    //店铺列表
    public function shop_lists(){
        $datas=Db::name('shop_info')->where(array('status'=>1))->order('add_time desc')->field('province,city,address,cat_id')->select();
        $arr=array();
        foreach($datas as $v){
            $v['cat_name']=Db::name('shop_cat')->where(array('id'=>$v['cat_id']))->value('name');
            $arr[]=$v;
            unset($v);
        }
        return json(array('code'=>418,'info'=>'操作成功','data'=>$arr));
    }

    //店铺信息
    public function shop_information(){
        if($this->request->isPost()){
            $id=$this->request->param('id');
            $data=Db::name('shop_info')->where(array('id'=>$id))->find();
            return json(array('code'=>419,'info'=>'操作成功','data'=>$data));
        }
    }

    //二手车首页
    public function car_index(){
        if($this->request->isPost()){
            $res=Db::name('car_info')->where(array('status'=>1))->order('add_time desc')->select();
            $arr=array();
            if(!empty($res)){
                foreach($res as $v){
                    $result=Db::name('users')->where(array('id'=>$v['user_id']))->field('sh_super_member')->find();
                    if($result['sh_super_member']){
                        $v['is_super']=1;
                    }else{
                        $v['is_super']=0;
                    }
                    $arr[]=$v;
                }
                return json(array('code'=>420,'info'=>'操作成功','data'=>$arr));
            }else{
                return json(array('code'=>421,'info'=>'操作失败','data'=>$arr));
            }
        }

    }

    //二手车交易搜索
    public function car_search(){
        if($this->request->isPost()){
            $user_id=session('user_id');
            $info=Db::name('users')->where(array('id'=>$user_id))->field('user_super_member')->find();
            if($info['user_super_member']==0){
                return json(array('code'=>422,'info'=>'超级会员才有搜索权限'));
            }
            $search_content=$this->request->param('search_content');
            $datas=Db::name('car_info')->where('address','like',"$search_content")->where(array('status'=>1))->field('province,city,address,user_id,open_time')->select();
            $arr=array();
            foreach($datas as $v){
                $v['company_name']=Db::name('company')->where(array('user_id'=>$v['user_id']))->value('company_name');
                $arr[]=$v;
                unset($v);
            }
            return json(array('code'=>423,'info'=>'获取成功','data'=>$arr));
        }
    }
    //二手车信息
    public function car_info(){
        if ($this->request->isPost()) {
            //商户信息
            //商户所填二手车信息
            $info = Db::name('car_info')->order('add_time desc')->field('id,car_name,car_type,car_age_limit,car_kilometer,car_pic')->where(array('status'=>1))->select();
            $arr = array();
            foreach ($info as $i) {
                $i['car_type_name'] = Db::name('car_type')->where(array('id' => $i['car_type']))->value('name');
                $i['car_age_limit_name'] = Db::name('car_age_limit')->where(array('id' => $i['car_age_limit']))->value('name');
                $i['car_kilometer_name'] = Db::name('car_kilometer_set')->where(array('id' => $i['car_kilometer']))->value('name');
                $i['company_info']=Db::name('company')->where(array('user_id' => $i['user_id'], 'select_type' => 3))->field('province,city,open_time,photos,company_name,contact_person,contact_tel')->find();
                $arr[] = $i;
            }
            return json(array('code' => 424, 'info' => '获取数据成功', 'data' => $arr));
        }
    }
    //二手车详情
    public function car_detail(){
      if($this->request->isPost()){
          $id=$this->request->param('id');
          $info = Db::name('car_info')->order('add_time desc')->field('id,car_name,car_type,car_age_limit,car_kilometer,car_pic')->where(array('id'=>$id))->find();
          return json(array('code' => 425, 'info' => '获取数据成功', 'data' => $info));
      }
    }

    //二手车筛选
    public function car_screen(){
        if($this->request->isPost()){
            $user_id=session('user_id');
            $info=Db::name('users')->where(array('id'=>$user_id))->field('user_super_member')->find();
            if($info['user_super_member']==0){
                return json(array('code'=>426,'info'=>'不是超级会员，无法筛选'));
            }
            $province=$this->request->param('province');
            $add_time=$this->request->param('add_time');
            $where=array();
            if($province){
                $where['province']=$province;
            }

            if($add_time){
                $where['add_time']=$add_time;
            }
            $lists=Db::name('car_info')->where($where)->where(array('status'=>1))->select();
            return json(array('code'=>427,'info'=>'搜索成功','data'=>$lists));
        }
    }
}