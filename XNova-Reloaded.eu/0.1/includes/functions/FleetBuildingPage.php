<?php

/**
 * FleetBuildingPage.php
 *
 * @version 1.1
 * @copyright 2008 By Chlorel for XNova
 *
 * Modifikation und  Übersetzung by Steggi for Xnova-reloaded.de
 */

// Seite für den Flottenbau
// $CurrentPlanet -> Planet auf dem gebaut wird
// $CurrentUser   -> User der baut
//
function FleetBuildingPage ( &$CurrentPlanet, $CurrentUser ) {
 	global $lang, $resource, $dpath, $_POST;

	if (isset($_POST['fmenge'])) {
		//fmenge muss zum Bauen gefüllt sein
		$AddedInQueue                     = false;
		
		foreach($_POST['fmenge'] as $Element => $Count) {
			
			$Element = intval($Element);
			$Count   = intval($Count);
			if ($Count > MAX_FLEET_OR_DEFS_PER_ROW) {
				$Count = MAX_FLEET_OR_DEFS_PER_ROW;
			}

			if ($Count != 0) {
				
				if ( IsTechnologieAccessible ($CurrentUser, $CurrentPlanet, $Element) ) { //prüfen, ob die nötigen Techs vohanden sind
					
					$MaxElements   = GetMaxConstructibleElements ( $Element, $CurrentPlanet ); //maximal baubare Schiffe herausfinden
					
					if ($Count > $MaxElements) { //wenn nicht genügend ress vorhanden sind
						$Count = $MaxElements;	//wird die Anzahl der Schiffe entsprechend angepasst
					}
					$Ressource = GetElementRessources ( $Element, $Count );
					$BuildTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
					if ($Count >= 1) {
						$CurrentPlanet['metal']          -= $Ressource['metal'];
						$CurrentPlanet['crystal']        -= $Ressource['crystal'];
						$CurrentPlanet['deuterium']      -= $Ressource['deuterium'];
						$CurrentPlanet['b_hangar_id']    .= "". $Element .",". $Count .";";
					}
				}
			}
		}
	}

	if ($CurrentPlanet[$resource[21]] == 0) {
		// Wenn es keine Raumschiffwerft auf dem Plani gibt...
		message($lang['need_hangar'], $lang['tech'][21]);
		//Dann gib nen Fehler aus
	}

	$TabIndex = 0;
	foreach($lang['tech'] as $Element => $ElementName) {	
		if ($Element > 201 && $Element <= 399) {	//ID des Elements muss zwischen diesen beiden Werten liegen 
			if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element)) {
				//Wenn verfügbar

				
				$CanBuildOne         = IsElementBuyable($CurrentUser, $CurrentPlanet, $Element, false);
				
				$BuildOneElementTimeWithoutTechs = GetBuildingTimeWithoutTechs($CurrentUser, $CurrentPlanet, $Element); //ursprüngliche Bauzeit ermitteln

				$BuildOneElementTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element); //benötigte Bauzeit ermitteln
				//aktuell verfügbar
				$baubar= GetMaxConstructibleShips($CurrentPlanet, $Element);
				$ElementCount        = $CurrentPlanet[$resource[$Element]];
				$ElementNbre         = ($ElementCount == 0) ? "($lang[builtable]$baubar)" : " (".$lang['dispo'].": " . pretty_number($ElementCount) . " $lang[builtable] $baubar)";
				
				$PageTable .= "\n<tr>\n";
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
					
					<a href=\"javascript:void(0);\" onmouseover=\"return overlib('";
					//$PageTable .= ShowTechs ($user, $planetrow, $Element);
					
					$PageTable .= "', BGCOLOR, 'red', FGCOLOR, '#000000', TEXTCOLOR, 'white', WIDTH, '120');\" onmouseout=\"return nd();\">".$lang['TechnicalData']."</a>
					
					
        			<td class=\"linksohneborder\" width=\"100\">
        			<p align=\"center\"><br>&nbsp;<br><a href=\"javascript:setL(".$Element.");\"><img src=\"images/back.gif\" width=\"17\" style=\"vertical-align:bottom\" border=\"0\" height=\"15\" alt=\"back\"></a><input name=\"fmenge[".$Element."]\" size=\"5\" maxlength=\"5\" style=\"text-align: center;\" value=\"0\" onClick=\"if(this.value=='0') this.value='';\" onBlur=\"if(this.value=='') this.value='0';\" type=\"text\" tabindex=\"".$TabIndex."\"><a href=\"javascript:setN(".$Element.");\"><img src=\"images/forward.gif\" width=\"17\" style=\"vertical-align:bottom\" border=\"0\" height=\"15\" alt=\"forward\"></a><br>&nbsp;<br><a href=\"javascript:setMax(".$Element.",".$baubar.")\">max</a>
                	</p>
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
				$PageTable .= "</tr>";
			}
		}
	}

	if ($CurrentPlanet['b_hangar_id'] != '') {
		$BuildQueue .= ElementBuildListBox( $CurrentUser, $CurrentPlanet );
	}

	$parse = $lang;
	//die HTML Seite lieht nun in $PageTable
	$parse['buildlist']    = $PageTable;
	// Und die Liste der noch laufenden Elemente liegt in $BuildQueue;
	$parse['buildinglist'] = $BuildQueue;
	$page .= parsetemplate(gettemplate('buildings_fleet'), $parse);

	display($page, $lang['Fleet']);
}
// Version History
// - 1.0 Modularisation
// - 1.1 Correction mise en place d'une limite max d'elements constructibles par ligne
//
?>