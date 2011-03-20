<form action="" method="post">
<input type="hidden" name="edit" value="addit">
<table width="400">
<tbody>
<tr>
	<td class="c" colspan="2"><center><h2>{ad_add_lvls_to_buildings}</h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option value="admin.php?page=editor&search=planets&id={id}">{ad_pla_moon}</option>
     <option value="admin.php?page=editor&search=resources&id={id}">{ad_resources}</option>
     <option selected value="admin.php?page=editor&search=buildings&id={id}">{ad_buildings}</option>
     <option value="admin.php?page=editor&search=ships&id={id}">{ad_ships}</option>
     <option value="admin.php?page=editor&search=defenses&id={id}">{ad_defenses}</option>
     </select></th>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" colspan="3"><center>{ad_planet} ({id}) {name}</center></td>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" align="center">{ad_building}</td>
	<td class="c" align="center">{ad_levels}</td>
	<td class="c" align="center">{ad_levels_edit}</td>
</tr><tr>
	<th>{ad_metal_mine}</th>
	<th>{metal_mine}</th>
	<th><input name="metal_mine" type="text" value="0" size="14" /></th>
</tr><tr>
	<th>{ad_crystal_mine}</td>
	<th>{crystal_mine}</th>
	<th><input name="crystal_mine" type="text" value="0" size="14"/></th>
</tr><tr>
	<th>{ad_deuterium_sintetizer}</td>
	<th>{deuterium_sintetizer}</th>
	<th><input name="deuterium_sintetizer" type="text" value="0" size="14"/></th>
</tr><tr>
	<th>{ad_solar_plant}</td>
	<th>{solar_plant}</th>
	<th><input name="solar_plant" type="text" value="0" size="14"/></th>
</tr><tr>
	<th>{ad_fusion_plant}</td>
	<th>{fusion_plant}</th>
	<th><input name="fusion_plant" type="text" value="0" size="14"/></th>
</tr><tr>
	<th>{ad_robot_factory}</td>
	<th>{robot_factory}</th>
	<th><input name="robot_factory" type="text" value="0" size="14"/></th>
</tr><tr>
	<th>{ad_nano_factory}</td>
	<th>{nano_factory}</th>
	<th><input name="nano_factory" type="text" value="0" size="14"/></th>
</tr><tr>
	<th>{ad_shipyard}</td>
	<th>{hangar}</th>
	<th><input name="hangar" type="text" value="0" size="14"/></th>
</tr><tr>
	<th>{ad_metal_store}</td>
	<th>{metal_store}</th>
	<th><input name="metal_store" type="text" value="0" size="14"/></th>
</tr><tr>
	<th>{ad_crystal_store}</td>
	<th>{crystal_store}</th>
	<th><input name="crystal_store" type="text" value="0" size="14"/></th>
</tr><tr>
	<th>{ad_deuterium_store}</td>
	<th>{deuterium_store}</th>
	<th><input name="deuterium_store" type="text" value="0" size="14"/></th>
</tr><tr>
	<th>{ad_laboratory}</td>
	<th>{laboratory}</th>
	<th><input name="laboratory" type="text" value="0" size="14"/></th>
</tr><tr>
	<th>{ad_terraformer}</td>
	<th>{terraformer}</th>
	<th><input name="terraformer" type="text" value="0" size="14"/></th>
</tr><tr>
	<th>{ad_ally_deposit}</td>
	<th>{ally_deposit}</th>
	<th><input name="ally_deposit" type="text" value="0" size="14"/></th>
</tr><tr>
	<th>{ad_silo}</td>
	<th>{silo}</th>
	<th><input name="silo" type="text" value="0" size="14"/></th>
</tr><tr>
	<td class="c" align="center">{ad_buildings_moon}</td>
	<td class="c" align="center">{ad_levels}</td>
	<td class="c" align="center">{ad_levels_edit}</td>
</tr><tr>
	<th>{ad_mondbasis}</td>
	<th>{mondbasis}</th>
	<th><input name="mondbasis" type="text" value="0" size="14"/></th>
</tr><tr>
	<th>{ad_phalanx}</td>
	<th>{phalanx}</th>
	<th><input name="phalanx" type="text" value="0" size="14"/></th>
</tr><tr>
	<th>{ad_sprungtor}</td>
	<th>{sprungtor}</th>
	<th><input name="sprungtor" type="text" value="0" size="14"/></th>
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