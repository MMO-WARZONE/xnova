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

/**
 * Base user management class
 *
 * @access      public
 * @author      gplanchat
 * @category    User
 * @package     Nova
 * @subpackage  Nova_User
 */
class Nova_User_Model_User
    extends Nova_Core_ModelAbstract
{
    /**
     * @var string
     */
    const USERNAME_FIELD = 'username';

    /**
     * @var string
     */
    const PASSWORD_FIELD = 'password';

    /**
     * @var string
     */
    const PASSWORD_TRANSFORM = 'MD5(?)';

    protected function _load($identifier, $field)
    {
        if ($field == NULL) {
            $field = $this->getIdFieldName();
        }
        $field = Nova_Database::getInstance()->quoteIdentifier($field);

        $result = Nova_Database::getInstance()
            ->select()
            ->from(array('users' => Nova_Database::getTable('deprecated/users')))
            ->where("{$field}=?", $identifier)
            ->query()
            ->fetch(Zend_Db::FETCH_ASSOC);
        $this->setData($result);

        return $this;
    }

    public function setId($identifier)
    {
        return $this->setData($this->_idField, (int) $identifier);
    }

    public function getId()
    {
        return $this->getData($this->_idField);
    }

    protected function _beforeUpdate()
    {
        $this->_unsetData('password');
    }

    protected function _save()
    {
        $field = Nova_Database::getInstance()->quoteIdentifier($this->getIdFieldName());
        Nova_Database::getInstance()
            ->update(Nova_Database::getTable('deprecated/users'), $this->getData(),
                array("{$field}=?" => $this->getId()));

        return $this;
    }

    protected function _delete()
    {
        $field = Nova_Database::getInstance()->quoteIdentifier($this->getIdFieldName());
        Nova_Database::getInstance()
            ->delete(Nova_Database::getTable('deprecated/users'),
                array("{$field}=?" => $this->getId()));

        return $this;
    }

    public function loadByUsername($username)
    {
        return $this->load($username, 'username');
    }

    public function login($username, $password)
    {
        $salt = uniqid(NULL, true);
        $auth = new Zend_Auth_Adapter_DbTable(Nova_Database::getInstance(),
            Nova_Database::getTable('deprecated/users'),
            self::USERNAME_FIELD, self::PASSWORD_FIELD, self::PASSWORD_TRANSFORM);

        $auth->setIdentity($username)
            ->setCredential($password);
        $result = $auth->authenticate();

        switch ($result->getCode()) {
        case Zend_Auth_Result::SUCCESS:
            $this->loadByUsername($result->getIdentity());
            return true;
            break;

        case Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID:
            // @todo

        case Zend_Auth_Result::FAILURE_IDENTITY_AMBIGUOUS:
            // @todo

        case Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND:
            // @todo

        case Zend_Auth_Result::FAILURE_UNCATEGORIZED:
            // @todo

        case Zend_Auth_Result::FAILURE:
            // @todo

        default:
            // @todo
            break;
        }

        return false;
    }

    public function setPassword($password)
    {
        $field = Nova_Database::getInstance()
            ->quoteIdentifier($this->getIdFieldName());
        $data = array(self::PASSWORD_FIELD
            => new Zend_Db_Expr(Nova_Database::getInstance()
                ->quoteInto(self::PASSWORD_TRANSFORM, $password)));

        Nova_Database::getInstance()
            ->update(Nova_Database::getTable('deprecated/users'), $data,
                array("{$field}=?" => $this->getId()));

        return $this;
    }

    public function regenerateRandomPassword()
    {
        $characters = array_rand(explode('', 'abcdefghijklmnopqrstuvwxyz0123456789[](){};:*%$/!+-_'));

        return implode('', array_slice($characters, random(7,10)));
    }
}
