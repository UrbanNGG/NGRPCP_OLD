<?php
require('../../global/func.php');
//ini_set('display_errors', 1);
$redir = '<meta http-equiv="refresh" content="0;url=../index.php">';
$rediredituser = '<meta http-equiv="refresh" content="0;url=../user.php">';
$rediraddleader = '<meta http-equiv="refresh" content="0;url=../user.php?p=usergroup&a=add">';
$redirdeleteleader = '<meta http-equiv="refresh" content="0;url=../user.php?p=usergroup&a=view">';
$redirleave = '<meta http-equiv="refresh" content="0;url=../user.php?p=pendingleave">';
$redir3 = '<meta http-equiv="refresh" content="0;url=../user.php?p=view&g=admin">';
$rediradvisor = '<meta http-equiv="refresh" content="0;url=../user.php?p=view&g=advisor">';
$redirmod1 = '<meta http-equiv="refresh" content="0;url=../user.php?p=view&g=moderator">';
$redirwatchdog = '<meta http-equiv="refresh" content="0;url=../user.php?p=view&g=watchdog">';
$redirhelper = '<meta http-equiv="refresh" content="0;url=../user.php?p=view&g=helper">';
$redir4 = '<meta http-equiv="refresh" content="0;url=../vUsers.php">';
$redir5 = '<meta http-equiv="refresh" content="0;url=../user.php?p=name_exists">';
if(isset($_GET['i'])) { $redir6 = '<meta http-equiv="refresh" content="0;url=info.php?uID='.$_GET['i'].'">'; }
$leaveredir = '<meta http-equiv="refresh" content="0;url=../user.php?p=pendingleave">';
$rediraddnote = '<meta http-equiv="refresh" content="0;url=../user.php?p=addnote&m=1">';
$noteredir = '<meta http-equiv="refresh" content="0;url=../user.php?p=pendingnote">';
$noteallredir = '<meta http-equiv="refresh" content="0;url=../user.php?p=allnote">';
$assignredir = '<meta http-equiv="refresh" content="0;url=../user.php?p=assigncal">';
$shiftredir = '<meta http-equiv="refresh" content="0;url=../user.php?p=shiftneeds">';

if(!isset($_SESSION['myusername'])){
$logged = 0;
echo $redir;
exit();
}

//----Variables
$section = "Staff";
$area = "User Management";
if(isset($_POST['admin'])) { $admin = $_POST['admin']; }
if(isset($_POST['action'])) { $action = $_POST['action']; }
if(isset($_POST['uID'])) { $uID = $_POST['uID']; }
if(isset($_POST['ip'])) { $ip = $_POST['ip']; }
$datetime = date('Y-m-d H:i:s');
$date = date('Y-m-d');
//Form Variables-------
if(isset($_POST['user']))
{
	$formuser = $_POST['user'];
	if($action == "adduser" || $action == "edituser" || $action == "editadvisor" || $action == "editmod")
	{
		$userquery = "SELECT `id` FROM `accounts` WHERE LOWER(Username) = '$formuser'";
		$userqueryrun = mysql_query($userquery);
		$userrows = mysql_num_rows($userqueryrun);
		if ($userrows == 0 || $action == 'edituser' || $action == "editadvisor" || $action == "editmod")
		{
			$user = $_POST['user'];
		}
		else
		{ 
			echo $redir5; 
			exit();
		}
	}
	$useridquery = mysql_query("SELECT `id`, `Key`, `AdminLevel` FROM `accounts` WHERE `Username` = '$formuser'");
	$userid = mysql_fetch_array($useridquery);
	if($userid['AdminLevel'] >= 2)
	{
		$adminstatquery = mysql_query("SELECT `points` FROM `cp_stat` WHERE `user_id` = '$userid[id]'");
		$adminstat = mysql_fetch_array($adminstatquery);
	}
}
$accountid = $_POST['accountid'];
$namequery = mysql_query("SELECT `Username` FROM `accounts` WHERE `id` = '$accountid'");
$name = mysql_fetch_array($namequery);
$username = $_POST['username'];
$querypart = "SELECT `id` FROM `accounts` WHERE `Username` = '$username'";
$accountquery = mysql_query($querypart);
$account = mysql_fetch_array($accountquery);
if (!$querypart) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $accountquery;
    die($message);
}
if(isset($_POST['pass'])) { $pass = $_POST['pass'];
	$secpass = strtoupper(hash('whirlpool', $pass)); }
if(isset($_POST['secureip'])) { $secureip = $_POST['secureip']; }
if(isset($_POST['rank'])) { $rank = $_POST['rank']; }
if(isset($_POST['senmod'])) { $senmod = $_POST['senmod']; }
if(isset($_POST['status'])) { $status = $_POST['status']; }
$points = $_POST['points'];
if(isset($_POST['cpl']))
{
	$cpl = implode(' = 1, ',$_POST['cpl']);
	$newcpl = implode(', ',$_POST['cpl']);
	$cplcount = COUNT($_POST['cpl']);
	$newcplval = array_fill(0,$cplcount,1);
	$cplval = implode(', ',$newcplval);
}
if(isset($_POST['cpv']))
{
	$cpv = implode(' = 1, ',$_POST['cpv']);
	$newcpv = implode(', ',$_POST['cpv']);
	$cpvcount = COUNT($_POST['cpv']);
	$newcpvval = array_fill(0,$cpvcount,1);
	$cpvval = implode(', ',$newcpvval);
}
if(isset($_POST['gl']))
{
	$gl = implode(' = 1, ',$_POST['gl']);
	$newgl = implode(', ',$_POST['gl']);
	$glcount = COUNT($_POST['gl']);
	$newglval = array_fill(0,$glcount,1);
	$glval = implode(', ',$newglval);
}
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
$shift_restrict = $_POST['shift_restrict'];
$shift_restrict = serialize($shift_restrict);
//-------End Variables

