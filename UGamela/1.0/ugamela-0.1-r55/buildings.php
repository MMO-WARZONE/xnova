<?php //building.php

define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }

//
// Esta funcion permite cambiar el planeta actual.
//
include($ugamela_root_path . 'includes/planet_toggle.'.$phpEx);

$planetrow = doquery("SELECT * FROM {{table}} WHERE id={$user['current_planet']}",'planets',true);
$galaxyrow = doquery("SELECT * FROM {{table}} WHERE id_planet={$planetrow['id']}",'galaxy',true);
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
check_field_current($planetrow);

includeLang('tech');
includeLang('buildings');


//Funciones
function echo_buildinglist(){
	global $lang,$user,$planetrow,$pricelist;

	//Array del b_hangar_id
	$b_hangar_id = explode(';',$planetrow['b_hangar_id']);
  
	$a=$b=$c="";
	foreach($b_hangar_id as $n => $array){
		if($array!=''){
			$array = explode(',',$array);
			//calculamos el tiempo
			$time = get_building_time($user,$planetrow,$array[0]);
			$totaltime += $time * $array[1];
			$c .= "$time,";
			$b .= "'{$lang['tech'][$array[0]]}',";
			$a .= "{$array[1]},";
		}
	}

	$parse = $lang;
	$parse['a'] = $a;
	$parse['b'] = $b;
	$parse['c'] = $c;
	$parse['b_hangar_id_plus'] = $planetrow['b_hangar'];

	$parse['pretty_time_b_hangar'] = pretty_time($totaltime-$planetrow['b_hangar']);// //$planetrow['last_update']

	$text .= parsetemplate(gettemplate('buildings_script'), $parse);

	return $text;
}

if($user["b_tech_planet"] != 0){//technology...
	/*
	  Hacemos el query para mantenerlo porque se va a utilizar mas adelante para dar la referencia
	  pero en vano es el query, si el planeta es el mismo que el actual :P
	*/
	if($user["b_tech_planet"] != $planetrow["id"]){
		$tech_planetrow = doquery("SELECT * FROM {{table}} WHERE id = '{$user['b_tech_planet']}'","planets",true);
	}
	if($tech_planetrow){$planet = $tech_planetrow;}else{$planet = $planetrow;}
	
	if($planet["b_tech"] <= time() && $planet["b_tech_id"] != 0){
		$user[$resource[$planet["b_tech_id"]]]++;
		
		doquery("UPDATE {{table}} SET b_tech_id=0 WHERE id='{$planet["id"]}'","planets");
		doquery("UPDATE {{table}} SET `{$resource[$planet["b_tech_id"]]}`='{$user[$resource[$planet["b_tech_id"]]]}', b_tech_planet=0  WHERE `id`=".$user["id"].";","users");
		$planet["b_tech_id"] = 0;
		
		if(isset($tech_planetrow)){$tech_planetrow = $planet;}else{$planetrow = $planet;}
		
	}elseif($planet["b_tech_id"] == 0){
		/*
		  Esto es para corregir algunos fallos o un posible problema al cancelar una investigacion
		*/
		doquery("UPDATE {{table}} SET b_tech_planet=0  WHERE id='{$user['id']}'","users");
	}else{ $teching = true;}
	
	
	
}

