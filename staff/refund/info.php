<?php
$rRes = mysql_query("SELECT `id` FROM `cp_refund`");
while ($rRow = mysql_fetch_array($rRes))
{
	if ($id == $rRow['id'])
	{
		$rAvail = "yes";
	}
}

if($rAvail == "yes") {
$rRen = mysql_query("SELECT * FROM `cp_refund` WHERE `id` = '$id'");
$rInf = mysql_fetch_array($rRen, MYSQL_ASSOC);
}

else { echo "No such refund"; }
?>