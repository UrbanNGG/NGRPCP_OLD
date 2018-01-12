<?php if(!isset($_GET['id']) && !isset($_GET['new']) && !isset($_GET['send'])) { ?>
<div id='content_wrap'>
	<ol id='breadcrumb'>
		<li>Mass Email Players &raquo; View</li>
	</ol>
	<div class='section_title'>
		<h2>Mass Email Players</h2>
	</div>
	<?php if(isset($msg)) { echo "<div class='acp-message'>".$msg."</div>"; } ?>
	<div class='acp-box'>
	<h3>Previous Messages</h3>
	<?php $query = mysql_query("SELECT * FROM `cp_mass_email`"); ?>
	<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
		<tr><th>ID</th><th>Subject</th><th>Created By</th><th>Created On</th><th>Last Sent</th><th>Action</th></tr>
		<?php
		while($array = mysql_fetch_array($query))
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
		?>
			<td width='10%'><?php echo $array['id']; ?></td>
			<td width='10%'><?php echo $array['subject']; ?></td>
			<td width='10%'><?php echo GetName($array['creator']); ?></td>
			<td width='10%'><?php echo $array['create_date']; ?></td>
			<td width='10%'><?php if(is_null($array['last_sent'])) echo "Never"; else echo $array['last_sent']; ?></td>
			<td width='10%'><a href='/staff/user.php?p=email&id=<?php echo $array['id']; ?>' class='button'>Edit</a> <a href='/staff/user.php?p=email&send=<?php echo $array['id']; ?>' class='button'><?php if(is_null($array['last_sent'])) echo "Send"; else echo "Resend"; ?></a></td>
			</tr>
		<?php } ?>
		<tr class='acp-actionbar'>
			<td colspan="6"><a href='/staff/user.php?p=email&new=note<?php echo $array['id']; ?>' class='button'>Create New Message</a></td>
		</tr>
	</table>
	</div>
