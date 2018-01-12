<?php
if(isset($_GET['list'])) {
	if(intval($_GET['list']) == "" || intval($_GET['list']) == "0") { $sql = "SELECT * FROM `flags` ORDER BY `time` ASC"; }
	if(intval($_GET['list']) == "1") { $sql = "SELECT * FROM `flags` WHERE `flag` LIKE '%punishment%' ORDER BY `time` ASC"; }
	if(intval($_GET['list']) == "2") { $sql = "SELECT * FROM `flags` WHERE `flag` LIKE '%refund%' ORDER BY `time` ASC"; }
	if(intval($_GET['list']) == "3") { $sql = "SELECT * FROM `flags` WHERE `flag` LIKE '%VIP%' ORDER BY `time` ASC"; }
	if(intval($_GET['list']) == "4") { $sql = "SELECT * FROM `flags` WHERE `flag` LIKE '%house (gift)%' ORDER BY `time` ASC"; }
	if(intval($_GET['list']) == "5") { $sql = "SELECT * FROM `flags` WHERE `flag` LIKE '%gate%' ORDER BY `time` ASC"; }
	if(intval($_GET['list']) == "6") { $sql = "SELECT * FROM `flags` WHERE `flag` LIKE '%credit%' ORDER BY `time` ASC"; }
	if(intval($_GET['list']) == "7") { $sql = "SELECT * FROM `flags` WHERE `flag` LIKE '%free car%' ORDER BY `time` ASC"; }
}
else {
$sql = "SELECT * FROM `flags` ORDER BY `time` ASC";
}
?>
			<div id='content_wrap'> 
				<ol id='breadcrumb'><li>Flags > View Flags</li></ol> 
			<div class='section_title'><h2>Flags</h2></div>
			<?php if(isset($_GET['note']) && $_GET['note'] == 1) { echo "<div class='acp-error'>The player you are attempting to flag does not exist!</div>"; }
			if(isset($_GET['note']) && $_GET['note'] == 2) { echo "<div class='acp-message'>The flag has been added!</div>"; }
			if(isset($_GET['note']) && $_GET['note'] == 3) { echo "<div class='acp-message'>The flag has been issued!</div>"; } ?>
			<div class='acp-box'>
			<h3>Add a Flag</h3>
				<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
					<form method='post' action='flag/proc.php'>
					<tr>
						<td>Name</td>
						<td><input type="text" size="25" name="player_name"></td>
						<td>Flag</td>
						<td><input type="text" size="100" name="flag"></td>
						<td>
							<input type='hidden' name='action' readonly='readonly' value='add'>
							<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
							<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
							<input type='submit' class='button' value='Add'>
						</td>
					</tr>
					</form>
				</table>
					<?php $flagquery = mysql_query($sql);
					$num = mysql_numrows($flagquery);
					$count = number_format($num);
					
					print "<h3>Flag List <span class='table_view'>$count Flags</span></h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'> 
					<tr>
						<th>Player</th>
						<th>Date Added</th>
						<th>Flag</th>
						<th>Added By</th>
						<th>Issue</th>
					</tr>";
					
					while ($flag = mysql_fetch_array($flagquery)) {

					if (isset($i) && $i == 1) {
						print "<tr class='tablerow1'>";
					$i=0;
					} else { 
						print "<tr>";
					$i=1;
					}

					$playernamequery = mysql_query("SELECT `Online`, `Username` FROM `accounts` WHERE `id` = '$flag[id]'");
					$playername = mysql_fetch_array($playernamequery);
					
					$issue = "<form method='post' action='flag/proc.php' name='form$flag[fid]'>
						<input type='hidden' name='action' readonly='readonly' value='issue'>
						<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
						<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
						<input type='hidden' name='fID' readonly='readonly' value='$flag[fid]'>
						<input type='hidden' name='user_id' readonly='readonly' value='$flag[id]'>
						<input type='hidden' name='player_name' readonly='readonly' value='$playername[Username]'>
						<input type='submit' class='button' value='Issue'></form>
					</form>";
					
					print "<td>";
					if($playername['Online'] > 0) { print "<span style='font-weight:bold'>$playername[Username]</span>"; }
						else { print "$playername[Username]"; }
					print "
						</td>
						<td>$flag[time]</td>
						<td>$flag[flag]</td>
						<td>$flag[issuer]</td>
						<td>$issue</td>
					</tr>
					";
					} ?>
					</table>
				<div class='acp-actionbar'></div>
			</div></div>