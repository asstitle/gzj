<?php
//控制器基类
namespace app\common\Controller;
use think\Controller;
use app\xyb\model\AdminMenu as adminMenuModel;
class Base extends Controller
{
    //验证是否登录,未登录跳转到登陆页
    public function __construct(){
        parent::__construct();
        $adminMenuModel=new adminMenuModel();
        $menus = $adminMenuModel->menuTree();
        $this->assign("menus", $menus);
        $session_admin_id = session('id');
        if (!empty($session_admin_id)) {
            if (!$this->checkAccess($session_admin_id)) {
                $this->error("您没有访问权限！");
            }
        } else {
            $this->redirect('Login/index');
        }
    }

    /**
     *  检查后台用户访问权限
     * @param int $userId 后台用户id
     * @return boolean 检查通过返回true
     */
    private function checkAccess($userId)
    {
        // 如果用户id是1，则无需判断
        if ($userId == 1) {
            return true;
        }

        $module     = $this->request->module();
        $controller = $this->request->controller();
        $action     = $this->request->action();
        $rule       = $module . $controller . $action;

        $notRequire = ["xybIndexindex"];
        if (!in_array($rule, $notRequire)) {
            return xyb_auth_check($userId);
        } else {
            return true;
        }
    }
}