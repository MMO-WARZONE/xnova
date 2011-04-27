<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="2">
	<tr>
		<td colspan="2" height="20"></td>
	</tr>
	<tr>
		<td valign="top">
		
<table width="695" height="450" border="0" align="center" cellpadding="2" cellspacing="2">
	<tr>
		<td width="569" valign="top">
			<table width="569" border="0" align="center" cellpadding="2" cellspacing="2">
				<tbody>
					<tr>
						<td colspan="8" class="c"><div style="float:left">{Solar_system_at}</div><div id="available_fleets" style="float:right"><span id="fleet_count">{fleet_count}</span> / {fleet_max} {gf_fleetslt}</div></td>
					</tr>
					<tr>
						<td align="center" class="c">{Pos}</td>
						<td class="c">{Planet}</td>
						<td class="c">{Name}</td>
						<td align="center" class="c">{Moon}</td>
						<td align="center" class="c">{Debris}</td>
						<td align="center" class="c">{Player}</td>
						<td align="center" class="c">{Alliance}</td>
						<td align="center" class="c">{Actions}</td>
					</tr>
					<!-- START BLOCK : planets -->
					<tr height="24">
						<th align="center">{i}</th>
						<th>{planet}</th>
						<th>{planet_status}</th>
						<th align="center">{moon}</th>
						<th align="center" class="{debris_class}">{debris}</th>
						<th align="center">{user_info}</th>
						<th align="center">{ally_info}</th>
						<th align="right">{actions}</th>
					</tr>
					<!-- END BLOCK : planets -->
				</tbody>
			</table>		</td>
		<td width="112" rowspan="2" valign="top">
			<!-- START BLOCK : movement -->
			<table border="0" height="100%" align="center" cellpadding="2" cellspacing="2">
				<form action="{PHP_SELF}" method="post" id="galaxy_form">
				<tr>
				  <td width="50%" height="30" align="center" class="c"><table width="100%" border="0" cellpadding="2" cellspacing="2">
                    <tr>
                      <td align="center">{Galaxy}</td>
                    </tr>
                    <tr>
                      <td><table align="center">
                          <tr>
                            <td><input name="galaxyLeft" value="&laquo;" onClick="galaxy_submit('galaxyLeft')" type="button" /></td>
                            <td><input name="galaxy" value="{galaxy}" size="5" maxlength="3" tabindex="1" type="text" /></td>
                            <td><input name="galaxyRight" value="&raquo;" onClick="galaxy_submit('galaxyRight')" type="button" /></td>
                          </tr>
                      </table></td>
                    </tr>
                  </table></td>
				  </tr>
				<tr>
				  <td class="c" height="30" align="center"><table width="100%" border="0" cellpadding="2" cellspacing="2">
                      <tr>
                        <td align="center">{Solar_system}</td>
                      </tr>
                      <tr>
                        <td><table align="center">
                            <tr>
                              <td><input name="systemLeft" value="&laquo;" onClick="galaxy_submit('systemLeft')" type="button" /></td>
                              <td><input name="system" value="{system}" size="5" maxlength="3" tabindex="1" type="text" /></td>
                              <td><input name="systemRight" value="&raquo;" onClick="galaxy_submit('systemRight')" type="button" /></td>
                            </tr>
                        </table></td>
                      </tr>
                  </table></td>
				  </tr>
				<tr height="20">
				  	<th><input value="{Show}" type="submit"><input id="auto" value="dr" type="hidden"></th>
				</tr>
				<tr height="50">
			  	  <th><div id="loading" align="center"><img src="images/loading-animation.gif" hspace="4" vspace="0" /><br>{loading_fleet}</div></th>
				</tr>
				<tr>
				  <th valign="top">
                  <div align="left" id="response"></div>
                  <table width=100%>
                    <tr>
                      <td class=c colspan=2>{Legend}</td>
                    </tr>
                    <tr>
                      <td>{Strong_player}</td>
                      <td align="center"><span class=strong>{strong_player_shortcut}</span></td>
                    </tr>
                    <tr>
                      <td>{Weak_player}</td>
                      <td align="center"><span class=noob>{weak_player_shortcut}</span></td>
                    </tr>
                    <tr>
                      <td>{Way_vacation}</td>
                      <td align="center"><span class=vacation>{vacation_shortcut}</span></td>
                    </tr>
                    <tr>
                      <td>{Pendent_user}</td>
                      <td align="center"><span class=banned>{banned_shortcut}</span></td>
                    </tr>
                    <tr>
                      <td>{Inactive_7_days}</td>
                      <td align="center"><span class=inactive>{inactif_7_shortcut}</span></td>
                    </tr>
                    <tr>
                      <td>{Inactive_28_days}</td>
                      <td align="center"><span class=longinactive>{inactif_28_shortcut}</span></td>
                    </tr>
                    <tr>
                      <td>Admin</td>
                      <td align="center"><font color=lime><blink>A</blink></font></td>
                    </tr>
                  </table></th>
				  </tr>
				</form>
			</table>
			<!-- END BLOCK : movement -->		</td>
	</tr>
	<tr>
	  <td valign="top"><table width="100%" border="0">
        <tr>
          <td class="c" colspan="2" align="center">Disponibilidad</td>
        </tr>
        <tr>
          <td width="14%" align="right"><span id="c_mip">{CurrentMIP}</span></td>
          <td width="86%">{gf_mi_title}</td>
        </tr>
        <tr>
          <td align="right"><span id="c_spy">{SpyProbes}</span></td>
          <td>{gf_sp_title}</td>
        </tr>
        <tr>
          <td align="right"><span id="c_rec">{Recyclers}</span></td>
          <td>{gf_rc_title}</td>
        </tr>
      </table></td>
	  </tr>
</table>

	  </td>
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
<script src="scripts/jquery.js" type="text/javascript"></script>
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
		
		sendData = 	"galaxy=" + galaxy 
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
			url: 'flotenajax.php', 
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
					$("#response").html('Unespected Ajax Error');
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
