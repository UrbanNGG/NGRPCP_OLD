<?php
ini_set('max_execution_time', 1200);
require('../../global/func.php');
$file = $_POST['logpath'];

if(!strstr($file, "/home/samp/main/scriptfiles/logs") && !strstr($file, "/home/samp/log_archive/")) {
	print("Stop trying to exploit and use this script properly.");
	die();
}

if(ob_get_level()) ob_end_clean();
if(file_exists($file))
{
	mysql_query("INSERT INTO `cp_log_access` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, NOW(), $inf[id], 'Logs', 'Downloaded $file', '$_SERVER[REMOTE_ADDR]')");
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    $handle = @fopen($file, "r");
    if ($handle) {
        if($inf['AdminLevel'] >= 1337 || $inf['ShopTech'] >= 3 || $inf['Security'] >= 1 || $uaccess['tech'] == 1) {
			ob_clean();
			flush();
			readfile($file);
			exit;
		}
		else {
			while (($buffer = fgets($handle, 4096)) !== false) {
				echo preg_replace('([0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})', $_SERVER['REMOTE_ADDR'], $buffer);
				flush();
			}
		}
    }
    if (!feof($handle)) {
        echo "Error: An error occurred while reading the file.\n";
    }
    fclose($handle);
    exit;
}
else { echo 'File does not exist';

}
?>
