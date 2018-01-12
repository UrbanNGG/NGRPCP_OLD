<?php
require('../global/func.php');
$redir = '<meta http-equiv="refresh" content="1;url=index.php">';
if(!isset($_SESSION['myusername'])){
$logged = 0;

echo $redir;
exit();
}
$date = date('m/d/y');
$query7 = "UPDATE `ngg_cms`.`a_users` SET  `dCheckin` = '$date', `CheckinStatus` = 'Active' WHERE `a_users`.`ID` = $inf[ID]";
mysql_query($query7);
echo $redir;

?>
