<?php
require('../infos/SQL.php');
$query="SELECT * FROM a_users";
		$result=mysql_query($query);
		$num=mysql_numrows($result);			
		$i=0;
		while ($i < $num) {		
		$user=mysql_result($result,$i,"aUser");
		$low = strtolower($user);
		//echo $user; echo '</br>'; echo $pass; echo '</br>'; echo 'lower: '; echo $low; echo '</br>';
		mysql_query("UPDATE a_users SET aUser = '".$low."' WHERE aUser = '".$user."'");
		++$i;
		}

?>