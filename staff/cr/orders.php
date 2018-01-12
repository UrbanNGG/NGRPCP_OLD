<?php
$userid = $inf['id'];
$ip = $_SERVER['REMOTE_ADDR'];
if (!isset($_GET['oid'])) {
?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li><?php echo $section; ?> > Orders</li></ol>
	<div class='section_title'><h2>View Orders</h2></div>
	<?php if(isset($addmsg)) { echo $addmsg; } if(isset($removemsg)) { echo $removemsg; } ?>
	<?php 
	$userCart = mysql_query("SELECT * FROM `cp_store_orders` ORDER BY `date_purchased` DESC;");
	$uCart = mysql_num_rows($userCart);
	$msales = mysql_query("SELECT SUM(pack_total_price) AS `sum` FROM `cp_store_orders` WHERE `order_status` = 'Completed' AND MONTH(`date_purchased`) = MONTH(NOW())");
	$msalesr = mysql_fetch_array($msales);
	$q = mysql_query("SELECT SUM(pack_total_price) AS `sum` FROM `cp_store_orders` WHERE `order_status` = 'Completed'");
	$r = mysql_fetch_array($q);
	$customersq = mysql_query("SELECT `customer_id` AS date, count(`customer_id`) AS orders
					FROM `cp_store_orders` WHERE `order_status` = 'Completed'
					GROUP BY date
					ORDER BY date ASC");
					$customers = mysql_num_rows($customersq);
	?>
	<div class='acp-box' style='width:49%;float:left;'>
		<h3><img src='https://127.0.0.1/cp//global/images/all/store/calendar.png' /> Overview</h3>
		<table cellpadding='0' style='height:180px;' class='double_pad' cellspacing='0' border='0'>
			<tr class='tablerow3'>
				<td width='50%' style='text-align:left;'>Total Sales:</td>
				<td width='50%' style='text-align:right;'><?php echo "$".number_format($r['sum'], 2); ?></td>
			</tr>
			<tr class='tablerow3'>
				<td width='50%' style='text-align:left;'>This Month's Sales:</td>
				<td width='50%' style='text-align:right;'><?php echo "$".number_format($msalesr['sum'], 2); ?></td>
			</tr>
			<tr class='tablerow3'>
				<td width='50%' style='text-align:left;'>Total Orders:</td>
				<td width='50%' style='text-align:right;'><?php echo $uCart; ?></td>
			</tr>
			<tr class='tablerow3'>
				<td width='50%' style='text-align:left;'>Total Customers:</td>
				<td width='50%' style='text-align:right;'><?php echo $customers; ?></td>
			</tr>
		</table>
	</div>
	<div class='acp-box' style='width:49%;float:right;'>
		<h3><img src='https://127.0.0.1/cp//global/images/all/store/table_money.png' /> Statistics</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0'>
			<tr class='tablerow3'>
			<script type="text/javascript" src="https://www.google.com/jsapi"></script>
			<script type="text/javascript">
			  google.load("visualization", "1", {packages:["corechart"]});
			  google.setOnLoadCallback(drawChart);
			  function drawChart() {
				var data = google.visualization.arrayToDataTable([
				  ['Day', 'Total Sales $', 'Total Orders'],
				  <?php
					$dataquery = mysql_query("SELECT DISTINCT(date(`date_purchased`)) AS date, count( * ) AS count, sum(`pack_total_price`) AS sales
					FROM `cp_store_orders` WHERE `order_status` = 'Completed'
					GROUP BY date
					ORDER BY date ASC");
					while($data = mysql_fetch_array($dataquery)) {
						echo "['".date('M j', strtotime($data['date']))."', ".$data['sales'].", ".number_format($data['count'], 2)."],";
					}
				  ?>
				]);

				var options = {
					chartArea: {width: '70%', height: '70%'},
					backgroundColor: '#fafafa',
					colors:['#657b97','#65a36a'],
					legend: {position: 'right'},
					hAxis: {title: '',  titleTextStyle: {color: 'blue'}}
				};

				var chart = new google.visualization.AreaChart(document.getElementById('chart_div'));
				chart.draw(data, options);
			  }
			</script>
				<td rowspan='4' width='100%'><div style='align: center;height:160px;' id="chart_div"></div></td>
			</tr>
		</table>
	</div>
	<div style='margin-top:250px;'></div>
	<style>
	.tablerow1:hover, .tablerow2:hover {
		background-color:#fffdd1;
	}
	</style>
	<div class='acp-box'>
		<h3><img src='https://127.0.0.1/cp//global/images/all/store/clipboard.png' /> Orders</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='1' width='100%' style='border-color:#ccc;'>
			<th>Order ID</th><th>Customer</th><th>Credit Amount</th><th>Price</th><th>Purchase Type</th><th>Date Purchased</th><th>Status</th><th>Action</th>
			<tr class='acp-actionbar'>
		<td style='width: 10%;'><input type='text' size='6'></td>
		<td style='width: 10%;'><input type='text'></td>
		<td style='width: 10%;'><input type='text' size='6'></td>
		<td style='width: 10%;'><input type='text' size='6'></td>
		<td style='width: 10%;'><select name='purchasetype'><option></option><option>Self</option><option>Gift</option></select></td>
		<td style='width: 10%;'><input type='text'></td>
		<td style='width: 10%;'><select name='status'><option></option><option>Pending</option><option>Completed</option><option>Denied</option></select></td>
		<td style='width: 5%;'><input type='submit' class='realbutton' value='Filter'></td>
		</tr>
			<?php
				$sql = "SELECT COUNT(*) FROM `cp_store_orders`";
				$result = mysql_query($sql);
				$r = mysql_fetch_row($result);
				$numrows = $r[0];
				$rowsperpage = 10;
				$totalpages = ceil($numrows / $rowsperpage);
				if (isset($_GET['op']) && is_numeric($_GET['op'])) {
				   $currentpage = (int) $_GET['op'];
				} else {
				   $currentpage = 1;
				} 
				if ($currentpage > $totalpages) {
				   $currentpage = $totalpages;
				}
				if ($currentpage < 1) {
				   $currentpage = 1;
				}
				$offset = ($currentpage - 1) * $rowsperpage;
				$sql = "SELECT * FROM `cp_store_orders` ORDER BY `id` DESC LIMIT $offset, $rowsperpage";
				$result = mysql_query($sql);
				while ($cart = mysql_fetch_assoc($result)) {
				if(isset($i) && $i == 1) {
											print "<tr class='tablerow1'>";
										$i=0;
										} else { 
											print "<tr class='tablerow2'>";
										$i=1;
										}
									if($cart['gift_player_id'] == '') { $type = 'Self'; } else { $type = 'Gift'; }
									echo "
											<td style='width: 10%;'>".$cart['id']."</td>
											<td style='width: 10%;'>".GetName($cart['customer_id'])."</td>
											<td style='width: 10%;'>".number_format($cart['pack_total_tokens'])."</td>
											<td style='width: 10%;'>$".number_format($cart['pack_total_price'], 2)."</td>
											<td style='width: 10%;'>".$type."</td>
											<td style='width: 10%;'>".$cart['date_purchased']."</td>
											<td style='width: 10%;'>".$cart['order_status']."</td>
											<td style='width: 5%;'><a href='http://".$_SERVER['SERVER_NAME']."/staff/cr.php?p=orders&oid=".$cart['id']."'><button class='realbutton'>View Order</button></a></td>
										</tr>
									";
				} 
				$range = 3;
				echo "<tr><td colspan='8'>";
				if ($currentpage > 1) {
				   echo " <a class='realbutton' href='".$_SERVER['PHP_SELF']."?p=orders&op=1'><<</a> ";
				   $prevpage = $currentpage - 1;
				   echo " <a class='realbutton' href='".$_SERVER['PHP_SELF']."?p=orders&op=$prevpage'><</a> ";
				}
				for ($x = ($currentpage - $range); $x < (($currentpage + $range) + 1); $x++) {
				   if (($x > 0) && ($x <= $totalpages)) {
					  if ($x == $currentpage) {
						 echo " <b class='realbutton'>$x</b> ";
					  } else {
						 echo " <a class='realbutton' href='".$_SERVER['PHP_SELF']."?p=orders&op=$x'>$x</a> ";
					  } 
				   } 
				}    
				if ($currentpage != $totalpages) {
				   $nextpage = $currentpage + 1;
				   echo " <a class='realbutton' href='".$_SERVER['PHP_SELF']."?p=orders&op=$nextpage'>></a> ";
				   echo " <a class='realbutton' href='".$_SERVER['PHP_SELF']."?p=orders&op=$totalpages'>>></a>";
				} 
				echo "</td></tr>";
				echo "<tr class='acp-actionbar'>
							<td colspan='8'><b>*Click on an order to see more details.</b></td>
						</tr>";
			?>
		</table>
	</div>
</div>
<?php 
} else {
if (!preg_match("/^[0-9]{1,6}+$/", $_GET['oid'])) {
		print "<meta http-equiv=\"refresh\" content=\"0;url=store.php?p=orders\">";exit();
	} else {
		$orderid = $_GET['oid'];
	}
	$userCart = mysql_query("SELECT * FROM `cp_store_orders` WHERE `id` = '".$orderid."';");
	$cart = mysql_fetch_array($userCart);
	$uCart = mysql_num_rows($userCart);
	
	if(isset($_POST['action']) && $_POST['action'] == 'status') {
		if($inf['ShopTech'] == 3) {
			if($_POST['order_status'] == 'Completed' && $cart['order_status'] != 'Completed') {
				if(IsPlayerOnline($_POST['customer']) == '0') {
					if($q = mysql_query("UPDATE `cp_store_orders` SET `order_status` = 'Completed' WHERE `id` = '".$orderid."';") && $r = mysql_query("UPDATE `accounts` SET `Credits` = `Credits` + '".$_POST['tokens']."', `ReceivedCredits` =  `ReceivedCredits` + '".$_POST['tokens']."' WHERE `id` = '".$_POST['customer']."'")) {
						doLog("$inf[id]", "Customer Relations", "Orders", "Processed Order #$orderid");
						$msg = 'Order has been processed.';
					} else {
						$msg = 'Error with database. Try again later.';
					}
				} else {
					$msg = 'Player is currently online. Try again later.';
				}
			} else {
				$msg = 'Order has already been processed.';
			}
			if($_POST['order_status'] == 'Denied') {
				$q = mysql_query("UPDATE `cp_store_orders` SET `order_status` = 'Denied' WHERE `id` = '".$orderid."';");
				doLog("$inf[id]", "Customer Relations", "Orders", "Denied Order #$orderid");
			}
		} else {
			$msg = 'You need to be the (a)DoCR to process or deny any orders.';
		}
	}
?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li><?php echo $section; ?> > Orders</li></ol>
	<div class='section_title'><h2>View Orders</h2></div>
	<a href="?p=orders"><input style='float:left;width:100px;display: inline;font-size:10px;' type='button' class='button' value='Back'></a><br><br>
	<?php if(isset($msg)) { echo "<div class='acp-message'>".$msg."</div>"; } ?>
	<div class='acp-box'>
		<h3><img src='https://127.0.0.1/cp//global/images/all/store/contact.png'> Viewing Details for Order #<?php echo $orderid; ?></h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
			<tr class='tablerow2'>
			<td width="50%">Date Purchased:</td><td><?php echo date('F j, h:i:s A', strtotime($cart['date_purchased'])); ?></td>
			</tr>
			<tr class='tablerow2'>
			<td>Credits:</td><td><?php echo number_format($cart['pack_total_tokens'])."&nbsp;";
					if($cart['pack_total_tokens'] < 500) {
						echo "<img src='https://127.0.0.1/cp//global/images/all/store/coin_single.png' title='credits'>";
					}
					if($cart['pack_total_tokens'] >= 500) {
						echo "<img src='https://127.0.0.1/cp//global/images/all/store/coin_stack.png' title='credits'>";
					}
				?></td>
			</tr>
			<tr class='tablerow2'>
			<td>Price:</td><td><?php echo "$".number_format($cart['pack_total_price'], 2); ?></td>
			</tr>
			<tr class='tablerow2'>
			<?php if($cart['gift_player_id'] == '') {?>
			<td>Gifted*:</td><td>No</td>
			</tr>
			<tr class='tablerow2'>
			<?php } else { ?>
			<td>Gifted*:</td><td>Yes</td>
			</tr>
			<tr class='tablerow2'>
			<td>Player Gifted:</td><td><?php echo GetName($cart['gift_player_id']); ?></td>
			</tr>
			<?php } ?>
			<tr class='tablerow2'>
			<td>Payment Method:</td><td><?php echo $cart['payment_method']; ?></td>
			</tr>
			<tr class='tablerow2'>
			<td width="50%">PayPal Order ID:</td><td><?php echo $cart['order_id']; ?></td>
			</tr>
			<tr class='tablerow2'>
			<td>Payment Address:</td><td><?php echo $cart['payment_address']; ?></td>
			</tr>
			<tr class='tablerow2'>
			<td>IP Address:</td><td><?php echo FlagWithIP($cart['customer_ip_address']); ?></td>
			</tr>
		</table>
	</div>
	<br>
	<div class='acp-box'>
		<h3><img src='https://127.0.0.1/cp//global/images/all/store/clipboard.png'> Edit Information</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
			<form method="POST">
			<tr class='tablerow2'>
			<td width="50%">
			Order Status:
			</td>
			<td>
				<select name="order_status">
					<option value='Pending' <?php if($cart['order_status'] == 'Pending') { echo "selected='selected'"; } ?>>Pending</option>
					<option value='Completed' <?php if($cart['order_status'] == 'Completed') { echo "selected='selected'"; } ?>>Completed</option>
					<option value='Denied' <?php if($cart['order_status'] == 'Denied') { echo "selected='selected'"; } ?>>Denied</option>
				</select>
			</td>
			</tr>
			<tr class='acp-actionbar'>
			<input type='hidden' name='tokens' value='<?php echo $cart['pack_total_tokens']; ?>'>
			<input type='hidden' name='customer' value='<?php if($cart['gift_player_id'] == "") { echo $cart['customer_id']; } else { echo $cart['gift_player_id']; } ?>'>
			<td><input type='hidden' name='action' value='status'></td>
			<td><input type='submit' value='Submit' class='realbutton'></td>
			</tr>
			</form>
		</table>
	</div>
</div>
<?php
}
?>