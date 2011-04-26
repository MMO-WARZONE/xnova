<?php //b_building.php

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;


include("common.php");
include("cookies.php");

{//init
	$userrow = checkcookies();//Identificación del usuario
	CheckUserExist($userrow);
	include(INCLUDES_PATH."planet_toggle.php");//Cambia de planeta
	$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];//Skin grafico
	$planetrow = doquery("SELECT * FROM {{table}} WHERE id={$userrow[current_planet]}","planets",true);
	
}

if($bau > 0&&$bau != 40&&$bau != 41&&$bau != 42&&$bau != 43&&$bau < 100 && is_tech_available($userrow,$planetrow,$bau) && is_buyable($userrow,$planetrow,$i)){ //Array ( [db_character] 

	check_field_current($planetrow);
	//hay que arreglar este mensaje de advertencia...
	if($planetrow["b_tech_id"] != 0 && $bau == 31){error("Durante una investigación, no se puede construir o ampliar el laboratorio","Construir laboratorio de investigaciones");}
	if($planetrow["field_current"] < $planetrow["field_max"] && $planetrow["b_building_id"] == 0){
	$planetrow["b_building_id"] = $bau;
  
	/*
	  Especular el tiempo de construccion, se puede establecer una funcion aparte, pero
	  todavia tengo el problema para averiguar el tiempo de construcciones...
	*/
	if($pricelist[$bau]['metal'] != 0){
		$cost_metal = floor($pricelist[$bau]['metal'] * pow($pricelist[$bau]['factor'],$planetrow[$resource[$bau]]+1));
		//ahora comprovamos si se tienen los recursos necesarios
		if($planetrow["metal"] < $cost_metal){error("No tienes suficientes recursos.","Construir ".$tech[$bau]);}
		$planetrow["metal"] = $planetrow["metal"] - $cost_metal;
	}
	if($pricelist[$bau]['crystal'] != 0){
		$cost_crystal = floor($pricelist[$bau]['crystal'] * pow($pricelist[$bau]['factor'],$planetrow[$resource[$bau]]+1));
		if($planetrow["crystal"] < $cost_crystal){error("No tienes suficientes recursos.","Construir ".$tech[$bau]);}
		$planetrow["crystal"] = $planetrow["crystal"] - $cost_crystal;
	}
	if($pricelist[$bau]['deuterium'] != 0){
		$cost_deuterium= floor($pricelist[$bau]['deuterium'] * pow($pricelist[$bau]['factor'],$planetrow[$resource[$bau]]+1));
		if($planetrow["deuterium"] < $cost_deuterium){error("No tienes suficientes recursos.","Construir ".$tech[$bau]);}
		$planetrow["deuterium"] = $planetrow["deuterium"] - $cost_deuterium;
	}
	
//error("$cost_metal/".$planetrow["metal"]." - $cost_crystal/".$planetrow["crystal"]." - $cost_deuterium/".$planetrow["deuterium"]."/","");
	$time = ((($cost_crystal )+($cost_metal)) / 2500) * (1 / ($planetrow[$resource['14']] + 1)) * pow(0.5,$planetrow[$resource['15']]);

	//metodo temporal para mostrar el formato tiempo...
	$time = ($time *60*60);

	$planetrow["b_building"] = time() + floor($time);
	doquery("UPDATE {{table}} SET b_building_id=".$planetrow["b_building_id"].", b_building=".$planetrow["b_building"].", metal=".$planetrow["metal"].", crystal=".$planetrow["crystal"].",deuterium=".$planetrow["deuterium"]."  WHERE `id`=".$planetrow["id"].";","planets");

	}
}
elseif($unbau > 0&&$unbau != 40&&$unbau != 41&&$unbau != 42&&$unbau != 43&&$unbau < 100){

	if($planetrow["b_building_id"] != 0 && $planetrow["b_building_id"] == $unbau){
		
		if($pricelist[$unbau]['metal'] != 0){
			$cost_metal = floor($pricelist[$unbau]['metal'] * pow($pricelist[$unbau]['factor'],$planetrow[$resource[$unbau]]+1));
			$planetrow["metal"] = $planetrow["metal"] + $cost_metal;
		}
		if($pricelist[$unbau]['crystal'] != 0){
			$cost_crystal = floor($pricelist[$unbau]['crystal'] * pow($pricelist[$unbau]['factor'],$planetrow[$resource[$unbau]]+1));
			$planetrow["crystal"] = $planetrow["crystal"] + $cost_crystal;
		}
		if($pricelist[$unbau]['deuterium'] != 0){
			$cost_deuterium= floor($pricelist[$unbau]['deuterium'] * pow($pricelist[$unbau]['factor'],$planetrow[$resource[$unbau]]+1));
			$planetrow["deuterium"] = $planetrow["deuterium"] + $cost_deuterium;
		}
		//error("$cost_metal/".$planetrow["metal"]." - $cost_crystal/".$planetrow["crystal"]." - $cost_deuterium/".$planetrow["deuterium"]."/","");
		//$time = ((($cost_crystal )+($cost_metal)) / 2500) * (1 / ($planetrow[$resource['14']] + 1)) * pow(0.5,$planetrow[$resource['15']]);
		//metodo temporal para mostrar el formato tiempo...
		//$time = ($time *60*60);
		$planetrow["b_building_id"] = 0;
		//$planetrow["b_building"] = time() + floor($time);
		doquery("UPDATE {{table}} SET b_building_id=".$planetrow["b_building_id"].", metal=".$planetrow["metal"].", crystal=".$planetrow["crystal"].",deuterium=".$planetrow["deuterium"]."  WHERE `id`=".$planetrow["id"].";","planets");
	}

}

