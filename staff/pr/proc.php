<?php
require('../../global/func.php');
$redir = '<meta http-equiv="refresh" content="0;url=../index.php">';
$redir_st1 = '<meta http-equiv="refresh" content="0;url=../cr.php?p=roster&n=1">';
$redir_st2 = '<meta http-equiv="refresh" content="0;url=../cr.php?p=roster&n=2">';
$redir_st3 = '<meta http-equiv="refresh" content="0;url=../cr.php?p=roster&n=3">';

if(!isset($_SESSION['myusername'])){
$logged = 0;
echo $redir;
exit();
}

if($inf['AdminLevel'] >= 1337 || $inf['PR'] > 0) {

//----Variables
$section = "Staff";
$area = "Public Relations";
$date = date('Y-m-d');
$datetime = date('Y-m-d H:i:s');
$action = $_POST['action'];
$admin = $_POST['admin'];
$ip = $_POST['ip'];
$id = $_POST['id'];
$points = $_POST['points'];
$shiftid = $_POST['shiftid'];
$shiftblock = $_POST['shiftblock'];
$assigndate = $_POST['assigndate'];
$diff = strtotime("$assigndate") - strtotime("$date");
$num = $diff/86400;
$days = intval($num);
$assignid = $_POST['assignid'];
$status = $_POST['status'];
$bonus = $_POST['bonus'];
$asst_req = $_POST['asst_req'];
$player = $_POST['player'];
$adminid = $_POST['admin_id'];
$playerid = GetID($player);
$houseid = $_POST['houseid'];
$doorid = $_POST['doorid'];
$gateid = $_POST['gateid'];
$orderid = $_POST['orderid'];
$housemove = $_POST['house_move'];
$level = $_POST['level'];
$vip = $_POST['vip'];
$vipm = $_POST['vipm'];
$gift = $_POST['gift'];
$renew = $_POST['renew'];
$email = $_POST['email'];
$restrictveh = $_POST['restrictveh'];
$donate = $_POST['donate'];
$expire = $_POST['expire'];
$databaseid = $_POST['db_id'];
$channel = $_POST['channel'];
$tracktype = $_POST['tracktype'];
$q1 = addslashes($_POST['q1']);
$q2 = addslashes($_POST['q2']);
$q3 = addslashes($_POST['q3']);
$q4 = addslashes($_POST['q4']);
$q5 = addslashes($_POST['q5']);
if($level == 1) { $rank = "Shop Technician"; }
if($level == 2) { $rank = "Senior Shop Technician"; }
$accountid = $_POST['accountid'];
$username = $_POST['username'];
if(isset($_POST['secureip'])) { $secureip = $_POST['secureip']; }
if(isset($_POST['rank'])) { $rank = $_POST['rank']; }
if(isset($_POST['senmod'])) { $senmod = $_POST['senmod']; }
if(isset($_POST['status'])) { $status = $_POST['status']; }
$cpl = implode(' = 1, ',$_POST['cpl']);
$cpv = implode(' = 1, ',$_POST['cpv']);
$gl = implode(' = 1, ',$_POST['gl']);
if(isset($_POST['leaveID'])) { $leaveID = $_POST['leaveID']; }
if(isset($_POST['noteID'])) { $noteID = $_POST['noteID']; }
if(isset($_POST['acceptID'])) { $acceptID = $_POST['acceptID']; }
if(isset($_POST['shiftid'])) { $shiftid = $_POST['shiftid']; }
if(isset($_POST['assigndate'])) { $assigndate = $_POST['assigndate']; }
if(isset($_POST['needs_sun'])) { $needs_sun = $_POST['needs_sun']; }
if(isset($_POST['needs_mon'])) { $needs_mon = $_POST['needs_mon']; }
if(isset($_POST['needs_tue'])) { $needs_tue = $_POST['needs_tue']; }
if(isset($_POST['needs_wed'])) { $needs_wed = $_POST['needs_wed']; }
if(isset($_POST['needs_thu'])) { $needs_thu = $_POST['needs_thu']; }
if(isset($_POST['needs_fri'])) { $needs_fri = $_POST['needs_fri']; }
if(isset($_POST['needs_sat'])) { $needs_sat = $_POST['needs_sat']; }
if(isset($_POST['assignid'])) { $assignid = $_POST['assignid']; }
$bonus = $_POST['bonus'];
$asst_req = $_POST['asst_req'];
if(isset($_POST['leader_type'])) { $leader_type = $_POST['leader_type']; }
if(isset($_POST['leader_ID'])) { $leader_ID = $_POST['leader_ID']; }
$shiftleadid = $_POST['shiftleadid'];
$type = $_POST['type'];
$note = $_POST['note'];
$invokeid = $_POST['invokeid'];
$leave_date = isset($_POST["date1"]) ? $_POST["date1"] : "";
$return_date = isset($_POST["date2"]) ? $_POST["date2"] : "";
$reason = $_POST['reason'];
//-------End Variables

if(strtolower($admin) != strtolower($inf['Username'])) { echo "Data tampered with. ERR:001"; exit(); }
if($ip != $_SERVER['REMOTE_ADDR']) { echo "Data tampered with. ERR:002"; exit(); }

//-------Advisors-----------------

if($action == "addadvisor") {
	if(CheckName($username) == 0) { echo '<meta http-equiv="refresh" content="0;url=../pr.php?p=view&g=advisor&n=1">'; }
	elseif(IsPlayerOnline(GetID($username)) > 0) { echo '<meta http-equiv="refresh" content="0;url=../pr.php?p=view&g=advisor&n=2">'; }
	else {
	if($rank == 2) { $rankname = "Community Advisor"; }
	if($rank == 3) { $rankname = "Senior Advisor"; }
	if($rank == 4) { $rankname = "Chief Advisor"; }

	$addadvisor = mysql_query("UPDATE `accounts` SET `Helper` = '$rank' WHERE `id` = $accountid");

	$details = "Made ".$username." a ".$rankname;
	doLog($inf['id'], $section, $area, $details);
	echo '<meta http-equiv="refresh" content="0;url=../pr.php?p=view&g=advisor&n=3">';

		if (!$addadvisor) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $addadvisor;
		die($message);
		}
	}
}

