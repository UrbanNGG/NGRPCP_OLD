<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<?php if($access['ban'] != 1 && $inf['BanAppealer'] < 1 && $inf['AdminLevel'] > 4) {
	echo $redir;
	exit();
}
require('.././global/jquery_int.php');

$banid = $_POST['id'];
$banquery = mysql_query("SELECT * FROM `bans` WHERE `id` = $banid");
$ban = mysql_fetch_array($banquery);

if($ban['status'] > -1) {
?>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
  <script src="http://code.jquery.com/jquery-1.8.3.js"></script>
  <script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />
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
						});
  $(function() {
    $( document ).tooltip();
  });
  </script>
		<div id='content_wrap'>
			<ol id='breadcrumb'><li>Bans > Editing Ban Details</li></ol>
			<div class='section_title'><h2>Editing <?php echo GetName($ban['user_id'])." (".$ban['user_id'].")"; ?>'s Ban Details</h2></div>
			<div class='acp-box'>
				<h3>Edit Ban #<?php echo $ban['id']; ?></h3>
				<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
				<form method="post" action="ban/proc.php">
					<tr class='tablerow1'>
						<td width='40%'>Player</td>
						<td><?php echo GetName($ban['user_id']); ?></td>
					</tr>
					<tr>
						<td>IP Address</td>
						<td><?php echo $ban['ip_address']; ?></td>
					</tr>
					<tr class='tablerow1'>
						<td>Reason</td>
						<td><?php echo $ban['reason']; ?></td>
					</tr>
					<tr>
						<td>Date Added</td>
						<td><?php echo date("F j, Y - g:iA", strtotime($ban['date_added'])); ?></td>
					</tr>
					<tr class='tablerow1'>
						<td>Unban Date</td>
						<td>
						<input style="margin-right:2px;" type="text" name="dateunban" id="date1" size="10" maxlength="10"/><img src='../global/images/iconCalendar.gif'></img>
						</td>
					</tr>
					<tr>
						<td>Status</td>
						<td>
							<select name="status">
								<option value="1"<?php if($ban['status'] == "1") { echo " selected"; } ?>>Pending Appeal</option>
								<option value="2"<?php if($ban['status'] == "2") { echo " selected"; } ?>>Temporary Banned</option>
								<option value="3"<?php if($ban['status'] == "3") { echo " selected"; } ?>>Permanent Banned</option>
								<option value="4"<?php if($ban['status'] == "4") { echo " selected"; } ?>>Unbanned</option>
								<option value="5"<?php if($ban['status'] == "5") { echo " selected"; } ?>>Archived</option>
							</select>
						</td>
					</tr>
					<tr class='tablerow1'>
						<td>Link to Appeal</td>
						<td><input type="text" title="Make sure to include 'http://' before the link" name="link" size="30"></td>
					</tr>
					<tr>
						<td>Banned By</td>
						<td><?php echo $ban['admin']; ?></td>
					</tr>
					<tr class='acp-actionbar'><td colspan='2'>
					<input type="hidden" name="action" readonly="readonly" value="edit">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="hidden" name="id" readonly="readonly" value="<?php echo $banid; ?>">
					<input type="submit" class="button" value="Edit">
					</form>
					</td></tr>
				</table>
			</div>
		</div>
<?php }
else { echo '<meta http-equiv="refresh" content="0;url=..ban.php?p=view&type=pending">'; } ?>