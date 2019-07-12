<?php if (!defined('THINK_PATH')) exit(); /*a:8:{s:62:"D:\wamp\www\xy\public/../application/xyb\view\index\index.html";i:1562840357;s:52:"D:\wamp\www\xy\application\xyb\view\Public\head.html";i:1562840357;s:54:"D:\wamp\www\xy\application\xyb\view\Public\header.html";i:1562840357;s:55:"D:\wamp\www\xy\application\xyb\view\Public\sidebar.html";i:1562840357;s:59:"D:\wamp\www\xy\application\xyb\view\Public\breadcrumbs.html";i:1562840357;s:51:"D:\wamp\www\xy\application\xyb\view\Public\set.html";i:1562840357;s:54:"D:\wamp\www\xy\application\xyb\view\Public\footer.html";i:1562840357;s:56:"D:\wamp\www\xy\application\xyb\view\Public\footerjs.html";i:1562840357;}*/ ?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta charset="utf-8"/>
    <title>代调课系统</title>

    <meta name="keywords" content=""/>
    <meta name="description" content=""/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0"/>


    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="/static//xyb/css/bootstrap.css"/>
    <link rel="stylesheet" href="/static//xyb/css/font-awesome.css"/>
    <link rel="stylesheet" href="/static//xyb/css/jquery-ui.css"/>
    <!-- page specific plugin styles -->

    <!-- text fonts -->
    <link rel="stylesheet" href="/static//xyb/css/ace-fonts.css"/>

    <!-- ace styles -->
    <link rel="stylesheet" href="/static//xyb/css/ace.css" class="ace-main-stylesheet" id="main-ace-style"/>

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="/static//xyb/css/ace-part2.css" class="ace-main-stylesheet"/>
    <![endif]-->

    <!--[if lte IE 9]>
    <link rel="stylesheet" href="/static//xyb/css/ace-ie.css"/>

    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->
    <script src="/static//xyb/js/ace-extra.js"></script>

    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

    <!--[if lte IE 8]>
    <script src="/static//xyb/js/html5shiv.js"></script>
    <script src="/static//xyb/js/respond.js"></script>
    <![endif]-->
</head>
<body class="no-skin">
    <!-- #section:basics/navbar.layout -->
    <div id="navbar" class="navbar navbar-default">
        <script type="text/javascript">
            try {
                ace.settings.check('navbar', 'fixed')
            } catch (e) {
            }
        </script>

        <div class="navbar-container" id="navbar-container">
            <!-- #section:basics/sidebar.mobile.toggle -->
            <button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
                <span class="sr-only">Toggle sidebar</span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>

                <span class="icon-bar"></span>
            </button>

            <!-- /section:basics/sidebar.mobile.toggle -->
            <div class="navbar-header pull-left">
                <!-- #section:basics/navbar.layout.brand -->
                <a href="{:Url('index/index')}" class="navbar-brand">
                    <small>
                        <i class="fa fa-leaf"></i>
                        代调课系统
                    </small>
                </a>

                <!-- /section:basics/navbar.layout.brand -->

                <!-- #section:basics/navbar.toggle -->

                <!-- /section:basics/navbar.toggle -->
            </div>

            <!-- #section:basics/navbar.dropdown -->
            <div class="navbar-buttons navbar-header pull-right" role="navigation">
                <ul class="nav ace-nav">

                    <li class="purple dropdown-modal">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                            <i class="ace-icon fa fa-bell icon-animated-bell"></i>
                            <span class="badge badge-important">8</span>
                        </a>

                        <ul class="dropdown-menu-right dropdown-navbar navbar-pink dropdown-menu dropdown-caret dropdown-close">
                            <li class="dropdown-header">
                                <i class="ace-icon fa fa-exclamation-triangle"></i>
                                8 条未读消息
                            </li>

                            <li class="dropdown-content">
                                <ul class="dropdown-menu dropdown-navbar navbar-pink">
                                    <li>
                                        <a href="#">
                                            <div class="clearfix">
													<span class="pull-left">
														<i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
														新消息
													</span>
                                            </div>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                        </ul>
                    </li>

                    <li class="light-blue dropdown-modal">
                        <a data-toggle="dropdown" href="#" class="dropdown-toggle">
                            <img class="nav-user-photo" src="/static/xyb/img/user.jpg" alt="Jason's Photo" />
                            <span class="user-info">
									<small>Welcome,</small>
									Jason
								</span>

                            <i class="ace-icon fa fa-caret-down"></i>
                        </a>

                        <ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
                            <li>
                                <a href="#">
                                    <i class="ace-icon fa fa-cog"></i>
                                    设置
                                </a>
                            </li>

                            <li>
                                <a href="profile.html">
                                    <i class="ace-icon fa fa-user"></i>
                                    个人资料
                                </a>
                            </li>

                            <li class="divider"></li>

                            <li>
                                <a href="#">
                                    <i class="ace-icon fa fa-power-off"></i>
                                    退出
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div><!-- /.navbar-container --><!-- /.navbar-container -->
    </div>

    <!-- /section:basics/navbar.layout -->
