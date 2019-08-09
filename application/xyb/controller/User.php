<?php

namespace app\xyb\Controller;
use app\common\controller\Base;
use think\Db;
class User extends Base
{

    //商家用户
    public function user_business(){
        $status=$this->request->param('status') ? $this->request->param('status') : '-1';
        $search_content=$this->request->param('search_content') ? $this->request->param('search_content') : '';
        $add_time=$this->request->param('add_time') ? $this->request->param('add_time') : '';
        $where=array();
        $pageParam=array();
        if(in_array($status,[1,2])){
            if($status==2){
                $status_code=0;
            }else{
                $status_code=$status;
            }
            $where['status']=$status_code;
            $pageParam['status']=$status;
        }else{
            $where['status']=array('in',[0,1]);
            $pageParam['status']=$status;

        }
        if($search_content){
            $where['contact_tel|contact_person']=array('like',"$search_content%");
            $pageParam['search_content']=$search_content;
        }else{
            $pageParam['search_content']=$search_content;
        }
        if($add_time){
            $arr_t=explode('-',$add_time);
            $start=strtotime($arr_t[0]);
            $end=strtotime(date("Y-m-d 23:59:59",strtotime($arr_t[1])));
            $where['add_time']=array('between',[$start,$end]);
            $pageParam['add_time']=$add_time;
        }else{
            $where['add_time']=array('>',0);
            $pageParam['add_time']=$add_time;
        }
        $data=Db::name('company')->where($where)->order('add_time desc')->field('id,company_name,province,city,address,contact_person,contact_tel,status,user_id,add_time,select_type')->paginate(10,false,$pageParam);
        $arr=array();
        foreach($data as $v){
            $result=Db::name('users')->where(array('id'=>$v['user_id']))->field('sh_super_member')->find();
            if($result['sh_super_member']==1){
                $v['is_super']=1;
            }else{
                $v['is_super']=0;
            }
            if($v['company_name']==''){
              $v['type_name']='商家-个人';
            }else{
              $v['type_name']='商家-公司';
            }
            $arr[]=$v;
            unset($v);
        }
        $page=$data->render();
        $this->assign('page',$page);
        $this->assign('data',$arr);
        $this->assign('status',$status);
        $this->assign('search_content',$search_content);
        $this->assign('add_time',$add_time);
        return $this->fetch();
    }
    //系统用户
    public function user_common(){
        $search_content=$this->request->param('search_content') ? $this->request->param('search_content') : '';
        $add_time=$this->request->param('add_time') ? $this->request->param('add_time') : '';
        $where=array();
        $pageParam=array();
        if($search_content){
            $where['user_nickname|mobile']=array('like',"$search_content%");
            $pageParam['search_content']=$search_content;
        }else{
            $pageParam['search_content']=$search_content;
        }
        if($add_time){
            $arr_t=explode('-',$add_time);
            $start=strtotime($arr_t[0]);
            $end=strtotime(date("Y-m-d 23:59:59",strtotime($arr_t[1])));
            $where['add_time']=array('between',[$start,$end]);
            $pageParam['add_time']=$add_time;
        }else{
            $where['add_time']=array('>=',0);
            $pageParam['add_time']=$add_time;
        }
        $result=Db::name('users')->where($where)->field('id,mobile,user_nickname,avater,add_time,openid')->order('add_time desc')->paginate(10,false,$pageParam);
        $page=$result->render();
        $this->assign('result',$result);
        $this->assign('page',$page);
        $this->assign('search_content',$search_content);
        $this->assign('add_time',$add_time);
        return $this->fetch();
    }
    //管理用户列表
   public function index(){
       $search_content=$this->request->param('search_content') ? $this->request->param('search_content') : '';
       $where=array();
       $pageParam=array();
       if($search_content){
           $where['mobile']=array('like',"$search_content%");
           $pageParam['search_content']=$search_content;
       }else{
           $pageParam['search_content']=$search_content;
       }
       $info=Db::name('user')->where($where)->order('last_login_time desc')->paginate(10);
       $page=$info->render();
       $this->assign('info',$info);
       $this->assign('page',$page);
       $this->assign('search_content',$search_content);
       return $this->fetch();
   }
   //添加用户
   public function add_user(){
       $roles = Db::name('role')->where(['status' => 1])->order("id DESC")->select();
       $this->assign("roles", $roles);
       return $this->fetch();
   }
   //添加用户提交
   public function add_user_post(){
       if ($this->request->isPost()) {
           if (!empty($_POST['role_id']) && is_array($_POST['role_id'])) {
               $role_ids = $_POST['role_id'];
               unset($_POST['role_id']);
                   $mrt=Config('MD5_KEY');
                   $_data['user_pass'] = Md5($mrt.$_POST['user_pass']);
                   $_data['user_login'] = $this->request->param('user_login');
                   $_data['sex'] = $this->request->param('sex');
                   $_data['mobile'] = $this->request->param('mobile');
                   $_data['create_time'] =time();
                   $_data['user_status'] =$this->request->param('user_status');
                   $result             = Db::name('user')->insertGetId($_data);
                   if ($result !== false) {
                       //$role_user_model=M("RoleUser");
                       foreach ($role_ids as $role_id) {
                           /*if (cmf_get_current_admin_id() != 1 && $role_id == 1) {
                               $this->error("为了网站的安全，非网站创建者不可创建超级管理员！");
                           }*/
                           Db::name('RoleUser')->insert(["role_id" => $role_id, "user_id" => $result]);
                       }
                       $this->success("添加成功！", url("user/index"));
                   } else {
                       $this->error("添加失败！");
                   }
               }
           } else {
               $this->error("请为此用户指定角色！");
           }
   }
   //查看用户详细信息
   public function user_cat_info(){
        $id=$this->request->param('id');
        $data=Db::name('company')->where(array('id'=>$id))->field('photos,zz_img')->find();
        $photos=json_decode($data['photos'],true);
        $zz_img=json_decode($data['zz_img'],true);
        $this->assign('photos',$photos);
        $this->assign('zz_img',$zz_img);
        return $this->fetch();
   }

