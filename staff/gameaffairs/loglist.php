<div id='content_wrap'> 
	<ol id='breadcrumb'><li>Faction > Treasury Logs</li></ol> 
	<div class='section_title'><h2>Treasury Logs</h2></div>
	<div class='acp-box'>
<h3>Logs by Date</h3>
<table cellpadding="0" class="double_pad" cellspacing="0" border="0" width="100%">
<?php

$facquery = mysql_query("SELECT `id`, `Name` FROM `groups`");
while ($fac = mysql_fetch_array($facquery)) {
	
	$facid = $fac['id'] - 1;
	
	print "<tr><th>$fac[Name]</th></tr>";
	
	$path = "/home/samp/main/scriptfiles/grouppay/".$facid."/";
	$dh = @opendir($path);

	while (false !== ($file=readdir($dh)))
	{
	  if (substr($file,0,1)!=".")
		 $files[]=array(filemtime($path.$file),$file);
	}
	closedir($dh);

	if ($files)
	{
	  rsort($files);
	  foreach ($files as $file) {
	  
		if (isset($i) && $i == 1) {
			print "<tr class='tablerow1'>";
		$i=0;
		} else { 
			print "<tr>";
		$i=1;
		}
	  
		$log = "<form method='post' action='gameaffairs.php?p=log'>
		<input type='hidden' name='id' readonly='readonly' value='$facid'>
		<input type='hidden' name='file' readonly='readonly' value='$file[1]'>
		<input type='submit' class='submit' value='$file[1]'></form>
		";

		echo "<td>$log</td></tr>";
	  }
	}
}
   echo '</table>';
?>

	</div>
	</div>