if(strtolower($admin) != strtolower($inf['Username'])) { echo "Data tampered with."; exit(); }
if($ip != $_SERVER['REMOTE_ADDR']) { echo "Data tampered with."; exit(); }

if($action == "adduser") {
	$adduserquery = "INSERT INTO `accounts` (`id`, `RegiDate`, `Username`, `Key`, `Registered`, `ConnectedTime`, `AdminLevel`, `Tutorial`) VALUES (NULL, '$datetime', '$user', '$secpass', '1', '2', '$rank', '1');";
	$runquery = mysql_query($adduserquery);
	$newuser = mysql_query("SELECT `id` FROM `accounts` WHERE `Username` = '$user'");
	$newuser_id = mysql_fetch_row($newuser);
		mysql_query("INSERT INTO `cp_access` (`user_id`) VALUES ($newuser_id[0])");
		if(isset($cpv)) { mysql_query("UPDATE `cp_access` SET $cpv = 1 WHERE `user_id` = $newuser_id[0]"); }
		if(isset($cpl)) { mysql_query("UPDATE `cp_access` SET $cpl = 1 WHERE `user_id` = $newuser_id[0]"); }
		if(isset($gl)) { mysql_query("UPDATE `cp_access` SET $gl = 1 WHERE `user_id` = $newuser_id[0]"); }
	$runquery2 = mysql_query($addaccessquery);
	if ($inf['AdminLevel'] >= 2) {
		$addstatquery = "INSERT INTO `cp_stat` (`user_id`, `points`, `shift`, `shift_complete`, `shift_partcomplete`, `shift_missed`, `type`) VALUES ('$newuser_id[0]', '0', '0', '0', '0', '0', '1');";
	} else {
		$addstatquery = "INSERT INTO `cp_stat` (`user_id`, `points`, `shift`, `shift_complete`, `shift_partcomplete`, `shift_missed`, `type`) VALUES ('$newuser_id[0]', '0', '0', '0', '0', '0', '3');";
	}
	$runquery3 = mysql_query($addstatquery);
	$details = "Created ".$user." at rank ".$rank;
	doLog($inf['id'], $section, $area, $details);
	echo $redir3;

	if (!$runquery) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $adduserquery;
		die($message);
	}
	if (!$runquery2) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $addaccessquery;
		die($message);
	}
	if (!$runquery3) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $addstatquery;
		die($message);
	}
}

if($action == "edituser")
{
	if($pass == "") { $edituserquery = "UPDATE `accounts` SET  `Username` = '$user', `SecureIP` = '$secureip', `AdminLevel` = '$rank', `AdminType` = '$type' WHERE `id` = '$uID'"; }
	if($pass != "") { $edituserquery = "UPDATE `accounts` SET  `Username` = '$user', `Key` = '$secpass', `SecureIP` = '$secureip', `AdminLevel` = '$rank', `AdminType` = '$type' WHERE `id` = '$uID'"; }

	$uaccesscheckquery = mysql_query("SELECT * FROM `cp_access` WHERE `user_id` = '$uID'");
	$uaccesscheck = mysql_num_rows($uaccesscheckquery);
	if($uaccesscheck == 0)
	{
		$editaccessquery = "INSERT INTO `cp_access` (`user_id`) VALUES ('$uID');";
		if(isset($cpv)) { mysql_query("UPDATE `cp_access` SET $cpv = 1 WHERE `user_id` = $uID"); }
		if(isset($cpl)) { mysql_query("UPDATE `cp_access` SET $cpl = 1 WHERE `user_id` = $uID"); }
		if(isset($gl)) { mysql_query("UPDATE `cp_access` SET $gl = 1 WHERE `user_id` = $uID"); }
	}
	elseif($uaccesscheck == 1)
	{
		$field_count = mysql_num_fields($uaccesscheckquery);
		for($i = 1; $i < $field_count; $i++)
		{
			$fields[$i] = mysql_field_name($uaccesscheckquery, $i);
		}
		$implode = implode(" = 0, ", $fields);
		mysql_query("UPDATE `cp_access` SET $implode = 0 WHERE `user_id` = '$uID'");
		if(isset($cpv)) { mysql_query("UPDATE `cp_access` SET $cpv = 1 WHERE `user_id` = $uID"); }
		if(isset($cpl)) { mysql_query("UPDATE `cp_access` SET $cpl = 1 WHERE `user_id` = $uID"); }
		if(isset($gl)) { mysql_query("UPDATE `cp_access` SET $gl = 1 WHERE `user_id` = $uID"); }
	}

	$ustatcheckquery = mysql_query("SELECT `user_id` FROM `cp_stat` WHERE `user_id` = '$uID'");
	$ustatcheck = mysql_num_rows($ustatcheckquery);
	if($ustatcheck == "0")
	{ 
		if ($inf['AdminLevel'] >= 2)
		{
			$editstatquery = "INSERT INTO `cp_stat` (`user_id`, `points`, `shift`, `shift_complete`, `shift_partcomplete`, `shift_missed`, `type`) VALUES ('$uID', '$points', '0', '0', '0', '0', '1');";
		}
		else
		{
			$editstatquery = "INSERT INTO `cp_stat` (`user_id`, `points`, `shift`, `shift_complete`, `shift_partcomplete`, `shift_missed`, `type`) VALUES ('$uID', '$points', '0', '0', '0', '0', '3');";
		}
	}
	elseif($ustatcheck == "1") { $editstatquery = "UPDATE `cp_stat` SET `points` = '$points', `shift_restrict` = '$shift_restrict' WHERE `user_id` = '$uID'"; }

	$runquery = mysql_query($edituserquery);
	$runquery2 = mysql_query($editstatquery);

	$details = "Edited ".$user."\'s account";
	doLog($inf['id'], $section, $area, $details);
	echo $redir3;

	if (!$runquery) {
		$message  = 'Invalid query: ('.mysql_errno().')'.mysql_error()."\n";
		$message .= 'Whole query: ' . $edituserquery;
		die($message);
	}
	if (!$runquery2) {
		$message  = 'Invalid query: ('.mysql_errno().')'.mysql_error()."\n";
		$message .= 'Whole query: ' . $editstatquery;
		die($message);
	}
}

