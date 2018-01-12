<?php if($inf['AdminLevel'] > 1) { ?>
			<div id='content_wrap'> 
				<ol id='breadcrumb'><li>Players > Vehicle Search</li></ol> 
			<div class='section_title'><h2>Vehicle Search</h2></div>
			<div class='acp-box'>
			<?php if(isset($_GET['vsearch']) && $_GET['vsearch'] == "id") { ?>
			<h3>Vehicle Search by ID</h3>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'> 
			<tr>
				<td><form action="player.php?p=vehicle&vsearch=id" method="post">
					<input type="text" name="id" />
					<input type="submit" class="button" value="Search" />
				</form></td>
			</tr>
			</table>
				<?php if(isset($_POST['id'])) {
					$playerquery = mysql_query("SELECT `sqlID`, `pvModelId` FROM `vehicles` WHERE `pvModelId` = '$_POST[id]'");
					$results = mysql_num_rows($playerquery);
					
					print "<h3>Vehicle #$_POST[id] -- ".GetVehicleName($_POST['id'])." <span class='table_view'>$results Results</span></h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
					<tr>
						<th>Owner</th>
					</tr>
					";
					while ($player = mysql_fetch_array($playerquery)) {
						if(isset($i) && $i == 1) {
							print "<tr class='tablerow1'>";
						$i=0;
						} else { 
							print "<tr>";
						$i=1;
						}
						
						print "
						<td>".GetName($player['sqlID'])."</td>
						";
					}
					?>
					</table>
				<?php }
				}
				if(isset($_GET['vsearch']) && $_GET['vsearch'] == "player")
				{
					AutoComplete();
				?>
					<h3>Vehicle Search by Player</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'> 
					<tr>
						<td><form action="player.php?p=vehicle&vsearch=player" method="post">
							<input id="accountsearch" type="text" name="player" />
							<input type="submit" class="button" value="Search" />
						</form></td>
					</tr>
					</table>
					<?php if(isset($_POST['player']))
					{
						$playerquery = mysql_query("SELECT `pvModelId` FROM `vehicles` WHERE `sqlID` = ".GetID($_POST[player])."");
						$vehcount = mysql_num_rows($playerquery);
						print "<h3>Results for $_POST[player]<span class='table_view'>$vehcount Vehicles</span></h3>
						<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
						<tr>
							<th width='10%'>Vehicle ID</th>
							<th width='80%'>Vehicle Name</th>
						</tr>";
						while($player = mysql_fetch_array($playerquery))
						{
							if (isset($i) && $i == 1) {
								print "<tr class='tablerow1'>";
								$i=0;
							} else { 
								print "<tr>";
								$i=1;
							}
							print "
								<td>$player[pvModelId]</td>
								<td>".GetVehicleName($player['pvModelId'])."</td>
							</tr>";
						}
						echo "</table>";
					} ?>
				<?php } ?>
				<div class='acp-actionbar'></div>
			</div></div>
<?php }
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>