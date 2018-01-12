<?php
function SideNav($inf, $group) {
	if($inf["Member"] != -1)
	{
		print "<ul>";
		if(($group['Type'] == 2 && $inf['Leader'] == $inf['Member']) || $group['Type'] != 2)
		{
			if($_GET['p'] == "roster") { print "<li class='active'>"; } else print "<li>";
			print "<a href='faction.php?p=roster'>Roster</a></li>";
		}
		if($inf["Leader"] != -1 && $inf["Leader"] == $inf["Member"])
		{
			if($_GET['p'] == "loglist" || $_GET['p'] == "log") { print "<li class='active'>"; } else print "<li>";
			print "<a href='faction.php?p=loglist'>Treasury Logs</a></li>";
		}
		if($_GET['p'] == "mostwanted") { print "<li class='active'>"; } else print "<li>";
		print "<a href='faction.php?p=mostwanted'>Most Wanted</a></li>";
		if($_GET['p'] == "mdc") { print "<li class='active'>"; } else print "<li>";
		print "<a href='faction.php?p=mdc'>MDC</a></li>";
		print "</ul>";
	}
}
?>