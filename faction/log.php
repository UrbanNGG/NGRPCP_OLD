<div id='content_wrap'>
	<ol id='breadcrumb'><li>Faction > Treasury Logs</li></ol>
	<div class='section_title'><h2><?php if(isset($_POST['file'])) { echo $_POST['file']; } ?></h2></div>
	<div style="width:100%;height:500px;overflow-y:scroll;background-color:#FFF;border:#333 solid thin;margin-left:auto;margin-right:auto;padding:10px">
<?php if(isset($_POST['file'])){
if ($inf['Leader'] != -1 && strstr($_POST['file'], "..") == FALSE)
{
$fl = fopen("/home/samp/main/scriptfiles/grouppay/".$inf['Leader']."/".$_POST['file'], "r");
for($x_pos = 0, $ln = 0, $output = ""; fseek($fl, $x_pos, SEEK_END) !== -1; $x_pos--) {
    $char = fgetc($fl);
    if ($char === "\n") {
        
		if ($ln != 0) {
		echo strrev($output) . "<br>";
		}
		$ln++;
		$output = "";
        continue;
        }
    $output .= $char;
    }
fclose($fl);
} else 
	{
	echo '<h2 align = "center"> You do not have permission to view this log. </h2>';
	}
}
?>
	</div>
</div>