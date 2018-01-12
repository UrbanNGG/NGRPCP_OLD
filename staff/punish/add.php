<?php if($inf['AdminLevel'] > 1 || $access['punish'] == 1) {
AutoComplete();
?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Punishments > Add Punishment</li></ol>
	<div class='section_title'><h2>Punishments</h2></div>
	<?php if(isset($_GET['e']) && $_GET['e'] == 1) { echo "<div class='acp-error'>You cannot add punishments to Admins!</div>"; } ?>
	<div class='acp-box'><h3>Add Punishment</h3>
		<table class="double_pad" cellpadding="0" cellspacing="0" border="0" width="100%">
		<form name="punish" method="POST" action="punish/proc.php">
			<tr class="tablerow1"><td width="50%">Offender</td><td><input id="accountsearch" type="text" name="player_name" /></td></tr>
			<tr><td>Rule(s) Broken</td><td><input type="text" name="p_rules" size="25" length="50"></td></tr>
			<tr class="tablerow1"><td>Prison Time</td><td><input type="text" name="p_prison" value="0" size="25" length="512"></td></tr>
			<tr><td>Warn</td><td><input type="hidden" name="p_warn" value="0" /><input type="checkbox" name="p_warn" value="1"></td></tr>
			<tr class="tablerow1"><td>Fine</td><td>$<input type="text" name="p_fine" value="0" size="25" length="512"></td></tr>
			<tr><td>Weapon Restriction</td><td><input type="text" name="p_wepreset" value="0" size="25" length="512"></td></tr>
			<tr class="tablerow1"><td>Ban</td><td><input type="hidden" name="p_ban" value="0" /><input type="checkbox" name="p_ban" value="1"></td></tr>
			<tr><td>Other Punishment</td><td><input type="text" name="p_punishment" size="25" length="512"></td></tr>
			<tr class="tablerow1"><td>Link</td><td><input type="text" name="p_link" size="25" length="512"></td></tr>
				<input type="hidden" name="action" readonly="readonly" value="add">
				<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
				<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
				<input type="hidden" name="adminid" readonly="readonly" value="<?php echo $inf['id']; ?>">
			<tr class="acp-actionbar"><td colspan="2"><input type="submit" class="button" value="Submit"></td></tr>
		</form>
		</table>
</div></div>
<?php }
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>