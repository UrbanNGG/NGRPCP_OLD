<?php
function SideNav($inf) {
	print "<ul>";
		if($inf['AdminLevel'] >= 1337 || $inf['PR'] > 0) {
			if(isset($_GET['g']) && $_GET['g'] == "advisor" || $_SERVER["REQUEST_URI"] == "/staff/pr.php?p=edit") {
				print "<li class='active'><a href='pr.php?p=view&g=advisor'>Community Advisors</a></li>";
			}
			else {
				print "<li><a href='pr.php?p=view&g=advisor'>Community Advisors</a></li>";
			}
			if(isset($_GET['g']) && $_GET['g'] == "helper") {
				print "<li class='active'><a href='pr.php?p=view&g=helper'>Helpers</a></li>";
			}
			else {
				print "<li><a href='pr.php?p=view&g=helper'>Helpers</a></li>";
			}
		}
		if($inf['AdminLevel'] >= 1338 || $inf['PR'] == 2) {
			if(isset($_GET['p']) && $_GET['p'] == "roster") {
				print "<li class='active'><a href='pr.php?p=roster'>PR Staff</a></li>";
			}
			else {
				print "<li><a href='pr.php?p=roster'>PR Staff</a></li>";
			}
		}
	print "</ul>";
}

?>