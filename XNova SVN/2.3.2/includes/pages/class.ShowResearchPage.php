<?php
//version 1


if (!defined('INSIDE')){die("Intento de hackeo");}

class ShowResearchPages
{
	private function CheckLabSettingsInQueue ($CurrentPlanet)
	{
		if ($CurrentPlanet['b_building_id'] != 0)
		{
			$CurrentQueue = $CurrentPlanet['b_building_id'];
			if (strpos ($CurrentQueue, ";"))
			{
				$QueueArray		= explode (";", $CurrentQueue);

				for($i = 0; $i < MAX_BUILDING_QUEUE_SIZE; $i++)
				{
					$ListIDArray	= explode (",", $QueueArray[$i]);
					$Element		= $ListIDArray[0];

					if($Element == 31){
						break;

                                        }
                                 }
			
			}
			else
			{
				$CurrentBuilding = $CurrentQueue;
			}

			if ($CurrentBuilding == 31 or $Element == 31)
			{
				$return = false;
			}
			else
			{
				$return = true;
			}
		}
		else
		{
			$return = true;
		}

		return $return;
	}

	private function GetRestPrice ($user, $planet, $Element, $userfactor = true)
	{
		global $pricelist, $resource, $lang;

		if ($userfactor)
		{
			$level = ($planet[$resource[$Element]]) ? $planet[$resource[$Element]] : $user[$resource[$Element]];
		}

		$array = array(
		'metal'      => $lang['Metal'],
		'crystal'    => $lang['Crystal'],
		'deuterium'  => $lang['Deuterium'],
		'energy_max' => $lang['Energy']
		);

		$text  = "<br><font color=\"#7f7f7f\">" . $lang['bd_remaining'] . ": ";
		foreach ($array as $ResType => $ResTitle)
		{
			if ($pricelist[$Element][$ResType] != 0)
			{
				$text .= $ResTitle . ": ";
				if ($userfactor)
				{
					$cost = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
				}
				else
				{
					$cost = floor($pricelist[$Element][$ResType]);
				}
				if ($cost > $planet[$ResType])
				{
					$text .= "<b style=\"color: rgb(127, 95, 96);\">". pretty_number($planet[$ResType] - $cost) ."</b> ";
				}
				else
				{
					$text .= "<b style=\"color: rgb(95, 127, 108);\">". pretty_number($planet[$ResType] - $cost) ."</b> ";
				}
			}
		}
		$text .= "</font>";

		return $text;
	}

