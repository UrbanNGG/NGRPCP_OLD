<?php if($inf['AdminLevel'] >= 1337 || $uaccess['tech'] == 1) { ?>
			<div id='content_wrap'> 
				<ol id='breadcrumb'><li>Players > Change User Password</li></ol> 
			<div class='section_title'><h2>Change User Password</h2></div>
			<div class='acp-box'>
			<h3>Search For Player</h3>
				<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
					<form method='post' action='player.php?p=changepass'>
					<tr>
						<td>Name</td>
						<td><input type="text" size="25" name="player_name"></td>
						<td>
							<input type='hidden' name='action' readonly='readonly' value='search'>
							<input type='submit' class='button' value='Search'>
						</td>
					</tr>
					</form>
				</table>
					<?php if(isset($_POST['action']) && $_POST['action'] == "search") {
					$playerquery = mysql_query("SELECT `id`, `Username`, `IP`, `AdminLevel`, `Level`, `Email`, `Band`, `Disabled` FROM `accounts` WHERE `Username` = '$_POST[player_name]'");
					$player = mysql_fetch_array($playerquery);
					$num = mysql_num_rows($playerquery);
					
					if($player['AdminLevel'] > 1)
					{
						print "<div class='acp-error'>You cannot change passwords of Admin accounts!</div>";
					}
					
					else if($num == 1) { ?>
					<h3><?php echo $player['Username']; ?><span class='table_view'>Database ID: <?php echo $player['id']; ?></span></h3>
					<?php if($player['Band'] > 0) { echo "<div class='acp-error'>This player is currently banned.</div>"; } ?>
					<?php if($player['Disabled'] > 0) { echo "<div class='acp-error'>This account is currently disabled.</div>"; } ?>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
						<tr class='tablerow1'>
							<td>IP Address</td>
							<td><?php echo FlagByIP($player['IP'])." ".$player['IP']; ?></td>
						</tr>
						<tr>
							<td>Last Active</td>
							<td><?php echo LastOnline($player['id']); ?></td>
						</tr>
						<tr class='tablerow1'>
							<td>Level</td>
							<td><?php echo $player['Level']; ?></td>
						</tr>
						<tr>
							<td>Email Address</td>
							<td><?php echo $player['Email']; ?></td>
						</tr>
					</table>
				<div class='acp-actionbar'>
					<table>
					<form method='post' action='player/proc.php'>
						<tr>
							<td>New Password</td>
							<td><input type="password" size="30" name="password"></td>
							<td>
								<input type='hidden' name='action' readonly='readonly' value='changepass'>
								<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
								<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
								<input type='hidden' name='user_id' readonly='readonly' value='<?php echo $player['id']; ?>'>
								<input type='submit' class='button' value='Change Password'>
							</td>
						</tr>
					</form>
					</table>
				</div>
					<?php }
					else { print "<div class='acp-error'>The player you are searching for does not exist!</div>"; } ?>
					<?php } ?>
			</div></div>
<?php }
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>