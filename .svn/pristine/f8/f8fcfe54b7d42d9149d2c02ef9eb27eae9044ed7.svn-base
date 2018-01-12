<?php if($inf['AdminLevel'] >= 1338 || $inf['BanAppealer'] == 2) { ?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Bans > Viewing Ban Appealers</li></ol>
	<div class='section_title'><h2>Ban Appealers</h2></div>
<div class='acp-box'>
	<?php
	if(isset($_GET['n']) && $_GET['n'] == 1) { echo "<div class='acp-error'>That Admin is currently in-game. Please try again.</div>"; }
	if(isset($_GET['n']) && $_GET['n'] == 2) { echo "<div class='acp-message'>Successfully added as a Ban Appealer!</div>"; }
	if(isset($_GET['n']) && $_GET['n'] == 3) { echo "<div class='acp-message'>Successfully removed from Ban Appealer!</div>"; }
	?>
	<h3>Add a Ban Appealer</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
			<form method='post' action='ban/proc.php'>
			<tr>
				<td>Name</td>
				<td><select name="id">
					<?php 
					$userquery = mysql_query("SELECT `id`, `Username` FROM `accounts` WHERE `AdminLevel` > 1 AND `BanAppealer` < 1 ORDER BY Username ASC");
					while ($user = mysql_fetch_array($userquery)) {
					echo "<option value='$user[id]'>$user[Username]</option>";
					} ?>
				</select></td>
				<td>
					<input type='hidden' name='action' readonly='readonly' value='add_banappealer'>
					<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
					<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
					<input type='submit' class='button' value='Add'>
				</td>
			</tr>
			</form>
		</table>
	<h3>Ban Appealer List</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th width='5%'></th><th width='5%'></th><th>Administrator</th><th>Last Active</th><th>Remove</th>
		</tr>
	<?php $sql = mysql_query("SELECT `id`, `Username`, `UpdateDate`, `IP`, `BanAppealer` FROM `accounts` WHERE `BanAppealer` > 0 AND `Disabled` = 0 ORDER BY Username ASC");
		while ($result = mysql_fetch_array($sql)) {
			if (isset($i) && $i == 1) {
				print "<tr class='tablerow1'>";
			$i=0;
			} else { 
				print "<tr>";
			$i=1;
			}
			
	$remove = "<form method='post' action='ban/proc.php'>
	<input type='hidden' name='action' readonly='readonly' value='remove_banappealer'>
	<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
	<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
	<input type='hidden' name='id' readonly='readonly' value='$result[id]'>
	<input type='image' src='../../global/images/all/icons/cross.png' alt='Remove'>
	</form>";
			
		if(IsPlayerOnline($result['id']) > 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-online.png' alt='Online' />"; }
		if(IsPlayerOnline($result['id']) == 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-offline.png' alt='Offline' />"; }
			
		print "
			<td>$status</td>
			<td>".FlagByIP($result['IP'])."</td>
			<td>$result[Username]</td>
			<td>".LastOnline($result['id'])."</td>
			<td>$remove</td>
				</tr>
			";
		} ?>
		</table>
</div>
</div>
<?php } 
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>