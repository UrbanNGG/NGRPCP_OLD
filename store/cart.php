<?php
$userid = $inf['id'];
$ip = $_SERVER['REMOTE_ADDR'];

if(isset($_POST['action']) && $_POST['action'] == 'remove') {
	$cart_id = $_POST['cart_id'];
	$pack_id = $_POST['pack_id'];
	RemoveFromCart($userid, $cart_id);
	$msg = "Pack was removed from your cart!";
}
?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li><?php echo $section; ?> > Checkout</li></ol>
	<div class='section_title'><h2>Your Checkout Cart</h2></div>
	<?php if(isset($msg)) { echo "<div class='acp-message'>".$msg."</div>"; } ?>
	<?php 
	$userCart = mysql_query("SELECT * FROM `cp_store_cart` WHERE `customer_id`='".$userid."' ORDER BY `date_item_added` ASC;");
	?>
	<div class='acp-box'>
		<h3></h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
			<th></th><th>Product ID</th><th>Product Name</th><th>Price</th>
			<?php
				while($cart = mysql_fetch_array($userCart)) {
					if (GetAdditionalTokens($cart['cart_pack_id']) > 0) { $additionalTokens = "<span style='color:green;'>+ ".GetAdditionalTokens($cart['cart_pack_id'])."</span>"; } else { $additionalTokens = ''; }
					if (GetOldPrice($cart['cart_pack_id']) != '') { $price = "<strike style='font-size:9px'>$".GetOldPrice($cart['cart_pack_id'])."</strike><br> $".GetStorePrice($cart['cart_pack_id'])." USD"; } else { $price = "$".GetStorePrice($cart['cart_pack_id'])." USD"; }
					$remove = "<form method='post' name='remove'>
						<input type='hidden' name='cart_id' readonly='readonly' value='".$cart['cart_id']."'>
						<input type='hidden' name='pack_id' readonly='readonly' value='".$cart['cart_pack_id']."'>
						<input type='hidden' name='action' readonly='readonly' value='remove'>
						<input type='submit' style='font-size:10px' class='button' value='Remove'>
					</form>";
					echo "
						<tr class='tablerow1'>
							<td style='width: 25%;'><img src='".GetPackPicture($cart['cart_pack_id'])."' /></td>
							<td style='width: 25%;font-size:12px'>".$cart['cart_pack_id']."</td>
							<td style='width: 25%;font-size:12px'>".number_format(GetTotalTokens($cart['cart_pack_id']))."  ".$additionalTokens." Credits</td>
							<td style='width: 25%;font-size:12px'>".$price."<br>$remove</td>
						</tr>
					";
				}
				if (GetCartSize($userid) == 0) {
					echo "<tr class='tablerow1'><td colspan='4'>There are no items in your cart! <br><a href='store.php?p=main'><b>Go to the store</a></td></tr>";
				}
			?>
			<tr class="tablerow1">
				<td colspan="4"><div style="border-bottom: 2px solid #e2e2e2;"></div></td>
			</tr>
			<?php
			if(GetCartTokens($userid) < 500) {
				$picture = "<img src='https://127.0.0.1/cp//global/images/all/store/coin_single.png' title='credits'>";
			}
			if(GetCartTokens($userid) >= 500) {
				$picture = "<img src='https://127.0.0.1/cp//global/images/all/store/coin_stack.png' title='credits'>";
			}
			?>
			<tr	class="tablerow1">
				<td></td><td></td><td style='font-size:12px'>Total Credits: <b><?php if(GetCartTokens($userid) != "") { echo GetCartTokens($userid); } else { echo "0"; } ?> <?php echo $picture; ?></b></td><td style='font-size:12px'><?php if (GetCartSize($userid) >= 1) { echo "Subtotal: <b>$".number_format(GetCartPrice($userid),2)." USD</b>"; } else { echo "Subtotal: <b>$0.00 USD</b>"; }?></td>
			</tr>
			</table>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
			<tr class="acp-actionbar">
				<td><a href="?p=main"><input style='float:left;width:150px;display: inline;font-size:10px;' type='button' class='button' value='CONTINUE SHOPPING'></a></td><td></td>
				<form action="store.php?p=checkout&purchasetype=self" method="POST">
				<input type='hidden' name='total_tokens' readonly='readonly' value='<?php echo GetCartTokens($userid); ?>'>
				<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
				<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
				<input type="hidden" name="userid" value="<?php echo $inf['id']; ?>">
				<td style="width: 10%;font-size:10px;">
				<?php if (GetCartSize($userid) <= 0) {
						echo "<input style='background:#6d7887;width:150px;display:inline;font-size:10px;' type='submit' disabled='disabled' class='button' value='PURCHASE FOR MYSELF'>";
					} else {
						echo "<input style='width:150px;display: inline;font-size:10px;' type='submit' class='button' value='PURCHASE FOR MYSELF'>";
					}
				?>
				</td>
				</form>
				<form action="store.php?p=checkout&purchasetype=gift" method="POST">
				<input type='hidden' name='total_tokens' readonly='readonly' value='<?php echo GetCartTokens($userid); ?>'>
				<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
				<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
				<input type="hidden" name="userid" value="<?php echo $inf['id']; ?>">
				<td style="width: 10%;font-size:10px;">
				<?php if (GetCartSize($userid) <= 0) {
						echo "<input style='background:#6d7887;width:150px;display: inline;font-size:10px;' type='submit' disabled='disabled' class='button' value='PURCHASE AS A GIFT'>";
					} else {
						echo "<input style='width:150px;display: inline;font-size:10px;' type='submit' class='button' value='PURCHASE AS A GIFT'>";
					}
				?>
				</td>
				</form>
			</tr> 
		</table>
	</div>
</div>