<?php
session_start();
require('SQL.php');


$tbRes = mysql_query("SELECT id FROM a_unban");
while ($tbRow = mysql_fetch_array($tbRes))
{
	if ($tbID == $tbRow['id'])
	{
		$tbAvail = "yes";
	}
}

if($tbAvail == "yes") { 

$tbInfo  = "SELECT * FROM a_unban WHERE id='$tbID'";
$tbRen = mysql_query($tbInfo);
$tbInf = mysql_fetch_array($tbRen, MYSQL_ASSOC);

}

else { echo "No Such Temp Ban"; }

?>