if($action == "editadvisor") {
	if(IsPlayerOnline($accountid) > 0) { echo '<meta http-equiv="refresh" content="0;url=../pr.php?p=view&g=advisor&n=2">'; }
	else {
		$edituserquery = "UPDATE `accounts` SET `Helper` = '$rank' WHERE `id` = '$accountid'";

		$uaccesscheckquery = mysql_query("SELECT `user_id` FROM `cp_access` WHERE `user_id` = '$accountid'");
		$uaccesscheck = mysql_num_rows($uaccesscheckquery);
		if($uaccesscheck == "0")
		{
			$editaccessquery = "INSERT INTO `cp_access` (`user_id`) VALUES ('$accountid');";
			if(isset($cpv)) { mysql_query("UPDATE `cp_access` SET $cpv = 1 WHERE `user_id` = $accountid"); }
			if(isset($cpl)) { mysql_query("UPDATE `cp_access` SET $cpl = 1 WHERE `user_id` = $accountid"); }
			if(isset($gl)) { mysql_query("UPDATE `cp_access` SET $gl = 1 WHERE `user_id` = $accountid"); }
		}
		elseif($uaccesscheck == "1") {
			mysql_query("UPDATE `cp_access` SET `punish` = 0, `refund` = 0, `ban` = 0, `cplgeneral` = 0, `cplstaff` = 0, `cplfaction` = 0, `cplfamily` = 0, `cplcr` = 0, `gladmin` = 0, `gladmingive` = 0, `gladminpay` = 0, `glban` = 0, `glbusiness` = 0, `glcontracts` = 0, `glddedit` = 0, `gldmpedit` = 0, `glfaction` = 0, `glfamily` = 0, `glfmembercount` = 0, `glgedit` = 0, `glgifts` = 0, `glhack` = 0, `glhedit` = 0, `glhouse` = 0, `glkick` = 0, `gllicenses` = 0, `glmoderator` = 0, `glmute` = 0, `glpads` = 0, `glpassword` = 0, `glpay` = 0, `glplayervehicle` = 0, `glrpspecial` = 0, `glsecurity` = 0, `glsetvip` = 0, `glshopconfirmedorders` = 0, `glshoplog` = 0, `glshoporders` = 0, `glstats` = 0, `glundercover` = 0, `glvipnamechanges` = 0, `glvipremove` = 0 WHERE `user_id` = '$accountid'");
			if(isset($cpv)) { mysql_query("UPDATE `cp_access` SET $cpv = 1 WHERE `user_id` = $accountid"); }
			if(isset($cpl)) { mysql_query("UPDATE `cp_access` SET $cpl = 1 WHERE `user_id` = $accountid"); }
			if(isset($gl)) { mysql_query("UPDATE `cp_access` SET $gl = 1 WHERE `user_id` = $accountid"); }
		}

		$ustatcheckquery = mysql_query("SELECT `user_id` FROM `cp_stat` WHERE `user_id` = '$accountid'");
		$ustatcheck = mysql_num_rows($ustatcheckquery);
		if($ustatcheck == "0") { $editstatquery = "INSERT INTO `cp_stat` (`user_id`, `points`, `shift`, `shift_complete`, `shift_partcomplete`, `shift_missed`) VALUES ('$accountid', '$points', '0', '0', '0', '0');"; }
		elseif($ustatcheck == "1") { $editstatquery = "UPDATE `cp_stat` SET  `points` = '$points' WHERE `user_id` = '$accountid'"; }

		$runquery = mysql_query($edituserquery);
		$runquery2 = mysql_query($editaccessquery);
		$runquery3 = mysql_query($editstatquery);

		$details = "Edited ".GetName($accountid)."\'s account";
		doLog($inf['id'], $section, $area, $details);
		if($rank == 0) { echo '<meta http-equiv="refresh" content="0;url=../pr.php?p=view&g=advisor&n=5">'; }
		else { echo '<meta http-equiv="refresh" content="0;url=../pr.php?p=view&g=advisor">'; }

		if (!$runquery) {
			$message  = 'Invalid query 1: ('.mysql_errno().')'.mysql_error()."\n";
			$message .= 'Whole query: ' . $edituserquery;
			die($message);
		}
		if (!$runquery2) {
			$message  = 'Invalid query 2: ('.mysql_errno().')'.mysql_error()."\n";
			$message .= 'Whole query: ' . $editaccessquery;
			die($message);
		}
		if (!$runquery3) {
			$message  = 'Invalid query 3: ('.mysql_errno().')'.mysql_error()."\n";
			$message .= 'Whole query: ' . $editstatquery;
			die($message);
		}
	}
}

