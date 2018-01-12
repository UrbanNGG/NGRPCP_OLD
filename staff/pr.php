<?php
require('../global/func.php');
require('pr/l_nav.php');
$redir = '<meta http-equiv="refresh" content="0;url=.././login.php">';

if (!isset($_GET['p'])){ print "<meta http-equiv='refresh' content='0;url=pr.php?p=index'>"; }

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
	if($inf['AdminLevel'] >= 1337 || $inf['PR'] > 0) {
		if ($_GET['p']=="index"){
		include('pr/index.php');
		}
		if ($_GET['p']=="view"){
		include('pr/view.php');
		}
		if ($_GET['p']=="edit"){
		include('pr/edit.php');
		}
		if ($_GET['p']=="roster"){
		include('pr/roster.php');
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