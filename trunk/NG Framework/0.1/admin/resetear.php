<?php
	//######################################################//
	//# Name:      resetear.php 						   #//
    //# Authors:   SainT  								   #//
	//# Copyright: OgameRC.com 							   #//
	//# Website:   http://www.xnova.saint-rc.es            #//
	//######################################################//
	
	define('INSIDE'  , true); //Definimos inside como verdadero
	define('INSTALL' , false); //Definimos install como falso. 
	define('IN_ADMIN', true); //Definimos IN_ADMIN como verdadero

	$ugamela_root_path = '../'; //Definimos la variable $ugamela_root_path como un la ruta principal
	include($ugamela_root_path . 'extension.inc'); //incluimos el archivo extension.inc
	include($ugamela_root_path . 'common.' . $phpEx); //incluimos el archivo common ($phpEx es la extension dada en extenxsion.inc)
	
	includeLang('admin'); //Incluimos el archivo del lenguaje
		
		//Si no tiene permiso no entra
	if ($IsUserChecked == false || $user['authlevel'] < 2) {
		message($lang['sys_noalloaw'], $lang['sys_noaccess']);
	}
	
	if(isset($_POST['resetear'])) { //Si le dieron a resetear.
	
	//mensaje a mostrar
	$parse['mensaje'] .= "<tr>";
	$parse['mensaje'] .= "<td class=\"mensaje\" colspan=\"4\">Universo Reseteado Correctamente</td>";
	$parse['mensaje'] .= "</tr>";
	
	if($_POST['usuarios'] == 1) { //Si se resetea usuarios
	doquery("DELETE FROM {{table}} WHERE id>1;","users"); //Se borra todo menos la cuenta de admin
	doquery("DELETE FROM {{table}} WHERE id>1;","planets"); //Se borra todo menos el planeta de admin
	doquery("DELETE FROM {{table}} WHERE id_planet>1;","galaxy"); //Se borra todo menos el planeta de admin en la galaxy
	doquery("UPDATE {{table}} SET id_luna='0'","galaxy"); //kitamos la luna
	
	}
	if($_POST['Edificios'] == 1) { //edificios.
	//ponemos todo a 0
	$consulta ="UPDATE {{table}} ";
	$consulta .="SET `metal_mine` = '0',";
	$consulta .="`crystal_mine` = '0',";
	$consulta .="`deuterium_sintetizer` = '0',";
	$consulta .="`solar_plant` = '0',";
	$consulta .="`fusion_plant` = '0',";
	$consulta .="`robot_factory` = '0',";
	$consulta .="`nano_factory` = '0',";
	$consulta .="`hangar` = '0',";
	$consulta .="`metal_store` = '0',";
	$consulta .="`crystal_store` = '0',";
	$consulta .="`deuterium_store` = '0',";
	$consulta .="`laboratory` = '0',";
	$consulta .="`terraformer` = '0',";
	$consulta .="`ally_deposit` = '0',";
	$consulta .="`silo` = '0';";
	doquery($consulta,"planets");
	}
		if($_POST['tecnologias'] == 1) { //Tecnologias.
	//ponemos todo a 0
	$consulta ="UPDATE {{table}} ";
	$consulta .=" SET `spy_tech` = '0',";
	$consulta .="`computer_tech` = '0',";
	$consulta .="`military_tech` = '0',";
	$consulta .="`defence_tech` = '0',";
	$consulta .="`shield_tech` = '0',";
	$consulta .="`energy_tech` = '0',";
	$consulta .="`hyperspace_tech` = '0',";
	$consulta .="`combustion_tech` = '0',";
	$consulta .="`impulse_motor_tech` = '0',";
	$consulta .="`hyperspace_motor_tech` = '0',";
	$consulta .="`laser_tech` = '0',";
	$consulta .="`ionic_tech` = '0',";
	$consulta .="`buster_tech` = '0',";
	$consulta .="`intergalactic_tech` = '0',";
	$consulta .="`expedition_tech` = '0',";
	$consulta .="`graviton_tech` = '0';";
	doquery($consulta,"users");
	}
		if($_POST['flotas'] == 1) { //flotas
	//ponemos todo a 0
	$consulta ="UPDATE {{table}} ";
	$consulta .=" SET `small_ship_cargo` = '0',";
	$consulta .="`big_ship_cargo` = '0',";
	$consulta .="`light_hunter` = '0',";
	$consulta .="`heavy_hunter` = '0',";
	$consulta .="`crusher` = '0',";
	$consulta .="`battle_ship` = '0',";
	$consulta .="`colonizer` = '0',";
	$consulta .="`recycler` = '0',";
	$consulta .="`spy_sonde` = '0',";
	$consulta .="`bomber_ship` = '0',";
	$consulta .="`solar_satelit` = '0',";
	$consulta .="`destructor` = '0',";
	$consulta .="`dearth_star` = '0',";
	$consulta .="`battleship` = '0';";
	doquery($consulta,"planets");
	}
	//Salon de la fama, borramos todo
	if($_POST['Fama'] == 1) { doquery("TRUNCATE {{table}}","topkb"); }
	
		if($_POST['Defensas'] == 1) { //Defensas
	//ponemos todo a 0
	$consulta = "UPDATE {{table}} ";
	$consulta .=" SET `misil_launcher` = '0',";
	$consulta .="`small_laser` = '0',";
	$consulta .="`big_laser` = '0',";
	$consulta .="`gauss_canyon` = '0',";
	$consulta .="`ionic_canyon` = '0',";
	$consulta .="`buster_canyon` = '0',";
	$consulta .="`small_protection_shield` = '0',";
	$consulta .="`big_protection_shield` = '0',";
	$consulta .="`interceptor_misil` = '0',";
	$consulta .="`interplanetary_misil = '0';";
	doquery($consulta,"planets");
	}
	//Alianzas
	if($_POST['Alianzas'] == 1) { 
	doquery("TRUNCATE {{table}}","alliance"); 
	doquery("UPDATE {{table}} SET ally_id='0', ally_name='', ally_request='0', ally_request_text='NULL', ally_register_time='0', ally_rank_id='0'","users"); 
	} 	 	 	
	//Lunas
	if($_POST['Lunas'] == 1) { doquery("TRUNCATE {{table}} where planet_type='3'","planets"); doquery("UPDATE {{table}} SET id_luna='0'","galaxy"); }
	//Menu 
	if($_POST['Alianzas'] == 1) { 
		doquery("TRUNCATE {{table}}","Menu"); 
		//datos menu
	$QryInsertMenu       .= "INSERT INTO `game_menu` (`id`, `nombre`, `link`, `orden`, `lang`) VALUES";
	$QryInsertMenu       .= "(1, 'devlp', '', '1', '0'), ";
	$QryInsertMenu       .= "(2, 'Overview', 'overview.php', '2', '0'), ";
	$QryInsertMenu       .= "(3, 'Buildings', 'buildings.php', '3', '0'), ";
	$QryInsertMenu       .= "(4, 'Research', 'buildings.php?mode=research', '4', '0'), ";
	$QryInsertMenu       .= "(5, 'Shipyard', 'buildings.php?mode=fleet', '5', '0'), ";
	$QryInsertMenu       .= "(6, 'Defense', 'buildings.php?mode=defense', '6', '0'), ";
	$QryInsertMenu       .= "(7, 'Officiers', 'officier.php', '7', '0'), ";
	$QryInsertMenu       .= "(8, 'Marchand', 'marchand.php', '8', '0'), ";
	$QryInsertMenu       .= "(31, 'Loteria', 'loteria.php', '9', '1'),";
	$QryInsertMenu       .= "(9, 'navig', '', '10', '0'), ";
	$QryInsertMenu       .= "(10, 'Alliance', 'alliance.php', '11', '0'), ";
	$QryInsertMenu       .= "(11, 'Fleet', 'fleet.php', '12', '0'), ";
	$QryInsertMenu       .= "(12, 'Messages', 'messages.php', '13', '0'), ";
	$QryInsertMenu       .= "(13, 'observ', '', '14', '0'), ";
	$QryInsertMenu       .= "(14, 'Galaxy', 'galaxy.php?mode=0', '15', '0'), ";
	$QryInsertMenu       .= "(15, 'Imperium', 'imperium.php', '16', '0'), ";
	$QryInsertMenu       .= "(16, 'Resources', 'resources.php', '17', '0'), ";
	$QryInsertMenu       .= "(17, 'Technology', 'techtree.php', '18', '0'), ";
	$QryInsertMenu       .= "(18, 'Records', 'records.php', '19', '0'), ";
	$QryInsertMenu       .= "(33, 'Salon de la fama', 'topkb.php', '20', '1'),";
	$QryInsertMenu       .= "(19, 'Statistics', 'stat.php?start=', '21', '0'), ";
	$QryInsertMenu       .= "(20, 'Search', 'search.php', '22', '0'), ";
	$QryInsertMenu       .= "(21, 'blocked', 'banned.php', '23', '0'), ";
	$QryInsertMenu       .= "(22, 'Annonces', 'annonce.php', '24', '0'), ";
	$QryInsertMenu       .= "(23, 'commun', '', '25', '0'), ";
	$QryInsertMenu       .= "(24, 'Buddylist', 'buddy.php', '26', '0'), ";
	$QryInsertMenu       .= "(25, 'Notes', 'notes.php', '27', '0'), ";
	$QryInsertMenu       .= "(26, 'Chat', 'chat.php', '28', '0'), ";
	$QryInsertMenu       .= "(32, 'Referidos', 'refers.php', '29', '1'),";
	$QryInsertMenu       .= "(27, 'Board', 'Foro.php', '30', '0'), ";
	$QryInsertMenu       .= "(28, 'Contact', 'contact.php', '31', '0'), ";
	$QryInsertMenu       .= "(29, 'support_system', 'support.php', '32', '0'), ";
	$QryInsertMenu       .= "(30, 'Options', 'options.php', '33', '0');";
	doquery($QryInsertMenu,"menu");
	}
	//Referidos
	if($_POST['Referidos'] == 1) { doquery("UPDATE {{table}} SET refer=''","users"); }
	
	//Planetas Principales
	if($_POST['Principales'] == 1) { 
	$planetas = doquery("select * FROM {{table}} where planet_type='2'","planets"); 
	while ($row = mysql_fetch_assoc($planetas)) {
	doquery("DELETE FROM {{table}} WHERE id_planet='{$row['id']}';","galaxy"); 
	}
	doquery("TRUNCATE {{table}} where planet_type='2'","planets"); 
	
	}
	
	//Sancionados 
	if($_POST['Sancionados'] == 1) { doquery("TRUNCATE {{table}}","banned"); }
	
		doquery( "TRUNCATE TABLE {{table}}", 'aks');
		doquery( "TRUNCATE TABLE {{table}}", 'annonce');
		doquery( "TRUNCATE TABLE {{table}}", 'buddy');
		doquery( "TRUNCATE TABLE {{table}}", 'chat');
		doquery( "TRUNCATE TABLE {{table}}", 'errors');
		doquery( "TRUNCATE TABLE {{table}}", 'fleets');
		doquery( "TRUNCATE TABLE {{table}}", 'iraks');
		doquery( "TRUNCATE TABLE {{table}}", 'messages');
		doquery( "TRUNCATE TABLE {{table}}", 'notes');
		doquery( "TRUNCATE TABLE {{table}}", 'rw');
		doquery( "TRUNCATE TABLE {{table}}", 'statpoints');
	
	} //FIN Comprobacion

	
		//Finalizamos el Parsing
	$tpl_menu = gettemplate('admin/resetear_body'); //Definimos el tpl a usar
	$menu = parsetemplate($tpl_menu, $parse); 
	display($menu, 'Optimizar la base de datos', '', false);

?>