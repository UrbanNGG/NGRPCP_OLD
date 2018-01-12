<?php if($inf['AdminLevel'] >= 1337 || $inf['PR'] > 0)
{
	if(isset($_POST['action']) && $_POST['action'] == "edit" && isset($_POST['accountid']))
	{
		$auID = $_POST['accountid'];
		$userquery = mysql_query("SELECT * FROM `accounts` WHERE `id` = '$auID'");
		$uInf = mysql_fetch_array($userquery, MYSQL_ASSOC);
		$uaccessquery = mysql_query("SELECT * FROM `cp_access` WHERE `user_id` = '$auID'");
		$uaccess = mysql_fetch_array($uaccessquery, MYSQL_ASSOC);
		$statquery = mysql_query("SELECT * FROM `cp_stat` WHERE `user_id` = '$auID'");
		$ustat = mysql_fetch_array($statquery, MYSQL_ASSOC);
	}
	else { echo "No such user"; }
?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>User Management > View Users</li></ol>
	<div class='section_title'><h2>User Manager</h2></div>
	<div class='acp-box'>
<h3>Editing User Account #<?php echo $uInf['id'];?></h3>
<table class="double_pad" cellpadding="0" cellspacing="0" border="0" width="100%">
<form action="pr/proc.php" method="POST">
	<tr class="tablerow1"><td colspan="2">Username</td><td colspan="4"><?php echo $uInf['Username']; ?></td></tr>
	<tr><td colspan="2">Rank</td><td colspan="4">
		<select name="rank">
			<option value="0">Remove</option>
			<option value="2" <?php if($uInf['Helper'] == "2") { echo "selected"; } ?>>Community Advisor</option>
			<option value="3" <?php if($uInf['Helper'] == "3") { echo "selected"; } ?>>Senior Advisor</option>
			<option value="4" <?php if($uInf['Helper'] == "4") { echo "selected"; } ?>>Chief Advisor</option>
		</select>
	</td></tr>
	<tr class="tablerow1"><td colspan="2">Last Known IP</td><td colspan="4"><?php echo $uInf['IP']; ?></td></tr>
		<?php $diff = strtotime("now") - strtotime("$uInf[RegiDate]");
		$num = $diff/86400;
		$days = intval($num);
		?>
	<tr><td colspan="2">Date Added</td><td colspan="4"><?php echo $uInf['RegiDate']; ?> (<?php echo $days; ?> days ago)</td></tr>
	<tr class="tablerow1"><td colspan="2">Last Active</td><td colspan="4"><?php echo $uInf['UpdateDate']; ?></td></tr>
	<tr><td colspan="2">Total Points</td><td colspan="4"><input type="text" length="10" name="points" value="<?php if (isset($ustat['points'])) { echo $ustat['points']; } else { echo "0";} ?>"></td></tr>
	<tr><th colspan="6">Permissions</th></tr>
	<tr class="tablerow1"><td colspan="2">CP Access</td>
	<td colspan="4"><select name="cpv[]" size="3" multiple="multiple">
		<option value="punish" <?php if($uaccess['punish'] == "1") { echo "selected='selected'"; } ?>>View Punishments</option>
		<option value="refund" <?php if($uaccess['refund'] == "1") { echo "selected='selected'"; } ?>>View Refunds</option>
		<option value="ban" <?php if($uaccess['ban'] == "1") { echo "selected='selected'"; } ?>>View Bans</option>
	</select></td>
	</tr>
	<tr><td colspan="2">Game Log Access</td>
	<td colspan="4"><select name="gl[]" size="6" multiple="multiple">
		<option value="gladmin" <?php if($uaccess['gladmin'] == "1") { echo "selected='selected'"; } ?>>Admin</option>
		<option value="gladminauction" <?php if($uaccess['gladminauction'] == "1") { echo "selected='selected'"; } ?>>Admin Auction</option>
		<option value="gladmingive" <?php if($uaccess['gladmingive'] == "1") { echo "selected='selected'"; } ?>>Admin Give</option>
		<option value="gladminpay" <?php if($uaccess['gladminpay'] == "1") { echo "selected='selected'"; } ?>>Admin Pay</option>
		<option value="glauction" <?php if($uaccess['glauction'] == "1") { echo "selected='selected'"; } ?>>Auction</option>
		<option value="glban" <?php if($uaccess['glban'] == "1") { echo "selected='selected'"; } ?>>Ban</option>
		<option value="glbedit" <?php if($uaccess['glbedit'] == "1") { echo "selected='selected'"; } ?>>Business Edit</option>
		<option value="glbusiness" <?php if($uaccess['glbusiness'] == "1") { echo "selected='selected'"; } ?>>Business</option>
		<option value="glcontracts" <?php if($uaccess['glcontracts'] == "1") { echo "selected='selected'"; } ?>>Contracts</option>
		<option value="glcrime" <?php if($uaccess['glcrime'] == "1") { echo "selected='selected'"; } ?>>Crime</option>
		<option value="glddedit" <?php if($uaccess['glddedit'] == "1") { echo "selected='selected'"; } ?>>Dynamic Door Edit</option>
		<option value="gldealership" <?php if($uaccess['gldealership'] == "1") { echo "selected='selected'"; } ?>>Dealership</option>
		<option value="gldmpedit" <?php if($uaccess['gldmpedit'] == "1") { echo "selected='selected'"; } ?>>Dynamic Map Icon Edit</option>
		<option value="gldv" <?php if($uaccess['gldv'] == "1") { echo "selected='selected'"; } ?>>Dynamic Vehicle</option>
		<option value="gldvspawn" <?php if($uaccess['gldvspawn'] == "1") { echo "selected='selected'"; } ?>>Dynamic Vehicle Spawn</option>
		<option value="gleditgroup" <?php if($uaccess['gleditgroup'] == "1") { echo "selected='selected'"; } ?>>Edit Group</option>
		<option value="glfaction" <?php if($uaccess['glfaction'] == "1") { echo "selected='selected'"; } ?>>Faction</option>
		<option value="glfamily" <?php if($uaccess['glfamily'] == "1") { echo "selected='selected'"; } ?>>Family</option>
		<option value="glflagmove" <?php if($uaccess['glflagmove'] == "1") { echo "selected='selected'"; } ?>>Flag Move</option>
		<option value="glflags" <?php if($uaccess['glflags'] == "1") { echo "selected='selected'"; } ?>>Flags</option>
		<option value="glfmembercount" <?php if($uaccess['glfmembercount'] == "1") { echo "selected='selected'"; } ?>>Family Member Count</option>
		<option value="glgedit" <?php if($uaccess['glgedit'] == "1") { echo "selected='selected'"; } ?>>Gate Edit</option>
		<option value="glgifts" <?php if($uaccess['glgifts'] == "1") { echo "selected='selected'"; } ?>>Gifts</option>
		<option value="glgov" <?php if($uaccess['glgov'] == "1") { echo "selected='selected'"; } ?>>Government</option>
		<option value="glgroup" <?php if($uaccess['glgroup'] == "1") { echo "selected='selected'"; } ?>>Group</option>
		<option value="glhack" <?php if($uaccess['glhack'] == "1") { echo "selected='selected'"; } ?>>Hack</option>
		<option value="glhedit" <?php if($uaccess['glhedit'] == "1") { echo "selected='selected'"; } ?>>House Edit</option>
		<option value="glhouse" <?php if($uaccess['glhouse'] == "1") { echo "selected='selected'"; } ?>>House</option>
		<option value="glhsafe" <?php if($uaccess['glhsafe'] == "1") { echo "selected='selected'"; } ?>>House Safe</option>
		<option value="glkick" <?php if($uaccess['glkick'] == "1") { echo "selected='selected'"; } ?>>Kick</option>
		<option value="gllicenses" <?php if($uaccess['gllicenses'] == "1") { echo "selected='selected'"; } ?>>Licenses</option>
		<option value="glmail" <?php if($uaccess['glmail'] == "1") { echo "selected='selected'"; } ?>>Mail</option>
		<option value="glmoderator" <?php if($uaccess['glmoderator'] == "1") { echo "selected='selected'"; } ?>>Moderator</option>
		<option value="glmute" <?php if($uaccess['glmute'] == "1") { echo "selected='selected'"; } ?>>Mute</option>
		<option value="glpads" <?php if($uaccess['glpads'] == "1") { echo "selected='selected'"; } ?>>Priority Advertisements</option>
		<option value="glpassword" <?php if($uaccess['glpassword'] == "1") { echo "selected='selected'"; } ?>>Password</option>
		<option value="glpay" <?php if($uaccess['glpay'] == "1") { echo "selected='selected'"; } ?>>Pay</option>
		<option value="glplayervehicle" <?php if($uaccess['glplayervehicle'] == "1") { echo "selected='selected'"; } ?>>Player Vehicle</option>
		<option value="glrpspecial" <?php if($uaccess['glrpspecial'] == "1") { echo "selected='selected'"; } ?>>RP Special</option>
		<option value="glsecurity" <?php if($uaccess['glsecurity'] == "1") { echo "selected='selected'"; } ?>>Security</option>
		<option value="glsetvip" <?php if($uaccess['glsetvip'] == "1") { echo "selected='selected'"; } ?>>Set VIP</option>
		<option value="glshopconfirmedorders" <?php if($uaccess['glshopconfirmedorders'] == "1") { echo "selected='selected'"; } ?>>Shop Confirmed Orders</option>
		<option value="glshoplog" <?php if($uaccess['glshoplog'] == "1") { echo "selected='selected'"; } ?>>Shop</option>
		<option value="glshoporders" <?php if($uaccess['glshoporders'] == "1") { echo "selected='selected'"; } ?>>Shop Orders</option>
		<option value="glstats" <?php if($uaccess['glstats'] == "1") { echo "selected='selected'"; } ?>>Stats</option>
		<option value="gltledit" <?php if($uaccess['gltledit'] == "1") { echo "selected='selected'"; } ?>>Text Label Edit</option>
		<option value="gltoydelete" <?php if($uaccess['gltoydelete'] == "1") { echo "selected='selected'"; } ?>>Toy Delete</option>
		<option value="glundercover" <?php if($uaccess['glundercover'] == "1") { echo "selected='selected'"; } ?>>Undercover</option>
		<option value="glvipnamechanges" <?php if($uaccess['glvipnamechanges'] == "1") { echo "selected='selected'"; } ?>>VIP Name-Changes</option>
		<option value="glvipremove" <?php if($uaccess['glvipremove'] == "1") { echo "selected='selected'"; } ?>>VIP Remove</option>
	</select></td>
	</tr>
	<tr class="tablerow1"><td colspan="2">CP Log Access</td>
	<td colspan="4"><select name="cpl[]" size="4" multiple="multiple">
		<option value="cplgeneral" <?php if($uaccess['cplgeneral'] == "1") { echo "selected='selected'"; } ?>>General</option>
		<option value="cplstaff" <?php if($uaccess['cplstaff'] == "1") { echo "selected='selected'"; } ?>>Staff</option>
		<option value="cplfaction" <?php if($uaccess['cplfaction'] == "1") { echo "selected='selected'"; } ?>>Faction</option>
		<option value="cplfamily" <?php if($uaccess['cplfamily'] == "1") { echo "selected='selected'"; } ?>>Family</option>
		<option value="cplcr" <?php if($uaccess['cplcr'] == "1") { echo "selected='selected'"; } ?>>Customer Relations</option>
	</select></td>
	</tr>
	<tr class="acp-actionbar"><td colspan="6">
		<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
		<input type="hidden" name="accountid" readonly="readonly" value="<?php echo $uInf['id']; ?>">
		<input type="hidden" name="action" readonly="readonly" value="editadvisor">
		<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
		<input type="submit" class="button" value="Submit Changes">
	</td></tr>
</form>
</table>
<div class='section_title' style='padding-top:20px'>
<h2>Help Requests Count</h2></div>
	<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
		<tr><th>Date</th><th>Help Requests Total</th></tr>
		<?php
			$list = glob("//sa-mp/admins/catokens/".$uInf['Username']."[*");
				usort(
					$list,
					create_function('$a,$b', 'return filemtime($b) - filemtime($a);')
				);
			foreach ($list as $file) {
				$handle = fopen($file, "r");
				$contents = fread($handle, filesize($file));
				if (file_exists($file)) {
				$fmtime = filemtime($file);
				
				if(isset($i) && $i == 1) {
					print "<tr>";
				$i=0;
				} else { 
					print "<tr class='tablerow1'>";
				$i=1;
				}
				
				echo "<td>".date("Y/m/d  ", $fmtime)."</td>";
			}
				echo "<td> ".$contents."</td></tr>";
			}
		?>
	</table>
		<div class='acp-actionbar'></div>
	</div>
</div>
<?php
}
else { echo "You do not have access to this section."; } ?>