<div class="main-container" id="main-container">
    <script type="text/javascript">
        try {
            ace.settings.check('main-container', 'fixed')
        } catch (e) {
        }
    </script>
        <!-- #section:basics/sidebar -->
    <div id="sidebar" class="sidebar responsive">
        <script type="text/javascript">
            try {
                ace.settings.check('sidebar', 'fixed')
            } catch (e) {
            }
        </script>

        <div class="sidebar-shortcuts" id="sidebar-shortcuts">
            <div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
                <button class="btn btn-success">
                    <i class="ace-icon fa fa-signal"></i>
                </button>

                <button class="btn btn-info">
                    <i class="ace-icon fa fa-pencil"></i>
                </button>

                <!-- #section:basics/sidebar.layout.shortcuts -->
                <button class="btn btn-warning">
                    <i class="ace-icon fa fa-users"></i>
                </button>

                <button class="btn btn-danger">
                    <i class="ace-icon fa fa-cogs"></i>
                </button>

                <!-- /section:basics/sidebar.layout.shortcuts -->
            </div>

            <div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
                <span class="btn btn-success"></span>

                <span class="btn btn-info"></span>

                <span class="btn btn-warning"></span>

                <span class="btn btn-danger"></span>
            </div>
        </div><!-- /.sidebar-shortcuts -->

        <ul class="nav nav-list">
            <li class="active">
                <a href="index.html">
                    <i class="menu-icon fa fa-tachometer"></i>
                    <span class="menu-text"> 控制台 </span>
                </a>

                <b class="arrow"></b>
            </li>

            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-desktop"></i>
                    <span class="menu-text">
								基本设置
							</span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">

                    <li class="">
                        <a href="typography.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            班级信息
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="elements.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            学年学期
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="buttons.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                           作息时间
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="content-slider.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                           课程信息
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="treeview.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                           任教信息
                        </a>

                        <b class="arrow"></b>
                    </li>

                </ul>
            </li>

            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-list"></i>
                    <span class="menu-text"> 我的日程 </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li class="">
                        <a href="tables.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            我的课表
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="jqgrid.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            调课情况
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>

            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-pencil-square-o"></i>
                    <span class="menu-text"> 班级课表 </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li class="">
                        <a href="form-elements.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            原始课表
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="form-elements-2.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                           实时班课表
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>
            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-pencil-square-o"></i>
                    <span class="menu-text"> 调代课申请 </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li class="">
                        <a href="form-elements.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            代课申请
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="form-elements-2.html">
                            <i class="menu-icon fa fa-caret-right"></i>
                            调课申请
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>
            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-pencil-square-o"></i>
                    <span class="menu-text"> 用户管理 </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li class="">
                        <a href="<?php echo url('rbac/index'); ?>">
                            <i class="menu-icon fa fa-caret-right"></i>
                            角色管理
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="<?php echo url('user/index'); ?>">
                            <i class="menu-icon fa fa-caret-right"></i>
                            系统用户
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>

            <li class="">
                <a href="#" class="dropdown-toggle">
                    <i class="menu-icon fa fa-pencil-square-o"></i>
                    <span class="menu-text"> 菜单管理 </span>

                    <b class="arrow fa fa-angle-down"></b>
                </a>

                <b class="arrow"></b>

                <ul class="submenu">
                    <li class="">
                        <a href="<?php echo url('menu/index'); ?>">
                            <i class="menu-icon fa fa-caret-right"></i>
                           菜单列表
                        </a>

                        <b class="arrow"></b>
                    </li>

                    <li class="">
                        <a href="<?php echo url('menu/add'); ?>">
                            <i class="menu-icon fa fa-caret-right"></i>
                            添加菜单
                        </a>

                        <b class="arrow"></b>
                    </li>
                </ul>
            </li>
        </ul><!-- /.nav-list -->

        <!-- #section:basics/sidebar.layout.minimize -->
        <div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
            <i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left"
               data-icon2="ace-icon fa fa-angle-double-right"></i>
        </div>

        <!-- /section:basics/sidebar.layout.minimize -->
        <script type="text/javascript">
            try {
                ace.settings.check('sidebar', 'collapsed')
            } catch (e) {
            }
        </script>
    </div>

    <!-- /section:basics/sidebar -->
    <div class="main-content">
        <div class="main-content-inner">
            <!-- #section:basics/content.breadcrumbs -->
                <div class="breadcrumbs" id="breadcrumbs">
        <script type="text/javascript">
            try {
                ace.settings.check('breadcrumbs', 'fixed')
            } catch (e) {
            }
        </script>

        <ul class="breadcrumb">
            <li>
                <i class="ace-icon fa fa-home home-icon"></i>
                <a href="{:Url('index/index')}">首页</a>
            </li>
            <li class="active">Dashboard</li>
        </ul><!-- /.breadcrumb -->
    </div>

            <!-- /section:basics/content.breadcrumbs -->
            <div class="page-content">

                
    <div class="ace-settings-container" id="ace-settings-container">
        <div class="btn btn-app btn-xs btn-warning ace-settings-btn" id="ace-settings-btn">
            <i class="ace-icon fa fa-cog bigger-130"></i>
        </div>

        <div class="ace-settings-box clearfix" id="ace-settings-box">
            <div class="pull-left width-50">
                <!-- #section:settings.skins -->
                <div class="ace-settings-item">
                    <div class="pull-left">
                        <select id="skin-colorpicker" class="hide">
                            <option data-skin="no-skin" value="#438EB9">#438EB9</option>
                            <option data-skin="skin-1" value="#222A2D">#222A2D</option>
                            <option data-skin="skin-2" value="#C6487E">#C6487E</option>
                            <option data-skin="skin-3" value="#D0D0D0">#D0D0D0</option>
                        </select>
                    </div>
                    <span>&nbsp; 选择皮肤</span>
                </div>

                <!-- /section:settings.skins -->

                <!-- #section:settings.navbar -->
                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-navbar"/>
                    <label class="lbl" for="ace-settings-navbar"> 固定导航条</label>
                </div>

                <!-- /section:settings.navbar -->

                <!-- #section:settings.sidebar -->
                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-sidebar"/>
                    <label class="lbl" for="ace-settings-sidebar"> 固定侧边栏</label>
                </div>

                <!-- /section:settings.sidebar -->

                <!-- #section:settings.breadcrumbs -->
                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-breadcrumbs"/>
                    <label class="lbl" for="ace-settings-breadcrumbs"> 固定面包屑</label>
                </div>

                <!-- /section:settings.breadcrumbs -->

                <!-- #section:settings.rtl -->
                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-rtl"/>
                    <label class="lbl" for="ace-settings-rtl"> 切换至左边</label>
                </div>

                <!-- /section:settings.rtl -->

                <!-- #section:settings.container -->
                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-add-container"/>
                    <label class="lbl" for="ace-settings-add-container">
                        切换宽窄度
                    </label>
                </div>

                <!-- /section:settings.container -->
            </div><!-- /.pull-left -->

            <div class="pull-left width-50">
                <!-- #section:basics/sidebar.options -->
                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-hover"/>
                    <label class="lbl" for="ace-settings-hover"> 子菜单收起</label>
                </div>

                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-compact"/>
                    <label class="lbl" for="ace-settings-compact"> 侧边栏紧凑</label>
                </div>

                <div class="ace-settings-item">
                    <input type="checkbox" class="ace ace-checkbox-2" id="ace-settings-highlight"/>
                    <label class="lbl" for="ace-settings-highlight"> 当前位置</label>
                </div>

                <!-- /section:basics/sidebar.options -->
            </div><!-- /.pull-left -->
        </div><!-- /.ace-settings-box -->
    </div><!-- /.ace-settings-container -->

                <!-- /section:settings.box -->
                <div class="row">
                    <div class="col-xs-12">
                        <!-- PAGE CONTENT BEGINS -->
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="tabbable">

                                    <div class="panel panel-default">
                                        <div class="panel-heading">
                                            <h3 class="panel-title">
                                                红花山小学简介
                                            </h3>
                                        </div>
                                        <div class="panel-body">
                                            深圳市光明新区红花山小学为2016年新建的公办小学，学校位于公明街道富利北路与松白公路交汇处，位于公明核心商圈，毗邻中粮云景国际小区。学校占地面积10500平方米，建筑面积12500平方米，办学规模为24个教学班，学生人数约1200人，2016年秋季开始招收一年级新生四个教学班约200人。 学校按照现代化学校高标准规划建设，设施设备齐全，配有多功能报告厅、图书馆、音乐室、美术室、舞蹈室、体育馆、科技创新实验室、语音室、200米跑道运动操场等，可满足多元化、个性化教育教学需要。
                                        </div>
                                    </div>

                                   <!-- /.tab-content -->
                                </div><!-- /.tabbable -->
                            </div><!-- /.col -->
                        </div><!-- /.row -->




                        <!-- PAGE CONTENT ENDS -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div>
    </div><!-- /.main-content -->

        <div class="footer">
        <div class="footer-inner">
            <!-- #section:basics/footer -->

            <!-- /section:basics/footer -->
        </div>
    </div>

