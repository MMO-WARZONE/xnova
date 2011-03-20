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

if(!defined('INSIDE')){ die(header("location:../../"));}

	function PlanetResourceUpdate ( $CurrentUser, &$CurrentPlanet, $UpdateTime, $Simul = false )
	{
		global $ProdGrid, $resource, $reslist, $game_config;

        $CurrentPlanet['metal_max']		=	(BASE_STORAGE_SIZE + 50000 * (roundUp(pow(1.6,$CurrentPlanet[ $resource[22] ])) -1)) * (1 + ($CurrentUser['rpg_stockeur'] * STOCKEUR));
		$CurrentPlanet['crystal_max']	=	(BASE_STORAGE_SIZE + 50000 * (roundUp(pow(1.6,$CurrentPlanet[ $resource[23] ])) -1)) * (1 + ($CurrentUser['rpg_stockeur'] * STOCKEUR));
		$CurrentPlanet['deuterium_max']	=	(BASE_STORAGE_SIZE + 50000 * (roundUp(pow(1.6,$CurrentPlanet[ $resource[24] ])) -1)) * (1 + ($CurrentUser['rpg_stockeur'] * STOCKEUR));
        $CurrentPlanet['darkmatter_max'] =	(BASE_STORAGE_SIZE + 50000 * (roundUp(pow(1.6,$CurrentPlanet[ $resource[25] ])) -1)) * (1 + ($CurrentUser['rpg_stockeur'] * STOCKEUR));

		$MaxMetalStorage                = $CurrentPlanet['metal_max']     * MAX_OVERFLOW;
		$MaxCristalStorage              = $CurrentPlanet['crystal_max']   * MAX_OVERFLOW;
		$MaxDeuteriumStorage            = $CurrentPlanet['deuterium_max'] * MAX_OVERFLOW;
        $MaxDarkmatterStorage           = $CurrentPlanet['darkmatter_max'] * MAX_OVERFLOW;

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

  //for ( $ProdID = 0; $ProdID < 300; $ProdID++ )
foreach($reslist['prod'] as $ProdID)
        {
            //if ( in_array( $ProdID, $reslist['prod']) )
            //{
                $BuildLevelFactor = $CurrentPlanet[ $resource[$ProdID]."_porcent" ];
                $BuildLevel = $CurrentPlanet[ $resource[$ProdID] ];
                $Caps['metal_perhour']     += floor( eval ( $ProdGrid[$ProdID]['formule']['metal'] )     * (0.01 * $post_porcent) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue'] * GEOLOGUE ) ) );
                $Caps['crystal_perhour']   += floor( eval ( $ProdGrid[$ProdID]['formule']['crystal'] )   * (0.01 * $post_porcent) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue'] * GEOLOGUE ) ) );
                $Caps['deuterium_perhour'] += floor( eval ( $ProdGrid[$ProdID]['formule']['deuterium'] ) * (0.01 * $post_porcent) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_geologue'] * GEOLOGUE ) ) );
                $Caps['darkmatter_perhour'] += floor( eval ( $ProdGrid[$ProdID]['formule']['darkmatter'] ) * (0.01 * $post_porcent) * ( $game_config['resource_multiplier'] ) );

                if ($ProdID < 4)
                {
                    $Caps['energy_used']   +=  floor( eval  ( $ProdGrid[$ProdID]['formule']['energy']    ) * ( $game_config['resource_multiplier'] ) );
                }
                elseif ($ProdID >= 4 )
                {
                    $Caps['energy_max']    +=  floor( eval  ( $ProdGrid[$ProdID]['formule']['energy']    ) * ( $game_config['resource_multiplier'] ) * ( 1 + ( $CurrentUser['rpg_ingenieur'] * INGENIEUR ) ) );
                }
            //}
        }

		if ($CurrentPlanet['planet_type'] == 3)
		{
			$game_config['metal_basic_income']     = 0;
			$game_config['crystal_basic_income']   = 0;
			$game_config['deuterium_basic_income'] = 0;
			$game_config['darkmatter_basic_income'] = 0;
			$CurrentPlanet['metal_perhour']        = 0;
			$CurrentPlanet['crystal_perhour']      = 0;
			$CurrentPlanet['deuterium_perhour']    = 0;
			$CurrentPlanet['darkmatter_perhour']   = 0;
			$CurrentPlanet['energy_used']          = 0;
			$CurrentPlanet['energy_max']           = 0;
		}
		else
		{
			$CurrentPlanet['metal_perhour']        = $Caps['metal_perhour'];
			$CurrentPlanet['crystal_perhour']      = $Caps['crystal_perhour'];
			$CurrentPlanet['deuterium_perhour']    = $Caps['deuterium_perhour'];
			$CurrentPlanet['darkmatter_perhour']   = $Caps['darkmatter_perhour'];
			$CurrentPlanet['energy_used']          = $Caps['energy_used'];
			$CurrentPlanet['energy_max']           = $Caps['energy_max'];
		}

		$ProductionTime               = ($UpdateTime - $CurrentPlanet['last_update']);
		$CurrentPlanet['last_update'] = $UpdateTime;

		if ($CurrentPlanet['energy_max'] == 0)
		{
			$CurrentPlanet['metal_perhour']     = $game_config['metal_basic_income'];
			$CurrentPlanet['crystal_perhour']   = $game_config['crystal_basic_income'];
			$CurrentPlanet['deuterium_perhour'] = $game_config['deuterium_basic_income'];
            $CurrentPlanet['darkmatter_perhour'] = $game_config['darkmatter_basic_income'];
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
			$MetalProduction = (($ProductionTime * ($CurrentPlanet['metal_perhour'] / 3600)) * $game_config['resource_multiplier']) * (0.01 * $production_level);
			$MetalBaseProduc = (($ProductionTime * ($game_config['metal_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
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
			$CristalProduction = (($ProductionTime * ($CurrentPlanet['crystal_perhour'] / 3600)) * $game_config['resource_multiplier']) * (0.01 * $production_level);
			$CristalBaseProduc = (($ProductionTime * ($game_config['crystal_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
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

		if ( $CurrentPlanet['deuterium'] <= $MaxDeuteriumStorage )
		{
			$DeuteriumProduction = (($ProductionTime * ($CurrentPlanet['deuterium_perhour'] / 3600)) * $game_config['resource_multiplier']) * (0.01 * $production_level);
			$DeuteriumBaseProduc = (($ProductionTime * ($game_config['deuterium_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
			$DeuteriumTheorical  = $CurrentPlanet['deuterium'] + $DeuteriumProduction  +  $DeuteriumBaseProduc;
			if ( $DeuteriumTheorical <= $MaxDeuteriumStorage )
			{
				$CurrentPlanet['deuterium']  = $DeuteriumTheorical;
			}
			else
			{
				$CurrentPlanet['deuterium']  = $MaxDeuteriumStorage;
			}
		}

        if ( $CurrentPlanet['darkmatter'] <= $MaxDarkmatterStorage )
		{
			$DarkmatterProduction = (($ProductionTime * ($CurrentPlanet['darkmatter_perhour'] / 3600)) * $game_config['resource_multiplier']) * (0.01 * $production_level);
			$DarkmatterBaseProduc = (($ProductionTime * ($game_config['darkmatter_basic_income'] / 3600 )) * $game_config['resource_multiplier']);
			$DarkmatterTheorical  = $CurrentPlanet['darkmatter'] + $DarkmatterProduction  +  $DarkmatterBaseProduc;
			if ( $DarkmatterTheorical <= $MaxDarkmatterStorage )
			{
				$CurrentPlanet['darkmatter']  = $DarkmatterTheorical;
			}
			else
			{
				$CurrentPlanet['darkmatter']  = $MaxDarkmatterStorage;
			}
		}

		if( $CurrentPlanet['deuterium'] < 0 )
		{
			$CurrentPlanet['deuterium']  = 0;
		}

        if( $CurrentPlanet['crystal'] < 0 )
        {
            $CurrentPlanet['crystal']  = 0;
        }

        if( $CurrentPlanet['metal'] < 0 )
        {
            $CurrentPlanet['metal']  = 0;
        }
        
        if( $CurrentPlanet['darkmatter'] < 0 )
        {
            $CurrentPlanet['darkmatter']  = 0;
        }
        
		if ($Simul == false)
		{
			$Builded          = HandleElementBuildingQueue ( $CurrentUser, $CurrentPlanet, $ProductionTime );

			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`metal` = '"            . $CurrentPlanet['metal']             ."', ";
			$QryUpdatePlanet .= "`crystal` = '"          . $CurrentPlanet['crystal']           ."', ";
			$QryUpdatePlanet .= "`deuterium` = '"        . $CurrentPlanet['deuterium']         ."', ";
			$QryUpdatePlanet .= "`darkmatter` = '"       . $CurrentPlanet['darkmatter']        ."', ";
			$QryUpdatePlanet .= "`last_update` = '"      . $CurrentPlanet['last_update']       ."', ";
			$QryUpdatePlanet .= "`b_hangar_id` = '"      . $CurrentPlanet['b_hangar_id']       ."', ";
			$QryUpdatePlanet .= "`metal_perhour` = '"    . $CurrentPlanet['metal_perhour']     ."', ";
			$QryUpdatePlanet .= "`crystal_perhour` = '"  . $CurrentPlanet['crystal_perhour']   ."', ";
			$QryUpdatePlanet .= "`deuterium_perhour` = '". $CurrentPlanet['deuterium_perhour'] ."', ";
			$QryUpdatePlanet .= "`darkmatter_perhour` = '". $CurrentPlanet['darkmatter_perhour'] ."', ";
			$QryUpdatePlanet .= "`energy_used` = '"      . $CurrentPlanet['energy_used']       ."', ";
			$QryUpdatePlanet .= "`energy_max` = '"       . $CurrentPlanet['energy_max']        ."', ";
			if ( $Builded != '' )
			{
				foreach ( $Builded as $Element => $Count )
				{
					if ($Element <> '')
						$QryUpdatePlanet .= "`". $resource[$Element] ."` = '". $CurrentPlanet[$resource[$Element]] ."', ";
				}
			}
			$QryUpdatePlanet .= "`b_hangar` = '". $CurrentPlanet['b_hangar'] ."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '". $CurrentPlanet['id'] ."';";
			doquery($QryUpdatePlanet, 'planets');
		}
	}
?>
