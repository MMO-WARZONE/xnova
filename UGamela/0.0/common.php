<?php
// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;

extract($_POST,EXTR_SKIP);
extract($_GET,EXTR_SKIP);
extract($_COOKIE,EXTR_SKIP);

/* common.php
perberos@hotmail.com
common.php v1.4 build.2
Contiene las funciones más comunes
*/
define('INSIDE',TRUE);
//lenguaje...
//if($l){
//  define('DEFAULT_LANG',$l);
//}else{
  define('DEFAULT_LANG','en');
//}

define('INCLUDES_PATH',"includes/");
define('COOKIE_NAME',"ogamela");
//define('DEFAULT_SKINPATH',"http://80.237.203.201/download/use/brotstyle/");
define('DEFAULT_SKINPATH',"http://people.freenet.de/kakashi/Maya/");
//define('DEFAULT_SKINPATH',"css/");
header("X-Powered-By: Perberos");

@include(INCLUDES_PATH."lang/".DEFAULT_LANG."/lang_main.php");

$controlrow = array( 'flood_avatar' => false);
//para depurar
$numqueries = 0;
$depurerwrote001 = "\n<center>{$lang['Time']}: ";
$depurerwrote002 = "\n || {$lang['Queries']}: ";
$depurerwrote003 = "</center><table><tr><th>Nº</th><th>{$lang['Query']}</th><th>{$lang['Table']}</th><th>Fetch</th></tr>";


function doquery($query, $table, $fetch = false){
  global $link;
  
	@include('config.php');
  
  if(!$link){
	  $link = mysql_connect($dbsettings["server"], $dbsettings["user"], $dbsettings["pass"]) or error(mysql_error()."<br />$query","SQL Error");
	  mysql_select_db($dbsettings["name"]) or error(mysql_error()."<br />$query","SQL Error");
  }
  
	$sqlquery = mysql_query(str_replace("{{table}}", $dbsettings["prefix"] . "_" . $table, $query)) or error(mysql_error()."<br />$query","SQL Error");

	unset($dbsettings);//se borra la array para liberar algo de memoria

	global $numqueries,$depurerwrote003;
	$numqueries++;
	$depurerwrote003 .= "<tr><th>Query $numqueries: </th><th>$query</th><th>$table</th><th>$fetch</th></tr>";
	
	if($fetch){ //hace el fetch y regresa $sqlrow
	  $sqlrow = mysql_fetch_array($sqlquery);
	  return $sqlrow;
	}else{ //devuelve el $sqlquery ("sin fetch")
	  return $sqlquery;
   }
}

function error($mes,$title='Error'){
	global $userrow,$lang,$link;
	
	$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];

	echo <<<HTML
<html>
<head>
<title>{$lang['ErrorPage']}</title>
<link rel="stylesheet" type="text/css" href="{$dpath}formate.css" />
<meta http-equiv="content-type" content="text/html; charset={$lang['ENCODING']}" />
</head>
<body>
 <center>
 <br><br>

 <table width="519">
 <tr>
   <td class="c"><font color="red">$title</font></td>
  </tr>
  <tr>
   <th class="errormessage">$mes</th>

  </tr>
 </table>
 </center>
</body>
</html>
HTML;
  if(isset($link)) mysql_close();
	die();
}

function message($mes,$title,$dest = "",$time = "3",$color = "#C0A000"){
	global $userrow,$lang,$link;
	
	$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];
	
	echo <<<HTML
<html>
<head>
<title>$title</title>
<link rel="stylesheet" type="text/css" href="{$dpath}formate.css" />
<meta http-equiv="content-type" content="text/html; charset={$lang['ENCODING']}" />
HTML;
	if($dest){echo "\n<meta http-equiv=\"refresh\" content=\"$time;URL=javascript:self.location='$dest';\">\n";}
	echo <<<HTML
</head>
<body>
 <center>
 <br><br>

 <table width="519">
 <tr>
   <td class="c"><font color="$color">$title</font></td>
  </tr>
  <tr>
   <th class="errormessage">$mes</th>

  </tr>
 </table>
 </center>
