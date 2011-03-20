<?php

/*
 _  \_/ |\ | /¯¯\ \  / /\    |¯¯) |_¯ \  / /¯¯\ |  |   |´¯|¯` | /¯¯\ |\ |
 ¯  /¯\ | \| \__/  \/ /--\   |¯¯\ |__  \/  \__/ |__ \_/   |   | \__/ | \|
 @copyright:
Copyright (C) 2010 por Brayan Narvaez (principe negro)
Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar

@support:
Web http://www.xnovarevolution.com.ar/
Forum http://www.xnovarevolution.com.ar/foros/

Proyect based in xg proyect for xtreme gamez.
*/

function ShowPhalanxPage($CurrentUser, $CurrentPlanet)
{
	global $xgp_root, $phpEx, $lang;

	include_once($xgp_root . 'includes/functions/InsertJavaScriptChronoApplet.' . $phpEx);
	include_once($xgp_root . 'includes/classes/class.FlyingFleetsTable.' . $phpEx);
	include_once($xgp_root . 'includes/classes/class.GalaxyRows.' . $phpEx);

	$FlyingFleetsTable 	= new FlyingFleetsTable();
	$GalaxyRows 		= new GalaxyRows();

	$parse	= $lang;

	$radar_menzil_min = $CurrentPlanet['system'] - $GalaxyRows->GetPhalanxRange ( $CurrentPlanet['phalanx'] );
	$radar_menzil_max = $CurrentPlanet['system'] + $GalaxyRows->GetPhalanxRange ( $CurrentPlanet['phalanx'] );
	if ( $radar_menzil_min < 1 )
		$radar_menzil_min = 1;

	if ( $radar_menzil_max > MAX_SYSTEM_IN_GALAXY )
		$radar_menzil_max = MAX_SYSTEM_IN_GALAXY;

	if ( ( intval ( $_GET["system"] ) < $radar_menzil_min ) or ( intval ( $_GET["system"] ) > $radar_menzil_max ) )
	{
		$DoScan = false;
	}

	if ($CurrentPlanet['planet_type'] == 3)
	{
		$parse['phl_pl_galaxy']    = $CurrentPlanet['galaxy'];
		$parse['phl_pl_system']    = $CurrentPlanet['system'];
		$parse['phl_pl_place']     = $CurrentPlanet['planet'];
		$parse['phl_pl_name']      = $CurrentUser['username'];

		if ($CurrentPlanet['deuterium'] > 10000)
		{
			doquery ("UPDATE {{table}} SET `deuterium` = `deuterium` - '10000' WHERE `id` = '". $CurrentUser['current_planet'] ."';", 'planets');
			$parse['phl_er_deuter'] = "";
			$DoScan                 = true;
		}
		else
		{
			$parse['phl_er_deuter'] = $lang['px_no_deuterium'];
			$DoScan                 = false;
		}

		if ($DoScan == true)
		{
			$Galaxy  = $_GET["galaxy"];
			if($Galaxy != $CurrentPlanet['galaxy']){
			$Galaxy = $CurrentPlanet['galaxy'];
			}
			$System  = $_GET["system"];
			$Planet  = $_GET["planet"];
			$PlType  = 1;
// ************
	function GetPhalanxRange($PhalanxLevel)
	{
		$PhalanxRange = 0;

		if ($PhalanxLevel > 1)
		{
			$PhalanxRange = pow($PhalanxLevel, 2) - 1;
		}
		elseif($PhalanxLevel == 1)
		{
			$PhalanxRange = 1;
		}

		return $PhalanxRange;
	}

	$radar_kademesi = $CurrentPlanet['phalanx'];
	
	
	$menzil = GetPhalanxRange($radar_kademesi);
	
	$limit_min = $CurrentPlanet['system'] - $menzil;
	if($limit_min < 1){
	$limit_min =1;
	}
	$limit_max = $CurrentPlanet['system'] + $menzil;
		if($System < $limit_min || $System > $limit_max || $_GET["planettype"] != 1)
		{
		$Fleets = "<tr><th>Hedef menzil disinda!</th></tr>";
		}else{
// **************
	
			$TargetInfo = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '". mysql_escape_string($Galaxy) ."' AND `system` = '". mysql_escape_string($System) ."' AND `planet` = '". mysql_escape_string($Planet) ."' AND `planet_type` = '". $PlType ."';", 'planets', true);
			$TargetName = $TargetInfo['name'];

			$QryLookFleets  = "SELECT * ";
			$QryLookFleets .= "FROM {{table}} ";
			$QryLookFleets .= "WHERE ( ( ";
			$QryLookFleets .= "`fleet_start_galaxy` = '". mysql_escape_string($Galaxy) ."' AND ";
			$QryLookFleets .= "`fleet_start_system` = '". mysql_escape_string($System) ."' AND ";
			$QryLookFleets .= "`fleet_start_planet` = '". mysql_escape_string($Planet) ."' AND ";
			$QryLookFleets .= "`fleet_start_type` = '". $PlType ."' ";
			$QryLookFleets .= ") OR ( ";
			$QryLookFleets .= "`fleet_end_galaxy` = '". mysql_escape_string($Galaxy) ."' AND ";
			$QryLookFleets .= "`fleet_end_system` = '". mysql_escape_string($System) ."' AND ";
			$QryLookFleets .= "`fleet_end_planet` = '". mysql_escape_string($Planet) ."' AND ";
			$QryLookFleets .= "`fleet_end_type` = '". $PlType ."' ";
			$QryLookFleets .= ") ) ";
			$QryLookFleets .= "ORDER BY `fleet_start_time`;";

			$FleetToTarget  = doquery( $QryLookFleets, 'fleets' );

			if (mysql_num_rows($FleetToTarget) <> 0 )
			{
				while ($FleetRow = mysql_fetch_array($FleetToTarget))
				{
					$Record++;

					$StartTime   = $FleetRow['fleet_start_time'];
					$StayTime    = $FleetRow['fleet_end_stay'];
					$EndTime     = $FleetRow['fleet_end_time'];

					if ($FleetRow['fleet_owner'] == $TargetInfo['id_owner'])
						$FleetType = true;
					else
						$FleetType = false;

					$FleetRow['fleet_resource_metal']     = 0;
					$FleetRow['fleet_resource_crystal']   = 0;
					$FleetRow['fleet_resource_deuterium'] = 0;
					$FleetRow['fleet_resource_darkmatter'] = 0;

					$Label = "fs";
					if ($StartTime > time())
						$fpage[$StartTime] = $FlyingFleetsTable->BuildFleetEventTable ( $FleetRow, 0, $FleetType, $Label, $Record );

					if ($FleetRow['fleet_mission'] <> 4)
					{
						$Label = "ft";
						if ($StayTime > time())
							$fpage[$StayTime] = $FlyingFleetsTable->BuildFleetEventTable ( $FleetRow, 1, $FleetType, $Label, $Record );

						if ($FleetType == true)
						{
							$Label = "fe";
							if ($EndTime > time())
								$fpage[$EndTime]  = $FlyingFleetsTable->BuildFleetEventTable ( $FleetRow, 2, $FleetType, $Label, $Record );
						}
					}
				}
			}
	
			if (count($fpage) > 0)
			{
				ksort($fpage);
				foreach ($fpage as $FleetTime => $FleetContent)
				{
					$Fleets .= $FleetContent ."\n";
				}
			}
		}

		$parse['phl_fleets_table'] = $Fleets;
	}
	
	}
	
	else
	{
		header("location:game.php?page=overview");
	}

	return display(parsetemplate(gettemplate('galaxy/phalanx_body'), $parse), false, '', false, false);
}
?>
