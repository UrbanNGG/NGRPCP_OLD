<?php
require('../../global/func.php');
if(isset($_GET['y'])) { $assignday = $_GET['y']; }
if(isset($_GET['d'])) { $assigndate = $_GET['d']; }
$redir = '<meta http-equiv="refresh" content="0;url=../login.php">';

if(!isset($_SESSION['myusername'])){
$logged = 0;
echo $redir;
exit();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php head($inf); ?>
</head>

<?php if($inf['AdminLevel'] >= 1337 || $inf['ShopTech'] > 0 && isset($_GET['y']) && isset($_GET['d'])) { ?>

	<div style='margin-left:0px' id='main_content'>
			<div style='padding:10px' id='content_wrap'>
				<div class='section_title'><h2>Shifts</h2></div>
			<div class='acp-box'>
				<table cellpadding='0' class='double_pad' cellspacing='0' border='1' width='100%'><tr><th width='15%'>Shift</th><th width='15%'>Needs</th><th width='20%'>Start Time (GMT -6)</th><th width='20%'>Start Time (Server Time)</th></tr>
					<?php $shift1 = mysql_query("SELECT * FROM `cp_shift_blocks` ORDER BY id ASC");
						$num=mysql_numrows($shift1);
						while ($shift = mysql_fetch_array($shift1)) {
						if (isset($r) && $r == 1) {
							print "<tr>";
						$r=0;
						} else { 
							print "<tr class='tablerow1'>";
						$r=1;
						}
							$needsquery = mysql_query("SELECT * FROM `cp_shifts` WHERE `date` = '$assigndate' AND `type` = 2 AND `shift_id` = '$shift[id]' AND `status` >= '2'");
							$need = mysql_num_rows($needsquery);
							$shiftday = 3;
							if($need < $shiftday) { $totalneeds = "<span style='font-weight:bold;color:red'>".$need."/".$shiftday."</span>"; }
							if($need >= $shiftday) { $totalneeds = "<span style='font-weight:bold;color:green'>".$need."/".$shiftday."</span>"; }
					if(date("H:i:s") > $shift['time_start'] && date("H:i:s") < $shift['time_end']) { echo '<td style="font-weight:bold;">'.$shift['shift'].'</td><td>'.$totalneeds.'</td><td style="font-weight:bold;">'.date("g A", strtotime("$shift[time_start]")).'</td><td style="font-weight:bold;">'.date("H:i", strtotime("$shift[time_start]")).'</td>'; }
					else { echo '<td>'.$shift['shift'].'</td><td>'.$totalneeds.'</td><td>'.date("g A", strtotime("$shift[time_start]")).'</td><td>'.date("H:i", strtotime("$shift[time_start]")).'</td>'; }
					}
					?>
				</table>
			</div>
			<div style="padding-top:20px">
				<div class='section_title'><h2>Choose your shift(s)</h2></div>
				<form method="post" action="proc.php">
					<select name="shiftid[]" style="text-align:center;width:100px" multiple>
						<?php $shiftquery = mysql_query("SELECT * FROM `cp_shift_blocks` ORDER BY id ASC");
						while ($shiftassign = mysql_fetch_array($shiftquery)) {
							$need2query = mysql_query("SELECT * FROM `cp_shifts` WHERE `type` = 2 AND `date` = '$assigndate' AND `shift_id` = '$shiftassign[id]' AND `status` >= '2'");
							$need2 = mysql_num_rows($need2query);
							$usercheckquery = mysql_query("SELECT `shift_id` FROM `cp_shifts` WHERE `type` = 2 AND `date` = '$assigndate' AND `shift_id` = '$shiftassign[id]' AND `user_id` = '$inf[ID]'");
							$useridcheck = mysql_fetch_row($usercheckquery);
							if($need2 < 3 && $useridcheck[0] != $shiftassign['id']) { echo "<option value='".$shiftassign['id']."'>".$shiftassign['shift']."</option>"; }
						} ?>
					</select>
					<input type="hidden" name="action" readonly="readonly" value="assign">
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<input type="hidden" name="admin_id" readonly="readonly" value="<?php echo $inf['id']; ?>">
					<input type="hidden" name="assigndate" readonly="readonly" value="<?php echo $assigndate; ?>">
					<input type="submit" class="button" value="Submit">
				</form>
				<p style="font-size:x-small"><em>Use Ctrl + left-click to select multiple shifts.</em></p>
			</div>
			<div align="center" style="padding-top:25px;font-weight:bold;color:red">Reminder: You need to select a minimum of 21 shifts each week.</div>
			</div>
	</div>
	<?php }
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this section.</h2></div></div>"; } ?>
</body>
</html>