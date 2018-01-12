<style type='text/css'>
body {
	background: #d3dae0 url(http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/branding_bg.png) repeat-x top;
}
#logo {
	margin-top:-9px;
}
#changelog {
	margin-top:50px;
}
</style>
<img id='logo' src="http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/logo.png" />
<div id='changelog'>
<?php
$xml = simplexml_load_file("../svninfo/svnlog.xml");
$i=1;
foreach ($xml->logentry as $logentry)
{	
	if($i < 20)
	{
	$datestr = (string)$logentry->date;
	$date = substr($datestr, 0, 10);
	echo "Revision: " . $logentry->attributes()->revision . "<br />";
	if(strtolower($logentry->author) == "grandtheftgamer") { echo "Developer: Farva<br />"; }
	if(strtolower($logentry->author) == "cabarama") { echo "Developer: John Roy<br />"; }
	echo "Date: ".$date."<br />";
	if(substr($logentry->msg, 0, 3) == "[*]")
		{
			$note = str_replace("[*]", "<li>", $logentry->msg);
			echo "Notes: <ul>".$note."</li></ul><br />";
		}
	else echo "Notes: <ul>".$logentry->msg."</ul><br /><br />";
	$i++;
	}
}
?>
</div>