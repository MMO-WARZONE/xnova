<!--
info.cuenta.php
Creado por Neko para XG Proyect - xtreme-gamez
-->

<script>document.body.style.overflow = "auto";</script> 

<body>
<!DOCTYPE HTML>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.min.js"></script>
<script type="text/javascript" src="../scripts/animatedcollapse.js"></script>
<script type="text/javascript">

animatedcollapse.addDiv('pla', 'fade=1,height=auto')
animatedcollapse.addDiv('inves', 'fade=1,height=auto')
animatedcollapse.addDiv('info', 'fade=1,height=auto')
animatedcollapse.addDiv('recursos', 'fade=1,height=auto')
animatedcollapse.addDiv('edificios', 'fade=1,height=auto')
animatedcollapse.addDiv('especiales', 'fade=1,height=auto')
animatedcollapse.addDiv('naves', 'fade=1,height=auto')
animatedcollapse.addDiv('defensa', 'fade=1,height=auto')
animatedcollapse.addDiv('datos', 'fade=1,height=auto')
animatedcollapse.addDiv('editar', 'fade=1,height=auto')
animatedcollapse.addDiv('destr', 'fade=1,height=auto')

animatedcollapse.ontoggle=function($, divobj, state){
}

animatedcollapse.init()
</script>
<style>
td
{
	color: #000000;
	margin: 3px;
	padding: 3px;
	font-size: 15px;
	font-weight: bold;
	border-bottom-width: medium;
	border-bottom-style: groove;
	border-bottom-color: #000000;
}

.editar_l
{
	color:#990000;
	font-size:11;
}
.editar_l:hover
{
	color:#FF0000;
	font-size:11;
}
</style>

<!--Datos de la cuenta-->
<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="60%" align="center" valign="top">
<tr>
<td width="7%" align="left" colspan="0"><span style="font-size:15"><font color="#000000">{ac_account_data}</font></span>
<a href="javascript:animatedcollapse.toggle('datos')"><div align="right">{ac_minimize_maximize}</div></a></td>
</tr>
</table>
<div id="datos">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="60%">
<tr><th>{ac_id}</th><th>{id}</th></tr>
<tr><th>{ac_name}</th><th>{nombre}</th></tr>
<tr><th>{ac_password}</th><th>{contra}</th></tr>
<tr><th>{ac_mail}</th><th>{email_1}</th></tr>
<tr><th>{ac_perm_mail}</th><th>{email_2}</th></tr>
<tr><th>{ac_auth_level}</th><th>{nivel}</th></tr>
<tr><th>{ac_on_vacation}</th><th>{vacas}</th></tr>
<tr><th>{ac_banned}</th><th>{suspen}</th></tr>
<tr><th>{ac_alliance}</th><th>{alianza}{id_ali}</th></tr>
<tr><th>{ac_reg_ip}</th><th>{ip}</th></tr>
<tr><th>{ac_last_ip}</th><th>{ip2}</th></tr>
<tr><th>{ac_home_planet_id}</th><th>{id_p}</th></tr>
<tr><th>{ac_home_planet_coord}</th><th>[{g}:{s}:{p}]</th></tr>
<tr><th>{ac_user_system}</th><th>{info}</th></tr>
</table>
</div>
<br /><br />



<!--Informacion detallada de planetas y lunas-->
<br /><br /><br /><br />
<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="100%" align="center" valign="top">
<tr>
<td></td>
</tr>
<tr>
<td width="7%" align="left" colspan="0"><span style="font-size:15"><font color="#000000">{ac_detailed_planet_moon_info}</font></span>
<a href="javascript:animatedcollapse.toggle('info')"><div align="left">{ac_minimize_maximize}</div></a></td>
</tr>
</table>
<br />



