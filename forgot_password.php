<?php
$redir = '<meta http-equiv="refresh" content="0;url=index.php?p=dashboard">';
session_start();
require('global/class/SQL.php');
if(isset($_SESSION['myusername'])){
$logged = 1;
echo $redir;
exit();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"> 
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
<meta http-equiv="content-type" content="text/html; charset=UTF-8" /> 
<title>CP Login</title> 
<link rel="shortcut icon" href="favicon.ico" /> 
 
	<style type='text/css' media='all'> 
		@import url( "global/css/acp.css" );
		@import url( "global/css/acp_content.css" );
	</style> 
 
	<!--[if IE]>
		<link href="global/css/acp_ie_tweaks.css" rel="stylesheet" type="text/css" />
	<![endif]--> 
    
</head> 

<body id='ipboard_body'> 
<div id='login'>
    <div id='login_controls'>
	<?php if(!isset($_POST['username'])) { ?>
		<form name='login' method='POST' action='forgot_password.php'>
                <label for='username'>Username</label>
                <input name='username' id="username" type="text" size="15">
		</div>
		<div id='login_submit'><input type='submit' name='submit' class='realbutton' value='Submit'></div>
		</form>
	<?php }
	else {
		$username = mysql_real_escape_string($_POST['username']);
		$idquery = mysql_query("SELECT `id` FROM `accounts` WHERE `Username` = '$username'");
		$id = mysql_fetch_row($idquery);
		$emailquery = mysql_query("SELECT `Email` FROM `accounts` WHERE `id` = $id[0]");
		$emailcheck = mysql_fetch_array($emailquery);
		$secquery = mysql_query("SELECT NULL FROM `sec_questions` WHERE `userid` = $id[0]");
		$seccheck = mysql_num_rows($secquery);
		if(!filter_var($emailcheck[0], FILTER_VALIDATE_EMAIL)) {
			echo '<script>alert("This account does not have a valid email address set to it! Please contact an Administrator on the forums via Administrative Request or on TeamSpeak.");</script>';
			echo '<meta http-equiv="refresh" content="0;url=../login.php">';
		}
		elseif($seccheck == 0) {
			echo '<script>alert("This account does not have a security question/answer set to it! Please contact an Administrator on the forums via Administrative Request or on TeamSpeak.");</script>';
			echo '<meta http-equiv="refresh" content="0;url=../login.php">';
		}
		else { ?>
			<form name='login' method='POST' action='proc/reset_pass.php'>
				<?php
					$query = mysql_query("SELECT `question` FROM `sec_questions` WHERE `userid` = $id[0]");
					$result = mysql_fetch_array($query);
				?>
					<label>Question</label>
					<?php echo "<span>".$result['question']."</span>"; ?>
				<br />
					<label for='answer'>Answer</label>
					<input id='answer' name='answer' type="password" size="15" style="margin-top:12px">
				</div>
				<input type='hidden' name='action' readonly='readonly' value='reset_pass'>
				<input type='hidden' name='userid' readonly='readonly' value='<?php echo $id[0]; ?>'>
				<div id='login_submit'><input type='submit' name='submit' class='realbutton' value='Submit'></div>
			</form>
		<?php }
	} ?>
</div>
<div id='copyright-login'><?php require('global/footer.php'); ?></div>
</body>
</html>