<?php if($group['Type'] == 1) { ?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Faction > Viewing Most Wanted</li></ol>
	<div class='section_title'><h2>Most Wanted List</h2></div>
<div class='acp-box'>
	<?php
	$wantedquery = mysql_query("SELECT `id`, `Online`, `Username`, `SPos_x`, `SPos_y`, `WantedLevel`, `Model`, DATE_FORMAT(`UpdateDate`, '%m/%d/%Y') FROM `accounts` WHERE `Band` = '0' AND `AdminLevel` < '2' AND `Disabled` = '0' AND `WantedLevel` = '6' AND `UpdateDate` BETWEEN SYSDATE() - INTERVAL 15 DAY AND SYSDATE() ORDER BY UpdateDate DESC");
	$wantcount = mysql_num_rows($wantedquery);
	print "
		<h3>Most Wanted List <span class='table_view'>Criminals: ".$wantcount."</span></h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th width='5%'></th><th>Latest Picture</th><th>Name</th><th>Last Known Location</th>
		</tr>
	";
		while ($wanted = mysql_fetch_array($wantedquery)) {
		
			if (isset($i) && $i == 1) {
				print "<tr class='tablerow1'>";
			$i=0;
			} else { 
				print "<tr>";
			$i=1;
			}

			if($wanted['Online'] > 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-online.png' alt='Online' />"; }
			if($wanted['Online'] == 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-offline.png' alt='Offline' />"; }
			
		print "
			<td>$status</td>
			<td><img src='../../global/images/skins/ImageSkin_$wanted[Model].png' alt='No picture available' /></td>
			<td>$wanted[Username]</td>
			<td>".GetPlayer2DZone($wanted['SPos_x'], $wanted['SPos_y'])."</td>
			</tr>
		";
		}
	?>
		</table>
</div>
</div>
<?php }
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this area.</h2></div></div>"; } ?>