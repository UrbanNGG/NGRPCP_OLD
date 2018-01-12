<div id='content_wrap'>
  <ol id='breadcrumb'>
    <li><?php echo $section; ?> &raquo; My Dashboard</li>
  </ol>
  <div class='section_title'>
    <h2>My Dashboard</h2>
  </div>
	<?php
	if($inf['AdminLevel'] >= 2) {
	$q = mysql_query("SELECT * FROM `cp_misc` WHERE `status` = '1'");
	$r = mysql_fetch_array($q);
	$z = mysql_num_rows($q);
	if($z == 1) {
	?>
	<div class='acp-message2'><span style='color:#dd2121'>Notification from <?php echo $r['from']; ?>:</span>
		<?php echo $r['message']; ?></div>
	<?php
	}
	}
	?>
  <div class='acp-box'>
    <h3>My Stats</h3>
    <table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
	<?php 
		$diff = strtotime("now") - strtotime("$inf[RegiDate]");
		$num = $diff/86400;
		$days = intval($num);
		$capointsq = mysql_query("SELECT `points` FROM `cp_stat` WHERE `user_id` = '$inf[id]'");
		$capointsr = mysql_fetch_array($capointsq);
		$capoints = $capointsr['points'];
	?>
      <tr class='tablerow1'>
        <td>Rank: <b><?php echo aRank($inf); ?></b></td>
        <td>Date Added: <?php echo date("M j, o", strtotime("$inf[RegiDate]")); ?> (<?php echo $days; ?> days ago)</td>
      </tr>
      <tr>
        <td>Last Logged In On The IP: <?php echo $inf['IP']; ?></td>
        <td>Your IP Address: <?php echo $_SERVER['REMOTE_ADDR']; ?></td>
      </tr>
	  <?php
	  if ($inf['Helper'] >= 2) { ?>
	  <tr>
		<td>Total Points: <?php echo $capoints; ?></td>
	  </tr>
	  <?php } ?>
	  <?php //Commented out until tables are transferred
      /*<tr class='tablerow1'>
	    <td>Last Checked In: <?php echo $inf['dCheckin']; ?></td>
        <td>You have checked in <?php echo $inf['checkins']; ?> times</td>
      </tr>
	  <tr>
		<td>You have <?php echo $inf['points']; ?> points</td>
        <td>You have completed <?php echo $inf['shift_complete']; ?> shifts</td>
      </tr>
	  <tr class='tablerow1'>
		<td>You have partially completed <?php echo $inf['shift_partcomplete']; ?> shifts</td>
        <td>You have missed <?php echo $inf['shift_missed']; ?> shifts</td>
        <td></td>
      </tr>*/ ?>
    </table>
	<h3><?php if ($inf['AdminLevel'] >= 2) { echo "Administrative"; } else { echo "Advisory"; } ?> Shifts</h3>
    <?php
	if ($inf['AdminLevel'] >= 2) {
 $shift1 = mysql_query("SELECT * FROM `cp_shifts` WHERE `user_id` = '$inf[id]' AND `type` = 1 AND `status` >= '2' ORDER BY `date` ASC, `shift_id` ASC");
 } else {
 $shift1 = mysql_query("SELECT * FROM `cp_shifts` WHERE `user_id` = '$inf[id]' AND `type` = 3 AND `status` >= '2' ORDER BY `date` ASC, `shift_id` ASC");
 }
$num_rows = mysql_num_rows($shift1);
?> 
    <table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
      <tr>
		<th></th>
        <th width='20%'>Date</th>
        <th width='20%'>Shift</th>
        <th width='40%'>Status</th>
		<th colspan='1' width='20%'></th>
      </tr> 
      <?php
