<?php

/**
 * moonlist.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
global $Adminerlaubt;

    if ( $user['authlevel'] >= 1 and in_array ($user['id'],$Adminerlaubt) ) {
	includeLang('admin');

	$parse = $lang;
	$query = doquery("SELECT * FROM {{table}} WHERE planet_type='3' ORDER BY id ASC", "planets");
	$i = 0;
	while ($u = mysql_fetch_array($query)) {
		$parse['moon'] .= "<tr>"
		. "<td class=b><center><b><a href='moonlist.php?action=edit&id=".$u['id'] ."'>" . $u[0] . "</center></b></td>"
		. "<td class=b><center><b><a href='moonlist.php?action=edit&id=".$u['id'] ."'>" . $u[1] . "</center></b></td>"
		. "<td class=b><center><b><a href='moonlist.php?action=edit&id=".$u['id'] ."'>" . $u[2] . "</center></b></td>"
		. "<td class=b><center><b><a href='moonlist.php?action=edit&id=".$u['id'] ."'>" . $u[18] . "</center></b></td>"
		. "<td class=b><center><b><a href='moonlist.php?action=edit&id=".$u['id'] ."'>" . $u[4] . "</center></b></td>"
		. "<td class=b><center><b><a href='moonlist.php?action=edit&id=".$u['id'] ."'>" . $u[5] . "</center></b></td>"
		. "<td class=b><center><b><a href='moonlist.php?action=edit&id=".$u['id'] ."'>" . $u[6] . "</center></b></td>"
		. "</tr>";
		$i++;
	}

	if ($i == 1) {
		$parse['moon'] .= "<tr><th class=b colspan=7>Es wurde 1 Mond gefunden</th></tr>";
	}else{
		$parse['moon'] .= "<tr><th class=b colspan=7>Es wurden {$i} Monde gefunden</th></tr>";
	}

	if(isset($_GET['action']) && isset($_GET['id'])) {
		$id = intval($_GET['id']);
		$query  = doquery("SELECT * FROM {{table}} WHERE planet_type=3 AND id='".$id."' LIMIT 1", "planets");
		$planet = mysql_fetch_array($query);
		$parse['show_edit_form'] = parsetemplate(gettemplate('admin/moon_edit_form'),$planet);
	}
	if(isset($_POST['submit'])) {

		$edit_id 	= intval($_POST['currid']);
		$planetname = mysql_real_escape_string($_POST['mondname']);
		$fields_max = intval($_POST['felder']);
		$query = doquery("UPDATE {{table}} SET
							`name` 				= '".$planetname."', 
							`field_max` 		= '".$fields_max."',
							`metal`				= '".intval($_POST['metal'])."',
							`crystal`			= '".intval($_POST['crystal'])."',
							`deuterium`			= '".intval($_POST['deuterium'])."', 
							`appolonium`		= '".intval($_POST['appolonium'])."', 
							`small_ship_cargo` 	= '".intval($_POST['small_ship_cargo'])."', 
							`big_ship_cargo` 	= '".intval($_POST['big_ship_cargo'])."', 
							`light_hunter`		= '".intval($_POST['light_hunter'])."', 
							`heavy_hunter`		= '".intval($_POST['heavy_hunter'])."', 
							`crusher`			= '".intval($_POST['crusher'])."', 
							`battle_ship`		= '".intval($_POST['battle_ship'])."', 
							`colonizer`			= '".intval($_POST['colonizer'])."', 
							`recycler`			= '".intval($_POST['recycler'])."', 
							`spy_sonde`			= '".intval($_POST['spy_sonde'])."', 
							`bomber_ship`		= '".intval($_POST['bomber_ship'])."', 
							`solar_satelit`		= '".intval($_POST['solar_satelit'])."', 
							`destructor`		= '".intval($_POST['destructor'])."', 
							`dearth_star`		= '".intval($_POST['dearth_star'])."', 
							`battleship`		= '".intval($_POST['battleship'])."',
							`lune_noir`		    = '".intval($_POST['lune_noir'])."',
							`ev_transporter`    = '".intval($_POST['ev_transporter'])."',
							`star_crasher`		= '".intval($_POST['star_crasher'])."',
							`giga_recykler`		= '".intval($_POST['giga_recykler'])."',
							`misil_launcher`	= '".intval($_POST['misil_launcher'])."',
							`small_laser`		= '".intval($_POST['small_laser'])."',
							`big_laser`			= '".intval($_POST['big_laser'])."',
							`gauss_canyon`		= '".intval($_POST['gauss_canyon'])."',
							`ionic_canyon`		= '".intval($_POST['ionic_canyon'])."',
							`buster_canyon`		= '".intval($_POST['buster_canyon'])."',
							`Gravitonka`		= '".intval($_POST['Gravitonka'])."',
							`small_protection_shield` 	= '".intval($_POST['small_protection_shield'])."',
							`big_protection_shield` 	= '".intval($_POST['big_protection_shield'])."',
							`gig_protection_shield` 	= '".intval($_POST['gig_protection_shield'])."',
							`robot_factory`				= '".intval($_POST['robot_factory'])."',
							`hangar`					= '".intval($_POST['hangar'])."',
	                        `nano_factory`				= '".intval($_POST['nano_factory'])."',
							`appolonium_store`		    = '".intval($_POST['appolonium_store'])."',
							`ally_deposit`				= '".intval($_POST['ally_deposit'])."',
							`phalanx`					= '".intval($_POST['phalanx'])."',
							`mondbasis`					= '".intval($_POST['mondbasis'])."',
							`ressgate`					= '".intval($_POST['ressgate'])."',
							`sprungtor`					= '".intval($_POST['sprungtor'])."'
							 WHERE `id` = '".$edit_id."' LIMIT 1",'planets');

		// AdminLOG - Helmchen
           $fp = @fopen('logs/adminlog_'.date('d.m.Y').'.php','a');
           fwrite($fp, " <?php\n");
           fwrite($fp, "if(!defined(\"INSIDE\")){ die(\"attemp hacking\"); }\n");
           fwrite($fp, "\$Logtext = ' \n");
           fwrite($fp,date("d.m.Y H:i:s",time())." - ".$user['username']." - ".$user['user_lastip']." - ".__FILE__." - changed values from moon ID ".$id." with user ID: ".$user['id']."';\n");
           fwrite($fp, " ?>\n");
           fclose($fp);
          // AdminLOG ENDE
		
		AdminMessage ('<meta http-equiv="refresh" content="1; url=moonlist.php">Mond wurde erfolgreich geaendert', 'Mond anpassen');
	}

	display(parsetemplate(gettemplate('admin/moonlist_body'), $parse), 'Lunalist' , false, '', true);

} else {
	message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
}
?>