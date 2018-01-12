<?php if($inf['Security'] < 0 || $inf['AdminLevel'] < 1338 && isset($redir2)) {
	echo $redir2;
	exit();
}

$name = mysql_real_escape_string($_GET['name']);

if($_SERVER['REQUEST_METHOD'] == "POST") {
	$description = mysql_real_escape_string($_POST['file_description']);
	if ($_FILES["file"]["error"] > 0) {
		$message = "There was an error in uploading the file, please try again.";
	} else {
		if($description != "") {
			$filename = mysql_real_escape_string($_FILES['file']['name']);
			$filetype = mysql_real_escape_string($_FILES['file']['type']);
			$filesize = mysql_real_escape_string($_FILES['file']['size']);
			$fileloc = mysql_real_escape_string($_FILES['file']['tmp_name']);
			if(mysql_query("INSERT INTO `cp_security_files` SET `user_id` = '".GetID($name)."', `file_name` = '".$filename."', `file_type` = '".$filetype."', `file_size` = '".$filesize."', `file_location` = '".$fileloc."', `file_description` = '".$description."';")) {
				if (file_exists($_SERVER['DOCUMENT_ROOT']."/staff/security/uploads/" . $_FILES["file"]["name"])) {
					$message = $_FILES["file"]["name"] . " already exists. ";
				} else {
					if(move_uploaded_file($_FILES["file"]["tmp_name"], $_SERVER['DOCUMENT_ROOT']."/staff/security/uploads/" . $_FILES["file"]["name"])) {
						$message = "File uploaded successfully";
					}
				}
			} else {
				echo mysql_error();
			}
		} else {
			$message = "A file description is required.";
		}
	}
}
?>

<div id='content_wrap'>
					<ol id='breadcrumb'><li>Security Profiles > Upload File</li></ol>
					<div class='section_title'><h2>Upload File for <?php echo $name; ?>'s Profile</h2></div>
				<div class='acp-box'>
					<a href="./security.php?p=view_profile&name=<?php echo $name; ?>"><button class="button">Back to Profile</button></a>
					<h3>Upload File</h3>
					<?php if(isset($message)) { ?>
						<div class='acp-message'><?php echo $message; ?></div>
					<?php } ?>
						<form method="post" enctype="multipart/form-data">
						<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%' style='font-weight:bold'>
							<tr><td><label for="file">File:</label></td><td>
							<input type="file" name="file" id="file"></td></tr>
							<tr><td>File Description:</td><td><textarea cols="30" rows="5" name="file_description"></textarea></td></tr>
							<tr><td></td><td>
							<input type="submit" value="Submit" class="button">
							</td></tr>
							</form>
						</table>
		<div class='acp-actionbar'></div>
				</div></div>