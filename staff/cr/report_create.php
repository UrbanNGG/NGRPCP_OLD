<?php if($inf['AdminLevel'] >= 1337 || $inf['ShopTech'] > 0) { ?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li><?php echo $section; ?> > Viewing Weekly Reports</li></ol>
	<div class='section_title'><h2>Create a Report</h2></div>
	<?php
		if(isset($_GET['n']) && $_GET['n'] == 1) { echo "<div class='acp-message'>Your report has been submitted.</div>"; }
	?>
	<div class='acp-box'>
	<h3>Weekly Report Form</h3>
		<table class="double_pad" cellpadding="0" cellspacing="0" border="0" width="100%">
		<form name="punish" method="POST" action="cr/proc.php">
			<tr class="tablerow1">
				<td width="50%">How has your week been?</td>
				<td><input type="text" name="q1" size="37"></td>
			</tr>
			<tr>
				<td>Have you experienced any issues?</td>
				<td><input type="text" name="q2" size="37"></td>
			</tr>
			<tr class="tablerow1">
				<td>How many hours, approximately, have you spent doing Shop Tech work?</td>
				<td><input type="text" name="q3" size="37"></td>
			</tr>
			<tr>
				<td>If you haven't completed 21 hours of duty this week, why haven't you?</td>
				<td><textarea name="q4" cols="30" rows="3"></textarea></td>
			</tr>
			<tr class="tablerow1">
				<td>What shifts have you been working in?</td>
				<td><input type="text" name="q5" size="37"></td>
			</tr>
				<input type="hidden" name="action" readonly="readonly" value="report_add">
				<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
				<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
				<input type="hidden" name="admin_id" readonly="readonly" value="<?php echo $inf['id']; ?>">
			<tr class="acp-actionbar"><td colspan="2"><input type="submit" class="button" value="Submit"></td></tr>
		</form>
		</table>
	</div>
</div>
<?php } 
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>