<br />
<table width="540" colspan="4">
<tr>
	<td class="c" colspan="4"><a href="overview.php?mode=renameplanet" title="{Planet_menu}">{Planet} "{planet_name}"</a> ({user_username})</td>
</tr>
{Have_new_message}
{Have_new_level_mineur}
{Have_new_level_raid}
<tr>
	<th>{Server_time}</th>
	<th colspan=3>{time}</th>
</tr>
{NewsFrame}
<tr>
	<td colspan="4" class="c">{Events}</td>
</tr>
{fleet_list}
<tr>
	<th>{moon_img}<br />{moon}</th>
	<th colspan="2"><a href="overview.php?mode=renameplanet" title="{Planet_menu}">{Planet} "{planet_name}"</a><br /><img src="{dpath}planeten/{planet_image}.jpg" height="200" width="200"><br />{coords} <a href="galaxy.php?mode=0&galaxy={galaxy_galaxy}&system={galaxy_system}">[{galaxy_galaxy}:{galaxy_system}:{galaxy_planet}]</a><br />{building}</th>
	<th><table width="100%" border="0">
		<tr>
			<th colspan="2">{ov_user}</th>
			<th colspan="2">{user_username}</th>
		</tr><tr>
			<th colspan="2" align="center"><b>{Rank}</b></th>
			<th colspan="2" align="center"><b><a href="stat.php?range={u_user_rank}">{user_rank}</a> {of} {max_users}</b></th>			
		</tr><tr>
			<th colspan="4"><span class="c">{ov_local_cdr}</span></th>
		</tr><tr>
			<th colspan="4"><font>{metal}</font>: {metal_debris} / <font>{crystal}</font> : {crystal_debris}{get_link}</th>
		</tr><tr>
			<th colspan="4">{Points}</th>
		</tr><tr>		
			<th colspan="4"><table border="0" width="100%"><tbody>
			<tr><td align="right" width="50%" style="background-color: transparent;"><b>{ov_pts_build}:</b></td>
			<td align="left" width="50%" style="background-color: transparent;"><b>{user_points}</b></td></tr>
			<tr><td align="right" width="50%" style="background-color: transparent;"><b>{ov_pts_fleet}:</b></td>
			<td align="left" width="50%" style="background-color: transparent;"><b>{user_fleet}</b></td></tr>
			<tr><td align="right" width="50%" style="background-color: transparent;"><b>{ov_pts_def}:</b></td>		
			<td align="left" width="50%" style="background-color: transparent;"><b>{user_defs}</b></td></tr>
			<tr><td align="right" width="50%" style="background-color: transparent;"><b>{ov_pts_reche}:</b></td>
			<td align="left" width="50%" style="background-color: transparent;"><b>{player_points_tech}</b></td></tr>
			<tr><td align="right" width="50%" style="background-color: transparent;"><b>{ov_pts_total}:</b></td>
			<td align="left" width="50%" style="background-color: transparent;"><b>{total_points}</b></td></tr>
			</tbody></table></th>
		</tr><tr>
			<th colspan="4">{MembersOnline}</th>
		</tr><tr>
			<th colspan="4">{NumberMembersOnline}</th>
		</tr><tr> 
			<th colspan="2" align="center">{ov_off_title}</th>
			<th align="center">{ov_off_mines}</th>
			<th align="center">{ov_off_raids}</th>
		</tr><tr> 
			<th colspan="2" align="center">{ov_off_level}</th>
			<th align="center">{lvl_minier}</th>
			<th align="center">{lvl_raid}</th>
		</tr>
</table>
<tr>
	<th>{Diameter}</th>
	<th colspan="3">{planet_diameter} km (<a title="{Developed_fields}">{planet_field_current}</a> / <a title="{max_eveloped_fields}">{planet_field_max}</a> {fields})</th>
</tr>

	<th>{Temperature}</th>
	<th colspan="3">{approx} {planet_temp_min}{Centigrade} {to} {planet_temp_max}{Centigrade}</th>
</tr><tr>
	<!--Ajout du pourcentage de case utilis?e et d'une barre-->
	<th >Mineria<br /> <font color="#CCF19F">{txt_minier}</font>&nbsp; </th>
	<th colspan="3" align="center">
		<div  style="border: 1px solid rgb(153, 153, 255); width: 400px;">
		<div  id="Mineria" style="background-color: {case_barre_barcolor}; width: {por_minier}%;">{por_minier}%</div>
		
	</th>
</tr>
<tr>
<th class="s" colspan ="4">
		<table class="s" align="top" border="0" style="background-color: transparent;">
			{anothers_planets}
		</table>
</th></tr>
{ExternalTchatFrame}
</table>
<br />
{ClickBanner}