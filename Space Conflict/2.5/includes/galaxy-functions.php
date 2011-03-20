<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** galaxy-functions.php                  **
******************************************/

function makePlanetTooltip($options, $actions, $actionName = 'missiontype'){
	global $lang;
	
	if(!$options OR !is_array($options)) return false;
	
	$tp = new TemplatePower(PATH . TEMPLATE_DIR . TEMPLATE_NAME . "/planet_actions.tpl" );
	$tp->prepare();
	
	switch($options[type]){
		case "planet":
				$tp->newBlock("planet");
			break;
		case "moon":
				$tp->newBlock("moon");
			break;
		case "debris":
				$tp->newBlock("debris");
			break;
		case "ally":
				$tp->newBlock("ally");
			break;
		default:	return false; break;
	}
	

	$actionName = $lang[$actionName];
	
	foreach($options as $k => $v){
		$tp->assign($k, $v);
	}
	
	if($actions AND is_array($actions)){
		foreach($actions[id] as $k => $actionId){
			//echo $actionId . "<-- <br>";
			$tp->newBlock($options[type] . "_actions");
			$tp->assign("action_name", $actionName[$actionId]);
			$tp->assign("action_link", $actions[alink][$k]);
		}
	}
	
	$tool = $tp->getOutputContent();
	
	$find = array('"', "'", "\n", "\r");
	$rep = array('\"', "\'", "", "");
	$tool = str_replace($find, $rep, $tool);
	
	return $tool;
}

function makeTargetWOJava($galaxy, $system, $planet, $planet_type = false){
	global $lang;
	
	if(!$galaxy OR !$galaxy OR !$system OR !$planet) return false;
		
	$return = " [" . $galaxy . ":" . $system . ":" . $planet . "]";
	
	if($planet_type){
		$return .= " (" . $lang['planettype'][$planet_type] . ")";
	}
	
	return $return;
	
}

function calculateDistance($arrStart, $arrEnd){
	if(!$arrStart OR !$arrEnd) return false;
	if(!is_array($arrStart) OR is_array(!$arrEnd)) return false;
	
	$galaxyDiff = $arrStart['galaxy'] - $arrEnd['galaxy'];
	$systemDiff = $arrStart['system'] - $arrEnd['system'];
	$planetDiff = $arrStart['planet'] - $arrEnd['planet'];
	
	if ($galaxyDiff != 0){
		$distance = abs($galaxyDiff) * 20000;
	}elseif ($systemDiff != 0){
		$distance = abs($systemDiff) * 95 + 2700;
	}elseif ($planetDiff != 0){
		$distance = abs($planetDiff) * 5 + 1000;
	}else{
		$distance = 5;
	}
	return $distance;
	
}

function getFlyTime($speed, $distance, $speedmin){
	global $fleet, $game_config;
	
	if(!$speed OR !$distance OR !$speedmin) return false;
	
	$formula = "return round(35000 / ".$speed." * sqrt(".$distance." * 10 / ".$speedmin." )) / (".$game_config['fleet_speed']."/2500);";
	$fleet['fly_time'] = round(eval($formula));
	$fleet['start_time'] = $fleet['fly_time'] + time();
	$fleet['end_time'] = 2*($fleet['fly_time']) + time();
	
	return;
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>