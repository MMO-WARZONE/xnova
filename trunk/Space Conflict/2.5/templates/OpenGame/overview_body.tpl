<style type="text/css">
<!--
.style1 {color: #FF0000}
.style2 {color: #FFFF00}
.style6 {color: #FFFFFF}
-->
</style>
<center>
<script language="JavaScript" type="text/javascript" src="scripts/chat.js"></script>
<br /><table width="60%" align="center">
  <tbody>

<tr>
  <td width="975" class="c"><strong>ShoutBox !! </strong></td>
</tr>

<tr><th><div id="shoutbox" style="margin: 5px; vertical-align: text-top; height: 85px; overflow:hidden;"></div></th></tr>

<tr><th>Message: <input name="msg" type="text" id="msg" size="85" maxlength="300" onKeyPress="if(event.keyCode == 13){ addMessage(); } if (event.keyCode==60 || event.keyCode==62) event.returnValue = false; if (event.which==60 || event.which==62) return false;">
<input type="button" name="send" value="Send" id="send" onClick="addMessage()"></th></tr>

</tbody></table>
<table width="60%">
<tr>
	<td class="c" colspan="4">
		<a href="overview.php?mode=renameplanet" title="{Planet_menu}">{Planet} "{planet_name}"</a> ({user_username})	</td>
</tr>
{Have_new_message}
{Have_new_level_mineur}
{Have_new_level_raid}
<tr>
	<th>{Server_time}</th>
	<th colspan=3>{time}</th>
</tr>
<tr>
    <th>{MembersOnline}</th>
	<th colspan="3">{NumberMembersOnline}</th>
</tr>
{NewsFrame}
<tr>
	<td colspan="4" class="c">Information</td>
</tr>
{fleet_list}
<tr>
	<th>{moon_img}<br>{moon}</th>
	<th colspan="2"><img src="{dpath}planeten/{planet_image}.jpg" height="200" width="200"><br>{building}</th>
	<th class="s">
		<table class="s" align="top" border="0">
		<tr>
			{anothers_planets}		</tr>
		</table>	</th>
</tr>
	  <th>Exp Percent % </th>
	    <th colspan="3" align="center">
		<div  style="border: 1px solid rgb(153, 153, 255); width: 100%;">
		<div  id="CaseBarre" style="background-color: {case_barre_barcolor}; width: {case_barre}px;">
		<font color="#000000">{case_pourcentage}</font>&nbsp;</div>	</th>

<tr>
	<th>Exp</th>
	<th colspan="3" align="center">Exp : {xpminier} </th>
</tr>
<tr>
	<th>Resources</th>
	<th colspan="3">Metal : {metal_debris} / Crystal : {crystal_debris}{get_link}</th>
</tr>
<tr>
	<th><strong>Ranking</strong></th>
	<th colspan="3"><strong><a href="stat.php?start={u_user_rank}">{user_rank}</a> / {max_users}</strong>	</th>
</tr>
{ExternalTchatFrame}
</table>
{overview_script}
<table width="60%" align="center">
  <tbody>
    <tr>
      <td width="100%" class="c"><div align="center"><b>Planet Intel</b></div></td>
    </tr>
  </tbody>
</table>
<table width="60%" align="center">
  <tbody>
    <tr>
      <th>Location : <a href="galaxy.php?mode=0&amp;galaxy={galaxy_galaxy}&amp;system={galaxy_system}">[{galaxy_galaxy}:{galaxy_system}:{galaxy_planet}]</a> | Temp : -{planet_temp_min}&deg;C / {planet_temp_max}&deg;C | Size : {planet_diameter} km (<a title="{Developed_fields}">{planet_field_current}</a> / <a title="{max_eveloped_fields}">{planet_field_max}</a> fields)</th>
    </tr>
  </tbody>
</table>
<table width="60%" align="center">
  <tbody>
    <tr>
      <td width="100%" class="c"><div align="center"><b>Points </b></div></td>
    </tr>
  </tbody>
</table>
<table width="60%" align="center">
  <tbody>
    <tr>
      <th>User : [{user_points}] | Fleet :[{user_fleet}] | Tech : [{player_points_tech}]</th>
    </tr>
    <tr>
      <th>Total :[{total_points} ]</th>
    </tr>
  </tbody>
</table>

</center>
</body>
</html>