/*
Navicat MariaDB Data Transfer

Source Server         : Devop
Source Server Version : 100124
Source Host           : 10.0.10.43:3306
Source Database       : wd4_demo_2

Target Server Type    : MariaDB
Target Server Version : 100124
File Encoding         : 65001

Date: 2018-01-31 12:58:37
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `last_name` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `user_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `is_enabled` int(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `enabled` (`is_enabled`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES ('1', 'Administrator', '', 'admin', '1');
INSERT INTO `users` VALUES ('2', 'John', 'Smith', 'john', '1');
INSERT INTO `users` VALUES ('3', 'Steven', 'Doe', 'Steven', '1');
INSERT INTO `users` VALUES ('4', 'Kostas', 'Petridis', 'Kostas', '1');
INSERT INTO `users` VALUES ('5', 'George', 'King', 'George', '1');
INSERT INTO `users` VALUES ('6', 'Mary', '', 'Maria', '1');
INSERT INTO `users` VALUES ('7', 'Nick', 'Georgiou', 'Nick', '0');
INSERT INTO `users` VALUES ('8', 'Eleni', 'Vikou', 'Eleni', '1');
INSERT INTO `users` VALUES ('9', 'Dmitris', 'Athanasiou', 'dimitris', '1');
INSERT INTO `users` VALUES ('10', 'Vaggelis', 'Vakouftsis', 'vaggelis', '0');
INSERT INTO `users` VALUES ('11', 'Sofia', 'Kanavou', 'Sofia', '0');
INSERT INTO `users` VALUES ('12', 'Petros', 'Takirtzis', 'petros', '1');
