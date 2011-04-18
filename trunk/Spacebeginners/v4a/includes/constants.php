<?php

if (defined('INSIDE') ) {
    define('ADMINEMAIL'               , "Metusalem100@gmx.de");
    define('GAMEURL'                  , "http://".$_SERVER['HTTP_HOST']."/");

    define('MAX_GALAXY_IN_WORLD'      , 9);
    define('MAX_SYSTEM_IN_GALAXY'     , 499);
    define('MAX_PLANET_IN_SYSTEM'     , 16);
    define('SPY_REPORT_ROW'           , 2);
    define('FIELDS_BY_MOONBASIS_LEVEL', 10);
    define('MAX_PLAYER_PLANETS'       , 15);
    define('MAX_BUILDING_QUEUE_SIZE'  , 5);
    define('MAX_FLEET_OR_DEFS_PER_ROW', 1000000000);
    define('MAX_OVERFLOW'             , 1.0);
    define('MAX_RIP'                  , 100000);  // Mindest benoetigte Rips zum zerstoeren eines Mondes
    define('MAX_ST'                   , 1000);    // Mindest benoetigte Sternenzerstoerer zum zerstoeren eines Mondes
    define('AZ_ABSTAND'               , 2);  
    define('BASE_STORAGE_SIZE'        , 10000000);
    define('BUILD_METAL'              , 400);
    define('BUILD_CRISTAL'            , 200);
    define('BUILD_DEUTERIUM'          , 1);
    define('BUILD_APPOLONIUM'         , 1);

    define('DEBUG', 1);

    $ListCensure = array ( "<", ">", "script", "doquery", "http", "javascript", "'" );
} else {
    die("Hacking attempt");
}

?>