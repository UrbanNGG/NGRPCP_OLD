<?php
$userid = $inf['id'];
$ip = $_SERVER['REMOTE_ADDR'];
if (!isset($_GET['oid'])) {
?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li><?php echo $section; ?> > History</li></ol>
	<div class='section_title'><h2>Your Purchase History</h2></div>
	<?php if(isset($addmsg)) { echo $addmsg; } if(isset($removemsg)) { echo $removemsg; } ?>
	<?php 
	$userCart = mysql_query("SELECT * FROM `cp_store_orders` WHERE `customer_id`='".$userid."';");
	$uCart = mysql_num_rows($userCart);
	?>
	<style>
			.tablerow1:hover, .tablerow2:hover {
				background-color:#fffdd1;
			}
			</style>
	<div class='acp-box'>
		<h3></h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
			<th>Order ID</th><th>Token Amount</th><th>Price</th><th>Purchase Type</th><th></th>
			<?php
				while($cart = mysql_fetch_array($userCart)) {
					if(isset($i) && $i == 1) {
							print "<tr class='tablerow1'>";
						$i=0;
						} else { 
							print "<tr class='tablerow2'>";
						$i=1;
						}
					if($cart['gift_player_id'] == '') { $type = 'Self'; } else { $type = 'Gift'; }
					echo "
							<td style='width: 23%;font-size:12px'>".$cart['id']."</td>
							<td style='width: 23%;font-size:12px'>".number_format($cart['pack_total_tokens'])."</td>
							<td style='width: 23%;font-size:12px'>$".number_format($cart['pack_total_price'],2)." USD</td>
							<td style='width: 23%;font-size:12px'>".$type."</td>
							<td style='width: 20%;font-size:12px'><a href='?p=history&oid=".$cart['id']."'><button class='realbutton'>View Order</button></a></td>
						</tr>
					";
				}
				if ($uCart == 0) {
					echo "<tr class='acp-actionbar'><td colspan='5'>You have not made any purchases! <br><a href='store.php?p=main'><b>Go to the store</a></td></tr>";
				} else {
				echo "<tr class='acp-actionbar'>
							<td colspan='5'><b>*Click on an order to see more details.</b></td>
						</tr>";
				}
			?>
		</table>
	</div>
</div>
<?php 
} else {
if (!preg_match("/^[0-9]{1,6}+$/", $_GET['oid'])) {
		print "<meta http-equiv=\"refresh\" content=\"0;url=store.php?p=history\">";exit();
	} else {
		$orderid = $_GET['oid'];
	}
?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li><?php echo $section; ?> > History</li></ol>
	<div class='section_title'><h2>Your Purchase History</h2></div>
	<?php if(isset($addmsg)) { echo $addmsg; } if(isset($removemsg)) { echo $removemsg; } ?>
	<?php 
	$userCart = mysql_query("SELECT * FROM `cp_store_orders` WHERE `customer_id`='".$userid."' AND `id` = '".$orderid."';");
	$cart = mysql_fetch_array($userCart);
	$uCart = mysql_num_rows($userCart);
	?>
	<a href="?p=history"><input style='float:left;width:100px;display: inline;font-size:10px;' type='button' class='button' value='Back'></a><br><br>
	<div class='acp-box'>
		<h3>Viewing Details for Order #<?php echo $orderid; ?></h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
			<tr class='tablerow2'>
			<td>Date Purchased:</td><td><?php echo date('F j, h:i:s A', strtotime($cart['date_purchased'])); ?></td>
			</tr>
			<tr class='tablerow2'>
			<td>Tokens:</td><td><?php echo number_format($cart['pack_total_tokens']); ?></td>
			</tr>
			<tr class='tablerow2'>
			<td>Price:</td><td><?php echo "$".number_format($cart['pack_total_price'],2); ?> USD</td>
			</tr>
			<tr class='tablerow2'>
			<?php if($cart['gift_player_id'] == '') { ?>
			<td>Gifted*:</td><td>No</td>
			</tr>
			<tr class='tablerow2'>
			<?php } else { ?>
			<td>Gifted*:</td><td>Yes</td>
			</tr>
			<tr class='tablerow2'>
			<td>Player Gifted:</td><td><?php echo GetName($cart['gift_player_id']); ?></td>
			</tr>
			<tr class='tablerow2'>
			<?php } ?>
			<td>Payment Method:</td><td><?php echo $cart['payment_method']; ?></td>
			</tr>
			<tr class='tablerow2'>
			<td>Payment Address:</td><td><?php echo $cart['payment_address']; ?></td>
			</tr>
		</table>
	</div>
</div>
<?php
}
?>