//-------Moderators---------------

if($action == "addmoderator") {
	$addmoderator = mysql_query("UPDATE `accounts` SET `AdminLevel` = '$rank', `SeniorModerator` = '$senmod' WHERE `id` = '$account[id]'");

	if($senmod == 0) { $details = "Made ".$username." a Moderator"; }
	if($senmod == 1) { $details = "Made ".$username." a Senior Moderator"; }
	doLog($inf['id'], $section, $area, $details);
	echo $redirmod1;

	if (!$addmoderator) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $addmoderator;
		die($message);
	}
	}

if($action == "editmod") {

	if($pass == "") {
	if($rank == 1) { $edituserquery = "UPDATE `accounts` SET  `Username` = '$user', `AdminLevel` = '1', `SeniorModerator` = '0' WHERE `id` = '$uID'"; }
	if($rank == 2) { $edituserquery = "UPDATE `accounts` SET  `Username` = '$user', `AdminLevel` = '1', `SeniorModerator` = '1' WHERE `id` = '$uID'"; }
	}
	if($pass != "") {
	if($rank == 1) { $edituserquery = "UPDATE `accounts` SET  `Username` = '$user', `Key` = '$secpass', `AdminLevel` = '1', `SeniorModerator` = '0' WHERE `id` = '$uID'"; }
	if($rank == 2) { $edituserquery = "UPDATE `accounts` SET  `Username` = '$user', `Key` = '$secpass', `AdminLevel` = '1', `SeniorModerator` = '1' WHERE `id` = '$uID'"; }
	}

	$uaccesscheckquery = mysql_query("SELECT `user_id` FROM `cp_access` WHERE `user_id` = '$uID'");
	$uaccesscheck = mysql_num_rows($uaccesscheckquery);
	if($uaccesscheck == "0")
	{
		$editaccessquery = "INSERT INTO `cp_access` (`user_id`) VALUES ('$uID');";
		if(isset($cpv)) { mysql_query("UPDATE `cp_access` SET $cpv = 1 WHERE `user_id` = $uID"); }
		if(isset($cpl)) { mysql_query("UPDATE `cp_access` SET $cpl = 1 WHERE `user_id` = $uID"); }
		if(isset($gl)) { mysql_query("UPDATE `cp_access` SET $gl = 1 WHERE `user_id` = $uID"); }
	}
	elseif($uaccesscheck == "1")
	{
		mysql_query("UPDATE `cp_access` SET `punish` = 0, `refund` = 0, `ban` = 0, `cplgeneral` = 0, `cplstaff` = 0, `cplfaction` = 0, `cplfamily` = 0, `cplcr` = 0, `gladmin` = 0, `gladmingive` = 0, `gladminpay` = 0, `glban` = 0, `glbusiness` = 0, `glcontracts` = 0, `glddedit` = 0, `gldmpedit` = 0, `glfaction` = 0, `glfamily` = 0, `glfmembercount` = 0, `glgedit` = 0, `glgifts` = 0, `glhack` = 0, `glhedit` = 0, `glhouse` = 0, `glkick` = 0, `gllicenses` = 0, `glmoderator` = 0, `glmute` = 0, `glpads` = 0, `glpassword` = 0, `glpay` = 0, `glplayervehicle` = 0, `glrpspecial` = 0, `glsecurity` = 0, `glsetvip` = 0, `glshopconfirmedorders` = 0, `glshoplog` = 0, `glshoporders` = 0, `glstats` = 0, `glundercover` = 0, `glvipnamechanges` = 0, `glvipremove` = 0 WHERE `user_id` = '$uID'");
		if(isset($cpv)) { mysql_query("UPDATE `cp_access` SET $cpv = 1 WHERE `user_id` = $uID"); }
		if(isset($cpl)) { mysql_query("UPDATE `cp_access` SET $cpl = 1 WHERE `user_id` = $uID"); }
		if(isset($gl)) { mysql_query("UPDATE `cp_access` SET $gl = 1 WHERE `user_id` = $uID"); }
	}

	$ustatcheckquery = mysql_query("SELECT `user_id` FROM `cp_stat` WHERE `user_id` = '$uID'");
	$ustatcheck = mysql_num_rows($ustatcheckquery);
	if($ustatcheck == "0") { 
		if ($inf['AdminLevel'] >= 2) {
			$editstatquery = "INSERT INTO `cp_stat` (`user_id`, `points`, `shift`, `shift_complete`, `shift_partcomplete`, `shift_missed`, `type`) VALUES ('$uID', '$points', '0', '0', '0', '0', '1');"; 
		} else {
			$editstatquery = "INSERT INTO `cp_stat` (`user_id`, `points`, `shift`, `shift_complete`, `shift_partcomplete`, `shift_missed`, `type`) VALUES ('$uID', '$points', '0', '0', '0', '0', '3');";
		}
	}
	elseif($ustatcheck == "1") { $editstatquery = "UPDATE `cp_stat` SET  `points` = '$points' WHERE `user_id` = '$uID'"; }

	$runquery = mysql_query($edituserquery);
	$runquery2 = mysql_query($editstatquery);
	$runquery3 = mysql_query($editaccessquery);

	$details = "Edited ".$user."\'s account";
	doLog($inf['id'], $section, $area, $details);
	echo $redirmod1;

	if (!$runquery) {
		$message  = 'Invalid query: ('.mysql_errno().')'.mysql_error()."\n";
		$message .= 'Whole query: ' . $edituserquery;
		die($message);
	}
	if (!$runquery2) {
		$message  = 'Invalid query: ('.mysql_errno().')'.mysql_error()."\n";
		$message .= 'Whole query: ' . $editstatquery;
		die($message);
	}
	if (!$runquery3) {
		$message  = 'Invalid query: ('.mysql_errno().')'.mysql_error()."\n";
		$message .= 'Whole query: ' . $editaccessquery;
		die($message);
	}
}

