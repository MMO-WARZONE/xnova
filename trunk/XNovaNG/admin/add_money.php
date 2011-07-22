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
		includeLang('admin/addmoney');

		$PageTpl   = gettemplate("admin/add_money");
		$parse     = $lang;

		if ($_POST) {
			
			if ( isset($_POST['planetId']) && $_POST['planetId'] != '') {
				$planetId = (int) $_POST['planetId'];
				$queryCondition = " `id` = '{$planetId}'";
			} else {
				$planetGalaxy	= (isset($_POST['galaxy'])) ? (int) $_POST['galaxy'] : 0;
				$planetSystem	= (isset($_POST['system'])) ? (int) $_POST['system'] : 0;
				$planetPosition	= (isset($_POST['planet'])) ? (int) $_POST['planet'] : 0;
				$queryCondition = " galaxy = '{$planetGalaxy}' AND system = '{$planetSystem}' AND planet = '{$planetPosition}'";
			}
			
			$metal       = (isset($_POST['metal'])) ? (int) $_POST['metal'] : 0;
			$cristal     = (isset($_POST['cristal'])) ? (int) $_POST['cristal'] : 0;
			$deut        = (isset($_POST['deut'])) ? (int) $_POST['deut'] : 0;
			
			$sql = <<<EOF
				UPDATE {{table}} 
				SET
					`metal` = `metal` + '{$metal}',
					`crystal` = `crystal` + '{$cristal}',
					`deuterium` = `deuterium` + '{$deut}'
				WHERE
					{$queryCondition}
EOF;

			$addMoney = doquery($sql, "planets");
			
			if ($addMoney) {
				AdminMessage($lang['AddMoney_Done'], $lang['AddMoney_Title']);
			} else {
				AdminMessage($lang['AddMoney_Fail'], $lang['AddMoney_Title']);
			}
		}
		$Page = parsetemplate($PageTpl, $parse);

		display ($Page, $lang['adm_am_ttle'], false, '', true);
	} else {
		AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

?>