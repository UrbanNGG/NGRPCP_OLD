<?php error_reporting(1);
require('../global/class/SQL.php');

if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])) $_SERVER['REMOTE_ADDR'] = $_SERVER['HTTP_CF_CONNECTING_IP'];

function doLog($user, $area, $details) {
	$ip = $_SERVER['REMOTE_ADDR'];
	$date = date('Y-m-d H:i:s');
	$logquery = "INSERT INTO `cp_log_general` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, '$date', '$user', '$area', '$details', '$ip')";
	$runquery = mysql_query($logquery);
	if (!$runquery) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $logquery;
		die($message);
	}
}

$redir = '<meta http-equiv="refresh" content="0;url=../index.php?p=dashboard">';
$error1 = '<meta http-equiv="refresh" content="0;url=../wllogin.php?error=1">';

$ip = $_SERVER['REMOTE_ADDR'];
$datetime = date('Y-m-d H:i:s');
$myusername=$_POST['username'];
$mypassword=$_POST['password'];

$myusername = stripslashes($myusername);
$myusername = mysql_real_escape_string($myusername);
$mypassword = mysql_real_escape_string($mypassword);

$passhash = strtoupper(hash('whirlpool', $mypassword));

$sql = "SELECT `id` FROM `accounts` WHERE `Username`='$myusername' and `Key`='$passhash'";
$result = mysql_query($sql);
if (!$result) {
	echo $sql;
    die('Invalid query: ' . mysql_error());
}
$count = mysql_num_rows($result);
$dataarray = mysql_fetch_array($result);
$id = $dataarray['id'];
if($count==1){
	$dbchkquery = mysql_query("SELECT * FROM `cp_whitelist` WHERE `id` = '$id'");
	$dbchk = mysql_num_rows($dbchkquery);
	if($dbchk == 0) {
	$wlquery = mysql_query("INSERT INTO `cp_whitelist` (`id`, `username`, `date`, `key`, `ip`) VALUES ('$id', '$myusername', '$datetime', '$passhash', '$ip')");
	}
	if($dbchk == 1) {
	$wlquery = mysql_query("UPDATE `cp_whitelist` SET `username` = '$myusername', `date` = '$datetime', `key` = '$passhash', `ip` = '$ip' WHERE `id` = '$id'");
	}
	if (!$wlquery) {
		echo $sql;
		die('Invalid query: ' . mysql_error());
	}
	echo $redir;
	exit();

} else {
	$area = "Login";
	$details = "Failed login for user: " . $myusername . "while trying to update whitelist IP";
	if($adminchk['id']==false){
		$adminchk['id'] = 0;
	}
	doLog($adminchk['id'], $area, $details);
	echo $error1;
	exit();
}
?>