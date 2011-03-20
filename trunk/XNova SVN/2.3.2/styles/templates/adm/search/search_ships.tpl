<form action="" method="post">
<input type="hidden" name="edit" value="addit">
<table width="400">
<tbody>
<tr>
	<td class="c" colspan="2"><center><h2>{ad_add_ships}</h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option value="admin.php?page=editor&search=planets&id={id}">{ad_pla_moon}</option>
     <option value="admin.php?page=editor&search=resources&id={id}">{ad_resources}</option>
     <option value="admin.php?page=editor&search=buildings&id={id}">{ad_buildings}</option>
     <option selected value="admin.php?page=editor&search=ships&id={id}">{ad_ships}</option>
     <option value="admin.php?page=editor&search=defenses&id={id}">{ad_defenses}</option>
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
</tr><tr>
	<th>{ad_small_ship_cargo}</th>
	<th>{small_ship_cargo}</th>
	<th><input name="small_ship_cargo" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_big_ship_cargo}</td>
	<th>{big_ship_cargo}</th>
	<th><input name="big_ship_cargo" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_light_hunter}</td>
	<th>{light_hunter}</th>
	<th><input name="light_hunter" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_heavy_hunter}</td>
	<th>{heavy_hunter}</th>
	<th><input name="heavy_hunter" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_crusher}</td>
	<th>{crusher}</th>
	<th><input name="crusher" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_battle_ship}</td>
	<th>{battle_ship}</th>
	<th><input name="battle_ship" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_colonizer}</td>
	<th>{colonizer}</th>
	<th><input name="colonizer" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_recycler}</td>
	<th>{recycler}</th>
	<th><input name="recycler" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_spy_sonde}</td>
	<th>{spy_sonde}</th>
	<th><input name="spy_sonde" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_bomber_ship}</td>
	<th>{bomber_ship}</th>
	<th><input name="bomber_ship" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_solar_satelit}</td>
	<th>{solar_satelit}</th>
	<th><input name="solar_satelit" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_destructor}</td>
	<th>{destructor}</th>
	<th><input name="destructor" type="text" value="0" size="16" /></th>
</tr><tr>
	<th>{ad_dearth_star}</td>
	<th>{dearth_star}</th>
	<th><input name="dearth_star" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_battleship}</td>
	<th>{battleship}</th>
	<th><input name="battleship" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_supernova}</td>
	<th>{supernova}</th>
	<th><input name="supernova" type="text" value="0"  size="16"/></th>
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
</tr>
</table>
</form>