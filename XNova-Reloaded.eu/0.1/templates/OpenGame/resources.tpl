<br>
<center>
<form method="post">
	<table width="700">
	<tbody>
		<tr>
		  <td class="c" colspan="6" height="21">{Production_of_resources_in_the_planet}</td>
		</tr>
		<tr>
		  <th height="22">&nbsp;</th>
		  <th height="22">{Metal}</th>
		  <th height="22">{Crystal}</th>
		  <th height="22">{Deuterium}</th>
		  <th height="22">{Energy}</th>
		  <th height="22">&nbsp;</th>
		</tr>
		<tr>
		  <th height="22">{Basic_income}</th>
		  <td class="k" height="22">{metal_basic_income}</td>
		  <td class="k" height="22">{crystal_basic_income}</td>
		  <td class="k" height="22">{deuterium_basic_income}</td>
		  <td class="k" height="22">{energy_basic_income}</td>
		  <th height="22">&nbsp;</th>
		</tr>
			{resource_row}
		<tr>
		  <th height="22">{Stores_capacity}</th>
		  <td class="k" height="22">{metal_max}</td>
		  <td class="k" height="22">{crystal_max}</td>
		  <td class="k" height="22">{deuterium_max}</td>
		  <td class="k" height="22"><font color="#00ff00">{energy_total}</font></td>
		  <td class="k" height="22"><input name="action" value="{Calcule}" type="submit"></td>
		</tr>
	</tbody>
	</table>
	
	<div>
	<br>
	<table width="700">
	<tbody>
		<tr>
		  <td class="c" colspan="5" height="21">{Widespread_production}</td>
		</tr>
		<tr>
		  <th height="22">&nbsp;</th>
		<th height="22">{Hour}</th>
		  <th height="22">{Daily}</th>
		  <th height="22">{Weekly}</th>
		  <th height="22">{Monthly}</th>
		</tr>
		<tr>
		  <th height="22">{Metal}</th>
		  <th height="22">{metal_total}</th>
		  <th height="22">{daily_metal}</th>
		  <th height="22">{weekly_metal}</th>
		  <th height="22">{monthly_metal}</th>
		</tr>
		<tr>
		  <th height="22">{Crystal}</th>
		  <th height="22">{crystal_total}</th>
		  <th height="22">{daily_crystal}</th>
		  <th height="22">{weekly_crystal}</th>
		  <th height="22">{monthly_crystal}</th>
		</tr>
		<tr>
		  <th height="22">{Deuterium}</th>
		  <th height="22">{deuterium_total}</th>
		  <th height="22">{daily_deuterium}</th>
		  <th height="22">{weekly_deuterium}</th>
		  <th height="22">{monthly_deuterium}</th>
		</tr>
	</tbody>
	</table>
	
	<br>
	
	<table width="700">
	<tbody>
		<tr>
		  <td class="c" colspan="3" height="21">{Storage_state}</td>
		</tr>
		<tr>
		  <th height="22">{Metal}</th>
		  <th height="22">{metal_storage}</th>
		  <th width="250" height="22">
			<div style="border: 1px solid rgb(153, 153, 255); width: 250px;">
			<div id="AlmMBar" style="background-color: {metal_storage_barcolor}; width: {metal_storage_bar}px;">
			&nbsp;
			</div>
			</div>
		</th>
		</tr>
		<tr>
		  <th height="22">{Crystal}</th>
		  <th height="22">{crystal_storage}</th>
		  <th width="250" height="22">
			<div style="border: 1px solid rgb(153, 153, 255); width: 250px;">
			<div id="AlmCBar" style="background-color: {crystal_storage_barcolor}; width: {crystal_storage_bar}px; opacity: 0.98;">
			&nbsp;
			</div>
			</div>
		  </th>
		</tr>
		<tr>
		  <th height="22">{Deuterium}</th>
		  <th height="22">{deuterium_storage}</th>
		  <th width="250" height="22">
			<div style="border: 1px solid rgb(153, 153, 255); width: 250px;">
			<div id="AlmDBar" style="background-color: {deuterium_storage_barcolor}; width: {deuterium_storage_bar}px;">
			&nbsp;
			</div>
			</div>
		  </th>
			<tr>
		  <th height="22">{Production_level}</th>
		  <th height="22">{production_level}</th>
		  <th width="250" height="22">
			<div style="border: 1px solid rgb(153, 153, 255); width: 250px;">
			<div id="AlmDBar" style="background-color: {production_level_barcolor}; width: {production_level_bar}px;">
			&nbsp;
			</div>
			</div>
		  </th>
		</tr>
	</tbody>
	</table>
	</div>
</form>
<script language="JavaScript" src="scripts/wz_tooltip.js"></script>