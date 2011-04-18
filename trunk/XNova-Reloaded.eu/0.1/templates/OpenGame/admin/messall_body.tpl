<br><br>
<center>
<script src="scripts/cntchar.js" type="text/javascript"></script>
<form action="?action=administrativeMessageToAll&amp;mode=change" method="post">
<table width="700">
<tbody>
<tr>
	<td class="c" colspan="2">Nachricht an alle Spieler Senden</td>
</tr><tr>
	<th>Betreff</th>
	<th><input name="temat" maxlength="100" size="20" value="" type="text"></th>
</tr>
<tr>
	<th colspan="2"><textarea name="text" cols="2" rows="10" style="width:700px" onkeyup="javascript:cntchar(5000)"></textarea></th>
</tr><tr>
	<td class="fett" width="300px">(<span id="cntChars">0</span> / 5000 {characters})</td>
	<td class="fett" style="text-align:right"><input type="submit" value="Absenden"></td>
</tr>
</tbody>
</table>
</form>
</center>