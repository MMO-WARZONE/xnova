<?php
//version 1.1


if(!defined('INSIDE')){ die(header("location:../../"));}

class ShowInfosPages
{

        private function GetNextJumpWaitTime($CurMoon)
	{
		global $resource;

		$JumpGateLevel  = $CurMoon[$resource[43]];
		$LastJumpTime   = $CurMoon['last_jump_time'];
		if ($JumpGateLevel > 0)
		{
			$WaitBetweenJmp = (60 * 60) * (1 / $JumpGateLevel);
			$NextJumpTime   = $LastJumpTime + $WaitBetweenJmp;
			if ($NextJumpTime >= time())
			{
				$RestWait   = $NextJumpTime - time();
				$RestString = " ". pretty_time($RestWait);
			}
			else
			{
				$RestWait   = 0;
				$RestString = "";
			}
		}
		else
		{
			$RestWait   = 0;
			$RestString = "";
		}
		$RetValue['string'] = $RestString;
		$RetValue['value']  = $RestWait;

		return $RetValue;
	}

	private function DoFleetJump ($CurrentUser, $CurrentPlanet)
        {
            global $resource, $lang;

            if ($_POST)
            {
                $RestString   = $this->GetNextJumpWaitTime ($CurrentPlanet);
                $NextJumpTime = $RestString['value'];
                $JumpTime     = time();

                if ( $NextJumpTime == 0 )
                {
                    $TargetPlanet = $_POST['jmpto'];
                    $TargetGate   = doquery ( "SELECT `id`, `sprungtor`, `last_jump_time` FROM {{table}} WHERE `id` = '". $TargetPlanet ."';", 'planets', true);

                    if ($TargetGate['sprungtor'] > 0)
                    {
                        $RestString   = $this->GetNextJumpWaitTime ( $TargetGate );
                        $NextDestTime = $RestString['value'];

                        if ( $NextDestTime == 0 )
                        {
                            $ShipArray   = array();
                            $SubQueryOri = "";
                            $SubQueryDes = "";

                            for ( $Ship = 200; $Ship < 300; $Ship++ )
                            {
                                $ShipLabel = "c". $Ship;
                                $gemi_kontrol    =    $_POST[ $ShipLabel ];

                                if (is_numeric($gemi_kontrol))
                                {
                                    if ( $gemi_kontrol > $CurrentPlanet[ $resource[ $Ship ] ])
                                    {
                                        $ShipArray[ $Ship ] = $CurrentPlanet[ $resource[ $Ship ] ];
                                    }
                                    else
                                    {
                                        $ShipArray[ $Ship ] = $gemi_kontrol;
                                    }


                                    if ($ShipArray[ $Ship ] > 0)
                                    {
                                        $SubQueryOri .= "`". $resource[ $Ship ] ."` = `". $resource[ $Ship ] ."` - '". $ShipArray[ $Ship ] ."', ";
                                        $SubQueryDes .= "`". $resource[ $Ship ] ."` = `". $resource[ $Ship ] ."` + '". $ShipArray[ $Ship ] ."', ";
                                    }
                                }
                            }
                            if ($SubQueryOri != "")
                            {
                                $QryUpdateOri  = "UPDATE {{table}} SET ";
                                $QryUpdateOri .= $SubQueryOri;
                                $QryUpdateOri .= "`last_jump_time` = '". $JumpTime ."' ";
                                $QryUpdateOri .= "WHERE ";
                                $QryUpdateOri .= "`id` = '". $CurrentPlanet['id'] ."';";
                                doquery ( $QryUpdateOri, 'planets');

                                $QryUpdateDes  = "UPDATE {{table}} SET ";
                                $QryUpdateDes .= $SubQueryDes;
                                $QryUpdateDes .= "`last_jump_time` = '". $JumpTime ."' ";
                                $QryUpdateDes .= "WHERE ";
                                $QryUpdateDes .= "`id` = '". $TargetGate['id'] ."';";
                                doquery ( $QryUpdateDes, 'planets');

                                $QryUpdateUsr  = "UPDATE {{table}} SET ";
                                $QryUpdateUsr .= "`current_planet` = '". $TargetGate['id'] ."' ";
                                $QryUpdateUsr .= "WHERE ";
                                $QryUpdateUsr .= "`id` = '". $CurrentUser['id'] ."';";
                                doquery ( $QryUpdateUsr, 'users');

                                $CurrentPlanet['last_jump_time'] = $JumpTime;
                                $RestString    = $this->GetNextJumpWaitTime ( $CurrentPlanet );
                                $RetMessage    = $lang['in_jump_gate_done'] . $RestString['string'];
                            }
                            else
                            {
                                $RetMessage = $lang['in_jump_gate_error_data'];
                            }
                        }
                        else
                        {
                            $RetMessage = $lang['in_jump_gate_not_ready_target'] . $RestString['string'];
                        }
                    }
                    else
                    {
                        $RetMessage = $lang['in_jump_gate_doesnt_have_one'];
                    }
                }
                else
                {
                    $RetMessage = $lang['in_jump_gate_already_used'] . $RestString['string'];
                }
            }
            else
            {
                $RetMessage = $lang['in_jump_gate_error_data'];
            }

            return $RetMessage;
        }

