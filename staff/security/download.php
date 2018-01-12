<?php
ini_set('max_execution_time', 1200);
$file = $_POST['logpath'];
if(ob_get_level()) ob_end_clean();
if(file_exists($file))
{
	// mysql_query("INSERT INTO `cp_log_access` (`id`, `date`, `user_id`, `area`, `details`, `ip_address`) VALUES (NULL, NOW(), $inf[id], 'Logs', 'Downloaded $file', '$_SERVER[REMOTE_ADDR]')");
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
			ob_clean();
			flush();
			readfile($file);
			exit;
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
