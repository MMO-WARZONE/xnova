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
        <th><select name="members">
		<!-- START BLOCK : members -->
			<option value="{username}">{username}</option>
		<!-- END BLOCK : members -->
         </select></th>
	<th><input name="delete_u" type="text" size="10"/></th>
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