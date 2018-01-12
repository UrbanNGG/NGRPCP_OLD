<?php

function SideNav() {
	print "<ul>";
	if($_SERVER["REQUEST_URI"] == "/staff/flag.php?p=view" || isset($_GET['list']) || isset($_GET['note'])) {
	print "<li class='active'><a href=\"flag.php?p=view\">View Flags</a>";
	print "<ul>";
	print "<li><a href=\"flag.php?p=view&list=1\">Punishments</a></li>";
	print "<li><a href=\"flag.php?p=view&list=2\">Refunds</a></li>";
	print "<li><a href=\"flag.php?p=view&list=3\">VIP</a></li>";
	print "<li><a href=\"flag.php?p=view&list=4\">House</a></li>";
	print "<li><a href=\"flag.php?p=view&list=5\">Gate</a></li>";
	print "<li><a href=\"flag.php?p=view&list=6\">Shop Credit</a></li>";
	print "<li><a href=\"flag.php?p=view&list=7\">Car</a></li>";
	print "</ul></li>";
	}
	else {
	print "<li><a href=\"flag.php?p=view\">View Flags</a>";
	print "<ul>";
	print "<li><a href=\"flag.php?p=view&list=1\">Punishments</a></li>";
	print "<li><a href=\"flag.php?p=view&list=2\">Refunds</a></li>";
	print "<li><a href=\"flag.php?p=view&list=3\">VIP</a></li>";
	print "<li><a href=\"flag.php?p=view&list=4\">House</a></li>";
	print "<li><a href=\"flag.php?p=view&list=5\">Gate</a></li>";
	print "<li><a href=\"flag.php?p=view&list=6\">Shop Credit</a></li>";
	print "<li><a href=\"flag.php?p=view&list=7\">Car</a></li>";
	print "</ul></li>";
	}
	if($_SERVER["REQUEST_URI"] == "/staff/flag.php?p=playersearch") {
	print "<li class='active'><a href=\"flag.php?p=playersearch\">Search by Player</a></li>";
	}
	else {
	print "<li><a href=\"flag.php?p=playersearch\">Search by Player</a></li>";
	}
	print "</ul>";
}

?>