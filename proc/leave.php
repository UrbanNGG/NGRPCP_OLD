<?php
require('aInfo.php');
$redir = '<meta http-equiv="refresh" content="1;url=login.php">';
if(!isset($_SESSION['myusername'])){
$logged = 0;

echo $redir;
exit();
}
if($_GET['action'] == "logout") {
	session_destroy();
	echo $redir;
	exit();
}

$query6 = "UPDATE `ngg_cms`.`a_users` SET  `Suspend` = '2' WHERE `a_users`.`ID` = $inf[ID]";
mysql_query($query6);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml"> 
<head> 
    <meta name="description" content="Next Generation Gaming's Content Management System (CMS), created by Luke Scowen (l.scowen@hotmail.co.uk)"> 
    <meta name="keywords" content="ngg, cms, ngrp, next generation gaming, content management system,"> 
	<!--[if lte IE 7]><link rel="shortcut icon" href="favicon.ico" type="image/x-icon" /><![endif]--> 
	<link rel="shortcut icon" href="favicon.png" type="image/png" /> 
 
	<title>NGRP CMS v4.0.0</title> 
	<style type='text/css' media='all'> 
		@import url( "global/css/acp.css" );
		@import url( "global/css/acp_content.css" );
		
.alignleft {
float: left;
}
.alignright {
float: right;
}
	</style> 
	<!--[if IE]>
		<link href="global/css/acp_ie_tweaks.css" rel="stylesheet" type="text/css" />
	<![endif]--> 

</head>

<body id='ipboard_body'> 
	<p id='admin_bar'> [Time and Date: <b><?php echo date('m/d/y'); ?></b>]
		<span id='logged_in'><font color='yellow'>You Need to Check In [<a href='checkin.php'>Check In</a>]</font>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Logged in as <strong><a href="profile.php?id=<?php echo $inf['ID']; ?>"><?php echo $_SESSION['myusername']; ?></a></strong> [<b><font color = 'green'><?php echo $inf['Level']; ?></font></b>] [<?php echo $inf['Group']; ?>] (<a href='leave.php?action=logout'>Log Out</a>)</span> 
	</p> 
	<div id='header'> 
		<div id='branding'> 
			<img src='http://www.ng-gaming.net/cms/admin/global/images/all/logo.png' alt='Logo' />

		</div> 
		<h1>NGG CMS Admin Home</h1> 
 

 				<?php //Nav($inf,$access); ?>

<div id='page_body'> 
		<div id='section_navigation'> 
			<ul> 
                        </li>
						<li class='active'>Menu						<ul> 
						
						</ul> 
		</div>

		<div id='main_content'> 
			<div id='content_wrap'> 
				<ol id='breadcrumb'> 
	<li>Home > Leave</li> 
</ol> 
<br /><div class='section_title'> 
	<h2>Account Status</h2></div> 
<br />

 
 
		<div class='acp-box'> 
		<h3>Account Halted</h3> 
		<ul class='alternate_rows' id='sortable_handle'> 
			<li class='isDraggable' id='setting_49'> 
You are now marked as "On Leave"<br>
To have your account restored, you will need to speak to a head administrator.
</li>	
 
		<div class='acp-actionbar'> 
						</div> 


		<div class='acp-box'> 

<div id='copyright'> 
				 &nbsp;</div> 
 
		</div> 
		
	</div> 
</body> 
</html>