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
  `created_by` int(11) NOT NULL,
  `created_on` datetime NOT NULL,
  `updated_by` int(11) NOT NULL,
  `updated_on` datetime NOT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  KEY `enabled` (`is_enabled`),
  KEY `access_backend` (`in_backend`),
  KEY `updated_by` (`updated_by`),
  KEY `created_by` (`created_by`)
) ENGINE=InnoDB AUTO_INCREMENT=15 DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
INSERT INTO `users` VALUES (1, 'Administrator', '', 'admin', '$2y$10$5/wVuS88izNDx9xodtQwkebbBQ/V4korq.yJKem5fV0BVmK.QDgnu', 'admin@mail.com', 1, 1, 1, '2018-01-24 09:06:59', 1, '2018-01-25 14:18:50');
INSERT INTO `users` VALUES (2, 'John', 'Smith', 'john', '$2y$10$etfj1NNYlQvpd9fcC2gUqecVDOhshM8M5kCF9mOJWUnj.iuqFhHdW', 'joh@mail.com', 1, 1, 1, '2018-01-25 14:11:09', 1, '2018-01-26 07:24:40');
INSERT INTO `users` VALUES (3, 'Steven', 'Doe', 'Steven', '$2y$10$AlJQvDI18Uo34xDKAuLYzOvvfEjXfk9p5653Rvcd/CdW8c0/e7.Sa', 'steven@mail.com', 1, 1, 1, '2018-01-25 14:12:24', 1, '2018-01-26 08:11:14');
INSERT INTO `users` VALUES (4, 'Kostas', 'Petridis', 'Kostas', '$2y$10$4TL48Mx9TlW3xrS6nmSRke5/ZuMlN0YLoXkNqDsUBUtrNA2CvDhhS', 'kostas@mail.com', 1, 0, 1, '2018-01-25 14:12:56', 1, '2018-01-25 14:12:56');
INSERT INTO `users` VALUES (5, 'George', 'King', 'George', '$2y$10$D583vfeXPhcLZNNechHu8OKrIDQyLPWRUvjxOx9SSED5m615FMYme', 'george@mail.com', 1, 1, 1, '2018-01-25 14:14:25', 1, '2018-01-25 14:14:25');
INSERT INTO `users` VALUES (6, 'Mary', '', 'Maria', '$2y$10$w2HtYelEHZ8n.vC2u/CaxuIqm204XznOHcMQrkd.F8ptYrtWm0ZMG', 'maria@mail.com', 1, 0, 1, '2018-01-25 14:15:02', 1, '2018-01-26 09:37:06');
INSERT INTO `users` VALUES (7, 'Nick', 'Georgiou', 'Nick', '$2y$10$gjYViPu2K.bhuh.Jg8NvYu3kw559E7mGO4SbLrKK0EJ40oWW20ARq', 'nick@mail.com', 1, 1, 1, '2018-01-25 14:15:51', 1, '2018-01-26 14:49:37');
INSERT INTO `users` VALUES (8, 'Eleni', 'Vikou', 'Eleni', '$2y$10$.DHztfdtRQrummVc8X6qn.aX9hvq4G6msiG.OqHVSnSAIxc/b2deO', 'eleni@mail.com', 1, 1, 1, '2018-01-25 15:59:30', 1, '2018-01-26 14:40:09');
INSERT INTO `users` VALUES (9, 'Dmitris', 'Athanasiou', 'dimitris', '$2y$10$/YGAdMd4YAtzqypWDjH4AOiP4XpNanB5j65OXoHLh76sBSlsxws5e', 'dimitris@mail.com', 1, 1, 1, '2018-01-26 08:49:37', 1, '2018-01-26 09:31:58');
INSERT INTO `users` VALUES (10, 'Vaggelis', 'Vakouftsis', 'vaggelis', '$2y$10$bKiieYG2PdImCy4gpYuCGOtqrrcUb5WYU2quS/8zHoOQv2SdE1zWS', 'vaggelis@mail.com', 0, 1, 1, '2018-01-26 09:36:18', 1, '2018-01-26 14:44:34');
INSERT INTO `users` VALUES (11, 'Sofia', 'Kanavou', 'Sofia', '$2y$10$lsbVUs3Ict7iqkW7.3ckDeKi95qlwWcVJrEp4U7cnltrKgtZxEZ.2', 'sofia@mail.com', 0, 0, 1, '2018-01-26 14:28:55', 1, '2018-01-26 08:20:08');
INSERT INTO `users` VALUES (12, 'Petros', 'Takirtzis', 'petros', '$2y$10$AeVhsVt3ujJa8WTBtU4D9OWxmMqt34q/KHF5m9libadlIgkX2oX3e', 'petros@mail.com', 0, 0, 1, '2018-01-27 11:35:30', 1, '2018-01-27 11:35:30');
INSERT INTO `users` VALUES (13, 'Eleni', 'Ntinou', 'eleni', '$2y$10$rbGAEaLHEHug09OTXW8fP./A1LCLKHkCfidJz7IXwz.U8s2BwmANO', 'eleni@mail.com', 1, 1, 1, '2018-01-27 11:37:18', 1, '2018-01-27 11:37:18');
INSERT INTO `users` VALUES (14, 'Nikos', 'Athanasiou', 'nikos', '$2y$10$UsJvoIEdda0a4mh5.yQcYew6GUFwUsW.CftmOtPt1BQtNCNU7ck9W', 'nikos2@mail.com', 0, 0, 1, '2018-01-27 11:38:58', 1, '2018-01-27 11:38:58');
COMMIT;

-- ----------------------------
-- Table structure for users_fields
-- ----------------------------
DROP TABLE IF EXISTS `users_fields`;
CREATE TABLE `users_fields` (
  `user_id` int(11) DEFAULT NULL,
  `gender` int(1) DEFAULT 0,
  `description` varchar(255) CHARACTER SET utf8 DEFAULT '',
  `birthdate` date DEFAULT NULL,
  `location` varchar(50) CHARACTER SET utf8 DEFAULT '',
  KEY `user_id` (`user_id`),
  CONSTRAINT `users_fields_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ----------------------------
-- Records of users_fields
-- ----------------------------
BEGIN;
INSERT INTO `users_fields` VALUES (1, 1, 'Desc', '2018-01-26', 'Location');
INSERT INTO `users_fields` VALUES (2, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (2, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (3, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (3, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (4, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (4, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (5, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (5, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (6, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (6, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (7, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (7, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (8, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (8, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (9, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (9, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (10, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (10, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (11, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (12, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (13, 0, '', NULL, '');
INSERT INTO `users_fields` VALUES (14, 0, '', NULL, '');
COMMIT;

SET FOREIGN_KEY_CHECKS = 1;
