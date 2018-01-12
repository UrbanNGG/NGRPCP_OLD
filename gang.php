<?php
require('global/func.php');
require('gang/l_nav.php');
$redir = '<meta http-equiv="refresh" content="0;url=../login.php">';

if (!isset($_GET['p'])){ print "<meta http-equiv='refresh' content='0;url=gameaffairs.php?p=view'>"; }

if(!isset($_SESSION['myusername'])){
$logged = 0;
echo $redir;
exit();
}

if($inf['FMember'] != 255) {
$gangquery = mysql_query("SELECT * FROM `families` WHERE `ID` = $inf[FMember]");
$gang = mysql_fetch_array($gangquery);
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
	if($inf["FMember"] != "255")
	{
		if($_GET['p'] == "roster") include('gang/roster.php');
		if($inf['Rank'] >= 6)
		{
			if($_GET['p'] == "loglist") include('gang/loglist.php');
			if($_GET['p'] == "log") include('gang/log.php');
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