</body>
</html>
HTML;
  if(isset($link)) mysql_close();
	die();
}

function display($page,$title = '',$topnav = true){
  global $link;
  echo_head($title);
  if($topnav){ echo_topnav();}
  echo "<center>\n$page\n</center>\n</body>\n</html>";
  if(isset($link)) mysql_close();
}

function CheckUserExist($user){
  global $lang,$link;
  
	if(!$user){
    if(isset($link)) mysql_close();
    error($lang['Please_Login'],$lang['Error']);
  }
}

function is_email($email){
  return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
}

function pretty_time($seconds){
	//Divisiones, y resto. Gracias Prody
	$day = floor($seconds / (24*3600));
	$hs = floor($seconds / 3600 % 24);
	$min = floor($seconds  / 60 % 60);
	$seg = floor($seconds / 1 % 60);
	
	$time = '';//la entrada del $time
	if($day != 0){ $time .= $day.'d ';}
	if($hs != 0){ $time .= $hs.'h ';}
	if($min != 0){ $time .= $min.'m ';}
	$time .= $seg.'s';
	
	return $time;//regresa algo como "[[[0d] 0h] 0m] 0s"
}

function echo_topnav(){

	global $userrow, $planetrow, $galaxyrow,$mode,$messageziel,$gid,$lang;

	if(!$userrow){return;}
	if(!$planetrow){ $planetrow = doquery("SELECT * FROM {{table}} WHERE id ={$userrow['current_planet']}","planets",true);}
	calculate_resources_planet($planetrow);//Actualizacion de rutina
	//if(!$galaxyrow){ $galaxyrow = doquery("SELECT * FROM {{table}} WHERE id_planet = '".$planetrow["id"]."'","galaxy",true);}
	$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];


echo <<<HTML

<center>
<table>
 <tr>
  <td></td>
  <td>
   <center>
   <table>
    <tr>
     <td><img src="{$dpath}planeten/small/s_{$planetrow['image']}.jpg" height="50" width="50"></td>
     <td>
      <select size="1" onChange="haha(this)">
HTML;
/*
  pequeño loop para agregar todos los planetas disponibles del mismo jugador...
*/

//pedimos todos los planetas que coincidan con el id del dueño.
	$planets_list = doquery("SELECT id,name,galaxy,system,planet FROM {{table}} WHERE id_owner = {$userrow['id']}","planets");

	while($p = mysql_fetch_array($planets_list)){
		/*
		  Cuando alguien selecciona destruir planeta, hay un tiempo en el que se vacia el slot
		  del planeta, es mas que nada para dar tiempo a posible problema de hackeo o robo de cuenta.
		*/
		if($p["destruyed"] == 0){
			
			//$pos_galaxy = doquery("SELECT * FROM {{table}} WHERE id_planet = {$p[id]}","galaxy",true);
			echo "\n	<option ";
			if($p["id"] == $userrow["current_planet"]) echo 'selected="selected" ';//Se selecciona el planeta actual
			echo "value=\"?cp={$p['id']}&amp;mode=$mode&amp;gid=$gid&amp;messageziel=$messageziel&amp;re=0\">";
			//Nombre [galaxy:system:planet]
			echo "{$p['name']} [{$p['galaxy']}:{$p['system']}:{$p['planet']}]</option>";
		}
	}

echo <<<HTML
     </select>
     <script language="JavaScript">function haha(z1) { eval("location='"+z1.options[z1.selectedIndex].value+"'");}</script>
     <table border="1"></table>
    </td>
   </tr>
  </table>
  </center>
  </td>
  <td>
   <table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
     <td align="center"></td>
     <td align="center" width="85">
      <img src="{$dpath}images/metall.gif" border="0" height="22" width="42">
     </td>
     <td align="center" width="85">
      <img src="{$dpath}images/kristall.gif" border="0" height="22" width="42">
     </td>
     <td align="center" width="85">
      <img src="{$dpath}images/deuterium.gif" border="0" height="22" width="42">
     </td>
     <td align="center" width="85">
      <img src="{$dpath}images/energie.gif" border="0" height="22" width="42">
     </td>
     <td align="center"></td>
    </tr>
    <tr>
     <td align="center"><i><b>&nbsp;&nbsp;</b></i></td>
     <td align="center" width="85"><i><b><font color="#ffffff">{$lang['Metal']}</font></b></i></td>
     <td align="center" width="85"><i><b><font color="#ffffff">{$lang['Crystal']}</font></b></i></td>
     <td align="center" width="85"><i><b><font color="#ffffff">{$lang['Deuterium']}</font></b></i></td>
     <td align="center" width="85"><i><b><font color="#ffffff">{$lang['Energy']}</font></b></i></td>
     <td align="center"><i><b>&nbsp;&nbsp;</b></i></td>
    </tr>
    <tr>
     <td align="center"></td>
     <td align="center" width="85">
