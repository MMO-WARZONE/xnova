<center>
<br>
<table width="519">

</tr>
{Have_new_message}
{Have_new_level_mineur}
{Have_new_level_raid}
<tr>
	<th><p align="left"><font color="green">{Server_time}</font></p></th>
	<th>{time}</th>
    <th><p align="left"><font color="green">{MembersOnline}</font></p></th>
	<th><font color="yellow">{NumberMembersOnline}</font></th>
</tr><tr>
	<th><p align="left"><font color="green">{user_name}</font></p><th>{user_username}</th><th><p align="left"><font color="green">{user_id}</font></p></th><th><font color="lightblue">{user_userid}</font></th>
</tr><tr>
	<th><p align="left"><font color="#b8860b">Online GO</font></p></th>
	<th colspan="3">{OnlineAdmins}</th>
</tr>

{NewsFrame}

{fleet_list}
<tr>
<td class="c" colspan="4" align="Center">Planeten Information</td>
</tr>
		</table>
		
   <table width="519">
     <tr>
        <th width="180" height="180" align="left" valign="top" rowspan="3">
        <a href="overview.php?mode=renameplanet" ><img src="{dpath}planeten/{planet_image}.jpg" width="180" height="180"></a><br>

{building}
        <td class="j" width="410" height="91" align="left" valign="top" colspan="5">
<div style="text-align: left;">

<p style="text-align: left; margin-left: 40px;"><b>Name</b>: {planet_name} <a href="galaxy.php?g={galaxy_galaxy}&s={galaxy_system}">[{galaxy_galaxy}:{galaxy_system}:{galaxy_planet}]</a>&nbsp;&nbsp;&nbsp;
</a><br />
</p>
<p style="text-align: left; margin-left: 40px;"><b>Deine Angriffszone</b>: {az}
<br />
</p>
<p style="text-align: left; margin-left: 40px;"><b>Durchmesser</b>: {planet_diameter}km<br>
</p>
<p style="text-align: left; margin-left: 40px;"><b>Temperatur</b>: {planet_temp_min}&deg;C bis
{planet_temp_max}&deg;C <br>
</p>
<p style="text-align: left; margin-left: 40px;"><b>Planetenfelder</b>: {planet_field_current} von {planet_field_max} bebaut.
<div  style="margin-left: 40px; border: 1px solid rgb(153, 153, 255); width: 70%;">
<div  id="CaseBarre" style="background-color: {case_barre_barcolor}; width: {case_pourcentage};">
<font color="#CCF19F"><center>{case_pourcentage}</center></font></div></div>
</p>
<p style="text-align: left; margin-left: 40px;"><b>Mond/Astro</b>:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;{moon_img}
</p>

</table>
<table style="width: 519px;">
<tr><td class ="c" width="519" height="1" align="left" valign="top" colspan="4"><center><b>{colonie_empire}</center></b></td>
{anothers_planets}
</table>
<table width="519">
</tr>
<tr>
	<th>Tr&uuml;mmerfeld</th>
	<th colspan="3">{Metal} : {metal_debris} / {Crystal} : {crystal_debris}{get_link}</th>
</tr>

<tr>
	<th>Level</th>
	<th colspan="2">Miner : {lvl_minier}</th>
	<th colspan="1">Raider : {lvl_raid}</th>
</tr>
<tr>
	<th>Dein aktueller<br>Rang im Uni:<br><br><font color="gold">{u_user_rank}</font></th>
	<th colspan="2"><img src='images/Raenge/Miner{lvl_minier}.gif' border=0></th>
	<th colspan="1"><img src='images/Raenge/Fleeter{lvl_raid}.gif' border=0></th>
</tr>
<tr>
	<th>Erfahrung</th>
	<th colspan="2">{xpminier} / {lvl_up_minier} f&uuml;r level {levelupm}</th>
	<th colspan="1">{xpraid} / {lvl_up_raid} f&uuml;r level {levelupr}</th>
</tr>
<tr>
<th><font color="green">Geb&auml;ude</font></th> <th><font color="white">{user_points}</font></th>
	<th><font color="green">Flotte</font></th> <th><font color="white">{user_fleet}</font></th></tr>
	<tr>	<th><font color="green">Forschung</font></th> <th><font color="white">{player_points_tech}</font></th><th><font color="green">Verteidigung</font></th> <th><font color="white">{user_def}</font></th></tr>
	<tr><th colspan="3"><font color="red">Total</font></th> <th><font color="gold">{total_points}</font></th></tr>
{ExternalTchatFrame}
</table>
<br>
{ClickBanner}
</center>
</body>
</html>