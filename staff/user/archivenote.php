<?php if($inf['AdminLevel'] < 1338 && $inf['AP'] < 2 && $inf['HR'] < 2) {
	echo $redir2;
	exit();
}
?>

			<div id='content_wrap'>
				<ol id='breadcrumb'><li>User Management > View Archived Notes</li></ol>
				<div class='section_title'><h2>Archived Notes</h2></div>
			<div class='acp-box'>
				<h3>Archived Notes</h3>
					<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'> 
<tr><th>Admin</th><th>Type</font></td><th>Added By</th><th>Added</th><th>Points</th></td><th>Note</th></tr>

<?php
$note1 = mysql_query("SELECT * FROM `user_notes` ORDER BY `uid` ASC, `type` ASC, `addDate` ASC");
while ($note = mysql_fetch_array($note1)) {
if($note['type'] == 1) { $type_char = 'Commendation'; }
if($note['type'] == 2) { $type_char = 'Infraction'; }

		if (isset($i) && $i == 1) {
			print "<tr class='tablerow1'>";
		$i=0;
		} else { 
			print "<tr>";
		$i=1;
		}

print "
<td>$note[uid]</td>
<td>$type_char</td>
<td>$note[invokeid]</td>
<td>$note[addDate]</td>
<td>$note[points]</td>
<td>$note[note]</td>
</tr>
";
}
?>
	</table>
	<div class='acp-actionbar'></div>
</div></div>