</div><!-- /.main-container -->

<!-- basic scripts -->

<!--[if !IE]> -->
<script type="text/javascript">
    window.jQuery || document.write("<script src='/static//xyb/js/jquery.js'>" + "<" + "/script>");
</script>

<!-- <![endif]-->

<!--[if IE]>
<script type="text/javascript">
    window.jQuery || document.write("<script src='/static//xyb/js/jquery1x.js'>" + "<" + "/script>");
</script>
<![endif]-->
<script type="text/javascript">
    if ('ontouchstart' in document.documentElement) document.write("<script src='/static//xyb/js/jquery.mobile.custom.js'>" + "<" + "/script>");
</script>
<script src="/static//xyb/js/bootstrap.js"></script>

<!-- page specific plugin scripts -->
<script charset="utf-8" src="/static//kindeditor/kindeditor-min.js"></script>
<script charset="utf-8" src="/static//kindeditor/lang/zh_CN.js"></script>
<script src="/static//xyb/js/bootbox.js"></script>
<!-- ace scripts -->
<script src="/static//xyb/js/ace/elements.scroller.js"></script>
<script src="/static//xyb/js/ace/elements.colorpicker.js"></script>
<script src="/static//xyb/js/ace/elements.fileinput.js"></script>
<script src="/static//xyb/js/ace/elements.typeahead.js"></script>
<script src="/static//xyb/js/ace/elements.wysiwyg.js"></script>
<script src="/static//xyb/js/ace/elements.spinner.js"></script>
<script src="/static//xyb/js/ace/elements.treeview.js"></script>
<script src="/static//xyb/js/ace/elements.wizard.js"></script>
<script src="/static//xyb/js/ace/elements.aside.js"></script>
<script src="/static//xyb/js/ace/ace.js"></script>
<script src="/static//xyb/js/ace/ace.ajax-content.js"></script>
<script src="/static//xyb/js/ace/ace.touch-drag.js"></script>
<script src="/static//xyb/js/ace/ace.sidebar.js"></script>
<script src="/static//xyb/js/ace/ace.sidebar-scroll-1.js"></script>
<script src="/static//xyb/js/ace/ace.submenu-hover.js"></script>
<script src="/static//xyb/js/ace/ace.widget-box.js"></script>
<script src="/static//xyb/js/ace/ace.settings.js"></script>
<script src="/static//xyb/js/ace/ace.settings-rtl.js"></script>
<script src="/static//xyb/js/ace/ace.settings-skin.js"></script>
<script src="/static//xyb/js/ace/ace.widget-on-reload.js"></script>
<script src="/static//xyb/js/ace/ace.searchbox-autocomplete.js"></script>
<script src="/static//xyb/js/jquery-ui.js"></script>
<!-- inline scripts related to this page -->
</body>
</html>
