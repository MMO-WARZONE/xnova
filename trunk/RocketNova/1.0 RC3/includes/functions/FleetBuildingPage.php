<?php

function FleetBuildingPage ( &$CurrentPlanet, $CurrentUser ) {
 	global $lang, $resource, $phpEx, $dpath, $_POST;
	
 	if($CurrentUser['urlaubs_modus'] == 0) {
	if(isset($_GET['cmd'])&& $_GET['cmd']=='dellast'){
	$previousqueue=$CurrentPlanet['b_hangar_id'];
	$previousqueue=preg_split('#\;#',$previousqueue);
	for($i=0;$i<count($previousqueue)-2;$i++){
	$newqueue.=$previousqueue[$i].';';
	}

	$cancelledship=preg_split('#\,#',$previousqueue[count($previousqueue)-2]);
	$Ressreturn = GetElementRessources ( $cancelledship[0], $cancelledship[1] );
		$CurrentPlanet['metal']          += $Ressreturn['metal'];
		$CurrentPlanet['crystal']        += $Ressreturn['crystal'];
		$CurrentPlanet['deuterium']      += $Ressreturn['deuterium'];
		$CurrentPlanet['b_hangar_id']    = $newqueue;
	}
	if (isset($_POST['fmenge'])) {
		// Es wurde 'Bauen' geklickt
		// Und hat auch eine Liste von [?]
		$AddedInQueue = false;
		// Gut, hier weiss man was und wieviel gebaut werden soll.
		foreach($_POST['fmenge'] as $Element => $Count) {
			// Bau der Flotte auf der Flottenseite
			// ACHTUNG ! Die Warteschlange der Flotte und Verteidigung werden zusammen verarbeitet.
			// In fmenge, sollte man eine Tabelle der Elemente Baugrundstücke und der Anzahl der Elemente haben

			$Element = intval($Element);
			$Count   = intval($Count);
			if ($Count > MAX_FLEET_OR_DEFS_PER_ROW) {
				$Count = MAX_FLEET_OR_DEFS_PER_ROW;
			}

			if ($Count != 0) {
				// Verified, wenn man die notwendige Technologie hat für den Bau des aktuellen Elements
				if ( IsTechnologieAccessible ($CurrentUser, $CurrentPlanet, $Element) ) {
					// Verified, hole maximal mögliche Anzahl
					$MaxElements   = GetMaxConstructibleElements ( $Element, $CurrentPlanet );
					// Wenn nicht genügend Ressourcen vorhanden sind, wird eine Anpassung der Anzahl der Elemente vorgenommen
					if ($Count > $MaxElements) {
						$Count = $MaxElements;
					}
					$Ressource = GetElementRessources ( $Element, $Count );
					$BuildTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
					if ($Count >= 1) {
						$CurrentPlanet['metal']          -= $Ressource['metal'];
						$CurrentPlanet['crystal']        -= $Ressource['crystal'];
						$CurrentPlanet['deuterium']      -= $Ressource['deuterium'];
						 if ($Element == 214 && $CurrentUser['rpg_destructeur'] == 1) {
						  $Count = 2 * $Count;
						 }
						 $CurrentPlanet['b_hangar_id']	.= "". $Element .",". $Count .";";
						
					}
				}
			}
			
			if (($CurrentUser['rpg_destructeur'] > 0) && ($Element == 214)) { $Count += $Count; }
		}
	}
 	}

	// -------------------------------------------------------------------------------------------------------
	// Wenn nix gebaut wird / werden kann
	if ($CurrentPlanet[$resource[21]] == 0) {
		// Veuillez avoir l'obligeance de construire le Chantier Spacial !!
		message($lang['need_hangar'], $lang['tech'][21]);
	}

	// -------------------------------------------------------------------------------------------------------
	// Bau der Seite der Baustelle (denn wenn ich hier ... ist, dass ich alles, was Sie brauchen, um ...
	$TabIndex = 0;
	foreach($lang['tech'] as $Element => $ElementName) {
		if ($Element > 201 && $Element <= 399) {
			if (IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Element)) {
				// Disponible à la construction

				// On regarde si on peut en acheter au moins 1
				$CanBuildOne         = IsElementBuyable($CurrentUser, $CurrentPlanet, $Element, false);
				// On regarde combien de temps il faut pour construire l'element
				$BuildOneElementTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
				// Disponibilité actuelle
				$ElementCount        = $CurrentPlanet[$resource[$Element]];
				$ElementNbre         = ($ElementCount == 0) ? "" : " (".$lang['dispo'].": " . pretty_number($ElementCount) . ")";

				// Construction des 3 cases de la ligne d'un element dans la page d'achat !
				// Début de ligne
				$PageTable .= "\n<tr>";

				// Imagette + Link vers la page d'info
				$PageTable .= "<th class=l>";
				$PageTable .= "<a href=infos.".$phpEx."?gid=".$Element.">";
				$PageTable .= "<img border=0 src=\"".$dpath."gebaeude/".$Element.".gif\" align=top width=120 height=120></a>";
				$PageTable .= "</th>";

				// Description
				$PageTable .= "<td class=l>";
				$PageTable .= "<a href=infos.".$phpEx."?gid=".$Element.">".$ElementName."</a> ".$ElementNbre."<br>";
				$PageTable .= "".$lang['res']['descriptions'][$Element]."<br>";
				// On affiche le 'prix' avec eventuellement ce qui manque en ressource
				$PageTable .= GetElementPrice($CurrentUser, $CurrentPlanet, $Element, false);
// On affiche le temps de construction (c'est toujours tellement plus joli)
$PageTable .= ShowBuildTime($BuildOneElementTime);
$baubar= GetMaxConstructibleShips($CurrentPlanet, $Element);
$PageTable .= "<br><br>Baubare Schiffe: ".$baubar;
$PageTable .= "</td>";

				// Case nombre d'elements a construire
				$PageTable .= "<th class=k>";
				// Si ... Et Seulement si je peux construire je mets la p'tite zone de saisie
				if ($CanBuildOne) {
					$TabIndex++;
					$PageTable .= "<input type=text name=fmenge[".$Element."] alt='".$lang['tech'][$Element]."' size=5 maxlength=8 value=0 tabindex=".$TabIndex.">";
				}
				$PageTable .= "</th>";

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
	$page .= parsetemplate(gettemplate('buildings_fleet'), $parse);

	display($page, $lang['Fleet']);
}
// Version History
// - 1.0 Modularisation
// - 1.1 Correction mise en place d'une limite max d'elements constructibles par ligne
//
?>