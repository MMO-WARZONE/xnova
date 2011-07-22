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

require_once dirname(__FILE__) . '/application/bootstrap.php';

/**
 * Mute the legacy coding errors reporting
 * @deprecated
 */
@ini_set('display_errors', DEBUG);

/**
 * @var string the php extension used for the files
 * @deprecated
 */
define('PHPEXT', require 'extension.inc');

/**
 * @var the current game version.
 * @deprecated
 */
define('VERSION', Nova::getSingleton('core/version')->getVersion());


//FIXME
$game_config    = Nova::app()->getGameConfig();
$user           = Nova::getSingleton('user/session')->getUser();
$lang           = array();
$IsUserChecked  = false;

define('DEFAULT_SKINPATH', 'skins/xnova/');
define('TEMPLATE_DIR', realpath(ROOT_PATH . '/templates/'));
define('TEMPLATE_NAME', 'OpenGame');
define('DEFAULT_LANG', 'fr_FR');

$debug = Nova::getSingleton('core/debug');

include(ROOT_PATH . 'includes/constants.php');
include(ROOT_PATH . 'includes/functions.php');
include(ROOT_PATH . 'includes/unlocalised.php');
include(ROOT_PATH . 'includes/todofleetcontrol.php');
include(ROOT_PATH . 'language/' . DEFAULT_LANG . '/lang_info.cfg');
include(ROOT_PATH . 'includes/vars.php');
include(ROOT_PATH . 'db/mysql.php');
include(ROOT_PATH . 'includes/strings.php');

$readConnection = Nova::getSingleton('core/database_connection_pool')
    ->getConnection('core_read');

if (!defined('DISABLE_IDENTITY_CHECK')) {
    //$Result        = CheckTheUser($IsUserChecked);
    //$IsUserChecked = $Result['state'];
    //$user          = $Result['record'];

    if ($game_config['game_disable'] && $user->getAuthlevel() < 2) {
        message(stripslashes($game_config['close_reason']), $game_config['game_name']);
    }
}

includeLang('system');
includeLang('tech');

if (!$user->getId() && !defined('DISABLE_IDENTITY_CHECK')) {
    header('HTTP/1.1 401 Unauthorized');
    header('Location: login.php');
    exit(0);
}

$sql = $readConnection->select()
    ->from($readConnection->getDeprecatedTable('fleets'), array(
        'galaxy' => 'fleet_start_galaxy',
        'system' => 'fleet_start_system',
        'planet' => 'fleet_start_planet',
        'planet_type' => 'fleet_start_type'
        ))
    ->where('fleet_start_time <=?', new Zend_Db_Expr('UNIX_TIMESTAMP()'))
    ->orWhere('fleet_end_time <=?', new Zend_Db_Expr('UNIX_TIMESTAMP()'));

$statement = $readConnection->fetchAssoc($sql);

//include(ROOT_PATH . 'rak.php');

if ($user->getId()) {
    foreach ($statement as $rowset) {
        FlyingFleetHandler($rowset);
    }

    if (!defined('IN_ADMIN')) {
        $dpath = (isset($user['dpath']) && !empty($user['dpath'])) ? $user['dpath'] : DEFAULT_SKINPATH;
    } else {
        $dpath = '../' . DEFAULT_SKINPATH;
    }

    SetSelectedPlanet($user);
/*
    $planetrow = $readConnection->select()
        ->from($readConnection->getDeprecatedTable('planets'))
        ->where('id=?', $user['current_planet'])
        ->query()
        ->fetch()*/
    ;
/*
    $galaxyrow = $readConnection->select()
        ->from($readConnection->getDeprecatedTable('planets'))
        ->where('id=?', $planetrow['id'])
        ->query()
        ->fetch()*/
    ;
}

