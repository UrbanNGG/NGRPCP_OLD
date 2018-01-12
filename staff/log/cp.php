<?php $log = $_GET['log'];
if(($log == "staff" && $access['cplstaff'] != 1) || ($log == "general" && $access['cplgeneral'] != 1) || ($log == "faction" && $access['cplfaction'] != 1) || ($log == "family" && $access['cplfamily'] != 1) || ($log == "cr" && $access['cplcr'] != 1) || ($log == "access" && $access['cplaccess'] != 1)) {
echo $redir2;
exit();
}

if(!isset($_GET['log'])) {
echo "<div id='content_wrap'>
		<ol id='breadcrumb'><li>Logs > CP Logs</li></ol>
		<div class='section_title'><h2>CP Logs</h2></div>
	<div class='acp-box'>
	No log specified!</div></div>"; 
}
else {
?>

	<div id='content_wrap'>
		<ol id='breadcrumb'><li>Logs > CP Logs</li></ol>
		<div class='section_title'><h2>CP Logs</h2></div>
	<div class='acp-box'>
		<h3>
		<table><tr>
			<td width='33%' align='left'>
			<?php
				if(!isset($_GET['limit']) || $_GET['limit'] == 0) { echo ""; }
				else {
					$prev = $_GET['limit'] - 500;
					echo "<a href='log.php?p=cp&log=$log&limit=$prev'><< Prev</a>";
				}
			?>
			</td>
			<td width='33%' align='center'>CP Log -- <?php if($log == "cr") { echo "Customer Relations"; } else { echo ucfirst(strtolower($log)); } ?></td>
			<td width='33%' align='right'>
			<?php
				if(!isset($_GET['limit'])) { $_GET['limit'] = 0; }
				$next = $_GET['limit'] + 500;
				echo "<a href='log.php?p=cp&log=$log&limit=$next'>Next >></a>";
			?>
			</td>
		</tr></table>
		</h3>
		<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'> 
<tr><th>Username</th><th>Date</th><th>Section</th><th>Details</th><th>IP</th></tr>
<?php
$sql = mysql_query("SELECT * FROM cp_log_$log ORDER BY id DESC LIMIT $_GET[limit],500");
while ($entry = mysql_fetch_array($sql)) {

	if (isset($i) && $i == 1) { print "<tr class='tablerow1'>";
		$i=0;
	} else { print "<tr>";
		$i=1;
	}

if($entry['user_id'] == 0 || GetName($entry['user_id']) == '') { print "<td>Unknown</td>"; }
else { 
if(preg_match('%[_]%', GetName($entry['user_id']))) {
	print "<td><a target='_blank' href='http://".$_SERVER['SERVER_NAME']."/staff/player.php?p=view&player_name=".GetName($entry['user_id'])."'>".GetName($entry['user_id'])."</a></td>";
} else {
	print "<td>".GetName($entry['user_id'])."</td>";
}
 }
print "
<td>$entry[date]</td>
<td>$entry[area]</td>
<td>$entry[details]</td>
<td>".FlagWithIp($entry['ip_address'])." <a style='font-size:8px;' target='_blank' href='http://www.ip-tracker.org/locator/ip-lookup.php?ip=".$entry['ip_address']."'>[Trace]</a></td>
</tr>
";

}
?>
			</table> 
		<div class='acp-actionbar'></div>
		</div></div>
<?php } ?>