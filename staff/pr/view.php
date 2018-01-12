<?php if($inf['AdminLevel'] >= 1337 || $inf['PR'] > 0) { ?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Public Relations > Viewing Staff</li></ol>
	<div class='section_title'><h2>Staff</h2></div>
	<?php if(isset($_GET['n']) && $_GET['n'] == 1) { echo "<div class='acp-error'>That player doesn't exist!</div>"; }
	  if(isset($_GET['n']) && $_GET['n'] == 2) { echo "<div class='acp-error'>That player is currently in-game!</div>"; }
	  if(isset($_GET['n']) && $_GET['n'] == 3) { echo "<div class='acp-message'>Advisor added successfully!</div>"; }
	  if(isset($_GET['n']) && $_GET['n'] == 4) { echo "<div class='acp-message'>Helper added successfully!</div>"; }
	  if(isset($_GET['n']) && $_GET['n'] == 5) { echo "<div class='acp-message'>Advisor removed successfully!</div>"; }
	  if(isset($_GET['n']) && $_GET['n'] == 6) { echo "<div class='acp-message'>Helper removed successfully!</div>"; } ?>
<?php if(isset($_GET['g']) && $_GET['g'] == "advisor") {
$advisorcntquery = mysql_query("SELECT NULL FROM `accounts` WHERE `Helper` > 1");
$advisorcnt = mysql_num_rows($advisorcntquery); ?>
<div class='acp-box'>
<?php if($inf['AdminLevel'] >= 1337 || $inf['PR'] >= 2) { ?>
<h3>Add an Advisor</h3>
<form method="POST" action="pr/proc.php">
	<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
		<tr class='tablerow1'>
			<td width='12%'>Name</td>
				<td width='35%'>
					<input type="text" name="user" length="64">
				</td>
			<td width='12%'>Rank</td>
				<td width='35%'>
					<select name="rank">
						<option value="2">Community Advisor</option>
						<option value="3">Senior Advisor</option>
						<option value="4">Chief Advisor</option>
					</select>
				</td>
			<td width='6%'>
				<input type="hidden" name="action" readonly="readonly" value="addadvisor">
				<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
				<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
				<input type="submit" class="button" value="Add Advisor">
			</td>
		</tr>
	</table>
</form>
<?php } ?>
<h3>Advisor List <span style='float:right'>Number of Advisors: <?php echo $advisorcnt; ?></span></h3>
	<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
		<tr><th width='5%'></th><th width='5%'></th><th>Rank</th><th>Name</th><th>On-Duty Time (Hours)</th><th>Points</th><th>Requests This Hour (Today)</th><th>Accepted Help Reports</th><th>Last Online</th></tr>
<?php
$sql = "SELECT `id`, `Online`, `IP`, `Username`, `Helper`, `AdvisorDutyHours`, `AcceptedHelp` FROM `accounts` WHERE `Helper` > 1 ORDER BY Helper DESC, Username ASC";
$userM1 = mysql_query($sql);

function ReportCount($userid)
{
	$date = date('Y-m-d');
	$time = date('h').":00:00";
	$reporthourquery = mysql_query("SELECT `count` FROM `tokens_request` WHERE `playerid` = $userid AND `date` = '$date' AND `hour` = '$time'");
	$reporthourarray = mysql_fetch_row($reporthourquery);
	$reportquery = mysql_query("SELECT SUM(count) FROM `tokens_request` WHERE `playerid` = $userid AND `date` = '$date'");
	$reportarray = mysql_fetch_row($reportquery);
	$reporthourcount = $reporthourarray[0];
	$reportcount = $reportarray[0];
	if(!$reporthourcount) $reporthourcount = 0;
	if(!$reportcount) $reportcount = 0;
	$contents = $reporthourcount." (".$reportcount.")";
	return $contents;
}

while ($userM = mysql_fetch_array($userM1)) {
		$pointquery = mysql_query("SELECT `points` FROM `cp_stat` WHERE `user_id` = $userM[id]");
		$point = mysql_fetch_row($pointquery);

		$useredit = "<form method='post' action='pr.php?p=edit'>
		<input type='hidden' name='action' readonly='readonly' value='edit'>
		<input type='hidden' name='accountid' readonly='readonly' value='$userM[id]'>
		<input type='submit' class='submit' value='$userM[Username]'></form>
		";

	if (isset($i) && $i == 1) { print "<tr class='tablerow1'>";
		$i=0;
	} else { print "<tr>";
		$i=1;
	}

	if($userM['Helper'] == 4) { $userM['Helper'] = '<span style=\'color:cyan\'>Chief Advisor</span>'; }
	if($userM['Helper'] == 3) { $userM['Helper'] = '<span style=\'color:cyan\'>Senior Advisor</span>'; }
	if($userM['Helper'] == 2) { $userM['Helper'] = '<span style=\'color:cyan\'>Community Advisor</span>'; }

	if($userM['Online'] > 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-online.png' alt='Online' />"; }
	if($userM['Online'] == 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-offline.png' alt='Offline' />"; }
	
print "
<td>$status</td>
<td>".FlagByIP($userM['IP'])."</td>
<td>$userM[Helper]</td>
<td>$useredit</td>
<td>$userM[AdvisorDutyHours]</td>
<td>".number_format($point[0])."</td>
<td>".ReportCount($userM['id'])."</td>
<td>".number_format($userM['AcceptedHelp'])."</td>
<td>".LastOnline($userM['id'])."</td>
</tr>
";
}

?>
	</table>
</div>
<?php }
if(isset($_GET['g']) && $_GET['g'] == "helper") { $helpercntquery = mysql_query("SELECT NULL FROM `accounts` WHERE `Helper` = 1");
$helpercnt = mysql_num_rows($helpercntquery); ?>
<div class='acp-box'>
<h3>Add a Helper</h3>
<form method="POST" action="pr/proc.php">
	<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
		<tr class='tablerow1'>
			<td width='20%'>Name</td>
				<td width='60%'>
					<input type="text" name="username" length="64">
				</td>
			<td width='20%'>
				<input type="hidden" name="action" readonly="readonly" value="addhelper">
				<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
				<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
				<input type="submit" class="button" value="Add Helper">
			</td>
		</tr>
	</table>
</form>
<h3>Helper List <span style='float:right'>Number of Helpers: <?php echo $helpercnt; ?></span></h3>
<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
<tr><th width='5%'></th><th width='5%'></th><th>Name</th><th>Last Online</th><th>Remove</th></tr>
<?php
$sql = "SELECT `id`, `Online`, `IP`, `Username`, `Helper` FROM `accounts` WHERE `Helper` = 1 ORDER BY Username ASC";
$userM1 = mysql_query($sql);
while ($userM = mysql_fetch_array($userM1)) {

	if (isset($i) && $i == 1) { print "<tr class='tablerow1'>";
		$i=0;
	} else { print "<tr>";
		$i=1;
	}

	$remove = "
	<form method='POST' action='pr/proc.php'>
	<input type='hidden' name='action' readonly='readonly' value='removehelper'>
	<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
	<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
	<input type='hidden' name='accountid' readonly='readonly' value='$userM[id]'>
	<input type='hidden' name='username' readonly='readonly' value='$userM[Username]'>
	<input type='image' src='../../global/images/all/icons/cross.png' alt='Remove'></form>
	";

	if($userM['Online'] > 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-online.png' alt='Online' />"; }
	if($userM['Online'] == 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-offline.png' alt='Offline' />"; }
	
print "
<td>$status</td>
<td>".FlagByIP($userM['IP'])."</td>
<td>$userM[Username]</td>
<td>".LastOnline($userM['id'])."</td>
<td>$remove</td>
</tr>
";
}

?>
	</table>
</div>
<?php } ?>
</div>
<?php }
else { echo "You do not have access to this section."; } ?>