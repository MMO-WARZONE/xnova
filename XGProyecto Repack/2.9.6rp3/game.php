<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from xgproyect.net      	 #
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
include($xgp_root . 'includes/functions/IsElementBuyable.' . $phpEx);
include($xgp_root . 'includes/functions/SetNextQueueElementOnTop.' . $phpEx);
include($xgp_root . 'includes/functions/SortUserPlanets.' . $phpEx);
include($xgp_root . 'includes/functions/UpdatePlanetBatimentQueueList.' . $phpEx);

//Espacio para BOTS
include_once($xgp_root . 'includes/newbot.class.'.$phpEx);
$BotString = '<table>';
UpdateNewBots();
$BotString .= '</table>';

switch($_GET[page])
{
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'tutorial':
		include_once($xgp_root . 'includes/pages/ShowTutorialPage.' . $phpEx);
		ShowTutorialPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'changelog':
		include_once($xgp_root . 'includes/pages/ShowChangelogPage.' . $phpEx);
		ShowChangelogPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
    case'records':
        include_once($xgp_root . 'includes/pages/ShowRecordsPage.' . $phpEx);
        ShowRecordsPage($user);
    break; 
// ----------------------------------------------------------------------------------------------------------------------------------------------//
    case'topkb':
        include_once($xgp_root . 'includes/pages/ShowTopKBPage.' . $phpEx);
        ShowTopKBPage();
    break;  
// ----------------------------------------------------------------------------------------------------------------------------------------------//
    case'pointsimulator':
        include_once($xgp_root . 'includes/pages/ShowPointSimulator.' . $phpEx);
        ShowChangelogPage();
    break;  
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'overview':
		include_once($xgp_root . 'includes/pages/ShowOverviewPage.' . $phpEx);
		ShowOverviewPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'galaxy':
		include_once($xgp_root . 'includes/pages/class.ShowGalaxyPage.' . $phpEx);
		$ShowGalaxyPage = new ShowGalaxyPage($user, $planetrow);
	break;
	case'phalanx':
		include_once($xgp_root . 'includes/pages/ShowPhalanxPage.' . $phpEx);
		ShowPhalanxPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'imperium':
		include_once($xgp_root . 'includes/pages/ShowImperiumPage.' . $phpEx);
		include_once($xgp_root . 'includes/pages/class.ShowBuildingsPage.' . $phpEx);
		ShowImperiumPage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'fleet':
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
		if(defined("UGAPAY_ACTIVATED") and UGAPAY_ACTIVATED == true){
			include_once($xgp_root . 'includes/payapi.php');
			$PaySystem = new UgamelaplayPay(UGAPAY_PRIVATE_KEY, UGAPAY_PRIVATE_KEY, $user['id'], 'xg'); //GAME_TYPES: xr => XNova Redesigned; xg => XG Proyect
			if($_GET['redir'] == "1"){
				$PaySystem->RedirToPaySystem();
			}
			if($_GET['code'] != ""){
				$Message = $PaySystem->Comprobate($_GET['code']);
				message($Message,'game.php?page=officier');			
			}
		}
		
		include_once($xgp_root . 'includes/pages/class.ShowOfficierPage.' . $phpEx);
		new ShowOfficierPage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'trader':
		include_once($xgp_root . 'includes/pages/ShowTraderPage.' . $phpEx);
		ShowTraderPage($user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'techtree':
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
		include_once($xgp_root . 'includes/pages/ShowMessagesPage.' . $phpEx);
		ShowMessagesPage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'alliance':
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
		include_once($xgp_root . 'includes/pages/ShowStatisticsPage.' . $phpEx);
		ShowStatisticsPage($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'search':
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
		include_once($xgp_root . 'includes/pages/ShowBannedPage.' . $phpEx);
		ShowBannedPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'logout':
		setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);
		message($lang['see_you_soon'], $xgp_root, 1, false, false);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	default:
		die(message($lang['page_doesnt_exist']));
// ----------------------------------------------------------------------------------------------------------------------------------------------//
}
?>
