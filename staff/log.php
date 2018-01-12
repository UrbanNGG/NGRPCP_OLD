<?php
require('../global/func.php');
require('log/l_nav.php');
$redir = '<meta http-equiv="refresh" content="0;url=.././login.php">';

if (!isset($_GET['p'])){ print "<meta http-equiv=\"refresh\" content=\"0;url=log.php?p=index\">"; }
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
			<?php SideNav($inf, $access); ?>
		</div>

		<div id='main_content'> 
			<?php
			if($_GET['p']=="index") include('log/index.php');
			if($_GET['p']=="cp") include('log/cp.php');
			if($_GET['p']=="game") include('log/game.php');
			if($_GET['p']=="download") include('log/download.php');
			?>
		<div class='acp-box'>
			<div id='copyright'><?php require('../global/footer.php'); ?></div>
		</div>
		</div>
	</div>
</body>
</html>