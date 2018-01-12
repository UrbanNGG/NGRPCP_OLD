<?php
function SideNav($inf)
{
	if($inf["FMember"] != "255")
	{
		print "<ul>";
		if($_GET['p'] == "roster") { print "<li class='active'>"; } else print "<li>";
			print "<a href='gang.php?p=roster'>Roster</a></li>";
		if($inf['Rank'] >= 6)
		{
			if($_GET['p'] == "loglist" || $_GET['p'] == "log") { print "<li class='active'>"; } else print "<li>";
			print "<a href='gang.php?p=loglist'>Logs</a></li>";
		}
		print "</ul>";
	}
}
?>