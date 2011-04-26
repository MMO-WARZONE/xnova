<br />
<form action="" method="post">
<input type="hidden" name="opt_save" value="1">
<table width="519" cellpadding="2" cellspacing="2">
<tr>
	<td class="c" colspan="2">{se_server_parameters}</td>
</tr><tr>
	<th>Teamspeak-Mod aktivieren?<br /></th>
	<th><input name="ts_on" {ts_on} type="checkbox" /></th>
</tr><tr>
	<th>Server-IP:</th>
	<th><input name="ts_ip" maxlength="15" size="10" value="{ts_ip}" type="text"></th>
</tr><tr>
	<th>TCP-Port:</th>
	<th><input name="ts_tcp" maxlength="5" size="10" value="{ts_tcp}" type="text"></th>
</tr><tr>
	<th>UDP-Port:</th>
	<th><input name="ts_udp" maxlength="5" size="10" value="{ts_udp}" type="text"></th>
</tr><tr>
	<th>Server Timeout:</th>
	<th><input name="ts_to" maxlength="2" size="10" value="{ts_to}" type="text"></th>
</tr></tr>
	<th colspan="3"><input value="{se_save_parameters}" type="submit"></th>
</tr>
</table>
</form>