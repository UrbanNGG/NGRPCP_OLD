<?php if($inf['AdminLevel'] > 1) {
AutoComplete();
?>
			<div id='content_wrap'> 
				<ol id='breadcrumb'><li>Players > View Player Stats</li></ol> 
			<div class='section_title'><h2>View Player Stats</h2></div>
			<div class='acp-box'>
			<h3>Search For Player</h3>
				<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
					<form method='post' action='player.php?p=view'>
					<tr>
						<td>Name</td>
						<td><input id="accountsearch" type="text" name="player_name" /></td>
						<td>
							<input type='hidden' name='action' readonly='readonly' value='search'>
							<input type='submit' class='button' value='Search'>
						</td>
					</tr>
					</form>
				</table>
					<?php if(isset($_GET['player_name']) || isset($_POST['player_name'])) {
					if(isset($_GET['player_name'])) { $player_name = mysql_real_escape_string($_GET['player_name']); } else { $player_name = mysql_real_escape_string($_POST['player_name']); }
					$playerquery = mysql_query("SELECT * FROM `accounts` WHERE `Username` = '" . $player_name . "' AND `AdminLevel` < 2");
					$player = mysql_fetch_array($playerquery);
					$num = mysql_num_rows($playerquery);
					
					if($player['Job'] == 1) { $exp = $player['DetSkill']; }
					elseif($player['Job'] == 2) { $exp = $player['LawSkill']; }
					elseif($player['Job'] == 3) { $exp = $player['SexSkill']; }
					elseif($player['Job'] == 4) { $exp = $player['DrugSkill']; }
					elseif($player['Job'] == 7) { $exp = $player['MechSkill']; }
					elseif($player['Job'] == 9) { $exp = $player['ArmsSkill']; }
					elseif($player['Job'] == 12) { $exp = $player['BoxSkill']; }
					elseif($player['Job'] == 20) { $exp = $player['SmugglerSkill']; }
					if($player['Job2'] == 1) { $exp2 = $player['DetSkill']; }
					elseif($player['Job2'] == 2) { $exp2 = $player['LawSkill']; }
					elseif($player['Job2'] == 3) { $exp2 = $player['SexSkill']; }
					elseif($player['Job2'] == 4) { $exp2 = $player['DrugSkill']; }
					elseif($player['Job2'] == 7) { $exp2 = $player['MechSkill']; }
					elseif($player['Job2'] == 9) { $exp2 = $player['ArmsSkill']; }
					elseif($player['Job2'] == 12) { $exp2 = $player['BoxSkill']; }
					elseif($player['Job2'] == 20) { $exp2 = $player['SmugglerSkill']; }
					
					if($player['Apartment'] > 0) {
					$house1query = mysql_query("SELECT * FROM `houses` WHERE `id` = $player[Apartment] + 1");
					$house1 = mysql_fetch_array($house1query);
					}
					if($player['Apartment2'] > 0) {
					$house2query = mysql_query("SELECT * FROM `houses` WHERE `id` = $player[Apartment2] + 1");
					$house2 = mysql_fetch_array($house1query);
					}
					if($player['Member'] <> -1) {
					$memquery = mysql_query("SELECT * FROM `groups` WHERE `id` = $player[Member] + 1");
					$mem = mysql_fetch_array($memquery);
					if($player['Division'] == -1) { $division = "G.D."; }
					elseif($player['Division'] == 0) { $division = $mem['Div1']; }
					elseif($player['Division'] == 1) { $division = $mem['Div2']; }
					elseif($player['Division'] == 2) { $division = $mem['Div3']; }
					elseif($player['Division'] == 3) { $division = $mem['Div4']; }
					elseif($player['Division'] == 4) { $division = $mem['Div5']; }
					elseif($player['Division'] == 5) { $division = $mem['Div6']; }
					elseif($player['Division'] == 6) { $division = $mem['Div7']; }
					elseif($player['Division'] == 7) { $division = $mem['Div8']; }
					elseif($player['Division'] == 8) { $division = $mem['Div9']; }
					}
					if($player['FMember'] <> 255) {
					$memquery = mysql_query("SELECT * FROM `families` WHERE `id` = '$player[FMember]'");
					$mem = mysql_fetch_array($memquery);
					}
					if($player['Member'] <> -1 || $player['FMember'] <> 255) {
					if($player['Rank'] == 0) { $rank = $mem['Rank0']; }
					elseif($player['Rank'] == 1) { $rank = $mem['Rank1']; }
					elseif($player['Rank'] == 2) { $rank = $mem['Rank2']; }
					elseif($player['Rank'] == 3) { $rank = $mem['Rank3']; }
					elseif($player['Rank'] == 4) { $rank = $mem['Rank4']; }
					elseif($player['Rank'] == 5) { $rank = $mem['Rank5']; }
					elseif($player['Rank'] == 6) { $rank = $mem['Rank6']; }
					elseif($player['Rank'] == 7) { $rank = $mem['Rank7']; }
					elseif($player['Rank'] == 8) { $rank = $mem['Rank8']; }
					elseif($player['Rank'] == 9) { $rank = $mem['Rank9']; }
					}
					if($player['Member'] == 0 && $player['FMember'] == 255) {
					$rank = "N/A";
					}
					?>
					<?php if($num == 1) { 
					// Mace Edits Start --
					$section = "Staff";
					$area = "Players";
					$details = "Viewed the account information of ".$player['Username'];
					doLog($inf['id'], $section, $area, $details);
					
					// -- Mace Edits End
					?>
					<h3><?php echo $player['Username']; ?><span class='table_view'>Database ID: <?php echo $player['id']; ?></span></h3>
					<?php if($player['Band'] > 0) { echo "<div class='acp-error'>This player is currently banned.</div>"; } ?>
					<?php if($player['Disabled'] > 0) { echo "<div class='acp-error'>This account is currently disabled.</div>"; } ?>
					<?php if($player['AdminLevel'] > 0 || $player['Helper'] > 1) echo "<div class='acp-message'>This account currently holds a staff rank.</div>"; ?>
					<?php $actchkquery = mysql_query("SELECT NULL FROM `accounts` WHERE `IP` = '$player[IP]' AND `id` != $player[id] AND (`AdminLevel` > 0 OR `Helper` > 1)");
					$actchk = mysql_num_rows($actchkquery);
					if($actchk > 0) echo "<div class='acp-message'>The IP that this account uses includes an account that currently holds a staff rank.</div>"; ?>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
						<tr class='tablerow1'>
							<td>Level</td>
							<td><?php echo $player['Level']; ?></td>
						</tr>
						<tr>
							<td>Playing Hours</td>
							<td><?php echo number_format($player['ConnectedTime']); ?></td>
						</tr>
						<tr class='tablerow1'>
							<td>Respect</td>
							<td><?php echo $player['Respect']; ?></td>
						</tr>
						<tr>
							<td>Email</td>
							<td><?php echo $player['Email']; ?></td>
						</tr>
						<?php if($actchk > 0 && $inf['AdminLevel'] >= 1337) { ?>
						<tr>
							<td>IP Address</td>
							<td><?php echo FlagWithIP($player['IP']); ?></td>
						</tr>
						<?php }
						else if($actchk == 0) { ?>
						<tr>
							<td>IP Address</td>
							<td><?php echo FlagWithIP($player['IP']); ?></td>
						</tr>
						<?php } ?>
						<tr class='tablerow1'>
							<td>Last Active</td>
							<td><?php echo LastOnline($player['id']); ?></td>
						</tr>
						<tr>
							<td>Weapons</td>
							<td>
							<?php
							if($player['Gun0'] <> 0) { echo GetWeaponName($player['Gun0'])."<br />"; }
							if($player['Gun1'] <> 0) { echo GetWeaponName($player['Gun1'])."<br />"; }
							if($player['Gun2'] <> 0) { echo GetWeaponName($player['Gun2'])."<br />"; }
							if($player['Gun3'] <> 0) { echo GetWeaponName($player['Gun3'])."<br />"; }
							if($player['Gun4'] <> 0) { echo GetWeaponName($player['Gun4'])."<br />"; }
							if($player['Gun5'] <> 0) { echo GetWeaponName($player['Gun5'])."<br />"; }
							if($player['Gun6'] <> 0) { echo GetWeaponName($player['Gun6'])."<br />"; }
							if($player['Gun7'] <> 0) { echo GetWeaponName($player['Gun7'])."<br />"; }
							if($player['Gun8'] <> 0) { echo GetWeaponName($player['Gun8'])."<br />"; }
							if($player['Gun9'] <> 0) { echo GetWeaponName($player['Gun9'])."<br />"; }
							if($player['Gun10'] <> 0) { echo GetWeaponName($player['Gun10'])."<br />"; }
							if($player['Gun11'] <> 0) { echo GetWeaponName($player['Gun11']); }
							if($player['Gun0'] == 0 && $player['Gun1'] == 0 && $player['Gun2'] == 0 && $player['Gun3'] == 0 && $player['Gun4'] == 0 && $player['Gun5'] == 0 && $player['Gun6'] == 0 && $player['Gun7'] == 0 && $player['Gun8'] == 0 && $player['Gun9'] == 0 && $player['Gun10'] == 0 && $player['Gun11'] == 0) { echo "None"; }
							?>
							</td>
						</tr>
						<tr class='tablerow1'>
							<td>Gender</td>
							<td><?php
							if($player['Sex'] == 0 || $player['Sex'] > 2) { $sex = "Unknown"; }
							if($player['Sex'] == 1) { $sex = "Male"; }
							if($player['Sex'] == 2) { $sex = "Female"; }
							echo $sex; ?></td>
						</tr>
						<tr>
							<td>Age</td>
							<td><?php echo $player['Age']; ?></td>
						</tr>
						<tr class='tablerow1'>
							<td><?php if($player['Member'] <> -1) { echo "Faction"; } 
							if($player['FMember'] <> 255) { echo "Gang"; }
							if($player['Member'] == 0 && $player['FMember'] == 255) { echo "Organization"; } ?></td>
							<td><?php if($player['Member'] <> -1) { echo $mem['Name']; } 
							if($player['FMember'] <> 255) { echo $mem['Name']; }
							if($player['Member'] == 0 && $player['FMember'] == 255) { echo "Not Affiliated"; } ?></td>
						</tr>
						<tr>
							<td>Rank <?php if($player['Member'] <> -1) { echo "(Division)"; } ?></td>
							<td><?php echo $rank." (".$player['Rank'].")";
							if($player['Member'] <> -1) { echo " (".$division.")"; } ?></td>
						</tr>
						<tr class='tablerow1'>
							<td>Job 1</td>
							<td><?php echo GetJobName($player['Job']);
							if($player['Job'] > 0) { echo " (Level: ".GetJobLevel($player['Job'],$exp).")"; } ?></td>
						</tr>
						<tr>
							<td>Job 2</td>
							<td><?php echo GetJobName($player['Job2']);
							if($player['Job2'] > 0) { echo " (Level: ".GetJobLevel($player['Job2'],$exp2).")"; } ?></td>
						</tr>
						<tr class='tablerow1'>
							<td>Phone Number</td>
							<td><?php echo $player['PhoneNr']; ?></td>
						</tr>
						<tr>
							<td>Radio Frequency</td>
							<td><?php echo $player['RadioFreq']; ?></td>
						</tr>
						<tr class='tablerow1'>
							<td>Money On-Hand</td>
							<td>$<?php echo number_format($player['Money']); ?></td>
						</tr>
						<tr>
							<td>Bank Balance</td>
							<td>$<?php echo number_format($player['Bank']); ?></td>
						</tr>
						<tr class='tablerow1'>
							<td>Total Wealth</td>
							<td>$<?php echo CalculateTotalWealth($player['id']); ?></td>
						</tr>
						<tr>
							<td>VIP Rank</td>
							<td><?php echo VIPrank($player['DonateRank']); ?></td>
						</tr>
						<tr class='tablerow1'>
							<td>VIP Expiration</td>
							<td><?php echo date("M. j, Y", $player['VIPExpire']); ?></td>
						</tr>
						<tr>
							<td>Warnings</td>
							<td><?php echo $player['Warnings']; ?></td>
						</tr>
						<tr class='tablerow1'>
							<td>Advertisement Mutes</td>
							<td><?php echo $player['AdMutedTotal']; ?></td>
						</tr>
						<tr>
							<td>Newbie Mutes</td>
							<td><?php echo $player['NewMutedTotal']; ?></td>
						</tr>
						<tr class='tablerow1'>
							<td>Report Mutes</td>
							<td><?php echo $player['ReportMutedTotal']; ?></td>
						</tr>
						<tr>
							<td>Weapon Restriction</td>
							<td><?php echo $player['WRestricted']; ?> hours</td>
						</tr>
						<tr class='tablerow1'>
							<td>Gang Warnings</td>
							<td><?php echo $player['GangWarn']; ?></td>
						</tr>
						<tr>
							<td>Faction Bans</td>
							<td><?php echo $player['FactionBanned']; ?></td>
						</tr>
						<tr class='tablerow1'>
							<td>Faction-Wide Banned</td>
							<td><?php echo $player['CSFBanned']; ?></td>
						</tr>
						<tr>
							<td>Materials</td>
							<td><?php echo number_format($player['Materials']); ?></td>
						</tr>
						<tr class='tablerow1'>
							<td>Crack</td>
							<td><?php echo number_format($player['Crack']); ?></td>
						</tr>
						<tr>
							<td>Pot</td>
							<td><?php echo number_format($player['Pot']); ?></td>
						</tr>
						<tr class='tablerow1'>
							<td>Crimes</td>
							<td><?php echo number_format($player['Crimes']); ?></td>
						</tr>
						<tr>
							<td>Arrests</td>
							<td><?php echo number_format($player['Arrested']); ?></td>
						</tr>
					</table>
					<?php }
					else { print "<div class='acp-error'>The player you are searching for does not exist!</div>"; } ?>
				<div class='acp-actionbar'></div>
					<?php } ?>
			</div></div>
<?php }
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>