HTML;
	/* 
	  Muestra los recursos, e indica si estos sobrepasan la capacidad de los almacenes
	*/
	$metal = number_format(floor($planetrow["metal"]),0,",",".");
	if(($planetrow["metal"] > $planetrow["metal_max"])){ echo "<font color=\"#ff0000\">$metal</font>";
	}else{echo $metal;}
	echo '</td>
     <td align="center" width="85">';
	$crystal = number_format(floor($planetrow["crystal"]),0,",",".");
	if(($planetrow["crystal"] > $planetrow["crystal_max"])){ echo "<font color=\"#ff0000\">$crystal</font>";
	}else{echo $crystal;}
	echo '</td>
     <td align="center" width="85">';
	$deuterium = number_format(floor($planetrow["deuterium"]),0,",",".");
	if(($planetrow["deuterium"] > $planetrow["deuterium_max"])){ echo "<font color=\"#ff0000\">$deuterium</font>";
	}else{echo $deuterium;}
	echo '</td>
     <td align="center" width="85">';
	$energy = number_format($planetrow["energy_free"],0,",",".")."/".number_format($planetrow["energy_max"],0,",",".");
	
	if(($planetrow["energy_free"] < $planetrow["energy_max"])){ echo "<font color=\"#ff0000\">$energy</font>";
	}else{echo $energy;}
	
	echo '</td>
     <td align="center"></td>
    </tr>
   </table>
  </td>
  </tr>
</table>
</center>
';
}

function echo_head($title = ''){

	global $userrow,$lang;
	
	$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];

	echo <<<HTML
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset={$lang['ENCODING']}">
<link rel="stylesheet" type="text/css" href="css/default.css">
<link rel="stylesheet" type="text/css" href="{$dpath}formate.css">
<title>{$title}</title>
</head>
<body>
HTML;

}

