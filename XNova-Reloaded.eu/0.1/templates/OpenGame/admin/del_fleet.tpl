<br><br>
<center>
<h2>{title}</h2>
<form action="?action=administrativeMatsDelFleet" method="post">
<input type="hidden" name="mode" value="del">
<table width="700">
<tbody>
<tr>
	<td class="c" colspan="3">{del_ship_form}</td>
</tr><tr>
	<th width="20">&nbsp;</th>
	<th width="130">{planet_id}</th>
	<th width="550"><input name="id" type="text" value="0" /></th>
</tr><tr>
	<td class="c" colspan="3">&nbsp;</td>
</tr><tr>
	<th>{ID}</th>
	<th>{ship_typ}</th>
	<th>{entf}</th>
</tr><tr>
	<th>1</td>
	<th>{kt}</th>
	<th><input name="small_ship_cargo" type="text" value="0" /></th>
</tr><tr>
	<th>2</td>
	<th>{gt}</td>
	<th><input name="big_ship_cargo" type="text" value="0" /></th>
</tr><tr>
	<th>3</td>
	<th>{lj}</td>
	<th><input name="light_hunter" type="text" value="0" /></th>
</tr><tr>
	<th>4</td>
	<th>{sj}</td>
	<th><input name="heavy_hunter" type="text" value="0" /></th>
</tr><tr>
	<th>5</td>
	<th>{kr}</td>
	<th><input name="crusher" type="text" value="0" /></th>
</tr><tr>
	<th>6</td>
	<th>{ss}</td>
	<th><input name="battle_ship" type="text" value="0" /></th>
</tr><tr>
	<th>7</td>
	<th>{kolo}</td>
	<th><input name="colonizer" type="text" value="0" /></th>
</tr><tr>
	<th>8</td>
	<th>{rec}</td>
	<th><input name="recycler" type="text" value="0" /></th>
</tr><tr>
	<th>9</td>
	<th>{spio}</td>
	<th><input name="spy_sonde" type="text" value="0" /></th>
</tr><tr>
	<th>10</td>
	<th>{bomb}</td>
	<th><input name="bomber_ship" type="text" value="0" /></th>
</tr><tr>
	<th>11</td>
	<th>{solar}</td>
	<th><input name="solar_satelit" type="text" value="0" /></th>
</tr><tr>
	<th>12</td>
	<th>{zerri}</td>
	<th><input name="destructor" type="text" value="0" /></th>
</tr><tr>
	<th>13</td>
	<th>{rip}</td>
	<th><input name="dearth_star" type="text" value="0" /></th>
</tr><tr>
	<th>14</td>
	<th>{sk}</td>
	<th><input name="battleship" type="text" value="0" /></th>
</tr><tr>
	<th colspan="3"><input type="Submit" value="{entf}" /></th>
</tr>
<tr>
	<td class="c" colspan="3"><a href="?action=administrativeMats">{back}</a></td>
</tr>
</tbody>
</table>
</form>
</center>