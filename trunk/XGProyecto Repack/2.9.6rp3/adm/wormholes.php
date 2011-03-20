<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

if ($user['authlevel'] < 1) die(message ($lang['404_page']));

	if($_GET['mode'] == 'delete'){
		doquery("UPDATE {{table}} SET `state` = '0' WHERE `id` = '".$_GET['id']."';", 'wormholes');
	}
	if($_GET['mode'] == 'erase'){
		doquery("DELETE FROM {{table}} WHERE `id` = '".$_GET['id']."';", 'wormholes');
	}
	if($_GET['mode'] == 'open'){
		doquery("UPDATE {{table}} SET `state` = '1' WHERE `id` = '".$_GET['id']."';", 'wormholes');
	}
	if($_GET['mode'] == 'create'){
		if($_POST){
			$QryInsertPlanet = "INSERT INTO {{table}} SET ";
			$QryInsertPlanet .= "`time` = '".              (($_POST['closetime'] * 60 * 60) + time())              ."', ";
			$QryInsertPlanet .= "`state` = '".$_GET['state']."', ";
			$QryInsertPlanet .= "`start_galaxy` = '".          $_POST['start_galaxy']          ."', ";
			$QryInsertPlanet .= "`start_system` = '".          $_POST['start_system']          ."', ";
			$QryInsertPlanet .= "`start_planet` = '".          $_POST['start_planet']          ."', ";
			$QryInsertPlanet .= "`end_galaxy` = '".          $_POST['end_galaxy']          ."', ";
			$QryInsertPlanet .= "`end_system` = '".          $_POST['end_system']          ."', ";
			$QryInsertPlanet .= "`end_planet` = '".          $_POST['end_planet']          ."'; ";
			doquery( $QryInsertPlanet, 'wormholes',  false);
		}else{
			$page = '<br><form action="wormholes.php?mode=create&state='.$_GET['state'].'" method="post"><table width="500"><tr><td class="c" colspan="4">Crear un agujero</td></tr><tr><td class="c">Cierre (horas)</td><td class="c">Inicio</td><td class="c">Fin</td><td class="c">Acciones</td></tr>';
			$page .= '<tr><th><input type="text" name="closetime" /></th><th>[<input type="text" size="1" name="start_galaxy" />:<input type="text" size="1" name="start_system" />:<input type="text" size="1" name="start_planet" />]</th><th>[<input type="text" size="1" name="end_galaxy" />:<input type="text" size="1" name="end_system" />:<input type="text" size="1" name="end_planet" />]</th><th><input type="submit" value="Abrir" /></th></tr>';
			$page .= "</table></form>";
			display ( $page, false, '', true, false);
		}
	}
	if($_GET['mode'] == 'rand'){
		for($cant = 1; $cant <= intval($_GET['cant']); $cant++){
			$StartGalaxy = mt_rand(1, MAX_GALAXY_IN_WORLD);
			$StartSystem = mt_rand(1, MAX_SYSTEM_IN_GALAXY);
			$StartPlanet = mt_rand(1, MAX_PLANET_IN_SYSTEM);
			$SelectFinished1 = false;
			while($SelectFinished1 == false){
				$planetquery = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '".$StartGalaxy."' AND `system` = '".$StartSystem."' AND `planet` = '".$StartPlanet."'; ", 'galaxy', true);
				if($planetquery){
					$StartGalaxy = mt_rand(1, MAX_GALAXY_IN_WORLD);
					$StartSystem = mt_rand(1, MAX_SYSTEM_IN_GALAXY);
					$StartPlanet = mt_rand(1, MAX_PLANET_IN_SYSTEM);
					$SelectFinished1 = false;
				}else{
					$SelectFinished1 = true;
				}
			
			}
			$EndGalaxy = mt_rand(1, MAX_GALAXY_IN_WORLD);
			$EndSystem = mt_rand(1, MAX_SYSTEM_IN_GALAXY);
			$EndPlanet = mt_rand(1, MAX_PLANET_IN_SYSTEM);
			$SelectFinished2 = false;
			while($SelectFinished2 == false){
				$planetquery = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '".$EndGalaxy."' AND `system` = '".$EndSystem."' AND `planet` = '".$EndPlanet."'; ", 'galaxy', true);
				if($planetquery){
					$EndGalaxy = mt_rand(1, MAX_GALAXY_IN_WORLD);
					$EndSystem = mt_rand(1, MAX_SYSTEM_IN_GALAXY);
					$EndPlanet = mt_rand(1, MAX_PLANET_IN_SYSTEM);
					$SelectFinished2 = false;
				}else{
					$SelectFinished2 = true;
				}
			
			}
			$WormHoleTime = (time() + ((mt_rand(25, 140) * 2) * 60 * 60));		
			if($SelectFinished1 == true and $SelectFinished2 == true){
				$QryInsertPlanet = "INSERT INTO {{table}} SET ";
				$QryInsertPlanet .= "`time` = '".              $WormHoleTime              ."', ";
				$QryInsertPlanet .= "`state` = '1', ";
				$QryInsertPlanet .= "`start_galaxy` = '".          $StartGalaxy          ."', ";
				$QryInsertPlanet .= "`start_system` = '".          $StartSystem          ."', ";
				$QryInsertPlanet .= "`start_planet` = '".          $StartPlanet          ."', ";
				$QryInsertPlanet .= "`end_galaxy` = '".          $EndGalaxy          ."', ";
				$QryInsertPlanet .= "`end_system` = '".          $EndSystem          ."', ";
				$QryInsertPlanet .= "`end_planet` = '".          $EndPlanet          ."'; ";
				doquery( $QryInsertPlanet, 'wormholes',  false);
			}
		}
	}
	if($_GET['mode'] == 'edit'){
	
		if($_POST){
			$QryInsertPlanet  = "UPDATE {{table}} SET ";
			$QryInsertPlanet .= "`time` = '".              (($_POST['closetime'] * 60 * 60) + time())              ."', ";
			$QryInsertPlanet .= "`start_galaxy` = '".          $_POST['start_galaxy']          ."', ";
			$QryInsertPlanet .= "`start_system` = '".          $_POST['start_system']          ."', ";
			$QryInsertPlanet .= "`start_planet` = '".          $_POST['start_planet']          ."', ";
			$QryInsertPlanet .= "`end_galaxy` = '".          $_POST['end_galaxy']          ."', ";
			$QryInsertPlanet .= "`end_system` = '".          $_POST['end_system']          ."', ";
			$QryInsertPlanet .= "`end_planet` = '".          $_POST['end_planet']          ."' WHERE `id` = '".$_POST['id']."' ;";
			doquery( $QryInsertPlanet, 'wormholes');
		}else{
			$WormHole = doquery("SELECT * FROM {{table}} WHERE `id` = '".$_GET['id']."';", 'wormholes', true);
			$page = '<br><form action="wormholes.php?mode=edit" method="post"><input type="hidden" name="id" value="'.$_GET['id'].'" /><table width="500"><tr><td class="c" colspan="4">Editar un agujero</td></tr><tr><td class="c">Cierre (horas)</td><td class="c">Inicio</td><td class="c">Fin</td><td class="c">Acciones</td></tr>';
			$page .= '<tr><th><input type="text" name="closetime" value="'.( (($WormHole['time'] - time() ) / 60 ) / 60).'" /></th><th>[<input type="text" size="1" name="start_galaxy" value="'.$WormHole['start_galaxy'].'" />:<input type="text" size="1" name="start_system" value="'.$WormHole['start_system'].'" />:<input type="text" size="1" name="start_planet" value="'.$WormHole['start_planet'].'" />]</th><th>[<input type="text" size="1" name="end_galaxy" value="'.$WormHole['end_galaxy'].'" />:<input type="text" size="1" name="end_system" value="'.$WormHole['end_system'].'" />:<input type="text" size="1" name="end_planet" value="'.$WormHole['end_planet'].'" />]</th><th><input type="submit" value="Editar" /></th></tr>';
			$page .= "</table></form>";
			display ( $page, false, '', true, false);
		}
	}
	$page = '<br><table width="500"><tr><td class="c" colspan="6">Agujeros de gusano - <a href="wormholes.php?mode=create&state=1">Crear</a>&nbsp;|&nbsp;<a href="wormholes.php?mode=rand&cant=1">Aleatorio</a>&nbsp;|&nbsp;<a href="wormholes.php?mode=create&state=2">Crear Natural</a></td></tr><tr><td class="c">#ID</td><td class="c">Cierre</td><td class="c">Flotas</td><td class="c">Inicio</td><td class="c">Fin</td><td class="c">Acciones</td></tr>';
	$RowTemplate = '<tr><th>{id}</th><th>{close}</th><th>{fleets}</th><th>{start_coord}</th><th>{end_coord}</th><th>{delete}{edit}</th></tr>';
	$AllWormHoles = doquery("SELECT * FROM {{table}};", 'wormholes');
	$WormHoleFleets = array();
	$WormFleets = doquery("SELECT * FROM {{table}} WHERE `fleet_wormhole` != '0';", 'fleets', false);
	while($Fleet = mysql_fetch_array($WormFleets)){
		if(!isset($WormHoleFleets[$WormHole['id']])){
			$WormHoleFleets[$FleetInfo[0]] = 0;
		}
		$FleetInfo = explode(',' , $Fleet['fleet_wormhole']);
		$WormHoleFleets[$FleetInfo[0]]++;
	}
	while($WormHole = mysql_fetch_array($AllWormHoles)){
		$bloc = array();
		$bloc['id'] = $WormHole['id'];
		if($WormHole['state'] == 2){
			$bloc['close'] = "Infinito";
		}else{
			$bloc['close'] = pretty_time(($WormHole['time'] - time()));
		}
		$bloc['start_coord'] = "[".$WormHole['start_galaxy'].":".$WormHole['start_system'].":".$WormHole['start_planet']."]";
		$bloc['end_coord'] = "[".$WormHole['end_galaxy'].":".$WormHole['end_system'].":".$WormHole['end_planet']."]";
		if(isset($WormHoleFleets[$WormHole['id']])){
			$bloc['fleets'] = $WormHoleFleets[$WormHole['id']];
		}else{
			$bloc['fleets'] = "0";		
		}
		if($WormHole['state'] == 1){
			$bloc['delete'] = "<a href='wormholes.php?mode=delete&id=".$WormHole['id']."'>Cerrar</a><br><a href='wormholes.php?mode=erase&id=".$WormHole['id']."'>Eliminar</a><br>";
		}elseif($WormHole['state'] == 2){
			$bloc['delete'] = "<a href='wormholes.php?mode=erase&id=".$WormHole['id']."'>Eliminar</a><br>";		
		}elseif($WormHole['time'] >= time()){
			$bloc['delete'] = "<a href='wormholes.php?mode=open&id=".$WormHole['id']."'>Abrir</a><br><a href='wormholes.php?mode=erase&id=".$WormHole['id']."'>Eliminar</a><br>";		
		}
		$bloc['edit'] = "<a href='wormholes.php?mode=edit&id=".$WormHole['id']."'>Editar</a><br>";
		$page .= parsetemplate($RowTemplate, $bloc);
	}
	$page .= "</table>";

	display ( $page, false, '', true, false);
	
?>