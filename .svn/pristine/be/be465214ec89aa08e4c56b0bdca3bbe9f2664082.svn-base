<?php
require('global/func.php');
require('business/l_nav.php');
$redir = '<meta http-equiv="refresh" content="0;url=../login.php">';

if (!isset($_GET['p'])){ print "<meta http-equiv=\"refresh\" content=\"0;url=business.php?p=info\">"; }

if(!isset($_SESSION['myusername'])){
$logged = 0;
echo $redir;
exit();
}

if($inf['Business'] != -1)
{
	$bizquery = mysql_query("SELECT * FROM `businesses` WHERE `Id` = $inf[Business]+1");
	$biz = mysql_fetch_array($bizquery);
	$biz['Id'] = $biz['Id'] - 1;
	
	function GetRankName($rank)
	{
		switch($rank)
		{
			case 0: $rankname = "Trainee";
				break;
			case 1: $rankname = "Employee";
				break;
			case 2: $rankname = "Senior Employee";
				break;
			case 3: $rankname = "Manager";
				break;
			case 4: $rankname = "Co-Owner";
				break;
			case 5: $rankname = "Owner";
				break;
			default: $rankname = "Undefined";
				break;
		}
		return $rankname;
	}
	
	switch($biz['Type'])
	{
		case 1: $type = "Gas Station";
			$inventory = "Items";
			break;
		case 2: $type = "Clothing Store";
			$inventory = "Clothes";
			break;
		case 3: $type = "Restaurant";
			$inventory = "Food & Beverages";
			break;
		case 4: $type = "Gun Shop";
			$inventory = "Materials";
			break;
		case 5: $type = "New Car Dealership";
			$inventory = "Vehicles";
			break;
		case 6: $type = "Used Car Dealership";
			$inventory = "Vehicles";
			break;
		case 7: $type = "Mechanic";
			$inventory = "Parts";
			break;
		case 8: $type = "24/7";
			$inventory = "Items";
			break;
		case 9: $type = "Bar";
			$inventory = "Food & Beverages";
			break;
		case 10: $type = "Club";
			$inventory = "Food & Beverages";
			break;
		case 11: $type = "Sex Shop";
			$inventory = "Items";
			break;
		default: $type = "Undefined";
			break;
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php head($inf); ?>
</head>

<?php headbar($inf); Nav($inf,$access); ?>

	<div id='page_body'>

		<div id='section_navigation'>
			<?php SideNav($inf); ?>
		</div>

		<div id='main_content'>
	<?php
	if($inf["Business"] != -1)
	{
		if ($_GET['p']=="roster"){
			include('business/roster.php');
		}
		if ($_GET['p']=="info"){
			include('business/info.php');
		}
	}
	else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this section.</h2></div></div>"; }
	?>
		<div class='acp-box'>
			<div id='copyright'><?php require('global/footer.php'); ?></div>
		</div>
		</div>
	</div>
</body>
</html>

<?php }
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this section.</h2></div></div>"; } ?>