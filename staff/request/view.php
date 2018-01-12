<div id='content_wrap'>
	<ol id='breadcrumb'><li>Requests > View Requests</li></ol>
<?php if($inf['AdminLevel'] >= 4) { ?>
	<div class='section_title'><h2>Whitelist Requests</h2></div>
		<div class='acp-box'><h3>Whitelist Request List</h3>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'> 
			<tr>
				<th>Admin</th>
				<th>Current IP</th>
				<th>Current Whitelisted IP</th>
				<th>Requested Whitelist IP</th>
				<th>Password Match</th>
				<th>Date</th>
				<th>Approve/Deny</th>
			</tr>

<?php
$wlreqquery = mysql_query("SELECT * FROM `cp_whitelist` ORDER BY `username` DESC");
	while ($wlreq = mysql_fetch_array($wlreqquery)) {
	$adminquery = mysql_query("SELECT `Key`, `IP`, `SecureIP`, `AdminLevel`, `Helper` FROM `accounts` WHERE `id` = '$wlreq[id]'");
	$admin = mysql_fetch_array($adminquery);

	if($wlreq['key'] == $admin['Key']) { $key = "<img src='http://".$_SERVER["SERVER_NAME"]."/global/images/all/icons/tick.png' />"; }
	if($wlreq['key'] <> $admin['Key']) { $key = "<img src='http://".$_SERVER["SERVER_NAME"]."/global/images/all/icons/cross.png' />"; }
	
$form = "
<form method='post' action='request/proc.php'>
<input type='hidden' name='action' readonly='readonly' value='wl_approve'>
<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
<input type='hidden' name='id' readonly='readonly' value='$wlreq[id]'>
<input type='hidden' name='username' readonly='readonly' value='$wlreq[username]'>
<input type='hidden' name='req_ip' readonly='readonly' value='$wlreq[ip]'>
<input type='image' src='/global/images/all/icons/tick.png' alt='Approve'>
</form>

<form method='post' action='request/proc.php'>
<input type='hidden' name='action' readonly='readonly' value='wl_deny'>
<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
<input type='hidden' name='id' readonly='readonly' value='$wlreq[id]'>
<input type='hidden' name='username' readonly='readonly' value='$wlreq[username]'>
<input type='hidden' name='req_ip' readonly='readonly' value='$wlreq[ip]'>
<input type='image' src='/global/images/all/icons/cross.png' alt='Deny'>
</form>
";

$wlreq['date'] = date("n/j/o g:iA", strtotime("$wlreq[date]"));

if (isset($i) && $i == 1) {
print "<tr>";
$i=0;
} else { 
print "<tr class='tablerow1'>"; 
$i=1;
}

if($inf['AdminLevel'] == 4 && $admin['AdminLevel'] <= 4) { print "<td>".UserRank($admin['AdminLevel'],$admin['Helper'],$wlreq['username'])."</td><td>".FlagByIP($admin['IP'])." $admin[IP]</td><td>".FlagByIP($admin['SecureIP'])." $admin[SecureIP]</td><td>".FlagByIP($wlreq['ip'])." $wlreq[ip]</td><td>$key</td><td>$wlreq[date]</td><td>$form</td>"; }
if($inf['AdminLevel'] == 1337 && $admin['AdminLevel'] <= 1337) { print "<td>".UserRank($admin['AdminLevel'],$admin['Helper'],$wlreq['username'])."]</td><td>".FlagByIP($admin['IP'])." $admin[IP]</td><td>".FlagByIP($admin['SecureIP'])." $admin[SecureIP]</td><td>".FlagByIP($wlreq['ip'])." $wlreq[ip]</td><td>$key</td><td>$wlreq[date]</td><td>$form</td>"; }
if($inf['AdminLevel'] == 1338 && $admin['AdminLevel'] <= 1338) { print "<td>".UserRank($admin['AdminLevel'],$admin['Helper'],$wlreq['username'])."</td><td>".FlagByIP($admin['IP'])." $admin[IP]</td><td>".FlagByIP($admin['SecureIP'])." $admin[SecureIP]</td><td>".FlagByIP($wlreq['ip'])." $wlreq[ip]</td><td>$key</td><td>$wlreq[date]</td><td>$form</td>"; }
if($inf['AdminLevel'] == 99999 && $admin['AdminLevel'] <= 99999) { print "<td>".UserRank($admin['AdminLevel'],$admin['Helper'],$wlreq['username'])."</td><td>".FlagByIP($admin['IP'])." $admin[IP]</td><td>".FlagByIP($admin['SecureIP'])." $admin[SecureIP]</td><td>".FlagByIP($wlreq['ip'])." $wlreq[ip]</td><td>$key</td><td>$wlreq[date]</td><td>$form</td>"; }
print "</tr>";
}
}
?>
			</table>
		</div>
<?php if($inf['AdminLevel'] >= 1337) { ?>
	<div class='section_title'><h2>Staff Email Requests</h2></div>
		<div class='acp-box'><h3>Staff Email Request List</h3>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'> 
			<tr>
				<th>Admin</th>
				<th>Requested Email</th>
				<th>Approve/Deny</th>
			</tr>

<?php
$reqquery = mysql_query("SELECT * FROM `cp_cache_email` WHERE `email_address` NOT LIKE '%@%' ORDER BY id DESC");
	while ($req = mysql_fetch_array($reqquery)) {
	$namequery = mysql_query("SELECT `Username` FROM `accounts` WHERE `id` = '$req[user_id]'");
	$name = mysql_fetch_row($namequery);

$form = "
<form method='post' action='request/proc.php'>
<input type='hidden' name='action' readonly='readonly' value='approve'>
<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
<input type='hidden' name='id' readonly='readonly' value='$req[id]'>
<input type='hidden' name='userID' readonly='readonly' value='$req[user_id]'>
<input type='hidden' name='email' readonly='readonly' value='$req[email_address]'>
<input type='image' src='/global/images/all/icons/tick.png' alt='Approve'>
</form>

<form method='post' action='request/proc.php'>
<input type='hidden' name='action' readonly='readonly' value='deny'>
<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
<input type='hidden' name='id' readonly='readonly' value='$req[id]'>
<input type='hidden' name='userID' readonly='readonly' value='$req[user_id]'>
<input type='hidden' name='email' readonly='readonly' value='$req[email_address]'>
<input type='image' src='/global/images/all/icons/cross.png' alt='Deny'>
</form>
";
if (isset($i) && $i == 1) {
print "<tr>";
$i=0;
} else { 
print "<tr class='tablerow1'>"; 
$i=1;
}
print "
	<td>$name[0]</td>
	<td>$req[email_address]@ng-gaming.net</td>
	<td>$form</td>
</tr>
";
}
?>
			</table>
	</div>
</div>
<?php } ?>