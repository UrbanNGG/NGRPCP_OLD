<?php require('.././global/jquery_int.php');
if($inf['AdminLevel'] > 1 || $access['refund'] == 1) {
AutoComplete();
?>
 
			<div id='content_wrap'>
				<ol id='breadcrumb'><li>Refunds > Add Refund</li></ol>
				<div class='section_title'><h2>Refunds</h2></div>
			<div class='acp-box'>
				<?php
					if(isset($_GET['note']) && $_GET['note'] == 0) { echo "<div class='acp-error'>That player does not exist!</div>"; }
				?>
				<h3>Add Refund</h3>
				<table class="double_pad" cellpadding="0" cellspacing="0" border="0" width="100%">
				<form method="POST" action="refund/proc.php">
					<tr class="tablerow1"><td width="50%">Player</td><td><input id="accountsearch" type="text" name="player" /></td></tr>
					<tr><td>Money</td><td>$<input value="0" type="text" name="money" size="30" title="Put full length of money (i.e: $1,000,000)" length="512"></td></tr>
					<tr class="tablerow1"><td>Materials</td><td><input value="0" type="text" name="material" size="30" length="64"></td></tr>
					<tr><td>Crack</td><td><input value="0" type="text" name="crack" size="30" length="512"></td></tr>
					<tr class="tablerow1"><td>Pot</td><td><input value="0" type="text" name="pot" size="30" length="64"></td></tr>
					<tr><td>Boomboxes</td><td><input value="0" type="text" name="boombox" size="30" length="512"></td></tr>
					<tr class="tablerow1"><td>VIP Tokens</td><td><input value="0" type="text" name="viptoken" size="30" length="64"></td></tr>
					<tr><td>Other Refund</td><td><input type="text" name="refund" size="30" title="Anything not listed (i.e: 2 sultans)" length="512"></td></tr>
					<tr class="tablerow1"><td>Authorization</td><td><input type="text" name="auth" size="30" length="64"></td></tr>
					<tr><td>Link</td><td><input type="text" name="link" size="30" title="Make sure to include 'http://' before the link" length="512"></td></tr>
						<input type="hidden" name="action" readonly="readonly" value="add">
						<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
						<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
						<input type="hidden" name="admin_id" readonly="readonly" value="<?php echo $inf['id']; ?>">
					<tr class="acp-actionbar"><td colspan="2" align="center"><input type="submit" class="button" value="Submit"></td></tr>
				</form>
		</div></div>
<?php }
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>