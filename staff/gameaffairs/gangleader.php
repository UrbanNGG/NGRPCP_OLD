<?php if($inf['GangModerator'] > 0 || $inf['AdminLevel'] > 3) { ?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Game Affairs > Viewing Gang Leaders</li></ol>
	<div class='section_title'><h2>Gang Leaders</h2></div>
<div class='acp-box'>
	<h3>Gang Leader List</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th width='5%'></th><th width='5%'></th><th>Player</th><th>Gang</th><th>Last Active</th>
		</tr>
	<?php $glead1 = mysql_query("SELECT `id`, `Username`, `UpdateDate`, `IP`, `Rank`, `FMember` FROM `accounts` WHERE `AdminLevel` < '2' AND `Disabled` = '0' AND `FMember` != '255' AND `Rank` > 5 ORDER BY FMember ASC, Username ASC");
		while ($glead = mysql_fetch_array($glead1)) {
			if (isset($i) && $i == 1) {
				print "<tr class='tablerow1'>";
			$i=0;
			} else { 
				print "<tr>";
			$i=1;
			}
			
		$famlistquery = mysql_query("SELECT `Name` FROM `families` WHERE `ID` = $glead[FMember]");
		$famlist = mysql_fetch_array($famlistquery);
			
		if(IsPlayerOnline($glead['id']) > 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-online.png' alt='Online' />"; }
		if(IsPlayerOnline($glead['id']) == 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-offline.png' alt='Offline' />"; }
			
		print "
			<td>$status</td>
			<td>".FlagByIP($glead['IP'])."</td>
			<td>$glead[Username]</td>
			<td>$famlist[0]</td>
			<td>".LastOnline($glead['id'])."</td>
				</tr>
			";
		} ?>
		</table>
</div>
</div>
<?php } 
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>