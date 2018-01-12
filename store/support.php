<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script>
$(function() {
    $( "#datepicker" ).datepicker();
  });
</script>
<style>
#sbutton {
	border:1px solid;
	border-radius:10px;
	box-shadow:1px 3px 3px #ccc;
	color:#2b5b8c;
	width:150px;
	height:150px;
	margin:auto;
	display: block;
}
#sbutton:hover {
	color:#1f4165;
	background-color:#efefef;
	box-shadow:2px 6px 6px #ccc;
	text-decoration:none;
}
#qbutton {
	border:1px solid;
	border-radius:10px;
	box-shadow:1px 2px 2px #ccc;
	color:#2b5b8c;
	width:450px;
	margin:auto;
	display: block;
}
</style>
<?php 
if(!isset($_GET['sp'])) {
if(!isset($_GET['tid'])) { ?>
<div id='content_wrap'>
	<ol id='breadcrumb'>
		<li><?php echo $section; ?> &raquo; Support</li>
	</ol>
	<div class='section_title'>
		<h2>Customer Support</h2>
	</div>
	<div class='acp-box'>
		<h3>Support Area</h3>
	<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%' align="center">
	<tr class="tablerow1">
		<td colspan='3'><span style='font-size:16px;color:#2d4a94;text-shadow: 0 1 0.1em black, 0 1 0.1em black'>Is there a problem regarding your purchase or product?</span></td>
	</tr>
	<tr class="tablerow2">
		<td width="32%"><div id="sbutton"><a href="?p=support&sp=items"><img style="margin-top:20px;" src='http://127.0.0.1/cp//global/images/all/store/cart.png'><br><br>Browse items purchased<br> with credits</a></div></td>
		<td width="32%"><div id="sbutton"><a href="?p=support&sp=faq"><img style="margin-top:20px;" src='http://127.0.0.1/cp//global/images/all/store/faq.png'><br><br>View Frequently Asked Questions</a></div></td>
		<td width="32%"><div id="sbutton"><a href="?p=support&sp=nticket"><img style="margin-top:20px;" src='http://127.0.0.1/cp//global/images/all/store/ticket.png'><br><br>Submit a Support Ticket</a></div></td>
	</tr>
	</table>
	</div>
	<br>
	<div class='acp-box'>
		<h3>My Tickets</h3>
	<table class='double_pad' cellpadding='0' cellspacing='0' border='1' width='100%' align="center" style='border-color:#ccc;'>
        <tr>
	        <th width="70" >
                Ticket</th>
	        <th width="70">
                Date</th>
	        <th width="280">Subject</th>
			<th width="80">Status</th>
	        <th width="120">
                Area</th>
			<th width="120">
                Priority</th>
        </tr>
			<style>
			.tablerow1 tr:hover {
				background-color:#fffdd1;
			}
			</style>
            <?php
			$t = mysql_query("SELECT * FROM `cp_support_tickets` WHERE `p_id` = '".$inf['id']."'");
			$z = mysql_num_rows($t);
			while($r = mysql_fetch_array($t)) {
			if(isset($i) && $i == 1) {
							print "<tr id='".$r['ticketID']."' class='tablerow1'>";
						$i=0;
						} else { 
							print "<tr id='".$r['ticketID']."' class='tablerow2'>";
						$i=1;
						}
			?>
                <td align="center" nowrap>
                  <img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/ticket_source_Web.gif' /> <a href="store.php?p=support&tid=<?php echo $r['ticketID']; ?>"><?php echo $r['ticketID']; ?></a></td>
                <td align="center" nowrap><?php echo date('Y-m-d', strtotime($r['created'])); ?></td>
                <td><a href="store.php?p=support&tid=<?php echo $r['ticketID']; ?>"><?php echo $r['subject']; ?></a></td>
				<td><?php echo $r['status']; ?></td>
                <td nowrap><?php echo $r['area']; ?></td>
				<td><?php echo $r['priority']; ?></td>
            </tr>
			<?php
			} 
			if($z == 0) {
			?>
            <tr class="tablerow1"><td colspan=8><b>No tickets</b></td></tr>
			<?php
			}
			?>
		</table>
		<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
        <tr><td class='acp-actionbar' colspan=8> <b>*Click on a ticket to see more details.</b> <br><br>
			Page: <b>[1]</b>
			</td>
 </table>
	</div>
</div>
<?php } else { ?>
<div id='content_wrap'>
	<ol id='breadcrumb'>
		<li><?php echo $section; ?> &raquo; View</li>
	</ol>
	<?php
	$tid = $_GET['tid'];
	if (!preg_match("/^[0-9]{1,6}+$/", $tid)) {
		print "<meta http-equiv=\"refresh\" content=\"0;url=store.php?p=support\">";exit();
	}
	if(isset($_POST['action']) && $_POST['action'] == 'reply') {
		$response = escape_string($_POST['response']);
		if($response != "") {
		$th = mysql_query("
		INSERT INTO `cp_support_tickets_response` (`ticket_id`, `p_id`, `form`, `staff`, `response`, `ip_address`, `created`)
		VALUES ('$tid', '".$inf['id']."', '0', '0', '$response', '".$_SERVER['REMOTE_ADDR']."', '".date('Y-m-d h:i:s A')."')
		");
		$re = mysql_query("
		UPDATE `cp_support_tickets` SET `lastresponse` = '".date('Y-m-d h:i:s A')."' WHERE `ticketID` = '$tid'
		");
		} else {
			$msg = 'Reply must be at least 10 characters in length.';
		}
	}
	$t = mysql_query("SELECT * FROM `cp_support_tickets` WHERE `ticketID` = '".$tid."' AND `p_id` = '".$inf['id']."';");
	$z = mysql_num_rows($t);
	$r = mysql_fetch_array($t);
	?>
	<?php
		if($z == 0) {
	?>
			<div class='acp-box'>
			<table class='double_pad' cellpadding='0' cellspacing='0' border='1' width='100%' align="center" style='border-color:#ccc;'>
			<tr class="tablerow1"><td colspan=8><b><h2>Ticket not found or no access to view.</h2></b></td></tr>
	<?php
		} else {
	?>
	<div class='section_title'>
		<h2>View Ticket #<?php echo $_GET['tid']; ?> <a href="store.php?p=support&tid=<?php echo $_GET['tid']; ?>" title="Reload"><img src='http://127.0.0.1/cp//global/images/all/store/arrow_refresh.png' /></a></h2>
	</div>
	<a href="?p=support"><input style='float:left;width:100px;display: inline;font-size:10px;' type='button' class='button' value='Back'></a><br><br>
	<?php if(isset($_GET['msg'])) { if ($_GET['msg'] == '1') { $msg = 'Reply added'; } else { $msg = 'Reply invalid. Must be at least 10 characters in length.'; } 
	 echo "<div class='acp-error'>".$msg."</div>"; }
	?>
	<div class='acp-box'>
	<h3><?php echo $r['subject']; ?></h3>
	<table width="100%" cellpadding="0" cellspacing="0" border="1" style='border-color:#ccc'>
    <tr>
     <td width="50%;">	
		<table align="left" cellspacing="1" cellpadding="3" width="100%" border="1" style='border-color:#fff'>
			<tr>
				<th>Status:</th>
				<td><?php echo $r['status']; ?></td>
			</tr>
			<tr>
        		<th>Priority:</th>
        		<td><?php echo $r['priority']; ?></td>
   	 		</tr>
            <tr>
                <th>Area:</th>
                <td><?php echo $r['area']; ?></td>
            </tr>
		</table>
     </td>
     <td width="50">
        <table align="right" cellspacing="1" cellpadding="3" width="100%" border="1" style='border-color:#fff'>
            <tr>
                <th>Name:</th>
                <td><?php echo GetName($inf['id']); ?></td>
            </tr>
            <tr>
                <th nowrap>Email:</th>
                <td><?php if(isset($r['Email'])) { echo $r['Email']; } else { echo "N/A"; } ?></td>
            </tr>
			<tr>
                <th>Create Date:</th>
                <td><?php echo date('m/d/Y h:i:s A', strtotime($r['created'])); ?></td>
            </tr>
        </table>
     </td>
    </tr>
</table>
<div align="left">
<table cellspacing="1" cellpadding="3" width="100%" border="0" style='border-color:#ccc'>
    <h3><img src='http://127.0.0.1/cp//global/images/all/store/comments.png'> Ticket Thread</h3>
			<?php 
			$th = mysql_query("SELECT * FROM `cp_support_tickets_response` WHERE `ticket_id` = ".$tid.";");
			$thn = mysql_num_rows($th);
			if($thn != 0) {
			while($thr = mysql_fetch_array($th)) {
			?>
			<table cellspacing="5" cellpadding="5" width="100%" border="1" style='border-color:#ccc'>
		        <tr><td align="left" style='background-color:<?php if ($thr['staff'] == 0) { echo "#B1C2D4"; } else { echo "#ffd8a6"; } ?>'> <?php echo GetName($thr['p_id']); ?> - <?php echo date('D, M d Y h:i A', strtotime($thr['created'])); ?></td></tr>
                <tr><td><?php echo $thr['response']; ?></td></tr>
		    </table>
			<?php }
			} else {
			?>
			<table cellspacing="5" cellpadding="5" width="100%" border="1" style='border-color:#ccc'>
		        <tr><td align="center" style="background-color:#B1C2D4"><h4>No responses<h4></td></tr>
		    </table>
			<?php 
			} ?>
	</table>
</div>
<?php
if($r['status'] != 'Closed') {
?>
<table align="center" cellspacing="0" cellpadding="3" width="90%" border="0">
    <tr> <td align="center"> 
  </td></tr><br>
  <h2>Post Reply</h2>
    <tr class='acp-actionbar'> <td align="center">
            <div id="reply" align="left">
                    <form method="post">
                        <input type="hidden" name="ticket_id" value="<?php echo $r['ticketID']; ?>">
							<textarea name="response" id="response" cols="90" rows="9" style="width:90%"></textarea>
                            <div style="margin-left: 50px; margin-top: 30px; margin-bottom: 10px;border: 0px;">
								<input type='hidden' name='action' value='reply'>
                                <input class="button" type='submit' value='Post Reply' />
                                <input class="button" type='reset' value='Reset' />
                                <input class="button" type='button' value='Cancel' onClick="history.go(-1)" />
                            </div>
                    </form>   
            </div>                 
    </td>
	</tr>
</table>
<?php } else { ?>
<table align="center" cellspacing="0" cellpadding="3" width="90%" border="0">
    <tr> <td align="center">
      
  </td></tr><br>

    <tr class='acp-actionbar'> <td align="center">
            <div align="left">
                    Your ticket has been closed. No new replies can be made.
            </div>                 
    </td>
	</tr>
	</table>
	</div>
</div>
<?php	
	}
} 
} 
}
if(isset($_GET['sp']) && $_GET['sp'] == 'nticket') {

if(isset($_POST['action']) && $_POST['action'] == 'create') {
	// Create Ticket
	$mq = mysql_query("SELECT FLOOR(RAND() * 999999) AS num FROM cp_support_tickets WHERE 'num' NOT IN (SELECT ticketID FROM cp_support_tickets) LIMIT 1;");
	$row = mysql_fetch_array($mq);
	$ticketid = $row['num'];
	$response = escape_string($_POST['question']);
	$subject = escape_string($_POST['subject']);
	$email = escape_string($_POST['email']);
	$area = escape_string($_POST['area']);
	if($cticket = mysql_query("
		INSERT INTO `cp_support_tickets` (`ticketID`, `area`, `p_id`, `email`, `subject`, `priority`, `ip_address`, `status`, `isoverdue`, `isanswered`, `lastmessage`, `lastresponse`, `created`, `updated`)
		VALUES ('$ticketid', '$area', '$inf[id]', '$email', '$subject', 'Normal', '".$_SERVER['REMOTE_ADDR']."', 'Open', '0', '0', '".date('Y-m-d h:i:s A')."', '', '".date('Y-m-d h:i:s A')."', '')
		;") && $th = mysql_query("
		INSERT INTO `cp_support_tickets_response` (`ticket_id`, `p_id`, `form`, `staff`, `response`, `ip_address`, `created`)
		VALUES ('$ticketid', '$inf[id]', '1', '0', '$response', '".$_SERVER['REMOTE_ADDR']."', '".date('Y-m-d h:i:s A')."')
		;")) {
		$msg = "Your ticket has been created successfully. Your ticket id is <a href='store.php?p=support&tid=".$ticketid."'>#".$ticketid."</a>";
	} else {
		$msg = 'An unexpected error has occured. Please try again.';
	}
}
?>
<div id='content_wrap'>
	<ol id='breadcrumb'>
		<li><?php echo $section; ?> &raquo; Support</li>
	</ol>
	<div class='section_title'>
		<h2>Customer Support</h2>
	</div>
	<a href="?p=support"><input style='float:left;width:100px;display: inline;font-size:10px;' type='button' class='button' value='Back'></a><br><br>
	<?php if(isset($msg)) { echo "<div class='acp-message'>".$msg."</div>"; } ?>
	<div class='acp-box'>
	<h3>New Ticket</h3>
	<table class='double_pad' cellpadding='0' cellspacing='0' border='1' width='100%' align="center" style='border-color:#ccc;'>
	<form method="POST">
	<tr class='tablerow2'>
		<td width='50%'>Subject:</td>
		<td><input type='text' name='subject'></td>
	</tr>
	<tr class='tablerow1'>
		<td>Email: *optional</td>
		<td><input type='text' style='margin-left:22px;' name='email'> <button style='font-size:8px;' disabled='disabled' title='We will use this email to send you instant notifications when you get a response/status change on your ticket, and will only be used for that purpose.'>?</button></td>
	</tr>
	<tr class='tablerow2'>
		<td>Your Question:</td>
		<td><textarea rows='6' cols='50' name='question' id='question'></textarea></td>
	</tr>
	<tr class='tablerow1'>
		<td>Area of problem:</td>
		<td>
			<select name="area">
			<option value="">Select one..</option>
			<?php
			$q = mysql_query("SELECT * FROM `cp_support_faq_category`");
			while($r = mysql_fetch_array($q)) {
				echo "<option value='".$r['category']."'>".$r['category']."</option>";
			}
			?>
			<option value="Other/Not Listed">Other/Not Listed</option>
			</select>
		</td>
	</tr>
	<tr class='acp-actionbar'>
		<input type='hidden' name='action' value='create'></td>
		<td colspan='2'><input type='submit' value='Submit' class='button'></td>
	</tr>
	</form>
	</table>
	</div>
</div>
<?php }
if(isset($_GET['sp']) && $_GET['sp'] == 'faq') {
if(!isset($_GET['cat'])) {
$qs = mysql_query("SELECT * FROM `cp_support_faq_category`");
?>
<div id='content_wrap'>
	<ol id='breadcrumb'>
		<li><?php echo $section; ?> &raquo; Support</li>
	</ol>
	<div class='section_title'>
		<h2>Customer Support</h2>
	</div>
	<a href="?p=support"><input style='float:left;width:100px;display: inline;font-size:10px;' type='button' class='button' value='Back'></a><br><br>
	<div class='acp-box'>
		<h3>Frequently Asked Questions</h3>
	<table cellpadding="1" cellspacing="1" border='0' width='100%'>
			<?php
				while($q = mysql_fetch_array($qs)) {
				$res = mysql_query("SELECT * FROM `cp_support_faq` WHERE `category` = '".$q['id']."';");
				$r = mysql_num_rows($res);
				if(isset($i) && $i == 1) {
								print "<tr class='tablerow1'>";
							$i=0;
							} else { 
								print "<tr class='tablerow2'>";
							$i=1;
							}
				?>
					<td><span style='margin-left:20px;font-size:16px;color:#2d4a94;text-shadow: 0 1 0.1em black, 0 1 0.1em black'><img src='http://127.0.0.1/cp//global/images/all/store/arrow_big.png' /> <a href='http://<?php echo $_SERVER['SERVER_NAME']; ?>/store.php?p=support&sp=faq&cat=<?php echo $q['id']; ?>'><?php echo $q['category']." (".$r.")"; ?></a></span></td>
				</tr>
				<?php
				}
			?>
	</table>
	</div>
	</div>
<?php
}
if(isset($_GET['cat']) && !isset($_GET['qid'])) {
$cat = $_GET['cat'];
if (!preg_match("/^[0-9]{1,}+$/", $cat)) {
	print "<meta http-equiv=\"refresh\" content=\"0;url=http://".$_SERVER['SERVER_NAME']."/store.php?p=support&sp=faq\">";exit();
}
$qs = mysql_query("SELECT * FROM `cp_support_faq` WHERE `category` = '".$_GET['cat']."';");
$res = mysql_num_rows($qs)
?>
<div id='content_wrap'>
	<ol id='breadcrumb'>
		<li><?php echo $section; ?> &raquo; Support</li>
	</ol>
	<div class='section_title'>
		<h2>Customer Support</h2>
	</div>
	<a href="?p=support&sp=faq"><input style='float:left;width:100px;display: inline;font-size:10px;' type='button' class='button' value='Back'></a><br><br>
	<div class='acp-box'>
		<h3>Frequently Asked Questions > <?php $q = mysql_query("SELECT `category` FROM `cp_support_faq_category` WHERE `id` = '".$cat."';"); $r = mysql_fetch_array($q); echo $r['category']; ?></h3>
	<table cellpadding="1" cellspacing="1" border='0' width='100%'>
			<?php
				while($r = mysql_fetch_array($qs)) {
				if(isset($i) && $i == 1) {
								print "<tr class='tablerow1'>";
							$i=0;
							} else { 
								print "<tr class='tablerow2'>";
							$i=1;
							}
				?>
					<td><span style='margin-left:30px;font-size:14px;color:#2d4a94;text-shadow: 0 1 0.1em black, 0 1 0.1em black'><img src='http://127.0.0.1/cp//global/images/all/store/arrow_small.png' /><a href='http://<?php echo $_SERVER['SERVER_NAME']; ?>/store.php?p=support&sp=faq&cat=<?php echo $_GET['cat']; ?>&qid=<?php echo $r['faq_id']; ?>'><?php echo $r['question']; ?></a></span></td>
				</tr>
				<?php
				}
				if($res == 0) {
				?>
				<tr class='acp-actionbar'>
					<td style='margin-left:30px;font-size:14px;color:#2d4a94;text-shadow: 0 1 0.1em black, 0 1 0.1em black'>No questions/answers found in this category!</td>
				</tr>
				<?php
				}
			?>
	</table>
	</div>
	</div>
<?php
}
if(isset($_GET['cat']) && isset($_GET['qid'])) {
$cat = $_GET['cat'];
if (!preg_match("/^[0-9]{1,}+$/", $cat)) {
	print "<meta http-equiv=\"refresh\" content=\"0;url=http://".$_SERVER['SERVER_NAME']."/store.php?p=support&sp=faq\">";exit();
}
$qid = $_GET['qid'];
if (!preg_match("/^[0-9]{1,}+$/", $qid)) {
	print "<meta http-equiv=\"refresh\" content=\"0;url=http://".$_SERVER['SERVER_NAME']."/store.php?p=support&sp=faq\">";exit();
}
$qs = mysql_query("SELECT * FROM `cp_support_faq` WHERE `category` = '".$cat."' AND `faq_id` = '".$qid."';");
?>
<div id='content_wrap'>
	<ol id='breadcrumb'>
		<li><?php echo $section; ?> &raquo; Support</li>
	</ol>
	<div class='section_title'>
		<h2>Customer Support</h2>
	</div>
	<a href="?p=support&sp=faq&cat=<?php echo $cat; ?>"><input style='float:left;width:100px;display: inline;font-size:10px;' type='button' class='button' value='Back'></a><br><br>
	<div class='acp-box'>
		<h3>Frequently Asked Questions > <?php $q = mysql_query("SELECT `category` FROM `cp_support_faq_category` WHERE `id` = '".$cat."';"); $r = mysql_fetch_array($q); echo $r['category']; ?> > <?php $q = mysql_query("SELECT `question` FROM `cp_support_faq` WHERE `faq_id` = '".$qid."';"); $r = mysql_fetch_array($q); echo $r['question']; ?></h3>
			<p>
			<?php
				while($r = mysql_fetch_array($qs)) {
				?>
						<p style='font-size:16px;color:#2d4a94;text-shadow: 0 1 0.1em black, 0 1 0.1em black'><?php echo "<b>".$r['question']."</b>"; ?></p>
					
						<p style='font-size:16px;text-shadow: 0 1 0.1em black, 0 1 0.1em black'><?php echo nl2br($r['answer']); ?></p>
				<?php
				}
			?>
			</p>
	</div>
	</div>
<?php 
}
}
if(isset($_GET['sp']) && $_GET['sp'] == 'items' && !isset($_GET['item_id'])) {
?>
<div id='content_wrap'>
	<ol id='breadcrumb'>
		<li><?php echo $section; ?> &raquo; Support</li>
	</ol>
	<div class='section_title'>
		<h2>Customer Support</h2>
	</div>
	<a href="?p=support"><input style='float:left;width:100px;display: inline;font-size:10px;' type='button' class='button' value='Back'></a><br><br>
	<div class='acp-box'>
		<h3>Store Items</h3>
	<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%' align="center">
		<?php
		$support_items = mysql_query("SELECT * FROM `cp_support_items` ORDER BY `item_category`, `sort_id` ASC");
		$row = 1;
		while($item = mysql_fetch_array($support_items)) {
			if ($row % 5 == 1) { 
				echo "</tr>";
				echo "<tr>";
			}
			?>
			<td width="20%"><a href="?p=support&sp=items&item_id=<?php echo $item['id']; ?>"><span style='font-size:16px;color:#2d4a94;text-shadow: 0 1 0.1em black, 0 1 0.1em black'><?php echo $item['item_name']; ?></span><br><img style="margin-top:10px;" src='<?php echo $item['item_picture']; ?>'></a></td>
			<?php
			$row++;
		}
		?>
		</tr>
		<tr>
			<td class='acp-actionbar' colspan='5'><b>*Click on an item to see more details.</b></td>
		</tr>
	</table>
	</div>
	</div>
<?php }
if(isset($_GET['item_id'])) {
if (!preg_match("/^[0-9]{1,6}+$/", $_GET['item_id'])) {
		print "<meta http-equiv=\"refresh\" content=\"0;url=store.php?p=support&sp=items\">";exit();
}
$support_items = mysql_query("SELECT * FROM `cp_support_items` WHERE `id` = '".$_GET['item_id']."'");
$item = mysql_fetch_array($support_items);
?>
<div id='content_wrap'>
	<ol id='breadcrumb'>
		<li><?php echo $section; ?> &raquo; Support</li>
	</ol>
	<div class='section_title'>
		<h2>Customer Support</h2>
	</div>
	<a href="?p=support&sp=items"><input style='float:left;width:100px;display: inline;font-size:10px;' type='button' class='button' value='Back'></a><br><br>
	<div class='acp-box'>
		<h3><?php echo $item['item_name']; ?></h3>
	<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%' align="center">
		<tr class='tablerow1'>
			<td width="25%"><img src='<?php echo $item['item_picture']; ?>'></td>
			<td width="15%"><span style='font-size:21px;color:#2d4a94;text-shadow: 0 1 0.1em black, 0 1 0.1em black'><?php echo $item['item_name']; ?></span></td>
			<td width="5%"></td>
		</tr>
		<tr class='tablerow1'>
			<td width="5%"></td>
			<td width="5%"><span style='font-size:12px;color:#2d4a94;'>Price:</span></td>
			<td width="25%">
				<span style='font-size:12px;'><?php echo number_format($item['item_credit_price']); ?>
				<?php
					if($item['item_credit_price'] < 500) {
						echo "<img src='http://127.0.0.1/cp//global/images/all/store/coin_single.png' title='credits'>";
					}
					if($item['item_credit_price'] >= 500) {
						echo "<img src='http://127.0.0.1/cp//global/images/all/store/coin_stack.png' title='credits'>";
					}
				?>
				</span>
			</td>
		</tr>
		<tr class='tablerow1'>
			<td width="5%"></td>
			<td width="15%"><span style='font-size:12px;color:#2d4a94;'>Description:</span></td>
			<td width="85%"></td>
		</tr>
		<tr class='tablerow1'>
			<td width="5%"></td>
			<td width="15%"></td>
			<td width="85%"><span style='font-size:12px;'><?php echo nl2br($item['item_description']); ?></span></td>
		</tr>
	</table>
	</div>
	</div>
<?php 
}
?>