function calculate_resources_planet(&$planet){
  global $resource;
  /*
    calculate_resources_planet calcula y suma los recursos de un planeta dependiendo del ultimo acceso
    al planeta.
    El row de la base de datos last_update indica el tiempo inicial desde que se ejecuto el
    ultimo acceso al calculo de recursos.
    Cualquier usuario puede actualizar los recursos de otro planeta.
    Eso hace que se actualize sin la necesidad de que el dueño ingrese a su cuenta.
  */
	//Entonces calculamos el tiempo de inactividad desde la ultima actualizacion del planeta.
	$left_time = (time() - $planet['last_update']);
	$total_time = ($left_time + $planet['last_update']);//$total_time va a ser el nuevo last_update
	if($planet['energy_free']>=0){
	//y ahora se agregan los recursos.
	if($planet['metal'] < ($planet['metal_max'] + $planet['metal_max'] * 0.25))
	$planet['metal'] = $planet['metal'] + ($left_time * ($planet['metal_perhour']/60));
	
	if($planet['crystal'] < ($planet['crystal_max'] + $planet['crystal_max'] * 0.25))
	$planet['crystal'] = $planet['crystal'] + ($left_time * ($planet['crystal_perhour']/60));
	
	if($planet['deuterium'] < ($planet['deuterium_max'] + $planet['deuterium_max'] * 0.25))
	$planet['deuterium'] = $planet['deuterium'] + ($left_time * ($planet['deuterium_perhour']/60));
	}
  /*
    Tambien se debe actualizar el tema del hangar...
  */
  if($planet['b_hangar_id']!=''){
    $planet['b_hangar']+=$left_time;
    $b_hangar_id = explode(';',$planet['b_hangar_id']);
    
    foreach($b_hangar_id as $n => $array){
      if($array!=''){
        $array = explode(',',$array);
        $buildArray[$n] = array($array[0],$array[1],get_building_time('',$planet,$array[0]));
      }
    }
    
    $planet['b_hangar_id'] = '';
    
    foreach($buildArray as $a => $b){
      
      while($planet['b_hangar']>=$b[2]){
        
        if($b[1]>0){
          
          $planet['b_hangar']-=$b[2];
          $summon[$b[0]]++;
          $planet[$resource[$b[0]]]++;
          $b[1]--;
          
        }else{break;}//Fix, cuando queda tiempo de sobra. se creaba loop
        
      }
      if($b[1]!=0){
        $planet['b_hangar_id'] .= "{$b[0]},{$b[1]};";
      }
    }
  }else{$planet['b_hangar'] = 0;}
	//despues se actualiza el $planet y se actualiza la base de datos con el nuevo last_update
  $query = "UPDATE {{table}} SET
  metal='{$planet['metal']}',
  crystal='{$planet['crystal']}',
  deuterium='{$planet['deuterium']}',
  last_update=$total_time,
  b_hangar_id='{$planet['b_hangar_id']}',";
  //Para hacer las consultas, mas precisas
  if(isset($summon)){
    
    foreach($summon as $a => $b){
      
      $query .= "{$resource[$a]}='{$planet[$resource[$a]]}', ";
      
    }
    
  }
  $query .= "b_hangar='{$planet['b_hangar']}' WHERE id={$planet['id']}";
	doquery($query,'planets');
	
}

function check_field_current(&$planet){
	/*
	  Esta funcion solo permite actualizar la cantidad de campos en un planeta.
	*/
	global $resource;
	//sumatoria de todos los edificios disponibles
	$cfc = $planet[$resource[1]]+$planet[$resource[2]]+$planet[$resource[3]];
	$cfc += $planet[$resource[4]]+$planet[$resource[12]]+$planet[$resource[14]];
	$cfc += $planet[$resource[15]]+$planet[$resource[21]]+$planet[$resource[22]];
	$cfc += $planet[$resource[23]]+$planet[$resource[24]]+$planet[$resource[31]];
	$cfc += $planet[$resource[33]]+$planet[$resource[34]]+$planet[$resource[44]];
	
	//Esto ayuda a ahorrar una query...
	if($planet['field_current'] != $cfc){
		$planet['field_current'] = $cfc;
		doquery("UPDATE {{table}} SET field_current=$cfc WHERE id={$planet['id']}",'planets');
	}
}

function check_abandon_planet(&$planet){

	if($planet['destruyed'] <= time()){
		//Borrando el planeta...
		doquery("DELETE FROM {{table}} WHERE id={$planet['id']}",'planets');
		//Borrando referencias en la galaxia...
		doquery("UPDATE {{table}} SET id_planet=0 WHERE id_planet={$planet['id']}",'galaxy');
		
	}
}

function check_building_progress($planet){
	/*
	  Esta funcion es utilizada en el Overview.
	  Indica si se esta construyendo algo en el planeta
	*/
	if($planet['b_building'] > time()) return true;

}

function is_tech_available($user,$planet,$i){//comprueba si la tecnologia esta disponible

	global $requeriments,$resource;

	if($requeriments[$i]){ //se comprueba si se tienen los requerimientos necesarios
		
		$enabled = true;
		foreach($requeriments[$i] as $r => $l){
			
			if($user[$resource[$r]] && $user[$resource[$r]] >= $l){
			// break;
			}elseif($planet[$resource[$r]] && $planet[$resource[$r]] >= $l){
				$enabled = true;
			}else{
				return false;
			}
		}
		return $enabled;
	}else{
		return true;
	}
}

