			<div id='content_wrap'>
				<ol id='breadcrumb'><li>User Management > Shifts</li></ol>
				<div class='section_title'><h2>Alerts</h2></div>
			<div class='acp-box'>
				<?php
				if(!isset($_GET['week'])) {
				$week = date('Y-m-d');
				$dateweek = date('W');
				}
				if(isset($_GET['week'])) {
				$gweek = $_GET['week'];
				$week = date('Y-m-d', strtotime("+".$_GET['week']." week"));
				$dateweek = date('W', strtotime("+".$_GET['week']." week"));
				}
				if ($inf['AdminLevel'] >= 2) { $stafftype = "Administrators"; } else { $stafftype = "Advisors"; }
				print "
					<h3><table class='thead'><tr>
						<td align='left'><a href='user.php?p=alert&week=".(isset($_GET['week']) - 1)."'><< Last Week</a></td>
						<td align='center'>Current Week: $dateweek</td>
						<td align='right'><a href='user.php?p=alert&week=".(isset($_GET['week']) + 1)."'>Next Week >></a></td>
					</tr></table></h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='1' width='100%'>
					<tr><th width='20%'>".$stafftype."</th><th width='10%'>Points Accumulated</th><th width='10%'>Reports (RPD)</th><th width='15%'>Completed Shifts</th><th width='15%'>Partially Completed Shifts</th><th width='15%'>Missed Shifts</th><th width='15%'>Total Number of Shifts</th></tr>
				";
				if ($inf['AdminLevel'] >= 2) $adminquery = mysql_query("SELECT `id`, `Username`, `AdminType` FROM `accounts` WHERE `AdminLevel` > 1 AND `AdminLevel` < 4 AND `AdminType` <> 1 AND `Band` = 0 AND `Disabled` = 0 ORDER BY `Username` ASC");
				else $adminquery = mysql_query("SELECT `id`, `Username` FROM `accounts` WHERE `Helper` > 1 AND `Band` = 0 AND `Disabled` = 0 ORDER BY `Username` ASC");
				while($admin = mysql_fetch_array($adminquery))
				{
					if ($inf['AdminLevel'] >= 2)
					{
						$countquery = mysql_query("SELECT NULL FROM `cp_shifts` WHERE `user_id` = '$admin[id]' AND YEARWEEK(`date`) = YEARWEEK('$week') AND `type` = '1'");
						$ccountquery = mysql_query("SELECT NULL FROM `cp_shifts` WHERE `user_id` = '$admin[id]' AND `status` = 3 AND YEARWEEK(`date`) = YEARWEEK('$week') AND `type` = '1'");
						$pcountquery = mysql_query("SELECT NULL FROM `cp_shifts` WHERE `user_id` = '$admin[id]' AND `status` = 4 AND YEARWEEK(`date`) = YEARWEEK('$week') AND `type` = '1'");
						$mcountquery = mysql_query("SELECT NULL FROM `cp_shifts` WHERE `user_id` = '$admin[id]' AND `status` = 5 AND YEARWEEK(`date`) = YEARWEEK('$week') AND `type` = '1'");
					}
					else
					{
						$countquery = mysql_query("SELECT NULL FROM `cp_shifts` WHERE `user_id` = '$admin[id]' AND YEARWEEK(`date`) = YEARWEEK('$week') AND `type` = '3'");
						$ccountquery = mysql_query("SELECT NULL FROM `cp_shifts` WHERE `user_id` = '$admin[id]' AND `status` = 3 AND YEARWEEK(`date`) = YEARWEEK('$week') AND `type` = '3'");
						$pcountquery = mysql_query("SELECT NULL FROM `cp_shifts` WHERE `user_id` = '$admin[id]' AND `status` = 4 AND YEARWEEK(`date`) = YEARWEEK('$week') AND `type` = '3'");
						$mcountquery = mysql_query("SELECT NULL FROM `cp_shifts` WHERE `user_id` = '$admin[id]' AND `status` = 5 AND YEARWEEK(`date`) = YEARWEEK('$week') AND `type` = '3'");
					}
					$count = mysql_num_rows($countquery);
					$ccount = mysql_num_rows($ccountquery);
					$pcount = mysql_num_rows($pcountquery);
					$mcount = mysql_num_rows($mcountquery);

					$scweekquery = mysql_query("SELECT COUNT(id) AS shift_count, SUM(bonus) AS shift_bonus FROM `cp_shifts` WHERE `user_id` = $admin[id] AND `status` = 3 AND YEARWEEK(date) = YEARWEEK('$week')");
					$scweek = mysql_fetch_array($scweekquery);
					$scweeksubquery = mysql_query("SELECT COUNT(id) AS shift_count FROM `cp_shifts` WHERE `user_id` = $admin[id] AND `status` = 5 AND `bonus` = 0 AND YEARWEEK(date) = YEARWEEK('$week')");
					$scweeksub = mysql_fetch_array($scweeksubquery);
					$scweekbonussubquery = mysql_query("SELECT COUNT(id) AS shift_count FROM `cp_shifts` WHERE `user_id` = $admin[id] AND `status` = 5 AND `bonus` = 2 AND YEARWEEK(date) = YEARWEEK('$week')");
					$scweekbonussub = mysql_fetch_array($scweekbonussubquery);

					$shiftpoints = $scweek['shift_count'] + $scweek['shift_bonus'];
					if($scweekbonussub['shift_count'] > 0) $shiftpoints -= $scweekbonussub['shift_count'] * 2;
					if($scweeksub['shift_count'] > 0) $shiftpoints -= $scweeksub['shift_count'];
					
					$reportcountquery = mysql_query("SELECT SUM(count) AS count FROM `tokens_report` WHERE `playerid` = $admin[id] AND YEARWEEK(`date`) = YEARWEEK('$week')");
					$ReportCount = mysql_fetch_array($reportcountquery);
					if(is_null($ReportCount['count'])) $ReportCount['count'] = 0;
					$RPD = round($ReportCount['count']/7);
					
					switch($admin['AdminType'])
					{
						default: $AdminType = ""; break;
						case 1: $AdminType = " (NGA)"; break;
						case 2: $AdminType = " (UGA)"; break;
						case 3: $AdminType = " (SGA)"; break;
					}

					if(isset($i) && $i == 1) {
						print "<tr>";
					$i=0;
					} else { 
						print "<tr class='tablerow1'>";
					$i=1;
					}
					
					if(($admin['AdminType'] != 3 && $ccount < 15) || ($admin['AdminType'] == 3 && $ccount < 9)) { print "<td><span style='font-weight:bold;color:red'>".$admin['Username'].$AdminType."</span></td><td><span style='font-weight:bold;color:red'>$shiftpoints</span></td><td><span style='font-weight:bold;color:red'>$ReportCount[count] ($RPD)</span></td><td><span style='font-weight:bold;color:red'>".$ccount."</span></td><td><span style='font-weight:bold;color:red'>".$pcount."</span></td><td><span style='font-weight:bold;color:red'>".$mcount."</span></td><td><span style='font-weight:bold;color:red'>".$count."</span></td></tr>"; }
					if(($admin['AdminType'] != 3 && $ccount >= 15) || ($admin['AdminType'] == 3 && $ccount >= 9)) { print "<td><span style='font-weight:bold'>".$admin['Username'].$AdminType."</span></td><td><span style='font-weight:bold'>$shiftpoints</span></td><td><span style='font-weight:bold'>$ReportCount[count] ($RPD)</span></td><td><span style='font-weight:bold'>".$ccount."</span></td><td><span style='font-weight:bold'>".$pcount."</span></td><td><span style='font-weight:bold'>".$mcount."</span></td><td><span style='font-weight:bold'>".$count."</span></td></tr>"; }
				}
				?>
					</table>
			</div>
			<?php if ($inf['Helper'] >= 3) { ?>
			<div class='acp-box'>
				<h3>Total Points</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='1' width='100%'>
						<tr><th><?php echo $stafftype; ?></th><th>Points</th></tr>
						<?php 
						$advisor = mysql_query("SELECT `id`, `Username` FROM `accounts` WHERE `Helper` > 1 AND `Helper` < 4 AND `Band` = 0 AND `Disabled` = 0 ORDER BY Helper ASC");
						while($ca = mysql_fetch_array($advisor)) {
							$pquery = mysql_query("SELECT `points` FROM `cp_stat` WHERE `user_id` = '$ca[id]' AND `type` = '3'");
							$p = mysql_fetch_array($pquery);
							print "<tr>";
							print "<td>".GetName($ca['id'])."</td>";
							print "<td>$p[points]</td>";
							print "</tr>";
						}
						?>
					</table>
			</div>
			<?php  } ?>
			<div class='acp-box'>
				<h3>Missed Shifts</h3>
					<table cellpadding='0' class='double_pad' cellspacing='0' border='1' width='100%'>
						<tr><th><?php echo $stafftype; ?></th><th>Number of Missed Shifts</th></tr>
						<?php
						
						if ($inf['AdminLevel'] >= 2) $adminquery = mysql_query("SELECT `id`, `Username` FROM `accounts` WHERE `AdminLevel` > 1 AND `AdminLevel` < 4 AND `Band` = 0 AND `Disabled` = 0 ORDER BY `Username` ASC");
						else $adminquery = mysql_query("SELECT `id`, `Username` FROM `accounts` WHERE `Helper` > 1 AND `Band` = 0 AND `Disabled` = 0 ORDER BY `Username` ASC");
						while($admin = mysql_fetch_array($adminquery))
						{
							if ($inf['AdminLevel'] >= 2) $mcountquery = mysql_query("SELECT NULL FROM `cp_shifts` WHERE `user_id` = '$admin[id]' AND YEARWEEK(`date`) = YEARWEEK('$week') AND `status` = 5 AND `type` = '1'");
							else $mcountquery = mysql_query("SELECT NULL FROM `cp_shifts` WHERE `user_id` = '$admin[id]' AND YEARWEEK(`date`) = YEARWEEK('$week') AND `status` = 5 AND `type` = '3'");
							$mcount = mysql_num_rows($mcountquery);
							if ($mcount != 0)
							{
								print "<tr>";
								print "<td>".GetName($admin['id'])."</td>";
								print "<td>$mcount</td>";
								print "</tr>";
							}
						}
						?>
					</table>
			</div>
			</div>