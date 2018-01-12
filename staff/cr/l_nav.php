<?php
$section = 'Customer Relations';
function SideNav($inf) {
	print "<ul>";
		if($_GET['p'] == "manage" || $_GET['p'] == "support" || $_GET['p'] == 'orders' || $_GET['p'] == 'csearch' || $_GET['p'] == 'ctracker') {
				print "<li class='active'>Store";
			}
			else print "<li>Store";
				print "<ul><b>Customer Area</b>";
				print "<li><a href='cr.php?p=orders'>Orders</a></li>";
				print "<li><a href='cr.php?p=support'>Customer Support</a></li>";
				print "</ul>";
				if($inf['AdminLevel'] >= 1338 || $inf['ShopTech'] == 3) {
				print "<ul><b>Credits</b>";
				print "<li><a href='cr.php?p=csearch'>Search</a></li>";
				print "<li><a href='cr.php?p=ctracker'>Tracker</a></li>";
				print "<li><a href='cr.php?p=pinchange'>Pin Change</a></li>";
				print "</ul><ul><b>Management</b>";
				print "<li><a href='cr.php?p=manage&sp=main'>CP Store</a></li>";
				print "<li><a href='cr.php?p=manage&sp=items'>In-Game Store</a></li>";
				print "<li><a href='cr.php?p=manage&sp=faq'>FAQ</a></li>";
				}
				print "</ul></li>";
		
		if($inf['AdminLevel'] >= 1337 || $inf['ShopTech'] > 0) {
		/*
			if($_GET['p'] == "shift" || $_GET['p'] == "assigncal" || $_GET['p'] == "assignview" || $_GET['p'] == "assignedit") {
				print "<li class='active'>Shifts";
			}
			else print "<li>Shifts";
				print "<ul>";
				print "<li><a href='cr.php?p=shift'>Sign-up</a></li>";
				print "<li><a href='cr.php?p=assigncal'>View & Issue Assignments</a></li>";
				print "</ul></li>";
			if($_GET['p'] == "report_create" || $_GET['p'] == "report_pending" || $_GET['p'] == "report_archive") {
				print "<li class='active'>Weekly Reports";
			}
		
			else print "<li>Weekly Reports";
				print "<ul>";
				print "<li><a href='cr.php?p=report_create'>Create a Report</a></li>";
				print "<li><a href='cr.php?p=report_pending'>Pending Reports</a></li>";
				print "<li><a href='cr.php?p=report_archive'>Archived Reports</a></li>";
				print "</ul></li>";
		*/
			if($_GET['p'] == "tracker") {
				print "<li class='active'>Trackers";
			}
			else print "<li>Trackers";
				print "<ul>";
				print "<li><a href='cr.php?p=tracker&item=business'>Business</a></li>";
				print "<li><a href='cr.php?p=tracker&item=house'>House</a></li>";
				print "<li><a href='cr.php?p=tracker&item=backdoor'>Backdoor</a></li>";
				print "<li><a href='cr.php?p=tracker&item=gate'>Gate</a></li>";
				print "<li><a href='cr.php?p=tracker&item=vip'>VIP</a></li>";
				print "<li><a href='cr.php?p=tracker&item=gvip'>Gold VIP</a></li>";
				print "<li><a href='cr.php?p=tracker&item=pvip'>Platinum VIP</a></li>";
				print "<li><a href='cr.php?p=tracker&item=ts'>TeamSpeak Channel</a></li>";
				print "</ul></li>";
		}
		if($inf['AdminLevel'] >= 1338 || $inf['ShopTech'] >= 3) {
		if(isset($_GET['p']) && $_GET['p'] == 'roster') {
			print "<li class='active'><a href='cr.php?p=roster'>Shop Technicians</a></li>";
		}
		else {
			print "<li><a href='cr.php?p=roster'>Shop Technicians</a></li>";
		}
		}
	print "</ul>";
}

?>