<div id='content_wrap'>
	<ol id='breadcrumb'><li>Dashboard > Viewing Gang Roster</li></ol>
	<div class='section_title'><h2>Gang Members</h2></div>
<div class='acp-box'>
	<?php
	$fmem1 = mysql_query("SELECT `id`, `Online`, `Username`, `UpdateDate`, `IP`, `Division`, `Rank` FROM `accounts` WHERE `AdminLevel` < '2' AND `Disabled` = '0' AND `FMember` = '$inf[FMember]' ORDER BY Rank DESC, Username ASC");
	$count = mysql_num_rows($fmem1);
	print "
		<h3>Gang Member List <span class='table_view'>Members: ".$count."</span></h3>";
		
			if(isset($_GET['note']) && $_GET['note'] == 0) { echo "<div class='acp-error'>You cannot uninvite the leader of a gang.</div>"; }
			if(isset($_GET['note']) && $_GET['note'] == 1) { echo "<div class='acp-error'>That player is currently in-game. Please remove them in-game or try again later.</div>"; }
			if(isset($_GET['note']) && $_GET['note'] == 2) { echo "<div class='acp-message'>Uninvited successfully!</div>"; }
			
	print "
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th width='5%'></th><th>Rank</th><th>Division</th><th>Player</th><th>Last Active</th>";
			if($inf['Rank'] > 4) { echo "<th>Uninvite</th>"; }
	print "
		</tr>
	";
		while ($fmem = mysql_fetch_array($fmem1))
		{
			$remove = "
			<form method='POST' action='gang/proc.php'>
			<input type='hidden' name='action' readonly='readonly' value='uninvite'>
			<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
			<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
			<input type='hidden' name='uID' readonly='readonly' value='$fmem[id]'>
			<input type='hidden' name='username' readonly='readonly' value='$fmem[Username]'>
			<input type='hidden' name='famname' readonly='readonly' value='$gang[Name]'>
			<input type='image' src='../../global/images/all/icons/cross.png' alt='Remove'></form>
			";
			
			if (isset($i) && $i == 1) {
				print "<tr class='tablerow1'>";
			$i=0;
			} else { 
				print "<tr>";
			$i=1;
			}
			
			switch($fmem['Rank'])
			{
				case 0: $fmem['Rank'] = $gang['Rank0']; break;
				case 1: $fmem['Rank'] = $gang['Rank1']; break;
				case 2: $fmem['Rank'] = $gang['Rank2']; break;
				case 3: $fmem['Rank'] = $gang['Rank3']; break;
				case 4: $fmem['Rank'] = $gang['Rank4']; break;
				case 5: $fmem['Rank'] = $gang['Rank5']; break;
				case 6: $fmem['Rank'] = $gang['Rank6']; break;
			}
			
			switch($fmem['Division'])
			{
				case -1: $fmem['Division'] = "None"; break;
				case 0: $fmem['Division'] = $gang['Division0']; break;
				case 1: $fmem['Division'] = $gang['Division1']; break;
				case 2: $fmem['Division'] = $gang['Division2']; break;
				case 3: $fmem['Division'] = $gang['Division3']; break;
				case 4: $fmem['Division'] = $gang['Division4']; break;
			}

			print "
			<td>".FlagByIP($fmem['IP'])."</td>
			<td>$fmem[Rank]</td>
			<td>$fmem[Division]</td>
			<td>
			";
			if($gang['Leader'] == $fmem['Username']) { print "<span style='color:red;font-weight:bold'>(L)</span> "; }
			if($fmem['Online'] <> 0) { print "<span style='font-weight:bold'>$fmem[Username]</span>"; }
			elseif($fmem['Username'] == $inf['Username']) { print "<span style='font-style:italic'>$fmem[Username]</span>"; }
			elseif($fmem['Online'] == 0) { print "$fmem[Username]"; }
			print "
				</td>
				<td>".LastOnline($fmem['id'])."</td>
			";
			if($inf['Rank'] > 4) { echo "<td>$remove</td>"; }
			print "
				</tr>
				";
		}
	?>
		</table>
	<div class="acp-actionbar" align='center'><span style='color:red;font-weight:bold'>(L)</span> - Leader</div>
<?php if($inf['Rank'] > 4) { ?>
	<h3>Change Rank</h3>
	<form method="POST" action="gang/proc.php">
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
			<tr class='tablerow1'>
				<td width='10%'>Name</td>
				<td width='20%'>
					<select name="uID" id="uID">
						<?php $userquery = mysql_query("SELECT `id`, `Username` FROM `accounts` WHERE `Online` = 0 AND `AdminLevel` < 2 AND `Disabled` = 0 AND `FMember` = '$inf[FMember]' ORDER BY `Username` ASC");
						while ($user = mysql_fetch_array($userquery)) {
							echo "<option value='$user[id]'>$user[Username]</option>";
						} ?>
					</select>
				</td>
				<td width='10%'>Rank</td>
				<td width='20%'>
					<select name="rank" id="rank">
						<?php
						echo "<option value='NULL'>Select Rank</option>";
						echo "<option value='0'>$gang[Rank0]</option>";
						echo "<option value='1'>$gang[Rank1]</option>";
						echo "<option value='2'>$gang[Rank2]</option>";
						echo "<option value='3'>$gang[Rank3]</option>";
						echo "<option value='4'>$gang[Rank4]</option>";
						echo "<option value='5'>$gang[Rank5]</option>";
						echo "<option value='6'>$gang[Rank6]</option>";
						?>
					</select>
				</td>
				<td width='10%'>Division</td>
				<td width='20%'>
					<select name="div" id="div">
						<?php
						echo "<option value='NULL'>Select Division</option>";
						echo "<option value='-1'>Remove Division</option>";
						echo "<option value='0'>$gang[Division0]</option>";
						echo "<option value='1'>$gang[Division1]</option>";
						echo "<option value='2'>$gang[Division2]</option>";
						echo "<option value='3'>$gang[Division3]</option>";
						echo "<option value='4'>$gang[Division4]</option>";
						?>
					</select>
				</td>
				<td width='20%'>
					<input type="hidden" name="action" readonly="readonly" value="fam_rank">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="submit" class="button" value="Adjust Rank/Division">
				</td>
			</tr>
		</table>
	</form>
<?php } ?>
</div>
</div>