<form action="" method="post">
<input type="hidden" name="edit" value="addit">
<table width="400">
<tbody>
<tr>
	<td class="c" colspan="2"><center><h2>{ad_add_resources}</h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option value="admin.php?page=editor&search=planets&id={id}">{ad_pla_moon}</option>
     <option selected value="admin.php?page=editor&search=resources&id={id}">{ad_resources}</option>
     <option value="admin.php?page=editor&search=buildings&id={id}">{ad_buildings}</option>
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