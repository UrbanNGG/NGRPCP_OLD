<?php if($inf['AdminLevel'] > 1 || $access['punish'] == 1) { ?>
			<div id='content_wrap'> 
				<ol id='breadcrumb'><li>Punishments > Search Punishments</li></ol> 
			<div class='section_title'><h2>Search Punishments</h2></div>
			<div class='acp-box'>
				<?php if(isset($_GET['by']) && $_GET['by'] == "player") { ?>
			<h3>Search Punishments by Player</h3>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'> 
			<tr>
				<td><form action="punish.php?p=search&by=player" method="post">
					<input type="text" name="player" />
					<input type="submit" class="button" value="Search" />
				</form></td>
			</tr>
			</table>
				<?php if(isset($_POST['player'])) {
					$playerquery = mysql_query("SELECT `id` FROM `accounts` WHERE `Username` = '$_POST[player]'");
					$num = mysql_num_rows($playerquery);
					
					if($num == 0) { echo "<div class='acp-error'>That player does not exist! Please try again.</div>"; }
					
					if($num == 1) {
					$player = mysql_fetch_array($playerquery);
					$ppunishquery = mysql_query("SELECT * FROM `cp_punishment` WHERE `player_id` = '$player[0]'");
					$count = mysql_num_rows($ppunishquery);
					print "<h3>Results from $_POST[player]: <span class='table_view'>$count Results</span></h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
					<tr><th>Date</th><th>Reason</th><th>Punishment</th><th>Status</th><th>Link</th></tr>";
					while ($ppunish = mysql_fetch_array($ppunishquery)) {

					if (isset($i) && $i == 1) {
						print "<tr>";
					$i=0;
					} else { 
						print "<tr class='tablerow1'>";
					$i=1;
					}
					
					if($ppunish['status'] == 1) { $status = 'Pending'; }
					if($ppunish['status'] == 2) { $status = 'Issued'; }
					if($ppunish['status'] == 3) { $status = 'Removed'; }
					
					print "
						<td>$ppunish[date_added]</td>
						<td>$ppunish[reason]</td>
						<td>
					";
					if($ppunish['other_punish'] != "") { print $ppunish['other_punish']."<br />"; }
					if($ppunish['prison'] > 0) { print "Prison ".$ppunish['prison']." hours<br />"; }
					if($ppunish['warn'] == 1) { print "Warn<br />"; }
					if($ppunish['fine'] > 0) { print "Fine $".number_format($ppunish['fine'])."<br />"; }
					if($ppunish['ban'] == 1) { print "Ban<br />"; }
					if($ppunish['wep_restrict'] > 0) { print $ppunish['wep_restrict']." hours weapon restriction"; }
					print "
						</td>
						<td>$status</td>
						<td><a href='$ppunish[link]'>Link</a></td>
					</tr>
					";
					} ?>
					</table>
				<?php }
				}
				} ?>
			<?php if(isset($_GET['by']) && $_GET['by'] == "ip") { ?>
			<h3>Search Punishments by IP</h3>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'> 
			<tr>
				<td><form action="punish.php?p=search&by=ip" method="post">
					<input type="text" name="ip" />
					<input type="submit" class="button" value="Search" />
				</form></td>
			</tr>
			</table>
				<?php if(isset($_POST['ip'])) {
					$playerquery = mysql_query("SELECT `id`, `IP` FROM `accounts` WHERE `IP` LIKE '$_POST[ip]%'");
					$num = mysql_num_rows($playerquery);
					
					if($num == 0) { echo "<div class='acp-error'>There are no players on that IP! Please try again.</div>"; }
					
					if($num > 0) {

					print "<h3>Results from $_POST[ip]:</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
					<tr><th>Username (IP)</th><th>Date</th><th>Reason</th><th>Punishment</th><th>Status</th><th>Link</th></tr>";
					while($player = mysql_fetch_array($playerquery)) {
					$ipunishquery = mysql_query("SELECT * FROM `cp_punishment` WHERE `player_id` = '$player[id]'");
					while ($ipunish = mysql_fetch_array($ipunishquery)) {

					if (isset($i) && $i == 1) {
						print "<tr>";
					$i=0;
					} else { 
						print "<tr class='tablerow1'>";
					$i=1;
					}
					
					if($ipunish['status'] == 1) { $status = 'Pending'; }
					if($ipunish['status'] == 2) { $status = 'Issued'; }
					if($ipunish['status'] == 3) { $status = 'Removed'; }
					
					print "
						<td>".GetName($ipunish['player_id'])." (".FlagbyIP($player['IP'])." ".$player['IP'].")</td>
						<td>$ipunish[date_added]</td>
						<td>$ipunish[reason]</td>
						<td>
					";
					if($ipunish['other_punish'] != "") { print $ipunish['other_punish']."<br />"; }
					if($ipunish['prison'] > 0) { print "Prison ".$ipunish['prison']." hours<br />"; }
					if($ipunish['warn'] == 1) { print "Warn<br />"; }
					if($ipunish['fine'] > 0) { print "Fine $".number_format($ipunish['fine'])."<br />"; }
					if($ipunish['ban'] == 0) { print "Ban<br />"; }
					if($ipunish['wep_restrict'] > 0) { print $ipunish['wep_restrict']." hours weapon restriction"; }
					print "
						</td>
						<td>$status</td>
						<td><a href='$ipunish[link]'>Link</a></td>
					</tr>
					";
					}
					?>
				<?php }
				print "</table>";
				}
				}
				} ?>
				<div class='acp-actionbar'></div>
			</div></div>
<?php }
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>