<?php

/*
switch.php
Copyright by Steggi and gianluca311 for Xnova-reloaded.de

Über diesen Switcher werden die Dateien für die Anzeige includiert, und anschleißend in der indexGame ausgegeben.
*/

switch($_GET["action"]){
	
	//wenn nichts mitgeschuckt wird, gelangt man automatisch auf die Overview
	case'': include("pages/overview.php"); break;
	case'ShowChangelog':						include("pages/changelog.php"); break;
	case'ShowReport':							include("pages/rw.php"); break;

	
	
	case'internalHome': 						include("pages/overview.php"); break;
	case'internalImperium':						include("pages/imperium.php"); break;
	case'internalResources':					include("pages/resources.php"); break;
	case'internalBuildings':					include("pages/buildings.php"); break;

	case'internalGalaxy':						include("pages/galaxy.php"); break;
	case'internalFleet':						include("pages/fleet.php"); break;
	case'internalFleet1':						include("pages/flotten1.php"); break;
	case'internalFleet2':						include("pages/flotten2.php"); break;
	case'internalFleet3':						include("pages/flotten3.php"); break;
	case'internalTechtree':						include("pages/techtree.php"); break;
	case'internalOfficiers':					include("pages/officier.php"); break;
	case'internalAlliance':						include("pages/alliance.php"); break;
	case'internalMessages':						include("pages/messages.php"); break;
	case'internalNotes':						include("pages/notes.php"); break;
	case'internalStats':						include("pages/stat.php"); break;
	case'internalSearch':						include("pages/search.php"); break;
	case'internalHelp':							include("pages/helpme.php"); break;
	case'internalContact':						include("pages/contact.php"); break;
	case'internalRecords':						include("pages/records.php"); break;
	case'internalOptions':						include("pages/options.php"); break;
	case'internalRocketAttack':					include("pages/raketenangriff.php"); break;
	case'internalBuddy':						include("pages/buddy.php"); break;
	case'internalFlottenajax':					include("pages/flottenajax.php"); break;
	case'internalInformations':					include("pages/infos.php"); break;
	case'internalAKS':							include("pages/verband.php"); break;
	case'internalFleetback':					include("pages/fleetback.php"); break;
	case'internalFleetshortcut':				include("pages/fleetshortcut.php"); break;
	case'internaljumpgate':						include("pages/jumpgate.php"); break;
	case'credits':								include("pages/credit.php"); break;
	
	case'logout':								include("pages/logout.php"); break;
	
	//Admin
	case'administrativeHome': 					include("pages/admin/overview.php"); break;
	case'administrativeServerInformation':		include("pages/admin/server.php"); break;
	case'administrativeServerSettings':			include("pages/admin/settings.php"); break;
	case'administrativeUniverseReset':			include("pages/admin/XnovaResetUnivers.php"); break;
	case'administrativeUserlist':				include("pages/admin/userlist.php"); break;
	case'administrativeUserlistMulti':			include("pages/admin/userlist_multi.php"); break;
	case'administrativeMeldungen':				include("pages/admin/meldenadmin.php"); break;
	case'administrativePanel':					include("pages/admin/adminpanel.php"); break;
	case'administrativeMats':					include("pages/admin/mats.php"); break;
	case'administrativeMatsAddRess':			include("pages/admin/add_ress.php"); break;
	case'administrativeMatsDelRess':			include("pages/admin/del_ress.php"); break;
	case'administrativeMatsAddFleet':			include("pages/admin/add_fleet.php"); break;
	case'administrativeMatsDelFleet':			include("pages/admin/del_fleet.php"); break;
	case'administrativeMatsAddDef':				include("pages/admin/add_def.php"); break;
	case'administrativeMatsDelDef':				include("pages/admin/del_def.php"); break;
	case'administrativeMatsAddBuildings':		include("pages/admin/add_building.php"); break;
	case'administrativeMatsDelBuildings':		include("pages/admin/del_building.php"); break;
	case'administrativeMatsAddResearches':		include("pages/admin/add_research.php"); break;
	case'administrativeMatsDelResearches':		include("pages/admin/del_research.php"); break;

	
	
	
	
	
	case'administrativePlanetlist':				include("pages/admin/planetlist.php"); break;
	case'administrativeMoonlist':				include("pages/admin/moonlist.php"); break;
	case'administrativeAddMoon':				include("pages/admin/add_moon.php"); break;
	case'administrativeShowFlyingFleets':		include("pages/admin/ShowFlyingFleets.php"); break;
	//Imperium Platzhalter
	case'administrativePlayerBanning':			include("pages/admin/banned.php"); break;
	case'administrativePlayerUnbanning':		include("pages/admin/unbanned.php"); break;
	case'administrativeShowPDOerrors':			include("pages/admin/pdo_errors.php"); break;
	case'administrativeStatbuilder':			include("pages/admin/statbuilder.php"); break;
	case'administrativeElementQueueFixer':		include("pages/admin/ElementQueueFixer.php"); break;
	case'administrativeMessageList':			include("pages/admin/messagelist.php"); break;
	case'administrativeMessageToAll':			include("pages/admin/messall.php"); break;
	case'administrativeMD5Encoder':				include("pages/admin/md5enc.php"); break;
	case'administrativeMySQLErrors':			include("pages/admin/errors.php"); break;
	
	
	
	//Bei nem ungültigem Link auch auf die Overview
	default:  include("pages/overview.php"); break;
}

$actions = array('internalHome', 'internalImperium', 'internalResources', 'internalBuildings', 'internalGalaxy', 'internalFleet', 'internalFleet1', 'internalFleet2', 'internalFleet3', 'internalTechtree', 'internalOfficiers', ' internalAlliance', 'internalMessages', 'internalNotes', 'internalStats', 'internalSearch', 'internalHelp', 'internalContact', 'internalRecords', 'internalOptions', 'internalInformations', 'internalAKS', 'internalFleetback', 'internalFleetshortcut', 'credits', 'logout');
?>