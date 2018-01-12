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
$area = "Players";
$id = $_POST['fID'];
$action = $_POST['action'];
$admin = $_POST['admin'];
$player = $_POST['player_name'];
$user_id = $_POST['user_id'];
$password = $_POST['password'];
$passhash = strtoupper(hash('whirlpool', $password));
$ip = $_POST['ip'];
$date = date('Y-m-d');
$datetime = date('Y-m-d H:i:s');
//-------End Variables

if(strtolower($admin) != strtolower($inf['Username'])) { echo "Data tampered with. ERR:001"; exit(); }
if($ip != $_SERVER['REMOTE_ADDR']) { echo "Data tampered with. ERR:002"; exit(); }

if($action == "changepass") {
	$query = "UPDATE `accounts` SET `Key` = '$passhash' WHERE `id` = '$user_id'";

	$runquery = mysql_query($query);
	if (!$runquery) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $query;
		die($message);
	}

	$details = "Changed ".GetName($user_id)."\'s password";
	doLog($inf['id'], $section, $area, $details);
	echo $redir2;
}
?>