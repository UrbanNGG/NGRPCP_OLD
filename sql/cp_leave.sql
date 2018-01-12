-- ----------------------------
-- Table structure for `cp_leave`
-- ----------------------------
DROP TABLE IF EXISTS `cp_leave`;
CREATE TABLE `cp_leave` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `date_leave` date DEFAULT NULL,
  `date_return` date DEFAULT NULL,
  `reason` varchar(1024) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `acceptedby_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;