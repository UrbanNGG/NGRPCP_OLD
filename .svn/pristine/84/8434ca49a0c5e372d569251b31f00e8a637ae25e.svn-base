				<div class='section_title'><h2>Add Usergroup Leader</h2></div>
			<div class='acp-box'>
				<h3>Add Usergroup Leader</h3>
				<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
					<form method="POST" action="user/proc.php">
						<tr class="tablerow1"><td width="40%">Username</td>
							<td><select name="uID">
<?php 
$ulist1 = mysql_query("SELECT * FROM users ORDER BY aUser");
while ($ulist = mysql_fetch_array($ulist1)) {
echo "<option value=$ulist[ID]>$ulist[aUser]</option>";
}
?></select></td></tr>
						<tr><td>Usergroup</td>
							<td><select name="gID">
<?php 
$glist1 = mysql_query("SELECT * FROM groups ORDER BY id");
while ($glist = mysql_fetch_array($glist1)) {
echo "<option value=$glist[id]>$glist[name]</option>";
}
?></select></td></tr>
						<tr><td class="acp-actionbar" colspan="2">
							<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
							<input type="hidden" name="action" readonly="readonly" value="addleader">
							<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
							<input type="submit" class="button" value="Add Leader">
						</td></tr>
					</form>
				</table>