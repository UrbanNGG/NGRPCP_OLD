<?php
session_start();
include_once("config.php");
include_once("paypal.class.php");
?>
	<link rel="stylesheet" type="text/css" href="http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/css/acp.css">
	<div id='main_content'>
<style type='text/css'>
body {
	background: #d3dae0 url(http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/branding_bg.png) repeat-x top;
}
#checkout_content {
	background: #FFF;
	margin-top:40px;
	margin-right:190px;
}
#checkout_tabs {
	margin-top:40px;
}
#tabs {
	display:inline;
	font-size:16px;
}
a:hover {
	text-decoration:none;
}
</style>
<img src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/logo.png" />
<div id='checkout_content'>
<div id='content_wrap'>
	<div class='section_title'><h2>Please Wait..</h2></div>
		<center>
		Processing...<br>
		<img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/upgrade/progressbar.gif'></img>
		<br><br>
		<?php if(isset($_GET['purchasetype'])) { echo 'Redirecting you to an external site to continue your payment.'; } ?>
		</center><br>
	<?php
	if($_GET['purchasetype'] == 'self' || $_GET['purchasetype'] == 'gift') {
		$ItemName = $_POST["item_name"]; //Item Name
		$ItemPrice = $_POST["amount"]; //Item Price
		$order_id = $_POST['custom'];

		//Data to be sent to paypal
		$padata = 	'&CURRENCYCODE='.urlencode($PayPalCurrencyCode).
					'&PAYMENTACTION=Sale'.
					'&ALLOWNOTE=0'.
					'&ADDROVERRIDE=0'.
					'&PAYMENTREQUEST_0_CUSTOM='.$order_id.''.
					'&HDRIMG=http://www.ng-gaming.net/staffbin/logo/logo.png'.
					'&BRANDNAME=Next Generation Gaming, LLC'.
					'&PAYMENTREQUEST_0_CURRENCYCODE='.urlencode($PayPalCurrencyCode).
					'&PAYMENTREQUEST_0_NAME='.urlencode($ItemName).
					'&PAYMENTREQUEST_0_AMT='.urlencode($ItemPrice).
					'&AMT='.urlencode($ItemPrice).	
					'&RM=2'.
					'&RETURNURL='.urlencode($PayPalReturnURL).
					'&CANCELURL='.urlencode($PayPalCancelURL);	
			
			//We need to execute the "SetExpressCheckOut" method to obtain paypal token
			$paypal= new MyPayPal();
			$httpParsedResponseAr = $paypal->PPHttpPost('SetExpressCheckout', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
			
			//Respond according to message we receive from Paypal
			if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
						
					// If successful set some session variable we need later when user is redirected back to page from paypal. 
					$_SESSION['itemprice'] =  $ItemPrice;
					$_SESSION['itemName'] =  $ItemName;
					
					if($PayPalMode=='sandbox') {
						$paypalmode 	=	'.sandbox';
					}
					else {
						$paypalmode 	=	'';
					}
					//Redirect user to PayPal store with Token received.
					$paypalurl ='https://www'.$paypalmode.'.paypal.com/cgi-bin/webscr?cmd=_express-checkout&token='.$httpParsedResponseAr["TOKEN"].'';
					echo '<meta http-equiv="refresh" content="1;url='.$paypalurl.'">';
				 
			} else {
				$error = '<meta http-equiv="refresh" content="0;url=http://'.$_SERVER['SERVER_NAME'].'/store.php?p=cart">';
				echo $error;exit();
			}
	}
?>
