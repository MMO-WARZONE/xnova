<script src="scripts/cntchar.js" type="text/javascript"></script>
<div align="center">
<form action="?action=internalMessages&amp;mode=write&amp;id={id}" method="post">
<table width="700" align="center">
<tr>
	<td class="c" colspan="2">{Send_message}</td>
</tr><tr>
	<td class="fett" width="300px">{Recipient}:</td>
	<td class="fett">{to}</td>
</tr><tr>
	<td class="fett" width="300px">{Subject}:</td>
	<td class="fett"><input type="text" name="subject" style="width:391px" maxlength="50" value="{subject}"></td>
</tr><tr>
	<td class="fett" width="300px">{Class}:</td>
	<td class="fett"><select style="width:391px" name="class" size="1"><option value="2">{normal}</option><option value="3">{wichtig}</option><option value="1">{unwichtig}</option></select></td>
</tr><tr>
	<th colspan="2"><textarea name="text" cols="2" rows="10" style="width:700px" onkeyup="javascript:cntchar(5000)">{text}</textarea></th>
</tr><tr>
	<td class="fett" width="300px">(<span id="cntChars">0</span> / 5000 {characters})</td>
	<td class="fett" style="text-align:right"><input type="submit" value="{Envoyer}"></td>
</tr>
</table>
</form>
</div>