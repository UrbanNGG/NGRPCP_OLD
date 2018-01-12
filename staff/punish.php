<?php
require('../global/func.php');
require('punish/l_nav.php');
$redir = '<meta http-equiv="refresh" content="0;url=.././login.php">';

if (!isset($_GET['p'])){ print "<meta http-equiv=\"refresh\" content=\"0;url=punish.php?p=view\">"; }

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
		<?php if($inf['AdminLevel'] > 1 || $access['punish'] == 1) {
			SideNav();
		} ?>
		</div>

		<div id='main_content'>
	<?php if($inf['AdminLevel'] > 1 || $access['punish'] == 1) {
	if ($_GET['p']=="add"){
	include('punish/add.php');
	}
	if ($_GET['p']=="view"){
	include('punish/view.php');
	}
	if ($_GET['p']=="viewold"){
	include('punish/viewold.php');
	}
	if ($_GET['p']=="edit"){
	include('punish/edit.php');
	}
	if ($_GET['p']=="search"){
	include('punish/search.php');
	}
	}
	else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this section.</h2></div></div>"; }
	?>
		<div class='acp-box'>
			<div id='copyright'><?php require('../global/footer.php'); ?></div>
		</div>
		</div>
	</div>
</body>
</html>