echo_head("Edificios");
echo_topnav();

echo "<center>\n<br />\n<table width=530>";
/*
  Pequeña comprobacion en el cual se revisa si se esta construyendo algo en el planeta
  Si el tiempo en el row 'b_building_id' es distinto a cero. Este comprueba el tiempo
  de finalizacion de la construccion.
  Con time(); sacamos el tiempo actual y el tiempo en el que termina para la comprobacion.
  Si el time() es mayor. Se actualiza el edificio, y se reestablece cero el 'b_building_id'
  'b_building' no hace falta actualizarlo, porque solo nos basaremos en 'b_building_id'
*/
if($planetrow["b_building_id"] != 0){

	if($planetrow["b_building"] <= time()){
		
		/*
		  en este lugar se calculan los agregados de cada edificio, por ejemplo.
		  cuanto afecta un edificio a la produccion de recursos, y cuanta energia consume el mismo.
		*/
		$planetrow[$resource[$planetrow["b_building_id"]]]++;
		
		
		//$cost_metal = floor($pricelist[$planetrow["b_building_id"]]['metal'] * pow($pricelist[$planetrow["b_building_id"]]['factor'],$planetrow[$resource[$planetrow["b_building_id"]]]+1));
		//$cost_crystal = floor($pricelist[$planetrow["b_building_id"]]['crystal'] * pow($pricelist[$planetrow["b_building_id"]]['factor'],$planetrow[$resource[$planetrow["b_building_id"]]]+1));
		
		doquery("UPDATE {{table}} SET `".$resource[$planetrow["b_building_id"]]."`= ".$planetrow[$resource[$planetrow["b_building_id"]]].", b_building_id=0  WHERE `id`=".$planetrow["id"].";","planets");
		$planetrow["b_building_id"] = 0;
	}else{$building = true;}
	
}

