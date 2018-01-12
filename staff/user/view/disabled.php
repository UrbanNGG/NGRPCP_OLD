<?php if($inf['AdminLevel'] >= 1338 || $inf['AP'] >= 2) {
$sql = mysql_query("SELECT `id`, `Username` FROM `accounts` WHERE `Disabled` = '1' ORDER BY Username ASC");
$disablecount = mysql_num_rows($sql);
?>
				<h3>Disabled List <span class="table_view"><?php echo $disablecount; ?> accounts</span></h3>
<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
<tr><th>Name</th><th>Re-Enable Account</th></tr>
<?php
while ($userM = mysql_fetch_array($sql)) {

	$useredit = "<form method='post' action='user/proc.php'>
	<select name='reenable'>
		<option value='1'></option>
		<option value='2'>Re-enable Account</option>
		<option value='3'>Reinstate as Junior Admin</option>
		<option value='4'>Reinstate as General Admin</option>
	</select>
	<input type='hidden' name='action' readonly='readonly' value='disabledacctupdate'>
	<input type='hidden' name='uID' readonly='readonly' value='$userM[id]'>
	<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
	<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
	<input type='submit' class='submit' value='Submit'>
	</form>";

	if (isset($i) && $i == 1) { print "<tr class='tablerow1'>";
		$i=0;
	} else { print "<tr>";
		$i=1;
	}

	print "
	<td>$userM[Username]</td>
	<td>$useredit</td>
	</tr>
	";
}

?>
	</table>
<?php }
else { echo "You do not have access to this section."; } ?>