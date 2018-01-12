<?php
function SideNav($inf) {
	print "<ul>";
	if($inf['AdminLevel'] >= 4 || $inf['FactionModerator'] > 0) {
		if($_GET['p'] == "factionmod" || $_GET['p'] == "factionleader" || $_GET['p'] == "factioninfo" || $_GET['p'] == "factionban" || $_GET['p'] == "loglist" || $_GET['p'] == "log") print "<li class='active'>Factions";
		else print "<li>Factions";
			print "<ul>";
			print "<li><a href='gameaffairs.php?p=factioninfo'>Faction Information</a></li>";
			print "<li><a href='gameaffairs.php?p=factionleader'>Faction Leaders</a></li>";
			print "<li><a href='gameaffairs.php?p=factionban'>Faction Ban List</a></li>";
			print "<li><a href='gameaffairs.php?p=loglist'>Treasury Logs</a></li>";
			if($inf['AdminLevel'] >= 1337 || $inf['FactionModerator'] == 2) print "<li><a href='gameaffairs.php?p=factionmod'>Faction Moderators</a></li>";
			print "</ul></li>";
	}
	if($inf['AdminLevel'] >= 4 || $inf['GangModerator'] > 0) {
		if($_GET['p'] == "gangmod" || $_GET['p'] == "gangleader" || $_GET['p'] == "ganginfo" || $_GET['p'] == "gangban") print "<li class='active'>Gangs";
		else print "<li>Gangs";
			print "<ul>";
			print "<li><a href='gameaffairs.php?p=ganginfo'>Gang Information</a></li>";
			print "<li><a href='gameaffairs.php?p=gangleader'>Gang Leaders</a></li>";
			print "<li><a href='gameaffairs.php?p=gangban'>Gang Ban List</a></li>";
			if($inf['AdminLevel'] >= 1337 || $inf['GangModerator'] == 2) print "<li><a href='gameaffairs.php?p=gangmod'>Gang Moderators</a></li>";
			print "</ul></li>";
	}
	if($inf['AdminLevel'] >= 1337 || $inf['Undercover'] == 2) {
		if($_GET['p'] == "specops") { print "<li class='active'>"; } else print "<li>";
		print "<a href='gameaffairs.php?p=specops'>Special Operations</a></li>";
		print "</ul></li>";
	}
	print "</ul>";
}

?>