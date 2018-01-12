<?php if($inf['AdminLevel'] < 1337) {
	echo $redir2;
	exit();
}
?>

			<div id='content_wrap'>
				<ol id='breadcrumb'><li>User Management > View Archived Leaves</li></ol>
				<div class='section_title'><h2>Archived Leaves</h2></div>
			<div class='acp-box'>
				<h3>Archived Leaves</h3>
					<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'> 
<tr><th>Admin</th><th>Date Requested</th><th>Date of Leave</th><th>Date Returned</th><th width='70%'>Reason</th></tr>

<?php
$leavequery = mysql_query("SELECT * FROM `cp_leave` WHERE `status` > 1 AND `date_return` < NOW() ORDER BY `date_return` DESC");
while ($leavearray = mysql_fetch_array($leavequery)) {

		if (isset($i) && $i == 1) {
			print "<tr class='tablerow1'>";
		$i=0;
		} else { 
			print "<tr>";
		$i=1;
		}

print "
<td>".GetName($leavearray['user_id'])."</td>";
if(is_null($leavearray['date'])) echo "<td>N/A</td>";
else echo "<td>".date('F j, Y', strtotime($leavearray['date']))."</td>";
print "
<td>".date('F j, Y', strtotime($leavearray['date_leave']))."</td>
<td>".date('F j, Y', strtotime($leavearray['date_return']))."</td>
<td>$leavearray[reason]</td>
</tr>
";
}
$aleave = mysql_query("SELECT * FROM `user_leaves` ORDER BY `uid` ASC, `date_leave` ASC");
while ($leave = mysql_fetch_array($aleave)) {

		if (isset($i) && $i == 1) {
			print "<tr class='tablerow1'>";
		$i=0;
		} else { 
			print "<tr>";
		$i=1;
		}

print "
<td>$leave[uid]</td>
<td>N/A</td>
<td>".date('F j, Y', strtotime($leave['date_leave']))."</td>
<td>".date('F j, Y', strtotime($leave['date_return']))."</td>
<td>$leave[reason]</td>
</tr>
";
}
?>
	</table>
	<div class='acp-actionbar'></div>
</div></div>