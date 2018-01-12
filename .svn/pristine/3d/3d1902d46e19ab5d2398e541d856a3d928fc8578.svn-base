<?php
session_start();
$aUser = $_SESSION['myusername'];
require('SQL.php');
$avail = "";
$res = mysql_query("SELECT Username FROM accounts");

while ($row = mysql_fetch_array($res))
{
	if (strtolower($aUser) == strtolower($row['Username']))
	{
		$avail = "yes";
	}
}

if($avail == "yes") { 

$userquery = mysql_query("SELECT * FROM accounts WHERE LOWER(Username)='$aUser'");
if (!$userquery) {
    die('Invalid query: ' . mysql_error());
}
$inf = mysql_fetch_array($userquery, MYSQL_ASSOC);

$accessquery  = mysql_query("SELECT * FROM `cp_access` WHERE `user_id` = '$inf[id]'");
if (!$accessquery) {
    die('Invalid query: ' . mysql_error());
}
$access = mysql_fetch_array($accessquery, MYSQL_ASSOC);

$statquery  = mysql_query("SELECT * FROM `cp_stat` WHERE `user_id` = '$inf[id]'");
if (!$statquery) {
    die('Invalid query: ' . mysql_error());
}
$stat = mysql_fetch_array($statquery, MYSQL_ASSOC);

//No longer because it will not be needed
//$leadquery  = "SELECT * FROM group_leaders WHERE uid = '$inf[ID]'";
//$leadren = mysql_query($leadquery);
//$lead = mysql_fetch_array($leadren, MYSQL_ASSOC);

}
else { echo "You are not logged in."; }

?>