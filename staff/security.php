<?php
require('../global/func.php');
require('security/l_nav.php');
$redir = '<meta http-equiv="refresh" content="0;url=.././login.php">';

if (!isset($_GET['p'])){ print "<meta http-equiv=\"refresh\" content=\"0;url=security.php?p=view\">"; }

if(!isset($_SESSION['myusername'])){
$logged = 0;
echo $redir;
exit();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php head($inf); ?>
</head>

<?php headbar($inf); Nav($inf,$access); ?>

	<div id='page_body'>

		<div id='section_navigation'>
			<?php SideNav($inf); ?>
		</div>

		<div id='main_content'>
	<?php
	//if($inf['AdminLevel'] > 3 || $inf['FactionModerator'] > 0 || $inf['GangModerator'] > 0) {
	
	switch($_GET['p'])
	{
		case "index": include('security/index.php'); break;
		case "profiles": include('security/profiles.php'); break;
		case "view_profile": include('security/view_profile.php'); break;
		case "edit_profile": include('security/edit_profile.php'); break;
		case "add_note": include('security/add_note.php'); break;
		case "upload_file": include('security/upload_file.php'); break;
		case "download": include('security/download.php'); break;
	}
	?>
		<div class='acp-box'>
			<div id='copyright'><?php require('../global/footer.php'); ?></div>
		</div>
		</div>
	</div>
</body>
</html>