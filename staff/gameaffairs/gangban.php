<?php if($inf['GangModerator'] > 0 || $inf['AdminLevel'] > 3) { ?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Game Affairs > Viewing Gang Bans</li></ol>
	<div class='section_title'><h2>Gang Bans</h2></div>
<div class='acp-box'>
	<h3>Gang Ban List</h3>
			<?php
			if(isset($_GET['n']) && $_GET['n'] == 1) { echo "<div class='acp-error'>That player is currently in-game. Please issue the gang warn in-game or try again later.</div>"; }
			if(isset($_GET['n']) && $_GET['n'] == 2) { echo "<div class='acp-message'>Gang warn added successfully!</div>"; }
			if(isset($_GET['n']) && $_GET['n'] == 11) { echo "<div class='acp-error'>That player is currently in-game. Please remove the gang ban in-game or try again later.</div>"; }
			if(isset($_GET['n']) && $_GET['n'] == 12) { echo "<div class='acp-message'>Gang ban removed successfully!</div>"; }
			?>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th width='5%'></th><th width='5%'></th><th>Player</th><th>Last Active</th><th>Remove</th>
		</tr>
	<?php $fmem1 = mysql_query("SELECT `id`, `Username`, `UpdateDate`, `IP`, `GangWarn` FROM `accounts` WHERE `GangWarn` = '3' ORDER BY `Username` ASC");
		while ($fmem = mysql_fetch_array($fmem1)) {
			if (isset($i) && $i == 1) {
				print "<tr>";
			$i=0;
			} else {
				print "<tr class='tablerow1'>";
			$i=1;
			}
			
			$remove = "
			<form method='POST' action='gameaffairs/proc.php'>
			<input type='hidden' name='action' readonly='readonly' value='gban_remove'>
			<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
			<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
			<input type='hidden' name='leader' readonly='readonly' value='$fmem[Username]'>
			<input type='image' src='../../global/images/all/icons/cross.png' alt='Remove'>
			</form>
			";
			
			if(IsPlayerOnline($fmem['id']) > 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-online.png' alt='Online' />"; }
			if(IsPlayerOnline($fmem['id']) == 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-offline.png' alt='Offline' />"; }
			
		print "
			<td>$status</td>
			<td>".FlagByIP($fmem['IP'])."</td>
			<td>$fmem[Username]</td>
			<td>".LastOnline($fmem['id'])."</td>
			<td>$remove</td>
				</tr>
			";
		} ?>
		</table>
</div>
<div class='acp-box'>
<h3>Add a Gang Ban</h3>
<form method="POST" action="gameaffairs/proc.php">
	<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
		<tr class='tablerow1'>
			<td width='10%'>Name</td>
			<td width='35%'>
				<input type="text" name="leader" maxlength="64">
			</td>
			<td width='10%'>Gang</td>
			<td width='35%'>
				<select name="ga_id">
					<?php
					$famlistquery = mysql_query("SELECT `ID`, `Name` FROM `families` ORDER BY id ASC");
					while ($famlist = mysql_fetch_array($famlistquery)) {
					echo "<option value='$famlist[ID]'>$famlist[Name]</option>";
					}
					?>
				</select>
			</td>
			<td width='10%'>
				<input type="hidden" name="action" readonly="readonly" value="fban_add">
				<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
				<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
				<input type="submit" class="button" value="Add Ban">
			</td>
		</tr>
	</table>
</form>
</div>
</div>
<?php } 
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>