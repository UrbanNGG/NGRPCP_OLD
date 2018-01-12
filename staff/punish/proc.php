<?php require('../../global/func.php');
$redir = '<meta http-equiv="refresh" content="0;url=../login.php">';
$redir2 = '<meta http-equiv="refresh" content="0;url=../punish.php?p=view&o=1">';
$redir2e1 = '<meta http-equiv="refresh" content="0;url=../punish.php?p=view&o=1&e=1">';
$redir2e2 = '<meta http-equiv="refresh" content="0;url=../punish.php?p=view&o=1&e=2">';
$rediradmin = '<meta http-equiv="refresh" content="0;url=../punish.php?p=add&e=1">';

if(!isset($_SESSION['myusername'])){
$logged = 0;
echo $redir;
exit();
}

if($inf['AdminLevel'] > 1 || $access['punish'] == 1) {

//----Variables
if(isset($_POST['pID'])) { $id = $_POST['pID']; }
if(isset($_POST['action'])) { $action = $_POST['action']; }
if(isset($_POST['admin'])) { $admin = $_POST['admin']; }
$section = "Staff";
$area = "Punishments";
if(isset($_POST['adminid'])) { $adminID = $_POST['adminid']; }
if(isset($_POST['player_name'])) { $player = $_POST['player_name'];
$playeridquery = "SELECT `id`, `AdminLevel` FROM `accounts` WHERE `Username` = '$player'";
$playername = mysql_query($playeridquery);
$player_id = mysql_fetch_array($playername); }
if(isset($_POST['user_id'])) { $user_id = $_POST['user_id']; }
if(isset($_POST['ip'])) { $ip = $_POST['ip']; }
$date = date('Y-m-d');
$datetime = date('Y-m-d H:i:s');
if(isset($_POST['p_rules'])) { $rule = $_POST['p_rules']; }
if(isset($_POST['p_prison'])) { $prison = StripNumber($_POST['p_prison']); }
if(isset($_POST['p_warn'])) { $warn = $_POST['p_warn']; }
if(isset($_POST['p_fine'])) { $fine = StripNumber($_POST['p_fine']); }
if(isset($_POST['p_wepreset'])) { $wepreset = StripNumber($_POST['p_wepreset']); }
if(isset($_POST['p_ban'])) { $ban = $_POST['p_ban']; }
if(isset($_POST['p_punishment'])) { $punishment = $_POST['p_punishment']; }
if(isset($_POST['p_link'])) { $link = $_POST['p_link']; }
//-------End Variables

if(strtolower($admin) != strtolower($inf['Username'])) { echo "Data tampered with. ERR:001"; exit(); }
if($ip != $_SERVER['REMOTE_ADDR']) { echo "Data tampered with. ERR:002"; exit(); }

if($action == "add") {
if($player_id['AdminLevel'] > 1) {
echo $rediradmin;
}
if($player_id['AdminLevel'] < 2) {
if($punishment != "") {
$query1 = "INSERT INTO `cp_punishment` (`id`, `player_id`, `date_added`, `addedby_id`, `reason`, `status`, `prison`, `warn`, `fine`, `ban`, `wep_restrict`, `other_punish`, `link`) VALUES (NULL, '$player_id[id]', '$date', '$adminID', '$rule', '1', '$prison', '$warn', '$fine', '$ban', '$wepreset', '$punishment', '$link')";

$flagquery = mysql_query("INSERT INTO `flags` (`fid`, `id`, `time`, `issuer`, `flag`) VALUES (NULL, '$player_id[id]', '$datetime', 'CP', '$punishment')");
}
else {
$query1 = "INSERT INTO `cp_punishment` (`id`, `player_id`, `date_added`, `addedby_id`, `reason`, `status`, `prison`, `warn`, `fine`, `ban`, `wep_restrict`, `other_punish`, `link`) VALUES (NULL, '$player_id[id]', '$date', '$adminID', '$rule', '1', '$prison', '$warn', '$fine', '$ban', '$wepreset', '$punishment', '$link')";
}
$runquery = mysql_query($query1);

if (!$runquery) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query1;
    die($message);
	}

$details = "Added punishment for ".$player;
doLog($inf['id'], $section, $area, $details);
echo $redir2;
}
}