if($action == "removemod") {

$removemod = mysql_query("UPDATE `accounts` SET `AdminLevel` = '0', `SeniorModerator` = '0' WHERE `id` = '$account[id]'");

$details = "Removed ".$username." as a Moderator";
doLog($inf['id'], $section, $area, $details);
echo $redirmod1;

if (!$removemod) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $removemod;
    die($message);
}
}

//--------------------------------

//-------Watchdogs----------------

if($action == "addwatchdog") {
$addmoderator = mysql_query("UPDATE `accounts` SET `Watchdog` = '1' WHERE `id` = '$account[id]'");

$details = "Made ".$username." a Watchdog";
doLog($inf['id'], $section, $area, $details);
echo $redirhelper;

if (!$addmoderator) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $addmoderator;
    die($message);
}
}

if($action == "removewatchdog") {
$removemod = mysql_query("UPDATE `accounts` SET `Watchdog` = '0' WHERE `id` = '$account[id]'");

$details = "Removed ".$username." as a Watchdog";
doLog($inf['id'], $section, $area, $details);
echo $redirhelper;

if (!$removemod) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $removemod;
    die($message);
}
}

//--------------------------------


//-----------Disabled-------------
if($action == "disabledacctupdate")
{
	if(isset($_POST['reenable']))
	{
		switch($_POST['reenable'])
		{
			case 2:
			{
				mysql_query("UPDATE `accounts` SET `Disabled` = 0 WHERE `id` = $uID");
				$details = "Re-enabled ".GetName($uID)."'s account";
				break;
			}
			case 3:
			{
				mysql_query("UPDATE `accounts` SET `Disabled` = 0, `AdminLevel` = 2 WHERE `id` = $uID");
				$details = "Reinstated ".GetName($uID)." to Junior Admin";
				break;
			}
			case 4:
			{
				mysql_query("UPDATE `accounts` SET `Disabled` = 0, `AdminLevel` = 3 WHERE `id` = $uID");
				$details = "Reinstated ".GetName($uID)." to General Admin";
				break;
			}
		}
		doLog($inf['id'], $section, $area, mysql_real_escape_string($details));
		echo '<meta http-equiv="refresh" content="0;url=../user.php?p=view&g=disabled">';
	}
}
//--------------------------------


//----------------Notes-----------
if($action == "addNote") {
$query5 = "INSERT INTO `cp_admin_notes` (`id`, `user_id`, `type`, `details`, `invoke_id`, `date`, `status`, `points`) VALUES (NULL, '$accountid', '$type', '$note', '$invokeid', '$date', '1', '$points')";
$doquery = mysql_query($query5);

if($type == 1) { $type_char = "Infraction"; }
if($type == 2) { $type_char = "Commendation"; }

$details = "Added a(n) ".$type_char." for ".$name['Username'];
doLog($inf['id'], $section, $area, $details);
echo $rediraddnote;

if (!$doquery) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query5;
    die($message);
}
}

if($action == "acceptNote") {

$pts1 = mysql_query("SELECT `points` FROM `cp_stat` WHERE `user_id` = '$accountid'");
$pts = mysql_fetch_array($pts1);

if($type == "1") { $npts = $pts['points'] - $points; }
if($type == "2") { $npts = $pts['points'] + $points; }
mysql_query("UPDATE `cp_stat` SET `points` = '$npts' WHERE `user_id` = '$accountid'");
mysql_query("UPDATE `cp_admin_notes` SET `status` = '2' WHERE `id` = '$noteID'");

if($type == 1) { $type_char = "Infraction"; }
if($type == 2) { $type_char = "Commendation"; }

$details = "Accepted the ".$type_char." on ".$name['Username'];
doLog($inf['id'], $section, $area, $details);
echo $noteredir;
}

