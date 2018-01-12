<?php
require('SQL.php');

mysql_query("UPDATE `accounts` SET `DonateRank` = 0, `VIPExpire` = 0 WHERE (`DonateRank` BETWEEN 1 AND 3) AND `VIPExpire` > 0 AND `VIPExpire` < Unix_Timestamp() AND `AdminLevel` < 2");
mysql_query("DELETE FROM `cp_whitelist` WHERE `date` < NOW() - INTERVAL 1 HOUR");
?>