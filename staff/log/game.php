<?php 
if(isset($_GET['name'])) $logname = urldecode($_GET['name']);
?>

			<div id='content_wrap'>
				<ol id='breadcrumb'><li>Logs > Game Log</li></ol>
				<div class='section_title'><h2><?php if(isset($_POST['action']) && $_POST['action'] == "log_archive") { echo $_POST['file']; } elseif(isset($_GET['log']) && $_GET['log'] == "ShiftBonus") { echo "Shift Bonus Log"; } else { echo $logname; } ?></h2></div>

<div style="width:100%;height:500px;overflow-y:scroll;background-color:#FFF;border:#333 solid thin;margin-left:auto;margin-right:auto;padding:10px">
<?php
if(isset($_GET['log']) && $_GET['log'] != "ShiftBonus")
{
mysql_query("INSERT INTO `cp_log_access` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, NOW(), $inf[id], 'Logs', 'Viewing $_GET[log] log', '$_SERVER[REMOTE_ADDR]')");
$permarray = array('admin' => $access['gladmin'], 'adminauction' => $access['gladminauction'], 'admingive' => $access['gladmingive'], 'adminpay' => $access['gladminpay'], 'auction' => $access['glauction'], 'ban' => $access['glban'], 'bedit' => $access['glbedit'], 'business' => $access['glbusiness'], 'cleo' => $access['glcleo'], 'contracts' => $access['glcontracts'], 'credits' => $access['glcredits'], 'crime' => $access['glcrime'], 'ddedit' => $access['glddedit'], 'dealership' => $access['gldealership'], 'dmpedit' => $access['gldmpedit'], 'dv' => $access['gldv'], 'dvspawn' => $access['gldvspawn'], 'editgroup' => $access['gleditgroup'], 'faction' => $access['glfaction'], 'family' => $access['glfamily'], 'flagmove' => $access['glflagmove'], 'flags' => $access['glflags'], 'fmembercount' => $access['glfmembercount'], 'gedit' => $access['glgedit'], 'gifts' => $access['glgifts'], 'gov' => $access['glgov'], 'group' => $access['glgroup'], 'hack' => $access['glhack'], 'hedit' => $access['glhedit'], 'house' => $access['glhouse'], 'hsafe' => $access['glhsafe'], 'kick' => $access['glkick'], 'licenses' => $access['gllicenses'], 'logincredits' => $access['gllogincredits'], 'mail' => $access['glmail'], 'moderator' => $access['glmoderator'], 'mute' => $access['glmute'], 'pads' => $access['glpads'], 'password' => $access['glpassword'], 'pay' => $access['glpay'], 'plant' => $access['glplant'], 'playervehicle' => $access['glplayervehicle'], 'pnsedit' => $access['glpnsedit'], 'poker' => $access['glpoker'], 'rpspecial' => $access['glrpspecial'], 'security' => $access['glsecurity'], 'sellcredits' => $access['glsellcredits'], 'setvip' => $access['glsetvip'], 'shopconfirmedorders' => $access['glshopconfirmedorders'], 'shoplog' => $access['glshoplog'], 'shoporders' => $access['glshoporders'], 'sobeit' => $access['glsobeit'], 'speedcam' => $access['glspeedcam'], 'stats' => $access['glstats'], 'tledit' => $access['gltledit'], 'toydelete' => $access['gltoydelete'], 'undercover' => $access['glundercover'], 'vipnamechanges' => $access['glvipnamechanges'], 'vipremove' => $access['glvipremove']);
if ($permarray[$_GET['log']] == 1 || $inf['AdminLevel'] >= 1337)
{
	$fl = fopen("/home/samp/main/scriptfiles/logs/".$_GET['log'].".log", "r");
	if(@$fl)
	{
		for($x_pos = 0, $ln = 0, $output = ""; fseek($fl, $x_pos, SEEK_END) !== -1; $x_pos--) {
			$char = fgetc($fl);
			if ($char === "\n") {
				
				if ($ln != 0)
				{
					$string = preg_replace('([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})', strrev($_SERVER['REMOTE_ADDR']), $output);
					if($inf['AdminLevel'] < 1337 && $inf['Security'] < 1 && $uaccess['tech'] < 1 && $_GET['log'] != "ban") echo strrev($string) . "<br>";
					else echo strrev($output) . "<br>";
				}
				$ln++;
				$output = "";
				continue;
				}
			$output .= $char;
			}
		fclose($fl);
	}
	else echo '<h2 align = "center">There was an error opening the log!</h2>';
} else 
	{
	echo '<h2 align = "center"> You do not have permission to view this log. </h2>';
	}
}

