<?php

/**
 * Hasterson
 * MIP Engine
 * 2008       
 *       
 * 
 *       
 *       
 * 
 */

if (!defined('INSIDE')) {
	die("Hacking attempt");
}
define('INSIDE' , true);
define('INSTALL' , false);



includeLang('tech');
includeLang('rake');

if (file_exists($xnova_root_path . "includes/raketenangriff.php")) {
	include($xnova_root_path . "includes/raketenangriff.php");
} elseif (file_exists("includes/raketenangriff.php")) {
	include("./includes/raketenangriff.php");
} elseif (file_exists("../includes/raketenangriff.php")) {
	include("../includes/raketenangriff.php");
} else {
	die('Fatal error!');
}

if (isset($resource) && !empty($resource[401])) {
	$iraks = doquery("SELECT * FROM {{table}} WHERE zeit <= '" . time() . "'", 'iraks');

	while ($selected_row = mysql_fetch_array($iraks)) {
		if ($selected_row['zeit'] != '' && $selected_row['galaxy'] != '' && $selected_row['system'] != '' && $selected_row['planet'] != '' && is_numeric($selected_row['owner']) && is_numeric($selected_row['zielid']) && is_numeric($selected_row['anzahl']) && !empty($selected_row['anzahl'])) {
			$planetrow = doquery("SELECT * FROM {{table}} WHERE
								galaxy = '" . $selected_row['galaxy'] . "' AND
								system = '" . $selected_row['system'] . "' AND
								planet = '" . $selected_row['planet'] . "' AND 
								planet_type = '1'", 'planets');

			$TargetArmour = doquery("SELECT `defence_tech` FROM {{table}} WHERE
								id = '" . $selected_row['zielid'] . "'", 'users');

			$OwnWeapons = doquery("SELECT `military_tech` FROM {{table}} WHERE
								id = '" . $selected_row['owner'] . "'", 'users');

			if (mysql_num_rows($planetrow) != 1 OR mysql_num_rows($TargetArmour) != 1) {
				doquery("DELETE FROM {{table}} WHERE id = '" . $selected_row['id'] . "'", 'iraks');
			} else {
				$Defender = mysql_fetch_array($TargetArmour);
				$Attacker = mysql_fetch_array($OwnWeapons);
				$planet = mysql_fetch_array($planetrow);

				$ids = array(
						0 => 401,
						1 => 402,
						2 => 403,
						3 => 404,
						4 => 405,
						5 => 406,
						6 => 407,
						7 => 408,
						8 => 409,
						9 => 410,
						10 => 502,
						11 => 503
						);

				$def = array(
						0 => $planet['misil_launcher'], // Raketenwerfer
						1 => $planet['small_laser'], // Leichtes Lasergesch�tz
						2 => $planet['big_laser'], // Schweres Lasergesch�tz
						3 => $planet['gauss_canyon'], // Gau�kanone
						4 => $planet['ionic_canyon'], // Ionengesch�tz
						5 => $planet['buster_canyon'], // Plasmawerfer
						6 => $planet['small_protection_shield'], // Kleine Schildkuppel
						7 => $planet['big_protection_shield'], // Gro�e Schildkuppel
						8 => $planet['gig_protection_shield'], // Gigantische Schildkuppel
						9 => $planet['Gravitonka'], // Gravitonenkanone
						10 => $planet['interceptor_misil'], // Abfangrakete
						11 => $planet['interplanetary_misil'] // Interplanetarrakete
						);

				$lange =	array(
						0 => $lang['tech'][401],
						1 => $lang['tech'][402],
						2 => $lang['tech'][403],
						3 => $lang['tech'][404],
						4 => $lang['tech'][405],
						5 => $lang['tech'][406],
						6 => $lang['tech'][407],
						7 => $lang['tech'][408],
						8 => $lang['tech'][409],
						9 => $lang['tech'][410],
						10 => $lang['tech'][502],
						11 => $lang['tech'][503]
						);

				$message = '';

				if ($planet['interceptor_misil'] >= $selected_row['anzahl']) {
					$message = 'Les Missiles Intercepteur adverses ont d&eacute;truit vos missiles Interplanetaire<br>';

					$x = $planet['interceptor_misil'] - $selected_row['anzahl'];

					doquery("UPDATE {{table}} SET `interceptor_misil` = '".$x."' WHERE id = " . $planet['id'], 'planets');
				} else {
					if ($planet['interceptor_misil'] > 0) {
						$x = $resource[$ids[11]];

						doquery("UPDATE {{table}} SET `interceptor_misil` = '0' WHERE id = " . $planet['id'], 'planets');

						$message = $planet['interceptor_misil'] . " missiles Interplanetaire ont &eacute;t&eacute; intercept&eacute;s par vos missiles.<br>";
						$selected_row['anzahl'] = $selected_row['anzahl'] - $planet['interceptor_misil'];
					}


					$irak = raketenangriff($Defender['defence_tech'], $Attacker['military_tech'], $selected_row['anzahl'], $def, $selected_row['primaer']);

					foreach ($irak['zerstoert'] as $id => $anzahl) {
						if (!empty($anzahl) && $id < 11) {
							if ($id != 11)
								$message .= $lange[$id] . " (- " . $anzahl . ")<br>";

							$x = $resource[$ids[$id]];

							doquery("UPDATE {{table}} SET " . $x . " = " . $x . "-" . $anzahl . " WHERE id = " . $planet['id'], 'planets');
						}
					}
				}

				$planet_1 = doquery("SELECT * FROM {{table}} WHERE
								galaxy = '" . $selected_row['galaxy_angreifer'] . "' AND
								system = '" . $selected_row['system_angreifer'] . "' AND
								planet = '" . $selected_row['planet_angreifer'] . "' AND
								planet_type ='1'", 'planets');

				if (mysql_num_rows($planet_1) == 1) {
					$array = mysql_fetch_array($planet_1);

					$name = $array['name'];
				}

				$planet_2 = doquery("SELECT * FROM {{table}} WHERE
								galaxy = '" . $selected_row['galaxy'] . "' AND
								system = '" . $selected_row['system'] . "' AND
								planet = '" . $selected_row['planet'] . "' AND
								planet_type ='1'", 'planets');

				if (mysql_num_rows($planet_2) == 1) {
					$array = mysql_fetch_array($planet_2);

					$name_deffer = $array['name'];
				}

				$message_vorlage  = 'One attack missles (' . $selected_row['anzahl'] . ') from the ' . $name . ' <a href="galaxy.php?mode=3&galaxy=' . $selected_row['galaxy_angreifer'] . '&system=' . $selected_row['system_angreifer'] . '&planet=' . $selected_row['planet_angreifer'] . '">[' . $selected_row['galaxy_angreifer'] . ':' . $selected_row['system_angreifer'] . ':' . $selected_row['planet_angreifer'] . ']</a>';
				$message_vorlage .= 'are attack ' . $name_deffer . ' <a href="galaxy.php?mode=3&galaxy=' . $selected_row['galaxy'] . '&system=' . $selected_row['system'] . '&planet=' . $selected_row['planet'] . '">[' . $selected_row['galaxy'] . ':' . $selected_row['system'] . ':' . $selected_row['planet'] . ']</a><br><br>';

				if (empty($message)){
					$message = $lang['nothing_destroy'];
				}

				doquery("INSERT INTO {{table}} SET
						`message_owner`='" . $selected_row['zielid'] . "',
						`message_sender`='',
						`message_time`=UNIX_TIMESTAMP(),
						`message_type`='3',
						`message_from`='Fleet Command',
						`message_subject`='Attack MIP',
						`message_text`='" . $message_vorlage ." ". $message . "'" , 'messages');
				doquery("UPDATE {{table}} SET `new_message` = `new_message` + 1 WHERE `id` = '" . $selected_row['zielid'] . "'", 'users');

				doquery("DELETE FROM {{table}} WHERE `id` = '" . $selected_row['id'] . "'", 'iraks');
                $message_vorlage1  = 'Your interplanetar rockets (' . $selected_row['anzahl'] . ') from the ' . $name . ' <a href="galaxy.php?mode=3&galaxy=' . $selected_row['galaxy_angreifer'] . '&system=' . $selected_row['system_angreifer'] . '&planet=' . $selected_row['planet_angreifer'] . '">[' . $selected_row['galaxy_angreifer'] . ':' . $selected_row['system_angreifer'] . ':' . $selected_row['planet_angreifer'] . ']</a>';
				$message_vorlage1 .= 'are attack ' . $name_deffer . ' <a href="galaxy.php?mode=3&galaxy=' . $selected_row['galaxy'] . '&system=' . $selected_row['system'] . '&planet=' . $selected_row['planet'] . '">[' . $selected_row['galaxy'] . ':' . $selected_row['system'] . ':' . $selected_row['planet'] . ']</a><br><br>';

				if (empty($message)){
					$$message = $lang['nothing_destroy'];
				}

				doquery("INSERT INTO {{table}} SET
						`message_owner`='" . $selected_row['owner'] . "',
						`message_sender`='',
						`message_time`=UNIX_TIMESTAMP(),
						`message_type`='3',
						`message_from`='Fleet Command',
						`message_subject`='Attack MIP',
						`message_text`='" . $message_vorlage1 ." ". $message . "'" , 'messages');
				doquery("UPDATE {{table}} SET `new_message` = `new_message` + 1 WHERE `id` = '" . $selected_row['owner'] . "'", 'users');

				doquery("DELETE FROM {{table}} WHERE `id` = '" . $selected_row['id'] . "'", 'iraks');
			}
		} else {
			doquery("DELETE FROM {{table}} WHERE `id` = '" . $selected_row['id'] . "'", 'iraks');
		}
	}
}

?>