if($action == "denyNote") {
mysql_query("DELETE FROM `cp_admin_notes` WHERE `id` = '$noteID'"); 

if($type == 1) { $type_char = "Infraction"; }
if($type == 2) { $type_char = "Commendation"; }

$details = "Denied the ".$type_char." on ".$name['Username'];
doLog($inf['id'], $section, $area, $details);
echo $noteredir;
}

if($action == "deletenote") {
mysql_query("DELETE FROM `cp_admin_notes` WHERE `id` = '$noteID'");

if($type == 1) { mysql_query("UPDATE `cp_stat` SET `points` = points + $points WHERE `user_id` = '$accountid'");
	$type_char = "Infraction"; }
if($type == 2) { mysql_query("UPDATE `cp_stat` SET `points` = points - $points WHERE `user_id` = '$accountid'");
	$type_char = "Commendation"; }

$details = "Deleted the ".$type_char." on ".$name['Username'];
doLog($inf['id'], $section, $area, $details);
echo $noteallredir;
}
//--------------Leaves-----------

if($action == "leave_add") {

$query = mysql_query("INSERT INTO `cp_leave` (`id`, `user_id`, `date_leave`, `date_return`, `reason`, `status`, `acceptedby_id`) VALUES 
(NULL, '$accountid', '$leave_date', '$return_date', '$reason', '2', $inf[id])");

$details = "Added ".GetName($accountid)." as on-leave";
doLog($inf['id'], $section, $area, $details);
echo '<meta http-equiv="refresh" content="0;url=../user.php?p=onleave">';

if (!$addmoderator) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $addmoderator;
    die($message);
}
}

if($action == "acceptLeave") {
$acceptquery = mysql_query("UPDATE `cp_leave` SET `status` = '2', `acceptedby_id` = '$acceptID' WHERE `id` = '$leaveID'");

if (!$acceptquery) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $acceptquery;
    die($message);
	}

$details = "Accepted the leave request for ".$formuser;
doLog($inf['id'], $section, $area, $details);
echo $leaveredir;
}

if($action == "denyLeave") {
$denyquery = mysql_query("DELETE FROM `cp_leave` WHERE `id` = '$leaveID'"); 

if (!$denyquery) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $denyquery;
    die($message);
	}

$details = "Denied the leave request for ".$formuser;
doLog($inf['id'], $section, $area, $details);
echo $leaveredir;
}

//--------------Checkins-----------

if($action == "acceptCheckin") {

$cin1 = mysql_query("SELECT * FROM users WHERE `aUser` = '$saUser'");
$cin = mysql_fetch_array($cin1);

$checkins1 = mysql_query("SELECT * FROM user_checkins WHERE `id` = '$sID'");
$checkinsInf = mysql_fetch_array($checkins1);

$cDate = $checkinsInf['addDate'];
$checkins = $cin['checkins'] + 1;
$npts = $cin['points'] + $sPTS;
mysql_query("UPDATE nmphosti_cms.users SET  `dCheckin` = '$cDate', `CheckinStatus` = 'Active', `checkins` = '$checkins', `points` = '$npts' WHERE `aUser` = '$saUser'");
mysql_query("UPDATE `nmphosti_cms`.`user_checkins` SET `status` = 'Accepted' WHERE `id` = '$sID'");
mysql_query("UPDATE `nmphosti_cms`.`user_checkins` SET `acceptBy` = '$editingAdmin' WHERE `id` = '$sID'");

$details = "Accepted the checkin request for user:  ".$saUser." and gave ".$sPTS." points";
doLog($inf['id'], $section, $area, $details);
echo $redir3;
}

if($action == "denyCheckin") {

mysql_query("DELETE FROM user_checkins WHERE `id` = '$sID'");
$details = "Denied the checkin request for user:  ".$saUser;
doLog($inf['id'], $section, $area, $details);
echo $redir3;
}

//-------Shifts--------

if($action == "shiftneeds") {
foreach ($shiftid as $n) {
$needs = $n - 1;
if($inf['AdminLevel'] >= 2) {
$shiftneedsquery = "UPDATE `cp_shift_blocks` SET `needs_sunday` = '$needs_sun[$needs]', `needs_monday` = '$needs_mon[$needs]', `needs_tuesday` = '$needs_tue[$needs]', `needs_wednesday` = '$needs_wed[$needs]', `needs_thursday` = '$needs_thu[$needs]', `needs_friday` = '$needs_fri[$needs]', `needs_saturday` = '$needs_sat[$needs]' WHERE `shift_id` = '$n' AND `type`='1'";
} else {
$shiftneedsquery = "UPDATE `cp_shift_blocks` SET `needs_sunday` = '$needs_sun[$needs]', `needs_monday` = '$needs_mon[$needs]', `needs_tuesday` = '$needs_tue[$needs]', `needs_wednesday` = '$needs_wed[$needs]', `needs_thursday` = '$needs_thu[$needs]', `needs_friday` = '$needs_fri[$needs]', `needs_saturday` = '$needs_sat[$needs]' WHERE `shift_id` = '$n' AND `type`='2'";
}
$runquery = mysql_query($shiftneedsquery);

$details = "Modified the shift needs";
doLog($inf['id'], $section, $area, $details);

if (!$runquery) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $shiftneedsquery;
    die($message);
	}
echo $shiftredir;
}
}

