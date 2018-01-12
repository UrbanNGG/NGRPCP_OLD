<?php
$pRes = mysql_query("SELECT `id` FROM `cp_punishment`");
while ($pRow = mysql_fetch_array($pRes))
{
	if ($pID == $pRow['id'])
	{
		$pAvail = "yes";
	}
}

if($pAvail == "yes") { 

$punishquery = mysql_query("SELECT * FROM `cp_punishment` WHERE `id` = '$pID'");
$pInf = mysql_fetch_array($punishquery, MYSQL_ASSOC);

}
else { echo "No such punishment"; }
?>