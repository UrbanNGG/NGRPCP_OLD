<?php

function SideNav() {
	print "<ul>";
	if($_SERVER["REQUEST_URI"] == "/staff/refund.php?p=add") {
	print "<li class='active'><a href=\"refund.php?p=add\">Add Refund</a></li>";
	}
	else {
	print "<li><a href=\"refund.php?p=add\">Add Refund</a></li>";
	}
	if($_SERVER["REQUEST_URI"] == "/staff/refund.php?p=view" || $_SERVER["REQUEST_URI"] == "/staff/refund.php?p=edit" || isset($_GET['o']) || isset($_GET['id'])) {
	print "<li class='active'><a href=\"refund.php?p=view\">View Refunds</a></li>";
	}
	else {
	print "<li><a href=\"refund.php?p=view\">View Refunds</a></li>";
	}
	if($_SERVER["REQUEST_URI"] == "/staff/refund.php?p=search" || isset($_GET['by'])) {
	print "<li class='active'>Search Refunds
	<ul><li><a href='refund.php?p=search&by=player'>By Player</a></li>
	<li><a href='refund.php?p=search&by=ip'>By IP</a></li></ul>
	</li>";
	}
	else {
	print "<li>Search Refunds
	<ul><li><a href='refund.php?p=search&by=player'>By Player</a></li>
	<li><a href='refund.php?p=search&by=ip'>By IP</a></li></ul>
	</li>";
	}
	print "</ul>";
}

?>