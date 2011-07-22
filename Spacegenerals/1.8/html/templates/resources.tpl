<br>
<form action="" method="post">
<table width="569">
<tbody>
<tr>
<td class="c" colspan="6" align="left">{Production_of_resources_in_the_planet}</td>	
</tr><tr>
	<th height="22"></th>
	<th width="60">{Metal}</th>
	<th width="60">{Crystal}</th>
	<th width="60">{Deuterium}</th>
	<th width="60">{Energy}</th>
	<td class="k"></td>
</tr><tr>
	<th height="22"><p align="left">{Basic_income}</p></th>
	<td class="k">{metal_basic_income}</td>
	<td class="k">{crystal_basic_income}</td>
	<td class="k">{deuterium_basic_income}</td>
	<td class="k">{energy_basic_income}</td>
	<td class="k"></td>
</tr>
{resource_row}
<tr>
    <th height="22"><p align="left">{Energiebonus}</p></th>
    <td class="k"><font color="#ffffff">-</font></td>
    <td class="k"><font color="#ffffff">-</font></td>
    <td class="k"><font color="#ffffff">-</font></td>
    <td class="k">{energy_tech_bonus}</td>
    <td class="k"><input name="action" value="{Calcule}" type="submit"></td>
</tr><tr>
    <th height="22"><p align="left">{officier_bonus}</p></th>
  	<td class="k">{metal_offi_bonus}</td>
  	<td class="k">{crystal_offi_bonus}</td>
  	<td class="k">{deuterium_offi_bonus}</td>
  	<td class="k">{energy_offi_bonus}</td>
  	<td class="k"></td>
</tr><tr>
  	<th height="22"><p align="left">{Stores_capacity}</p></th>
  	<td class="k">{metal_max}</td>
  	<td class="k">{crystal_max}</td>
  	<td class="k">{deuterium_max}</td>
  	<td class="k"><font color="#00ff00">-</font></td>
  	<td class="k"></td>
</tr>




<tr>
	<th height="22"><p align="left">Total:</p></th>
	<td class="k">{metal_total}</td>
	<td class="k">{crystal_total}</td>
	<td class="k">{deuterium_total}</td>
	<td class="k">{energy_total}</td>
  <td class="k"></td>
</tr>
</tbody>
</table>
</form>
<br />
<table width="569">
<tbody>
<tr>
<td class="c" colspan="6" align="left">{Storage_state}</td>
</tr><tr>
	<th><p align="left">{Metal}</p></th>
	<th>{metal_storage}</th>
	<th width="250">
		<div style="border: 1px solid rgb(153, 153, 255); width: 250px;">
		<div id="AlmMBar" style="background-color: {metal_storage_barcolor}; width: {metal_storage_bar}px;">
		&nbsp;
		</div>
		</div>
	</th>
</tr><tr>
	<th><p align="left">{Crystal}</p></th>
	<th>{crystal_storage}</th>
	<th width="250">
		<div style="border: 1px solid rgb(153, 153, 255); width: 250px;">
		<div id="AlmCBar" style="background-color: {crystal_storage_barcolor}; width: {crystal_storage_bar}px; opacity: 0.98;">
		&nbsp;
		</div>
		</div>
	</th>
</tr><tr>
	<th><p align="left">{Deuterium}</p></th>
	<th>{deuterium_storage}</th>
	<th width="250">
		<div style="border: 1px solid rgb(153, 153, 255); width: 250px;">
		<div id="AlmDBar" style="background-color: {deuterium_storage_barcolor}; width: {deuterium_storage_bar}px;">
		&nbsp;
		</div>
		</div>
	</th>
</tr>
</tbody>
</table>
<br />
<table width="569">
<tbody>
<tr>
<td class="c" colspan="6" align="left">{Widespread_production}</td>
</tr><tr>
	<th>&nbsp;</th>
	<th>St&uuml;ndlich</th>
	<th>{Daily}</th>
	<th>{Weekly}</th>
	<th>{Monthly}</th>
</tr><tr>
	<th><p align="left">{Metal}</p></th>
	<th>{metal_total}</th>
	<th>{daily_metal}</th>
	<th>{weekly_metal}</th>
	<th>{monthly_metal}</th>
</tr><tr>
	<th><p align="left">{Crystal}</p></th>
	<th>{crystal_total}</th>
	<th>{daily_crystal}</th>
	<th>{weekly_crystal}</th>
	<th>{monthly_crystal}</th>
</tr><tr>
	<th><p align="left">{Deuterium}</p></th>
	<th>{deuterium_total}</th>
	<th>{daily_deuterium}</th>
	<th>{weekly_deuterium}</th>
	<th>{monthly_deuterium}</th>
</tr>
</tbody>
</table>
<br />

<table width="569">
<tbody>
<tr>
<td class="c" colspan="6" align="left">{ship_production}</td>
</tr><tr>
   <th>&nbsp;</th>
   <th>{Daily}</th>
   <th>{Weekly}</th>
   <th>{Monthly}</th>
</tr>
{predu_fleet}
<tr>
<td class="c" colspan="6" align="left">{deffend_production}</td>
</tr><tr>
   <th>&nbsp;</th>
   <th>{Daily}</th>
   <th>{Weekly}</th>
   <th>{Monthly}</th>
</tr>
</tr>
{predu_def}
<tr>
</tbody>
</table>
<br /><br />
