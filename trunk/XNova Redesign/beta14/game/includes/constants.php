<?php


/**
 * constants.php
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 */

// ----------------------------------------------------------------------------------------------------------------

if ( defined('INSIDE') ) {
	//Default skins
	define('DEFAULT_SKIN'				, BASEURL.'skins/xr/');
	//define('DEFAULT_SKIN'				, 'http://uni42.ogame.org/game/');
	
	//Default AVATAR where Gravatar not used
	define('AVATAR'						, 'wavatar'); //'404' returns a 404 error, 'wavatar' returns a unique but generic avatar [http://www.shamusyoung.com/twentysidedtale/?p=1462] otherwise just give a url.
	define('AVATAR_RATING'				, 'pg'); //Set the content you will allow by rating, g, pg, r, or x
	
	//Template and Language locations
	define('TEMPLATE_DIR'				, 'templates/');
	define('TEMPLATE_NAME'				, 'Redesigned');
	define('DEFAULT_LANG'				, 'en');
	
	//Link back to XNova Redesigned page for updates on release versions. Do not change
	define('XNOVAUKLINK' , 'http://xnovaredesigned.co.cc/');



	//Universe constraints
	define('MAX_GALAXY_IN_WORLD'      , 9);
	define('MAX_SYSTEM_IN_GALAXY'     , 499);
	define('MAX_PLANET_IN_SYSTEM'     , 15);
	
	
	//Some small config options
	define('SPY_REPORT_ROW'           , 2);		//Number of columns in the spy reports
	define('FIELDS_BY_MOONBASIS_LEVEL', 4);		//Number of fields per level of the moonbase
	//define('MAX_PLAYER_PLANETS'       , 8);	//Max number of planets for a player, NO LONGER CONSTANT
	define('MAX_BUILDING_QUEUE_SIZE'  , 5);		//How large should the buildings queue be
	define('MAX_FLEET_OR_DEFS_PER_ROW', 1000000);//How many ships or defenses in 1 item in the shipyard queue
	define('MAX_OVERFLOW'             , 1);		//When do mines stop working, 1 = 100% of starage used
	define('SHOW_ADMIN_IN_RECORDS'    , 0);		//Should the Admins appear in the Stats/Records page
	define('MAX_BATTLE_ROUNDS'			, 8);	//Number of rounds a battle should last until it is called a draw

	//Base storage size
	define('BASE_STORAGE_SIZE'        , 10000);
	define('BUILD_METAL'              , 500);
	define('BUILD_CRISTAL'            , 500);
	define('BUILD_DEUTERIUM'          , 500);
	
	//Change this constant to alter how much dark matter is worth. EG if set to 1000, 1 unit in the db is 1000 Dark Matter
	define('DARK_MATTER_FACTOR'       , 1);
	
	//Moon chance data
	define('DEBRIS_PER_PERCENT'			, 100000);
	define('MAX_MOON_PERCENT'			, 20);
	define('MIN_MOON_PERCENT'			, 1);
	
	// Maximum amount which can be raided from a planet, (as a faction of the total resources)
	define('MAX_ATTACK_RAID'			, 0.5);
	
	
	//Enable ACS
	define('ENABLE_ACS'					, false);
	
	
	//Expedition Constants
	define('MAX_DARKMATTER'				, 10000);	//Maximum ammount of Dark Matter that can be got from 1 expedition. (Note it is exponential so lower ammounts are more probable)
	define('MIN_DELAY'					, 60);		//Minimum ammount a fleet will be delayed (or sped up by) from an expedition. (Seconds)
	define('MAX_DELAY'					, 36000);	//Maximum ammount a fleet will be delayed (or sped up by) from an expedition. (Seconds)
	

	//A list of chara\cters to accept in emails. note that alpa-numeric are enabled by default
	define('EMAIL_CHARS'				, '-._');
	//define('EMAIL_CHARS'				, '-_.\+');

	// Debug Level
	define('DEBUG', 1); // Debugging off
	
	//Things to ban from some messages
	$ListCensure = array ( "<", ">", "'", "script", "doquery", "http", "javascript", "\"" );
} else {
	die("Error: Sorry you may not view this page in this way.");
}



?>
