/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : xyb

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2019-07-30 15:12:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for xyb_admin_menu
-- ----------------------------
DROP TABLE IF EXISTS `xyb_admin_menu`;
CREATE TABLE `xyb_admin_menu` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父菜单id',
  `type` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '菜单类型;1:有界面可访问菜单,2:无界面可访问菜单,0:只作为菜单',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态;1:显示,0:不显示',
  `list_order` float NOT NULL DEFAULT '0' COMMENT '排序',
  `app` varchar(40) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '应用名',
  `controller` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '控制器名',
  `action` varchar(30) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '操作名称',
  `param` varchar(50) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '额外参数',
  `name` varchar(30) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '菜单名称',
  `icon` varchar(60) CHARACTER SET utf8 NOT NULL DEFAULT '' COMMENT '菜单图标',
  `remark` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `status` (`status`),
  KEY `parent_id` (`parent_id`),
  KEY `controller` (`controller`)
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8mb4 COMMENT='后台菜单表';

-- ----------------------------
-- Records of xyb_admin_menu
-- ----------------------------
INSERT INTO `xyb_admin_menu` VALUES ('1', '0', '1', '1', '0', 'xyb', 'user', 'default', '', '用户管理', 'menu-icon fa fa-users', '');
INSERT INTO `xyb_admin_menu` VALUES ('2', '1', '1', '1', '0', 'xyb', 'user', 'user_business', '', '商户管理', '', '');
INSERT INTO `xyb_admin_menu` VALUES ('3', '1', '1', '1', '0', 'xyb', 'user', 'user_common', '', '普通用户', '', '');
INSERT INTO `xyb_admin_menu` VALUES ('4', '1', '1', '1', '0', 'xyb', 'user', 'index', '', '系统用户', '', '');
INSERT INTO `xyb_admin_menu` VALUES ('5', '0', '1', '1', '0', 'xyb', 'suggest', 'default', '', '意见管理', 'menu-icon fa fa-list', '');
INSERT INTO `xyb_admin_menu` VALUES ('6', '5', '1', '1', '0', 'xyb', 'suggest', 'index', '', '意见反馈', '', '');
INSERT INTO `xyb_admin_menu` VALUES ('7', '0', '1', '1', '0', 'user', 'consume', 'default', '', '金额明细', 'menu-icon fa fa-list-alt', '');
INSERT INTO `xyb_admin_menu` VALUES ('8', '7', '1', '1', '0', 'xyb', 'consume', 'info', '', '明细列表', '', '');
INSERT INTO `xyb_admin_menu` VALUES ('9', '0', '1', '1', '0', 'xyb', 'recruit', 'default', '', '招聘管理', 'menu-icon fa fa-tag', '');
INSERT INTO `xyb_admin_menu` VALUES ('10', '9', '1', '1', '0', 'xyb', 'recruit', 'release', '', '在招职位', '', '');
INSERT INTO `xyb_admin_menu` VALUES ('11', '9', '1', '1', '0', 'xyb', 'recruit', 'closed', '', '关闭职位', '', '');
INSERT INTO `xyb_admin_menu` VALUES ('12', '0', '1', '1', '0', 'xyb', 'shops', 'default', '', '商铺(房)管理', 'menu-icon fa fa-tag', '');
INSERT INTO `xyb_admin_menu` VALUES ('13', '12', '1', '1', '0', 'xyb', 'shops', 'release', '', '发布中', '', '');
INSERT INTO `xyb_admin_menu` VALUES ('14', '12', '1', '1', '0', 'xyb', 'shops', 'closed', '', '已关闭', '', '');
INSERT INTO `xyb_admin_menu` VALUES ('15', '0', '1', '1', '0', 'xyb', 'car', 'default', '', '二手车', 'menu-icon fa fa-tag', '');
INSERT INTO `xyb_admin_menu` VALUES ('16', '15', '1', '1', '0', 'xyb', 'car', 'release', '', '发布中', '', '');
INSERT INTO `xyb_admin_menu` VALUES ('17', '15', '1', '1', '0', 'xyb', 'car', 'closed', '', '已关闭', '', '');
INSERT INTO `xyb_admin_menu` VALUES ('18', '0', '1', '1', '0', 'xyb', 'profile', 'default', '', '资料管理', 'menu-icon fa fa-file-o', '');
INSERT INTO `xyb_admin_menu` VALUES ('19', '18', '1', '1', '0', 'xyb', 'profile', 'enterprise_info', '', '公司资料审核', '', '');
INSERT INTO `xyb_admin_menu` VALUES ('20', '18', '1', '1', '0', 'xyb', 'profile', 'person_info', '', '个人资料审核', '', '');
INSERT INTO `xyb_admin_menu` VALUES ('21', '0', '1', '1', '0', 'xyb', 'menu', 'default', '', '菜单管理', 'menu-icon fa fa-desktop', '');
INSERT INTO `xyb_admin_menu` VALUES ('22', '21', '1', '1', '0', 'xyb', 'menu', 'index', '', '菜单列表', '', '');
INSERT INTO `xyb_admin_menu` VALUES ('23', '21', '1', '1', '0', 'xyb', 'menu', 'add', '', '添加菜单', '', '');
INSERT INTO `xyb_admin_menu` VALUES ('24', '0', '1', '1', '0', 'xyb', 'index', 'index', '', '控制台', 'menu-icon fa fa-tachometer', '');
INSERT INTO `xyb_admin_menu` VALUES ('25', '1', '1', '1', '0', 'xyb', 'user', 'add_user', '', '添加用户', '', '');

-- ----------------------------
-- Table structure for xyb_auth_access
-- ----------------------------
DROP TABLE IF EXISTS `xyb_auth_access`;
CREATE TABLE `xyb_auth_access` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL COMMENT '角色',
  `rule_name` varchar(100) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识,全小写',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '权限规则分类,请加应用前缀,如admin_',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `rule_name` (`rule_name`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='权限授权表';

-- ----------------------------
-- Records of xyb_auth_access
-- ----------------------------

-- ----------------------------
-- Table structure for xyb_auth_rule
-- ----------------------------
DROP TABLE IF EXISTS `xyb_auth_rule`;
CREATE TABLE `xyb_auth_rule` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '规则id,自增主键',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '是否有效(0:无效,1:有效)',
  `app` varchar(15) NOT NULL COMMENT '规则所属module',
  `type` varchar(30) NOT NULL DEFAULT '' COMMENT '权限规则分类，请加应用前缀,如admin_',
  `name` varchar(100) NOT NULL DEFAULT '' COMMENT '规则唯一英文标识,全小写',
  `param` varchar(100) NOT NULL DEFAULT '' COMMENT '额外url参数',
  `title` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '规则描述',
  `condition` varchar(200) NOT NULL DEFAULT '' COMMENT '规则附加条件',
  PRIMARY KEY (`id`),
  UNIQUE KEY `name` (`name`) USING BTREE,
  KEY `module` (`app`,`status`,`type`)
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COMMENT='权限规则表';

-- ----------------------------
-- Records of xyb_auth_rule
-- ----------------------------
INSERT INTO `xyb_auth_rule` VALUES ('1', '1', 'xyb', 'admin_url', 'xyb/user/default', '', '用户管理', '');
INSERT INTO `xyb_auth_rule` VALUES ('2', '1', 'xyb', 'admin_url', 'xyb/user/user_business', '', '商户管理', '');
INSERT INTO `xyb_auth_rule` VALUES ('3', '1', 'xyb', 'admin_url', 'xyb/user/user_common', '', '普通用户', '');
INSERT INTO `xyb_auth_rule` VALUES ('4', '1', 'xyb', 'admin_url', 'xyb/user/index', '', '系统用户', '');
INSERT INTO `xyb_auth_rule` VALUES ('5', '1', 'xyb', 'admin_url', 'xyb/suggest/default', '', '意见管理', '');
INSERT INTO `xyb_auth_rule` VALUES ('6', '1', 'xyb', 'admin_url', 'xyb/suggest/index', '', '意见反馈', '');
INSERT INTO `xyb_auth_rule` VALUES ('7', '1', 'user', 'admin_url', 'user/consume/default', '', '金额明细', '');
INSERT INTO `xyb_auth_rule` VALUES ('8', '1', 'xyb', 'admin_url', 'xyb/consume/info', '', '明细列表', '');
INSERT INTO `xyb_auth_rule` VALUES ('9', '1', 'xyb', 'admin_url', 'xyb/recruit/default', '', '招聘管理', '');
INSERT INTO `xyb_auth_rule` VALUES ('10', '1', 'xyb', 'admin_url', 'xyb/recruit/release', '', '在招职位', '');
INSERT INTO `xyb_auth_rule` VALUES ('11', '1', 'xyb', 'admin_url', 'xyb/recruit/closed', '', '关闭职位', '');
INSERT INTO `xyb_auth_rule` VALUES ('12', '1', 'xyb', 'admin_url', 'xyb/shops/default', '', '商铺(房)管理', '');
INSERT INTO `xyb_auth_rule` VALUES ('13', '1', 'xyb', 'admin_url', 'xyb/shops/release', '', '发布中', '');
INSERT INTO `xyb_auth_rule` VALUES ('14', '1', 'xyb', 'admin_url', 'xyb/shops/closed', '', '已关闭', '');
INSERT INTO `xyb_auth_rule` VALUES ('15', '1', 'xyb', 'admin_url', 'xyb/car/default', '', '二手车', '');
INSERT INTO `xyb_auth_rule` VALUES ('16', '1', 'xyb', 'admin_url', 'xyb/car/release', '', '发布中', '');
INSERT INTO `xyb_auth_rule` VALUES ('17', '1', 'xyb', 'admin_url', 'xyb/car/closed', '', '已关闭', '');
INSERT INTO `xyb_auth_rule` VALUES ('18', '1', 'xyb', 'admin_url', 'xyb/profile/default', '', '资料管理', '');
INSERT INTO `xyb_auth_rule` VALUES ('19', '1', 'xyb', 'admin_url', 'xyb/profile/enterprise_info', '', '公司资料审核', '');
INSERT INTO `xyb_auth_rule` VALUES ('20', '1', 'xyb', 'admin_url', 'xyb/profile/person_info', '', '个人资料审核', '');
INSERT INTO `xyb_auth_rule` VALUES ('21', '1', 'xyb', 'admin_url', 'xyb/menu/default', '', '菜单管理', '');
INSERT INTO `xyb_auth_rule` VALUES ('22', '1', 'xyb', 'admin_url', 'xyb/menu/index', '', '菜单列表', '');
INSERT INTO `xyb_auth_rule` VALUES ('23', '1', 'xyb', 'admin_url', 'xyb/menu/add', '', '添加菜单', '');
INSERT INTO `xyb_auth_rule` VALUES ('24', '1', 'xyb', 'admin_url', 'xyb/user/add_user', '', '添加用户', '');

