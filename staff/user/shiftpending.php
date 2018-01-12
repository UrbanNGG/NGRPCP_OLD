<?php if($inf['AdminLevel'] < 1337) {
	echo $redir2;
	exit();
}
?>
 
			<div id='content_wrap'>
				<ol id='breadcrumb'><li>User Management > Shifts</li></ol>
				<div class='section_title'><h2>Shift Assignments</h2></div>
			<div class='acp-box'>
<?php 
if ($inf['AdminLevel'] >= 2) {
	$shift1 = mysql_query("SELECT * FROM `cp_shift_blocks` WHERE `type`='1' ORDER BY id ASC");
	$shiftquery = mysql_query("SELECT `shift` FROM `cp_shift_blocks` WHERE `type`='1'");
} else {
	$shift1 = mysql_query("SELECT * FROM `cp_shift_blocks` WHERE `type`='2' ORDER BY id ASC");
	$shiftquery = mysql_query("SELECT `shift` FROM `cp_shift_blocks` WHERE `type`='2'");
}
$shift = mysql_fetch_array($shift1);

echo "<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>";

if(date('w') == 0)
    $str = 'today';
else
    $str = 'last sunday';

$timestamp = strtotime($str);
for($i = 0; $i < 14; $i++)
{

	$assigndate = date('Y-m-d', $timestamp + ($i * (60 * 60 * 24)));
		
    echo '<tr style="color:#fff;font-size:1.1em;font-weight:bold;background:#1d3652 url(http://www.ng-gaming.net/admin/global/images/global/gradient_bg.png) repeat-x 50%"><td>'.date('l', $timestamp + ($i * (60 * 60 * 24))).' (Week '.strftime("%U", $timestamp + ($i * (60 * 60 * 24))).')</td></tr>';
	
	while ($row = mysql_fetch_row($shiftquery))
		{
	
			$count = count($row);
			$z = 0;
			while($z <$count)
			{
			
	if($i == 0 || $i == 9) { $shiftday = $shift[needs_sunday]; }
	if($i == 1) { $shiftday = $shift[needs_monday]; }
	if($i == 2) { $shiftday = $shift[needs_tuesday]; }
	if($i == 4) { $shiftday = $shift[needs_wednesday]; }
	if($i == 5) { $shiftday = $shift[needs_thursday]; }
	if($i == 6) { $shiftday = $shift[needs_friday]; }
	if($i == 7) { $shiftday = $shift[needs_saturday]; }
			
				$value = current($row);
				
						if($value == A) { $shiftID = 1; }
						if($value == B) { $shiftID = 2; }
						if($value == C) { $shiftID = 3; }
						if($value == D) { $shiftID = 4; }
						if($value == E) { $shiftID = 5; }
						if($value == F) { $shiftID = 6; }
						if($value == G) { $shiftID = 7; }
						if($value == H) { $shiftID = 8; }
					if ($inf['AdminLevel'] >= 2) {
						$needsquery = mysql_query("SELECT * FROM `cp_shifts` WHERE `date` = '$assigndate' AND `shift_id` = '$shiftID' AND `type` = '1'");
					} else {
						$needsquery = mysql_query("SELECT * FROM `cp_shifts` WHERE `date` = '$assigndate' AND `shift_id` = '$shiftID' AND `type` = '3'");
					}
					$need = mysql_num_rows($needsquery);
				echo '<tr><th>'.$value.' ('.$need.'/'.$shiftday.')</th></tr>';
						if ($r == 1) {
							print "<tr>";
						$r=0;
						} else {
							print "<tr class='tablerow1'>";
						$r=1;
						}
				echo '<td>'.$shiftID.'</td>';
				next($row);
				$z++;
			}
		}
		$z = 0;
		mysql_data_seek( $shiftquery, 0);

}
?>
</h3></table>
			</div></div>