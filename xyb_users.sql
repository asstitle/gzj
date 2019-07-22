/*
Navicat MySQL Data Transfer

Source Server         : localhost_3306
Source Server Version : 50714
Source Host           : localhost:3306
Source Database       : xyb

Target Server Type    : MYSQL
Target Server Version : 50714
File Encoding         : 65001

Date: 2019-07-22 17:57:09
*/

SET FOREIGN_KEY_CHECKS=0;

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
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xyb_users
-- ----------------------------
INSERT INTO `xyb_users` VALUES ('1', '1838555555555', '1', '1', '0');
