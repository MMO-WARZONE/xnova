<?php


/**
 * constants.php
 *
 * @version 1.1
 */

if (!defined('INSIDE'))
{
   die();
}  
 
// ----------------------------------------------------------------------------------------------------------------

	define('ADMINEMAIL'               , "admin@teamrocket.info");
	define('GAMEURL'                  , "http://".$_SERVER['HTTP_HOST']."/");

	// Galaxien,Sonnensysteme und Planetenanzahl
	define('MAX_GALAXY_IN_WORLD'      , 9);
	define('MAX_SYSTEM_IN_GALAXY'     , 499);
	define('MAX_PLANET_IN_SYSTEM'     , 15);
	define('START_PLANET_POSITION'    , round (rand ( 1, 15) ));
	
	// Sperrzeit nach dem Urlaubsmodus (60x60x24x3 = 3tage)
	define('URLAUBS_MODUS_SPERRE'     , 259200);
	
	// Spionageanzhal Reihen
	define('SPY_REPORT_ROW'           , 1);
	
	// Anzahl der Mondfelder pro Mondbasis
	define('FIELDS_BY_MOONBASIS_LEVEL', 4);
	
	// Maximale Anzahl der Planeten pro Spieler
	define('MAX_PLAYER_PLANETS'       , 9);
	
	//Maximal Gebaeude in Bauschleife
	define('MAX_BUILDING_QUEUE_SIZE'  	, 5);
   
	// Maximal baubaren Schiffe und Verteidigungen auf einmal
	define('MAX_FLEET_OR_DEFS_PER_ROW'	, 400000);

	// Überschreitungen in den Speicherplatz in den Hangar(1.0 = 100%)
	define('MAX_OVERFLOW'             , 1.0);
	
	define('BASE_STORAGE_SIZE'        , 100000);
	define('BUILD_METAL'              , 500);
	define('BUILD_CRISTAL'            , 500);
	define('BUILD_DEUTERIUM'          , 0);

	// Maximal baubaren Schiffe und Verteidigungen auf einmal
	define('MAX_FLEET_OR_DEFS_PER_ROW'	, 400000);

	// User Session name
	define("USER_SESSION", "rocketnova");
	
	// // Debug Level
	define('DEBUG', 1); // Debugging aus
	
	// Wort verboten bei der Eingabe
	$ListCensure = array ( "<", "+", "-", "/", "'", ">", "script", "doquery", "http", "javascript", " ' ");

?>