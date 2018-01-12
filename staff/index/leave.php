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
<?php
if(isset($_POST['action']) && $_POST['action'] == "doLeave") {
	$reason = $_POST['reason'];
	$leave_date = isset($_POST["date1"]) ? $_POST["date1"] : "";
	$return_date = isset($_POST["date2"]) ? $_POST["date2"] : "";
	$query6 = "INSERT INTO `cp_leave` (`id`, `user_id`, `date`, `date_leave`, `date_return`, `reason`, `status`) VALUES (NULL, '$inf[id]', NOW(), '$leave_date', '$return_date', '$reason', '1')";
	mysql_query($query6);
	echo $redir;
}
?>

			<div id='content_wrap'> 
				<ol id='breadcrumb'><li><?php echo $section; ?> > On-Leave Request</li></ol>
			<div class='section_title'><h2>On-Leave Request</h2></div>

		<div class='acp-box'>
		<h3>On-Leave Request</h3>
		<?php
			 
echo '<form action="index.php?p=leave" method="POST">';
echo '<table class="double_pad" cellpadding="0" cellspacing="0" border="0" width="100%">';
echo '<tr class="tablerow1"><td width="40%">Leave Date</td><td width="60%">';

//get class into the page

echo "<div style='width:275px;'><input style='margin-right:2px;' type='text' name='date1' id='date1' size='10' maxlength='10'/><img src='../global/images/iconCalendar.gif'></img></div>";

echo '</td></tr>';
echo '<tr><td>Return Date</td><td>';

echo "<div style='width:275px;'><input style='margin-right:2px;' type='text' name='date2' id='date2' size='10' maxlength='10'/><img src='../global/images/iconCalendar.gif'></img></div>";

echo '</td></tr>';

echo '<tr class="tablerow1"><td>Reason</td><td style="float:left"><input type="text" size="50" name="reason"></td></tr>';
echo '<tr class="acp-actionbar"><td colspan="2"><input type="hidden" name="action" value="doLeave"><input type="submit" class="button" value="Request Leave"></td></tr>';
echo '</table>';
echo '</form>';
?>
		</div></div>