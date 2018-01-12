<?php if($inf['AdminLevel'] >= 1337 || $inf['ShopTech'] >= 2) { ?>
<div id='content_wrap'> 
	<ol id='breadcrumb'><li>Customer Relations > Viewing Archived Reports</li></ol> 
	<div class='section_title'><h2>Weekly Reports</h2></div>
	<div class='acp-box'>
	<h3>Archived Reports</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'> 
		<tr>
			<th>Administrator</th><th>Date</th><th>How has your week been?</th><th>Have you experienced any issues?</th><th>Hours spent on-duty</th><th>If you haven't completed 21 hours of duty this week, why haven't you?</th><th>What shifts have you been working in?</th>
		</tr>
		<?php
			$sql = mysql_query("SELECT * FROM `cp_weekly_reports` WHERE `status` = 2");
			while ($result = mysql_fetch_array($sql)) {

			if (isset($i) && $i == 1) {
				print "<tr class='tablerow1'>";
			$i=0;
			} else { 
				print "<tr>";
			$i=1;
			}
			
			print "
				<td>".GetName($result['admin_id'])."</td>
				<td>$result[date]</td>
				<td>$result[q1]</td>
				<td>$result[q2]</td>
				<td>$result[q3]</td>
				<td>$result[q4]</td>
				<td>$result[q5]</td>
			</tr>
			";
			}
		?>
		</table>
</div></div>
<?php }
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>