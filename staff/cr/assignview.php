<?php
$assignday = $_GET['y']; 
$assigndate = $_GET['d'];

function queryshift($inf,$shiftid,$date,$id,$level)
	{
		$shiftquery = mysql_query("SELECT `id`, `user_id`, `status`, `bonus` FROM `cp_shifts` WHERE `type` = 2 AND `date` = '$date' AND `shift_id` = '$shiftid'");
			$row = mysql_num_rows($shiftquery);
			$a=0;
			while($a <= $row)
			{
			$value = mysql_fetch_array($shiftquery);
			if($value['bonus'] == 2) { $bonus = "<img src='/global/images/star_gold.png' alt='Early Sign-up Bonus' />"; }
			if($value['bonus'] == 1) { $bonus = "<img src='/global/images/star_silver.png' alt='Shift Assist' />"; }
			if($value['bonus'] == 0) { $bonus = ""; }
				if($inf['AdminLevel'] >= 1337 || $inf['ShopTech'] >= 2) {
			if($value['status'] == 1) { echo '<div style="padding-top:10px">'.$bonus.' <a href="cr.php?p=assignedit&assignid='.$value['id'].'"><span style="color:silver"><strike>'.GetName($value['user_id']).'</strike></span></a></div>'; }
			if($value['status'] == 2) { echo '<div style="padding-top:10px">'.$bonus.' <a href="cr.php?p=assignedit&assignid='.$value['id'].'">'.GetName($value['user_id']).'</a></div>'; }
			if($value['status'] == 3) { echo '<div style="padding-top:10px">'.$bonus.' <a href="cr.php?p=assignedit&assignid='.$value['id'].'"><span style="color:green">'.GetName($value['user_id']).'</span></a></div>'; }
			if($value['status'] == 4) { echo '<div style="padding-top:10px">'.$bonus.' <a href="cr.php?p=assignedit&assignid='.$value['id'].'"><span style="color:darkorange">'.GetName($value['user_id']).'</span></a></div>'; }
			if($value['status'] == 5) { echo '<div style="padding-top:10px">'.$bonus.' <a href="cr.php?p=assignedit&assignid='.$value['id'].'"><span style="color:red">'.GetName($value['user_id']).'</span></a></div>'; }
				}
			$a++;
			}
	}
 ?>
			<div id='content_wrap'>
				<ol id='breadcrumb'><li>Customer Relations > Shifts</li></ol>
				<div class='section_title'><h2>Shifts</h2></div>
			<div class='acp-box'>
			<?php if($inf['AdminLevel'] >= 1337 || $inf['ShopTech'] == 3) { ?>
				<h3>Add Shift Assignment</h3>
				<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
				<form method="POST" action="cr/proc.php">
				<tr class='tablerow1'><td width="50%">Administrator</td><td width="50%">Shifts</td></tr>
				<tr><td><select name="admin_id">
					<option selected>Choose an Administrator...</option>
						<?php $ulist1 = mysql_query("SELECT `id`, `Username` FROM `accounts` WHERE `ShopTech` > 0 ORDER BY Username");
						while ($ulist = mysql_fetch_array($ulist1)) {
						echo "<option value=$ulist[id]>$ulist[Username]</option>";
						} ?>
					</select></td>
					<td><select name="shiftid[]" style="text-align:center;width:100px;overflow-y:visible" size="3" multiple>
						<?php
						$optionquery = mysql_query("SELECT * FROM `cp_shift_blocks`");
						while ($option = mysql_fetch_array($optionquery)) {
						print "<option value='$option[id]'>$option[shift]</option>";
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
					<?php $shiftquery = mysql_query("SELECT * FROM `cp_shift_blocks` ORDER BY id ASC");
						$num=mysql_numrows($shiftquery);
						while ($shift = mysql_fetch_array($shiftquery)) {
							$needsquery = mysql_query("SELECT * FROM `cp_shifts` WHERE `type` = 2 AND `date` = '$assigndate' AND `shift_id` = '$shift[id]' AND `status` >= '2'");
							$need = mysql_num_rows($needsquery);
							$shiftday = 2;
							if($need < $shiftday) { $totalneeds = "<span style='font-weight:bold;color:red'>".$need."/".$shiftday."</span>"; }
							if($need >= $shiftday) { $totalneeds = "<span style='font-weight:bold;color:green'>".$need."/".$shiftday."</span>"; }
							if($inf['AdminLevel'] >= 1337 || $inf['ShopTech'] >= 2) { 
								echo "<th width='12.5%'>".$shift['shift']." (".$totalneeds.") -- ".date("gA", strtotime("$shift[time_start]"))."-".date("gA", strtotime("$shift[time_end]"))."</th></tr><tr><td>";
								queryshift($inf,$shift['id'],$assigndate,$inf['id'],$inf['AdminLevel']);
								echo'</td>';
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