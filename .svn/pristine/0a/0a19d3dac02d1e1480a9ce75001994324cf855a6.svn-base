<?php
//Load DB Connections etc.
if(!empty($_REQUEST['player_name']))
{
    $username = mysql_real_escape_string($_REQUEST['player_name']);

    if(isset($_SESSION['username_tmp'][$username]))
    {
        echo json_encode(array('valid' => (bool)$_SESSION['username_tmp'][$username]));
        die();
    }
    //Check the database here... $num_rows being a validation var from mysql_result
    $_SESSION['username_tmp'][$username] = ($num_rows == 0) ? true : false;

    echo json_encode(array('valid' => (bool)$_SESSION['username_tmp'][$username]));
    die();
}
?>