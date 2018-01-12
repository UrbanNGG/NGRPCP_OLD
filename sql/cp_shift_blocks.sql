-- ----------------------------
-- Table structure for `cp_shift_blocks`
-- ----------------------------
DROP TABLE IF EXISTS `cp_shift_blocks`;
CREATE TABLE `cp_shift_blocks` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `shift` varchar(1) DEFAULT NULL,
  `time_start` time DEFAULT NULL,
  `time_end` time DEFAULT NULL,
  `needs_sunday` int(11) DEFAULT NULL,
  `needs_monday` int(11) DEFAULT NULL,
  `needs_tuesday` int(11) DEFAULT NULL,
  `needs_wednesday` int(11) DEFAULT NULL,
  `needs_thursday` int(11) DEFAULT NULL,
  `needs_friday` int(11) DEFAULT NULL,
  `needs_saturday` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=utf8;