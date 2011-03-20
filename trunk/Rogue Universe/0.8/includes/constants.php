<?php

if (!defined('INSIDE'))
{
	die();
}


if ( defined('INSIDE') ) {
	define('ADMINEMAIL'               , "CHANGE_ME@IN.CONSTANTS.PHP");
	define('GAMEURL'                  , "http://".$_SERVER['HTTP_HOST']."/");

	define('MAX_GALAXY_IN_WORLD'      , 9);
	define('MAX_SYSTEM_IN_GALAXY'     , 499);
	define('MAX_PLANET_IN_SYSTEM'     , 15);

	define('SPY_REPORT_ROW'           , 2);

	define('FIELDS_BY_MOONBASIS_LEVEL', 10);

	define('MAX_PLAYER_PLANETS'       , 18);

	define('MAX_BUILDING_QUEUE_SIZE'  , 6);

	define('MAX_FLEET_OR_DEFS_PER_ROW', 1000);

	define('MAX_OVERFLOW'             , 1.1);

	define('BASE_STORAGE_SIZE'        , 2500000);
	define('BUILD_METAL'              , 1000);
	define('BUILD_CRISTAL'            , 1000);
	define('BUILD_DEUTERIUM'          , 1000);

	// Debug Level
	define('DEBUG', 1); // Debugging off

	$ListCensure = array ( "<", ">", "script", "doquery", "http", "javascript");
} else {
	die("Hacking attempt");
}
?>