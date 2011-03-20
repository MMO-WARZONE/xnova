<br />
<body onmousemove="tt_Mousemove(event);">
<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td colspan="2" height="20"></td>
	</tr>
	<tr>
		<td valign="top">
		
<table width="695" height="450" border="0" align="center" cellpadding="2" cellspacing="2">
	<tr>
		<th width="569" valign="top">
			<table width="569" border="0" align="center" cellpadding="2" cellspacing="2">
				<tbody>
					<tr>
						<td colspan="8" class="c">{Solar_system_at}</td>
					</tr>
					<tr>
						<td align="center" class="c">{Pos}</td>
						<td class="c">{Planet}</td>
						<td class="c">{Name}</td>
						<td align="center" class="c">{Moon}</td>
						<td align="center" class="c">{Debris}</td>
						<td align="center" class="c">{Player} ({State})</td>
						<td align="center" class="c">{Alliance}</td>
						<td align="center" class="c">{Actions}</td>
					</tr>
					<!-- START BLOCK : planets -->
					<tr height="24">
						<th align="center">{i}</th>
						<th>
							<!-- START BLOCK : planet_image -->
							<a href="javascript:void(0);" style="cursor: pointer;" onMouseOver="this.T_WIDTH=250;this.T_OFFSETX=-110;this.T_OFFSETY=-30;this.T_STICKY=true;this.T_TEMP={time};this.T_STATIC=true;return escape('{planet_tooltip}');">
							<img src="{dpath}planeten/small/s_{planet_image}.jpg" height="22" width="22">
							</a>
							<!-- END BLOCK : planet_image -->
						</th>
						<th>
							<!-- START BLOCK : planet_status -->
							<span class="{classname}">{planet_name} {planet_status}</span>
							<!-- END BLOCK : planet_status -->
						</th>
						<th align="center">
							<!-- START BLOCK : moon_image -->
							<a href="javascript:void(0);" style="cursor: pointer;" onMouseOver="this.T_WIDTH=250;this.T_OFFSETX=-110;this.T_OFFSETY=-30;this.T_STICKY=true;this.T_TEMP={time};this.T_STATIC=true;return escape('{moon_tooltip}');">
							<img src="{dpath}planeten/small/s_mond.jpg" border="0" alt="{moon_name}" height="22" width="22"/>							</a>
							<!-- END BLOCK : moon_image -->						</th>
						<th align="center" class="{debrisClass}">
							<!-- START BLOCK : debris_image -->
							<a href="javascript:void(0);" style="cursor: pointer;" onMouseOver="this.T_WIDTH=300;this.T_OFFSETX=-110;this.T_OFFSETY=-30;this.T_STICKY=true;this.T_TEMP={time};this.T_STATIC=true;return escape('{debris_tooltip}');">
							<img src="{dpath}planeten/debris.jpg" border="0" alt="{Debris}" height="22" width="22"/>							</a>
							<!-- END BLOCK : debris_image -->						</th>
						<th align="center">{username}</th>
						<th align="center">
							<!-- START BLOCK : ally_info -->
							<a href="javascript:void(0);" style="cursor: pointer;" onMouseOver="this.T_WIDTH=250;this.T_OFFSETX=-110;this.T_OFFSETY=-30;this.T_STICKY=true;this.T_TEMP={time};this.T_STATIC=true;return escape('{ally_tooltip}');">
							<span class="{ally_classname}">{ally_tag}</span>
							</a>
							<!-- END BLOCK : ally_info -->
						</th>
						<th align="right">
							<div align="right" style="padding-right:8px">
							<!-- START BLOCK : espionage -->
							<a href="javascript:void(0);" title="{Espionage}" onClick="spy({this_g}, {this_s}, {this_p}, {this_t}, {this_mission});"><img src="{dpath}img/e.gif" alt="{Espionage}" title="{Espionage}" border="0"></a>
							<!-- END BLOCK : espionage -->
							<!-- START BLOCK : message -->
							<a href="messages.php?mode=write&id={user_id}" title="{NewMessage}"><img src="{dpath}img/m.gif" alt="{NewMessage}" title="{NewMessage}" border="0"></a>
							<!-- END BLOCK : message -->
							<!-- START BLOCK : buddy -->
							<a href="buddy.php?a=2&amp;u={user_id}" title="{Buddy}"><img src="{dpath}img/b.gif" alt="{Buddy}" title="{Buddy}" border="0"></a>
							<!-- END BLOCK : buddy -->	
							</div>				
						</th>
					</tr>
					<!-- END BLOCK : planets -->
				</tbody>
			</table>
		</th>
		<th width="112" valign="top">
			<!-- START BLOCK : movement -->
			<table border="0" align="center" cellpadding="2" cellspacing="2">
				<form action="galaxy-new.php" method="post" id="galaxy_form">
				<tr>
				  <td width="50%" align="center" class="c"><table width="100%" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td align="center">{Galaxy}</td>
                    </tr>
                    <tr>
                      <td><table align="center">
                          <tr>
                            <td><input name="galaxyLeft" value="&laquo;" onclick="galaxy_submit('galaxyLeft')" type="button" /></td>
                            <td><input name="galaxy" value="{galaxy}" size="5" maxlength="3" tabindex="1" type="text" /></td>
                            <td><input name="galaxyRight" value="&raquo;" onclick="galaxy_submit('galaxyRight')" type="button" /></td>
                          </tr>
                      </table></td>
                    </tr>
                  </table></td>
				  </tr>
				<tr>
					<td class="c" align="center"><table width="100%" border="0" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center">{Solar_system}</td>
                      </tr>
                      <tr>
                        <td><table align="center">
                            <tr>
                              <td><input name="systemLeft" value="&laquo;" onclick="galaxy_submit('systemLeft')" type="button" /></td>
                              <td><input name="system" value="{system}" size="5" maxlength="3" tabindex="1" type="text" /></td>
                              <td><input name="systemRight" value="&raquo;" onclick="galaxy_submit('systemRight')" type="button" /></td>
                            </tr>
                        </table></td>
                      </tr>
                    </table></td>
				  </tr>
				<tr height="20">
				  <th><input value="{Show}" type="submit"><input id="auto" value="dr" type="hidden"></th>
				  </tr>
				<tr height="20">
				  <th><div align="left" id="response"></div></th>
				  </tr>
				<tr height="20">
				  <th><div id="loading" style="display:none;" align="center"><img src="images/loading-small.gif" hspace="4" vspace="0" />{LoadingFleet}</div></th>
				  </tr>
				</form>
			</table>
			<!-- END BLOCK : movement -->
		</th>
	</tr>
