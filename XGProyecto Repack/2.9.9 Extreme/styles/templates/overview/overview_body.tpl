 
<script type="text/javascript">
    <!--
    date = new Date("{time}");
    function time()
    {
        var hours=date.getHours();
        var minutes=date.getMinutes();
        var seconds=date.getSeconds();
        if(hours<10){ hours='0'+hours;}
        if(minutes<10){minutes='0'+minutes;}
        if(seconds<10){seconds='0'+seconds;}
        output=hours+":"+minutes+":"+seconds;
        document.getElementById('live_time').innerHTML=output;
        date.setSeconds(date.getSeconds()+1);
        setTimeout("time()",1000);
    }
    //-->
</script>
<br />
<br />
<div id="content">
    <table width=530>
        <tr>
            <th colspan="4"><a href="game.php?page=overview&mode=renameplanet" title="{Planet_menu}">{ov_planet} "{planet_name}"</a> </th>
        </tr>
        <tr>
             <td colspan="4" class="c"><div align="center" class="Estilo4">Noticias</div></td>
        </tr>
           {NewsFrame}
        <tr>

                   	<th width="160">{ov_server_time}</th>
        	<th colspan="3">{date_time}</th>
        </tr>
		<tr>
            	<th width="160"><img src="styles/img-rango/{rankimg}" width="20" height="40"></th>
        	<th colspan="3"><b>Rank:</b> {rankgame}</th>
        </tr>
		<tr>
        	<td colspan="4" class="c">&nbsp;Aliança:  {ally_name}</td>
         </tr>
		<tr>
        <th width="160">Online Administrators</th>
            <th colspan="3"><font color="Green"><b>{OnlineAdmins}</b></font></th>
        </tr>
		<tr>
        <th width="160" rowspan="5"><img src="{imgrace}"/" " height="100" width="100"></th>
            <th align="left" colspan="3">
			<p align="center"><font color="#C0C0C0">Player Stats</font></th>
        </tr>
		<tr>
            <th align="left" colspan="2"><font color="#00CC99">Edificios</font></th>
            <th align="left">{puntos_edificios} <font color="lime">({top_edificios})</font></th>
        </tr>
		<tr>
            <th align="left" colspan="2"><font color="#00CC99">Flota</font></th>
            <th align="left">{puntos_naves} <font color="lime">({top_naves})</font></th>
        </tr>
		<tr>
            <th align="left" colspan="2"><font color="#00CC99">Defensa</font></th>
            <th align="left">{puntos_defensa} <font color="lime">({top_defensa})</font></th>
        </tr>
		<tr>
            <th align="left" colspan="2"><font color="#00CC99">Investigaciones</font></th>
            <th align="left">{puntos_investigaciones} <font color="lime">({top_investigaciones})</font></th>
        </tr>
		<tr>
        <th width="160">{race}</th>
            <th colspan="3"><font color="red">{user_rank}</font></th>
        </tr>
          {STAATSFORM_LINK} 
        <tr>
            <th colspan="4">
			<table border="1" width="100%">
				<tr>
        	<td align="Center" class="c"><div class="pre-spoiler"> <input type="button" value="Eventos" style="width:80px;font-size:10px;margin:1px;padding:0px;" onclick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = '';this.innerText = ''; this.value = 'FECHAR'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.value = 'Eventos';}"> </div> <div> <div class="spoiler" style="display: left;"> 
          <table  align="center"> 
          {fleet_list} 
       </table>  </th> 
     </tr>
				</tr>
			</table>
			</th>
        </tr>
                                
         <td colspan="4">
              <div style="background-image: url({dpath}planeten/{planet_image}.jpg); background-repeat:no-repeat; height:300px; margin:0px
auto; position:relative; width:650px; margin-bottom:0px; font-weight: bold;">
                <div id="planetdata">
                  <div id="planetDetails">
                    <table cellpadding="0" cellspacing="0" width="100%">
                      <tbody>
                        <tr>
                          <td class="transparent" style="text-align: left; color: #09F; font-weight: bold;"><span id="diameterField">{ov_diameter}:</span></td>
                          <td class="transparent" style="text-align: right; font-weight: bold;" title="|Di&aacute;metro, n&uacute;mero de campos usados y campos m&aacute;ximos disponibles">{planet_diameter} {ov_distance_unit} (<a title="{ov_developed_fields}">{planet_field_current}</a> / <a title="{ov_max_developed_fields}">{planet_field_max}</a> {ov_fields})</td>
                        </tr>
                        <tr>
                          <td class="transparent" style="text-align: left; color: #09F; font-weight: bold;"><span id="temperatureField">{ov_temperature}:</span></td>
                          <td class="transparent" style="text-align: right; font-weight: bold;" title="|Temperatura del planeta">{ov_aprox} {planet_temp_min}{ov_temp_unit} {ov_to} {planet_temp_max}{ov_temp_unit}</td>
                        </tr>
                        <tr>
                          <td class="transparent" style="text-align: left; color: #09F; font-weight: bold;"><span id="positionField">{ov_position}:</span></td>
                          <td class="transparent" style="text-align: right; font-weight: bold;"><a href="game.php?page=galaxy&mode=0&galaxy={galaxy_galaxy}&system={galaxy_system}">[{galaxy_galaxy}:{galaxy_system}:{galaxy_planet}]</a></td>
                        </tr>
                        <tr>
                          <td class="transparent" style="text-align: left; color: #09F; font-weight: bold;"><span id="scoreField">
							{ov_points}:</span></td>
                          <td class="transparent" style="text-align: right; font-weight: bold;" rel="#highscoreTT"><font color="">
							{user_rank}</font></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div id="moon">{moon_img}</br>{moon}</div>
            </div></td>
        </tr>
        <tr>
        <td colspan="2"><p align="center">Campo de escombros</td>
        <td colspan="2"><font color=yellow>Metal:</font> <strong>{metal_debris}</strong> / <font color="#0174DF">Cristal:</font> <strong>{crystal_debris}</strong>{get_link}</td>
        </tr>
        <tr>
        <td colspan="4">{overview_produccion}</td>
        <tr>
  <td colspan="4" align="Center" class="a"><div class="pre-spoiler"> <span style="float:left; padding-top: 3px;"></span> <input type="button" value="COLONIAS" style="width:80px;font-size:10px;margin:1px;padding:0px;" onclick="if (this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display != '') { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = '';this.innerText = ''; this.value = 'FECHAR'; } else { this.parentNode.parentNode.getElementsByTagName('div')[1].getElementsByTagName('div')[0].style.display = 'none'; this.value = 'COLONIAS';}"> </div> <div> <div class="spoiler" style="display: none;">
          <table  align="center">
          {anothers_planets}
       </table> 
  </tr>
   		<tr>
<th width="160" >Campos ocupados</th>
<th colspan="3" align="center">
<div  style="border: 1px solid rgb(153, 153, 255); width: 400px;">
<div  id="CaseBarre" style="background-color: {case_barre_barcolor}; width: {case_barre}px;">
<font color="#CCF19F">{case_pourcentage}%</font>&nbsp;</div>        </th>
		</tr>
	<tr>
        <th colspan="1">BANNER</th>
            <th colspan="3"><input  value="banner.php?id={id}" size=40 type="text"  readonly="readonly"></th>
                </tr><tr>
            <th colspan="4"><img  src="banner.php?id={id}"> </th>
        
        </tr>
		<tr>
   <td class="c" colspan="4" align="Center">&nbsp;</td>
		</tr>
   </table>
	