if($action == "addassign") {
foreach ($shiftid as $shift) {
if($inf['AdminLevel'] >= 2) {
$assignquery = "INSERT INTO `cp_shifts` (`id`, `user_id`, `type`, `shift_id`, `date`, `sign_up`, `status`) VALUES (NULL, '$uID', 1, '$shift', '$assigndate', '$datetime', '2')";
} else {
$assignquery = "INSERT INTO `cp_shifts` (`id`, `user_id`, `type`, `shift_id`, `date`, `sign_up`, `status`) VALUES (NULL, '$uID', 3, '$shift', '$assigndate', '$datetime', '2')";
}
$runquery = mysql_query($assignquery);
echo $assignredir;

if (!$runquery) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $assignquery;
    die($message);
	}

}
}

if($action == "assign_edit") {
if($inf['AdminLevel'] >= 2) {
$assigneditquery = "UPDATE `cp_shifts` SET `status` = '$status' WHERE `id` = '$assignid' AND `type`='1'";
} else {
$assigneditquery = "UPDATE `cp_shifts` SET `status` = '$status' WHERE `id` = '$assignid' AND `type`='3'";
}
	if($inf['AdminLevel'] >= 2) {
	if($status == "3" && $asst_req == 1) { $bonus = 1;
	mysql_query("UPDATE `cp_stat` SET `shift_complete` = shift_complete + 1, `points` = points + $bonus + 1 WHERE `user_id` = '$uID'"); }
	if($status == "3" && $asst_req == 0) { mysql_query("UPDATE `cp_stat` SET `shift_complete` = shift_complete + 1, `points` = points + $bonus + 1 WHERE `user_id` = '$uID'"); }
	if($status == "4") { mysql_query("UPDATE `cp_stat` SET `shift_partcomplete` = shift_partcomplete + 1 WHERE `user_id` = '$uID'"); }
	if($status == "5" && $bonus == 0) { mysql_query("UPDATE `cp_stat` SET `shift_missed` = shift_missed + 1, `points` = points - 1 WHERE `user_id` = '$uID'"); }
	if($status == "5" && $bonus == 2) { mysql_query("UPDATE `cp_stat` SET `shift_missed` = shift_missed + 1, `points` = points - 2 WHERE `user_id` = '$uID'"); }
	} else {
	$helper = GetHelperLevel($uID);
	if($status == "3" && $asst_req == 1) { $bonus = 1;
		if ($helper == 2) {
		mysql_query("UPDATE `cp_stat` SET `shift_complete` = shift_complete + 1, `points` = points + $bonus + 10 WHERE `user_id` = '$uID'"); 
		}
		if ($helper == 3) {
		mysql_query("UPDATE `cp_stat` SET `shift_complete` = shift_complete + 1, `points` = points + $bonus + 15 WHERE `user_id` = '$uID'"); 
		}
		if ($helper == 4) {
		mysql_query("UPDATE `cp_stat` SET `shift_complete` = shift_complete + 1, `points` = points + $bonus + 20 WHERE `user_id` = '$uID'"); 
		}
	}
	if($status == "3" && $asst_req == 0) { 
		if ($helper == 2) {
		mysql_query("UPDATE `cp_stat` SET `shift_complete` = shift_complete + 1, `points` = points + $bonus + 10 WHERE `user_id` = '$uID'");
		}
		if ($helper == 3) {
		mysql_query("UPDATE `cp_stat` SET `shift_complete` = shift_complete + 1, `points` = points + $bonus + 15 WHERE `user_id` = '$uID'");
		}
		if ($helper == 4) {
		mysql_query("UPDATE `cp_stat` SET `shift_complete` = shift_complete + 1, `points` = points + $bonus + 20 WHERE `user_id` = '$uID'");
		}
	}
	if($status == "4") { 
		if ($helper == 2) {
		mysql_query("UPDATE `cp_stat` SET `shift_partcomplete` = shift_partcomplete + 1, `points` = points + 5 WHERE `user_id` = '$uID'"); 
		}
		if ($helper == 3) {
		mysql_query("UPDATE `cp_stat` SET `shift_partcomplete` = shift_partcomplete + 1, `points` = points + 7 WHERE `user_id` = '$uID'"); 
		}
		if ($helper == 4) {
		mysql_query("UPDATE `cp_stat` SET `shift_partcomplete` = shift_partcomplete + 1, `points` = points + 10 WHERE `user_id` = '$uID'"); 
		}
	
	}
	if($status == "5" && $bonus == 0) { mysql_query("UPDATE `cp_stat` SET `shift_missed` = shift_missed + 1, `points` = points - 10 WHERE `user_id` = '$uID'"); }
	if($status == "5" && $bonus == 2) { mysql_query("UPDATE `cp_stat` SET `shift_missed` = shift_missed + 1, `points` = points - 15 WHERE `user_id` = '$uID'"); }
	}
$runquery = mysql_query($assigneditquery);

$details = "Modified assignment #".$assignid;
doLog($inf['id'], $section, $area, $details);
echo $assignredir;

if (!$runquery) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $assigneditquery;
    die($message);
}
}

