<center>
</table>
<form action="overview.php?mode=renameplanet&pl={planet_id}" method=POST>
<table width=519>
<tr>
	<td class=c colspan=3>{ov_rena_dele}</td>
</tr>
<tr >
	<th>{security_query}</th>
	<th colspan=2>{confirm_planet_delete} {galaxy_galaxy}:{galaxy_system}:{galaxy_planet} {confirmed_with_password}</th>
</tr><tr>
	<th>{password}</th>
	<th><input type=password name=pw></th>
	<th><input type=submit name=action value="{deleteplanet}" alt="{colony_abandon}"></th><input type="hidden" name="kolonieloeschen" value="1">
</tr>
</table>
<input type=hidden name=deleteid value ="{planet_id}">
</form>
</center>
