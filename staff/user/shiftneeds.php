<?php if($inf['AdminLevel'] < 1338 && $inf['Helper'] < 3 && $inf['AP'] < 2) {
	echo $redir2;
	exit();
}
?>
 
			<div id='content_wrap'>
				<ol id='breadcrumb'><li>User Management > Shifts</li></ol>
				<div class='section_title'><h2>Shift Needs</h2></div>
			<div class='acp-box'>
				<h3>Shift Needs</h3>
					<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'><tr><th colspan='1'></th><th width='14.28%'>Sunday</th><th width='14.28%'>Monday</th><th width='14.28%'>Tuesday</th><th width='14.28%'>Wednesday</th><th width='14.28%'>Thursday</th><th width='14.28%'>Friday</th><th width='14.28%'>Saturday</th></tr>
					<form action="user/proc.php" method="POST">
<?php
if ($inf['AdminLevel'] >= 2) {
$needs1 = mysql_query("SELECT * FROM `cp_shift_blocks` WHERE `type`='1'");
} else {
$needs1 = mysql_query("SELECT * FROM `cp_shift_blocks` WHERE `type`='2'");
}
while ($needs = mysql_fetch_array($needs1)) {
						echo '<input type="hidden" name="shiftid[]" readonly="readonly" value="';
						echo $needs['shift_id'];
						echo '">';
						if (isset($i) && $i == 1) {
							print "<tr>";
						$i=0;
						} else { 
							print "<tr class='tablerow1'>";
						$i=1;
						}

print "<th>$needs[shift]</th><td><input type='text' size='5' name='needs_sun[]' value='$needs[needs_sunday]' /></td><td><input type='text' size='5' name='needs_mon[]' value='$needs[needs_monday]' /></td><td><input type='text' size='5' name='needs_tue[]' value='$needs[needs_tuesday]' /></td><td><input type='text' size='5' name='needs_wed[]' value='$needs[needs_wednesday]' /></td><td><input type='text' size='5' name='needs_thu[]' value='$needs[needs_thursday]' /></td><td><input type='text' size='5' name='needs_fri[]' value='$needs[needs_friday]' /></td><td><input type='text' size='5' name='needs_sat[]' value='$needs[needs_saturday]' /></td></tr>"; } ?>
						<tr class="acp-actionbar"><td colspan="8">
							<input type="hidden" name="action" readonly="readonly" value="shiftneeds">
							<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
							<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
							<input type="submit" class="button" value="Modify Needs">
						</td></tr>
					</form>
					</table>
				<h3>Shift Leaders</h3>
					<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
						<tr><th width="25%">Shift</th><th width="25%">Rank</th><th width="25%"><?php if($inf['AdminLevel'] >= 2) { echo "Administrator"; } else { echo "Advisor"; } ?></th><th width="25%">Remove</th></tr>
<?php
if ($inf['AdminLevel'] >= 2) {
$lead1 = mysql_query("SELECT * FROM `cp_shift_leader` WHERE `type`='1' ORDER BY shift_id ASC");
} else {
$lead1 = mysql_query("SELECT * FROM `cp_shift_leader` WHERE `type`='2' ORDER BY shift_id ASC");
}
if (!$lead1) {
    $message  = 'Invalid query: ' . mysql_error() . "\n";
    $message .= 'Whole query: ' . $lead1;
    die($message);
	}