switch ($mode){

case 'fleet':{//------------------------------------------------------------
//modo POST
  if(isset($_POST['fmenge'])){
    
    foreach($_POST['fmenge'] as $a => $b){
      /*
        Lo que se hara a continuacion es totalmente insano y muy loco...
        
        Bueno, se procede a crear una array con la produccion de los
        elementos elegidos, y se comprobara si se tiene el suficiente
        recurso para poder comprarlo
      */
      if($b != 0){
        //se comprueba que este disponible, para evitar hacks
        if(is_tech_available($user,$planetrow,$a)){
          //Se procede a comprobar cuantos recursos requiere esa cantidad de
          //elementos
          //version 1.0
          while($b != 0){
            
            $is_buyeable = true;
            $costMetal=0;
            $costCrystal=0;
            $costDeuterium=0;
            $costEnergy=0;
            
            if($pricelist[$a]['metal'] != 0){
              $costMetal = $pricelist[$a]['metal'];
              if($costMetal > $planetrow["metal"]){ $is_buyeable = false;}
            }
            if($pricelist[$a]['crystal'] != 0){
              $costCrystal = $pricelist[$a]['crystal'];
              if($costCrystal > $planetrow["crystal"] && $is_buyeable){ $is_buyeable = false;}
            }
            if($pricelist[$a]['deuterium'] != 0){
              $costDeuterium = $pricelist[$a]['deuterium'];
              if($costDeuterium > $planetrow["deuterium"] && $is_buyeable){$is_buyeable = false;}
            }
            if($pricelist[$a]['energy'] != 0){
              $costEnergy = $pricelist[$a]['energy'];
              if($costEnergy > $planetrow["energy_max"] && $is_buyeable){$is_buyeable = false;}
            }
            if($is_buyeable){
              //Se agrega a una array donde se contiene todo lo que se pudo
              //comprar
              $builds[$a]++;
              $planetrow["metal"] -= $costMetal;
              $planetrow["crystal"] -= $costCrystal;
              $planetrow["deuterium"] -= $costDeuterium;
              
              $b--;//un contador menos...
            }else{
              $b=0;//para romper el loop
            }
            
          }
          //ahora que ya quitamos los recursos, que se actualizan solos ademas!
          //se procede a crear la array de produccion
          
          foreach($builds as $a => $b){
            $planetrow['b_hangar_id'] .= "$a,$b;";
          }
        }
      }
    }
  }

	if($planetrow[$resource[21]] == 0){
		
		message($lang['need_hangar'],$lang["Hangar"]);
	}
	//luego del post
	//
	//--[Comienza normalmente]----------------------------------------------
	//
	$tabindex = 0;

	foreach($lang['tech'] as $i => $n){//investigacion
		
		if($i > 201&&$i <= 399){
			
			if(!is_tech_available($user,$planetrow,$i)){
				$buildlist .= "</tr>\n";
			}else{
				//Funciona ^_^
				$buildlist .= "<tr><td class=l><a href=infos.{$phpEx}?gid=$i><img border=0 src=\"{$dpath}gebaeude/$i.gif\" align=top width=120 height=120></a></td>";
				//obtenemos el nivel del edificio
				$building_level = $planetrow[$resource[$i]];
				//Muestra el nivel actual de la mina
				//die($user[$resource[$i]]);
				$nivel = ($building_level == 0) ? "" : " ($building_level disponibles)";
				//Descripcion
				$buildlist .= "<td class=l><a href=infos.{$phpEx}?gid=$i>$n</a>$nivel<br>{$lang['res']['descriptions'][$i]}<br>\n";
				
				$is_buyeable = is_buyeable($user,$planetrow,$i,false);
				$buildlist .= price($user,$planetrow,$i,false);
				
				/*
				Calculo del tiempo de produccion
				[(Cris+Met)/2500]*[1/(Nivel f.robots+1)]* 0,5^NivelFabrica Nanos. 
				*/
				$time = get_building_time($user,$planetrow,$i);
				//metodo temporal para mostrar el formato tiempo...
				$buildlist .= building_time($time);
				
				$buildlist .= "<td class=k>";
				
				//Muestra la opcion a elegir para construir o ampliar un edificio
				if($is_buyeable){
					$tabindex++;
					$buildlist .= "<input type=text name=fmenge[$i] alt='{$lang['tech'][$i]}' size=6 maxlength=6 value=0 tabindex=$tabindex>";
				}
			}
		}
	}
  
  
	if ($planetrow['b_hangar_id']!='') $buildinglist .= echo_buildinglist();
  

	$parse = $lang;
	$parse['buildlist'] = $buildlist;
	$parse['buildinglist'] = $buildinglist;
	//fragmento de template
	$page .= parsetemplate(gettemplate('buildings_fleet'), $parse);

	display($page,$lang['Research']);
	die();}

case 'research':{//---------------------------------------------------------
	/*
	  Investigacion
	  Este codigo es similar en todo este php
	*/
	if(isset($bau) && in_array($bau,$reslist['tech'])){
		//if(is_buyable($user,$planetrow,$bau)) error("No se puede investigar esa tecnologia.","Investigar");
		//nueva configuracion :D
		if($planetrow["b_building_id"] == 31 &&
			$game_config['allow_invetigate_while_lab_is_update']!=1)
		{
			message($lang['cant_invetigate_while_lab_is_update'],"Investigación");
		}
		
		
		
		if(is_tech_available($user,$planetrow,$bau) &&
			$user["b_tech_planet"]==0 &&
			is_buyable($user,$planetrow,$bau))
		{
		//establecemos que se investiga.
		$planetrow["b_tech_id"] = $bau;
		//indicamos el tiempo de investigacion.y establecemos el tiempo de
		//especulacion de cuando termine la investigacion.
		$planetrow["b_tech"] = time()+get_building_time($user,$planetrow,$bau);
		//actualizamos e indicamos donde se esta haciendo la investigacion.
		$user["b_tech_planet"] = $planetrow["id"];
		//ahora se restan los recursos
		$costs = get_building_price($user,$planetrow,$bau);
		
		doquery("UPDATE {{table}} SET b_tech_id={$planetrow['b_tech_id']}, b_tech={$planetrow['b_tech']}, metal=-{$costs['metal']}, crystal=-{$costs['crystal']}, deuterium=-{$costs['deuterium']} WHERE id={$planetrow['id']}","planets");
		doquery("UPDATE {{table}} SET b_tech_planet={$user['b_tech_planet']} WHERE id={$user['id']}","users");
		//listo
		$planet = $planetrow;
		$teching = true;
		}
	}
	elseif(isset($unbau) && in_array($unbau, $reslist['tech'])){

	//checheamos la tecnologia...
    if($user["b_tech_planet"] != 0){// && $planetrow["b_tech_id"] == $unbau
		
      if($user["b_tech_planet"] != $planetrow["id"]){
        $tech_planetrow = doquery("SELECT * FROM {{table}} WHERE id = '".$user["b_tech_planet"]."'","planets",true);
      }
      
      if(isset($tech_planetrow)){$planet = $tech_planetrow;}else{$planet = $planetrow;}
      //if($planet["b_tech"] <= time()){
      
      if($planet["b_tech_id"] == $unbau){
        
        $planet["b_tech_id"] = 0;
        $user["b_tech_planet"] = 0;
        
        if($pricelist[$unbau]['metal'] != 0){
          $cost_metal = floor($pricelist[$unbau]['metal'] * pow($pricelist[$unbau]['factor'],$user[$resource[$unbau]]+1));
          $planet["metal"] = $planet["metal"] + $cost_metal;
        }
        if($pricelist[$unbau]['crystal'] != 0){
          $cost_crystal = floor($pricelist[$unbau]['crystal'] * pow($pricelist[$unbau]['factor'],$user[$resource[$unbau]]+1));
          $planet["crystal"] = $planet["crystal"] + $cost_crystal;
        }
        if($pricelist[$unbau]['deuterium'] != 0){
          $cost_deuterium= floor($pricelist[$unbau]['deuterium'] * pow($pricelist[$unbau]['factor'],$user[$resource[$unbau]]+1));
          $planet["deuterium"] = $planet["deuterium"] + $cost_deuterium;
        }
        
        //doquery("UPDATE {{table}} SET b_tech_id=0  WHERE `id`=".$planet["id"].";","planets");
        doquery("UPDATE {{table}} SET b_tech_id=0, metal=".$planet["metal"].", crystal=".$planet["crystal"].",deuterium=".$planet["deuterium"]."  WHERE `id`=".$planet["id"].";","planets");
        doquery("UPDATE {{table}} SET b_tech_planet=0 WHERE `id`=".$user["id"].";","users");
        
        if(isset($tech_planetrow)){$tech_planetrow = $planet;}else{$planetrow = $planet;}
		//listo :)
		$teching = false;
        
        
        
      }
      //error("$cost_metal/".$planetrow["metal"]." - $cost_crystal/".$planetrow["crystal"]." - $cost_deuterium/".$planetrow["deuterium"]."/","");
      //$time = ((($cost_crystal )+($cost_metal)) / 2500) * (1 / ($planetrow[$resource['14']] + 1)) * pow(0.5,$planetrow[$resource['15']]);
      //metodo temporal para mostrar el formato tiempo...
      //$time = ($time *60*60);
      
    }
  
  }

	//
	//--[Comienza normalmente]----------------------------------------------
	//
	if($planetrow[$resource[31]] == 0){
		message($lang['need_investigationlab'],"Investigación");
	}

	if($planetrow["b_building_id"] == 31 &&
		$game_config['allow_invetigate_while_lab_is_update']!=1)
	{
		$buildinglist = '<br><br><font color="#ff0000">'.$lang['cant_invetigate_while_lab_is_update'].'</font><br><br>';
	}

	//cargamos la template...
	$template = gettemplate('buildings_research_row');

	foreach($lang['tech'] as $i => $n){//investigacion
		
		if($i > 105&&$i <= 199){
			
			if(!is_tech_available($user,$planetrow,$i)){//:)
				$buildinglist .= "</tr>";
			}else{
				//Funciona ^_^
				$parse = $lang;
				$parse['dpath'] = $dpath;
				$parse['i'] = $i;
				//obtenemos el nivel del edificio
				$building_level = $user[$resource[$i]];
				//Muestra el nivel actual de la mina
				$parse['nivel'] = ($building_level == 0) ? "" : "(Nivel $building_level)";
				//Descripcion
				$parse['n'] = $n;
				$parse['description'] = $lang['res']['descriptions'][$i];
				//$is_buyeable = is_buyable($user,$planetrow,$i,true);
				$is_buyeable = is_buyeable($user,$planetrow,$i);
				$parse['price'] = price($user,$planetrow,$i);
				/*
				Calculo del tiempo de produccion
				[(Cris+Met)/2500]*[1/(Nivel f.robots+1)]* 0,5^NivelFabrica Nanos. 
				*/
				//$time = (($pricelist[$i]['metal'] + $pricelist[$i]['crystal']) / 1000) * (($planetrow[$resource['31']] + 1 ));
				//metodo temporal para mostrar el formato tiempo...
				$time = get_building_time($user,$planetrow,$i);//$time*60*60);
				$parse['time'] = building_time($time);
				
				
				//agregamos el row a la buildinglist
				$buildinglist .= parsetemplate($template, $parse);
				
				/*if($game_config['allow_invetigate_while_lab_is_update']==1){
					
					$lang['cant_invetigate_while_lab_is_update'];
					
					
					
					
				}else*/
				if(!$teching){
					//Muestra la opcion a elegir para construir o ampliar un edificio
					if($user[$resource[$i]] == 0 && $is_buyeable){
						
						if($planetrow["b_building_id"] == 31 &&
							$game_config['allow_invetigate_while_lab_is_update']!=1)
						{
							$buildinglist .= "<font color=#FF0000>Investigar</font>";
						}else{
							$buildinglist .= "<a href=\"?mode=research&bau=$i\"><font color=#00FF00>Investigar</font></a>";
						}
						
					}elseif($is_buyeable){
						
						if($planetrow["b_building_id"] == 31 &&
							$game_config['allow_invetigate_while_lab_is_update']!=1)
						{
							$nplus = $user[$resource[$i]] + 1;
							$buildinglist .= "<font color=#FF0000>Investigar<br> al nivel $nplus</font>";
						}else{
							$nplus = $user[$resource[$i]] + 1;
							$buildinglist .= "<a href=\"?mode=research&bau=$i\"><font color=#00FF00>Investigar<br> al nivel $nplus</font></a>";
						}
						
					}elseif($user[$resource[$i]] == 0){
						$buildinglist .= "<font color=#FF0000>Investivar</font>";
					}else{
						$nplus = $user[$resource[$i]] + 1;
						$buildinglist .= "<font color=#FF0000>Investivar<br> al nivel $nplus</font>";
					}
				}else{
					
					if($planet["b_tech_id"] == $i){
						$parse = $lang;
						if(isset($tech_planetrow)){
							$planet = $tech_planetrow;
							$parse['time'] = $tech_planetrow["b_tech"] - time();
							$parse['name'] = $tech_planetrow["name"];
							$parse['idcp'] = $tech_planetrow["id"];
							$parse['unbau'] = $tech_planetrow["b_tech_id"];
						}else{
							$planet = $planetrow;
							$parse['time'] = $planetrow["b_tech"] - time();
							$parse['name'] = "";
							$parse['idcp'] = $planetrow["id"];
							$parse['unbau'] = $planetrow["b_tech_id"];
						}
						// Todo loco, este script permite mostrar el tiempo de investigacion seguido
						$buildinglist .= parsetemplate(gettemplate('buildings_research_script'), $parse);
						
					}else{$buildinglist .= "<center>-</center>";}
					
				}
				
			}
			
		}
		
		
		

		
		
		
		
		
	}

	$parse = $lang;
	$parse['buildinglist'] = $buildinglist;
	//fragmento de template
	$page .= parsetemplate(gettemplate('buildings_research'), $parse);

	display($page,$lang['Research']);
	die();}

case 'defense':{//----------------------------------------------------------
//Defensa
	//
	//--[modo POST]-------------------------------------------------------
	//
  if(isset($_POST['fmenge'])){
    
    foreach($_POST['fmenge'] as $a => $b){
      /*
        Lo que se hara a continuacion es totalmente insano y muy loco...
        
        Bueno, se procede a crear una array con la produccion de los
        elementos elegidos, y se comprobara si se tiene el suficiente
        recurso para poder comprarlo
      */
      if($b != 0){
        //se comprueba que este disponible, para evitar hacks
        if(is_tech_available($user,$planetrow,$a)){
          //Se procede a comprobar cuantos recursos requiere esa cantidad de
          //elementos
          //version 1.0
          while($b != 0){
            
            $is_buyeable = true;
            $costMetal=0;
            $costCrystal=0;
            $costDeuterium=0;
            $costEnergy=0;
            
            if($pricelist[$a]['metal'] != 0){
              $costMetal = $pricelist[$a]['metal'];
              if($costMetal > $planetrow["metal"]){ $is_buyeable = false;}
            }
            if($pricelist[$a]['crystal'] != 0){
              $costCrystal = $pricelist[$a]['crystal'];
              if($costCrystal > $planetrow["crystal"] && $is_buyeable){ $is_buyeable = false;}
            }
            if($pricelist[$a]['deuterium'] != 0){
              $costDeuterium = $pricelist[$a]['deuterium'];
              if($costDeuterium > $planetrow["deuterium"] && $is_buyeable){$is_buyeable = false;}
            }
            if($pricelist[$a]['energy'] != 0){
              $costEnergy = $pricelist[$a]['energy'];
              if($costEnergy > $planetrow["energy_max"] && $is_buyeable){$is_buyeable = false;}
            }
            if($is_buyeable){
              //Se agrega a una array donde se contiene todo lo que se pudo
              //comprar
              $builds[$a]++;
              $planetrow["metal"] -= $costMetal;
              $planetrow["crystal"] -= $costCrystal;
              $planetrow["deuterium"] -= $costDeuterium;
              
              $b--;//un contador menos...
            }else{
              $b=0;//para romper el loop
            }
            
          }
          //ahora que ya quitamos los recursos, que se actualizan solos ademas!
          //se procede a crear la array de produccion
          foreach($builds as $a => $b){
            $planetrow['b_hangar_id'] .= "$a,$b;";
          }
        }
      }
    }
  }

	//
	//--[Modo normal]-------------------------------------------------------
	//
  
	if($planetrow[$resource[21]] == 0){
		message($lang['need_hangar']);
	}else{
		
		$tabindex = 0;
		
		foreach($lang['tech'] as $i => $n){ //Defensa
			
			if($i > 400&&$i <= 599){
				
				if(!is_tech_available($user,$planetrow,$i)){
					
					$buildinglist .= "</tr>\n";
					
				}else{
					//Funciona ^_^
					$buildinglist .= "<tr><td class=l><a href=infos?gid=$i><img border='0' src=\"".$dpath."gebaeude/$i.gif\" align='top' width='120' height='120'></a></td>";
					
					//obtenemos la cantidad de unidades que hay en el planeta
					$building_level = $planetrow[$resource[$i]];
					//Muestra la cantidad de unidades que se encuentran en el planeta
					//die($planetrow[$resource[$i]]);
					$nivel = ($building_level == 0) ? "" : "(cantidad $building_level)";
					//Descripcion
					$buildinglist .= "<td class=l><a href=infos?gid=$i>$n</a> $nivel<br>{$lang['res']['descriptions'][$i]}<br>";
					
					$is_buyeable = is_buyeable($user,$planetrow,$i,false);
					$buildinglist .= price($user,$planetrow,$i,false);
					/*
					  Calculo del tiempo de produccion
					  [(Cris+Met)/2500]*[1/(Nivel f.robots+1)]* 0,5^NivelFabrica Nanos. 
					*/
					$time = get_building_time($user,$planetrow,$i);
					//metodo temporal para mostrar el formato tiempo...
					$buildinglist .= building_time($time);
					
					$buildinglist .= "<td class=k>";
					
					//Muestra la opcion a elegir para construir o ampliar un edificio
					if($is_buyeable){
						$tabindex++;
						$buildinglist .= "<input type=text name=fmenge[$i] alt='{$tech[$i]}' size=6 maxlength=6 value=0 tabindex=$tabindex>";
					}
				}
				
			}
			
		}
		
		$buildinglist .= '</td></tr>
		<td class=c colspan=2 align=center><input type=submit value="Aceptar">
		</td></tr></table></form></td><td valign="top"></td></tr></table>';
		
		if ($planetrow['b_hangar_id']!='') $buildinglist .= echo_buildinglist();
	}


	$parse = $lang;
	$parse['buildinglist'] = $buildinglist;
	//fragmento de template
	$page .= parsetemplate(gettemplate('buildings_defense'), $parse);

	display($page,$lang['Defense']);
	die();
}

default:{//-----------------------------------------------------------------

if(isset($bau) &&$bau > 0&&$bau != 40&&$bau != 41&&$bau != 42&&$bau != 43&&$bau < 100 && @is_tech_available($userrow,$planetrow,$bau) && @is_buyable($userrow,$planetrow,@$i)){ //Array ( [db_character] 

	check_field_current($planetrow);
	//hay que arreglar este mensaje de advertencia...
	if($user["b_tech_planet"] != 0 &&
		$bau == 31 &&
		$game_config['allow_invetigate_while_lab_is_update'] != 1)
	{
		message("Durante una investigaci, no se puede construir o ampliar el laboratorio","Construir laboratorio de investigaciones");
	}
	
	if($planetrow["field_current"] < $planetrow["field_max"] && $planetrow["b_building_id"] == 0){
	$planetrow["b_building_id"] = $bau;
  
	/*
	  Especular el tiempo de construccion, se puede establecer una funcion aparte, pero
	  todavia tengo el problema para averiguar el tiempo de construcciones...
	*/
	if($pricelist[$bau]['metal'] != 0){
		$cost_metal = floor($pricelist[$bau]['metal'] * pow($pricelist[$bau]['factor'],$planetrow[$resource[$bau]]));
		//ahora comprovamos si se tienen los recursos necesarios
		if($planetrow["metal"] < $cost_metal){message("No tienes suficientes recursos.","Construir ".$lang['tech'][$bau]);}
		$planetrow["metal"] = $planetrow["metal"] - $cost_metal;
	}
	if($pricelist[$bau]['crystal'] != 0){
		$cost_crystal = floor($pricelist[$bau]['crystal'] * pow($pricelist[$bau]['factor'],$planetrow[$resource[$bau]]));
		if($planetrow["crystal"] < $cost_crystal){message("No tienes suficientes recursos.","Construir ".$lang['tech'][$bau]);}
		$planetrow["crystal"] = $planetrow["crystal"] - $cost_crystal;
	}
	if($pricelist[$bau]['deuterium'] != 0){
		$cost_deuterium= floor($pricelist[$bau]['deuterium'] * pow($pricelist[$bau]['factor'],$planetrow[$resource[$bau]]));
		if($planetrow["deuterium"] < $cost_deuterium){message("No tienes suficientes recursos.","Construir ".$lang['tech'][$bau]);}
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
	elseif(@$unbau > 0&&$unbau != 40&&$unbau != 41&&$unbau != 42&&$unbau != 43&&$unbau < 100){

	if($planetrow["b_building_id"] != 0 && $planetrow["b_building_id"] == $unbau){
		
		if($pricelist[$unbau]['metal'] != 0){
			$cost_metal = floor($pricelist[$unbau]['metal'] * pow($pricelist[$unbau]['factor'],$planetrow[$resource[$unbau]]));
			$planetrow["metal"] = $planetrow["metal"] + $cost_metal;
		}
		if($pricelist[$unbau]['crystal'] != 0){
			$cost_crystal = floor($pricelist[$unbau]['crystal'] * pow($pricelist[$unbau]['factor'],$planetrow[$resource[$unbau]]));
			$planetrow["crystal"] = $planetrow["crystal"] + $cost_crystal;
		}
		if($pricelist[$unbau]['deuterium'] != 0){
			$cost_deuterium= floor($pricelist[$unbau]['deuterium'] * pow($pricelist[$unbau]['factor'],$planetrow[$resource[$unbau]]));
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
  Peque comprobacion en el cual se revisa si se esta construyendo algo en el planeta
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

foreach($lang['tech'] as $i => $n){

	if($i > 0&&$i != 40&&$i != 41&&$i != 42&&$i != 43&&$i < 100){
		
		if(!@is_tech_available($userrow,$planetrow,$i)){//:)
			echo "</tr>\n";
		}else{
			//Funciona ^_^.. no como yo esperaba ｬ_ｬ
			echo "<tr><td class=l><a href=infos.php?gid=$i>";
			echo "<img border='0' src=\"{$dpath}gebaeude/$i.gif\" align='top' ";
			echo "width='120' height='120'></a></td>";
			
			//obtenemos el nivel del edificio
			$building_level = $planetrow[$resource[$i]];
			//Muestra el nivel actual de la mina
			$nivel = ($building_level == 0) ? "" : " (Nivel $building_level)";
			//Descripcion
			echo "<td class=l><a href=infos.php?gid=$i>$n</a>$nivel<br>";
			echo "{$lang['res']['descriptions'][$i]}<br>\n		";
			
			/*
			  Formula sencilla para mostrar los costos de construccion.
			  
			  
			  Mina de Metal: 60*1,5^(nivel-1) Metal y 15*1,5^(nivel-1) Cristal
			  Mina de Cristal: 48*1,6^(nivel-1) Metal y 24*1,6^(nivel-1) Cristal
			  Sintetizador de Deuterio: 225*1,5^(nivel-1) Metal y 75*1,5^(Nivel-1) Cristal
			  Planta energ僘 Solar: 75*1,5^(nivel-1) Metal y 30*1,5^(Nivel-1) cristal
			  Planta Fusion: 900*1,8^(nivel-1) Metal y 360*1,8^(Nivel-1) cristal y 180*1,8^(Nivel-1) Deuterio
			  tecnolog僘 Gravit: *3 por Nivel.
			  
			  Todas las dem疽 investigaciones y edificios *2^Nivel 
			  
			*/
			$is_buyeable = @echo_price($userrow,$planetrow,$i);
			
			/*
			  Calculo del tiempo de produccion
			  [(Cris+Met)/2500]*[1/(Nivel f.robots+1)]* 0,5^NivelFabrica Nanos. 
			*/
			//$time = ((($cost_crystal )+($cost_metal)) / 2500) * (1 / ($planetrow[$resource['14']] + 1)) * pow(0.5,$planetrow[$resource['15']]);
			//metodo temporal para mostrar el formato tiempo...
			//$time = ($time *60*60);
			
			$time = get_building_time($userrow,$planetrow,$i);
			echo building_time($time);
			
			echo_rest_price($userrow,$planetrow,$i);
			
			echo "<td class=k>";
			
			/*if(	if($planetrow["b_building_id"] == 31 &&
		$game_config['allow_invetigate_while_lab_is_update']!=1)
	{
		$buildinglist = '<br><br><font color="#ff0000">'.$lang['cant_invetigate_while_lab_is_update'].'</font><br><br>';
	}*/
			
			
			if(!$building){
				if($user["b_tech_planet"] != 0 && $i == 31 && $game_config['allow_invetigate_while_lab_is_update'] != 1){
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
   ps="buildings.php";
   t();
</script>
</td></tr>';
			}
		}
	  
	}

}
echo "</table>\n</center>\n</body>\n</html>\n";

die();}

}

// Created by Perberos. All rights reversed (C) 2006
?>
