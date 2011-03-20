
<table width="400">
<tr>
	<td class="c" colspan="6">{pl_list}</td>
</tr>
<tr>
	<th>{pl_id}</th>
	<th>{pl_name}</th>
	<th>{mt_moon_owner}</th>
	<th>{pl_galaxy}</th>
	<th>{pl_system}</th>
	<th>{pl_planet}</th>
</tr>
<!-- START BLOCK : lista_planetas-->
<tr>
	<th>{id}</th>
	<th><a href=admin.php?page=search&mode=planets&search={id}>{name}</a></th>
	<th>{username}</th>
	<th>{galaxy}</th>
	<th>{system}</th>
	<th>{planet}</th>
</tr>
<!-- END BLOCK : lista_planetas -->
{planets_list}
</table>