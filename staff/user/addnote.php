<?php require('.././global/jquery_int.php'); ?>
	<div id='content_wrap'>
				<ol id='breadcrumb'><li>User Management > Add Note</li></ol>
				<div class='section_title'><h2>Add User Note</h2></div>
			<div class='acp-box'>
			<?php if(isset($_GET['m']) && $_GET['m'] == 1) { echo "<div class='acp-message'>Your note has been added!</div>"; } ?>
				<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
				<form method="POST" action="user/proc.php">
				<tr class='tablerow1'><td>User</td><td><select name="accountid">
  <?php 
$ulist1 = mysql_query("SELECT `id`,`Username` FROM `accounts` WHERE `AdminLevel`>'1' AND `AdminLevel`<'99999' AND `Disabled`='0' ORDER BY Username ASC");
while ($ulist = mysql_fetch_array($ulist1)) {
print "<option value='$ulist[id]'>$ulist[Username]</option>";
}
  ?>
  				</select></td></tr>
				<tr><td>Type</td><td><select name="type">
					<option value="1">Infraction</option>
					<option value="2">Commendation</option>
				</select></td></tr>
				<tr class='tablerow1'><td>Note</td><td><textarea style="max-height:200px; min-height:50px;max-width:200px; min-width:50px;" name="note" rows="2" cols="60"></textarea></td></tr>
				<tr><td>Point Change</td><td><input name="points" /></td></tr>
				<input type="hidden" name="action" readonly="readonly" value="addNote">
				<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
				<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
				<input type="hidden" name="invokeid" readonly="readonly" value="<?php echo $inf['id']; ?>">
				<tr class="acp-actionbar"><td colspan="2"><input class="button" type="submit" value="Add Note"></td></tr>
				</form>
				</table>

			</div></div>