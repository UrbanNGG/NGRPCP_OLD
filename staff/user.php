<?php
require('../global/func.php');
require('user/l_nav.php');
$redir = '<meta http-equiv="refresh" content="0;url=.././login.php">';

if (!isset($_GET['p'])){ print "<meta http-equiv=\"refresh\" content=\"0;url=user.php?p=index\">"; }

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
	<?php if($inf['AdminLevel'] >= 4 || $inf['Helper'] > 2 || $inf['HR'] >= 1)
	{
		if ($_GET['p'] == "index") include('user/index.php');
		if ($_GET['p'] == "admincreate") include('user/admincreate.php');
		if ($_GET['p'] == "name_exists") include('user/nameexists.php');
		if ($_GET['p'] == "edit") include('user/edit.php');
		if ($_GET['p'] == "view") include('user/view.php');
		if ($_GET['p'] == "usergroup") include('user/usergroup.php');
		if ($_GET['p'] == "email") include('user/email.php');
		if ($_GET['p'] == "addnote") include('user/addnote.php');
		if ($_GET['p'] == "onleave") include('user/onleave.php');
		if ($_GET['p'] == "pendingnote") include('user/pendingnote.php');
		if ($_GET['p'] == "pendingleave") include('user/pendingleave.php');
		if ($_GET['p'] == "archiveleave") include('user/archiveleave.php');
		if ($_GET['p'] == "allnote") include('user/allnote.php');
		if ($_GET['p'] == "archivenote") include('user/archivenote.php');
		if ($_GET['p'] == "pendingcheckin") include('user/pendingcheckin.php');
		if ($_GET['p'] == "shiftpending") include('user/shiftpending.php');
		if ($_GET['p'] == "shiftneeds") include('user/shiftneeds.php');
		if ($_GET['p'] == "assigncal") include('user/assigncal.php');
		if ($_GET['p'] == "assignview") include('user/assignview.php');
		if ($_GET['p'] == "assignedit") include('user/assignedit.php');
		if ($_GET['p'] == "alert") include('user/alert.php');
		if ($_GET['p'] == "manage") include('user/manage.php');
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