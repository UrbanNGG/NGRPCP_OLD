<?php
require('../global/func.php');
require('player/l_nav.php');
$redir = '<meta http-equiv="refresh" content="0;url=http://127.0.0.1/cp//login.php">';

if (!isset($_GET['p'])){ print "<meta http-equiv=\"refresh\" content=\"0;url=player.php?p=view\">"; }

if(!isset($_SESSION['myusername'])){
$logged = 0;
echo $redir;
exit();
}

$uaccessquery = mysql_query("SELECT * FROM `cp_access` WHERE `user_id` = '$inf[id]'");
$uaccess = mysql_fetch_array($uaccessquery, MYSQL_ASSOC);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php head($inf); ?>
</head>

<?php headbar($inf); Nav($inf,$access); ?>

	<div id='page_body'>

		<div id='section_navigation'>
			<?php SideNav($inf,$uaccess); ?>
		</div>

		<div id='main_content'> 
	<?php if ($_GET['p']=="view"){
	include('player/view.php');
	}
	if ($_GET['p']=="ipcheck"){
	include('player/ipcheck.php');
	}
	if ($_GET['p']=="house"){
	include('player/house.php');
	}
	if ($_GET['p']=="vehicle"){
	include('player/vehicle.php');
	}
	if ($_GET['p']=="changepass"){
	include('player/changepass.php');
	}
	?>
		<div class='acp-box'>
			<div id='copyright'><?php require('../global/footer.php'); ?></div>
		</div>
		</div>
	</div>
</body>
</html>