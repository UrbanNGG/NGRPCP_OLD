<?php
require('global/func.php');
require('faction/l_nav.php');
$redir = '<meta http-equiv="refresh" content="0;url=../login.php">';

if (!isset($_GET['p'])){ print "<meta http-equiv=\"refresh\" content=\"0;url=faction.php?p=roster\">"; }

if(!isset($_SESSION['myusername'])){
$logged = 0;
echo $redir;
exit();
}

if($inf['Member'] != -1) {
$groupquery = mysql_query("SELECT * FROM `groups` WHERE `id` = $inf[Member]+1");
$group = mysql_fetch_array($groupquery);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php head($inf); ?>
</head>

<?php headbar($inf); Nav($inf,$access); ?>

	<div id='page_body'>

		<div id='section_navigation'>
			<?php SideNav($inf, $group); ?>
		</div>

		<div id='main_content'>
	<?php if($inf["Member"] != -1) {
	if ($_GET['p']=="roster"){
	include('faction/roster.php');
	}
	if ($_GET['p']=="mostwanted"){
	include('faction/mostwanted.php');
	}
	if ($_GET['p']=="mdc"){
	include('faction/mdc.php');
	}
	if ($_GET['p']=="log"){
	include('faction/log.php');
	}
	if ($_GET['p']=="loglist"){
	include('faction/loglist.php');
	}
	}
	else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this section.</h2></div></div>"; }
	?>
		<div class='acp-box'>
			<div id='copyright'><?php require('global/footer.php'); ?></div>
		</div>
		</div>
	</div>
</body>
</html>

<?php }
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this section.</h2></div></div>"; } ?>