<?php
require('../../global/func.php');
$redir = '<meta http-equiv="refresh" content="0;url=../login.php">';
$redir2n0 = '<meta http-equiv="refresh" content="0;url=../refund.php?p=view&o=1&note=0">';
$redir2n1 = '<meta http-equiv="refresh" content="0;url=../refund.php?p=view&o=1&note=1">';
$redir2n2 = '<meta http-equiv="refresh" content="0;url=../refund.php?p=view&o=1&note=2">';
$redir2n3 = '<meta http-equiv="refresh" content="0;url=../refund.php?p=view&o=1&note=3">';
$redir2n4 = '<meta http-equiv="refresh" content="0;url=../refund.php?p=view&o=1&note=4">';

if(!isset($_SESSION['myusername'])){
$logged = 0;
echo $redir;
exit();
}

if($inf['AdminLevel'] > 1 || $access['refund'] == 1) {

//----Variables
$section = "Staff";
$area = "Refunds";
if(isset($_POST['rID'])) { $id = $_POST['rID']; }
$admin = $_POST['admin'];
$admin_id = $_POST['admin_id'];
$ip = $_POST['ip'];
$date = date('Y-m-d');
$datetime = date('Y-m-d H:i:s');
$player = $_POST['player'];
$playeridquery = mysql_query("SELECT `id` FROM `accounts` WHERE `Username` = '$player'");
$player_id = mysql_fetch_row($playeridquery);
$refund = $_POST['refund'];
$money = StripNumber($_POST['money']);
$material = StripNumber($_POST['material']);
$pot = StripNumber($_POST['pot']);
$crack = StripNumber($_POST['crack']);
$boombox = StripNumber($_POST['boombox']);
$viptoken = StripNumber($_POST['viptoken']);
$auth = $_POST['auth'];
$link = $_POST['link'];
$action = $_POST['action'];
//-------End Variables

if(strtolower($admin) != strtolower($inf['Username'])) { echo "Data tampered with. ERR:001"; exit(); }
if($ip != $_SERVER['REMOTE_ADDR']) { echo "Data tampered with. ERR:002"; exit(); }

if($action == "add") {

if(CheckName($player) == 0) {
echo '<meta http-equiv="refresh" content="0;url=../refund.php?p=add&note=0">';
}

if(CheckName($player) > 0) {

if($refund != "") {
$addquery = "INSERT INTO `cp_refund` (`id`, `user_id`, `refund`, `money`, `materials`, `crack`, `pot`, `boombox`, `viptoken`, `link`, `status`, `auth`, `addedby_id`, `date_added`) VALUES (NULL, '$player_id[0]', '$refund', '$money', '$material', '$pot', '$crack', '$boombox', '$viptoken', '$link', '1', '$auth', '$admin_id', '$date')";

$flagquery = mysql_query("INSERT INTO `flags` (`fid`, `id`, `time`, `issuer`, `flag`) VALUES (NULL, '$player_id[0]', '$datetime', 'CP', 'Refund: $refund')");
}
else {
$addquery = "INSERT INTO `cp_refund` (`id`, `user_id`, `refund`, `money`, `materials`, `crack`, `pot`, `boombox`, `viptoken`, `link`, `status`, `auth`, `addedby_id`, `date_added`) VALUES (NULL, '$player_id[0]', '$refund', '$money', '$material', '$pot', '$crack', '$boombox', '$viptoken', '$link', '1', '$auth', '$admin_id', '$date')";
}

$runquery = mysql_query($addquery);
if (!$runquery) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $addquery;
    die($message);
	}
$details = "Added refund for ".$player;
doLog($inf['id'], $section, $area, $details);
echo $redir2n1;
}
}

if($action == "edit") {
$query1 = "UPDATE `cp_refund` SET `user_id` = '$player_id[0]', `refund` = '$refund', `money` = '$money', `materials` = '$material', `pot` = '$pot', `crack` = '$crack', `boombox` = '$boombox', `viptoken` = '$viptoken', `auth` = '$auth', `link` = '$link' WHERE `id` = $id";

$runquery = mysql_query($query1);
if (!$runquery) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query1;
    die($message);
	}
$details = "Modified refund #".$id." for ".$player;
doLog($inf['id'], $section, $area, $details);
echo $redir2n0;
}

if($action == "issue") {
if(IsPlayerOnline($player_id[0]) > 0) { echo $redir2n4; }
if(IsPlayerOnline($player_id[0]) == 0) {
if($money > 0) {
	mysql_query("UPDATE `accounts` SET `Bank` = Bank + $money WHERE `id` = '$player_id[0]'");
	$file = "adminpay.log";
	$content = $inf['Username']." (IP:".$_SERVER['REMOTE_ADDR'].") has given $".number_format($money)." to ".$player.", Refund #".$id;
	LogFile($logdir,$file,$content);
	}
if($material > 0) {
	mysql_query("UPDATE `accounts` SET `Materials` = Materials + $material WHERE `id` = '$player_id[0]'");
	$file = "adminpay.log";
	$content = $inf['Username']." (IP:".$_SERVER['REMOTE_ADDR'].") has given ".number_format($material)." materials to ".$player.", Refund #".$id;
	LogFile($logdir,$file,$content);
	}
if($pot > 0) {
	mysql_query("UPDATE `accounts` SET `Pot` = Pot + $pot WHERE `id` = '$player_id[0]'");
	$file = "adminpay.log";
	$content = $inf['Username']." (IP:".$_SERVER['REMOTE_ADDR'].") has given ".number_format($pot)." pot to ".$player.", Refund #".$id;
	LogFile($logdir,$file,$content);
	}
if($crack > 0) {
	mysql_query("UPDATE `accounts` SET `Crack` = Crack + $crack WHERE `id` = '$player_id[0]'");
	$file = "adminpay.log";
	$content = $inf['Username']." (IP:".$_SERVER['REMOTE_ADDR'].") has given ".number_format($crack)." crack to ".$player.", Refund #".$id;
	LogFile($logdir,$file,$content);
	}
if($boombox > 0) {
	mysql_query("UPDATE `accounts` SET `Boombox` = $boombox WHERE `id` = '$player_id[0]'");
	$file = "adminpay.log";
	$content = $inf['Username']." (IP:".$_SERVER['REMOTE_ADDR'].") has given ".number_format($boombox)." boombox to ".$player.", Refund #".$id;
	LogFile($logdir,$file,$content);
	}
if($viptoken > 0) {
	mysql_query("UPDATE `accounts` SET `Tokens` = Tokens + $viptoken WHERE `id` = '$player_id[0]'");
	$file = "adminpay.log";
	$content = $inf['Username']." (IP:".$_SERVER['REMOTE_ADDR'].") has given ".number_format($viptoken)." VIP tokens to ".$player.", Refund #".$id;
	LogFile($logdir,$file,$content);
	}
$query1 = mysql_query("UPDATE `cp_refund` SET `status` = '2', `issuedby_id` = '$inf[id]', `date_issued` = '$date' WHERE `id` = $id");

if (!$query1) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query1;
    die($message);
	}

$details = "Issued refund #".$id." for ".$player;
doLog($inf['id'], $section, $area, $details);
echo $redir2n2;
}
}

if($action == "remove") {
$query1 = mysql_query("UPDATE `cp_refund` SET `status` = '3', `issuedby_id` = '$inf[id]', `date_issued` = '$date' WHERE `id` = $id");

if (!$query1) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query1;
    die($message);
	}

$details = "Removed refund #".$id." for ".$player;
doLog($inf['id'], $section, $area, $details);
echo $redir2n3;
}

}
else {
	echo $redir;
	exit();
}
?>