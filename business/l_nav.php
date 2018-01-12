<?php
function SideNav($inf) {
	if($inf["Business"] != -1) {
	print "<ul>";
	if($_GET['p'] == "info") { print "<li class='active'>"; } else print "<li>";
		print "<a href='business.php?p=info'>Information</a></li>";
	if($_GET['p'] == "roster") { print "<li class='active'>"; } else print "<li>";
		print "<a href='business.php?p=roster'>Roster</a></li>";
	print "</ul>";
	}
}
?>