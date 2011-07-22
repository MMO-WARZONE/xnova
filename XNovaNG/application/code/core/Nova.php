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

/**
 * Bootstrapping class
 *
 * @access      public
 * @author      gplanchat
 * @category    Nova
 * @package     Bootstrap
 * @subpackage  Bootstrap
 */
final class Nova
{
    const RESOURCE_DEFAULT_CONTEXT = 'master';

    /**
     * @var array
     */
    private static $_classCache = array();

    /**
     * @var array
     */
    private static $_modelClassCache = array();

    /**
     * @var array
     */
    private static $_resourceModelClassCache = array();

    /**
     * @var array
     */
    private static $_blockClassCache = array();

    /**
     * @var array
     */
    private static $_exceptionClassCache = array();

    /**
     * @var array
     */
    private static $_singletons = array();

    /**
     * @var array
     */
    private static $_resourceSingletons = array();

    /**
     * @var array
     */
    private static $_blockSingletons = array();

    /**
     * @var Nova_Core_Model_Profiler
     */
    private static $_profilerData = array();

    /**
     * @var Nova_Core_Model_Application
     */
    private static $_application = NULL;

    /**
     * @var Zend_Config
     */
    private static $_modelsConfig = NULL;

    /**
     * @var Zend_Config
     */
    private static $_resourceModelsConfig = NULL;

    /**
     * @var Zend_Config
     */
    private static $_exceptionsConfig = NULL;

    /**
     * Starts a profile timing count
     *
     * @param string $profile
     * @return void
     */
    public static function profilerStart($profile)
    {
        if (isset(self::$_profilerData[(string)$profile])) {
            self::$_profilerData[(string)$profile]['start'] = microtime(true);
        } else {
            self::$_profilerData[(string)$profile] = array(
                'name'  => (string) $profile,
                'count' => 0,
                'total' => 0,
                'minimal' => 0,
                'maximal' => 0,
                'start' => microtime(true)
                );
        }

        //printf('PROFILER/START: %s - %f<br />' . PHP_EOL, $profile, self::$_profilerData[(string)$profile]['start']);
    }

    /**
     * Stops a profile timing count
     *
     * @param string $profile
     * @return void
     */
    public static function profilerStop($profile)
    {
        $stop = microtime(true);
        $difference = $stop - self::$_profilerData[(string)$profile]['start'];

        self::$_profilerData[(string)$profile]['total'] += $difference;
        self::$_profilerData[(string)$profile]['start'] = NULL;
        self::$_profilerData[(string)$profile]['count']++;
        self::$_profilerData[(string)$profile]['maximal'] = max(self::$_profilerData[(string)$profile]['maximal'], $difference);
        if (self::$_profilerData[(string)$profile]['minimal'] > 0) {
            self::$_profilerData[(string)$profile]['minimal'] = min(self::$_profilerData[(string)$profile]['minimal'], $difference);
        } else {
            self::$_profilerData[(string)$profile]['minimal'] = $difference;
        }

        //printf('PROFILER/STOP: %s - %f (%f)<br />' . PHP_EOL, $profile, $stop, self::$_profilerData[(string)$profile]['total']);
    }

    /**
     *
     * @return array
     */
    public static function getProfilerData()
    {
        return self::$_profilerData;
    }

    /**
     *
     * @param string $classSuffix
     * @return string
     */
    private static function _translateClassName($classSuffix)
    {
        //$classSuffix = str_replace(' ', '', ucwords(str_replace('-', ' ', $classSuffix)));
        //return str_replace(' ', '_', ucwords(str_replace('.', ' ', $classSuffix)));
        return str_replace(' ', '_', ucwords(str_replace('_', ' ', $classSuffix)));
    }

