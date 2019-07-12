<?php
namespace app\xyb\Controller;
use app\common\Controller\Base;
use think\Db;
use tree\Tree;
class Menu extends Base
{
    //菜单列表
    public function index(){
        $result     = Db::name('AdminMenu')->order(["list_order" => "ASC"])->select();
        $tree       = new Tree();
        $tree->icon = ['&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ '];
        $tree->nbsp = '&nbsp;&nbsp;&nbsp;';

        $newMenus = [];
        foreach ($result as $m) {
            $newMenus[$m['id']] = $m;
        }
        foreach ($result as $key => $value) {

            $result[$key]['parent_id_node'] = ($value['parent_id']) ? ' class="child-of-node-' . $value['parent_id'] . '"' : '';
            $result[$key]['style']          = empty($value['parent_id']) ? '' : 'display:none;';
            $result[$key]['str_manage']     = '<a href="' . url("Menu/add", ["parent_id" => $value['id'], "menu_id" => $this->request->param("menu_id")])
                . '"> 添加子菜单</a>  <a href="' . url("Menu/edit", ["id" => $value['id'], "menu_id" => $this->request->param("menu_id")])
                . '">编辑</a>  <a class="js-ajax-delete" href="' . url("Menu/delete", ["id" => $value['id'], "menu_id" => $this->request->param("menu_id")]) . '">删除</a> ';
            $result[$key]['status']         = $value['status'] ? '显示' : '隐藏';

                $result[$key]['app'] = $value['app'] . "/" . $value['controller'] . "/" . $value['action'];
        }

        $tree->init($result);
        $str      = "<tr id='node-\$id' \$parent_id_node style='\$style'>
                        <td style='padding-left:20px;'><input name='list_orders[\$id]' type='text' size='3' value='\$list_order' class='input input-order'></td>
                        <td>\$id</td>
                        <td>\$spacer\$name</td>
                        <td>\$app</td>
                        <td>\$status</td>
                        <td>\$str_manage</td>
                    </tr>";
        $category = $tree->getTree(0, $str);
        $this->assign("category", $category);
       return $this->fetch();
    }
    //添加菜单
    public function add(){
        $tree     = new Tree();
        $parentId = $this->request->param("parent_id", 0, 'intval');
        $result   = Db::name('AdminMenu')->order(["list_order" => "ASC"])->select();

        $array    = [];
        foreach ($result as $r) {
            $r['selected'] = $r['id'] == $parentId ? 'selected' : '';
            $array[]       = $r;
        }
        $str = "<option value='\$id' \$selected>\$spacer \$name</option>";

        $tree->init($array);

        $selectCategory = $tree->getTree(0, $str);
        $this->assign("select_category", $selectCategory);
        return $this->fetch();
    }


    public function addPost()
    {
        if ($this->request->isPost()) {
                $data = $this->request->param();
                Db::name('AdminMenu')->strict(false)->field(true)->insert($data);

                $app          = $this->request->param("app");
                $controller   = $this->request->param("controller");
                $action       = $this->request->param("action");
                $param        = $this->request->param("param");
                $authRuleName = "$app/$controller/$action";
                $menuName     = $this->request->param("name");

                $findAuthRuleCount = Db::name('auth_rule')->where([
                    'app'  => $app,
                    'name' => $authRuleName,
                    'type' => 'admin_url'
                ])->count();
                if (empty($findAuthRuleCount)) {
                    Db::name('AuthRule')->insert([
                        "name"  => $authRuleName,
                        "app"   => $app,
                        "type"  => "admin_url", //type 1-admin rule;2-user rule
                        "title" => $menuName,
                        'param' => $param,
                    ]);
                }
                $sessionAdminMenuIndex = session('admin_menu_index');
                $to                    = empty($sessionAdminMenuIndex) ? "Menu/index" : $sessionAdminMenuIndex;
                $this->success("添加成功！", url($to));
            }
    }


}