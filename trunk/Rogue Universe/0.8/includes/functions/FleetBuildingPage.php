<?php

function FleetBuildingPage ( &$CurrentPlanet, $CurrentUser ) {
 	global $planetrow, $lang, $pricelist, $resource, $phpEx, $dpath, $_POST;
	
	if(isset($_GET[action])){
		switch($_GET[action]){
			case "cancelqueue":
					
					$ElementQueue = explode(';', $CurrentPlanet['b_hangar_id']);
					foreach($ElementQueue as $ElementLine => $Element) {
						if ($Element != '') {
							$Element = explode(',', $Element);
							$ResourcesToUpd[metal] += floor($pricelist[$Element[0]][metal] * $Element[1]);
							$ResourcesToUpd[crystal] += floor($pricelist[$Element[0]][crystal] * $Element[1]);
							$ResourcesToUpd[deuterium] += floor($pricelist[$Element[0]][deuterium] * $Element[1]);
						}
					}
					
					$SetRes = "UPDATE {{table}} SET ";
					$SetRes .= "`metal` = metal + '" . $ResourcesToUpd[metal] . "', ";
					$SetRes .= "`crystal` = crystal + '" . $ResourcesToUpd[crystal] . "', ";
					$SetRes .= "`deuterium` = deuterium + '" . $ResourcesToUpd[deuterium] . "', ";
					$SetRes .= "`b_hangar` = '', ";
					$SetRes .= "`b_hangar_id` = ''";
					$SetRes .= " WHERE `id` = '" . $CurrentPlanet['id'] . "'";
					doquery($SetRes, 'planets');
					
					header("location: " . $_SERVER['PHP_SELF'] . "?mode=" . $_GET[mode]);
					exit;
				
				break;
		}
	}
	
	if (isset($_POST['fmenge'])) {

		$AddedInQueue = false;
		foreach($_POST['fmenge'] as $Element => $Count) {
			$Element = intval($Element);
			$Count   = intval($Count);
			if ($Count > MAX_FLEET_OR_DEFS_PER_ROW) {
				$Count = MAX_FLEET_OR_DEFS_PER_ROW;
			}

			if ($Count != 0) {

				if ( IsTechnologieAccessible ($CurrentUser, $CurrentPlanet, $Element) ) {

					$MaxElements   = GetMaxConstructibleElements ( $Element, $CurrentPlanet );

        if ($Count > $MaxElements) {
                          $Count = $MaxElements;
                       }
                       $Ressource = GetElementRessources ( $Element, $Count );
                       $BuildTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
                       if ($Count >= 1) {
        $CurrentPlanet['metal']         -= $Ressource['metal'];
        $CurrentPlanet['crystal']       -= $Ressource['crystal'];
        $CurrentPlanet['deuterium']     -= $Ressource['deuterium'];
        if ($Element == 214 && $CurrentUser['rpg_destructeur'] == 1) {
          $Count = 2 * $Count;
        }
        $CurrentPlanet['b_hangar_id']   .= "". $Element .",". $Count .";";
        }
                    }
                 }
              }
           }

	if ($CurrentPlanet[$resource[21]] == 0) {
		message($lang['need_hangar'], $lang['tech'][21]);
	}

	$TabIndex = 0;
	foreach($lang['tech'] as $Element => $ElementName) {
		if ($Element > 201 && $Element <= 399) {
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
					$TabIndex++;
					$PageTable .= "<input type=text name=fmenge[".$Element."] alt='".$lang['tech'][$Element]."' size=5 maxlength=5 value=0 tabindex=".$TabIndex.">";
				}
				$PageTable .= "</th>";

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
	$page .= parsetemplate(gettemplate('buildings_fleet'), $parse);

	display($page, $lang['Fleet']);
}


?>