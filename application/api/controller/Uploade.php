<?php


namespace app\api\controller;


use think\Controller;
use think\Db;
class Uploade extends Controller
{
    //上传店铺照
    public function upload_shop_img(){
        //获取表单上传文件 例如上传了001.jpg
        $file = request()->file('imgs');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file) {
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                $file_name=$info->getSaveName();
                return json(array('code'=>411,'info'=>'店铺照上传成功','file_name'=>$file_name));
            } else {
                // 上传失败获取错误信息
                return json(array('code'=>412,'info'=>$file->getError(),'file_name'=>''));
            }
        }else{
            return json(array('code'=>413,'info'=>'没有图片'));
        }
    }
    //删除店铺照
    public function delete_shop_img(){
        if($this->request->isPost()){
            $file_name=$this->request->param('file_name');
            @unlink('../public/uploads/'.$file_name);
            return json(array('code'=>415,'info'=>'删除成功'));
        }
    }

    //上传营业资质
    public function upload_zz_img(){
        //获取表单上传文件 例如上传了001.jpg
        $file = request()->file('Business_img');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file) {
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                $file_name=$info->getSaveName();
                return json(array('code'=>413,'info'=>'营业资质上传成功','file_name'=>$file_name));
            } else {
                // 上传失败获取错误信息
                return json(array('code'=>414,'info'=>$file->getError(),'file_name'=>''));
            }
        }else{
            return json(array('code'=>413,'info'=>'没有图片'));
        }
    }
    //删除营业资质
    public function delete_zz_img(){
        if($this->request->isPost()){
            $file_name=$this->request->param('file_name');
            @unlink('../public/uploads/'.$file_name);
            return json(array('code'=>416,'info'=>'删除成功'));
        }
    }

    //招聘上传工作照图片
    public function upload_work_img(){
        //获取表单上传文件 例如上传了001.jpg
        $file = request()->file('work_pic');
        // 移动到框架应用根目录/public/uploads/ 目录下
        if($file) {
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            if ($info) {
                $file_name=$info->getSaveName();
                return json(array('code'=>417,'info'=>'工作照上传成功','file_name'=>$file_name));
            } else {
                // 上传失败获取错误信息
                return json(array('code'=>418,'info'=>$file->getError(),'file_name'=>''));
            }
        }else{
            return json(array('code'=>419,'info'=>'没有图片'));
        }
    }

    //删除上传工作照图片
    public function delete_work_img(){
        if($this->request->isPost()){
            $file_name=$this->request->param('file_name');
            @unlink('../public/uploads/'.$file_name);
            return json(array('code'=>420,'info'=>'删除成功'));
        }
    }
}