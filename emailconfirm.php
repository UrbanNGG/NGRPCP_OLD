<?php require('./global/func.php');
if(isset($_GET['token']) && isset($_GET['confirm'])) {
$redirect = '<meta http-equiv="refresh" content="0;url=./index.php">';
$query = mysql_query("SELECT * FROM `cp_cache_email` WHERE `token` = '$_GET[token]' AND `user_id` = $inf[id]");
$email = mysql_fetch_array($query);
	if($_GET['confirm'] == "1") {
	$acctupdate = mysql_query("UPDATE `accounts` SET `Email` = '$email[email_address]' WHERE `id` = '$email[user_id]'");
	$cachedelete = mysql_query("DELETE FROM `cp_cache_email` WHERE `id` = '$email[id]'");
	}
	if($_GET['confirm'] == "0") {
	$cachedelete = mysql_query("DELETE FROM `cp_cache_email` WHERE `id` = '$email[id]'");
	}
	echo $redirect;
} ?>