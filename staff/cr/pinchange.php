<?php if(!isset($_POST['dbid']) && !isset($_POST['pname']) && !isset($_GET['pid'])) { ?>
<div id='content_wrap'>
	<ol id='breadcrumb'>
		<li><?php echo $section; ?> &raquo; Search</li>
	</ol>
	<div class='section_title'>
		<h2>Pin Change</h2>
	</div>
	<div class='acp-box'>
		<h3>Search</h3>
	<table class='double_pad' cellpadding='0' cellspacing='0' border='1' width='100%' align="center" style='border-color:#ccc;'>
	<tr>
		<form method="POST">
		<td>By Database ID<br><br><input name='dbid' type='text'><br><br><input type='submit' class='realbutton' value='Submit'></td>
		</form>
		<form method="POST">
		<td>By Player Name<br><br><input name='pname' type='text'><br><br><input type='submit' class='realbutton' value='Submit'></td>
		</form>
	</tr>
    </table>
	</div>
</div>
<?php } else { ?>
<div id='content_wrap'>
	<ol id='breadcrumb'>
		<li><?php echo $section; ?> > Pin Change</li>
	</ol>
	<?php
	if(isset($_POST['dbid'])) {
	$t = mysql_query("SELECT * FROM `accounts` WHERE `id` = '".$_POST['dbid']."'");
	}
	if(isset($_POST['pname'])) {
	$t = mysql_query("SELECT * FROM `accounts` WHERE `Username` = '".$_POST['pname']."'");
	}
	if(isset($_GET['pid'])) {
	$t = mysql_query("SELECT * FROM `accounts` WHERE `id` = '".$_GET['pid']."'");
	}
	$z = mysql_num_rows($t);
	$r = mysql_fetch_array($t);
	
	if(isset($_POST['action']) && $_POST['action'] == 'edit') {
		$pin = escape_string($_POST['pin']);
		$pin = hash('whirlpool', $pin);
		$on = mysql_query("SELECT `Online` FROM `accounts` WHERE `id` =  '" . $_GET['pid'] . "'");
		$online = mysql_fetch_array($on);
		if($online['Online'] == 0) {
			$re = mysql_query("
			UPDATE `accounts` SET `Pin` = '" . strtoupper($pin) . "' WHERE `id` = '" . $_GET['pid'] . "'
			");
			$msg = "Account edited successfully.";
			doLog("$inf[id]", "Customer Relations", "Credits", "Edited pin for " . GetName($_GET['pid']) . "");
		} else {
			$msg = "Player is currently online, please try again later or change in-game.";
		}
	}
	?>
	<?php
		if($z == 0) {
	?>
			<div class='acp-box'>
			<table class='double_pad' cellpadding='0' cellspacing='0' border='1' width='100%' align="center" style='border-color:#ccc;'>
			<tr class="tablerow1"><td colspan=8><b><h2>Player not found</h2></b></td></tr>
			</table>
			</div>
	<?php
		} else {
	?>
	<div class='section_title'>
		<h2>View Player Information</h2>
	</div>
	<?php if(isset($msg)) {
	 echo "<div class='acp-message'>".$msg."</div>"; }
	?>
	<div class='acp-box'>
	<h3><?php echo $r['Username']; ?></h3>
	<table width="100%" class='double_pad' cellpadding="0" cellspacing="0" border="1" style='border-color:#ccc'>
	<form action="http://127.0.0.1/cp//staff/cr.php?p=pinchange&pid=<?php echo $r['id']; ?>" method="POST">
	<tr class='tablerow2'>
		<td width="50%">New Pin:</td><td><input type='text' name='pin' /></td>
	</tr>
	<tr class='tablerow2'>
		<td colspan='2'><input type='hidden' name='action' value='edit'><input type='submit' class='realbutton' value='Submit'></td>
	</tr>
	</form>
	</table>
	</div>

<?php } ?>
</div>
<?php } ?>