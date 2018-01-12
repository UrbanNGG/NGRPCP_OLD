<?php if($inf['AdminLevel'] > 1 || $access['refund'] == 1) {

$id = $_GET['id'];
require('refund/info.php');

	if($rInf['status'] == 1) { $status = "Pending"; }
	if($rInf['status'] == 2) { $status = "Issued"; }
	if($rInf['status'] == 3) { $status = "Removed"; }

	$player = GetName($rInf['user_id']);
	$addedID = GetName($rInf['addedby_id']);
	$issuedID = GetName($rInf['issuedby_id']);
?>

<div id='content_wrap'>
	<ol id='breadcrumb'><li>Refunds > Edit Refund</li></ol>
	<div class='section_title'><h2>Editing <?php echo $player; ?>'s Refund</h2></div>
	<div class='acp-box'>
		<h3>Editing Refund #<?php echo $rInf['id']; ?></h3>
		<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
			<form method="post" action="refund/proc.php">
			<tr class='tablerow1'>
				<td width='40%'>Player</td>
				<td>
					<input type="text" length="64" size="50" name="player" value="<?php echo $player; ?>">
				</td>
			</tr>
			<tr>
				<td>Money</td>
				<td>
					$<input type="text" length="64" size="50" name="money" value="<?php echo $rInf['money']; ?>">
				</td>
			</tr>
			<tr class='tablerow1'>
				<td>Materials</td>
				<td>
					<input type="text" length="64" size="50" name="material" value="<?php echo $rInf['materials']; ?>">
				</td>
			</tr>
			<tr>
				<td>Pot</td>
				<td>
					<input type="text" length="64" size="50" name="pot" value="<?php echo $rInf['pot']; ?>">
				</td>
			</tr>
			<tr class='tablerow1'>
				<td>Crack</td>
				<td>
					<input type="text" length="64" size="50" name="crack" value="<?php echo $rInf['crack']; ?>">
				</td>
			</tr>
			<tr>
				<td>Boomboxes</td>
				<td>
					<input type="text" length="64" size="50" name="boombox" value="<?php echo $rInf['boombox']; ?>">
				</td>
			</tr>
			<tr class='tablerow1'>
				<td>VIP Tokens</td>
				<td>
					<input type="text" length="64" size="50" name="viptoken" value="<?php echo $rInf['viptoken']; ?>">
				</td>
			</tr>
			<tr>
				<td>Other Refund</td>
				<td>
					<input type="text" length="64" size="50" name="refund" value="<?php echo $rInf['refund']; ?>">
				</td>
			</tr>
			<tr class='tablerow1'>
				<td>Authorization</td>
				<td>
					<input type="text" length="64" size="50" name="auth" value="<?php echo $rInf['auth']; ?>">
				</td>
			</tr>
			<tr>
				<td>Link</td>
				<td>
					<input type="text" length="64" size="50" name="link" value="<?php echo $rInf['link']; ?>">
				</td>
			</tr>
			<tr class='tablerow1'>
				<td>Status</td>
				<td><?php echo $status; ?></td>
			</tr>
			<tr>
				<td>Added By</td>
				<td><?php echo $addedID; ?></td>
			</tr>
			<tr class='tablerow1'>
				<td>Date Added</td>
				<td><?php echo $rInf['date_added']; ?></td>
			</tr>
				<?php if($rInf['status'] == 2) { ?>
			<tr>
				<td>Issued By</td>
				<td><?php echo $issuedID; ?></td>
			</tr>
			<tr class='tablerow1'>
				<td>Date Issued</td>
				<td><?php echo $rInf['date_issued']; ?></td>
			</tr>
				<?php }
				if($rInf['status'] == 3) { ?>
			<tr>
				<td>Removed By</td>
				<td><?php echo $issuedID; ?></td>
			</tr>
			<tr class='tablerow1'>
				<td>Date Removed</td>
				<td><?php echo $rInf['date_issued']; ?></td>
			</tr>
				<?php }
				if($rInf['status'] == 1) { ?>
			<tr class='acp-actionbar'>
				<td>
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="hidden" name="action" readonly="readonly" value="edit">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<input type="hidden" name="rID" readonly="readonly" value="<?php echo $rInf['id']; ?>">
					<input type="submit" class="button" value="Edit">
				</form>
				</td>
				<td>
				<form method="post" action="refund/proc.php">
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="hidden" name="action" readonly="readonly" value="issue">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<input type="hidden" name="rID" readonly="readonly" value="<?php echo $rInf['id']; ?>">
					<input type="submit" class="button" value="Issue">
				</form>
				</td>
			</tr>
				<?php } ?>
		</table>
	</div></div>
<?php }
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>