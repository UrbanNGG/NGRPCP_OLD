<?php
$section = 'Store';
function SideNav($inf) {
	print "<ul>";
	if($_GET['p'] == "main" || $_GET['p'] == "cart" || $_GET['p'] == "addcart" || $_GET['p'] == "info") {
				print "<li class='active'>Main";
			}
	print "</ul>";
}
?>