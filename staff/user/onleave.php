 			<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
			<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
			<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
			<script>
			  $(function() {
						$( '#date1' ).datepicker({
						  defaultDate: '+1w',
						  changeMonth: true,
						  numberOfMonths: 2,
						  minDate: "Now",
						  onClose: function( selectedDate ) {
							$( '#date2' ).datepicker( 'option', 'minDate', selectedDate );
							$( "#date1" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
						  }
						});
						$( '#date2' ).datepicker({
						  defaultDate: '+1w',
						  changeMonth: true,
						  numberOfMonths: 2,
						  minDate: 1,
						  onClose: function( selectedDate ) {
							$( "#date2" ).datepicker( "option", "dateFormat", "yy-mm-dd" );
						  }
						});
					  });
			</script>
			<div id='content_wrap'>
				<ol id='breadcrumb'><li>User Management > Users On-Leave</li></ol>
				<div class='section_title'><h2>Users On-Leave</h2></div>
			<div class='acp-box'>
			<?php if($inf['AdminLevel'] >= 1338) { ?>
			<h3>Add an Administrator</h3>
			<form action="user/proc.php" method="POST">
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
			<tr><td>Administrator</td><td>
				<select name="accountid">
				<?php $adminquery = mysql_query("SELECT `id`, `Username` FROM `accounts` WHERE `AdminLevel` > 1 AND `Disabled` = 0 ORDER BY `Username` ASC");
				while ($admin = mysql_fetch_array($adminquery)) {
					echo "<option value='$admin[id]'>$admin[Username]</option>";
				} ?>
				</select>
			</td><td>Reason</td><td><input type="text" name="reason"></td></tr>
			<tr><td>Leave Date</td><td>
			<?php
			echo "<div style='width:780px;'><input style='margin-right:2px;' type='text' name='date1' id='date1' size='10' maxlength='10'/><img src='../global/images/iconCalendar.gif'></img></div>";
			echo '</td><td>Return Date</td><td>';
			echo "<div style='width:300px;'><input style='margin-right:2px;' type='text' name='date2' id='date2' size='10' maxlength='10'/><img src='../global/images/iconCalendar.gif'></img></div>";
			?>
			<td width='10%'>
				<input type="hidden" name="action" readonly="readonly" value="leave_add">
				<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
				<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
				<input type="hidden" name="admin_id" readonly="readonly" value="<?php echo $inf['id']; ?>">
				<input type="submit" class="button" value="Add Leave">
			</td></tr></table>
			<?php } ?>
			<h3>On-Leave: Administrators</h3>
			<table class="double_pad" cellpadding="0" cellspacing="0" border="0" width="100%">
			<tr><th>Administrator</th><th>Date Requested</th><th>Leave Date</th><th>Return Date</th><th>Reason</th><th>Approved By</th></tr>

			<?php
			$leavequery = mysql_query("SELECT * FROM `cp_leave` WHERE `status` = '2' AND `date_return` > DATE(NOW()) ORDER BY `date_return` ASC");
			while($leave = mysql_fetch_array($leavequery)) {

			if (isset($i) && $i == 1) {
				print "<tr class='tablerow1'>";
			$i=0;
			} else { 
				print "<tr>";
			$i=1;
			}

		print "
		<td>".GetName($leave['user_id'])."</td>";
		if(is_null($leave['date'])) echo "<td>N/A</td>";
		else echo "<td>".date('F j, Y', strtotime($leave['date']))."</td>";
		print "
		<td>".date('F j, Y', strtotime($leave['date_leave']))."</td>
		<td>".date('F j, Y', strtotime($leave['date_return']))."</td>
		<td>$leave[reason]</td>
		<td>".GetName($leave['acceptedby_id'])."</td>
		</tr>
		";
}
			?>
			</table>
			</div></div>