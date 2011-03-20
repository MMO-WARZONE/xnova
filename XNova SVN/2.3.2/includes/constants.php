<?php
//version 1


if ( !defined('INSIDE') ) die(header("location:../"));

	//TEMPLATES DEFAULT SETTINGS
	define('DEFAULT_SKINPATH' 		 , 'styles/skins/xnova/');
	define('DEFAULT_SKINPATH_FOLDER'         , 'styles/skins/');


        define('TEMPLATE_DIR'     		 , 'styles/templates/');


	// ADMINISTRATOR EMAIL AND GAME URL - THIS DATA IS REQUESTED BY REG.PHP
	define('ADMINEMAIL'               , "jtsamper@xnova.es");
	define('GAMEURL'                  , "http://".$_SERVER['HTTP_HOST']."/");

	// UNIVERSE DATA, GALAXY, SYSTEMS AND PLANETS || DEFAULT 9-499-15 RESPECTIVELY
	define('MAX_GALAXY_IN_WORLD'      ,   9);
	define('MAX_SYSTEM_IN_GALAXY'     , 499);
	define('MAX_PLANET_IN_SYSTEM'     ,  15);

	// NUMBER OF COLUMNS FOR SPY REPORTS
	define('SPY_REPORT_ROW'           , 3);

	// FIELDS FOR EACH LEVEL OF THE LUNAR BASE
	define('FIELDS_BY_MOONBASIS_LEVEL', 3);

	// FIELDS FOR EACH LEVEL OF THE TERRAFORMER
	define('FIELDS_BY_TERRAFORMER'	  , 5);

	// NUMBER OF PLANETS THAT MAY HAVE A PLAYER
	define('MAX_PLAYER_PLANETS'       , 18);

	// NUMBER OF BUILDINGS THAT CAN GO IN THE CONSTRUCTION QUEUE
	define('MAX_BUILDING_QUEUE_SIZE'  , 5);

	// NUMBER OF SHIPS THAT CAN BUILD FOR ONCE
	define('MAX_FLEET_OR_DEFS_PER_ROW', 1000000);

	// PERCENTAGE OF RESOURCES THAT CAN BE OVER STORED
	// 1.0 TO 100% - 1.1% FOR 110 AND SO ON
	define('MAX_OVERFLOW'             , 1.5);

	// INITIAL RESOURCE OF NEW PLANETS
	define('BASE_STORAGE_SIZE'        , 1000000);
	define('BUILD_METAL'              ,     500);
	define('BUILD_CRISTAL'            ,     500);
	define('BUILD_DEUTERIUM'          , 	  0);
?>