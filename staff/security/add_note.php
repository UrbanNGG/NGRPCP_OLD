<?php if($inf['Security'] < 0 || $inf['AdminLevel'] < 1338 && isset($redir2)) {
	echo $redir2;
	exit();
}

$user = mysql_real_escape_string($_GET['name']);
$user_id = GetID($user);
if(GetAdminLevel($user_id) >= 2) {
if($_SERVER['REQUEST_METHOD'] == "POST") {
	if($_POST['note'] == "") {
		$message = "You need to put a note in before submitting";
	} else {
		$note = mysql_real_escape_string($_POST['note']);
		if(mysql_query("INSERT INTO `cp_security_notes` SET `user_id` = '".$user_id."', `note_by` = '".$inf['id']."', `note` = '".$note."', `date_added` = NOW();")) {
			$message = "Note successfully added.";
		}
	}
}
?>

<div id='content_wrap'>
					<ol id='breadcrumb'><li>Security Profiles > Add Note</li></ol>
					<div class='section_title'><h2>Adding a Note on <?php echo $user; ?>'s Profile</h2></div>
				<div class='acp-box'>
					
					<h3>Add Note</h3>
					<?php if(isset($message)) { ?>
						<div class='acp-message'><?php echo $message; ?></div>
					<?php } ?>
					<form method="POST">
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
						<tr><td width="50%">Note:</td><td><textarea cols="50" rows="5" name="note"></textarea></td></tr>
						<tr><td></td><td><button type="submit" class="button">Submit</button></td></tr>
					</table>
					</form>
		<div class='acp-actionbar'></div>
				</div></div>
<?php } else {
?>
		<div id='content_wrap'>
					<ol id='breadcrumb'><li>Security Profiles > Add Note</li></ol>
				<div class='acp-box'>
					You cannot add a note on this user as either they do not exist or they are not an administrator.
		<div class='acp-actionbar'></div>
				</div></div>
<?php
}
?>