while ($lead = mysql_fetch_array($lead1)) {
if ($inf['AdminLevel'] >= 2) {
$shiftquery = mysql_query("SELECT `id`, `shift` FROM `cp_shift_blocks` WHERE `shift_id` = '$lead[shift_id]' AND `type`='1'");
} else {
$shiftquery = mysql_query("SELECT `id`, `shift` FROM `cp_shift_blocks` WHERE `shift_id` = '$lead[shift_id]' AND `type`='2'");
}
$shift = mysql_fetch_array($shiftquery);
if ($inf['AdminLevel'] >= 2) {
$userquery = mysql_query("SELECT `Username`, `AdminLevel` FROM `accounts` WHERE `id` = '$lead[user_id]' ORDER BY AdminLevel DESC, Username ASC");
} else {
$userquery = mysql_query("SELECT `Username`, `Helper` FROM `accounts` WHERE `id` = '$lead[user_id]' ORDER BY Helper DESC, Username ASC");
}
$user = mysql_fetch_array($userquery);
						echo '<input type="hidden" name="shiftid[]" readonly="readonly" value="';
						echo $lead['id'];
						echo '">';
						if ($i == 1) {
							print "<tr>";
						$i=0;
						} else {
							print "<tr class='tablerow1'>";
						$i=1;
						}
				if ($inf['AdminLevel'] >= 2) {
					if($user['AdminLevel'] == "4") { $rank = "<span style='color:sandybrown'>Senior Administrator</span>"; }
					if($user['AdminLevel'] == "1337") { $rank = "<span style='color:red'>Head Administrator</span>"; }
					if($user['AdminLevel'] == "1338") { $rank = "<span style='color:red'>Admin Director</span>"; }
					if($user['AdminLevel'] == "99999") { $rank = "<span style='color:red'>Executive Administrator</span>"; }
				} else {
					if($user['Helper'] == "4") { $rank = "<span style='color:#00f4f4'>Chief Advisor</span>"; }
					if($user['Helper'] == "3") { $rank = "<span style='color:#00f4f4'>Senior Advisor</span>"; }
					if($user['Helper'] == "2") { $rank = "<span style='color:#00f4f4'>Community Advisor</span>"; }
				}
					print "<td>".$shift['shift']."</td>";
					print "<td>".$rank."</td>";
					print "<td>".$user['Username']."</td>";
					print "<td><form action='user/proc.php' method='POST'>
						<input type='hidden' name='action' readonly='readonly' value='removeshiftleader'>
						<input type='hidden' name='shiftleadid' readonly='readonly' value='".$lead['id']."'>
						<input type='hidden' name='ip' readonly='readonly' value='".$_SERVER['REMOTE_ADDR']."'>
						<input type='hidden' name='admin' readonly='readonly' value='".$_SESSION['myusername']."'>
						<input type='submit' class='button' value='Remove'>
					</form></td>";
					print "</tr>"; } ?>
					<form action="user/proc.php" method="POST">
						<tr><th>Shift</th><th colspan='3'><?php if($inf['AdminLevel'] >= 2) { echo "Administrator"; } else { echo "Advisor"; } ?></th></tr>
						<tr class='tablerow1'>
							<td>
								<select name="shiftid">
								<?php 
								if ($inf['AdminLevel'] >= 2) {
								$shiftlistquery = mysql_query("SELECT `shift_id`, `shift` FROM `cp_shift_blocks` WHERE `type`='1'");
								} else {
								$shiftlistquery = mysql_query("SELECT `shift_id`, `shift` FROM `cp_shift_blocks` WHERE `type`='2'");
								}
								while ($shiftlist = mysql_fetch_array($shiftlistquery)) {
								print "<option value='$shiftlist[shift_id]'>$shiftlist[shift]</option>";
								} ?>
								</select>
							</td>
							<td colspan='3'>
								<select name='leader_ID'>
								<?php 
								if ($inf['AdminLevel'] >= 2) {
								$leaderquery = mysql_query("SELECT `id`, `Username`, `AdminLevel` FROM `accounts` WHERE `AdminLevel` >= '4' ORDER BY `Username` ASC");
								} else {
								$leaderquery = mysql_query("SELECT `id`, `Username`, `Helper` FROM `accounts` WHERE `Helper` >= '3' ORDER BY `Username` ASC");
								}
								while ($leader = mysql_fetch_array($leaderquery)) { print "<option value='".$leader['id']."'>".$leader['Username']."</option>"; } ?>
								</select>
							</td>
						</tr>
						<tr class="acp-actionbar"><td colspan="9">
							<input type="hidden" name="action" readonly="readonly" value="addshiftleader">
							<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
							<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
							<input type="submit" class="button" value="Add/Modify Leader">
						</td></tr>
					</form>
					</table>
			</div></div>