<?php require('global/func.php');
require('index/l_nav.php');
$redir = '<meta http-equiv="refresh" content="0;url=login.php">';

if(!isset($_SESSION['myusername'])){
$logged = 0;
echo $redir;
exit();
}

if(isset($_POST['action']) && $_POST['action'] == "earlyreturn") {
$date = date('Y-m-d');
$admin = $_POST['admin'];
$ip = $_POST['ip'];
$id = $_POST['leaveid'];
$query = mysql_query("UPDATE `cp_leave` SET `date_return` = '$date' WHERE `id` = '$id'");
echo '<meta http-equiv="refresh" content="0;url=index.php?p=dashboard">';
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php head($inf); ?>
</head>

	<div id='page_body'>
		<div id='main_content'> 
			<div id='content_wrap'>
				<div class='section_title'><h2>On-Leave</h2></div>
			<div class='acp-box'>
				<?php
				$leavequery = mysql_query("SELECT * FROM `cp_leave` WHERE `id` = '$_GET[id]'");
				$leave = mysql_fetch_array($leavequery);
				?>
					<p>You are currently marked on-leave.<br /><br />
					<form method='POST' action='onleave.php'>
						<input type='hidden' name='action' readonly='readonly' value='earlyreturn'>
						<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
						<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
						<input type='hidden' name='uID' readonly='readonly' value='<?php echo $leave['user_id']; ?>'>
						<input type='hidden' name='leaveid' readonly='readonly' value='<?php echo $leave['id']; ?>'>
						<input class='submit' type='submit' value='Click here if you have returned early.'>
					</form>
					</p>
	<div class='acp-actionbar'></div>
			</div></div>
		<div class='acp-box'>
			<div id='copyright'></div>
		</div>
		</div>
	</div>
</body>
</html>