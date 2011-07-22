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

defined('DEBUG') || define('DEBUG', ($env = strtolower(getenv('DEBUG'))) === '1' || $env === 'true' || $env === 'on');

define('PS', PATH_SEPARATOR);
define('DS', DIRECTORY_SEPARATOR);

set_include_path(implode(PATH_SEPARATOR, array(
    dirname(dirname(__FILE__)) . DS . 'include' . DS . 'classes',
    dirname(dirname(__FILE__)) . DS . 'library',
    get_include_path()
    )));

require 'Zend/Loader/Autoloader.php';
$loader = Zend_Loader_Autoloader::getInstance();
$loader->registerNamespace('Legacies_');


