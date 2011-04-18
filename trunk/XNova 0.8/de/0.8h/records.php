<?php

/**
 * records.php
 *
 * @version 1.0
 * @copyright 2009 by Dr.Isaacs für XNova-Germany
 * http://www.xnova-germany.org
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	includeLang('records');

	$RecordTpl = gettemplate('records_body');
	$HeaderTpl = gettemplate('records_section_header');
	$TableRows = gettemplate('records_section_rows');

	$parse['rec_title'] = $lang['rec_title'];

	$bloc['section']    = $lang['rec_build'];
	$bloc['player']     = $lang['rec_playe'];
	$bloc['level']      = $lang['rec_level'];
	$parse['building']  = parsetemplate( $HeaderTpl, $bloc);

	$bloc['section']    = $lang['rec_specb'];
	$bloc['player']     = $lang['rec_playe'];
	$bloc['level']      = $lang['rec_level'];
	$parse['buildspe']  = parsetemplate( $HeaderTpl, $bloc);

	$bloc['section']    = $lang['rec_techn'];
	$bloc['player']     = $lang['rec_playe'];
	$bloc['level']      = $lang['rec_level'];
	$parse['research']  = parsetemplate( $HeaderTpl, $bloc);

	$bloc['section']    = $lang['rec_fleet'];
	$bloc['player']     = $lang['rec_playe'];
	$bloc['level']      = $lang['rec_nbre'];
	$parse['fleet']     = parsetemplate( $HeaderTpl, $bloc);

	$bloc['section']    = $lang['rec_defes'];
	$bloc['player']     = $lang['rec_playe'];
	$bloc['level']      = $lang['rec_nbre'];
	$parse['defenses']  = parsetemplate( $HeaderTpl, $bloc);


   foreach($lang['tech'] as $Element => $ElementName) {
      if ($ElementName != "") {
         if ($resource[$Element] != "") {
            // Je sais bien qu'il n'y a aucune raison de blinder ce test ...
            // Mais avec les zozos qui vont le pomper ... Mieux vaut prevoir que guerir !!
            if       ($Element >=   1 && $Element <=  39) {
               // Batiment
               $PlanetRow          = doquery ("SELECT `id_owner`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE `". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}});", 'planets', true);
               $UserRow            = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '".$PlanetRow['id_owner']."';", 'users', true);
               $Row['element']     = $ElementName;
               $Row['winner']      = ($PlanetRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
               $Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
               $parse['building'] .= parsetemplate( $TableRows, $Row);
            } elseif ($Element >=  41 && $Element <=  99) {
               // Batiment spéciaux
               $PlanetRow          = doquery ("SELECT `id_owner`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE `". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}});", 'planets', true);
               $UserRow            = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '".$PlanetRow['id_owner']."';", 'users', true);
               $Row['element']     = $ElementName;
               $Row['winner']      = ($PlanetRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
               $Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
               $parse['buildspe'] .= parsetemplate( $TableRows, $Row);
            } elseif ($Element >= 101 && $Element <= 199) {
               // Techno
               $UserRow            = doquery ("SELECT `username`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE `". $resource[$Element] ."` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}});", 'users', true);
               $Row['element']     = $ElementName;
               $Row['winner']      = ($UserRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
               $Row['count']       = ($UserRow['current'] != 0) ? pretty_number( $UserRow['current'] ) : $lang['rec_rien'];
               $parse['research'] .= parsetemplate( $TableRows, $Row);
            } elseif ($Element >= 201 && $Element <= 399) {
               // Flotte
               $PlanetRow          = doquery ("SELECT `id_owner`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE `". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}});", 'planets', true);
               $UserRow            = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '".$PlanetRow['id_owner']."';", 'users', true);
               $Row['element']     = $ElementName;
               $Row['winner']      = ($PlanetRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
               $Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
               $parse['fleet']    .= parsetemplate( $TableRows, $Row);
            } elseif ($Element >= 401 && $Element <= 599) {
               // Défenses
               $PlanetRow          = doquery ("SELECT `id_owner`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE `". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}});", 'planets', true);
               $UserRow            = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '".$PlanetRow['id_owner']."';", 'users', true);
               $Row['element']     = $ElementName;
               $Row['winner']      = ($PlanetRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
               $Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
               $parse['defenses'] .= parsetemplate( $TableRows, $Row);
				}
			}
		}
	}

	$page = parsetemplate( $RecordTpl, $parse );
	display($page, $lang['rec_title']);


?>