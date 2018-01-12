<?php
$section = 'Notifications';
if(!isset($_GET['nid']) && !isset($_GET['new'])) { 
?>
<div id='content_wrap'>
	<ol id='breadcrumb'>
		<li><?php echo $section; ?> &raquo; View</li>
	</ol>
	<div class='section_title'>
		<h2>CP Notifications</h2>
	</div>
	<?php if(isset($msg)) { echo "<div class='acp-message'>".$msg."</div>"; } ?>
	<div class='acp-box'>
	<h3></h3>
	<?php
	$preplyq = mysql_query("SELECT * FROM `cp_misc`");
	?>
	<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%' align="center" style='border-color:#ccc;'>
	<th>ID</th>
	<th>From</th>
	<th>Message</th>
	<th>Enabled</th>
	<th></th>
	<?php
	while($preply = mysql_fetch_array($preplyq)) {
		if(isset($i) && $i == 1) {
			print "<tr class='tablerow1'>";
			$i=0;
		} else { 
			print "<tr>";
			$i=1;
		}
    ?>
	<td width='10%'><?php echo $preply['id']; ?></td>
	<td width='10%'><?php echo $preply['from']; ?></td>
	<td width='40%'><?php echo $preply['message']; ?></td>
	<td width='10%'><?php if($preply['status'] == 1) { echo 'Enabled'; } else { echo 'Disabled'; } ?></td>
	<td width='10%'><a href='/staff/user.php?p=manage&nid=<?php echo $preply['id']; ?>'>Edit</td>
	<?php
		print "</tr>";
	}
	?>
	<tr class='acp-actionbar'>
		<td></td><td></td><td></td><td></td><td><a href='/staff/user.php?p=manage&new=note<?php echo $preply['id']; ?>'>Create New</a></td>
	</tr>
	</table>
	</div>
</div>
<?php }
if(isset($_GET['nid']) && !isset($_GET['new'])) { 
	$nid = $_GET['nid'];
	if (!preg_match("/^[0-9]{1,6}+$/", $nid)) {
		print "<meta http-equiv=\"refresh\" content=\"0;url=/staff/user.php?p=manage\">";exit();
	}
	$preplyq = mysql_query("SELECT * FROM `cp_misc` WHERE `id` = '".$_GET['nid']."';");
	$preply = mysql_fetch_array($preplyq);
	$num = mysql_num_rows($preplyq);
	$q = mysql_query("SELECT `status` FROM `cp_misc` WHERE `status` = '1';");
	$r = mysql_num_rows($q);
	if(isset($_POST['action']) && $_POST['action'] == 'edit') {
		$from = escape_string($_POST['from']);
		$message = escape_string($_POST['message']);
		if($r == 0 || $r == 1 && $_POST['status'] == '0') {
			if($c = mysql_query("UPDATE `cp_misc` SET `from` = '".$from."', `message` = '".$message."', `status` = '".$_POST['status']."' WHERE `id` = '".$nid."';")) {
			$msg = 'Notification edited.';
			}
		} else {
			$msg = 'Only one notification can be active at a time.';
		}
	}
	if($num == 1) {
?>
<div id='content_wrap'>
	<ol id='breadcrumb'>
		<li><?php echo $section; ?> &raquo; Edit</li>
	</ol>
	<div class='section_title'>
		<h2>View Notification #<?php echo $_GET['nid']; ?></h2>
	</div>
	<?php if(isset($msg)) { echo "<div class='acp-message'>".$msg."</div>"; } ?>
	<div class='acp-box'>
	<h3>Edit Information</h3>
	<table class='double_pad' cellpadding='0' cellspacing='0' border='1' width='100%' align="center" style='border-color:#ccc;'>
	<form method='POST'>
	<tr>
		<td width='50%'>From:</td>
		<td><input type='text' name='from' value='<?php echo $preply['from']; ?>'></td>
	</tr>
	<tr class='tablerow1'>
		<td>Status:</td>
		<td><input type='radio' name='status' value='1' <?php if ($preply['status'] == '1') { echo "checked='checked'"; } ?>> Enabled &nbsp; <input type='radio' name='status' value='0' <?php if ($preply['status'] == '0') { echo "checked='checked'"; } ?>> Disabled
	</tr>
	<tr>
		<td>Message:</td>
		<td><textarea rows='6' cols='50' name='message'><?php echo $preply['message']; ?></textarea></td>
	</tr>
	<tr class='acp-actionbar'>
		<input type='hidden' name='action' value='edit'></td>
		<td colspan='2'><input type='submit' value='Change' class='button'></td>
	</tr>
	</form>
	</table>
	</div>
</div>
<?php }
}
if(isset($_GET['new'])) { 

if(isset($_POST['action']) && $_POST['action'] == 'create') {
	$from = escape_string($_POST['from']);
	$message = escape_string($_POST['message']);
	if($c = mysql_query("INSERT INTO `cp_misc` (`from`, `message`, `status`) VALUES ('".$from."', '".$message."', '".$_POST['status']."');")) {
	$msg = 'Notification created.';
	}
}
?>
<div id='content_wrap'>
	<ol id='breadcrumb'>
		<li><?php echo $section; ?> &raquo; Create</li>
	</ol>
	<div class='section_title'>
		<h2>New Notification</h2>
	</div>
	<?php if(isset($msg)) { echo "<div class='acp-message'>".$msg."</div>"; } ?>
	<div class='acp-box'>
	<h3></h3>
	<table class='double_pad' cellpadding='0' cellspacing='0' border='1' width='100%' align="center" style='border-color:#ccc;'>
	<form method='POST'>
	<tr>
		<td width='50%'>From:</td>
		<td><input type='text' name='from' value='<?php echo $preply['from']; ?>'></td>
	</tr>
	<tr class='tablerow1'>
		<td>Status:</td>
		<td><input type='radio' name='status' value='1'> Enabled &nbsp; <input type='radio' name='status' value='0'> Disabled
	</tr>
	<tr>
		<td>Message:</td>
		<td><textarea rows='6' cols='50' name='message'></textarea></td>
	</tr>
	<tr class='acp-actionbar'>
		<input type='hidden' name='action' value='create'></td>
		<td colspan='2'><input type='submit' value='Create' class='button'></td>
	</tr>
	</form>
	</table>
	</div>
</div>
<?php
}
?>