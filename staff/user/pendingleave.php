<?php if($inf['AdminLevel'] < 1338 && $inf['HR'] < 2 && $inf['AP'] < 2) {
	echo $redir2;
	exit();
}
?>

			<div id='content_wrap'>
				<ol id='breadcrumb'><li>User Management > View Pending Leaves</li></ol> 
				<div class='section_title'><h2>Pending Leaves</h2></div>
			<div class='acp-box'>
				<h3>Pending Leaves</h3>
					<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
<tr><th>User</th><th>Date Requested</th><th>Leave Date</th><th>Return Date</th><th>Reason</th></td><th>Accept</th><th>Deny</th></tr>

<?php
$leavequery = mysql_query("SELECT * FROM cp_leave WHERE status = '1' AND `date_return` > DATE(NOW()) ORDER BY date_leave");
while ($leave = mysql_fetch_array($leavequery)) {
$userquery = mysql_query("SELECT `Username` FROM `accounts` WHERE `id` = '$leave[user_id]'");
$user = mysql_fetch_array($userquery);

						if (isset($i) && $i == 1) {
							print "<tr class='tablerow1'>";
						$i=0;
						} else { 
							print "<tr>";
						$i=1;
						}

print "
<td>$user[0]</a></td>";
if(is_null($leave['date'])) echo "<td>N/A</td>";
else echo "<td>".date('F j, Y', strtotime($leave['date']))."</td>";
print "
<td>".date('F j, Y', strtotime($leave['date_leave']))."</td>
<td>".date('F j, Y', strtotime($leave['date_return']))."</td>
<td>$leave[reason]</td>

<td><form method='POST' action='user/proc.php'>
<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
<input type='hidden' name='action' readonly='readonly' value='acceptLeave'>
<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
<input type='hidden' name='acceptID' readonly='readonly' value='$inf[id]'>
<input type='hidden' name='uID' readonly='readonly' value='$leave[user_id]'>
<input type='hidden' name='leaveID' readonly='readonly' value='$leave[id]'>
<input type='hidden' name='user' readonly='readonly' value='$user[0]'>
<input class='button' type='submit' value='Accept'></form>
</td>

<td><form method='POST' action='user/proc.php'>
<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
<input type='hidden' name='action' readonly='readonly' value='denyLeave'>
<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
<input type='hidden' name='uID' readonly='readonly' value='$leave[user_id]'>
<input type='hidden' name='leaveID' readonly='readonly' value='$leave[id]'>
<input type='hidden' name='user' readonly='readonly' value='$user[0]'>
<input class='button' type='submit' value='Deny'></form>
</td>
</tr>
"; }
?>
	</table>
 
				<div class='acp-actionbar'></div>
			</div></div>