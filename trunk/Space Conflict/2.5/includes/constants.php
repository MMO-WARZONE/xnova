<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** constants.php                         **
******************************************/

if ( defined('INSIDE') ) {
	define('ADMINEMAIL'               , "Your Email Address");
	define('GAMEURL'                  , "http://".$_SERVER['HTTP_HOST']."/");

	define('MAX_GALAXY_IN_WORLD'      , 9);
	define('MAX_SYSTEM_IN_GALAXY'     , 999);
	define('MAX_PLANET_IN_SYSTEM'     , 15);

	define('SPY_REPORT_ROW'           , 2);
	define('FIELDS_BY_MOONBASIS_LEVEL', 10);
	define('FIELDS_BY_TERRAFORMER_LEVEL', 10);	
	define('MAX_PLAYER_PLANETS'       , 25);
	define('MAX_BUILDING_QUEUE_SIZE'  , 15);
	define('MAX_FLEET_OR_DEFS_PER_ROW', 1000000000);
 	define('MAX_OVERFLOW'             , 1.1);
	define('SHOW_ADMIN_IN_RECORDS'    , 0);

	define('BASE_STORAGE_SIZE'        , 100000);
	define('BUILD_METAL'              , 50);
	define('BUILD_CRISTAL'            , 50);
	define('BUILD_DEUTERIUM'          , 50);
	define('BUILD_TACHYON'            , 50);

	define('DEBUG', 0);
	$ListCensure = array ( "<", ">", "script", "doquery", "http", "javascript", "'" );
} else {
	die("Hacking attempt");
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>