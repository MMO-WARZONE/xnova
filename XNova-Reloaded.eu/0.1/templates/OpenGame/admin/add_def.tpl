<br><br>
<center>
<h2>{add_title}</h2>
<form action="?action=administrativeMatsAddDef" method="post">
<input type="hidden" name="mode" value="addit">
<table width="700">
<tbody>
<tr>
	<td class="c" colspan="3">{add_def_form}</td>
</tr><tr>
	<th width="20">&nbsp;</th>
	<th width="130">{planet_id}</th>
	<th width="550"><input name="id" type="text" value="0"></th>
</tr><tr>
	<td class="c" colspan="3">&nbsp;</td>
</tr><tr>
	<th>{ID}</th>
	<th>{def_typ}</th>
	<th>{hinz}</th>
</tr><tr>
	<th>1</th>
	<th>{misil_launcher}</th>
	<th><input name="misil_launcher" type="text" value="0"></th>
</tr><tr>
	<th>2</th>
	<th>{small_laser}</th>
	<th><input name="small_laser" type="text" value="0"></th>
</tr><tr>
	<th>3</th>
	<th>{big_laser}</th>
	<th><input name="big_laser" type="text" value="0"></th>
</tr><tr>
	<th>4</th>
	<th>{gauss_canyon}</th>
	<th><input name="gauss_canyon" type="text" value="0"></th>
</tr><tr>
	<th>5</th>
	<th>{ionic_canyon}</th>
	<th><input name="ionic_canyon" type="text" value="0"></th>
</tr><tr>
	<th>6</th>
	<th>{buster_canyon}</th>
	<th><input name="buster_canyon" type="text" value="0"></th>
</tr><tr>
	<th>7</th>
	<th>{small_protection_shield}</th>
	<th><input name="small_protection_shield" type="text" value="0"></th>
</tr><tr>
	<th>8</th>
	<th>{big_protection_shield}</th>
	<th><input name="big_protection_shield" type="text" value="0"></th>
</tr><tr>
	<th>9</th>
	<th>{interceptor_misil}</th>
	<th><input name="interceptor_misil" type="text" value="0"></th>
</tr><tr>
	<th>10</th>
	<th>{interplanetary_misil}</th>
	<th><input name="interplanetary_misil" type="text" value="0"></th>
</tr><tr>
	<th colspan="3"><input type="Submit" value="{hinz}"></th>
</tr><tr>
	<td class="c" colspan="3"><a href="?action=administrativeMats">{back}</a></td>
</tr>
</tbody>
</table>
</form>
</center>