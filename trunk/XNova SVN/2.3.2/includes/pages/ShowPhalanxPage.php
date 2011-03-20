<?php
//version 1



function ShowPhalanxPage($CurrentUser, &$CurrentPlanet)
{
	global $svn_root, $phpEx, $lang,$db,$displays;

	include_once($svn_root . 'includes/functions/InsertJavaScriptChronoApplet.' . $phpEx);
	include_once($svn_root . 'includes/functions/classes/class.FlyingFleetsTable.' . $phpEx);

	$FlyingFleetsTable = new FlyingFleetsTable();

	//$parse	= $lang;
        $displays->assignContent('galaxy/phalanx_body');

	if ($CurrentPlanet['planet_type'] == 3)
	{
		$parse['phl_pl_galaxy']    = $CurrentPlanet['galaxy'];
		$parse['phl_pl_system']    = $CurrentPlanet['system'];
		$parse['phl_pl_place']     = $CurrentPlanet['planet'];
		$parse['phl_pl_name']      = $CurrentUser['username'];

		if ($CurrentPlanet['deuterium'] > 10000)
		{
                        $CurrentPlanet['deuterium'] -= 10000;
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
			$System  = $_GET["system"];
			$Planet  = $_GET["planet"];
			$PlType  = $_GET["planettype"];

			$TargetInfo = $db->query("SELECT * FROM {{table}} WHERE `galaxy` = '". $Galaxy ."' AND `system` = '". $System ."' AND `planet` = '". $Planet ."' AND `planet_type` = '". $PlType ."';", 'planets', true);
			$TargetName = $TargetInfo['name'];

			$QryLookFleets  = "SELECT * ";
			$QryLookFleets .= "FROM {{table}} ";
			$QryLookFleets .= "WHERE ( ( ";
			$QryLookFleets .= "`fleet_start_galaxy` = '". $Galaxy ."' AND ";
			$QryLookFleets .= "`fleet_start_system` = '". $System ."' AND ";
			$QryLookFleets .= "`fleet_start_planet` = '". $Planet ."' AND ";
			$QryLookFleets .= "`fleet_start_type` = '". $PlType ."' ";
			$QryLookFleets .= ") OR ( ";
			$QryLookFleets .= "`fleet_end_galaxy` = '". $Galaxy ."' AND ";
			$QryLookFleets .= "`fleet_end_system` = '". $System ."' AND ";
			$QryLookFleets .= "`fleet_end_planet` = '". $Planet ."' AND ";
			$QryLookFleets .= "`fleet_end_type` = '". $PlType ."' ";
			$QryLookFleets .= ") ) ";
			$QryLookFleets .= "ORDER BY `fleet_start_time`;";

			$FleetToTarget  = $db->query( $QryLookFleets, 'fleets' );

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

                foreach($parse as $key => $value){
                    $displays->assign($key,$value);
                }
	}
	else
	{
		header("location:game.php?page=overview");
	}

	$displays->display();
}
?>