<?php
require('../../global/func.php');
$redir = '<meta http-equiv="refresh" content="0;url=../index.php">';
$redir2 = '<meta http-equiv="refresh" content="0;url=../tempban.php?p=view">';

if(!isset($_SESSION['myusername'])){
$logged = 0;
echo $redir;
exit();
}

if($inf['AdminLevel'] < 4 && $inf['BanAppealer'] < 1 && $access['ban'] != 1) {
	echo $redir;
	exit();
}

//----Variables
$action = $_POST['action'];
$section = "Staff";
$area = "Bans";
$admin = $_POST['admin'];
$ip = $_POST['ip'];
$id = $_POST['id'];
$date = date('Y-m-d');
$datetime = date('Y-m-d H:i:s');
if(isset($id)) { $ipquery = mysql_query("SELECT * FROM `ip_bans` WHERE `bid` = $id");
$iparray = mysql_fetch_array($ipquery);
$banquery = mysql_query("SELECT * FROM `bans` WHERE `id` = $id");
$banarray = mysql_fetch_array($banquery); }
$username = $_POST['username'];
$userid = GetID($username);
$userip = GetLastIP($userid);
$banip = $_POST['banip'];
$reason = $_POST['reason'];
$status = $_POST['status'];
$dateunban = $_POST['dateunban']." 00:00:00";
$link = $_POST['link'];
//-------End Variables

if(strtolower($admin) != strtolower($inf['Username'])) { echo "Data tampered with. ERR:001"; exit(); }
if($ip != $_SERVER['REMOTE_ADDR']) { echo "Data tampered with. ERR:002"; exit(); }

if($action == "add") {
if(CheckName($username) == 0) { echo '<meta http-equiv="refresh" content="0;url=../ban.php?p=view&type=pending&note=3">'; }
//elseif(IsPlayerOnline($userid) > 0) { echo '<meta http-equiv="refresh" content="0;url=../ban.php?p=view&type=pending&note=4">'; }
else {
$query = mysql_query("INSERT INTO `bans` (`id`, `user_id`, `ip_address`, `reason`, `date_added`, `status`, `admin`) VALUES (NULL, $userid, '$userip', '$reason',  NOW(), 1, '$admin')");
$details = "Added ban details on ".$username;
doLog($inf['id'], $section, $area, $details);
echo '<meta http-equiv="refresh" content="0;url=../ban.php?p=view&type=pending">';
}
}

if($action == "edit") {
$query = mysql_query("UPDATE `bans` SET `date_unban` = '$dateunban', `status` = $status, `link` = '$link' WHERE `id` = $id");
if($status < 3) { $details = "Modified ".GetName($banarray['user_id'])." (#".$banarray['id'].")\'s ban details"; }
if($status == 3) { $query2 = mysql_query("UPDATE `accounts` SET `Band` = 3, `PermBand` = 1 WHERE `id` = $banarray[user_id]");
	$details = "Permanently banned ".GetName($banarray['user_id']); }
if($status == 4) { $query2 = mysql_query("UPDATE `accounts` SET `Band` = 0 WHERE `id` = $banarray[user_id]");
	$query3 = mysql_query("DELETE FROM `ip_bans` WHERE `ip` = $banarray[ip_address]");
	$details = "Unbanned ".GetName($banarray['user_id']); }
doLog($inf['id'], $section, $area, $details);
echo '<meta http-equiv="refresh" content="0;url=../ban.php?p=view&type=pending">';
}

if($action == "ip_add") {
$query = mysql_query("INSERT INTO `ip_bans` (`bid`, `ip`, `date`, `reason`, `admin`) VALUES (NULL, '$banip', NOW(), '$reason', '$admin')");
$details = "Banned IP ".$banip;
doLog($inf['id'], $section, $area, $details);
echo '<meta http-equiv="refresh" content="0;url=../ban.php?p=view&type=ip&note=2">';
}

if($action == "ip_remove") {
$query = mysql_query("DELETE FROM `ip_bans` WHERE `bid` = $id");
$details = "Unbanned IP ".$iparray['ip'];
doLog($inf['id'], $section, $area, $details);
echo '<meta http-equiv="refresh" content="0;url=../ban.php?p=view&type=ip&note=1">';
}

if($action == "add_banappealer") {
if(IsPlayerOnline($id) > 0) { echo '<meta http-equiv="refresh" content="0;url=../ban.php?p=roster&n=1">'; }
else {
$query = mysql_query("UPDATE `accounts` SET `BanAppealer` = 1 WHERE `id` = $id");
$details = "Added ".GetName($id)." as a Ban Appealer";
doLog($inf['id'], $section, $area, $details);
echo '<meta http-equiv="refresh" content="0;url=../ban.php?p=roster&n=2">';
}
}

if($action == "remove_banappealer") {
if(IsPlayerOnline($id) > 0) { echo '<meta http-equiv="refresh" content="0;url=../ban.php?p=roster&n=1">'; }
else {
$query = mysql_query("UPDATE `accounts` SET `BanAppealer` = 0 WHERE `id` = $id");
$details = "Removed ".GetName($id)." as a Ban Appealer";
doLog($inf['id'], $section, $area, $details);
echo '<meta http-equiv="refresh" content="0;url=../ban.php?p=roster&n=3">';
}
}
?>