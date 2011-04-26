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
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

if ($user['authlevel'] < 3) die(message($lang['not_enough_permissions']));

	$parse = $lang;

	switch($_GET[mode])
	{
		case'add_resources':
			$mode      = $_POST['mode'];
			if ($mode == 'addit')
			{
				$id          = $_POST['id'];
				$metal       = $_POST['metal'];
				$cristal     = $_POST['cristal'];
				$deut        = $_POST['deut'];
				$dark		 = $_POST['dark'];
				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= "`metal` = `metal` + '". $metal ."', ";
				$QryUpdatePlanet .= "`crystal` = `crystal` + '". $cristal ."', ";
				$QryUpdatePlanet .= "`deuterium` = `deuterium` + '". $deut ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $id ."' ";
				doquery( $QryUpdatePlanet, "planets");

				$QryUpdateUser  = "UPDATE {{table}} SET ";
				$QryUpdateUser .= "`darkmatter` = `darkmatter` + '". $dark ."' ";
				$QryUpdateUser .= "WHERE ";
				$QryUpdateUser .= "`id` = '". $id ."' ";
				doquery( $QryUpdateUser, "users");

				message ($lang['ad_sucess'],"adminresources.php",2);
			}
			display (parsetemplate(gettemplate("adm/add_resources"), $parse), false, '', true, false);
		break;
		case'del_resources':
			$mode      = $_POST['mode'];
			if ($mode == 'addit')
			{
				$id          = $_POST['id'];
				$metal       = $_POST['metal'];
				$cristal     = $_POST['cristal'];
				$deut        = $_POST['deut'];
				$dark        = $_POST['dark'];
				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= "`metal` = `metal` - '". $metal ."', ";
				$QryUpdatePlanet .= "`crystal` = `crystal` - '". $cristal ."', ";
				$QryUpdatePlanet .= "`deuterium` = `deuterium` - '". $deut ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $id ."' ";
				doquery( $QryUpdatePlanet, "planets");

				$QryUpdateUser  = "UPDATE {{table}} SET ";
				$QryUpdateUser .= "`darkmatter` = `darkmatter` - '". $dark ."' ";
				$QryUpdateUser .= "WHERE ";
				$QryUpdateUser .= "`id` = '". $id ."' ";
				doquery( $QryUpdateUser, "users");

				message ($lang['ad_sucess'],"adminresources.php",2);
			}
			display (parsetemplate(gettemplate("adm/del_resources"), $parse), false, '', true, false);
		break;
		case'add_ships':
			$mode      = $_POST['mode'];
			if ($mode == 'addit')
			{
				$id          		= $_POST['id'];
				$light_hunter       = $_POST['light_hunter'];
				$heavy_hunter    	= $_POST['heavy_hunter'];
				$small_ship_cargo	= $_POST['small_ship_cargo'];
				$big_ship_cargo     = $_POST['big_ship_cargo'];
				$crusher    		= $_POST['crusher'];
				$battle_ship        = $_POST['battle_ship'];
				$colonizer      	= $_POST['colonizer'];
				$recycler        	= $_POST['recycler'];
				$spy_sonde       	= $_POST['spy_sonde'];
				$bomber_ship      	= $_POST['bomber_ship'];
				$solar_satelit     	= $_POST['solar_satelit'];
				$destructor       	= $_POST['destructor'];
				$dearth_star       	= $_POST['dearth_star'];
				$battleship      	= $_POST['battleship'];
				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= "`small_ship_cargo` = `small_ship_cargo` + '". $small_ship_cargo ."', ";
				$QryUpdatePlanet .= "`battleship` = `battleship` + '". $battleship ."', ";
				$QryUpdatePlanet .= "`dearth_star` = `dearth_star` + '". $dearth_star ."', ";
				$QryUpdatePlanet .= "`destructor` = `destructor` + '". $destructor ."', ";
				$QryUpdatePlanet .= "`solar_satelit` = `solar_satelit` + '". $solar_satelit ."', ";
				$QryUpdatePlanet .= "`bomber_ship` = `bomber_ship` + '". $bomber_ship ."', ";
				$QryUpdatePlanet .= "`spy_sonde` = `spy_sonde` + '". $spy_sonde ."', ";
				$QryUpdatePlanet .= "`recycler` = `recycler` + '". $recycler ."', ";
				$QryUpdatePlanet .= "`colonizer` = `colonizer` + '". $colonizer ."', ";
				$QryUpdatePlanet .= "`battle_ship` = `battle_ship` + '". $battle_ship ."', ";
				$QryUpdatePlanet .= "`crusher` = `crusher` + '". $crusher ."', ";
				$QryUpdatePlanet .= "`heavy_hunter` = `heavy_hunter` + '". $heavy_hunter ."', ";
				$QryUpdatePlanet .= "`big_ship_cargo` = `big_ship_cargo` + '". $big_ship_cargo ."', ";
				$QryUpdatePlanet .= "`light_hunter` = `light_hunter` + '". $light_hunter ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $id ."' ";
				doquery( $QryUpdatePlanet, "planets");

				message ($lang['ad_sucess'],"adminresources.php",2);
			}
			display (parsetemplate(gettemplate("adm/add_ships"), $parse), false, '', true, false);
		break;
		case'del_ships':
			$mode      = $_POST['mode'];
			if ($mode == 'addit')
			{
				$id          		= $_POST['id'];
				$light_hunter       = $_POST['light_hunter'];
				$heavy_hunter    	= $_POST['heavy_hunter'];
				$small_ship_cargo	= $_POST['small_ship_cargo'];
				$big_ship_cargo     = $_POST['big_ship_cargo'];
				$crusher    		= $_POST['crusher'];
				$battle_ship        = $_POST['battle_ship'];
				$colonizer      	= $_POST['colonizer'];
				$recycler        	= $_POST['recycler'];
				$spy_sonde       	= $_POST['spy_sonde'];
				$bomber_ship      	= $_POST['bomber_ship'];
				$solar_satelit     	= $_POST['solar_satelit'];
				$destructor       	= $_POST['destructor'];
				$dearth_star       	= $_POST['dearth_star'];
				$battleship      	= $_POST['battleship'];
				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= "`small_ship_cargo` = `small_ship_cargo` - '". $small_ship_cargo ."', ";
				$QryUpdatePlanet .= "`battleship` = `battleship` - '". $battleship ."', ";
				$QryUpdatePlanet .= "`dearth_star` = `dearth_star` - '". $dearth_star ."', ";
				$QryUpdatePlanet .= "`destructor` = `destructor` - '". $destructor ."', ";
				$QryUpdatePlanet .= "`solar_satelit` = `solar_satelit` - '". $solar_satelit ."', ";
				$QryUpdatePlanet .= "`bomber_ship` = `bomber_ship` - '". $bomber_ship ."', ";
				$QryUpdatePlanet .= "`spy_sonde` = `spy_sonde` - '". $spy_sonde ."', ";
				$QryUpdatePlanet .= "`recycler` = `recycler` - '". $recycler ."', ";
				$QryUpdatePlanet .= "`colonizer` = `colonizer` - '". $colonizer ."', ";
				$QryUpdatePlanet .= "`battle_ship` = `battle_ship` - '". $battle_ship ."', ";
				$QryUpdatePlanet .= "`crusher` = `crusher` - '". $crusher ."', ";
				$QryUpdatePlanet .= "`heavy_hunter` = `heavy_hunter` - '". $heavy_hunter ."', ";
				$QryUpdatePlanet .= "`big_ship_cargo` = `big_ship_cargo` - '". $big_ship_cargo ."', ";
				$QryUpdatePlanet .= "`light_hunter` = `light_hunter` - '". $light_hunter ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $id ."' ";
				doquery( $QryUpdatePlanet, "planets");

				message ($lang['ad_sucess'],"adminresources.php",2);
			}
			display (parsetemplate(gettemplate("adm/del_ships"), $parse), false, '', true, false);
		break;
		case'add_defenses':
			$mode      = $_POST['mode'];
			if ($mode == 'addit')
			{
				$id          				= $_POST['id'];
				$misil_launcher       		= $_POST['misil_launcher'];
				$small_laser    			= $_POST['small_laser'];
				$big_laser        			= $_POST['big_laser'];
				$gauss_canyon        		= $_POST['gauss_canyon'];
				$ionic_canyon    			= $_POST['ionic_canyon'];
				$buster_canyon        		= $_POST['buster_canyon'];
				$small_protection_shield	= $_POST['small_protection_shield'];
				$big_protection_shield      = $_POST['big_protection_shield'];
				$interceptor_misil       	= $_POST['interceptor_misil'];
				$interplanetary_misil      	= $_POST['interplanetary_misil'];
				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= "`misil_launcher` = `misil_launcher` + '". $misil_launcher ."', ";
				$QryUpdatePlanet .= "`small_laser` = `small_laser` + '". $small_laser ."', ";
				$QryUpdatePlanet .= "`big_laser` = `big_laser` + '". $big_laser ."', ";
				$QryUpdatePlanet .= "`gauss_canyon` = `gauss_canyon` + '". $gauss_canyon ."', ";
				$QryUpdatePlanet .= "`ionic_canyon` = `ionic_canyon` + '". $ionic_canyon ."', ";
				$QryUpdatePlanet .= "`buster_canyon` = `buster_canyon` + '". $buster_canyon ."', ";
				$QryUpdatePlanet .= "`small_protection_shield` = `small_protection_shield` + '". $small_protection_shield ."', ";
				$QryUpdatePlanet .= "`big_protection_shield` = `big_protection_shield` + '". $big_protection_shield ."', ";
				$QryUpdatePlanet .= "`interceptor_misil` = `interceptor_misil` + '". $interceptor_misil ."', ";
				$QryUpdatePlanet .= "`interplanetary_misil` = `interplanetary_misil` + '". $interplanetary_misil ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $id ."' ";
				doquery( $QryUpdatePlanet, "planets");

				message ($lang['ad_sucess'],"adminresources.php",2);
			}
			display (parsetemplate(gettemplate("adm/add_defenses"), $parse), false, '', true, false);
		break;
		case'del_defenses':
			$mode      = $_POST['mode'];
			if ($mode == 'addit')
			{
				$id          				= $_POST['id'];
				$misil_launcher       		= $_POST['misil_launcher'];
				$small_laser    			= $_POST['small_laser'];
				$big_laser        			= $_POST['big_laser'];
				$gauss_canyon        		= $_POST['gauss_canyon'];
				$ionic_canyon    			= $_POST['ionic_canyon'];
				$buster_canyon        		= $_POST['buster_canyon'];
				$small_protection_shield	= $_POST['small_protection_shield'];
				$big_protection_shield      = $_POST['big_protection_shield'];
				$interceptor_misil       	= $_POST['interceptor_misil'];
				$interplanetary_misil      	= $_POST['interplanetary_misil'];
				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= "`misil_launcher` = `misil_launcher` - '". $misil_launcher ."', ";
				$QryUpdatePlanet .= "`small_laser` = `small_laser` - '". $small_laser ."', ";
				$QryUpdatePlanet .= "`big_laser` = `big_laser` - '". $big_laser ."', ";
				$QryUpdatePlanet .= "`gauss_canyon` = `gauss_canyon` - '". $gauss_canyon ."', ";
				$QryUpdatePlanet .= "`ionic_canyon` = `ionic_canyon` - '". $ionic_canyon ."', ";
				$QryUpdatePlanet .= "`buster_canyon` = `buster_canyon` - '". $buster_canyon ."', ";
				$QryUpdatePlanet .= "`small_protection_shield` = `small_protection_shield` - '". $small_protection_shield ."', ";
				$QryUpdatePlanet .= "`big_protection_shield` = `big_protection_shield` - '". $big_protection_shield ."', ";
				$QryUpdatePlanet .= "`interceptor_misil` = `interceptor_misil` - '". $interceptor_misil ."', ";
				$QryUpdatePlanet .= "`interplanetary_misil` = `interplanetary_misil` - '". $interplanetary_misil ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $id ."' ";
				doquery( $QryUpdatePlanet, "planets");

				message ($lang['ad_sucess'],"adminresources.php",2);
			}
			display (parsetemplate(gettemplate("adm/del_defenses"), $parse), false, '', true, false);
		break;
		case'add_buildings':
			$mode      = $_POST['mode'];
			if ($mode == 'addit')
			{
				$id          			= $_POST['id'];
				$metal_mine       		= $_POST['metal_mine'];
				$crystal_mine    		= $_POST['crystal_mine'];
				$deuterium_sintetizer	= $_POST['deuterium_sintetizer'];
				$solar_plant        	= $_POST['solar_plant'];
				$fusion_plant    		= $_POST['fusion_plant'];
				$robot_factory        	= $_POST['robot_factory'];
				$nano_factory      		= $_POST['nano_factory'];
				$hangar        			= $_POST['hangar'];
				$metal_store       		= $_POST['metal_store'];
				$crystal_store      	= $_POST['crystal_store'];
				$deuterium_store     	= $_POST['deuterium_store'];
				$laboratory       		= $_POST['laboratory'];
				$terraformer       		= $_POST['terraformer'];
				$ally_deposit      		= $_POST['ally_deposit'];
				$silo      				= $_POST['silo'];
				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= "`metal_mine` = `metal_mine` + '". $metal_mine ."', ";
				$QryUpdatePlanet .= "`crystal_mine` = `crystal_mine` + '". $crystal_mine ."', ";
				$QryUpdatePlanet .= "`deuterium_sintetizer` = `deuterium_sintetizer` + '". $deuterium_sintetizer ."', ";
				$QryUpdatePlanet .= "`solar_plant` = `solar_plant` + '". $solar_plant ."', ";
				$QryUpdatePlanet .= "`fusion_plant` = `fusion_plant` + '". $fusion_plant ."', ";
				$QryUpdatePlanet .= "`robot_factory` = `robot_factory` + '". $robot_factory ."', ";
				$QryUpdatePlanet .= "`nano_factory` = `nano_factory` + '". $nano_factory ."', ";
				$QryUpdatePlanet .= "`hangar` = `hangar` + '". $hangar ."', ";
				$QryUpdatePlanet .= "`metal_store` = `metal_store` + '". $metal_store ."', ";
				$QryUpdatePlanet .= "`crystal_store` = `crystal_store` + '". $crystal_store ."', ";
				$QryUpdatePlanet .= "`deuterium_store` = `deuterium_store` + '". $deuterium_store ."', ";
				$QryUpdatePlanet .= "`laboratory` = `laboratory` + '". $laboratory ."', ";
				$QryUpdatePlanet .= "`terraformer` = `terraformer` + '". $terraformer ."', ";
				$QryUpdatePlanet .= "`ally_deposit` = `ally_deposit` + '". $ally_deposit ."', ";
				$QryUpdatePlanet .= "`silo` = `silo` + '". $silo ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $id ."' ";
				doquery( $QryUpdatePlanet, "planets");

				message ($lang['ad_sucess'],"adminresources.php",2);
			}
			display (parsetemplate(gettemplate("adm/add_buildings"), $parse), false, '', true, false);
		break;
		case'del_buildings':
			$mode      = $_POST['mode'];
			if ($mode == 'addit')
			{
				$id          			= $_POST['id'];
				$metal_mine       		= $_POST['metal_mine'];
				$crystal_mine    		= $_POST['crystal_mine'];
				$deuterium_sintetizer	= $_POST['deuterium_sintetizer'];
				$solar_plant        	= $_POST['solar_plant'];
				$fusion_plant    		= $_POST['fusion_plant'];
				$robot_factory        	= $_POST['robot_factory'];
				$nano_factory      		= $_POST['nano_factory'];
				$hangar        			= $_POST['hangar'];
				$metal_store       		= $_POST['metal_store'];
				$crystal_store      	= $_POST['crystal_store'];
				$deuterium_store     	= $_POST['deuterium_store'];
				$laboratory       		= $_POST['laboratory'];
				$terraformer       		= $_POST['terraformer'];
				$ally_deposit      		= $_POST['ally_deposit'];
				$silo      				= $_POST['silo'];
				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= "`metal_mine` = `metal_mine` - '". $metal_mine ."', ";
				$QryUpdatePlanet .= "`crystal_mine` = `crystal_mine` - '". $crystal_mine ."', ";
				$QryUpdatePlanet .= "`deuterium_sintetizer` = `deuterium_sintetizer` - '". $deuterium_sintetizer ."', ";
				$QryUpdatePlanet .= "`solar_plant` = `solar_plant` - '". $solar_plant ."', ";
				$QryUpdatePlanet .= "`fusion_plant` = `fusion_plant` - '". $fusion_plant ."', ";
				$QryUpdatePlanet .= "`robot_factory` = `robot_factory` - '". $robot_factory ."', ";
				$QryUpdatePlanet .= "`nano_factory` = `nano_factory` - '". $nano_factory ."', ";
				$QryUpdatePlanet .= "`hangar` = `hangar` - '". $hangar ."', ";
				$QryUpdatePlanet .= "`metal_store` = `metal_store` - '". $metal_store ."', ";
				$QryUpdatePlanet .= "`crystal_store` = `crystal_store` - '". $crystal_store ."', ";
				$QryUpdatePlanet .= "`deuterium_store` = `deuterium_store` - '". $deuterium_store ."', ";
				$QryUpdatePlanet .= "`laboratory` = `laboratory` - '". $laboratory ."', ";
				$QryUpdatePlanet .= "`terraformer` = `terraformer` - '". $terraformer ."', ";
				$QryUpdatePlanet .= "`ally_deposit` = `ally_deposit` - '". $ally_deposit ."', ";
				$QryUpdatePlanet .= "`silo` = `silo` - '". $silo ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $id ."' ";
				doquery( $QryUpdatePlanet, "planets");

				message ($lang['ad_sucess'],"adminresources.php",2);
			}
			display (parsetemplate(gettemplate("adm/del_buildings"), $parse), false, '', true, false);
		break;
		case'add_research':
			$mode      = $_POST['mode'];
			if ($mode == 'addit')
			{
				$id          			= $_POST['id'];
				$spy_tech       		= $_POST['spy_tech'];
				$computer_tech    		= $_POST['computer_tech'];
				$military_tech        	= $_POST['military_tech'];
				$defence_tech        	= $_POST['defence_tech'];
				$shield_tech    		= $_POST['shield_tech'];
				$energy_tech        	= $_POST['energy_tech'];
				$hyperspace_tech      	= $_POST['hyperspace_tech'];
				$combustion_tech        = $_POST['combustion_tech'];
				$impulse_motor_tech     = $_POST['impulse_motor_tech'];
				$hyperspace_motor_tech  = $_POST['hyperspace_motor_tech'];
				$laser_tech     		= $_POST['laser_tech'];
				$ionic_tech       		= $_POST['ionic_tech'];
				$buster_tech       		= $_POST['buster_tech'];
				$intergalactic_tech     = $_POST['intergalactic_tech'];
				$expedition_tech     	= $_POST['expedition_tech'];
				$graviton_tech     		= $_POST['graviton_tech'];

				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= "`spy_tech` = `spy_tech` + '". $spy_tech ."', ";
				$QryUpdatePlanet .= "`computer_tech` = `computer_tech` + '". $computer_tech ."', ";
				$QryUpdatePlanet .= "`military_tech` = `military_tech` + '". $military_tech ."', ";
				$QryUpdatePlanet .= "`defence_tech` = `defence_tech` + '". $defence_tech ."', ";
				$QryUpdatePlanet .= "`shield_tech` = `shield_tech` + '". $shield_tech ."', ";
				$QryUpdatePlanet .= "`energy_tech` = `energy_tech` + '". $energy_tech ."', ";
				$QryUpdatePlanet .= "`hyperspace_tech` = `hyperspace_tech` + '". $hyperspace_tech ."', ";
				$QryUpdatePlanet .= "`combustion_tech` = `combustion_tech` + '". $combustion_tech ."', ";
				$QryUpdatePlanet .= "`impulse_motor_tech` = `impulse_motor_tech` + '". $impulse_motor_tech ."', ";
				$QryUpdatePlanet .= "`hyperspace_motor_tech` = `hyperspace_motor_tech` + '". $hyperspace_motor_tech ."', ";
				$QryUpdatePlanet .= "`laser_tech` = `laser_tech` + '". $laser_tech ."', ";
				$QryUpdatePlanet .= "`ionic_tech` = `ionic_tech` + '". $ionic_tech ."', ";
				$QryUpdatePlanet .= "`buster_tech` = `buster_tech` + '". $buster_tech ."', ";
				$QryUpdatePlanet .= "`intergalactic_tech` = `intergalactic_tech` + '". $intergalactic_tech ."', ";
				$QryUpdatePlanet .= "`expedition_tech` = `expedition_tech` + '". $expedition_tech ."', ";
				$QryUpdatePlanet .= "`graviton_tech` = `graviton_tech` + '". $graviton_tech ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $id ."' ";
				doquery( $QryUpdatePlanet, "users");

				message ($lang['ad_sucess'],"adminresources.php",2);
			}
			display (parsetemplate(gettemplate("adm/add_research"), $parse), false, '', true, false);
		break;
		case'del_research':
			$mode      = $_POST['mode'];
			if ($mode == 'addit')
			{
				$id          			= $_POST['id'];
				$spy_tech       		= $_POST['spy_tech'];
				$computer_tech    		= $_POST['computer_tech'];
				$military_tech        	= $_POST['military_tech'];
				$defence_tech        	= $_POST['defence_tech'];
				$shield_tech    		= $_POST['shield_tech'];
				$energy_tech        	= $_POST['energy_tech'];
				$hyperspace_tech      	= $_POST['hyperspace_tech'];
				$combustion_tech        = $_POST['combustion_tech'];
				$impulse_motor_tech     = $_POST['impulse_motor_tech'];
				$hyperspace_motor_tech	= $_POST['hyperspace_motor_tech'];
				$laser_tech     		= $_POST['laser_tech'];
				$ionic_tech       		= $_POST['ionic_tech'];
				$buster_tech       		= $_POST['buster_tech'];
				$intergalactic_tech     = $_POST['intergalactic_tech'];
				$expedition_tech     	= $_POST['expedition_tech'];
				$graviton_tech     		= $_POST['graviton_tech'];

				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= "`spy_tech` = `spy_tech` - '". $spy_tech ."', ";
				$QryUpdatePlanet .= "`computer_tech` = `computer_tech` - '". $computer_tech ."', ";
				$QryUpdatePlanet .= "`military_tech` = `military_tech` - '". $military_tech ."', ";
				$QryUpdatePlanet .= "`defence_tech` = `defence_tech` - '". $defence_tech ."', ";
				$QryUpdatePlanet .= "`shield_tech` = `shield_tech` - '". $shield_tech ."', ";
				$QryUpdatePlanet .= "`energy_tech` = `energy_tech` - '". $energy_tech ."', ";
				$QryUpdatePlanet .= "`hyperspace_tech` = `hyperspace_tech` - '". $hyperspace_tech ."', ";
				$QryUpdatePlanet .= "`combustion_tech` = `combustion_tech` - '". $combustion_tech ."', ";
				$QryUpdatePlanet .= "`impulse_motor_tech` = `impulse_motor_tech` - '". $impulse_motor_tech ."', ";
				$QryUpdatePlanet .= "`hyperspace_motor_tech` = `hyperspace_motor_tech` - '". $hyperspace_motor_tech ."', ";
				$QryUpdatePlanet .= "`laser_tech` = `laser_tech` - '". $laser_tech ."', ";
				$QryUpdatePlanet .= "`ionic_tech` = `ionic_tech` - '". $ionic_tech ."', ";
				$QryUpdatePlanet .= "`buster_tech` = `buster_tech` - '". $buster_tech ."', ";
				$QryUpdatePlanet .= "`intergalactic_tech` = `intergalactic_tech` - '". $intergalactic_tech ."', ";
				$QryUpdatePlanet .= "`expedition_tech` = `expedition_tech` - '". $expedition_tech ."', ";
				$QryUpdatePlanet .= "`graviton_tech` = `graviton_tech` - '". $graviton_tech ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $id ."' ";
				doquery( $QryUpdatePlanet, "users");

				message ($lang['ad_sucess'],"adminresources.php",2);
			}
			display (parsetemplate(gettemplate("adm/del_research"), $parse), false, '', true, false);
		break;
		default:
			display(parsetemplate(gettemplate('adm/adminresources'), $parse), false, '', true, false);
	}
?>