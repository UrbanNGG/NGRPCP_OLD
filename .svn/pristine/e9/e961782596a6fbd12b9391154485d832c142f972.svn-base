	<div id='content_wrap'>
		<ol id='breadcrumb'><li>Requests > Add Request</li></ol>
		<div class='section_title'><h2>Add Request</h2></div>

		<div class='acp-box'>
		<h3>Request Submission</h3>

			<table cellpadding="0" cellspacing="0" border="0" width="100%">
				<form method="POST" action="request/proc.php">
					<tr class="tablerow1"><td width="50%" align="center">Category</td>
						<td align="center"><select name="ngen_cat">
							<option selected value="In-Game">In-Game</option>
							<option value="Forum">Forums</option>
							<option value="CMS">CMS</option>
							<option value="TeamSpeak">TeamSpeak</option>
							<option value="Other">Other</option>
						</select></td>
					</tr>
					<tr><td align="center">Request</td><td align="center"><input type="text" name="nnote" length="64"></td></tr>
					<tr class="acp-actionbar"><td colspan="2" align="center">
						<input type="hidden" name="ip" readonly="readonly" value='.$_SERVER["REMOTE_ADDR"].'>
						<input type="hidden" name="action" readonly="readonly" value="gen_request">
						<input type="hidden" name="admin" readonly="readonly" value='.$_SESSION["myusername"].'>
						<input type="submit" value="Submit Request">
					</td></tr>
				</form>
			</table>
	</div></div>