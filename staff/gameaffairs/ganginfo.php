<?php if($inf['GangModerator'] > 0 || $inf['AdminLevel'] > 3) {
if(isset($_GET['fmem'])) { $fmem = $_GET['fmem']; }
?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Game Affairs > Viewing Gang Members</li></ol>
	<div class='section_title'><h2>Gang Members</h2></div>
<div class='acp-box'>
		<?php
			if(isset($_GET['n']) && $_GET['n'] == 1) { echo "<div class='acp-error'>That player is currently in-game. Please issue the gang warn in-game or try again later.</div>"; }
			if(isset($_GET['n']) && $_GET['n'] == 2) { echo "<div class='acp-message'>Warned successfully!</div>"; }
			if(isset($_GET['n']) && $_GET['n'] == 3) { echo "<div class='acp-error'>That player is currently in-game. Please kick them in-game or try again later.</div>"; }
			if(isset($_GET['n']) && $_GET['n'] == 4) { echo "<div class='acp-message'>Kicked successfully!</div>"; }
		if(!isset($_GET['fmem'])) { echo "<h3>Gang Member List</h3>"; } ?>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th colspan='8'>
			<?php
			$famlistquery = mysql_query("SELECT `ID`, `Name` FROM `families`");
			while ($famlist = mysql_fetch_array($famlistquery)) {
			echo "[<a href='gameaffairs.php?p=ganginfo&fmem=$famlist[ID]'>$famlist[Name]</a>]";
			}
			?>
			</th>
		</tr>
		<tr>
			<th width='5%'></th><th width='5%'></th><th>Rank</th><th>Player</th><th>Gang Warns</th><th>Last Active</th><th>Warn</th><th>Kick</th>
		</tr>
	<?php if(isset($_GET['fmem'])) {
	$fmem1 = mysql_query("SELECT `id`, `Online`, `Username`, `UpdateDate`, `IP`, `FMember`, `Rank`, `GangWarn` FROM `accounts` WHERE `AdminLevel` < '2' AND `Disabled` = '0' AND `FMember` = '$fmem' ORDER BY Rank DESC, Username ASC");
	$count = mysql_num_rows($fmem1);
	echo "<h3>Gang Member List <span class='table_view'>Members: ".$count."</span></h3>";
		while ($fmem = mysql_fetch_array($fmem1)) {
		$gangquery = mysql_query("SELECT * FROM `families` WHERE `ID` = '$fmem[FMember]'");
		$gang = mysql_fetch_array($gangquery);
			if (isset($i) && $i == 1) {
				print "<tr>";
			$i=0;
			} else { 
				print "<tr class='tablerow1'>";
			$i=1;
			}
			
			if($fmem['Rank'] == 0) { $fmem['Rank'] = $gang['Rank0']; }
			if($fmem['Rank'] == 1) { $fmem['Rank'] = $gang['Rank1']; }
			if($fmem['Rank'] == 2) { $fmem['Rank'] = $gang['Rank2']; }
			if($fmem['Rank'] == 3) { $fmem['Rank'] = $gang['Rank3']; }
			if($fmem['Rank'] == 4) { $fmem['Rank'] = $gang['Rank4']; }
			if($fmem['Rank'] == 5) { $fmem['Rank'] = $gang['Rank5']; }
			if($fmem['Rank'] == 6) { $fmem['Rank'] = $gang['Rank6']; }

		$warn = "
		<form method='POST' action='gameaffairs/proc.php'>
		<input type='hidden' name='action' readonly='readonly' value='gangwarn_add'>
		<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
		<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
		<input type='hidden' name='ga_id' readonly='readonly' value='$fmem[FMember]'>
		<input type='hidden' name='leader' readonly='readonly' value='$fmem[Username]'>
		<input type='image' src='../../global/images/all/icon_components/topics/post_new.png' alt='Warn'></form>
		";
			
		$kick = "
		<form method='POST' action='gameaffairs/proc.php'>
		<input type='hidden' name='action' readonly='readonly' value='gang_kick'>
		<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
		<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
		<input type='hidden' name='ga_id' readonly='readonly' value='$fmem[FMember]'>
		<input type='hidden' name='leader' readonly='readonly' value='$fmem[Username]'>
		<input type='image' src='../../global/images/all/icons/cross.png' alt='Kick'></form>
		";
		
		if(IsPlayerOnline($fmem['id']) > 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-online.png' alt='Online' />"; }
		if(IsPlayerOnline($fmem['id']) == 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-offline.png' alt='Offline' />"; }
			
		print "
			<td>$status</td>
			<td>".FlagByIP($fmem['IP'])."</td>
			<td>$fmem[Rank]</td>
			<td>
		";
			if($fmem['Online'] > 0) { print "<span style='font-weight:bold'>$fmem[Username]</span>"; }
			else { print "$fmem[Username]"; }
		print "
			</td>
			<td>$fmem[GangWarn]</td>
			<td>".LastOnline($fmem['id'])."</td>
			<td>$warn</td>
			<td>$kick</td>
		</tr>
		";
		}
	} ?>
		</table>
</div>
</div>
<?php } 
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>