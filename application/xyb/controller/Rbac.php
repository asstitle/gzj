<?php

namespace app\xyb\Controller;
use app\common\controller\Base;
use app\xyb\model\AdminMenu as adminMenuModel;
use think\Db;
use tree\Tree;
class Rbac extends Base
{
     //角色管理界面
    public function index(){
       $data = Db::name('role')->order(["list_order" => "ASC", "id" => "DESC"])->select();
       $this->assign("roles", $data);
       return $this->fetch();
    }
    //角色添加
    public function role_add(){
        return $this->fetch();
    }
    //角色添加提交
    public function role_add_post(){
      if($this->request->isPost()){
          $data['name'] =$this->request->param('name');
          $data['remark']=$this->request->param('remark');
          $data['status']=$this->request->param('status');
          $data['create_time']=time();
          $data['update_time']=time();
          $result = Db::name('role')->insert($data);
          if ($result) {
              $this->success("添加角色成功", url("rbac/index"));
          } else {
              $this->error("添加角色失败");
          }
      }
    }

    /**
     * 设置角色权限
     * @adminMenu(
     *     'name'   => '设置角色权限',
     *     'parent' => 'index',
     *     'display'=> false,
     *     'hasView'=> true,
     *     'order'  => 10000,
     *     'icon'   => '',
     *     'remark' => '设置角色权限',
     *     'param'  => ''
     * )
     */
    public function authorize()
    {
        $AuthAccess     = Db::name("AuthAccess");
        $result     = Db::name('AdminMenu')->order(["list_order" => "ASC"])->select();
        //角色ID
        $roleId = $this->request->param("id", 0, 'intval');
        if (empty($roleId)) {
            $this->error("参数错误！");
        }
        $tree       = new Tree();
        $tree->icon = ['│ ', '├─ ', '└─ '];
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';
        $newMenus      = [];
        $privilegeData = $AuthAccess->where(["role_id" => $roleId])->column("rule_name");//获取权限表数据
        foreach ($result as $m) {
            $newMenus[$m['id']] = $m;
        }
        foreach ($result as $n => $t) {
            $result[$n]['checked']      = ($this->_isChecked($t, $privilegeData)) ? ' checked' : '';
            $result[$n]['level']        = $this->_getLevel($t['id'], $newMenus);
            $result[$n]['style']        = empty($t['parent_id']) ? '' : 'display:none;';
            $result[$n]['parentIdNode'] = ($t['parent_id']) ? ' class="child-of-node-' . $t['parent_id'] . '"' : '';
        }
        $str = "<tr id='node-\$id'\$parentIdNode  style='\$style'>
                   <td style='padding-left:30px;'>\$spacer<input type='checkbox' name='menuId[]' value='\$id' level='\$level' \$checked onclick='javascript:checknode(this);'> \$name</td>
    			</tr>";
        $tree->init($result);
        $category = $tree->getTree(0, $str);
        $this->assign("category", $category);
        $this->assign("roleId", $roleId);
        return $this->fetch();
    }

    /**角色授权提交
     * @throws \think\Exception
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\ModelNotFoundException
     * @throws \think\exception\DbException
     * @throws \think\exception\PDOException
     */
    public function authorizePost()
    {
        if ($this->request->isPost()) {
            $roleId = $this->request->param("roleId", 0, 'intval');
            if (!$roleId) {
                $this->error("需要授权的角色不存在！");
            }
            if (is_array($this->request->param('menuId/a')) && count($this->request->param('menuId/a')) > 0) {
                Db::name("authAccess")->where(["role_id" => $roleId, 'type' => 'admin_url'])->delete();
                foreach ($_POST['menuId'] as $menuId) {
                    $menu = Db::name("adminMenu")->where(["id" => $menuId])->field("app,controller,action")->find();
                    if ($menu) {
                        $app    = $menu['app'];
                        $model  = $menu['controller'];
                        $action = $menu['action'];
                        $name   = strtolower("$app/$model/$action");
                        Db::name("authAccess")->insert(["role_id" => $roleId, "rule_name" => $name, 'type' => 'admin_url']);
                    }
                }
                $this->success("授权成功！",url('rbac/index'));
            } else {
                //当没有数据时，清除当前角色授权
                Db::name("authAccess")->where(["role_id" => $roleId])->delete();
                $this->error("没有接收到数据，执行清除授权成功！");
            }
        }
    }

    /**
     * 检查指定菜单是否有权限
     * @param array $menu menu表中数组
     * @param $privData
     * @return bool
     */
    private function _isChecked($menu, $privData)
    {
        $app    = $menu['app'];
        $model  = $menu['controller'];
        $action = $menu['action'];
        $name   = strtolower("$app/$model/$action");
        if ($privData) {
            if (in_array($name, $privData)) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    /**
     * 获取菜单深度
     * @param $id
     * @param array $array
     * @param int $i
     * @return int
     */
    protected function _getLevel($id, $array = [], $i = 0)
    {
        if ($array[$id]['parent_id'] == 0 || empty($array[$array[$id]['parent_id']]) || $array[$id]['parent_id'] == $id) {
            return $i;
        } else {
            $i++;
            return $this->_getLevel($array[$id]['parent_id'], $array, $i);
        }
    }

    //编辑角色
    public function role_edit(){
        $id=$this->request->param('id');
        $info=Db::name('role')->where(array('id'=>$id))->find();
        $this->assign('info',$info);
        $this->assign('id',$id);
        return $this->fetch();
    }
    //编辑角色提交
    public function role_edit_post(){
      if($this->request->isPost()){
          $id=$this->request->param('id');
          $data['name'] =$this->request->param('name');
          $data['remark']=$this->request->param('remark');
          $data['status']=$this->request->param('status');
          $data['update_time']=time();
          $result = Db::name('role')->where(array('id'=>$id))->update($data);
          if ($result) {
              $this->success("修改角色成功", url("rbac/index"));
          } else {
              $this->error("修改角色失败");
          }
      }
    }
    //删除角色
    public function role_delete(){
        $id = $this->request->param("id", 0, 'intval');
        if ($id == 1) {
            $this->error("超级管理员角色不能被删除！");
        }
        $count = Db::name('RoleUser')->where(['role_id' => $id])->count();
        if ($count > 0) {
            $this->error("该角色已经有用户！");
        } else {
            $status = Db::name('role')->delete($id);
            if (!empty($status)) {
                $this->success("删除成功！", url('rbac/index'));
            } else {
                $this->error("删除失败！");
            }
        }
    }
}