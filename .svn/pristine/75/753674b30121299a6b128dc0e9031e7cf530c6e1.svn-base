<?php
session_start();
require('SQL.php');

$reRes = mysql_query("SELECT id FROM a_reqs");
while ($reRow = mysql_fetch_array($reRes))
{
	if ($reID == $reRow['id'])
	{
		$reAvail = "yes";
	}
}

if($reAvail == "yes") { 

$reInfo  = "SELECT * FROM a_reqs WHERE id='$reID'";
$reRen = mysql_query($reInfo);
$reInf = mysql_fetch_array($reRen, MYSQL_ASSOC);

}

else { echo "No Such Request"; }

?>