        /*public function ShowDoJumpgate($CurrentUser,$CurrentPlanet){
            global $displays;
            $displays->message($this->DoFleetJump($CurrentUser, $CurrentPlanet), "game.php?page=infos&gid=43", 2);
        }*/
        
	private function BuildFleetListRows ($CurrentPlanet)
	{
		global $resource, $lang,$displays;

		//$RowsTPL  = gettemplate('infos/info_gate_rows');

		$CurrIdx  = 1;
		$Result   = "";
		for ($Ship = 300; $Ship > 200; $Ship-- )
		{
			if ($resource[$Ship] != "")
			{
				if ($CurrentPlanet[$resource[$Ship]] > 0)
				{
                                        $displays->newblock("fleet_rows");
					$bloc['idx']             = $CurrIdx;
					$bloc['fleet_id']        = $Ship;
					$bloc['fleet_name']      = $lang['tech'][$Ship];
					$bloc['fleet_max']       = pretty_number ( $CurrentPlanet[$resource[$Ship]] );
					$bloc['gate_ship_dispo'] = $lang['in_jump_gate_available'];
					//$Result                 .= parsetemplate ( $RowsTPL, $bloc );
					$CurrIdx++;
                                        foreach($bloc as $key => $value){
                                            $displays->assign($key,$value);
                                        }
                                }
			}
		}
		//return $Result;
	}
	
	private function BuildJumpableMoonCombo ( $CurrentUser, $CurrentPlanet )
	{
		global $resource,$db;
		$QrySelectMoons  = "SELECT * FROM {{table}} WHERE `planet_type` = '3' AND `id_owner` = '". $CurrentUser['id'] ."';";
		$MoonList        = $db->query ( $QrySelectMoons, 'planets');
		$Combo           = "";
		while ( $CurMoon = mysql_fetch_assoc($MoonList) )
		{
			if ( $CurMoon['id'] != $CurrentPlanet['id'] )
			{
				$RestString = $this->GetNextJumpWaitTime ( $CurMoon );
				if ($CurMoon[$resource[43]] >= 1)
					$Combo .= "<option value=\"". $CurMoon['id'] ."\">[". $CurMoon['galaxy'] .":". $CurMoon['system'] .":". $CurMoon['planet'] ."] ". $CurMoon['name'] . $RestString['string'] ."</option>\n";
			}
		}
		return $Combo;
	}
	
