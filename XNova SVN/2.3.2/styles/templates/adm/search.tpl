
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
      <option selected value="">{ad_user_planets}</option>
<!-- START BLOCK : lista_colos_resources-->
     <option value="admin.php?page=search&mode=resources&search={id}">{name}[{galaxy}:{system}:{planet}]</option>
<!-- END BLOCK : lista_colos_resources -->
     </select></th>
</tr><tr>
	<td class="c" colspan="2"><center><h2></h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option value="admin.php?page=search&mode=planets&search={id}">{ad_pla_moon}</option>
     <option selected value="admin.php?page=search&mode=resources&search={id}">{ad_resources}</option>
     <option value="admin.php?page=search&mode=buildings&search={id}">{ad_buildings}</option>
     <option value="admin.php?page=search&mode=ships&search={id}">{ad_ships}</option>
     <option value="admin.php?page=search&mode=defenses&search={id}">{ad_defenses}</option>
     </select></th>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" colspan="3"><center>{ad_planet} ({id}) {name} [{galaxy}:{system}:{planet}]</center></td>
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
<!-- START BLOCK : buildings -->
<form action="" method="post">
<input type="hidden" name="edit" value="addit">
<table width="400">
<tbody>
<tr>
	<td class="c" colspan="2"><center><h2>{ad_add_lvls_to_buildings}</h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option selected value="">{ad_user_planets}</option>
<!-- START BLOCK : lista_colos_buildings -->
     <option value="admin.php?page=search&mode=buildings&search={id}">{name}[{galaxy}:{system}:{planet}]</option>
<!-- END BLOCK : lista_colos_buildings -->
     </select></th>
</tr><tr>
	<td class="c" colspan="2"><center><h2></h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option value="admin.php?page=search&mode=planets&search={id}">{ad_pla_moon}</option>
     <option value="admin.php?page=search&mode=resources&search={id}">{ad_resources}</option>
     <option selected value="admin.php?page=search&mode=buildings&search={id}">{ad_buildings}</option>
     <option value="admin.php?page=search&mode=ships&search={id}">{ad_ships}</option>
     <option value="admin.php?page=search&mode=defenses&search={id}">{ad_defenses}</option>
     </select></th>
</tr><tr>
	<td class="c" colspan="3"><center>{ad_planet} ({id}) {name} [{galaxy}:{system}:{planet}]</center></td>
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
<!-- START BLOCK : ships -->
<form action="" method="post">
<input type="hidden" name="edit" value="addit">
<table width="400">
<tbody>
<tr>
	<td class="c" colspan="2"><center><h2>{ad_add_ships}</h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option selected value="">{ad_user_planets}</option>
<!-- START BLOCK : lista_colos_ships -->
     <option value="admin.php?page=search&mode=ships&search={id}">{name}[{galaxy}:{system}:{planet}]</option>
<!-- END BLOCK : lista_colos_ships -->
     </select></th>
</tr><tr>
	<td class="c" colspan="2"><center><h2></h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option value="admin.php?page=search&mode=planets&search={id}">{ad_pla_moon}</option>
     <option value="admin.php?page=search&mode=resources&search={id}">{ad_resources}</option>
     <option value="admin.php?page=search&mode=buildings&search={id}">{ad_buildings}</option>
     <option selected value="admin.php?page=search&mode=ships&search={id}">{ad_ships}</option>
     <option value="admin.php?page=search&mode=defenses&search={id}">{ad_defenses}</option>
     </select></th>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" colspan="3"><center>{ad_planet} ({id}) {name} [{galaxy}:{system}:{planet}]</center></td>
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
<!-- START BLOCK : defenses -->
<form action="" method="post">
<input type="hidden" name="edit" value="addit">
<table width="400">
<tbody>
<tr>
	<td class="c" colspan="2"><center><h2>{ad_add_defenses}</h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option selected value="">{ad_user_planets}</option>
<!-- START BLOCK : lista_colos_defenses -->
     <option value="admin.php?page=search&mode=defenses&search={id}">{name}[{galaxy}:{system}:{planet}]</option>
<!-- END BLOCK : lista_colos_defenses -->
     </select></th>
</tr><tr>
	<td class="c" colspan="2"><center><h2></h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option value="admin.php?page=search&mode=planets&search={id}">{ad_pla_moon}</option>
     <option value="admin.php?page=search&mode=resources&search={id}">{ad_resources}</option>
     <option value="admin.php?page=search&mode=buildings&search={id}">{ad_buildings}</option>
     <option value="admin.php?page=search&mode=ships&search={id}">{ad_ships}</option>
     <option selected value="admin.php?page=search&mode=defenses&search={id}">{ad_defenses}</option>
     </select></th>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" colspan="3"><center>{ad_planet} ({id}) {name} [{galaxy}:{system}:{planet}]</center></td>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" align="center">{ad_defense}</td>
	<td class="c" align="center">{ad_defenses_number}</td>
	<td class="c" align="center">{ad_defenses_edit}</td>