   //审核用户信息
    public function check_user_info(){
        if($this->request->isPost()){
            $id=$this->request->param('id');
            $result=Db::name('company')->where(array('id'=>$id))->update(array('status'=>1));
            if($result){
               return json(array('status'=>1,'info'=>'审核成功'));
            }else{
               return json(array('status'=>0,'info'=>'审核失败'));
            }
        }
    }

    //禁用系统用户
    public function forbidden_user_info(){
        if($this->request->isPost()){
            $id=$this->request->param('id');
            $result=Db::name('user')->where(array('id'=>$id))->update(array('user_status'=>0));
            if($result){
                return json(array('status'=>1,'info'=>'操作成功'));
            }else{
                return json(array('status'=>0,'info'=>'操作失败'));
            }
        }
    }
    //启用系统用户
    public function open_user_info(){
        if($this->request->isPost()){
            $id=$this->request->param('id');
            $result=Db::name('user')->where(array('id'=>$id))->update(array('user_status'=>1));
            if($result){
                return json(array('status'=>1,'info'=>'操作成功'));
            }else{
                return json(array('status'=>0,'info'=>'操作失败'));
            }
        }
    }

    //编辑系统用户
    public function user_edit(){
        $id    = $this->request->param('id', 0, 'intval');
        $roles = DB::name('role')->where(['status' => 1])->order("id DESC")->select();
        $this->assign("roles", $roles);
        $role_ids = DB::name('RoleUser')->where(["user_id" => $id])->column("role_id");
        $this->assign("role_ids", $role_ids);
        $user = DB::name('user')->where(["id" => $id])->find();
        $this->assign('user',$user);
        $this->assign('id',$id);
        return $this->fetch();
    }
    //编辑系统用户提交
    public function user_edit_post(){
        if ($this->request->isPost()) {
            if (!empty($_POST['role_id']) && is_array($_POST['role_id'])) {
                if (empty($_POST['user_pass'])) {
                    unset($_POST['user_pass']);
                } else {
                    $_POST['user_pass']= md5(Config('MD5_KEY').$_POST['user_pass']);
                }
                $role_ids = $this->request->param('role_id/a');
                unset($_POST['role_id']);
                $uid = $this->request->param('id', 0, 'intval');
                    $result = DB::name('user')->where(array('id'=>$uid))->update($_POST);
                    if ($result !== false) {
                        DB::name("RoleUser")->where(["user_id" => $uid])->delete();
                        foreach ($role_ids as $role_id) {
                            if (session('id') != 1 && $role_id == 1) {
                                $this->error("为了网站的安全，非网站创建者不可创建超级管理员！");
                            }
                            DB::name("RoleUser")->insert(["role_id" => $role_id, "user_id" => $uid]);
                        }
                        $this->success("保存成功！",url('user/index'));
                    } else {
                        $this->error("保存失败！");
                    }
                }
            } else {
                $this->error("请为此用户指定角色！");
            }
    }

}