<?php if($inf['AdminLevel'] >= 2 || $inf['Helper'] >= 2) { ?>
			<div id='content_wrap'>
				<ol id='breadcrumb'><li><?php echo $section; ?> > Shifts</li></ol>
				<div class='section_title'><h2>Shifts</h2></div>
			<div class='acp-box'>
				<h3>Viewing Shifts</h3>
<?php echo "<table cellpadding='0' class='double_pad' cellspacing='0' border='1' width='100%'><tr><th width='14.28%'>Sunday</th><th width='14.28%'>Monday</th><th width='14.28%'>Tuesday</th><th width='14.28%'>Wednesday</th><th width='14.28%'>Thursday</th><th width='14.28%'>Friday</th><th width='14.28%'>Saturday</th></tr><tr>";

if(date('w') == 0)
    $str = 'today';
else
    $str = 'last sunday';

$timestamp = strtotime($str);

$j = 0;
for($i = 0; $i < 14; $i++)
{		
		$date = date('j', $timestamp + ($i * (60 * 60 * 24)));
		$assigndate = date('Y-m-d', $timestamp + ($i * (60 * 60 * 24)));
	if ($date == date('j')) {
		echo '<td style="background:#fffdbc"><a href="index/assign.php?y='.date ('l', $timestamp + ($i * (60 * 60 * 24))).'&d='.$assigndate.'">'.date('j', $timestamp + ($i * (60 * 60 * 24))).'</a></td>';
	} else {
		echo '<td><a href="index/assign.php?y='.date ('l', $timestamp + ($i * (60 * 60 * 24))).'&d='.$assigndate.'">'.date('j', $timestamp + ($i * (60 * 60 * 24))).'</a></td>';
	}
    $j++;
    if($j == 7)
    {
        echo '</tr><tr>';
        $j = 0;
    }
}
?>
</td></tr></table>
</div>
<div align="center" style="padding-top:25px;font-weight:bold;color:red">Reminder: You need to select a minimum of <?php if($inf['AdminType'] == 3) echo "9"; else echo "15"; ?> shifts each week.</div>
</div>
<?php }
else { echo "<div id='content_wrap'><div class='section_title'><h2>You do not have access to this section.</h2></div></div>"; } ?>