    /**
     * Instanciate a Model
     *
     * @param string $model
     * @param array $params
     * @return Nova_Core_ModelAbstract
     */
    public static function getModel($model, $params = array())
    {
        $offset = strpos($model, '/');

        if ($offset === false) {
            self::throwException('core/exception', 'Wrong class identifier format.');
        }

        $moduleName = substr($model, 0, $offset);
        $classSuffix = substr($model, $offset + 1);

        if (isset(self::$_modelClassCache[$moduleName]) &&
            isset(self::$_modelClassCache[$moduleName][$classSuffix])) {

            $className = self::$_modelClassCache[$moduleName][$classSuffix];
        } else {
            Nova::profilerStart("CORE.MODEL.LOAD " . __METHOD__ . " [{$model}]");

            // TODO : implement a clean configuration loading
            if (is_null(self::$_modelsConfig)) {
                Nova::profilerStart("CORE.MODEL.CONFIG.LOAD");
                self::$_modelsConfig = new Zend_Config(self::app()->getConfig('global.models'));
                Nova::profilerStop("CORE.MODEL.CONFIG.LOAD");
            }

            //TODO : implement a clean configuration navigation
            $config = self::$_modelsConfig->get($moduleName);
            if (!$config) { echo 'he';
                Nova::profilerStop("CORE.MODEL.LOAD " . __METHOD__ . " [{$model}]");
                return NULL;
            } else if ($config->get('rewrite') && $config->get('rewrite')->get($moduleName)) { echo 'h2e';
                $className = $config->get('rewrite')->get($classSuffix);
            } else {
                $className = $config->get('class') . self::_translateClassName($classSuffix);
            }

//            $reflection = new ReflectionClass($className);
//            if ($reflection->implementsInterface('Nova_Core_ObjectInterface') ||
//                    $reflection->isSubclassOf('Nova_Core_Object')) {
//                self::throwException('core/implementationError',
//                    'Class "%s" should implement "Nova_Core_ObjectInterface" or extend "Nova_Core_Object".', $className);
//            }

            self::$_modelClassCache[$moduleName][$classSuffix] = $className;

            Nova::profilerStop("CORE.MODEL.LOAD " . __METHOD__ . " [{$model}]");
        }

        $reflectionClass = new ReflectionClass($className);
        if ($reflectionClass->isSubclassOf('Nova_Core_Object')) {
            $object = $reflectionClass->newInstance($moduleName, $params);
        } else {
            $object = $reflectionClass->newInstanceArgs($params);
        }

        return $object;
    }

    /**
     * Instanciate a resource model
     *
     * @param string $resourceModel
     * @param string $context
     * @param array $params
     * @return Nova_Core_ResourceInterface
     */
    public static function getResourceModel($resourceModel, $context = NULL, $params = array())
    {
        if (is_null($context)) {
            $context = self::RESOURCE_DEFAULT_CONTEXT;
        }

        $offset = strpos($resourceModel, '/');

        if ($offset === false) {
            self::throwException('core/exception', 'Wrong class identifier format.');
        }

        $moduleName = substr($resourceModel, 0, $offset);
        $classSuffix = substr($resourceModel, $offset + 1);

        if (isset(self::$_resourceModelClassCache[$moduleName]) &&
            isset(self::$_resourceModelClassCache[$moduleName][$classSuffix]) &&
            isset(self::$_resourceModelClassCache[$moduleName][$classSuffix][$context])) {

            $className = self::$_resourceModelClassCache[$moduleName][$classSuffix][$context];
        } else {
            Nova::profilerStart("CORE.RESOURCE.LOAD " . __METHOD__ . " [{$resourceModel}]");

            // TODO : implement a clean configuration loading
            if (is_null(self::$_modelsConfig)) {
                Nova::profilerStart("CORE.MODEL.CONFIG.LOAD");
                self::$_modelsConfig = new Zend_Config(self::app()->getConfig('global.models'));
                Nova::profilerStop("CORE.MODEL.CONFIG.LOAD");
            }

            //TODO : implement a clean configuration navigation
            $config = self::$_modelsConfig->get($moduleName)->get('resource')->get($context);
            if (!$config) {
                Nova::profilerStop("CORE.RESOURCE.LOAD " . __METHOD__ . " [{$resourceModel}]");
                return NULL;
            } else if ($config->get('rewrite') && $config->get('rewrite')->get($classSuffix)) {
                $className = $config->get('rewrite')->get($classSuffix);
            } else {
                $className = $config->get('class_prefix') . self::_translateClassName($classSuffix);
            }

            self::$_resourceModelClassCache[$moduleName][$classSuffix][$context] = $className;

            Nova::profilerStop("CORE.RESOURCE.LOAD " . __METHOD__ . " [{$resourceModel}]");
        }


        $reflectionClass = new ReflectionClass($className);
        if ($reflectionClass->isSubclassOf('Nova_Core_Object')) {
            $object = $reflectionClass->newInstance($moduleName, $params);
        } else {
            $object = $reflectionClass->newInstanceArgs($params);
        }

        return $object;
    }

    /**
     * Get the desired Model singleton
     *
     * @param string $model
     * @param array $params
     * @return Nova_Core_ModelAbstract
     */
    public static function getSingleton($model, $params = array())
    {
        if (!isset(self::$_singletons[$model])) {
            self::$_singletons[$model] = self::getModel($model, $params);
        }
        return self::$_singletons[$model];
    }

