<div id='content_wrap'>
	<ol id='breadcrumb'><li>User Management > View Users</li></ol>
	<div class='section_title'><h2>User Manager</h2></div>
	<div class='acp-box'>
		<?php if ($_GET['u']=="admin"){
		include('edit/admin.php');
		}
		if ($_GET['u']=="advisor"){
		include('edit/advisor.php');
		}
		if ($_GET['u']=="mod"){
		include('edit/mod.php');
		}
		if ($_GET['u']=="helper"){
		include('edit/helper.php');
		}
		if ($_GET['u']=="disabled"){
		include('edit/disabled.php');
		}
		?>
		<div class='acp-actionbar'></div>
	</div>
</div>