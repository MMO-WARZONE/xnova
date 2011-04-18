<br><br>
<center>
<h2>{adm_opt_title}</h2>
<form action="" method="post">
<input type="hidden" name="opt_save" value="1">
<table width="700" style="color:#FFFFFF" align="center">
<tbody>
<tr>
	<td class="c" colspan="2">{adm_opt_game_settings}</td>
</tr><tr>
	<th>{adm_opt_game_name}</th>
	<th><input name="game_name" size="20" value="{game_name}" type="text"></th>
</tr><tr>
	<th>{adm_opt_game_gspeed}</th>
	<th><input name="game_speed" size="20" value="{game_speed}" type="text" maxlength="2"></th>
</tr><tr>
	<th>{adm_opt_game_fspeed}</th>
	<th><input name="fleet_speed" size="20" value="{fleet_speed}" type="text" maxlength="2"></th>
</tr><tr>
	<th>{adm_opt_game_pspeed}</th>
	<th><input name="resource_multiplier" value="{resource_multiplier}" type="text" maxlength="2"></th>
</tr><tr>
	<th>{adm_opt_game_forum}<br></th>
	<th><input name="forum_url" size="40" maxlength="254" value="{forum_url}" type="text"></th>
</tr><tr>
	<th>{adm_opt_game_online}<br></th>
	<th><input name="closed"{closed} type="checkbox"></th>
</tr><tr>
	<th>{adm_opt_game_offreaso}<br></th>
	<th><textarea name="close_reason" cols="80" rows="5" size="80" >{close_reason}</textarea></th>
</tr><tr>
	<th>{adm_opt_email}<br></th>
	<th><input name="adm_email" size="40" maxlength="254" value="{adm_email}" type="text"></th>
</tr><tr>
	<th>{adm_opt_max_galaxy_in_world}<br></th>
	<th><input name="max_galaxy_in world" size="6" maxlength="2" value="{max_galaxy_in_world}" type="text"></th>
</tr><tr>
	<th>{adm_opt_max_system_in_galaxy}<br></th>
	<th><input name="max_system_in_galaxy" size="6" maxlength="3" value="{max_system_in_galaxy}" type="text"></th>
</tr><tr>
	<th>{adm_opt_max_planet_in_system}<br></th>
	<th><input name="max_planet_in_system" size="6" maxlength="2" value="{max_planet_in_system}" type="text"></th>
</tr><tr>
	<th>{adm_opt_spy_report_row}<br></th>
	<th><input name="spy_report_row" size="6" maxlength="1" value="{spy_report_row}" type="text"></th>
</tr><tr>
	<th>{adm_opt_fields_by_moonbasis_level}<br></th>
	<th><input name="fields_by_moonbasis_level" size="6" maxlength="2" value="{fields_by_moonbasis_level}" type="text"></th>
</tr><tr>
	<th>{adm_opt_max_player_planets}<br></th>
	<th><input name="max_player_planets" size="6" maxlength="2" value="{max_player_planets}" type="text"></th>
</tr><tr>
	<th>{adm_opt_max_building_queue_size}<br></th>
	<th><input name="max_building_queue_size" size="6" maxlength="2" value="{max_building_queue_size}" type="text"></th>
</tr><tr>
	<th>{adm_opt_max_fleet_or_defs_per_row}<br></th>
	<th><input name="max_fleet_or_defs_per_row" size="6" maxlength="4" value="{max_fleet_or_defs_per_row}" type="text"></th>
</tr><tr>
	<th>{adm_opt_max_overflow}<br></th>
	<th><input name="max_overflow" size="6" maxlength="5" value="{max_overflow}" type="text"></th>
</tr><tr>
	<th>{adm_opt_base_storage_size}<br></th>
	<th><input name="base_storage_size" size="6" maxlength="6" value="{base_storage_size}" type="text"></th>
