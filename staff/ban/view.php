<?php if($access['ban'] != 1 && $inf['BanAppealer'] < 1 && $inf['AdminLevel'] > 4) {
	echo $redir;
	exit();
}

AutoComplete();

if(isset($_GET['type'])) {
if($_GET['type'] == "pending") {
?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Bans > Viewing Appeals Pending</li></ol>
	<div class='section_title'><h2>Appeals Pending</h2></div>
		<?php if(isset($_GET['note']) && $_GET['note'] == 3) { echo "<div class='acp-error'>That account does not exist.</div>"; }
			  //if(isset($_GET['note']) && $_GET['note'] == 4) { echo "<div class='acp-error'>The IP was successfully banned.</div>"; } ?>
<div class='acp-box'>
	<h3>Add New Ban</h3>
	<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<form id="ipform" method="post" action="ban/proc.php">
		<tr>
			<td>Username</td><td><input id="accountsearch" type="text" name="username" /></td>
			<td>Reason</td><td><input type="text" size="25" name="reason"></td>
			<input type='hidden' name='action' readonly='readonly' value='add'>
			<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
			<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
			<td><input type='submit' class='button' value='Add'></td>
		</tr>
		<tr>
			<td colspan="5">Note: This function simply lists their ban in the list below. It does not actually ban the player.</td>
		</tr>
		</form>
	</table>
</div>
<div class='acp-box'>
	<h3>Pending Appeals List</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th>Player</th><th>IP Address</th><th>Ban Date</th><th>Reason</th><th>Banned By</th>
		</tr>
	<?php $query1 = mysql_query("SELECT * FROM `bans` WHERE `status` = '1' ORDER BY date_added ASC");
		while ($result1 = mysql_fetch_array($query1)) {
		if(GetName($result1['user_id']) != "") {
			if (isset($i) && $i == 1) {
				print "<tr class='tablerow1'>";
			$i=0;
			} else { 
				print "<tr>";
			$i=1;
			}
			
		$edit = "<form method='post' action='ban.php?p=edit'>
		<input type='hidden' name='action' readonly='readonly' value='edit'>
		<input type='hidden' name='id' readonly='readonly' value='$result1[id]'>
		<input type='submit' class='submit' value='".GetName($result1['user_id'])."'></form>";
			
		print "
			<td>$edit</td>
			<td>$result1[ip_address]</td>
			<td>".date("F j, Y - g:iA", strtotime($result1['date_added']))."</td>
			<td>$result1[reason]</td>
			<td>$result1[admin]</td>
				</tr>
			";
		}
		} ?>
		</table>
</div>
</div>
<?php }
if($_GET['type'] == "temporary") {
?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Bans > Viewing Temporary Bans</li></ol>
	<div class='section_title'><h2>Temporary Bans List</h2></div>
<div class='acp-box'>
	<h3>Temporarily Banned List</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th>Player</th><th>IP Address</th><th>Ban Date</th><th>Unban Date</th><th>Reason</th><th>Banned By</th><th>Link to Appeal</th>
		</tr>
	<?php $query2 = mysql_query("SELECT * FROM `bans` WHERE `status` = '2' ORDER BY date_unban DESC");
		while ($result2 = mysql_fetch_array($query2)) {
		if(GetName($result2['user_id']) != "") {
			if (isset($i) && $i == 1) {
				print "<tr class='tablerow1'>";
			$i=0;
			} else { 
				print "<tr>";
			$i=1;
			}
			
		$edit = "<form method='post' action='ban.php?p=edit'>
		<input type='hidden' name='action' readonly='readonly' value='edit'>
		<input type='hidden' name='id' readonly='readonly' value='$result2[id]'>
		<input type='submit' class='submit' value='".GetName($result2['user_id'])."'></form>";
			
		print "
			<td>$edit</td>
			<td>$result2[ip_address]</td>
			<td>".date("F j, Y - g:iA", strtotime($result2['date_added']))."</td>
			<td>".date("F j, Y", strtotime($result2['date_unban']))."</td>
			<td>$result2[reason]</td>
			<td>$result2[admin]</td>
			<td><a href='$result2[link]'>Click Here</a></td>
				</tr>
			";
		}
		} ?>
		</table>
</div>
</div>
<?php }
if($_GET['type'] == "permanent") {
?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Bans > Viewing Permanent Bans</li></ol>
	<div class='section_title'><h2>Permanent Bans</h2></div>
<div class='acp-box'>
	<h3>Permanently Banned List</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th>Player</th><th>IP Address</th><th>Ban Date</th><th>Reason</th><th>Banned By</th><th>Link to Appeal</th>
		</tr>
	<?php $query3 = mysql_query("SELECT * FROM `bans` WHERE `status` = '3' ORDER BY date_added DESC");
		while ($result3 = mysql_fetch_array($query3)) {
		if(GetName($result3['user_id']) != "") {
			if (isset($i) && $i == 1) {
				print "<tr class='tablerow1'>";
			$i=0;
			} else { 
				print "<tr>";
			$i=1;
			}
		print "
			<td>".GetName($result3['user_id'])."</td>
			<td>$result3[ip_address]</td>
			<td>".date("F j, Y - g:iA", strtotime($result3['date_added']))."</td>
			<td>$result3[reason]</td>
			<td>$result3[admin]</td>
			<td><a href='$result3[link]'>Click Here</a></td>
				</tr>
			";
		}
		} ?>
		</table>
</div>
</div>
<?php }
if($_GET['type'] == "unban") {
?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Bans > Viewing Unbans</li></ol>
	<div class='section_title'><h2>Unbans</h2></div>
<div class='acp-box'>
	<h3>Unbanned List</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th>Player</th><th>IP Address</th><th>Ban Date</th><th>Unban Date</th><th>Reason</th><th>Banned By</th><th>Link to Appeal</th>
		</tr>
	<?php $query4 = mysql_query("SELECT * FROM `bans` WHERE `status` = '4' ORDER BY date_unban DESC");
		while ($result4 = mysql_fetch_array($query4)) {
		if(GetName($result4['user_id']) != "") {
			if (isset($i) && $i == 1) {
				print "<tr class='tablerow1'>";
			$i=0;
			} else { 
				print "<tr>";
			$i=1;
			}
			
		$edit = "<form method='post' action='ban.php?p=edit'>
		<input type='hidden' name='action' readonly='readonly' value='edit'>
		<input type='hidden' name='id' readonly='readonly' value='$result4[id]'>
		<input type='submit' class='submit' value='".GetName($result4['user_id'])."'></form>";
			
		print "
			<td>".$edit."</td>
			<td>$result4[ip_address]</td>
			<td>".date("F j, Y - g:iA", strtotime($result4['date_added']))."</td>
			<td>".date("F j, Y", strtotime($result4['date_unban']))."</td>
			<td>$result4[reason]</td>
			<td>$result4[admin]</td>
			<td><a href='$result4[link]'>Click Here</a></td>
				</tr>
			";
		}
		} ?>
		</table>
</div>
</div>
<?php }
if($_GET['type'] == "archive") {
?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Bans > Viewing Archived Bans</li></ol>
	<div class='section_title'><h2>Archived Bans</h2></div>
<div class='acp-box'>
	<h3>Archived Ban List</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th>Player</th><th>IP Address</th><th>Ban Date</th><th>Reason</th><th>Banned By</th><th>Link to Appeal</th>
		</tr>
	<?php $query8 = mysql_query("SELECT * FROM `bans` WHERE `status` = '5' ORDER BY date_added DESC");
		while ($result8 = mysql_fetch_array($query8)) {
		if(GetName($result8['user_id']) != "") {
			if (isset($i) && $i == 1) {
				print "<tr class='tablerow1'>";
			$i=0;
			} else { 
				print "<tr>";
			$i=1;
			}
			
			$edit = "<form method='post' action='ban.php?p=edit'>
			<input type='hidden' name='action' readonly='readonly' value='edit'>
			<input type='hidden' name='id' readonly='readonly' value='$result8[id]'>
			<input type='submit' class='submit' value='".GetName($result8['user_id'])."'></form>";
			
		print "
			<td>$edit</td>
			<td>$result8[ip_address]</td>
			<td>".date("F j, Y - g:iA", strtotime($result8['date_added']))."</td>
			<td>".date("F j, Y", strtotime($result8['date_unban']))."</td>
			<td>$result8[reason]</td>
			<td>$result8[admin]</td>
			<td><a href='$result8[link]'>Click Here</a></td>
				</tr>
			";
		}
		} ?>
		</table>
</div>
</div>
<?php }
if($_GET['type'] == "ip" && !isset($_POST['search'])) {
if(isset($_GET['limit'])) { $limit = $_GET['limit']; }
else { $limit = 0; }
?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Bans > Viewing IP Bans</li></ol>
	<div class='section_title'><h2>IP Bans</h2></div>
	<?php if(isset($_GET['note']) && $_GET['note'] == 1) { echo "<div class='acp-message'>The IP was successfully unbanned.</div>"; }
	if(isset($_GET['note']) && $_GET['note'] == 2) { echo "<div class='acp-message'>The IP was successfully banned.</div>"; }
	if($inf['AdminLevel'] >= 4) { ?>
	<div class='acp-box'>
	<h3>Add IP Ban</h3>
	<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<form id="ipform" method="post" action="ban/proc.php">
		<tr>
			<td>IP Address</td><td><input id="ip" type="text" size="25" name="banip"></td>
			<td>Reason</td><td><input type="text" size="25" name="reason"></td>
			<input type='hidden' name='action' readonly='readonly' value='ip_add'>
			<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
			<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
			<td><input type='submit' class='button' value='Add'></td>
		</tr>
		</form>
	</table>
	</div>
	<?php } ?>
	<div class='acp-box'>
	<h3>IP Search</h3>
	<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<form method='post' action='ban.php?p=view&type=ip'>
		<tr>
			<td>IP Address</td>
			<td><input type="text" size="25" name="search"></td>
			<td><input type='submit' class='button' value='Search'></td>
		</tr>
		</form>
	</table>
	</div>
	<div class='acp-box'>
	<h3>
		<table><tr>
			<td width='33%' align='left'>
			<?php
				if(!isset($_GET['limit']) || $_GET['limit'] == 0) { echo "<< Prev"; }
				else {
					$prev = $_GET['limit'] - 500;
					echo "<a href='ban.php?p=view&type=ip&limit=$prev'><< Prev</a>";
				}
			?>
			</td>
			<td width='33%' align='center'>IP Ban List</td>
			<td width='33%' align='right'>
			<?php
				$next = $limit + 500;
				echo "<a href='ban.php?p=view&type=ip&limit=$next'>Next >></a>";
			?>
			</td>
		</tr></table>
	</h3>
	<?php $query6 = mysql_query("SELECT * FROM `ip_bans` ORDER BY `date` DESC LIMIT $limit, 500");
		print "
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<thead><tr>
			<th>IP Address</th><th>Ban Date</th><th>Reason</th><th>Banned By</th><th>Remove</th>
		</thead></tr>
		<tbody>
		";
		while ($result6 = mysql_fetch_array($query6)) {
			if (isset($i) && $i == 1) {
				print "<tr class='tablerow1'>";
			$i=0;
			} else { 
				print "<tr>";
			$i=1;
			}
			
			$remove = "<form method='post' action='ban/proc.php'>
			<input type='hidden' name='action' readonly='readonly' value='ip_remove'>
			<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
			<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
			<input type='hidden' name='id' readonly='readonly' value='$result6[bid]'>
			<input type='image' src='../../global/images/all/icons/cross.png' alt='Remove'>
			</form>";
			
		print "
			<td>$result6[ip]</td>
			<td>".date("F j, Y - g:iA", strtotime($result6['date']))."</td>
			<td>$result6[reason]</td>
			<td>$result6[admin]</td>
			<td>$remove</td>
				</tr>
			";
		} ?>
		</tbody>
		</table>
</div>
</div>
<?php }
if($_GET['type'] == "ip" && isset($_POST['search'])) {
?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Bans > Viewing IP Bans</li></ol>
	<div class='section_title'><h2>IP Bans Search Results</h2></div>
<div class='acp-box'>
	<?php $query7 = mysql_query("SELECT * FROM `ip_bans` WHERE `ip` LIKE '$_POST[search]%' ORDER BY `ip` ASC");
		$count = mysql_num_rows($query7);
		print "
		<h3>Search Results for $_POST[search] <span class='table_view'>".number_format($count)." Results</span></h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<thead><tr>
			<th>IP Address</th><th>Ban Date</th><th>Reason</th><th>Banned By</th><th>Remove</th>
		</thead></tr>
		<tbody>
		";
		while ($result7 = mysql_fetch_array($query7)) {
			if (isset($i) && $i == 1) {
				print "<tr class='tablerow1'>";
			$i=0;
			} else { 
				print "<tr>";
			$i=1;
			}
			
			$remove = "<form method='post' action='ban/proc.php'>
			<input type='hidden' name='action' readonly='readonly' value='ip_remove'>
			<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
			<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
			<input type='hidden' name='id' readonly='readonly' value='$result7[bid]'>
			<input type='image' src='../../global/images/all/icons/cross.png' alt='Remove'>
			</form>";
			
		print "
			<td>$result7[ip]</td>
			<td>".date("F j, Y - g:iA", strtotime($result7['date']))."</td>
			<td>$result7[reason]</td>
			<td>$result7[admin]</td>
			<td>$remove</td>
				</tr>
			";
		} ?>
		</tbody>
		</table>
</div>
</div>
<?php }
if($_GET['type'] == "history") {
?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Bans > Viewing Player Ban History</li></ol>
	<div class='section_title'><h2>Player Ban Histroy</h2></div>
<div class='acp-box'>
<?php if(!isset($_POST['username'])) { ?>
	<h3>Player Search</h3>
	<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<form method='post' action='ban.php?p=view&type=history'>
		<tr>
			<td>Name</td>
			<td><input type="text" size="25" name="username"></td>
			<td>
				<input type='submit' class='button' value='Search'>
			</td>
		</tr>
		</form>
	</table>
<?php }
else {
$username = $_POST['username']; ?>
	<h3>Ban Histroy for <?php echo $username; ?></h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th>Player</th><th>IP Address</th><th>Ban Date</th><th>Unban Date</th><th>Reason</th><th>Status</th><th>Banned By</th>
		</tr>
	<?php $query5 = mysql_query("SELECT * FROM `bans` WHERE `user_id` = '".GetID($username)."' ORDER BY date_unban DESC");
		while ($result5 = mysql_fetch_array($query5)) {
			if (isset($i) && $i == 1) {
				print "<tr class='tablerow1'>";
			$i=0;
			} else { 
				print "<tr>";
			$i=1;
			}
			
			if($result5['status'] == 1) { $status = "Pending Appeal"; }
			elseif($result5['status'] == 2) { $status = "Temporarily Banned"; }
			elseif($result5['status'] == 3) { $status = "Permanently Banned"; }
			elseif($result5['status'] == 4) { $status = "Unbanned"; }
			elseif($result5['status'] == 5) { $status = "Archived"; }
			
			$edit = "<form method='post' action='ban.php?p=edit'>
			<input type='hidden' name='action' readonly='readonly' value='edit'>
			<input type='hidden' name='id' readonly='readonly' value='$result5[id]'>
			<input type='submit' class='submit' value='".GetName($result5['user_id'])."'></form>";
				
			if($result5['status'] < 3) { print "<td>$edit</td>"; }
			else { print "<td>".GetName($result5['user_id'])."</td>"; }
			print "
			<td>$result5[ip_address]</td>
			<td>".date("F j, Y - g:iA", strtotime($result5['date_added']))."</td>
			<td>".date("F j, Y", strtotime($result5['date_unban']))."</td>
			<td>$result5[reason]</td>
			<td>$status</td>
			<td>$result5[admin]</td>
				</tr>
			";
		} ?>
		</table>
<?php } ?>
</div>
</div>
<?php }
} ?>