//--------------------------------

//-------Helpers------------------

if($action == "addhelper") {
	if(CheckName($username) == 0) { echo '<meta http-equiv="refresh" content="0;url=../pr.php?p=view&g=helper&n=1">'; }
	elseif(IsPlayerOnline(GetID($username)) > 0) { echo '<meta http-equiv="refresh" content="0;url=../pr.php?p=view&g=helper&n=2">'; }
	else {
		$addmoderator = mysql_query("UPDATE `accounts` SET `Helper` = '1' WHERE `id` = ".GetID($username));

		$details = "Made ".$username." a Helper";
		doLog($inf['id'], $section, $area, $details);
		echo '<meta http-equiv="refresh" content="0;url=../pr.php?p=view&g=helper&n=4">';

		if (!$addmoderator) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $addmoderator;
			die($message);
		}
	}
}

if($action == "removehelper") {
	if(IsPlayerOnline($accountid) > 0) { echo '<meta http-equiv="refresh" content="0;url=../pr.php?p=view&g=helper&n=2">'; }
	else {
		$removemod = mysql_query("UPDATE `accounts` SET `Helper` = '0' WHERE `id` = $accountid");

		$details = "Removed ".$username." from Helper";
		doLog($inf['id'], $section, $area, $details);
		echo '<meta http-equiv="refresh" content="0;url=../pr.php?p=view&g=helper&n=6">';

		if (!$removemod) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $removemod;
			die($message);
		}
	}
}