if ($num_rows == 0) { 
	echo '<tr><td colspan="5"><strong>You have not signed up for any shifts!</strong></td></tr>';
}
else {
	if(date('w') == 0){$str = 'today';}else{$str = 'last sunday';}
	$timestamp = strtotime($str);
	$noshifts = 0;
	while ($shift = mysql_fetch_array($shift1))
		{
		$shiftidquery = mysql_query("SELECT `shift` FROM `cp_shift_blocks` WHERE `id` = '$shift[shift_id]'");
		$shiftID = mysql_fetch_row($shiftidquery);
		if($shift['status'] == 2) { $status = "Approved"; }
		if($shift['status'] == 3) { $status = "<span style='color:lime'>Completed</span>"; }
		if($shift['status'] == 4) { $status = "<span style='color:orange'>Partially Completed</span>"; }
		if($shift['status'] == 5) { $status = "<span style='color:red'>Missed</span>"; }
			for($i = 0; $i < 14; $i++)
				{
				$assigndate = date('Y-m-d', $timestamp + ($i * (60 * 60 * 24)));
				if ($shift['date'] == $assigndate)
					{
					if (isset($a) && $a == 1) 
						{
						print "<tr class='tablerow1'>";
						$a=0;
						} else 
						{ 
						print "<tr>";
						$a=1;
						}
					print "<td align='right'>";
					if($shift['bonus'] == 2) { print "<img src='/global/images/star_gold.png' alt='Early Sign-up Bonus' />"; }
					if($shift['bonus'] == 1) { print "<img src='/global/images/star_silver.png' alt='Shift Assist' />"; }
					print "</td><td>".date('M j, o', strtotime("$shift[date]"))."</td><td>$shiftID[0]</td><td>$status</td>";
					if($shift['status'] == 2) {
					print "<td><form method='POST' action='index/proc.php'>
						<input type='hidden' name='action' readonly='readonly' value='removeshift'>
						<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
						<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
						<input type='hidden' name='shiftid' readonly='readonly' value='$shift[id]'>
						<input type='hidden' name='shiftblock' readonly='readonly' value='$shiftID[0]'>
						<input type='hidden' name='assigndate' readonly='readonly' value='$shift[date]'>
						<input class='button' type='submit' value='Remove'></form></td>";
					}
					print "</tr>";
					if(isset($nofshifts)) { $nofshifts++; }
					}
				}
		
		}
		if(isset($nofshifts) && $nofshifts == "0")
		{
		echo '<tr><td colspan="5"><strong>You have not signed up for any shifts!</strong></td></tr>';
		}
	} ?>
		</table>
	<?php if($inf['ShopTech'] > 0) { ?>
	<h3>Shop Technician Shifts</h3>
    <?php
		$stshiftquery = mysql_query("SELECT * FROM `cp_shifts` WHERE `user_id` = '$inf[id]' AND `type` = 2 AND `status` >= '2' ORDER BY `date` ASC, `shift_id` ASC");
		$stnum_rows = mysql_num_rows($stshiftquery);
	?> 
    <table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
      <tr>
		<th></th>
        <th width='20%'>Date</th>
        <th width='20%'>Shift</th>
        <th width='40%'>Status</th>
		<th colspan='1' width='20%'></th>
      </tr> 
      <?php
	if ($stnum_rows == 0) { 
		echo '<tr><td colspan="5"><strong>You have not signed up for any shifts!</strong></td></tr>';
	}
	else {
	if(date('w') == 0){$str = 'today';}else{$str = 'last sunday';}
	$timestamp = strtotime($str);
	$noshifts = 0;
	while ($stshift = mysql_fetch_array($stshiftquery))
		{
		$stshiftidquery = mysql_query("SELECT `shift` FROM `cp_shift_blocks` WHERE `id` = '$stshift[shift_id]'");
		$stshiftID = mysql_fetch_row($stshiftidquery);
		if($stshift['status'] == 2) { $status = "Approved"; }
		if($stshift['status'] == 3) { $status = "<span style='color:lime'>Completed</span>"; }
		if($stshift['status'] == 4) { $status = "<span style='color:orange'>Partially Completed</span>"; }
		if($stshift['status'] == 5) { $status = "<span style='color:red'>Missed</span>"; }
			for($j = 0; $j < 14; $j++)
				{
				$assigndate = date('Y-m-d', $timestamp + ($j * (60 * 60 * 24)));
				if ($stshift['date'] == $assigndate)
					{
					if (isset($b) && $b == 1) 
						{
						print "<tr class='tablerow1'>";
						$b=0;
						} else 
						{ 
						print "<tr>";
						$b=1;
						}
					print "<td align='right'>";
					if($stshift['bonus'] == 2) { print "<img src='/global/images/star_gold.png' alt='Early Sign-up Bonus' />"; }
					if($stshift['bonus'] == 1) { print "<img src='/global/images/star_silver.png' alt='Shift Assist' />"; }
					print "</td><td>".date('M j, o', strtotime("$stshift[date]"))."</td><td>$stshiftID[0]</td><td>$status</td>";
					if($stshift['status'] == 2) {
					print "<td><form method='POST' action='index/proc.php'>
						<input type='hidden' name='action' readonly='readonly' value='removeshift'>
						<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
						<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
						<input type='hidden' name='shiftid' readonly='readonly' value='$stshift[id]'>
						<input type='hidden' name='shiftblock' readonly='readonly' value='$stshiftID[0]'>
						<input type='hidden' name='assigndate' readonly='readonly' value='$stshift[date]'>
						<input class='button' type='submit' value='Remove'></form></td>";
					}
					print "</tr>";
					if(isset($nofshifts)) { $nofshifts++; }
					}
				}
		
		}
		if(isset($nofshifts) && $nofshifts == "0")
		{
		echo '<tr><td colspan="5"><strong>You have not signed up for any shifts!</strong></td></tr>';
		}
	} ?>
		</table>
	<?php } 
	if ($inf['AdminLevel'] > 1) { ?>
    <h3>My Notes</h3>
    <?php 
$note1 = mysql_query("SELECT * FROM `cp_admin_notes` WHERE `type` = '2' AND `status` = '2' AND `user_id` = '$inf[id]' ORDER BY date DESC");
$num_rows = mysql_num_rows($note1);
?>
    <table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
      <tr>
        <th width='20%'>Date</th>
        <th width='60%'>Note</th>
        <th width='20%'>Points</th>
      </tr>
      <tr>
        <th colspan='3'>Commendations</th>
      </tr>
      <?php
if ($num_rows == 0) 
	{ 
	echo '<tr><td colspan="3"><strong>You have no approved commendations!</strong></td></tr>';
	} 
	else 
	{
while ($note = mysql_fetch_array($note1)){ 
						if (isset($c) && $c == 1) {
							print "<tr class='tablerow1'>";
						$c=0;
						} else { 
							print "<tr>";
						$c=1;
						}
	print "<td>$note[date]</td><td>$note[details]</td><td>$note[points]</td></tr>";
}
} ?>
		</table>

    <?php
$note2 = mysql_query("SELECT * FROM `cp_admin_notes` WHERE `type` = '1' AND `status` = '2' AND `user_id` = '$inf[id]' ORDER BY date DESC");
$num_rows = mysql_num_rows($note2);
?> 
    <table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
      <tr>
        <th colspan='3'>Infractions</th>
      </tr>
      <?php
if ($num_rows == 0) 
	{ 
	echo '<tr><td colspan="3"><strong>You have no approved infractions!</strong></td></tr>';
	} 
	else 
	{
while ($note = mysql_fetch_array($note2)){ 
						if (isset($d) && $d == 1) {
							print "<tr class='tablerow1'>";
						$d=0;
						} else { 
							print "<tr>";
						$d=1;
						}
	print "<td width='20%'>$note[date]</td><td width='60%'>$note[details]</td><td width='20%'>$note[points]</td></tr>";
}
}
} ?>
		</table>
</div></div>