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

if (version_compare(phpversion(), '5.2.0', '<') === true) {
    echo  <<<EOF
<html>
  <head>
    <title>XNova:Legacies - PHP version</title>
  </head>
  <body>
  <div style="font: 12px/1.35em arial, helvetica, sans-serif;">
    <div style="margin: 0 0 25px 0; border-bottom: 1px solid #CCCCCC;">
      <h3 style="margin: 0; font-size: 1.7em; font-weight: normal; text-transform:none; text-align: left; color: #2f2f2f;">
      Whoops, it looks like you have an invalid PHP version
      </h3>
    </div>
    <p>XNova:Legacies supports PHP 5.2.0 or newer. Please update your PHP version.</p>
  </div>
  </body>
</html>
EOF;
    exit(0);
}

define('PS', PATH_SEPARATOR);
define('DS', DIRECTORY_SEPARATOR);

/**
 * @var string The root directory of the game files.
 */
define('ROOT_PATH', realpath(dirname(dirname(__FILE__))) . DS);

/**
 * @var string The application's directory.
 */
define('APPLICATION_PATH', realpath(dirname(__FILE__)) . DS);

/**
 * Start up session handler
 * @todo: implement sessions in a singleton model
 */
session_start();

/**
 * Set up environment
 */
defined('DEBUG') || define('DEBUG',
    ($env = strtolower(getenv('DEBUG'))) === '1' || $env === 'true' || $env === 'on');
defined('DEPRECATION') || define('DEPRECATION',
    ($env = strtolower(getenv('DEPRECATION'))) === '1' || $env === 'true' || $env === 'on');

/**
 * Define a valid include_path
 */
set_include_path(implode(PS, array(
    ROOT_PATH . 'library',
    APPLICATION_PATH . 'code' . DS . 'core',
    APPLICATION_PATH . 'code' . DS . 'community',
    APPLICATION_PATH . 'code' . DS . 'local',
    // get_include_path()
    )));

require_once 'Nova.php';

/**
 * Zend Framework's autoloader class.
 * @todo: add this to Nova::app()
 */
require_once 'Zend/Loader/Autoloader.php';
$loader = Zend_Loader_Autoloader::getInstance();
$loader->registerNamespace('Legacies_');
$loader->registerNamespace('Nova_');
$loader->registerNamespace('Whitewashing_');

/**
 * Check up if the game is already installed.
 */
if (!file_exists(APPLICATION_PATH . 'config/local.xml')) {
    header('HTTP/1.1 302 Found');
    header('Location: install/');
    exit(0);
}

Nova::app()
    ->bootstrap()
    ->run();
