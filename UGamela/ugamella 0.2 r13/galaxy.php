<?php //galaxy.php :: Vision de la galaxia

define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.php"); }

//
// Esta funcion permite cambiar el planeta actual.
//
include($ugamela_root_path . 'includes/planet_toggle.'.$phpEx);

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
check_field_current($planetrow);

includeLang('galaxy');
$parse = $lang;
//Comenzamos a contar los planetas
$planetcount = 0;

//
// Comprobacion para obtener las coordenadas a previsualizar
//
if(isset($g) && isset($s)){
	$galaxy =  $g;
	$system =  $s;
}elseif(!$_POST){
	//pedimos el planeta actual
	$planetrow = doquery("SELECT * FROM {{table}} WHERE id = '{$user['current_planet']}'",'planets',true);
	
	$query = doquery("SELECT * FROM {{table}} WHERE id_planet = '{$planetrow['id']}'",'galaxy',true);
	//la posicion actual donde se encuentra el planeta activo.
	$galaxy = round((!$galaxy) ? $query["galaxy"] : $galaxy);
	$system = round((!$system) ? $query["system"] : $system);
	
}else{
	//Agrega o quita +1 en $galaxy
	if($_POST["galaxyLeft"]){
		$galaxy = $_POST["galaxy"] -1;
	}elseif($_POST["galaxyRight"]){
		$galaxy =  $_POST["galaxy"] +1;
	}else{
		$galaxy = (!$galaxy) ? $_POST["galaxy"] : $galaxy;//default
	}
	//Agrega o quita +1 en $system
	if($_POST["systemLeft"]){
		$system =  $_POST["system"] -1;
	}elseif($_POST["systemRight"]){
		$system =  $_POST["system"] +1;
	}else{
		$system = (!$system) ? $_POST["system"] : $system;//default
	}

}
//
// y el resto...
//
//ahora delimitamos el maximo de los sistemas solares permitidos
if($galaxy<1){$galaxy=1;}
if($galaxy>$game_config['max_galaxy']){$galaxy=$game_config['max_galaxy'];}
$parse['galaxy'] = $galaxy;
if($system<1){$system=1;}
if($system>$game_config['max_system']){$system=$game_config['max_system'];}
$parse['system'] = $system;
/*
  Esta parte lo que hace es crear una array a partir de una query no fecheada.
  Con esto evitamos hacer queries diferentes en el for
*/
$query = doquery("SELECT * FROM {{table}} WHERE galaxy='{$galaxy}' AND system='{$system}'","galaxy");
while ($qr = mysql_fetch_array($query)) {
	//Agregamos a la array :D
	$galaxyrow[$qr['planet']] = array(
		'id_planet'=>$qr['id_planet'],
		'destruyed'=>$qr['destruyed'],
		'metal'=>$qr['metal'],
		'crystal'=>$qr['crystal'],
		);

}
/*
  Aqui hacemos el loop...
*/
{
	//obtenemos las templates
	$row_galaxy = gettemplate('galaxy_row');
	$row_planet = gettemplate('galaxy_row_planet');
	$row_debris = gettemplate('galaxy_row_debris');
	$row_user = gettemplate('galaxy_row_user');
	$row_ally = gettemplate('galaxy_row_ally');
	$row_action = gettemplate('galaxy_row_action');
	
	for($i = 1; $i<=$game_config['max_position']; $i++){//mega loop para listar los jugadores y las alianzas
		unset($planetrow);
		unset($playerrow);
		unset($allyrrow);
		$p = array();
		//$planet = doquery( ,"galaxy",true);
		//solo pedimos el user si existe
		if($galaxyrow[$i]){
			
			$planetrow = doquery("SELECT * FROM {{table}} WHERE id='{$galaxyrow[$i]['id_planet']}'","planets",true);
			/*
			  Pequeña conprovacion para verificar que un planeta esta destruido
			  En caso de que sea cierto, este se quita de la base de datos si cumplio el maximo
			  de tiempo establecido en el campo destruyed
			*/
			if($planetrow["destruyed"] != 0){
				check_abandon_planet($planetrow);
			}else{
				$planetcount++;
				$playerrow = doquery("SELECT * FROM {{table}} WHERE id='{$planetrow["id_owner"]}'","users",true);
			}
			
		}
		
		//
		// algunos parse comunes
		//
		$tabindex = $i + 1;
		$p['tab'] = ($galaxyrow[$i]['id_planet'] != 0) ? " tabindex=\"$tabindex\">": ">";
		$p['g'] = $galaxy;
		$p['s'] = $system;
		$p['i'] = $i;
		$p['p'] = $i;
		$p['T_TEMP'] = $user["settings_tooltiptime"]*1000;
		$p['dpath'] = $dpath;
			
		//
		// Row del planeta
		//
		if($galaxyrow[$i] && $planetrow['destruyed'] == 0 && $galaxyrow[$i]['id_planet'] != 0){
			$p['planet_name'] = $planetrow{"name"};
			$p['image'] = $planetrow["image"];
			//pegamos el galaxy_row_planet
			$p['row_planet'] = parsetemplate($row_planet, $p);
			
		}elseif($planetrow["destruyed"] != 0){
			$p['planet_name'] = "Planeta destruido";
			$p['row_planet'] = '';
		}else{
			$p['planet_name'] = '';
			$p['row_planet'] = '';
		}
		
		//
		// Row para mostrar escombros
		//
		if($galaxyrow[$i]){
			
			if($galaxyrow[$i]['metal'] != 0 || $galaxyrow[$i]['crystal'] != 0 ){
				//muestra de color rojo el fondo cuando hay muchos recursos
				if ($galaxyrow[$i]['metal'] >= 5000 || $galaxyrow[$i]['crystal'] >= 5000 ){
					$p['debris_style'] = 'style=\"background-color: rgb(51, 0, 0);background-image: none;" ';
				}else{
					$p['debris_style'] = 'style=\"background-image: none;" ';
				}
				//pegamos el galaxy_row_debris
				$p['row_debris'] = parsetemplate($row_planet, $p);
			}else{
				$p['debris_style'] = "";
				$p['row_debris'] = "";
			}//Fin escombros
		}else{
			$p['debris_style'] = "";
			$p['row_debris'] = "";
		}//Fin escombros
		
		//
		// Row del usuario row_user
		//
		if($playerrow  && $planetrow["destruyed"] == 0){
			
			$p['username'] = $playerrow["username"];
			$p['user_id'] = $playerrow["id"];
			$p['row_user'] = parsetemplate($row_user, $p);
		}else{
			$p['row_user'] = "";
		}
		
		//
		// Row de alianza row_ally
		//
		if($playerrow['ally_id'] && $playerrow['ally_id'] !=0){
			
			$allyquery = doquery("SELECT * FROM {{table}} WHERE id={$playerrow['ally_id']}","alliance",true);
			
			if($allyquery){
				$p['ally_name'] = $allyquery['ally_name'];
				$p['ally_id'] = $allyquery['id'];
				$p['ally_web'] = $allyquery['ally_web'];
				$p['ally_tag'] = $allyquery['ally_tag'];
				$query = doquery("SELECT * FROM {{table}} WHERE ally_points>='380' ORDER BY ally_points ASC",'alliance',true);
				$p['ally_rank'] = $query[0];
				//info tips
				$p['AllyInfoText'] = str_replace('%n',$allyquery['ally_name'],$lang['AllyInfoText']);//ally_name
				$p['AllyInfoText'] = str_replace('%r',$query[0],$p['AllyInfoText']);//ally_rank
				$p['AllyInfoText'] = str_replace('%m',$allyquery['ally_members'],$p['AllyInfoText']);//ally_members
				//esto es laborioso :(
				$p['row_ally'] = parsetemplate($row_ally, $p);
				
			}else{
				$p['row_ally'] = '';
			}
		}else{
			$p['row_ally'] = '';
		}
		
		//
		// Row de acciones
		//
		$p['row_action'] = '';
		if($playerrow && $planetrow["destruyed"] == 0){
			
			//el iconito de espiar
			if($user["settings_esp"] == "1"){
				$p['row_action'] .= '<a style="cursor: pointer;"
				onclick="javascript:doit(6, '.$g.', '.$s.', '.$i.', 1, 1);">
				<img src="'.$dpath.'img/e.gif" alt="Espiar" title="Espiar" border="0"></a>';
			}
			//el de enviar mensajes
			if($user["settings_wri"] == "1"){
				$p['row_action'] .= '<a href="messages.php?mode=write&id='.
				$playerrow["id"].'"><img src="'.$dpath.'img/m.gif" alt="Escribir mensaje" title="Escribir mensaje" border="0"></a>';
			}
			if($user["settings_bud"] == "1"){
				$p['row_action'] .= '<a href="buddy.php?a=2&amp;u='.
				$playerrow["id"].'"><img src="'.$dpath.'img/b.gif" alt="Solicitud de compa⦲os" title="Solicitud de compa⦲os" border="0"></a>';
			}
		}
		
		$echo_galaxy .= parsetemplate($row_galaxy, $p);
		
	}
	
	$parse['echo_galaxy'] = $echo_galaxy;
}
/*
  Si colocas el echo_galaxy despues que el Planet_count, $planetcount será 0
*/
$parse['planetcount'] = str_replace('%n',$planetcount,$lang['Planets_count']);
$parse['Solar_system_at'] = str_replace('%g',$galaxy,$lang['Solar_system_at']);
$parse['Solar_system_at'] = str_replace('%s',$system,$parse['Solar_system_at']);

$page = parsetemplate(gettemplate('galaxy_body'), $parse);
display($page,$lang['Galaxy'],false);

// Created by Perberos. All rights reversed (C) 2006
?>
