<form action="" method="post">
<input type="hidden" name="edit" value="addit">
<table width="200">
<tbody>
<tr>
	<td class="c" colspan="2"><center><h2>{ad_add_defenses}</h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option value="admin.php?page=editor&search=planets&id={id}">{ad_pla_moon}</option>
     <option value="admin.php?page=editor&search=resources&id={id}">{ad_resources}</option>
     <option value="admin.php?page=editor&search=buildings&id={id}">{ad_buildings}</option>
     <option value="admin.php?page=editor&search=ships&id={id}">{ad_ships}</option>
     <option selected value="admin.php?page=editor&search=defenses&id={id}">{ad_defenses}</option>
     </select></th>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" colspan="3"><center>{ad_planet} ({id}) {name}</center></td>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" align="center">{ad_defense}</td>
	<td class="c" align="center">{ad_defenses_number}</td>
	<td class="c" align="center">{ad_defenses_edit}</td>
</tr><tr>
	<th>{ad_misil_launcher}</th>
	<th>{misil_launcher}</th>
	<th><input name="misil_launcher" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_small_laser}</td>
	<th>{small_laser}</th>
	<th><input name="small_laser" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_big_laser}</td>
	<th>{big_laser}</th>
	<th><input name="big_laser" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_gauss_canyon}</td>
	<th>{gauss_canyon}</th>
	<th><input name="gauss_canyon" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_ionic_canyon}</td>
	<th>{ionic_canyon}</th>
	<th><input name="ionic_canyon" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_buster_canyon}</td>
	<th>{buster_canyon}</th>
	<th><input name="buster_canyon" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_small_protection_shield}</td>
	<th>{small_protection_shield}</th>
	<th><input name="small_protection_shield" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_big_protection_shield}</td>
	<th>{big_protection_shield}</th>
	<th><input name="big_protection_shield" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_planet_protector}</td>
	<th>{planet_protector}</th>
	<th><input name="planet_protector" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_interceptor_misil}</td>
	<th>{interceptor_misil}</th>
	<th><input name="interceptor_misil" type="text" value="0"  size="16"/></th>
</tr><tr>
	<th>{ad_interplanetary_misil}</td>
	<th>{interplanetary_misil}</th>
	<th><input name="interplanetary_misil" type="text" value="0"  size="16"/></th>
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