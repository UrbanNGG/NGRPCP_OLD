<?php
require('../../global/func.php');
ini_set('display_errors', 0);
$redir_email = '<meta http-equiv="refresh" content="0;url=../request.php?p=email">';
$redir_view = '<meta http-equiv="refresh" content="0;url=../request.php?p=view">';

if($inf['AdminLevel'] < 2 || $inf['Helper'] < 2 && !isset($_SESSION['myusername'])){
$logged = 0;
echo $redir;
exit();
}

//----Variables
$section = "Staff";
$area = "Requests";
$id = $_POST['id'];
$action = $_POST['action'];
$admin = $_POST['admin'];
$adminip = $_POST['ip'];
$username = $_POST['username'];
$req_ip = $_POST['req_ip'];
$userID = $_POST['userID'];
$datetime = date('Y-m-d H:i:s');
$adminactquery = mysql_query("SELECT `Username`, `Email` FROM `accounts` WHERE `id` = '$userID'");
$adminact = mysql_fetch_array($adminactquery);
$email = $_POST['email'];

include("xmlapi.php");
$email_user = $email;
$acctemail = $adminact['Email'];
$email_password = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,12);
$ip = "10.4.8.78";
$cpuser = 'nmphosti';
$root_pass = "gR5&4@)krN!sf";
$xmlapi = new xmlapi($ip);
$xmlapi->password_auth($cpuser,$root_pass);
//-------End Variables

if(strtolower($admin) != strtolower($inf['Username'])) { echo "Data tampered with. ERR:001"; exit(); }
if($adminip != $_SERVER['REMOTE_ADDR']) { echo "Data tampered with. ERR:002"; exit(); }

if($action == "req_email") {
$xmlapi->set_output = 'json';
$args = array(
	'domain' => 'ng-gaming.net',
	'regex' => $email,
);
$result = $xmlapi->api2_query($cpuser, 'Email', 'listpops', $args);

$count = 0;
foreach ($result->data as $email_reference) {
	$email_address = str_replace( '@ng-gaming.net', '', $email_reference->email);
	$email_names[] = $email_address;
	if($args['regex'] == $email_address) { $count++; }
}

if($count > 0) { echo '<meta http-equiv="refresh" content="0;url=../request.php?p=email&note=1">'; }

if($count == 0) {
$query = mysql_query("INSERT INTO `cp_cache_email` (`id`, `user_id`, `email_address`) VALUES (NULL, '$userID', '$email')");

$details = "Added email request";
doLog($inf['id'], $section, $area, $details);
echo $redir_email;
}
}

if($action == "approve")
{
	/*$newpopdata = array(
	 'domain'=>'ng-gaming.net',
	 'email'=>$email,
	 'password'=>$email_password,
	 'quota'=>'250',
	);
	$result = $xmlapi->api2_query($cpuser, "Email", "addpop", $newpopdata);
	$xmlapi->set_debug(1);*/
	
	$body = 'The staff email that you requested has been approved. Below is the information to log into the account.
	<br /><br />
	<a href="http://mail.ng-gaming.net/webmail/">http://mail.ng-gaming.net/webmail/</a><br />Username: '.$email.'@ng-gaming.net<br />Password: '.$email_password.'<br /><br />
	If you have any questions, feel free to make an Administrative Request on the forums.';
	
	SendMail($acctemail, $adminname['Username'], "Your staff email has been approved!", $body);

	$query = mysql_query("DELETE FROM `cp_cache_email` WHERE `id` = '$id'");
	$details = "Approved email ".$email."@ng-gaming.net for ".$adminname['Username'];
	doLog($inf['id'], $section, $area, $details);
	echo $redir_view;
}

if($action == "deny") {
$query = mysql_query("DELETE FROM `cp_cache_email` WHERE `id` = '$id'");
$details = "Denied email ".$email."@ng-gaming.net for ".$adminname['Username'];
doLog($inf['id'], $section, $area, $details);
echo $redir_view;
}

if($action == "wl_approve") {
$useredit = mysql_query("UPDATE `accounts` SET `SecureIP` = '$req_ip' WHERE `id` = '$id'");
$query = mysql_query("DELETE FROM `cp_whitelist` WHERE `id` = '$id'");
$details = "Approved whitelist request for ".$username." on ".$req_ip;
doLog($inf['id'], $section, $area, $details);
echo $redir_view;
}

if($action == "wl_deny") {
$query = mysql_query("DELETE FROM `cp_whitelist` WHERE `id` = '$id'");
$details = "Denied whitelist request for ".$username." on ".$req_ip;
doLog($inf['id'], $section, $area, $details);
echo $redir_view;
}
?>