-- ----------------------------
-- Table structure for xyb_car_age_limit
-- ----------------------------
DROP TABLE IF EXISTS `xyb_car_age_limit`;
CREATE TABLE `xyb_car_age_limit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `age_limit` tinyint(4) NOT NULL DEFAULT '0' COMMENT '年限',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_car_age_limit
-- ----------------------------
INSERT INTO `xyb_car_age_limit` VALUES ('1', '1');
INSERT INTO `xyb_car_age_limit` VALUES ('2', '2');
INSERT INTO `xyb_car_age_limit` VALUES ('3', '3');
INSERT INTO `xyb_car_age_limit` VALUES ('4', '4');
INSERT INTO `xyb_car_age_limit` VALUES ('5', '5');
INSERT INTO `xyb_car_age_limit` VALUES ('6', '6');
INSERT INTO `xyb_car_age_limit` VALUES ('7', '7');
INSERT INTO `xyb_car_age_limit` VALUES ('8', '8');
INSERT INTO `xyb_car_age_limit` VALUES ('9', '9');
INSERT INTO `xyb_car_age_limit` VALUES ('10', '10');

-- ----------------------------
-- Table structure for xyb_car_color
-- ----------------------------
DROP TABLE IF EXISTS `xyb_car_color`;
CREATE TABLE `xyb_car_color` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL DEFAULT '' COMMENT '名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_car_color
-- ----------------------------
INSERT INTO `xyb_car_color` VALUES ('1', '黑色');
INSERT INTO `xyb_car_color` VALUES ('2', '白色');
INSERT INTO `xyb_car_color` VALUES ('3', '红色');
INSERT INTO `xyb_car_color` VALUES ('4', '其他');

-- ----------------------------
-- Table structure for xyb_car_handle_type
-- ----------------------------
DROP TABLE IF EXISTS `xyb_car_handle_type`;
CREATE TABLE `xyb_car_handle_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL DEFAULT '' COMMENT '名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_car_handle_type
-- ----------------------------
INSERT INTO `xyb_car_handle_type` VALUES ('1', '手动');
INSERT INTO `xyb_car_handle_type` VALUES ('2', '自动');

