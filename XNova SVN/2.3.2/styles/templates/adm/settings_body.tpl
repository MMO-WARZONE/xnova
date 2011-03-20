
<form action="" method="post">
<input type="hidden" name="opt_save" value="1">
<table width="519" cellpadding="2" cellspacing="2">
<tr>
	<td class="c" colspan="2">{se_server_parameters}</td>
</tr><tr>
	<th>{se_name}</th>
	<th><input name="game_name"  size=20 value="{game_name}" type=text></th>
</tr><tr>
	<th>{se_lang}</th>
	<th><select name="language">{language_settings}</select></th>
</tr><tr>
	<th>{se_general_speed}</th>
	<th><input name="game_speed" size="15" value="{game_speed}" type="text">  {se_normal_speed}</th>
</tr><tr>
	<th>{se_fleet_speed}</th>
	<th><input name="fleet_speed" size="15" value="{fleet_speed}" type="text">  {se_normal_speed}</th>
</tr><tr>
	<th>{se_resources_producion_speed}</th>
	<th><input name="resource_multiplier" maxlength="8" size="10" value="{resource_multiplier}" type="text"> {se_normal_speed_resoruces}</th>
</tr><tr>
	<th>{se_forum_link}</th>
	<th><input name="forum_url" size="84" maxlength="254" value="{forum_url}" type="text"></th>
</tr><tr>
	<th>{se_server_op_close}<br /></th>
	<th><input name="closed"{closed} type="checkbox" /></th>
</tr><tr>
	<th>{se_server_status_message}<br /></th>
	<th><textarea name="close_reason" cols="80" rows="5" size="80" >{close_reason}</textarea></th>
</tr><tr>
	<td class="c" colspan="2">{se_server_planet_parameters}</td>
</tr><tr>
	<th>{se_initial_fields}</th>
	<th><input name="initial_fields" maxlength="80" size="10" value="{initial_fields}" type="text"> {se_fields} </th>
</tr><tr>
	<th>{se_metal_production}</th>
	<th><input name="metal_basic_income" maxlength="5" size="10" value="{metal_basic_income}" type="text"> {se_per_hour}</th>
</tr><tr>
	<th>{se_crystal_production}</th>
	<th><input name="crystal_basic_income" maxlength="5" size="10" value="{crystal_basic_income}" type="text"> {se_per_hour}</th>
</tr><tr>
	<th>{se_deuterium_production}</th>
	<th><input name="deuterium_basic_income" maxlength="5" size="10" value="{deuterium_basic_income}" type="text"> {se_per_hour}</th>
</tr><tr>
	<th>{se_energy_production}</th>
	<th><input name="energy_basic_income" maxlength="5" size="10" value="{energy_basic_income}" type="text"> {se_per_hour}</th>
</tr><tr>
	<td class="c" colspan="2">{se_several_parameters}</td>
</tr><tr>
	<th><a href="#" title="{se_title_admins_protection}">{se_admin_protection}</a><br></th>
    <th><input name="adm_attack" {adm_attack} type="checkbox" /></th>
</tr><tr>
	<th>{se_debug_mode}</th>
	<th><input name="debug" {adm_debug} type="checkbox" /></th>
</tr><tr>
	<th>{se_captcha_mode}</th>
	<th><input name="captcha" {captcha} {disabled} type="checkbox" />
            <input name="captcha_valor" value="{captcha_val}" {disabled} maxlength="2" size="2" type="text" /><br>{disabled_info}</th>
</tr>
<tr>
<td class="c" colspan="2">{se_opt_game_oth_info}</td>
</tr><tr>
	<th>{se_opt_game_oth_news}<br></th>
	<th><input name="newsframe" {newsframe} type="checkbox" /></th>
</tr><tr>
	<th colspan="2"><textarea name="NewsText" cols="80" rows="5" size="80" >{NewsTextVal}</textarea></th>
</tr>
	
<tr>
	<th>{se_opt_game_oth_adds}<br></th>
	<th><input name="act_publicidad" {frame_publi} type="checkbox" /></th>
</tr><tr>
	<th colspan="2"><textarea name="Publicidad" cols="80" rows="5" size="80" >{Publi}</textarea></th>
</tr><tr>
	<th colspan="3"><input value="{se_save_parameters}" type="submit"></th>
</tr>
</table>
</form>