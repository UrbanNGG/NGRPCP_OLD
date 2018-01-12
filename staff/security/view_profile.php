<?php if($inf['Security'] < 0 || $inf['AdminLevel'] < 1338 && isset($redir2)) {
	echo $redir2;
	exit();
}

if(isset($_GET['name'])) {
$name = mysql_real_escape_string($_GET['name']);
$query = mysql_query("SELECT * FROM `accounts` WHERE `Username` = '".$name."'");
	while($user = mysql_fetch_array($query)) {
	?>

				<div id='content_wrap'>
					<ol id='breadcrumb'><li>Security Profiles > View Profile</li></ol>
					<div class='section_title'><h2>Viewing Security Profile for <?php echo $user['Username']; ?></h2></div>
				<div class='acp-box'>
					<h3>Basic Information</h3>
					<?php 
					$info = mysql_query("SELECT * FROM `cp_security_profiles` WHERE `user_id` = '".$user['id']."';");
					$profile = mysql_fetch_array($info);
					?>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
						<tr><th>Forum Name</th><th>TeamSpeak Name</th><th>Recommending Admin</th></tr>
						<tr><td><?php echo $profile['forum_name']; ?></td><td><?php echo $profile['teamspeak_name']; ?></td><td><?php echo $profile['recommending_admin']; ?></td></tr>
						<tr><th>All known RP names</th><th>All known email addresses</th><th>All known messenger handles</th></tr>
						<tr><td><?php echo $profile['rp_names']; ?></td><td><?php echo $profile['email_addresses']; ?></td><td><?php echo $profile['messenger_handles']; ?></td></tr>
					</table>
					<a href="./security.php?p=edit_profile&name=<?php echo $user['Username']; ?>"><button class='button'>Edit Profile</button></a>
					<br><br>
					<h3>Security Information</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
						<tr><th>Security Orientation</th><th>Security Profile</th></tr>
						<tr><td width="50%"><?php if($user['AdminLevel'] >= 1338) { echo "Exempt"; } else { echo "TBD"; } ?></td><td><?php if($user['AdminLevel'] >= 1338) { echo "Exempt"; } else { echo "TBD"; } ?></td></tr>
					</table>
					<br><br>
					<h3>Personal Files</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
						<tr><th>File</th><th>File Description</th></tr>
						<?php
						$files = mysql_query("SELECT * FROM `cp_security_files` WHERE `user_id` = '".$user['id']."';");
						while($file = mysql_fetch_array($files)) {
						$file_name = '<form method="post" action="./security/download.php">
						<input type="hidden" name="logpath" readonly="readonly" value="'.$_SERVER['DOCUMENT_ROOT']."/staff/security/uploads/".$file['file_name'].'">
						<input class="submit" type="submit" value="'.$file["file_name"].'">
						</form>';
						?>
							<tr><td width="50%"><?php echo $file_name; ?></td><td><?php echo $file['file_description']; ?></td></tr>
						<?php } 
						if(mysql_num_rows($files) == 0)	{ ?>
							<tr><td colspan="3">No files</td></tr>
						<?php } ?>
					</table>
					<a href="./security.php?p=upload_file&name=<?php echo $user['Username']; ?>"><button class='button'>Upload</button></a>
					<br><br>
					<h3>Security Notes</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
						<tr><th>Note By</th><th>Note</th><th>Date Added</th></tr>
						<?php
						$notes = mysql_query("SELECT * FROM `cp_security_notes` WHERE `user_id` = '".$user['id']."';");
						while($note = mysql_fetch_array($notes)) {
						?>
							<tr><td><?php echo GetName($note['note_by']); ?></td><td><?php echo $note['note']; ?></td><td><?php echo date('m/d/Y', strtotime($note['date_added'])); ?></td></tr>
						<?php } 
						if(mysql_num_rows($notes) == 0)	{ ?>
							<tr><td colspan="3">No notes</td></tr>
						<?php } ?>
					</table>
					<a href="./security.php?p=add_note&name=<?php echo $user['Username']; ?>"><button class='button'>Add Note</button></a>
					<br><br>
				<div class='acp-actionbar'></div>
				</div></div>
	<?php
	}
} else {
?>
	<div id='content_wrap'>
					<ol id='breadcrumb'><li>Security Profiles > Error Occured</li></ol>
				<div class='acp-box'>
					<h3>Error</h3>
						<p>No user has been selected, profile cannot be displayed.<br><br>Please return back to the main security profiles page and select an admin there.</p>
		<div class='acp-actionbar'></div>
				</div></div>
<?php
}
?>