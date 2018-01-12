<?php if($inf['GangModerator'] > 0 || $inf['AdminLevel'] > 3 && isset($_POST['action']) && $_POST['action'] == "edit") {
	$familyquery = mysql_query("SELECT * FROM `cp_family` WHERE `id` = '$_POST[famid]'");
	$family = mysql_fetch_array($familyquery);
	$leaderquery = mysql_query("SELECT `Username` FROM `accounts` WHERE `id` = '$family[leader]'");
	$leader = mysql_fetch_array($leaderquery);
?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Game Affairs > Modifying Gangs</li></ol>
	<div class='section_title'><h2>Gangs</h2></div>
<div class='acp-box'>
	<h3>Modifying <?php echo $family['name']; ?></h3>
		<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
		<form method="post" action="gameaffairs/proc.php">
			<tr class='tablerow1'>
				<td width='40%'>Name</td>
				<td><input type="text" length="64" size="50" name="name" value="<?php echo $family['name']; ?>"></td>
			</tr>
			<tr>
				<td>Leader</td>
				<td><input type="text" length="64" size="50" name="leader" value="<?php echo $leader[0]; ?>"></td>
			</tr>
			<tr class='tablerow1'>
				<td>Rank 1</td>
				<td><input type="text" length="64" size="50" name="rank1" value="<?php echo $family['rank_1']; ?>"></td>
			</tr>
			<tr>
				<td>Rank 2</td>
				<td><input type="text" length="64" size="50" name="rank2" value="<?php echo $family['rank_2']; ?>"></td>
			</tr>
			<tr class='tablerow1'>
				<td>Rank 3</td>
				<td><input type="text" length="64" size="50" name="rank3" value="<?php echo $family['rank_3']; ?>"></td>
			</tr>
			<tr>
				<td>Rank 4</td>
				<td><input type="text" length="64" size="50" name="rank4" value="<?php echo $family['rank_4']; ?>"></td>
			</tr>
			<tr class='tablerow1'>
				<td>Rank 5</td>
				<td><input type="text" length="64" size="50" name="rank5" value="<?php echo $family['rank_5']; ?>"></td>
			</tr>
			<tr>
				<td>Rank 6</td>
				<td><input type="text" length="64" size="50" name="rank6" value="<?php echo $family['rank_6']; ?>"></td>
			</tr>
			<tr class='acp-actionbar'>
				<td colspan='2'>
						<input type="hidden" name="action" readonly="readonly" value="edit_family">
						<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
						<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
						<input type="hidden" name="ga_id" readonly="readonly" value="<?php echo $family['id']; ?>">
						<input type="submit" class="button" value="Modify">
				</td>
			</tr>
		</form>
		</table>
</div>
</div>
<?php } 
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>