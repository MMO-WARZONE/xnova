<script src="scripts/cntchar.js" type="text/javascript"></script>
<br />
<center>
<form action="messages.php?mode=write&id={id}" method="post">
<table width="519">
<tr>
	<td class="c" colspan="2">{Send_message}</td>
</tr><tr>
	<th>{Recipient}:</th>
	<th><input type="text" name="to" size="40" value="{to}" /></th>
</tr><tr>
	<th>{Subject}:</th>
	<th><input type="text" name="subject" size="40" maxlength="40" value="{subject}" /></th>
</tr><tr>
	<th>{Class}:</th>
	<th><select name="class" size="1"><option value="2">{normal}</option><option value="3">{wichtig}</option><option value="1">{unwichtig}</option></select></th>
</tr><tr>
	<th><p>{Message}:</p>
	  <p>(<span id="cntChars">0</span> / 5000 {characters})</p></th>
	<th><textarea name="text" cols="40" rows="10" size="100" onkeyup="javascript:cntchar(5000)">{text}</textarea></th>
</tr><tr>
	<th colspan="2"><input type="submit" value="{Envoyer}" /></th>
</tr>
</table>
</form>
</center>