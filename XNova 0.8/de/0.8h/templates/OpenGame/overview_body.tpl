<center>
<br>
<table width="519">
<tr><font size="5" color="#FF0000"></font>
	<td class="c" colspan="4">
		<a href="overview.php?mode=renameplanet" title="{Planet_menu}">{Planet} "{planet_name}"</a> ({user_username})
	</td>
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
	<td colspan="4" class="c">Ereignisse</td>
</tr>
{fleet_list}
<tr>
	<th>{moon_img}<br>{moon}</th>
	<th colspan="2"><img src="{dpath}planeten/{planet_image}.jpg" height="200" width="200"><br>{building}</th>
	<th class="s">
		<table class="s" align="top" border="0">
		<tr>
			{anothers_planets}
		</tr>
		</table>
	</th>
</tr>
<tr>
	<th>Durchmesser</th>
	<th colspan="3">{planet_diameter} km (<a title="{Developed_fields}">{planet_field_current}</a> / <a title="{max_eveloped_fields}">{planet_field_max}</a> Felder)</th>
</tr>
	<!--Ajout du pourcentage de case utilis�e et d'une barre-->
	<th >Felder verbaut</th>
	<th colspan="3" align="center">
		<div  style="border: 1px solid rgb(153, 153, 255); width: 400px;">
		<div  id="CaseBarre" style="background-color: {case_barre_barcolor}; width: {case_barre}px;">
		<font color="#CCF19F">{case_pourcentage}</font>&nbsp;</div>
	</th>
<tr>
<tr>
	<th>Level</th>
	<th>Offizier : {lvl_minier}</th>
	<th></th>
	<th>Raid Level : {lvl_raid}</th>
</tr>
<tr>
	<th>Berufserfahrung</th>
	<th>Minen Level : {xpminier} / {lvl_up_minier}</th>
	<th></th>
	<th>Erfahrungs Level : {xpraid} / {lvl_up_raid} </th>
</tr>
<th>{Raids}</th>
	<th colspan="3"><table border="0" width="100%"><tbody><tr>
		<td align="right" width="50%" style="background-color: transparent;"><b>{NumberOfRaids} :</b></td>
		<td align="left" width="50%" style="background-color: transparent;"><b>{raids}</b></td></tr>
		<tr><td align="right" width="50%" style="background-color: transparent;"><b>{RaidsWin} :</b></td>
		<td align="left" width="50%" style="background-color: transparent;"><b>{raidswin}</b></td></tr></tr>
		<tr><td align="right" width="50%" style="background-color: transparent;"><b>{RaidsLoose} :</b></td>
		<td align="left" width="50%" style="background-color: transparent;"><b>{raidsloose}</b></td></tr></tbody></table></th></tr>
	<th>Temparatur</th>
	<th colspan="3">ca. {planet_temp_min}&deg;C bis {planet_temp_max}&deg;C</th>
</tr>
<td colspan="4" class="c">Game Avatar</td>
  </tr>
  <tr>
	<th>Dein Skin</th><th colspan="3"> {dpath}
	</th>

  </tr>

      <tr>
	<th>Dein Avatar</th><th colspan="3"><a href="options.php"> Um dein Avatar zuwechseln <i><b>hier Klicken</b></i></a>
	</th>

  </tr>    
  <tr>
	<th>Avatar</th><th colspan="3"><img src="{avatar}" alt="Avatarwechseln unter Optionen" />
	</th>

  </tr>
<tr>
	<td colspan="4" class="c"></td>
  </tr>
{ExternalTchatFrame}
</table>
<br>
{ClickBanner}
</center>
</body>
</html>