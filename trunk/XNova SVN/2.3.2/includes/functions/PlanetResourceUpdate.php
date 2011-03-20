<?php
//version 1.1


function PlanetResourceUpdate ( $CurrentUser, &$CurrentPlanet, $UpdateTime, $Simul = false )
{
	global $ProdGrid, $resource, $reslist, $db;

	$CurrentPlanet['metal_max']     = (floor (BASE_STORAGE_SIZE * pow (1.5, $CurrentPlanet[ $resource[22] ] ))) * (1 + ($CurrentUser['rpg_stockeur'] * 0.5));
	$CurrentPlanet['crystal_max']   = (floor (BASE_STORAGE_SIZE * pow (1.5, $CurrentPlanet[ $resource[23] ] ))) * (1 + ($CurrentUser['rpg_stockeur'] * 0.5));
	$CurrentPlanet['deuterium_max'] = (floor (BASE_STORAGE_SIZE * pow (1.5, $CurrentPlanet[ $resource[24] ] ))) * (1 + ($CurrentUser['rpg_stockeur'] * 0.5));

	$MaxMetalStorage                = $CurrentPlanet['metal_max']     * MAX_OVERFLOW;
	$MaxCristalStorage              = $CurrentPlanet['crystal_max']   * MAX_OVERFLOW;
	$MaxDeuteriumStorage            = $CurrentPlanet['deuterium_max'] * MAX_OVERFLOW;

	$Caps             = array();
	$BuildTemp        = $CurrentPlanet[ 'temp_max' ];

	$parse['production_level'] = 100;

	if ($CurrentPlanet['energy_max'] == 0 && $CurrentPlanet['energy_used'] > 0)
	{
		$post_porcent = 0;
	}
	elseif ($CurrentPlanet['energy_max'] > 0 && ($CurrentPlanet['energy_used'] + $CurrentPlanet['energy_max']) < 0 )
	{
		$post_porcent = floor(($CurrentPlanet['energy_max']) / ($CurrentPlanet['energy_used']*-1) * 100);
	}
	else
	{
		$post_porcent = 100;
	}

	if ($post_porcent > 100)
	{
		$post_porcent = 100;
	}


	foreach($reslist['prod'] as $ProdID)
        {
		
			$BuildLevelFactor = $CurrentPlanet[ $resource[$ProdID]."_porcent" ];
			$BuildLevel = $CurrentPlanet[ $resource[$ProdID] ];
			$Caps['metal_perhour']     +=  floor( eval  ( $ProdGrid[$ProdID]['formule']['metal']     ) * ( $db->game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue']  * 0.05 ) ) );
			$Caps['crystal_perhour']   +=  floor( eval  ( $ProdGrid[$ProdID]['formule']['crystal']   ) * ( $db->game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue']  * 0.05 ) ) );
			$Caps['deuterium_perhour'] +=  floor( eval  ( $ProdGrid[$ProdID]['formule']['deuterium'] ) * ( $db->game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue']  * 0.05 ) ) );

			if ($ProdID < 4)
			{
				$Caps['energy_used']   +=  floor( eval  ( $ProdGrid[$ProdID]['formule']['energy']    ) * ( $db->game_config['resource_multiplier'] ) );
			}
			elseif ($ProdID >= 4 )
			{
				$Caps['energy_max']    +=  floor( eval  ( $ProdGrid[$ProdID]['formule']['energy']    ) * ( $db->game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_ingenieur'] * 0.05 ) ) );
			}
		
	}

        if ($CurrentPlanet['planet_type'] == 3)
	{
		$db->game_config['metal_basic_income']     = 0;
		$db->game_config['crystal_basic_income']   = 0;
		$db->game_config['deuterium_basic_income'] = 0;
		$CurrentPlanet['metal_perhour']        = 0;
		$CurrentPlanet['crystal_perhour']      = 0;
		$CurrentPlanet['deuterium_perhour']    = 0;
		$CurrentPlanet['energy_used']          = 0;
		$CurrentPlanet['energy_max']           = 0;
	}
	else
	{
		$CurrentPlanet['metal_perhour']        = $Caps['metal_perhour'];
		$CurrentPlanet['crystal_perhour']      = $Caps['crystal_perhour'];
		$CurrentPlanet['deuterium_perhour']    = $Caps['deuterium_perhour'];
		$CurrentPlanet['energy_used']          = $Caps['energy_used'];
		$CurrentPlanet['energy_max']           = $Caps['energy_max'];
	}

	$ProductionTime               = ($UpdateTime - $CurrentPlanet['last_update']);
	$CurrentPlanet['last_update'] = $UpdateTime;

	if ($CurrentPlanet['energy_max'] == 0)
	{
		$CurrentPlanet['metal_perhour']     = $db->game_config['metal_basic_income'];
		$CurrentPlanet['crystal_perhour']   = $db->game_config['crystal_basic_income'];
		$CurrentPlanet['deuterium_perhour'] = $db->game_config['deuterium_basic_income'];
		$production_level            = 100;
	}
	elseif ($CurrentPlanet["energy_max"] >= $CurrentPlanet["energy_used"])
	{
		$production_level = 100;
	}
	else
	{
		$production_level = floor(($CurrentPlanet['energy_max'] / $CurrentPlanet['energy_used']) * 100);
	}
	if($production_level > 100)
	{
		$production_level = 100;
	}
	elseif ($production_level < 0)
	{
		$production_level = 0;
	}

	if ( $CurrentPlanet['metal'] <= $MaxMetalStorage )
	{
		$MetalProduction = (($ProductionTime * ($CurrentPlanet['metal_perhour'] / 3600)) * $db->game_config['resource_multiplier']) * (0.01 * $production_level);
		$MetalBaseProduc = (($ProductionTime * ($db->game_config['metal_basic_income'] / 3600 )) * $db->game_config['resource_multiplier']);
		$MetalTheorical  = $CurrentPlanet['metal'] + $MetalProduction  +  $MetalBaseProduc;
		if ( $MetalTheorical <= $MaxMetalStorage )
		{
			$CurrentPlanet['metal']  = $MetalTheorical;
		}
		else
		{
			$CurrentPlanet['metal']  = $MaxMetalStorage;
		}
	}

	if ( $CurrentPlanet['crystal'] <= $MaxCristalStorage )
	{
		$CristalProduction = (($ProductionTime * ($CurrentPlanet['crystal_perhour'] / 3600)) * $db->game_config['resource_multiplier']) * (0.01 * $production_level);
		$CristalBaseProduc = (($ProductionTime * ($db->game_config['crystal_basic_income'] / 3600 )) * $db->game_config['resource_multiplier']);
		$CristalTheorical  = $CurrentPlanet['crystal'] + $CristalProduction  +  $CristalBaseProduc;
		if ( $CristalTheorical <= $MaxCristalStorage )
		{
			$CurrentPlanet['crystal']  = $CristalTheorical;
		}
		else
		{
			$CurrentPlanet['crystal']  = $MaxCristalStorage;
		}
	}

	if ( $CurrentPlanet['deuterium'] <= $MaxDeuteriumStorage || $CurrentPlanet['deuterium_perhour']<0 )
	{
		$DeuteriumProduction = (($ProductionTime * ($CurrentPlanet['deuterium_perhour'] / 3600)) * $db->game_config['resource_multiplier']) * (0.01 * $production_level);
		$DeuteriumBaseProduc = (($ProductionTime * ($db->game_config['deuterium_basic_income'] / 3600 )) * $db->game_config['resource_multiplier']);
		$DeuteriumTheorical  = $CurrentPlanet['deuterium'] + $DeuteriumProduction  +  $DeuteriumBaseProduc;
		if ( $DeuteriumTheorical <= $MaxDeuteriumStorage || $CurrentPlanet['deuterium_perhour']<0 )
		{
			$CurrentPlanet['deuterium']  = $DeuteriumTheorical;
		}
		else
		{
			$CurrentPlanet['deuterium']  = $MaxDeuteriumStorage;
		}
                
	}
        
	if ($Simul == false)
	{
		$Builded          = HandleElementBuildingQueue ( $CurrentUser, $CurrentPlanet, $ProductionTime );

		$QryUpdatePlanet  = "UPDATE {{table}} SET ";
		$QryUpdatePlanet .= "`metal` = '"            . $CurrentPlanet['metal']             ."', ";
		$QryUpdatePlanet .= "`crystal` = '"          . $CurrentPlanet['crystal']           ."', ";
		$QryUpdatePlanet .= "`deuterium` = '"        . $CurrentPlanet['deuterium']         ."', ";
		$QryUpdatePlanet .= "`last_update` = '"      . $CurrentPlanet['last_update']       ."', ";
		$QryUpdatePlanet .= "`b_hangar_id` = '"      . $CurrentPlanet['b_hangar_id']       ."', ";
		$QryUpdatePlanet .= "`metal_perhour` = '"    . $CurrentPlanet['metal_perhour']     ."', ";
		$QryUpdatePlanet .= "`crystal_perhour` = '"  . $CurrentPlanet['crystal_perhour']   ."', ";
		$QryUpdatePlanet .= "`deuterium_perhour` = '". $CurrentPlanet['deuterium_perhour'] ."', ";
		$QryUpdatePlanet .= "`energy_used` = '"      . $CurrentPlanet['energy_used']       ."', ";
		$QryUpdatePlanet .= "`energy_max` = '"       . $CurrentPlanet['energy_max']        ."', ";
		
                if ($Builded != '')
		{
			foreach ( $Builded as $Element => $Count )
			{
				if ($Element <> ''){
					$QryUpdatePlanet .= "`". $resource[$Element] ."` = '". $CurrentPlanet[$resource[$Element]] ."', ";
                                }
                        }

		}
                if ($CurrentPlanet['fleet'])
		{
			foreach ( $CurrentPlanet['fleet'] as $Element => $Count )
			{
                                    $QryUpdatePlanet .= "`". $resource[$Element] ."` = '". $CurrentPlanet[$resource[$Element]] ."', ";
                        }

		}
                
		$QryUpdatePlanet .= "`b_hangar` = '". $CurrentPlanet['b_hangar'] ."' ";
		$QryUpdatePlanet .= "WHERE ";
		$QryUpdatePlanet .= "`id` = '". $CurrentPlanet['id'] ."';";
		$db->query($QryUpdatePlanet, 'planets' );
	}
}
?>