<?php require('../global/func.php');
$redir = '<meta http-equiv="refresh" content="0;url=../login.php">';

if(!isset($_SESSION['myusername'])){
$logged = 0;
echo $redir;
exit();
}

//----Variables
$section = "General";
$area = "Business";
$action = $_POST['action'];
$admin = $_POST['admin'];
$ip = $_POST['ip'];
$userid = $_POST['uID'];
$username = $_POST['username'];
$bizname = $_POST['bizname'];
$rank = $_POST['rank'];
$date = date('Y-m-d');
//-------End Variables

if(strtolower($admin) != strtolower($inf['Username'])) { echo "Data tampered with. ERR:001"; exit(); }
if($ip != $_SERVER['REMOTE_ADDR']) { echo "Data tampered with. ERR:002"; exit(); }

if($action == "uninvite" && $inf['BusinessRank'] >= Biz($inf['Business'], "MinInviteRank"))
{
	$leaderchkquery = mysql_query("SELECT `BusinessRank` FROM `accounts` WHERE `id` = '$userid'");
	$leaderchk = mysql_fetch_array($leaderchkquery);
	if($leaderchk[0] >= $inf['BusinessRank']) { echo '<meta http-equiv="refresh" content="0;url=../business.php?p=roster">'; }
	else
	{
		if(IsPlayerOnline($userid) > 0)
		{
			echo '<script>alert("You cannot remove an employee of equal or higher rank!");</script>';
			echo '<meta http-equiv="refresh" content="0;url=../business.php?p=roster">';
		}
		if(IsPlayerOnline($userid) == 0)
		{
			$query = mysql_query("UPDATE `accounts` SET `Business` = -1, `BusinessRank` = -1 WHERE `id` = '$userid'");
			$details = "Removed ".$username." from ".$bizname;
			doLog($inf['id'], $section, $area, $details);
			echo '<script>alert("Employee removed successfully!");</script>';
			echo '<meta http-equiv="refresh" content="0;url=../business.php?p=roster">';
		}
	}
}

else if($action == "adjust" && $inf['BusinessRank'] >= Biz($inf['Business'], "MinGiveRankRank")) {
	$query = mysql_query("UPDATE `accounts` SET `BusinessRank` = $rank WHERE `id` = '$userid'");
	$details = "Set ".GetName($userid)."\'s rank to ".$rank." in the ".$bizname;
	doLog($inf['id'], $section, $area, $details);
	echo '<meta http-equiv="refresh" content="0;url=../business.php?p=roster">';
}

else {
	echo $redir;
	exit();
}
?>