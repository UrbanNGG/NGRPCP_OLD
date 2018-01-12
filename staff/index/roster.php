<?php if($inf['AdminLevel'] >= 2 || $inf['Helper'] >= 2) { ?>
<div id='content_wrap'> 
	<ol id='breadcrumb'><li><?php echo $section; ?> > Roster</li></ol>
	<div class='section_title'><h2><?php if($inf['AdminLevel'] >= 2) { echo "Administrative"; } else { echo "Advisory"; } ?> Roster</h2></div>
	<div class='acp-box'>
		<h3><?php if($inf['AdminLevel'] >= 2) { echo "Administrative"; } else { echo "Advisory"; } ?> Roster</h3>
			<table class="double_pad" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<th width='10%'></th>
				<th width='5%'></th>
				<th>Username</th>
				<th>Email Address</th>
				<th>GTalk</th>
			</tr>
			<?php
				if ($inf['AdminLevel'] >= 2) {
				$adminquery = mysql_query("SELECT `id`, `Online`, `Username`, `Email`, `AdminLevel`, `AdminType`, `IP` FROM `accounts` WHERE `AdminLevel` > 1 AND `Disabled` = '0' ORDER BY AdminLevel DESC, Username ASC");
				} else {
				$adminquery = mysql_query("SELECT `id`, `Online`, `Username`, `Email`, `Helper`, `IP` FROM `accounts` WHERE `Helper` > 1 AND `Disabled` = '0' ORDER BY Helper DESC, Username ASC");
				}
				while ($admin = mysql_fetch_array($adminquery)) {
					if ($inf['AdminLevel'] >= 2) {
					$rstatquery = mysql_query("SELECT `timezone`, `gtalk` FROM `cp_stat` WHERE `user_id` = $admin[id] AND `type` = '1'");
					} else {
					$rstatquery = mysql_query("SELECT `timezone`, `gtalk` FROM `cp_stat` WHERE `user_id` = $admin[id] AND `type` = '3'");
					}
					$rstat = mysql_fetch_array($rstatquery);
					if($rstat['timezone'] == "" || $rstat['timezone'] == "NULL") { $tz = "America/Chicago"; }
					else { $tz = $rstat['timezone']; }
					$timezone = new DateTimeZone($tz);
					$offset = $timezone->getOffset(new DateTime("now"));
					if($admin['Online'] > 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-online.png'  title='Online' alt='Online' />"; }
					if($admin['Online'] == 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-offline.png' title='Offline' alt='Offline' />"; }
					if ($inf['AdminLevel'] >= 2)
					{
						if($admin['AdminLevel'] == 2 || $admin['AdminLevel'] == 3) { $admin['Username'] = "<span style='color:lime'>".$admin['Username']."</span>"; }
						if($admin['AdminLevel'] == 4) { $admin['Username'] = "<span style='color:sandybrown'>".$admin['Username']."</span>"; }
						if($admin['AdminLevel'] == 1337) { $admin['Username'] = "<span style='color:red'>".$admin['Username']."</span>"; }
						if($admin['AdminLevel'] == 1338 || $admin['AdminLevel'] == 99999) { $admin['Username'] = "<span style='color:#298eff'>".$admin['Username']."</span>"; }
					} else {
					if($admin['Helper'] == 4 || $admin['Helper'] == 3 || $admin['Helper'] == 2) { $admin['Username'] = "<span style='color:#00f4f4'>".$admin['Username']."</span>"; }
					}
					if ($inf['AdminLevel'] >= 2) {
					if (preg_grep('/^[A-Za-z]+$/', $admin)) {
					if (isset($i) && $i == 1) {
						print "<tr>";
					$i=0;
					} else { 
						print "<tr class='tablerow1'>";
					$i=1;
					}
					print "<td>".FlagByIP($admin['IP'])." <br><span style='font-size:9px;'>(GMT ".($offset < 0 ? '-' : '+').abs(round($offset/3600)).")</span></td>";
					print "<td>$status</td>";
					print "<td><strong>$admin[Username]</strong></td>";
					print "<td><a href='mailto:$admin[Email]'>$admin[Email]</a></td>";
					print "<td>".$rstat['gtalk']."</td>";
					print "</tr>";
					}
					} else {
					if (isset($i) && $i == 1) {
						print "<tr>";
					$i=0;
					} else { 
						print "<tr class='tablerow1'>";
					$i=1;
					}
					print "<td>".FlagByIP($admin['IP'])." (GMT ".($offset < 0 ? '-' : '+').abs(round($offset/3600)).")</td>";
					print "<td>$status</td>";
					print "<td><strong>$admin[Username]</strong></td>";
					print "<td><a href='mailto:$admin[Email]'>$admin[Email]</a></td>";
					print "<td>".$rstat['gtalk']."</td>";
					print "</tr>";
					}
				}
			?>
			</table>
	</div>
	<div class='acp-box'>
		<h3>GTalk List</h3>
<textarea rows="10" style="width:100%;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;" onclick="this.focus();this.select()">
<?php
if($inf['AdminLevel'] >= 2) $gtalkquery = mysql_query("SELECT Stat.user_id, Stat.gtalk, Accounts.AdminLevel, Accounts.Disabled FROM cp_stat Stat LEFT JOIN accounts Accounts ON Stat.user_id = Accounts.id WHERE Stat.gtalk <> '' AND Stat.gtalk <> 'N/A' AND Stat.type = '1' AND Accounts.AdminLevel >= 2 AND Accounts.Disabled = 0 ORDER BY Accounts.AdminLevel DESC");
else $gtalkquery = mysql_query("SELECT Stat.user_id, Stat.gtalk, Accounts.Helper, Accounts.Disabled FROM cp_stat Stat LEFT JOIN accounts Accounts ON Stat.user_id = Accounts.id WHERE Stat.gtalk <> '' AND Stat.gtalk <> 'N/A' AND Stat.type = '3' AND Accounts.Helper >= 2 AND Accounts.Disabled = 0");

while($gtalk = mysql_fetch_array($gtalkquery))
{
	echo GetName($gtalk['user_id'])." <".$gtalk['gtalk'].">, ";
}
?>
</textarea>
	</div>
	<div style='font-weight:bolder;text-align:center;padding:10px'>
		<a href='/index.php?p=contact'>Click here to update your GTalk address.</a>
	</div>
</div>
<?php }
else { echo "You do not have access to this page."; } ?>