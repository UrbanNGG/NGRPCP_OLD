<?php if($inf['AdminLevel'] > 1 || $access['punish'] == 1) {

if(isset($_GET['o'])) {
	if(intval($_GET['o']) == "" || intval($_GET['o']) == "0") { $viewcode = "0"; }
	if(intval($_GET['o']) == "1") { $viewcode = "1"; }
	if(intval($_GET['o']) == "2") { $viewcode = "2"; }
	if(intval($_GET['o']) == "3") { $viewcode = "3"; }
}
if(isset($viewcode) && $viewcode > 0) {
$viewSQL = "SELECT * FROM `cp_punishment` WHERE `status` = '$viewcode' ORDER BY id DESC";
}
else {
$viewSQL = "SELECT * FROM `cp_punishment` ORDER BY id DESC";
}
?>

			<div id='content_wrap'> 
				<ol id='breadcrumb'><li>Punishments > View Punishments</li></ol> 
			<div class='section_title'><h2>Punishments</h2></div>
			<?php if(isset($_GET['e']) && $_GET['e'] == 1) { echo "<div class='acp-error'>That player is currently in-game. Please issue the punishment in-game or try again later.</div>"; }
			if(isset($_GET['e']) && $_GET['e'] == 2) { echo "<div class='acp-error'>You cannot add punishments to Admins!</div>"; } ?>
			<div class='acp-box'>
				<h3>Punishment List <span class="table_view"><a href="punish.php?p=view&o=0">View All</a>&nbsp;&nbsp;&#8226;&nbsp;&nbsp;<a href="punish.php?p=view&o=1">View Pending</a>&nbsp;&nbsp;&#8226;&nbsp;&nbsp;<a href="punish.php?p=view&o=2">View Issued</a>&nbsp;&nbsp;&#8226;&nbsp;&nbsp;<a href="punish.php?p=view&o=3">View Removed</a></span></h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'> 
					<tr>
						<th>Offender</th>
						<th>Rule(s) Broken</th>
						<th>Punishment</th>
						<th>Added</th>
						<th>Status</th>
						<th>Link</th>
						<th>Issue/Remove</th>
					</tr>
					<?php $punish1 = mysql_query($viewSQL);
					$num = mysql_numrows($punish1);
					while ($punish = mysql_fetch_array($punish1)) {
					$issue = "<form method='post' action='punish/proc.php' name='form$punish[id]'>
						<input type='hidden' name='action' readonly='readonly' value='issue'>
						<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
						<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
						<input type='hidden' name='adminid' readonly='readonly' value='$inf[id]'>
						<input type='hidden' name='pID' readonly='readonly' value='$punish[id]'>
						<input type='hidden' name='p_rules' readonly='readonly' value='$punish[reason]'>
						<input type='hidden' name='p_prison' readonly='readonly' value='$punish[prison]'>
						<input type='hidden' name='p_warn' readonly='readonly' value='$punish[warn]'>
						<input type='hidden' name='p_fine' readonly='readonly' value='$punish[fine]'>
						<input type='hidden' name='p_wepreset' readonly='readonly' value='$punish[wep_restrict]'>
						<input type='hidden' name='p_ban' readonly='readonly' value='$punish[ban]'>
						<input type='hidden' name='user_id' readonly='readonly' value='$punish[player_id]'>
						<input type='submit' class='button' value='Issue'></form>
					</form>";
					
					$remove = "<form method='post' action='punish/proc.php' name='form$punish[id]'>
						<input type='hidden' name='action' readonly='readonly' value='remove'>
						<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
						<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
						<input type='hidden' name='adminid' readonly='readonly' value='$inf[id]'>
						<input type='hidden' name='pID' readonly='readonly' value='$punish[id]'>
						<input type='hidden' name='user_id' readonly='readonly' value='$punish[player_id]'>
						<input type='submit' class='button' value='Remove'></form>
					</form>";

					if($punish['status'] == 1) { $punish['status'] = 'Pending'; }
					if($punish['status'] == 2) { $punish['status'] = 'Issued'; }
					if($punish['status'] == 3) { $punish['status'] = 'Removed'; }

					if (isset($i) && $i == 1) {
						print "<tr class='tablerow1'>";
					$i=0;
					} else { 
						print "<tr>";
					$i=1;
					}

					$playernamequery = mysql_query("SELECT `Username` FROM `accounts` WHERE `id` = '$punish[player_id]'");
					$playername = mysql_fetch_row($playernamequery);
					
					print "
						<td><a href=\"punish.php?p=edit&id=$punish[id]\">$playername[0]</a></td>
						<td>$punish[reason]</td>";
					print "<td><ul>";
					if(!$punish['other_punish'] == "") { print "<li>".$punish['other_punish']."</li>"; }
					if($punish['prison'] >= 1) { print "<li>Prison ".$punish['prison']." minutes</li>"; }
					if($punish['warn'] == 1) { print "<li>Warn</li>"; }
					if($punish['fine'] > 0) { print "<li>Fine $".number_format($punish['fine'])."</li>"; }
					if($punish['wep_restrict'] >= 1) { print "<li>".$punish['wep_restrict']." hour(s) weapon restriction</li>"; }
					if($punish['ban'] == 1) { print "<li>Ban</li>"; }
					print "</ul></td>";
					print "
						<td>$punish[date_added]</td>
						<td>$punish[status]</td>
						<td><a href=$punish[link]>Link</a></td>
					";
					if($punish['status'] == "Pending") {
						if($punish['ban'] == 1 && $inf['AdminLevel'] > 3) { print "<td>$issue <br /> $remove</td>"; }
						elseif($punish['ban'] == 1 && $inf['AdminLevel'] < 4) { print "<td>$remove</td>"; }
						elseif($punish['ban'] == 0 && $inf['AdminLevel'] > 2) { print "<td>$issue <br /> $remove</td>"; }
						elseif($punish['ban'] == 0 && $inf['AdminLevel'] == 2) { print "<td>$remove</td>"; }
					}
					print "
					</tr>
					";
					} ?>
					</table>
				<div class='acp-actionbar'><strong>To edit a punishment, click on the offender's name.</strong></div>
			</div></div>
<?php }
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>