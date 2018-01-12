<?php if($inf['AdminLevel'] > 1 || $access['punish'] == 1) {

$pID = intval($_GET['id']);
require('info.php');

	if($pInf['status'] == 1) { $p_status = 'Pending'; }
	if($pInf['status'] == 2) { $p_status = 'Issued'; }
	if($pInf['status'] == 3) { $p_status = 'Removed'; }
?>

		<div id='content_wrap'>
			<ol id='breadcrumb'><li>Punishments > View Punishments</li></ol>
			<div class='section_title'><h2>Editing <?php echo $playername[0]; ?>'s Punishment</h2></div>
			<div class='acp-box'>
				<h3>Edit Punishment #<?php echo $pInf['id']; ?></h3>
				<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
				<form method="post" action="punish/proc.php">
					<tr class='tablerow1'>
						<td width='40%'>Offender</td>
						<td>
							<?php if($pInf['status'] == 1) { ?>
							<input type="text" length="64" size="50" name="player_name" value="<?php echo GetName($pInf['player_id']); ?>">
							<?php }
							else { echo GetName($pInf['player_id']; } ?>
						</td>
					</tr>
					<tr>
						<td>Rule(s) Broken</td>
						<td>
							<?php if($pInf['status'] == 1) { ?>
							<input type="text" length="64" size="50" name="p_rules" value="<?php echo $pInf['reason']; ?>">
							<?php }
							else { echo $pInf['reason']; } ?>
						</td>
					</tr>
					<tr class='tablerow1'>
						<td>Prison Time</td>
						<td>
							<?php if($pInf['status'] == 1) { ?>
							<input type="text" name="p_prison" value="<?php echo $pInf['prison']; ?>" size="25" length="512">
							<?php }
							else {
							if($pInf['prison'] == 0) { echo "None"; }
							if($pInf['prison'] != 0) { echo $pInf['prison']." Minutes"; }
							} ?>
						</td>
					</tr>
					<tr>
						<td>Warn</td>
						<td>
							<?php if($pInf['status'] == 1) { ?>
							<input type="hidden" name="p_warn" value="0" /><input type="checkbox" name="p_warn" <?php if($pInf['warn'] == "1") { echo "checked=Yes"; } ?> value="1" />
							<?php }
							else {
							if($pInf['warn'] == 0) { echo "No"; }
							if($pInf['warn'] == 1) { echo "Yes"; }
							} ?>
						</td>
					</tr>
					<tr class='tablerow1'>
						<td>Fine</td>
						<td>$
							<?php if($pInf['status'] == 1) { ?>
							<input type="text" name="p_fine" value="<?php echo $pInf['fine']; ?>" size="25" length="512">
							<?php }
							else { echo $pInf['fine']; } ?>
						</td>
					</tr>
					<tr>
						<td>Weapon Restriction</td>
						<td>
							<?php if($pInf['status'] == 1) { ?>
							<input type="text" name="p_wepreset" value="<?php echo $pInf['wep_restrict']; ?>" size="25" length="512">
							<?php }
							else {
							if($pInf['wep_restrict'] == 0) { echo "None"; }
							if($pInf['wep_restrict'] != 0) { echo $pInf['wep_restrict']; }
							} ?>
						</td>
					</tr>
					<tr class='tablerow1'>
						<td>Ban</td>
						<td>
							<?php if($pInf['status'] == 1) { ?>
							<input type="hidden" name="p_ban" value="0" /><input type="checkbox" name="p_ban" <?php if($pInf['ban'] == "1") { echo "checked=Yes"; } ?> value="1" />
							<?php }
							else {
							if($pInf['ban'] == 0) { echo "No"; }
							if($pInf['ban'] == 1) { echo "Yes"; }
							} ?>
						</td>
					</tr>
					<tr>
						<td>Other Punishment</td>
						<td>
							<?php if($pInf['status'] == 1) { ?>
							<input type="text" name="p_punishment" value="<?php echo $pInf['other_punish']; ?>" size="25" length="512">
							<?php }
							else { echo $pInf['other_punish']; } ?>
						</td>
					</tr>
					<tr class='tablerow1'>
						<td>Punishment Link</td>
						<td>
							<?php if($pInf['status'] == 1) { ?>
							<input type="text" length="64" size="50" name="p_link" value="<?php echo $pInf['link']; ?>">
							<?php }
							else { echo $pInf['link']; } ?>
						</td>
					</tr>
					<tr>
						<td>Punishment Status</td>
						<td><?php echo $p_status; ?></td>
					</tr>
					<tr class='tablerow1'>
						<td>Punishment Added By</td>
						<td><?php echo GetName($pInf['addedby_id']; ?></td>
					</tr>
					<tr>
						<td>Date Added</td>
						<td><?php echo $pInf['date_added']; ?></td>
					</tr>
					<?php if($pInf['status'] == 2) { ?>
					<tr class='tablerow1'>
						<td>Punishment Issued By</td>
						<td><?php echo GetName($pInf['issuedby_id']; ?></td>
					</tr>
					<tr>
						<td>Date Issued</td>
						<td><?php echo $pInf['date_issued']; ?></td>
					</tr>
					<?php }
					if($pInf['status'] == 3) { ?>
					<tr class='tablerow1'>
						<td>Punishment Removed By</td>
						<td><?php echo GetName($pInf['issuedby_id']; ?></td>
					</tr>
					<tr>
						<td>Date Removed</td>
						<td><?php echo $pInf['date_issued']; ?></td>
					</tr>
					<?php } ?>
					<?php if($pInf['status'] == 1) { ?>
					<tr class='acp-actionbar'><td>
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="hidden" name="action" readonly="readonly" value="edit">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<input type="hidden" name="pID" readonly="readonly" value="<?php echo $pInf['id']; ?>">
					<input type="submit" class="button" value="Edit">
					</form>
					</td>
					<td>
					<form method="post" action="punish/proc.php">
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="hidden" name="action" readonly="readonly" value="issue">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<input type="hidden" name="pID" readonly="readonly" value="<?php echo $pInf['id']; ?>">
					<input type="submit" class="button" value="Issue">
					</form>
					</td></tr>
					<?php } ?>
				</table>
			</div>
		</div>
<?php }
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>