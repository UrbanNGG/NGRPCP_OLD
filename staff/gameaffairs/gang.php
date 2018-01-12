<?php if($inf['GangModerator'] > 0 || $inf['AdminLevel'] > 3) { ?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Game Affairs > Viewing Gangs</li></ol>
	<div class='section_title'><h2>Gangs</h2></div>
<div class='acp-box'>
	<h3>Gang List</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th>Name</th>
		</tr>
	<?php $famquery = mysql_query("SELECT `id`, `name` FROM `cp_family`");
		while ($fam = mysql_fetch_array($famquery)) {
			if (isset($i) && $i == 1) {
				print "<tr class='tablerow1'>";
			$i=0;
			} else { 
				print "<tr>";
			$i=1;
			}
			
	$fam_edit = "<form method='post' action='gameaffairs.php?p=gangedit'>
	<input type='hidden' name='action' readonly='readonly' value='edit'>
	<input type='hidden' name='famid' readonly='readonly' value='$fam[id]'>
	<input type='submit' class='submit' value='$fam[name]'>
	</form>";
			
		print "
			<td>$fam_edit</td>
			</tr>
			";
		}
	?>
		</table>
</div>
</div>
<?php } 
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>