//--------------------------------

if($action == "assign") {
foreach ($shiftid as $shift) {
if($days > 4) {
$assignquery = "INSERT INTO `cp_shifts` (`id`, `user_id`, `type`, `shift_id`, `date`, `sign_up`, `status`, `bonus`) VALUES (NULL, '$adminid', 2, '$shift', '$assigndate', '$date', '2', '2')";
}
else {
$assignquery = "INSERT INTO `cp_shifts` (`id`, `user_id`, `type`, `shift_id`, `date`, `sign_up`, `status`, `bonus`) VALUES (NULL, '$adminid', 2, '$shift', '$assigndate', '$date', '2', '0')";
}
$runquery = mysql_query($assignquery);
echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=shift">';

if (!$runquery) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $assignquery;
    die($message);
	}
}
}

if($action == "addassign") {
foreach ($shiftid as $shift) {
$assignquery = "INSERT INTO `cp_shifts` (`id`, `user_id`, `type`, `shift_id`, `date`, `sign_up`, `status`) VALUES (NULL, '$adminid', 2, '$shift', '$assigndate', '$date', '2')";
$runquery = mysql_query($assignquery);
echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=assigncal">';

if (!$runquery) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $assignquery;
    die($message);
	}
echo $assignquery;
}
}

if($action == "assign_edit") {
$assigneditquery = "UPDATE `cp_shifts` SET `status` = '$status' WHERE `id` = $assignid";
	if($status == "3" && $asst_req == 1) { $bonus = 1;
	mysql_query("UPDATE `cp_stat` SET `shift_complete` = shift_complete + 1, `points` = points + $bonus + 1 WHERE `user_id` = '$adminid'"); }
	if($status == "3" && $asst_req == 0) { mysql_query("UPDATE `cp_stat` SET `shift_complete` = shift_complete + 1, `points` = points + $bonus + 1 WHERE `user_id` = '$adminid'"); }
	if($status == "4") { mysql_query("UPDATE `cp_stat` SET `shift_partcomplete` = shift_partcomplete + 1 WHERE `user_id` = '$adminid'"); }
	if($status == "5" && $bonus == 0) { mysql_query("UPDATE `cp_stat` SET `shift_missed` = shift_missed + 1, `points` = points - 1 WHERE `user_id` = '$adminid'"); }
	if($status == "5" && $bonus == 2) { mysql_query("UPDATE `cp_stat` SET `shift_missed` = shift_missed + 1, `points` = points - 2 WHERE `user_id` = '$adminid'"); }
$runquery = mysql_query($assigneditquery);

$area = "Shifts";
$details = "Modified assignment #".$assignid;
doLog($inf['id'], $section, $area, $details);
echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=assigncal">';

if (!$runquery) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $assigneditquery;
    die($message);
}
}

if($action == "report_add") {
	$sql = "INSERT INTO `cp_weekly_reports` (`id`, `admin_id`, `date`, `q1`, `q2`, `q3`, `q4`, `q5`, `status`) VALUES (NULL, $adminid, '$datetime', '$q1', '$q2', '$q3', '$q4', '$q5', 1);";
	$details = "Created a weekly report";
	$area = "Weekly Reports";
	doLog($inf['id'], $section, $area, $details);
	echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=report_create&n=1">';
	$run = mysql_query($sql);
	
	if (!$run) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $sql;
    die($message);
	}
}

