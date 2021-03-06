<?php 
include_once("paypal/config.php");
include_once("paypal/paypal.class.php");
?>
<div id='main_content'>
<style type='text/css'>
body {
	background: #d3dae0 url(https://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/branding_bg.png) repeat-x top;
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
#footer {
	margin-left:200px;
	margin-top:-5px;
}
tabs:hover {
	text-decoration:none;
}
#main_content #content_wraps {
		padding: 15px 20px;
		
	}
</style>
<script type="text/javascript">
 var selectionsObject = {
	<?php 
	$q = mysql_query("SELECT `state_name` FROM `cp_info_states`");
	?>
 	"United States":	[<?php while($r = mysql_fetch_array($q)) { echo "'".$r['state_name']."',"; }?>],
 	};
 function populateSelectbox(selectSource,selectToPopulate,optionsObject) {
 	selectToPopulate.options.length = 1
 	if (selectSource.value == '') {
 		selectToPopulate.disabled = true
 		return
 	}
 	for (var i = 0; i < optionsObject[selectSource.value].length; i++) {
 		selectToPopulate.options[i+1] =	new Option(optionsObject[selectSource.value][i],
 			optionsObject[selectSource.value][i])
 	}
 	selectToPopulate.disabled = false
 }
</script>
</head>
<body>
<?php
if(isset($_POST['action']) && $_POST['action'] == 'process') {
		// Variables
		/*
		$_POST['method']
		$_POST['first_name']
		$_POST['last_name']
		$_POST['billing_address']
		$_POST['country']
		$_POST['city']
		$_POST['zip_code']
		$_POST['save']
		$_POST['gift_player']
		$_POST['gift_note']
		$_GET['purchasetype']
		$_GET['process']
		$_GET['success']
		*/
		// Process
		if($_POST['method'] == "") { $error[1] = "<div class='acp-error'>A Payment Method must be selected.</div>"; $s = 'error'; }
		if(!preg_match('/^[A-Za-z]+$/', $_POST['first_name']) || !preg_match('/^[A-Za-z]+$/', $_POST['last_name'])) { $error[2] = "<div class='acp-error'>Invalid first/last name given.</div>"; $s = 'error'; }
		if(!preg_match('/^[A-Za-z0-9\ .-]+$/', $_POST['billing_address'])) { $error[3] = "<div class='acp-error'>Invalid address given.</div>"; $s = 'error'; }
		if($_POST['country'] == "") { $error[4] = "<div class='acp-error'>A Country must be selected.</div>"; $s = 'error'; }
		if(isset($_POST['country']) && $_POST['country'] == 'United States' && $_POST['state'] == "") { $error[5] = "<div class='acp-error'>A State must be selected.</div>"; $s = 'error'; }
		if(!preg_match('/^[A-Za-z ]+$/', $_POST['city']) || $_POST['city'] == "") { $error[6] = "<div class='acp-error'>Invalid city given.</div>"; $s = 'error'; }
		if(isset($_GET['purchasetype']) && $_GET['purchasetype'] == 'gift') {
			if(preg_match('/^[A-Za-z_.]+$/', $_POST['gift_player'])) {
				if(CheckName($_POST['gift_player']) == 0 || GetAdminLevel(GetID($_POST['gift_player'])) >= 2) {
					$error[8] = "<div class='acp-error'>That player cannot be gifted, or does not exist.</div>"; $s = 'error'; 
				}
			} else {
				$error[9]= "<div class='acp-error'>Invalid characters in player's name.</div>"; $s = 'error'; 
			}
		}
		if(!isset($s)) { $s = 'success'; }
		if($s == 'success') {
			$numq = mysql_query("SELECT FLOOR(RAND() * 99999) AS `num` FROM `cp_store_orders` WHERE 'num' NOT IN (SELECT `order_id` FROM `cp_store_orders`) LIMIT 1;");
			$numr = mysql_fetch_array($numq);
			$order_id = $numr['num'];
			$giftplayer = GetID($_POST['gift_player']);
			$zipcode = escape_string($_POST['zip_code']);
			if($_POST['state'] != "") { $state = escape_string($_POST['state']); } else { $state = ""; }
			$store = mysql_query("INSERT INTO `cp_info_temp`
				(`order_id`, `player_id`, `first_name`, `last_name`, `billing_address`, `country`, `state`, `city`, `zip_code`, `purchasetype`, `gift_player`, `method`, `date_added`) VALUES
				('".$order_id."', '".$inf['id']."', '".$_POST['first_name']."', '".$_POST['last_name']."', '".$_POST['billing_address']."', '".$_POST['country']."', '$state', '".$_POST['city']."', '$zipcode', 
				'".$_GET['purchasetype']."', '$giftplayer', '".$_POST['method']."', '".date('Y-m-d h:i:s A')."')");
		}
}
?>
<img src="https://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/logo.png" />
<?php 
if (isset($_GET['purchasetype']) && isset($s) && $s == 'error' || isset($_GET['purchasetype']) && !isset($s)) {
	echo "<div id='checkout_tabs'><p id='tabs'><a style='color:#44607c;'>Order Information</a> > <a style='color:#aebbc6;'>Review + Purchase</a> > <a style='color:#aebbc6;'>Success</a></p></div>";
}
if (isset($s) && $s == 'success' || isset($_GET['token']) && isset($_GET['PayerID']) && !isset($status)) {
	echo "<div id='checkout_tabs'><p id='tabs'><a style='color:#8bac8a;'>Order Information</a> > <a style='color:#44607c;'>Review + Purchase</a> > <a style='color:#aebbc6;'>Success</a></p></div>";
}
if (isset($_GET['success']) || isset($status) && $status == 'paymentfailed') {
	echo "<div id='checkout_tabs'><p id='tabs'><a style='color:#8bac8a;'>Order Information</a> > <a style='color:#8bac8a;'>Review + Purchase</a> > <a style='color:#44607c;'>Success</a></p></div>";
}
?><br>
<a href="?p=main"><input style='float:left;width:100px;display: inline;font-size:10px;' type='button' class='button' value='< Return to Store'></a>
<div id='checkout_content'>
<?php
$userid = $inf['id'];
$userCart = mysql_query("SELECT * FROM `cp_store_cart` WHERE `customer_id`='".$userid."' ORDER BY `date_item_added` ASC;");
$cart = mysql_fetch_array($userCart);
$ip = $_SERVER['REMOTE_ADDR'];
if (isset($_GET['purchasetype'])) {
if(!isset($_POST['action']) || isset($_POST['action']) && isset($s) && $s == 'error') {
?>
<div id='content_wraps'>
	<div class='section_title'><h2>Confirm your information</h2></div>
	<?php
	for($i=1;$i<=10;$i++) {
		if(isset($error[$i])) {
			echo $error[$i];
		}
	}
	?>
	<div class='acp-box'>
		<h3></h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<form method="POST" action="">
			<tr class="tablerow1"><td colspan="2" style='color:#44607c;'>Checkout Information</td></tr>
			<tr class="tablerow2">
				<td>Your Account Name:</td><td><?php echo $inf['Username']; ?></td>
			</tr>
			<tr class="tablerow2">
				<td>Payment Method:</td><td>
				<select name='method'>
					<option value="">Select One..</option>
					<option>PayPal</option>
				</select>
				</td>
			</tr>
			<tr class="tablerow1"><td colspan="2" style='color:#44607c;'>Billing Details <button style='font-size:8px;' disabled='disabled' title='Billing details help secure and verify your account to prevent fraud and for a support resource. It is used for only those purposes and is never shared.'>?</button></td></tr>
			<tr class="tablerow2">
				<td><span style='margin-right:25px;'>First name</span> Last name<br><input size="10" type='text' name='first_name'/>&nbsp;<input size="10" type='text' name='last_name'/></td>
				<td>Country:<br><select name="country" style='width:122px;' onchange="populateSelectbox(this,this.form.state,selectionsObject)"> 
<option value="">Select Country</option> 
<option value="United States">United States</option> 
<option value="United Kingdom">United Kingdom</option> 
<option value="Afghanistan">Afghanistan</option> 
<option value="Albania">Albania</option> 
<option value="Algeria">Algeria</option> 
<option value="American Samoa">American Samoa</option> 
<option value="Andorra">Andorra</option> 
<option value="Angola">Angola</option> 
<option value="Anguilla">Anguilla</option> 
<option value="Antarctica">Antarctica</option> 
<option value="Antigua and Barbuda">Antigua and Barbuda</option> 
<option value="Argentina">Argentina</option> 
<option value="Armenia">Armenia</option> 
<option value="Aruba">Aruba</option> 
<option value="Australia">Australia</option> 
<option value="Austria">Austria</option> 
<option value="Azerbaijan">Azerbaijan</option> 
<option value="Bahamas">Bahamas</option> 
<option value="Bahrain">Bahrain</option> 
<option value="Bangladesh">Bangladesh</option> 
<option value="Barbados">Barbados</option> 
<option value="Belarus">Belarus</option> 
<option value="Belgium">Belgium</option> 
<option value="Belize">Belize</option> 
<option value="Benin">Benin</option> 
<option value="Bermuda">Bermuda</option> 
<option value="Bhutan">Bhutan</option> 
<option value="Bolivia">Bolivia</option> 
<option value="Bosnia and Herzegovina">Bosnia and Herzegovina</option> 
<option value="Botswana">Botswana</option> 
<option value="Bouvet Island">Bouvet Island</option> 
<option value="Brazil">Brazil</option> 
<option value="British Indian Ocean Territory">British Indian Ocean Territory</option> 
<option value="Brunei Darussalam">Brunei Darussalam</option> 
<option value="Bulgaria">Bulgaria</option> 
<option value="Burkina Faso">Burkina Faso</option> 
<option value="Burundi">Burundi</option> 
<option value="Cambodia">Cambodia</option> 
<option value="Cameroon">Cameroon</option> 
<option value="Canada">Canada</option> 
<option value="Cape Verde">Cape Verde</option> 
<option value="Cayman Islands">Cayman Islands</option> 
<option value="Central African Republic">Central African Republic</option> 
<option value="Chad">Chad</option> 
<option value="Chile">Chile</option> 
<option value="China">China</option> 
<option value="Christmas Island">Christmas Island</option> 
<option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option> 
<option value="Colombia">Colombia</option> 
<option value="Comoros">Comoros</option> 
<option value="Congo">Congo</option> 
<option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option> 
<option value="Cook Islands">Cook Islands</option> 
<option value="Costa Rica">Costa Rica</option> 
<option value="Cote D'ivoire">Cote D'ivoire</option> 
<option value="Croatia">Croatia</option> 
<option value="Cuba">Cuba</option> 
<option value="Cyprus">Cyprus</option> 
<option value="Czech Republic">Czech Republic</option> 
<option value="Denmark">Denmark</option> 
<option value="Djibouti">Djibouti</option> 
<option value="Dominica">Dominica</option> 
<option value="Dominican Republic">Dominican Republic</option> 
<option value="Ecuador">Ecuador</option> 
<option value="Egypt">Egypt</option> 
<option value="El Salvador">El Salvador</option> 
<option value="Equatorial Guinea">Equatorial Guinea</option> 
<option value="Eritrea">Eritrea</option> 
<option value="Estonia">Estonia</option> 
<option value="Ethiopia">Ethiopia</option> 
<option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option> 
<option value="Faroe Islands">Faroe Islands</option> 
<option value="Fiji">Fiji</option> 
<option value="Finland">Finland</option> 
<option value="France">France</option> 
<option value="French Guiana">French Guiana</option> 
<option value="French Polynesia">French Polynesia</option> 
<option value="French Southern Territories">French Southern Territories</option> 
<option value="Gabon">Gabon</option> 
<option value="Gambia">Gambia</option> 
<option value="Georgia">Georgia</option> 
<option value="Germany">Germany</option> 
<option value="Ghana">Ghana</option> 
<option value="Gibraltar">Gibraltar</option> 
<option value="Greece">Greece</option> 
<option value="Greenland">Greenland</option> 
<option value="Grenada">Grenada</option> 
<option value="Guadeloupe">Guadeloupe</option> 
<option value="Guam">Guam</option> 
<option value="Guatemala">Guatemala</option> 
<option value="Guinea">Guinea</option> 
<option value="Guinea-bissau">Guinea-bissau</option> 
<option value="Guyana">Guyana</option> 
<option value="Haiti">Haiti</option> 
<option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option> 
<option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option> 
<option value="Honduras">Honduras</option> 
<option value="Hong Kong">Hong Kong</option> 
<option value="Hungary">Hungary</option> 
<option value="Iceland">Iceland</option> 
<option value="India">India</option> 
<option value="Indonesia">Indonesia</option> 
<option value="Iran, Islamic Republic of">Iran, Islamic Republic of</option> 
<option value="Iraq">Iraq</option> 
<option value="Ireland">Ireland</option> 
<option value="Israel">Israel</option> 
<option value="Italy">Italy</option> 
<option value="Jamaica">Jamaica</option> 
<option value="Japan">Japan</option> 
<option value="Jordan">Jordan</option> 
<option value="Kazakhstan">Kazakhstan</option> 
<option value="Kenya">Kenya</option> 
<option value="Kiribati">Kiribati</option> 
<option value="Korea, Democratic People's Republic of">Korea, Democratic People's Republic of</option> 
<option value="Korea, Republic of">Korea, Republic of</option> 
<option value="Kuwait">Kuwait</option> 
<option value="Kyrgyzstan">Kyrgyzstan</option> 
<option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option> 
<option value="Latvia">Latvia</option> 
<option value="Lebanon">Lebanon</option> 
<option value="Lesotho">Lesotho</option> 
<option value="Liberia">Liberia</option> 
<option value="Libyan Arab Jamahiriya">Libyan Arab Jamahiriya</option> 
<option value="Liechtenstein">Liechtenstein</option> 
<option value="Lithuania">Lithuania</option> 
<option value="Luxembourg">Luxembourg</option> 
<option value="Macao">Macao</option> 
<option value="Macedonia, The Former Yugoslav Republic of">Macedonia, The Former Yugoslav Republic of</option> 
<option value="Madagascar">Madagascar</option> 
<option value="Malawi">Malawi</option> 
<option value="Malaysia">Malaysia</option> 
<option value="Maldives">Maldives</option> 
<option value="Mali">Mali</option> 
<option value="Malta">Malta</option> 
<option value="Marshall Islands">Marshall Islands</option> 
<option value="Martinique">Martinique</option> 
<option value="Mauritania">Mauritania</option> 
<option value="Mauritius">Mauritius</option> 
<option value="Mayotte">Mayotte</option> 
<option value="Mexico">Mexico</option> 
<option value="Micronesia, Federated States of">Micronesia, Federated States of</option> 
<option value="Moldova, Republic of">Moldova, Republic of</option> 
<option value="Monaco">Monaco</option> 
<option value="Mongolia">Mongolia</option> 
<option value="Montserrat">Montserrat</option> 
<option value="Morocco">Morocco</option> 
<option value="Mozambique">Mozambique</option> 
<option value="Myanmar">Myanmar</option> 
<option value="Namibia">Namibia</option> 
<option value="Nauru">Nauru</option> 
<option value="Nepal">Nepal</option> 
<option value="Netherlands">Netherlands</option> 
<option value="Netherlands Antilles">Netherlands Antilles</option> 
<option value="New Caledonia">New Caledonia</option> 
<option value="New Zealand">New Zealand</option> 
<option value="Nicaragua">Nicaragua</option> 
<option value="Niger">Niger</option> 
<option value="Nigeria">Nigeria</option> 
<option value="Niue">Niue</option> 
<option value="Norfolk Island">Norfolk Island</option> 
<option value="Northern Mariana Islands">Northern Mariana Islands</option> 
<option value="Norway">Norway</option> 
<option value="Oman">Oman</option> 
<option value="Pakistan">Pakistan</option> 
<option value="Palau">Palau</option> 
<option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option> 
<option value="Panama">Panama</option> 
<option value="Papua New Guinea">Papua New Guinea</option> 
<option value="Paraguay">Paraguay</option> 
<option value="Peru">Peru</option> 
<option value="Philippines">Philippines</option> 
<option value="Pitcairn">Pitcairn</option> 
<option value="Poland">Poland</option> 
<option value="Portugal">Portugal</option> 
<option value="Puerto Rico">Puerto Rico</option> 
<option value="Qatar">Qatar</option> 
<option value="Reunion">Reunion</option> 
<option value="Romania">Romania</option> 
<option value="Russian Federation">Russian Federation</option> 
<option value="Rwanda">Rwanda</option> 
<option value="Saint Helena">Saint Helena</option> 
<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option> 
<option value="Saint Lucia">Saint Lucia</option> 
<option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option> 
<option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option> 
<option value="Samoa">Samoa</option> 
<option value="San Marino">San Marino</option> 
<option value="Sao Tome and Principe">Sao Tome and Principe</option> 
<option value="Saudi Arabia">Saudi Arabia</option> 
<option value="Senegal">Senegal</option> 
<option value="Serbia and Montenegro">Serbia and Montenegro</option> 
<option value="Seychelles">Seychelles</option> 
<option value="Sierra Leone">Sierra Leone</option> 
<option value="Singapore">Singapore</option> 
<option value="Slovakia">Slovakia</option> 
<option value="Slovenia">Slovenia</option> 
<option value="Solomon Islands">Solomon Islands</option> 
<option value="Somalia">Somalia</option> 
<option value="South Africa">South Africa</option> 
<option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option> 
<option value="Spain">Spain</option> 
<option value="Sri Lanka">Sri Lanka</option> 
<option value="Sudan">Sudan</option> 
<option value="Suriname">Suriname</option> 
<option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option> 
<option value="Swaziland">Swaziland</option> 
<option value="Sweden">Sweden</option> 
<option value="Switzerland">Switzerland</option> 
<option value="Syrian Arab Republic">Syrian Arab Republic</option> 
<option value="Taiwan, Province of China">Taiwan, Province of China</option> 
<option value="Tajikistan">Tajikistan</option> 
<option value="Tanzania, United Republic of">Tanzania, United Republic of</option> 
<option value="Thailand">Thailand</option> 
<option value="Timor-leste">Timor-leste</option> 
<option value="Togo">Togo</option> 
<option value="Tokelau">Tokelau</option> 
<option value="Tonga">Tonga</option> 
<option value="Trinidad and Tobago">Trinidad and Tobago</option> 
<option value="Tunisia">Tunisia</option> 
<option value="Turkey">Turkey</option> 
<option value="Turkmenistan">Turkmenistan</option> 
<option value="Turks and Caicos Islands">Turks and Caicos Islands</option> 
<option value="Tuvalu">Tuvalu</option> 
<option value="Uganda">Uganda</option> 
<option value="Ukraine">Ukraine</option> 
<option value="United Arab Emirates">United Arab Emirates</option> 
<option value="United Kingdom">United Kingdom</option> 
<option value="United States">United States</option> 
<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option> 
<option value="Uruguay">Uruguay</option> 
<option value="Uzbekistan">Uzbekistan</option> 
<option value="Vanuatu">Vanuatu</option> 
<option value="Venezuela">Venezuela</option> 
<option value="Viet Nam">Viet Nam</option> 
<option value="Virgin Islands, British">Virgin Islands, British</option> 
<option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option> 
<option value="Wallis and Futuna">Wallis and Futuna</option> 
<option value="Western Sahara">Western Sahara</option> 
<option value="Yemen">Yemen</option> 
<option value="Zambia">Zambia</option> 
<option value="Zimbabwe">Zimbabwe</option>
</select></td>
			</tr>
			<tr class="tablerow2">
				<td>Billing Address:<br><input type='text' name='billing_address'/></td>
				<td>State: <i style='font-size:8px'>*US only</i><br>
					<select name="state"> 
					<option value="">Select a State</option> 
					</select>
				</td>
			</tr>
			<tr class="tablerow2">
				<td>City:<br><input type='text' name='city'/></td>
				<td>Zip or Postal code:<br><input type='text' name='zip_code'/></td>
			</tr>
			<?php if($_GET['purchasetype'] == 'gift') {  ?>
			<tr class="tablerow1"><td colspan="2" style='color:#44607c;'>Gift Details</td></tr>
			<tr class="tablerow2">
				<td>Name of Player to gift:</td><td><input type="text" id="tags" name="gift_player"></td>
			</tr>
			<?php } ?>
			<tr class="acp-actionbar">
				<input type='hidden' name='action' value='process'>
				<input type='hidden' name='total_tokens' readonly='readonly' value='<?php echo GetCartTokens($userid); ?>'>
				<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
				<td><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"></td>
				<td><input type='submit' class='realbutton' value='CONTINUE'></td>
				</td>
			</tr> 
		</form>
		</table>
	</div>
</div>
<?php }
}
if(isset($s) && $s == 'success' && !isset($_GET['token']) && !isset($_GET['PayerID'])) {
?>
<div id='content_wrap'>
	<div class='section_title'><h2>Continue your order</h2></div>
	<div class='acp-box'>
		<h3></h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
			<tr class="tablerow2">
				<td align="center" colspan="4">You may now continue your payment on <?php echo $_POST['method']; ?>. After you continue, you will be redirected back<br> here to complete your order. You will get a chance to review your order before purchase.</td>
			</tr>
			<tr class="acp-actionbar">
				<td></td><td></td><td></td>
				<td>
				<?php
				switch($_POST['method']) {
					case 'PayPal': echo '
						<form method="post" action="https://'.$_SERVER['SERVER_NAME'].'/store/paypal/process.php?purchasetype=self">
						<input type="hidden" name="item_name" value="'.GetCartTokens($userid).' Credits">
						<input type="hidden" name="amount" value="'.GetCartPrice($userid).'">
						<input type="hidden" name="custom" value="'.$order_id.'">
						<input type="hidden" name="currency_code" value="USD">
						<input type="submit" name="submit" class="realbutton" value="CONTINUE TO PAYPAL">
						</form>'; break;
					/*
					case 'Amazon': echo '
						<form action="https://authorize.payments.amazon.com/pba/paypipeline" method="POST">
						<ipput type="image" src="https://authorize.payments-sandbox.amazon.com/pba/images/payNowButton.png" border="0">
						<input type="hidden" name="signatureVersion" value="2" >
						<input type="hidden" name="immediateReturn" value="0" >
						<input type="hidden" name="signature" value="hd" >
						<input type="hidden" name="amount" value="USD 1.1" >
						<input type="hidden" name="signatureMethod" value="HmacSHA256" >
						<input type="hidden" name="description" value="Test Widget" >
						<input type="hidden" name="ipnUrl" value="https://yourwebsite.com/ipn" >
						<input type="hidden" name="accessKey" value="AKIAJG44SOC5GLUKD2HQ" >
						<input type="hidden" name="cobrandingStyle" value="logo" >
						<input type="hidden" name="processImmediate" value="1" >
						<input type="hidden" name="returnUrl" value="https://yourwebsite.com/return.html" >
						<input type="hidden" name="referenceId" value="YourReferenceId" >
						</form>'; break;
					case 'Google Checkout': echo '
						<form action="https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/151389436380907" id="BB_BuyButtonForm" method="post" name="BB_BuyButtonForm" target="_top">
						<input name="item_name_1" type="hidden" value="Test"/>
						<input name="item_description_1" type="hidden" value=""/>
						<input name="item_quantity_1" type="hidden" value="1"/>
						<input name="item_price_1" type="hidden" value="1.0"/>
						<input name="item_currency_1" type="hidden" value="USD"/>
						<input name="_charset_" type="hidden" value="utf-8"/>
						<input alt="" src="https://checkout.google.com/buttons/buy.gif?merchant_id=151389436380907&amp;w=121&amp;h=44&amp;style=trans&amp;variant=text&amp;loc=en_US" type="image"/>
						</form>'; break;
					*/
				}
				?></td>
			</tr> 
		</table>
	</div>
</div>
<?php }
if(isset($_GET['token']) && isset($_GET['PayerID']) && !isset($_POST['action'])) {
?>
<div id='content_wrap'>
	<div class='section_title'><h2>Review your order</h2></div>
	<?php 
	$userCart = mysql_query("SELECT * FROM `cp_store_cart` WHERE `customer_id`='".$userid."' ORDER BY `date_item_added` ASC;");
	?>
	<div class='acp-box'>
		<h3></h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
			<th></th><th>Product ID</th><th>Product Name</th><th>Price</th>
			<?php
				while($cart = mysql_fetch_array($userCart)) {
					if (GetAdditionalTokens($cart['cart_pack_id']) > 0) { $additionalTokens = "+ ".GetAdditionalTokens($cart['cart_pack_id']).""; } else { $additionalTokens = ''; }
					echo "
						<tr class='tablerow1'>
							<td style='width: 25%;'><img src='".GetPackPicture($cart['cart_pack_id'])."' /></td>
							<td style='width: 25%;font-size:12px'>".$cart['cart_pack_id']."</td>
							<td style='width: 25%;font-size:12px'>".number_format(GetTotalTokens($cart['cart_pack_id']))."  ".$additionalTokens." Credits</td>
							<td style='width: 25%;font-size:12px'>$".GetStorePrice($cart['cart_pack_id'])."</td>
						</tr>
					";
				}
			?>
			<?php ?>
			<tr class="tablerow1">
				<td colspan="4"><div style="border-bottom: 2px solid #e2e2e2;"></div></td>
			</tr>
			<tr	class="tablerow1">
				<td></td><td></td><td></td><td>Subtotal: <b>$<?php echo number_format(GetCartPrice($userid),2); ?></b></td>
			</tr>
			<tr class="acp-actionbar">
				<td></td><td></td><td></td>
				<td>
				<?php
				echo '<form method="post" action="https://'.$_SERVER['SERVER_NAME'].'/store.php?p=checkout&paypal=process&token='.$_GET['token'].'&PayerID='.$_GET['PayerID'].'">
						<input type="hidden" name="action" value="process">
						<input type="submit" name="submit" class="realbutton" value="Purchase">
						</form>
				';
				/*
				switch($_POST['method']) {
					case 'PayPal': echo '
						<form method="post" action="https://'.$_SERVER['SERVER_NAME'].'/store/paypal/process.php?purchasetype=self">
						<input type="hidden" name="item_name_1" value="'.GetCartTokens($userid).'">
						<input type="hidden" name="amount" value="'.GetCartPrice($userid).'">
						<input type="hidden" name="custom" value="username='.$inf['Username'].'&">
						<input type="hidden" name="currency_code" value="USD">
						<input type="submit" name="submit" class="realbutton" value="CONTINUE TO PAYPAL">
						</form>'; break;
					case 'Amazon': echo '
						<form action="https://authorize.payments.amazon.com/pba/paypipeline" method="POST">
						<ipput type="image" src="https://authorize.payments-sandbox.amazon.com/pba/images/payNowButton.png" border="0">
						<input type="hidden" name="signatureVersion" value="2" >
						<input type="hidden" name="immediateReturn" value="0" >
						<input type="hidden" name="signature" value="hd" >
						<input type="hidden" name="amount" value="USD 1.1" >
						<input type="hidden" name="signatureMethod" value="HmacSHA256" >
						<input type="hidden" name="description" value="Test Widget" >
						<input type="hidden" name="ipnUrl" value="https://yourwebsite.com/ipn" >
						<input type="hidden" name="accessKey" value="AKIAJG44SOC5GLUKD2HQ" >
						<input type="hidden" name="cobrandingStyle" value="logo" >
						<input type="hidden" name="processImmediate" value="1" >
						<input type="hidden" name="returnUrl" value="https://yourwebsite.com/return.html" >
						<input type="hidden" name="referenceId" value="YourReferenceId" >
						</form>'; break;
					case 'Google Checkout': echo '
						<form action="https://checkout.google.com/api/checkout/v2/checkoutForm/Merchant/151389436380907" id="BB_BuyButtonForm" method="post" name="BB_BuyButtonForm" target="_top">
						<input name="item_name_1" type="hidden" value="Test"/>
						<input name="item_description_1" type="hidden" value=""/>
						<input name="item_quantity_1" type="hidden" value="1"/>
						<input name="item_price_1" type="hidden" value="1.0"/>
						<input name="item_currency_1" type="hidden" value="USD"/>
						<input name="_charset_" type="hidden" value="utf-8"/>
						<input alt="" src="https://checkout.google.com/buttons/buy.gif?merchant_id=151389436380907&amp;w=121&amp;h=44&amp;style=trans&amp;variant=text&amp;loc=en_US" type="image"/>
						</form>'; break;
				}
				*/
				?></td>
			</tr> 
		</table>
	</div>
</div>
<?php } 
if(isset($_GET["token"]) && isset($_GET["PayerID"]) && isset($_POST['action']) && $_POST['action'] == 'process')
{
	//we will be using these two variables to execute the "DoExpressCheckoutPayment"
	//Note: we haven't received any payment yet.
	
	$token = $_GET["token"];
	$playerid = $_GET["PayerID"];
	
	//get session variables
	$ItemPrice 		= $_SESSION['itemprice'];
	$ItemName 		= $_SESSION['itemName'];
	$order_id		= $_SESSION['custom'];
	
	$padata = 	'&TOKEN='.urlencode($token).
				'&PAYMENTREQUEST_0_CUSTOM='.$order_id.
				'&PAYERID='.urlencode($playerid).
				'&PAYMENTACTION='.urlencode("SALE").
				'&AMT='.urlencode($ItemPrice).
				'&CURRENCYCODE='.urlencode($PayPalCurrencyCode);
	
	//We need to execute the "DoExpressCheckoutPayment" at this point to Receive payment from user.
	$paypal= new MyPayPal();
	$httpParsedResponseAr = $paypal->PPHttpPost('DoExpressCheckoutPayment', $padata, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);
	
	//Check if everything went ok..
	if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {	
				if('Completed' == $httpParsedResponseAr["PAYMENTSTATUS"]) {
					$status = 'paymentcomplete';
				}
					elseif('Pending' == $httpParsedResponseAr["PAYMENTSTATUS"]) {
					$status = 'paymentpending';
				}

				$transactionID = urlencode($httpParsedResponseAr["TRANSACTIONID"]);
				$nvpStr = "&TRANSACTIONID=".$transactionID;
				$paypal= new MyPayPal();
				$httpParsedResponseAr = $paypal->PPHttpPost('GetTransactionDetails', $nvpStr, $PayPalApiUsername, $PayPalApiPassword, $PayPalApiSignature, $PayPalMode);

				if("SUCCESS" == strtoupper($httpParsedResponseAr["ACK"]) || "SUCCESSWITHWARNING" == strtoupper($httpParsedResponseAr["ACK"])) {
					if('Completed' == $httpParsedResponseAr["PAYMENTSTATUS"]) {
						$status = 'paymentcomplete';
					}
					elseif('Pending' == $httpParsedResponseAr["PAYMENTSTATUS"]) {
						$status = 'paymentpending';
					}
				} else  {
					echo 'An error has occured getting your order information';
				}
	
	} else {
			$status = 'paymentfailed';
	}
	
if($status == 'paymentcomplete' || $status == 'paymentpending') {
$userCart = mysql_query("SELECT * FROM `cp_store_cart` WHERE `customer_id`='".$inf['id']."';");
$cart = mysql_fetch_array($userCart);
$q = mysql_query("SELECT * FROM `cp_info_temp` WHERE `player_id` = '".$inf['id']."' ORDER BY `date_added` DESC LIMIT 1");
$r = mysql_fetch_array($q);
if($r['gift_player'] != "") { $giftplayer = $r['gift_player']; } else { $giftplayer = ""; }
if(mysql_query("INSERT INTO `cp_store_orders`
	(`order_id`, `order_status`, `customer_id`, `gift_player_id`, `customer_ip_address`, `pack_id`, `pack_total_tokens`, `pack_total_price`,
	`payment_method`, `payment_address`, `date_purchased`) VALUES
	('".$r['order_id']."', 'Pending', '".$cart['customer_id']."', '$giftplayer', '".$_SERVER['REMOTE_ADDR']."',
	'".$cart['cart_pack_id']."', '".GetCartTokens($inf['id'])."', '".GetCartPrice($inf['id'])."', 
	'PayPal', '".$r['first_name']." ".$r['last_name']."<br>".$r['billing_address']."<br>".$r['city'].", ".$r['country']." ".$r['zip_code']."', '".date('Y-m-d h:i:s A')."');")) { echo 'success'; } else { echo mysql_error(); }
mysql_query("DELETE FROM `cp_store_cart` WHERE `customer_id` = '".$inf['id']."';");
	?>
	<div id='content_wrap'>
	<div class='section_title'><h2>Purchase complete!</h2></div>
	<div class='acp-box'>
		<h3></h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
			<tr class="acp-actionbar">
				<td><img src='https://127.0.0.1/cp//global/images/all/store/success.png' /><br><h2>Thank you for your purchase!</h2><br>
					Order details; <br><br> <b><?php echo number_format(GetTotalTokens($cart['cart_pack_id'])); ?></b> tokens &nbsp; - &nbsp; <b>$<?php echo GetStorePrice($cart['cart_pack_id']); ?></b> USD &nbsp; - &nbsp; Username: <b><?php echo $inf['Username']; ?></b> <?php if ($r['gift_player'] != "") { echo "- Gifted for: ".GetName($r['gift_player']).""; } ?> <br><br> Your order id is <b>#<?php echo $r['order_id']; ?></b>. <br><br>*Order history for all of your purchases can be found at the main page of the store for any tracking or support purposes. <br><br>Please allow time for Customer Relations to confirm your order for the tokens to be transfered to your account, if tokens have not been added after an appropriate amount of time, please contact support regarding the issue.
				</td>
			</tr> 
		</table>
	</div>
	</div>
			<?php  
}
if($status == 'paymentfailed') { ?>
<div id='content_wrap'>
	<div class='section_title'><h2>Purchase incomplete</h2></div>
	<div class='acp-box'>
		<h3></h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
			<tr class="acp-actionbar">
				<td><img src='https://127.0.0.1/cp//global/images/all/store/error.png' /><br><br>
					An unexpected error has occured with trying to complete your order. Please try the payment process again.
					<br><br>If this error reoccurs after trying several times, please try contacting <a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/store.php?p=support">customer support</a> regarding the issue.
				</td>
			</tr> 
		</table>
	</div>
</div>
<?php
}
}
?>
</div>
</div>
<div id='footer'><img src='https://127.0.0.1/cp//global/images/all/store/logo.png' height='60px' width='130px' align='left'><br> &nbsp; &copy; 2010-<?php echo date('Y'); ?> Next Generation Gaming, LLC. <br>&nbsp;
				<a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/store.php?p=info&page=policy">Privacy Policy</a>&nbsp;&nbsp;|&nbsp;
				<a href="https://<?php echo $_SERVER['SERVER_NAME']; ?>/store.php?p=info&page=terms">Terms & Conditions</a><br>&nbsp;&nbsp;<span id="siteseal"><script type="text/javascript" src="https://seal.starfieldtech.com/getSeal?sealID=iqW3ojgEoTENRthUwzjnSFGbHssgm8rggjJOpLl7nWpF81vfeAM2"></script></span></div>