<?php

if(!defined('INSIDE')){ die(header("location:../../"));}

class ShowShipyardPage
{
	private function GetMaxConstructibleElements ($Element, $Ressources)
	{
		global $pricelist;

		if ($pricelist[$Element]['metal'] != 0)
		{
			$Buildable        = floor($Ressources["metal"] / $pricelist[$Element]['metal']);
			$MaxElements      = $Buildable;
		}

		if ($pricelist[$Element]['crystal'] != 0)
			$Buildable        = floor($Ressources["crystal"] / $pricelist[$Element]['crystal']);

		if (!isset($MaxElements))
			$MaxElements      = $Buildable;
		elseif($MaxElements > $Buildable)
			$MaxElements      = $Buildable;

		if ($pricelist[$Element]['deuterium'] != 0)
			$Buildable        = floor($Ressources["deuterium"] / $pricelist[$Element]['deuterium']);

    	if ($pricelist[$Element]['darkmatter'] != 0)
		$Buildable        = floor($Ressources["darkmatter"] / $pricelist[$Element]['darkmatter']);

		if (!isset($MaxElements))
			$MaxElements      = $Buildable;
		elseif ($MaxElements > $Buildable)
			$MaxElements      = $Buildable;

		if ($pricelist[$Element]['energy'] != 0)
			$Buildable        = floor($Ressources["energy_max"] / $pricelist[$Element]['energy']);

		if ($Buildable < 1)
			$MaxElements      = 0;

		return $MaxElements;
	}

	private function GetElementRessources($Element, $Count)
	{
		global $pricelist;

		$ResType['metal']     = ($pricelist[$Element]['metal']     * $Count);
		$ResType['crystal']   = ($pricelist[$Element]['crystal']   * $Count);
		$ResType['deuterium'] = ($pricelist[$Element]['deuterium'] * $Count);
        $ResType['darkmatter'] = ($pricelist[$Element]['darkmatter'] * $Count);

		return $ResType;
	}

	private function ElementBuildListBox ( $CurrentUser, $CurrentPlanet )
	{
		global $lang, $pricelist;

		$ElementQueue = explode(';', $CurrentPlanet['b_hangar_id']);
		$NbrePerType  = "";
		$NamePerType  = "";
		$TimePerType  = "";

		foreach($ElementQueue as $ElementLine => $Element)
		{
			if ($Element != '')
			{
				$Element 		= explode(',', $Element);
				$ElementTime  	= GetBuildingTime( $CurrentUser, $CurrentPlanet, $Element[0] );
				$QueueTime   	+= $ElementTime * $Element[1];
				$TimePerType 	.= "".$ElementTime.",";
				$NamePerType 	.= "'". html_entity_decode($lang['tech'][$Element[0]]) ."',";
				$NbrePerType 	.= "".$Element[1].",";
			}
		}

		$parse 							= $lang;
		$parse['a'] 					= $NbrePerType;
		$parse['b'] 					= $NamePerType;
		$parse['c'] 					= $TimePerType;
		$parse['b_hangar_id_plus'] 		= $CurrentPlanet['b_hangar'];
		$parse['pretty_time_b_hangar'] 	= pretty_time($QueueTime - $CurrentPlanet['b_hangar']);
		$text .= parsetemplate(gettemplate('buildings/buildings_script'), $parse);

		return $text;
	}

