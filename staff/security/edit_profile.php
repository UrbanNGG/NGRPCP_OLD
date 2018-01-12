<?php if($inf['Security'] < 0 || $inf['AdminLevel'] < 1338 && isset($redir2)) {
	echo $redir2;
	exit();
}

$user = mysql_real_escape_string($_GET['name']);
$user_id = GetID($user);
if(GetAdminLevel($user_id) >= 2) {
if($_SERVER['REQUEST_METHOD'] == "POST") {
	$note = mysql_real_escape_string($_POST['note']);
	if(mysql_query("INSERT INTO `cp_security_notes` SET `user_id` = '".$user_id."', `note_by` = '".$inf['id']."', `note` = '".$note."', `date_added` = NOW();")) {
		$message = "Profile successfully edited.";
	}
}
?>

<div id='content_wrap'>
					<ol id='breadcrumb'><li>Security Profiles > Edit Profile</li></ol>
					<div class='section_title'><h2>Editing <?php echo $user; ?>'s Profile</h2></div>
				<div class='acp-box'>
					<a href="./security.php?p=view_profile&name=<?php echo $user; ?>"><button class="button">Back to Profile</button></a>
					<h3>Edit Profile</h3>
					<?php if(isset($message)) { ?>
						<div class='acp-message'><?php echo $message; ?></div>
					<?php } ?>
					<form method="POST">
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'>
						<tr><td width="50%">Forum Name:</td><td><input type="text" name="forum_name"></td></tr>
						<tr><td>Teamspeak Name:</td><td><input type="text" name="teamspeak_name"></td></tr>
						<tr><td>Recommending Admin:</td><td><input type="text" name="recommending_admin"></td></tr>
						<tr><td>Roleplay Names</td><td><textarea cols="50" rows="5" name="rp_names"></textarea></td></tr>
						<tr><td>Email Addresses:</td><td><textarea cols="50" rows="5" name="email_addresses"></textarea></td></tr>
						<tr><td>Messenger Handles:</td><td><textarea cols="50" rows="5" name="messenger_handles"></textarea></td></tr>
						<tr><td>Security Orientation:</td><td><input type="text" name="security_orientation"></td></tr>
						<tr><td>Security Profile:</td><td><input type="text" name="security_profile"></td></tr>
						<tr><td></td><td><button type="submit" class="button">Submit</button></td></tr>
					</table>
					</form>
		<div class='acp-actionbar'></div>
				</div></div>
<?php } else {
?>
		<div id='content_wrap'>
					<ol id='breadcrumb'><li>Security Profiles > Edit Profile</li></ol>
				<div class='acp-box'>
					You cannot edit this user's profile as either they do not exist or they are not an administrator.
		<div class='acp-actionbar'></div>
				</div></div>
<?php
}
?>