<?php if($inf['AdminLevel'] > 2) { ?>
			<div id='content_wrap'> 
				<ol id='breadcrumb'><li>Players > IP Check</li></ol> 
			<div class='section_title'><h2>IP Check</h2></div>
			<div class='acp-box'>
			<?php if(isset($_GET['search']) && $_GET['search'] == "ip") { ?>
			<h3>Player Search by IP</h3>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'> 
			<tr>
				<td><form action="player.php?p=ipcheck&search=ip" method="post">
					<input type="text" name="ip" />
					<input type="submit" class="button" value="Search" />
				</form></td>
			</tr>
			</table>
				<?php if(isset($_POST['ip'])) {
					$playerquery = mysql_query("SELECT `Username`, `IP` FROM `accounts` WHERE `IP` LIKE '$_POST[ip]%' AND `AdminLevel` < 2 ORDER BY IP DESC");
					$num = mysql_num_rows($playerquery);
					$count = number_format($num);
					
					print "<h3>Results from $_POST[ip]: $count matches</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>";
					
					while ($player = mysql_fetch_array($playerquery)) {

					$search = "<form method='post' action='player.php?p=view'>
					<input type='hidden' name='action' readonly='readonly' value='search'>
					<input type='hidden' name='player_name' readonly='readonly' value='$player[Username]'>
					<input type='submit' class='submit' value='$player[Username]'></form>";
					
					if (isset($i) && $i == 1) {
						print "<tr>";
					$i=0;
					} else { 
						print "<tr class='tablerow1'>";
					$i=1;
					}
					
					print "
						<td>$search ".FlagByIP($player['IP'])." $player[IP]</td>
					</tr>
					";
					}
					?>
					</table>
				<?php }
				}
				if(isset($_GET['search']) && $_GET['search'] == "player") {
				AutoComplete();
				?>
			<h3>IP Search by Player</h3>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'> 
			<tr>
				<td><form action="player.php?p=ipcheck&search=player" method="post">
					<input id="accountsearch" type="text" name="player" />
					<input type="submit" class="button" value="Search" />
				</form></td>
			</tr>
			</table>
				<?php if(isset($_POST['player'])) {
					$playerquery = mysql_query("SELECT `Username`, `IP` FROM `accounts` WHERE `Username` LIKE '%$_POST[player]%' AND `AdminLevel` < 2 ORDER BY Username ASC");
					$num = mysql_num_rows($playerquery);
					$count = number_format($num);
					
					print "<h3>Results from $_POST[player]: $count matches</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>";
					
					while ($player = mysql_fetch_array($playerquery)) {

					$search = "<form method='post' action='player.php?p=view'>
					<input type='hidden' name='action' readonly='readonly' value='search'>
					<input type='hidden' name='player_name' readonly='readonly' value='$player[Username]'>
					<input type='submit' class='submit' value='$player[Username]'></form>";
					
					if (isset($i) && $i == 1) {
						print "<tr>";
					$i=0;
					} else { 
						print "<tr class='tablerow1'>";
					$i=1;
					}
					
					print "
						<td>$search ".FlagByIP($player['IP'])." $player[IP]</td>
					</tr>
					";
					} ?>
					</table>
				<?php }
				} ?>
				<div class='acp-actionbar'></div>
			</div></div>
<?php }
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>