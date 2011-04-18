<br><br>
<center>
<h2>{del_title}</h2>
<form action="?action=administrativeMatsDelBuildings" method="post">
<input type="hidden" name="mode" value="addit">
<table width="700">
<tbody>
<tr>
	<td class="c" colspan="3">{del_buildings_form}</td>
</tr><tr>
	<th width="20"></th>
	<th width="130">{planet_id}</th>
	<th width="550"><input name="id" type="text" value="0"></th>
</tr><tr>
	<td class="c" colspan="3">&nbsp;</td>
</tr><tr>
	<th>{id}</th>
	<th>{building_typ}</th>
	<th>{del}</th>
</tr><tr>
	<th>1</th>
	<th>{metal_mine}</th>
	<th><input name="metal_mine" type="text" value="0"></th>
</tr><tr>
	<th>2</th>
	<th>{crystal_mine}</th>
	<th><input name="crystal_mine" type="text" value="0"></th>
</tr><tr>
	<th>3</th>
	<th>{deuterium_sintetizer}</th>
	<th><input name="deuterium_sintetizer" type="text" value="0"></th>
</tr><tr>
	<th>4</th>
	<th>{solar_plant}</th>
	<th><input name="solar_plant" type="text" value="0"></th>
</tr><tr>
	<th>5</th>
	<th>{fusion_plant}</th>
	<th><input name="fusion_plant" type="text" value="0"></th>
</tr><tr>
	<th>6</th>
	<th>{robot_factory}</th>
	<th><input name="robot_factory" type="text" value="0"></th>
</tr><tr>
	<th>7</th>
	<th>{nano_factory}</th>
	<th><input name="nano_factory" type="text" value="0"></th>
</tr><tr>
	<th>8</th>
	<th>{hangar}</th>
	<th><input name="hangar" type="text" value="0"></th>
</tr><tr>
	<th>9</th>
	<th>{metal_store}</th>
	<th><input name="metal_store" type="text" value="0"></th>
</tr><tr>
	<th>10</th>
	<th>{crystal_store}</th>
	<th><input name="crystal_store" type="text" value="0"></th>
</tr><tr>
	<th>11</th>
	<th>{deuterium_store}</th>
	<th><input name="deuterium_store" type="text" value="0"></th>
</tr><tr>
	<th>12</th>
	<th>{laboratory}</th>
	<th><input name="laboratory" type="text" value="0"></th>
</tr><tr>
	<th>13</th>
	<th>{terraformer}</th>
	<th><input name="terraformer" type="text" value="0"></th>
</tr><tr>
	<th>14</th>
	<th>{ally_deposit}</th>
	<th><input name="ally_deposit" type="text" value="0" /></th>
</tr><tr>
	<th>15</th>
	<th>{silo}</th>
	<th><input name="silo" type="text" value="0"></th>
</tr><tr>
	<th colspan="3"><input type="Submit" value="{del}"></th>
</tr><tr>
	<td class="c" colspan="3"><a href="?action=administrativeMats">{back}</a></td>
</tr>
</tbody>
</table>
</form>
</center>