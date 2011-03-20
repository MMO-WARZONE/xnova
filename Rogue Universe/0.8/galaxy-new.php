<?php

define('INSIDE', true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);
require($ugamela_root_path . 'config.' . $phpEx);
	
	includeLang('galaxy');
	includeLang('fleet');
	includeLang('imperium');
	
	// NEEDED GLOBALS VARS
	$UserPoints = doquery("SELECT * FROM {{table}} WHERE `stat_type` = 1 AND `stat_code` = 1 AND `id_owner` = ". $user['id'], 'statpoints', true);
	$CurrentSystem = $planetrow['system'];
	$CurrentGalaxy = $planetrow['galaxy'];
	
	$MaxFleet = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = " . $user['id'], 'fleets');
	$MaxFleetCount = mysql_num_rows($MaxFleet);
	
	$FleetMax      = 1 + $user[$resource[108]] + ($user[$resource[611]] * 3);
	$CurrentMIP    = $planetrow['interplanetary_misil'];
	$CurrentRC     = $planetrow['recycler'];
	$CurrentSP     = $planetrow['spy_sonde'];
	$HavePhalanx   = $planetrow['phalanx'];
	$CurrentSystem = $planetrow['system'];
	$CurrentGalaxy = $planetrow['galaxy'];
	$CanDestroy    = $planetrow[$resource[213]] + $planetrow[$resource[214]];
	
	// USELESS YET, NEEDED FOR MIPS I THINK
	$_GET['mode'] = cleanNumeric($_GET['mode']);
	
	
	if($_POST OR $_GET['galaxy'] OR $_GET['system']){	
		if($_POST){
			// PREVENT NO-NUMERIC VALUES
			$_POST['galaxy'] = cleanNumeric($_POST['galaxy']);
			$_POST['system'] = cleanNumeric($_POST['system']);
		
			$system = $_POST['system'];
			$galaxy = $_POST['galaxy'];
		
			if($_POST['galaxyLeft']){
				$galaxy = $galaxy - 1;
			}elseif($_POST['galaxyRight']){	
				$galaxy = $galaxy + 1;
			}
			if($_POST['systemLeft']){
				$system = $system - 1;
			}elseif($_POST['systemRight']){	
				$system = $system + 1;
			}
		}else if($_GET){
			$_GET['galaxy'] = cleanNumeric($_GET['galaxy']);
			$_GET['system'] = cleanNumeric($_GET['system']);
			$system = $_GET['system'];
			$galaxy = $_GET['galaxy'];
		}
		if ($galaxy < 1 OR !$galaxy)	$galaxy = 1;
		if ($galaxy > MAX_GALAXY_IN_WORLD)	$galaxy = MAX_GALAXY_IN_WORLD;
		if ($system < 1 OR !$system)	$system = 1;
		if ($system > MAX_SYSTEM_IN_GALAXY)	$system = MAX_SYSTEM_IN_GALAXY;
	}

	$position[galaxy] = (empty($galaxy)) ? $planetrow['galaxy'] : $galaxy;
	$position[system] = (empty($system)) ? $planetrow['system'] : $system;
	$position[planet] = (empty($planet)) ? $planetrow['planet'] : $planet;
	$position[planet_type] = (empty($planet_type)) ? $planetrow['planet_type'] : $planet_type;
	
	
	$tp = new TemplatePower($ugamela_root_path . TEMPLATE_DIR . TEMPLATE_NAME . "/galaxy_body_new.tpl" );
	$tp->prepare();
	
	// MOVEMENT BLOCK
	$tp->newBlock("movement");
	foreach($position as $name => $trans){
		$tp->assign($name, $trans);
	}

	// SHORT DEFINITION
	$g = $position[galaxy];
	$s = $position[system];
	
	// GALAXY TABLE BLOCK
	// PREPARE THE $galaxy:$system
	$lang['Solar_system_at'] = $lang['Solar_system'] . " ".$g.":".$s;
	
	// PLANET INFORMATION
	$sql = "SELECT 
				l.temp_min, l.diameter, l.name as moon_name,
				g.*, g.metal as debris_metal, g.crystal as debris_crystal, g.planet as planetpos,
				p.*, p.name as planet_name,
				u.*,
				s.total_points, s.total_rank,
				a.ally_tag, a.ally_name, a.ally_web, a.ally_members
			FROM {{table}}planets as p
				
				LEFT JOIN {{table}}galaxy as g ON g.id_planet = p.id
				LEFT JOIN {{table}}users as u ON u.id = p.id_owner
				LEFT JOIN {{table}}alliance as a ON a.id = u.ally_id
				LEFT JOIN {{table}}planets as l ON l.id = g.id_luna AND l.planet_type = 3
				LEFT JOIN {{table}}statpoints as s ON s.id_owner = u.id AND stat_type = 1 AND stat_code = 1 
				
			WHERE 
					g.galaxy = $g 
				AND g.system = $s 
			ORDER BY g.planet ASC";
	$rs = doquery($sql, '');
	if($temprow = mysql_fetch_assoc($rs)){
		do{
			$planetsrow[$temprow[planetpos]] = $temprow;
		}while($temprow = mysql_fetch_assoc($rs));
	}
	
	// PLANETS LIST BLOCK
	for($i = 1; $i < 16; $i++){
		
		$tp->newBlock("planets");
		if($planetsrow[$i]):
			
			// PLANET NUMER :/
			$tp->assign("i", $i);
			
			// PLANET IMAGE TOOLTIP
			$planet = _TooltipPlanet($planetsrow[$i], $g, $s, $i, 1);
			$tp->assign("planet", $planet);
			
			// MOON TOOLTIP
			if($planetsrow[$i][id_luna]){
				$moon = _TooltipMoon($planetsrow[$i], $g, $s, $i, 3);
				$tp->assign("moon", $moon);
			}
			unset($moon);			
			
			// PLANET STATUS
			$planet_status = _TooltipPlanetStatus($planetsrow[$i], $g, $s, $i, 1);
			$tp->assign("planet_status", $planet_status);
			
			// DEBRIS FIELD
			if($planetsrow[$i][debris_metal] > 0 OR $planetsrow[$i][debris_crystal] > 0){
				
				$debris = _TooltipDebris($planetsrow[$i], $g, $s, $i, 2);
				
				$debristotal = round($planetsrow[$i][debris_metal] + $planetsrow[$i][debris_crystal]);
				if ($debristotal >= 100000) $debris_class = "debris_small";
				if ($debristotal >= 1000000) $debris_class = "debris_medium";
				if ($debristotal >= 10000000) $debris_class = "debris_large";
				
				$tp->assign("debris", $debris);
				$tp->assign("debris_class", $debris_class);
			}
			
			// USER INFO
			$user_info = _TooltipUser($planetsrow[$i], $g, $s, $i, 0);
			$tp->assign("user_info", $user_info);
			
			// ALLIANCE INFO
			if($planetsrow[$i][ally_id]){
				$ally_info = _TooltipAlliance($planetsrow[$i], $g, $s, $i, 0);
				$tp->assign("ally_info", $ally_info);
			}
			
			// ACTIONS
			$actions = _TooltipActions($planetsrow[$i], $g, $s, $i, 0);
			$tp->assign("actions", $actions);
		
		else:
			// ADD BLANK TDS ?
			
		endif;
	}	
	
	$replace[fleet_count] = $MaxFleetCount;
	$replace[fleet_max] = $FleetMax;
	$replace[Recyclers] = pretty_number($CurrentRC);
	$replace[SpyProbes] = pretty_number($CurrentSP);
	$replace[CurrentMIP] = pretty_number($CurrentMIP);
	$replace[this_galaxy] = $planetrow['galaxy'];
	$replace[this_system] = $planetrow['system'];
	$replace[this_planet] = $planetrow['planet'];
	$replace[this_planet_type] = $planetrow['planet_type'];
	$replace[PHP_SELF] = $_SERVER['PHP_SELF'];
	
	$tp->gotoBlock("_ROOT");
	if(is_array($replace)){
		foreach($replace as $k => $v){
			$tp->assign($k, $v);
		}
	}

	// GLOBAL VARIABLES
	$lang[dpath] = $dpath;
	foreach($lang as $name => $trans){
		$tp->assignGlobal($name, $trans);
	}
	
	$galaxy = $tp->getOutputContent();
	
	display($galaxy, 'Galaxy', false);


?>
