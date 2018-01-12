<?php
require('../global/class/SQL.php');

function Strikeout() {
	$query = mysql_query("SELECT NULL FROM `login_strikes` WHERE `ip_address` = '$_SERVER[REMOTE_ADDR]'");
	$result = mysql_num_rows($query);
	if($result >= 5) {
		echo '<meta http-equiv="refresh" content="0;url=../ipban.php">';
		exit();
	}
}
Strikeout();

function doLog($user, $area, $details) {
	$ip = $_SERVER['REMOTE_ADDR'];
	$date = date('Y-m-d H:i:s');
	$logquery = "INSERT INTO `cp_log_general` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, '$date', '$user', '$area', '$details', '$ip')";
	$runquery = mysql_query($logquery);
	if (!$runquery) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $logquery;
		die($message);
	}
}

function SendMail($email, $emailname, $subject, $body)
{
	require 'class.phpmailer.php';

	$mail = new PHPMailer;

	$mail->IsSMTP();                                      // Set mailer to use SMTP
	$mail->Host	    = 'mail.ng-gaming.net'; 			  // Specify main and backup server
	$mail->Port     = 25;								  // Mail port
	$mail->SMTPAuth = true;                               // Enable SMTP authentication
	$mail->Username = 'donotreply';                       // SMTP username
	$mail->Password = 'p7u9ase49CRuPH';                   // SMTP password
	$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted
	$mail->SMTPDebug = 0;

	$mail->From = 'donotreply@ng-gaming.net';
	$mail->FromName = 'Next Generation Gaming, LLC.';
	if(!$emailname) $mail->AddAddress($email);			  // Without a name
	else $mail->AddAddress($email, $emailname);			  // With a name

	$mail->IsHTML(true);                                  // Set email format to HTML

	$mail->Subject = $subject;
	$mail->Body    = $body;

	if(!$mail->Send()) {
	   echo 'Email could not be sent. Please send an email to techissues@ng-gaming.net with this message.';
	   echo 'Mailer Error: ' . $mail->ErrorInfo;
	   exit;
	}

	//echo 'Email has been sent to inbox!';
}

$ip = $_SERVER['REMOTE_ADDR'];
$userid = $_POST['userid'];
$answer = $_POST['answer'];
$answer = mysql_real_escape_string($answer);
$enc_answer = hash('whirlpool', $answer);
$token = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,20);
$enc_token = hash('whirlpool', $token);
$area = "Login";

$sql = mysql_query("SELECT `answer` FROM `sec_questions` WHERE `userid` = '$userid'");
$result = mysql_fetch_row($sql);

if($result[0] == $enc_answer) {
	mysql_query("INSERT INTO `cp_cache_passreset` (`id`, `user_id`, `token`, `date`) VALUES (NULL, $userid, '$enc_token', NOW())");
	$emailquery = mysql_query("SELECT `Username`, `Email` FROM `accounts` WHERE `id` = $userid");
	$email = mysql_fetch_array($emailquery);
	$message = 'An account on Next Generation Gaming is requesting to authorize a password reset.
	<br /><br />
	If you made this request and would like to approve this request, please visit this link: <a href="http://127.0.0.1/cp//confirm.php?token='.$token.'&type=3">http://127.0.0.1/cp//confirm.php?token='.$token.'&type=3</a>
	<br /><br />
	If this request was not made by you, you can ignore this email and the request will expire in 24 hours from the time of the request being submitted.';
	SendMail($email['Email'], $email['Username'], "Your password reset requires approval!", $message);
	$details = 'Sent password recovery email';
	doLog($userid, $area, $details);
	echo '<meta http-equiv="refresh" content="0;url=../login.php?note=4">';
	exit();
}
else {
	echo '<meta http-equiv="refresh" content="0;url=../login.php?note=3">';
	exit();
}
?>