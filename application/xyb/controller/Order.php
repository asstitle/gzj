<?php
namespace app\xyb\Controller;
use app\common\controller\Base;
use think\Db;
class Order extends Base
{
    //订单列表
    public function lists(){
        $status=$this->request->param('status') ? $this->request->param('status') : '-1';
        $done_time=$this->request->param('done_time') ? $this->request->param('done_time') : '';
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
        if($done_time){
            $arr_t=explode('-',$done_time);
            $start=strtotime($arr_t[0]);
            $end=strtotime(date("Y-m-d 23:59:59",strtotime($arr_t[1])));
            $where['done_time']=array('between',[$start,$end]);
            $pageParam['done_time']=$done_time;
        }else{
            $where['done_time']=array('>',0);
            $pageParam['done_time']=$done_time;
        }
       $data=Db::name('order')->where($where)->order('add_time desc')->paginate(10,false,$pageParam);
       $arr=array();
       foreach($data as $v){
         $info=Db::name('users')->where(array('id'=>$v['user_id']))->field('user_nickname,mobile')->find();
         $v['user_nickname']=$info['user_nickname'];
         $v['mobile']=$info['mobile'];
         $arr[]=$v;
         unset($v);
       }
       $page=$data->render();
       $this->assign('page',$page);
       $this->assign('arr',$arr);
       $this->assign('status',$status);
       $this->assign('done_time',$done_time);
       return $this->fetch();
    }
}