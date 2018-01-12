<?php
$date = date('Y-m-d h:i:s');
if($date == $inf['dCheckin']) { echo $redir10; exit(); }
$checkins = $inf['checkins'] + 1;

$query6 = "INSERT INTO `nmphosti_cms`.`user_checkins` (`id`, `user`, `date`, `status`, `acceptBy`) VALUES (NULL, '$inf[aUser]', '$date', 'Pending', 'Pending')";

mysql_query("UPDATE users SET dCheckin = '".$date."' WHERE aUser = '".$_SESSION['myusername']."'");

mysql_query($query6);
echo $redir;

?>