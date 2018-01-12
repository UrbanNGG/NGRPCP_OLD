<?php require('../global/func.php');
$redir = '<meta http-equiv="refresh" content="0;url=../login.php">';

if(!isset($_SESSION['myusername'])){
$logged = 0;
echo $redir;
exit();
}

if($inf['FMember'] != 255 && $inf['Rank'] > 4) {

//----Variables
$section = "Family";
$area = "Leadership";
$action = $_POST['action'];
$admin = $_POST['admin'];
$ip = $_POST['ip'];
$userid = $_POST['uID'];
$username = $_POST['username'];
$famname = $_POST['famname'];
$rank = $_POST['rank'];
$date = date('Y-m-d');
//-------End Variables

if(strtolower($admin) != strtolower($inf['Username'])) { echo "Data tampered with. ERR:001"; exit(); }
if($ip != $_SERVER['REMOTE_ADDR']) { echo "Data tampered with. ERR:002"; exit(); }

if($action == "uninvite")
{
	$leaderchkquery = mysql_query("SELECT `leader` FROM `cp_family` WHERE `leader` = '$userid'");
	$leaderchk = mysql_num_rows($leaderchkquery);
	if($leaderchk == 1) echo '<meta http-equiv="refresh" content="0;url=../gang.php?p=roster&note=0">';
	if($leaderchk == 0)
	{
		if(IsPlayerOnline($userid) > 0) echo '<meta http-equiv="refresh" content="0;url=../gang.php?p=roster&note=1">';
		if(IsPlayerOnline($userid) == 0)
		{
			$query = mysql_query("UPDATE `accounts` SET `FMember` = 255, `Rank` = 0 WHERE `id` = '$userid'");
			$details = "Removed ".$username." from ".$famname;
			doLog($inf['id'], $section, $area, $details);
			echo '<meta http-equiv="refresh" content="0;url=../gang.php?p=roster&note=2">';
		}
	}
}

if($action == "fam_rank")
{
	if(IsPlayerOnline($userid) > 0) echo '<meta http-equiv="refresh" content="0;url=../gang.php?p=roster&note=1">';
	if(IsPlayerOnline($userid) == 0)
	{
		if($_POST['rank'] != "NULL")
		{
			$query = mysql_query("UPDATE `accounts` SET `Rank` = '$rank' WHERE `id` = '$userid'");
			$details = "Set ".GetName($userid)."\'s rank to ".$rank." in ".GetFamName($inf['FMember']);
			doLog($inf['id'], $section, $area, $details);
		}
		if($_POST['div'] != "NULL")
		{
			$query = mysql_query("UPDATE `accounts` SET `Division` = '$_POST[div]' WHERE `id` = '$userid'");
			$details = "Set ".GetName($userid)."\'s division to ".$_POST['div']." in ".GetFamName($inf['FMember']);
			doLog($inf['id'], $section, $area, $details);
		}
		echo '<meta http-equiv="refresh" content="0;url=../gang.php?p=roster">';
	}
}

}
else {
	echo $redir;
	exit();
}
?>