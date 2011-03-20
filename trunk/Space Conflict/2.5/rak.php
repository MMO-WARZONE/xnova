<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** rak.php                               **
******************************************/

if (!defined('INSIDE')) {
	die("Hacking attempt");
}

if (file_exists($xnova_root_path . "includes/raketenangriff.php")) {
	include($xnova_root_path . "includes/raketenangriff.php");
} elseif (file_exists("includes/raketenangriff.php")) {
	include("./includes/raketenangriff.php");
} elseif (file_exists("../includes/raketenangriff.php")) {
	include("../includes/raketenangriff.php");
} else
	die('Fatal error!');

if (isset($resource) && !empty($resource[401])) {
	$iraks = doquery("SELECT * FROM {{table}} WHERE zeit <= '" . time() . "'", 'iraks');

	while ($selected_row = mysql_fetch_array($iraks)) {
		if ($selected_row['zeit'] != '' && $selected_row['galaxy'] != '' && $selected_row['system'] != '' && $selected_row['planet'] != '' && is_numeric($selected_row['owner']) && is_numeric($selected_row['zielid']) && is_numeric($selected_row['anzahl']) && !empty($selected_row['anzahl'])) {
			$planetrow = doquery("SELECT * FROM {{table}} WHERE
								galaxy = '" . $selected_row['galaxy'] . "' AND
								system = '" . $selected_row['system'] . "' AND
								planet = '" . $selected_row['planet'] . "'", 'planets');

			$select_ziel = doquery("SELECT defence_tech FROM {{table}} WHERE
								id = '" . $selected_row['zielid'] . "'", 'users');

			$select_owner = doquery("SELECT military_tech FROM {{table}} WHERE
								id = '" . $selected_row['owner'] . "'", 'users');

			if (mysql_num_rows($planetrow) != 1 OR mysql_num_rows($select_ziel) != 1) {
				doquery("DELETE FROM {{table}} WHERE id = '" . $selected_row['id'] . "'", 'iraks');
			} else {
				$verteidiger = mysql_fetch_array($select_ziel);
				$angreifer = mysql_fetch_array($select_owner);
				$planet = mysql_fetch_array($planetrow);

				$ids = array(0 => 401,
					1 => 402,
					2 => 403,
					3 => 404,
					4 => 405,
					5 => 406,
					6 => 407,
					7 => 408,
					8 => 409,
					9 => 502,
					10 => 503
					);

				$def =
				array(0 => $planet['misil_launcher'], 
					1 => $planet['small_laser'], 
					2 => $planet['big_laser'],
					3 => $planet['gauss_canyon'], 
					4 => $planet['ionic_canyon'], 
					5 => $planet['buster_canyon'], 
					6 => $planet['small_protection_shield'], 
					7 => $planet['big_protection_shield'], 
					8 => $planet['orb_def_plat'], 
					9 => $planet['interplanetary_misil'], 
					10 => $planet['interceptor_misil'], 
					);

				$lang =
				array(0 => "Missile Launcher",
					1 => "Light Laser",
					2 => "Heavy Laser",
					3 => "Gauss Cannon",
					4 => "Ion Cannon",
					5 => "Plasma Cannon",
					6 => "Small Shield Dome",
					7 => "Large Shield Dome",
					8 => "Orbital Defense Platform",
					9 => "Interceptor Missiles",
					10 => "Interplanetary Missiles"
					);

				$irak = raketenangriff($verteidiger['defence_tech'], $angreifer['military_tech'], $selected_row['anzahl'], $def, $selected_row['primaer']);

				$message = '';

				if ($planet['interceptor_misil'] >= $selected_row['anzahl']) {
					$message = 'The interceptor missile destroyed your opponent Interplanetary Missile<br>';

					$x = $resource[$ids[9]];

					doquery("UPDATE {{table}} SET " . $x . " = " . $x . "-" . $selected_row['anzahl'] . " WHERE id = " . $planet['id'], 'planets');
				} else {
					if ($planet['interceptor_misil'] > 0) {
						$x = $resource[$ids[9]];

						doquery("UPDATE {{table}} SET " . $x . " = '0' WHERE id = " . $planet['id'], 'planets');

						$message = $planet['interceptor_misil'] . " Interplanetary Missiles have been intercepted.<br>";
					}

					foreach ($irak['zerstoert'] as $id => $anzahl) {
						if (!empty($anzahl) && $id < 10) {
							if ($id != 9)
								$message .= $lang[$id] . " (- " . $anzahl . ")<br>";

							$x = $resource[$ids[$id]];

							doquery("UPDATE {{table}} SET " . $x . " = " . $x . "-" . $anzahl . " WHERE id = " . $planet['id'], 'planets');
						}
					}
				}

				$planet_ = doquery("SELECT * FROM {{table}} WHERE
								galaxy = '" . $selected_row['galaxy_angreifer'] . "' AND
								system = '" . $selected_row['system_angreifer'] . "' AND
								planet = '" . $selected_row['planet_angreifer'] . "'", 'planets');

				if (mysql_num_rows($planet_) == 1) {
					$array = mysql_fetch_array($planet_);

					$name = $array['name'];
				}

				$planet_2 = doquery("SELECT * FROM {{table}} WHERE
								galaxy = '" . $selected_row['galaxy'] . "' AND
								system = '" . $selected_row['system'] . "' AND
								planet = '" . $selected_row['planet'] . "'", 'planets');

				if (mysql_num_rows($planet_2) == 1) {
					$array = mysql_fetch_array($planet_2);

					$name_deffer = $array['name'];
				}

				$message_vorlage  = 'Missile attack (' . $selected_row['anzahl'] . ') from ' . $name . ' <a href="galaxy.php?mode=3&galaxy=' . $selected_row['galaxy_angreifer'] . '&system=' . $selected_row['system_angreifer'] . '&planet=' . $selected_row['planet_angreifer'] . '">[' . $selected_row['galaxy_angreifer'] . ':' . $selected_row['system_angreifer'] . ':' . $selected_row['planet_angreifer'] . ']</a>';
				$message_vorlage .= 'to the planet ' . $name_deffer . ' <a href="galaxy.php?mode=3&galaxy=' . $selected_row['galaxy'] . '&system=' . $selected_row['system'] . '&planet=' . $selected_row['planet'] . '">[' . $selected_row['galaxy'] . ':' . $selected_row['system'] . ':' . $selected_row['planet'] . ']</a><br><br>';

				if (empty($message))
					$message = "The enemy had no defenses, nothing has been destroyed !";

				doquery("INSERT INTO {{table}} SET
						`message_owner`='" . $selected_row['zielid'] . "',
						`message_sender`='',
						`message_time`=UNIX_TIMESTAMP(),
						`message_type`='0',
						`message_from`='QG',
						`message_subject`='Attaque de MIP',
						`message_text`='" . $message_vorlage . $message . "'" , 'messages');
				doquery("UPDATE {{table}} SET new_message=new_message+1 WHERE id='" . $selected_row['zielid'] . "'", 'users');

				doquery("DELETE FROM {{table}} WHERE id = '" . $selected_row['id'] . "'", 'iraks');
			}
		} else {
			doquery("DELETE FROM {{table}} WHERE id = '" . $selected_row['id'] . "'", 'iraks');
		}
	}
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>