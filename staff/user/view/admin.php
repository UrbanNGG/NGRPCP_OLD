<?php if($inf['AdminLevel'] >= 1337 || $inf['HR'] >= 1) { ?>
				<h3>Administrator List</h3>
<?php
$sql = "SELECT `id`, `Online`, `IP`, `Username`, `AdminLevel`, `AdminType`, `Disabled`, `AcceptReport`, `TrashReport` FROM `accounts` WHERE `AdminLevel` > '1' AND `Disabled` = '0' ORDER BY AdminLevel DESC, Username ASC";
?>
<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
<tr><th width='10%'></th><th width='5%'></th><th>Rank</th><th>Name</th><th>Reports This Hour (Today)</th><th>Accepted Reports</th><th>Points</th><th>Last Online</th></tr>
<?php
$userM1 = mysql_query($sql);

function ReportCount($userid)
{
	$date = date('Y-m-d');
	$time = date('h').":00:00";
	$reporthourquery = mysql_query("SELECT `count` FROM `tokens_report` WHERE `playerid` = $userid AND `date` = '$date' AND `hour` = '$time'");
	$reporthourarray = mysql_fetch_row($reporthourquery);
	$reportquery = mysql_query("SELECT SUM(count) FROM `tokens_report` WHERE `playerid` = $userid AND `date` = '$date'");
	$reportarray = mysql_fetch_row($reportquery);
	$reporthourcount = $reporthourarray[0];
	$reportcount = $reportarray[0];
	if(!$reporthourcount) $reporthourcount = 0;
	if(!$reportcount) $reportcount = 0;
	$contents = $reporthourcount." (".$reportcount.")";
	return $contents;
}

while ($userM = mysql_fetch_array($userM1)) {

	$useredit = "<form method='post' action='user.php?p=edit&u=admin'>
		<input type='hidden' name='action' readonly='readonly' value='edit'>
		<input type='hidden' name='uID' readonly='readonly' value='$userM[id]'>
		<input type='submit' class='submit' value='$userM[Username]'></form>";

	$rstatquery = mysql_query("SELECT `timezone`, `points` FROM `cp_stat` WHERE `user_id` = $userM[id]");
	$rstat = mysql_fetch_array($rstatquery);
		
	if (isset($i) && $i == 1) { print "<tr class='tablerow1'>";
		$i=0;
	} else { print "<tr>";
		$i=1;
	}
	
	if($rstat['timezone'] == "" || $rstat['timezone'] == "NULL") { $tz = "America/Chicago"; }
	else { $tz = $rstat['timezone']; }
	$timezone = new DateTimeZone($tz);
	$offset = $timezone->getOffset(new DateTime("now"));
	
	if($userM['Online'] > 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-online.png' alt='Online' />"; }
	if($userM['Online'] == 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-offline.png' alt='Offline' />"; }
	
	switch($userM['AdminType'])
	{
		default: $type = ""; break;
		case 1: $type = "Non-Gaming"; break;
		case 2: $type = "Unassigned"; break;
		case 3: $type = "Shift"; break;
	}

	if($userM['AdminLevel'] == 99999) { $lvl = "<span style='color:#298eff'>Executive Administrator</span>"; }
	if($userM['AdminLevel'] == 1338) { $lvl = "<span style='color:#298eff'>Lead Head Administrator</span>"; }
	if($userM['AdminLevel'] == 1337) { $lvl = "<span style='color:red'>".$type." Head Administrator</span>"; }
	if($userM['AdminLevel'] == 4) { $lvl = "<span style='color:sandybrown'>".$type." Senior Administrator</span>"; }
	if($userM['AdminLevel'] == 3) { $lvl = "<span style='color:lime'>".$type." General Administrator</span>"; }
	if($userM['AdminLevel'] == 2) { $lvl = "<span style='color:lime'>".$type." Junior Administrator</span>"; }

if($userM['AdminLevel'] <= 99999 && $inf['AdminLevel'] == 99999) { print "<td>$status</td><td>".FlagByIP($userM['IP'])." <br><span style='font-size:9px;'>(GMT ".($offset < 0 ? '-' : '+').abs(round($offset/3600)).")</span></td><td>$lvl</td><td>$useredit</td><td>".ReportCount($userM['id'])."</td><td>".number_format($userM['AcceptReport'])."</td><td>".number_format($rstat['points'])."</td><td>".LastOnline($userM['id'])."</td>"; }
else if($userM['AdminLevel'] <= 1338 && $inf['AdminLevel'] == 1338) { print "<td>$status</td><td>".FlagByIP($userM['IP'])." <br><span style='font-size:9px;'>(GMT ".($offset < 0 ? '-' : '+').abs(round($offset/3600)).")</span></td><td>$lvl</td><td>$useredit</td><td>".ReportCount($userM['id'])."</td><td>".number_format($userM['AcceptReport'])."</td><td>".number_format($rstat['points'])."</td><td>".LastOnline($userM['id'])."</td>"; }
else if($userM['AdminLevel'] <= 1337 && $inf['AdminLevel'] == 1337) { print "<td>$status</td><td>".FlagByIP($userM['IP'])." <br><span style='font-size:9px;'>(GMT ".($offset < 0 ? '-' : '+').abs(round($offset/3600)).")</span></td><td>$lvl</td><td>$useredit</td><td>".ReportCount($userM['id'])."</td><td>".number_format($userM['AcceptReport'])."</td><td>".number_format($rstat['points'])."</td><td>".LastOnline($userM['id'])."</td>"; }
else if($userM['AdminLevel'] <= 3 && $inf['HR'] > 0) { print "<td>$status</td><td>".FlagByIP($userM['IP'])." <br><span style='font-size:9px;'>(GMT ".($offset < 0 ? '-' : '+').abs(round($offset/3600)).")</span></td><td>$lvl</td><td>$useredit</td><td>".ReportCount($userM['id'])."</td><td>".number_format($userM['AcceptReport'])."</td><td>".number_format($rstat['points'])."</td><td>".LastOnline($userM['id'])."</td>"; }
print "
</tr>
";
}

?>
	</table>
<?php }
else { echo "You do not have access to this section."; } ?>