-- ----------------------------
-- Table structure for xyb_car_info
-- ----------------------------
DROP TABLE IF EXISTS `xyb_car_info`;
CREATE TABLE `xyb_car_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_brand` int(11) NOT NULL DEFAULT '0' COMMENT '汽车品牌id',
  `car_type` int(11) NOT NULL DEFAULT '0' COMMENT '汽车类型',
  `car_age_limit` int(11) NOT NULL DEFAULT '0' COMMENT '汽车年限',
  `car_kilometer` int(11) NOT NULL DEFAULT '0' COMMENT '汽车公里数id',
  `car_handle_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '汽车操作类型',
  `car_color` tinyint(4) NOT NULL DEFAULT '0' COMMENT '汽车颜色',
  `car_price` tinyint(4) NOT NULL DEFAULT '0' COMMENT '汽车价格id',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '1已发布，0已关闭',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_car_info
-- ----------------------------

-- ----------------------------
-- Table structure for xyb_car_kilometer_set
-- ----------------------------
DROP TABLE IF EXISTS `xyb_car_kilometer_set`;
CREATE TABLE `xyb_car_kilometer_set` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `car_kilometer` varchar(20) NOT NULL DEFAULT '' COMMENT '公里数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_car_kilometer_set
-- ----------------------------
INSERT INTO `xyb_car_kilometer_set` VALUES ('1', '10KM');
INSERT INTO `xyb_car_kilometer_set` VALUES ('2', '20KM');
INSERT INTO `xyb_car_kilometer_set` VALUES ('3', '30KM');
INSERT INTO `xyb_car_kilometer_set` VALUES ('4', '40KM');
INSERT INTO `xyb_car_kilometer_set` VALUES ('5', '50KM');

-- ----------------------------
-- Table structure for xyb_car_price
-- ----------------------------
DROP TABLE IF EXISTS `xyb_car_price`;
CREATE TABLE `xyb_car_price` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(10) NOT NULL DEFAULT '' COMMENT '名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_car_price
-- ----------------------------
INSERT INTO `xyb_car_price` VALUES ('1', '10K');
INSERT INTO `xyb_car_price` VALUES ('2', '12K');
INSERT INTO `xyb_car_price` VALUES ('3', '15K');
INSERT INTO `xyb_car_price` VALUES ('4', '20K');

-- ----------------------------
-- Table structure for xyb_car_type
-- ----------------------------
DROP TABLE IF EXISTS `xyb_car_type`;
CREATE TABLE `xyb_car_type` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_car_type
-- ----------------------------
INSERT INTO `xyb_car_type` VALUES ('1', 'SUV');
INSERT INTO `xyb_car_type` VALUES ('2', '商务');
INSERT INTO `xyb_car_type` VALUES ('3', '跑车');

-- ----------------------------
-- Table structure for xyb_city
-- ----------------------------
DROP TABLE IF EXISTS `xyb_city`;
CREATE TABLE `xyb_city` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL,
  `name` varchar(20) NOT NULL,
  `province_code` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=346 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_city
-- ----------------------------
INSERT INTO `xyb_city` VALUES ('1', '110100', '北京市', '110000');
INSERT INTO `xyb_city` VALUES ('2', '1102xx', '北京下属县', '1100xx');
INSERT INTO `xyb_city` VALUES ('3', '120100', '天津市', '120000');
INSERT INTO `xyb_city` VALUES ('4', '1202xx', '天津下属县', '1200xx');
INSERT INTO `xyb_city` VALUES ('5', '130100', '石家庄市', '130000');
INSERT INTO `xyb_city` VALUES ('6', '130200', '唐山市', '130000');
INSERT INTO `xyb_city` VALUES ('7', '130300', '秦皇岛市', '130000');
INSERT INTO `xyb_city` VALUES ('8', '130400', '邯郸市', '130000');
INSERT INTO `xyb_city` VALUES ('9', '130500', '邢台市', '130000');
INSERT INTO `xyb_city` VALUES ('10', '130600', '保定市', '130000');
INSERT INTO `xyb_city` VALUES ('11', '130700', '张家口市', '130000');
INSERT INTO `xyb_city` VALUES ('12', '130800', '承德市', '130000');
INSERT INTO `xyb_city` VALUES ('13', '130900', '沧州市', '130000');
INSERT INTO `xyb_city` VALUES ('14', '131000', '廊坊市', '130000');
INSERT INTO `xyb_city` VALUES ('15', '131100', '衡水市', '130000');
INSERT INTO `xyb_city` VALUES ('16', '140100', '太原市', '140000');
INSERT INTO `xyb_city` VALUES ('17', '140200', '大同市', '140000');
INSERT INTO `xyb_city` VALUES ('18', '140300', '阳泉市', '140000');
INSERT INTO `xyb_city` VALUES ('19', '140400', '长治市', '140000');
INSERT INTO `xyb_city` VALUES ('20', '140500', '晋城市', '140000');
INSERT INTO `xyb_city` VALUES ('21', '140600', '朔州市', '140000');
INSERT INTO `xyb_city` VALUES ('22', '140700', '晋中市', '140000');
INSERT INTO `xyb_city` VALUES ('23', '140800', '运城市', '140000');
INSERT INTO `xyb_city` VALUES ('24', '140900', '忻州市', '140000');
INSERT INTO `xyb_city` VALUES ('25', '141000', '临汾市', '140000');
INSERT INTO `xyb_city` VALUES ('26', '141100', '吕梁市', '140000');
INSERT INTO `xyb_city` VALUES ('27', '150100', '呼和浩特市', '150000');
INSERT INTO `xyb_city` VALUES ('28', '150200', '包头市', '150000');
INSERT INTO `xyb_city` VALUES ('29', '150300', '乌海市', '150000');
INSERT INTO `xyb_city` VALUES ('30', '150400', '赤峰市', '150000');
INSERT INTO `xyb_city` VALUES ('31', '150500', '通辽市', '150000');
INSERT INTO `xyb_city` VALUES ('32', '150600', '鄂尔多斯市', '150000');
INSERT INTO `xyb_city` VALUES ('33', '150700', '呼伦贝尔市', '150000');
INSERT INTO `xyb_city` VALUES ('34', '150800', '巴彦淖尔市', '150000');
INSERT INTO `xyb_city` VALUES ('35', '150900', '乌兰察布市', '150000');
INSERT INTO `xyb_city` VALUES ('36', '152200', '兴安盟', '150000');
INSERT INTO `xyb_city` VALUES ('37', '152500', '锡林郭勒盟', '150000');
INSERT INTO `xyb_city` VALUES ('38', '152900', '阿拉善盟', '150000');
INSERT INTO `xyb_city` VALUES ('39', '210100', '沈阳市', '210000');
INSERT INTO `xyb_city` VALUES ('40', '210200', '大连市', '210000');
INSERT INTO `xyb_city` VALUES ('41', '210300', '鞍山市', '210000');
INSERT INTO `xyb_city` VALUES ('42', '210400', '抚顺市', '210000');
INSERT INTO `xyb_city` VALUES ('43', '210500', '本溪市', '210000');
INSERT INTO `xyb_city` VALUES ('44', '210600', '丹东市', '210000');
INSERT INTO `xyb_city` VALUES ('45', '210700', '锦州市', '210000');
INSERT INTO `xyb_city` VALUES ('46', '210800', '营口市', '210000');
INSERT INTO `xyb_city` VALUES ('47', '210900', '阜新市', '210000');
INSERT INTO `xyb_city` VALUES ('48', '211000', '辽阳市', '210000');
INSERT INTO `xyb_city` VALUES ('49', '211100', '盘锦市', '210000');
INSERT INTO `xyb_city` VALUES ('50', '211200', '铁岭市', '210000');
INSERT INTO `xyb_city` VALUES ('51', '211300', '朝阳市', '210000');
INSERT INTO `xyb_city` VALUES ('52', '211400', '葫芦岛市', '210000');
INSERT INTO `xyb_city` VALUES ('53', '220100', '长春市', '220000');
INSERT INTO `xyb_city` VALUES ('54', '220200', '吉林市', '220000');
INSERT INTO `xyb_city` VALUES ('55', '220300', '四平市', '220000');
INSERT INTO `xyb_city` VALUES ('56', '220400', '辽源市', '220000');
INSERT INTO `xyb_city` VALUES ('57', '220500', '通化市', '220000');
INSERT INTO `xyb_city` VALUES ('58', '220600', '白山市', '220000');
INSERT INTO `xyb_city` VALUES ('59', '220700', '松原市', '220000');
INSERT INTO `xyb_city` VALUES ('60', '220800', '白城市', '220000');
INSERT INTO `xyb_city` VALUES ('61', '222400', '延边朝鲜族自治州', '220000');
INSERT INTO `xyb_city` VALUES ('62', '230100', '哈尔滨市', '230000');
INSERT INTO `xyb_city` VALUES ('63', '230200', '齐齐哈尔市', '230000');
INSERT INTO `xyb_city` VALUES ('64', '230300', '鸡西市', '230000');
INSERT INTO `xyb_city` VALUES ('65', '230400', '鹤岗市', '230000');
INSERT INTO `xyb_city` VALUES ('66', '230500', '双鸭山市', '230000');
INSERT INTO `xyb_city` VALUES ('67', '230600', '大庆市', '230000');
INSERT INTO `xyb_city` VALUES ('68', '230700', '伊春市', '230000');
INSERT INTO `xyb_city` VALUES ('69', '230800', '佳木斯市', '230000');
INSERT INTO `xyb_city` VALUES ('70', '230900', '七台河市', '230000');
INSERT INTO `xyb_city` VALUES ('71', '231000', '牡丹江市', '230000');
INSERT INTO `xyb_city` VALUES ('72', '231100', '黑河市', '230000');
INSERT INTO `xyb_city` VALUES ('73', '231200', '绥化市', '230000');
INSERT INTO `xyb_city` VALUES ('74', '232700', '大兴安岭地区', '230000');
INSERT INTO `xyb_city` VALUES ('75', '310100', '上海市', '310000');
INSERT INTO `xyb_city` VALUES ('76', '3102xx', '上海下属县', '3100xx');
INSERT INTO `xyb_city` VALUES ('77', '320100', '南京市', '320000');
INSERT INTO `xyb_city` VALUES ('78', '320200', '无锡市', '320000');
INSERT INTO `xyb_city` VALUES ('79', '320300', '徐州市', '320000');
INSERT INTO `xyb_city` VALUES ('80', '320400', '常州市', '320000');
INSERT INTO `xyb_city` VALUES ('81', '320500', '苏州市', '320000');
INSERT INTO `xyb_city` VALUES ('82', '320600', '南通市', '320000');
INSERT INTO `xyb_city` VALUES ('83', '320700', '连云港市', '320000');
INSERT INTO `xyb_city` VALUES ('84', '320800', '淮安市', '320000');
INSERT INTO `xyb_city` VALUES ('85', '320900', '盐城市', '320000');
INSERT INTO `xyb_city` VALUES ('86', '321000', '扬州市', '320000');
INSERT INTO `xyb_city` VALUES ('87', '321100', '镇江市', '320000');
INSERT INTO `xyb_city` VALUES ('88', '321200', '泰州市', '320000');
INSERT INTO `xyb_city` VALUES ('89', '321300', '宿迁市', '320000');
INSERT INTO `xyb_city` VALUES ('90', '330100', '杭州市', '330000');
INSERT INTO `xyb_city` VALUES ('91', '330200', '宁波市', '330000');
INSERT INTO `xyb_city` VALUES ('92', '330300', '温州市', '330000');
INSERT INTO `xyb_city` VALUES ('93', '330400', '嘉兴市', '330000');
INSERT INTO `xyb_city` VALUES ('94', '330500', '湖州市', '330000');
INSERT INTO `xyb_city` VALUES ('95', '330600', '绍兴市', '330000');
INSERT INTO `xyb_city` VALUES ('96', '330700', '金华市', '330000');
INSERT INTO `xyb_city` VALUES ('97', '330800', '衢州市', '330000');
INSERT INTO `xyb_city` VALUES ('98', '330900', '舟山市', '330000');
INSERT INTO `xyb_city` VALUES ('99', '331000', '台州市', '330000');
INSERT INTO `xyb_city` VALUES ('100', '331100', '丽水市', '330000');
INSERT INTO `xyb_city` VALUES ('101', '340100', '合肥市', '340000');
INSERT INTO `xyb_city` VALUES ('102', '340200', '芜湖市', '340000');
INSERT INTO `xyb_city` VALUES ('103', '340300', '蚌埠市', '340000');
INSERT INTO `xyb_city` VALUES ('104', '340400', '淮南市', '340000');
INSERT INTO `xyb_city` VALUES ('105', '340500', '马鞍山市', '340000');
INSERT INTO `xyb_city` VALUES ('106', '340600', '淮北市', '340000');
INSERT INTO `xyb_city` VALUES ('107', '340700', '铜陵市', '340000');
INSERT INTO `xyb_city` VALUES ('108', '340800', '安庆市', '340000');
INSERT INTO `xyb_city` VALUES ('109', '341000', '黄山市', '340000');
INSERT INTO `xyb_city` VALUES ('110', '341100', '滁州市', '340000');
INSERT INTO `xyb_city` VALUES ('111', '341200', '阜阳市', '340000');
INSERT INTO `xyb_city` VALUES ('112', '341300', '宿州市', '340000');
INSERT INTO `xyb_city` VALUES ('113', '341400', '巢湖市', '340000');
INSERT INTO `xyb_city` VALUES ('114', '341500', '六安市', '340000');
INSERT INTO `xyb_city` VALUES ('115', '341600', '亳州市', '340000');
INSERT INTO `xyb_city` VALUES ('116', '341700', '池州市', '340000');
INSERT INTO `xyb_city` VALUES ('117', '341800', '宣城市', '340000');
INSERT INTO `xyb_city` VALUES ('118', '350100', '福州市', '350000');
INSERT INTO `xyb_city` VALUES ('119', '350200', '厦门市', '350000');
INSERT INTO `xyb_city` VALUES ('120', '350300', '莆田市', '350000');
INSERT INTO `xyb_city` VALUES ('121', '350400', '三明市', '350000');
INSERT INTO `xyb_city` VALUES ('122', '350500', '泉州市', '350000');
INSERT INTO `xyb_city` VALUES ('123', '350600', '漳州市', '350000');
INSERT INTO `xyb_city` VALUES ('124', '350700', '南平市', '350000');
INSERT INTO `xyb_city` VALUES ('125', '350800', '龙岩市', '350000');
INSERT INTO `xyb_city` VALUES ('126', '350900', '宁德市', '350000');
INSERT INTO `xyb_city` VALUES ('127', '360100', '南昌市', '360000');
INSERT INTO `xyb_city` VALUES ('128', '360200', '景德镇市', '360000');
INSERT INTO `xyb_city` VALUES ('129', '360300', '萍乡市', '360000');
INSERT INTO `xyb_city` VALUES ('130', '360400', '九江市', '360000');
INSERT INTO `xyb_city` VALUES ('131', '360500', '新余市', '360000');
INSERT INTO `xyb_city` VALUES ('132', '360600', '鹰潭市', '360000');
INSERT INTO `xyb_city` VALUES ('133', '360700', '赣州市', '360000');
INSERT INTO `xyb_city` VALUES ('134', '360800', '吉安市', '360000');
INSERT INTO `xyb_city` VALUES ('135', '360900', '宜春市', '360000');
INSERT INTO `xyb_city` VALUES ('136', '361000', '抚州市', '360000');
INSERT INTO `xyb_city` VALUES ('137', '361100', '上饶市', '360000');
INSERT INTO `xyb_city` VALUES ('138', '370100', '济南市', '370000');
INSERT INTO `xyb_city` VALUES ('139', '370200', '青岛市', '370000');
INSERT INTO `xyb_city` VALUES ('140', '370300', '淄博市', '370000');
INSERT INTO `xyb_city` VALUES ('141', '370400', '枣庄市', '370000');
INSERT INTO `xyb_city` VALUES ('142', '370500', '东营市', '370000');
INSERT INTO `xyb_city` VALUES ('143', '370600', '烟台市', '370000');
INSERT INTO `xyb_city` VALUES ('144', '370700', '潍坊市', '370000');
INSERT INTO `xyb_city` VALUES ('145', '370800', '济宁市', '370000');
INSERT INTO `xyb_city` VALUES ('146', '370900', '泰安市', '370000');
INSERT INTO `xyb_city` VALUES ('147', '371000', '威海市', '370000');
INSERT INTO `xyb_city` VALUES ('148', '371100', '日照市', '370000');
INSERT INTO `xyb_city` VALUES ('149', '371200', '莱芜市', '370000');
INSERT INTO `xyb_city` VALUES ('150', '371300', '临沂市', '370000');
INSERT INTO `xyb_city` VALUES ('151', '371400', '德州市', '370000');
INSERT INTO `xyb_city` VALUES ('152', '371500', '聊城市', '370000');
INSERT INTO `xyb_city` VALUES ('153', '371600', '滨州市', '370000');
INSERT INTO `xyb_city` VALUES ('154', '371700', '荷泽市', '370000');
INSERT INTO `xyb_city` VALUES ('155', '410100', '郑州市', '410000');
INSERT INTO `xyb_city` VALUES ('156', '410200', '开封市', '410000');
INSERT INTO `xyb_city` VALUES ('157', '410300', '洛阳市', '410000');
INSERT INTO `xyb_city` VALUES ('158', '410400', '平顶山市', '410000');
INSERT INTO `xyb_city` VALUES ('159', '410500', '安阳市', '410000');
INSERT INTO `xyb_city` VALUES ('160', '410600', '鹤壁市', '410000');
INSERT INTO `xyb_city` VALUES ('161', '410700', '新乡市', '410000');
INSERT INTO `xyb_city` VALUES ('162', '410800', '焦作市', '410000');
INSERT INTO `xyb_city` VALUES ('163', '410900', '濮阳市', '410000');
INSERT INTO `xyb_city` VALUES ('164', '411000', '许昌市', '410000');
INSERT INTO `xyb_city` VALUES ('165', '411100', '漯河市', '410000');
INSERT INTO `xyb_city` VALUES ('166', '411200', '三门峡市', '410000');
INSERT INTO `xyb_city` VALUES ('167', '411300', '南阳市', '410000');
INSERT INTO `xyb_city` VALUES ('168', '411400', '商丘市', '410000');
INSERT INTO `xyb_city` VALUES ('169', '411500', '信阳市', '410000');
INSERT INTO `xyb_city` VALUES ('170', '411600', '周口市', '410000');
INSERT INTO `xyb_city` VALUES ('171', '411700', '驻马店市', '410000');
INSERT INTO `xyb_city` VALUES ('172', '420100', '武汉市', '420000');
INSERT INTO `xyb_city` VALUES ('173', '420200', '黄石市', '420000');
INSERT INTO `xyb_city` VALUES ('174', '420300', '十堰市', '420000');
INSERT INTO `xyb_city` VALUES ('175', '420500', '宜昌市', '420000');
INSERT INTO `xyb_city` VALUES ('176', '420600', '襄樊市', '420000');
INSERT INTO `xyb_city` VALUES ('177', '420700', '鄂州市', '420000');
INSERT INTO `xyb_city` VALUES ('178', '420800', '荆门市', '420000');
INSERT INTO `xyb_city` VALUES ('179', '420900', '孝感市', '420000');
INSERT INTO `xyb_city` VALUES ('180', '421000', '荆州市', '420000');
INSERT INTO `xyb_city` VALUES ('181', '421100', '黄冈市', '420000');
INSERT INTO `xyb_city` VALUES ('182', '421200', '咸宁市', '420000');
INSERT INTO `xyb_city` VALUES ('183', '421300', '随州市', '420000');
INSERT INTO `xyb_city` VALUES ('184', '422800', '恩施土家族苗族自治州', '420000');
INSERT INTO `xyb_city` VALUES ('185', '429000', '省直辖行政单位', '420000');
INSERT INTO `xyb_city` VALUES ('186', '430100', '长沙市', '430000');
INSERT INTO `xyb_city` VALUES ('187', '430200', '株洲市', '430000');
INSERT INTO `xyb_city` VALUES ('188', '430300', '湘潭市', '430000');
INSERT INTO `xyb_city` VALUES ('189', '430400', '衡阳市', '430000');
INSERT INTO `xyb_city` VALUES ('190', '430500', '邵阳市', '430000');
INSERT INTO `xyb_city` VALUES ('191', '430600', '岳阳市', '430000');
INSERT INTO `xyb_city` VALUES ('192', '430700', '常德市', '430000');
INSERT INTO `xyb_city` VALUES ('193', '430800', '张家界市', '430000');
INSERT INTO `xyb_city` VALUES ('194', '430900', '益阳市', '430000');
INSERT INTO `xyb_city` VALUES ('195', '431000', '郴州市', '430000');
INSERT INTO `xyb_city` VALUES ('196', '431100', '永州市', '430000');
INSERT INTO `xyb_city` VALUES ('197', '431200', '怀化市', '430000');
INSERT INTO `xyb_city` VALUES ('198', '431300', '娄底市', '430000');
INSERT INTO `xyb_city` VALUES ('199', '433100', '湘西土家族苗族自治州', '430000');
INSERT INTO `xyb_city` VALUES ('200', '440100', '广州市', '440000');
INSERT INTO `xyb_city` VALUES ('201', '440200', '韶关市', '440000');
INSERT INTO `xyb_city` VALUES ('202', '440300', '深圳市', '440000');
INSERT INTO `xyb_city` VALUES ('203', '440400', '珠海市', '440000');
INSERT INTO `xyb_city` VALUES ('204', '440500', '汕头市', '440000');
INSERT INTO `xyb_city` VALUES ('205', '440600', '佛山市', '440000');
INSERT INTO `xyb_city` VALUES ('206', '440700', '江门市', '440000');
INSERT INTO `xyb_city` VALUES ('207', '440800', '湛江市', '440000');
INSERT INTO `xyb_city` VALUES ('208', '440900', '茂名市', '440000');
INSERT INTO `xyb_city` VALUES ('209', '441200', '肇庆市', '440000');
INSERT INTO `xyb_city` VALUES ('210', '441300', '惠州市', '440000');
INSERT INTO `xyb_city` VALUES ('211', '441400', '梅州市', '440000');
INSERT INTO `xyb_city` VALUES ('212', '441500', '汕尾市', '440000');
INSERT INTO `xyb_city` VALUES ('213', '441600', '河源市', '440000');
INSERT INTO `xyb_city` VALUES ('214', '441700', '阳江市', '440000');
INSERT INTO `xyb_city` VALUES ('215', '441800', '清远市', '440000');
INSERT INTO `xyb_city` VALUES ('216', '441900', '东莞市', '440000');
INSERT INTO `xyb_city` VALUES ('217', '442000', '中山市', '440000');
INSERT INTO `xyb_city` VALUES ('218', '445100', '潮州市', '440000');
INSERT INTO `xyb_city` VALUES ('219', '445200', '揭阳市', '440000');
INSERT INTO `xyb_city` VALUES ('220', '445300', '云浮市', '440000');
INSERT INTO `xyb_city` VALUES ('221', '450100', '南宁市', '450000');
INSERT INTO `xyb_city` VALUES ('222', '450200', '柳州市', '450000');
INSERT INTO `xyb_city` VALUES ('223', '450300', '桂林市', '450000');
INSERT INTO `xyb_city` VALUES ('224', '450400', '梧州市', '450000');
INSERT INTO `xyb_city` VALUES ('225', '450500', '北海市', '450000');
INSERT INTO `xyb_city` VALUES ('226', '450600', '防城港市', '450000');
INSERT INTO `xyb_city` VALUES ('227', '450700', '钦州市', '450000');
INSERT INTO `xyb_city` VALUES ('228', '450800', '贵港市', '450000');
INSERT INTO `xyb_city` VALUES ('229', '450900', '玉林市', '450000');
INSERT INTO `xyb_city` VALUES ('230', '451000', '百色市', '450000');
INSERT INTO `xyb_city` VALUES ('231', '451100', '贺州市', '450000');
INSERT INTO `xyb_city` VALUES ('232', '451200', '河池市', '450000');
INSERT INTO `xyb_city` VALUES ('233', '451300', '来宾市', '450000');
INSERT INTO `xyb_city` VALUES ('234', '451400', '崇左市', '450000');
INSERT INTO `xyb_city` VALUES ('235', '460100', '海口市', '460000');
INSERT INTO `xyb_city` VALUES ('236', '460200', '三亚市', '460000');
INSERT INTO `xyb_city` VALUES ('237', '469000', '省直辖县级行政单位', '460000');
INSERT INTO `xyb_city` VALUES ('238', '500100', '重庆市', '500000');
INSERT INTO `xyb_city` VALUES ('239', '5002xx', '重庆下属县', '5000xx');
INSERT INTO `xyb_city` VALUES ('240', '5003xx', '重庆下属市', '5000xx');
INSERT INTO `xyb_city` VALUES ('241', '510100', '成都市', '510000');
INSERT INTO `xyb_city` VALUES ('242', '510300', '自贡市', '510000');
INSERT INTO `xyb_city` VALUES ('243', '510400', '攀枝花市', '510000');
INSERT INTO `xyb_city` VALUES ('244', '510500', '泸州市', '510000');
INSERT INTO `xyb_city` VALUES ('245', '510600', '德阳市', '510000');
INSERT INTO `xyb_city` VALUES ('246', '510700', '绵阳市', '510000');
INSERT INTO `xyb_city` VALUES ('247', '510800', '广元市', '510000');
INSERT INTO `xyb_city` VALUES ('248', '510900', '遂宁市', '510000');
INSERT INTO `xyb_city` VALUES ('249', '511000', '内江市', '510000');
INSERT INTO `xyb_city` VALUES ('250', '511100', '乐山市', '510000');
INSERT INTO `xyb_city` VALUES ('251', '511300', '南充市', '510000');
INSERT INTO `xyb_city` VALUES ('252', '511400', '眉山市', '510000');
INSERT INTO `xyb_city` VALUES ('253', '511500', '宜宾市', '510000');
INSERT INTO `xyb_city` VALUES ('254', '511600', '广安市', '510000');
INSERT INTO `xyb_city` VALUES ('255', '511700', '达州市', '510000');
INSERT INTO `xyb_city` VALUES ('256', '511800', '雅安市', '510000');
INSERT INTO `xyb_city` VALUES ('257', '511900', '巴中市', '510000');
INSERT INTO `xyb_city` VALUES ('258', '512000', '资阳市', '510000');
INSERT INTO `xyb_city` VALUES ('259', '513200', '阿坝藏族羌族自治州', '510000');
INSERT INTO `xyb_city` VALUES ('260', '513300', '甘孜藏族自治州', '510000');
INSERT INTO `xyb_city` VALUES ('261', '513400', '凉山彝族自治州', '510000');
INSERT INTO `xyb_city` VALUES ('262', '520100', '贵阳市', '520000');
INSERT INTO `xyb_city` VALUES ('263', '520200', '六盘水市', '520000');
INSERT INTO `xyb_city` VALUES ('264', '520300', '遵义市', '520000');
INSERT INTO `xyb_city` VALUES ('265', '520400', '安顺市', '520000');
INSERT INTO `xyb_city` VALUES ('266', '522200', '铜仁地区', '520000');
INSERT INTO `xyb_city` VALUES ('267', '522300', '黔西南布依族苗族自治州', '520000');
INSERT INTO `xyb_city` VALUES ('268', '522400', '毕节地区', '520000');
INSERT INTO `xyb_city` VALUES ('269', '522600', '黔东南苗族侗族自治州', '520000');
INSERT INTO `xyb_city` VALUES ('270', '522700', '黔南布依族苗族自治州', '520000');
INSERT INTO `xyb_city` VALUES ('271', '530100', '昆明市', '530000');
INSERT INTO `xyb_city` VALUES ('272', '530300', '曲靖市', '530000');
INSERT INTO `xyb_city` VALUES ('273', '530400', '玉溪市', '530000');
INSERT INTO `xyb_city` VALUES ('274', '530500', '保山市', '530000');
INSERT INTO `xyb_city` VALUES ('275', '530600', '昭通市', '530000');
INSERT INTO `xyb_city` VALUES ('276', '530700', '丽江市', '530000');
INSERT INTO `xyb_city` VALUES ('277', '530800', '思茅市', '530000');
INSERT INTO `xyb_city` VALUES ('278', '530900', '临沧市', '530000');
INSERT INTO `xyb_city` VALUES ('279', '532300', '楚雄彝族自治州', '530000');
INSERT INTO `xyb_city` VALUES ('280', '532500', '红河哈尼族彝族自治州', '530000');
INSERT INTO `xyb_city` VALUES ('281', '532600', '文山壮族苗族自治州', '530000');
INSERT INTO `xyb_city` VALUES ('282', '532800', '西双版纳傣族自治州', '530000');
INSERT INTO `xyb_city` VALUES ('283', '532900', '大理白族自治州', '530000');
INSERT INTO `xyb_city` VALUES ('284', '533100', '德宏傣族景颇族自治州', '530000');
INSERT INTO `xyb_city` VALUES ('285', '533300', '怒江傈僳族自治州', '530000');
INSERT INTO `xyb_city` VALUES ('286', '533400', '迪庆藏族自治州', '530000');
INSERT INTO `xyb_city` VALUES ('287', '540100', '拉萨市', '540000');
INSERT INTO `xyb_city` VALUES ('288', '542100', '昌都地区', '540000');
INSERT INTO `xyb_city` VALUES ('289', '542200', '山南地区', '540000');
INSERT INTO `xyb_city` VALUES ('290', '542300', '日喀则地区', '540000');
INSERT INTO `xyb_city` VALUES ('291', '542400', '那曲地区', '540000');
INSERT INTO `xyb_city` VALUES ('292', '542500', '阿里地区', '540000');
INSERT INTO `xyb_city` VALUES ('293', '542600', '林芝地区', '540000');
INSERT INTO `xyb_city` VALUES ('294', '610100', '西安市', '610000');
INSERT INTO `xyb_city` VALUES ('295', '610200', '铜川市', '610000');
INSERT INTO `xyb_city` VALUES ('296', '610300', '宝鸡市', '610000');
INSERT INTO `xyb_city` VALUES ('297', '610400', '咸阳市', '610000');
INSERT INTO `xyb_city` VALUES ('298', '610500', '渭南市', '610000');
INSERT INTO `xyb_city` VALUES ('299', '610600', '延安市', '610000');
INSERT INTO `xyb_city` VALUES ('300', '610700', '汉中市', '610000');
INSERT INTO `xyb_city` VALUES ('301', '610800', '榆林市', '610000');
INSERT INTO `xyb_city` VALUES ('302', '610900', '安康市', '610000');
INSERT INTO `xyb_city` VALUES ('303', '611000', '商洛市', '610000');
INSERT INTO `xyb_city` VALUES ('304', '620100', '兰州市', '620000');
INSERT INTO `xyb_city` VALUES ('305', '620200', '嘉峪关市', '620000');
INSERT INTO `xyb_city` VALUES ('306', '620300', '金昌市', '620000');
INSERT INTO `xyb_city` VALUES ('307', '620400', '白银市', '620000');
INSERT INTO `xyb_city` VALUES ('308', '620500', '天水市', '620000');
INSERT INTO `xyb_city` VALUES ('309', '620600', '武威市', '620000');
INSERT INTO `xyb_city` VALUES ('310', '620700', '张掖市', '620000');
INSERT INTO `xyb_city` VALUES ('311', '620800', '平凉市', '620000');
INSERT INTO `xyb_city` VALUES ('312', '620900', '酒泉市', '620000');
INSERT INTO `xyb_city` VALUES ('313', '621000', '庆阳市', '620000');
INSERT INTO `xyb_city` VALUES ('314', '621100', '定西市', '620000');
INSERT INTO `xyb_city` VALUES ('315', '621200', '陇南市', '620000');
INSERT INTO `xyb_city` VALUES ('316', '622900', '临夏回族自治州', '620000');
INSERT INTO `xyb_city` VALUES ('317', '623000', '甘南藏族自治州', '620000');
INSERT INTO `xyb_city` VALUES ('318', '630100', '西宁市', '630000');
INSERT INTO `xyb_city` VALUES ('319', '632100', '海东地区', '630000');
INSERT INTO `xyb_city` VALUES ('320', '632200', '海北藏族自治州', '630000');
INSERT INTO `xyb_city` VALUES ('321', '632300', '黄南藏族自治州', '630000');
INSERT INTO `xyb_city` VALUES ('322', '632500', '海南藏族自治州', '630000');
INSERT INTO `xyb_city` VALUES ('323', '632600', '果洛藏族自治州', '630000');
INSERT INTO `xyb_city` VALUES ('324', '632700', '玉树藏族自治州', '630000');
INSERT INTO `xyb_city` VALUES ('325', '632800', '海西蒙古族藏族自治州', '630000');
INSERT INTO `xyb_city` VALUES ('326', '640100', '银川市', '640000');
INSERT INTO `xyb_city` VALUES ('327', '640200', '石嘴山市', '640000');
INSERT INTO `xyb_city` VALUES ('328', '640300', '吴忠市', '640000');
INSERT INTO `xyb_city` VALUES ('329', '640400', '固原市', '640000');
INSERT INTO `xyb_city` VALUES ('330', '640500', '中卫市', '640000');
INSERT INTO `xyb_city` VALUES ('331', '650100', '乌鲁木齐市', '650000');
INSERT INTO `xyb_city` VALUES ('332', '650200', '克拉玛依市', '650000');
INSERT INTO `xyb_city` VALUES ('333', '652100', '吐鲁番地区', '650000');
INSERT INTO `xyb_city` VALUES ('334', '652200', '哈密地区', '650000');
INSERT INTO `xyb_city` VALUES ('335', '652300', '昌吉回族自治州', '650000');
INSERT INTO `xyb_city` VALUES ('336', '652700', '博尔塔拉蒙古自治州', '650000');
INSERT INTO `xyb_city` VALUES ('337', '652800', '巴音郭楞蒙古自治州', '650000');
INSERT INTO `xyb_city` VALUES ('338', '652900', '阿克苏地区', '650000');
INSERT INTO `xyb_city` VALUES ('339', '653000', '克孜勒苏柯尔克孜自治州', '650000');
INSERT INTO `xyb_city` VALUES ('340', '653100', '喀什地区', '650000');
INSERT INTO `xyb_city` VALUES ('341', '653200', '和田地区', '650000');
INSERT INTO `xyb_city` VALUES ('342', '654000', '伊犁哈萨克自治州', '650000');
INSERT INTO `xyb_city` VALUES ('343', '654200', '塔城地区', '650000');
INSERT INTO `xyb_city` VALUES ('344', '654300', '阿勒泰地区', '650000');
INSERT INTO `xyb_city` VALUES ('345', '659000', '省直辖行政单位', '650000');

-- ----------------------------
-- Table structure for xyb_coin_money_select
-- ----------------------------
DROP TABLE IF EXISTS `xyb_coin_money_select`;
CREATE TABLE `xyb_coin_money_select` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `coins_num` int(11) NOT NULL DEFAULT '0' COMMENT '金币数量',
  `money` int(11) NOT NULL DEFAULT '0' COMMENT '金额',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_coin_money_select
-- ----------------------------
INSERT INTO `xyb_coin_money_select` VALUES ('1', '5', '10');
INSERT INTO `xyb_coin_money_select` VALUES ('2', '20', '30');
INSERT INTO `xyb_coin_money_select` VALUES ('3', '50', '100');
INSERT INTO `xyb_coin_money_select` VALUES ('4', '100', '200');
INSERT INTO `xyb_coin_money_select` VALUES ('5', '500', '500');

-- ----------------------------
-- Table structure for xyb_company
-- ----------------------------
DROP TABLE IF EXISTS `xyb_company`;
CREATE TABLE `xyb_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(30) NOT NULL COMMENT '公司名称',
  `province` int(11) NOT NULL DEFAULT '0' COMMENT '省份代码',
  `city` int(11) NOT NULL DEFAULT '0' COMMENT '城市代码',
  `address` varchar(80) NOT NULL COMMENT '详细地址',
  `photos` text NOT NULL COMMENT '店铺照',
  `contact_person` varchar(30) NOT NULL DEFAULT '' COMMENT '联系人',
  `contact_tel` int(11) NOT NULL DEFAULT '0' COMMENT '联系电话',
  `zz_img` varchar(70) DEFAULT NULL COMMENT '营业执照',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '提交时间',
  `status` char(1) NOT NULL DEFAULT '0' COMMENT '0未审核，已审核',
  `select_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1-我要招聘 2-店铺(房)交易 3-二手车',
  `open_time` varchar(30) NOT NULL DEFAULT '0' COMMENT '营业时间描述',
  PRIMARY KEY (`id`),
  KEY `provice` (`province`) USING BTREE,
  KEY `city` (`city`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `to_type` (`select_type`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_company
-- ----------------------------

-- ----------------------------
-- Table structure for xyb_company_publish_record
-- ----------------------------
DROP TABLE IF EXISTS `xyb_company_publish_record`;
CREATE TABLE `xyb_company_publish_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(30) NOT NULL DEFAULT '' COMMENT '公司名称',
  `work_address` varchar(30) NOT NULL DEFAULT '' COMMENT '工作地址',
  `num` int(11) NOT NULL DEFAULT '0' COMMENT '发布次数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_company_publish_record
