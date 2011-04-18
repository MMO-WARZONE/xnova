<?php

/**
 * DefensesBuildingPage.php
 *
 * @version 1.2
 * @copyright 2008 By Chlorel for XNova
 */

// Seite für den Bau von Deff
// $CurrentPlanet -> Planet auf dem gebaut wird
//                   
// $CurrentUser   -> User der baut
//
function DefensesBuildingPage ( &$CurrentPlanet, $CurrentUser ) {
 	global $lang, $resource, $dpath, $_POST;


	if (isset($_POST['fmenge'])) {
		// Wenn man auf "Bauen" klickt
		
		// Raketen
		$Missiles[502] = $CurrentPlanet[ $resource[502] ];
		$Missiles[503] = $CurrentPlanet[ $resource[503] ];
		$SiloSize      = $CurrentPlanet[ $resource[44] ];
		$MaxMissiles   = $SiloSize * 10;
		$BuildQueue    = $CurrentPlanet['b_hangar_id'];
		$BuildArray    = explode (";", $BuildQueue);
		for ($QElement = 0; $QElement < count($BuildArray); $QElement++) {
			$ElmentArray = explode (",", $BuildArray[$QElement] );
			if       ($ElmentArray[502] != 0) {
				$Missiles[502] += $ElmentArray[502];
			} elseif ($ElmentArray[503] != 0) {
				$Missiles[503] += $ElmentArray[503];
			}
		}
		foreach($_POST['fmenge'] as $Element => $Count) {
			

			$Element = intval($Element);
			$Count   = intval($Count);
			if ($Count > MAX_FLEET_OR_DEFS_PER_ROW) {
				$Count = MAX_FLEET_OR_DEFS_PER_ROW;
			}


			if ($Count != 0) {
				//Die Kuppeln können nur einmal gebaut werden.
				$InQueue = strpos ( $CurrentPlanet['b_hangar_id'], $Element.",");
				
					$IsBuildp = ($CurrentPlanet[$resource[407]] >= 1) ? TRUE : FALSE;
					$IsBuildg = ($CurrentPlanet[$resource[408]] >= 1) ? TRUE : FALSE;
					if ( $Element == 407 && !$IsBuildp && $InQueue === FALSE ) {
						$Count = 1;
					}
					if ( $Element == 408 && !$IsBuildg && $InQueue === FALSE ) {
						$Count = 1;
					}
					
				//Prüfen, ob man die nötige Technologie für den Bau hat
				if ( IsTechnologieAccessible ($CurrentUser, $CurrentPlanet, $Element) ) {
					//Festlegen, wieviele Elemente maximal gebaut werden können
					$MaxElements   = GetMaxConstructibleElements ( $Element, $CurrentPlanet );

					//Prüfen, ob in den Silos noch Platz für Raketen ist
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
						// Hat man micht genug Ress, wird die Anzahl der Schiffe entsprechend angepasst
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

	//Wenn man keine Raumschiffswerft hat
	if ($CurrentPlanet[$resource[21]] == 0) {
		//Kann man acuh nichts bauen^^
		message($lang['need_hangar'], $lang['tech'][21]);
		//Und bekommt ne Fehlermeldung
	}

	// Beginn der eigentlichen Bauseite ( Also das, was der User nachher sieht )
	$TabIndex  = 0;
	$PageTable = "";
	foreach($lang['tech'] as $Element => $ElementName) {
		if ($Element > 400 && $Element <= 599) {
			if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element)) {
				// Wenn man bauen kann...

				
				$CanBuildOne         = IsElementBuyable($CurrentUser, $CurrentPlanet, $Element, false);
				
				$BuildOneElementTimeWithoutTechs = GetBuildingTimeWithoutTechs($CurrentUser, $CurrentPlanet, $Element); //ursprüngliche Bauzeit ermitteln

				$BuildOneElementTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element); //benötigte Bauzeit ermitteln
				
				// aktuell verfügbar
				$baubar= GetMaxConstructibleShips($CurrentPlanet, $Element);
				$ElementCount        = $CurrentPlanet[$resource[$Element]];
				$ElementNbre         = ($ElementCount == 0) ? "($lang[builtable]$baubar)" : " (".$lang['dispo'].": " . pretty_number($ElementCount) . " $lang[builtable] $baubar)";

				
				$PageTable .= "\n<tr>";

				$PageTable .= "
	<th class=\"l\" rowspan=\"2\" width=\"120\">
		<a href=\"?action=internalInformations&amp;gid=".$Element."\"><img border=0 src=\"".$dpath."gebaeude/".$Element.".gif\" align=top alt=".$Element.".gif width=120 height=120></a>
	</th>
    <td class=\"c\">
    	<table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
    		<tbody>
				<tr>
					<td width=\"15\"><img src=\"images/transparent.gif\" alt=\"transparent\" width=\"0\" height=\"21\"></td>
					<td><a href=\"?action=internalInformations&amp;gid=".$Element."\">".$ElementName."</a> ".$ElementNbre."</td>
					<td width=\"100\">&nbsp;</td>
    			</tr>
    		</tbody>
		</table>
    </td>
</tr>
<tr>
    <td colspan=\"1\">
    	<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
    		<tbody>
				<tr>
					<td class=\"rechtsohneborder\" width=\"10\"><img src=\"images/transparent.gif\" alt=\"transparent\" width=\"0\" height=\"100\"></td>
					<td class=\"linksundrechtsohneborder\" width=\"80%\">".$lang['res']['descriptions'][$Element]."<br>&nbsp;<br>";
					$PageTable .= GetElementPrice($CurrentUser, $CurrentPlanet, $Element, false);
					$PageTable .= "
					<br><br>
        			<td class=\"linksohneborder\" width=\"100\">";
					if ($CanBuildOne) 
				{
					if ( ($Element == 407 && $CurrentPlanet[$resource[407]] >= "1") ||
						($Element == 407 && $CurrentPlanet['b_hangar_id'] == "407,1;") ||
						($Element == 408 && $CurrentPlanet[$resource[408]] >= "1") ||
						($Element == 408 && $CurrentPlanet['b_hangar_id'] == "408,1;")){
						$PageTable .= "<p align=\"center\"><br>&nbsp;<br><font color=\"orange\">".$lang['only_one']."</font></p>";
					} else {
						$TabIndex++;
						$PageTable .= "<p align=\"center\"><br>&nbsp;<br><a href=\"javascript:setL(".$Element.");\"><img src=\"images/back.gif\" width=\"17\" style=\"vertical-align:bottom\" border=\"0\" height=\"15\" alt=\"back\"></a><input name=fmenge[".$Element."] size=\"5\" maxlength=\"5\" style=\"text-align: center;\" value=\"0\" onClick=\"if(this.value=='0') this.value='';\" onBlur=\"if(this.value=='') this.value='0';\" type=\"text\" tabindex=\"".$TabIndex."\"><a href=\"javascript:setN(".$Element.");\"><img src=\"images/forward.gif\" width=\"17\" style=\"vertical-align:bottom\" border=\"0\" height=\"15\" alt=\"forward\"></a><br>&nbsp;<br><a href=\"javascript:setMax(".$Element.",".$baubar.")\">max</a></p>";
						$PageTable .= "</th>";
					}
				} else 
				{
					$PageTable .= "</th>";
				}
				
				$PageTable .= "
					</td>
				</tr>
			</tbody>
		</table>
    </td>
</tr>
<tr>
    <td colspan=\"2\">
    
        <table width=\"100%\" border=\"0\" cellpadding=\"0\" cellspacing=\"0\">
        <tbody><tr>
       
             <td class=\"b\">
                <table width=\"100%\" align=\"center\" cellpadding=\"2\" cellspacing=\"0\">
                <tbody>
				<tr>
					<td>
						<a class=\"b\">".$lang['NeededRess']."</a><br><br>
					</td>
					<td colspan=\"2\">
						<a class=\"b\">".$lang['BuildingTime']."</a><br>
						<br>
					</td>
				</tr>
				<tr>		
					<td width=\"68%\" rowspan=\"3\">";
                    	$PageTable .= GetRestPrice($CurrentUser, $CurrentPlanet, $Element);
					$PageTable .= "</td>
                    <td width=\"20%\">". $lang['ConstructionTimeWithoutTechs'] ."</td>
                    <td width=\"12%\" align=\"right\">";
                    	$PageTable .= ShowBuildTimeWithoutTechs($BuildOneElementTimeWithoutTechs);
					$PageTable .= "</td>
                </tr>
                <tr>
                    <td>
                        ". $lang['TechBonus'] .":
                    </td>
                                
                    <td align=\"right\">";
                       $PageTable .= ShowTechBonus($BuildOneElementTimeWithoutTechs - $BuildOneElementTime);
                    $PageTable .= "</td>
                </tr>
				
				<tr>
                    <td>&nbsp;</td>          
                    <td align=\"right\">&nbsp;</td>
                </tr>
				
                 <tr>
                    <td colspan=\"2\" height=\"5\"></td>          
                </tr>
                <tr>
					<td>&nbsp;</td>
                    <td>". $lang['ConstructionTime'] ."</td>
                    <td align=\"right\">";
                        $PageTable .= ShowBuildTime($BuildOneElementTime);
                    $PageTable .= "</td>
                </tr>
                </tbody></table>
            </td>
        </tr>
        </tbody></table><br>";
				// Fin de ligne (les 3 cases sont construites !!
				$PageTable .= "</tr>";
			}
		}
	}

	if ($CurrentPlanet['b_hangar_id'] != '') {
		$BuildQueue .= ElementBuildListBox( $CurrentUser, $CurrentPlanet );
	}

	$parse = $lang;
	// La page se trouve dans $PageTable;
	$parse['buildlist']    = $PageTable;
	// Et la liste de constructions en cours dans $BuildQueue;
	$parse['buildinglist'] = $BuildQueue;
	// fragmento de template
	$page .= parsetemplate(gettemplate('buildings_defense'), $parse);

	display($page, $lang['Defense']);

}
// Version History
// - 1.0 Modularisation
// - 1.1 Correction mise en place d'une limite max d'elements constructibles par ligne
// - 1.2 Correction limitation bouclier meme si en queue de fabrication
//
?>