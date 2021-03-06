<?php if($inf['AdminLevel'] >= 1337 || $inf['ShopTech'] > 0) { ?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li><?php echo $section; ?> > Viewing Trackers</li></ol>
	<?php
	if(isset($_GET['n']) && $_GET['n'] == 1) { echo "<div class='acp-error'>That player doesn't exist!</div>"; }
	if(isset($_GET['n']) && $_GET['n'] == 2) { echo "<div class='acp-message'>Successfully added to the tracker!</div>"; }
	?>
<?php if($_GET['item'] == "house") { ?>
<div class='section_title'><h2>House Tracker</h2></div>
<div class='acp-box'>
	<h3>Add a House</h3>
	<form method="POST" action="cr/proc.php">
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
			<tr class='tablerow1'>
				<td width='10%'>Player Name</td>
				<td width='25%'>
					<input type="text" name="player" length="64">
				</td>
				<td width='10%'>House ID</td>
				<td width='25%'>
					<input type="text" name="houseid" length="64">
				</td>
				<td width='10%'>Order ID</td>
				<td width='25%'>
					<input type="text" name="orderid" length="64">
				</td>
				<td width='10%'>House-Move</td>
				<td width='25%'>
					<input type="hidden" name="house_move" readonly="readonly" value="0"><input type="checkbox" name="house_move" value="1">
				</td>
				<td width='10%'>
					<input type="hidden" name="action" readonly="readonly" value="trackadd_house">
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<input type="hidden" name="admin_id" readonly="readonly" value="<?php echo $inf['id']; ?>">
					<input type="submit" class="button" value="Add House">
				</td>
			</tr>
		</table>
	</form>
</div>
<div class='acp-box'>
	<h3>House Track List</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th>Player Name</th><th>House ID</th><th>Order ID</th><th>House Move</th><th>Added By</th><th>Date</th><th>Remove</th>
		</tr>
	<?php $sql = mysql_query("SELECT * FROM `track_house` ORDER BY `id` ASC");
		while ($result = mysql_fetch_array($sql)) {
			if (isset($i) && $i == 1) {
				print "<tr>";
			$i=0;
			} else {
				print "<tr class='tablerow1'>";
			$i=1;
			}
			
			if($result['house_move'] == 0) { $result['house_move'] = "No"; }
			if($result['house_move'] == 1) { $result['house_move'] = "Yes"; }
			
			$remove = "
			<form method='POST' action='cr/proc.php'>
			<input type='hidden' name='action' readonly='readonly' value='trackremove'>
			<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
			<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
			<input type='hidden' name='id' readonly='readonly' value='$result[id]'>
			<input type='hidden' name='player' readonly='readonly' value='".GetName($result['player_id'])."'>
			<input type='hidden' name='tracktype' readonly='readonly' value='house'>
			<input type='image' src='../../global/images/all/icons/cross.png' alt='Remove'></form>
			";
			
		print "
			<td>".GetName($result['player_id'])."</td>
			<td>$result[house_id]</td>
			<td>$result[order_id]</td>
			<td>$result[house_move]</td>
			<td>".GetName($result['admin_id'])."</td>
			<td>$result[date]</td>
			<td>$remove</td>
				</tr>
			";
		} ?>
		</table>
</div>
<?php } ?>
<?php if($_GET['item'] == "backdoor") { ?>
<div class='section_title'><h2>Backdoor Tracker</h2></div>
<div class='acp-box'>
	<h3>Add a Backdoor</h3>
	<form method="POST" action="cr/proc.php">
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
			<tr class='tablerow1'>
				<td width='10%'>Player Name</td>
				<td width='25%'>
					<input type="text" name="player" length="64">
				</td>
				<td width='10%'>Order ID</td>
				<td width='25%'>
					<input type="text" name="orderid" length="64">
				</td>
				<td width='10%'>House ID</td>
				<td width='25%'>
					<input type="text" name="houseid" length="64">
				</td>
				<td width='10%'>Door ID</td>
				<td width='25%'>
					<input type="text" name="doorid" length="64">
				</td>
				<td width='10%'>
					<input type="hidden" name="action" readonly="readonly" value="trackadd_backdoor">
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<input type="hidden" name="admin_id" readonly="readonly" value="<?php echo $inf['id']; ?>">
					<input type="submit" class="button" value="Add Door">
				</td>
			</tr>
		</table>
	</form>
</div>
<div class='acp-box'>
	<h3>Backdoor Track List</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th>Player Name</th><th>Order ID</th><th>House ID</th><th>Door ID</th><th>Added By</th><th>Date</th><th>Remove</th>
		</tr>
	<?php $sql = mysql_query("SELECT * FROM `track_backdoor` ORDER BY `id` ASC");
		while ($result = mysql_fetch_array($sql)) {
			if (isset($i) && $i == 1) {
				print "<tr>";
			$i=0;
			} else {
				print "<tr class='tablerow1'>";
			$i=1;
			}
			
			$remove = "
			<form method='POST' action='cr/proc.php'>
			<input type='hidden' name='action' readonly='readonly' value='trackremove'>
			<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
			<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
			<input type='hidden' name='id' readonly='readonly' value='$result[id]'>
			<input type='hidden' name='player' readonly='readonly' value='".GetName($result['player_id'])."'>
			<input type='hidden' name='tracktype' readonly='readonly' value='backdoor'>
			<input type='image' src='../../global/images/all/icons/cross.png' alt='Remove'></form>
			";
			
		print "
			<td>".GetName($result['player_id'])."</td>
			<td>$result[order_id]</td>
			<td>$result[house_id]</td>
			<td>$result[door_id]</td>
			<td>".GetName($result['admin_id'])."</td>
			<td>$result[date]</td>
			<td>$remove</td>
				</tr>
			";
		} ?>
		</table>
</div>
<?php }
if($_GET['item'] == "gate") { ?>
<div class='section_title'><h2>Gate Tracker</h2></div>
<div class='acp-box'>
	<h3>Add a Gate</h3>
	<form method="POST" action="cr/proc.php">
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
			<tr class='tablerow1'>
				<td width='10%'>Player Name</td>
				<td width='25%'>
					<input type="text" name="player" length="64">
				</td>
				<td width='10%'>Order ID</td>
				<td width='25%'>
					<input type="text" name="orderid" length="64">
				</td>
				<td width='10%'>House ID</td>
				<td width='25%'>
					<input type="text" name="houseid" length="64">
				</td>
				<td width='10%'>Gate ID</td>
				<td width='25%'>
					<input type="text" name="gateid" length="64">
				</td>
				<td width='10%'>Gate-Move</td>
				<td width='25%'>
					<input type="hidden" name="house_move" readonly="readonly" value="0"><input type="checkbox" name="house_move" value="1">
				</td>
				<td width='10%'>
					<input type="hidden" name="action" readonly="readonly" value="trackadd_gate">
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<input type="hidden" name="admin_id" readonly="readonly" value="<?php echo $inf['id']; ?>">
					<input type="submit" class="button" value="Add Gate">
				</td>
			</tr>
		</table>
	</form>
</div>
<div class='acp-box'>
	<h3>Gate Track List</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th>Player Name</th><th>Order ID</th><th>House ID</th><th>Gate ID</th><th>Gate Move</th><th>Added By</th><th>Date</th><th>Remove</th>
		</tr>
	<?php $sql = mysql_query("SELECT * FROM `track_gate` ORDER BY `id` ASC");
		while ($result = mysql_fetch_array($sql)) {
			if (isset($i) && $i == 1) {
				print "<tr>";
			$i=0;
			} else {
				print "<tr class='tablerow1'>";
			$i=1;
			}
			
			if($result['gate_move'] == 0) { $result['gate_move'] = "No"; }
			if($result['gate_move'] == 1) { $result['gate_move'] = "Yes"; }
			
			$remove = "
			<form method='POST' action='cr/proc.php'>
			<input type='hidden' name='action' readonly='readonly' value='trackremove'>
			<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
			<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
			<input type='hidden' name='id' readonly='readonly' value='$result[id]'>
			<input type='hidden' name='player' readonly='readonly' value='".GetName($result['player_id'])."'>
			<input type='hidden' name='tracktype' readonly='readonly' value='gate'>
			<input type='image' src='../../global/images/all/icons/cross.png' alt='Remove'></form>
			";
			
		print "
			<td>".GetName($result['player_id'])."</td>
			<td>$result[order_id]</td>
			<td>$result[house_id]</td>
			<td>$result[gate_id]</td>
			<td>$result[gate_move]</td>
			<td>".GetName($result['admin_id'])."</td>
			<td>$result[date]</td>
			<td>$remove</td>
				</tr>
			";
		} ?>
		</table>
</div>
<?php }
if($_GET['item'] == "vip") { ?>
<div class='section_title'><h2>VIP Tracker</h2></div>
<div class='acp-box'>
	<h3>Add a VIP</h3>
	<form method="POST" action="cr/proc.php">
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
			<tr class='tablerow1'>
				<td width='10%'>Player Name</td>
				<td width='25%'>
					<input type="text" name="player" length="64">
				</td>
				<td width='10%'>VIP Level</td>
				<td width='25%'>
					<select name="vip">
						<option value="1">Bronze</option>
						<option value="2">Silver</option>
					</select>
				</td>
				<td width='10%'>Order ID</td>
				<td width='25%'>
					<input type="text" name="orderid" size="6">
				</td>
				<td width='10%'>VIPM</td>
				<td width='25%'>
					<input type="text" name="vipm" size="5">
				</td>
				<td width='10%'>Expiration</td>
				<td width='25%'>
					<input type="text" name="expire" size="13" onclick="this.value='';" onfocus="this.select()" onblur="this.value=!this.value?'Number of months':this.value;" value="Number of months">
				</td>
				<td width='10%'>
					<input type="hidden" name="action" readonly="readonly" value="trackadd_vip">
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<input type="hidden" name="admin_id" readonly="readonly" value="<?php echo $inf['id']; ?>">
					<input type="submit" class="button" value="Add VIP">
				</td>
			</tr>
		</table>
	</form>
</div>
<div class='acp-box'>
	<h3>VIP Track List</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th>Player Name</th><th>VIP Level</th><th>Order ID</th><th>VIPM</th><th>Expires In</th><th>Added By</th><th>Date</th><th>Remove</th>
		</tr>
	<?php $sql = mysql_query("SELECT * FROM `track_vip` ORDER BY `id` ASC");
		while ($result = mysql_fetch_array($sql)) {
			if (isset($i) && $i == 1) {
				print "<tr>";
			$i=0;
			} else {
				print "<tr class='tablerow1'>";
			$i=1;
			}
			
			if($result['vip'] == 1) { $result['vip'] = "Bronze"; }
			if($result['vip'] == 2) { $result['vip'] = "Silver"; }
			
			$remove = "
			<form method='POST' action='cr/proc.php'>
			<input type='hidden' name='action' readonly='readonly' value='trackremove'>
			<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
			<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
			<input type='hidden' name='id' readonly='readonly' value='$result[id]'>
			<input type='hidden' name='player' readonly='readonly' value='".GetName($result['player_id'])."'>
			<input type='hidden' name='tracktype' readonly='readonly' value='vip'>
			<input type='image' src='../../global/images/all/icons/cross.png' alt='Remove'></form>
			";
			
		print "
			<td>".GetName($result['player_id'])."</td>
			<td>$result[vip]</td>
			<td>$result[order_id]</td>
			<td>$result[vipm]</td>
			<td>$result[expiration] month(s)</td>
			<td>".GetName($result['admin_id'])."</td>
			<td>$result[date]</td>
			<td>$remove</td>
				</tr>
			";
		} ?>
		</table>
</div>
<?php }
if($_GET['item'] == "gvip") { ?>
<div class='section_title'><h2>Gold VIP Tracker</h2></div>
<div class='acp-box'>
	<h3>Add a Gold VIP</h3>
	<form method="POST" action="cr/proc.php">
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
			<tr class='tablerow1'>
				<td width='10%'>Player Name</td>
				<td width='25%'>
					<input type="text" name="player" length="64">
				</td>
				<td width='10%'>Order ID</td>
				<td width='25%'>
					<input type="text" name="orderid" size="6">
				</td>
				<td width='10%'>VIPM</td>
				<td width='25%'>
					<input type="text" name="vipm" size="5">
				</td>
				<td width='10%'>Expiration</td>
				<td width='25%'>
					<input type="text" name="expire" size="13" onclick="this.value='';" onfocus="this.select()" onblur="this.value=!this.value?'Number of months':this.value;" value="Number of months">
				</td>
				<td width='10%'>Gift</td>
				<td width='25%'>
					<input type="hidden" name="gift" readonly="readonly" value="0"><input type="checkbox" name="gift" value="1">
				</td>
				<td width='10%'>Renewal</td>
				<td width='25%'>
					<input type="hidden" name="renew" readonly="readonly" value="0"><input type="checkbox" name="renew" value="1">
				</td>
				<td width='10%'>
					<input type="hidden" name="action" readonly="readonly" value="trackadd_gvip">
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<input type="hidden" name="admin_id" readonly="readonly" value="<?php echo $inf['id']; ?>">
					<input type="submit" class="button" value="Add Gold VIP">
				</td>
			</tr>
		</table>
	</form>
</div>
<div class='acp-box'>
	<h3>Gold VIP Track List</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th>Player Name</th><th>Order ID</th><th>VIPM</th><th>Expires In</th><th>Gift</th><th>Renewal</th><th>Added By</th><th>Date</th><th>Remove</th>
		</tr>
	<?php $sql = mysql_query("SELECT * FROM `track_gvip` ORDER BY `id` ASC");
		while ($result = mysql_fetch_array($sql)) {
			if (isset($i) && $i == 1) {
				print "<tr>";
			$i=0;
			} else {
				print "<tr class='tablerow1'>";
			$i=1;
			}
			
			if($result['gift'] == 0) { $result['gift'] = "No"; }
			if($result['gift'] == 1) { $result['gift'] = "Yes"; }
			if($result['renewal'] == 0) { $result['renewal'] = "No"; }
			if($result['renewal'] == 1) { $result['renewal'] = "Yes"; }
			
			$remove = "
			<form method='POST' action='cr/proc.php'>
			<input type='hidden' name='action' readonly='readonly' value='trackremove'>
			<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
			<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
			<input type='hidden' name='id' readonly='readonly' value='$result[id]'>
			<input type='hidden' name='player' readonly='readonly' value='".GetName($result['player_id'])."'>
			<input type='hidden' name='tracktype' readonly='readonly' value='gvip'>
			<input type='image' src='../../global/images/all/icons/cross.png' alt='Remove'></form>
			";
			
		print "
			<td>".GetName($result['player_id'])."</td>
			<td>$result[order_id]</td>
			<td>$result[vipm]</td>
			<td>$result[expiration] month(s)</td>
			<td>$result[gift]</td>
			<td>$result[renewal]</td>
			<td>".GetName($result['admin_id'])."</td>
			<td>$result[date]</td>
			<td>$remove</td>
				</tr>
			";
		} ?>
		</table>
</div>
<?php }
if($_GET['item'] == "pvip") { ?>
<div class='section_title'><h2>Platinum VIP Tracker</h2></div>
<div class='acp-box'>
	<h3>Add a Platinum VIP</h3>
	<form method="POST" action="cr/proc.php">
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
			<tr class='tablerow1'>
				<td width='10%'>Player Name</td>
				<td width='25%'>
					<input type="text" name="player" length="64">
				</td>
				<td width='10%'>VIPM</td>
				<td width='25%'>
					<input type="text" name="vipm" size="3">
				</td>
				<td width='10%'>Shop Email</td>
				<td width='25%'>
					<input type="text" name="email" size="6">
				</td>
				<td width='10%'>Restricted Vehicle</td>
				<td width='25%'>
					<input type="text" name="restrictveh" size="10" onclick="this.value='';" onfocus="this.select()" onblur="this.value=!this.value?'Vehicle ID only!':this.value;" value="Vehicle ID only!">
				</td>
				<td width='10%'>Amount Donated</td>
				<td width='25%'>
					<input type="text" name="donate" size="3">
				</td>
				<td width='10%'>
					<input type="hidden" name="action" readonly="readonly" value="trackadd_pvip">
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<input type="hidden" name="admin_id" readonly="readonly" value="<?php echo $inf['id']; ?>">
					<input type="submit" class="button" value="Add Platinum VIP">
				</td>
			</tr>
		</table>
	</form>
</div>
<div class='acp-box'>
	<h3>Platinum VIP Track List</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th>Player Name</th><th>VIPM</th><th>Shop Email</th><th>Restricted Vehicle</th><th>Amount Donated</th><th>Added By</th><th>Date</th><th>Remove</th>
		</tr>
	<?php $sql = mysql_query("SELECT * FROM `track_pvip` ORDER BY `id` ASC");
		while ($result = mysql_fetch_array($sql)) {
			if (isset($i) && $i == 1) {
				print "<tr>";
			$i=0;
			} else {
				print "<tr class='tablerow1'>";
			$i=1;
			}
			
			$remove = "
			<form method='POST' action='cr/proc.php'>
			<input type='hidden' name='action' readonly='readonly' value='trackremove'>
			<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
			<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
			<input type='hidden' name='id' readonly='readonly' value='$result[id]'>
			<input type='hidden' name='player' readonly='readonly' value='".GetName($result['player_id'])."'>
			<input type='hidden' name='tracktype' readonly='readonly' value='pvip'>
			<input type='image' src='../../global/images/all/icons/cross.png' alt='Remove'></form>
			";
			
		print "
			<td>".GetName($result['player_id'])."</td>
			<td>$result[vipm]</td>
			<td>$result[shop_email]</td>
			<td>$result[restrict_veh]</td>
			<td>$".number_format($result['donate'])."</td>
			<td>".GetName($result['admin_id'])."</td>
			<td>$result[date]</td>
			<td>$remove</td>
				</tr>
			";
		} ?>
		</table>
</div>
<?php }
if($_GET['item'] == "ts") { ?>
<div class='section_title'><h2>TeamSpeak Channel Tracker</h2></div>
<div class='acp-box'>
	<h3>Add a TeamSpeak User Channel</h3>
	<form method="POST" action="cr/proc.php">
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
			<tr class='tablerow1'>
				<td width='10%'>Username</td>
				<td width='25%'>
					<input type="text" name="player" size="15">
				</td>
				<td width='10%'>Order ID</td>
				<td width='25%'>
					<input type="text" name="orderid" size="5">
				</td>
				<td width='10%'>Database ID</td>
				<td width='25%'>
					<input type="text" name="db_id" size="5">
				</td>
				<td width='10%'>Channel Name</td>
				<td width='25%'>
					<input type="text" name="channel" size="15">
				</td>
				<td width='10%'>
					<input type="hidden" name="action" readonly="readonly" value="trackadd_ts">
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<input type="hidden" name="admin_id" readonly="readonly" value="<?php echo $inf['id']; ?>">
					<input type="submit" class="button" value="Add Channel">
				</td>
			</tr>
		</table>
	</form>
</div>
<div class='acp-box'>
	<h3>TeamSpeak Channel Track List</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th>Username</th><th>Order ID</th><th>Database ID</th><th>Channel Name</th><th>Added By</th><th>Date</th><th>Remove</th>
		</tr>
	<?php $sql = mysql_query("SELECT * FROM `track_ts` ORDER BY `id` ASC");
		while ($result = mysql_fetch_array($sql)) {
			if (isset($i) && $i == 1) {
				print "<tr>";
			$i=0;
			} else {
				print "<tr class='tablerow1'>";
			$i=1;
			}
			
			$remove = "
			<form method='POST' action='cr/proc.php'>
			<input type='hidden' name='action' readonly='readonly' value='trackremove'>
			<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
			<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
			<input type='hidden' name='id' readonly='readonly' value='$result[id]'>
			<input type='hidden' name='player' readonly='readonly' value='$result[name]'>
			<input type='hidden' name='tracktype' readonly='readonly' value='ts'>
			<input type='image' src='../../global/images/all/icons/cross.png' alt='Remove'></form>
			";
			
		print "
			<td>$result[name]</td>
			<td>$result[order_id]</td>
			<td>$result[database_id]</td>
			<td>$result[channel_name]</td>
			<td>".GetName($result['admin_id'])."</td>
			<td>$result[date]</td>
			<td>$remove</td>
				</tr>
			";
		} ?>
		</table>
</div>
<?php }
if($_GET['item'] == "business") { ?>
<div class='section_title'><h2>Business Tracker</h2></div>
<?php /* ?>
<div class='acp-box'>
	<h3>Add a Business</h3>
	<form method="POST" action="cr/proc.php">
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'> 
			<tr class='tablerow1'>
				<td width='10%'>Username</td>
				<td width='25%'>
					<input type="text" name="player" size="15">
				</td>
				<td width='10%'>Order ID</td>
				<td width='25%'>
					<input type="text" name="orderid" size="5">
				</td>
				<td width='10%'>Database ID</td>
				<td width='25%'>
					<input type="text" name="db_id" size="5">
				</td>
				<td width='10%'>Channel Name</td>
				<td width='25%'>
					<input type="text" name="channel" size="15">
				</td>
				<td width='10%'>
					<input type="hidden" name="action" readonly="readonly" value="trackadd_ts">
					<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
					<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
					<input type="hidden" name="admin_id" readonly="readonly" value="<?php echo $inf['id']; ?>">
					<input type="submit" class="button" value="Add Channel">
				</td>
			</tr>
		</table>
	</form>
</div>
<?php */ ?>
<div class='acp-box'>
	<h3>Business Track List</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th>ID</th><th>Name</th><th>Type</th><th>Date Added</th><th>Owner</th><th>Expiration Date (Days Remaining)</th>
		</tr>
	<?php $sql = mysql_query("SELECT `Id`, `Name`, `Type`, `OwnerID`, `OrderDate`, `Months` FROM `businesses` ORDER BY `id` ASC");
		while ($result = mysql_fetch_array($sql)) {
			if (isset($i) && $i == 1) {
				print "<tr>";
			$i=0;
			} else {
				print "<tr class='tablerow1'>";
			$i=1;
			}
			
			$unixtodate = date("M j, Y", $result['Months']);
			$diff = strtotime("$unixtodate") - strtotime("now");
			$num = $diff/86400;
			$days = intval($num);
		
			switch($result['Type'])
			{
				case 1:
					$biztype = "Gas Station";
					break;
				case 2:
					$biztype = "Clothing Store";
					break;
				case 3:
					$biztype = "Restaurant";
					break;
				case 4:
					$biztype = "Gun Shop";
					break;
				case 5:
					$biztype = "New Car Dealership";
					break;
				case 6:
					$biztype = "Used Car Dealership";
					break;
				case 7:
					$biztype = "Mechanic";
					break;
				case 8:
					$biztype = "24/7";
					break;
				case 9:
					$biztype = "Bar";
					break;
				case 10:
					$biztype = "Club";
					break;
				case 11:
					$biztype = "Sex Shop";
					break;
				default:
					$biztype = "Undefined";
					break;
			}
		
			if($days <= 0)
			{
				print "
				<td style='color:red'>$result[Id]</td>
				<td style='color:red'>$result[Name]</td>
				<td style='color:red'>$biztype</td>
				<td style='color:red'>$result[OrderDate]</td>
				<td style='color:red'>".GetName($result['OwnerID'])."</td>";
				if($result['Months'] == 0) print "<td style='color:red'>Not set</td>";
				else print "<td style='color:red'>$unixtodate</td>";
			}
			else if($days == 1)
			{
				print "
				<td style='color:orange'>$result[Id]</td>
				<td style='color:orange'>$result[Name]</td>
				<td style='color:orange'>$biztype</td>
				<td style='color:orange'>$result[OrderDate]</td>
				<td style='color:orange'>".GetName($result['OwnerID'])."</td>
				<td style='color:orange'>$unixtodate ($days day)</td>
				";
			}
			else
			{
				print "
				<td style='color:lime'>$result[Id]</td>
				<td style='color:lime'>$result[Name]</td>
				<td style='color:lime'>$biztype</td>
				<td style='color:lime'>$result[OrderDate]</td>
				<td style='color:lime'>".GetName($result['OwnerID'])."</td>
				<td style='color:lime'>$unixtodate (".number_format($days)." days)</td>
				";
			}
			print "</tr>";
		} ?>
		</table>
</div>
<?php } ?>
</div>
<?php } 
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>