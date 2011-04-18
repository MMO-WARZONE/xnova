<?php


/**
 * constants.php
 *
 * @version 1.0
 * @copyright 2009 by Dr.Isaacs f�r XNova-Germany
 * http://www.xnova-germany.org
 */

// ----------------------------------------------------------------------------------------------------------------

if ( defined('INSIDE') ) {
	define('ADMINEMAIL'               , "admin@xnova.de");
	define('GAMEURL'                  , "http://".$_SERVER['HTTP_HOST']."/");

	// Definition du monde connu !
	define('MAX_GALAXY_IN_WORLD'      , 9);
	define('MAX_SYSTEM_IN_GALAXY'     , 499);
	define('MAX_PLANET_IN_SYSTEM'     , 15);
	define('START_PLANET_POSITION'    , round (rand ( 1, 15) ));
	// Sperrzeit nach dem Urlaubsmodus (60x60x24x3 = 3tage)
	define('URLAUBS_MODUS_SPERRE'     , 259200);
	// Nombre de colones pour les rapports d'espionnage
	define('SPY_REPORT_ROW'           , 1);
	// Cases données par niveau de Base Lunaire
	define('FIELDS_BY_MOONBASIS_LEVEL', 4);
	// Nombre maximum de colonie par joueur
	define('MAX_PLAYER_PLANETS'       , 9);
	// Nombre maximum d'element dans la liste de construction de batiments
	define('MAX_BUILDING_QUEUE_SIZE'  , 5);
	// Nombre maximum d'element dans une ligne de liste de construction flotte et defenses
	define('MAX_FLEET_OR_DEFS_PER_ROW', 2000000);
	// Taux de depassement possible dans l'espace de stockage des hangards ...
	// 1.0 pour 100% - 1.1 pour 110% etc ...
	define('MAX_OVERFLOW'             , 1.0001);

	// Valeurs de bases pour les colonies ou planetes fraichement crées
	define('BASE_STORAGE_SIZE'        , 3000000);
	define('BUILD_METAL'              , 500);
	define('BUILD_CRISTAL'            , 500);
	define('BUILD_DEUTERIUM'          , 0);

	// Debug Level
	define('DEBUG', 1); // Debugging off
	// Mot qui sont interdit a la saisie !
	$ListCensure = array ( "<", ">", "script", "doquery", "http", "javascript");
} else {
	die("Hacking attempt");
}
?>