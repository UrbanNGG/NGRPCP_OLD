<?php if(!isset($_GET['tid'])) { ?>
<div id='content_wrap'>
	<ol id='breadcrumb'>
		<li><?php echo $section; ?> &raquo; Tracker</li>
	</ol>
	<div class='section_title'>
		<h2>Credit Tracker</h2>
	</div>
	<div class='acp-box'>
		<h3>Tracker</h3>
	<table class='double_pad' cellpadding='0' cellspacing='0' border='1' width='100%' align="center" style='border-color:#ccc;'>
	<th>Database ID</th><th>Username</th><th>Total Credits</th>
	<?php
	$pls = mysql_query("SELECT `id`, `Username`, `Credits` FROM `accounts` WHERE `AdminLevel` < 2 ORDER BY `Credits` DESC LIMIT 50");
	while($pl = mysql_fetch_array($pls)) {
	if(isset($i) && $i == 1) {
											print "<tr class='tablerow1'>";
										$i=0;
										} else { 
											print "<tr class='tablerow2'>";
										$i=1;
										}
		echo "
			<td><a href='https://127.0.0.1/cp//staff/cr.php?p=csearch&pid=".$pl['id']."'>".$pl['id']."</a></td>
			<td><a href='https://127.0.0.1/cp//staff/cr.php?p=csearch&pid=".$pl['id']."'>".$pl['Username']."</a></td>
			<td>".number_format($pl['Credits'])."</td>
		</tr>";
	}
	?>
    </table>
	</div>
</div>
<?php } else { ?>
<script type="text/javascript">
 var selectionsObject = {
 	"Change Priority":	['Low', 'Normal', 'High'],
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
<div id='content_wrap'>
	<ol id='breadcrumb'>
		<li><?php echo $section; ?> Support</li>
	</ol>
	<?php
	$tid = $_GET['tid'];
	if (!preg_match("/^[0-9]{1,6}+$/", $tid)) {
		print "<meta http-equiv=\"refresh\" content=\"0;url=cr.php?p=support\">";exit();
	}
	if(isset($_POST['action']) && $_POST['action'] == 'reply') {
		$response = escape_string($_POST['response']);
		if($response != "") {
		$th = mysql_query("
		INSERT INTO `cp_support_tickets_response` (`ticket_id`, `p_id`, `form`, `staff`, `response`, `ip_address`, `created`)
		VALUES ('$tid', '$inf[id]', '0', '1', '$response', '".$_SERVER['REMOTE_ADDR']."', '".date('Y-m-d h:i:s A')."')
		");
		$re = mysql_query("
		UPDATE `cp_support_tickets` SET `lastresponse` = '".date('Y-m-d h:i:s A')."' WHERE `ticketID` = '$tid'
		");
		} 
	}
	if(isset($_POST['action']) && $_POST['action'] == 'status') {
		if($_POST['status'] == 'close') {
			if($q = mysql_query("UPDATE `cp_support_tickets` SET `status` = 'Closed' where `ticketID` = '".$tid."';")) {
				$msg = 'Ticket has been closed.';
				doLog("$inf[id]", "Customer Relations", "Support Tickets", "Closed Ticket #$tid");
			}
		}
		if($_POST['status'] == 'reopen') {
			if($q = mysql_query("UPDATE `cp_support_tickets` SET `status` = 'Open' where `ticketID` = '".$tid."';")) {
				$msg = 'Ticket has been re-opened.';
				doLog("$inf[id]", "Customer Relations", "Support Tickets", "Reopened Ticket #$tid");
			}
		}
	}
	$t = mysql_query("SELECT * FROM `cp_support_tickets` WHERE `ticketID` = '".$tid."';");
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
		<h2>View Ticket #<?php echo $_GET['tid']; ?> <a href="cr.php?p=support&tid=<?php echo $_GET['tid']; ?>" title="Reload"><img src='http://cdn1.iconfinder.com/data/icons/silk2/arrow_refresh.png' /></a></h2>
	</div>
	<?php if(isset($msg)) {
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
                <td><?php echo GetName($r['p_id']); ?></td>
            </tr>
            <tr>
                <th nowrap>Email:</th>
                <td><?php if (!empty($r['email'])) { echo $r['email']; } else { echo "N/A"; } ?></td>
            </tr>
			<tr>
                <th>Create Date:</th>
                <td><?php echo date('m/d/Y h:i:s A', strtotime($r['created'])); ?></td>
            </tr>
        </table>
     </td>
    </tr>
    <tr>
     <td width="50%">
        <table align="center" cellspacing="1" cellpadding="3" width="100%" border="1" style='border-color:#fff'>
            <tr>
                <th>Assigned Staff:</th>
                <td><?php echo GetName($r['a_id']); ?></td>
            </tr>
            <tr>
                <th nowrap>Last Response:</th>
                <td><?php echo $r['lastresponse']; ?></td>
            </tr>
                    </table>
     </td>
     <td width=50% valign="top">
        <table align="center" cellspacing="1" cellpadding="3" width="100%" border="1" style='border-color:#fff'>
            <tr>
                <th>IP Address:</th>
                <td><?php echo FlagWithIP($r['ip_address']); ?></td>
            </tr>
            <tr><th nowrap>Last Message:</th>
                <td><?php echo $r['lastmessage']; ?></td>
            </tr>
        </table>
     </td>
    </tr>
</table>
<div>
    </div>
 
<table cellpadding="0" cellspacing="2" border="0" width="100%" style='border-color:#ccc'>
    <tr class='tablerow1'><td>
        <form method='POST'>
            <input type='hidden' name='ticket_id' value="729"/>
            <input type='hidden' name='a' value="process"/>
            <span for="do"> &nbsp;<b>Action:</b></span>
            <select name="status" 
              onchange="populateSelectbox(this,this.form.change_priority,selectionsObject)">
                <option value="">Select Action</option>
                <option value="change_priority"  >Change Priority</option>
                                <option value="overdue"  >Mark Overdue</option>
                                                
                                    <?php
									if($r['status'] != 'Closed') {
									?>
									 <option value="close"  >Close Ticket</option>
									<?php } else {
									?>
									 <option value="reopen"  >Reopen Ticket</option>
									<?php } ?>
                                        
                        <option value="banemail" >Ban Email &amp; Close</option>
                                    
                                <option value="delete" >Delete Ticket</option>
                            </select>
            <span for="ticket_priority">Priority:</span>
            <select id="ticket_priority" name="ticket_priority" disabled >
                <option value="0" selected="selected">-Unchanged-</option>
                                    <option value="1"  >Low</option>
                                    <option value="2"  >Normal</option>
                                    <option value="3" >High</option>
                                    <option value="4"  >Emergency</option>
                                    <option value="5"  >Pending EA</option>
                                    <option value="6"  >Pending Logs</option>
                                    <option value="7"  >Pending Evidence</option>
                                    <option value="8"  >Under Review</option>
                                    <option value="10"  >Overdue</option>
                            </select>
                &nbsp;&nbsp;
			<input type="hidden" name="action" value="status">
            <input class="button" type="submit" value="GO">
        </form>
    </tr></td>
</table>
<div align="left">
<table cellspacing="1" cellpadding="3" width="100%" border="0" style='border-color:#ccc'>
    <h3><img src='http://cdn1.iconfinder.com/data/icons/silk2/comments.png'> Ticket Thread</h3>
			<?php 
			$th = mysql_query("SELECT * FROM `cp_support_tickets_response` WHERE `ticket_id` = ".$tid.";");
			$thn = mysql_num_rows($th);
			if($thn != 0) {
			while($thr = mysql_fetch_array($th)) {
			?>
			<table cellspacing="5" cellpadding="5" width="100%" border="1" style='border-color:#ccc'>
		        <tr><td align="left" style='background-color:<?php if ($thr['staff'] == 0) { echo "#B1C2D4"; } else { echo "#ffd8a6"; } ?>'> <?php echo GetName($thr['p_id']); ?> - <?php echo date('D, M d Y h:i A', strtotime($thr['created'])); ?></td></tr>
                <tr><td><?php echo nl2br($thr['response']); ?></td></tr>
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
<table align="center" cellspacing="0" cellpadding="3" width="90%" border=0>
    <tr> <td align="center">
      
  </td></tr>
    <tr> <td align="center">
        <div class="tabber">
            <div id="reply" class="tabbertab" align="left">
                <h2>Post Reply</h2>
                <p>
                    <form name="reply" method="post">
                        <input type="hidden" name="ticket_id" value="<?php echo $r['ticketID']; ?>">
                        <div><font class="error">&nbsp;</font></div>
                        <div>
                                                          Canned Response:&nbsp;
                               <select id="canned" name="canned"
                                onChange="getCannedResponse(this.options[this.selectedIndex].value,this.form,'response');this.selectedIndex='0';" >
                                <option value="0" selected="selected">Select a premade reply</option>
                                    <option value="4" >Pending Staff Assignment</option>
                                    <option value="13" >Assigner Reply</option>
                                    <option value="6" >Supervisor Review</option>
                                    <option value="7" >Double ticket</option>
                                    <option value="8" >Resolved - No info</option>
                                    <option value="9" >Resolved - Info</option>
                                    <option value="10" >Closed</option>
                                    <option value="11" >No reply</option>
                                <option value="12" >Assignee Reply</option>
                            </select>&nbsp;&nbsp;&nbsp;<label><input type='checkbox' value='1' name=append checked="true" />Append</label>
							<input type='hidden' name='action' value='reply'>
                            <textarea name="response" id="response" cols="90" rows="9" wrap="soft" style="width:90%"></textarea>
                        </div>
                        <div style="margin-top: 10px;">
                            <label for="signature" nowrap>Append Signature:</label>
                            <label><input type="radio" name="signature" value="none" checked > None</label>
                            <label><input type="radio" name="signature" value="dept"  > Dept Signature</label>
                        </div>
						<div style="margin-top: 3px;">
							<b>Ticket Status:</b>
                            <label><input type="checkbox" name="ticket_status" id="l_ticket_status" value="Close"  > Close on Reply</label>
                        </div>
                        <p>
                            <div style="margin-left: 50px; margin-top: 30px; margin-bottom: 10px;border: 0px;">
                                <input class="button" type='submit' value='Post Reply' />
                                <input class="button" type='reset' value='Reset' />
                                <input class="button" type='button' value='Cancel' onClick="history.go(-1)" />
                            </div>
                        </p>
                    </form>                
                </p>
            </div>                 
        </div>
    </td>
 </tr>

<?php } ?>
	</table>
	</div>
</div>
<?php } ?>