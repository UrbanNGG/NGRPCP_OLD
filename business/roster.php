<div id='content_wrap'>
	<ol id='breadcrumb'><li>Business > Viewing Business Roster</li></ol>
	<div class='section_title'><h2>Business Employees</h2></div>
<div class='acp-box'>
	<?php
	$fmem1 = mysql_query("SELECT `id`, `Online`, `Username`, `UpdateDate`, `IP`, `BusinessRank` FROM `accounts` WHERE `AdminLevel` < '2' AND `Disabled` = '0' AND `Business` = '$inf[Business]' ORDER BY Rank DESC, Username ASC");
	$count = mysql_num_rows($fmem1);
	print "<h3>Employee List <span class='table_view'>Employees: ".$count."</span></h3>";
	print "		
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th width='5%'></th><th>Rank</th><th>Name</th><th>Last Active</th>";
			if($inf['BusinessRank'] >= $biz['MinInviteRank']) { echo "<th>Uninvite</th>"; }
	print "
		</tr>
	";
		while($fmem = mysql_fetch_array($fmem1)) {
		
		$remove = "
		<form method='POST' action='business/proc.php'>
		<input type='hidden' name='action' readonly='readonly' value='uninvite'>
		<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
		<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
		<input type='hidden' name='uID' readonly='readonly' value='$fmem[id]'>
		<input type='hidden' name='username' readonly='readonly' value='$fmem[Username]'>
		<input type='hidden' name='bizname' readonly='readonly' value='$biz[Name]'>
		<input type='image' src='../../global/images/all/icons/cross.png' alt='Remove'></form>
		";
		
		switch($fmem['BusinessRank'])
		{
			case 0: $rank = "Trainee";
				break;
			case 1: $rank = "Employee";
				break;
			case 2: $rank = "Senior Employee";
				break;
			case 3: $rank = "Manager";
				break;
			case 4: $rank = "Co-Owner";
				break;
			case 5: $rank = "Owner";
				break;
			default: $rank = "Undefined";
				break;
		}
		
		if (isset($i) && $i == 1) {
			print "<tr class='tablerow1'>";
		$i=0;
		} else { 
			print "<tr>";
		$i=1;
		}

		print "
			<td>".FlagByIP($fmem['IP'])."</td>
			<td>$rank</td>
			<td>
		";
			if($fmem['Online'] <> 0) { print "<span style='font-weight:bold'>$fmem[Username]</span>"; }
			elseif($fmem['Username'] == $inf['Username']) { print "<span style='font-style:italic'>$fmem[Username]</span>"; }
			elseif($fmem['Online'] == 0) { print "$fmem[Username]"; }
		print "
			</td>
			<td>".LastOnline($fmem['id'])."</td>
		";
			if($inf['BusinessRank'] >= $biz['MinInviteRank'] && $inf['BusinessRank'] > $fmem['BusinessRank']) { echo "<td>$remove</td>"; }
		print "
				</tr>
		";
		}
	?>
		</table>
	<div class="acp-actionbar"></div>
<?php if($inf['BusinessRank'] >= $biz['MinGiveRankRank']) { ?>
	<h3>Member Management</h3>
	<form method="POST" action="business/proc.php">
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
			<tr class='tablerow1'>
				<td width='10%'>Name</td>
				<td width='30%'>
					<select name="uID">
						<?php $userquery = mysql_query("SELECT `id`, `Username` FROM `accounts` WHERE `Online` = 0 AND `AdminLevel` < 2 AND `Disabled` = 0 AND `Business` = $inf[Business] AND `BusinessRank` < $inf[BusinessRank] ORDER BY `Username` ASC");
						while ($user = mysql_fetch_array($userquery)) {
							echo "<option value='$user[id]'>$user[Username]</option>";
						} ?>
					</select>
				</td>
				<td width='10%'>Rank</td>
				<td width='30%'>
					<select name="rank">
						<?php
						echo "<option value='0'>Trainee</option>";
						echo "<option value='1'>Employee</option>";
						echo "<option value='2'>Senior Employee</option>";
						echo "<option value='3'>Manager</option>";
						echo "<option value='4'>Co-Owner</option>";
						echo "<option value='5'>Owner</option>";
						?>
					</select>
				</td>
				<td width='20%'>
					<input type="hidden" name="action" readonly="readonly" value="adjust">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type='hidden' name='bizname' readonly='readonly' value='<?php echo $biz['Name']; ?>'>
					<input type="submit" class="button" value="Adjust">
				</td>
			</tr>
		</table>
	</form>
<?php } ?>
</div>
</div>