	public function ShowResearchPage (&$CurrentPlanet, $CurrentUser, $InResearch, $ThePlanet)
	{
		global $lang, $resource, $reslist, $phpEx, $dpath,$db, $displays, $_GET;

		include_once($svn_root . 'includes/functions/IsTechnologieAccessible.' . $phpEx);
		include_once($svn_root . 'includes/functions/GetElementPrice.' . $phpEx);
                $displays->assignContent("buildings/buildings_research");

                $NoResearchMessage 	= "";
		$bContinue         	= true;

		if ($CurrentPlanet[$resource[31]] == 0){
			$displays->message($lang['bd_lab_required'], '', '', true);
                }
		if (!$this->CheckLabSettingsInQueue ($CurrentPlanet))
		{
			$displays->assign('noresearch', $lang['bd_building_lab']);
                        $bContinue         = false;
		}

		if (isset($_GET['cmd']) && $bContinue)
		{
			$TheCommand 	= $_GET['cmd'];
			$Techno     	= intval($_GET['tech']);

			if ( isset ($Techno) )
			{
				if (!strstr ( $Techno, ",") && !strchr ( $Techno, " ") &&
                                    !strchr ( $Techno, "+") && !strchr ( $Techno, "*") &&
                                    !strchr ( $Techno, "~") && !strchr ( $Techno, "=") &&
                                    !strchr ( $Techno, ";") && !strchr ( $Techno, "'") &&
                                    !strchr ( $Techno, "#") && !strchr ( $Techno, "-") &&
                                    !strchr ( $Techno, "_") && !strchr ( $Techno, "[") &&
                                    !strchr ( $Techno, "]") && !strchr ( $Techno, ".") &&
                                    !strchr ( $Techno, ":"))
                                 {
					if ( in_array($Techno, $reslist['tech']) )
					{
						if ( is_array ($ThePlanet) )
						{
							$WorkingPlanet = $ThePlanet;
						}
						else
						{
							$WorkingPlanet = $CurrentPlanet;
						}

						switch($TheCommand)
						{
							case 'cancel':
								if ($ThePlanet['b_tech_id'] == $Techno)
								{
									$costs                        = GetBuildingPrice($CurrentUser, $WorkingPlanet, $Techno);
									$WorkingPlanet['metal']      += $costs['metal'];
									$WorkingPlanet['crystal']    += $costs['crystal'];
									$WorkingPlanet['deuterium']  += $costs['deuterium'];
									$WorkingPlanet['b_tech_id']   = 0;
									$WorkingPlanet["b_tech"]      = 0;
									$CurrentUser['b_tech_planet'] = 0;
									$UpdateData                   = true;
									$InResearch                   = false;
								}
								break;
							case 'search':
								if (IsTechnologieAccessible($CurrentUser, $WorkingPlanet, $Techno) && IsElementBuyable($CurrentUser, $WorkingPlanet, $Techno))
								{
									$costs                        = GetBuildingPrice($CurrentUser, $WorkingPlanet, $Techno);
									$WorkingPlanet['metal']      -= $costs['metal'];
									$WorkingPlanet['crystal']    -= $costs['crystal'];
									$WorkingPlanet['deuterium']  -= $costs['deuterium'];
									$WorkingPlanet["b_tech_id"]   = $Techno;
									$WorkingPlanet["b_tech"]      = time() + GetBuildingTime($CurrentUser, $WorkingPlanet, $Techno);
									$CurrentUser["b_tech_planet"] = $WorkingPlanet["id"];
									$UpdateData                   = true;
									$InResearch                   = true;
								}
								break;
						}
						if ($UpdateData == true)
						{
							$QryUpdatePlanet  = "UPDATE {{table}} SET ";
							$QryUpdatePlanet .= "`b_tech_id` = '".   $WorkingPlanet['b_tech_id']   ."', ";
							$QryUpdatePlanet .= "`b_tech` = '".      $WorkingPlanet['b_tech']      ."', ";
							$QryUpdatePlanet .= "`metal` = '".       $WorkingPlanet['metal']       ."', ";
							$QryUpdatePlanet .= "`crystal` = '".     $WorkingPlanet['crystal']     ."', ";
							$QryUpdatePlanet .= "`deuterium` = '".   $WorkingPlanet['deuterium']   ."' ";
							$QryUpdatePlanet .= "WHERE ";
							$QryUpdatePlanet .= "`id` = '".          $WorkingPlanet['id']          ."';";
							$db->query( $QryUpdatePlanet, 'planets');

							$QryUpdateUser  = "UPDATE {{table}} SET ";
							$QryUpdateUser .= "`b_tech_planet` = '". $CurrentUser['b_tech_planet'] ."' ";
							$QryUpdateUser .= "WHERE ";
							$QryUpdateUser .= "`id` = '".            $CurrentUser['id']            ."';";
							$db->query( $QryUpdateUser, 'users');
						}

						$CurrentPlanet = $WorkingPlanet;
						if (is_array ($ThePlanet))
						{
							$ThePlanet     = $WorkingPlanet;
						}
						else
						{
							$CurrentPlanet = $WorkingPlanet;
							if ($TheCommand == 'search')
							{
								$ThePlanet = $CurrentPlanet;
							}
						}
					}
				}else{
					die(header("location:game.php?page=buildings&mode=research"));
			
                                }
                        }
			else
			{
				$bContinue = false;
			}
		}

		$siguiente=1;

                foreach($reslist['tech'] as $Tech)
		{
                    if ( IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Tech))
                    {
                            $displays->newblock("research");

                            $RowParse['tech_id']     = $Tech;
                            $building_level          = $CurrentUser[$resource[$Tech]];

                            if($Tech == 106)
                            {
                                    $RowParse['tech_level']  = ($building_level == 0 ) ? "" : "(". $lang['bd_lvl'] . " ".$building_level .")" ;
                                    $RowParse['tech_level']  .= ($CurrentUser['rpg_espion'] == 0) ? "" : "<strong><font color=\"lime\"> +" . ($CurrentUser['rpg_espion'] * 5) . $lang['bd_spy']	. "</font></strong>";
                            }elseif($Tech == 108) {
                                    $RowParse['tech_level']  = ($building_level == 0) ? "" : "(". $lang['bd_lvl'] . " ".$building_level .")";
                                    $RowParse['tech_level']  .= ($CurrentUser['rpg_commandant'] == 0) ? "" : "<strong><font color=\"lime\"> +" . ($CurrentUser['rpg_commandant'] * 3) . $lang['bd_commander'] . "</font></strong>";
                            }else{
                                    $RowParse['tech_level']  = ($building_level == 0) ? "" : "(". $lang['bd_lvl'] . " ".$building_level." )";
                            }
                            $RowParse['tech_name']   = $lang['tech'][$Tech];
                            $RowParse['tech_descr']  = $lang['res']['descriptions'][$Tech];
                            $RowParse['tech_price']  = GetElementPrice($CurrentUser, $CurrentPlanet, $Tech);
                            $SearchTime              = GetBuildingTime($CurrentUser, $CurrentPlanet, $Tech);
                            $RowParse['search_time'] = ShowBuildTime($SearchTime);
                            $RowParse['tech_restp']  = "Restantes ". $this->GetRestPrice ($CurrentUser, $CurrentPlanet, $Tech, true);
                            $CanBeDone               = IsElementBuyable($CurrentUser, $CurrentPlanet, $Tech);

                            if (!$InResearch)
                            {
                                    $LevelToDo = 1 + $CurrentUser[$resource[$Tech]];
                                    if ($CanBeDone)
                                    {
                                            if (!$this->CheckLabSettingsInQueue ( $CurrentPlanet ))
                                            {
                                                    if ($LevelToDo == 1){
                                                            $TechnoLink  = "<font color=#FF0000>".$lang['bd_research']."</font>";
                                                    }else{
                                                            $TechnoLink  = "<font color=#FF0000>".$lang['bd_research']."<br>".$lang['bd_lvl']." ".$LevelToDo."</font>";
                                                    }
                                            }
                                            else
                                            {
                                                    $TechnoLink  = "<a href=\"game.php?page=buildings&mode=research&cmd=search&tech=".$Tech."\">";
                                                    if ($LevelToDo == 1){
                                                            $TechnoLink .= "<font color=#00FF00>".$lang['bd_research']."</font>";
                                                    }else{
                                                            $TechnoLink .= "<font color=#00FF00>".$lang['bd_research']."<br>".$lang['bd_lvl']." ".$LevelToDo."</font>";
                                                    }
                                                    $TechnoLink  .= "</a>";
                                            }
                                    }
                                    else
                                    {
                                            if ($LevelToDo == 1){
                                                    $TechnoLink  = "<font color=#FF0000>".$lang['bd_research']."</font>";
                                            }else{
                                                    $TechnoLink  = "<font color=#FF0000>".$lang['bd_research']."<br>".$lang['bd_lvl']." ".$LevelToDo."</font>";
                                            }

                                    }
                            }
                            else
                            {
                                    if ($ThePlanet["b_tech_id"] == $Tech)
                                    {
                                            $displays->newblock("script");
                                            if ($ThePlanet['id'] != $CurrentPlanet['id'])
                                            {
                                                    $bloc['tech_time']  = $ThePlanet["b_tech"] - time();
                                                    $bloc['tech_name']  = "de<br>". $ThePlanet["name"];
                                                    $bloc['tech_home']  = $ThePlanet["id"];
                                                    $bloc['tech_id']    = $ThePlanet["b_tech_id"];
                                            }
                                            else
                                            {
                                                    $bloc['tech_time']  = $CurrentPlanet["b_tech"] - time();
                                                    $bloc['tech_name']  = "";
                                                    $bloc['tech_home']  = $CurrentPlanet["id"];
                                                    $bloc['tech_id']    = $CurrentPlanet["b_tech_id"];
                                            }
                                            foreach($bloc as $name => $trans){
                                                $displays->assign($name, $trans);
                                            }

                                    }
                                    else
                                    {
                                            $TechnoLink  = "<center>-</center>";
                                    }

                            }
                            $displays->gotoBlock("research");
                            $RowParse['tech_link']  = $TechnoLink;
                            if ($siguiente%3==0){
                                    $RowParse['cerrar'] = "</tr><tr>";
                            }
                            $siguiente++;
                            foreach($RowParse as $name => $trans){
				$displays->assign($name, $trans);
			    }
                            unset($RowParse,$TechnoLink);
                    }
			
		}
                $displays->display("Investigación");
	}
}