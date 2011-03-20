<?php

function DefensesBuildingPage ( &$CurrentPlanet, $CurrentUser ) {
 	global $lang, $resource, $phpEx, $dpath, $_POST;

	if (isset($_POST['fmenge'])) {

		$Missiles[502] = $CurrentPlanet[ $resource[502] ];
		$Missiles[503] = $CurrentPlanet[ $resource[503] ];
		$SiloSize      = $CurrentPlanet[ $resource[44] ];
		$MaxMissiles   = $SiloSize * 10;

          $BuildQueueList    = $CurrentPlanet['b_hangar_id'];
          $BuildArray    = explode (";", $BuildQueueList);
          for ($QElement = 0; $QElement < count($BuildArray); $QElement++) {
             $ElmentArray = explode (",", $BuildArray[$QElement] );
             if ($ElmentArray[0] == 502 && $ElmentArray[1]>=0) {
                $Missiles[502] += $ElmentArray[1];
             } elseif ($ElmentArray[0] == 503 && $ElmentArray[1]>=0) {
                $Missiles[503] += $ElmentArray[1];
             }
          }
		foreach($_POST['fmenge'] as $Element => $Count) {

			$Element = intval($Element);
			$Count   = intval($Count);
			if ($Count > MAX_FLEET_OR_DEFS_PER_ROW) {
				$Count = MAX_FLEET_OR_DEFS_PER_ROW;
			}


			if ($Count != 0) {

                 $InQueue = strpos ( $CurrentPlanet['b_hangar_id'], $Element.",");
                $IsBuildp = ($CurrentPlanet[$resource[407]] >= 1) ? TRUE : FALSE;
                $IsBuildg = ($CurrentPlanet[$resource[408]] >= 1) ? TRUE : FALSE;
                if ( $Element == 407 && !$IsBuildp && $InQueue === FALSE ) {
                   $Count = 1;
                }
                 if ( $Element == 408 && !$IsBuildg && $InQueue === FALSE ) {
                   $Count = 1;
                }

				if ( IsTechnologieAccessible ($CurrentUser, $CurrentPlanet, $Element) ) {

					$MaxElements   = GetMaxConstructibleElements ( $Element, $CurrentPlanet );

					if ($Element == 502 || $Element == 503) {
						$ActuMissiles  = $Missiles[502] + ( 2 * $Missiles[503] );
						$MissilesSpace = $MaxMissiles - $ActuMissiles;
						if ($Element == 502) {
							if ( $Count > $MissilesSpace ) {
								$Count = $MissilesSpace;
							}
						} else {
							if ( $Count > floor( $MissilesSpace / 2 ) ) {
								$Count = floor( $MissilesSpace / 2 );
							}
						}
						if ($Count > $MaxElements) {
							$Count = $MaxElements;
						}
						$Missiles[$Element] += $Count;
					} else {

						if ($Count > $MaxElements) {
							$Count = $MaxElements;
						}
					}

					$Ressource = GetElementRessources ( $Element, $Count );
					$BuildTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
					if ($Count >= 1) {
						$CurrentPlanet['metal']           -= $Ressource['metal'];
						$CurrentPlanet['crystal']         -= $Ressource['crystal'];
						$CurrentPlanet['deuterium']       -= $Ressource['deuterium'];
						$CurrentPlanet['b_hangar_id']     .= "". $Element .",". $Count .";";
					}
				}
			}
		}
	}

	if ($CurrentPlanet[$resource[21]] == 0) {
		message($lang['need_hangar'], $lang['tech'][21]);
	}

	$TabIndex  = 0;
	$PageTable = "";
	foreach($lang['tech'] as $Element => $ElementName) {
		if ($Element > 400 && $Element <= 599) {
			if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element)) {

				$CanBuildOne         = IsElementBuyable($CurrentUser, $CurrentPlanet, $Element, false);

				$BuildOneElementTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);

				$ElementCount        = $CurrentPlanet[$resource[$Element]];
				$ElementNbre         = ($ElementCount == 0) ? "" : " (".$lang['dispo'].": " . pretty_number($ElementCount) . ")";

				$PageTable .= "\n<tr>";
				$PageTable .= "<th class=l>";
				$PageTable .= "<a href=infos.".$phpEx."?gid=".$Element.">";
				$PageTable .= "<img border=0 src=\"".$dpath."gebaeude/".$Element.".gif\" align=top width=120 height=120></a>";
				$PageTable .= "</th>";
				$PageTable .= "<td class=l>";
				$PageTable .= "<a href=infos.".$phpEx."?gid=".$Element.">".$ElementName."</a> ".$ElementNbre."<br>";
				$PageTable .= "".$lang['res']['descriptions'][$Element]."<br>";
				$PageTable .= GetElementPrice($CurrentUser, $CurrentPlanet, $Element, false);
				$PageTable .= ShowBuildTime($BuildOneElementTime);
				$PageTable .= "</td>";
				$PageTable .= "<th class=k>";

				if ($CanBuildOne) {
					$InQueue = strpos ( $CurrentPlanet['b_hangar_id'], $Element.",");
					$IsBuild = ($CurrentPlanet[$resource[407]] >= 1) ? true : false;
					$BuildIt = true;
					if ($Element == 407 || $Element == 408) {
                        $BuildIt = false;
						if ( $InQueue === false && !$IsBuild) {
							$BuildIt = true;
						}
					}

					if ( !$BuildIt ) {
						$PageTable .= "<font color=\"red\">".$lang['only_one']."</font>";
					} else {
						$TabIndex++;
						$PageTable .= "<input type=text name=fmenge[".$Element."] alt='".$lang['tech'][$Element]."' size=5 maxlength=5 value=0 tabindex=".$TabIndex.">";
						$PageTable .= "</th>";
					}
				} else {
					$PageTable .= "</th>";
				}

				$PageTable .= "</tr>";
			}
		}
	}

	if ($CurrentPlanet['b_hangar_id'] != '') {
		$BuildQueue .= ElementBuildListBox( $CurrentUser, $CurrentPlanet );
	}

	$parse = $lang;
	$parse['buildlist']    = $PageTable;
	$parse['buildinglist'] = $BuildQueue;
	$page .= parsetemplate(gettemplate('buildings_defense'), $parse);

	display($page, $lang['Defense']);

}

?>