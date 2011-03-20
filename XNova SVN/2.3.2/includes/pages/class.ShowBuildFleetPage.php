<?php
//version 1
if (!defined('INSIDE')){die("Intento de hackeo");}

class ShowBuildFleetPage
{

	private function GetElementRessources($Element, $Count)
	{
		global $pricelist;

		$ResType['metal']     = ($pricelist[$Element]['metal']     * $Count);
		$ResType['crystal']   = ($pricelist[$Element]['crystal']   * $Count);
		$ResType['deuterium'] = ($pricelist[$Element]['deuterium'] * $Count);

		return $ResType;
	}

	private function ElementBuildListBox ( $CurrentUser, $CurrentPlanet )
	{
		global $lang, $pricelist,$displays;

                $displays->newblock("buildinglist");
		$ElementQueue = explode(';', $CurrentPlanet['b_hangar_id']);
		$NbrePerType  = "";
		$NamePerType  = "";
		$TimePerType  = "";

		foreach($ElementQueue as $ElementLine => $Element)
		{
			if ($Element != '')
			{
				$Element 	= explode(',', $Element);
				$ElementTime  	= GetBuildingTime( $CurrentUser, $CurrentPlanet, $Element[0] );
				$QueueTime   	+= $ElementTime * $Element[1];
				$TimePerType 	.= "".$ElementTime.",";
				$NamePerType 	.= "'". $lang['tech'][$Element[0]] ."',";
				$NbrePerType 	.= "".$Element[1].",";
			}
		}

		//$parse 							= $lang;
		$parse['a'] 			= $NbrePerType;
		$parse['b'] 			= $NamePerType;
		$parse['c'] 			= $TimePerType;
		$parse['b_hangar_id_plus'] 	= $CurrentPlanet['b_hangar'];
		$parse['pretty_time_b_hangar'] 	= pretty_time($QueueTime - $CurrentPlanet['b_hangar']);

                foreach ($parse as $key => $value) {
                               $displays->assign($key,$value);
                }
                
	}
	private function GetMaxConstructibleElements ($Element, $Ressources)
	{
		global $pricelist;

		if ($pricelist[$Element]['metal'] != 0)
		{
			$Buildable        = floor($Ressources["metal"] / $pricelist[$Element]['metal']);
			$MaxElements      = $Buildable;
		}

		if ($pricelist[$Element]['crystal'] != 0){
			$Buildable        = floor($Ressources["crystal"] / $pricelist[$Element]['crystal']);
		}

		if (!isset($MaxElements)){
			$MaxElements      = $Buildable;
		}
		elseif($MaxElements > $Buildable){
			$MaxElements      = $Buildable;
		}

		if ($pricelist[$Element]['deuterium'] != 0){
			$Buildable        = floor($Ressources["deuterium"] / $pricelist[$Element]['deuterium']);
		}

		if (!isset($MaxElements)){
			$MaxElements      = $Buildable;
		}elseif ($MaxElements > $Buildable){
			$MaxElements      = $Buildable;
		}

		if ($pricelist[$Element]['energy'] != 0){
			$Buildable        = floor($Ressources["energy_max"] / $pricelist[$Element]['energy']);
		}

		if ($Buildable < 1){
			$MaxElements      = 0;
		}

		return $MaxElements;
	}
	public function FleetBuildingPage ( &$CurrentPlanet, $CurrentUser )
	{
		global $lang, $resource, $phpEx, $dpath, $svn_root,$displays,$reslist;


                if ($CurrentPlanet[$resource[21]] == 0){
			$displays->message($lang['bd_shipyard_required'], '', '', true);
                }

		include_once($svn_root . 'includes/functions/IsTechnologieAccessible.' . $phpEx);
		include_once($svn_root . 'includes/functions/GetElementPrice.' . $phpEx);

		$displays->assignContent("buildings/buildings_fleet");
		if (isset($_POST['fmenge']))
		{
			$AddedInQueue = false;

			foreach($_POST['fmenge'] as $Element => $Count)
			{
				$Element = intval($Element);
				$Count   = intval($Count);
				if ($Count > MAX_FLEET_OR_DEFS_PER_ROW){
					$Count = MAX_FLEET_OR_DEFS_PER_ROW;
                                }
				if ($Count != 0)
				{
					if ( IsTechnologieAccessible ($CurrentUser, $CurrentPlanet, $Element) )
					{
						$MaxElements   = $this->GetMaxConstructibleElements ( $Element, $CurrentPlanet );

						if ($Count > $MaxElements)
							$Count = $MaxElements;

						$Ressource = $this->GetElementRessources ( $Element, $Count );

						if ($Count >= 1)
						{
							$CurrentPlanet['metal']          -= $Ressource['metal'];
							$CurrentPlanet['crystal']        -= $Ressource['crystal'];
							$CurrentPlanet['deuterium']      -= $Ressource['deuterium'];

							if ($Element == 214 && $CurrentUser['rpg_destructeur'] == 1)
								$Count = 2 * $Count;

							$CurrentPlanet['b_hangar_id']    .= "". $Element .",". $Count .";";
						}
					}
				}
			}
                        header("location: ?page=buildings&mode=fleet");
		}

		
		$NotBuilding = true;

		if ($CurrentPlanet['b_building_id'] != 0)
		{
			$CurrentQueue = explode(";",$CurrentPlanet['b_building_id']);
			
			foreach($CurrentQueue as $a){
				
				
				if($i<1){
				$QueueArray		= explode (",", $a);
				
					if($QueueArray[0] == 21  || $QueueArray[0] == 15){
						$NotCan=TRUE;
					}
				}
				$i++;
				
			}

			if ($NotCan)
			{
				$parse[message] = "<font color=\"red\">".$lang['bd_building_shipyard']."</font>";
				$NotBuilding = false;
			}
		}

		$TabIndex = 0;
		$fila=1;
		foreach($reslist['fleet'] as $Element )
		{
			if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element))
			{
                                        $displays->newblock("fleet");
					$CanBuildOne         = IsElementBuyable($CurrentUser, $CurrentPlanet, $Element, false);
					$BuildOneElementTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
					$ElementCount        = $CurrentPlanet[$resource[$Element]];
					$ElementNbre         = ($ElementCount == 0) ? "" : " (". $lang['bd_available'] . pretty_number($ElementCount) . ")";

					$parserow["i"] =$Element;
					$parserow["count"]=$ElementNbre;
					$parserow["name"]=$lang['tech'][$Element];
					$parserow["descripcion"] = $lang['res']['descriptions'][$Element];
					$parserow["price"] = GetElementPrice($CurrentUser, $CurrentPlanet, $Element, false);
					$parserow["time"] = ShowBuildTime($BuildOneElementTime);


					if ($CanBuildOne && $NotBuilding)
					{
						$TabIndex++;
						$parserow["TabIndex"]=$TabIndex;
						$maxElement = $this->GetMaxConstructibleElements ( $Element, $CurrentPlanet );
						$parserow["max"]=$maxElement;
						$parserow["max2"]="M&aacute;x";
						
					}
					if ($fila%3==0){
						$parserow['cerrartr'] = "</tr><tr>";
					}
					$fila++;
					
					foreach ($parserow as $key => $value) {
                                            $displays->assign($key,$value);
                                        }
					unset($parserow);
			}
			
		}
                if ($CurrentPlanet['b_hangar_id'] != '' && $CurrentPlanet['b_hangar_id'] != '0'){
			$this->ElementBuildListBox( $CurrentUser, $CurrentPlanet );
		}
                 $displays->gotoBlock("_ROOT");
		
                if($NotBuilding){
			$parse['build_fleet'] = "<tr><td class=\"c\" colspan=\"3\" align=\"center\"><input type=\"submit\" value=\"".$lang['bd_build_ships']."\"></td></tr>";
		}

                foreach ($parse as $key => $value) {
                        $displays->assign($key,$value);
                }

		$displays->display();
         }

	public function DefensesBuildingPage ( &$CurrentPlanet, $CurrentUser )
	{
		global $lang, $resource, $phpEx, $dpath, $_POST,$svn_root,$reslist,$displays;

                if ($CurrentPlanet[$resource[21]] == 0){
			$displays->message($lang['bd_shipyard_required'], '', '', true);
		}
                
		include_once($svn_root . 'includes/functions/IsTechnologieAccessible.' . $phpEx);
		include_once($svn_root . 'includes/functions/GetElementPrice.' . $phpEx);

		$displays->assignContent("buildings/buildings_defense");

                if (isset($_POST['fmenge']))
		{
                        $Missiles[502] = $CurrentPlanet[ $resource[502] ];
			$Missiles[503] = $CurrentPlanet[ $resource[503] ];
			$SiloSize      = $CurrentPlanet[ $resource[44] ];
			$MaxMissiles   = $SiloSize * 10;
			$BuildQueue    = $CurrentPlanet['b_hangar_id'];
			$BuildArray    = explode (";", $BuildQueue);

			for ($QElement = 0; $QElement < count($BuildArray); $QElement++)
			{
				$ElmentArray = explode (",", $BuildArray[$QElement] );
				if($ElmentArray[0] == 502)
				{
					$Missiles[502] += $ElmentArray[1];
				}
				elseif($ElmentArray[0] == 503)
				{
					$Missiles[503] += $ElmentArray[1];
				}
			}

                        foreach($_POST['fmenge'] as $Element => $Count)
			{
				$Element = intval($Element);
				$Count   = intval($Count);

				if ($Count > MAX_FLEET_OR_DEFS_PER_ROW){
					$Count = MAX_FLEET_OR_DEFS_PER_ROW;
				}

				if ($Count != 0)
				{
					$InQueue = strpos ( $CurrentPlanet['b_hangar_id'], $Element.",");
					$IsBuildp = ($CurrentPlanet[$resource[407]] >= 1) ? TRUE : FALSE;
					$IsBuildg = ($CurrentPlanet[$resource[408]] >= 1) ? TRUE : FALSE;
					$IsBuildpp = ($CurrentPlanet[$resource[409]] >= 1) ? TRUE : FALSE;

					if ( $Element == 407 && !$IsBuildp && $InQueue === FALSE )
					{
						$Count = 1;
					}


					if ( $Element == 408 && !$IsBuildg && $InQueue === FALSE )
					{
						$Count = 1;
					}


					if ( $Element == 409 && !$IsBuildpp && $InQueue === FALSE )
					{
						$Count = 1;
					}


					if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element))
					{
						$MaxElements = $this->GetMaxConstructibleElements ( $Element, $CurrentPlanet );

						if ($Element == 502 || $Element == 503)
						{
							$ActuMissiles  = $Missiles[502] + ( 2 * $Missiles[503] );
							$MissilesSpace = $MaxMissiles - $ActuMissiles;
							if ($Element == 502)
							{
								if ( $Count > $MissilesSpace )
								{
									$Count = $MissilesSpace;
								}

							}
							else
							{
								if ( $Count > floor( $MissilesSpace / 2 ) )
								{
									$Count = floor( $MissilesSpace / 2 );
								}
							}

							if ($Count > $MaxElements)
							{
								$Count = $MaxElements;
							}

							$Missiles[$Element] += $Count;
						}
						else
						{
							if ($Count > $MaxElements)
							{
								$Count = $MaxElements;
							}

						}

						$Ressource = $this->GetElementRessources ( $Element, $Count );

						if ($Count >= 1)
						{
							$CurrentPlanet['metal']           -= $Ressource['metal'];
							$CurrentPlanet['crystal']         -= $Ressource['crystal'];
							$CurrentPlanet['deuterium']       -= $Ressource['deuterium'];
							$CurrentPlanet['b_hangar_id']     .= "". $Element .",". $Count .";";
						}
					}
				}
			}
                        //$CurrentPlanet['b_hangar_id']=substr($CurrentPlanet['b_hangar_id'], 0, -1);
                        
                        header("location: ?page=buildings&mode=defense");
		}

		

		$NotBuilding = true;
		
		if ($CurrentPlanet['b_building_id'] != '')
		{
			$CurrentQueue = explode(";",$CurrentPlanet['b_building_id']);
			
			foreach($CurrentQueue as $a){
				
				if($i<1){
				$QueueArray		= explode (",", $a);
				
				if($QueueArray[0] == 21  || $QueueArray[0] == 15){
					$NotCan=TRUE;
				}
				}
				$i++;
				
			}
			
	
			if ($NotCan)
			{
				$parse[message] = "<font color=\"red\">".$lang['bd_building_shipyard']."</font>";
				$NotBuilding = false;
			}


		}

		$TabIndex  = 0;
		$fila=1;
		foreach($reslist['defense'] as $Element )
		{
			
				if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element))
				{
                                        $displays->newblock("buildlist");
					$CanBuildOne         = IsElementBuyable($CurrentUser, $CurrentPlanet, $Element, false);
					$BuildOneElementTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
					$ElementCount        = $CurrentPlanet[$resource[$Element]];
					$ElementNbre         = ($ElementCount == 0) ? "" : " (". $lang['bd_available'] . pretty_number($ElementCount) . ")";
					
					$parserow["i"] =$Element;
					$parserow["dpath"] =$dpath;
					$parserow["count"]=$ElementNbre;
					$parserow["name"]=$lang['tech'][$Element];
					$parserow["descripcion"] = $lang['res']['descriptions'][$Element];
					$parserow["price"] = GetElementPrice($CurrentUser, $CurrentPlanet, $Element, false);
					$parserow["time"] = ShowBuildTime($BuildOneElementTime);


					if ($CanBuildOne)
					{
						$InQueue = strpos ( $CurrentPlanet['b_hangar_id'], $Element.",");
						$IsBuildp = ($CurrentPlanet[$resource[407]] >= 1) ? TRUE : FALSE;
						$IsBuildg = ($CurrentPlanet[$resource[408]] >= 1) ? TRUE : FALSE;
						$IsBuildpp = ($CurrentPlanet[$resource[409]] >= 1) ? TRUE : FALSE;
						$BuildIt = TRUE;
						if ($Element == 407 || $Element == 408 || $Element == 409)
						{
							$BuildIt = false;

							if ( $Element == 407 && !$IsBuildp && $InQueue === FALSE )
								$BuildIt = TRUE;

							if ( $Element == 408 && !$IsBuildg && $InQueue === FALSE )
								$BuildIt = TRUE;

							if ( $Element == 409 && !$IsBuildpp && $InQueue === FALSE )
								$BuildIt = TRUE;

						}

						if (!$BuildIt){
							$parserow["click"] = "<font color=\"red\">".$lang['bd_protection_shield_only_one']."</font>";
						}
						elseif($NotBuilding)
						{
							$TabIndex++;
							$maxElement = $this->GetMaxConstructibleElements ( $Element, $CurrentPlanet );
							
							$parserow["click"]="<input type=text name=fmenge[".$Element."] alt='".$lang['tech'][$Element]."' size=9 maxlength=9 value=0 tabindex=".$TabIndex.">
								<a href='javascript:' onclick=\"document.getElementsByName('fmenge[".$Element."]')[0].value = '$maxElement';\">M&aacute;x.</a>";
						}

						
					}
					if ($fila%3==0){
						$parserow['cerrartr'] = "</tr><tr>";
					}
					$fila++;
                                        foreach ($parserow as $key => $value) {
                                            $displays->assign($key,$value);
                                        }
                                        
                                        //$buildefense.=parsetemplate(gettemplate('buildings/buildings_defense_row'), $parserow);
					unset($parserow);
				}
			
		}

		if ($CurrentPlanet['b_hangar_id'] != ''){
			$this->ElementBuildListBox( $CurrentUser, $CurrentPlanet );
		}
                $displays->gotoBlock("_ROOT");

                if($NotBuilding){
			$parse['build_defenses'] = "<tr><td class=\"c\" colspan=\"3\" align=\"center\"><input type=\"submit\" value=\"".$lang['bd_build_ships']."\"></td></tr>";
		}

                foreach ($parse as $key => $value) {
                        $displays->assign($key,$value);
                }

                $displays->display();
       }


       
}
?>