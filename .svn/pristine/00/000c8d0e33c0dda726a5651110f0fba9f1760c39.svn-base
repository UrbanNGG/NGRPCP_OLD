<?php if($inf['AdminLevel'] < 1337) {
	echo $redir2;
	exit();
}
?>
 
			<div id='content_wrap'>
				<ol id='breadcrumb'><li>User Management > View Pending Check-Ins</li></ol>
				<div class='section_title'><h2>Pending Check-Ins</h2></div>
			<div class='acp-box'>
				<h3>Pending Check-Ins</h3>
					<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
<tr><th>Name</th><th>Date</th><th>Status</th><th>Points</th><th>Accept Check-In</th><th>Deny Check-In</th></tr>

<?php
$check1 = mysql_query("SELECT * FROM user_checkins WHERE status = 'Pending' ORDER BY user");
while ($check = mysql_fetch_array($check1)) {

						if ($i == 1) {
							print "<tr class='tablerow1'>";
						$i=0;
						} else { 
							print "<tr>";
						$i=1;
						}

print "
<td>$check[user]</a></td>
<td>$check[date]</td>
<td>$check[status]</td>

<form method=POST action=proc/editUser.php>
<input type=hidden name=ip readonly=readonly value=$_SERVER[REMOTE_ADDR]>
<input type=hidden name=action readonly=readonly value=acceptCheckin>
<input type=hidden name=admin readonly=readonly value=$_SESSION[myusername]>
<input type=hidden name=faUser readonly=readonly value=$check[user]>
<input type=hidden name=fID readonly=readonly value=$check[id]>
<td><input type=text name=npoints></td>
<td><input type=submit value=Accept></form>
</td>

<td><form method=POST action=proc/editUser.php>
<input type=hidden name=ip readonly=readonly value=$_SERVER[REMOTE_ADDR]>
<input type=hidden name=action readonly=readonly value=denyCheckin>
<input type=hidden name=admin readonly=readonly value=$_SESSION[myusername]>
<input type=hidden name=faUser readonly=readonly value=$check[user]>
<input type=hidden name=fID readonly=readonly value=$check[id]>
<input type=submit value=Deny></form>
</td>
</tr>
"; }
?>
					</table>
					<div class='acp-actionbar'></div>
			</div></div>