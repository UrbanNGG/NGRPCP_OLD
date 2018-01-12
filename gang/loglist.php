<div id='content_wrap'> 
	<ol id='breadcrumb'><li>Gang > Logs</li></ol> 
	<div class='section_title'><h2>Gang Logs</h2></div>
	<div class='acp-box'>
<h3>Logs by Date</h3>
<table cellpadding="0" class="double_pad" cellspacing="0" border="0" width="100%">
<?php

$path = "/home/samp/main/scriptfiles/family_logs/".$inf['FMember']."/";
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
	  
		$log = "<form method='post' action='gang.php?p=log'>
		<input type='hidden' name='file' readonly='readonly' value='$file[1]'>
		<input type='submit' class='submit' value='$file[1]'></form>
		";

		echo "<td>$log</td></tr>";
	  }
   }
   echo '</table>';
?>

	</div>
	</div>