<?php

function SideNav($level) {
	print "<ul>";

	/*if($_SERVER["REQUEST_URI"] == "/staff/request.php?p=add") {
	print "<li class='active'><a href=\"request.php?p=add\">Add Request</a></li>";
	}
	else {
	print "<li><a href=\"request.php?p=add\">Add Request</a></li>";
	}*/

	if($_SERVER["REQUEST_URI"] == "/staff/request.php?p=email") {
	print "<li class='active'><a href=\"request.php?p=email\">Staff Email Request</a></li>";
	}
	else {
	print "<li><a href=\"request.php?p=email\">Staff Email Request</a></li>";
	}
	
	if($level > 3) {
	if($_SERVER["REQUEST_URI"] == "/staff/request.php?p=view") {
	print "<li class='active'><a href=\"request.php?p=view\">View Requests</a></li>";
	}
	else {
	print "<li><a href=\"request.php?p=view\">View Requests</a></li>";
	}
	}
}

?>