<?php if($inf['AdminLevel'] > 1 || $access['refund'] == 1) { ?>
			<div id='content_wrap'> 
				<ol id='breadcrumb'><li>Refunds > Search Refunds</li></ol> 
			<div class='section_title'><h2>Search Refunds</h2></div>
			<div class='acp-box'>
				<?php if(isset($_GET['by']) && $_GET['by'] == "player") { ?>
			<h3>Search Refunds by Player</h3>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'> 
			<tr>
				<td><form action="refund.php?p=search&by=player" method="post">
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
					$prefundquery = mysql_query("SELECT * FROM `cp_refund` WHERE `user_id` = '$player[0]'");
					$count = mysql_num_rows($prefundquery);
					print "<h3>Results from $_POST[player]: <span class='table_view'>$count Results</span></h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
					<tr><th>Date</th><th>Refund</th><th>Status</th><th>Link</th></tr>";
					while ($prefund = mysql_fetch_array($prefundquery)) {

					if (isset($i) && $i == 1) {
						print "<tr>";
					$i=0;
					} else { 
						print "<tr class='tablerow1'>";
					$i=1;
					}
					
					if($prefund['status'] == 1) { $status = 'Pending'; }
					if($prefund['status'] == 2) { $status = 'Issued'; }
					if($prefund['status'] == 3) { $status = 'Removed'; }
					
					print "
						<td>$prefund[date_added]</td>
						<td>
					";
					if($prefund['refund'] != "") { print $prefund['refund']."<br />"; }
					if($prefund['money'] > 0) { print "$".number_format($prefund['money'])."<br />"; }
					if($prefund['materials'] > 0) { print number_format($prefund['materials'])." materials<br />"; }
					if($prefund['crack'] > 0) { print number_format($prefund['crack'])." crack<br />"; }
					if($prefund['pot'] > 0) { print number_format($prefund['pot'])." pot<br />"; }
					if($prefund['boombox'] > 0) { print number_format($prefund['boombox'])." boombox<br />"; }
					if($prefund['viptoken'] > 0) { print number_format($prefund['viptoken'])." VIP Tokens"; }
					print "
						</td>
						<td>$status</td>
						<td><a href='$prefund[link]'>Link</a></td>
					</tr>
					";
					} ?>
					</table>
				<?php }
				}
				} ?>
			<?php if(isset($_GET['by']) && $_GET['by'] == "ip") { ?>
			<h3>Search Refunds by IP</h3>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'> 
			<tr>
				<td><form action="refund.php?p=search&by=ip" method="post">
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
					<tr><th>Username (IP)</th><th>Date</th><th>Refund</th><th>Status</th><th>Link</th></tr>";
					while($player = mysql_fetch_array($playerquery)) {
					$irefundquery = mysql_query("SELECT * FROM `cp_refund` WHERE `user_id` = '$player[id]'");
					while ($irefund = mysql_fetch_array($irefundquery)) {

					if (isset($i) && $i == 1) {
						print "<tr>";
					$i=0;
					} else { 
						print "<tr class='tablerow1'>";
					$i=1;
					}
					
					if($irefund['status'] == 1) { $status = 'Pending'; }
					if($irefund['status'] == 2) { $status = 'Issued'; }
					if($irefund['status'] == 3) { $status = 'Removed'; }
					
					print "
						<td>".GetName($irefund['user_id'])." (".FlagbyIP($player['IP'])." ".$player['IP'].")</td>
						<td>$irefund[date_added]</td>
						<td>
					";
					if($irefund['refund'] != "") { print $irefund['refund']."<br />"; }
					if($irefund['money'] > 0) { print "$".number_format($irefund['money'])."<br />"; }
					if($irefund['materials'] > 0) { print number_format($irefund['materials'])." materials<br />"; }
					if($irefund['crack'] > 0) { print number_format($irefund['crack'])." crack<br />"; }
					if($irefund['pot'] > 0) { print number_format($irefund['pot'])." pot<br />"; }
					if($irefund['boombox'] > 0) { print number_format($irefund['boombox'])." boombox<br />"; }
					if($irefund['viptoken'] > 0) { print number_format($irefund['viptoken'])." VIP Tokens"; }
					print "
						</td>
						<td>$status</td>
						<td><a href='$irefund[link]'>Link</a></td>
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