foreach($tech as $i => $n){

	if($i > 0&&$i != 40&&$i != 41&&$i != 42&&$i != 43&&$i < 100){
		
		if(!is_tech_available($userrow,$planetrow,$i)){//:)
			echo "</tr>\n";
		}else{
			//Funciona ^_^.. no como yo esperaba ¬_¬
			echo "<tr><td class=l><a href=infos.php?gid=$i>";
			echo "<img border='0' src=\"{$dpath}gebaeude/$i.gif\" align='top' ";
			echo "width='120' height='120'></a></td>";
			
			//obtenemos el nivel del edificio
			$building_level = $planetrow[$resource[$i]];
			//Muestra el nivel actual de la mina
			$nivel = ($building_level == 0) ? "" : " (Nivel $building_level)";
			//Descripcion
			echo "<td class=l><a href=infos.php?gid=$i>$n</a>$nivel<br>";
			echo "{$pricelist[$i][description]}<br>\n		";
			
			/*
			  Formula sencilla para mostrar los costos de construccion.
			  
			  
			  Mina de Metal: 60*1,5^(nivel-1) Metal y 15*1,5^(nivel-1) Cristal
			  Mina de Cristal: 48*1,6^(nivel-1) Metal y 24*1,6^(nivel-1) Cristal
			  Sintetizador de Deuterio: 225*1,5^(nivel-1) Metal y 75*1,5^(Nivel-1) Cristal
			  Planta energía Solar: 75*1,5^(nivel-1) Metal y 30*1,5^(Nivel-1) cristal
			  Planta Fusion: 900*1,8^(nivel-1) Metal y 360*1,8^(Nivel-1) cristal y 180*1,8^(Nivel-1) Deuterio
			  tecnología Gravitón: *3 por Nivel.
			  
			  Todas las demás investigaciones y edificios *2^Nivel 
			  
			*/
			$is_buyeable = echo_price($userrow,$planetrow,$i);
			
			/*
			  Calculo del tiempo de produccion
			  [(Cris+Met)/2500]*[1/(Nivel f.robots+1)]* 0,5^NivelFabrica Nanos. 
			*/
			//$time = ((($cost_crystal )+($cost_metal)) / 2500) * (1 / ($planetrow[$resource['14']] + 1)) * pow(0.5,$planetrow[$resource['15']]);
			//metodo temporal para mostrar el formato tiempo...
			//$time = ($time *60*60);
			
			$time = get_building_time($userrow,$planetrow,$i);
			echo_building_time($time);
			
			echo "<td class=k>";
			if(!$building){
				if($userrow["b_tech_planet"] != 0 && $i == 31){
				//en caso de que sea el laboratorio y se este investigando algo.
					echo "<font color=#FF0000>Investigando</font>";
				//Muestra la opcion a elegir para construir o ampliar un edificio
				}elseif($planetrow[$resource[$i]] == 0 && $planetrow["field_current"] < $planetrow["field_max"]  && $is_buyeable){
					echo "<a href=\"?bau=$i\"><font color=#00FF00>Construir</font></a>";
				}elseif($planetrow["field_current"] < $planetrow["field_max"] && $is_buyeable){
					$nplus = $planetrow[$resource[$i]] + 1;
					echo "<a href=\"?bau=$i\"><font color=#00FF00>Ampliar<br> al nivel $nplus</font></a>";
				}elseif($planetrow["field_current"] < $planetrow["field_max"] && !$is_buyeable){
					if($planetrow[$resource[$i]] == 0){
					echo "<font color=#FF0000>Construir</font>";
					}else{
					$nplus = $planetrow[$resource[$i]] + 1;
					echo "<font color=#FF0000>Ampliar<br> al nivel $nplus</font>";}
				}else{
					echo "<font color=#FF0000>Planeta ocupado</font>";
				}
				
			}elseif($planetrow["b_building_id"] == $i){
				/*
				  no lo puedo creer, esta funcionando T_T
				*/
				$time = $planetrow["b_building"] - time();
				echo '<script src="scripts/cnt.js" type="text/javascript">
</script><div id="bxx" class="z"></div><SCRIPT language=JavaScript>
   pp="'.$time.'";
   pk="'.$planetrow["b_building_id"].'";
   pl="'.$planetrow["id"].'";
   ps="";
   t();
</script>
</td></tr>';
			}
		}
	  
	}

}
echo "</table>\n</center>\n</body>\n</html>\n";
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