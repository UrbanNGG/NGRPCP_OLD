<?php require('../../global/func.php');
$redir = '<meta http-equiv="refresh" content="0;url=../login.php">';
$redir2 = '<meta http-equiv="refresh" content="0;url=../flag.php?p=view">';
$redir2note1 = '<meta http-equiv="refresh" content="0;url=../flag.php?p=view&note=1">';
$redir2note2 = '<meta http-equiv="refresh" content="0;url=../flag.php?p=view&note=2">';
$redir2note3 = '<meta http-equiv="refresh" content="0;url=../flag.php?p=view&note=3">';
if(!isset($_SESSION['myusername'])){
$logged = 0;
echo $redir;
exit();
}

if($inf['AdminLevel'] < "2") {
	echo $redir;
	exit();
}

//----Variables
$section = "Staff";
$area = "Flags";
$id = $_POST['fID'];
$action = $_POST['action'];
$admin = $_POST['admin'];
$player = $_POST['player_name'];
	$playeridquery = mysql_query("SELECT `id` FROM `accounts` WHERE `Username` = '$player'");
	$player_id = mysql_fetch_array($playeridquery);
$user_id = $_POST['user_id'];
$flag = mysql_real_escape_string($_POST['flag']);
$ip = $_POST['ip'];
$date = date('Y-m-d');
$datetime = date('Y-m-d H:i:s');
//-------End Variables

if(strtolower($admin) != strtolower($inf['Username'])) { echo "Data tampered with. ERR:001"; exit(); }
if($ip != $_SERVER['REMOTE_ADDR']) { echo "Data tampered with. ERR:002"; exit(); }

if($action == "add")
{
	if($player_id[0] == "") echo $redir2note1;
	else
	{
		$query1 = "INSERT INTO `flags` (`fid`, `id`, `time`, `issuer`, `flag`) VALUES (NULL, '$player_id[0]', '$datetime', '$inf[Username]', '$flag')";

		$runquery = mysql_query($query1);
		if (!$runquery)
		{
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query1;
			die($message);
		}

		$details = "Added flag for ".$player;
		doLog($inf['id'], $section, $area, $details);
		echo $redir2note2;
	}
}

if($action == "issue") {
$query1 = "DELETE FROM `flags` WHERE `fid` = '$id'";

$runquery = mysql_query($query1);
if (!$runquery) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $query1;
    die($message);
	}

$details = "Issued flag #".$id." for ".$player;
doLog($inf['id'], $section, $area, $details);
echo $redir2;
}
?>