<?php
require('SQL.php');

mysql_query("DELETE FROM `login_strikes` WHERE `date` < NOW() - INTERVAL 15 MINUTE ORDER BY `date` ASC");
?>