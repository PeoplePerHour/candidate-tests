/*
 Navicat Premium Data Transfer

 Source Server         : TouthostLocal
 Source Server Type    : MariaDB
 Source Server Version : 100212
 Source Host           : localhost:3306
 Source Schema         : PPHDemo

 Target Server Type    : MariaDB
 Target Server Version : 100212
 File Encoding         : 65001

 Date: 29/01/2018 18:51:56
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `last_name` varchar(255) CHARACTER SET utf8 NOT NULL DEFAULT '',
  `user_name` varchar(255) CHARACTER SET utf8 NOT NULL,
  `password` varchar(255) CHARACTER SET utf8 NOT NULL,
  `email` varchar(255) CHARACTER SET utf8 NOT NULL,
  `is_enabled` int(1) NOT NULL DEFAULT 0,
  `in_backend` int(1) NOT NULL DEFAULT 0,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `enabled` (`is_enabled`),
  KEY `access_backend` (`in_backend`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (1, 'Administrator', '', 'admin', '$2y$10$5/wVuS88izNDx9xodtQwkebbBQ/V4korq.yJKem5fV0BVmK.QDgnu', 'admin@mail.com', 1, 1);
INSERT INTO `users` VALUES (2, 'John', 'Smith', 'john', '$2y$10$etfj1NNYlQvpd9fcC2gUqecVDOhshM8M5kCF9mOJWUnj.iuqFhHdW', 'joh@mail.com', 1, 1);
INSERT INTO `users` VALUES (3, 'Steven', 'Doe', 'Steven', '$2y$10$AlJQvDI18Uo34xDKAuLYzOvvfEjXfk9p5653Rvcd/CdW8c0/e7.Sa', 'steven@mail.com', 1, 1);
INSERT INTO `users` VALUES (4, 'Kostas', 'Petridis', 'Kostas', '$2y$10$4TL48Mx9TlW3xrS6nmSRke5/ZuMlN0YLoXkNqDsUBUtrNA2CvDhhS', 'kostas@mail.com', 1, 0);
INSERT INTO `users` VALUES (5, 'George', 'King', 'George', '$2y$10$D583vfeXPhcLZNNechHu8OKrIDQyLPWRUvjxOx9SSED5m615FMYme', 'george@mail.com', 1, 1);
INSERT INTO `users` VALUES (6, 'Mary', '', 'Maria', '$2y$10$w2HtYelEHZ8n.vC2u/CaxuIqm204XznOHcMQrkd.F8ptYrtWm0ZMG', 'maria@mail.com', 1, 0);
INSERT INTO `users` VALUES (7, 'Nick', 'Georgiou', 'Nick', '$2y$10$gjYViPu2K.bhuh.Jg8NvYu3kw559E7mGO4SbLrKK0EJ40oWW20ARq', 'nick@mail.com', 1, 1);
INSERT INTO `users` VALUES (8, 'Eleni', 'Vikou', 'Eleni', '$2y$10$.DHztfdtRQrummVc8X6qn.aX9hvq4G6msiG.OqHVSnSAIxc/b2deO', 'eleni@mail.com', 1, 1);
INSERT INTO `users` VALUES (9, 'Dmitris', 'Athanasiou', 'dimitris', '$2y$10$/YGAdMd4YAtzqypWDjH4AOiP4XpNanB5j65OXoHLh76sBSlsxws5e', 'dimitris@mail.com', 1, 1);
INSERT INTO `users` VALUES (10, 'Vaggelis', 'Vakouftsis', 'vaggelis', '$2y$10$bKiieYG2PdImCy4gpYuCGOtqrrcUb5WYU2quS/8zHoOQv2SdE1zWS', 'vaggelis@mail.com', 0, 1);
INSERT INTO `users` VALUES (11, 'Sofia', 'Kanavou', 'Sofia', '$2y$10$lsbVUs3Ict7iqkW7.3ckDeKi95qlwWcVJrEp4U7cnltrKgtZxEZ.2', 'sofia@mail.com', 0, 0);
INSERT INTO `users` VALUES (12, 'Petros', 'Takirtzis', 'petros', '$2y$10$AeVhsVt3ujJa8WTBtU4D9OWxmMqt34q/KHF5m9libadlIgkX2oX3e', 'petros@mail.com', 0, 0);
INSERT INTO `users` VALUES (13, 'Eleni', 'Ntinou', 'eleni', '$2y$10$rbGAEaLHEHug09OTXW8fP./A1LCLKHkCfidJz7IXwz.U8s2BwmANO', 'eleni@mail.com', 0, 0);
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
