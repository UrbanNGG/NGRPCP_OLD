<?php if($inf['FactionModerator'] > 0 || $inf['AdminLevel'] > 3) { ?>
<div id='content_wrap'>
	<ol id='breadcrumb'><li>Game Affairs > Viewing Factions</li></ol>
	<div class='section_title'><h2>Factions</h2></div>
<div class='acp-box'>
	<h3>Faction List</h3>
		<table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
		<tr>
			<th>Name</th>
		</tr>
	<?php $facquery = mysql_query("SELECT `id`, `name` FROM `cp_faction`");
		while ($fac = mysql_fetch_array($facquery)) {
			if (isset($i) && $i == 1) {
				print "<tr class='tablerow1'>";
			$i=0;
			} else { 
				print "<tr>";
			$i=1;
			}
			
	$fac_edit = "<form method='post' action='gameaffairs.php?p=factionedit'>
	<input type='hidden' name='action' readonly='readonly' value='edit'>
	<input type='hidden' name='facid' readonly='readonly' value='$fac[id]'>
	<input type='submit' class='submit' value='$fac[name]'>
	</form>";
			
		print "
			<td>$fac_edit</td>
			</tr>
			";
		}
	?>
		</table>
</div>
</div>
<?php } 
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this page.</h2></div></div>"; } ?>