</div>
<?php
}
if(isset($_GET['send']) && !isset($_GET['new']))
{
	$id = strval($_GET['send']);
	if(!is_numeric($id))
	{
		echo '<meta http-equiv="refresh" content="0;url=user.php?p=email">';
		exit;
	}
	$query = mysql_query("SELECT * FROM `cp_mass_email` WHERE `id` = $id");
	$array = mysql_fetch_array($query);
	$userquery = mysql_query(GetMassEmailRecepients($id));
	$i = 0;
	while($userarray = mysql_fetch_array($userquery))
	{
		if(filter_var($userarray['Email'], FILTER_VALIDATE_EMAIL))
		{
			$user[$i] = "<a title='".$userarray['Email']."'>".$userarray['Username']."</a>";
			$i += 1;
		}
	}
?>
<div id='content_wrap'>
	<ol id='breadcrumb'>
		<li>Mass Email Players &raquo; Send</li>
	</ol>
	<div class='section_title'>
		<h2>Send Message</h2>
	</div>
	<?php if(isset($msg)) { echo "<div class='acp-message'>".$msg."</div>"; } ?>
	<div class='acp-box'>
	<h3>Are you sure you would like to send the following message?</h3>
	<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
		<tr><th colspan='2'><?php echo $array['subject']; ?></th></tr>
		<tr><td colspan='2'><?php echo $array['message']; ?></td></tr>
		<tr class='tablerow1'><td colspan='2'>This email will be sent to <?php echo number_format($i); ?> players, including:<br /><br /><?php echo implode(", ", $user); ?></td></tr>
		<tr class='acp-actionbar'>
			<td style='width:50%'><form method="POST" action="user/proc.php">
				<input type='hidden' name='action' value='send_email'>
				<input type="hidden" name="id" readonly="readonly" value="<?php echo $id; ?>">
				<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
				<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
				<input type='submit' value='Confirm' class='button'>
			</form></td>
			<td style='width:50%'><a href='/staff/user.php?p=email' class='button'>Cancel</a></td>
		</tr>
	</table>
	</div>
</div>
<?php }
if(isset($_GET['id']) && !isset($_GET['new']))
{
	$id = strval($_GET['id']);
	if(!is_numeric($id))
	{
		echo '<meta http-equiv="refresh" content="0;url=user.php?p=email">';
		exit;
	}
	$query = mysql_query("SELECT * FROM `cp_mass_email` WHERE `id` = $id");
	$array = mysql_fetch_array($query);
	$admins = unserialize($array['admins']);
	$helpers = unserialize($array['helpers']);
	$vip = unserialize($array['vip']);
	$famed = unserialize($array['famed']);
	$faction = unserialize($array['faction']);
	$faction_rank = unserialize($array['faction_rank']);
	$gang = unserialize($array['gang']);
	$gang_rank = unserialize($array['gang_rank']);
	$biz = unserialize($array['biz']);
	$biz_rank = unserialize($array['biz_rank']);
?>
	<div id='content_wrap'>
		<ol id='breadcrumb'>
			<li>Mass Email Players &raquo; Edit</li>
		</ol>
		<div class='section_title'>
			<h2>Viewing Email #<?php echo $id; ?></h2>
		</div>
		<?php if(isset($msg)) { echo "<div class='acp-message'>".$msg."</div>"; } ?>
		<div class='acp-box'>
		<h3>Edit Message</h3>
		<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
			<form method="POST" action="user/proc.php">
				<tr class='tablerow1'>
					<td>Subject</td>
					<td><input type="text" name="subject" value="<?php echo $array['subject']; ?>" size="50" maxlength="255"></td>
				</tr>
				<tr>
					<td>Message</td>
					<td><textarea rows='6' cols='50' name='message'><?php echo $array['message']; ?></textarea></td>
				</tr>
				<tr class='tablerow1'>
					<td>Creator</td>
					<td><?php echo GetName($array['creator']); ?></td>
				</tr>
				<tr>
					<td>Created On</td>
					<td><?php echo $array['create_date']; ?></td>
				</tr>
				<tr class='tablerow1'>
					<td>Last Updated</td>
					<td><?php if(is_null($array['update_date'])) echo "Never"; else echo $array['update_date']; ?></td>
				</tr>
				<tr>
					<td>Last Sent</td>
					<td><?php if(is_null($array['last_sent'])) echo "Never"; else echo $array['last_sent']; ?></td>
				</tr>
				<tr class='tablerow1'>
				<td>Send to Banned Accounts</td>
				<td><input type="checkbox" name="banned" value="1" <?php if($array['banned'] == 1) echo 'checked="checked"'; ?> /></td>
				</tr>
				<tr>
					<td>Send to Disabled Accounts</td>
					<td><input type="checkbox" name="disabled" value="1" <?php if($array['disabled'] == 1) echo 'checked="checked"'; ?> /></td>
				</tr>
				<tr class='tablerow1'>
					<td>Admin Level</td>
					<td><select name="admins[]" size="5" multiple>
						<option value='1' <?php if($admins != 0 && in_array(1, $admins)) echo "selected"; ?>>Server Moderators</option>
						<option value='1.5' <?php if($admins != 0 && in_array(1.5, $admins)) echo "selected"; ?>>Senior Moderators</option>
						<option value='2' <?php if($admins != 0 && in_array(2, $admins)) echo "selected"; ?>>Junior Administrators</option>
						<option value='3' <?php if($admins != 0 && in_array(3, $admins)) echo "selected"; ?>>General Administrators</option>
						<option value='4' <?php if($admins != 0 && in_array(4, $admins)) echo "selected"; ?>>Senior Administrators</option>
						<option value='1337' <?php if($admins != 0 && in_array(1337, $admins)) echo "selected"; ?>>Head Administrators</option>
						<option value='1338' <?php if($admins != 0 && in_array(1338, $admins)) echo "selected"; ?>>Lead Head Administrators</option>
						<option value='99999' <?php if($admins != 0 && in_array(99999, $admins)) echo "selected"; ?>>Executive Administrators</option>
					</select></td>
				</tr>
				<tr>
					<td>Helper Level</td>
					<td><select name="helpers[]" size="4" multiple>
						<option value='1' <?php if($helpers != 0 && in_array(1, $helpers)) echo "selected"; ?>>Community Helpers</option>
						<option value='2' <?php if($helpers != 0 && in_array(2, $helpers)) echo "selected"; ?>>Community Advisors</option>
						<option value='3' <?php if($helpers != 0 && in_array(3, $helpers)) echo "selected"; ?>>Senior Advisors</option>
						<option value='4' <?php if($helpers != 0 && in_array(4, $helpers)) echo "selected"; ?>>Chief Advisor</option>
					</select></td>
				</tr>
				<tr class='tablerow1'>
					<td>VIP Level</td>
					<td><select name="vips[]" size="5" multiple>
						<option value='1' <?php if($vip != 0 && in_array(1, $vip)) echo "selected"; ?>>Bronze VIP</option>
						<option value='2' <?php if($vip != 0 && in_array(2, $vip)) echo "selected"; ?>>Silver VIP</option>
						<option value='3' <?php if($vip != 0 && in_array(3, $vip)) echo "selected"; ?>>Gold VIP</option>
						<option value='4' <?php if($vip != 0 && in_array(4, $vip)) echo "selected"; ?>>Platinum VIP</option>
						<option value='5' <?php if($vip != 0 && in_array(5, $vip)) echo "selected"; ?>>VIP Moderators</option>
					</select></td>
				</tr>
				<tr>
					<td>Famed Level</td>
					<td><select name="famed[]" size="5" multiple>
						<option value='1' <?php if($famed != 0 && in_array(1, $famed)) echo "selected"; ?>>Old-School</option>
						<option value='2' <?php if($famed != 0 && in_array(2, $famed)) echo "selected"; ?>>Chartered Old-School</option>
						<option value='3' <?php if($famed != 0 && in_array(3, $famed)) echo "selected"; ?>>Famed</option>
						<option value='4' <?php if($famed != 0 && in_array(4, $famed)) echo "selected"; ?>>Famed Commissioners</option>
						<option value='5' <?php if($famed != 0 && in_array(5, $famed)) echo "selected"; ?>>Famed Moderators</option>
						<option value='6' <?php if($famed != 0 && in_array(6, $famed)) echo "selected"; ?>>Famed Vice-Chairman</option>
						<option value='7' <?php if($famed != 0 && in_array(7, $famed)) echo "selected"; ?>>Famed Chairman</option>
					</select></td>
				</tr>
				<tr class='tablerow1'>
					<td>Faction</td>
					<td><select name="faction[]" size="5" multiple>
					<?php
						$grouplistquery = mysql_query("SELECT `id`, `Name` FROM `groups` WHERE `Name` <> ''");
						while ($grouplist = mysql_fetch_array($grouplistquery)) echo "<option value='$grouplist[id]' ".(($faction != 0 && in_array($grouplist['id'], $faction)) ? "selected" : "").">$grouplist[Name]</option>";
					?>
					</select></td>
				</tr>
				<tr>
					<td>Restrict to Ranks</td>
					<td><select name="faction_rank[]" size="5" multiple>
						<option value='0' <?php if($faction_rank != 0 && in_array(0, $faction_rank)) echo "selected"; ?>>Rank 0</option>
						<option value='1' <?php if($faction_rank != 0 && in_array(1, $faction_rank)) echo "selected"; ?>>Rank 1</option>
						<option value='2' <?php if($faction_rank != 0 && in_array(2, $faction_rank)) echo "selected"; ?>>Rank 2</option>
						<option value='3' <?php if($faction_rank != 0 && in_array(3, $faction_rank)) echo "selected"; ?>>Rank 3</option>
						<option value='4' <?php if($faction_rank != 0 && in_array(4, $faction_rank)) echo "selected"; ?>>Rank 4</option>
						<option value='5' <?php if($faction_rank != 0 && in_array(5, $faction_rank)) echo "selected"; ?>>Rank 5</option>
						<option value='6' <?php if($faction_rank != 0 && in_array(6, $faction_rank)) echo "selected"; ?>>Rank 6</option>
						<option value='7' <?php if($faction_rank != 0 && in_array(7, $faction_rank)) echo "selected"; ?>>Rank 7</option>
						<option value='8' <?php if($faction_rank != 0 && in_array(8, $faction_rank)) echo "selected"; ?>>Rank 8</option>
						<option value='9' <?php if($faction_rank != 0 && in_array(9, $faction_rank)) echo "selected"; ?>>Rank 9</option>
					</select></td>
				</tr>
				<tr class='tablerow1'>
					<td>Gang</td>
					<td><select name="gang[]" size="5" multiple>
					<?php
						$ganglistquery = mysql_query("SELECT `ID`, `Name` FROM `families` WHERE `Name` <> 'None'");
						while ($ganglist = mysql_fetch_array($ganglistquery)) echo "<option value='$ganglist[ID]' ".(($gang != 0 && in_array($ganglist['id'], $gang)) ? "selected" : "").">$ganglist[Name]</option>";
					?>
					</select></td>
				</tr>
				<tr>
					<td>Restrict to Ranks</td>
					<td><select name="gang_rank[]" size="5" multiple>
						<option value='0' <?php if($gang_rank != 0 && in_array(0, $gang_rank)) echo "selected"; ?>>Rank 0</option>
						<option value='1' <?php if($gang_rank != 0 && in_array(1, $gang_rank)) echo "selected"; ?>>Rank 1</option>
						<option value='2' <?php if($gang_rank != 0 && in_array(2, $gang_rank)) echo "selected"; ?>>Rank 2</option>
						<option value='3' <?php if($gang_rank != 0 && in_array(3, $gang_rank)) echo "selected"; ?>>Rank 3</option>
						<option value='4' <?php if($gang_rank != 0 && in_array(4, $gang_rank)) echo "selected"; ?>>Rank 4</option>
						<option value='5' <?php if($gang_rank != 0 && in_array(5, $gang_rank)) echo "selected"; ?>>Rank 5</option>
						<option value='6' <?php if($gang_rank != 0 && in_array(6, $gang_rank)) echo "selected"; ?>>Rank 6</option>
					</select></td>
				</tr>
				<tr class='tablerow1'>
					<td>Business</td>
					<td><select name="biz[]" size="5" multiple>
					<?php
						$bizlistquery = mysql_query("SELECT `Id`, `Name` FROM `businesses` WHERE `Name` <> '' AND `Name` <> 'Unnamed Business'");
						while ($bizlist = mysql_fetch_array($bizlistquery)) echo "<option value='$bizlist[Id]' ".(($biz != 0 && in_array($bizlist['id'], $biz)) ? "selected" : "").">$bizlist[Name]</option>";
					?>
					</select></td>
				</tr>
				<tr>
					<td>Restrict to Ranks</td>
					<td><select name="biz_rank[]" size="5" multiple>
						<option value='0' <?php if($biz_rank != 0 && in_array(0, $biz_rank)) echo "selected"; ?>>Rank 0</option>
						<option value='1' <?php if($biz_rank != 0 && in_array(1, $biz_rank)) echo "selected"; ?>>Rank 1</option>
						<option value='2' <?php if($biz_rank != 0 && in_array(2, $biz_rank)) echo "selected"; ?>>Rank 2</option>
						<option value='3' <?php if($biz_rank != 0 && in_array(3, $biz_rank)) echo "selected"; ?>>Rank 3</option>
						<option value='4' <?php if($biz_rank != 0 && in_array(4, $biz_rank)) echo "selected"; ?>>Rank 4</option>
						<option value='5' <?php if($biz_rank != 0 && in_array(5, $biz_rank)) echo "selected"; ?>>Rank 5</option>
					</select></td>
				</tr>
				<tr class='tablerow1'>
					<td>Bypass Opt-Out</td>
					<td><input type="checkbox" name="optout" value="1" <?php if($array['bypass'] == 1) echo 'checked="checked"'; ?> /></td>
				</tr>
				<tr class='acp-actionbar'>
					<input type='hidden' name='action' value='update_email'>
					<input type="hidden" name="id" readonly="readonly" value="<?php echo $_GET['id']; ?>">
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<td colspan='2'><input type='submit' value='Change' class='button'></td>
				</tr>
			</form>
		</table>
		</div>
	</div>
<?php
}
if(isset($_GET['new']))
{
?>
<div id='content_wrap'>
	<ol id='breadcrumb'>
		<li>Mass Email Players &raquo; Create</li>
	</ol>
	<div class='section_title'>
		<h2>Create New Email</h2>
	</div>
	<?php if(isset($msg)) { echo "<div class='acp-message'>".$msg."</div>"; } ?>
	<div class='acp-box'>
	<h3>New Message</h3>
	<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
		<form method="POST" action="user/proc.php">
			<tr class='tablerow1'>
				<td width='50%'>Subject</td>
				<td width='50%'><input type="text" name="subject" size="50" maxlength="255"></td>
			</tr>
			<tr>
				<td>Message</td>
				<td><textarea rows='6' cols='50' name='message'></textarea></td>
			</tr>
			<tr class='tablerow1'>
				<td>Send to Banned Accounts</td>
				<td><input type="checkbox" name="banned" value="1" /></td>
			</tr>
			<tr>
				<td>Send to Disabled Accounts</td>
				<td><input type="checkbox" name="disabled" value="1" /></td>
			</tr>
			<tr class='tablerow1'>
				<td>Admin Level</td>
				<td><select name="admins[]" size="5" multiple>
					<option value='1'>Server Moderators</option>
					<option value='1.5'>Senior Moderators</option>
					<option value='2'>Junior Administrators</option>
					<option value='3'>General Administrators</option>
					<option value='4'>Senior Administrators</option>
					<option value='1337'>Head Administrators</option>
					<option value='1338'>Lead Head Administrators</option>
					<option value='99999'>Executive Administrators</option>
				</select></td>
			</tr>
			<tr>
				<td>Helper Level</td>
				<td><select name="helpers[]" size="4" multiple>
					<option value='1'>Community Helpers</option>
					<option value='2'>Community Advisors</option>
					<option value='3'>Senior Advisors</option>
					<option value='4'>Chief Advisor</option>
				</select></td>
			</tr>
			<tr class='tablerow1'>
				<td>VIP Level</td>
				<td><select name="vips[]" size="5" multiple>
					<option value='1'>Bronze VIP</option>
					<option value='2'>Silver VIP</option>
					<option value='3'>Gold VIP</option>
					<option value='4'>Platinum VIP</option>
					<option value='5'>VIP Moderators</option>
				</select></td>
			</tr>
			<tr>
				<td>Famed Level</td>
				<td><select name="famed[]" size="5" multiple>
					<option value='1'>Old-School</option>
					<option value='2'>Chartered Old-School</option>
					<option value='3'>Famed</option>
					<option value='4'>Famed Commissioners</option>
					<option value='5'>Famed Moderators</option>
					<option value='6'>Famed Vice-Chairman</option>
					<option value='7'>Famed Chairman</option>
				</select></td>
			</tr>
			<tr class='tablerow1'>
				<td>Faction</td>
				<td><select name="faction[]" size="5" multiple>
				<?php
					$grouplistquery = mysql_query("SELECT `id`, `Name` FROM `groups` WHERE `Name` <> ''");
					while ($grouplist = mysql_fetch_array($grouplistquery)) echo "<option value='$grouplist[id]'>$grouplist[Name]</option>";
				?>
				</select></td>
			</tr>
			<tr>
				<td>Restrict to Ranks</td>
				<td><select name="faction_rank[]" size="5" multiple>
					<option value='0'>Rank 0</option>
					<option value='1'>Rank 1</option>
					<option value='2'>Rank 2</option>
					<option value='3'>Rank 3</option>
					<option value='4'>Rank 4</option>
					<option value='5'>Rank 5</option>
					<option value='6'>Rank 6</option>
					<option value='7'>Rank 7</option>
					<option value='8'>Rank 8</option>
					<option value='9'>Rank 9</option>
				</select></td>
			</tr>
			<tr class='tablerow1'>
				<td>Gang</td>
				<td><select name="gang[]" size="5" multiple>
				<?php
					$ganglistquery = mysql_query("SELECT `ID`, `Name` FROM `families` WHERE `Name` <> 'None'");
					while ($ganglist = mysql_fetch_array($ganglistquery)) echo "<option value='$ganglist[ID]'>$ganglist[Name]</option>";
				?>
				</select></td>
			</tr>
			<tr>
				<td>Restrict to Ranks</td>
				<td><select name="gang_rank[]" size="5" multiple>
					<option value='0'>Rank 0</option>
					<option value='1'>Rank 1</option>
					<option value='2'>Rank 2</option>
					<option value='3'>Rank 3</option>
					<option value='4'>Rank 4</option>
					<option value='5'>Rank 5</option>
					<option value='6'>Rank 6</option>
				</select></td>
			</tr>
			<tr class='tablerow1'>
				<td>Business</td>
				<td><select name="biz[]" size="5" multiple>
				<?php
					$bizlistquery = mysql_query("SELECT `Id`, `Name` FROM `businesses` WHERE `Name` <> '' AND `Name` <> 'Unnamed Business'");
					while ($bizlist = mysql_fetch_array($bizlistquery)) echo "<option value='$bizlist[Id]'>$bizlist[Name]</option>";
				?>
				</select></td>
			</tr>
			<tr>
				<td>Restrict to Ranks</td>
				<td><select name="biz_rank[]" size="5" multiple>
					<option value='0'>Rank 0</option>
					<option value='1'>Rank 1</option>
					<option value='2'>Rank 2</option>
					<option value='3'>Rank 3</option>
					<option value='4'>Rank 4</option>
					<option value='5'>Rank 5</option>
				</select></td>
			</tr>
			<tr class='tablerow1'>
				<td>Bypass Opt-Out</td>
				<td><input type="checkbox" name="optout" value="1" /></td>
			</tr>
			<tr class='acp-actionbar'>
				<td colspan='2'>
					<input type='hidden' name='action' value='create_email'>
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<input type='submit' value='Create' class='button'>
				</td>
			</tr>
		</form>
	</table>
	</div>
</div>
<?php
}
?>