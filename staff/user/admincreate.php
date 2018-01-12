<link rel="stylesheet" href="http://code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" />
<script src="http://code.jquery.com/jquery-1.8.3.js"></script>
<script src="http://code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
<script>
  $(function() {
    $( document ).tooltip();
  });
</script>
<?php
if(isset($_GET['err']) && $_GET['err'] == "003") { echo "That username already exists."; }
	if($inf['AdminLevel'] > 1337 || $inf['AP'] >= 2) { ?>
		<div id='content_wrap'>
			<ol id='breadcrumb'><li>User Management > Add User</li></ol> 
			<div class='section_title'><h2>Add User</h2></div>
			<div class='acp-box'>
				<h3>Add Administrator</h3>
				<table class='double_pad' cellpadding='0' cellspacing='0' border='0' width='100%'>
					<form method="POST" action="user/proc.php">
						<tr class="tablerow1"><td width="40%" colspan="2">Username</td><td colspan="4"><input type="text" name="user" title="Administrator Name" length="64"></td></tr>
						<tr><td colspan="2">Password</td><td colspan="4"><input type="password" name="pass" title="Temporary Password (/changepass in-game)" length="64"></td></tr>
						<tr class="tablerow1"><td colspan="2">Rank</td>
							<td colspan="4"><select name="rank">
								<option value="2">Junior Administrator</option>
								<option value="3">General Administrator</option>
							</select></td>
						</tr>
						<tr><th colspan="6">Permissions</th></tr>
						<tr><td colspan="2">CP Access</td>
						<td colspan="4"><select name="cpv[]" size="3" multiple="multiple">
							<option value="punish">View Punishments</option>
							<option value="refund">View Refunds</option>
							<option value="ban">View Bans</option>
						</select></td>
						</tr>
						<tr class="tablerow1"><td colspan="2">Game Log Access</td>
						<td colspan="4"><select name="gl[]" size="6" multiple="multiple">
							<option value="gladmin">Admin</option>
							<option value="gladminauction">Admin Auction</option>
							<option value="gladmingive">Admin Give</option>
							<option value="gladminpay">Admin Pay</option>
							<option value="glauction">Auction</option>
							<option value="glban">Ban</option>
							<option value="glbedit">Business Edit</option>
							<option value="glbusiness">Business</option>
							<option value="glcontracts">Contracts</option>
							<option value="glcrime">Crime</option>
							<option value="glddedit">Dynamic Door Edit</option>
							<option value="gldealership">Dealership</option>
							<option value="gldmpedit">Dynamic Map Icon Edit</option>
							<option value="gldv">Dynamic Vehicle</option>
							<option value="gldvspawn">Dynamic Vehicle Spawn</option>
							<option value="gleditgroup">Edit Group</option>
							<option value="glfaction">Faction</option>
							<option value="glfamily">Family</option>
							<option value="glflagmove">Flag Move</option>
							<option value="glflags">Flags</option>
							<option value="glfmembercount">Family Member Count</option>
							<option value="glgedit">Gate Edit</option>
							<option value="glgifts">Gifts</option>
							<option value="glgov">Government</option>
							<option value="glgroup">Group</option>
							<option value="glhack">Hack</option>
							<option value="glhedit">House Edit</option>
							<option value="glhouse">House</option>
							<option value="glhsafe">House Safe</option>
							<option value="glkick">Kick</option>
							<option value="gllicenses">Licenses</option>
							<option value="glmail">Mail</option>
							<option value="glmoderator">Moderator</option>
							<option value="glmute">Mute</option>
							<option value="glpads">Priority Advertisements</option>
							<option value="glpassword">Password</option>
							<option value="glpay">Pay</option>
							<option value="glplayervehicle">Player Vehicle</option>
							<option value="glrpspecial">RP Special</option>
							<option value="glsecurity">Security</option>
							<option value="glsetvip">Set VIP</option>
							<option value="glshopconfirmedorders">Shop Confirmed Orders</option>
							<option value="glshoplog">Shop</option>
							<option value="glshoporders">Shop Orders</option>
							<option value="glstats">Stats</option>
							<option value="gltledit">Text Label Edit</option>
							<option value="gltoydelete">Toy Delete</option>
							<option value="glundercover">Undercover</option>
							<option value="glvipnamechanges">VIP Name-Changes</option>
							<option value="glvipremove">VIP Remove</option>
						</select></td>
						</tr>
						<tr><td colspan="2">CP Log Access</td>
						<td colspan="4"><select name="cpl[]" size="4" multiple="multiple">
							<option value="cplgeneral">General</option>
							<option value="cplstaff">Staff</option>
							<option value="cplfaction">Faction</option>
							<option value="cplfamily">Family</option>
							<option value="cplcr">Customer Relations</option>
						</select></td>
						</tr>
						<tr><td class="acp-actionbar" colspan="6">
							<input type="hidden" name="action" readonly="readonly" value="adduser">
							<input type="hidden" name="ip" readonly="readonly" value="<?php echo $_SERVER['REMOTE_ADDR']; ?>">
							<input type="hidden" name="admin" readonly="readonly" value="<?php echo $_SESSION['myusername']; ?>">
							<input type="submit" class="button" value="Create User">
						</td></tr>
					</form>
				</table>
			</div>
		</div>
	<?php }
	else { echo "You do not have access to this section."; } ?>