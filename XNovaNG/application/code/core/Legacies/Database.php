<?php
/**
 * This file is part of XNova:Legacies
 *
 * @license http://www.gnu.org/licenses/gpl-3.0.txt
 * @see http://www.xnova-ng.org/
 *
 * Copyright (c) 2009-2010, Grégory PLANCHAT <g.planchat at gmail.com>
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

require_once 'Nova/Core/Model/Database/Connection/Pool.php';

/**
 * Database management class
 *
 * @access public
 * @author gplanchat
 * @category Nova
 * @deprecated
 */
class Legacies_Database
    extends Nova_Core_Model_Database_Connection_Pool
{
    static $_defaultConnection = NULL;

    public static function getTable($table)
    {
        return self::getInstance()->getTable($table);
    }

    public static function getDeprecatedTable($table)
    {
        return self::getInstance()->getDeprecatedTable($table);
    }

    /**
     * @deprecated
     * @return unknown_type
     */
    public static function getInstance()
    {
        if (is_null(self::$_defaultConnection)) {
            self::$_defaultConnection = Nova::getModel('core/database_connection_pool')
                ->getConnection('core_read');
        }
        return self::$_defaultConnection;
    }
}