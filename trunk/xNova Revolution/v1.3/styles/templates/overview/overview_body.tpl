<style type="text/css">
<!--
.tborder {	background: #FFFFFF;
	color: #333333;
	border: 1px solid #CCCCCC;
}
.vbmenu_control {	background: #19579E url({dpath}img/menu/mo.png) repeat-x top left;
	color: #FFFFFF;
	font: bold 11px tahoma, verdana, geneva, lucida, 'lucida grande', arial, helvetica, sans-serif;
	padding: 3px 3px 3px 3px;
	white-space: nowrap;
}
.Estilo2 {font-size: 12px}
-->
</style>
<br />
<br />
<div id="content">
<script language="JavaScript" type="text/javascript" src="scripts/time.js"></script>
<script language="JavaScript" type="text/javascript" src="scripts/overlib.js"></script>

    <table width="">
            {Have_new_message}
              <tr>              </tr>
              
           <td colspan="4" class="c"><div align="center">{ov_events}</div>
          {fleet_list}        </tr>
       	  <th colspan="2" >
		  <div style="background-image: url({dpath}planeten/{planet_image}.jpg);background-repeat:no-repeat;height:255px;margin:0px
auto;position:relative;width:650px;margin-bottom:0px ">
            <div style="position: absolute; left: 160px;top: 8px; font-size: 16px" >V<span class="Estilo2">ision General - {planet_name} </span><a href="game.php?page=overview&amp;mode=renameplanet"><img style="" class="tips hinted" title="|abandona/renombra Planeta" src="{dpath}img/en.gif"></a><font style="font-size:10px"></div>
            <div style="position: absolute; left: 513px; top: 0px; font-size: 16px; width: 142px;" >
              <p><a href="game.php?page=messages"><img style="" class="tips hinted" title="|Aca tenes tus aviso de Mensajes|" src="{dpath}img/post_off.png" /></a></p>
              <p>{lm_messages} {new_message}</p>
            <font style="font-size:10px"></div>
            <!--<h2></h2>
			-->
            <div style="position: absolute; left: 50px; top: 31px; font-size: 16px" >{moon_img}</div>
            <div style="position: absolute; left: 38px; top: 180px; font-size: 16px" >
              <p><img src="styles/img-rango/{rankimg}" alt="" class="tips hinted" style="" title="Tu rango es: {rankgame}" /></p>
              <p>{rankgame}</p>
            </div>
<div style="float: right;margin:140px 5px 0px 0px;
	width:255px;font-size:10px; background-color:transparent; text-align: left">
				<br>
                <br>
                <br>
			<b>{ov_diameter}: {planet_diameter} {ov_distance_unit}  [{planet_field_current} / {planet_field_max} {fields}]<br>
			<b>{ov_temperature}: {ov_aprox} {planet_temp_min}{ov_temp_unit} {ov_to} {planet_temp_max}{ov_temp_unit}<br>
			<b>{ov_position}: <a href="game.php?page=galaxy&mode=0&galaxy={galaxy_galaxy}&system={galaxy_system}">[{galaxy_galaxy}:{galaxy_system}:{galaxy_planet}]</a><br>
<b>{ov_total_rnk}: <a href="game.php?page=statistics&amp;range=" onmouseover='return overlib("<table width=240 background={dpath}img/box.gif><tr><td class=c colspan=3><font color=lime>Jugador :</font> {user_username}</td></tr><tr><td class=header width=50%><font color=lime>{ov_bildings} :</font></td><td class=header>{puntos_edificios}<td class=header><font color=lime>({top_edificios})</font></td></tr><tr><td class=header width=50%><font color=lime>{ov_defe} :</font> </td><td class=header>{puntos_defensa}<td class=header><font color=lime>({top_defensa})</font></td></tr><tr><td class=header width=50%><font color=lime>{ov_fleet} :</font> </td><td class=header>{puntos_naves}<td class=header><font color=lime>({top_naves})</font></td></tr><tr><td class=header width=50%><font color=lime>{ov_tech} :</font> </td><td class=header>{puntos_investigaciones} <td class=header><font color=lime>({top_investigaciones})</font></td></tr>", MOUSEOFF, CENTER, OFFSETX, -60, OFFSETY, -140 );' onmouseout="return nd();"><font color="red">{user_rank}</font></a></br>
 </td>
                <b>{ov_options}: <a href="game.php?page=overview&mode=renameplanet">Renombrar | Abandonar</a><br>
				
        </tr>
	    <tr>        </tr>
        <tr>
            <th colspan="4">
                {overview_produccion}            </th>
        </tr>
    </table>
  <td colspan="4" class="c">
    </table>
</div>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