-- ----------------------------

-- ----------------------------
-- Table structure for xyb_look_recruit_record
-- ----------------------------
DROP TABLE IF EXISTS `xyb_look_recruit_record`;
CREATE TABLE `xyb_look_recruit_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '查看用户的id',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `usj_id` int(11) NOT NULL DEFAULT '0' COMMENT '求职者简历表中的id',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `usj_id` (`usj_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_look_recruit_record
-- ----------------------------

-- ----------------------------
-- Table structure for xyb_look_resume_record
-- ----------------------------
DROP TABLE IF EXISTS `xyb_look_resume_record`;
CREATE TABLE `xyb_look_resume_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '查看用户的id',
  `coins` int(11) NOT NULL DEFAULT '0' COMMENT '金币',
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '求职者user_seek_job发布简历的id',
  `content` varchar(30) NOT NULL COMMENT '操作内容',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_look_resume_record
-- ----------------------------

-- ----------------------------
-- Table structure for xyb_member_day
-- ----------------------------
DROP TABLE IF EXISTS `xyb_member_day`;
CREATE TABLE `xyb_member_day` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '名称',
  `day` int(11) NOT NULL DEFAULT '0' COMMENT '天数',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_member_day
-- ----------------------------
INSERT INTO `xyb_member_day` VALUES ('1', '月度会员', '30');
INSERT INTO `xyb_member_day` VALUES ('2', '季度会员', '90');
INSERT INTO `xyb_member_day` VALUES ('3', '半年会员', '180');
INSERT INTO `xyb_member_day` VALUES ('4', '一年会员', '360');

-- ----------------------------
-- Table structure for xyb_order
-- ----------------------------
DROP TABLE IF EXISTS `xyb_order`;
CREATE TABLE `xyb_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `order_number` varchar(60) NOT NULL DEFAULT '0' COMMENT '订单编号',
  `money` int(11) NOT NULL DEFAULT '0' COMMENT '订单金额',
  `status` char(1) NOT NULL DEFAULT '0' COMMENT '0待支付,1已支付',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `done_time` int(11) NOT NULL DEFAULT '0' COMMENT '完成时间',
  `select_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1招聘者 2商铺租赁 3二手车',
  `member_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '充值用户类型',
  `is_merchant` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1商户 2用户',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `status` (`status`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_order
