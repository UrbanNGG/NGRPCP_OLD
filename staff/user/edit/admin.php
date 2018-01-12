<?php if($inf['AdminLevel'] > 4 || $inf['HR'] > 0) {
if(isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['uID'])) { $auID = $_POST['uID'];
$userquery = mysql_query("SELECT * FROM `accounts` WHERE `id` = '$auID'");
$uInf = mysql_fetch_array($userquery, MYSQL_ASSOC);
$uaccessquery = mysql_query("SELECT * FROM `cp_access` WHERE `user_id` = '$auID'");
$uaccess = mysql_fetch_array($uaccessquery, MYSQL_ASSOC);
$statquery = mysql_query("SELECT * FROM `cp_stat` WHERE `user_id` = '$auID'");
$ustat = mysql_fetch_array($statquery, MYSQL_ASSOC);

}
else { echo "No such user"; }
?>
<h3>Editing User Account #<?php echo $uInf['id'];?></h3>
<table class="double_pad" cellpadding="0" cellspacing="0" border="0" width="100%">
<?php if($inf['AdminLevel'] > 4) { ?><form action="user/proc.php" method="POST"><?php } ?>
	<tr class="tablerow1"><td colspan="2">Username</td><td colspan="4"><input type="text" size="30" length="64" name="user" value="<?php echo $uInf['Username']; ?>"></td></tr>
	<?php if($inf['AdminLevel'] == 99999 || $inf['AP'] > 0 || $inf['HR'] > 2) { ?><tr><td colspan="2">Password</td><td colspan="4"><input type="password" size="30" length="255" name="pass" value=""></td></tr><?php } ?>
	<tr class="tablerow1"><td colspan="2">Rank</td><td colspan="4">
		<select name="rank">
			<option value="2" <?php if($uInf['AdminLevel'] == 2) echo "selected"; ?>>Junior Administrator</option>
			<option value="3" <?php if($uInf['AdminLevel'] == 3) echo "selected"; ?>>General Administrator</option>
			<option value="4" <?php if($uInf['AdminLevel'] == 4) echo "selected"; ?>>Senior Administrator</option>
			<option value="1337" <?php if($uInf['AdminLevel'] == 1337) echo "selected"; ?>>Head Administrator</option>
			<?php if($inf['AdminLevel'] > 1337) { ?><option value="1338" <?php if($uInf['AdminLevel'] == 1338) echo "selected"; ?>>Lead Head Administrator</option><?php } ?>
			<?php if($inf['AdminLevel'] == 99999) { ?><option value="99999" <?php if($uInf['AdminLevel'] == 99999) echo "selected"; ?>>Executive Administrator</option><?php } ?>
		</select>
	</td></tr>
	<tr><td colspan="2">Type</td><td colspan="4">
		<select name="type">
			<option value="0" <?php if($uInf['AdminType'] == 0) echo "selected"; ?>>Regular</option>
			<option value="1" <?php if($uInf['AdminType'] == 1) echo "selected"; ?>>Non-Gaming</option>
			<option value="2" <?php if($uInf['AdminType'] == 2) echo "selected"; ?>>Unassigned</option>
			<option value="3" <?php if($uInf['AdminType'] == 3) echo "selected"; ?>>Shift</option>
		</select>
	</td></tr>
	<tr class="tablerow1"><td colspan="2">Whitelisted IP</td><td colspan="4"><input type="text" size="30" length="15" name="secureip" value="<?php echo $uInf['SecureIP']; ?>"></td></tr>
	<tr><td colspan="2">Last Known IP</td><td colspan="4"><?php echo $uInf['IP']; ?></td></tr>
		<?php $diff = strtotime("now") - strtotime("$uInf[RegiDate]");
		$num = $diff/86400;
		$days = intval($num);
		?>
	<tr class="tablerow1"><td colspan="2">Date Added</td><td colspan="4"><?php echo $uInf['RegiDate']; ?> (<?php echo $days; ?> days ago)</td></tr>
	<tr><td colspan="2">Shift Restrictions</td>
	<td colspan="4">
		<select name="shift_restrict[]" size="3" multiple>
		<?php
			$shift = unserialize($ustat['shift_restrict']);
			$shiftquery = mysql_query("SELECT * FROM `cp_shift_blocks` WHERE `type` = '1' ORDER BY shift_id ASC");
			while($shiftassign = mysql_fetch_array($shiftquery))
			{
				if(in_array($shiftassign['shift_id'], $shift)) echo "<option value='".$shiftassign['shift_id']."' selected>".$shiftassign['shift']."</option>";
				else echo "<option value='".$shiftassign['shift_id']."'>".$shiftassign['shift']."</option>";
			}
		?>
		</select>
	</td>
	</tr>
	<tr class="tablerow1"><td colspan="2">Shifts Completed</td><td colspan="4"><?php echo $ustat['shift_complete']; ?></td></tr>
	<tr><td colspan="2">Shifts Partially Completed</td><td colspan="4"><?php echo $ustat['shift_partcomplete']; ?></td></tr>
	<tr class="tablerow1"><td colspan="2">Shifts Missed</td><td colspan="4"><?php echo $ustat['shift_missed']; ?></td></tr>
	<tr><td colspan="2">Total Points</td><td colspan="4"><input type="text" length="10" name="points" value="<?php if (isset($ustat['points'])) { echo $ustat['points']; } else { echo "0";} ?>"></td></tr>
		<tr><th colspan="6">Permissions</th></tr>
		<tr><td colspan="2">CP Access</td>
		<td colspan="4"><select name="cpv[]" size="3" multiple="multiple">
			<option value="punish" <?php if($uaccess['punish'] == 1) echo "selected='selected'"; ?>>Punishments</option>
			<option value="refund" <?php if($uaccess['refund'] == 1) echo "selected='selected'"; ?>>Refunds</option>
			<option value="ban" <?php if($uaccess['ban'] == 1) echo "selected='selected'"; ?>>Bans</option>
			<option value="tech" <?php if($uaccess['tech'] == 1) echo "selected='selected'"; ?>>Technology</option>
		</select></td>
		</tr>
		<tr class="tablerow1"><td colspan="2">Game Log Access</td>
		<td colspan="4"><select name="gl[]" size="10" multiple="multiple">
			<option value="gladmin" <?php if($uaccess['gladmin'] == 1) echo "selected='selected'"; ?>>Admin</option>
			<option value="gladminauction" <?php if($uaccess['gladminauction'] == 1) echo "selected='selected'"; ?>>Admin Auction</option>
			<option value="gladmingive" <?php if($uaccess['gladmingive'] == 1) echo "selected='selected'"; ?>>Admin Give</option>
			<option value="gladminpay" <?php if($uaccess['gladminpay'] == 1) echo "selected='selected'"; ?>>Admin Pay</option>
			<option value="glauction" <?php if($uaccess['glauction'] == 1) echo "selected='selected'"; ?>>Auction</option>
			<option value="glban" <?php if($uaccess['glban'] == 1) echo "selected='selected'"; ?>>Ban</option>
			<option value="glbedit" <?php if($uaccess['glbedit'] == 1) echo "selected='selected'"; ?>>Business Edit</option>
			<option value="glbusiness" <?php if($uaccess['glbusiness'] == 1) echo "selected='selected'"; ?>>Business</option>
			<option value="glcredits" <?php if($uaccess['glcredits'] == 1) echo "selected='selected'"; ?>>Credits</option>
			<option value="glcontracts" <?php if($uaccess['glcontracts'] == 1) echo "selected='selected'"; ?>>Contracts</option>
			<option value="glcrime" <?php if($uaccess['glcrime'] == 1) echo "selected='selected'"; ?>>Crime</option>
			<option value="glddedit" <?php if($uaccess['glddedit'] == 1) echo "selected='selected'"; ?>>Dynamic Door Edit</option>
			<option value="gldealership" <?php if($uaccess['gldealership'] == 1) echo "selected='selected'"; ?>>Dealership</option>
			<option value="gldmpedit" <?php if($uaccess['gldmpedit'] == 1) echo "selected='selected'"; ?>>Dynamic Map Icon Edit</option>
			<option value="gldv" <?php if($uaccess['gldv'] == 1) echo "selected='selected'"; ?>>Dynamic Vehicle</option>
			<option value="gldvspawn" <?php if($uaccess['gldvspawn'] == 1) echo "selected='selected'"; ?>>Dynamic Vehicle Spawn</option>
			<option value="gleditgroup" <?php if($uaccess['gleditgroup'] == 1) echo "selected='selected'"; ?>>Edit Group</option>
			<option value="glfaction" <?php if($uaccess['glfaction'] == 1) echo "selected='selected'"; ?>>Faction</option>
			<option value="glfamily" <?php if($uaccess['glfamily'] == 1) echo "selected='selected'"; ?>>Family</option>
			<option value="glflagmove" <?php if($uaccess['glflagmove'] == 1) echo "selected='selected'"; ?>>Flag Move</option>
			<option value="glflags" <?php if($uaccess['glflags'] == 1) echo "selected='selected'"; ?>>Flags</option>
			<option value="glfmembercount" <?php if($uaccess['glfmembercount'] == 1) echo "selected='selected'"; ?>>Family Member Count</option>
			<option value="glgedit" <?php if($uaccess['glgedit'] == 1) echo "selected='selected'"; ?>>Gate Edit</option>
			<option value="glgifts" <?php if($uaccess['glgifts'] == 1) echo "selected='selected'"; ?>>Gifts</option>
			<option value="glgov" <?php if($uaccess['glgov'] == 1) echo "selected='selected'"; ?>>Government</option>
			<option value="glgroup" <?php if($uaccess['glgroup'] == 1) echo "selected='selected'"; ?>>Group</option>
			<option value="glhack" <?php if($uaccess['glhack'] == 1) echo "selected='selected'"; ?>>Hack</option>
			<option value="glhedit" <?php if($uaccess['glhedit'] == 1) echo "selected='selected'"; ?>>House Edit</option>
			<option value="glhouse" <?php if($uaccess['glhouse'] == 1) echo "selected='selected'"; ?>>House</option>
			<option value="glhsafe" <?php if($uaccess['glhsafe'] == 1) echo "selected='selected'"; ?>>House Safe</option>
			<option value="glkick" <?php if($uaccess['glkick'] == 1) echo "selected='selected'"; ?>>Kick</option>
			<option value="gllicenses" <?php if($uaccess['gllicenses'] == 1) echo "selected='selected'"; ?>>Licenses</option>
			<option value="gllogincredits" <?php if($uaccess['gllogincredits'] == 1) echo "selected='selected'"; ?>>Login Credits</option>
			<option value="glmail" <?php if($uaccess['glmail'] == 1) echo "selected='selected'"; ?>>Mail</option>
			<option value="glmoderator" <?php if($uaccess['glmoderator'] == 1) echo "selected='selected'"; ?>>Moderator</option>
			<option value="glmute" <?php if($uaccess['glmute'] == 1) echo "selected='selected'"; ?>>Mute</option>
			<option value="glpads" <?php if($uaccess['glpads'] == 1) echo "selected='selected'"; ?>>Priority Advertisements</option>
			<option value="glpassword" <?php if($uaccess['glpassword'] == 1) echo "selected='selected'"; ?>>Password</option>
			<option value="glpay" <?php if($uaccess['glpay'] == 1) echo "selected='selected'"; ?>>Pay</option>
			<option value="glplant" <?php if($uaccess['glplant'] == 1) echo "selected='selected'"; ?>>Plant</option>
			<option value="glplayervehicle" <?php if($uaccess['glplayervehicle'] == 1) echo "selected='selected'"; ?>>Player Vehicle</option>
			<option value="glpnsedit" <?php if($uaccess['glpnsedit'] == 1) echo "selected='selected'"; ?>>Pay N' Spray Edit</option>
			<option value="glpoker" <?php if($uaccess['glpoker'] == 1) echo "selected='selected'"; ?>>Poker</option>
			<option value="glrpspecial" <?php if($uaccess['glrpspecial'] == 1) echo "selected='selected'"; ?>>RP Special</option>
			<option value="glsecurity" <?php if($uaccess['glsecurity'] == 1) echo "selected='selected'"; ?>>Security</option>
			<option value="glsellcredits" <?php if($uaccess['glsellcredits'] == 1) echo "selected='selected'"; ?>>Sell Credits</option>
			<option value="glsetvip" <?php if($uaccess['glsetvip'] == 1) echo "selected='selected'"; ?>>Set VIP</option>
			<option value="glshopconfirmedorders" <?php if($uaccess['glshopconfirmedorders'] == 1) echo "selected='selected'"; ?>>Shop Confirmed Orders</option>
			<option value="glshoplog" <?php if($uaccess['glshoplog'] == 1) echo "selected='selected'"; ?>>Shop</option>
			<option value="glshoporders" <?php if($uaccess['glshoporders'] == 1) echo "selected='selected'"; ?>>Shop Orders</option>
			<option value="glsobeit" <?php if($uaccess['glsobeit'] == 1) echo "selected='selected'"; ?>>Sobeit</option>
			<option value="glspeedcam" <?php if($uaccess['glspeedcam'] == 1) echo "selected='selected'"; ?>>Speedcam</option>
			<option value="glstats" <?php if($uaccess['glstats'] == 1) echo "selected='selected'"; ?>>Stats</option>
			<option value="gltledit" <?php if($uaccess['gltledit'] == 1) echo "selected='selected'"; ?>>Text Label Edit</option>
			<option value="gltoydelete" <?php if($uaccess['gltoydelete'] == 1) echo "selected='selected'"; ?>>Toy Delete</option>
			<option value="gltoys" <?php if($uaccess['gltoys'] == 1) echo "selected='selected'"; ?>>Toys</option>
			<option value="glundercover" <?php if($uaccess['glundercover'] == 1) echo "selected='selected'"; ?>>Undercover</option>
			<option value="glvipnamechanges" <?php if($uaccess['glvipnamechanges'] == 1) echo "selected='selected'"; ?>>VIP Name-Changes</option>
			<option value="glvipremove" <?php if($uaccess['glvipremove'] == 1) echo "selected='selected'"; ?>>VIP Remove</option>
		</select></td>
		</tr>
		<tr><td colspan="2">CP Log Access</td>
		<td colspan="4"><select name="cpl[]" size="4" multiple="multiple">
			<option value="cplgeneral" <?php if($uaccess['cplgeneral'] == 1) echo "selected='selected'"; ?>>General</option>
			<option value="cplstaff" <?php if($uaccess['cplstaff'] == 1) echo "selected='selected'"; ?>>Staff</option>
			<option value="cplfaction" <?php if($uaccess['cplfaction'] == 1) echo "selected='selected'"; ?>>Faction</option>
			<option value="cplfamily" <?php if($uaccess['cplfamily'] == 1) echo "selected='selected'"; ?>>Family</option>
			<option value="cplcr" <?php if($uaccess['cplcr'] == 1) echo "selected='selected'"; ?>>Customer Relations</option>
		</select></td>
		</tr>
	<?php if($inf['AdminLevel'] > 4 || $inf['AP'] > 0) { ?>
	<tr class="acp-actionbar"><td colspan="6">
		<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
		<input type="hidden" name="uID" readonly="readonly" value="<?php echo $_POST['uID']; ?>">
		<input type="hidden" name="action" readonly="readonly" value="edituser">
		<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
		<input type="submit" class="button" value="Submit Changes">
	</td></tr>
	</form>
	<?php } ?>
