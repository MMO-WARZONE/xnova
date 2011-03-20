<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<th class="anything" valign="top">
		
<table width="695" height="450" border="0" align="center" cellpadding="2" cellspacing="2">
	<tr>
		<th class="anything" width="569" valign="top">
			<table width="569" border="0" align="center" cellpadding="2" cellspacing="2">
				<tbody>
					<tr>
						<td colspan="8" class="c"><div style="float:left">{gl_solar_system}</div><div id="available_fleets" style="float:right"><span id="fleet_count">{fleet_count}</span> / {fleet_max} {gf_fleetslt}</div></td>
					</tr>
					<tr>
						<td align="center" class="c">{gl_pos}</td>
						<td class="c">{gl_planet}</td>
						<td class="c">{gl_name_activity}</td>
						<td align="center" class="c">{gl_moon}</td>
						<td align="center" class="c">{gl_debris}</td>
						<td align="center" class="c">{gl_player}</td>
						<td align="center" class="c">{gl_alliance}</td>
						<td align="center" class="c">{gl_actions}</td>
					</tr>
					<!-- START BLOCK : planets -->
					<tr class="galaxy" height="24">
						<th align="center">
                                                    {i}
                                                </th>
						<th>{planet}</th>
						<th>{planet_status}</th>
						<th align="center">{moon}</th>
						<th align="center" class="{debris_class}">{debris}</th>
						<th align="center">{user_info}</th>
						<th align="center">{ally_info}</th>
						<th align="right">{actions}</th>
					</tr>
					<!-- END BLOCK : planets -->
                                        <tr>
                                            <th width="30">16</th>
                                            <th colspan="7">
                                            <a href="game.php?page=fleet&galaxy={this_galaxy}&amp;system={this_system}&amp;planet=16&amp;planettype=1&amp;target_mission=15">{gl_out_space}</a>
                                            </th>
                                        </tr>
                              </tbody>
			</table>		</th>
		<th class="anything" width="112" rowspan="2" valign="top">
			<!-- START BLOCK : movement -->
			<table border="0" height="100%" align="center" cellpadding="2" cellspacing="2">
				<form action="{PHP_SELF}" method="post" id="galaxy_form">
				<tr>
				  <th class="anything" width="50%" height="30" align="center" class="c">
                                      <table width="100%" border="0" cellpadding="2" cellspacing="2">
					<tr>
						<td class=c align="center">{gl_galaxy}</td>
					</tr>
					<tr>
					<th>
						<table align="center">
						<tr>
						  <th><input name="galaxyLeft" value="&laquo;" onClick="galaxy_submit('galaxyLeft')" type="button" /></th>
						  <th><input name="galaxy" value="{galaxy}" size="5" maxlength="3" tabindex="1" type="text" /></th>
						  <th><input name="galaxyRight" value="&raquo;" onClick="galaxy_submit('galaxyRight')" type="button" /></th>
						</tr>
						</table>
					</th>
					</tr>
                                        </table></th>
				  </tr>
				<tr>
				  <th class="anything" height="30" align="center">
                                      <table width="100%" border="0" cellpadding="2" cellspacing="2">
                                          <tr>
                                            <td class="c" align="center">{gl_solar_system}</td>
                                          </tr>
                                          <tr>
                                            <th><table align="center">
                                                <tr>
                                                  <th><input name="systemLeft" value="&laquo;" onClick="galaxy_submit('systemLeft')" type="button" /></th>
                                                  <th><input name="system" value="{system}" size="5" maxlength="3" tabindex="1" type="text" /></th>
                                                  <th><input name="systemRight" value="&raquo;" onClick="galaxy_submit('systemRight')" type="button" /></th>
                                                </tr>
                                            </table></th>
                                          </tr>
                                      </table>
                                  </th>
                                </tr>
				<tr height="10">
				  	<th><input value="{gl_show}" type="submit"><input id="auto" value="dr" type="hidden"></th>
				</tr>
				
				
				<tr>
				  <th class="anything" valign="top">
                 <table width=100% cellpadding=0 cellspacing=0>
                    <tr>
                      <td class=c colspan=2 align=center><a href=# onclick="if($('table#leyenda').css('display')=='none'){ $('table#leyenda').css('display',''); }else{ $('table#leyenda').css('display','none');}">{gl_legend}</a></td>
                    </tr>
                 </table>
		<table id="leyenda" style="display:none" width=100% cellpadding=0 cellspacing=0>
                    <tr>
                      <th>{gl_strong_player}</th>
                      <th align="center"><span class=strong>{gl_s}</span></th>
                    </tr>
                    <tr>
                      <th>{gl_week_player}</td>
                      <th align="center"><span class=noob>{gl_w}</span></th>
                    </tr>
                    <tr>
                      <th>{gl_vacation}</td>
                      <th align="center"><span class=vacation>{gl_v}</span></th>
                    </tr>
                    <tr>
                      <th>{gl_banned}</td>
                      <th align="center"><span class=banned>{gl_b}</span></th>
                    </tr>
                    <tr>
                      <th>{gl_inactive_seven}</td>
                      <th align="center"><span class=inactive>{gl_i}</span></th>
                    </tr>
                    <tr>
                      <th>{gl_inactive_twentyeight}</td>
                      <th align="center"><span class=longinactive>{gl_I}</span></th>
                    </tr>
                    <tr>
                      <th>Admin</td>
                      <th align="center"><font color=lime><blink>A</blink></font></th>
                    </tr>
                  </table></th>
				  </tr>
				<tr  style="" id="fleetstatusrow">
					<th class="anything" colspan="8" >
                                            <div id="loading"></div>
                                            <div id="response"></div>
						<!--<table cellpadding=0 border=1px cellspacing=0 style="font-weight: bold" width="50%" id="fleetstatustable">
							<!-- will be filled with content later on while processing ajax replys -->
						<!--</table>-->
					</th>
				</tr>
                                 
				</form>
				<tr><th class="anything">
				<!-- START BLOCK : misiles -->
			<table>
			<tr>
				<th >
					<form action="game.php?page=misiles" method="POST">
						<table border="0">
							<tr>
								<td class="c" colspan="2">{gl_missil_launch} [{galaxy}:{system}:{planet}]</td>
							</tr>
							<tr>
								<input type="hidden" name="galaxy" value="{galaxy}" size="2" maxlength="7" />
								<input type="hidden" name="system" value="{system}" size="2" maxlength="7" />
								<input type="hidden" name="planet" value="{planet}" size="2" maxlength="7" />
								<td class="c">{missile_count} <input type="text" name="SendMI" size="2" maxlength="7" /></td>
								<td class="c">{gl_objective}: 
				                	<select name="Target">
				                        <option value="all" selected>{gl_all_defenses}</option>
				                        <option value="0">{ma_misil_launcher}</option>
				                        <option value="1">{ma_small_laser}</option>
				                        <option value="2">{ma_big_laser}</option>
				                        <option value="3">{ma_gauss_canyon}</option>
				                        <option value="4">{ma_ionic_canyon}</option>
				                        <option value="5">{ma_buster_canyon}</option>
				                        <option value="6">{ma_small_protection_shield}</option>
				                        <option value="7">{ma_big_protection_shield}</option>
				                    </select>
				                </td>
							</tr>
							<tr>
								<td class="c" colspan="2"><input type="submit" name="aktion" value="{gl_missil_launch_action}"></td>
							</tr>
						</table>
					</form>
				</th>
			</tr>
			</table>
			<!-- END BLOCK : misiles -->
				</th></tr>
			</table>
			
			<!-- END BLOCK : movement -->		</th>
	</tr>
	<tr>
	<th class="anything" valign="top"><table width="100%" border="0">
		<tr>
		  <td class="c" colspan="2" align="center">Disponibilidad</td>
		</tr>
		<tr>
		  <th width="14%" align="right"><span id="c_mip">{CurrentMIP}</span></th>
		  <th width="86%">{gl_avaible_missiles}</th>
		</tr>
		<tr>
		  <th align="right"><span id="c_spy">{SpyProbes}</span></th>
		  <th>{gl_avaible_spyprobes}</th>
		</tr>
		<tr>
		  <th align="right"><span id="c_rec">{Recyclers}</span></th>
		  <th>{gl_avaible_recyclers}</th>
		</tr>
	</table></th>
	  </tr>