<div id="info">
<!--Planetas y lunas-->
<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="20%" align="center" valign="top">
<tr>
<td width="7%" align="center" colspan="0">{ac_id_names_coords}
<a href="javascript:animatedcollapse.toggle('pla')"><div align="center">{ac_minimize_maximize}</div></a></td>
</tr>
</table>
<div id="pla" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="70%">
<tr>
<td width="6%" align="center" valign="top">{ac_id}</td>
<td width="35%" align="center" valign="top">{ac_name}</td>
<td width="15%" align="center" valign="top">{ac_coords}</td>
<td width="15%" align="center" valign="top">{ac_diameter}</td>
<td width="15%" align="center" valign="top">{ac_fields}</td>
<td width="25%" align="center" valign="top">{ac_temperature}</td>
</tr>
{planetas}
</table>
<br>
</div>
<br />


<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="25%" align="center" valign="top">
<tr>
<td width="7%" align="center" colspan="0"><span style="font-size:15"><font color="#000000">{ac_resources}</font></span>
<a href="javascript:animatedcollapse.toggle('recursos')"><div align="center">{ac_minimize_maximize}</div></a></td>
</tr>
</table>
<div id="recursos" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%">
<td width="12%" align="center" colspan="0"><center>{ac_resources}</center></td>
<center>{planetas2}</center>
<tr><th>{Metal}</th>{metal}</tr>
<tr><th>{Crystal}</th>{cristal}</tr>
<tr><th>{Deuterium}</th>{deute}</tr>
<tr><th>{Energy}</th>{energia}</tr>
</table>
<br />
<table border="5" cellpadding="2" cellspacing="5" style="border-collapse: collapse" bordercolor="#000000" width="50%">
<tr><td width="25%" align="center" colspan="0">{Darkmatter}</td><th width="50%" align="center" colspan="0">{mo}</th></tr>
</table>
</div>
<br />


<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="30%" align="center" valign="top">
<tr>
<td width="7%" align="center" colspan="0"><span style="font-size:15"><font color="#000000">{ad_buildings}</font></span>
<a href="javascript:animatedcollapse.toggle('edificios')"><div align="center">{ac_minimize_maximize}</div></a></td>
</tr>
</table>
<div id="edificios" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%">
<td width="12%" align="center" colspan="0"><center>{ad_buildings}</center></td>
{planetas2}
<tr><th>{ad_metal_mine}</th>{mina_metal}</tr>
<tr><th>{ad_crystal_mine}</th>{mina_cristal}</tr>
<tr><th>{ad_deuterium_sintetizer}</th>{mina_deu}</tr>
<tr><th>{ad_solar_plant}</th>{planta_s}</tr>
<tr><th>{ad_fusion_plant}</th>{planta_f}</tr>
<tr><th>{ad_robot_factory}</th>{fabrica}</tr>
<tr><th>{ad_nano_factory}</th>{nanos}</tr>
<tr><th>{ad_shipyard}</th>{hangar}</tr>
<tr><th>{ad_metal_store}</th>{almacen_m}</tr>
<tr><th>{ad_crystal_store}</th>{almacen_c}</tr>
<tr><th>{ad_deuterium_store}</th>{almacen_d}</tr>
<tr><th>{ad_laboratory}</th>{labo}</tr>
<tr><th>{ad_terraformer}</th>{terra}</tr>
<tr><th>{ad_ally_deposit}</th>{ali}</tr>
<tr><th>{ad_silo}</th>{silo}</tr>
</table>
</div>
<br />

<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="35%" align="center" valign="top">
<tr>
<td width="7%" align="center" colspan="0"><span style="font-size:15"><font color="#000000">{ac_lunar_buildings}</font></span>
<a href="javascript:animatedcollapse.toggle('especiales')"><div align="center">{ac_minimize_maximize}</div></a></td>
</tr>
</table>
<div id="especiales" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%">
<td width="12%" align="center" colspan="0"><center>{ac_short_lunar_buildings}</center></td>
{lunas}
<tr><th>{ac_lunar_base}</th>{base}</tr>
<tr><th>{ac_phalanx}</th>{phalanx}</tr>
<tr><th>{ac_jump_gate}</th>{salto}</tr>
</table>
</div>
<br />

