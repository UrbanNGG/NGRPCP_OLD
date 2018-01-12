<?php
$PayPalMode 			= 'live'; // sandbox or live
$PayPalApiUsername 		= 'billing_api1.ng-gaming.net'; //PayPal API Username
$PayPalApiPassword 		= 'PLPRLSPL8WMTETGM'; //Paypal API password
$PayPalApiSignature 	= 'AFcWxV21C7fd0v3bYYYRCpSSRl31A9mk9qeIVMh9tiNvu-o2ZkcYQt4u'; //Paypal API Signature
$PayPalCurrencyCode 	= 'USD'; //Paypal Currency Code
$PayPalReturnURL 		= 'http://'.$_SERVER['SERVER_NAME'].'/store.php?p=checkout&paypal=process'; //Point to process.php page
$PayPalCancelURL 		= 'http://'.$_SERVER['SERVER_NAME'].'/store.php?p=cart'; //Cancel URL if user clicks cancel
?>