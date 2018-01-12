	<div id='content_wrap'> 
		<ol id='breadcrumb'> 
			<li>Logs > Index</li>
		</ol>

	<div class='section_title'>
		<h2>Log Index</h2>
	</div>
	<div class='acp-box'>
		<h3>Game Logs</h3>
<?php
echo '<table cellpadding="0" class="double_pad" cellspacing="0" border="0" width="100%">';
$names = array('Admin Log', 'Admin Auction Log', 'Admin Give Log', 'Admin Pay Log', 'Auction Log', 'Ban Log', 'Business Edit Log', 'Business Log', 'CLEO Log', 'Contracts Log', 'Credits Log', 'Crime Log', 'Dynamic Door Edit Log', 'Dealership Log', 'Dynamic Map Icon Edit Log', 'Dynamic Vehicle Log', 'Dynamic Vehicle Spawn Log', 'Edit Group Log', 'Faction Log', 'Family Log', 'Flag Move Log', 'Flags Log', 'Family Member Count Log', 'Gate Edit Log', 'Gifts Log', 'Government Log', 'Group Log', 'Hack Log', 'House Edit Log', 'House Log', 'House Safe Log', 'Kick Log', 'Licenses Log', 'Login Credits Log', 'Mail Log', 'Moderator Log', 'Mute Log', 'Priority Advertisements Log', 'Password Log', 'Pay Log', 'Plant Log', 'Player Vehicle Log', 'Pay N Spray Edit Log', 'Poker Log', 'RP Special Log', 'Security Log', 'Sell Credits Log', 'Set VIP Log', 'Shop Confirmed Orders Log', 'Shop Log', 'Shop Orders Log', 'Sobeit Log', 'Speedcam Log', 'Stats Log', 'Text Label Edit Log', 'Toys Log', 'Toy Delete Log', 'Undercover Log', 'VIP Name-Changes Log', 'VIP Remove Log');
$names1 = array($access['gladmin'], $access['gladminauction'], $access['gladmingive'], $access['gladminpay'], $access['glauction'], $access['glban'], $access['glbedit'], $access['glbusiness'], $access['glcleo'], $access['glcontracts'], $access['glcredits'], $access['glcrime'], $access['glddedit'], $access['gldealership'], $access['gldmpedit'], $access['gldv'], $access['gldvspawn'], $access['gleditgroup'], $access['glfaction'], $access['glfamily'], $access['glflagmove'], $access['glflags'], $access['glfmembercount'], $access['glgedit'], $access['glgifts'], $access['glgov'], $access['glgroup'], $access['glhack'], $access['glhedit'], $access['glhouse'], $access['glhsafe'], $access['glkick'], $access['gllicenses'], $access['gllogincredits'], $access['glmail'], $access['glmoderator'], $access['glmute'], $access['glpads'], $access['glpassword'], $access['glpay'], $access['glplant'], $access['glplayervehicle'], $access['glpnsedit'], $access['glpoker'], $access['glrpspecial'], $access['glsecurity'], $access['glsellcredits'], $access['glsetvip'], $access['glshopconfirmedorders'], $access['glshoplog'], $access['glshoporders'], $access['glsobeit'], $access['glspeedcam'], $access['glstats'], $access['gltledit'], $access['gltoys'], $access['gltoydelete'], $access['glundercover'], $access['glvipnamechanges'], $access['glvipremove']);
$logname = array('admin', 'adminauction', 'admingive', 'adminpay', 'auction', 'ban', 'bedit', 'business', 'cleo', 'contracts', 'credits', 'crime', 'ddedit', 'dealership', 'dmpedit', 'dv', 'dvspawn', 'editgroup', 'faction', 'family', 'flagmove', 'flags', 'fmembercount', 'gedit', 'gifts', 'gov', 'group', 'hack', 'hedit', 'house', 'hsafe', 'kick', 'licenses', 'logincredits', 'mail', 'moderator', 'mute', 'pads', 'password', 'pay', 'plant', 'playervehicle', 'pnsedit', 'poker', 'rpspecial', 'security', 'sellcredits', 'setvip', 'shopconfirmedorders', 'shoplog', 'shoporders', 'sobeit', 'speedcam', 'stats', 'tledit', 'toys', 'toydelete', 'undercover', 'vipnamechanges', 'vipremove');
$i=0;
$total=59;

