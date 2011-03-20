<?php

function ResearchBuildingPage (&$CurrentPlanet, $CurrentUser, $InResearch, $ThePlanet) {
	global $lang, $resource, $reslist, $phpEx, $dpath, $game_config, $_GET;


	$NoResearchMessage = "";
	$bContinue         = true;

	if ($CurrentPlanet[$resource[31]] == 0) {
		message($lang['no_laboratory'], $lang['Research']);
	}

	if (!CheckLabSettingsInQueue ( $CurrentPlanet )) {
		$NoResearchMessage = $lang['labo_on_update'];
		$bContinue         = false;
	}


	if (isset($_GET['cmd'])) {
		$TheCommand = $_GET['cmd'];
		$Techno     = intval($_GET['tech']);
		if ( is_numeric($Techno) ) {
			if ( in_array($Techno, $reslist['tech']) ) {

				if ( is_array ($ThePlanet) ) {
					$WorkingPlanet = $ThePlanet;
				} else {
					$WorkingPlanet = $CurrentPlanet;
				}
				switch($TheCommand){
					case 'cancel':
						if ($ThePlanet['b_tech_id'] == $Techno) {		
							$Needed                        = GetBuildingPrice ($CurrentUser, $CurrentPlanet, $Techno, true, $ForDestroy);
							$CurrentPlanet['metal']       += $Needed['metal'];
							$CurrentPlanet['crystal']     += $Needed['crystal'];
							$CurrentPlanet['deuterium']   += $Needed['deuterium'];
							$WorkingPlanet['b_tech_id']   = 0;
							$WorkingPlanet["b_tech"]      = 0;
							$CurrentUser['b_tech_planet'] = 0;
							$UpdateData                   = true;
							$InResearch                   = false;
							
							
						}
						break;
					case 'search':
						if ( IsTechnologieAccessible($CurrentUser, $WorkingPlanet, $Techno) &&
							 IsElementBuyable($CurrentUser, $WorkingPlanet, $Techno) ) {
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
				if ($UpdateData == true) {
					$QryUpdatePlanet  = "UPDATE {{table}} SET ";
					$QryUpdatePlanet .= "`b_tech_id` = '".   $WorkingPlanet['b_tech_id']   ."', ";
					$QryUpdatePlanet .= "`b_tech` = '".      $WorkingPlanet['b_tech']      ."', ";
					$QryUpdatePlanet .= "`metal` = '".       $WorkingPlanet['metal']       ."', ";
					$QryUpdatePlanet .= "`crystal` = '".     $WorkingPlanet['crystal']     ."', ";
					$QryUpdatePlanet .= "`deuterium` = '".   $WorkingPlanet['deuterium']   ."' ";
					$QryUpdatePlanet .= "WHERE ";
					$QryUpdatePlanet .= "`id` = '".          $WorkingPlanet['id']          ."';";
					doquery( $QryUpdatePlanet, 'planets');

					$QryUpdateUser  = "UPDATE {{table}} SET ";
					$QryUpdateUser .= "`b_tech_planet` = '". $CurrentUser['b_tech_planet'] ."' ";
					$QryUpdateUser .= "WHERE ";
					$QryUpdateUser .= "`id` = '".            $CurrentUser['id']            ."';";
					doquery( $QryUpdateUser, 'users');
				}
				if ( is_array ($ThePlanet) ) {
					$ThePlanet     = $WorkingPlanet;
				} else {
					$CurrentPlanet = $WorkingPlanet;
					if ($TheCommand == 'search') {
						$ThePlanet = $CurrentPlanet;
					}
				}
			}
		} else {
			$bContinue = false;
		}
	}

	$TechRowTPL = gettemplate('buildings_research_row');
	$TechScrTPL = gettemplate('buildings_research_script');

	foreach($lang['tech'] as $Tech => $TechName) {
		if ($Tech > 105 && $Tech <= 199) {
			if ( IsTechnologieAccessible($CurrentUser, $CurrentPlanet, $Tech)) {
				$RowParse                = $lang;
				$RowParse['dpath']       = $dpath;
				$RowParse['tech_id']     = $Tech;
				$building_level          = $CurrentUser[$resource[$Tech]];
				$RowParse['tech_level']  = ($building_level == 0) ? "" : "( ". $lang['level']. " ".$building_level." )";
				$RowParse['tech_name']   = $TechName;
				$RowParse['tech_descr']  = $lang['res']['descriptions'][$Tech];
				$RowParse['tech_price']  = GetElementPrice($CurrentUser, $CurrentPlanet, $Tech);
				$SearchTime              = GetBuildingTime($CurrentUser, $CurrentPlanet, $Tech);
				$RowParse['search_time'] = ShowBuildTime($SearchTime);
				$RowParse['tech_restp']  = $lang['Rest_ress'] ." ". GetRestPrice ($CurrentUser, $CurrentPlanet, $Tech, true);
				$CanBeDone               = IsElementBuyable($CurrentUser, $CurrentPlanet, $Tech);

				if (!$InResearch) {
					$LevelToDo = 1 + $CurrentUser[$resource[$Tech]];
					if ($CanBeDone) {
						if (!CheckLabSettingsInQueue ( $CurrentPlanet )) {

							if ($LevelToDo == 1) {
								$TechnoLink  = "<font color=#FF0000>". $lang['Rechercher'] ."</font>";
							} else {
								$TechnoLink  = "<font color=#FF0000>". $lang['Rechercher'] ."<br>".$lang['level']." ".$LevelToDo."</font>";
							}
						} else {
							$TechnoLink  = "<a href=\"buildings.php?mode=research&cmd=search&tech=".$Tech."\">";
							if ($LevelToDo == 1) {
								$TechnoLink .= "<font color=#00FF00>". $lang['Rechercher'] ."</font>";
							} else {
								$TechnoLink .= "<font color=#00FF00>". $lang['Rechercher'] ."<br>".$lang['level']." ".$LevelToDo."</font>";
							}
							$TechnoLink  .= "</a>";
						}
					} else {
						if ($LevelToDo == 1) {
							$TechnoLink  = "<font color=#FF0000>". $lang['Rechercher'] ."</font>";
						} else {
							$TechnoLink  = "<font color=#FF0000>". $lang['Rechercher'] ."<br>".$lang['level']." ".$LevelToDo."</font>";
						}
					}

				} else {

					if ($ThePlanet["b_tech_id"] == $Tech) {

						$bloc       = $lang;
						if ($ThePlanet['id'] != $CurrentPlanet['id']) {
							$bloc['tech_time']  = $ThePlanet["b_tech"] - time();
							$bloc['tech_name']  = $lang['on'] ."<br>". $ThePlanet["name"];
							$bloc['tech_home']  = $ThePlanet["id"];
							$bloc['tech_id']    = $ThePlanet["b_tech_id"];
						} else {
							$bloc['tech_time']  = $CurrentPlanet["b_tech"] - time();
							$bloc['tech_name']  = "";
							$bloc['tech_home']  = $CurrentPlanet["id"];
							$bloc['tech_id']    = $CurrentPlanet["b_tech_id"];
						}
						$TechnoLink  = parsetemplate($TechScrTPL, $bloc);
					} else {

					$TechnoLink  = "<center>-</center>";
					}
				}
				$RowParse['tech_link']  = $TechnoLink;
				$TechnoList            .= parsetemplate($TechRowTPL, $RowParse);
			}
		}
	}

	$PageParse                = $lang;
	$PageParse['noresearch']  = $NoResearchMessage;
	$PageParse['technolist']  = $TechnoList;
	$Page                    .= parsetemplate(gettemplate('buildings_research'), $PageParse);

	display( $Page, $lang['Research'] );
}

?>