function is_buyable($user,$planet,$i,$userfactor=true){//No usado por el momento...

	global $pricelist,$resource;

	$level = (isset($planet[$resource[$i]])) ? $planet[$resource[$i]] : $user[$resource[$i]];
  $is_buyeable = true;
	//array
  $array = array('metal'=>$lang["Metal"],'crystal'=>$lang["Crystal"],'deuterium'=>$lang["Deuterium"],'energy'=>$lang["Energy"]);
  //loop
  foreach($array as $a => $b){
  
    if($pricelist[$i][$a] != 0){
      //echo "$b: ";
      if($userfactor)
        $cost = floor($pricelist[$i][$a] * pow($pricelist[$i]['factor'],$level));
      else
        $cost = floor($pricelist[$i][$a]);
        
      if($cost > $planet[$a]){
        $is_buyeable = false;
        
      }
    }
    
  }
	return $is_buyeable;
}

function echo_price($user,$planet,$i,$userfactor=true){//Usado
  global $pricelist,$resource,$lang;
  
  if($userfactor)
    $level = ($planet[$resource[$i]]) ? $planet[$resource[$i]] : $user[$resource[$i]];
  
  $is_buyeable = true;
  
  $array = array('metal'=>$lang["Metal"],'crystal'=>$lang["Crystal"],'deuterium'=>$lang["Deuterium"],'energy'=>$lang["Energy"]);
  echo "{$lang['Requires']}: ";
  foreach($array as $a => $b){
  
    if($pricelist[$i][$a] != 0){
      echo "$b: ";
      if($userfactor)
        $cost = floor($pricelist[$i][$a] * pow($pricelist[$i]['factor'],$level));
      else
        $cost = floor($pricelist[$i][$a]);
        
      if($cost > $planet[$a]){
        echo "<a style=\"cursor: pointer;\" title=\"-".number_format($cost-$planet[$a],0,',','.')."\"><span class=\"noresources\">".number_format($cost,0,',','.')."</span></a> ";
        $is_buyeable = false;
      }else{
        echo "<b>".number_format($cost,0,',','.')."</b> ";
      }
    }
  }
  return $is_buyeable;

}

function echo_building_time($time){
  global $lang;

  echo "<br>{$lang['ConstructionTime']}: ".pretty_time($time)."<br>";
  
  //a futuro...
  //echo "La investigacion puede ser iniciada en: 14d 23h 12m 2s";
}

function get_building_time($user,$planet,$i){//solo funciona con los edificios y talvez con las investigaciones
	global $pricelist,$resource;
  /*
    Formula sencilla para mostrar los costos de construccion.
    
    
    Mina de Metal: 60*1,5^(nivel-1) Metal y 15*1,5^(nivel-1) Cristal
    Mina de Cristal: 48*1,6^(nivel-1) Metal y 24*1,6^(nivel-1) Cristal
    Sintetizador de Deuterio: 225*1,5^(nivel-1) Metal y 75*1,5^(Nivel-1) Cristal
    Planta energú} Solar: 75*1,5^(nivel-1) Metal y 30*1,5^(Nivel-1) cristal
    Planta Fusion: 900*1,8^(nivel-1) Metal y 360*1,8^(Nivel-1) cristal y 180*1,8^(Nivel-1) Deuterio
    tecnologú} Gravitón: *3 por Nivel.
    
    Todas las demás investigaciones y edificios *2^Nivel 
    
  */
	$level = ($planet[$resource[$i]]) ? $planet[$resource[$i]] : $user[$resource[$i]];
	
	if($i > 0&&$i != 40&&$i != 41&&$i != 42&&$i != 43&&$i < 100)
	{//Edificios
		/*
		  Calculo del tiempo de produccion
		  [(Cris+Met)/2500]*[1/(Nivel f.robots+1)]* 0,5^NivelFabrica Nanos. 
		*/
		$cost_metal = 	floor($pricelist[$i]['metal'] * pow($pricelist[$i]['factor'],$level+1));
		$cost_crystal = floor($pricelist[$i]['crystal'] * pow($pricelist[$i]['factor'],$level+1));
		$time = ((($cost_crystal )+($cost_metal)) / 2500) * (1 / ($planet[$resource['14']] + 1)) * pow(0.5,$planet[$resource['15']]);
		//metodo temporal para mostrar el formato tiempo...
		$time = floor($time * 60 * 60);
		return $time;
		//return 30;
	}
	elseif($i > 100&&$i < 200&&isset($pricelist[$i]))
	{//Investigaciones
		$cost_metal = 	floor($pricelist[$i]['metal'] * pow($pricelist[$i]['factor'],$level+1));
		$cost_crystal = floor($pricelist[$i]['crystal'] * pow($pricelist[$i]['factor'],$level+1));
		$time = (($cost_metal + $cost_crystal) / 1000) / ( ($planet[$resource['31']] + 1 )*2);
		//metodo temporal para mostrar el formato tiempo...
		$time = floor($time*60*60);
		return $time;
		//return 30;
	}elseif((($i>200&&$i<215)||($i>400&&$i<500))&&isset($pricelist[$i]))
  {//flota y defensa
    $time = (($pricelist[$i]['metal'] + $pricelist[$i]['crystal']) / 2500) * (1 / ($planet[$resource['14']] + 1 )) * pow(1/2,$planet[$resource['15']]);
    //metodo temporal para mostrar el formato tiempo...
    $time = $time*60*60;
		return $time;
  }

}

