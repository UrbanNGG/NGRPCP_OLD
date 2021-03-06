<?php if($inf['AdminLevel'] < 1337 && $inf['FactionModerator'] != 2) {
	echo $redir;
	exit();
}
?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Game Affairs > Viewing Faction Moderators</li></ol>
	<div class='section_title'><h2>Faction Moderators</h2></div>
<div class='acp-box'>
	<?php
	if(isset($_GET['n']) && $_GET['n'] == 1) { echo "<div class='acp-error'>That Admin is currently in-game. Please try again.</div>"; }
	if(isset($_GET['n']) && $_GET['n'] == 2) { echo "<div class='acp-message'>Successfully added as Faction Moderator!</div>"; }
	if(isset($_GET['n']) && $_GET['n'] == 3) { echo "<div class='acp-error'>That Admin is currently in-game. Please try again.</div>"; }
	if(isset($_GET['n']) && $_GET['n'] == 4) { echo "<div class='acp-message'>Successfully removed from Faction Moderator!</div>"; }
	?>
	<h3>Add a Faction Moderator</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
			<form method='post' action='gameaffairs/proc.php'>
			<tr>
				<td>Name</td>
				<td><select name="ga_id">
					<?php 
					$userquery = mysql_query("SELECT `id`,`Username`,`AdminLevel`,`Disabled`,`FactionModerator` FROM `accounts` WHERE `AdminLevel`>'1' AND `AdminLevel`<'1338' AND `Disabled`='0' AND `FactionModerator`='0' ORDER BY Username ASC");
					while ($user = mysql_fetch_array($userquery)) {
					echo "<option value='$user[id]'>$user[Username]</option>";
					} ?>
				</select></td>
				<td>
					<input type='hidden' name='action' readonly='readonly' value='facmod_add'>
					<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
					<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
					<input type='submit' class='button' value='Add'>
				</td>
			</tr>
			</form>
		</table>
	<h3>Faction Moderator List</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th width='5%'></th><th width='5%'></th><th>Rank</th><th>Administrator</th><th>Faction</th><th>Last Active</th><th>Remove</th>
		</tr>
	<?php $fmod1 = mysql_query("SELECT `id`,`Username`,`UpdateDate`,`IP`,`AdminLevel`,`Member`,`FactionModerator` FROM `accounts` WHERE `AdminLevel`<'1338' AND `FactionModerator`>'0' AND `Disabled`='0' ORDER BY FactionModerator DESC, Username ASC");
		while ($fmod = mysql_fetch_array($fmod1)) {
			if (isset($i) && $i == 1) {
				print "<tr class='tablerow1'>";
			$i=0;
			} else { 
				print "<tr>";
			$i=1;
			}
			
		$faclistquery = mysql_query("SELECT `Name` FROM `groups` WHERE `id` = $fmod[Member]+1");
		$faclist = mysql_fetch_array($faclistquery);
		if($fmod['Member'] > 0) { $facname = $faclist['0']; }
		if($fmod['Member'] == 0) { $facname = "None"; }
		
		if($fmod['FactionModerator'] == 1) { $rank = "Moderator"; }
		elseif($fmod['FactionModerator'] == 2) { $rank = "Director"; }
			
	$remove = "<form method='post' action='gameaffairs/proc.php'>
	<input type='hidden' name='action' readonly='readonly' value='facmod_remove'>
	<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
	<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
	<input type='hidden' name='ga_id' readonly='readonly' value='$fmod[id]'>
	<input type='image' src='../../global/images/all/icons/cross.png' alt='Remove'>
	</form>";
			
		if(IsPlayerOnline($fmod['id']) > 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-online.png' alt='Online' />"; }
		if(IsPlayerOnline($fmod['id']) == 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-offline.png' alt='Offline' />"; }
			
		print "
			<td>$status</td>
			<td>".FlagByIP($fmod['IP'])."</td>
			<td>$rank</td>
			<td>$fmod[Username]</td>
			<td>$facname</td>
			<td>".LastOnline($fmod['id'])."</td>
			<td>$remove</td>
				</tr>
			";
		} ?>
		</table>
</div>
</div>