</table>

		</td>
	</tr>
</table>
<script src="scripts/jquery-1.2.3.pack.js" type="text/javascript"></script>
<script src="scripts/wz_tooltip.js" language="JavaScript"></script>
<style>
.green{
	color:#009933;
}
.red{
	color:#FF3300;
}
.debris_small{
	background-color: #99CC99;
}
.debris_medium{
	background-color: #CC9933;
}
.debris_large{
	background-color: #CC3300;
}

#loading{
	text-align:left;

	bottom: 0;
	padding: 3px 0px 3px 0px;
	margin: 0;
	background-color: #FFFFFF;
	display: block;
	text-align: center;
	font-weight: bold;
	font-size: 12px;
	font-family: Arial, Helvetica, sans-serif;
	color: #333333;
	padding-top: 5px;
	
	border: 1px solid #003366;
	border-left: none;
	border-right: none;	
}

#loading img{
	vertical-align:middle;
}

</style>
<script>
	function galaxy_submit(value) {
		document.getElementById('auto').name = value;
		document.getElementById('galaxy_form').submit();
	}
	
	window.onload = function() {
		$.ajaxSetup({
			timeout: 7000
		});
	}
	
	function spy(galaxy, system, planet, planettype, missiontype){
		
		$("#response").html('');
		$("#loading").fadeIn("slow");
		//var t = $("#response").html()
		
		sendData = "g=" + galaxy + "&s=" + system + "&p=" + planet + "&t=" + planettype + "&m=" + missiontype;
		
		$.ajax({
			url: 'galaxy-ajax.php', 
			data: sendData,
			cache: false,
			type: 'POST', 
			
			success: function(html) {
				$("#loading").fadeOut("slow", function() {
					
					$("#response").html(html);
				});
			},
			error: function(html) {
				$("#loading").fadeOut("slow", function() {
					$("#response").html('Unespected Error');
				});
			}
		});
	
	}
	
</script>
</body>