</table>

	  </th>
	</tr>
	
</table>
<style>
.debris_small{
	background-color: #99CC99;
}
.debris_medium{
	background-color: #CC9933;
}
.debris_large{
	background-color: #CC3300;
}

#response{
	height:150px;
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
	display:none;
}

#loading img{
	vertical-align:middle;
}

</style>
<!--<script src="scripts/jquery.js" type="text/javascript"></script>-->
<script>
	function galaxy_submit(value) {
		document.getElementById('auto').name = value;
		document.getElementById('galaxy_form').submit();
	}
	
	window.onload = function() {
		$.ajaxSetup({
			timeout: 3000
		});
	}
	
	function fenster(target_url, win_name) {
		var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=640,height=480,top=0,left=0');
		new_win.focus();
	}
	
	// THERE'S NO NEED TO MAKE ANOTHER FLOTENAJAX, SO, LETS EMULATE :D
	// LOVE JQUERY :3
	function pada_galaxy(order, galaxy, system, planet, planettype, shipcount){
		
		$("#response").html('');
		$("#loading").fadeIn("slow");
		
		sendData =		"galaxy=" + galaxy 
					+ "&system=" + system 
					+ "&planet=" + planet 
					+ "&planettype=" + planettype 
					+ "&mission=" + order 
					+ "&thisgalaxy={this_galaxy}"
					+ "&thissystem={this_system}"
					+ "&thisplanet={this_planet}"
					+ "&thisplanettype={this_planet_type}";
		
		if (order == 6) Add = "&ship210=" + shipcount;
		if (order == 7) Add = "&ship208=1";
		if (order == 8) Add = "&ship209=" + shipcount;
		
		$.ajax({
			url: 'flotenajax.php?action=send',
			data: sendData + Add,
			cache: false,
			type: 'POST', 
			
			success: function(html) {
				$("#loading").fadeOut("slow", function(){
					parseResponse(html);
				});
			},
			error: function(html) {
				$("#loading").fadeOut("slow", function() {
					$("#response").html('Error Inesperado en Jquery');
				});
			}
		});
		
		function parseResponse(html){
			if (html) {
				$("#response").html(html);
				
				htmlArray = html.split('|');
				
				tmpMessage = htmlArray[0].split(";");
				tmpInfo = htmlArray[1].split(" ");
				UsedSlots = tmpInfo[0];
				SpyProbes = tmpInfo[1];
				Recyclers = tmpInfo[2];
				Missiles  = tmpInfo[3];
				
				$("#response").html(tmpMessage[1]);
				$("#c_mip").html(Missiles);
				$("#c_spy").html(SpyProbes);
				$("#c_rec").html(Recyclers);
				$("#fleet_count").html(UsedSlots);				
			}
		}
	}
</script>
{ajaxscript}