			<div id='content_wrap'> 
				<ol id='breadcrumb'><li>Flags > Search Flags by Player</li></ol> 
			<div class='section_title'><h2>Flags</h2></div>
			<div class='acp-box'>
			<h3>Search Flags by Player</h3>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'> 
			<tr>
				<td><form action="flag.php?p=playersearch" method="post">
					<input type="text" name="player" />
					<input type="submit" class="button" value="Search" />
				</form></td>
			</tr>
			</table>
				<?php if(isset($_POST['player'])) {
					$playeridquery = mysql_query("SELECT `id` FROM `accounts` WHERE `Username` = '$_POST[player]'");
					$playerid = mysql_fetch_array($playeridquery);
					$flagquery = mysql_query("SELECT * FROM `flags` WHERE `id` = '$playerid[0]' ORDER BY `time` ASC");
					$num = mysql_numrows($flagquery);
					$count = number_format($num);
					
					print "<h3>$_POST[player]'s Flags <span class='table_view'>$count Flags</span></h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'> 
					<tr>
						<th>Date Added</th>
						<th>Flag</th>
						<th>Added By</th>
						<th>Issue</th>
					</tr>";
					
					while ($flag = mysql_fetch_array($flagquery)) {

					if (isset($i) && $i == 1) {
						print "<tr class='tablerow1'>";
					$i=0;
					} else { 
						print "<tr>";
					$i=1;
					}
					
					$issue = "<form method='post' action='flag/proc.php' name='form$flag[fid]'>
						<input type='hidden' name='action' readonly='readonly' value='issue'>
						<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
						<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
						<input type='hidden' name='fID' readonly='readonly' value='$flag[fid]'>
						<input type='hidden' name='user_id' readonly='readonly' value='$flag[id]'>
						<input type='hidden' name='player_name' readonly='readonly' value='$_POST[player]'>
						<input type='submit' class='button' value='Issue'></form>
					</form>";
					
					print "
						<td>$flag[time]</td>
						<td>$flag[flag]</td>
						<td>$flag[issuer]</td>
						<td>$issue</td>
					</tr>
					";
					} ?>
					</table>
				<?php } ?>
				<div class='acp-actionbar'></div>
			</div></div>