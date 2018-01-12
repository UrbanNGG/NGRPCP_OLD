<div id='content_wrap'>
	<ol id='breadcrumb'><li><?php echo $section; ?> > Signatures</li></ol>
	<div class='section_title'><h2>Signatures</h2></div>
		<div class='acp-box'>
			<h3>Stat Signatures</h3>
			<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
				<form action="index/proc.php" method="POST">
				<?php
				$sigquery = mysql_query("SELECT * FROM `sig_stats` WHERE `user_id` = '$inf[id]'");
				$sigarray = mysql_fetch_array($sigquery);
				if(!$sigarray) { ?>
				<tr class="tablerow1">
					<td align="center">Click the button below to generate a stat signature</td>
				</tr>
				<tr class="acp-actionbar">
					<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
					<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
					<td align="center"><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"><input type="hidden" name="action" value="sig_generate"><input type="submit" class="button" value="Generate Signature"></td>
				</tr>
				<?php }
				else { ?>
				<tr><td align="center" colspan="10"><img src='http://sampweb.ng-gaming.net/sig/stats.php?id=<?php echo $inf["id"]; ?>' /></td></tr>
				<tr><td align="center" colspan="10"><input rows="2" value="[URL='http://www.ng-gaming.net/'][IMG]http://sampweb.ng-gaming.net/sig/stats.php?id=<?php echo $inf["id"]; ?>'[/IMG][/URL]" style="width:100%;-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;" onclick="this.focus();this.select()"></input></td></tr>
				<tr class="tablerow1" height="80px">
					<td><input type="checkbox" name="field[]" value="field1" <?php if($sigarray['field1'] == 1) echo "checked='checked'"; ?>><legend>Sex</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field2" <?php if($sigarray['field2'] == 1) echo "checked='checked'"; ?>><legend>Date of Birth</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field3" <?php if($sigarray['field3'] == 1) echo "checked='checked'"; ?>><legend>Total Wealth</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field4" <?php if($sigarray['field4'] == 1) echo "checked='checked'"; ?>><legend>Playing Hours</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field5" <?php if($sigarray['field5'] == 1) echo "checked='checked'"; ?>><legend>Phone Number</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field6" <?php if($sigarray['field6'] == 1) echo "checked='checked'"; ?>><legend>Cash</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field7" <?php if($sigarray['field7'] == 1) echo "checked='checked'"; ?>><legend>Bank</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field8" <?php if($sigarray['field8'] == 1) echo "checked='checked'"; ?>><legend>Health</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field9" <?php if($sigarray['field9'] == 1) echo "checked='checked'"; ?>><legend>Armor</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field10" <?php if($sigarray['field10'] == 1) echo "checked='checked'"; ?>><legend>Upgrade Points</legend></input></td>
				</tr>
				<tr height="80px">
					<td><input type="checkbox" name="field[]" value="field11" <?php if($sigarray['field11'] == 1) echo "checked='checked'"; ?>><legend>Next Level</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field12" <?php if($sigarray['field12'] == 1) echo "checked='checked'"; ?>><legend>Faction/Family</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field13" <?php if($sigarray['field13'] == 1) echo "checked='checked'"; ?>><legend>Rank</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field14" <?php if($sigarray['field14'] == 1) echo "checked='checked'"; ?>><legend>Division</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field15" <?php if($sigarray['field15'] == 1) echo "checked='checked'"; ?>><legend>Business</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field16" <?php if($sigarray['field16'] == 1) echo "checked='checked'"; ?>><legend>Business Rank</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field17" <?php if($sigarray['field17'] == 1) echo "checked='checked'"; ?>><legend>Job 1</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field18" <?php if($sigarray['field18'] == 1) echo "checked='checked'"; ?>><legend>Job 2</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field19" <?php if($sigarray['field19'] == 1) echo "checked='checked'"; ?>><legend>Crimes</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field20" <?php if($sigarray['field20'] == 1) echo "checked='checked'"; ?>><legend>Arrests</legend></input></td>
				</tr>
				<tr class="tablerow1" height="80px">
					<td><input type="checkbox" name="field[]" value="field21" <?php if($sigarray['field21'] == 1) echo "checked='checked'"; ?>><legend>Wanted Level</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field22" <?php if($sigarray['field22'] == 1) echo "checked='checked'"; ?>><legend>Insurance</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field23" <?php if($sigarray['field23'] == 1) echo "checked='checked'"; ?>><legend>Nation</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field24" <?php if($sigarray['field24'] == 1) echo "checked='checked'"; ?>><legend>Married To</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field25" <?php if($sigarray['field25'] == 1) echo "checked='checked'"; ?>><legend>Paintball Tokens</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field26" <?php if($sigarray['field26'] == 1) echo "checked='checked'"; ?>><legend>Pot</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field27" <?php if($sigarray['field27'] == 1) echo "checked='checked'"; ?>><legend>Crack</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field28" <?php if($sigarray['field28'] == 1) echo "checked='checked'"; ?>><legend>Crates</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field29" <?php if($sigarray['field29'] == 1) echo "checked='checked'"; ?>><legend>Paper</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field30" <?php if($sigarray['field30'] == 1) echo "checked='checked'"; ?>><legend>Materials</legend></input></td>
				</tr>
				<tr height="80px">
					<td><input type="checkbox" name="field[]" value="field31" <?php if($sigarray['field31'] == 1) echo "checked='checked'"; ?>><legend>Ropes</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field32" <?php if($sigarray['field32'] == 1) echo "checked='checked'"; ?>><legend>Cigars</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field33" <?php if($sigarray['field33'] == 1) echo "checked='checked'"; ?>><legend>Sprunk</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field34" <?php if($sigarray['field34'] == 1) echo "checked='checked'"; ?>><legend>Spraycans</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field35" <?php if($sigarray['field35'] == 1) echo "checked='checked'"; ?>><legend>Screwdrivers</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field36" <?php if($sigarray['field36'] == 1) echo "checked='checked'"; ?>><legend>VIP Tokens</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field37" <?php if($sigarray['field37'] == 1) echo "checked='checked'"; ?>><legend>Checks</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field38" <?php if($sigarray['field38'] == 1) echo "checked='checked'"; ?>><legend>VIP Rank</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field39" <?php if($sigarray['field39'] == 1) echo "checked='checked'"; ?>><legend>Radio Frequency</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field40" <?php if($sigarray['field40'] == 1) echo "checked='checked'"; ?>><legend>Warnings</legend></input></td>
				</tr>
				<tr class="tablerow1" height="80px">
					<td><input type="checkbox" name="field[]" value="field41" <?php if($sigarray['field41'] == 1) echo "checked='checked'"; ?>><legend>Advertisement Mutes</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field42" <?php if($sigarray['field42'] == 1) echo "checked='checked'"; ?>><legend>Newbie Mutes</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field43" <?php if($sigarray['field43'] == 1) echo "checked='checked'"; ?>><legend>Report Mutes</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field44" <?php if($sigarray['field44'] == 1) echo "checked='checked'"; ?>><legend>Weapon Restriction Time</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field45" <?php if($sigarray['field45'] == 1) echo "checked='checked'"; ?>><legend>Gang Warns</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field46" <?php if($sigarray['field46'] == 1) echo "checked='checked'"; ?>><legend>EXP Tokens</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field47" <?php if($sigarray['field47'] == 1) echo "checked='checked'"; ?>><legend>EXP Hours</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field48" <?php if($sigarray['field48'] == 1) echo "checked='checked'"; ?>><legend>Opium Seeds</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field49" <?php if($sigarray['field49'] == 1) echo "checked='checked'"; ?>><legend>Raw Opium</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field50" <?php if($sigarray['field50'] == 1) echo "checked='checked'"; ?>><legend>Syringes</legend></input></td>
				</tr>
				<tr height="80px">
					<td><input type="checkbox" name="field[]" value="field51" <?php if($sigarray['field51'] == 1) echo "checked='checked'"; ?>><legend>Heroin</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field52" <?php if($sigarray['field52'] == 1) echo "checked='checked'"; ?>><legend>Hunger</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field53" <?php if($sigarray['field53'] == 1) echo "checked='checked'"; ?>><legend>Fitness</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field54" <?php if($sigarray['field54'] == 1) echo "checked='checked'"; ?>><legend>Event Tokens</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field55" <?php if($sigarray['field55'] == 1) echo "checked='checked'"; ?>><legend>Referrals</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field56" <?php if($sigarray['field56'] == 1) echo "checked='checked'"; ?>><legend>Famed Rank</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field57" <?php if($sigarray['field57'] == 1) echo "checked='checked'"; ?>><legend>Additional Vehicle Slots</legend></input></td>
					<td><input type="checkbox" name="field[]" value="field58" <?php if($sigarray['field58'] == 1) echo "checked='checked'"; ?>><legend>Additional Toy Slots</legend></input></td>
					<td></td>
					<td></td>
				</tr>
				<tr class="acp-actionbar">
					<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
					<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
					<td align="center" colspan="10"><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"><input type="hidden" name="action" value="sig_update"><input type="submit" class="button" value="Update Signature"></td>
				</tr>
				</form>
				</table>
				<h3>Enable/Disable</h3>
				<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
				<form action="index/proc.php" method="POST">
				<tr class="acp-actionbar">
					<input type='hidden' name='admin' readonly='readonly' value='<?php echo $_SESSION['myusername']; ?>'>
					<input type='hidden' name='ip' readonly='readonly' value='<?php echo $_SERVER['REMOTE_ADDR']; ?>'>
					<td align="center" colspan="10"><input type="hidden" name="userid" value="<?php echo $inf['id']; ?>"><input type="hidden" name="action" value="sig_enable"><?php if($sigarray['enabled'] == 1) { ?><input type="hidden" name="enable" value="1"><input type="submit" class="button" value="Disable Signature"><?php } if($sigarray['enabled'] == 0) { ?><input type="hidden" name="enable" value="0"><input type="submit" class="button" value="Enable Signature"><?php } ?></td>
				</tr>
				<?php } ?>
				</form>
			</table>
		</div>
</div>