<?php //overview.php

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;


{// init
	include("common.php");
	include("cookies.php");
	$userrow = checkcookies();//Identificación del usuario
	CheckUserExist($userrow);
	include(INCLUDES_PATH."planet_toggle.php");//Cambia de planeta
	$planetrow = doquery("SELECT * FROM {{table}} WHERE id={$userrow[current_planet]}",'planets',true);
	$galaxyrow = doquery("SELECT * FROM {{table}} WHERE id_planet={$planetrow["id"]}",'galaxy',true);
	$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];
	check_field_current($planetrow);
}

echo_head($lang['Overview']);
echo_topnav();
echo <<<HTML
<center>
<br>
<table width="519">
  <tr>
	<td class="c" colspan="4">
	  <a href="renameplanet.php" title="{$lang[Planet_menu]}">{$lang[Planet]} "{$planetrow[name]}"</a> ({$userrow[username]})
	</td>
  </tr>
HTML;

if($userrow['new_message'] == 1){
	echo "<tr><th colspan=\"4\"><a href=\"messages.php\">{$lang[Have_new_message]}</a></th></tr>";
}elseif($userrow['new_message'] > 1){
	echo "<tr><th colspan=\"4\"><a href=\"messages.php\">";
	$m = number_format($userrow['new_message'],0,',','.');
	echo str_replace('%m',$m,$lang['Have_new_messages']);
	echo "</a></th></tr>";
}

echo <<<HTML
  <tr>
	<th>{$lang[Server_time]}</th>
	<th colspan="3">
HTML;
echo gmdate("D M d H:i:s",time()-3*60*60);
echo <<<HTML
	</th>
  </tr>
  <tr>
	<td colspan="4" class="c">{$lang[Events]}</td>
  </tr>
  <script language="javascript"> anz=0; t(); </script>
  <tr>
	<th></th>
	<th colspan="2">
	  <img src="{$dpath}planeten/{$planetrow[image]}.jpg" height="200" width="200">
	  <br>
	</th>
	<th class="s">
      <table class="s" align="top" border="0">
		<tr>
HTML;
	/*
	  Cuando un jugador tiene mas de un planeta, se muestra una lista de ellos a la derecha.
	*/
	
	$planets_query = doquery("SELECT * FROM {{table}} WHERE `id_owner`=".$userrow["id"],"planets");
	
	$c = 1;
	while($p = mysql_fetch_array($planets_query)){
		
		if($p["id"] != $userrow["current_planet"]){
			echo <<<HTML
		<th>{$p[name]}<br>
		  <a href="overview.php?cp={$p[id]}" title="{$p[name]}"><img src="{$dpath}planeten/small/s_{$p[image]}.jpg" height="50" width="50"></a><br>
		  <center>
HTML;
			/*
			  Gracias al 'b_building_id' y al 'b_building' podemos mostrar en el overview
			  si se esta construyendo algo en algun planeta.
			*/
			if($p['b_building_id'] != 0){
				if(check_building_progress($p)){echo $tech[$p['b_building_id']];}
				else{echo $lang['Free'];}
			}else{echo $lang['Free'];}
			
			echo'<center></center></center></th>';
			//Para ajustar a dos columnas
			if($c <= 1){$c++;}else{echo '</tr><tr>';$c = 1;	}
		}
	}
echo <<<HTML
		</tr>
     </table>
    </th>
    </tr>
  <tr>
      <th>
    {$lang[Diameter]}</th><th colspan="3">{$lang[diameter]} km (<a title="{$lang[Developed_fields]}">{$planetrow[field_current]} </a> / <a title="{$lang[max_eveloped_fields]}">{$planetrow[field_max]} </a> {$lang[fields]})</th>
  </tr>
  <tr>
	<th>{$lang[Temperature]}</th> <th colspan="3">{$lang[approx]} {$planetrow[temp_min]}°C {$lang[to]} {$planetrow[temp_max]}°C</th> </tr>   <tr>
	<th>{$lang[Position]}</th><th colspan="3">{$galaxyrow[galaxy]}:{$galaxyrow[system]}:{$galaxyrow[planet]}</th></tr>   <tr>
	<th>{$lang[Points]}</th><th colspan="3">{$userrow[points]} ({$lang[Rank]} <a href="stat.php?start={$userrow[points]}">????</a> {$lang[of]} ????)</th>
  </tr>
</table>
 <br>
</center>
  <script language="JavaScript" src="scripts/wz_tooltip.js"></script>
</body>
</html>
HTML;

//  Timer, para comprobar la velocidad del scriptd
if($userrow['authlevel'] == 3){
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoFin = $tiempo;
	$tiempoReal = ($tiempoFin - $tiempoInicio);
	echo $depurerwrote001.$tiempoReal.$depurerwrote002.$numqueries.$depurerwrote003;
}
// Created by Perberos. All rights reversed (C) 2006
?>