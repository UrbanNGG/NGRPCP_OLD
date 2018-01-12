<?php
if(!isset($_REQUEST['term'])) exit;

require('../class/SQL.php');

$query = mysql_query('SELECT `id`, `Username` FROM `accounts` WHERE `Disabled` = 0 AND `Username` LIKE "'. mysql_real_escape_string($_REQUEST['term']) .'%" ORDER BY `Username` ASC LIMIT 0,10');

$data = array();
if($query && mysql_num_rows($query))
{
    while($row = mysql_fetch_array($query, MYSQL_ASSOC))
    {
        $data[] = array(
            'label' => $row['Username'] ,
            'value' => $row['Username']
        );
    }
}

echo json_encode($data);
flush();

