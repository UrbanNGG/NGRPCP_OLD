<?php require('../global/func.php');
$redir = '<meta http-equiv="refresh" content="0;url=../login.php">';

if(!isset($_SESSION['myusername'])){
$logged = 0;
echo $redir;
exit();
}

if($inf['Leader'] != -1) {

//----Variables
$section = "Faction";
$area = "Leadership";
$action = $_POST['action'];
$admin = $_POST['admin'];
$ip = $_POST['ip'];
$userid = $_POST['uID'];
$username = $_POST['username'];
$facname = $_POST['facname'];
$rank = $_POST['rank'];
$div = $_POST['div'];
$date = date('Y-m-d');
//-------End Variables

if(strtolower($admin) != strtolower($inf['Username'])) { echo "Data tampered with. ERR:001"; exit(); }
if($ip != $_SERVER['REMOTE_ADDR']) { echo "Data tampered with. ERR:002"; exit(); }

if($action == "uninvite") {
$leaderchkquery = mysql_query("SELECT `Leader` FROM `accounts` WHERE `id` = '$userid'");
$leaderchk = mysql_fetch_array($leaderchkquery);
if($leaderchk[0] > -1) { echo '<meta http-equiv="refresh" content="0;url=../faction.php?p=roster&note=0">'; }
if($leaderchk[0] == -1) {
if(IsPlayerOnline($userid) > 0) { echo '<meta http-equiv="refresh" content="0;url=../faction.php?p=roster&note=1">'; }
if(IsPlayerOnline($userid) == 0) {
$query = mysql_query("UPDATE `accounts` SET `Member` = -1, `Rank` = -1, `Division` = 255 WHERE `id` = '$userid'");
$details = "Removed ".$username." from ".$facname;
doLog($inf['id'], $section, $area, $details);
echo '<meta http-equiv="refresh" content="0;url=../faction.php?p=roster&note=2">';
}
}
}

if($action == "fac_adjust")
{
	if(IsPlayerOnline($userid) > 0) echo '<meta http-equiv="refresh" content="0;url=../faction.php?p=roster&note=1">';
	if(IsPlayerOnline($userid) == 0)
	{
		if($rank != "NULL")
		{
			$query = mysql_query("UPDATE `accounts` SET `Rank` = '$rank' WHERE `id` = '$userid'");
			$details = "Set ".GetName($userid)."\'s rank to ".$rank." in the ".GetFacName($inf['Member']);
			doLog($inf['id'], $section, $area, $details);
		}
		if($div != "NULL")
		{
			$query = mysql_query("UPDATE `accounts` SET `Division` = '$div' WHERE `id` = '$userid'");
			$details = "Set ".GetName($userid)."\'s division to ".$div." in the ".GetFacName($inf['Member']);
			doLog($inf['id'], $section, $area, $details);
		}
		echo '<meta http-equiv="refresh" content="0;url=../faction.php?p=roster">';
	}
}

}
else {
	echo $redir;
	exit();
}
?>