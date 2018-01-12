<?php
function SideNav($inf, $access) {
	print "<ul>";
	if($_GET['p'] == "index") { print "<li class='active'>"; } else print "<li>";
	print "<a href='log.php?p=index'>Log Index</a></li>";
	if($_GET['p'] == "game" && $_GET['log'] != "ShiftBonus") { print "<li class='active'>"; } else print "<li>";
	print "<a href='log.php?p=index'>Game Logs</a></li>";
	if($_GET['p'] == "view" || $_GET['p'] == "edit" || $_GET['p'] == "cp") { print "<li class='active'>CP Logs"; } else print "<li>CP Logs";
	print "<ul>";
	if($access['cplgeneral'] == 1) print "<li><a href='log.php?p=cp&log=general'>General</a></li>";
	if($access['cplaccess'] == 1) print "<li><a href='log.php?p=cp&log=access'>Access</a></li>";
	if($access['cplstaff'] == 1) print "<li><a href='log.php?p=cp&log=staff'>Staff</a></li>";
	if($access['cplfaction'] == 1) print "<li><a href='log.php?p=cp&log=faction'>Faction</a></li>";
	if($access['cplfamily'] == 1) print "<li><a href='log.php?p=cp&log=family'>Family</a></li>";
	if($access['cplcr'] == 1) print "<li><a href='log.php?p=cp&log=cr'>Customer Relations</a></li>";
	print "</ul></li>";
	if($inf['AdminLevel'] >= 1337 || $inf['AP'] >= 2 || $inf['HR'] >= 2) print "<li".(($_GET['log'] == "ShiftBonus") ? " class='active'" : "")."><a href='log.php?p=game&log=ShiftBonus'>Shift Bonus Log</a></li>";
}
?>