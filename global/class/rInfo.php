<?php
session_start();
require('SQL.php');

$rRes = mysql_query("SELECT id FROM a_refunds");
while ($rRow = mysql_fetch_array($rRes))
{
	if ($rID == $rRow['id'])
	{
		$rAvail = "yes";
	}
}

if($rAvail == "yes") { 

$rInfo  = "SELECT * FROM a_refunds WHERE id='$rID'";
$rRen = mysql_query($rInfo);
$rInf = mysql_fetch_array($rRen, MYSQL_ASSOC);

}

else { echo "No Such Refund"; }

?>