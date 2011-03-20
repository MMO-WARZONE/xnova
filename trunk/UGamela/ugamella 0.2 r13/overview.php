<?php //overview.php

define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.$phpEx"); }

includeLang('overview');
includeLang('tech');
/*
  Checkear el tema de la lista de flotas
*/
include($ugamela_root_path . 'includes/planet_toggle.'.$phpEx);//Esta funcion permite cambiar el planeta actual.

$planetrow = doquery("SELECT * FROM {{table}} WHERE id={$user['current_planet']}",'planets',true);
$galaxyrow = doquery("SELECT * FROM {{table}} WHERE id_planet={$planetrow['id']}",'galaxy',true);
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
check_field_current($planetrow);

switch ($mode)
{
case 'renameplanet':{//Abandonar o renombrar planetas

	if($_POST['action'] == $lang['namer']){
		
		$newname = trim($_POST['newname']);
		
		if(!preg_match("/[^A-z0-9\ _\-]/", $newname) == 1 && $newname != ""){
			/*
			  Realmente no lo encuentro muy necesario. e incluso es esguro, 
			  porque si o si, se nombra en base al planeta actual
			*/
			$planetrow['name'] = $newname;
			doquery("UPDATE {{table}} SET `name`='$newname' WHERE `id`='{$user['current_planet']}' LIMIT 1","planets");
			
		}
	}
	elseif($_POST['action'] == $lang['colony_abandon']){
	
		$parse = $lang;
		
		$parse['planet_id'] = $planetrow['id'];
		$parse['galaxy_galaxy'] = $galaxyrow['galaxy'];
		$parse['galaxy_system'] = $galaxyrow['system'];
		$parse['galaxy_planet'] = $galaxyrow['planet'];
		$parse['planet_name'] = $planetrow['name'];
		
		$page .= parsetemplate(gettemplate('overview_deleteplanet'), $parse);
		
		display($page,$lang['rename_and_abandon_planet']);
		
	}
	elseif($_POST['action'] == $lang['deleteplanet'] && $_POST['deleteid'] == $user['current_planet']){

		//comprobamos la contraseña y comprobamos que el planeta actual no sea el planeta principal
		if(md5($_POST['pw']) == $user["password"] && $user['id_planet'] != $user['current_planet']){
			//actualizamos el el planeta para que este modo destruido
			
			//tiempo cuando se destruira, y quedara el espacio libre
			$destruyed = time() + 60*60*24;
			doquery("UPDATE {{table}} SET `destruyed` = '$destruyed', `id_owner` = 0 WHERE `id` = '{$user['current_planet']}' LIMIT 1","planets");
			doquery("UPDATE {{table}} SET
				current_planet=id_planet,
				points_points=points_points-{$planetrow['points']}
				WHERE id='{$user['id']}' LIMIT 1","users");
			message($lang['deletemessage_ok'],$lang['colony_abandon'],'overview.php?mode=renameplanet');
		}elseif($user['id_planet'] == $user["current_planet"]){ 
			message($lang['deletemessage_wrong'],$lang['colony_abandon'],'overview.php?mode=renameplanet');
		}else{message($lang['deletemessage_fail'],$lang['colony_abandon'],'overview.php?mode=renameplanet');}

	}

	$parse = $lang;

	$parse['planet_id'] = $planetrow['id'];
	$parse['galaxy_galaxy'] = $galaxyrow['galaxy'];
	$parse['galaxy_system'] = $galaxyrow['system'];
	$parse['galaxy_planet'] = $galaxyrow['planet'];
	$parse['planet_name'] = $planetrow['name'];

	$page .= parsetemplate(gettemplate('overview_renameplanet'), $parse);

	display($page,$lang['rename_and_abandon_planet']);

}

default:{//-----------------------------------------------------------------
	//Agrega un link que lleva a la seccion de mensajes
	if($user['new_message'] == 1){
		$Have_new_message .= "<tr><th colspan=4><a href=messages.$phpEx>{$lang['Have_new_message']}</a></th></tr>";
	}elseif($user['new_message'] > 1){
		$Have_new_message .= "<tr><th colspan=4><a href=messages.$phpEx>";
		$m = pretty_number($user['new_message']);
		$Have_new_message .= str_replace('%m',$m,$lang['Have_new_messages']);
		$Have_new_message .= "</a></th></tr>";
	}
	/*
	  Lista de flotas actuales
	*/
	$missiontype = array(
		1 => 'Atacar',
		3 => 'Transportar',
		4 => 'Desplazar',
		5 => 'Destruir',
		6 => 'Espiar',
		7 => 'Posicionar flota',
		8 => 'Reciclar',
		9 => 'Colonizar',
		);
	/*
	  Aqui se debe de mostrar los movimientos de flotas, propios del jugador
	*/
	$fq = doquery("SELECT * FROM {{table}} WHERE fleet_owner={$user['id']}",'fleets');
	$i=0;
	while($f = mysql_fetch_array($fq)){
		$i++;
		$fpage .= "<tr height=20><th>".gmdate("D M d H:i:s",$f['fleet_end_time']-3*60*60)."</th><th colspan=3>";
		$fpage .= "una flota se acerca al planeta  bla bla bla a {$missiontype[$f[fleet_mission]]}";
		$fpage .= '(<a title="';
		/*
		  Se debe hacer una lista de las tropas
		*/
		$fleet = explode("\r\n",$f['fleet_array']);
		$e=0;
		foreach($fleet as $a =>$b){
			if($b != ''){
				$e++;
				$a = explode(",",$b);
				$fpage .= "{$lang['tech']{$a[0]}}: {$a[1]}\n";
				if($e>1){$fpage .= "\t";}
			}
		}
		$fpage .= "\">{$f[fleet_amount]}</a>)";
		$fpage .= "desde [{$f[fleet_start_galaxy]}:{$f[fleet_start_system]}:{$f[fleet_start_planet]}] hasta";
		$fpage .= "[{$f[fleet_end_galaxy]}:{$f[fleet_end_system]}:{$f[fleet_end_planet]}]";
		$fpage .= "</th>";
	}

	/*
	  Cuando un jugador tiene mas de un planeta, se muestra una lista de ellos a la derecha.
	*/
	
	$planets_query = doquery("SELECT * FROM {{table}} WHERE id_owner='{$user['id']}'","planets");
	$c = 1;
	while($p = mysql_fetch_array($planets_query)){
		
		if($p["id"] != $user["current_planet"]){
			$ap .= "<th>{$p['name']}<br>
			<a href=\"?cp={$p['id']}&re=0\" title=\"{$p['name']}\"><img src=\"{$dpath}planeten/small/s_{$p['image']}.jpg\" height=\"50\" width=\"50\"></a><br>
			<center>";
			/*
			  Gracias al 'b_building_id' y al 'b_building' podemos mostrar en el overview
			  si se esta construyendo algo en algun planeta.
			*/
			if($p['b_building_id'] != 0){
				if(check_building_progress($p)){
					$ap .= $lang['tech'][$p['b_building_id']];
					$time = pretty_time($p['b_building'] - time());
					$ap .= "<br><font color=\"#7f7f7f\">({$time})</font>";
				}
				else{$ap .= $lang['Free'];}
			}else{$ap .= $lang['Free'];}
			
			$ap .= "<center></center></center></th>";
			//Para ajustar a dos columnas
			if($c <= 1){$c++;}else{$ap .= "</tr><tr>";$c = 1;	}
		}
	}


	$parse = $lang;

	$parse['planet_name'] = $planetrow['name'];
	$parse['planet_diameter'] = $planetrow['diameter'];
	$parse['planet_field_current'] = $planetrow['field_current'];
	$parse['planet_field_max'] = $planetrow['field_max'];
	$parse['planet_temp_min'] = $planetrow['temp_min'];
	$parse['planet_temp_max'] = $planetrow['temp_max'];
	$parse['galaxy_galaxy'] = $galaxyrow['galaxy'];
	$parse['galaxy_planet'] = $galaxyrow['planet'];
	$parse['galaxy_system'] = $galaxyrow['system'];
	$parse['user_points'] = pretty_number($user['points_points']/1000);
	$rank = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE points_points>={$user['points_points']}","users",true);
	$parse['user_rank'] = $rank[0];
	$parse['u_user_rank'] = $rank[0];
	$parse['user_username'] = $user['username'];
	$parse['fleet_list'] = $fpage;
	$parse['energy_used'] = $planetrow["energy_max"]-$planetrow["energy_used"];

	$parse['Have_new_message'] = $Have_new_message;
	$parse['time'] = date("D M d H:i:s",time());

	$parse['dpath'] = $dpath;

	$parse['planet_image'] = $planetrow['image'];
	$parse['anothers_planets'] = $ap;
	$parse['max_users'] = $game_config['users_amount'];
	//Muestra los escombros en la posicion del planeta  * Agregado en v0.1 r46 *
	$parse['metal_debris'] = $galaxyrow['metal'];
	$parse['crystal_debris'] = $galaxyrow['crystal'];
	//El link
	if(($galaxyrow['metal']!=0||$galaxyrow['crystal']!=0)&&$planetrow[$resource[209]]!=0){
		$parse['get_link'] = " (<a href=\"quickfleet.php?mode=harvest&g={$galaxyrow['system']}&s={$galaxyrow['system']}&p={$galaxyrow['planet']}\">{$lang['Harvest']}</a>)";
	}else{$parse['get_link'] = '';}
	//
	//Muestra la actual contruccion en el planeta
	//Y un contador, gracias NaNiN por la sugerencia
	if($planetrow['b_building_id']!=0&&$planetrow['b_building']>time()){
		$parse['building'] = $lang['tech'][$planetrow['b_building_id']].
		'<br><div id="bxx" class="z">'.pretty_time($planetrow['b_building'] - time()).'</div><SCRIPT language=JavaScript>
		pp="'.($planetrow['b_building'] - time()).'";
		pk="'.$planetrow["b_building_id"].'";
		pl="'.$planetrow["id"].'";
		ps="buildings.php";
		t();
	</script>';
		//$time =  pretty_time();
		//$a['building'] = "<br><font color=\"#7f7f7f\">({$time})</font>";
		// = parsetemplate(gettemplate('overview_body'), $parse);
	}else{
		$parse['building'] = $lang['Free'];
	}

	$page = parsetemplate(gettemplate('overview_body'), $parse);
	display($page,$lang['Overview']);

}
}
// Created by Perberos. All rights reversed (C) 2006
?>
