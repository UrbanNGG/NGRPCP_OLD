<?php
function SideNav($inf) {
	if($inf['AdminLevel'] >= 4 || $inf['Helper'] >= 3 || $inf['HR'] > 0) {
		print "<ul>";
		if($inf['AdminLevel'] >= 1338 || $inf['AP'] >= 2) {
			if($_GET['p'] == "manage") { print "<li class='active'>"; } else print "<li>";
			print "<a href='user.php?p=manage'>CP Notification</a></li>";
			if($_GET['p'] == "admincreate") { print "<li class='active'>"; } else print "<li>";
			print "<a href='user.php?p=admincreate'>Add Administrator</a></li>";
		}
		if($inf['AdminLevel'] >= 1337 || $inf['HR'] > 0)
		{
			if($_GET['p'] == "view" || $_GET['p'] == "edit") print "<li class='active'>View Users";
			else print "<li>View Users";
				print "<ul>";
				if($inf['AdminLevel'] >= 1337 || $inf['HR'] > 0) print "<li><a href='user.php?p=view&g=admin'>Administrators</a></li>";
				if($inf['AdminLevel'] >= 1337) print "<li><a href='user.php?p=view&g=moderator'>Moderators</a></li>";
				if($inf['AdminLevel'] >= 1337) print "<li><a href='user.php?p=view&g=watchdog'>Watchdogs</a></li>";
				if($inf['AdminLevel'] >= 1338 || $inf['AP'] >= 2) print "<li><a href='user.php?p=view&g=disabled'>Disabled</a></li>";
				print "</ul></li>";
		}
		if($inf['AdminLevel'] >= 1338 || $inf['PR'] >= 3 || $inf['CR'] >= 3)
		{
			if($_GET['p'] == "email") { print "<li class='active'>"; } else print "<li>";
				print "<a href='user.php?p=email'>Mass Email Players</a></li>";
		}
		if($inf['AdminLevel'] >= 4) {
		if($_GET['p'] == "pendingnote" || $_GET['p'] == "allnote" || $_GET['p'] == "archivenote" || $_GET['p'] == "addnote") {
			print "<li class='active'>Notes";
		}
		else print "<li>Notes";
			print "<ul>";
			print "<li><a href='user.php?p=addnote'>Add User Note</a></li>";
			if($inf['AdminLevel'] >= 1338 || $inf['AP'] >= 2) print "<li><a href='user.php?p=pendingnote'>Pending Notes</a></li>";
			if($inf['AdminLevel'] >= 1338 || $inf['AP'] >= 2 || $inf['HR'] >= 2) print "<li><a href='user.php?p=allnote'>All Notes</a></li>";
			if($inf['AdminLevel'] >= 1338 || $inf['AP'] >= 2 || $inf['HR'] >= 2) print "<li><a href='user.php?p=archivenote'>Archived Notes</a></li>";
			print "</ul></li>";
		if($_GET['p'] == "pendingleave" || $_GET['p'] == "archiveleave" || $_GET['p'] == "onleave") {
			print "<li class='active'>Leaves";
		}
		else print "<li>Leaves";
			print "<ul>";
			if($inf['AdminLevel'] >= 1338 || $inf['AP'] >= 2) print "<li><a href='user.php?p=pendingleave'>Pending Leaves</a></li>";
			if($inf['AdminLevel'] >= 1337 || $inf['HR'] >= 2) print "<li><a href='user.php?p=onleave'>Current Leave Notices</a></li>";
			print "<li><a href='user.php?p=archiveleave'>Archived Leaves</a></li>";
			print "</ul></li>";
		}
		if($_GET['p'] == "shiftpending" || $_GET['p'] == "shiftneeds" || $_GET['p'] == "assigncal" || $_GET['p'] == "alert") {
			print "<li class='active'>Shifts";
		}
		else print "<li>Shifts";
			print "<ul>";
			if($inf['AdminLevel'] >= 1338 || $inf['HR'] >= 2 || $inf['AP'] >= 2 || $inf['Helper'] >= 3) { print "<li><a href='user.php?p=alert'>Alerts</a></li>"; }
			if($inf['AdminLevel'] >= 4 || $inf['Helper'] >= 3 || $inf['HR'] >= 2) { print "<li><a href='user.php?p=assigncal'>View & Issue Assignments</a></li>"; }
			if($inf['AdminLevel'] >= 1338 || $inf['Helper'] == 4 || $inf['AP'] >= 2) { print "<li><a href='user.php?p=shiftneeds'>Shift Needs & Leaders</a></li>"; }
			print "</ul></li>";
		print "</ul>";
	}
}
?>