<br><br>
<h2>{adm_opt_title}</h2>
<form action="" method="post">
<input type="hidden" name="opt_save" value="1">
<table width="519" style="color:#FFFFFF">
<tbody>
<tr>
	<td class="c" colspan="2">{adm_opt_game_settings}</td>
</tr><tr>
	<th>{adm_opt_game_name}</th>
	<th><input name="game_name" size="20" value="{game_name}" type="text"></th>
</tr><tr>
	<th>{adm_opt_game_gspeed}</th>
	<th><input name="game_speed" size="20" value="{game_speed}" type="text"></th>
</tr><tr>
	<th>{adm_opt_game_fspeed}</th>
	<th><input name="fleet_speed" size="20" value="{fleet_speed}" type="text"></th>
</tr><tr>
	<th>{adm_opt_game_pspeed}</th>
	<th><input name="resource_multiplier" maxlength="80" size="10" value="{resource_multiplier}" type="text"></th>
</tr><tr>
	<th>Game URL</th>
	<th><input name="game_url" maxlength="254" size="40" value="{gameurl}" type="text"></th>
</tr>
<tr>
	<th>{adm_opt_game_forum}<br></th>
	<th><input name="forum_url" size="40" maxlength="254" value="{forum_url}" type="text"></th>
</tr><tr>
	<th>{adm_opt_game_online}<br></th>
	<th><input name="closed"{closed} type="checkbox" /></th>
</tr><tr>
	<th>Flottensperre<br></th>
	<th><input name="attack_disabled"{attack_disabled} type="checkbox" /></th>
</tr><tr>
         <th>{adm_opt_game_offreaso}<br></th>
	<th><textarea name="close_reason" cols="80" rows="5" size="80" >{close_reason}</textarea></th>
</tr><tr>
	<td class="c" colspan="2">{adm_opt_plan_tf}</td>
</tr><tr>
	<th>{adm_opt_game_tffleet}</th>
	<th><input name="Fleet_Cdr" maxlength="2" size="5" value="{Fleet_Cdr}" type="text"></th>
</tr><tr>
	<th>{adm_opt_game_tfdef}</th>
	<th><input name="Defs_Cdr" maxlength="2" size="5" value="{Defs_Cdr}" type="text"></th>
</tr><tr>
	<td class="c" colspan="2">{adm_opt_plan_noobs}</td>
</tr><tr>
	<th>{adm_opt_game_noobti}</th>
	<th><input name="noobprotectiontime" maxlength="7" size="5" value="{noobprotectiontime}" type="text"></th>
</tr><tr>
	<th>{adm_opt_game_noobmu}</th>
	<th><input name="noobprotectionmulti" maxlength="1" size="5" value="{noobprotectionmulti}" type="text"></th>
</tr><tr>
	<td class="c" colspan="2">{adm_opt_plan_gala}</td>
</tr><tr>
	<th>{adm_opt_game_gpos}</th>
	<th><input name="LastSettedGalaxyPos" maxlength="1" size="5" value="{LastSettedGalaxyPos}" type="text"></th>
</tr><tr>
	<th>{adm_opt_game_spos}</th>
	<th><input name="LastSettedSystemPos" maxlength="1" size="5" value="{LastSettedSystemPos}" type="text"></th>
</tr><tr>
	<th>{adm_opt_game_ppos}</th>
	<th><input name="LastSettedPlanetPos" maxlength="1" size="5" value="{LastSettedPlanetPos}" type="text"></th>
</tr><tr>
	<td class="c" colspan="2">{adm_opt_plan_settings}</td>
</tr><tr>
	<th>{adm_opt_plan_initial}</th>
	<th><input name="initial_fields" maxlength="80" size="10" value="{initial_fields}" type="text"> {felder}</th>
</tr><tr>
	<th>{adm_opt_plan_base_inc}{Metal}</th>
	<th><input name="metal_basic_income" maxlength="80" size="10" value="{metal_basic_income}" type="text"> {Stunde}</th>
</tr><tr>
	<th>{adm_opt_plan_base_inc}{Crystal}</th>
	<th><input name="crystal_basic_income" maxlength="80" size="10" value="{crystal_basic_income}" type="text"> {Stunde}</th>
</tr><tr>
	<th>{adm_opt_plan_base_inc}{Deuterium}</th>
	<th><input name="deuterium_basic_income" maxlength="80" size="10" value="{deuterium_basic_income}" type="text"> {Stunde}</th>
</tr><tr>
	<th>{adm_opt_plan_base_inc}{Energy}</th>
	<th><input name="energy_basic_income" maxlength="80" size="10" value="{energy_basic_income}" type="text">
	  {Stunde}</th>
</tr><tr>
	<td class="c" colspan="2">{adm_opt_game_oth_info}</td>
</tr><tr>
	<th>{adm_opt_game_oth_news}<br></th>
	<th><input name="newsframe"{newsframe} type="checkbox" /></th>
</tr><tr>
	<th colspan="2"><textarea name="NewsText" cols="80" rows="5" size="80" >{NewsTextVal}</textarea></th>
</tr><tr>
	<th>{adm_opt_game_oth_chat}</th>
	<th><input name="chatframe"{chatframe} type="checkbox" /></th>
</tr><tr>
	<th colspan="2"><textarea name="ExternChat" cols="80" rows="5" size="80" >{ExtTchatVal}</textarea></th>
</tr><tr>
	<th>{adm_opt_game_oth_adds}</th>
	<th><input name="googlead"{googlead} type="checkbox" /></th>
</tr><tr>
	<th colspan="2"><textarea name="GoogleAds" cols="80" rows="5" size="80" >{GoogleAdVal}</textarea></th>
</tr><tr>
	<th>{adm_opt_game_debugmod}</a></th>
	<th><input name="debug"{debug} type="checkbox" /></th>
</tr><tr>
	<th colspan="2"><input value="{adm_opt_btn_save}" type="submit"></th>
</tr>
</tbody>
</table>
</form>