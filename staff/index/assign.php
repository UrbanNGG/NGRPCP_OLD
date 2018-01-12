<?php
require('../../global/func.php');
if(isset($_GET['y'])) { $assignday = $_GET['y']; }
if(isset($_GET['d'])) { $assigndate = $_GET['d']; }
$redir = '<meta http-equiv="refresh" content="0;url=../login.php">';

$restrictquery = mysql_query("SELECT `shift_restrict` FROM `cp_stat` WHERE `user_id` = $inf[id]");
$restrictarray = mysql_fetch_array($restrictquery);
$restrict = unserialize($restrictarray['shift_restrict']);

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

<?php if($inf['AdminLevel'] >= 2 || $inf['Helper'] >= 2 && isset($_GET['y']) && isset($_GET['d'])) {
	$timezone = new DateTimeZone($stat['timezone']);
	$offset = $timezone->getOffset(new DateTime("now"));
?>

	<div style='margin-left:0px' id='main_content'>
			<div style='padding:10px' id='content_wrap'>
				<div class='section_title'><h2>Shifts</h2></div>
			<div class='acp-box'>
				<table cellpadding='0' class='double_pad' cellspacing='0' border='1' width='100%'><tr><th width='15%'>Shift</th><th width='15%'>Needs</th><th width='20%'>Start Time -- Your Timezone (GMT <?php echo ($offset < 0 ? '-' : '+').abs(round($offset/3600)); ?>)</th><th width='20%'>Start Time -- Server Time (GMT -6)</th></tr>
					<?php 
						if ($inf['AdminLevel'] >= 2) {
							$shift1 = mysql_query("SELECT * FROM `cp_shift_blocks` WHERE `type` = '1' ORDER BY id ASC");
						} else {
							$shift1 = mysql_query("SELECT * FROM `cp_shift_blocks` WHERE `type` = '2' ORDER BY id ASC");
						}
						$num = mysql_num_rows($shift1);
						while ($shift = mysql_fetch_array($shift1)) 
						{
							if (isset($r) && $r == 1) {
								print "<tr>";
							$r=0;
							} else { 
								print "<tr class='tablerow1'>";
							$r=1;
							}
							if ($inf['AdminLevel'] >= 2) $needsquery = mysql_query("SELECT NULL FROM `cp_shifts` WHERE `type` = 1 AND `date` = '$assigndate' AND `shift_id` = '$shift[shift_id]' AND `status` >= '2' AND cp_shifts.user_id NOT IN (SELECT cp_shift_leader.user_id FROM `cp_shift_leader` WHERE cp_shifts.user_id = cp_shift_leader.user_id AND type = 1)");
							else $needsquery = mysql_query("SELECT NULL FROM `cp_shifts` WHERE `type` = 3 AND `date` = '$assigndate' AND `shift_id` = '$shift[shift_id]' AND `status` >= '2' AND cp_shifts.user_id NOT IN (SELECT cp_shift_leader.user_id FROM `cp_shift_leader` WHERE cp_shifts.user_id = cp_shift_leader.user_id AND type = 3)");
							$need = mysql_num_rows($needsquery);

							if($assignday == 'Sunday') $shiftday = $shift['needs_sunday'];
							if($assignday == 'Monday') $shiftday = $shift['needs_monday'];
							if($assignday == 'Tuesday') $shiftday = $shift['needs_tuesday'];
							if($assignday == 'Wednesday') $shiftday = $shift['needs_wednesday'];
							if($assignday == 'Thursday') $shiftday = $shift['needs_thursday'];
							if($assignday == 'Friday') $shiftday = $shift['needs_friday'];
							if($assignday == 'Saturday') $shiftday = $shift['needs_saturday'];
							if($need < $shiftday) { $totalneeds = "<span style='font-weight:bold;color:red'>".$need."/".$shiftday."</span>"; }
							if($need >= $shiftday) { $totalneeds = "<span style='font-weight:bold;color:green'>".$need."/".$shiftday."</span>"; }
							$timestart = new DateTime($shift['time_start'], new DateTimeZone('America/Chicago'));
							$timestart->setTimezone(new DateTimeZone($stat['timezone']));
							
							if($inf['AdminType'] == 3)
							{
								if(in_array($shift['shift_id'], $restrict))
								{
									if(date("H:i:s") > $shift['time_start'] && date("H:i:s") < $shift['time_end']) echo '<td style="font-weight:bold;background:#fffdbc;">'.$shift['shift'].'</td><td style="background:#fffdbc">'.$totalneeds.'</td><td style="font-weight:bold;background:#fffdbc">'.$timestart->format('g A').'</td><td style="font-weight:bold;background:#fffdbc">'.date("g A", strtotime("$shift[time_start]")).'</td>';
									else echo '<td>'.$shift['shift'].'</td><td>'.$totalneeds.'</td><td>'.$timestart->format('g A').'</td><td>'.date("g A", strtotime("$shift[time_start]")).'</td>';
								}
							}
							else
							{
								if(date("H:i:s") > $shift['time_start'] && date("H:i:s") < $shift['time_end']) echo '<td style="font-weight:bold;background:#fffdbc;">'.$shift['shift'].'</td><td style="background:#fffdbc">'.$totalneeds.'</td><td style="font-weight:bold;background:#fffdbc">'.$timestart->format('g A').'</td><td style="font-weight:bold;background:#fffdbc">'.date("g A", strtotime("$shift[time_start]")).'</td>';
								else echo '<td>'.$shift['shift'].'</td><td>'.$totalneeds.'</td><td>'.$timestart->format('g A').'</td><td>'.date("g A", strtotime("$shift[time_start]")).'</td>';
							}
						}
					?>
				</table>
			</div>
			<div style="padding-top:20px">
				<div class='section_title'><h2>Choose your shift(s)</h2></div>
				<?php if($inf['AdminLevel'] >= 2) {
						echo "<form method='post' action='proc.php?assign=admin'>";
					} else {
						echo "<form method='post' action='proc.php?assign=advisor'>";
					}
				?>
					<select name="shiftid[]" style="text-align:center;width:100px" multiple>
						<?php 
						if ($inf['AdminLevel'] >= 2) {
							$shiftquery = mysql_query("SELECT * FROM `cp_shift_blocks` WHERE `type` = '1' ORDER BY shift_id ASC");
						} else {
							$shiftquery = mysql_query("SELECT * FROM `cp_shift_blocks` WHERE `type` = '2' ORDER BY shift_id ASC");
						}
						while ($shiftassign = mysql_fetch_array($shiftquery))
						{
							if ($inf['AdminLevel'] >= 2)
							{
								$need2query = mysql_query("SELECT NULL FROM `cp_shifts` WHERE `type` = 1 AND `date` = '$assigndate' AND `shift_id` = '$shiftassign[shift_id]' AND `status` >= '2' AND cp_shifts.user_id NOT IN (SELECT cp_shift_leader.user_id FROM `cp_shift_leader` WHERE cp_shifts.user_id = cp_shift_leader.user_id AND type = 1)");
								$usercheckquery = mysql_query("SELECT `shift_id` FROM `cp_shifts` WHERE `date` = '$assigndate' AND `shift_id` = '$shiftassign[shift_id]' AND `user_id` = '$inf[id]' AND `type` = '1'");
							}
							else
							{
								$need2query = mysql_query("SELECT NULL FROM `cp_shifts` WHERE `type` = 3 AND `date` = '$assigndate' AND `shift_id` = '$shiftassign[shift_id]' AND `status` >= '2' AND cp_shifts.user_id NOT IN (SELECT cp_shift_leader.user_id FROM `cp_shift_leader` WHERE cp_shifts.user_id = cp_shift_leader.user_id AND type = 3)");
								$usercheckquery = mysql_query("SELECT `shift_id` FROM `cp_shifts` WHERE `date` = '$assigndate' AND `shift_id` = '$shiftassign[shift_id]' AND `user_id` = '$inf[id]' AND `type` = 3");
							}
							$need2 = mysql_num_rows($need2query);
							$useridcheck = mysql_fetch_row($usercheckquery);
							if($assignday == "Sunday") $shiftday = $shiftassign['needs_sunday'];
							if($assignday == "Monday") $shiftday = $shiftassign['needs_monday'];
							if($assignday == "Tuesday") $shiftday = $shiftassign['needs_tuesday'];
							if($assignday == "Wednesday") $shiftday = $shiftassign['needs_wednesday'];
							if($assignday == "Thursday") $shiftday = $shiftassign['needs_thursday'];
							if($assignday == "Friday") $shiftday = $shiftassign['needs_friday'];
							if($assignday == "Saturday") $shiftday = $shiftassign['needs_saturday'];
							if($need2 < $shiftday && $useridcheck[0] != $shiftassign['shift_id'])
							{
								if($inf['AdminType'] == 3)
								{
									if(in_array($shiftassign['shift_id'], $restrict)) echo "<option value='".$shiftassign['shift_id']."'>".$shiftassign['shift']."</option>";
								}
								else echo "<option value='".$shiftassign['shift_id']."'>".$shiftassign['shift']."</option>";
							}
						}
						?>
					</select>
					<input type="hidden" name="action" readonly="readonly" value="assign">
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<input type="hidden" name="userid" readonly="readonly" value="<?php echo $inf['id']; ?>">
					<input type="hidden" name="assigndate" readonly="readonly" value="<?php echo $assigndate; ?>">
					<input type="submit" class="button" value="Submit">
				</form>
				<p style="font-size:x-small"><em>Use Ctrl + left-click to select multiple shifts.</em></p>
			</div>
			<div align="center" style="padding-top:25px;font-weight:bold;color:red">Reminder: You need to select a minimum of <?php if($inf['AdminType'] == 3) echo "9"; else echo "15"; ?> shifts each week.</div>
			</div>
	</div>
	<?php }
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this section.</h2></div></div>"; } ?>
</body>
</html>