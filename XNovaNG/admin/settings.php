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

function DisplayGameSettingsPage () {
	global $lang, $game_config;

	includeLang('admin/settings');
					
	if ($_POST) {

		$game_config_keys = array_keys($game_config);
		$game_config_old = $game_config;

		foreach ($_POST as $key => $value) {
			
			if ( in_array($key, $game_config_keys)) {
				$key	= mysql_real_escape_string($key);
				$value	= mysql_real_escape_string($value);
				
				$game_config[$key] = ($value == 'on') ? '1' : $value;
			}
				
		}

		$checkboxArray = array ('game_disable', 'OverviewNewsFrame', 'OverviewExternChat', 'OverviewBanner', 'debug');
			
		foreach ($checkboxArray as $checkbox) {
			if ( is_null($_POST[$checkbox])) 
				$game_config[$checkbox] = '0';
	    }
			
		$game_config_newValues = array_diff_assoc($game_config, $game_config_old);

                $readConnection = Nova::getSingleton('core/database_connection_pool')
                    ->getConnection('core_read');

		foreach ($game_config_newValues as $key => $value) {
                    $readConnection->update(
                        $readConnection->getDeprecatedTable('config'),
                        array('config_value' => $value),
                        array('config_name =?' => $key)
                    );
        }

		    AdminMessage ($lang['GameSettings_SettingsChanged'], $lang['GameSettings_Success']);
			
		} else {

			$parse                           = $lang;
			
			foreach ($game_config as $key => $value) {	
				$parse[$key] = $value;	
			}
			
			$parse['closed']                = ($game_config['game_disable'] == 1) ? " checked = 'checked' ":"";
			$parse['newsframe']             = ($game_config['OverviewNewsFrame'] == 1) ? " checked = 'checked' ":"";
			$parse['chatframe']             = ($game_config['OverviewExternChat'] == 1) ? " checked = 'checked' ":"";
			$parse['googlead']              = ($game_config['OverviewBanner'] == 1) ? " checked = 'checked' ":"";
			$parse['debug']                 = ($game_config['debug'] == 1)        ? " checked = 'checked' ":"";
			$parse['bannerframe']           = ($game_config['ForumBannerFrame'] == 1) ? " checked = 'checked' ":"";

			$PageTPL                         = gettemplate('admin/options_body');
			$Page                           = parsetemplate( $PageTPL,  $parse );

			display ( $Page, $lang['GameSettings_Title'], false, '', true );
			
		}
    
	return $Page;
}
    
if ($user['authlevel'] > 2) {
	$Page = DisplayGameSettingsPage();
} else {
    AdminMessage ($lang['sys_noalloaw'], $lang['sys_noaccess']);
}