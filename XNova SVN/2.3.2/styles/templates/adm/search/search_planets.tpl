<form action="" method="post">
<input type="hidden" name="edit" value="addit">
<table width="45%">

<tr>
	<td class="c" colspan="2"><center><h2>{ad_edit_planets}</h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option selected value="admin.php?page=editor&search=planets&id={id}">{ad_pla_moon}</option>
     <option value="admin.php?page=editor&search=resources&id={id}">{ad_resources}</option>
     <option value="admin.php?page=editor&search=buildings&id={id}">{ad_buildings}</option>
     <option value="admin.php?page=editor&search=ships&id={id}">{ad_ships}</option>
     <option value="admin.php?page=editor&search=defenses&id={id}">{ad_defenses}</option>
     </select></th>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" colspan="3"><center>{ad_planet} ({id}) {name} [{galaxy}:{system}:{planet}]</center></td>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" align="center">{ad_acction}</td>
	<td class="c" align="center">{ad_value}</td>
</tr><tr>
	<th>{ad_planet_name}</th>
	<th>{name}</th>
	<th><input name="name" type="text" size="18"/></th>
</tr><tr>
	<th>{ad_planet_diameter}</th>
	<th>{diameter}</th>
	<th><input name="diameter" type="text" size="18"/></th>
</tr><tr>
	<th>{ad_planet_fields}</th>
	<th>{field_max}</th>
	<th><input name="fields" type="text" size="18"/></th>
</tr><tr>
	<th>{ad_t_min}</th>
	<th>{temp_min}</th>
	<th><input name="temp_min" type="text" size="18"/></th>
</tr><tr>
	<th>{ad_t_max}</th>
	<th>{temp_max}</th>
	<th><input name="temp_max" type="text" size="18"/></th>
</tr><tr>
	<th><a onMouseOver="return overlib('{ad_position_planet_desc}', BELOW, CENTER, WIDTH, 350, CAPTION, 'Alerta!',BGCOLOR,'#344566', FGCOLOR,'#344566',TEXTCOLOR,'white',CLOSECOLOR,'lime', CAPCOLOR,'red');" onMouseOut="return nd();" class="big">{ad_position_planet} (*)</a></th>
        <th>{galaxy}:{system}:{planet}</th>
	<th><input name="change_position" type="checkbox" title="{ad_pla_change_pp}"/>
	<input name="g" type="text" size="1" maxlength="1"/> :
	<input name="s" type="text" size="1" maxlength="3"/> :
	<input name="p" type="text" size="1" maxlength="2"/></th>
</tr><tr>
	<td class="c" colspan="7"><center>{ad_del}</center></td>
</tr><tr>
	<th><br></th>
</tr><tr>
	<th>{ad_del_hd}</th>
	<th>{b_hangar_id}</th>
	<th><input name="0_c_hangar" type="checkbox"/></th>
</tr><tr>
	<th>{ad_del_cb}</th>
	<th>{b_building_id}</th>
	<th><input name="0_c_buildings" type="checkbox"/></th>
</tr><tr>
	<th>{ad_del_b}</th>
	<th></th>
	<th><input name="0_buildings" type="checkbox"/></th>
</tr><tr>
	<th>{ad_del_s}</th>
	<th></th>
	<th><input name="0_ships" type="checkbox"/></th>
</tr><tr>
	<th>{ad_del_d}</th>
	<th></th>
	<th><input name="0_defenses" type="checkbox"/></th>
</tr><tr>
	<th>{ad_del_planet}</th>
	<th>({id}) {name} [{galaxy}:{system}:{planet}]</th>
	<th><input name="delete" type="checkbox"/></th>
</tr><tr>
	<th colspan="3"><input type="Submit" value="{ad_save}"/>&nbsp;
	<input type="reset" value="Reset"/></th>
</tr>
</table>
</form>
