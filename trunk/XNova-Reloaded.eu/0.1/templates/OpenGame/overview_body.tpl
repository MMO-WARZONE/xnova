		<center>
			<table width="700">
				{NewsFrame}
			</table>
			<table width="700">
				{Have_new_message}
				{Have_new_level_mineur}
				{Have_new_level_raid}
				{fleet_list}
				<tr>
					<td class="c" colspan="4"><u>{planet_type}</u> : {planet_name}</td>
				</tr>
			</table>	
			<table width="700">
				<tr>
					<th width="200" height="200" align="left" valign="top" rowspan="3">
						<img src="images/planeten/gross/{planet_image}.jpg" width="200" height="200" alt="{planet_name}"><br>
						<div  style="border: 1px solid rgb(153, 153, 255); width: 100%;">
							<div  id="CaseBarre" style="background-color: {case_barre_barcolor}; width: {case_pourcentage};">
								<center>
									<font color="#CCF19F">
										{case_pourcentage}
									</font>
								</center>
							</div>
						</div>
					</th>
					<td class="j" width="490" align="left" valign="middle" colspan="5">
						<div style="text-align: left;">
							<br>
							<p class="p"><a href="?action=internalHome&amp;height=320&amp;width=700&amp;mode=umbenennen" class="thickbox" title="{rename}">{rename}</a> /
										 <a href="?action=internalHome&amp;height=320&amp;width=700&amp;mode=loeschen" class="thickbox" title="{delete}">{delete}</a>
							</p><br>
							<p class="p"><u>{diameter}</u> : {planet_diameter}km</p>
							<br>
							<p class="p"><u>{temperature}</u> : {planet_temp_min}&deg;C bis {planet_temp_max}&deg;C</p><br>
							<p class="p"><u>{fields}</u> : {planet_field_current} / {planet_field_max}</p><br>
							<p class="p"><u>{tf}</u> : {metal_debris} {Metal} / {crystal_debris} {Crystal} {get_link}</p>
							<br>
							<p class="p">{DeinMond}</p>
							<center>{moon_img}<br>{moon}</center><br>
						</div>
					</td>
				</tr>
			</table>
			<table width="700">
				<tr>
					<td class="c" colspan="4" align="Center">{building_overview} {planet_name}</td>
				</tr>
				<tr>
					<th width="230">{typ}</th>
					<th>{time4building}</th>
					<th colspan="2">{building_name}</th>
				</tr>
				<tr>
					<th>{build}</th>
						{building}
				</tr>
				<tr>
					<th>{research}</th>
						{tech}
				</tr>
				<tr>
					<th>{fleet2}</th>
					{fleet}
				</tr>
				<tr>
					<th>{defense}</th>
					{def}
				</tr>
				<tr>
					<th>{MembersOnline}</th>
					<th colspan="3"><font color="lime">{NumberMembersOnline}</font> / {total_users}</th>
				</tr>
			</table>
			<table width="700">
				{DeinePlanis}
				{anothers_planets}
			</table>
			<table width="700">	
				<tr>
					<td colspan="4" class="c">{copyright}</td>
				</tr>
				<tr>
					<td colspan="4" class="c">{lastmember} {last_user}</td>
				</tr>
			</table>	
				{bannerframe}
				{ExternalTchatFrame}
			
			<br>
			{ClickBanner}
		</center>