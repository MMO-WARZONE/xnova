<script src="scripts/cntchar.js" type="text/javascript"></script>
	<center>
		<!-- START BLOCK : title -->
			<table>
				<tr>
					<th class=c colspan=6 align="center">{bu_buddy_list}</th>
				</tr>
				<!-- START BLOCK : anuncio -->
				<tr>
					<th class=c colspan=6 align="center">{bu_no_exists}</th>
				</tr>
				<!-- END BLOCK : anuncio -->
			</table>
		<!-- END BLOCK : title -->
		<!-- START BLOCK : newbuddy -->
			<form action="game.php?page=buddy&mode=1&sm=3" method="post">
				<input type="hidden" name="u" value="{u}">
					<table width="520">
						<tr>
							<td class="c" colspan="2">{bu_request_message}</td>
						</tr>
						<tr>
							<th>{bu_player}</th><th>{username}</th>
						</tr>
						<tr>
							<th>{bu_request_text} (<span id="cntChars">0</span>
							 / 5000 {bu_characters})</th>
							<th>
								<textarea name="text" cols="60" rows="10" onKeyUp="javascript:cntchar(5000)"></textarea>
							</th>
							
						</tr>
						
						<tr>
							<td class="c"><a href="javascript:back();">{bu_back}</a></td><td class="c"><input type="submit" value='{bu_send}' /></td>
						</tr>
					</table>
			</form>
			<!-- END BLOCK : newbuddy -->
			
			
			
			<!-- START BLOCK : buddy -->
			<table width=520>
			
				<tr>
					<td class=c colspan=6><center>{tipo}</center></td>
				</tr>
				<tr>
					<td class=c>{bu_player}</td>
					<td class=c>{bu_alliance}</td>
					<td class=c>{bu_coords}</td>
					<td class=c>{texts1}</td>
					<td class=c>{bu_action}</td>
				</tr>
				<!-- START BLOCK : listbuddy -->
				<tr>
					<th><a onclick="new_mensaje('{username}','{id}','Sin Asunto','')" href="#">{username}</a></th>
					<th><a href="game.php?page=alliance&mode=ainfo&a={ally_id}">{ally_name}</a></th>
					<th><a href="game.php?page=galaxy&mode=3&galaxy={galaxy}&system={system}">{galaxy}:{system}:{planet}</a></th>
					<th><font color="{color}">{texts2}</font></th>
					<th>{actions}</th>
				</tr>
				<!-- END BLOCK : listbuddy -->
				
			</table>
			<!-- END BLOCK : buddy -->