if($action == "report_approve") {
	$sql = "UPDATE `cp_weekly_reports` SET `status` = 2 WHERE `id` = $id;";
	$details = "Approved report #".$id;
	$area = "Weekly Reports";
	doLog($inf['id'], $section, $area, $details);
	echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=report_pending&n=1">';
	$run = mysql_query($sql);
	
	if (!$run) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $sql;
    die($message);
	}
}

if($action == "report_deny") {
	$sql = "DELETE FROM `cp_weekly_reports` WHERE `id` = $id;";
	$details = "Denied report #".$id;
	$area = "Weekly Reports";
	doLog($inf['id'], $section, $area, $details);
	echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=report_pending&n=2">';
	$run = mysql_query($sql);
	
	if (!$run) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $sql;
    die($message);
	}
}

if($action == "trackadd_house") {
	if(CheckName($player) == 0) {
		echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=tracker&item=house&n=1">';
	}
	$sql = "INSERT INTO `track_house` (`id`, `player_id`, `house_id`, `order_id`, `house_move`, `admin_id`, `date`) VALUES (NULL, $playerid, $houseid, '$orderid', $housemove, $adminid, '$datetime');";
	$details = "Added house ID ".$houseid." with order ID ".$orderid;
	$area = "Tracker";
	doLog($inf['id'], $section, $area, $details);
	echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=tracker&item=house&n=2">';
	$run = mysql_query($sql);
	
	if (!$run) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $sql;
    die($message);
	}
}

if($action == "trackadd_backdoor") {
	if(CheckName($player) == 0) {
		echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=tracker&item=backdoor&n=1">';
	}
	else {
	$sql = "INSERT INTO `track_backdoor` (`id`, `player_id`, `order_id`, `house_id`, `door_id`, `admin_id`, `date`) VALUES (NULL, $playerid, '$orderid', $houseid, $doorid, $adminid, '$datetime');";
	$details = "Added door ID ".$doorid." to house ID ".$houseid." with order ID ".$orderid;
	$area = "Tracker";
	doLog($inf['id'], $section, $area, $details);
	echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=tracker&item=backdoor&n=2">';
	$run = mysql_query($sql);
	
	if (!$run) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $sql;
    die($message);
	}
	}
}

if($action == "trackadd_gate") {
	if(CheckName($player) == 0) {
		echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=tracker&item=gate&n=1">';
	}
	else {
	$sql = "INSERT INTO `track_gate` (`id`, `player_id`, `order_id`, `house_id`, `gate_id`, `gate_move`, `admin_id`, `date`) VALUES (NULL, $playerid, '$orderid', $houseid, $gateid, $housemove, $adminid, '$datetime');";
	$details = "Added gate ID ".$gateid." with order ID ".$orderid;
	$area = "Tracker";
	doLog($inf['id'], $section, $area, $details);
	echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=tracker&item=gate&n=2">';
	$run = mysql_query($sql);
	
	if (!$run) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $sql;
    die($message);
	}
	}
}

if($action == "trackadd_vip") {
	if(CheckName($player) == 0) {
		echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=tracker&item=vip&n=1">';
	}
	else {
	$sql = "INSERT INTO `track_vip` (`id`, `player_id`, `vip`, `order_id`, `vipm`, `expiration`, `admin_id`, `date`) VALUES (NULL, $playerid, $vip, '$orderid', $vipm, $expire, $adminid, '$datetime');";
	$details = "Added VIP for ".$player." with order ID ".$orderid;
	$area = "Tracker";
	doLog($inf['id'], $section, $area, $details);
	echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=tracker&item=vip&n=2">';
	$run = mysql_query($sql);
	
	if (!$run) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $sql;
    die($message);
	}
	}
}

