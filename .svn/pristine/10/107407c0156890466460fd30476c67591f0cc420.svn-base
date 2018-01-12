<?php

function SideNav() {
	print "<ul>";
	if($_SERVER["REQUEST_URI"] == "/staff/punish.php?p=add") {
	print "<li class='active'><a href=\"punish.php?p=add\">Add Punishment</a></li>";
	}
	else {
	print "<li><a href=\"punish.php?p=add\">Add Punishment</a></li>";
	}
	if($_SERVER["REQUEST_URI"] == "/staff/punish.php?p=view" || $_SERVER["REQUEST_URI"] == "/staff/punish.php?p=edit" || isset($_GET['o']) || isset($_GET['id'])) {
	print "<li class='active'><a href=\"punish.php?p=view\">View Punishments</a></li>";
	}
	else {
	print "<li><a href=\"punish.php?p=view\">View Punishments</a></li>";
	}
	if($_SERVER["REQUEST_URI"] == "/staff/punish.php?p=search" || isset($_GET['by'])) {
	print "<li class='active'>Search Punishments
	<ul><li><a href='punish.php?p=search&by=player'>By Player</a></li>
	<li><a href='punish.php?p=search&by=ip'>By IP</a></li></ul>
	</li>";
	}
	else {
	print "<li>Search Punishments
	<ul><li><a href='punish.php?p=search&by=player'>By Player</a></li>
	<li><a href='punish.php?p=search&by=ip'>By IP</a></li></ul>
	</li>";
	}
	print "</ul>";
}

?>