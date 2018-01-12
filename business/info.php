<div id='content_wrap'>
  <ol id='breadcrumb'>
    <li>Business &raquo; Information</li>
  </ol>
  <div class='section_title'>
    <h2>Business Information</h2>
  </div>
  <div class='acp-box'>
    <h3><?php echo $biz['Name']; ?> (Business ID: <?php echo $biz['Id']; ?>)</h3>
    <table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
	  <tr class='tablerow1'>
        <td>Type of Business: <?php echo $type; ?></td>
		<td>Status: <?php if($biz['Status'] == 1) echo "Open"; else echo "Closed"; ?></td>
        <td>Business Owner: <?php echo GetName($biz['OwnerID']); ?></td>
		<td>Business Value: $<?php echo number_format($biz['Value']); ?></td>
      </tr>
	  <tr>
        <td>Level: <?php echo $biz['Level']; ?></td>
        <td>Sale Type: <?php if($biz['AutoSale'] == 1) echo "Automatic"; else echo "Manual"; ?></td>
        <td>Total Sales: <?php echo number_format($biz['TotalSales']); ?></td>
        <td>Safe Balance: $<?php echo number_format($biz['SafeBalance']); ?></td>
      </tr>
	  <tr class='tablerow1'>
        <td>Inventory: <?php echo number_format($biz['Inventory'])."/".number_format($biz['InventoryCapacity'])." ".$inventory; ?></td>
        <td>Last Resupply Date: <?php echo date("m/d/Y - g:iA", strtotime("$biz[OrderDate]")); ?></td>
        <td>Supply Amount: <?php echo number_format($biz['OrderAmount'])." ".$inventory; ?></td>
        <td>Supply Requested By: <?php echo $biz['OrderBy']; ?></td>
      </tr>
    </table>
  </div>
<?php if($biz['Type'] == 1) { ?>
  <div class='acp-box'>
    <h3>Gas Pumps</h3>
    <table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
	<tr><th>Pump ID</th><th>Available Gas</th><th>Tank Capacity</th><th>Price</th></tr>
	<?php
	for($i = 1; $i < 3; $i++)
	{
		$gas = "GasPump".$i."Gas";
		$capacity = "GasPump".$i."Capacity";
		if(isset($r) && $r == 1) {
			print "<tr class='tablerow1'>";
		$r=0;
		} else { 
			print "<tr>";
		$r=1;
		}
		$pump = $i - 1;
		echo "<td>$pump</td><td>".number_format($biz[$gas])." gallons</td><td>".number_format($biz[$capacity])." gallons</td><td>$".number_format($biz['GasPrice'], 2, '.', ',')."</td></tr>";
	}
	?>
    </table>
  </div>
<?php }
if($biz['Type'] == 1 || $biz['Type'] == 8) { ?>
  <div class='acp-box'>
    <h3>Items</h3>
    <table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
	<tr><th>Item Name</th><th>Price</th></tr>
	<?php
	for($i = 1; $i < 19; $i++)
	{
		$price = "Item".$i."Price";
		switch($i)
		{
			case 1: $item = "Cell Phone";
				break;
			case 2: $item = "Phone Book";
				break;
			case 3: $item = "Dice";
				break;
			case 4: $item = "Condom";
				break;
			case 5: $item = "Music Player";
				break;
			case 6: $item = "Rope";
				break;
			case 7: $item = "Cigar";
				break;
			case 8: $item = "Sprunk";
				break;
			case 9: $item = "Vehicle Lock";
				break;
			case 10: $item = "Spraycan";
				break;
			case 11: $item = "Portable Radio";
				break;
			case 12: $item = "Camera";
				break;
			case 13: $item = "Lottery Ticket";
				break;
			case 14: $item = "Checkbook";
				break;
			case 15: $item = "Papers";
				break;
			case 16: $item = "Industrial Lock";
				break;
			case 17: $item = "Electrical Lock";
				break;
			case 18: $item = "Alarm Lock";
				break;
		}
		if(isset($r) && $r == 1) {
			print "<tr class='tablerow1'>";
		$r=0;
		} else { 
			print "<tr>";
		$r=1;
		}
		echo "<td>$item</td><td>$".number_format($biz[$price])."</td></tr>";
	}
	?>
    </table>
  </div>
<?php }
if($biz['Type'] == 11) { ?>
  <div class='acp-box'>
    <h3>Items</h3>
    <table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
	<tr><th>Item Name</th><th>Price</th></tr>
	<?php
	for($i = 1; $i < 5; $i++)
	{
		$price = "Item".$i."Price";
		switch($i)
		{
			case 1: $item = "Purple Dildo";
				break;
			case 2: $item = "Short Vibrator";
				break;
			case 3: $item = "Long Vibrator";
				break;
			case 4: $item = "White Dildo";
				break;
		}
		if(isset($r) && $r == 1) {
			print "<tr class='tablerow1'>";
		$r=0;
		} else { 
			print "<tr>";
		$r=1;
		}
		echo "<td>$item</td><td>$".number_format($biz[$price])."</td></tr>";
	}
	?>
    </table>
  </div>
<?php }
if($biz['Type'] == 5 || $biz['Type'] == 6) { ?>
  <div class='acp-box'>
    <h3>Vehicles</h3>
    <table cellpadding='0' class='double_pad' cellspacing='0' border='0' width='100%'>
	<tr><th>Vehicle Name</th><th>Price</th></tr>
	<?php
	for($i = 0; $i < 10; $i++)
	{
		$model = "Car".$i."ModelId";
		$price = "Car".$i."Price";
		if($biz[$model] > 0)
		{
			if(isset($r) && $r == 1) {
				print "<tr class='tablerow1'>";
			$r=0;
			} else { 
				print "<tr>";
			$r=1;
			}
			echo "<td>".GetVehicleName($biz[$model])."</td><td>$".number_format($biz[$price])."</td></tr>";
		}
	}
	?>
    </table>
  </div>
<?php } ?>
</div>