</tr>
<!-- START BLOCK : defense_list -->
<tr>
	<th>{name_lang}</th>
	<th>{count}</th>
	<th><input name="{name}" type="text" value="0"  size="16"/></th>
</tr>
<!-- END BLOCK : defense_list -->
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
<!-- END BLOCK : defenses -->
<!-- START BLOCK : researchs -->
<form action="" method="post">
<input type="hidden" name="edit" value="addit">
<table width="400">
<tbody>
<tr>
	<td class="c" colspan="2"><center><h2>{ad_add_lvls_research}</h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option selected value="admin.php?page=search&mode=researchs&search={id}">{ad_researchs}</option>
     <option value="admin.php?page=search&mode=oficers&search={id}">{ad_oficers}</option>
     <option value="admin.php?page=search&mode=users&search={id}">{ad_users}</option>
     </select></th>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" colspan="3"><center>{ad_planet} ({id}) {name}</center></td>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" align="center">{ad_research}</td>
	<td class="c" align="center">{ad_levels}</td>
	<td class="c" align="center">{ad_levels_edit}</td>
</tr>
<!-- START BLOCK : research_list -->
<tr>
	<th>{name_lang}</th>
	<th>{count}</th>
	<th><input name="{name}" type="text" value="0"  size="16"/></th>
</tr>
<!-- END BLOCK : research_list -->
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
<!-- END BLOCK : researchs -->
<!-- START BLOCK : oficers -->
<form action="" method="post">
<input type="hidden" name="edit" value="addit">
<table width="400">
<tbody>
<tr>
	<td class="c" colspan="2"><center><h2>{ad_add_lvls_oficers}</h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option value="admin.php?page=search&mode=researchs&search={id}">{ad_researchs}</option>
     <option selected value="admin.php?page=search&mode=oficers&search={id}">{ad_oficers}</option>
     <option value="admin.php?page=search&mode=users&search={id}">{ad_users}</option>
     </select></th>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" colspan="3"><center>{ad_planet} ({id}) {name}</center></td>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" align="center">{ad_oficer}</td>
	<td class="c" align="center">{ad_levels}</td>
	<td class="c" align="center">{ad_levels_edit}</td>
</tr>
<!-- START BLOCK : oficers_list -->
<tr>
	<th>{name_lang}</th>
	<th>{count}</th>
	<th><input name="{name}" type="text" value="0"  size="16"/></th>
</tr>
<!-- END BLOCK : oficers_list -->
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
<!-- END BLOCK : oficers -->
<!-- START BLOCK : planets -->
<form action="" method="post">
<input type="hidden" name="edit" value="addit">
<table width="45%">
<tr>
	<td class="c" colspan="2"><center><h2>{ad_edit_planets}</h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option selected value="">{ad_user_planets}</option>
<!-- START BLOCK : lista_colos_planets -->
     <option value="admin.php?page=search&mode=planets&search={id}">{name}[{galaxy}:{system}:{planet}]</option>
<!-- END BLOCK : lista_colos_planets -->
     </select></th>
</tr><tr>
	<td class="c" colspan="2"><center><h2></h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option selected value="admin.php?page=search&mode=planets&search={id}">{ad_pla_moon}</option>
     <option value="admin.php?page=search&mode=resources&search={id}">{ad_resources}</option>
     <option value="admin.php?page=search&mode=buildings&search={id}">{ad_buildings}</option>
     <option value="admin.php?page=search&mode=ships&search={id}">{ad_ships}</option>
     <option value="admin.php?page=search&mode=defenses&search={id}">{ad_defenses}</option>
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
<!-- END BLOCK : planets -->
<!-- START BLOCK : users -->
<form action="" method="post">
<input type="hidden" name="edit" value="addit">
<table width="400">
<tr>
     <td class="c" colspan="2"><center><h2>{ad_edit_users}</h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option value="admin.php?page=search&mode=researchs&search={id}">{ad_researchs}</option>
     <option value="admin.php?page=search&mode=oficers&search={id}">{ad_oficers}</option>
     <option selected value="admin.php?page=search&mode=users&search={id}">{ad_users}</option>
     </select></th>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" align="center">{ad_acction}</td>
	<td class="c" align="center">{ad_value}</td>
	<td class="c" align="center">{ad_value}</td>
