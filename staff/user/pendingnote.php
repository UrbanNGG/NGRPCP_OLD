<?php if($inf['AdminLevel'] < 1338 && $inf['AP'] < 2 && $inf['HR'] < 2) {
	echo $redir2;
	exit();
}
?>

			<div id='content_wrap'>
				<ol id='breadcrumb'><li>User Management > View Pending Notes</li></ol>
				<div class='section_title'><h2>Pending Notes</h2></div>
			<div class='acp-box'>
				<h3>Pending Notes</h3>
					<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'> 
<tr><th>Admin</th><th>Type</font></td><th>Added By</th><th>Added</th><th>Points</th></td><th>Note</th><th>Accept</th><th>Deny</th></tr>

<?php
$note1 = mysql_query("SELECT * FROM `cp_admin_notes` WHERE `status` = '1' ORDER BY `date` DESC");
while ($note = mysql_fetch_array($note1)) {
$userquery = mysql_query("SELECT `Username` FROM `accounts` WHERE `id` = '$note[user_id]'");
$invokeuserquery = mysql_query("SELECT `Username` FROM `accounts` WHERE `id` = $note[invoke_id]");
if($note['type'] == 1) { $type_char = 'Infraction'; }
if($note['type'] == 2) { $type_char = 'Commendation'; }
$invokeuser = mysql_fetch_array($invokeuserquery);
$user = mysql_fetch_array($userquery);

						if (isset($i) && $i == 1) {
							print "<tr class='tablerow1'>";
						$i=0;
						} else { 
							print "<tr>";
						$i=1;
						}

print "
<td>$user[0]</td>
<td>$type_char</td>
<td>$invokeuser[0]</td>
<td>$note[date]</td>
<td>$note[points]</td>
<td>$note[details]</td>

<td><form method='POST' action='user/proc.php'>
<input type='hidden' name='action' readonly='readonly' value='acceptNote'>
<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
<input type='hidden' name='accountid' readonly='readonly' value='$note[user_id]'>
<input type='hidden' name='noteID' readonly='readonly' value='$note[id]'>
<input type='hidden' name='points' readonly='readonly' value='$note[points]'>
<input type='hidden' name='type' readonly='readonly' value='$note[type]'>
<input class='button' type='submit' value='Accept'></form>
</td>

<td><form method='POST' action='user/proc.php'>
<input type='hidden' name='action' readonly='readonly' value='denyNote'>
<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
<input type='hidden' name='accountid' readonly='readonly' value='$note[user_id]'>
<input type='hidden' name='noteID' readonly='readonly' value='$note[id]'>
<input type='hidden' name='type' readonly='readonly' value='$note[type]'>
<input class='button' type='submit' value='Deny'></form>
</font>
</tr>
";
}


?>
	</table>
 
	<div class='acp-actionbar'></div>
</div></div>