if($action == "trackadd_gvip") {
	if(CheckName($player) == 0) {
		echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=tracker&item=gvip&n=1">';
	}
	else {
	$sql = "INSERT INTO `track_gvip` (`id`, `player_id`, `order_id`, `vipm`, `renewal`, `gift`, `expiration`, `admin_id`, `date`) VALUES (NULL, $playerid, '$orderid', $vipm, $renew, $gift, $expire, $adminid, '$datetime');";
	$details = "Added Gold VIP for ".$player." with order ID ".$orderid;
	$area = "Tracker";
	doLog($inf['id'], $section, $area, $details);
	echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=tracker&item=gvip&n=2">';
	$run = mysql_query($sql);
	
	if (!$run) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $sql;
    die($message);
	}
	}
}

if($action == "trackadd_pvip") {
	if(CheckName($player) == 0) {
		echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=tracker&item=pvip&n=1">';
	}
	else {
	$sql = "INSERT INTO `track_pvip` (`id`, `player_id`, `vipm`, `shop_email`, `restrict_veh`, `donate`, `admin_id`, `date`) VALUES (NULL, $playerid, $vipm, '$email', $restrictveh, $donate, $adminid, '$datetime');";
	$details = "Added Platinum VIP for ".$player;
	$area = "Tracker";
	doLog($inf['id'], $section, $area, $details);
	echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=tracker&item=pvip&n=2">';
	$run = mysql_query($sql);
	
	if (!$run) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $sql;
    die($message);
	}
	}
}

if($action == "trackadd_ts") {
	$sql = "INSERT INTO `track_ts` (`id`, `name`, `order_id`, `database_id`, `channel_name`, `admin_id`, `date`) VALUES (NULL, '$player', $orderid, $databaseid, '$channel', $adminid, '$datetime');";
	$details = "Added a TeamSpeak channel for ".$player;
	$area = "Tracker";
	doLog($inf['id'], $section, $area, $details);
	echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=tracker&item=ts&n=2">';
	$run = mysql_query($sql);
	
	if (!$run) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $sql;
    die($message);
	}
}

if($action == "trackremove") {
	$sql = "DELETE FROM `track_$tracktype` WHERE `id` = $id";
	$details = "Removed tracked item #".$id." (".$tracktype.") from ".$player;
	$area = "Tracker";
	doLog($inf['id'], $section, $area, $details);
	echo '<meta http-equiv="refresh" content="0;url=../cr.php?p=tracker&item='.$tracktype.'">';
	$run = mysql_query($sql);
	
	if (!$run) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $sql;
    die($message);
	}
}

if($action == "add_PR") {
	if(IsPlayerOnline($adminid) > 0) {
		echo '<meta http-equiv="refresh" content="0;url=../pr.php?p=roster&n=1">';
	}
	else {
	$sql = "UPDATE `accounts` SET `PR` = 1 WHERE `id` = $adminid;";
	$details = "Added ".GetName($adminid)." as PR Staff";
	$area = "Management";
	doLog($inf['id'], $section, $area, $details);
	echo '<meta http-equiv="refresh" content="0;url=../pr.php?p=roster&n=2">';
	$run = mysql_query($sql);
	
	if (!$run) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $sql;
    die($message);
	}
	}
}

if($action == "remove_PR") {
	if(IsPlayerOnline($adminid) > 0) {
		echo '<meta http-equiv="refresh" content="0;url=../pr.php?p=roster&n=1">';
	}
	else {
	$sql = "UPDATE `accounts` SET `PR` = 0 WHERE `id` = $adminid;";
	$details = "Removed Shop Tech from ".GetName($adminid);
	$area = "Management";
	doLog($inf['id'], $section, $area, $details);
	echo '<meta http-equiv="refresh" content="0;url=../pr.php?p=roster&n=3">';
	$run = mysql_query($sql);
	
	if (!$run) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $sql;
    die($message);
	}
	}
}

}
else {
	echo $redir;
	exit();
}
?>