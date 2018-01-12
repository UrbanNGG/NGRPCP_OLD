<?php
if(isset($_POST['action']) && $_POST['action'] == "newmail") {
	if($_POST['email_new_rep'] == $_POST['email_new']) {
	if(filter_var($_POST['email_new'], FILTER_VALIDATE_EMAIL)) {
	$token = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,20);
	$query = "INSERT INTO `cp_cache_email` (`id`, `user_id`, `email_address`, `token`) VALUES (NULL, '$_POST[userid]', '$_POST[email_new]', '$token')";
	$db_insert = mysql_query($query);

	$message = 'An account on Next Generation Gaming is requesting to use this email address.
	<br /><br />
	If you made this request and would like to approve this email for use on the account, please visit this link: <a href="http://127.0.0.1/cp//emailconfirm.php?token='.$token.'&confirm=1">http://127.0.0.1/cp//emailconfirm.php?token='.$token.'&confirm=1</a>
	<br /><br />
	If this request was not made by you, please visit this link to cancel the request: <a href="http://127.0.0.1/cp//emailconfirm.php?token='.$token.'&confirm=0">http://127.0.0.1/cp//emailconfirm.php?token='.$token.'&confirm=0</a>';
	
	SendMail($_POST['email_new'], $inf['Username'], "Your email address requires approval!", $message);
	
	$note = "An authorization code has been sent to your email address.";
	}
	else {
		echo "<script type='text/javascript'>
			alert(This email is invalid!);
		</script>";
	}
	}
	else {
	$note = "<span style='color:red'>The email address was not entered correctly.</span>";
	}
}
if(isset($_POST['action']) && $_POST['action'] == "updatemail") {
	if($_POST['email_new_rep'] == $_POST['email_new']) {
	$token = substr(str_shuffle(str_repeat('ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789',5)),0,20);
	$query = "INSERT INTO `cp_cache_email` (`id`, `user_id`, `email_address`, `token`) VALUES (NULL, '$_POST[userid]', '$_POST[email_new]', '$token')";
	$db_insert = mysql_query($query);

	$message = 'An account on Next Generation Gaming is requesting to use a new email address.
	<br /><br />
	If you made this request and would like to approve this email for use on the account, please visit this link: <a href="http://127.0.0.1/cp//emailconfirm.php?token='.$token.'&confirm=1">http://127.0.0.1/cp//emailconfirm.php?token='.$token.'&confirm=1</a>
	<br /><br />
	If this request was not made by you, please visit this link to cancel the request: <a href="http://127.0.0.1/cp//emailconfirm.php?token='.$token.'&confirm=0">http://127.0.0.1/cp//emailconfirm.php?token='.$token.'&confirm=0</a>';
	
	SendMail($_POST['email_new'], $inf['Username'], "Your email address requires approval!", $message);
	
	$note = "An authorization code has been sent to your email address.";
	}
	else {
	$note = "<span style='color:red'>The email address was not entered correctly.</span>";
	}
}
if(isset($_POST['action']) && $_POST['action'] == "update_gtalk") {
	mysql_query("UPDATE `cp_stat` SET `gtalk` = '$_POST[gtalk]' WHERE `user_id` = $_POST[userid]");
	$gtalknote = "Your GTalk address has been updated.";
}
?>

			<div id='content_wrap'>
				<ol id='breadcrumb'><li><?php echo $section; ?> > Contact Information</li></ol>
				<div class='section_title'><h2>My Contact Information</h2></div>
				<?php if(isset($gtalknote)) { echo "<div class='acp-message'>$gtalknote</div>"; } ?>
				<div class='acp-box'>
				<h3>Update Email Address</h3>
					<?php if(isset($note)) { echo $note; }
					$cachequery = mysql_query("SELECT `id` FROM `cp_cache_email` WHERE `user_id` = '$inf[id]'");
					$cache = mysql_fetch_row($cachequery);
					if($inf['id'] == $cache['0']) { echo "There is currently an email pending for this account."; }
					else { ?>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
				<form id="email" action="index.php?p=contact" method="POST" onsubmit="javascript:return validate('email','email_new');">
					<?php if($inf['Email'] == "") { ?>
						<tr><td>New Email Address</td><td><input type="text" id="email_new" name="email_new" length="64"></td></tr>
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
				</div>
				<div class='acp-box'>
				<?php $seccheckquery = mysql_query("SELECT NULL FROM `sec_questions` WHERE `userid` = $inf[id]");
				$seccheck = mysql_num_rows($seccheckquery); ?>
				<h3><?php if($seccheck == 0) { echo "Add Security Question"; } else { echo "Update Security Question"; } ?></h3>
				<?php if(isset($_GET['n']) && $_GET['n'] == 1) { echo "<div class='acp-error'>Your current answer is incorrect!</div>"; }
				if(isset($_GET['n']) && $_GET['n'] == 2) { echo "<div class='acp-message'>A confirmation message has been sent to your email address.</div>"; } ?>
				<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
					<form action="index/proc.php" method="POST">
						<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
						<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
						<?php if($seccheck == 0) { ?>
							<tr><td>New Security Question</td><td><input type="text" name="question" length="64"></td></tr>
							<tr class="tablerow1"><td>Answer</td><td><input type="text" name="answer" length="64"></td></tr>
							<tr class="acp-actionbar"><td colspan="2" align="center"><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"><input type="hidden" name="action" value="secquestion"><input type="submit" class="button" value="Submit"></td></tr>
						<?php }
						else { ?>
							<tr class="tablerow1"><td>Current Security Answer</td><td><input type="text" name="curanswer" length="64"></td></tr>
							<tr><td>New Security Question</td><td><input type="text" name="question" length="64"></td></tr>
							<tr class="tablerow1"><td>New Security Answer</td><td><input type="text" name="answer" length="64"></td></tr>
							<tr class="acp-actionbar"><td colspan="2" align="center"><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"><input type="hidden" name="action" value="secquestion"><input type="submit" class="button" value="Submit"></td></tr>
						<?php } ?>
					</form>
				</table>
				</div>
				<?php if($inf['AdminLevel'] > 1) { ?>
				<div class='acp-box'>
					<h3>Update Timezone</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
					<form action="index/proc.php" method="POST">
						<tr class="tablerow1"><td width='50%'><label for="tz">Timezone</label></td><td width='50%'><select name='timezone' id='tz'>
							<?php
							$list = DateTimeZone::listAbbreviations();
							$idents = DateTimeZone::listIdentifiers();

							$data = $offset = $added = array();
							foreach ($list as $abbr => $info)
							{
								foreach ($info as $zone)
								{
									if (!empty($zone['timezone_id']) AND !in_array($zone['timezone_id'], $added) AND in_array($zone['timezone_id'], $idents))
									{
										$z = new DateTimeZone($zone['timezone_id']);
										$c = new DateTime(null, $z);
										$zone['time'] = $c->format('g:i A');
										$data[] = $zone;
										$offset[] = $z->getOffset($c);
										$added[] = $zone['timezone_id'];
									}
								}
							}
							
							function formatOffset($offset)
							{
								$hours = $offset / 3600;
								$remainder = $offset % 3600;
								$sign = $hours > 0 ? '+' : '-';
								$hour = (int) abs($hours);
								$minutes = (int) abs($remainder / 60);

								if ($hour == 0 AND $minutes == 0) {
									$sign = ' ';
								}
								return 'GMT ' . $sign . $hour;
							}

							array_multisort($offset, SORT_ASC, $data);
							$options = array();
							foreach ($data as $key => $row)
							{
								$options[$row['timezone_id']] = $row['timezone_id'].' ('.formatOffset($row['offset']).') -- '. $row['time'];
								if($stat['timezone'] == $row['timezone_id'])
								{
									echo "<option value='".$stat['timezone']."' selected='selected'>".$options[$row['timezone_id']]."</option>";
								}
								else if($row['timezone_id'] == "America/Chicago")
								{
									echo "<option value='".$row['timezone_id']."' selected='selected'>".$options[$row['timezone_id']]."</option>";
								}
								else
								{
									echo "<option value='".$row['timezone_id']."'>".$options[$row['timezone_id']]."</option>";
								}
							}
							?>
						</select></td></tr>
						<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
						<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
						<tr class="acp-actionbar"><td colspan="2" align="center"><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"><input type="hidden" name="action" value="update_timezone"><input type="submit" class="button" value="Submit"></td></tr>
					</form>
					</table>
				</div>
				<div class='acp-box'>
					<h3>Update GTalk Address</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
					<form action="index.php?p=contact" method="POST">
						<tr class="tablerow1"><td>GTalk Address</td><td><input type="text" name="gtalk" length="64"></td></tr>
						<tr class="acp-actionbar"><td colspan="2" align="center"><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"><input type="hidden" name="action" value="update_gtalk"><input type="submit" class="button" value="Submit"></td></tr>
					</form>
					</table>
				</div>
				<div class='acp-box'>
					<h3>Update PayPal Address</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
					<form action="index/proc.php" method="POST">
						<tr class="tablerow1"><td>PayPal Address</td><td><input type="text" name="paypal" length="64"></td></tr>
						<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
						<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
						<tr class="acp-actionbar"><td colspan="2" align="center"><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"><input type="hidden" name="action" value="update_paypal"><input type="submit" class="button" value="Submit"></td></tr>
					</form>
					</table>
				</div>
				<?php } ?>
			</div>