-- ----------------------------

-- ----------------------------
-- Table structure for xyb_person
-- ----------------------------
DROP TABLE IF EXISTS `xyb_person`;
CREATE TABLE `xyb_person` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `contact_person` varchar(30) NOT NULL COMMENT '联系人',
  `contact_tel` int(11) NOT NULL DEFAULT '0' COMMENT '联系电弧',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `status` char(1) NOT NULL DEFAULT '0' COMMENT '0未审核,1已审核',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_person
-- ----------------------------

-- ----------------------------
-- Table structure for xyb_province
-- ----------------------------
DROP TABLE IF EXISTS `xyb_province`;
CREATE TABLE `xyb_province` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(10) NOT NULL DEFAULT '',
  `name` varchar(30) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=InnoDB AUTO_INCREMENT=35 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_province
-- ----------------------------
INSERT INTO `xyb_province` VALUES ('1', '110000', '北京市');
INSERT INTO `xyb_province` VALUES ('2', '120000', '天津市');
INSERT INTO `xyb_province` VALUES ('3', '130000', '河北省');
INSERT INTO `xyb_province` VALUES ('4', '140000', '山西省');
INSERT INTO `xyb_province` VALUES ('5', '150000', '内蒙古自治区');
INSERT INTO `xyb_province` VALUES ('6', '210000', '辽宁省');
INSERT INTO `xyb_province` VALUES ('7', '220000', '吉林省');
INSERT INTO `xyb_province` VALUES ('8', '230000', '黑龙江省');
INSERT INTO `xyb_province` VALUES ('9', '310000', '上海市');
INSERT INTO `xyb_province` VALUES ('10', '320000', '江苏省');
INSERT INTO `xyb_province` VALUES ('11', '330000', '浙江省');
INSERT INTO `xyb_province` VALUES ('12', '340000', '安徽省');
INSERT INTO `xyb_province` VALUES ('13', '350000', '福建省');
INSERT INTO `xyb_province` VALUES ('14', '360000', '江西省');
INSERT INTO `xyb_province` VALUES ('15', '370000', '山东省');
INSERT INTO `xyb_province` VALUES ('16', '410000', '河南省');
INSERT INTO `xyb_province` VALUES ('17', '420000', '湖北省');
INSERT INTO `xyb_province` VALUES ('18', '430000', '湖南省');
INSERT INTO `xyb_province` VALUES ('19', '440000', '广东省');
INSERT INTO `xyb_province` VALUES ('20', '450000', '广西壮族自治区');
INSERT INTO `xyb_province` VALUES ('21', '460000', '海南省');
INSERT INTO `xyb_province` VALUES ('22', '500000', '重庆市');
INSERT INTO `xyb_province` VALUES ('23', '510000', '四川省');
INSERT INTO `xyb_province` VALUES ('24', '520000', '贵州省');
INSERT INTO `xyb_province` VALUES ('25', '530000', '云南省');
INSERT INTO `xyb_province` VALUES ('26', '540000', '西藏自治区');
INSERT INTO `xyb_province` VALUES ('27', '610000', '陕西省');
INSERT INTO `xyb_province` VALUES ('28', '620000', '甘肃省');
INSERT INTO `xyb_province` VALUES ('29', '630000', '青海省');
INSERT INTO `xyb_province` VALUES ('30', '640000', '宁夏回族自治区');
INSERT INTO `xyb_province` VALUES ('31', '650000', '新疆维吾尔自治区');
INSERT INTO `xyb_province` VALUES ('32', '710000', '台湾省');
INSERT INTO `xyb_province` VALUES ('33', '810000', '香港特别行政区');
INSERT INTO `xyb_province` VALUES ('34', '820000', '澳门特别行政区');

