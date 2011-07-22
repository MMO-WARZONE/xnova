
<script src="scripts/cntchar.js" type="text/javascript"></script>
<script src="scripts/win.js" type="text/javascript"></script>
<center>
<form action="buddy.php" method="post">
<input type="hidden" name="a" value="1">
<input type="hidden" name="s" value="3">
<input type="hidden" name="e" value="1">
<input type="hidden" name="u" value="{id}">
<table width="519">
	<tr>
		<td class="c" colspan="2">{Buddy_request}</td>
	</tr><tr>
		<th>{Player}</th>
		<th>{username}</th>
	</tr><tr>
		<th>{Request_text} (<span id="cntChars">0</span> / 5000 {characters})</th>
		<th><textarea name="text" cols="60" rows="10" onKeyUp="cntchar(5000);"></textarea></th>
	</tr><tr>
		<td class="c"><a href="javascript:back();">{Back}</a></td>
		<td class="c"><input type="submit" value="{Send}"></td>
	</tr>
</table>
</form>
</center>