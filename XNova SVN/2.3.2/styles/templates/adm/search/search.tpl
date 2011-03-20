
<!-- START BLOCK : default -->
<form action="" method="get">
<input type="hidden" name="page" value="search">
<table width="300">  
    <tr>
         <td class="c" colspan="6"><h2><center>{ad_main_title}</center></h2></td>
    </tr>
    <tr>
     <th>
         <select type="hidden"name="mode">
         <option value="">{ad_sel_op}</option>
         <option value="resources">{ad_resources}</option>
         <option value="buildings">{ad_buildings}</option>
         <option value="ships">{ad_ships}</option>
         <option value="defenses">{ad_defenses}</option>
         <option value="researchs">{ad_research}</option>
         <option value="oficers">{ad_oficers}</option>
         <option value="planets">{ad_pla_moon}</option>
         <option value="users">{ad_users}</option>
         <option value="alliances">{ad_alliances}</option>
         <option value="iplog">{ad_iplog}</option>
        </select>
     </th>
</tr>
<tr>
     <td><center>{ad_id} <input type="text" name="search" size=7"></center></td>
</tr>
<tr>
     <th colspan="2"><input type="submit" value="{ad_send}"></th>
</tr>
</table>
</form>
<!-- END BLOCK : default -->
<!-- START BLOCK : resources -->
<form action="" method="post">
<input type="hidden" name="edit" value="addit">
<table width="400">
<tbody>
<tr>
	<td class="c" colspan="2"><center><h2>{ad_add_resources}</h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option value="?page=search&mode=planets&search={id}">{ad_pla_moon}</option>
     <option selected value="?page=search&mode=resources&search={id}">{ad_resources}</option>
     <option value="?page=search&mode=buildings&search={id}">{ad_buildings}</option>
     <option value="?page=search&mode=ships&search={id}">{ad_ships}</option>
     <option value="?page=search&mode=defenses&search={id}">{ad_defenses}</option>
     </select></th>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" colspan="3"><center>{ad_planet} ({id}) {name}</center></td>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" align="center">{ad_resource}</td>
	<td class="c" align="center">{ad_resources_number}</td>
	<td class="c" align="center">{ad_resources_edit}</td>
</tr><tr>
	<th>{Metal}</th>
	<th>{metal}</th>
	<th><input name="metal" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{Crystal}</td>
	<th>{crystal}</th>
	<th><input name="cristal" type="text" value="0" size="16" /></th>
</tr><tr>
	<th>{Deuterium}</td>
	<th>{deuterium}</th>
	<th><input name="deut" type="text" value="0" size="16" /></th>
</tr><tr>
	<th><br></th>
</tr><tr>
      	<th></th>
	<th><input type="Submit" value="{ad_save}" /></th>
        <th><select name="accion">
        <option value="+">{ad_add}</option>
        <option value="-">{ad_delete}</option>
        </select></th>
    </tr>
</tbody>
</table>
</form>
<!-- END BLOCK : resources -->
<!-- START BLOCK : ships -->
<form action="" method="post">
<input type="hidden" name="edit" value="addit">
<table width="400">
<tbody>
<tr>
	<td class="c" colspan="2"><center><h2>{ad_add_ships}</h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option value="?page=search&mode=planets&search={id}">{ad_pla_moon}</option>
     <option value="?page=search&mode=resources&search={id}">{ad_resources}</option>
     <option value="?page=search&mode=buildings&search={id}">{ad_buildings}</option>
     <option selected value="?page=search&mode=ships&search={id}">{ad_ships}</option>
     <option value="?page=search&mode=defenses&search={id}">{ad_defenses}</option>
     </select></th>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" colspan="3"><center>{ad_planet} ({id}) {name}</center></td>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" align="center">{ad_ship}</td>
	<td class="c" align="center">{ad_ships_number}</td>
	<td class="c" align="center">{ad_ships_edit}</td>
</tr>
<!-- START BLOCK : ships_list -->
<tr>
	<th>{name_lang}</th>
	<th>{count}</th>
	<th><input name="{name}" type="text" value="0"  size="16"/></th>
</tr>
<!-- END BLOCK : ships_list -->
<tr>
	<th><br></th>
</tr><tr>
      	<th></th>
	<th><input type="Submit" value="{ad_save}" /></th>
        <th><select name="accion">
        <option value="+">{ad_add}</option>
        <option value="-">{ad_delete}</option>
        </select></th>
    </tr>
</tbody>
</table>
</form>
<!-- END BLOCK : ships -->
<!-- START BLOCK : buildings -->
<form action="" method="post">
<input type="hidden" name="edit" value="addit">
<table width="400">
<tbody>
<tr>
	<td class="c" colspan="2"><center><h2>{ad_add_lvls_to_buildings}</h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option value="?page=search&mode=planets&search={id}">{ad_pla_moon}</option>
     <option value="?page=search&mode=resources&search={id}">{ad_resources}</option>
     <option selected value="?page=search&mode=buildings&search={id}">{ad_buildings}</option>
     <option value="?page=search&mode=ships&search={id}">{ad_ships}</option>
     <option value="?page=search&mode=defenses&search={id}">{ad_defenses}</option>
     </select></th>
</tr><tr>
	<td class="c" colspan="3"><center>{ad_planet} ({id}) {name}</center></td>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" align="center">{ad_building}</td>
	<td class="c" align="center">{ad_levels}</td>
	<td class="c" align="center">{ad_levels_edit}</td>
</tr>

<!-- START BLOCK : buildings_list -->
<tr>
	<th>{name_lang}</th>
	<th>{count}</th>
	<th><input name="{name}" type="text" value="0"  size="16"/></th>
</tr>
<!-- END BLOCK : buildings_list -->
<tr>
	<th><br></th>
</tr><tr>
      	<th></th>
	<th><input type="Submit" value="{ad_save}" /></th>
        <th><select name="accion">
        <option value="+">{ad_add}</option>
        <option value="-">{ad_delete}</option>
        </select></th>
    </tr>
</tbody>

</table>
</form>
<!-- END BLOCK : buildings -->