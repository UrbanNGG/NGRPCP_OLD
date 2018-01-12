-- ----------------------------
-- Table structure for `cp_shifts`
-- ----------------------------
DROP TABLE IF EXISTS `cp_shifts`;
CREATE TABLE `cp_shifts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `shift_id` int(11) DEFAULT NULL,
  `date` date DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=68 DEFAULT CHARSET=utf8;