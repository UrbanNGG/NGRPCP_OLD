<?php
/*$host="localhost";
$username="cp";
$password="chuJUstabR2XA3";
$host="10.4.29.102";
$username="ngrp";
$password="@phh63oo3";
$db_name="NGRP";*/

/* Windows Box
DEFINE('HOST', '10.4.4.198');
DEFINE('USRNM', 'ngrpm_manage');
DEFINE('PSWD', 'f3J5drub9crEb2');
DEFINE('DBNM', 'ngrp');
*/

// Linux Box
DEFINE('HOST', '127.0.0.1');
DEFINE('USRNM', 'root');
DEFINE('PSWD', '');
DEFINE('DBNM', 'samp_test');

/*
DEFINE('HOST', '10.4.29.102');
DEFINE('USRNM', 'ngrp');
DEFINE('PSWD', '@phh63oo3');
DEFINE('DBNM', 'NGRP');
*/

mysql_connect(HOST, USRNM, PSWD) or die('Could not connect: ' . mysql_error());
mysql_select_db(DBNM) or die('Could not connect: ' . mysql_error());
?>