<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="40%" align="center" valign="top">
<tr>
<td width="7%" align="center" colspan="0"><span style="font-size:15"><font color="#000000">{ac_ships}</font></span>
<a href="javascript:animatedcollapse.toggle('naves')"><div align="center">{ac_minimize_maximize}</div></a></td>
</tr>
</table>
<div id="naves" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%">
<td width="12%" align="center" colspan="0"><center>{ac_ships}</center></td>
{planetas2}
<tr><th>{ad_small_ship_cargo}</th>{peque}</tr>
<tr><th>{ad_big_ship_cargo}</th>{grande}</tr>
<tr><th>{ad_light_hunter}</th>{ligero}</tr>
<tr><th>{ad_heavy_hunter}</th>{pesado}</tr>
<tr><th>{ad_crusher}</th>{cru}</tr>
<tr><th>{ad_battle_ship}</th>{nave}</tr>
<tr><th>{ad_colonizer}</th>{colo}</tr>
<tr><th>{ad_recycler}</th>{reci}</tr>
<tr><th>{ad_spy_sonde}</th>{sondas}</tr>
<tr><th>{ad_bomber_ship}</th>{bomba}</tr>
<tr><th>{ad_solar_satelit}</th>{satelite}</tr>
<tr><th>{ad_destructor}</th>{destru}</tr>
<tr><th>{ad_dearth_star}</th>{edlm}</tr>
<tr><th>{ad_battleship}</th>{aco}</tr>
<tr><th>{ac_supernova}</th>{supernova}</tr>
</table>
</div>
<br />

<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="45%" align="center" valign="top">
<tr>
<td width="7%" align="center" colspan="0"><span style="font-size:15"><font color="#000000">{ac_defense}</font></span>
<a href="javascript:animatedcollapse.toggle('defensa')"><div align="center">{ac_minimize_maximize}</div></a></td>
</tr>
</table>
<div id="defensa" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="100%">
<td width="12%" align="center" colspan="0"><center>{ac_defense}</center></td>
{planetas2}
<tr><th>{ad_misil_launcher}</th>{lanza}</tr>
<tr><th>{ad_small_laser}</th>{laser_p}</tr>
<tr><th>{ad_big_laser}</th>{laser_g}</tr>
<tr><th>{ad_gauss_canyon}</th>{gauss}</tr>
<tr><th>{ad_ionic_canyon}</th>{ionico}</tr>
<tr><th>{ad_buster_canyon}</th>{plasma}</tr>
<tr><th>{ad_small_protection_shield}</th>{c_peque}</tr>
<tr><th>{ad_big_protection_shield}</th>{c_grande}</tr>
<tr><th>{ac_planet_protector}</th>{protector}</tr>
<tr><th>{ad_interceptor_misil}</th>{misil_i}</tr>
<tr><th>{ad_interplanetary_misil}</th>{misil_in}</tr>
</table>
</div>
<br />


<!--Investigaciones y oficiales-->
<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="50%" align="center" valign="top">
<tr>
<td width="7%" align="center" colspan="0"><span style="font-size:15"><font color="#000000">{ac_officier_research}</font></span>
<a href="javascript:animatedcollapse.toggle('inves')"><div align="center">{ac_minimize_maximize}</div></a></td>
</tr>
</table>
<div id="inves" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="60%">
<tr>
<td width="40%" align="center" valign="top">{ac_research}</td>
<td width="40%" align="center" valign="top">{ac_officier}</td>
</tr>
{investi}
</table>
</div>
<br />

<!--Planetas y lunas destruidos-->
<table border="0" style="border-collapse: collapse" bordercolor="#000000" width="55%" align="center" valign="top">
<tr>
<td width="7%" align="center" colspan="0">{ac_recent_destroyed_planets}
<a href="javascript:animatedcollapse.toggle('destr')"><div align="center">{ac_minimize_maximize}</div></a></td>
</tr>
</table>
<div id="destr" style="display:none">
<table border="5" cellpadding="5" cellspacing="0" style="border-collapse: collapse" bordercolor="#000000" width="60%">
<tr>
<td width="6%" align="center" valign="top">{ac_id}</td>
<td width="40%" align="center" valign="top">{ac_name}</td>
<td width="30%" align="center" valign="top">{ac_coords}</td>
</tr>
{planetas_d}
</table>
</div>
</div>
</body>