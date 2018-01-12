<?php

function SideNav($inf,$uaccess) {
	print "<ul>";
	if($_SERVER["REQUEST_URI"] == "/staff/player.php?p=view") {
	print "<li class='active'><a href=\"player.php?p=view\">Player Stats</a></li>";
	}
	else {
	print "<li><a href=\"player.php?p=view\">Player Stats</a></li>";
	}
	if($inf['AdminLevel'] >= 1337 || $uaccess['tech'] == 1) {
		if($_GET['p'] == "changepass") { print "<li class='active'>"; } else print "<li>";
		print "<a href='player.php?p=changepass'>Change User Password</a></li>";
	}
	if($_SERVER["REQUEST_URI"] == "/staff/player.php?p=vehicle" || isset($_GET['vsearch'])) {
	print "<li class='active'>Vehicle Search";
	print "<ul>";
	print "<li><a href=\"player.php?p=vehicle&vsearch=id\">By ID</a></li>";
	print "<li><a href=\"player.php?p=vehicle&vsearch=player\">By Player</a></li>";
	print "</ul></li>";
	}
	else {
	print "<li>Vehicle Search";
	print "<ul>";
	print "<li><a href=\"player.php?p=vehicle&vsearch=id\">By ID</a></li>";
	print "<li><a href=\"player.php?p=vehicle&vsearch=player\">By Player</a></li>";
	print "</ul></li>";
	}
	if($_SERVER["REQUEST_URI"] == "/staff/player.php?p=house" || isset($_GET['hsearch'])) {
	print "<li class='active'>House Search";
	print "<ul>";
	print "<li><a href=\"player.php?p=house&hsearch=id\">By ID</a></li>";
	print "<li><a href=\"player.php?p=house&hsearch=player\">By Player</a></li>";
	print "</ul></li>";
	}
	else {
	print "<li>House Search";
	print "<ul>";
	print "<li><a href=\"player.php?p=house&hsearch=id\">By ID</a></li>";
	print "<li><a href=\"player.php?p=house&hsearch=player\">By Player</a></li>";
	print "</ul></li>";
	}
	if($inf['AdminLevel'] > 2) {
	if($_SERVER["REQUEST_URI"] == "/staff/player.php?p=ipcheck" || isset($_GET['search'])) {
	print "<li class='active'>IP Check";
	print "<ul>";
	print "<li><a href=\"player.php?p=ipcheck&search=ip\">By IP</a></li>";
	print "<li><a href=\"player.php?p=ipcheck&search=player\">By Player</a></li>";
	print "</ul></li>";
	}
	else {
	print "<li>IP Check";
	print "<ul>";
	print "<li><a href=\"player.php?p=ipcheck&search=ip\">By IP</a></li>";
	print "<li><a href=\"player.php?p=ipcheck&search=player\">By Player</a></li>";
	print "</ul></li>";
	}
	}
	print "</ul>";
}

?>