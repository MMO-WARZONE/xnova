<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** scrapvars.php                         **
******************************************/

if ( defined('INSIDE')) {

	$scrapid = array(202 => "small_ship_cargo",
			 203 => "big_ship_cargo",
			 204 => "light_hunter",
			 205 => "heavy_hunter",
			 206 => "crusher",
			 207 => "battle_ship",
			 208 => "colonizer",
			 209 => "recycler",
			 210 => "spy_sonde",
			 211 => "bomber_ship",
			 212 => "solar_satelit",
			 213 => "destructor",
			 214 => "dearth_star",
			 215 => "battleship",
			 216 => "freighter",
			 217 => "elite_fighter",
			 218 => "world_eater",

			 401 => "misil_launcher",
			 402 => "small_laser",
			 403 => "big_laser",
			 404 => "gauss_canyon",
			 405 => "ionic_canyon",
			 406 => "buster_canyon",
			 407 => "small_protection_shield",
			 408 => "big_protection_shield",
			 409 => "orb_def_plat",

			 996 => "metal",
			 997 => "crystal",
			 998 => "deuterium",
			 999 => "tachyon");


	$scrapname = array(202 => "Small Cargo Ship",
			   203 => "Large Cargo Ship",
			   204 => "Light Fighter",
			   205 => "Heavy Fighter",
			   206 => "Cruiser",
			   207 => "Battleship",
			   208 => "Colony Ship",
			   209 => "Recycler",
			   210 => "Espionage Probe",
			   211 => "Bomber",
			   212 => "Solar Satalite",
			   213 => "Destroyer",
			   214 => "Death Star",
			   215 => "Battlecruiser",
			   216 => "Freighter",
			   217 => "Elite Fighter",
			   218 => "World Eater",

			   401 => "Rocket Launcher",
			   402 => "Small Laser",
			   403 => "Large Laser",
			   404 => "Gauss cannon",
			   405 => "Ion Cannon",
			   406 => "Plasma Cannon",
			   407 => "Small Shield Dome",
			   408 => "Large Shield Dome",
			   409 => "Orbital Defense Platform",

			   996 => "Metal",
			   997 => "Crystal",
			   998 => "Deuterium",
			   999 => "Tachyon Particles"
			   );

	$scrapvalue = array(202 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    203 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    204 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    205 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    206 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    207 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    208 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    209 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    210 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    211 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    212 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    213 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    214 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    215 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    216 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    217 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    218 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),

			    401 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    402 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    403 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    404 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    405 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    406 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    407 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    408 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    409 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),

			    996 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    997 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    998 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1),
			    999 => array('metal' => 1, 'crystal' => 1, 'deuterium' => 1, 'tachyon' => 1)
			    );
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>	