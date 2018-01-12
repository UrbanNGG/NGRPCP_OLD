<?php
function SideNav($inf) {
	print "<ul>";
	if($inf['AdminLevel'] >= 4 || $inf['BanAppealer'] >= 1 || $access['ban'] == 1) {
	if(isset($_GET['type']) && ($_GET['type'] == "pending" || $_GET['type'] == "temporary" || $_GET['type'] == "permanent" || $_GET['type'] == "unban")) {
	print "<li class='active'>Player Ban Lists";
	print "<ul>";
	print "<li><a href='ban.php?p=view&type=pending'>Pending Appeal</a></li>";
	print "<li><a href='ban.php?p=view&type=temporary'>Temporary Bans</a></li>";
	print "<li><a href='ban.php?p=view&type=permanent'>Permanent Bans</a></li>";
	print "<li><a href='ban.php?p=view&type=unban'>Unbans</a></li>";
	print "<li><a href='ban.php?p=view&type=archive'>Archived Bans</a></li>";
	print "</ul></li>";
	}
	else {
	print "<li>Player Ban Lists";
	print "<ul>";
	print "<li><a href='ban.php?p=view&type=pending'>Pending Appeal</a></li>";
	print "<li><a href='ban.php?p=view&type=temporary'>Temporary Bans</a></li>";
	print "<li><a href='ban.php?p=view&type=permanent'>Permanent Bans</a></li>";
	print "<li><a href='ban.php?p=view&type=unban'>Unbans</a></li>";
	print "<li><a href='ban.php?p=view&type=archive'>Archived Bans</a></li>";
	print "</ul></li>";
	}
	if(isset($_GET['type']) && $_GET['type'] == "ip") {
	print "<li class='active'><a href='ban.php?p=view&type=ip'>IP Bans</a></li>";
	}
	else {
	print "<li><a href='ban.php?p=view&type=ip'>IP Bans</a></li>";
	}
	if(isset($_GET['type']) && $_GET['type'] == "history") {
	print "<li class='active'><a href='ban.php?p=view&type=history'>Player History</a></li>";
	}
	else {
	print "<li><a href='ban.php?p=view&type=history'>Player History</a></li>";
	}
	if($inf['AdminLevel'] >= 1338 || $inf['BanAppealer'] == 2) {
	if($_GET['p'] == "roster") {
	print "<li class='active'><a href='ban.php?p=roster'>Ban Appealers</a></li>";
	}
	else {
	print "<li><a href='ban.php?p=roster'>Ban Appealers</a></li>";
	}
	}
	}
	print "</ul>";
}

?>