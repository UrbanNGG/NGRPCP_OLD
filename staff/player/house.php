<?php if($inf['AdminLevel'] > 1) { ?>
			<div id='content_wrap'> 
				<ol id='breadcrumb'><li>Players > House Search</li></ol> 
			<div class='section_title'><h2>House Search</h2></div>
			<div class='acp-box'>
			<?php if(isset($_GET['hsearch']) && $_GET['hsearch'] == "id") { ?>
			<h3>House Search by ID</h3>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'> 
			<tr>
				<td><form action="player.php?p=house&hsearch=id" method="post">
					<input type="text" name="id" />
					<input type="submit" class="button" value="Search" />
				</form></td>
			</tr>
			</table>
				<?php if(isset($_POST['id'])) {
					$housequery = mysql_query("SELECT * FROM `houses` WHERE `id` = $_POST[id] + 1");
					$num = mysql_num_rows($housequery);
					
					print "<h3>House #$_POST[id]</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>";
					
					$house = mysql_fetch_array($housequery);
					
					echo "<tr><td>".MapLocation($house['Owner'], $house['id'], $house['ExteriorX'], $house['ExteriorY'], $house['Owner'])."</td></tr>";
					
					print "
					<tr class='tablerow1'>
						<td>Owner</td>
						<td>".GetName($house['OwnerID'])."</td>
					</tr>
					<tr>
						<td>Location</td>
						<td>".GetPlayer2DZone($house['ExteriorX'], $house['ExteriorY'])."</td>
					</tr>
					<tr class='tablerow1'>
						<td>Level</td>
						<td>$house[Level]</td>
					</tr>
					<tr>
						<td>Value</td>
						<td>$".number_format($house['Value'])."</td>
					</tr>
					<tr class='tablerow1'>
						<td>Rent</td>
						<td>
					";
					if($house['Rentable'] == 1) { print "$".number_format($house['RentFee']); }
					if($house['Rentable'] == 0) { print "N/A"; }
					print "
						</td>
					</tr>
					<tr>
						<td>Safe</td>
						<td>$".number_format($house['SafeMoney'])."<br />".number_format($house['Materials'])." Materials<br />".number_format($house['Crack'])." Crack<br />".number_format($house['Pot'])." Pot</td>
					</tr>
					<tr class='tablerow1'>
						<td>Weapons</td>
						<td>
					";
					if($house['GLUpgrade'] == 5) { print "Slot 1: ".GetWeaponName($house['Weapons0'])."<br />Slot 2: ".GetWeaponName($house['Weapons1'])."<br />Slot 3: ".GetWeaponName($house['Weapons2'])."<br />Slot 4: ".GetWeaponName($house['Weapons3'])."<br />Slot 5: ".GetWeaponName($house['Weapons4']); }
					if($house['GLUpgrade'] == 4) { print "Slot 1: ".GetWeaponName($house['Weapons0'])."<br />Slot 2: ".GetWeaponName($house['Weapons1'])."<br />Slot 3: ".GetWeaponName($house['Weapons2'])."<br />Slot 4: ".GetWeaponName($house['Weapons3']); }
					if($house['GLUpgrade'] == 3) { print "Slot 1: ".GetWeaponName($house['Weapons0'])."<br />Slot 2: ".GetWeaponName($house['Weapons1'])."<br />Slot 3: ".GetWeaponName($house['Weapons2']); }
					if($house['GLUpgrade'] == 2) { print "Slot 1: ".GetWeaponName($house['Weapons0'])."<br />Slot 2: ".GetWeaponName($house['Weapons1']); }
					if($house['GLUpgrade'] == 1) { print "Slot 1: ".GetWeaponName($house['Weapons0']); }
					print "
						</td>
					</tr>
					<tr>
						<td>Locked?</td>
						<td>
					";
					if($house['Lock'] == 1) { print "Yes"; }
					if($house['Lock'] == 0) { print "No"; }
					print "
						</td>
					</tr>
					<tr class='tablerow1'>
						<td>Custom Exterior?</td>
						<td>
					";
					if($house['CustomExterior'] == 1) { print "Yes"; }
					if($house['CustomExterior'] == 0) { print "No"; }
					print "
						</td>
					</tr>
					<tr>
						<td>Custom Interior?</td>
						<td>
					";
					if($house['CustomInterior'] == 1) { print "Yes"; }
					if($house['CustomInterior'] == 0) { print "No"; }
					print "
						</td>
					</tr>
					<tr class='tablerow1'>
						<td>Exterior Coordinates</td>
						<td>X: $house[ExteriorX]<br />Y: $house[ExteriorY]<br />Z: $house[ExteriorZ]</td>
					</tr>
					<tr>
						<td>Interior Coordinates</td>
						<td>X: $house[InteriorX]<br />Y: $house[InteriorY]<br />Z: $house[InteriorZ]</td>
					</tr>
					<tr class='tablerow1'>
						<td>Virtual Interior ID</td>
						<td>$house[HInteriorWorld]</td>
					</tr>
					<tr>
						<td>Virtual World ID</td>
						<td>
					";
						print $house['id'] + 6000;
					print "
						</td>
					</tr>
					";
					?>
					</table>
					<h3>Gates Associated with House #<?php echo $_POST['id']; ?></h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
					<tr><th>ID</th><th>Model</th><th>Password</th><th>Coordinates</th></tr>
					<?php
						$gatequery = mysql_query("SELECT * FROM `gates` WHERE `HID` = $_POST[id]");
						while($gate = mysql_fetch_array($gatequery))
						{
							if(isset($i) && $i == 1)
							{
								print "<tr class='tablerow1'>";
								$i = 0;
							}
							else
							{ 
								print "<tr>";
								$i = 1;
							}
							print "<td>$gate[ID]</td><td>$gate[Model]</td><td>$gate[Pass]</td><td>$gate[PosX], $gate[PosY], $gate[PosZ]<br />VW: $gate[VW] - Int: $gate[Int]</td>";
						}
					?>
					</table>
				<?php }
				}
				if(isset($_GET['hsearch']) && $_GET['hsearch'] == "player") {
				AutoComplete();
				?>
			<h3>House Search by Player</h3>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'> 
			<tr>
				<td><form action="player.php?p=house&hsearch=player" method="post">
					<input id="accountsearch" type="text" name="player" />
					<input type="submit" class="button" value="Search" />
				</form></td>
			</tr>
			</table>
				<?php if(isset($_POST['player'])) {
					$housequery = mysql_query("SELECT * FROM `houses` WHERE `OwnerID` = ".GetID($_POST['player'])."");
					$num = mysql_num_rows($housequery);
					
					print "<h3>Results for $_POST[player]: $num</h3>";
					
					while ($house = mysql_fetch_array($housequery))
					{
						$houseid = $house['id'] - 1;
						
						print "<h3>House #$houseid</h3>
						<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>

						<tr><td>".MapLocation($_POST['player'], $house['id'], $house['ExteriorX'], $house['ExteriorY'], $house['Owner'])."</td></tr>
						
						<tr class='tablerow1'>
							<td>Owner</td>
							<td>".GetName($house['OwnerID'])."</td>
						</tr>
						<tr>
							<td>Location</td>
							<td>".GetPlayer2DZone($house['ExteriorX'], $house['ExteriorY'])."</td>
						</tr>
						<tr class='tablerow1'>
							<td>Level</td>
							<td>$house[Level]</td>
						</tr>
						<tr>
							<td>Value</td>
							<td>$".number_format($house['Value'])."</td>
						</tr>
						<tr class='tablerow1'>
							<td>Rent</td>
							<td>
						";
						if($house['Rentable'] == 1) { print "$".number_format($house['RentFee']); }
						if($house['Rentable'] == 0) { print "N/A"; }
						print "
							</td>
						</tr>
						<tr>
							<td>Safe</td>
							<td>$".number_format($house['SafeMoney'])."<br />".number_format($house['Materials'])." Materials<br />".number_format($house['Crack'])." Crack<br />".number_format($house['Pot'])." Pot</td>
						</tr>
						<tr class='tablerow1'>
							<td>Weapons</td>
							<td>
						";
						if($house['GLUpgrade'] == 5) { print "Slot 1: ".GetWeaponName($house['Weapons0'])."<br />Slot 2: ".GetWeaponName($house['Weapons1'])."<br />Slot 3: ".GetWeaponName($house['Weapons2'])."<br />Slot 4: ".GetWeaponName($house['Weapons3'])."<br />Slot 5: ".GetWeaponName($house['Weapons4']); }
						if($house['GLUpgrade'] == 4) { print "Slot 1: ".GetWeaponName($house['Weapons0'])."<br />Slot 2: ".GetWeaponName($house['Weapons1'])."<br />Slot 3: ".GetWeaponName($house['Weapons2'])."<br />Slot 4: ".GetWeaponName($house['Weapons3']); }
						if($house['GLUpgrade'] == 3) { print "Slot 1: ".GetWeaponName($house['Weapons0'])."<br />Slot 2: ".GetWeaponName($house['Weapons1'])."<br />Slot 3: ".GetWeaponName($house['Weapons2']); }
						if($house['GLUpgrade'] == 2) { print "Slot 1: ".GetWeaponName($house['Weapons0'])."<br />Slot 2: ".GetWeaponName($house['Weapons1']); }
						if($house['GLUpgrade'] == 1) { print "Slot 1: ".GetWeaponName($house['Weapons0']); }
						print "
							</td>
						</tr>
						<tr>
							<td>Locked?</td>
							<td>
						";
						if($house['Lock'] == 1) { print "Yes"; }
						if($house['Lock'] == 0) { print "No"; }
						print "
							</td>
						</tr>
						<tr class='tablerow1'>
							<td>Custom Exterior?</td>
							<td>
						";
						if($house['CustomExterior'] == 1) { print "Yes"; }
						if($house['CustomExterior'] == 0) { print "No"; }
						print "
							</td>
						</tr>
						<tr>
							<td>Custom Interior?</td>
							<td>
						";
						if($house['CustomInterior'] == 1) { print "Yes"; }
						if($house['CustomInterior'] == 0) { print "No"; }
						print "
							</td>
						</tr>
						<tr class='tablerow1'>
							<td>Exterior Coordinates</td>
							<td>X: $house[ExteriorX]<br />Y: $house[ExteriorY]<br />Z: $house[ExteriorZ]</td>
						</tr>
						<tr>
							<td>Interior Coordinates</td>
							<td>X: $house[InteriorX]<br />Y: $house[InteriorY]<br />Z: $house[InteriorZ]</td>
						</tr>
						<tr class='tablerow1'>
							<td>Virtual Interior ID</td>
							<td>$house[HInteriorWorld]</td>
						</tr>
						<tr>
							<td>Virtual World ID</td>
							<td>
						";
							print $house['id'] + 6000;
						print "
							</td>
						</tr>
						</table>
						";
						
					print "<h3>Gates Associated with House #$houseid</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
					<tr><th>ID</th><th>Model</th><th>Password</th><th>Coordinates</th></tr>";
					$gatequery = mysql_query("SELECT * FROM `gates` WHERE `HID` = $houseid");
					while($gate = mysql_fetch_array($gatequery))
					{
						if(isset($i) && $i == 1)
						{
							print "<tr class='tablerow1'>";
							$i = 0;
						}
						else
						{ 
							print "<tr>";
							$i = 1;
						}
						print "<td>$gate[ID]</td><td>$gate[Model]</td><td>$gate[Pass]</td><td>$gate[PosX], $gate[PosY], $gate[PosZ]<br />VW: $gate[VW] - Int: $gate[Int]</td>";
					}
					print "</table>";
					}
					?>
				<?php }
				} ?>
				<div class='acp-actionbar'></div>
			</div></div>
<?php }
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>