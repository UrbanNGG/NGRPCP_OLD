<?php
require('global/func.php');
require('store/l_nav.php');
$redir = '<meta http-equiv="refresh" content="0;url=../login.php">';

if (!isset($_GET['p'])){ print "<meta http-equiv=\"refresh\" content=\"0;url=store.php?p=main\">"; }

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

<?php
if ($_GET['p']=="checkout") {
	include('store/checkout.php');
	exit();
}
?>

<?php headbar($inf); Nav($inf,$access); ?>

	<div id='page_body'>

		<div id='section_navigation'>
			<?php SideNav($inf); ?>
		</div>

		<div id='main_content'>
	<?php
	if (GetStoreStatus($inf) == 'ON') {
	if ($_GET['p']=="main") {
	include('store/main.php');
	}
	if ($_GET['p']=="cart") {
	include('store/cart.php');
	}
	if ($_GET['p']=="addcart") {
	include('store/addcart.php');
	}
	if ($_GET['p']=="info") {
	include('store/info.php');
	}
	if ($_GET['p']=="history") {
	include('store/history.php');
	}
	if ($_GET['p']=="support") {
	include('store/support.php');
	}
	} else {
		$redir = '<meta http-equiv="refresh" content="0;url=http://'.$_SERVER['SERVER_NAME'].'/index.php?p=dashboard">';
		echo $redir;
	}
	?>
		<div class='acp-box'>
			<div id='copyright'><?php require('global/footer.php'); ?></div>
		</div>
		</div>
	</div>
</body>
</html>