<?php
$assignday = $_GET['y']; 
$assigndate = $_GET['d'];

function queryshift($shiftid,$time,$date,$id,$lshift,$level,$helper,$hr)
	{
		if($level >= 2) {
		$shiftquery = mysql_query("SELECT `id`, `user_id`, `status`, `bonus` FROM `cp_shifts` WHERE `type` = '1' AND `date` = '$date' AND `shift_id` = '$shiftid'");
		} else {
		$shiftquery = mysql_query("SELECT `id`, `user_id`, `status`, `bonus` FROM `cp_shifts` WHERE `type` = '3' AND `date` = '$date' AND `shift_id` = '$shiftid'");
		}
			$row = mysql_num_rows($shiftquery);
			$a=0;
			while($a <= $row)
			{
				$value = mysql_fetch_array($shiftquery);
				$reportcountquery = mysql_query("SELECT `id`, `count` FROM `tokens_report` WHERE `playerid` = '$value[user_id]' AND `date` = '$date' AND `hour` = '$time'");
				$reportcount = mysql_fetch_array($reportcountquery);
				switch($value['bonus'])
				{
					case 0: $bonus = ""; break;
					case 1: $bonus = "<img src='/global/images/star_silver.png' alt='Shift Assist' />"; break;
					case 2: $bonus = "<img src='/global/images/star_gold.png' alt='Early Sign-up Bonus' />"; break;
				}
				if($lshift == $shiftid)
				{
					if($value['status'] == 1) echo '<div style="padding-top:10px">'.$bonus.' <a href="user.php?p=assignedit&assignid='.$value['id'].'"><span style="color:silver"><strike>'.GetName($value['user_id']).'</strike></span></a></div>';
					if($value['status'] == 2) echo '<div style="padding-top:10px">'.$bonus.' <a href="user.php?p=assignedit&assignid='.$value['id'].'">'.GetName($value['user_id']).'</a> - Reports Accepted: '.$reportcount['count'].'</div>';
					if($value['status'] == 3) echo '<div style="padding-top:10px">'.$bonus.' <a href="user.php?p=assignedit&assignid='.$value['id'].'"><span style="color:green">'.GetName($value['user_id']).'</span></a> - Reports Accepted: '.$reportcount['count'].'</div>';
					if($value['status'] == 4) echo '<div style="padding-top:10px">'.$bonus.' <a href="user.php?p=assignedit&assignid='.$value['id'].'"><span style="color:darkorange">'.GetName($value['user_id']).'</span></a> - Reports Accepted: '.$reportcount['count'].'</div>';
					if($value['status'] == 5) echo '<div style="padding-top:10px">'.$bonus.' <a href="user.php?p=assignedit&assignid='.$value['id'].'"><span style="color:red">'.GetName($value['user_id']).'</span></a> - Reports Accepted: '.$reportcount['count'].'</div>';
				}
				if($level >= 1337 || $helper >= 3 || $hr >= 2)
				{
					if($value['status'] == 1) echo '<div style="padding-top:10px">'.$bonus.' <a href="user.php?p=assignedit&assignid='.$value['id'].'"><span style="color:silver"><strike>'.GetName($value['user_id']).'</strike></span></a></div>';
					if($value['status'] == 2) echo '<div style="padding-top:10px">'.$bonus.' <a href="user.php?p=assignedit&assignid='.$value['id'].'">'.GetName($value['user_id']).'</a> - Reports Accepted: '.$reportcount['count'].'</div>';
					if($value['status'] == 3) echo '<div style="padding-top:10px">'.$bonus.' <a href="user.php?p=assignedit&assignid='.$value['id'].'"><span style="color:green">'.GetName($value['user_id']).'</span></a> - Reports Accepted: '.$reportcount['count'].'</div>';
					if($value['status'] == 4) echo '<div style="padding-top:10px">'.$bonus.' <a href="user.php?p=assignedit&assignid='.$value['id'].'"><span style="color:darkorange">'.GetName($value['user_id']).'</span></a> - Reports Accepted: '.$reportcount['count'].'</div>';
					if($value['status'] == 5) echo '<div style="padding-top:10px">'.$bonus.' <a href="user.php?p=assignedit&assignid='.$value['id'].'"><span style="color:red">'.GetName($value['user_id']).'</span></a> - Reports Accepted: '.$reportcount['count'].'</div>';
				}
				$a++;
			}
	}
 ?>
			<div id='content_wrap'>
				<ol id='breadcrumb'><li>User Management > Shifts</li></ol>
				<div class='section_title'><h2>Shifts</h2></div>
			<div class='acp-box'>
			<?php if($inf['AdminLevel'] >= 1337 || $inf['Helper'] == 4) { ?>
				<h3>Add Shift Assignment</h3>
				<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
				<form method="POST" action="user/proc.php">
				<tr class='tablerow1'><td width="50%"><?php if($inf['AdminLevel'] >= 2) { echo "Administrator"; } else { echo "Advisor"; } ?></td><td width="50%">Shifts</td></tr>
				<tr><td><select name="uID">
					<option selected>Choose an <?php if($inf['AdminLevel'] >= 2) { echo "Administrator"; } else { echo "Advisor"; } ?>...</option>
						<?php 
						if($inf['AdminLevel'] >= 2) {
						$ulist1 = mysql_query("SELECT `id`, `Username` FROM `accounts` WHERE `AdminLevel` >= 2 ORDER BY Username");
						} else {
						$ulist1 = mysql_query("SELECT `id`, `Username` FROM `accounts` WHERE `Helper` >= 2 ORDER BY Username");
						}
						while ($ulist = mysql_fetch_array($ulist1)) {
						echo "<option value=$ulist[id]>$ulist[Username]</option>";
						} ?>
					</select></td>
					<td><select name="shiftid[]" style="text-align:center;width:100px;overflow-y:visible" size="3" multiple>
						<?php
						if($inf['AdminLevel'] >= 2) {
						$optionquery = mysql_query("SELECT * FROM `cp_shift_blocks` WHERE `type`='1'");
						} else {
						$optionquery = mysql_query("SELECT * FROM `cp_shift_blocks` WHERE `type`='2'");
						}
						while ($option = mysql_fetch_array($optionquery)) {
						print "<option value='$option[shift_id]'>$option[shift]</option>";
						} ?>
					</select></td></tr>
				<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
				<input type="hidden" name="action" readonly="readonly" value="addassign">
				<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
				<input type="hidden" name="assigndate" readonly="readonly" value="<?php echo $assigndate; ?>">
				<tr class="acp-actionbar"><td colspan="2"><input class="button" type="submit" value="Add Assignment"></td></tr>
				</form>
				</table>
				<?php } ?>
				<h3>View Assignments</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='1' width='100%'><tr>
					<?php 
						if($inf['AdminLevel'] >= 2) {
						$shiftquery = mysql_query("SELECT * FROM `cp_shift_blocks` WHERE `type`='1' ORDER BY shift_id ASC");
						} else {
						$shiftquery = mysql_query("SELECT * FROM `cp_shift_blocks` WHERE `type`='2' ORDER BY shift_id ASC");
						}
						$num=mysql_numrows($shiftquery);
						while ($shift = mysql_fetch_array($shiftquery)) {
							if($inf['AdminLevel'] >= 2) {
							$needsquery = mysql_query("SELECT * FROM `cp_shifts` WHERE `type` = '1' AND `date` = '$assigndate' AND `shift_id` = '$shift[shift_id]' AND `status` >= 2 AND cp_shifts.user_id NOT IN (SELECT cp_shift_leader.user_id FROM `cp_shift_leader` WHERE cp_shifts.user_id = cp_shift_leader.user_id AND `type` = '1')");
							} else {
							$needsquery = mysql_query("SELECT * FROM `cp_shifts` WHERE `type` = '3' AND `date` = '$assigndate' AND `shift_id` = '$shift[shift_id]' AND `status` >= 2 AND cp_shifts.user_id NOT IN (SELECT cp_shift_leader.user_id FROM `cp_shift_leader` WHERE cp_shifts.user_id = cp_shift_leader.user_id AND `type` = '2')");
							}
							$need = mysql_num_rows($needsquery);
								if($assignday == "Sunday") { $shiftday = $shift['needs_sunday']; }
								if($assignday == "Monday") { $shiftday = $shift['needs_monday']; }
								if($assignday == "Tuesday") { $shiftday = $shift['needs_tuesday']; }
								if($assignday == "Wednesday") { $shiftday = $shift['needs_wednesday']; }
								if($assignday == "Thursday") { $shiftday = $shift['needs_thursday']; }
								if($assignday == "Friday") { $shiftday = $shift['needs_friday']; }
								if($assignday == "Saturday") { $shiftday = $shift['needs_saturday']; }
							if($need < $shiftday) { $totalneeds = "<span style='font-weight:bold;color:red'>".$need."/".$shiftday."</span>"; }
							if($need >= $shiftday) { $totalneeds = "<span style='font-weight:bold;color:green'>".$need."/".$shiftday."</span>"; }
					if($inf['AdminLevel'] >= 2) {
					$shiftleadquery = mysql_query("SELECT * FROM `cp_shift_leader` WHERE `user_id` = '$inf[id]' AND `type` = '1'");
					} else {
					$shiftleadquery = mysql_query("SELECT * FROM `cp_shift_leader` WHERE `user_id` = '$inf[id]' AND `type` = '2'");
					}
					$timestart = new DateTime($shift['time_start'], new DateTimeZone('America/Chicago'));
					$timestart->setTimezone(new DateTimeZone($stat['timezone']));
					$timeend = new DateTime($shift['time_end'], new DateTimeZone('America/Chicago'));
					$timeend->setTimezone(new DateTimeZone($stat['timezone']));
					while ($shiftlead = mysql_fetch_array($shiftleadquery)) {
					if($shiftlead['shift_id'] == $shift['shift_id'] && $inf['AdminLevel'] < 1337 && $inf['Helper'] < 3) { 
						echo "<th width='12.5%'>".$shift['shift']." (".$totalneeds.") -- ".$timestart->format('gA')."-".$timeend->format('gA')." (Server Time: ".date("gA", strtotime("$shift[time_start]"))."-".date("gA", strtotime("$shift[time_end]")).")</th></tr><tr><td>";
						queryshift($shift['shift_id'],$shift['time_start'],$assigndate,$inf['id'],$shiftlead['shift_id'],$inf['AdminLevel'],$inf['Helper'],$inf['HR']);
						echo'</td>';
					}
					}
					if($inf['AdminLevel'] >= 1337 || $inf['Helper'] >= 3 || $inf['HR'] >= 2) {
						echo "<th width='12.5%'>".$shift['shift']." (".$totalneeds.") -- ".$timestart->format('gA')."-".$timeend->format('gA')." (Server Time: ".date("gA", strtotime("$shift[time_start]"))."-".date("gA", strtotime("$shift[time_end]")).")<br />Shift Leaders:";
						if($inf['AdminLevel'] >= 2) {
						$shiftadminquery = mysql_query("SELECT `user_id`, `shift_id` FROM `cp_shift_leader` WHERE `shift_id` = '$shift[shift_id]' AND `type`='1'");
						} else {
						$shiftadminquery = mysql_query("SELECT `user_id`, `shift_id` FROM `cp_shift_leader` WHERE `shift_id` = '$shift[shift_id]' AND `type`='2'");
						}
						while($shiftadmin = mysql_fetch_array($shiftadminquery)) {
							$shiftadminform = "<form method='post' action='user.php?p=assignedit'>
							<input type='hidden' name='action' readonly='readonly' value='edit'>
							<input type='hidden' name='userid' readonly='readonly' value='$shiftadmin[user_id]'>
							<input type='hidden' name='date' readonly='readonly' value='$assigndate'>
							<input type='hidden' name='shift' readonly='readonly' value='$shift[shift_id]'>
							<input type='submit' class='submit' value='".GetName($shiftadmin['user_id'])."' style='font-weight:normal'></form>";
							if(GetAdminLevel($shiftadmin['user_id']) < 1337) { echo $shiftadminform; }
						}
						echo "</th></tr><tr><td>";
						queryshift($shift['shift_id'],$shift['time_start'],$assigndate,$inf['id'],$shiftlead['shift_id'],$inf['AdminLevel'],$inf['Helper'],$inf['HR']);
						echo '</td>';
					}
					echo'</tr>';
					}
					?>
				</table>
				<h3>Legend</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='1' width='100%'><tr>
						<tr class='tablerow1'><td><span style="color:silver"><strike>Strikethrough</strike></span></td><td>Self-Removed</td></tr>
						<tr><td>No Color</td><td>Pending</td></tr>
						<tr class='tablerow1'><td><span style="color:green">Green</span></td><td>Completed</td></tr>
						<tr><td><span style="color:darkorange">Orange</span></td><td>Partially Completed</td></tr>
						<tr class='tablerow1'><td><span style="color:red">Red</span></td><td>Missed</td></tr>
					</table>
			</div>
			</div>