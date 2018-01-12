<?php
require('SQL.php');

function TextLog($filename, $content)
{
	$content = "[".date('Y-m-d H:i:s')."] ".$content."\r\n";
	$file = "/home/samp/main/scriptfiles/cplogs/" . $filename;

	if (is_writable($file))
	{
		if (!$handle = fopen($file, 'a')) {
			 echo "Cannot open file ($filename)";
			 exit;
		}
		if (fwrite($handle, $content) === FALSE)
		{
			echo "Cannot write to file ($filename)";
			exit;
		}
		fclose($handle);
	}
	else echo "The file $filename is not writable";
}

//Shift Admin Completion Bonus
$userquery = mysql_query("SELECT `id`, `Username` FROM `accounts` WHERE `AdminLevel` > 1 AND `AdminType` = 3 AND `Disabled` = 0");
while($userarray = mysql_fetch_array($userquery))
{
	$shiftquery = mysql_query("SELECT NULL FROM `cp_shifts` WHERE `user_id` = '$userarray[id]' AND `status` = 3 AND YEARWEEK(`date`) = YEARWEEK(NOW())-1 AND `type` = '1'");
	$count = mysql_num_rows($shiftquery);
	if($count >= 9)
	{
		mysql_query("UPDATE `cp_stat` SET `points` =+ 6 WHERE `user_id` = $userarray[id]");
		$log = $userarray['Username']." (SGA) has been awarded 6 additional points for completing 9 shifts this week.";
		TextLog("ShiftBonus.log", $log);
	}
	else
	{
		$log = $userarray['Username']." (SGA) failed to complete 9 shifts this week.";
		TextLog("ShiftBonus.log", $log);
	}
}
?>