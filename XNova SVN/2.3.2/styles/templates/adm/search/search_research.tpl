<form action="" method="post">
<input type="hidden" name="edit" value="addit">
<table width="400">
<tbody>
<tr>
	<td class="c" colspan="2"><center><h2>{ad_add_lvls_research}</h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option selected value="admin.php?page=editor&search=researchs&id={id}">{ad_researchs}</option>
     <option value="admin.php?page=editor&search=oficers&id={id}">{ad_oficers}</option>
     <option value="admin.php?page=editor&search=users&id={id}">{ad_users}</option>
     </select></th>

</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" colspan="3"><center>{ad_user} ({id}) {name}</center></td>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" align="center">{ad_research}</td>
	<td class="c" align="center">{ad_levels}</td>
	<td class="c" align="center">{ad_levels_edit}</td>
</tr><tr>
	<th>{ad_spy_tech}</th>
	<th>{spy_tech}</th>
	<th><input name="spy_tech" type="text" value="0" /></th>
</tr><tr>
	<th>{ad_computer_tech}</th>
        <th>{computer_tech}</th>
	<th><input name="computer_tech" type="text" value="0" /></th>
</tr><tr>
	<th>{ad_military_tech}</th>
	<th>{military_tech}</th>
	<th><input name="military_tech" type="text" value="0" /></th>
</tr><tr>
	<th>{ad_defence_tech}</th>
	<th>{defence_tech}</th>
	<th><input name="defence_tech" type="text" value="0" /></th>
</tr><tr>
	<th>{ad_shield_tech}</td>
	<th>{shield_tech}</th>
	<th><input name="shield_tech" type="text" value="0" /></th>
</tr><tr>
	<th>{ad_energy_tech}</td>
	<th>{energy_tech}</th>
	<th><input name="energy_tech" type="text" value="0" /></th>
</tr><tr>
	<th>{ad_hyperspace_tech}</td>
	<th>{hyperspace_tech}</th>
	<th><input name="hyperspace_tech" type="text" value="0" /></th>
</tr><tr>
	<th>{ad_combustion_tech}</td>
	<th>{combustion_tech}</th>
	<th><input name="combustion_tech" type="text" value="0" /></th>
</tr><tr>
	<th>{ad_impulse_motor_tech}</td>
	<th>{impulse_motor_tech}</th>
	<th><input name="impulse_motor_tech" type="text" value="0" /></th>
</tr><tr>
	<th>{ad_hyperspace_motor_tech}</td>
	<th>{hyperspace_motor_tech}</th>
	<th><input name="hyperspace_motor_tech" type="text" value="0" /></th>
</tr><tr>
	<th>{ad_laser_tech}</td>
	<th>{laser_tech}</th>
	<th><input name="laser_tech" type="text" value="0" /></th>
</tr><tr>
	<th>{ad_ionic_tech}</td>
	<th>{ionic_tech}</th>
	<th><input name="ionic_tech" type="text" value="0" /></th>
</tr><tr>
	<th>{ad_buster_tech}</td>
	<th>{buster_tech}</th>
	<th><input name="buster_tech" type="text" value="0" /></th>
</tr><tr>
	<th>{ad_intergalactic_tech}</td>
	<th>{intergalactic_tech}</th>
	<th><input name="intergalactic_tech" type="text" value="0" /></th>
</tr><tr>
	<th>{ad_expedition_tech}</td> 
	<th>{expedition_tech}</th>
	<th><input name="expedition_tech" type="text" value="0" /></th>
</tr><tr>
	<th>{ad_graviton_tech}</td>
	<th>{graviton_tech}</th>
	<th><input name="graviton_tech" type="text" value="0" /></th>
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