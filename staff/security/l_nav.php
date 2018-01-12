<?php
function SideNav($inf) {
	print "<ul>";
	if($inf['AdminLevel'] >= 4 || $inf['Security'] >= 1) {
		if($_GET['p'] == "index" || $_GET['p'] == "profiles" || $_GET['p'] == "view_profile" || $_GET['p'] == "edit_profile" || $_GET['p'] == "add_note" || $_GET['p'] == "upload_file") print "<li class='active'>Main";
		else print "<li>Main";
			print "<ul>";
			print "<li><a href='security.php?p=profiles'>Security Profiles</a></li>";
			print "</ul></li>";
	}
	print "</ul>";
}

?>