	public function FleetBuildingPage ( &$CurrentPlanet, $CurrentUser )
	{
		global $lang, $resource, $phpEx, $dpath, $xgp_root;

		include_once($xgp_root . 'includes/functions/IsTechnologieAccessible.' . $phpEx);
		include_once($xgp_root . 'includes/functions/GetElementPrice.' . $phpEx);

		$parse = $lang;
		//---Inicio cancelar cola de flotas---//
        if($_GET['cancel'] == 'queue'){
        // Comprobacion de cola
       if ($CurrentPlanet['b_hangar_id'] == 0 OR $CurrentPlanet['b_hangar_id'] == '')
                       {
message('Error<br>No hay ningun elemento en la cola', 'game.php?page=buildings&mode=fleet', 3);
}

// Reconstruir
$Queue   = $CurrentPlanet['b_hangar_id'];
$DO      = explode(";", $Queue);
$QueueCountColocation = 1;
if(count($DO) > 1) $QueueCountColocation = 2;
$COUNTD  = count($DO)-$QueueCountColocation;

// Devolver recursos
$CASE  = explode(",", $DO[$COUNTD]);
$Ressource = $this->GetElementRessources($CASE[0], $CASE[1]);
$Ressource['metal']          = ($Ressource['metal']/100)*75;
$Ressource['crystal']        = ($Ressource['crystal']/100)*75;
$Ressource['deuterium']      = ($Ressource['deuterium']/100)*75;
$Ressource['darkamatter']    = ($Ressource['darkmatter']/100)*75;
$CurrentPlanet['metal']     += $Ressource['metal'];
$CurrentPlanet['crystal']   += $Ressource['crystal'];
$CurrentPlanet['deuterium'] += $Ressource['deuterium'];
$CurrentPlanet['darkmatter'] += $Ressource['darkmatter'];

// POP Manual
if(count($DO) > 1){
$LAST = $COUNTD;

// Reconstruccion
foreach($DO as $ID => $CAD){
if($ID != $LAST){
$NDO[$ID] = $CAD;
}
}

// Grabar nuevos datos
$REC  = implode(";", $NDO);
doquery("UPDATE {{table}} SET  b_hangar_id = '".$REC."', metal = metal + ".$Ressource['metal'].", crystal = crystal + ".$Ressource['crystal'].", deuterium = deuterium + ".$Ressource['deuterium'].", darkmatter = darkmatter + ".$Ressource['darkmatter']." WHERE id = '".$CurrentPlanet["id"]."'", "planets");
}else{
doquery("UPDATE {{table}} SET b_hangar = '', b_hangar_plus = '', b_hangar_id = '', metal = metal + ".$Ressource['metal'].", crystal = crystal + ".$Ressource['crystal'].", deuterium = deuterium + ".$Ressource['deuterium'].", darkmatter = darkmatter + ".$Ressource['darkmatter']." WHERE id = '".$CurrentPlanet["id"]."'", "planets");
}
message('¡Cancelado!<br><a href=game.php?page=buildings&mode=fleet>Regresar</a>', 'game.php?page=buildings&mode=fleet', 3);
}
//---Fin cancelar cola de flotas---//

		if (isset($_POST['fmenge']))
		{
			$AddedInQueue = false;

			foreach($_POST['fmenge'] as $Element => $Count)
			{
				$Element = floatval($Element);
				$Count   = floatval($Count);
				if ($Count > MAX_FLEET_OR_DEFS_PER_ROW)
					$Count = MAX_FLEET_OR_DEFS_PER_ROW;

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
							$CurrentPlanet['darkmatter']      -= $Ressource['darkmatter'];

							if ($Element == 214 && $CurrentUser['rpg_destructeur'] == 1)
								$Count = 2 * $Count;

							$CurrentPlanet['b_hangar_id']    .= "". $Element .",". $Count .";";
						}
					}
				}
			}

			header ("Location: game.php?page=buildings&mode=fleet");
		}

		if ($CurrentPlanet[$resource[21]] == 0)
			message($lang['bd_shipyard_required'], '', '', true);

		$NotBuilding = true;

		if ($CurrentPlanet['b_building_id'] != 0)
		{
			$CurrentQueue = $CurrentPlanet['b_building_id'];
			if (strpos ($CurrentQueue, ";"))
			{
				// FIX BY LUCKY - IF THE SHIPYARD IS IN QUEUE THE USER CANT RESEARCH ANYTHING...
				$QueueArray		= explode (";", $CurrentQueue);

				for($i = 0; $i < MAX_BUILDING_QUEUE_SIZE; $i++)
				{
					$ListIDArray	= explode (",", $QueueArray[$i]);
					$Element		= $ListIDArray[0];

					if ( ($Element == 21 ) or ( $Element == 14 ) or ( $Element == 15 ) )
					{
						break;
					}
				}
				// END - FIX
			}
			else
			{
				$CurrentBuilding = $CurrentQueue;
			}

			if ( ( ( $CurrentBuilding == 21 ) or ( $CurrentBuilding == 14 ) or ( $CurrentBuilding == 15 ) ) or  (($Element == 21 ) or ( $Element == 14 ) or ( $Element == 15 )) ) // ADDED (or $Element == 21) BY LUCKY
			{
				$parse[message] = "<font color=\"red\">".$lang['bd_building_shipyard']."</font>";
				$NotBuilding = false;
			}
		}

		$TabIndex = 0;
		foreach($lang['tech'] as $Element => $ElementName)
		{
			if ($Element > 201 && $Element <= 399)
			{
				if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element))
				{
					$CanBuildOne         = IsElementBuyable($CurrentUser, $CurrentPlanet, $Element, false);
					$BuildOneElementTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
					$ElementCount        = $CurrentPlanet[$resource[$Element]];
					$ElementNbre         = ($ElementCount == 0) ? "" : " (". $lang['bd_available'] . pretty_number($ElementCount) . ")";

					$PageTable .= "\n<tr>";
					$PageTable .= "<th class=l>";
					$PageTable .= "<a href=game.".$phpEx."?page=infos&gid=".$Element.">";
					$PageTable .= "<img border=0 src=\"".$dpath."gebaeude/".$Element.".gif\" align=top width=120 height=120></a>";
					$PageTable .= "</th>";
					$PageTable .= "<td class=l>";
					$PageTable .= "<a href=game.".$phpEx."?page=infos&gid=".$Element.">".$ElementName."</a> ".$ElementNbre."<br>";
					$PageTable .= "".$lang['res']['descriptions'][$Element]."<br>";
					$PageTable .= GetElementPrice($CurrentUser, $CurrentPlanet, $Element, false);
					$PageTable .= ShowBuildTime($BuildOneElementTime);
					$PageTable .= "</td>";
					$PageTable .= "<th class=k>";

					if ($CanBuildOne && $NotBuilding)
					{
						$TabIndex++;
						$PageTable .= "<input type=text name=fmenge[".$Element."] alt='".$lang['tech'][$Element]."' size=6 maxlength=25 value=0 tabindex=".$TabIndex.">";
                                     $maxElement = $this->GetMaxConstructibleElements ( $Element, $CurrentPlanet );
                    $PageTable .= "<br><th><a href='javascript:' onclick=\"document.getElementsByName('fmenge[".$Element."]')[0].value = '$maxElement';\">Max.</a></th>";
                    }

					if($NotBuilding)
					{
						$parse[build_fleet] = "<tr><td class=\"c\" colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"".$lang['bd_build_ships']."\"></td></tr>";
					}

					$PageTable .= "</th>";
					$PageTable .= "</tr>";

				}
			}
		}

		if ($CurrentPlanet['b_hangar_id'] != '')
			$BuildQueue .= $this->ElementBuildListBox( $CurrentUser, $CurrentPlanet );

		$parse['buildlist']    	= $PageTable;
		$parse['buildinglist'] 	= $BuildQueue;
		display(parsetemplate(gettemplate('buildings/buildings_fleet'), $parse));
	}

	public function DefensesBuildingPage ( &$CurrentPlanet, $CurrentUser )
	{
		global $lang, $resource, $phpEx, $dpath, $_POST,$xgp_root;

		include_once($xgp_root . 'includes/functions/IsTechnologieAccessible.' . $phpEx);
		include_once($xgp_root . 'includes/functions/GetElementPrice.' . $phpEx);

		$parse = $lang;
		//---Inicio cancelar cola de defensas---//
        if($_GET['cancel'] == 'queue'){
        // Comprobacion de cola
       if ($CurrentPlanet['b_hangar_id'] == 0 OR $CurrentPlanet['b_hangar_id'] == '')
                       {
message('Error<br>No hay ningun elemento en la cola', 'game.php?page=buildings&mode=defense', 3);
}

// Reconstruir
$Queue   = $CurrentPlanet['b_hangar_id'];
$DO      = explode(";", $Queue);
$QueueCountColocation = 1;
if(count($DO) > 1) $QueueCountColocation = 2;
$COUNTD  = count($DO)-$QueueCountColocation;

// Devolver recursos
$CASE  = explode(",", $DO[$COUNTD]);
$Ressource = $this->GetElementRessources($CASE[0], $CASE[1]);
$Ressource['metal']          = ($Ressource['metal']/100)*75;
$Ressource['crystal']        = ($Ressource['crystal']/100)*75;
$Ressource['deuterium']      = ($Ressource['deuterium']/100)*75;
$Ressource['darkmatter']      = ($Ressource['darkmatter']/100)*75;
$CurrentPlanet['metal']     += $Ressource['metal'];
$CurrentPlanet['crystal']   += $Ressource['crystal'];
$CurrentPlanet['deuterium'] += $Ressource['deuterium'];
$CurrentPlanet['darkmatter'] += $Ressource['darkmatter'];

// POP Manual
if(count($DO) > 1){
$LAST = $COUNTD;

// Reconstruccion
foreach($DO as $ID => $CAD){
if($ID != $LAST){
$NDO[$ID] = $CAD;
}
}

// Grabar nuevos datos
$REC  = implode(";", $NDO);
doquery("UPDATE {{table}} SET  b_hangar_id = '".$REC."', metal = metal + ".$Ressource['metal'].", crystal = crystal + ".$Ressource['crystal'].", deuterium = deuterium + ".$Ressource['deuterium'].", darkmatter = darkmatter + ".$Ressource['darkmatter']." WHERE id = '".$CurrentPlanet["id"]."'", "planets");
}else{
doquery("UPDATE {{table}} SET b_hangar = '', b_hangar_plus = '', b_hangar_id = '', metal = metal + ".$Ressource['metal'].", crystal = crystal + ".$Ressource['crystal'].", deuterium = deuterium + ".$Ressource['deuterium'].", darkmatter = darkmatter + ".$Ressource['darkmatter']." WHERE id = '".$CurrentPlanet["id"]."'", "planets");
}
message('¡Cancelado!<br><a href=game.php?page=buildings&mode=fleet>Regresar</a>', 'game.php?page=buildings&mode=fleet', 3);
}
//---Fin cancelar cola de defensas---//

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
				$Element = floatval($Element);
				$Count   = floatval($Count);

				if ($Count > MAX_FLEET_OR_DEFS_PER_ROW)
					$Count = MAX_FLEET_OR_DEFS_PER_ROW;

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
					    	$CurrentPlanet['darkmatter']     -= $Ressource['darkmatter'];
							$CurrentPlanet['b_hangar_id']     .= "". $Element .",". $Count .";";
						}
					}
				}
			}

			header ("Location: game.php?page=buildings&mode=defense");

    	}

		if ($CurrentPlanet[$resource[21]] == 0)
			message($lang['bd_shipyard_required'], '', '', true);

		$NotBuilding = true;

		if ($CurrentPlanet['b_building_id'] != 0)
		{
			$CurrentQueue = $CurrentPlanet['b_building_id'];
			if (strpos ($CurrentQueue, ";"))
			{
				// FIX BY LUCKY - IF THE SHIPYARD IS IN QUEUE THE USER CANT RESEARCH ANYTHING...
				$QueueArray		= explode (";", $CurrentQueue);

				for($i = 0; $i < MAX_BUILDING_QUEUE_SIZE; $i++)
				{
					$ListIDArray	= explode (",", $QueueArray[$i]);
					$Element		= $ListIDArray[0];

					if ( ($Element == 21 ) or ( $Element == 14 ) or ( $Element == 15 ) )
					{
						break;
					}
				}
				// END - FIX
			}
			else
			{
				$CurrentBuilding = $CurrentQueue;
			}

			if ( ( ( $CurrentBuilding == 21 ) or ( $CurrentBuilding == 14 ) or ( $CurrentBuilding == 15 ) ) or  (($Element == 21 ) or ( $Element == 14 ) or ( $Element == 15 )) ) // ADDED (or $Element == 21) BY LUCKY
			{
				$parse[message] = "<font color=\"red\">".$lang['bd_building_shipyard']."</font>";
				$NotBuilding = false;
			}


		}

		$TabIndex  = 0;
		$PageTable = "";
		foreach($lang['tech'] as $Element => $ElementName)
		{
			if ($Element > 400 && $Element <= 599)
			{
				if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element))
				{
					$CanBuildOne         = IsElementBuyable($CurrentUser, $CurrentPlanet, $Element, false);
					$BuildOneElementTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
					$ElementCount        = $CurrentPlanet[$resource[$Element]];
					$ElementNbre         = ($ElementCount == 0) ? "" : " (". $lang['bd_available'] . pretty_number($ElementCount) . ")";

					$PageTable .= "\n<tr>";
					$PageTable .= "<th class=l>";
					$PageTable .= "<a href=game.".$phpEx."?page=infos&gid=".$Element.">";
					$PageTable .= "<img border=0 src=\"".$dpath."gebaeude/".$Element.".gif\" align=top width=120 height=120></a>";
					$PageTable .= "</th>";
					$PageTable .= "<td class=l>";
					$PageTable .= "<a href=game.".$phpEx."?page=infos&gid=".$Element.">".$ElementName."</a> ".$ElementNbre."<br>";
					$PageTable .= "".$lang['res']['descriptions'][$Element]."<br>";
					$PageTable .= GetElementPrice($CurrentUser, $CurrentPlanet, $Element, false);
					$PageTable .= ShowBuildTime($BuildOneElementTime);
					$PageTable .= "</td>";
					$PageTable .= "<th class=k>";

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

						if (!$BuildIt)
							$PageTable .= "<font color=\"red\">".$lang['bd_protection_shield_only_one']."</font>";
						elseif($NotBuilding)
						{
							$TabIndex++;
							$PageTable .= "<input type=text name=fmenge[".$Element."] alt='".$lang['tech'][$Element]."' size=18 maxlength=18 value=0 tabindex=".$TabIndex.">";
                                                       $maxElement = $this->GetMaxConstructibleElements ( $Element, $CurrentPlanet );
                            $PageTable .= "<br><th><a href='javascript:' onclick=\"document.getElementsByName('fmenge[".$Element."]')[0].value = '$maxElement';\">Max.</a></th>";
                            $PageTable .= "</th>";
						}

						if($NotBuilding)
						{
							$parse[build_defenses] = "<tr><td class=\"c\" colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"".$lang['bd_build_defenses']."\"></td></tr>";
						}
					}
					else
					{
						$PageTable .= "</th>";
					}

					$PageTable .= "</tr>";
				}
			}
		}

		if ($CurrentPlanet['b_hangar_id'] != '')
			$BuildQueue .= $this->ElementBuildListBox( $CurrentUser, $CurrentPlanet );

		$parse['buildlist']    	= $PageTable;
		$parse['buildinglist'] 	= $BuildQueue;
		display(parsetemplate(gettemplate('buildings/buildings_defense'), $parse));
	}
}
?>
