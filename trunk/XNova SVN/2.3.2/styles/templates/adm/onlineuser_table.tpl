<table width="100%">
<tr>
	<td colspan="13">{ou_players_connected} ({adm_ov_data_count})</td>
</tr>
<tr>
	<th class="d" width="12px"><a href="?page=userlist&cmd=sort&type=id">{ou_private_message}</a></th>
	<th class="d"><a href="?page=onlineusers&cmd=sort&type=username">{ou_user_id}</a></th>
	<th class="d"><a href="?page=onlineusers&cmd=sort&type=user_lastip">{ou_ip_address}</a></th>
	<th class="d"><a href="?page=onlineusers&cmd=sort&type=ally_name">{ou_alliance}</a></th>
	<th class="d">{ou_points}</th>
	<th class="d"><a href="?page=onlineusers&cmd=sort&type=onlinetime">{ou_inactivity}</a></th>
	<th class="d">{ou_email}</th>
	<th class="d" width="16px">{ou_vacation_mode}</th>
	<th class="d" width="16px">{ou_banned}</th>
	<th class="d">{ou_planet}</th>
	<th class="d">{ou_actual_page}</th>
	<th class="d">Cuenta Activada</th>
</tr>

        <!-- START BLOCK : list_online -->
<tr>
	<th class="d"><a onclick="new_mensaje('{adm_ov_data_name}','{adm_ov_data_id}','Sin Asunto','')" href="#" title="{write_message}"><img src="{dpath}img/{adm_ov_data_pict}" border="0"></a></th>
	<th class="d"><a href="#" title="{adm_ov_data_agen}">{adm_ov_data_name} ({usr_s_id})</a></th>
	<th class="d"><a href="http://network-tools.com/default.asp?prog=trace&host={adm_ov_data_adip}">{adm_ov_data_adip}</a></th>
	<th class="d">{adm_ov_data_ally}</th>
	<th class="d">{adm_ov_data_point}</th>
	<th class="d">{adm_ov_data_activ}</th>
	<th class="d"><a href="mailto:{usr_email}">{usr_email}</a></th>
	<th class="d">{state_vacancy}</th>
	<th class="d">{is_banned}</th>
	<th class="d">[<a href="../game.php?page=galaxy&mode=0&galaxy={usr_planet_gal}&system={usr_planet_sys}">{usr_planet_gal}:{usr_planet_sys}:{usr_planet_pos}</a>]</th>
	<th class="d">{current_page}</th>
	<th class="d">{actived}</th>
</tr>
        <!-- END BLOCK : list_online -->
<tr>
	<th class="b" colspan="12">{ul_there_are} {adm_ov_data_count} {players}</th>
</tr>
</table>