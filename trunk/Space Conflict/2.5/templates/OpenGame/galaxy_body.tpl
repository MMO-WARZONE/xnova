<script language="JavaScript">
    function galaxy_submit(value) {
      document.getElementById('auto').name = value;
      document.getElementById('galaxy_form').submit();
    }

    function fenster(target_url,win_name) {
      var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=640,height=480,top=0,left=0');
new_win.focus();
    }
  </script>
<script language="JavaScript" src="scripts/tw-sack.js"></script>
<script type="text/javascript">
var ajax = new sack();
var strInfo = "";
      
function whenLoading(){
  //var e = document.getElementById('fleetstatus'); 
  //e.innerHTML = "{Sending_fleet}";
}
      
function whenLoaded(){
  //    var e = document.getElementById('fleetstatus'); 
  // e.innerHTML = "{Sent_fleet}";
}
      
function whenInteractive(){
  //var e = document.getElementById('fleetstatus'); 
  // e.innerHTML = "{Obtaining_data}";
}

/* 
   We can overwrite functions of the sack object easily. :-)
   This function will replace the sack internal function runResponse(), 
   which normally evaluates the xml return value via eval(this.response).
*/

function whenResponse(){

 /*
 *
 *  600   OK
 *  601   no planet exists there
 *  602   no moon exists there
 *  603   player is in noob protection
 *  604   player is too strong
 *  605   player is in u-mode 
 *  610   not enough espionage probes, sending x (parameter is the second return value)
 *  611   no espionage probes, nothing send
 *  612   no fleet slots free, nothing send
 *  613   not enough deuterium to send a probe
 *
 */

  // the first three digit long return value
  retVals = this.response.split(" ");
  // and the other content of the response
  // but since we only got it if we can send some but not all probes 
  // theres no need to complicate things with better parsing
  // each case gets a different table entry, no language file used :P
  switch(retVals[0]) {
  case "600":
    addToTable("done", "success");
        changeSlots(retVals[1]);
    setShips("probes", retVals[2]);
    setShips("recyclers", retVals[3]);
    setShips("missiles", retVals[4]);
        break;
  case "601":
    addToTable("{an_error_has_happened_while_it_was_sent}", "error");
    break;
  case "602":
    addToTable("{error_there_is_no_moon}", "error");
    break;
  case "603":
    addToTable("{error_the_player_is_under_the_protection_of_beginners}", "error");
    break;
  case "604":
    addToTable("{error_the_player_is_too_strong}", "error");
    break;
  case "605":
    addToTable("Nie mozna skanowac graczy bedacych na urlopie", "vacation");
    break;
  case "610":
    addToTable("{error_only_x_available_probes_sending}", "notice");
    break;
  case "611":
    addToTable("Brak sond szpiegowskich", "error");
    break;
  case "612":
    addToTable("Osiagnieta maksymalna ilosc flot", "error");
    break;
  case "613":
    addToTable("Masz za malo deuteru", "error");
    break;
  case "614":
    addToTable("Nie mozna skanowac planety nie skolonizowanej", "error");
    break;
  case "615":
    addToTable("{error_there_is_no_sufficient_fuel}", "error");
    break;
  case "616":
    addToTable("Multialarm!", "error");
    break;
  case "617":
	addToTable("Nie masz recyklerow", "error");
  break;
  }
}

function doit(order, galaxy, system, planet, planettype, shipcount){
  	if(order==2)	
	strInfo = "Wysylanie "+shipcount+" "+(shipcount>1?"sond":"sondy")+" na "+galaxy+":"+system+":"+planet+"...";
   if(order==8)	
	strInfo = "Wysylanie "+shipcount+" "+(shipcount>1?"recykler":"recyklerow")+" na "+galaxy+":"+system+":"+planet+"...";
    
    ajax.requestFile = "floten3.php?action=send";

    // no longer needed, since we don't want to write the cryptic
    // response somewhere into the output html
    //ajax.element = 'fleetstatus';
    //ajax.onLoading = whenLoading;
    //ajax.onLoaded = whenLoaded; 
    //ajax.onInteractive = whenInteractive;

    // added, overwrite the function runResponse with our own and
    // turn on its execute flag
    ajax.runResponse = whenResponse;
    ajax.execute = true;

    ajax.setVar("thisgalaxy", {tg})
    ajax.setVar("thissystem", {ts});
    ajax.setVar("thisplanet", {tp});
    ajax.setVar("thisplanettype", {tpt});
    ajax.setVar("speed210", 1000000000);
    ajax.setVar("speed209", 2000);
    ajax.setVar("mission", order);
    ajax.setVar("galaxy", galaxy);
    ajax.setVar("system", system);
    ajax.setVar("planet", planet);
    ajax.setVar("speedfactor", 1000);
    ajax.setVar("planettype", planettype);
    ajax.setVar("z_gali", 1);
    if(order==2)
    ajax.setVar("ship210", shipcount);
    if(order==8)
    ajax.setVar("ship209", shipcount);
    
    ajax.setVar("speed", 10);
    //ajax.setVar("reply", "short");
    ajax.runAJAX();

}

/*
 * This function will manage the table we use to output up to three lines of
 * actions the user did. If there is no action, the tr with id 'fleetstatusrow'
 * will be hidden (display: none;) - if we want to output a line, its display 
 * value is cleaned and therefore its visible. If there are more than 2 lines 
 * we want to remove the first row to restrict the history to not more than 
 * 3 entries. After using the object function of the table we fill the newly
 * created row with text. Let the browser do the parsing work. :D
 */
function addToTable(strDataResult, strClass) {
  var e = document.getElementById('fleetstatusrow');
  var e2 = document.getElementById('fleetstatustable');

  // make the table row visible
  e.style.display = '';
  
  if(e2.rows.length > 2) {
    e2.deleteRow(2);
  }
  
  var row = e2.insertRow('test');

  var td1 = document.createElement("td");
  var td1text = document.createTextNode(strInfo);
  td1.appendChild(td1text);

  var td2 = document.createElement("td");

  var span = document.createElement("span");
  var spantext = document.createTextNode(strDataResult);

  var spanclass = document.createAttribute("class");
  spanclass.nodeValue = strClass;
  span.setAttributeNode(spanclass);

  span.appendChild(spantext);
  td2.appendChild(span);
  
  row.appendChild(td1);
  row.appendChild(td2);
}

function changeSlots(slotsInUse) {
  var e = document.getElementById('slots');
  e.innerHTML = slotsInUse;
}

function setShips(ship, count) {
  var e = document.getElementById(ship);
  e.innerHTML = count;
}

</script>


<body onmousemove="tt_Mousemove(event);">
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
                            <td><input name="galaxyLeft" value="&laquo;" onClick="galaxy_submit('galaxyLeft')" type="button" /></td>
                            <td><input name="galaxy" value="{galaxy}" size="5" maxlength="3" tabindex="1" type="text" /></td>
                            <td><input name="galaxyRight" value="&raquo;" onClick="galaxy_submit('galaxyRight')" type="button" /></td>
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