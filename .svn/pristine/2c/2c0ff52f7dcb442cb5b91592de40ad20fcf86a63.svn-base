<?php
require('./func.php');

$redir = '<meta http-equiv="refresh" content="0;url=../login.php">';
if(!isset($_SESSION['myusername'])){
$logged = 0;
echo $redir;
exit();
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xml:lang="en" lang="en" xmlns="http://www.w3.org/1999/xhtml">

<head>
<?php head($inf); ?>
</head>

<body id='ipboard_body'> 
<div id='redirect'>
    <div>
        The username you selected is already in use. Please check the <a href="user.php?p=view&g=archive" style="font-weight:bold">Archived users section</a> to restore the account, or <a href="javascript:history.go(-1)" style="font-weight:bold">go back and choose another username</a>.
	</div>
</div>
<div id='copyright-login'><?php require('./footer.php'); ?></div>
</body>
</html>