	private function ShowProductionTable ($CurrentUser, $CurrentPlanet, $BuildID)
	{
		global $ProdGrid, $resource, $db,$displays;

                if($BuildID==42){
                    $displays->newblock("phanlax");
                }else{
                    $displays->newblock("productions");
                }


		$BuildLevelFactor = $CurrentPlanet[ $resource[$BuildID]."_porcent" ];
		$BuildTemp        = $CurrentPlanet[ 'temp_max' ];
		$CurrentBuildtLvl = $CurrentPlanet[ $resource[$BuildID] ];

		$BuildLevel       = ($CurrentBuildtLvl > 0) ? $CurrentBuildtLvl : 1;
		$Prod[1]          = (floor(eval($ProdGrid[$BuildID]['formule']['metal'])     * $db->game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
		$Prod[2]          = (floor(eval($ProdGrid[$BuildID]['formule']['crystal'])   * $db->game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
		$Prod[3]          = (floor(eval($ProdGrid[$BuildID]['formule']['deuterium']) * $db->game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));

		if( $BuildID >= 4 )
			$Prod[4] = (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $db->game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * 0.05)));
		else
			$Prod[4] = (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $db->game_config['resource_multiplier']));

		$ActualProd       = floor($Prod[$BuildID]);

		if ($BuildID != 12)
			$ActualNeed       = floor($Prod[4]);
		else
			$ActualNeed       = floor($Prod[3]);

		$BuildStartLvl    = $CurrentBuildtLvl - 2;
		if ($BuildStartLvl < 1)
			$BuildStartLvl = 1;

		$Table     = "";
		$ProdFirst = 0;

                if($BuildID==4){

                    $block="production_list_sin";
                }elseif($BuildID!=42){
                    $displays->newblock("energy");
                    $block="production_list_con";
                    $displays->gotoBlock("productions");
                }

		for ( $BuildLevel = $BuildStartLvl; $BuildLevel < $BuildStartLvl + 15; $BuildLevel++ )
		{
                        
			if ($BuildID != 42)
			{
                            $displays->newblock($block);
				$Prod[1] = (floor(eval($ProdGrid[$BuildID]['formule']['metal'])     * $db->game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
				$Prod[2] = (floor(eval($ProdGrid[$BuildID]['formule']['crystal'])   * $db->game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));
				$Prod[3] = (floor(eval($ProdGrid[$BuildID]['formule']['deuterium']) * $db->game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_geologue']  * 0.05)));

				if( $BuildID >= 4 )
					$Prod[4] = (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $db->game_config['resource_multiplier']) * (1 + ($CurrentUser['rpg_ingenieur'] * 0.05)));
				else
					$Prod[4] = (floor(eval($ProdGrid[$BuildID]['formule']['energy'])    * $db->game_config['resource_multiplier']));

				$bloc['build_lvl']       = ($CurrentBuildtLvl == $BuildLevel) ? "<font color=\"#ff0000\">".$BuildLevel."</font>" : $BuildLevel;

				if ($ProdFirst > 0)
					if ($BuildID != 12)
						$bloc['build_gain']      = "<font color=\"lime\">(". pretty_number(floor($Prod[$BuildID] - $ProdFirst)) .")</font>";
					else
						$bloc['build_gain']      = "<font color=\"lime\">(". pretty_number(floor($Prod[4] - $ProdFirst)) .")</font>";
				else
					$bloc['build_gain']      = "";

				if ($BuildID != 12)
				{
					$bloc['build_prod']      = pretty_number(floor($Prod[$BuildID]));
					$bloc['build_prod_diff'] = colorNumber( pretty_number(floor($Prod[$BuildID] - $ActualProd)) );
					$bloc['build_need']      = colorNumber( pretty_number(floor($Prod[4])) );
					$bloc['build_need_diff'] = colorNumber( pretty_number(floor($Prod[4] - $ActualNeed)) );
				}
				else
				{
					$bloc['build_prod']      = pretty_number(floor($Prod[4]));
					$bloc['build_prod_diff'] = colorNumber( pretty_number(floor($Prod[4] - $ActualProd)) );
					$bloc['build_need']      = colorNumber( pretty_number(floor($Prod[3])) );
					$bloc['build_need_diff'] = colorNumber( pretty_number(floor($Prod[3] - $ActualNeed)) );
				}
				if ($ProdFirst == 0)
				{
					if ($BuildID != 12)
						$ProdFirst = floor($Prod[$BuildID]);
					else
						$ProdFirst = floor($Prod[4]);
				}
			}
			else
			{
                            $displays->newblock("phanlax_list");
				$bloc['build_lvl']       = ($CurrentBuildtLvl == $BuildLevel) ? "<font color=\"#ff0000\">".$BuildLevel."</font>" : $BuildLevel;
				$bloc['build_range']     = ($BuildLevel * $BuildLevel) - 1;
			}
			foreach ($bloc as $key => $value) {
                            $displays->assign($key ,$value);
                        }
                       
		}
	}
	
	private function ShowRapidFireTo ($BuildID)
	{
		global $lang, $CombatCaps;
		$ResultString = "";
		for ($Type = 200; $Type < 500; $Type++)
		{
			if ($CombatCaps[$BuildID]['sd'][$Type] > 1)
				$ResultString .= $lang['in_rf_again']. " ". $lang['tech'][$Type] ." <font color=\"#00ff00\">".$CombatCaps[$BuildID]['sd'][$Type]."</font><br>";
		}
		return $ResultString;
	}

	private function ShowRapidFireFrom ($BuildID)
	{
		global $lang, $CombatCaps;

		$ResultString = "";
		for ($Type = 200; $Type < 500; $Type++)
		{
			if ($CombatCaps[$Type]['sd'][$BuildID] > 1)
				$ResultString .= $lang['in_rf_from']. " ". $lang['tech'][$Type] ." <font color=\"#ff0000\">".$CombatCaps[$Type]['sd'][$BuildID]."</font><br>";
		}
		return $ResultString;
	}


	public function ShowInfosPage ($CurrentUser, $CurrentPlanet, $BuildID)
	{
		global $dpath, $lang, $resource, $pricelist, $CombatCaps, $phpEx,$db, $svn_root,$displays;

                $displays->assignContent("infos/info");
		$GateTPL              = '';
		$DestroyTPL           = '';
		$TableHeadTPL         = '';

		$parse['dpath']       = $dpath;
		$parse['name']        = $lang['info'][$BuildID]['name'];
		$parse['image']       = $BuildID;
		$parse['description'] = $lang['info'][$BuildID]['description'];
                
		if ($BuildID >=   1 && $BuildID <=   3)
		{
			$PageTPL              = 'info_buildings';
			$DestroyTPL           = 'info_buildings_destroy';
                        $TableHeadTPL=TRUE;


                }
		elseif ($BuildID ==   4)
		{
			$PageTPL              = 'info_buildings';
			$DestroyTPL           = 'info_buildings_destroy';
                        $TableHeadTPL=TRUE;
                }
		elseif ($BuildID ==  12)
		{
			$PageTPL              = 'info_buildings';
			$DestroyTPL           = 'info_buildings_destroy';
                        $TableHeadTPL=TRUE;


                }
		elseif ($BuildID >=  14 && $BuildID <=  32)
		{
			$PageTPL              = 'info_buildings';
			$DestroyTPL           = 'info_buildings_destroy';

		}
		elseif ($BuildID ==  33)
		{
			$PageTPL              = 'info_buildings';
			
		}
		elseif ($BuildID ==  34)
		{
			$PageTPL              = 'info_buildings';
			$DestroyTPL           = 'info_buildings_destroy';

		}
		elseif ($BuildID ==  44)
		{
			$PageTPL              = 'info_buildings';
			$DestroyTPL           = 'info_buildings_destroy';

		}
		elseif ($BuildID ==  41)
		{
			$PageTPL              = 'info_buildings';
		
		}
		elseif ($BuildID ==  42)
		{
			$PageTPL              = 'info_buildings';
			$DestroyTPL           = 'info_buildings_destroy';
                        $TableHeadTPL=TRUE;

		}
		elseif ($BuildID ==  43)
		{
			$GateTPL              = 'info_gate_table';
			$PageTPL              = 'info_buildings';
			$DestroyTPL           = 'info_buildings_destroy';


		}
		elseif ($BuildID >= 106 && $BuildID <= 199)
		{
			$PageTPL              = 'info_buildings';
			
		}
		elseif ($BuildID >= 202 && $BuildID <= 224)
		{
			$PageTPL              = 'info_fleet';
			$parse['element_typ'] = $lang['tech'][200];
			$parse['rf_info_to']  = $this->ShowRapidFireTo($BuildID);
			$parse['rf_info_fr']  = $this->ShowRapidFireFrom($BuildID);
			$parse['hull_pt']     = pretty_number ($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal']);
			$parse['shield_pt']   = pretty_number ($CombatCaps[$BuildID]['shield']);
			$parse['attack_pt']   = pretty_number ($CombatCaps[$BuildID]['attack']);
			$parse['capacity_pt'] = pretty_number ($pricelist[$BuildID]['capacity']);
			$parse['base_speed']  = pretty_number ($pricelist[$BuildID]['speed']);
			$parse['base_conso']  = pretty_number ($pricelist[$BuildID]['consumption']);
			if ($BuildID == 202)
			{
				$parse['upd_speed']   = "<font color=\"yellow\">(". pretty_number ($pricelist[$BuildID]['speed2']) .")</font>";
				$parse['upd_conso']   = "<font color=\"yellow\">(". pretty_number ($pricelist[$BuildID]['consumption2']) .")</font>";
			}elseif ($BuildID == 211){
				$parse['upd_speed']   = "<font color=\"yellow\">(". pretty_number ($pricelist[$BuildID]['speed2']) .")</font>";
                        }

                }
		elseif ($BuildID >= 401 && $BuildID <= 411)
		{
			$PageTPL              = 'info_fleet';
			$parse['element_typ'] = $lang['tech'][400];

			$parse['rf_info_to']  = $this->ShowRapidFireTo ($BuildID);
			$parse['rf_info_fr']  = $this->ShowRapidFireFrom ($BuildID);
			$parse['hull_pt']     = pretty_number ($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal']);
			$parse['shield_pt']   = pretty_number ($CombatCaps[$BuildID]['shield']);
			$parse['attack_pt']   = pretty_number ($CombatCaps[$BuildID]['attack']);
		}
		elseif ($BuildID >= 502 && $BuildID <= 503)
		{
			$PageTPL              = 'info_fleet';
			$parse['element_typ'] = $lang['tech'][400];
			$parse['hull_pt']     = pretty_number ($pricelist[$BuildID]['metal'] + $pricelist[$BuildID]['crystal']);
			$parse['shield_pt']   = pretty_number ($CombatCaps[$BuildID]['shield']);
			$parse['attack_pt']   = pretty_number ($CombatCaps[$BuildID]['attack']);
		}
		elseif ($BuildID >= 601 && $BuildID <= 615)
                {
			$PageTPL              = 'info_oficial';
                }

		$displays->newblock($PageTPL);
                foreach ($parse as $key => $value) {
                    $displays->assign($key ,$value);
                }
                if ($TableHeadTPL)
		{             
			$this->ShowProductionTable ($CurrentUser, $CurrentPlanet, $BuildID);
		}
                if ($GateTPL != '')
		{
			if ($CurrentPlanet[$resource[$BuildID]] > 0)
			{
                                $displays->newblock($GateTPL);
				$RestString               = $this->GetNextJumpWaitTime ( $CurrentPlanet );
				$parse['gate_start_link'] = BuildPlanetAdressLink ( $CurrentPlanet );
				if ($RestString['value'] != 0)
				{
					include($svn_root . 'includes/functions/InsertJavaScriptChronoApplet.' . $phpEx);

					$parse['gate_time_script'] = InsertJavaScriptChronoApplet ( "Gate", "1", $RestString['value'], true );
					$parse['gate_wait_time']   = "<div id=\"bxx". "Gate" . "1" ."\"></div>";
					$parse['gate_script_go']   = InsertJavaScriptChronoApplet ( "Gate", "1", $RestString['value'], false );
				}
				else
				{
					$parse['gate_time_script'] = "";
					$parse['gate_wait_time']   = "";
					$parse['gate_script_go']   = "";
				}
                                foreach ($parse as $key => $value) {
                                     $displays->assign($key ,$value);
                                }
				$parse['gate_dest_moons'] = $this->BuildJumpableMoonCombo ($CurrentUser, $CurrentPlanet);
                                $this->BuildFleetListRows ($CurrentPlanet);

                                
			}
		}

		if ($DestroyTPL != '')
		{
			if ($CurrentPlanet[$resource[$BuildID]] > 0)
			{
                                $displays->newblock($DestroyTPL);
				$NeededRessources     = GetBuildingPrice ($CurrentUser, $CurrentPlanet, $BuildID, true, true);
				$DestroyTime          = GetBuildingTime  ($CurrentUser, $CurrentPlanet, $BuildID) / 2;
				$parse['destroyurl']  = "game.php?page=buildings&cmd=destroy&building=".$BuildID;
				$parse['levelvalue']  = $CurrentPlanet[$resource[$BuildID]];
				$parse['nfo_metal']   = $lang['Metal'];
				$parse['nfo_crysta']  = $lang['Crystal'];
				$parse['nfo_deuter']  = $lang['Deuterium'];
				$parse['metals']      = pretty_number ($NeededRessources['metal']);
				$parse['crystals']    = pretty_number ($NeededRessources['crystal']);
				$parse['deuteriums']  = pretty_number ($NeededRessources['deuterium']);
				$parse['destroytime'] = pretty_time   ($DestroyTime);
				foreach ($parse as $key => $value) {
                                    $displays->assign($key ,$value);
                                }
			}
		}

                $displays->display();
	}
}
?>