<?php
//version 1
function ShowResourceAdmin($user){
	global $lang,$db,$displays;
if ($user['authlevel'] < 2) die($displays->message($lang['not_enough_permissions']));

//	$parse = $lang;

	switch($_GET[edit])
	{
		case'resources':
			$mode      = $_POST['edit'];
			if ($mode == 'addit')
			{
				$id          = $_POST['id'];
				$metal       = $_POST['metal'];
				$cristal     = $_POST['cristal'];
				$deut        = $_POST['deut'];
				$dark	     = $_POST['dark'];
				$accion      = $_POST['accion'];

				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= "`metal` = `metal` ". $accion ." '". $metal ."', ";
				$QryUpdatePlanet .= "`crystal` = `crystal` ". $accion ." '". $cristal ."', ";
				$QryUpdatePlanet .= "`deuterium` = `deuterium` ". $accion ." '". $deut ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $id ."' ";
				$db->query( $QryUpdatePlanet, "planets");

				$QryUpdateUser  = "UPDATE {{table}} SET ";
				$QryUpdateUser .= "`darkmatter` = `darkmatter` ". $accion ." '". $dark ."' ";
				$QryUpdateUser .= "WHERE ";
				$QryUpdateUser .= "`id` = '". $id ."' ";
				$db->query( $QryUpdateUser, "users");

				message ($lang['ad_sucess'],"admin.php?page=admresource&edit=resources",2);
			}
				$displays->assignContent('adm/editor_resources');
			
      		                $displays->display();

		break;

		case'ships':
			$mode      = $_POST['edit'];
			if ($mode == 'addit')
			{
				$id          		= $_POST['id'];
				$light_hunter           = $_POST['light_hunter'];
				$heavy_hunter    	= $_POST['heavy_hunter'];
				$small_ship_cargo	= $_POST['small_ship_cargo'];
				$big_ship_cargo         = $_POST['big_ship_cargo'];
				$crusher    		= $_POST['crusher'];
				$battle_ship            = $_POST['battle_ship'];
				$colonizer      	= $_POST['colonizer'];
				$recycler        	= $_POST['recycler'];
				$spy_sonde       	= $_POST['spy_sonde'];
				$bomber_ship      	= $_POST['bomber_ship'];
				$solar_satelit     	= $_POST['solar_satelit'];
				$destructor       	= $_POST['destructor'];
				$dearth_star       	= $_POST['dearth_star'];
				$battleship      	= $_POST['battleship'];
				$supernova      	= $_POST['supernova'];
				$accion                 = $_POST['accion'];

				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= "`small_ship_cargo` = `small_ship_cargo` ". $accion ." '". $small_ship_cargo ."', ";
				$QryUpdatePlanet .= "`battleship` = `battleship` ". $accion ." '". $battleship ."', ";
				$QryUpdatePlanet .= "`dearth_star` = `dearth_star` ". $accion ." '". $dearth_star ."', ";
				$QryUpdatePlanet .= "`destructor` = `destructor` ". $accion ." '". $destructor ."', ";
				$QryUpdatePlanet .= "`solar_satelit` = `solar_satelit` ". $accion ." '". $solar_satelit ."', ";
				$QryUpdatePlanet .= "`bomber_ship` = `bomber_ship` ". $accion ." '". $bomber_ship ."', ";
				$QryUpdatePlanet .= "`spy_sonde` = `spy_sonde` ". $accion ." '". $spy_sonde ."', ";
				$QryUpdatePlanet .= "`recycler` = `recycler` ". $accion ." '". $recycler ."', ";
				$QryUpdatePlanet .= "`colonizer` = `colonizer` ". $accion ." '". $colonizer ."', ";
				$QryUpdatePlanet .= "`battle_ship` = `battle_ship` ". $accion ." '". $battle_ship ."', ";
				$QryUpdatePlanet .= "`crusher` = `crusher` ". $accion ." '". $crusher ."', ";
				$QryUpdatePlanet .= "`heavy_hunter` = `heavy_hunter` ". $accion ." '". $heavy_hunter ."', ";
				$QryUpdatePlanet .= "`big_ship_cargo` = `big_ship_cargo` ". $accion ." '". $big_ship_cargo ."', ";
				$QryUpdatePlanet .= "`light_hunter` = `light_hunter` ". $accion ." '". $light_hunter ."', ";
				$QryUpdatePlanet .= "`supernova` = `supernova` ". $accion ." '". $supernova ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $id ."' ";
				$db->query( $QryUpdatePlanet, "planets");

				message ($lang['ad_sucess'],"admin.php?page=admresource",2);
			}
				$displays->assignContent('adm/editor_ships');
			
      		                $displays->display();

		break;
		case'defenses':
			$mode      = $_POST['edit'];
			if ($mode == 'addit')
			{
				$id          			= $_POST['id'];
				$misil_launcher       		= $_POST['misil_launcher'];
				$small_laser    		= $_POST['small_laser'];
				$big_laser        		= $_POST['big_laser'];
				$gauss_canyon        		= $_POST['gauss_canyon'];
				$ionic_canyon    		= $_POST['ionic_canyon'];
				$buster_canyon        		= $_POST['buster_canyon'];
				$small_protection_shield	= $_POST['small_protection_shield'];
				$big_protection_shield          = $_POST['big_protection_shield'];
				$planet_protector               = $_POST['planet_protector'];
				$interceptor_misil       	= $_POST['interceptor_misil'];
				$interplanetary_misil      	= $_POST['interplanetary_misil'];
				$accion                         = $_POST['accion'];

				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= "`misil_launcher` = `misil_launcher` ". $accion ." '". $misil_launcher ."', ";
				$QryUpdatePlanet .= "`small_laser` = `small_laser` ". $accion ." '". $small_laser ."', ";
				$QryUpdatePlanet .= "`big_laser` = `big_laser` ". $accion ." '". $big_laser ."', ";
				$QryUpdatePlanet .= "`gauss_canyon` = `gauss_canyon` ". $accion ." '". $gauss_canyon ."', ";
				$QryUpdatePlanet .= "`ionic_canyon` = `ionic_canyon` ". $accion ." '". $ionic_canyon ."', ";
				$QryUpdatePlanet .= "`buster_canyon` = `buster_canyon` ". $accion ." '". $buster_canyon ."', ";
				$QryUpdatePlanet .= "`small_protection_shield` = `small_protection_shield` ". $accion ." '". $small_protection_shield ."', ";
				$QryUpdatePlanet .= "`big_protection_shield` = `big_protection_shield` ". $accion ." '". $big_protection_shield ."', ";
				$QryUpdatePlanet .= "`planet_protector` = `planet_protector` ". $accion ." '". $planet_protector ."', ";
				$QryUpdatePlanet .= "`interceptor_misil` = `interceptor_misil` ". $accion ." '". $interceptor_misil ."', ";
				$QryUpdatePlanet .= "`interplanetary_misil` = `interplanetary_misil` ". $accion ." '". $interplanetary_misil ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $id ."' ";
				$db->query( $QryUpdatePlanet, "planets");

				message ($lang['ad_sucess'],"admin.php?page=admresource",2);
			}
				$displays->assignContent('adm/editor_defenses');
			
      		                $displays->display();

		break;
		case'buildings':
			$mode      = $_POST['edit'];
			if ($mode == 'addit')
			{
				$id          		= $_POST['id'];
				$metal_mine       	= $_POST['metal_mine'];
				$crystal_mine    	= $_POST['crystal_mine'];
				$deuterium_sintetizer	= $_POST['deuterium_sintetizer'];
				$solar_plant        	= $_POST['solar_plant'];
				$fusion_plant    	= $_POST['fusion_plant'];
				$robot_factory        	= $_POST['robot_factory'];
				$nano_factory      	= $_POST['nano_factory'];
				$hangar        		= $_POST['hangar'];
				$metal_store       	= $_POST['metal_store'];
				$crystal_store      	= $_POST['crystal_store'];
				$deuterium_store     	= $_POST['deuterium_store'];
				$laboratory       	= $_POST['laboratory'];
				$terraformer       	= $_POST['terraformer'];
				$ally_deposit      	= $_POST['ally_deposit'];
				$silo      		= $_POST['silo'];
				$mondbasis       	= $_POST['mondbasis'];
				$phalanx      	        = $_POST['phalanx'];
				$sprungtor      	= $_POST['sprungtor'];
				$accion                 = $_POST['accion'];
				$field_current          = $metal_mine + $crystal_mine + $deuterium_sintetizer + $solar_plant + $fusion_plant + $robot_factory + $hangar + $metal_store + $crystal_store + $deuterium_store + $laboratory + $terraformer + $ally_deposit + $silo + $field_current + $mondbasis + $sprungtor + $phalanx;

				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= "`metal_mine` = `metal_mine` ". $accion ." '". $metal_mine ."', ";
				$QryUpdatePlanet .= "`crystal_mine` = `crystal_mine` ". $accion ." '". $crystal_mine ."', ";
				$QryUpdatePlanet .= "`deuterium_sintetizer` = `deuterium_sintetizer` ". $accion ." '". $deuterium_sintetizer ."', ";
				$QryUpdatePlanet .= "`solar_plant` = `solar_plant` ". $accion ." '". $solar_plant ."', ";
				$QryUpdatePlanet .= "`fusion_plant` = `fusion_plant` ". $accion ." '". $fusion_plant ."', ";
				$QryUpdatePlanet .= "`robot_factory` = `robot_factory` ". $accion ." '". $robot_factory ."', ";
				$QryUpdatePlanet .= "`nano_factory` = `nano_factory` ". $accion ." '". $nano_factory ."', ";
				$QryUpdatePlanet .= "`hangar` = `hangar` ". $accion ." '". $hangar ."', ";
				$QryUpdatePlanet .= "`metal_store` = `metal_store` ". $accion ." '". $metal_store ."', ";
				$QryUpdatePlanet .= "`crystal_store` = `crystal_store` ". $accion ." '". $crystal_store ."', ";
				$QryUpdatePlanet .= "`deuterium_store` = `deuterium_store` ". $accion ." '". $deuterium_store ."', ";
				$QryUpdatePlanet .= "`laboratory` = `laboratory` ". $accion ." '". $laboratory ."', ";
				$QryUpdatePlanet .= "`terraformer` = `terraformer` ". $accion ." '". $terraformer ."', ";
				$QryUpdatePlanet .= "`ally_deposit` = `ally_deposit` ". $accion ." '". $ally_deposit ."', ";
				$QryUpdatePlanet .= "`silo` = `silo` ". $accion ." '". $silo ."', ";
				$QryUpdatePlanet .= "`mondbasis` = `mondbasis` ". $accion ." '". $mondbasis ."', ";
				$QryUpdatePlanet .= "`phalanx` = `phalanx` ". $accion ." '". $phalanx ."', ";
				$QryUpdatePlanet .= "`sprungtor` = `sprungtor` ". $accion ." '". $sprungtor ."', ";

				$QryUpdatePlanet .= "`field_current` = `field_current` ". $accion ." '". $field_current ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $id ."' ";
				$db->query( $QryUpdatePlanet, "planets");

				message ($lang['ad_sucess'],"admin.php?page=admresource",2);
			}
				$displays->assignContent('adm/editor_buildings');

      		                $displays->display();

		break;
		
		case'research':
			$mode      = $_POST['edit'];
			if ($mode == 'addit')
			{
				$id          		= $_POST['id'];
				$spy_tech       	= $_POST['spy_tech'];
				$computer_tech    	= $_POST['computer_tech'];
				$military_tech        	= $_POST['military_tech'];
				$defence_tech        	= $_POST['defence_tech'];
				$shield_tech    	= $_POST['shield_tech'];
				$energy_tech        	= $_POST['energy_tech'];
				$hyperspace_tech      	= $_POST['hyperspace_tech'];
				$combustion_tech        = $_POST['combustion_tech'];
				$impulse_motor_tech     = $_POST['impulse_motor_tech'];
				$hyperspace_motor_tech  = $_POST['hyperspace_motor_tech'];
				$laser_tech     	= $_POST['laser_tech'];
				$ionic_tech       	= $_POST['ionic_tech'];
				$buster_tech       	= $_POST['buster_tech'];
				$intergalactic_tech     = $_POST['intergalactic_tech'];
				$expedition_tech     	= $_POST['expedition_tech'];
				$graviton_tech     	= $_POST['graviton_tech'];
				$accion                 = $_POST['accion'];

				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= "`spy_tech` = `spy_tech` ". $accion ." '". $spy_tech ."', ";
				$QryUpdatePlanet .= "`computer_tech` = `computer_tech` ". $accion ." '". $computer_tech ."', ";
				$QryUpdatePlanet .= "`military_tech` = `military_tech` ". $accion ." '". $military_tech ."', ";
				$QryUpdatePlanet .= "`defence_tech` = `defence_tech` ". $accion ." '". $defence_tech ."', ";
				$QryUpdatePlanet .= "`shield_tech` = `shield_tech` ". $accion ." '". $shield_tech ."', ";
				$QryUpdatePlanet .= "`energy_tech` = `energy_tech` ". $accion ." '". $energy_tech ."', ";
				$QryUpdatePlanet .= "`hyperspace_tech` = `hyperspace_tech` ". $accion ." '". $hyperspace_tech ."', ";
				$QryUpdatePlanet .= "`combustion_tech` = `combustion_tech` ". $accion ." '". $combustion_tech ."', ";
				$QryUpdatePlanet .= "`impulse_motor_tech` = `impulse_motor_tech` ". $accion ." '". $impulse_motor_tech ."', ";
				$QryUpdatePlanet .= "`hyperspace_motor_tech` = `hyperspace_motor_tech` ". $accion ." '". $hyperspace_motor_tech ."', ";
				$QryUpdatePlanet .= "`laser_tech` = `laser_tech` ". $accion ." '". $laser_tech ."', ";
				$QryUpdatePlanet .= "`ionic_tech` = `ionic_tech` ". $accion ." '". $ionic_tech ."', ";
				$QryUpdatePlanet .= "`buster_tech` = `buster_tech` ". $accion ." '". $buster_tech ."', ";
				$QryUpdatePlanet .= "`intergalactic_tech` = `intergalactic_tech` ". $accion ." '". $intergalactic_tech ."', ";
				$QryUpdatePlanet .= "`expedition_tech` = `expedition_tech` ". $accion ." '". $expedition_tech ."', ";
				$QryUpdatePlanet .= "`graviton_tech` = `graviton_tech` ". $accion ." '". $graviton_tech ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $id ."' ";
				$db->query( $QryUpdatePlanet, "users");

				message ($lang['ad_sucess'],"admin.php?page=admresource",2);
			}
				$displays->assignContent('adm/editor_research');
			
      		                $displays->display();

		break;

		
		case'oficers':
			$mode      = $_POST['edit'];
			if ($mode == 'addit')
			{
				$id          			= $_POST['id'];
				$rpg_geologue        		= $_POST['rpg_geologue'];
				$rpg_amiral      		= $_POST['rpg_amiral'];
				$rpg_ingenieur          	= $_POST['rpg_ingenieur'];
				$rpg_technocrate         	= $_POST['rpg_technocrate'];
				$rpg_espion     		= $_POST['rpg_espion'];
				$rpg_constructeur         	= $_POST['rpg_constructeur'];
				$rpg_scientifique       	= $_POST['rpg_scientifique'];
				$rpg_commandant                 = $_POST['rpg_commandant'];
				$rpg_stockeur                   = $_POST['rpg_stockeur'];
				$rpg_defenseur                  = $_POST['rpg_defenseur'];
				$rpg_destructeur      		= $_POST['rpg_destructeur'];
				$rpg_general        		= $_POST['rpg_general'];
				$rpg_bunker        		= $_POST['rpg_bunker'];
				$rpg_raideur                    = $_POST['rpg_raideur'];
				$rpg_empereur      	        = $_POST['rpg_empereur'];
                                $accion                         = $_POST['accion'];

				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= "`rpg_geologue` = `rpg_geologue` ". $accion ." '". $rpg_geologue ."', ";
				$QryUpdatePlanet .= "`rpg_amiral` = `rpg_amiral` ". $accion ." '". $rpg_amiral ."', ";
				$QryUpdatePlanet .= "`rpg_ingenieur` = `rpg_ingenieur` ". $accion ." '". $rpg_ingenieur ."', ";
				$QryUpdatePlanet .= "`rpg_technocrate` = `rpg_technocrate` ". $accion ." '". $rpg_technocrate ."', ";
				$QryUpdatePlanet .= "`rpg_espion` = `rpg_espion` ". $accion ." '". $rpg_espion ."', ";
				$QryUpdatePlanet .= "`rpg_constructeur` = `rpg_constructeur` ". $accion ." '". $rpg_constructeur ."', ";
				$QryUpdatePlanet .= "`rpg_scientifique` = `rpg_scientifique` ". $accion ." '". $rpg_scientifique ."', ";
				$QryUpdatePlanet .= "`rpg_commandant` = `rpg_commandant` ". $accion ." '". $rpg_commandant ."', ";
				$QryUpdatePlanet .= "`rpg_stockeur` = `rpg_stockeur` ". $accion ." '". $rpg_stockeur ."', ";
				$QryUpdatePlanet .= "`rpg_defenseur` = `rpg_defenseur` ". $accion ." '". $rpg_defenseur ."', ";
				$QryUpdatePlanet .= "`rpg_destructeur` = `rpg_destructeur` ". $accion ." '". $rpg_destructeur ."', ";
				$QryUpdatePlanet .= "`rpg_general` = `rpg_general` ". $accion ." '". $rpg_general ."', ";
				$QryUpdatePlanet .= "`rpg_bunker` = `rpg_bunker` ". $accion ." '". $rpg_bunker ."', ";
				$QryUpdatePlanet .= "`rpg_raideur` = `rpg_raideur` ". $accion ." '". $rpg_raideur ."', ";
				$QryUpdatePlanet .= "`rpg_empereur` = `rpg_empereur` ". $accion ." '". $rpg_empereur ."' ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`id` = '". $id ."' ";
				$db->query( $QryUpdatePlanet, "users");

				message ($lang['ad_sucess'],"admin.php?page=admresource",2);
			}
			        $displays->assignContent('adm/editor_oficers');
			
      		                $displays->display();
		break;

	case 'planets':
			$mode      = $_POST['edit'];
			if ($mode == 'addit')
		{
        			$id			=	$_POST['id'];
	           		$name			=	$_POST['name'];
		         	$change_id		=	$_POST['change_id'];
	           		$diameter		=	$_POST['diameter'];
	             		$fields			=	$_POST['fields'];
	               		$buildings		=	$_POST['0_buildings'];
	                 	$ships			=	$_POST['0_ships'];
	                  	$defenses		=	$_POST['0_defenses'];
		           	$c_hangar		=	$_POST['0_c_hangar'];
		            	$c_buildings	        =	$_POST['0_c_buildings'];
		             	$change_pos		=	$_POST['change_position'];
			        $galaxy			=	$_POST['g'];
		         	$system			=	$_POST['s'];
		          	$planet			=	$_POST['p'];
		           	$delete			=	$_POST['delete'];

			if ($id != NULL)
			{
			 	if (is_numeric($id))
			 	{

   	                             if ($delete != 'on')
				{
                                        if ($name != NULL){

                       				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
                                                $QryUpdatePlanet .= "`name` =  '". $name ."' ";
                                                $QryUpdatePlanet .= "WHERE ";
                                                $QryUpdatePlanet .= "`id` = '". $id ."' ";
                                                $db->query( $QryUpdatePlanet, "planets");

                                                }

					if ($buildings == 'on'){
                                          
                                                $QryUpdatePlanet  = "UPDATE {{table}} SET ";
                                                $QryUpdatePlanet .= "`metal_mine` =  '0', ";
                                                $QryUpdatePlanet .= "`crystal_mine` =  '0', ";
                                                $QryUpdatePlanet .= "`deuterium_sintetizer` =  '0', ";
                                                $QryUpdatePlanet .= "`solar_plant` =  '0', ";
                                                $QryUpdatePlanet .= "`fusion_plant` =  '0', ";
                                                $QryUpdatePlanet .= "`robot_factory` =  '0', ";
                                                $QryUpdatePlanet .= "`nano_factory` =  '0', ";
                                                $QryUpdatePlanet .= "`hangar` =  '0', ";
                                                $QryUpdatePlanet .= "`metal_store` =  '0', ";
                                                $QryUpdatePlanet .= "`crystal_store` =  '0', ";
                                                $QryUpdatePlanet .= "`deuterium_store` =  '0', ";
                                                $QryUpdatePlanet .= "`laboratory` =  '0', ";
                                                $QryUpdatePlanet .= "`terraformer` =  '0', ";
                                                $QryUpdatePlanet .= "`ally_deposit` =  '0', ";
                                                $QryUpdatePlanet .= "`silo` =  '0', ";
                                                $QryUpdatePlanet .= "`mondbasis` =  '0', ";
                                                $QryUpdatePlanet .= "`phalanx` =  '0', ";
                                                $QryUpdatePlanet .= "`sprungtor` =  '0', ";
                                                $QryUpdatePlanet .= "`last_jump_time` =  '0', ";
                                                $QryUpdatePlanet .= "`field_current` =  '0' ";
                                                $QryUpdatePlanet .= "WHERE ";
                                                $QryUpdatePlanet .= "`id` = '". $id ."' ";
                                                $db->query( $QryUpdatePlanet, "planets");

                                                }

					if ($ships == 'on'){
                                          
                                                $QryUpdatePlanet  = "UPDATE {{table}} SET ";
                                                $QryUpdatePlanet .= "`small_ship_cargo` =  '0', ";
                                                $QryUpdatePlanet .= "`big_ship_cargo` =  '0', ";
                                                $QryUpdatePlanet .= "`light_hunter` =  '0', ";
                                                $QryUpdatePlanet .= "`heavy_hunter` =  '0', ";
                                                $QryUpdatePlanet .= "`crusher` =  '0', ";
                                                $QryUpdatePlanet .= "`battle_ship` =  '0', ";
                                                $QryUpdatePlanet .= "`colonizer` =  '0', ";
                                                $QryUpdatePlanet .= "`recycler` =  '0', ";
                                                $QryUpdatePlanet .= "`spy_sonde` =  '0', ";
                                                $QryUpdatePlanet .= "`bomber_ship` =  '0', ";
                                                $QryUpdatePlanet .= "`solar_satelit` =  '0', ";
                                                $QryUpdatePlanet .= "`destructor` =  '0', ";
                                                $QryUpdatePlanet .= "`dearth_star` =  '0', ";
                                                $QryUpdatePlanet .= "`battleship` =  '0', ";
                                                $QryUpdatePlanet .= "`supernova` =  '0' ";
                                                $QryUpdatePlanet .= "WHERE ";
                                                $QryUpdatePlanet .= "`id` = '". $id ."' ";
                                                $db->query( $QryUpdatePlanet, "planets");

						}

					if ($defenses == 'on'){

                                                $QryUpdatePlanet  = "UPDATE {{table}} SET ";
                                                $QryUpdatePlanet .= "`misil_launcher` =  '0', ";
                                                $QryUpdatePlanet .= "`small_laser` =  '0', ";
                                                $QryUpdatePlanet .= "`big_laser` =  '0', ";
                                                $QryUpdatePlanet .= "`gauss_canyon` =  '0', ";
                                                $QryUpdatePlanet .= "`ionic_canyon` =  '0', ";
                                                $QryUpdatePlanet .= "`buster_canyon` =  '0', ";
                                                $QryUpdatePlanet .= "`small_protection_shield` =  '0', ";
                                                $QryUpdatePlanet .= "`planet_protector` =  '0', ";
                                                $QryUpdatePlanet .= "`big_protection_shield` =  '0', ";
                                                $QryUpdatePlanet .= "`interceptor_misil` =  '0', ";
                                                $QryUpdatePlanet .= "`interceptor_misil` =  '0' ";
                                                $QryUpdatePlanet .= "WHERE ";
                                                $QryUpdatePlanet .= "`id` = '". $id ."' ";
                                                $db->query( $QryUpdatePlanet, "planets");

						}

					if ($c_hangar == 'on'){
                                          
                                                $QryUpdatePlanet  = "UPDATE {{table}} SET ";
                                                $QryUpdatePlanet .= "`b_hangar` =  '0', ";
                                                $QryUpdatePlanet .= "`b_hangar_plus` =  '0', ";
                                                $QryUpdatePlanet .= "`b_hangar_id` =  '' ";
                                                $QryUpdatePlanet .= "WHERE ";
                                                $QryUpdatePlanet .= "`id` = '". $id ."' ";
                                                $db->query( $QryUpdatePlanet, "planets");

						}

					if ($c_buildings == 'on'){
                                          
                                                $QryUpdatePlanet  = "UPDATE {{table}} SET ";
                                                $QryUpdatePlanet .= "`b_building` =  '0', ";
                                                $QryUpdatePlanet .= "`b_building_id` =  '' ";
                                                $QryUpdatePlanet .= "WHERE ";
                                                $QryUpdatePlanet .= "`id` = '". $id ."' ";
                                                $db->query( $QryUpdatePlanet, "planets");

						}

					if ($diameter != NULL && is_numeric($diameter) && $diameter > 0){

                                                $QryUpdatePlanet  = "UPDATE {{table}} SET ";
                                                $QryUpdatePlanet .= "`diameter` =  '".$diameter."' ";
                                                $QryUpdatePlanet .= "WHERE ";
                                                $QryUpdatePlanet .= "`id` = '". $id ."' ";
                                                $db->query( $QryUpdatePlanet, "planets");

						}

					if ($fields != NULL && is_numeric($fields) && $fields > 0){
                                          
                                                $QryUpdatePlanet  = "UPDATE {{table}} SET ";
                                                $QryUpdatePlanet .= "`field_max` =  '".$fields."' ";
                                                $QryUpdatePlanet .= "WHERE ";
                                                $QryUpdatePlanet .= "`id` = '". $id ."' ";
                                                $db->query( $QryUpdatePlanet, "planets");

						}
						
				 	$P	=	$db->query("SELECT * FROM {{table}} WHERE `id` = '".$id."'", "planets", true);


					if ($change_pos == 'on')
					{
						if (is_numeric($galaxy) && is_numeric($system) && is_numeric($planet) && $galaxy > 0 && $system > 0 && $planet > 0 &&
							$galaxy <= MAX_GALAXY_IN_WORLD && $system <= MAX_SYSTEM_IN_GALAXY && $planet <= MAX_PLANET_IN_SYSTEM)
						{
							$Queryyy	=	$db->query("SELECT * FROM {{table}} WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND
											`planet` = '".$planet."'", "galaxy", true);

							if ($P['planet_type'] == '1')
							{
								if (!$Queryyy)
								{
									if ($Queryyy['id_luna'] != '0')
									{
										$db->query ("UPDATE {{table}} SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."' WHERE
										`galaxy` = '".$P['galaxy']."' AND `system` = '".$P['system']."' AND `planet` = '".$P['planet']."' AND `planet_type` = '3'", "planets");
									}

									$db->query ("UPDATE {{table}} SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."' WHERE
										`id` = '".$id."'", "planets");

									$db->query ("UPDATE {{table}} SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."' WHERE
										`id_planet` = '".$id."'", "galaxy");

									$Name	=	$lang['log_planet_pos'];
								}
								else
								{
									$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_pla_error_planets3'].'</font></th></tr>';
								}
							}
							elseif ($P['planet_type'] == '3')
							{
								if ($Queryyy)
								{
									if ($Queryyy['id_luna'] == '0')
									{
										$db->query ("UPDATE {{table}} SET `id_luna` = '0' WHERE `galaxy` = '".$P['galaxy']."' AND `system` = '".$P['system']."' AND
											`planet` = '".$P['planet']."'", "galaxy");

										$db->query ("UPDATE {{table}} SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."',
										`id_luna` = '".$id."' WHERE `id_planet` = '".$Queryyy['id_planet']."'", "galaxy");

										$QMOON2	=	doquery("SELECT * FROM {{table}} WHERE `galaxy` = '".$galaxy."' AND `system` = '".$system."' AND
										`planet` = '".$planet."'", "planets", true);

										$db->query ("UPDATE {{table}} SET `galaxy` = '".$galaxy."', `system` = '".$system."', `planet` = '".$planet."',
										`id_owner` = '".$QMOON2['id_owner']."', `id_level` = '".$QMOON2['id_level']."' WHERE `id` = '".$id."' AND `planet_type` = '3'", "planets");
										$Name	=	$lang['log_moon_pos'];
									}
									else
									{
										$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_pla_error_planets4'].'</font></th></tr>';
									}
								}
								else
								{
									$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_pla_error_planets5'].'</font></th></tr>';
								}
							}

							$Log	.=	$lang['log_change_pla_pos'].$Name.": [".$galaxy.":".$system.":".$planet."]\n";
						}
						else
						{
							$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_only_numbers'].'</font></th></tr>';
						}
					}

				}
				

				else
				{
					$QueryPlanetsS	=	$db->query("SELECT planet_type FROM {{table}} WHERE id = '".$id."'", "planets", true);
					if ($QueryPlanetsS['planet_type'] == '1')
					{
						$db->query("DELETE FROM {{table}} WHERE id = '".$id."'", "planets");
						$db->query("DELETE FROM {{table}} WHERE id_planet = '".$id."'", "galaxy");
					}
					else
					{
						$db->query("DELETE FROM {{table}} WHERE id = '".$id."'", "planets");
						$db->query("UPDATE {{table}} SET id_luna = '0', luna = '0' WHERE id_luna = '".$id."'", "galaxy");
					}

					$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_pla_delete_planet_s'].'</font></th></tr>';
				}



     }
    	else
			 	{
					$parse['display']	=	'<tr><th colspan="3"><font color=red>'.$lang['only_numbers'].'</font></th></tr>';
			 	}
   }
			else
			{
				$parse['display']	=	'<tr><th colspan="3"><font color=red>'.$lang['ad_forgiven_id'].'</font></th></tr>';
			}
                                        message ($lang['ad_sucess'],"admin.php?page=admresource",2);

 	}

			        $displays->assignContent('adm/editor_planets');

      		                $displays->display();
	break;
	
	case 'users':
	
			$mode      = $_POST['edit'];
			if ($mode == 'addit')
		{

        			$id		        = $_POST['id'];
	           		$username		= $_POST['username'];
		         	$password		= $_POST['password'];
	           		$email	                = $_POST['email'];
	             		$email2		        = $_POST['email2'];
	             		$activate		= $_POST['activate'];
	             		$dpath		        = $_POST['dpath'];
	             		$design		        = $_POST['design'];
	             		$noipcheck	        = $_POST['noipcheck'];
                                $authlevel              = $_POST['authlevel'];
	               		$vacations         	= $_POST['vacations'];
	               		$d         		= $_POST['d'];
	               		$h         		= $_POST['h'];



                                        $QueryUsers     = "UPDATE {{table}} SET ";
				if($username != NULL){
					$QueryUsers    .= "`username` = '".$username."', ";
					}
					
				if($password != NULL){
					$QueryUsers    .= "`password` = '".md5($password)."', ";
                                        }

				if($email != NULL){
					$QueryUsers    .= "`email` = '".$email."', ";
					}

				if($email_2 != NULL){
					$QueryUsers    .= "`email_2` = '".$email2."', ";
					}
					
				if($activate != ''){
					if ($activate == 'yes')
					{
					$QueryUsers    .= "`activate_status` = '1', ";
					}

					elseif ($activate == 'no')
					{
					$QueryUsers    .= "`activate_status` = '0', ";
					}
                                     }

				
				if($dpath != NULL){
					$QueryUsers    .= "`dpath` = '".$dpath."', ";
					}
					
				if($design != ''){
					if ($design == 'no')
					{
					$QueryUsers    .= "`design` = '0', ";
					}

					elseif ($design == 'yes')
					{
					$QueryUsers    .= "`design` = '1', ";
					}
                                     }
				if($noipcheck != ''){

					if ($noipcheck == 'no')
					{
					$QueryUsers    .= "`noipcheck` = '0', ";
					}

					elseif ($noipcheck == 'yes')
					{
					$QueryUsers    .= "`noipcheck` = '1', ";
					}
                                     }
				if($authlevel != NULL){
					$QueryUsers    .= "`authlevel` = '".$authlevel."', ";
					}

				if($vacations != '')
				{
					if ($vacations == 'no')
					{
						$Vacation   =    0;
						$TimeAns    =    0;
					}
					elseif ($vacations == 'yes')
					{
						$Vacation   =    1;
						$VTime      =    ($d * 86400)+($h * 3600);
						$TimeAns    =    $VTime + time();
					}

					$QueryUsers    .= "`urlaubs_modus` = '".$Vacation."', ";
                                        $QueryUsers    .= "`urlaubs_until` = '".$TimeAns."' ";
				}
				else {
					$QueryUsers    .= "`onlinetime` = '".time()."' ";
                                     }


					$QueryUsers    .= "WHERE ";
                                        $QueryUsers    .= "`id` = '".$id."' ";
					$db->query($QueryUsers, "users");

                                        message ($lang['ad_sucess'],"admin.php?page=admresource",2);

  }

			        $displays->assignContent('adm/editor_users');

      		                $displays->display();


	break;
	
	
	case 'alliances':
			$mode      = $_POST['edit'];
			if ($mode == 'addit')
		{
			$id			=	$_POST['id'];
			$name			=	$_POST['name'];
			$changeleader	        =	$_POST['changeleader'];
			$tag			=	$_POST['tag'];
			$externo		=	$_POST['externo'];
			$interno		=	$_POST['interno'];
			$solicitud		=	$_POST['solicitud'];
			$delete			=	$_POST['delete'];
			$delete_u		=	$_POST['delete_u'];

			if ($id != NULL)
			{
				$QueryF	=	$db->query("SELECT * FROM {{table}} WHERE `id` = '".$id."'", "alliance", true);

			 	if ($QueryF)
			 	{

					if ($name != NULL){
						$db->query("UPDATE {{table}} SET `ally_name` = '".$name."' WHERE `id` = '".$id."'", "alliance");
						$db->query("UPDATE {{table}} SET `ally_name` = '".$name."' WHERE `ally_id` = '".$id."'", "users");
						}

					if ($tag != NULL){
						$db->query("UPDATE {{table}} SET `ally_tag` = '".$tag."' WHERE `id` = '".$id."'", "alliance");
						}


					$i	=	0;
					$QueryF2	=	$db->query("SELECT * FROM {{table}} WHERE `id` = '".$changeleader."'", "users", true);
					if ($QueryF2 && $changeleader != NULL && $QueryF2['ally_id'] == $id){
						$db->query("UPDATE {{table}} SET `ally_owner` = '".$changeleader."' WHERE `id` = '".$id."'", "alliance");
						$db->query("UPDATE {{table}} SET `ally_rank_id` = '0' WHERE `id` = '".$changeleader."'", "users");
						}
					elseif (!$QueryF2 && $changeleader != NULL){
						$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_ally_not_exist3'].'</font></th></tr>';
						$i++;}

					if ($externo != NULL){
						$db->query("UPDATE {{table}} SET `ally_description` = '".$externo."' WHERE `id` = '".$id."'", "alliance");
						}

					if ($interno != NULL){
						$db->query("UPDATE {{table}} SET `ally_text` = '".$interno."' WHERE `id` = '".$id."'", "alliance");
						}

					if ($solicitud != NULL){
						$db->query("UPDATE {{table}} SET `ally_request` = '".$solicitud."' WHERE `id` = '".$id."'", "alliance");
						}

					if ($delete == 'on'){
						$db->query("DELETE FROM {{table}} WHERE `id` = '".$id."'", "alliance");
						$db->query("UPDATE {{table}} SET `ally_id` = '0', `ally_name` = '', `ally_request` = '0', `ally_rank_id` = '0', `ally_register_time` = '0',
							`ally_request` = '0' WHERE `ally_id` = '".$id."'", "users");
						}



					$QueryF3	=	$db->query("SELECT * FROM {{table}} WHERE `id` = '".$delete_u."'", "users", true);
					if ($QueryF3 && $delete_u != NULL){
						$db->query("UPDATE {{table}} SET `ally_members` = ally_members - 1 WHERE `id` = '".$id."'", "alliance");
						$db->query("UPDATE {{table}} SET `ally_id` = '0', `ally_name` = '', `ally_request` = '0', `ally_rank_id` = '0', `ally_register_time` = '0',
							`ally_request` = '0' WHERE `id` = '".$delete_u."' AND `ally_id` = '".$id."'", "users");
						}
					elseif (!$QueryF3 && $delete_u != NULL){
						$Error	.=	'<tr><th colspan="3"><font color=red>'.$lang['ad_ally_not_exist2'].'</font></th></tr>';
						$i++;}

					if ($i == 0)
						$parse['display']	=	'<tr><th colspan="3"><font color=lime>'.$lang['ad_ally_succes'].'</font></th></tr>';
					else
						$parse['display']	=	$Error;

			 	}
			 	else
			 	{
                                        message ($lang['ad_ally_not_exist'],"admin.php?page=admresource&mode=alliances",2);
			 	}
			}
			else
			{
                                message ($lang['ad_forgiven_id'],"admin.php?page=admresource&mode=alliances",2);
			}
                                 message ($lang['ad_sucess'],"admin.php?page=admresource",2);

		}
                		$displays->assignContent('adm/editor_alliances');
                		
      		                $displays->display();

	break;



		default:

                		$displays->assignContent('adm/editor');
                		
      		                $displays->display();


	}
}
?>