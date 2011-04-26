<br />
<form action="" method="post">
<table width="400">
<tr>
	<td class="c" colspan="2">{bo_ban_player}</td>
</tr><tr>
	<th width="200">{bo_username}</th>
	<th width="200"><input name="ban_name" type="text" size="25" /></th>
</tr><tr>
	<th>{bo_reason}</th>
	<th><input name="why" type="text" value="" size="25" maxlength="50"></th>
</tr><tr>
	<td class="c" colspan="2">{bo_time}</td>
</tr><tr>
	<th>{bo_days}</th>
	<th><input name="days" type="text" value="0" size="5" /></th>
</tr><tr>
	<th>{bo_hours}</th>
	<th><input name="hour" type="text" value="0" size="5" /></th>
</tr><tr>
	<th>{bo_minutes}</th>
	<th><input name="mins" type="text" value="0" size="5" /></th>
</tr><tr>
	<th>{bo_seconds}</th>
	<th><input name="secs" type="text" value="0" size="5" /></th>
</tr><tr>
	<th>{bo_vacation_mode}</th>
	<th><input name="vacat" type="checkbox"/></th>
</tr><tr>
	<th colspan="2"><input type="submit" value="{bo_ban_player_button}" /></th>
</tr>
</table>
</form>
<br />
<form action="" method="post">
<table width="400">
<tr>
	<td class="c" colspan="2">{bo_unban_player}</td>
</tr><tr>
	<th width="200">{bo_username}</th>
	<th width="200"><input name="unban_name" maxlength="80" size="25" value="" type="text"></th>
</tr><tr>
	<th colspan="2"><input value="{bo_unban_button}" type="submit"></th>
</tr>
</table>
</form>