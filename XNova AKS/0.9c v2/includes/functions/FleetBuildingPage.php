<?php

/**
 * FleetBuildingPage.php
 *
 * @version 1.1
 * @copyright 2008 By Chlorel for XNova
 */

// Page de Construction d'Elements de Flotte
// $CurrentPlanet -> Planete sur laquelle la construction est lancée
//                   Parametre passé par adresse, cela permet de mettre les valeurs a jours
//                   dans le programme appelant
// $CurrentUser   -> Utilisateur qui a lancé la construction
//
function FleetBuildingPage ( &$CurrentPlanet, $CurrentUser ) {
 	global $lang, $resource, $phpEx, $dpath, $_POST;

	if (isset($_POST['fmenge'])) {
		// On vient de Cliquer ' Construire '
		// Et y a une liste de dol&eacute;ances
		$AddedInQueue                     = false;
		// Ici, on sait precisement ce qu'on aimerait bien construire ...
		foreach($_POST['fmenge'] as $Element => $Count) {
// Construction d'Element recuperés sur la page de Flotte ...
            // ATTENTION ! La file d'attente Flotte est Commune a celle des Defenses
            // Dans fmenge, on devrait trouver un tableau des elements constructibles et du nombre d'elements souhaités

            $Element = floatval($Element);
            $Count   = floatval($Count);
            if ($Count > MAX_FLEET_OR_DEFS_PER_ROW) {
                $Count = MAX_FLEET_OR_DEFS_PER_ROW;
            }

			if ($Count != 0) {
				// On verifie si on a les technologies necessaires a la construction de l'element
				if ( IsTechnologieAccessible ($CurrentUser, $CurrentPlanet, $Element) ) {
					// On verifie combien on sait faire de cet element au max
					$MaxElements   = GetMaxConstructibleElements ( $Element, $CurrentPlanet );
					// Si pas assez de ressources, on ajuste le nombre d'elements
					if ($Count > $MaxElements) {
						$Count = $MaxElements;
					}
					$Ressource = GetElementRessources ( $Element, $Count );
					$BuildTime = GetBuildingTime($CurrentUser, $CurrentPlanet, $Element);
                   if ($Count >= 1) {
                      if ($BuildTime > 0) {
                      $CurrentPlanet['metal']           -= $Ressource['metal'];
                      $CurrentPlanet['crystal']         -= $Ressource['crystal'];
                      $CurrentPlanet['deuterium']       -= $Ressource['deuterium'];
					  if($Element == 214) {                        
                        $requete = doquery("SELECT rpg_destructeur FROM {{table}} WHERE id = ". $CurrentUser['id'] .";", 'users', true);
                      if($requete['rpg_destructeur'] == 1) { 
                        $Count = 2 * $Count; 
                            }
                        } 
                      $CurrentPlanet['b_hangar_id']     .= "". $Element .",". $Count .";";
                   } else {
                      $CurrentPlanet['metal'] -= $Ressource['metal'];
                      $CurrentPlanet['crystal'] -= $Ressource['crystal'];
                      $CurrentPlanet['deuterium'] -= $Ressource['deuterium'];
					 if($Element == 214) {                       
                      $requete = doquery("SELECT rpg_destructeur FROM {{table}} WHERE id = ". $CurrentUser['id'] .";", 'users', true);
                     if($requete['rpg_destructeur'] == 1) { 
                      $Count = 2 * $Count; 
                            }
                        } 
                      $NewFleetNumber = $CurrentPlanet[$resource[$Element]] + $Count;
                      $QryUpdatefleet = "UPDATE {{table}} SET ";
                      $QryUpdatefleet .= "`$resource[$Element]` = '" . $NewFleetNumber ."' ";
                      $QryUpdatefleet .= "WHERE ";
                      $QryUpdatefleet .= "`id` = '". $CurrentPlanet['id'] ."'";
                      doquery ( $QryUpdatefleet, 'planets');
                     }					 					
                  }
				}
			}
		}
	}

	// -------------------------------------------------------------------------------------------------------
	// S'il n'y a pas de Chantier ...
	if ($CurrentPlanet[$resource[21]] == 0) {
		// Veuillez avoir l'obligeance de construire le Chantier Spacial !!
		message($lang['need_hangar'], $lang['tech'][21]);
	}

	// -------------------------------------------------------------------------------------------------------
	// Construction de la page du Chantier (car si j'arrive ici ... c'est que j'ai tout ce qu'il faut pour ...
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
				$PageTable .= "</td>";

				// Case nombre d'elements a construire
				$PageTable .= "<th class=k>";
				// Si ... Et Seulement si je peux construire je mets la p'tite zone de saisie
				if ($CanBuildOne) {
					$TabIndex++;					
				    $PageTable .= "<input type=text name=fmenge[".$Element."] alt='".$lang['tech'][$Element]."' size=12 maxlength=12 value=0 tabindex=".$TabIndex.">";
				$maxElement = GetMaxConstructibleElements($Element, $CurrentPlanet);
                if ($maxElement > MAX_FLEET_OR_DEFS_PER_ROW) $maxElement = MAX_FLEET_OR_DEFS_PER_ROW; 
                $PageTable .= "<br><a href='javascript:' onclick=\"document.getElementsByName('fmenge[".$Element."]')[0].value = '$maxElement';\">(Max : {$maxElement})</a>"; 
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
// - Fix Destructeur
// - Fix Abbruch Fehler bei größeren Fleetmengen
?>