while ($i < $total) {
if ($names1[$i]==1 || $inf['AdminLevel'] >= 1337){
	$log_download = "<form method='post' action='log/download.php'>
	<input type='hidden' name='logpath' readonly='readonly' value='/home/samp/main/scriptfiles/logs/$logname[$i].log'>
	<input type='submit' class='submit' value='[Download]'></form>
	</form>";
echo '<tr><th colspan="2">'.$names[$i].'</th></tr>';
echo '<td><a href=log.php?p=game&log='.$logname[$i]."&name=".urlencode($names[$i]);
echo '><b>'.$names[$i].'</b></a></td><td>'.$log_download.'</td></tr>';

/*$secservdir = "//sa-mp/logs2/";
if (is_dir($secservdir)) {
    if ($dh = opendir($secservdir)) {
        while (($file = readdir($dh)) !== false)
		{
			if($file == $logname[$i].".log")
			{
				$log_download = "<form method='post' action='log/download.php'>
				<input type='hidden' name='logpath' readonly='readonly' value='$secservdir/$file'>
				<input type='submit' class='submit' value='[Download]'></form>
				</form>";
				$log_archive = "<form method='post' action='log.php?p=game'>
				<input type='hidden' name='action' readonly='readonly' value='log'>
				<input type='hidden' name='dir' readonly='readonly' value='$secservdir'>
				<input type='hidden' name='file' readonly='readonly' value='$file'>
				<input type='hidden' name='log' readonly='readonly' value='$logname[$i]'>
				<input type='submit' class='submit' value='$file (2nd Server)'></form>
				</form>";
				
				echo "<tr><td>".$log_archive."</td><td>".$log_download."</td></tr>";
			}
        }
        closedir($dh);
    }
}*/

$cpdir = "/home/samp/main/scriptfiles/cplogs/";
if (is_dir($cpdir)) {
    if ($dh = opendir($cpdir)) {
        while (($file = readdir($dh)) !== false)
		{
			if($file == $logname[$i].".log")
			{
				$log_download = "<form method='post' action='log/download.php'>
				<input type='hidden' name='logpath' readonly='readonly' value='$cpdir/$file'>
				<input type='submit' class='submit' value='[Download]'></form>
				</form>";
				$log_archive = "<form method='post' action='log.php?p=game'>
				<input type='hidden' name='action' readonly='readonly' value='log'>
				<input type='hidden' name='dir' readonly='readonly' value='$cpdir'>
				<input type='hidden' name='file' readonly='readonly' value='$file'>
				<input type='hidden' name='log' readonly='readonly' value='$logname[$i]'>
				<input type='submit' class='submit' value='$file (CP)'></form>
				</form>";
			
				echo "<tr><td>".$log_archive."</td><td>".$log_download."</td></tr>";
			}
        }
        closedir($dh);
    }
}

$dir = "/home/samp/log_archive/";
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
        while (($file = readdir($dh)) !== false)
		{
			if($file != "." && $file != ".." && strstr($file.".log-", $logname[$i].".log-") !== false)
			{
				$log_download = "<form method='post' action='log/download.php'>
				<input type='hidden' name='logpath' readonly='readonly' value='$dir$file'>
				<input type='submit' class='submit' value='[Download]'></form>
				</form>";
				$log_archive = "<form method='post' action='log.php?p=game'>
				<input type='hidden' name='action' readonly='readonly' value='log'>
				<input type='hidden' name='dir' readonly='readonly' value='$dir'>
				<input type='hidden' name='file' readonly='readonly' value='$file'>
				<input type='hidden' name='log' readonly='readonly' value='$logname[$i]'>
				<input type='submit' class='submit' value='$file'></form>
				</form>";
			
				echo "<tr><td>".$log_archive."</td><td>".$log_download."</td></tr>";
			}
        }
        closedir($dh);
    }
}
}
++$i;
}
echo '</table>';
?>

	</div>
	</div>