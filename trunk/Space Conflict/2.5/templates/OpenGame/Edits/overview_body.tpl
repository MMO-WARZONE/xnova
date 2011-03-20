<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {color: #FFFF00}
.style6 {color: #FFFFFF}
-->
</style>
<center>
	  <table width="80%" cellspacing="0" cellpadding="0"><tr>
			  <td width="100%" style="border-top: 1px #545454 solid" background="{dpath}img/bg1.gif"><div>
			    <div align="center"><span class="c"><a href="overview.php?mode=renameplanet" title="{Planet_menu}">{Planet} &quot;{planet_name}&quot;</a> ({user_username}) </span><br>
			    </div>
			  </div></td>
			</tr>
			<tr>
				<td><table width="100%" border="0">
  <tr>
    <th width="50%" scope="col"><div align="left">Position</div></th>
    <th width="50%" scope="col"><a href="galaxy.php?mode=0&amp;galaxy={galaxy_galaxy}&amp;system={galaxy_system}">[{galaxy_galaxy}:{galaxy_system}:{galaxy_planet}]</a></th>
  </tr>
  <tr>
    <th width="50%" scope="col"><div align="left">Planet Diameter</div></th>
    <th width="50%" scope="col">{planet_diameter} km (<a title="{Developed_fields}">{planet_field_current}</a> / <a title="{max_eveloped_fields}">{planet_field_max}</a> points)</th>
  </tr>
  <tr>
    <th width="50%" scope="col"><div align="left">Temperature</div></th>
    <th width="50%" scope="col">-{planet_temp_min}&deg;C / {planet_temp_max}&deg;C</th>
  </tr>
</table></td>
			</tr>
			<tr>
		    <td><div align="center"><div  id="CaseBarre" style="background-color: {case_barre_barcolor}; width: {case_barre}px;">
		<font color="#CCF19F">Exp {case_pourcentage}%</font>&nbsp;</div></div></tr>
			<tr>
		    <td><div align="center">{Server_time}	:	{time} |   
			{MembersOnline} : {NumberMembersOnline}
			</div>		    </tr>
</table>    
<br />
<table width="519">
{Have_new_message}
{Have_new_level_mineur}
{Have_new_level_raid}
<tr>
	<td colspan="3" class="c" background="{dpath}img/bg1.gif">Information</td>
</tr>
{fleet_list}
<tr>
	<th>{moon_img}<br>{moon}</th>
	<th><img src="{dpath}planeten/{planet_image}.jpg" height="200" width="200"><br>{building}</th>
	<th class="s">
		<table class="s" align="top" border="0">
		<tr>
			{anothers_planets}		</tr>
		</table>	</th>
</tr>
<tr>
	<th>Resources</th>
	<th colspan="2">Metal : {metal_debris} / Crystal : {crystal_debris}{get_link}</th>
</tr>
<tr>
	<th>Points</th>
	<th colspan="2">User Points : {user_points} <br>
	Float : {user_fleet} <br>
	Player Points : {player_points_tech} <br>
	Total Points : {total_points} <br>	<br>
	<strong>Ranking :  <a href="stat.php?start={u_user_rank}" class="style2">{user_rank}</a> / <span class="style1">{max_users}</span></strong>	</th>
</tr>
{ExternalTchatFrame}
</table>
<br>
{ClickBanner}
</center>
</body>
</html>