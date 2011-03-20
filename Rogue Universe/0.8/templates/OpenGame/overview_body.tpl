<script language="JavaScript">
function f(target_url,win_name) {
  var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
  new_win.focus();
}
</script>

<!-- BEGIN FLOATING LAYER CODE //-->
<div id="theLayer" style="border:none;background-color:transparent;position:absolute;width:20px;left:720;top:64;visibility:visible">
<table border="0" width="20" style="border:none;background-color:transparent" cellspacing="0" cellpadding="5">
<!-- slut på första flytmenydelen -->


	<th class="s">
		<table class="s" align="top" border="0">
		<tr>
			{anothers_planets}
		</tr>
		</table>
	</th>
<!-- andra flytmeny delen -->
</table>
</div>
<!-- END FLOATING LAYER CODE //--> 


<!-- BEGIN FLOATING LAYER CODE //-->
<div style="position:absolute;width:20px;left:150;top:50;visibility:visible">
<table border="1" width="20" cellspacing="0" cellpadding="5">
<!-- slut på första flytmenydelen -->
<script language="JavaScript" type="text/javascript" src="scripts/time.js"></script>
<center>
<br />
<table width="540" colspan="4">
<tr>
	<td class="c" colspan="4"><a href="overview.php?mode=renameplanet" title="{Planet_menu}">{Planet} "{planet_name}"</a> ({user_username})</td>
</tr>
{Have_new_message}
{Have_new_level_mineur}
{Have_new_level_raid}
<tr><th>{Server_time}</th>
	<th colspan="3"><div id="dateheure"></div></th></tr>
<tr>
    <th>{MembersOnline}</th>
	<th colspan="3">{NumberMembersOnline}</th>
</tr>
{NewsFrame}
<tr>
	<td colspan="4" class="c">{Events}</td>
</tr>
{fleet_list}
<tr>
	<th>{moon_img}<br />{moon}</th>
	<th colspan="2"><a href="overview.php?mode=renameplanet" title="{Planet_menu}">{Planet} "{planet_name}"</a><br /><img src="{dpath}planeten/{planet_image}.jpg" height="200" width="200"><br />{coords} <a href="galaxy.php?mode=0&galaxy={galaxy_galaxy}&system={galaxy_system}">[{galaxy_galaxy}:{galaxy_system}:{galaxy_planet}]</a><br />{building}</th>
	<th><table width="100%" border="1">
		<tr>
			<td colspan="2">{ov_user}</td>
			<td colspan="2">{user_username}</td>
		</tr><tr>
			<td colspan="2" align="center"><b>{Rank}</b></td>
			<td colspan="2" align="center"><b><a href="stat.php?range={u_user_rank}">{user_rank}</a> {of} {max_users}</b></td>
		</tr><tr>
			<td colspan="4"><span class="c">{ov_local_cdr}</span></td>
		</tr><tr>
			<td colspan="4"><font>{metal}</font>: {metal_debris} / <font>{crystal}</font> : {crystal_debris}{get_link}</td>
		</tr><tr>
			<td colspan="4">{Points}</td>
		</tr><tr>		
			<th colspan="4"><table border="1" width="250px"><tbody>
			<tr><td align="right" width="50%" style="background-color: transparent;"><b>{ov_pts_build} :</b></td>
			<td align="left" width="50%" style="background-color: transparent;"><b>{user_points}</b></td></tr>
			<tr><td align="right" width="50%" style="background-color: transparent;"><b>{ov_pts_fleet} :</b></td>
			<td align="left" width="50%" style="background-color: transparent;"><b>{user_fleet}</b></td></tr>
			<tr><td align="right" width="50%" style="background-color: transparent;"><b>{ov_pts_def} :</b></td>		
			<td align="left" width="50%" style="background-color: transparent;"><b>{user_defs}</b></td></tr>
			<tr><td align="right" width="50%" style="background-color: transparent;"><b>{ov_pts_reche} :</b></td>
			<td align="left" width="50%" style="background-color: transparent;"><b>{player_points_tech}</b></td></tr>
			<tr><td align="right" width="50%" style="background-color: transparent;"><b>{ov_pts_total} :</b></td>
			<td align="left" width="50%" style="background-color: transparent;"><b>{total_points}</b></td></tr>
			</tbody></table></th>
			</tr><tr> 
			<td colspan="2" align="center">{ov_off_title}</td>
			<td align="center">{ov_off_mines}</td>
			<td align="center">{ov_off_raids}</td>
			</tr><tr> 
			<td colspan="2" align="center">{ov_off_level}</td>
			<td align="center">{lvl_minier}</td>
			<td align="center">{lvl_raid}</td>
			</tr><tr>
			<td colspan="2" align="center">{ov_off_expe}</td>
			<td align="center">{xpminier} / {lvl_up_minier}</td>
			<td align="center">{xpraid} / {lvl_up_raid}</td>
			</tr></table></th>
</tr>
<tr>
	<th>{Diameter}</th>
	<th colspan="3">{planet_diameter} km (<a title="{Developed_fields}">{planet_field_current}</a> / <a title="{max_eveloped_fields}">{planet_field_max}</a> {fields})</th>
</tr><tr>
	<!--Ajout du pourcentage de case utilisï¿½e et d'une barre-->
	<th >{Developed_fields}</th>
	<th colspan="3" align="center">
		<div  style="border: 1px solid rgb(153, 153, 255); width: 400px;">
		<div  id="CaseBarre" style="background-color: {case_barre_barcolor}; width: {case_barre}px;">
		<font color="#CCF19F">{case_pourcentage}</font>&nbsp;</div>
	</th>
</tr>
	<th>{Temperature}</th>
	<th colspan="3">{approx} {planet_temp_min}{Centigrade} {to} {planet_temp_max}{Centigrade}</th>
</tr>
    <tr>
    <th>{Raids}</th>
       <th colspan="3" align="center"><table border="1" width="100%"><tbody><tr>
          <td align="right" width="50%" style="background-color: transparent;"><b>{NumberOfRaids} :</b></td>
          <td align="left" width="50%" style="background-color: transparent;"><b>{raids}</b></td></tr>
          <tr><td align="right" width="50%" style="background-color: transparent;"><b>{RaidsWin} :</b></td>
          <td align="left" width="50%" style="background-color: transparent;"><b>{raidswin}</b></td></tr></tr>
          <tr><td align="right" width="50%" style="background-color: transparent;"><b>{RaidsLoose} :</b></td>
          <td align="left" width="50%" style="background-color: transparent;"><b>{raidsloose}</b></td></tr></tr>
         <tr><td align="right" width="50%" style="background-color: transparent;"><b>{RaidsDraw} :</b></td>
          <td align="left" width="50%" style="background-color: transparent;"><b>{raidsdraw}</b></td></tr></tbody></table></th></tr>
{ExternalTchatFrame}
{bannerframe}
</table>
<br />
{ClickBanner}</center>

<!-- anda flytmeny delen -->
</table></div>

<!-- END FLOATING LAYER CODE //--> 
<!-- <div style="border:none;background-color:transparent;position:relative;left:180;top:650;visibility:visible"> --!>
<!-- td--!>
<!-- img src="http://sajt.sytes.net/scripts/createbanner.php?id=<? .$users['id']. ?>"--!>
<!-- /td --!>

</body>
</html>