</tr><tr>
	<th>{ad_username}</th>
	<th>{username}</th>
	<th><input name="username"  size="19" type="text"/></th>
</tr><tr>
        <th>{ad_userpass}</th>
        <th>{password}</th>
	<th><input name="password"  size="19" type="password"/></th>
</tr><tr>
	<th>{ad_useremail}</th>
	<th>{email}</th>
	<th><input name="email"  size="19" type="text"/></th>
</tr><tr>
	<th>{ad_useremail2}</th>
	<th>{email2}</th>
	<th><input name="email2"  size="19" type="text"/></th>
</tr><tr>
	<th>{ad_register}</th>
	<th>{register}<br>({ip_at_reg})</th>
	<th></th>
</tr><tr>
	<th>{ad_lastlogin}</th>
	<th>{lastlogin}<br>({user_lastip})</th>
	<th></th>
</tr><tr>
	<th>{ad_activate}</th>
	<th>{activate}</th>
		<th colspan="4">
		<select name="activate">
			<option value="">{ad_sel_op}</option>
			<option value="yes">{ad_yesactivate}</option>
			<option value="no">{ad_noactivate}</option>
		</select>
	</th>
</tr><tr>
	<th>{ad_dpath}</th>
	<th>{dpath}</th>
	<th><input name="dpath"  size="19" type="text"/></th>
</tr><tr>
	<th>{ad_design}</th>
	<th>{design}</th>
		<th colspan="4">
		<select name="design">
			<option value="">{ad_sel_op}</option>
			<option value="yes">{ad_yes}</option>
			<option value="no">{ad_no}</option>
		</select>
	</th>
</tr><tr>
	<th>{ad_noipcheck}</th>
	<th>{noipcheck}</th>
		<th colspan="4">
		<select name="noipcheck">
			<option value="">{ad_sel_op}</option>
			<option value="yes">{ad_yes}</option>
			<option value="no">{ad_no}</option>
		</select>
	</th>
</tr><tr>
	<th>{ad_userlevel}</th>
	<th>{authlevel_s}</th>
	<th>
		<select name="authlevel">
			<option value="">{ad_sel_op}</option>
                        <option value="0" {levels_0} >{ad_level_player}</option>
			<option value="1" {levels_1} >{ad_level_mod}</option>
			<option value="2" {levels_2} >{ad_level_op}</option>
			<option value="3" {levels_3} >{ad_level_adm}</option>
		</select>
	</th>
</tr><tr>
	<th>{ad_uservac}</th>
	<th>{vacations}</th>
	<th>
		<select name="vacations">
			<option value="">{ad_sel_op}</option>
			<option value="yes">{ad_yesactivate}</option>
			<option value="no">{ad_noactivate}</option>
		</select>
	</th>
</tr><tr>
	<th>{ad_duration}</th>
	<th>{duration}</th>
        <th>{ad_days}  <input name="d" type="text" size="2" maxlength="2"/>  {ad_hours}  <input name="h" type="text" size="2"  maxlength="2"/></th>
</tr><tr>
	<th colspan="3"><input type="Submit" value="{ad_save}"/></th>
</tr>
</table>
<table>
<tr>
     <td class="c" colspan="6"><center><h2>{ad_user_planets}</h2></center></td>
</tr><tr>
     <td class="c" align="center">{ad_idplanet}</td>
     <td class="c" align="center">{ad_planet_name}</td>
     <td class="c" align="center">{ad_type}</td>
     <td class="c" align="center">{ad_field}</td>
     <td class="c" align="center">{ad_position}</td>
     <td class="c" align="center">{ad_activity}</td>
</tr>
<!-- START BLOCK : lista_colos_users -->
<tr>
     <th><a href=admin.php?page=search&mode=planets&search={id}>{id}</a></th>
     <th><a href=admin.php?page=search&mode=planets&search={id}>{name}</a></th>
     <th><a href=admin.php?page=search&mode=planets&search={id}>{type}</a></th>
     <th><a href=admin.php?page=search&mode=planets&search={id}>{field_current}/{field_max}</a></th>
     <th><a href=game.php?page=galaxy&mode=3&galaxy={galaxy}&system={system}>[{galaxy}:{system}:{planet}]</a></th>
     <th>{activity}</th>
</tr>
<!-- END BLOCK : lista_colos_users -->
</table>
</form>
<!-- END BLOCK : users -->
<!-- START BLOCK : alliances -->  
<form action="" method="post">
<input type="hidden" name="edit" value="addit">
<table width="500">
<tr>
     <td class="c" colspan="3"><center><h2>{ad_edit_alliances}</h2></center></td>
