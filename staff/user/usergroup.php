<?php if($inf['AdminLevel'] < 1337) {
	echo $redir2;
	exit();
}

?>

			<div id='content_wrap'>
				<ol id='breadcrumb'><li>User Management > Usergroup Leaders</li></ol>
				<?php if ($_GET['a']=="add"){
				include('usergroup/add.php');
				}
				?>

				<?php if ($_GET['a']=="view"){
				include('usergroup/view.php');
				}
				?>
			</div></div>