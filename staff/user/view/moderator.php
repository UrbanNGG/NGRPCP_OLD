<?php if($inf['AdminLevel'] >= 1337) { $senmodcntquery = mysql_query("SELECT `AdminLevel`, `SeniorModerator` FROM `accounts` WHERE `AdminLevel` = 1 AND `SeniorModerator` = 1");
$senmodcnt = mysql_num_rows($senmodcntquery); ?>
<h3>Senior Moderators <span style='float:right'>Number of Senior Moderators: <?php echo $senmodcnt; ?></span></h3>
<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
<tr><th width='5%'></th><th width='5%'></th><th>Name</th><th>Last Online</th><th>Remove</th></tr>
<?php
$sql = "SELECT `id`, `Online`, `Username`, `IP`, `AdminLevel`, `SeniorModerator` FROM `accounts` WHERE `AdminLevel` = 1 AND `SeniorModerator` = 1 ORDER BY Username ASC";
$userM1 = mysql_query($sql);
while ($userM = mysql_fetch_array($userM1)) {

		$useredit = "<form method='post' action='user.php?p=edit&u=mod'>
		<input type='hidden' name='action' readonly='readonly' value='edit'>
		<input type='hidden' name='uID' readonly='readonly' value='$userM[id]'>
		<input type='submit' class='submit' value='$userM[Username]'></form>
		</form>";

	if (isset($i) && $i == 1) { print "<tr class='tablerow1'>";
		$i=0;
	} else { print "<tr>";
		$i=1;
	}
	
	$remove = "
	<form method='POST' action='user/proc.php'>
	<input type='hidden' name='action' readonly='readonly' value='removemod'>
	<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
	<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
	<input type='hidden' name='uID' readonly='readonly' value='$userM[id]'>
	<input type='hidden' name='username' readonly='readonly' value='$userM[Username]'>
	<input type='image' src='../../global/images/all/icons/cross.png' alt='Remove'></form>
	";

	if($userM['Online'] > 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-online.png' alt='Online' />"; }
	if($userM['Online'] == 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-offline.png' alt='Offline' />"; }

print "
<td>$status</td>
<td>".FlagByIP($userM['IP'])."</td>
<td>$useredit</td>
<td>".LastOnline($userM['id'])."</td>
<td>$remove</td>
</tr>
";
}
?>
</table>
<?php $modcntquery = mysql_query("SELECT `AdminLevel`, `SeniorModerator` FROM `accounts` WHERE `AdminLevel` = 1 AND `SeniorModerator` = 0");
$modcnt = mysql_num_rows($modcntquery); ?>
<h3>Server Moderators <span style='float:right'>Number of Server Moderators: <?php echo $modcnt; ?></span></h3>
<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
<tr><th width='5%'></th><th width='5%'></th><th>Name</th><th>Last Online</th><th>Remove</th></tr>
<?php
$sql = "SELECT `id`, `Online`, `IP`, `Username`, `AdminLevel`, `SeniorModerator` FROM `accounts` WHERE `AdminLevel` = 1 AND `SeniorModerator` = 0 ORDER BY Username ASC";
$userM1 = mysql_query($sql);
while ($userM = mysql_fetch_array($userM1)) {

		$useredit = "<form method='post' action='user.php?p=edit&u=mod'>
		<input type='hidden' name='action' readonly='readonly' value='edit'>
		<input type='hidden' name='uID' readonly='readonly' value='$userM[id]'>
		<input type='submit' class='submit' value='$userM[Username]'></form>
		</form>";

	if (isset($i) && $i == 1) { print "<tr class='tablerow1'>";
		$i=0;
	} else { print "<tr>";
		$i=1;
	}
	
	$remove = "
	<form method='POST' action='user/proc.php'>
	<input type='hidden' name='action' readonly='readonly' value='removemod'>
	<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
	<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
	<input type='hidden' name='uID' readonly='readonly' value='$userM[id]'>
	<input type='hidden' name='username' readonly='readonly' value='$userM[Username]'>
	<input type='image' src='../../global/images/all/icons/cross.png' alt='Remove'></form>
	";
	
	if($userM['Online'] > 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-online.png' alt='Online' />"; }
	if($userM['Online'] == 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-offline.png' alt='Offline' />"; }
	
print "
<td>$status</td>
<td>".FlagByIP($userM['IP'])."</td>
<td>$useredit</td>
<td>".LastOnline($userM['id'])."</td>
<td>$remove</td>
</tr>
";
}
?>
</table>

<?php if($inf['AdminLevel'] > 1337) { ?>
<h3>Add a Moderator</h3>
<form method="POST" action="user/proc.php">
	<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
		<tr class='tablerow1'>
			<td width='15%'>Name</td>
				<td width='32%'>
					<input type="text" name="username" length="64">
				</td>
			<td width='15%'>Senior Moderator?</td>
				<td width='32%'>
					<input type="hidden" name="senmod" value="0" /><input type="checkbox" name="senmod" value="1" />
				</td>
			<td width='6%'>
				<input type="hidden" name="action" readonly="readonly" value="addmoderator">
				<input type="hidden" name="rank" readonly="readonly" value="1">
				<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
				<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
				<input type="submit" class="button" value="Add Moderator">
			</td>
		</tr>
	</table>
</form>
<?php }
}
else { echo "You do not have access to this section."; } ?>