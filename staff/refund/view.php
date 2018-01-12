<?php if($inf['AdminLevel'] > 1 || $access['punish'] == 1) {

if(isset($_GET['o'])) {
	if(intval($_GET['o']) == "" || intval($_GET['o']) == "0") { $viewcode = "0"; }
	if(intval($_GET['o']) == "1") { $viewcode = "1"; }
	if(intval($_GET['o']) == "2") { $viewcode = "2"; }
	if(intval($_GET['o']) == "3") { $viewcode = "3"; }
}
if(!isset($_GET['o'])) { $viewcode = "1"; }
if(isset($viewcode) && $viewcode > 0) {
$viewSQL = "SELECT * FROM `cp_refund` WHERE `status` = '$viewcode' ORDER BY id DESC";
}
else {
$viewSQL = "SELECT * FROM `cp_refund` ORDER BY id DESC";
}
?>

			<div id='content_wrap'> 
				<ol id='breadcrumb'><li>Refunds > View Refunds</li></ol>
				<div class='section_title'><h2>Refunds</h2></div>
			<div class='acp-box'>
				<div class='acp-message3'>Items in bold with an asterisk (*) need to be manually issued.</div>
				<?php
					if(isset($_GET['note']) && $_GET['note'] == 0) { echo "<div class='acp-message'>The refund has been modified!</div>"; }
					if(isset($_GET['note']) && $_GET['note'] == 1) { echo "<div class='acp-message'>The refund has been added!</div>"; }
					if(isset($_GET['note']) && $_GET['note'] == 2) { echo "<div class='acp-message'>The refund has been issued!</div>"; }
					if(isset($_GET['note']) && $_GET['note'] == 3) { echo "<div class='acp-message'>The refund has been removed!</div>"; }
					if(isset($_GET['note']) && $_GET['note'] == 4) { echo "<div class='acp-error'>That player is currently in-game. Please refund them manually in-game or try again later.</div>"; }
				?>
				<h3>Refund List <span class="table_view"><a href="refund.php?p=view&o=0">View All</a>&nbsp;&nbsp;&#8226;&nbsp;&nbsp;<a href="refund.php?p=view&o=1">View Pending</a>&nbsp;&nbsp;&#8226;&nbsp;&nbsp;<a href="refund.php?p=view&o=2">View Issued</a>&nbsp;&nbsp;&#8226;&nbsp;&nbsp;<a href="refund.php?p=view&o=3">View Removed</a></span></h3>

				<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
				<tr>
					<th width='20%'>Player</th>
					<th width='40%'>Items Refunded</th>
					<th width='10%'>Added</th>
					<th width='10%'>Status</th>
					<th width='10%'>Link</th>
					<?php if($viewcode < 2) { print "<th width='10%'>Issue/Remove</th>"; } ?>
				</tr>

				<?php $reff1 = mysql_query($viewSQL);
					while ($ref = mysql_fetch_array($reff1)) {
					
					$player = GetName($ref['user_id']);
					
					$issue = "
					<form method='post' action='refund/proc.php' name='form$ref[id]'>
					<input type='hidden' name='action' readonly='readonly' value='issue'>
					<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
					<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
					<input type='hidden' name='rID' readonly='readonly' value='$ref[id]'>
					<input type='hidden' name='player' readonly='readonly' value='$player'>
					<input type='hidden' name='money' readonly='readonly' value='$ref[money]'>
					<input type='hidden' name='material' readonly='readonly' value='$ref[materials]'>
					<input type='hidden' name='pot' readonly='readonly' value='$ref[pot]'>
					<input type='hidden' name='crack' readonly='readonly' value='$ref[crack]'>
					<input type='hidden' name='boombox' readonly='readonly' value='$ref[boombox]'>
					<input type='hidden' name='viptoken' readonly='readonly' value='$ref[viptoken]'>
					<input type='submit' class='button' value='Issue'></form>
					";
					
					$remove = "
					<form method='post' action='refund/proc.php' name='form$ref[id]'>
					<input type='hidden' name='action' readonly='readonly' value='remove'>
					<input type='hidden' name='ip' readonly='readonly' value='$_SERVER[REMOTE_ADDR]'>
					<input type='hidden' name='admin' readonly='readonly' value='$_SESSION[myusername]'>
					<input type='hidden' name='rID' readonly='readonly' value='$ref[id]'>
					<input type='hidden' name='player' readonly='readonly' value='$player'>
					<input type='submit' class='button' value='Remove'></form>
					";

						if(isset($i) && $i == 1) {
							print "<tr class='tablerow1'>";
						$i=0;
						} else { 
							print "<tr>";
						$i=1;
						}

						if($ref['status'] == '1') { $ref['status'] = 'Pending'; }
						if($ref['status'] == '2') { $ref['status'] = 'Issued'; }
						if($ref['status'] == '3') { $ref['status'] = 'Removed'; }

				print "
					<td><a href=refund.php?p=edit&id=$ref[id]>$player</a></td>
					<td>
				";
				if($ref['money'] > 0) { print "$".number_format($ref['money'])."<br />"; }
				if($ref['materials'] > 0) { print number_format($ref['materials'])." Materials<br />"; }
				if($ref['crack'] > 0) { print number_format($ref['crack'])." Crack<br />"; }
				if($ref['pot'] > 0) { print number_format($ref['pot'])." Pot<br />"; }
				if($ref['boombox'] > 0) { print $ref['boombox']." Boombox<br />"; }
				if($ref['viptoken'] > 0) { print number_format($ref['viptoken'])." VIP Tokens<br />"; }
				if($ref['refund'] <> "") { print "<strong>*".$ref['refund']."</strong>"; }
				print "
					</td>
					<td>$ref[date_added]</td>
					<td>$ref[status]</td>
					<td><a href=$ref[link]>Link</a></td>
				";
				if($ref['status'] == "Pending") {
					if($inf['AdminLevel'] > 3) { print "<td>$issue <br /> $remove</td>"; }
					else { print "<td>$remove</td>"; }
				}
				print "
					</tr>
				";
				} ?>
				</table>
 
				<div class='acp-actionbar'><strong>To edit a refund, click on the offender's name.</strong></div>
			</div></div>
<?php }
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>