<form action="" method="post">
<input type="hidden" name="edit" value="addit">
<table width="400">
<tbody>
<tr>
	<td class="c" colspan="2"><center><h2>{ad_add_lvls_oficers}</h2></center></td>
     <th><select onChange="eval('location=\''+this.options[this.selectedIndex].value+'\'');">
     <option value="admin.php?page=editor&search=researchs&id={id}">{ad_researchs}</option>
     <option selected value="admin.php?page=editor&search=oficers&id={id}">{ad_oficers}</option>
     <option value="admin.php?page=editor&search=users&id={id}">{ad_users}</option>
     </select></th>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" colspan="3"><center>{ad_user} ({id}) {name}</center></td>
</tr><tr>
	<th><br></th>
</tr><tr>
	<td class="c" align="center">{ad_oficer}</td>
	<td class="c" align="center">{ad_levels}</td>
	<td class="c" align="center">{ad_levels_edit}</td>
</tr><tr>
        <th><a onMouseOver="return overlib('{ad_message_alert_darkmatter}', BELOW, CENTER, WIDTH, 350, CAPTION, 'Alerta!',BGCOLOR,'#344566', FGCOLOR,'#344566',TEXTCOLOR,'white',CLOSECOLOR,'lime', CAPCOLOR,'red');" onMouseOut="return nd();" class="big">{Darkmatter} (*)</a></th>
	<th>{darkmatter}</th>
	<th><input name="darkmatter" type="text" value="0" size="14" /></th>
</tr><tr>
	<th><br></th>
</tr><tr>
	<th>{ad_rpg_geologue}</th>
	<th>{rpg_geologue}</th>
	<th><input name="rpg_geologue" type="text" value="0"  size="14"/></th>
</tr><tr>
	<th>{ad_rpg_amiral}</td>
	<th>{rpg_amiral}</th>
	<th><input name="rpg_amiral" type="text" value="0"  size="14"/></th>
</tr><tr>
	<th>{ad_rpg_ingenieur}</td>
	<th>{rpg_ingenieur}</th>
	<th><input name="rpg_ingenieur" type="text" value="0"  size="14"/></th>
</tr><tr>
	<th>{ad_rpg_technocrate}</td>
	<th>{rpg_technocrate}</th>
	<th><input name="rpg_technocrate" type="text" value="0"  size="14"/></th>
</tr><tr>
	<th>{ad_rpg_constructeur}</td>
	<th>{rpg_constructeur}</th>
	<th><input name="rpg_constructeur" type="text" value="0"  size="14"/></th>
</tr><tr>
	<th>{ad_rpg_scientifique}</td>
	<th>{rpg_scientifique}</th>
	<th><input name="rpg_scientifique" type="text" value="0"  size="14"/></th>
</tr><tr>
	<th>{ad_rpg_stockeur}</td>
	<th>{rpg_stockeur}</th>
	<th><input name="rpg_stockeur" type="text" value="0"  size="14"/></th>
</tr><tr>
	<th>{ad_rpg_defenseur}</td>
	<th>{rpg_defenseur}</th>
	<th><input name="rpg_defenseur" type="text" value="0"  size="14"/></th>
</tr><tr>
	<th>{ad_rpg_bunker}</td>
	<th>{rpg_bunker}</th>
	<th><input name="rpg_bunker" type="text" value="0"  size="14"/></th>
</tr><tr>
	<th>{ad_rpg_espion}</td>
	<th>{rpg_espion}</th>
	<th><input name="rpg_espion" type="text" value="0"  size="14"/></th>
</tr><tr>
	<th>{ad_rpg_commandant}</td>
	<th>{rpg_commandant}</th>
	<th><input name="rpg_commandant" type="text" value="0"  size="14"/></th>
</tr><tr>
	<th>{ad_rpg_destructeur}</td>  
        <th>{rpg_destructeur}</th>
	<th><input name="rpg_destructeur" type="text" value="0"  size="14"/></th>
</tr><tr>
	<th>{ad_rpg_general}</td>
	<th>{rpg_general}</th>
	<th><input name="rpg_general" type="text" value="0"  size="14"/></th>
</tr><tr>
	<th>{ad_rpg_raideur}</td>
	<th>{rpg_raideur}</th>
	<th><input name="rpg_raideur" type="text" value="0"  size="14"/></th>
</tr><tr>
	<th>{ad_rpg_empereur}</td>
	<th>{rpg_empereur}</th>
	<th><input name="rpg_empereur" type="text" value="0"  size="14"/></th>
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