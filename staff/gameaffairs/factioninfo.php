<?php 
if($inf['FactionModerator'] > 0 || $inf['AdminLevel'] > 3)
{
	function toColor($n)
	{
		return("#".substr("000000".dechex($n),-6));
	}
	if(isset($_GET['mem']))
	{
		$mem = $_GET['mem'];
		$groupquery = mysql_query("SELECT * FROM `groups` WHERE `id` = '$mem'");
		$group = mysql_fetch_array($groupquery);
		$color = $group['DutyColour'];
		switch($group['Type'])
		{
			case 1: $type = "Law Enforcement"; break;
			case 2: $type = "Hitman"; break;
			case 3: $type = "Medical"; break;
			case 4: $type = "News Reporter"; break;
			case 5: $type = "Government"; break;
			case 6: $type = "Judicial"; break;
			case 7: $type = "Transportation"; break;
			case 8: $type = "Towing"; break;
			case 9: $type = "Racing"; break;
		}
		switch($group['Allegiance'])
		{
			case 0: $allegiance = "None"; break;
			case 1: $allegiance = "San Andreas"; break;
			case 2: $allegiance = "Tierra Robada"; break;
		}
		function GetRankName($group, $rnum)
		{
			switch($rnum)
			{
				case 0: $rankname = $group['Rank0']." (0)"; break;
				case 1: $rankname = $group['Rank1']." (1)"; break;
				case 2: $rankname = $group['Rank2']." (2)"; break;
				case 3: $rankname = $group['Rank3']." (3)"; break;
				case 4: $rankname = $group['Rank4']." (4)"; break;
				case 5: $rankname = $group['Rank5']." (5)"; break;
				case 6: $rankname = $group['Rank6']." (6)"; break;
				case 7: $rankname = $group['Rank7']." (7)"; break;
				case 8: $rankname = $group['Rank8']." (8)"; break;
				case 9: $rankname = $group['Rank9']." (9)"; break;
				case 255: $rankname = "N/A"; break;
			}
			return $rankname;
		}
	}
	?>
	<div id='content_wrap'>
		<ol id='breadcrumb'><li>Game Affairs > Viewing Faction Information</li></ol>
		<div class='section_title'><h2>Faction Information</h2></div>
	<div class='acp-box'>
		<h3>Faction Member List</h3>
			<?php
			if(isset($_GET['n']) && $_GET['n'] == 1) echo "<div class='acp-error'>That player is currently in-game. Please remove membership in-game or try again later.</div>";
			if(isset($_GET['n']) && $_GET['n'] == 2) echo "<div class='acp-message'>Player removed successfully!</div>";
			?>
		
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
			<tr>
				<th colspan='7'>
			<?php
			$grouplistquery = mysql_query("SELECT `id`, `Name`, `DutyColour` FROM `groups` WHERE `Name` <> ''");
			while ($grouplist = mysql_fetch_array($grouplistquery))
			{
				echo "[<a href='gameaffairs.php?p=factioninfo&mem=$grouplist[id]' style='color:".toColor($grouplist['DutyColour'])."'>$grouplist[Name]</a>] ";
			}
			?>
				</th>
			</tr>
			</table>
			<?php if(isset($_GET['mem'])) {
			$fmem1 = mysql_query("SELECT `id`, `Online`, `Username`, `IP`, `Leader`, `Member`, `Rank`, `Division` FROM `accounts` WHERE `AdminLevel` < 2 AND `Disabled` = 0 AND `Member` = $mem-1 ORDER BY Rank DESC, Username ASC");
			$count = mysql_num_rows($fmem1);
			echo "<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>";
			echo "<tr><h3>Faction Information - <span style='color:".toColor($color)."'>$group[Name]</span></h3></tr>";
			print "
			<tr>
				<td colspan='4'>MOTD: $group[MOTD]</td>
			</tr>
			<tr class='tablerow1'>
				<td width='25%'>Type: $type</td>
				<td width='25%'>Allegiance: $allegiance</td>
				<td width='25%'>Safe Balance: $".number_format($group['Budget'])."</td>
				<td width='25%'>Materials: ".number_format($group['Stock'])."</td>
			</tr>
			";
			echo "</table>";

			echo "<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>";
			echo "<tr><h3>Rank Restrictions</h3></tr>";
			print "
			<tr>
				<td width='25%'>Faction Radio: ".GetRankName($group, $group['Radio'])."</td>
				<td width='25%'>Department Radio: ".GetRankName($group, $group['DeptRadio'])."</td>
				<td width='25%'>Government Announcement: ".GetRankName($group, $group['GovAnnouncement'])."</td>
				<td width='25%'>Bug: ".GetRankName($group, $group['Bug'])."</td>
			</tr>
			";
			print "
			<tr class='tablerow1'>
				<td width='25%'>Spike Strips: ".GetRankName($group, $group['SpikeStrips'])."</td>
				<td width='25%'>Barricades: ".GetRankName($group, $group['Barricades'])."</td>
				<td width='25%'>Cones: ".GetRankName($group, $group['Cones'])."</td>
				<td width='25%'>Barrels: ".GetRankName($group, $group['Barrels'])."</td>
			</tr>
			";
			print "
			<tr>
				<td width='25%'>Flares: ".GetRankName($group, $group['Flares'])."</td>
				<td width='25%'>Free Name-Change: ".GetRankName($group, $group['FreeNameChange'])."</td>
				<td width='25%'></td>
				<td width='25%'></td>
			</tr>
			";
			echo "</table>";
			echo "<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>";
			echo "<tr><h3>Locker Contents</h3></tr>";
			print "
			<tr class='tablerow1'>
				<td width='11.1%'>".GetWeaponName($group['Gun0'])." (".number_format($group['Cost0']).")</td>
				<td width='11.1%'>".GetWeaponName($group['Gun1'])." (".number_format($group['Cost1']).")</td>
				<td width='11.1%'>".GetWeaponName($group['Gun2'])." (".number_format($group['Cost2']).")</td>
				<td width='11.1%'>".GetWeaponName($group['Gun3'])." (".number_format($group['Cost3']).")</td>
				<td width='11.1%'>".GetWeaponName($group['Gun4'])." (".number_format($group['Cost4']).")</td>
				<td width='11.1%'>".GetWeaponName($group['Gun5'])." (".number_format($group['Cost5']).")</td>
				<td width='11.1%'>".GetWeaponName($group['Gun6'])." (".number_format($group['Cost6']).")</td>
				<td width='11.1%'>".GetWeaponName($group['Gun7'])." (".number_format($group['Cost7']).")</td>
				<td width='11.1%'>".GetWeaponName($group['Gun8'])." (".number_format($group['Cost8']).")</td>
			</tr>
			";
			print "
			<tr>
				<td width='11.1%'>".GetWeaponName($group['Gun9'])." (".number_format($group['Cost9']).")</td>
				<td width='11.1%'>".GetWeaponName($group['Gun10'])." (".number_format($group['Cost10']).")</td>
				<td width='11.1%'>".GetWeaponName($group['Gun11'])." (".number_format($group['Cost11']).")</td>
				<td width='11.1%'>".GetWeaponName($group['Gun12'])." (".number_format($group['Cost12']).")</td>
				<td width='11.1%'>".GetWeaponName($group['Gun13'])." (".number_format($group['Cost13']).")</td>
				<td width='11.1%'>".GetWeaponName($group['Gun14'])." (".number_format($group['Cost14']).")</td>
				<td width='11.1%'>".GetWeaponName($group['Gun15'])." (".number_format($group['Cost15']).")</td>
				<td width='11.1%'>".GetWeaponName($group['Gun16'])." (".number_format($group['Cost16']).")</td>
				<td width='11.1%'></td>
			</tr>
			";
			echo "<tr class='tablerow1'><td colspan='9' style='font-weight:bold;font-style:italic'>";
			if($group['LockerCostType'] == 0) echo "Cost (noted in paraenthesis) is based on materials.";
			else if($group['LockerCostType'] == 1) echo "Cost (noted in paraenthesis) is based on cash from the faction safe.";
			else if($group['LockerCostType'] == 2) echo "Cost (noted in paraenthesis) is based on cash from the player.";
			echo "</td></tr>";
			echo "</table>";

			echo "<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>";
			echo "<tr><h3>Member List <span class='table_view'>Members: ".$count."</span></h3></tr>";
			print "<tr><th width='5%'></th><th width='5%'></th><th>Rank</th><th>Player</th><th>Division</th><th>Last Active</th><th>Kick</th></tr>";
			while ($fmem = mysql_fetch_array($fmem1))
			{
				if (isset($i) && $i == 1) {
					print "<tr class='tablerow1'>";
				$i=0;
				} else { 
					print "<tr>";
				$i=1;
				}
				
				switch($fmem['Rank'])
				{
					case 0: $fmem['Rank'] = $group['Rank0']; break;
					case 1: $fmem['Rank'] = $group['Rank1']; break;
					case 2: $fmem['Rank'] = $group['Rank2']; break;
					case 3: $fmem['Rank'] = $group['Rank3']; break;
					case 4: $fmem['Rank'] = $group['Rank4']; break;
					case 5: $fmem['Rank'] = $group['Rank5']; break;
					case 6: $fmem['Rank'] = $group['Rank6']; break;
					case 7: $fmem['Rank'] = $group['Rank7']; break;
					case 8: $fmem['Rank'] = $group['Rank8']; break;
					case 9: $fmem['Rank'] = $group['Rank9']; break;
				}
				switch($fmem['Division'])
				{
					case -1: $fmem['Division'] = "G.D."; break;
					case 0: $fmem['Division'] = $group['Div1']; break;
					case 1: $fmem['Division'] = $group['Div2']; break;
					case 2: $fmem['Division'] = $group['Div3']; break;
					case 3: $fmem['Division'] = $group['Div4']; break;
					case 4: $fmem['Division'] = $group['Div5']; break;
					case 5: $fmem['Division'] = $group['Div6']; break;
					case 6: $fmem['Division'] = $group['Div7']; break;
					case 7: $fmem['Division'] = $group['Div8']; break;
					case 8: $fmem['Division'] = $group['Div9']; break;
				}
				
				$kick = "
				<form method='POST' action='gameaffairs/proc.php'>
				<input type='hidden' name='action' readonly='readonly' value='kick_member'>
				<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
				<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
				<input type='hidden' name='leader' readonly='readonly' value='$fmem[Username]'>
				<input type='hidden' name='ga_id' readonly='readonly' value='$fmem[Member]'>
				<input type='image' src='../../global/images/all/icons/cross.png' alt='Kick'></form>
				";
				
				if(IsPlayerOnline($fmem['id']) > 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-online.png' alt='Online' />"; }
				if(IsPlayerOnline($fmem['id']) == 0) { $status = "<img src='../../global/images/all/icon_components/topics/user-offline.png' alt='Offline' />"; }
				
				print "
					<td>$status</td>
					<td>".FlagByIP($fmem['IP'])."</td>
					<td>$fmem[Rank]</td>
					<td>
				";
				if($fmem['Leader'] <> -1) { print "<span style='color:red;font-weight:bold'>(L)</span> "; }
				if($fmem['Online'] <> 0) { print "<span style='font-weight:bold'>$fmem[Username]</span>"; }
				elseif($fmem['Online'] == 0) { print "$fmem[Username]"; }
				print "
					</td>
					<td>$fmem[Division]</td>
					<td>".LastOnline($fmem['id'])."</td>
					<td>$kick</td>
					</tr>
					";
				}
			?>
			</table>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
			<?php
			$vehquery = mysql_query("SELECT * FROM `groupvehs` WHERE `gID` = $group[id]-1");
			$vehcount = mysql_num_rows($vehquery);
			echo "<tr><h3>Vehicle List <span class='table_view'>Total: ".$vehcount."</span></h3></tr>";
			print "<tr><th>Database ID</th><th>Spawned ID</th><th>Vehicle</th><th>Spawn Location</th><th>Upkeep</th><th>Object 1</th><th>Object 2</th><th>License Plate</th></tr>";
			while ($veharray = mysql_fetch_array($vehquery))
			{
				if (isset($i) && $i == 1) {
					print "<tr class='tablerow1'>";
				$i=0;
				} else { 
					print "<tr>";
				$i=1;
				}
				
				/*switch($fmem['Rank'])
				{
					case 0: $fmem['Rank'] = $group['Rank0']; break;
					case 1: $fmem['Rank'] = $group['Rank1']; break;
					case 2: $fmem['Rank'] = $group['Rank2']; break;
					case 3: $fmem['Rank'] = $group['Rank3']; break;
					case 4: $fmem['Rank'] = $group['Rank4']; break;
					case 5: $fmem['Rank'] = $group['Rank5']; break;
					case 6: $fmem['Rank'] = $group['Rank6']; break;
					case 7: $fmem['Rank'] = $group['Rank7']; break;
					case 8: $fmem['Rank'] = $group['Rank8']; break;
					case 9: $fmem['Rank'] = $group['Rank9']; break;
				}
				switch($fmem['Division'])
				{
					case -1: $fmem['Division'] = "G.D."; break;
					case 0: $fmem['Division'] = $group['Div1']; break;
					case 1: $fmem['Division'] = $group['Div2']; break;
					case 2: $fmem['Division'] = $group['Div3']; break;
					case 3: $fmem['Division'] = $group['Div4']; break;
					case 4: $fmem['Division'] = $group['Div5']; break;
					case 5: $fmem['Division'] = $group['Div6']; break;
					case 6: $fmem['Division'] = $group['Div7']; break;
					case 7: $fmem['Division'] = $group['Div8']; break;
					case 8: $fmem['Division'] = $group['Div9']; break;
				}*/
				
				print "
					<td>$veharray[id]</td>
					<td>$veharray[SpawnedID]</td>
					<td>$veharray[vModel]</td>
					<td>--</td>
					<td>$veharray[vUpkeep]</td>
					<td>$veharray[vAttachedObjectModel1]</td>
					<td>$veharray[vAttachedObjectModel2]</td>
					<td>$veharray[vPlate]</td>
				</tr>
				";
			}
		}
		?>
		</table>
	</div>
	</div>
<?php
} 
else echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>";
?>