</tr><tr>
	<th>{adm_opt_build_metal}<br></th>
	<th><input name="build_metal" size="6" maxlength="5" value="{build_metal}" type="text"></th>
</tr><tr>
	<th>{adm_opt_build_cristal}<br></th>
	<th><input name="build_cristal" size="6" maxlength="5" value="{build_cristal}" type="text"></th>
</tr><tr>
	<th>{adm_opt_build_deuterium}<br></th>
	<th><input name="build_deuterium" size="6" maxlength="5" value="{build_deuterium}" type="text"></th>
</tr><tr>
	<td class="c" colspan="2">{adm_opt_plan_tf}</td>
</tr><tr>
	<th>{adm_opt_game_tffleet}</th>
	<th><input name="Fleet_Cdr" maxlength="2" size="6" value="{Fleet_Cdr}" type="text"></th>
</tr><tr>
	<th>{adm_opt_game_tfdef}</th>
	<th><input name="Defs_Cdr" maxlength="2" size="6" value="{Defs_Cdr}" type="text"></th>
</tr><tr>
	<td class="c" colspan="2">{adm_opt_plan_noobs}</td>
</tr><tr>
	<th>{adm_opt_game_noobpr}</th>
	<th><input name="noobprotection" maxlength="1" size="6" value="{noobprotection}" type="text"></th>
</tr><tr>
	<th>{adm_opt_game_noobti}</th>
	<th><input name="noobprotectiontime" maxlength="7" size="6" value="{noobprotectiontime}" type="text"></th>
</tr><tr>
	<th>{adm_opt_game_noobmu}</th>
	<th><input name="noobprotectionmulti" maxlength="1" size="6" value="{noobprotectionmulti}" type="text"></th>
</tr><tr>
	<td class="c" colspan="2">{adm_opt_plan_gala}</td>
</tr><tr>
	<th>{adm_opt_game_gpos}</th>
	<th><input name="LastSettedGalaxyPos" maxlength="1" size="6" value="{LastSettedGalaxyPos}" type="text"></th>
</tr><tr>
	<th>{adm_opt_game_spos}</th>
	<th><input name="LastSettedSystemPos" maxlength="1" size="6" value="{LastSettedSystemPos}" type="text"></th>
</tr><tr>
	<th>{adm_opt_game_ppos}</th>
	<th><input name="LastSettedPlanetPos" maxlength="1" size="6" value="{LastSettedPlanetPos}" type="text"></th>
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
	<th>{adm_opt_login_news}<br></th>
	<th><input name="LoginNewsFrame"{LoginNewsFrame} type="checkbox"></th>
</tr><tr>
	<th colspan="2"><textarea name="LoginNewsText" cols="80" rows="5" size="80" >{LoginNewsText}</textarea></th>
</tr


><tr>
	<th>{adm_opt_game_oth_news}<br></th>
	<th><input name="newsframe"{newsframe} type="checkbox"></th>
</tr><tr>
	<th colspan="2"><textarea name="NewsText" cols="80" rows="5" size="80" >{NewsTextVal}</textarea></th>
</tr><tr>
	<th>{adm_opt_game_oth_chat}</th>
	<th><input name="chatframe"{chatframe} type="checkbox"></th>
</tr><tr>
	<th colspan="2"><textarea name="ExternChat" cols="80" rows="5" size="80" >{ExtTchatVal}</textarea></th>
</tr><tr>
	<th>{adm_opt_game_oth_adds}</th>
	<th><input name="googlead"{googlead} type="checkbox"></th>
</tr><tr>
	<th colspan="2"><textarea name="GoogleAds" cols="80" rows="5" size="80" >{GoogleAdVal}</textarea></th>
</tr><tr>
	<th>{adm_opt_game_debugmod}</th>
	<th><input name="debug"{debug} type="checkbox"></th>
</tr><tr>
	<th colspan="2"><input value="{adm_opt_btn_save}" type="submit"></th>
</tr>
</tbody>
</table>
</form>
</center>