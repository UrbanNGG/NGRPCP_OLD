<?php
$punishquery = mysql_query("SELECT `id` FROM `cp_punishment` WHERE `status` = '1'");
$punishcount = mysql_num_rows($punishquery);
$refundquery = mysql_query("SELECT `id` FROM `cp_refund` WHERE `status` = '1'");
$refundcount = mysql_num_rows($refundquery);
?>
<div class="sc_menu">
<ul class='sc_menu'>
	<?php if($_SERVER["SCRIPT_NAME"] == "/staff/index.php") { ?><li class='active'><?php } else { ?><li><?php } ?><a href='index.php?p=dashboard'><img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/applications/portal.png' alt='' /> Main</a></li>
	
	<?php if($_SERVER["SCRIPT_NAME"] == "/staff/request.php") { ?><li class='active'><?php } else { ?><li><?php } ?><a href='request.php?p=email'><img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/applications/help.png' alt='' /> Requests</a></li>
	
	<?php if($inf['AdminLevel'] > 1 || $access["punish"] == 1) { ?>
		<?php if($_SERVER["SCRIPT_NAME"] == "/staff/punish.php") { ?><li class='active'><?php } else { ?><li><?php } ?><div id='notification_contain'><a href='punish.php?p=view&o=1'><img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/applications/gallery.png' alt='' /> Punishments</a><?php if($punishcount != 0) { ?> <div class="notification"><?php echo $punishcount; ?></div><?php } ?></div></li> 
	<?php } ?>
	
	<?php if($inf['AdminLevel'] > 1 || $access['refund'] == 1) { ?>
		<?php if($_SERVER["SCRIPT_NAME"] == "/staff/refund.php") { ?><li class='active'><?php } else { ?><li><?php } ?><div id='notification_contain'><a href='refund.php?p=view&o=1'><img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/applications/subscriptions.png' alt='' /> Refunds</a><?php if($refundcount != 0) { ?> <div class="notification"><?php echo $refundcount; ?></div><?php } ?></div></li>
	<?php } ?>
	
	<?php if($inf['AdminLevel'] >= 4 || $inf['BanAppealer'] > 0 || $access['ban'] == 1) { ?>
		<?php if($_SERVER["SCRIPT_NAME"] == "/staff/ban.php") { ?><li class='active'><?php } else { ?><li><?php } ?><a href='ban.php?p=view&type=pending'><img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/applications/calendar.png' alt='' /> Bans</a></li>
	<?php } ?>
	
	<?php if($inf['AdminLevel'] >= 4 || $inf['FactionModerator'] > 0 || $inf['GangModerator'] > 0) { ?>
		<?php if($_SERVER["SCRIPT_NAME"] == "/staff/gameaffairs.php") { ?><li class='active'><?php } else { ?><li><?php } ?><a href='gameaffairs.php?p=index'><img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/applications/core.png' alt='' /> Game Affairs</a></li>
	<?php } ?>
	
	<?php if($inf['AdminLevel'] >= 1337 || $inf['PR'] > 0) { ?>
		<?php if($_SERVER["SCRIPT_NAME"] == "/staff/pr.php") { ?><li class='active'><?php } else { ?><li><?php } ?><a href='pr.php?p=index'><img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/applications/brick.png' alt='' /> Public Relations</a></li>
	<?php } ?>
	
	<?php if($inf['AdminLevel'] >= 1337 || $inf['ShopTech'] > 0) { ?>
		<?php if($_SERVER["SCRIPT_NAME"] == "/staff/cr.php") { ?><li class='active'><?php } else { ?><li><?php } ?><a href='cr.php?p=index'><img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/applications/chat.png' alt='' /> Customer Relations</a></li>
	<?php } ?>
	
	<?php if($inf['AdminLevel'] >= 1337 || $inf['Security'] > 0) { ?>
		<?php if($_SERVER["SCRIPT_NAME"] == "/staff/security.php") { ?><li class='active'><?php } else { ?><li><?php } ?><a href='security.php?p=index'><img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/applications/key.png' alt='' /> Security</a></li>
	<?php } ?>
	
	<?php if($inf['AdminLevel'] >= 2) { ?>
		<?php if($_SERVER["SCRIPT_NAME"] == "/staff/flag.php") { ?><li class='active'><?php } else { ?><li><?php } ?><a href='flag.php?p=view'><img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/applications/forums.png' alt='' /> Flags</a></li>
	<?php } ?>
	
	<?php if($inf['AdminLevel'] >= 1 || $inf['Helper'] >= 3) { ?>
		<?php if($_SERVER["SCRIPT_NAME"] == "/staff/log.php") { ?><li class='active'><?php } else { ?><li><?php } ?><a href='log.php?p=index'><img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/applications/blog.png' alt='' /> Logs</a></li>
	<?php } ?>
	
	<?php if($inf['AdminLevel'] >= 2) { ?>
		<?php if($_SERVER["SCRIPT_NAME"] == "/staff/player.php") { ?><li class='active'><?php } else { ?><li><?php } ?><a href='player.php?p=view'><img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/icons/members_icon_small.png' alt='' /> Players</a></li>
	<?php } ?>
	
	<?php if($inf['AdminLevel'] >= 4 || $inf['Helper'] >= 3 || $inf['HR'] > 0) { ?>
	<?php if($_SERVER["SCRIPT_NAME"] == "/staff/user.php") { ?><li class='active'><?php } else { ?><li><?php } ?><a href='user.php?p=index'><img src='http://<?php echo $_SERVER['SERVER_NAME']; ?>/global/images/all/applications/members.png' alt='Icon' /> Management</a></li>
	<?php } ?>
</ul>
</div>