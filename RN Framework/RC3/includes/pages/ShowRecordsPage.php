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

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowRecordsPage()
{
	global $lang, $planetrow, $user, $resource;
	
	$HeaderTpl = gettemplate('records/records_section_header');
	$TableRows = gettemplate('records/records_section_rows');

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
		if (($ElementName != "") && ($resource[$Element] != "")) {
			if ($Element >=   1 && $Element <=  39 || $Element == 44) {
			    // Batiment
			    $PlanetRow          = doquery ("SELECT `id_owner`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE `". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}} WHERE `id_level` = '0');", 'planets', true);
			    $UserRow            = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '".$PlanetRow['id_owner']."';", 'users', true);
			    $Row['element']     = $ElementName;
			    $Row['winner']      = ($PlanetRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
			    $Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
			    $parse['building'] .= parsetemplate( $TableRows, $Row);
			} elseif ($Element >=  41 && $Element <=  99 && $Element != 44) {
			    // Batiment spéciaux
			    $PlanetRow          = doquery ("SELECT `id_owner`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE `". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}} WHERE `id_level` = '0');", 'planets', true);
			    $UserRow            = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '".$PlanetRow['id_owner']."';", 'users', true);
			    $Row['element']     = $ElementName;
			    $Row['winner']      = ($PlanetRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
			    $Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
			    $parse['buildspe'] .= parsetemplate( $TableRows, $Row);
			} elseif ($Element >= 101 && $Element <= 199) {
			    // Techno
			    $UserRow            = doquery ("SELECT `username`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE `". $resource[$Element] ."` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}} WHERE `authlevel` = '0');", 'users', true);
			    $Row['element']     = $ElementName;
			    $Row['winner']      = ($UserRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
			    $Row['count']       = ($UserRow['current'] != 0) ? pretty_number( $UserRow['current'] ) : $lang['rec_rien'];
			    $parse['research'] .= parsetemplate( $TableRows, $Row);
			} elseif ($Element >= 201 && $Element <= 399) {
			    // Flotte
			    $PlanetRow          = doquery ("SELECT `id_owner`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE `". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}} WHERE `id_level` = '0');", 'planets', true);
			    $UserRow            = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '".$PlanetRow['id_owner']."';", 'users', true);
			    $Row['element']     = $ElementName;
			    $Row['winner']      = ($PlanetRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
			    $Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
			    $parse['fleet']    .= parsetemplate( $TableRows, $Row);
			} elseif ($Element >= 401 && $Element <= 599) {
			    // Défenses
			    $PlanetRow          = doquery ("SELECT `id_owner`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE `". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}} WHERE `id_level` = '0');", 'planets', true);
			    $UserRow            = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '".$PlanetRow['id_owner']."';", 'users', true);
			    $Row['element']     = $ElementName;
			    $Row['winner']      = ($PlanetRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
			   $Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
			   $parse['defenses'] .= parsetemplate( $TableRows, $Row);
			}
		}
	}
	display(parsetemplate(gettemplate('records/records_body'), $parse ), false);
}
// -----------------------------------------------------------------------------------------------------------
// History version
// - 1.0 Réécriture
// - 1.1 Ajout du test de presence d'un chmap de la base de données ... Si apres ca ca plante c'est
//       que l'utilisateur de ce module est vraiment trop con et devrait arreter l'informatique pour aller
//       vendre des frittes chez Mc Do ou autre FastFood
// - 1.2 Separateur de chiffres ... qu'ils soient comme partout ailleur dans le jeu
// - 1.3 Remplacement des 0 par un texte ou un '-' (suggestion matdu57)
// - 1.4 Non prise en compte des planetes protégées
// - 1.4b Adaptacion a Proyecto XGP, version 2.7
?> 