</tr><tr>
         <td><br></td>
</tr><tr>
	<td class="c" align="center">{ad_acction}</td>
	<td class="c" align="center">{ad_value}</td>
	<td class="c" align="center">{ad_value_edit}</td>
</tr><tr>
        <th><a onMouseOver="return overlib('{ad_ally_user_id}', BELOW, CENTER, WIDTH, 155, CAPTION, 'Alerta!',BGCOLOR,'#344566', FGCOLOR,'#344566',TEXTCOLOR,'white',CLOSECOLOR,'lime', CAPCOLOR,'red');" onMouseOut="return nd();" class="big">{ad_ally_change_id} (*)</a></th>
        <th>{ally_owner}</th>
	<th><input name="changeleader" type="text" size="10"/></th>
</tr><tr>
	<th>{ad_owner_range}</th>
	<th>{owner_range}</th>
	<th><input name="range" type="text" size="10"/></th>
</tr><tr>
	<th>{ad_ally_name}</th>
	<th>{ally_name}</th>
	<th><input name="name" type="text" size="10"/></th>
</tr><tr>
	<th>{ad_ally_tag}</th>
	<th>{ally_tag}</th>
	<th><input name="tag" type="text" size="10"/></th>
</tr><tr>
	<th>{ad_ally_web}</th>
	<th><a href="{ally_web}" target="_blank"/>{ally_web}</a></th>
	<th><input name="web" type="text" size="10"/></th>
</tr><tr>
	<th>{ad_ally_image}</th>
	<th><a href="{ally_image}" target="_blank"/><img src="{ally_image}" height=100 width=100></a></th>
	<th><input name="image" type="text" size="10"/></th>
</tr><tr>
        <th><a onMouseOver="return overlib('{ad_ally_user_id}', BELOW, CENTER, WIDTH, 155, CAPTION, 'Alerta!',BGCOLOR,'#344566', FGCOLOR,'#344566',TEXTCOLOR,'white',CLOSECOLOR,'lime', CAPCOLOR,'red');" onMouseOut="return nd();" class="big">{ad_ally_delete_u} (*)</a></th>
	<th></th>
        <th><select name="delete_u">
                        <option value="">Usuarios</option>
		<!-- START BLOCK : members -->
			<option value="{id}">{id} {username}</option>
		<!-- END BLOCK : members -->
         </select></th>
</tr><tr>
	<th>{ad_ally_delete}</th>
	<th></th>
	<th><input name="delete" type="checkbox"/></th>
</tr><tr>
         <td><br></td>
</tr><tr>
	<th colspan="3">{ad_ally_text1}</th>
</tr><tr>
	<th colspan="3"><textarea name="externo" type="text" rows="6" cols="80"/>{ally_description}</textarea></th>
</tr><tr>
	<th colspan="3">{ad_ally_text2}</th>
</tr><tr>
	<th colspan="3"><textarea name="interno" type="text" rows="6" cols="80"/>{ally_text}</textarea></th>
</tr><tr>
	<th colspan="3">{ad_ally_text3}</th>
</tr><tr>
	<th colspan="3"><textarea name="solicitud" type="text" rows="6" cols="80"/>{ally_request}</textarea></th>
</tr><tr>
	<th colspan="3"><input type="Submit" value="{ad_save}"/></th>
</tr>
</table>
</form>
</body>
<!-- END BLOCK : alliances -->
<!-- START BLOCK : iplog -->
<table width="400">
<tbody>
<tr>
	<td class="c" colspan="5"><center><h2>{ad_iplog}</h2></center></td>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" align="center">{ad_ip_id}</td>
	<td class="c" align="center">{ad_ip_userid}</td>
	<td class="c" align="center">{ad_ip_user}</td>
	<td class="c" align="center">{ad_ip_login}</td>
	<td class="c" align="center">{ad_ip_date}</td>
</tr>
<!-- START BLOCK : lista_ip-->
<tr>
	<th>{id}</th>
	<th><a href="admin.php?page=search&mode=iplog&search={userid}">{userid}</a></th>
	<th><a href="admin.php?page=search&mode=iplog&search={username}">{username}</a></th>
	<th><a href="admin.php?page=search&mode=iplog&search={user_ip}">{user_ip}</a></th>
	<th>{date}</th>

</tr>
<!-- END BLOCK : lista_ip -->
</tbody>
</tr>
</table>
</form>
<!-- END BLOCK : iplog -->