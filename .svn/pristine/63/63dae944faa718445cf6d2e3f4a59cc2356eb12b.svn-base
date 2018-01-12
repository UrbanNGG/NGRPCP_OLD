<?php $section = 'Main';
function SideNav($inf) {
	print "<ul>";
	if($_GET['p'] == "dashboard") {
	print "<li class='active'><a href='index.php?p=dashboard'>Dashboard</a></li>";
	}
	else {
	print "<li><a href='index.php?p=dashboard'>Dashboard</a></li>";
	}
	//if($_SERVER["REQUEST_URI"] == "/admin/index.php?p=checkin") {
	//print "<li class='active'><a href='index.php?p=checkin'>Check-In</a></li>";
	//}
	//else {
	//print "<li><a href='index.php?p=checkin'>Check-In</a></li>";
	//}
	if($_GET['p'] == "shift") {
	print "<li class='active'><a href='index.php?p=shift'>Shift Sign-Up</a></li>";
	} else {
	print "<li><a href='index.php?p=shift'>Shift Sign-Up</a></li>";
	}
	if($inf['AdminLevel'] >= 2) { $stafftype = "Administrative"; } else { $stafftype = "Advisory"; }
	if($_GET['p'] == "roster") {
	print "<li class='active'><a href='index.php?p=roster'>".$stafftype." Roster</a></li>";
	}
	else {
	print "<li><a href='index.php?p=roster'>".$stafftype." Roster</a></li>";
	}
	if($inf['AdminLevel'] >= 2) {
	if($_GET['p'] == "leave") {
	print "<li class='active'><a href='index.php?p=leave'>On-Leave Request</a></li>";
	}
	else {
	print "<li><a href='index.php?p=leave'>On-Leave Request</a></li>";
	}
	}
	print "</ul>";
}

?>