if($action == "edit") {
if($player_id['AdminLevel'] > 1) {
echo $redir2e2;
}
if($player_id['AdminLevel'] < 2) {
$query1 = "UPDATE `cp_punishment` SET `player_id` = '$player_id[id]', `reason` = '$rule', `prison` = '$prison', `warn` = '$warn', `fine` = '$fine', `ban` = '$ban', `wep_restrict` = '$wepreset', `other_punish` = '$punishment', `link` = '$link' WHERE `id` = $id";

$runquery = mysql_query($query1);

if (!$runquery) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query1;
    die($message);
	}

$details = "Edited punishment #".$id." on ".$player;
doLog($inf['id'], $section, $area, $details);
echo $redir2;
}
}

if($action == "issue") {
$p_namequery = mysql_query("SELECT `Online`, `Username` FROM `accounts` WHERE `id` = '$user_id'");
$p_name = mysql_fetch_array($p_namequery);

if($p_name['Online'] == 0) {
$query1 = "UPDATE `cp_punishment` SET `status` = '2', `date_issued` = '$date', `issuedby_id` = '$adminID' WHERE `id` = $id";

$p_userquery = mysql_query("SELECT `JailTime`, `Warnings` FROM `accounts` WHERE `id` = '$user_id'");
$p_user = mysql_fetch_row($p_userquery);
if($prison > 0) { $prisontime = $prison * 60;
	$punishquery = "UPDATE `accounts` SET `JailTime` += '$prisontime', `PrisonedBy` = '$admin', `PrisonReason` = '[OOC] (CP#$id) $rule' WHERE `id` = $user_id";
	mysql_query($punishquery);
	$file = "admin.log";
	$content = $p_name['Username']." has been prisoned by ".$inf['Username'].", reason: (CP#".$id.") ".$rule;
	LogFile($logdir,$file,$content);
	}
if($warn == 1) { $punishquery = "UPDATE `accounts` SET `Warnings` = Warnings+1 WHERE `id` = $user_id";
	mysql_query($punishquery);
	$file = "admin.log";
	$content = $p_name['Username']." has been warned by ".$inf['Username'].", reason: (CP#".$id.") ".$rule;
	LogFile($logdir,$file,$content);
	}
if($fine > 0) { $punishquery = "UPDATE `accounts` SET `Money` = Money-$fine WHERE `id` = $user_id";
	mysql_query($punishquery);
	$file = "admin.log";
	$content = $p_name['Username']." was fined $".number_format($fine)." by ".$inf['Username'].", reason: (CP#".$id.") ".$rule;
	LogFile($logdir,$file,$content);
	}
if($ban == 1) { $punishquery = "UPDATE `accounts` SET `Band` = '1' WHERE `id` = $user_id";
	mysql_query($punishquery);
	$file = "ban.log";
	$content = $p_name['Username']." was banned by ".$inf['Username'].", reason: (CP#".$id.") ".$rule;
	LogFile($logdir,$file,$content);
	}
if($wepreset > 0) { $punishquery = "UPDATE `accounts` SET `WRestricted` += $wepreset WHERE `id` = $user_id";
	mysql_query($punishquery);
	$file = "admin.log";
	$content = $p_name['Username']." has been weapon restricted for ".$wepreset." hours by ".$inf['Username'].", reason: (CP#".$id.") ".$rule;
	LogFile($logdir,$file,$content);
	}
$punishquery = "UPDATE `accounts` SET `Online` = '0' WHERE `id` = $user_id";

$runquery = mysql_query($query1);
$runquery2 = mysql_query($punishquery);

$details = "Issued punishment #".$id." on ".$p_name['Username'];
doLog($inf['id'], $section, $area, $details);
echo $redir2;

if (!$runquery) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query1;
    die($message);
	}
if (!$runquery2) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $punishquery;
    die($message);
	}
}

if($p_name['Online'] != 0) {
echo $redir2e1;
}
}

if($action == "remove") {
$query1 = "UPDATE `cp_punishment` SET `status` = '3', `date_issued` = '$date', `issuedby_id` = '$adminID' WHERE `id` = $id";

$runquery = mysql_query($query1);
if (!$runquery) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query1;
    die($message);
	}

$details = "Removed punishment #".$id." on ".$player;
doLog($inf['id'], $section, $area, $details);
echo $redir2;
}

}
else {
	echo $redir;
	exit();
}
?>