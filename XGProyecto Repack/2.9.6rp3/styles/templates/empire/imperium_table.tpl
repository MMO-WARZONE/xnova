<div id="content">
<table border="0" cellpadding="0" cellspacing="1" width="750">
<tbody>
<tr height="20" valign="left">
	<td class="c" colspan="{mount}">{imperium_vision}</td>
</tr><tr height="75">
	<th width="100" colspan="2"><form action="game.php" method="get"><input type="hidden" name="page" value="imperium"/><select name="planet_type"><option value="0"{select0}>Todos</option><option value="1"{select1}>Planetas</option><option value="3"{select3}>Lunas</option></select><br/><input type="submit" value="Ver" /></form></th>
	{file_images}
</tr><tr height="20">
	<th width="100" colspan="2">{name}</th>
	{file_names}
</tr><tr height="20">
	<th width="100" colspan="2">Tipo</th>
	{file_type}
</tr><tr height="20">
	<th width="100" colspan="2">{coordinates}</th>
	{file_coordinates}
</tr><tr height="20">
	<th width="100" colspan="2">Campos</th>
	{file_fields}
</tr><tr height="20">
	<th width="100" colspan="2">Construcción</th>
	{build}
</tr><tr height="20">
	<td class="c" colspan="{mount}" align="left">{resources}</td>
</tr><tr height="20">
	<th width="100" colspan="2">{Metal}</th>
	{file_metal}
</tr><tr height="20">
	<th width="100" colspan="2">{Crystal}</th>
	{file_crystal}
</tr><tr height="20">
	<th width="100" colspan="2">{Deuterium}</th>
	{file_deuterium}
</tr><tr height="20">
	<th width="100" colspan="2">{Tritium}</th>
	{file_tritium}
</tr><tr height="20">
	<th width="100" colspan="2">{Energy}</th>
	{file_energy}
</tr><tr height="20">
	<td class="c" colspan="{mount}" align="left">{buildings}</td>
</tr>
	<!-- Lista de edificios -->
	{building_row}
<tr height="20">
	<td class="c" colspan="{mount}" align="left">{investigation}</td>
</tr>
	<!-- Lista de tecnologias -->
	{technology_row}
<tr height="20">
	<td class="c" colspan="{mount}" align="left">{ships}</td>
</tr>
	<!-- Lista de naves -->
	{fleet_row}
<tr height="20">
	<td class="c" colspan="{mount}" align="left">{defense}</td>
</tr>
	<!-- Lista de defensas -->
	{defense_row}
</tbody>
</table>
</div>