if($action == "assign_add") {
if($inf['AdminLevel'] >= 2) {
$assigneditquery = "INSERT INTO `cp_shifts` (`id`, `user_id`, `type`, `shift_id`, `date`, `sign_up`, `status`) VALUES (NULL, '$uID', 1, '$shiftid', '$assigndate', '$datetime', $status)";
} else {
$assigneditquery = "INSERT INTO `cp_shifts` (`id`, `user_id`, `type`, `shift_id`, `date`, `sign_up`, `status`) VALUES (NULL, '$uID', 3, '$shiftid', '$assigndate', '$datetime', $status)";
}
	if($status == "3") { mysql_query("UPDATE `cp_stat` SET `shift_complete` = shift_complete + 1, `points` = points + 1 WHERE `user_id` = '$uID'"); }
	if($status == "4") { mysql_query("UPDATE `cp_stat` SET `shift_partcomplete` = shift_partcomplete + 1 WHERE `user_id` = '$uID'"); }
	if($status == "5") { mysql_query("UPDATE `cp_stat` SET `shift_missed` = shift_missed + 1, `points` = points - 1 WHERE `user_id` = '$uID'"); }
$runquery = mysql_query($assigneditquery);

$details = "Added details for ".GetName($uID)."\'s shift details on ".$assigndate;
doLog($inf['id'], $section, $area, $details);
echo $assignredir;

if (!$runquery) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $assigneditquery;
    die($message);
}
}

if($action == "addshiftleader") {
if($inf['AdminLevel'] >= 2) {
$shiftleaderquery = "INSERT INTO `cp_shift_leader` (`id`, `user_id`, `shift_id`, `type`) VALUES (NULL, '$leader_ID', '$shiftid', '1')";
} else {
$shiftleaderquery = "INSERT INTO `cp_shift_leader` (`id`, `user_id`, `shift_id`, `type`) VALUES (NULL, '$leader_ID', '$shiftid', '2')";
}
$runquery = mysql_query($shiftleaderquery);

echo $shiftredir;

if (!$runquery) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $shiftleaderquery;
    die($message);
}
}

if($action == "removeshiftleader") {
if($inf['AdminLevel'] >= 2) {
$removeleaderquery = "DELETE FROM `cp_shift_leader` WHERE `id` = '$shiftleadid' AND `type`='1'";
} else {
$removeleaderquery = "DELETE FROM `cp_shift_leader` WHERE `id` = '$shiftleadid' AND `type`='2'";
}
$runquery = mysql_query($removeleaderquery);

echo $shiftredir;

if (!$runquery) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $shiftleaderquery;
    die($message);
}
}
//--------------------------------


