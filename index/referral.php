<div id='content_wrap'>
	<ol id='breadcrumb'><li><?php echo $section; ?> > Referrals</li></ol>
	<div class='section_title'><h2>Referrals</h2></div>
	<div class='acp-box' style='width:100%;'>
		<h3>How it works</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr class='tablerow2'>
			<td>
				<div style="border:1px solid;box-shadow:1px 3px 3px #ccc;color:#2b5b8c;width:140px;height:140px;margin:auto;display: block;">
				<img style="height:140px;width:140px;" src='http://127.0.0.1/cp//global/images/all/ref1.png'>
				</div>
			</td>
			<td>
				<img src='http://127.0.0.1/cp//global/images/all/go-next.png'>
			</td>
			<td>
				<div style="border:1px solid;box-shadow:1px 3px 3px #ccc;color:#2b5b8c;width:140px;height:140px;margin:auto;display: block;">
				<img style="height:140px;width:140px;" src='http://127.0.0.1/cp//global/images/all/ref2.png'>
				</div>
			</td>
			<td>
				<img src='http://127.0.0.1/cp//global/images/all/go-next.png'>
			</td>
			<td>
				<div style="border:1px solid;box-shadow:1px 3px 3px #ccc;color:#2b5b8c;width:140px;height:140px;margin:auto;display: block;">
				<img style="height:140px;width:140px;" src='http://127.0.0.1/cp//global/images/all/ref3.png'>
				</div>
			</td>
		</tr>
		<tr class='tablerow2'>
			<td><span style='font-size:21px;color:#2d4a94;text-shadow: 0 1 0.1em black, 0 1 0.1em black'>Refer Friends</span></td>
			<td></td>
			<td><span style='font-size:21px;color:#2d4a94;text-shadow: 0 1 0.1em black, 0 1 0.1em black'>Level Together</span></td>
			<td></td>
			<td><span style='font-size:21px;color:#2d4a94;text-shadow: 0 1 0.1em black, 0 1 0.1em black'>Earn rewards</span></td>
		</tr>
		<tr class='tablerow2'>
			<td>Refer all your friends using the referral link,<br> or have them use your name during registration in-game!</td>
			<td></td>
			<td>Help them achieve levels by earning money by getting jobs,<br> joining factions, gangs, or businesses, and gaining playing hours.</td>
			<td></td>
			<td>Get rewarded when your friend reaches level 3,<br> gain bigger gifts by referring more friends!</td>
		</tr>
		</table>
	</div>
	<br>
	<div class='acp-box' style='width:100%;'>
		<h3>Reward List</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<thead>
			<th>Refers</th>
			<th>Reward</th>
		</thead>
		<tr class='tablerow2'>
		<td>Every player</td><td>100 Credits</td>
		</tr>
		<tr class='tablerow2'>
		<td>5th player</td><td>500 Credits</td>
		</tr>
		<tr class='tablerow2'>
		<td>10th player</td><td>1000 Credits</td>
		</tr>
		<tr class='tablerow2'>
		<td>15th player</td><td>1500 Credits</td>
		</tr>
		<tr class='tablerow2'>
		<td>20th player</td><td>2000 Credits</td>
		</tr>
		<tr class='tablerow2'>
		<td>Every multiple of 5</td><td>100 x number referral</td>
		</tr>
		</table>
	</div>
	<br>
	<!--
	<div class='acp-box' style='width:100%;'>
		<h3>My Refer History</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<thead>
			<th>Friend</th>
			<th>Referred On</th>
			<th>Link Status</th>
			<th>Rewards</th>
		</thead>
		<?php
		$query = mysql_query("");
		while($ref = mysql_fetch_array($query)) {
		?>
		
		<?php
		}
		?>
		<tr class='tablerow2'>
		<td>Bob Johnson</td><td>5/20/2013</td><td>Linked</td><td><img src='http://<?php echo $_SERVER["SERVER_NAME"]; ?>/global/images/all/award_inactive.png' title='Reward not yet received' /></td>
		</tr>
		</table>
	</div>
	<br>
	-->
	<div class='acp-box' style='width:30%;'>
		<h3>My Referral Link</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<?php if($inf['referral_id'] == "") { ?>
			<form action="index/proc.php" method="POST">
			<tr class="tablerow1">
				<td align="center">Click the button below to generate a referral link</td>
			</tr>
			<tr class="acp-actionbar">
				<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
				<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
				<td align="center"><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"><input type="hidden" name="action" value="ref_generate"><input type="submit" class="button" value="Generate ID"></td>
			</tr>
			</form>
		<?php } else { ?>
			<tr class="tablerow1">
				<td align="center">Copy the URL below to give to your friends</td>
			</tr>
			<tr class="acp-actionbar">
				<td align="center"><input type="text" name="refid" size="60" onclick="this.focus();this.select()" value="http://127.0.0.1/cp//referral.php?rid=<?php echo $inf['referral_id']; ?>" readonly="readonly"></td>
			</tr>
		<?php } ?>
		</table>
	</div>
</div>