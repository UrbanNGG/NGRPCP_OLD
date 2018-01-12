			<?php if($group['Type'] == 1 || $group['Type'] == 2) { ?>
			<div id='content_wrap'> 
				<ol id='breadcrumb'><li>Faction > MDC</li></ol> 
			<div class='section_title'><h2>Search</h2></div>
			<div class='acp-box'>
			<h3>Search by Name</h3>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'> 
			<tr>
				<td><form action="faction.php?p=mdc" method="post">
					<input type="text" name="name" />
					<input type="submit" class="button" value="Search" />
				</form></td>
			</tr>
			</table>
				<?php if(isset($_POST['name'])) {
					$playerquery = mysql_query("SELECT `UpdateDate`, `id`, `Username`, `Sex`, `BirthDate`, `Age`, `Model`, `Married`, `MarriedTo`, `CarLic`, `BoatLic`, `FlyLic`, `FishLic`, `TaxiLicense`, `WantedLevel`, `PhoneNr`, `Apartment`, `Apartment2`, `Renting` FROM `accounts` WHERE `Username` = '$_POST[name]' AND `AdminLevel` <= 1");
					$player = mysql_fetch_array($playerquery);
					$housequery = mysql_query("SELECT * FROM `houses` WHERE `id` = $player[Apartment] + 1 OR `id` = $player[Apartment2] + 1 OR `id` = $player[Renting] + 1");
					$num = mysql_num_rows($playerquery);
					$housecount = mysql_num_rows($housequery);
					
					if($num == 0) { echo "<div class='acp-error'>That name is not in the database!</div>"; }
					
					if($num > 0) {
					
					if($player['Sex'] == 1) { $gender = "Male"; }
					if($player['Sex'] == 2) { $gender = "Female"; }
					
					print "
					<h3>Search Results</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
						<tr class='tablerow1'>
							<td><img src='http://".$_SERVER['SERVER_NAME']."/global/images/skins/ImageSkin_$player[Model].png' style='display:inline;float:left;' /></td>
							<td>Full Name</td>
							<td>".StripName($player['Username'])."</td>
						</tr>
						<tr>
							<td></td>
							<td>Gender</td>
							<td>$gender</td>
						</tr>
						<tr class='tablerow1'>
							<td></td>
							<td>Age</td>
							<td>$player[Age]</td>
						</tr>
						<tr>
							<td></td>
							<td>Phone Number</td>
							<td>$player[PhoneNr]</td>
						</tr>
						<tr class='tablerow1'>
							<td></td>
							<td>Last Seen</td>
							<td>".date('F j, Y, g:i A', strtotime($player['UpdateDate']))."</td>
						</tr>
						<tr>
							<td></td>
							<td>Marital Status</td>
							<td>
					";
							if($player['Married'] == 0) { echo "Single"; }
							if($player['Married'] == 1) { echo "Married to ".StripName($player['MarriedTo']); }
					print "
							</td>
						</tr>
						<tr class='tablerow1'>
							<td></td>
							<td>Status of Residence</td>
							<td>
					";
							if($player['Apartment'] == -1 && $player['Apartment2'] == -1 && $player['Renting'] == -1) { echo "Homeless"; }
							if($player['Apartment'] == -1 && $player['Apartment2'] == -1 && $player['Renting'] > -1) { echo "Renting"; }
							if($player['Apartment'] > -1 || $player['Apartment2'] > -1) { echo "Home Owner"; }
					print "
							</td>
						</tr>
					</table>";
					/*
					echo "<h3>Licenses</h3>";
						print "<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
						<tr><th>Name</th><th>Status</th><th>Expires</th></tr>";
						if($player['CarLic'] == 1 || $player['FlyLic'] == 1 || $player['BoatLic'] == 1 || $player['FishLic'] == 1) { $status = 'Active'; } else { $status = 'Not Active/Registered'; }
						print "<tr><td>Drivers License</td><td>" . $status . "</td><td>" . date('m-d', strtotime($player['BirthDate'])) . "-" . date('Y', strtotime('+1 year')) . "</td></tr>";
						if($player['FlyLic'] == 1) {
						print "<tr><td>Pilot License</td><td>" . $status . "</td><td>Lifetime</td></tr>";
						}
						if($player['BoatLic'] == 1) {
						print "<tr><td>Boat License</td><td>" . $status . "</td><td>Lifetime</td></tr>";
						}
						if($player['FishLic'] == 1) {
						print "<tr><td>Fishing License</td><td>" . $status . "</td><td>Lifetime</td></tr>";
						}
						if($player['TaxiLicense'] == 1) {
						print "<tr><td>Taxi License</td><td>" . $status . "</td><td>Lifetime</td></tr>";
						}
						print "</table>";
					echo "<h3>Vehicle Registrations</h3>";
						print "<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
						<tr><th>Name</th><th>Status</th></tr>";
						$q = mysql_query("SELECT * FROM `vehicles` WHERE `sqlID` = ".$inf['id']."");
						while($r = mysql_fetch_array($q)) {
							print "<tr><td>" . GetVehicleName($r['pvModelId']) . "</td><td>" . $r['pvDisabled'] . "</td></tr>";
						}
						print "</table>";
					*/
					print "
					<h3>Active Warrants</h3>
					";
					if($player['WantedLevel'] == 0) { echo "<div class='acp-message'>There are currently no active warrants for this person.</div>"; }
					if($player['WantedLevel'] > 0) { echo "<div class='acp-error'>This person currently has ".$player['WantedLevel']." active warrants!</div>";
						print "<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
						<tr><th>Date</th><th>Crime</th><th>Issued By</th></tr>";
						$activequery = mysql_query("SELECT * FROM `mdc` WHERE `id` = '$player[id]' AND `active` = 1 ORDER BY `time` ASC");
						while ($active = mysql_fetch_array($activequery)) {
						
						if (isset($i) && $i == 1) {
							print "<tr class='tablerow1'>";
						$i=0;
						} else { 
							print "<tr>";
						$i=1;
						}
						
						print "
						<td>".date("m/d/o -- h:i:sA", strtotime($active['time']))."</td>
						<td>$active[crime]</td>
						<td>$active[issuer]</td>
						";
						}
						echo "</table>";
					}
					echo "<h3>Arrest History</h3>";
						print "<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
						<tr><th>Date</th><th>Crime</th><th>Issued By</th></tr>";
						$historyquery = mysql_query("SELECT * FROM `mdc` WHERE `id` = '$player[id]' AND `active` = 0 ORDER BY `time` DESC");
						$historycount = mysql_num_rows($historyquery);
						if($historycount == 0) { echo "<tr><td colspan='3'>There have been no arrests made against this person!</td></tr>"; }
						if($historycount > 0) {
						while ($history = mysql_fetch_array($historyquery)) {
						
						if (isset($i) && $i == 1) {
							print "<tr class='tablerow1'>";
						$i=0;
						} else { 
							print "<tr>";
						$i=1;
						}
						
						print "
						<td>".date("m/d/o -- h:i:sA", strtotime($history['time']))."</td>
						<td>$history[crime]</td>
						<td>$history[issuer]</td>
						";
						}
						}
						echo "</table>";
					if($player['Apartment'] > -1 || $player['Apartment2'] > -1 || $player['Renting'] > -1) {
					print "<h3>Residential Information</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
					";
					
					while ($house = mysql_fetch_array($housequery)) {
					
					echo MapLocation($_POST['name'], $house['id'], $house['ExteriorX'], $house['ExteriorY'], $house['Owner']);
					
					print "
					<tr>
						<td colspan='2'>
							<body onload='load()' onunload='Unload()'><div id='map'></div></body>
						</td>
					</tr>
					<tr class='tablerow1'>
						<td>Address</td>
						<td>$house[id], ".GetPlayer2DZone($house['ExteriorX'], $house['ExteriorY'])."</td>
					</tr>
					<tr>
						<td>House Owner</td>
						<td>".StripName($house['Owner']);
							if($house['id'] == $player['Renting'] + 1) { echo " (Renter)"; }
					print "
						</td>
					</tr>
					";
					}
					print "</table>";
					}
					}
					}
					?>
				<div class='acp-actionbar'></div>
			</div></div>
			<?php }
			else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this area.</h2></div></div>"; } ?>