    /**
     * Get the desired resource singleton
     *
     * @param string $model
     * @param string $context
     * @param array $params
     * @return Nova_Core_ResourceInterface
     */
    public static function getResourceSingleton($resourceModel, $context = NULL, $params = array())
    {
        if (!isset(self::$_resourceSingletons[$resourceModel])) {
            self::$_resourceSingletons[$resourceModel] = self::getResourceModel($resourceModel, $context, $params);
        }
        return self::$_resourceSingletons[$resourceModel];
    }

    /**
     * @param string $block
     * @param array $params
     * @return Nova_Core_BlockAbstract
     *
     * FIXME : Reimplemet method
     */
    public static function getBlockSingleton($block, $params = array())
    {
        if (!isset(self::$_blockSingletons[$block])) {
            if (isset(self::$_blockClassCache[$model])) {
                $className = self::$_blockClassCache[$model];
            } else {
                Nova::profilerStart("CORE.BLOCK.LOAD " . __METHOD__ . " [{$model}]");
                $blockConfig = explode('/', $model);
                if (count($blockConfig) === 1) {
                    $className = $model;
                } else {
                    //FIXME: load a block class name from the configuration.
                    $className = sprintf('Nova_%s_Block_', ucfirst($blockConfig[0]));
                    $className = $config->get('class') . '_' . self::_translateClassName($blockConfig[1]);
                }
                self::$_blockClassCache[$model] = $className;
                Nova::profilerStop("CORE.BLOCK.LOAD " . __METHOD__ . " [{$model}]");
            }
            self::$_blockSingletons[$block] = new $className($moduleName, $params);
        }
        return self::$_blockSingletons[$block];
    }

    /**
     * @param string $model
     * @param array $params
     * @return Nova_Core_HelperAbstract
     *
     * FIXME : Reimplemet method
     */
    public static function helper($model, $params = array())
    {
        if (!isset(self::$_helperSingletons[$block])) {
            if (isset(self::$_helperClassCache[$model])) {
                $className = self::$_helperClassCache[$model];
            } else {
                Nova::profilerStart("CORE.HELPER.LOAD " . __METHOD__ . " [{$model}]");
                $helperConfig = explode('/', $model);
                if (count($helperConfig) === 1) {
                    $className = $model;
                } else {
                    //FIXME: load a block class name from the configuration.
                    $className = sprintf('Nova_%s_Helper_', ucfirst($helperConfig[0]));
                    $className = $config->get('class') . '_' . self::_translateClassName($blockConfig[1]);
                }
                self::$_helperClassCache[$model] = $className;
                Nova::profilerStop("CORE.HELPER.LOAD " . __METHOD__ . " [{$model}]");
            }
            self::$_helperSingletons[$block] = new $className($params);
        }
        return self::$_helperSingletons[$block];
    }

    /**
     * Throw an exception, depending on its forge identifier
     *
     * FIXME : Reimplemet method
     *
     * @param string $model
     * @param array $params
     * @throws Nova_Core_ExceptionAbstract
     */
    public static function throwException($exception, $message = NULL, $_ = NULL)
    {
        if (isset(self::$_exceptionClassCache[$exception])) {
            $className = self::$_exceptionClassCache[$exception];
        } else {
            Nova::profilerStart("CORE.EXCEPTION.LOAD " . __METHOD__ . " [{$exception}]");
            $exceptionConfig = explode('/', $exception);
            if (count($exceptionConfig) === 1) {
                $className = $exception;
            } else {
                Nova::profilerStart("CORE.EXCEPTION.CONFIG.LOAD");
                if (is_null(self::$_exceptionsConfig)) {
                    self::$_exceptionsConfig = new Zend_Config(self::app()->getConfig('global.exceptions'));
                }
                $config = self::$_exceptionsConfig->get($exceptionConfig[0]);
                if (!$config) {
                    $className = 'Exception';
                } else if ($config->get('rewrite') && $config->get('rewrite')->get($exceptionConfig[1])) {
                    $className = $config->get('rewrite')->get($exceptionConfig[1]);
                } else {
                    $className = $config->get('class') . self::_translateClassName($classSuffix);
                }
                Nova::profilerStop("CORE.EXCEPTION.CONFIG.LOAD");
            }
            self::$_exceptionClassCache[$exception] = $className;
            Nova::profilerStop("CORE.EXCEPTION.LOAD " . __METHOD__ . " [{$exception}]");
        }
        if (!is_null($message)) {
            $args = func_get_args();
            array_shift($args);
            array_shift($args);
            $message = vsprintf($message, $args);
        }

        throw new $className($message);
    }

    /**
     *
     * @return unknown_type
     *
     * FIXME : Reimplemet method
     */
    public static function app()
    {
        if (is_null(self::$_application)) {
            self::$_application = new Nova_Core_Model_Application();
        }
        return self::$_application;
    }
}
