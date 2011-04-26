<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

define('INSIDE'  , true);
define('INSTALL' , false);

$xgp_root = './';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

include($xgp_root . 'includes/functions/CheckPlanetBuildingQueue.' . $phpEx);
include($xgp_root . 'includes/functions/GetBuildingPrice.' . $phpEx);
include($xgp_root . 'includes/functions/GetBuildingTime.' . $phpEx);
include($xgp_root . 'includes/functions/HandleElementBuildingQueue.' . $phpEx);
include($xgp_root . 'includes/functions/IsElementBuyable.' . $phpEx);
include($xgp_root . 'includes/functions/PlanetResourceUpdate.' . $phpEx);
include($xgp_root . 'includes/functions/SetNextQueueElementOnTop.' . $phpEx);
include($xgp_root . 'includes/functions/SortUserPlanets.' . $phpEx);
include($xgp_root . 'includes/functions/UpdatePlanetBatimentQueueList.' . $phpEx);

switch($_GET[page])
{
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'changelog':
		include_once($xgp_root . 'includes/pages/ShowChangelogPage.' . $phpEx);
		ShowChangelogPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'overview':
		include_once($xgp_root . 'includes/pages/ShowOverviewPage.' . $phpEx);
		ShowOverviewPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'galaxy':

		$query = doquery("SELECT estado FROM {{table}} where modulo='Galaxie'", 'modulos', true);
		if($query[0] == "0") { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/pages/class.ShowGalaxyPage.' . $phpEx);
		$ShowGalaxyPage = new ShowGalaxyPage($user, $planetrow);
	break;
	case'phalanx':
		include_once($xgp_root . 'includes/pages/ShowPhalanxPage.' . $phpEx);
		ShowPhalanxPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'imperium':

		$query = doquery("SELECT estado FROM {{table}} where modulo='Imperium'", 'modulos', true);
		if($query[0] == "0") { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/pages/ShowImperiumPage.' . $phpEx);
		ShowImperiumPage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'fleet':

		$query = doquery("SELECT estado FROM {{table}} where modulo='Flotte'", 'modulos', true);
		if($query[0] == "0") { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/pages/ShowFleetPage.' . $phpEx);
		ShowFleetPage($user, $planetrow);
	break;
	case'fleet1':
		include_once($xgp_root . 'includes/pages/ShowFleet1Page.' . $phpEx);
		ShowFleet1Page($user, $planetrow);
	break;
	case'fleet2':
		include_once($xgp_root . 'includes/pages/ShowFleet2Page.' . $phpEx);
		ShowFleet2Page($user, $planetrow);
	break;
	case'fleet3':
		include_once($xgp_root . 'includes/pages/ShowFleet3Page.' . $phpEx);
		ShowFleet3Page($user, $planetrow);
	break;
	case'fleetACS':
		include_once($xgp_root . 'includes/pages/ShowFleetACSPage.' . $phpEx);
		ShowFleetACSPage($user, $planetrow);
	break;
	case'shortcuts':
		include_once($xgp_root . 'includes/pages/ShowFleetShortcuts.' . $phpEx);
		ShowFleetShortcuts($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'buildings':

		$query = doquery("SELECT estado FROM {{table}} where modulo='Bauen'", 'modulos', true);
		if($query[0] == "0") { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/functions/HandleTechnologieBuild.' . $phpEx);
		UpdatePlanetBatimentQueueList ($planetrow, $user);
		$IsWorking = HandleTechnologieBuild($planetrow, $user);
		switch ($_GET['mode'])
		{
			case 'research':
				include_once($xgp_root . 'includes/pages/class.ShowResearchPage.' . $phpEx);
				new ShowResearchPage($planetrow, $user, $IsWorking['OnWork'], $IsWorking['WorkOn']);
			break;
			case 'fleet':
				include_once($xgp_root . 'includes/pages/class.ShowShipyardPage.' . $phpEx);
				$FleetBuildingPage = new ShowShipyardPage();
				$FleetBuildingPage->FleetBuildingPage ($planetrow, $user);
			break;
			case 'defense':
				include_once($xgp_root . 'includes/pages/class.ShowShipyardPage.' . $phpEx);
				$DefensesBuildingPage = new ShowShipyardPage();
				$DefensesBuildingPage->DefensesBuildingPage ($planetrow, $user);
			break;
			default:
				include_once($xgp_root . 'includes/pages/class.ShowBuildingsPage.' . $phpEx);
				new ShowBuildingsPage($planetrow, $user);
			break;
		}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'resources':
		include_once($xgp_root . 'includes/pages/ShowResourcesPage.' . $phpEx);
		ShowResourcesPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'officier':

		$query = doquery("SELECT estado FROM {{table}} where modulo='Offiziere'", 'modulos', true);
		if($query[0] == "0") { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/pages/class.ShowOfficierPage.' . $phpEx);
		new ShowOfficierPage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'trader':

		$query = doquery("SELECT estado FROM {{table}} where modulo='Trader'", 'modulos', true);
		if($query[0] == "0") { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/pages/ShowTraderPage.' . $phpEx);
		ShowTraderPage($planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'techtree':

		$query = doquery("SELECT estado FROM {{table}} where modulo='Techtree'", 'modulos', true);
		if($query[0] == "0") { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/pages/ShowTechTreePage.' . $phpEx);
		ShowTechTreePage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'infos':
		include_once($xgp_root . 'includes/pages/class.ShowInfosPage.' . $phpEx);
		new ShowInfosPage($user, $planetrow, $_GET['gid']);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'messages':

		$query = doquery("SELECT estado FROM {{table}} where modulo='Nachrichten'", 'modulos', true);
		if($query[0] == "0") { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/pages/ShowMessagesPage.' . $phpEx);
		ShowMessagesPage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'alliance':

		$query = doquery("SELECT estado FROM {{table}} where modulo='Allianz'", 'modulos', true);
		if($query[0] == "0") { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/pages/class.ShowAlliancePage.' . $phpEx);
		new ShowAlliancePage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'buddy':
		include_once($xgp_root . 'includes/pages/ShowBuddyPage.' . $phpEx);
		ShowBuddyPage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'notes':
		include_once($xgp_root . 'includes/pages/ShowNotesPage.' . $phpEx);
		ShowNotesPage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'statistics':

		$query = doquery("SELECT estado FROM {{table}} where modulo='Statistiken'", 'modulos', true);
		if($query[0] == "0") { message("Modul inaktiv.","game.php?page=overview"); }
 
		include_once($xgp_root . 'includes/pages/ShowStatisticsPage.' . $phpEx);
		ShowStatisticsPage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'search':

		$query = doquery("SELECT estado FROM {{table}} where modulo='Suche'", 'modulos', true);
		if($query[0] == "0") { message("Modul inaktiv.","game.php?page=overview"); }

		include_once($xgp_root . 'includes/pages/ShowSearchPage.' . $phpEx);
		ShowSearchPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'options':
		include_once($xgp_root . 'includes/pages/class.ShowOptionsPage.' . $phpEx);
		new ShowOptionsPage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'banned':

		$query = doquery("SELECT estado FROM {{table}} where modulo='Pranger'", 'modulos', true);
		if($query[0] == "0") { message("Modul inaktiv.","game.php?page=overview"); }

		include_once($xgp_root . 'includes/pages/ShowBannedPage.' . $phpEx);
		ShowBannedPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'topkb':
		include_once($xgp_root . 'includes/pages/ShowTopKB.' . $phpEx);
		ShowTopKB();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'records':
	

		$query = doquery("SELECT estado FROM {{table}} where modulo='Rekorde'", 'modulos', true);
		if($query[0] == "0") { message("Modul inaktiv.","game.php?page=overview"); }


		include_once($xgp_root . 'includes/pages/ShowRecordsPage.' . $phpEx);
		ShowRecordsPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'chat':
	

		$query = doquery("SELECT estado FROM {{table}} where modulo='Chat'", 'modulos', true);
		if($query[0] == "0") { message("Modul inaktiv.","game.php?page=overview"); }


		include_once($xgp_root . 'includes/pages/ShowChatPage.' . $phpEx);
		ShowChatPage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
    case'support':
	

		$query = doquery("SELECT estado FROM {{table}} where modulo='Support'", 'modulos', true);
		if($query[0] == "0") { message("Modul inaktiv.","game.php?page=overview"); }


		include_once($xnova_root . 'includes/pages/ShowSupportPage.' . $phpEx);
        ShowSupportPage($user);
    break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//	
    case'loteria':
        include_once($xgp_root . 'includes/pages/ShowLoteriaPage.' . $phpEx);
        Loteria($CurrentUser, $CurrentPlanet);
    break; 
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'logout':
		$QryUpdateUser    = "UPDATE {{table}} SET ";
		$QryUpdateUser   .= "`current_planet` = `id_planet` ";
		$QryUpdateUser   .= "WHERE ";
		$QryUpdateUser   .= "`id` = '". $user['id'] ."' LIMIT 1";
		doquery( $QryUpdateUser, "users");
		setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);
		$parse['dpath'] = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
		$page = parsetemplate(gettemplate('logout_body'), $parse);		
		echo $page;
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	default:
		die(message($lang['page_doesnt_exist']));
// ----------------------------------------------------------------------------------------------------------------------------------------------//
}
?>