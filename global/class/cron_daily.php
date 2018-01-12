<?php
require('SQL.php');

$banquery = mysql_query("SELECT * FROM `bans` WHERE `status` < 3 AND `date_unban` <= NOW()");
while($ban = mysql_fetch_array($banquery)) {
	mysql_query("UPDATE `accounts` SET `Warnings` = 0, `Band` = 0 WHERE `id` = $ban[user_id]");
	mysql_query("DELETE FROM `ip_bans` WHERE `ip` = '$ban[ip_address]'");
	mysql_query("UPDATE `bans` SET `status` = 4 WHERE `id` = $ban[id]");
}

$refundquery = mysql_query("SELECT `id`, `refund` FROM `cp_refund` WHERE `status` = 1 AND `refund` <> '' AND `date_added` < NOW() - INTERVAL 2 MONTH");
while($refund = mysql_fetch_array($refundquery))
{
	$customrefund = "Refund: ".$refund['refund'];
	mysql_query("UPDATE `cp_refund` SET `status` = 3 WHERE `id` = $refund[id]");
	mysql_query("DELETE FROM `flags` WHERE `flag` = '$customrefund' AND `issuer` = 'CP'");
}
?>