<?php
session_start();
require('SQL.php');


$pRes = mysql_query("SELECT id FROM a_punishments");
while ($pRow = mysql_fetch_array($pRes))
{
	if ($pID == $pRow['id'])
	{
		$pAvail = "yes";
	}
}

if($pAvail == "yes") { 

$pInfo  = "SELECT * FROM a_punishments WHERE id='$pID'";
$pRen = mysql_query($pInfo);
$pInf = mysql_fetch_array($pRen, MYSQL_ASSOC);

}

else { echo "No Such Punishment"; }

?>