<?php
require('../global/func.php');
require('gameaffairs/l_nav.php');
$redir = '<meta http-equiv="refresh" content="0;url=.././login.php">';

if (!isset($_GET['p'])){ print "<meta http-equiv=\"refresh\" content=\"0;url=gameaffairs.php?p=view\">"; }

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
		case "index": include('gameaffairs/index.php'); break;
		case "faction": include('gameaffairs/faction.php'); break;
		case "factionedit": include('gameaffairs/factionedit.php'); break;
		case "factionmod": include('gameaffairs/factionmod.php'); break;
		case "factionleader": include('gameaffairs/factionleader.php'); break;
		case "factioninfo": include('gameaffairs/factioninfo.php'); break;
		case "factionban": include('gameaffairs/factionban.php'); break;
		case "gang": include('gameaffairs/gang.php'); break;
		case "gangedit": include('gameaffairs/gangedit.php'); break;
		case "gangmod": include('gameaffairs/gangmod.php'); break;
		case "gangleader": include('gameaffairs/gangleader.php'); break;
		case "ganginfo": include('gameaffairs/ganginfo.php'); break;
		case "gangban": include('gameaffairs/gangban.php'); break;
		case "specops": include('gameaffairs/specops.php'); break;
		case "log": include('gameaffairs/log.php'); break;
		case "loglist": include('gameaffairs/loglist.php'); break;
	}
	
	/*if ($_GET['p']=="index"){
	include('gameaffairs/index.php');
	}
	if ($_GET['p']=="faction"){
	include('gameaffairs/faction.php');
	}
	if ($_GET['p']=="factionedit"){
	include('gameaffairs/factionedit.php');
	}
	if ($_GET['p']=="factionmod"){
	include('gameaffairs/factionmod.php');
	}
	if ($_GET['p']=="factionleader"){
	include('gameaffairs/factionleader.php');
	}
	if ($_GET['p']=="factionmember"){
	include('gameaffairs/factioninfo.php');
	}
	if ($_GET['p']=="factionban"){
	include('gameaffairs/factionban.php');
	}
	if ($_GET['p']=="gang"){
	include('gameaffairs/gang.php');
	}
	if ($_GET['p']=="gangedit"){
	include('gameaffairs/gangedit.php');
	}
	if ($_GET['p']=="gangmod"){
	include('gameaffairs/gangmod.php');
	}
	if ($_GET['p']=="gangleader"){
	include('gameaffairs/gangleader.php');
	}
	if ($_GET['p']=="gangmember"){
	include('gameaffairs/ganginfo.php');
	}
	if ($_GET['p']=="gangban"){
	include('gameaffairs/gangban.php');
	}
	if ($_GET['p']=="specops"){
	include('gameaffairs/specops.php');
	}
	if ($_GET['p']=="log"){
	include('gameaffairs/log.php');
	}
	if ($_GET['p']=="loglist"){
	include('gameaffairs/loglist.php');
	}*/
	
	//}
	//else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this section.</h2></div></div>"; }
	?>
		<div class='acp-box'>
			<div id='copyright'><?php require('../global/footer.php'); ?></div>
		</div>
		</div>
	</div>
</body>
</html>