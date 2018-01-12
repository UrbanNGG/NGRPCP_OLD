<?php
if(isset($_POST['action']) && $_POST['action'] == "newmail")
{
	if($_POST['email_new_rep'] == $_POST['email_new'])
	{
		$token = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,20);
		$query = "INSERT INTO `cp_cache_email` (`id`, `date`, `user_id`, `email_address`, `token`) VALUES (NULL, NOW(), '$_POST[userid]', '$_POST[email_new]', '$token')";
		$db_insert = mysql_query($query);

		$message = 'An account on Next Generation Gaming is requesting to use this email address.
		<br /><br />
		If you made this request and would like to approve this email for use on the account, please visit this link: <a href="http://127.0.0.1/cp//emailconfirm.php?token='.$token.'&confirm=1">http://127.0.0.1/cp//emailconfirm.php?token='.$token.'&confirm=1</a>
		<br /><br />
		If this request was not made by you, please visit this link to cancel the request: <a href="http://127.0.0.1/cp//emailconfirm.php?token='.$token.'&confirm=0">http://127.0.0.1/cp//emailconfirm.php?token='.$token.'&confirm=0</a>';
		
		SendMail($_POST['email_new'], $inf['Username'], "Your email address requires approval!", $message);
		
		$note = "An authorization code has been sent to your email address. The code will automatically expire after one hour.";
	}
	else $note = "<span style='color:red'>The email address was not entered correctly.</span>";
}
if(isset($_POST['action']) && $_POST['action'] == "updatemail")
{
	if($_POST['email_new_rep'] == $_POST['email_new'])
	{
		$token = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,20);
		$query = "INSERT INTO `cp_cache_email` (`id`, `date`, `user_id`, `email_address`, `token`) VALUES (NULL, NOW(), '$_POST[userid]', '$_POST[email_new]', '$token')";
		$db_insert = mysql_query($query);

		$message = 'An account on Next Generation Gaming is requesting to use a new email address.
		<br /><br />
		If you made this request and would like to approve this email for use on the account, please visit this link: <a href="http://127.0.0.1/cp//emailconfirm.php?token='.$token.'&confirm=1">http://127.0.0.1/cp//emailconfirm.php?token='.$token.'&confirm=1</a>
		<br /><br />
		If this request was not made by you, please visit this link to cancel the request: <a href="http://127.0.0.1/cp//emailconfirm.php?token='.$token.'&confirm=0">http://127.0.0.1/cp//emailconfirm.php?token='.$token.'&confirm=0</a>';
		
		SendMail($_POST['email_new'], $inf['Username'], "Your email address requires approval!", $message);
		
		$note = "An authorization code has been sent to your email address. The code will automatically expire after one hour.";
	}
	else $note = "<span style='color:red'>The email address was not entered correctly.</span>";
}
?>

			<div id='content_wrap'>
				<ol id='breadcrumb'><li><?php echo $section; ?> > Update Email Address</li></ol>
				<div class='section_title'><h2>My Email Address</h2></div>
			<div class='acp-box'>
				<h3>Update Email Address</h3>
					<?php if(isset($note)) { echo $note; }
					$cachequery = mysql_query("SELECT `id` FROM `cp_cache_email` WHERE `user_id` = '$inf[id]'");
					$cache = mysql_fetch_row($cachequery);
					if($inf['id'] == $cache['0']) { echo "There is currently an email pending for this account."; }
					else { ?>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
				<form action="index.php?p=email" method="POST">
					<?php if($inf['Email'] == "") { ?>
						<tr><td>New Email Address</td><td><input type="text" name="email_new" length="64"></td></tr>
						<tr class="tablerow1"><td>Repeat Email Address</td><td><input type="text" name="email_new_rep" length="64"></td></tr>
						<tr class="acp-actionbar"><td colspan="2" align="center"><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"><input type="hidden" name="action" value="newmail"><input type="submit" class="button" value="Submit"></td></tr>
					<?php }
					else { ?>
						<tr class="tablerow1"><td>Current Email Address</td><td><input type="text" name="email_cur" length="64"></td></tr>
						<tr><td>New Email Address</td><td><input type="text" name="email_new" length="64"></td></tr>
						<tr class="tablerow1"><td>Repeat Email Address</td><td><input type="text" name="email_new_rep" length="64"></td></tr>
						<tr class="acp-actionbar"><td colspan="2" align="center"><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"><input type="hidden" name="action" value="updatemail"><input type="submit" class="button" value="Submit"></td></tr>
					<?php } ?>
				</form>
			</table>
				<?php } ?>
			</div></div>