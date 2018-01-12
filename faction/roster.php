<?php if(($group['Type'] == 2 && $inf['Leader'] == $inf['Member']) || $group['Type'] != 2) { ?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Faction > Viewing Faction Roster</li></ol>
	<div class='section_title'><h2>Faction Members</h2></div>
<div class='acp-box'>
	<?php
	$fmem1 = mysql_query("SELECT `id`, `Online`, `Username`, `UpdateDate`, `IP`, `Leader`, `Rank`, `Division` FROM `accounts` WHERE `AdminLevel` < '2' AND `Disabled` = '0' AND `Member` = '$inf[Member]' ORDER BY Rank DESC, Username ASC");
	$count = mysql_num_rows($fmem1);
	print "<h3>Faction Member List <span class='table_view'>Members: ".$count."</span></h3>";
		
			if(isset($_GET['note']) && $_GET['note'] == 0) { echo "<div class='acp-error'>That player has leadership!</div>"; }
			if(isset($_GET['note']) && $_GET['note'] == 1) { echo "<div class='acp-error'>That player is currently in-game. Please remove them in-game or try again later.</div>"; }
			if(isset($_GET['note']) && $_GET['note'] == 2) { echo "<div class='acp-message'>Uninvited successfully!</div>"; }
			
	print "		
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th width='5%'></th><th>Rank</th><th>Player</th><th>Division</th><th>Last Active</th>";
			if($inf['Leader'] == $inf['Member']) { echo "<th>Uninvite</th>"; }
	print "
		</tr>
	";
		while ($fmem = mysql_fetch_array($fmem1)) {
		
		$remove = "
		<form method='POST' action='faction/proc.php'>
		<input type='hidden' name='action' readonly='readonly' value='uninvite'>
		<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
		<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
		<input type='hidden' name='uID' readonly='readonly' value='$fmem[id]'>
		<input type='hidden' name='username' readonly='readonly' value='$fmem[Username]'>
		<input type='hidden' name='facname' readonly='readonly' value='$group[Name]'>
		<input type='image' src='../../global/images/all/icons/cross.png' alt='Remove'></form>
		";
		
			if (isset($i) && $i == 1) {
				print "<tr class='tablerow1'>";
			$i=0;
			} else { 
				print "<tr>";
			$i=1;
			}

			if($fmem['Rank'] == 0) { $fmem['Rank'] = $group['Rank0']; }
			elseif($fmem['Rank'] == 1) { $fmem['Rank'] = $group['Rank1']; }
			elseif($fmem['Rank'] == 2) { $fmem['Rank'] = $group['Rank2']; }
			elseif($fmem['Rank'] == 3) { $fmem['Rank'] = $group['Rank3']; }
			elseif($fmem['Rank'] == 4) { $fmem['Rank'] = $group['Rank4']; }
			elseif($fmem['Rank'] == 5) { $fmem['Rank'] = $group['Rank5']; }
			elseif($fmem['Rank'] == 6) { $fmem['Rank'] = $group['Rank6']; }
			elseif($fmem['Rank'] == 7) { $fmem['Rank'] = $group['Rank7']; }
			elseif($fmem['Rank'] == 8) { $fmem['Rank'] = $group['Rank8']; }
			elseif($fmem['Rank'] == 9) { $fmem['Rank'] = $group['Rank9']; }
			elseif($fmem['Rank'] == "") { $fmem['Rank'] = "Undefined"; }
			if($fmem['Division'] == -1) { $fmem['Division'] = "G.D."; }
			elseif($fmem['Division'] == 0) { $fmem['Division'] = $group['Div1']; }
			elseif($fmem['Division'] == 1) { $fmem['Division'] = $group['Div2']; }
			elseif($fmem['Division'] == 2) { $fmem['Division'] = $group['Div3']; }
			elseif($fmem['Division'] == 3) { $fmem['Division'] = $group['Div4']; }
			elseif($fmem['Division'] == 4) { $fmem['Division'] = $group['Div5']; }
			elseif($fmem['Division'] == 5) { $fmem['Division'] = $group['Div6']; }
			elseif($fmem['Division'] == 6) { $fmem['Division'] = $group['Div7']; }
			elseif($fmem['Division'] == 7) { $fmem['Division'] = $group['Div8']; }
			elseif($fmem['Division'] == 8) { $fmem['Division'] = $group['Div9']; }

		print "
			<td>".FlagByIP($fmem['IP'])."</td>
			<td>$fmem[Rank]</td>
			<td>
		";
			if($fmem['Leader'] <> -1) { print "<span style='color:red;font-weight:bold'>(L)</span> "; }
			if($fmem['Online'] <> 0) { print "<span style='font-weight:bold'>$fmem[Username]</span>"; }
			elseif($fmem['Username'] == $inf['Username']) { print "<span style='font-style:italic'>$fmem[Username]</span>"; }
			elseif($fmem['Online'] == 0) { print "$fmem[Username]"; }
		print "
			</td>
			<td>$fmem[Division]</td>
			<td>".LastOnline($fmem['id'])."</td>
		";
			if($inf['Leader'] == $inf['Member']) { echo "<td>$remove</td>"; }
		print "
				</tr>
		";
		}
	?>
		</table>
	<div class="acp-actionbar" align='center'><span style='color:red;font-weight:bold'>(L)</span> - Leader</div>
<?php if($inf['Leader'] == $inf['Member']) { ?>
	<h3>Member Management</h3>
	<form method="POST" action="faction/proc.php">
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
			<tr class='tablerow1'>
				<td width='10%'>Name</td>
				<td width='30%'>
					<select name="uID">
						<?php $userquery = mysql_query("SELECT `id`, `Username` FROM `accounts` WHERE `Online` = 0 AND `AdminLevel` < 2 AND `Disabled` = 0 AND `Member` = $inf[Member] ORDER BY `Username` ASC");
						while ($user = mysql_fetch_array($userquery)) {
							echo "<option value='$user[id]'>$user[Username]</option>";
						} ?>
					</select>
				</td>
				<td width='10%'>Rank</td>
				<td width='30%'>
					<select name="rank">
						<?php
						echo "<option value='NULL'>Select Rank</option>";
						echo "<option value='0'>$group[Rank0]</option>";
						echo "<option value='1'>$group[Rank1]</option>";
						echo "<option value='2'>$group[Rank2]</option>";
						echo "<option value='3'>$group[Rank3]</option>";
						echo "<option value='4'>$group[Rank4]</option>";
						echo "<option value='5'>$group[Rank5]</option>";
						echo "<option value='6'>$group[Rank6]</option>";
						echo "<option value='7'>$group[Rank7]</option>";
						echo "<option value='8'>$group[Rank8]</option>";
						echo "<option value='9'>$group[Rank9]</option>";
						?>
					</select>
				</td>
				<td width='10%'>Division</td>
				<td width='30%'>
					<select name="div">
						<?php
						echo "<option value='NULL'>Select Division</option>";
						echo "<option value='-1'>G.D.</option>";
						if($group['Div1'] <> "") { echo "<option value='0'>$group[Div1]</option>"; }
						if($group['Div2'] <> "") { echo "<option value='1'>$group[Div2]</option>"; }
						if($group['Div3'] <> "") { echo "<option value='2'>$group[Div3]</option>"; }
						if($group['Div4'] <> "") { echo "<option value='3'>$group[Div4]</option>"; }
						if($group['Div5'] <> "") { echo "<option value='4'>$group[Div5]</option>"; }
						if($group['Div6'] <> "") { echo "<option value='5'>$group[Div6]</option>"; }
						if($group['Div7'] <> "") { echo "<option value='6'>$group[Div7]</option>"; }
						if($group['Div8'] <> "") { echo "<option value='7'>$group[Div8]</option>"; }
						if($group['Div9'] <> "") { echo "<option value='8'>$group[Div9]</option>"; }
						?>
					</select>
				</td>
				<td width='20%'>
					<input type="hidden" name="action" readonly="readonly" value="fac_adjust">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="submit" class="button" value="Adjust">
				</td>
			</tr>
		</table>
	</form>
<?php } ?>
</div>
</div>
<?php } ?>