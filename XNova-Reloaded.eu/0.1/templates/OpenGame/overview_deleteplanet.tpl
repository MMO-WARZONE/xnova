<br>
<center>
<h1 style="color:#FFFFFF">{colony_abandon}</h1>
<form action="?action=internalHome&amp;mode=loeschen&amp;pl={planet_id}" method=POST>
<table width="700">
<tr>
	<td class=c colspan=2>{security_query}</td>
</tr><tr>
	<th colspan=2>{confirm_planet_delete}  {confirmed_with_password}</th>
</tr><tr>
	<th>{coords}</th>
	<th>{galaxy_galaxy}:{galaxy_system}:{galaxy_planet}</th>
</tr><tr>
	<th>{name}</th>
	<th>{planet_name}</th>
</tr><tr>
	<th>{password}</th>
	<th><input type=password name=pw></th>
</tr>
<tr>
	<th colspan="2"><input type=submit name=action value="{deleteplanet}" alt="{colony_abandon}"><input type="hidden" name="kolonieloeschen" value="1"></th>
</tr>
</table>
<input type=hidden name=deleteid value ="{planet_id}">
</form>
</center>