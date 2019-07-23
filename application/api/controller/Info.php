<?php

namespace app\api\controller;
use app\common\controller\ApiBase;
use think\Controller;
use think\Db;
class Info extends ApiBase
{
    //检查是否完善信息
    public function update_info(){
       if($this->request->isPost()) {
           //查询该商户是否完善信息
           $user_id = $this->request->param('user_id');
           $user_perfect = Db::name('users')->where(array('id' => $user_id))->field('id,is_deal')->find();
           if ($user_perfect['is_deal'] == 1) {
               return json(array('code' => 200, 'info' => '该用户已完善信息', 'is_deal' => 1, 'user_id' => $user_id));
           } else {
               return json(array('code' => 201, 'info' => '该用户未完善信息', 'is_deal' => 0, 'user_id' => $user_id));
           }
       }
    }

    //完善信息
    public function update_info_do(){
        $user_id = $this->request->param('user_id');
        $to_type=$this->request->param('to_type');
        $is_company=$this->request->param('is_company');
        $open_time=$this->request->param('open_time') ? $this->request->param('open_time') : '';
        //1-我要招聘 2-店铺(房)交易 3-二手车
        if($to_type==0){
            return json(array('code'=>400,'请选择从事类型'));
        }
        if($to_type==3&&$is_company==1){
            if($open_time==''){
                return json(array('code'=>401,'请选择营业时间'));
            }
        }
        //1公司,2个人
        if($is_company==0){
            return json(array('code'=>402,'请选择公司还是个人'));
        }
        $contact_person=$this->request->param('contact_person');//联系人
        $contact_tel=$this->request->param('contact_tel');//联系电话
        if(!preg_match('/^1[34578]\d{9}$/',$contact_tel)){
            return json(array('code'=>403,'info'=>'手机号格式有误'));
        }
        //1-商户类型公司 2-商户类型是个人
        if($is_company==1){
            $company_name=$this->request->param('company_name');//公司名称
            $province=$this->request->param('province');//省份
            $city=$this->request->param('city');//城市
            $address=$this->request->param('address');//详细地址
            $files = $_FILES;//上传店铺照
            if(empty($files)){
                return json(array('code'=>404,'info'=>'请选择上传店铺照'));
            }
            $file_count=count($files);
            for($i=1;$i<=$file_count;$i++){
                $size = $_FILES['img'.$i]['size'];
                $file_type = explode('.',$_FILES['img'.$i]['name']);
                $ext = $file_type[count ( $file_type ) - 1];
                if($size > 20*1024){
                    return json(array('code'=>405,'info'=>'上传文件大小超过限制,请选择20K以下的文件'));
                }
                if($ext != 'jpg' && $ext != 'png' && $ext != 'gif'){
                    return json(array('code'=>406,'info'=>'图片格式不正确'));
                }
                $tmp_name=$_FILES['img'.$i]["tmp_name"];
                /*判断是否符合验证*/
                $dir = ROOT_PATH . 'public' . DS . 'uploads';
                $date_dir=date('Ymd');
                $destination=$dir.'/'.$date_dir;
                if(!is_dir($destination)){
                    mkdir(iconv("UTF-8", "GBK", $destination),0777,true);
                }
                // 验证文件并移动到框架应用根目录/public/uploads/ 目录下
                $filename=time().'.'.$ext;
                if(!move_uploaded_file ($tmp_name, $destination))
                {
                    $data['shop_name']=$filename;
                    if($_FILES['img'.$i]['is_flag']==1){
                        $data['is_flag']=1;
                    }else{
                        $data['is_flag']=0;
                    }
                }

            }
            $business_img=request()->file('business_img');//营业资质
            if(!empty($business_img)){
                $validate_infos=$business_img->validate(['size'=>20*1024,'ext'=>'jpg,png,gif']);
                if(!$validate_infos){
                    return json(array('code'=>407,'info'=>'图片大小不能超过20KB,类型jpg,png,gif其中一种'));
                }
                $infos = $business_img->rule('uniqid')->move(ROOT_PATH . 'public' . DS . 'uploads');
                if($infos){
                    $zz_img=$infos->getSaveName();
                }else{
                    return json(array('code'=>408,'info'=>'营业资质上传失败'));
                }
            }else{
                $zz_img='';
            }

            $add_info['company_name']=$company_name;
            $add_info['province']=$province;
            $add_info['city']=$city;
            $add_info['address']=$address;
            $add_info['photos']=json_encode($data);
            $add_info['contact_person']=$contact_person;
            $add_info['contact_tel']=$contact_tel;
            $add_info['zz_img']=$zz_img;
            $add_info['user_id']=$user_id;
            $add_info['to_type']=$to_type;
            $add_info['open_time']=$open_time;
            $result=Db::name('company')->insert($add_info);
            if($result){
                Db::name('users')->where(array('id'=>$user_id))->update(array('is_company'=>1,'is_deal'=>1));
                return json(array('code'=>409,'info'=>'公司信息提交成功'));
            }else{
                return json(array('code'=>410,'info'=>'公司信息提交失败'));
            }
        }else{
            $add_info['contact_person']=$contact_person;
            $add_info['contact_tel']=$contact_tel;
            $add_info['user_id']=$user_id;
            $add_info['to_type']=$to_type;
            $result=Db::name('person')->insert($add_info);
            if($result){
                Db::name('users')->where(array('id'=>$user_id))->update(array('is_company'=>2,'is_deal'=>1));
                return json(array('code'=>411,'info'=>'个人信息提交成功'));
            }else{
                return json(array('code'=>412,'info'=>'个人信息提交失败'));
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
              unset($arr);
          }
          return json(array('code'=>200,'info'=>'获取成功','arr'=>$arr));
      }
    }
}