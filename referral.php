<?php
	if(isset($_GET['rid']))
	{
		require('global/class/SQL.php');
		$rid = mysql_real_escape_string($_GET['rid']);
		$query = mysql_query("SELECT `Username` FROM `accounts` WHERE `referral_id` = '$rid'");
		$count = mysql_num_rows($query);
		if($count > 0)
		{
			$result = mysql_fetch_array($query);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
	<?php require('global/head.php'); ?>
</head>

<body id='ipboard_body'>
<p id="admin_bar"></p>
<div id='header'>
	<div id='branding'>
		<a href="http://<?php echo $_SERVER['SERVER_NAME']; ?>"><img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/logo.png' alt='Logo' /></a>
	</div>
</div>

<div id='page_body'>
	<div id='main_content'> 
	<div id='content_wrap'>
	  <ol id='breadcrumb'>
		<li>Referrals</li>
	  </ol>
	  <div class='section_title'>
		<h2>Referrals</h2>
	  </div>
	  <div class='acp-box'>
		<h3>Referral Information</h3>
		<p>You have been referred to Next Generation Gaming by <?php echo $result['Username']; ?>! <br><br>Your next step is to register an account with us on San Andreas Multiplayer.</p>
		</div>
		<br>
		<div class='acp-box'>
		<h3>Registration Instructions</h3>
		<table>
		<tr class='tablerow1'>
			<td>
				<div style="border:1px solid;box-shadow:1px 3px 3px #ccc;color:#2b5b8c;width:140px;height:140px;margin:auto;display: block;">
				<img style="height:140px;width:140px;" src='http://127.0.0.1/cp//global/images/all/inf1.png'>
				</div>
			</td>
			<td><span style='font-size:28px;color:#333;'>1</span></td>
			<td><p><b>Install GTA: San Andreas & San Andreas Multiplayer</b><br><br>You must have GTA: San Andreas installed to be able to install San Andreas Multiplayer. If you do have the game, you can download SA-MP via <a href="http://www.sa-mp.com/download.php">http://www.sa-mp.com/download.php</a>. If you do not have the game, you'll need to purchase it from <a href='http://www.rockstargames.com/sanandreas/pc/'>Rockstar Games</a> or a third-party seller, such as <a href='http://store.steampowered.com/'>Steam</a>.</p>
			</td>
		</tr>
		<tr class='tablerow1'>
			<td>
				<div style="border:1px solid;box-shadow:1px 3px 3px #ccc;color:#2b5b8c;width:140px;height:140px;margin:auto;display: block;">
				<img style="height:140px;width:140px;" src='http://127.0.0.1/cp//global/images/all/inf2.png'>
				</div>
			</td>
			<td><span style='font-size:28px;color:#333;'>2<span></td>
			<td>
			<p><b>Register your account</b><br><br>Once you have SA-MP installed, launch the SA-MP client. First, you will need a "roleplay" name, which means a first and last name (separated by an underscore, ie: John_Doe). You can enter your name in the top-center of the client where it says Name (<img src='http://puu.sh/1tri6' />). <br><br>From there, click on the <img src='http://puu.sh/1trjF' /> Add Server button and type <a href='samp://samp.ng-gaming.net:7777'>samp.ng-gaming.net</a> as the server address. Once the server has been added, double-click the server and join it.</p>
			</td>
		</tr>
		<tr class='tablerow1'>
			<td>
				<div style="border:1px solid;box-shadow:1px 3px 3px #ccc;color:#2b5b8c;width:140px;height:140px;margin:auto;display: block;">
				<img style="height:140px;width:140px;" src='http://127.0.0.1/cp//global/images/all/inf3.png'>
				</div>
			</td>
			<td><span style='font-size:28px;color:#333;'>3<span></td>
			<td>
			<p><b>Complete referral process</b><br><br>
			When you have logged in with your account, you will need to complete the registration process in-game. During registration, it will ask you to enter the players name whom referred you, please make sure you spell the name correctly and enter the underscore (your referrer's name: <?php echo $result['Username']; ?>). Once you have finished the registration, you may continue <a href="">to this page</a> to finish the referral process.
			</p>
			</td>
		</tr>
		</table>
	  </div>
	</div>
	<div class='acp-box'>
		<div id='copyright'><?php require('global/footer.php'); ?></div>
	</div>
	</div>
</div>
</body>
</html>
<?php
		}
		else
		{
			echo '<script>alert("Invalid referral ID!");</script>';
			echo '<meta http-equiv="refresh" content="0;url=http://'.$_SERVER["SERVER_NAME"].'">';
		}
	}
	else
	{
		echo '<script>alert("Invalid referral ID!");</script>';
		echo '<meta http-equiv="refresh" content="0;url=http://'.$_SERVER["SERVER_NAME"].'">';
	}
?>