				<div class='section_title'><h2>View/Delete Usergroup Leaders</h2></div>
			<div class='acp-box'>
				<h3>Usergroup Leaders</h3>
					<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'> 
<tr><th>Username</th><th>Usergroup</th><th>Delete</th></tr>

<?php
$leader1 = mysql_query("SELECT * FROM `group_leaders` ORDER BY `id`");
while ($leader = mysql_fetch_array($leader1)) {
$userquery = mysql_query("SELECT `aUser` FROM `users` WHERE `ID` = '$leader[uid]'");
$groupquery = mysql_query("SELECT `name` FROM `groups` WHERE `id` = '$leader[gid]'");
$user = mysql_fetch_array($userquery);
$group = mysql_fetch_array($groupquery);

						if ($i == 1) {
							print "<tr class='tablerow1'>";
						$i=0;
						} else { 
							print "<tr>";
						$i=1;
						}

print "
<td>$user[0]</td>
<td>$group[0]</td>

<td><form method='POST' action='user/proc.php'>
<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
<input type='hidden' name='action' readonly='readonly' value='deleteleader'>
<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
<input type='hidden' name='leaderID' readonly='readonly' value='$leader[id]'>
<input type='submit' value='Delete'></form>
</td>
</tr>
";
}


?>
	</table>