function get_building_price($user,$planet,$i,$userfactor=true){
	global $pricelist,$resource;

  if($userfactor){$level = (isset($planet[$resource[$i]])) ? $planet[$resource[$i]] : $user[$resource[$i]];}
	//array
  $array = array('metal'=>$lang["Metal"],'crystal'=>$lang["Crystal"],'deuterium'=>$lang["Deuterium"]);
  //loop
  foreach($array as $a => $b){
    if($userfactor){
      $cost[$a] = floor($pricelist[$i][$a] * pow($pricelist[$i]['factor'],$level));
    }else{
      $cost[$a] = floor($pricelist[$i][$a]);
    }
  }
  return $cost;

}

{$resource = array(

1 => "metal_mine",
2 => "crystal_mine",
3 => "deuterium_sintetizer",
4 => "solar_plant",
12 => "fusion_plant",
14 => "robot_factory",
15 => "nano_factory",
21 => "hangar",
22 => "metal_store",
23 => "crystal_store",
24 => "deuterium_store",
31 => "laboratory",
33 => "terraformer",
34 => "ally_deposit",
44 => "silo",

106 => "spy_tech",
108 => "computer_tech",
109 => "military_tech",
110 => "defence_tech",
111 => "shield_tech",
113 => "energy_tech",
114 => "hyperspace_tech",
115 => "combustion_tech",
117 => "impulse_motor_tech",
118 => "hyperspace_motor_tech",
120 => "laser_tech",
121 => "ionic_tech",
122 => "buster_tech",
123 => "intergalactic_tech",
199 => "graviton_tech",

202 => "small_ship_cargo",
203 => "big_ship_cargo",
204 => "light_hunter",
205 => "heavy_hunter",
206 => "crusher",
207 => "battle_ship",
208 => "colonizer",
209 => "recycler",
210 => "spy_sonde",
211 => "bomber_ship",
212 => "solar_satelit",
213 => "destructor",
214 => "dearth_star",

401 => "misil_launcher",
402 => "small_laser",
403 => "big_laser",
404 => "gauss_canyon",
405 => "ionic_canyon",
406 => "buster_canyon",
407 => "small_protection_shield",
408 => "big_protection_shield",
502 => "interceptor_misil",
503 => "interplanetary_misil",
41 => "lunar_base",
42 => "sensor_phalax",
43 => "quantic_jump"
);}


//  Timer, para comprobar la velocidad del script
if ( isset($userrow['authlevel']) && $userrow['authlevel']== 3 ) {
	$tiempo = microtime();
	$tiempo = explode(" ", $tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoFin = $tiempo;
	$tiempoReal = ($tiempoFin - $tiempoInicio);
	echo $depurerwrote001.$tiempoReal.$depurerwrote002.$numqueries.$depurerwrote003;
}

// Created by Perberos. All rights reversed (C) 2006
?>
