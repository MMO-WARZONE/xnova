<?php
/**
 * This file is part of XNova:Legacies
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @see http://www.xnova-ng.org/
 *
 * Copyright (c) 2009-2010, XNova Support Team <http://www.xnova-ng.org>
 * All rights reserved.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 *                                --> NOTICE <--
 *  This file is part of the core development branch, changing its contents will
 * make you unable to use the automatic updates manager. Please refer to the
 * documentation for further information about customizing XNova.
 *
 */

define('IN_ADMIN', true);
require_once dirname(dirname(__FILE__)) .'/common.php';

	if ($user['authlevel'] >= 2) {
		
		includeLang('admin/addmoon');
		$PageTpl   = gettemplate("admin/add_moon");

		if ($_POST) {
			
			$moonName  = (isset($_POST['moonName'])) ? mysql_real_escape_string($_POST['moonName']) : $lang['AddMoon_DefaultName']; 

			if ( isset($_POST['planetId']) && $_POST['planetId'] != '') {
				$planetId = (int) $_POST['planetId'];
				$queryCondition = " `id` = '{$planetId}'";
			} else {
				$planetGalaxy	= (isset($_POST['galaxy'])) ? (int) $_POST['galaxy'] : false;
				$planetSystem	= (isset($_POST['system'])) ? (int) $_POST['system'] : false;
				$planetPosition	= (isset($_POST['planet'])) ? (int) $_POST['planet'] : false;
				$queryCondition = " galaxy = '{$planetGalaxy}' AND system = '{$planetSystem}' AND planet = '{$planetPosition}'";
			}
			
			$qrySelectPlanet = "SELECT id_owner, galaxy, system, planet FROM {{table}} WHERE {$queryCondition} LIMIT 1;";
			$PlanetSelected = doquery($qrySelectPlanet, 'planets', true);
			
			if ($PlanetSelected) {
			
				$Galaxy    = $PlanetSelected['galaxy'];
				$System    = $PlanetSelected['system'];
				$Planet    = $PlanetSelected['planet'];
            	$Owner     = $PlanetSelected['id_owner'];

				CreateOneMoonRecord ($Galaxy, $System, $Planet, $Owner, time(), $moonName, 20 );
				AdminMessage ($lang['AddMoon_Done'], $lang['AddMoon_Title']);
				
			} else {
				AdminMessage($lang['AddMoon_Fail'], $lang['AddMoon_Title']);
			}
		}
		$Page = parsetemplate($PageTpl, $lang);

		display ($Page, $lang['AddMoon_Title'], false, '', true);
	} else {
		AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}
?>