-- ----------------------------
-- Table structure for xyb_recruit_company
-- ----------------------------
DROP TABLE IF EXISTS `xyb_recruit_company`;
CREATE TABLE `xyb_recruit_company` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `company_name` varchar(40) NOT NULL DEFAULT '' COMMENT '公司名称',
  `seek_job` varchar(30) NOT NULL DEFAULT '' COMMENT '招聘岗位',
  `work_time` varchar(30) NOT NULL DEFAULT '',
  `work_address` varchar(80) NOT NULL DEFAULT '' COMMENT '工作地址',
  `demand_num` tinyint(4) NOT NULL DEFAULT '0' COMMENT '需求人数',
  `salary_rand` varchar(30) NOT NULL DEFAULT '' COMMENT '薪资范围',
  `salary_type` varchar(20) NOT NULL DEFAULT '' COMMENT '薪资结算时间',
  `work_detail` text NOT NULL COMMENT '工作详情',
  `work_pic` varchar(255) NOT NULL DEFAULT '' COMMENT '工作图片',
  `contact_user` varchar(30) NOT NULL DEFAULT '' COMMENT '联系人',
  `tel` int(11) NOT NULL DEFAULT '0' COMMENT '联系电话',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '1发布中，0已关闭',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '发布人',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_recruit_company
