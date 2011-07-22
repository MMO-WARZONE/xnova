<?php

define('ROOT_PATH', dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR);

$oldConfig = include ROOT_PATH . 'config.php';

$newConfig = array(
    'global' => array(
        'database' => array(
            'core_default' => array(
                'engine' => 'Mysql4',
                'params' => array(
                    'host'             => $oldConfig['global']['database']['options']['hostname'],
                    'username'         => $oldConfig['global']['database']['options']['username'],
                    'password'         => $oldConfig['global']['database']['options']['password'],
                    'dbname'           => $oldConfig['global']['database']['options']['database'],
                    ),
                'table_prefix' => $oldConfig['global']['database']['table_prefix'],
                ),
            'core_read' => array(
                'use' => 'core_default'
                ),
            'core_write' => array(
                'use' => 'core_default'
                ),
            'core_setup' => array(
                'use' => 'core_default'
                )
            )
        ),
    'entities' => array(
        'deprecated' => array(
            'aks'        => 'aks',
            'alliance'   => 'alliance',
            'annonce'    => 'annonce',
            'banned'     => 'banned',
            'buddy'      => 'buddy',
            'chat'       => 'chat',
            'config'     => 'config',
            'declared'   => 'declared',
            'errors'     => 'errors',
            'fleets'     => 'fleets',
            'galaxy'     => 'galaxy',
            'iraks'      => 'iraks',
            'lunas'      => 'lunas',
            'messages'   => 'messages',
            'multi'      => 'multi',
            'notes'      => 'notes',
            'planets'    => 'planets',
            'rw'         => 'rw',
            'statpoints' => 'statpoints',
            'users'      => 'users'
            ),
        'user' => array(
            'entity'     => 'user_entity',
            'session'    => 'user_session',
            'auth'       => 'user_auth',
            'log'        => 'user_log',
            'options'    => 'user_options',
            'group_link' => 'user_group_link',
            'group'      => 'user_group'
            ),
        'acl' => array(
            'role'            => 'acl_role',
            'role_group_link' => 'acl_role_group_link',
            'resource'        => 'acl_resource'
            ),
        'alliance' => array(
            'entity'     => 'alliance_entity',
            'group_link' => 'alliance_group_link'
            ),
        'empire' => array(
            'planet_building_queue' => 'empire_planet_building_queue',
            'technologies'          => 'user_technologies',
            'stats'                 => 'user_stats'
            )
        )
    );

file_put_contents(ROOT_PATH . 'config.php', '<?php return ' . var_export($newConfig, true) . ';');
file_put_contents(ROOT_PATH . 'VERSION', '2009.3');