if(isset($_POST['action']) && $_POST['action'] == "log"){
mysql_query("INSERT INTO `cp_log_access` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, NOW(), $inf[id], 'Logs', 'Viewing $_POST[log] log', '$_SERVER[REMOTE_ADDR]')");
$permarray = array('admin' => $access['gladmin'], 'adminauction' => $access['gladminauction'], 'admingive' => $access['gladmingive'], 'adminpay' => $access['gladminpay'], 'auction' => $access['glauction'], 'ban' => $access['glban'], 'bedit' => $access['glbedit'], 'business' => $access['glbusiness'], 'cleo' => $access['glcleo'], 'contracts' => $access['glcontracts'], 'credits' => $access['glcredits'], 'crime' => $access['glcrime'], 'ddedit' => $access['glddedit'], 'dealership' => $access['gldealership'], 'dmpedit' => $access['gldmpedit'], 'dv' => $access['gldv'], 'dvspawn' => $access['gldvspawn'], 'editgroup' => $access['gleditgroup'], 'faction' => $access['glfaction'], 'family' => $access['glfamily'], 'flagmove' => $access['glflagmove'], 'flags' => $access['glflags'], 'fmembercount' => $access['glfmembercount'], 'gedit' => $access['glgedit'], 'gifts' => $access['glgifts'], 'gov' => $access['glgov'], 'group' => $access['glgroup'], 'hack' => $access['glhack'], 'hedit' => $access['glhedit'], 'house' => $access['glhouse'], 'hsafe' => $access['glhsafe'], 'kick' => $access['glkick'], 'licenses' => $access['gllicenses'], 'logincredits' => $access['gllogincredits'], 'mail' => $access['glmail'], 'moderator' => $access['glmoderator'], 'mute' => $access['glmute'], 'pads' => $access['glpads'], 'password' => $access['glpassword'], 'pay' => $access['glpay'], 'plant' => $access['glplant'], 'playervehicle' => $access['glplayervehicle'], 'pnsedit' => $access['glpnsedit'], 'poker' => $access['glpoker'], 'rpspecial' => $access['glrpspecial'], 'security' => $access['glsecurity'], 'sellcredits' => $access['glsellcredits'], 'setvip' => $access['glsetvip'], 'shopconfirmedorders' => $access['glshopconfirmedorders'], 'shoplog' => $access['glshoplog'], 'shoporders' => $access['glshoporders'], 'sobeit' => $access['glsobeit'], 'speedcam' => $access['glspeedcam'], 'stats' => $access['glstats'], 'tledit' => $access['gltledit'], 'toydelete' => $access['gltoydelete'], 'undercover' => $access['glundercover'], 'vipnamechanges' => $access['glvipnamechanges'], 'vipremove' => $access['glvipremove']);
if ($permarray[$_POST['log']] == 1 || $inf['AdminLevel'] >= 1337)
{
$fl = fopen($_POST['dir']."".$_POST['file'], "r");
for($x_pos = 0, $ln = 0, $output = ""; fseek($fl, $x_pos, SEEK_END) !== -1; $x_pos--) {
    $char = fgetc($fl);
    if ($char === "\n") {
        
		if ($ln != 0)
		{
			$string = preg_replace('([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})', strrev($_SERVER['REMOTE_ADDR']), $output);
			if($inf['AdminLevel'] < 1337 && $inf['Security'] < 1 && $uaccess['tech'] < 1 && $_GET['log'] != "ban") echo strrev($string) . "<br>";
			else echo strrev($output) . "<br>";
		}
		$ln++;
		$output = "";
        continue;
        }
    $output .= $char;
    }
fclose($fl);
} else 
	{
	echo '<h2 align = "center"> You do not have permission to view this log. </h2>';
	}
}

if(isset($_GET['log']) && $_GET['log'] == "ShiftBonus")
{
	if($inf['AdminLevel'] >= 1337 || $inf['AP'] >= 2 || $inf['HR'] >= 2)
	{
		$fl = fopen("/home/samp/main/scriptfiles/logs/shiftbonus.log", "r");
		if(@$fl)
		{
			for($x_pos = 0, $ln = 0, $output = ""; fseek($fl, $x_pos, SEEK_END) !== -1; $x_pos--)
			{
				$char = fgetc($fl);
				if ($char === "\n")
				{
					if($ln > 0) echo strrev($output) . "<br>";
					$ln++;
					$output = "";
					continue;
				}
				$output .= $char;
			}
			fclose($fl);
		}
		else echo '<h2 align = "center">There was an error opening the log!</h2>';
	}
	else 
	{
		echo '<h2 align = "center"> You do not have permission to view this log. </h2>';
	}
}
?>
</div>
</div>