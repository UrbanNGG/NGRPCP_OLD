<?php
require('../global/func.php');
require('cr/l_nav.php');
$redir = '<meta http-equiv="refresh" content="0;url=.././login.php">';

if (!isset($_GET['p'])){ print "<meta http-equiv=\"refresh\" content=\"0;url=cr.php?p=index\">"; }

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
	if($inf['AdminLevel'] >= 1337 || $inf['ShopTech'] >= 1) {
		if ($_GET['p']=="index"){
		include('cr/index.php');
		}
		if ($_GET['p']=="shift"){
		include('cr/shift.php');
		}
		if ($_GET['p']=="assigncal"){
		include('cr/assigncal.php');
		}
		if ($_GET['p']=="assignedit"){
		include('cr/assignedit.php');
		}
		if ($_GET['p']=="assignview"){
		include('cr/assignview.php');
		}
		if ($_GET['p']=="tracker"){
		include('cr/tracker.php');
		}
		if ($_GET['p']=="report_create"){
		include('cr/report_create.php');
		}
		if ($_GET['p']=="report_pending"){
		include('cr/report_pending.php');
		}
		if ($_GET['p']=="report_archive"){
		include('cr/report_archive.php');
		}
		if ($_GET['p']=="roster"){
		include('cr/roster.php');
		}
		if ($_GET['p']=="manage"){
		include('cr/manage.php');
		}
		if ($_GET['p']=="support"){
		include('cr/support.php');
		}
		if ($_GET['p']=="orders"){
		include('cr/orders.php');
		}
		if ($_GET['p']=="csearch"){
		include('cr/csearch.php');
		}
		if ($_GET['p']=="ctracker"){
		include('cr/ctracker.php');
		}
		if ($_GET['p']=="pinchange"){
		include('cr/pinchange.php');
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