-- ----------------------------

-- ----------------------------
-- Table structure for xyb_recruit_pic
-- ----------------------------
DROP TABLE IF EXISTS `xyb_recruit_pic`;
CREATE TABLE `xyb_recruit_pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` tinyint(4) NOT NULL DEFAULT '0' COMMENT '数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_recruit_pic
-- ----------------------------

-- ----------------------------
-- Table structure for xyb_role
-- ----------------------------
DROP TABLE IF EXISTS `xyb_role`;
CREATE TABLE `xyb_role` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父角色ID',
  `status` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '状态;0:禁用;1:正常',
  `create_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '创建时间',
  `update_time` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',
  `list_order` float NOT NULL DEFAULT '0' COMMENT '排序',
  `name` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '角色名称',
  `remark` varchar(255) NOT NULL DEFAULT '' COMMENT '备注',
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `status` (`status`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COMMENT='角色表';

-- ----------------------------
-- Records of xyb_role
-- ----------------------------
INSERT INTO `xyb_role` VALUES ('1', '0', '1', '1562828141', '1562828141', '0', '超级管理员', '超级管理员拥有做高权限');
INSERT INTO `xyb_role` VALUES ('2', '0', '1', '1562837129', '1562837129', '0', '任课教师', '任教某堂课');

-- ----------------------------
-- Table structure for xyb_role_user
-- ----------------------------
DROP TABLE IF EXISTS `xyb_role_user`;
CREATE TABLE `xyb_role_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `role_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '角色 id',
  `user_id` bigint(20) unsigned NOT NULL DEFAULT '0' COMMENT '用户id',
  PRIMARY KEY (`id`),
  KEY `role_id` (`role_id`),
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COMMENT='用户角色对应表';

-- ----------------------------
-- Records of xyb_role_user
-- ----------------------------
INSERT INTO `xyb_role_user` VALUES ('1', '2', '2');
INSERT INTO `xyb_role_user` VALUES ('2', '2', '3');

-- ----------------------------
-- Table structure for xyb_seeker_pull_black
-- ----------------------------
DROP TABLE IF EXISTS `xyb_seeker_pull_black`;
CREATE TABLE `xyb_seeker_pull_black` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rc_id` int(11) NOT NULL DEFAULT '0' COMMENT '求职者拉黑商户表id',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '拉黑时间',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作人id',
  PRIMARY KEY (`id`),
  KEY `rc_id` (`rc_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_seeker_pull_black
-- ----------------------------

-- ----------------------------
-- Table structure for xyb_select_salary
-- ----------------------------
DROP TABLE IF EXISTS `xyb_select_salary`;
CREATE TABLE `xyb_select_salary` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_select_salary
-- ----------------------------
INSERT INTO `xyb_select_salary` VALUES ('1', '1K以下');
INSERT INTO `xyb_select_salary` VALUES ('2', '1K-2K');
INSERT INTO `xyb_select_salary` VALUES ('3', '2K-4K');
INSERT INTO `xyb_select_salary` VALUES ('4', '4K-6K');
INSERT INTO `xyb_select_salary` VALUES ('5', '6K-8K');
INSERT INTO `xyb_select_salary` VALUES ('6', '8K-10K');
INSERT INTO `xyb_select_salary` VALUES ('7', '10K-15K');
INSERT INTO `xyb_select_salary` VALUES ('8', '15K-25K');
INSERT INTO `xyb_select_salary` VALUES ('9', '25K-35K');
INSERT INTO `xyb_select_salary` VALUES ('10', '35K-50K');
INSERT INTO `xyb_select_salary` VALUES ('11', '50K-70K');
INSERT INTO `xyb_select_salary` VALUES ('12', '70K-100K');
INSERT INTO `xyb_select_salary` VALUES ('13', '100K以上');
INSERT INTO `xyb_select_salary` VALUES ('14', '不限');

-- ----------------------------
-- Table structure for xyb_select_salary_time
-- ----------------------------
DROP TABLE IF EXISTS `xyb_select_salary_time`;
CREATE TABLE `xyb_select_salary_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_select_salary_time
-- ----------------------------
INSERT INTO `xyb_select_salary_time` VALUES ('1', '月结');
INSERT INTO `xyb_select_salary_time` VALUES ('2', '日结');
INSERT INTO `xyb_select_salary_time` VALUES ('3', '周结');
INSERT INTO `xyb_select_salary_time` VALUES ('4', '小时结');

-- ----------------------------
-- Table structure for xyb_select_work_time
-- ----------------------------
DROP TABLE IF EXISTS `xyb_select_work_time`;
CREATE TABLE `xyb_select_work_time` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '工作时间',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_select_work_time
-- ----------------------------
INSERT INTO `xyb_select_work_time` VALUES ('1', '周一至周五');
INSERT INTO `xyb_select_work_time` VALUES ('2', '周一至周六');

-- ----------------------------
-- Table structure for xyb_shop_cat
-- ----------------------------
DROP TABLE IF EXISTS `xyb_shop_cat`;
CREATE TABLE `xyb_shop_cat` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(20) NOT NULL DEFAULT '' COMMENT '名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_shop_cat
-- ----------------------------
INSERT INTO `xyb_shop_cat` VALUES ('1', '出售');
INSERT INTO `xyb_shop_cat` VALUES ('2', '转租');
INSERT INTO `xyb_shop_cat` VALUES ('3', '出租');

-- ----------------------------
-- Table structure for xyb_shop_info
-- ----------------------------
DROP TABLE IF EXISTS `xyb_shop_info`;
CREATE TABLE `xyb_shop_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `province` int(11) NOT NULL,
  `city` int(11) NOT NULL,
  `address` varchar(40) NOT NULL DEFAULT '' COMMENT '详细地址',
  `cat_id` tinyint(4) NOT NULL DEFAULT '0' COMMENT '类型',
  `contact_user` varchar(20) NOT NULL DEFAULT '' COMMENT '联系人',
  `contact_tel` int(11) NOT NULL DEFAULT '0' COMMENT '联系电话',
  `price` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '价格',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `shop_mj` varchar(20) NOT NULL DEFAULT '' COMMENT '店铺面积',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '0关闭，1发布中',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `close_time` int(11) NOT NULL DEFAULT '0' COMMENT '关闭时间',
  PRIMARY KEY (`id`),
  KEY `province` (`province`) USING BTREE,
  KEY `city` (`city`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_shop_info
-- ----------------------------

-- ----------------------------
-- Table structure for xyb_shop_pic
-- ----------------------------
DROP TABLE IF EXISTS `xyb_shop_pic`;
CREATE TABLE `xyb_shop_pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` tinyint(4) NOT NULL DEFAULT '0' COMMENT '数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_shop_pic
-- ----------------------------
INSERT INTO `xyb_shop_pic` VALUES ('1', '3');

-- ----------------------------
-- Table structure for xyb_sh_post_message
-- ----------------------------
DROP TABLE IF EXISTS `xyb_sh_post_message`;
CREATE TABLE `xyb_sh_post_message` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '商户id',
  `seek_user_id` int(11) NOT NULL DEFAULT '0' COMMENT '求职者id',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '发送时间',
  `status` char(1) NOT NULL DEFAULT '0' COMMENT '0未读，1已读',
  `content` varchar(100) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_sh_post_message
-- ----------------------------

-- ----------------------------
-- Table structure for xyb_sh_pull_black
-- ----------------------------
DROP TABLE IF EXISTS `xyb_sh_pull_black`;
CREATE TABLE `xyb_sh_pull_black` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `usj_id` int(11) NOT NULL DEFAULT '0' COMMENT '商户拉黑求职者表中的id',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '拉黑时间',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '操作id',
  `user_seek_id` int(11) NOT NULL DEFAULT '0' COMMENT '求职者ID',
  PRIMARY KEY (`id`),
  KEY `usj_id` (`usj_id`) USING BTREE,
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_sh_pull_black
-- ----------------------------

-- ----------------------------
-- Table structure for xyb_super_member_record
-- ----------------------------
DROP TABLE IF EXISTS `xyb_super_member_record`;
CREATE TABLE `xyb_super_member_record` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1招聘，2商铺,3二手车',
  `coins` int(11) NOT NULL DEFAULT '0' COMMENT '充值金额',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `member_day` tinyint(4) NOT NULL DEFAULT '0' COMMENT '会员天数',
  `surplus_member_day` tinyint(4) NOT NULL DEFAULT '0' COMMENT '剩余会员天数',
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '会员ID',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  KEY `type` (`type`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_super_member_record
-- ----------------------------

-- ----------------------------
-- Table structure for xyb_user
-- ----------------------------
DROP TABLE IF EXISTS `xyb_user`;
CREATE TABLE `xyb_user` (
  `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT,
  `sex` tinyint(2) NOT NULL DEFAULT '0' COMMENT '性别;0:保密,1:男,2:女',
  `last_login_time` int(11) NOT NULL DEFAULT '0' COMMENT '最后登录时间',
  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '注册时间',
  `user_status` tinyint(3) unsigned NOT NULL DEFAULT '1' COMMENT '1在职，0离职',
  `user_login` varchar(60) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '用户名',
  `user_pass` varchar(64) NOT NULL DEFAULT '' COMMENT '登录密码;cmf_password加密',
  `mobile` varchar(20) NOT NULL DEFAULT '' COMMENT '用户手机号',
  PRIMARY KEY (`id`),
  KEY `user_login` (`user_login`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4 COMMENT='用户表';

-- ----------------------------
-- Records of xyb_user
-- ----------------------------
INSERT INTO `xyb_user` VALUES ('1', '0', '1563861775', '1562552887', '1', 'admin', '00e0678b1678a8c2a597a4935e1a180d', '');
INSERT INTO `xyb_user` VALUES ('2', '1', '1562917266', '1562837322', '1', 'dkd', '00e0678b1678a8c2a597a4935e1a180d', '18382426150');
INSERT INTO `xyb_user` VALUES ('3', '1', '1562917376', '1562917356', '1', '123', '00e0678b1678a8c2a597a4935e1a180d', '18259662301');

-- ----------------------------
-- Table structure for xyb_users
-- ----------------------------
DROP TABLE IF EXISTS `xyb_users`;
CREATE TABLE `xyb_users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `mobile` varchar(30) NOT NULL COMMENT '手机号',
  `tj_code` int(11) NOT NULL DEFAULT '0' COMMENT '推荐人的推荐码',
  `type` char(1) NOT NULL DEFAULT '0' COMMENT '1商家，2普通用户',
  `passwd` varchar(50) NOT NULL DEFAULT '0' COMMENT '密码',
  `is_company` tinyint(2) NOT NULL DEFAULT '0' COMMENT '1公司,2个人',
  `coins` int(11) NOT NULL DEFAULT '0' COMMENT '金币',
  `user_nickname` varchar(30) NOT NULL COMMENT '用户昵称',
  `avater` varchar(255) NOT NULL COMMENT '头像',
  `sh_super_member` char(1) NOT NULL DEFAULT '0' COMMENT '1商户超级会员，0商户普通',
  `openid` varchar(60) NOT NULL DEFAULT '' COMMENT '用户openid',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `sh_super_day` int(11) NOT NULL DEFAULT '0' COMMENT '商户超级会员天数',
  `user_super_member` char(1) NOT NULL DEFAULT '0' COMMENT '1普通用户超级会员，0普通用户',
  `user_super_day` int(11) NOT NULL DEFAULT '0' COMMENT '普通用户超级会员天数',
  `now_select_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1-招聘者，2-商铺租赁，3-二手车',
  `sex` char(1) NOT NULL DEFAULT '0' COMMENT '1男 2女',
  PRIMARY KEY (`id`),
  KEY `mobile` (`mobile`) USING BTREE,
  KEY `openid` (`openid`) USING BTREE,
  KEY `tj_code` (`tj_code`) USING BTREE
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_users
-- ----------------------------
INSERT INTO `xyb_users` VALUES ('1', '1838555555555', '1', '1', '0', '2', '0', '', '', '0', '', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for xyb_user_consume_fee_detail
-- ----------------------------
DROP TABLE IF EXISTS `xyb_user_consume_fee_detail`;
CREATE TABLE `xyb_user_consume_fee_detail` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `content` varchar(30) NOT NULL DEFAULT '' COMMENT '内容',
  `select_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1招聘者 2商户租赁 3二手车',
  `is_merchant` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1商户 2用户',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '添加时间',
  `member_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '会员类型',
  `coins` varchar(10) NOT NULL DEFAULT '' COMMENT '金额',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_user_consume_fee_detail
-- ----------------------------

-- ----------------------------
-- Table structure for xyb_user_seek_job
-- ----------------------------
DROP TABLE IF EXISTS `xyb_user_seek_job`;
CREATE TABLE `xyb_user_seek_job` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL COMMENT '求职者id',
  `user_name` varchar(50) NOT NULL COMMENT '用户名',
  `age` int(11) NOT NULL DEFAULT '0' COMMENT '年龄',
  `job_name` varchar(30) NOT NULL COMMENT '求职岗位',
  `tel` int(11) NOT NULL DEFAULT '0' COMMENT '联系电话',
  `email` varchar(30) NOT NULL DEFAULT '0' COMMENT '邮箱',
  `work_position` varchar(50) NOT NULL COMMENT '期望工作地点',
  `work_salary` varchar(30) NOT NULL COMMENT '期望薪资',
  `entry_time` varchar(30) NOT NULL COMMENT '入职时间',
  `self_pj` text NOT NULL COMMENT '自我评价',
  `work_content` text NOT NULL COMMENT '工作内容',
  `jz_time` varchar(30) NOT NULL DEFAULT '0' COMMENT '就职时间',
  `jz_company` varchar(30) NOT NULL DEFAULT '0' COMMENT '就职公司',
  `jz_gw` varchar(30) NOT NULL DEFAULT '' COMMENT '就职岗位',
  `add_time` int(11) NOT NULL DEFAULT '0' COMMENT '发布时间',
  `status` char(1) NOT NULL DEFAULT '1' COMMENT '1发布,0隐藏',
  `province` int(11) NOT NULL DEFAULT '0' COMMENT '省份ID',
  `city` int(11) NOT NULL DEFAULT '0' COMMENT '城市ID',
  `gw_id` int(11) NOT NULL DEFAULT '0' COMMENT '岗位id',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_user_seek_job
-- ----------------------------

-- ----------------------------
-- Table structure for xyb_user_type_info
-- ----------------------------
DROP TABLE IF EXISTS `xyb_user_type_info`;
CREATE TABLE `xyb_user_type_info` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户id',
  `is_deal` char(1) NOT NULL DEFAULT '0' COMMENT '0信息未完善,1已完善',
  `select_type` tinyint(4) NOT NULL DEFAULT '0' COMMENT '1招聘者身份，2商铺身份，3二手车身份',
  `type` char(1) NOT NULL DEFAULT '0' COMMENT '1商家 2普通用户',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_user_type_info
-- ----------------------------

-- ----------------------------
-- Table structure for xyb_zz_pic
-- ----------------------------
DROP TABLE IF EXISTS `xyb_zz_pic`;
CREATE TABLE `xyb_zz_pic` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `num` tinyint(4) NOT NULL DEFAULT '0' COMMENT '数量',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_zz_pic
-- ----------------------------
