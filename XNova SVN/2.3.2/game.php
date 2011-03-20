<?php
//version 1.2


define('INSIDE'  , true);
define('INSTALL' , false);

$svn_root = './';
$InLogin  = false;
include($svn_root . 'extension.inc.php');
include($svn_root . 'common.' . $phpEx);


include($svn_root . 'includes/functions/CheckPlanetBuildingQueue.' . $phpEx);
include($svn_root . 'includes/functions/GetBuildingPrice.' . $phpEx);
include($svn_root . 'includes/functions/GetBuildingTime.' . $phpEx);
include($svn_root . 'includes/functions/HandleElementBuildingQueue.' . $phpEx);
include($svn_root . 'includes/functions/IsElementBuyable.' . $phpEx);
include($svn_root . 'includes/functions/PlanetResourceUpdate.' . $phpEx);
include($svn_root . 'includes/functions/SetNextQueueElementOnTop.' . $phpEx);
include($svn_root . 'includes/functions/SortUserPlanets.' . $phpEx);
include($svn_root . 'includes/functions/UpdatePlanetBatimentQueueList.' . $phpEx);

if($users->user["activate_status"]==0 && ($_GET["page"]!="options" && $_GET["page"]!="overview" && $_GET["page"]!="logout" )){
     $parse='<strong  style="position:relative; text-align:center;z-index:10000;color:red">Debes activar tu cuenta si quieres seguir jugando.</strong> <a href="'.$svn_root.'game.php?page=options&mode=activar">Activar tu Cuenta</a>';
     $displays->message($parse,false,true,true);
}