//----------Mass Emails-----------
if($action == "create_email")
{
	if($inf['AdminLevel'] >= 1338 || $inf['PR'] >= 3 || $inf['CR'] >= 3)
	{
		$subject = stripslashes($_POST['subject']);
		$subject = mysql_real_escape_string($subject);
		$message = stripslashes($_POST['message']);
		$message = mysql_real_escape_string($message);
		if($_POST['banned'] == 1) $banned = 1;
		else $banned = 0;
		if($_POST['disabled'] == 1) $disabled = 1;
		else $disabled = 0;
		if(!is_null($_POST['admins'])) $admins = serialize($_POST['admins']);
		else $admins = 0;
		if(!is_null($_POST['helpers'])) $helpers = serialize($_POST['helpers']);
		else $helpers = 0;
		if(!is_null($_POST['vips'])) $vips = serialize($_POST['vips']);
		else $vips = 0;
		if(!is_null($_POST['famed'])) $famed = serialize($_POST['famed']);
		else $famed = 0;
		if(!is_null($_POST['faction'])) $faction = serialize($_POST['faction']);
		else $faction = 0;
		if(!is_null($_POST['faction_rank'])) $faction_rank = serialize($_POST['faction_rank']);
		else $faction_rank = 0;
		if(!is_null($_POST['gang'])) $gang = serialize($_POST['gang']);
		else $gang = 0;
		if(!is_null($_POST['gang_rank'])) $gang_rank = serialize($_POST['gang_rank']);
		else $gang_rank = 0;
		if(!is_null($_POST['biz'])) $biz = serialize($_POST['biz']);
		else $biz = 0;
		if(!is_null($_POST['biz_rank'])) $biz_rank = serialize($_POST['biz_rank']);
		else $biz_rank = 0;
		if($_POST['optout'] == 1) $optout = 1;
		else $optout = 0;
		$query = "INSERT INTO `cp_mass_email` (`id`, `subject`, `message`, `creator`, `create_date`, `banned`, `disabled`, `admins`, `helpers`, `vip`, `famed`, `faction`, `faction_rank`, `gang`, `gang_rank`, `biz`, `biz_rank`, `bypass`) VALUES (NULL, '$subject', '$message', '$inf[id]', '$datetime', $banned, $disabled, '$admins', '$helpers', '$vips', '$famed', '$faction', '$faction_rank', '$gang', '$gang_rank', '$biz', '$biz_rank', $optout)";
		$runquery = mysql_query($query);
		
		if(!$runquery)
		{
			$message  = 'Invalid query: ' . mysql_error() . "<br /><br />";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
		
		echo '<meta http-equiv="refresh" content="0;url=../user.php?p=email">';
	}
}

if($action == "update_email")
{
	if($inf['AdminLevel'] >= 1338 || $inf['PR'] >= 3 || $inf['CR'] >= 3)
	{
		$subject = stripslashes($_POST['subject']);
		$subject = mysql_real_escape_string($subject);
		$message = stripslashes($_POST['message']);
		$message = mysql_real_escape_string($message);
		if($_POST['banned'] == 1) $banned = 1;
		else $banned = 0;
		if($_POST['disabled'] == 1) $disabled = 1;
		else $disabled = 0;
		if(!is_null($_POST['admins'])) $admins = serialize($_POST['admins']);
		else $admins = 0;
		if(!is_null($_POST['helpers'])) $helpers = serialize($_POST['helpers']);
		else $helpers = 0;
		if(!is_null($_POST['vips'])) $vips = serialize($_POST['vips']);
		else $vips = 0;
		if(!is_null($_POST['famed'])) $famed = serialize($_POST['famed']);
		else $famed = 0;
		if(!is_null($_POST['faction'])) $faction = serialize($_POST['faction']);
		else $faction = 0;
		if(!is_null($_POST['faction_rank'])) $faction_rank = serialize($_POST['faction_rank']);
		else $faction_rank = 0;
		if(!is_null($_POST['gang'])) $gang = serialize($_POST['gang']);
		else $gang = 0;
		if(!is_null($_POST['gang_rank'])) $gang_rank = serialize($_POST['gang_rank']);
		else $gang_rank = 0;
		if(!is_null($_POST['biz'])) $biz = serialize($_POST['biz']);
		else $biz = 0;
		if(!is_null($_POST['biz_rank'])) $biz_rank = serialize($_POST['biz_rank']);
		else $biz_rank = 0;
		if($_POST['optout'] == 1) $optout = 1;
		else $optout = 0;
		$query = "UPDATE `cp_mass_email` SET `subject` = '$subject', `message` = '$message', `banned` = $banned, `disabled` = $disabled, `admins` = '$admins', `helpers` = '$helpers', `vip` = '$vips', `famed` = '$famed', `faction` = '$faction', `faction_rank` = '$faction_rank', `gang` = '$gang', `gang_rank` = '$gang_rank', `biz` = '$biz', `biz_rank` = '$biz_rank', `bypass` = $optout WHERE `id` = $_POST[id]";
		$runquery = mysql_query($query);
		
		if(!$runquery)
		{
			$message  = 'Invalid query: ' . mysql_error() . "<br /><br />";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
		
		echo '<meta http-equiv="refresh" content="0;url=../user.php?p=email">';
	}
}

if($action == "send_email")
{
	if($inf['AdminLevel'] >= 1338 || $inf['PR'] >= 3 || $inf['CR'] >= 3)
	{
		$id = strval($_POST['id']);
		if(!is_numeric($id))
		{
			echo '<meta http-equiv="refresh" content="0;url=user.php?p=email">';
			exit;
		}
		$mailquery = mysql_query("SELECT `subject`, `message` FROM `cp_mass_email` WHERE `id` = $id");
		$mailarray = mysql_fetch_array($mailquery);
		
		require_once 'class.phpmailer.php';
		$mail = new PHPMailer;
		
		$mail->IsSMTP();                                      // Set mailer to use SMTP
		$mail->Host	    = 'mail.ng-gaming.net'; 			  // Specify main and backup server
		$mail->Port     = 587;								  // Mail port
		$mail->SMTPAuth = true;                               // Enable SMTP authentication
		$mail->Username = 'donotreply';							  // SMTP username
		$mail->Password = 'p7u9ase49CRuPH';                   // SMTP password
		$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
		$mail->SMTPDebug = 0;
		$mail->From = 'donotreply@ng-gaming.net';
		$mail->FromName = 'Next Generation Gaming';
		$mail->IsHTML(true);
		$mail->Subject = $mailarray['subject'];
		
		$message = '
    <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html style="background:#F2F2F2;">
	<head>
		<meta http-equiv="Content-type" content="text/html; charset=utf-8">
		<style type="text/css">
		* {
			margin:0;
			padding:0;
		}
		body,footer{
			color:#606060;
			font-family:Helvetica;
			font-size:15px;
			line-height:150%;
			text-align:left;
		}
		h1,h2,h3,h4,h5,h6{
			margin:0;
			padding:0;
		}
		h1{
			color:#606060 !important;
			display:block;
			font-family:Helvetica;
			font-size:40px;
			font-style:normal;
			font-weight:bold;
			line-height:100%;
			letter-spacing:-1px;
			margin:0;
			text-align:left;
		}
		h2{
			color:#404040 !important;
			display:block;
			font-family:Helvetica;
			font-size:26px;
			font-style:normal;
			font-weight:bold;
			line-height:125%;
			letter-spacing:-.75px;
			margin:0;
			text-align:left;
		}
		
		h4{
			color:#404040 !important;
			display:block;
			font-family:Helvetica;
			font-size:26px;
			font-style:normal;
			font-weight:bold;
			margin-bottom:5px;
			text-align:left;
		}
		</style>
	</head>
	<body>
		<div class="body-container" style="background:#ececec;padding:15px 0;">
			<div class="body-text" style="width:50%;margin:0 auto;">
				<img src="http://ng-gaming.net/logo.png" width="150px" height="68px">
				'.$mailarray["message"].'
				<br />
			</div>
		</div>
	</body>
	<footer>
		<div class="footer-container" style="background:#F2F2F2;;padding:15px 0;">
			<div class="footer-text" style="width:50%;margin:0 auto;">
				<em>Copyright &copy; 2013 - Next Generation Gaming, LLC
				</div>
			</div>
	</footer>
</html>
    ';
		
		$query = mysql_query(GetMassEmailRecepients($id));
		while($array = mysql_fetch_array($query))
		{
			if(filter_var($array['Email'], FILTER_VALIDATE_EMAIL))
			{
				$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!";
				$mail->MsgHTML($message);
				$mail->AddAddress($array['Email'], $array['Username']);
				$mail->Send();
				$mail->ClearAddresses();
			}
		}
		
		mysql_query("UPDATE `cp_mass_email` SET `last_sent` = NOW() WHERE `id` = $id");
		echo '<meta http-equiv="refresh" content="0;url=../user.php?p=email">';
	}
}
//--------------------------------
?>