</table>
<div class='section_title' style='padding-top:20px'><h2>Report Count & Shifts</h2></div>
	<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
		<tr><th>Date</th><th>Report Count</th><th>Shifts</th></tr>
		<?php
			$shiftquery = mysql_query("SELECT `shift_id`, `status`, `bonus`, `date`, WEEK(`date`) AS shift_week FROM `cp_shifts` WHERE `user_id` = $uInf[id] AND `date` <= NOW() ORDER BY `date` DESC, `shift_id` ASC");
			$curDate = "";
			$curWeek = "";
			while($shift = mysql_fetch_array($shiftquery))
			{
				switch($shift['bonus'])
				{
					default: $shift_bonus = ""; break;
					case 1: $shift_bonus = "<img src='/global/images/star_silver.png' alt='Shift Assist' />"; break;
					case 2: $shift_bonus = "<img src='/global/images/star_gold.png' alt='Early Sign-up Bonus' />"; break;
				}
				switch($shift['status'])
				{
					case 1: $shift_status = $shift_bonus."<span style='color:silver'><strike>Self-Removed</strike></span>"; break;
					case 2: $shift_status = $shift_bonus."Pending"; break;
					case 3: $shift_status = $shift_bonus."<span style='color:green'>Completed</span>"; break;
					case 4: $shift_status = $shift_bonus."<span style='color:darkorange'>Partially Completed</span>"; break;
					case 5: $shift_status = $shift_bonus."<span style='color:red'>Missed</span>"; break;
				}
				if($shift['date'] != $curDate)
				{
					$reportcountquery = mysql_query("SELECT `hour`, `count`, SUM(count) AS report_count FROM `tokens_report` WHERE `playerid` = $uInf[id] AND `date` = '$shift[date]'");
					$sum = mysql_fetch_array($reportcountquery);
					if($shift['shift_week'] != $curWeek)
					{
						$scweekquery = mysql_query("SELECT COUNT(id) AS shift_count, SUM(bonus) AS shift_bonus FROM `cp_shifts` WHERE `user_id` = $uInf[id] AND `status` = 3 AND WEEK(date) = $shift[shift_week]");
						$scweek = mysql_fetch_array($scweekquery);
						$scweeksubquery = mysql_query("SELECT COUNT(id) AS shift_count FROM `cp_shifts` WHERE `user_id` = $uInf[id] AND `status` = 5 AND `bonus` = 0 AND WEEK(date) = $shift[shift_week]");
						$scweeksub = mysql_fetch_array($scweeksubquery);
						$scweekbonussubquery = mysql_query("SELECT COUNT(id) AS shift_count FROM `cp_shifts` WHERE `user_id` = $uInf[id] AND `status` = 5 AND `bonus` = 2 AND WEEK(date) = $shift[shift_week]");
						$scweekbonussub = mysql_fetch_array($scweekbonussubquery);
						$shiftpoints = $scweek['shift_count'] + $scweek['shift_bonus'];
						if($scweekbonussub['shift_count'] > 0) $shiftpoints -= $scweekbonussub['shift_count'] * 2;
						if($scweeksub['shift_count'] > 0) $shiftpoints -= $scweeksub['shift_count'];
						echo "<tr><th colspan='3'>Week $shift[shift_week] - Shift Points: $shiftpoints</th></tr>";
					}
					if(isset($i) && $i == 1)
					{
						print "<tr>";
						$i=0;
					}
					else
					{
						print "<tr class='tablerow1'>";
						$i=1;
					}

					echo "<td>$shift[date]</td><td>$sum[report_count]</td><td>";
					$curDate = $shift['date'];
				}
				$curWeek = $shift['shift_week'];
				echo GetShiftName($shift['shift_id'])." - $shift_status<br />";
			}
			echo "</td></tr>";
		?>
	</table>
<div class='section_title' style='padding-top:20px'><h2>User Notes</h2></div>
	<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
		<tr><th>Date</th><th>Type</th><th>Details</th><th>Added By</th></td><th>Points</th></tr>
<?php $note1 = mysql_query("SELECT * FROM `cp_admin_notes` WHERE `user_id` = '$uInf[id]' ORDER BY date DESC");
while ($note = mysql_fetch_array($note1)) {

if($note['type'] == 1) { $note['type'] = "Infraction"; }
if($note['type'] == 2) { $note['type'] = "Commendation"; }

	if(isset($i) && $i == 1) {
		print "<tr class='tablerow1'>";
	$i=0;
	} else { 
		print "<tr>";
	$i=1;
	}

print "
<tr>
<td>$note[date]</td>
<td>$note[type]</td>
<td>$note[details]</td>
<td>".GetName($note['invoke_id'])."</td>
<td>$note[points]</td>
</tr>
";
}
print "</table>";
}
else { echo "You do not have access to this section."; } ?>