switch($_GET["page"])
{
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'changelog':
                include_once($svn_root . 'includes/pages/ShowChangelogPage.' . $phpEx);
		ShowChangelogPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'overview':
		include_once($svn_root . 'includes/pages/ShowOverviewPage.' . $phpEx);
		ShowOverviewPage($users->user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'galaxy':
		include_once($svn_root . 'includes/pages/class.ShowGalaxyPage.' . $phpEx);
		$ShowGalaxyPage = new ShowGalaxyPages();
		$ShowGalaxyPage->ShowGalaxyPage($users->user,$planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'phalanx':
		include_once($svn_root . 'includes/pages/ShowPhalanxPage.' . $phpEx);
		ShowPhalanxPage($users->user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'imperium':
		include_once($svn_root . 'includes/pages/ShowImperiumPage.' . $phpEx);
		ShowImperiumPage($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'fleet':
		include_once($svn_root . 'includes/pages/ShowFleetPage.' . $phpEx);
		ShowFleetPage($users->user, $planetrow);
	break;
	case'fleet1':
		include_once($svn_root . 'includes/pages/ShowFleet1Page.' . $phpEx);
		ShowFleet1Page($users->user, $planetrow);
	break;
	case'fleet2':
		include_once($svn_root . 'includes/pages/ShowFleet2Page.' . $phpEx);
		ShowFleet2Page($users->user, $planetrow);
	break;
	case'fleet3':
		include_once($svn_root . 'includes/pages/ShowFleet3Page.' . $phpEx);
		ShowFleet3Page($users->user, $planetrow);
	break;
	case'fleetsac':
		include_once($svn_root . 'includes/pages/ShowFleetSacPage.' . $phpEx);
		ShowFleetSacPage($users->user, $planetrow);
	break;
	case'shortcuts':
		include_once($svn_root . 'includes/pages/ShowFleetShortcuts.' . $phpEx);
		ShowFleetShortcuts($users->user);
	break;
	case'fleetback':
		include_once($svn_root . 'includes/pages/ShowFleetBack.' . $phpEx);
		fleetback($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'buildings':
		include_once($svn_root . 'includes/functions/HandleTechnologieBuild.' . $phpEx);
		UpdatePlanetBatimentQueueList ($planetrow, $users->user);
		$IsWorking = HandleTechnologieBuild($planetrow, $users->user);
		switch ($_GET['mode']){
			case 'research':
				include_once($svn_root . 'includes/pages/class.ShowResearchPage.' . $phpEx);
				$Researchpage=new ShowResearchPages();
				$Researchpage->ShowResearchPage($planetrow, $users->user, $IsWorking['OnWork'], $IsWorking['WorkOn']);
			break;
			case 'fleet':
				include_once($svn_root . 'includes/pages/class.ShowBuildFleetPage.' . $phpEx);
				$FleetBuildingPage = new ShowBuildFleetPage();
				$FleetBuildingPage->FleetBuildingPage ($planetrow, $users->user);
			break;
			case 'defense':
				include_once($svn_root . 'includes/pages/class.ShowBuildFleetPage.' . $phpEx);
				$DefensesBuildingPage = new ShowBuildFleetPage();
				$DefensesBuildingPage->DefensesBuildingPage ($planetrow, $users->user);
			break;
			default:
				include_once($svn_root . 'includes/pages/class.ShowBuildingsPage.' . $phpEx);
				$BuildingsPage=new ShowBuildingsPages();
				$BuildingsPage->ShowBuildingsPage($planetrow, $users->user);
			break;
		}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'resources':
		include_once($svn_root . 'includes/pages/ShowResourcesPage.' . $phpEx);
		ShowResourcesPage($users->user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'misiles':
		include_once($svn_root . 'includes/pages/ShowMisilesPage.' . $phpEx);
		ShowMissiles($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'officier':
		include_once($svn_root . 'includes/pages/class.ShowOfficierPage.' . $phpEx);
		$officier=new ShowOfficierPages();
		$officier->ShowOfficierPage($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'marchand':
		include_once($svn_root . 'includes/pages/ShowMarchandPage.' . $phpEx);
		ShowMarchandPage($planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'techtree':
		include_once($svn_root . 'includes/pages/ShowTechTreePage.' . $phpEx);
		ShowTechTreePage($users->user, $planetrow);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'infos':
		if($_GET['gid']){
			include_once($svn_root . 'includes/pages/class.ShowInfosPage.' . $phpEx);
			$infos=new ShowInfosPages();
			$infos->ShowInfosPage($users->user, $planetrow, $_GET['gid']);
		}else{
			die(message($lang['page_doesnt_exist']));
		}
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'banned':
		include_once($svn_root . 'includes/pages/ShowBannedPage.' . $phpEx);
		ShowBannedPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'alliance':
                 
                include_once($svn_root . 'includes/pages/class.ShowAlliancePage.' . $phpEx);
		$alianza= new ShowAlliancesPage();
                               
		$alianza->ShowAlliancePage($users->user);

	break;
	case'diplo':
		include_once($svn_root . 'includes/pages/ShowDiploPage.' . $phpEx);
		ShowDiploPage($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'officier':
		include_once($svn_root . 'includes/pages/class.ShowOfficierPage.' . $phpEx);
		$officier=new ShowOfficierPages();
		$officier->ShowOfficierPage($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'statistics':
		include_once($svn_root . 'includes/pages/ShowStatisticsPage.' . $phpEx);
		ShowStatisticsPage($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'search':
		include_once($svn_root . 'includes/pages/ShowSearchPage.' . $phpEx);
		ShowSearchPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'messages':
		include_once($svn_root . 'includes/pages/ShowMessagesPage.' . $phpEx);
		ShowMessagesPage($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'notes':
		include_once($svn_root . 'includes/pages/ShowNotesPage.' . $phpEx);
		ShowNotesPage($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'buddy':
		include_once($svn_root . 'includes/pages/ShowBuddyPage.' . $phpEx);
		ShowBuddyPage($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'support':
		include_once($svn_root . 'includes/pages/ShowSupportPage.' . $phpEx);
		ShowSupportPage($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'contact':
		include_once($svn_root . 'includes/pages/ShowContactPage.' . $phpEx);
		ShowContactPage();
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'options':
		include_once($svn_root . 'includes/pages/class.ShowOptionsPage.' . $phpEx);
		$OptionsPage=new ShowOptionsPages();
		$OptionsPage->ShowOptionsPage($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'dojump':
		include_once($svn_root . 'includes/pages/class.ShowDojumpgatePage.' . $phpEx);
		$dojump= new ShowDojump();
		$dojump->ShowDoJumpgate($users->user,$planetrow);
		
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'credit':
		include_once($svn_root . 'includes/pages/ShowCreditPage.' . $phpEx);
		ShowCreditPage();
		
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'news':
		include_once($svn_root . 'includes/pages/ShowNewsPage.' . $phpEx);
		ShowNewsPage();
		
	break;

// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'logout':
		setcookie($db->game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);
		$displays->message($lang['see_you_soon'], $svn_root, 1, false, false);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	default:
                $plugin->is_plugins($_GET["page"]) ? '':$displays->message($lang['page_doesnt_exist']);
        break;
// --------------------------------------------------------------------------------------------------------------------------------------------//

    }

?>