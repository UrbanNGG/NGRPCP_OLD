-- ----------------------------
-- Table structure for `cp_log_general`
-- ----------------------------
DROP TABLE IF EXISTS `cp_log_general`;
CREATE TABLE `cp_log_general` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `date` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `area` varchar(255) DEFAULT NULL,
  `details` varchar(1024) DEFAULT NULL,
  `ip_address` varchar(15) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=330 DEFAULT CHARSET=utf8;