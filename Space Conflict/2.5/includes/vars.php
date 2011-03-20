<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** vars.php                              **
******************************************/

if ( defined('INSIDE')) {
	$messfields = array (
	0 => "mnl_spy",
	1 => "mnl_joueur",
	2 => "mnl_alliance",
	3 => "mnl_attaque",
	4 => "mnl_exploit",
	5 => "mnl_transport",
	15 => "mnl_expedition",
	97 => "mnl_general",
	99 => "mnl_buildlist",
	100 => "new_message"
	);

	$resource = array(
	  1 => "metal_mine",
	  2 => "crystal_mine",
	  3 => "deuterium_sintetizer",
	  4 => "tach_accel",
	  5 => "solar_plant",
	 12 => "fusion_plant",
	 14 => "robot_factory",
	 15 => "nano_factory",
	 21 => "hangar",
	 22 => "metal_store",
	 23 => "crystal_store",
	 24 => "deuterium_store",
	 25 => "tachyon_store",
	 31 => "laboratory",
	 33 => "terraformer",
	 34 => "ally_deposit",
	 35 => "orb_shipyard",
	 41 => "mondbasis",
	 42 => "phalanx",
	 43 => "sprungtor",
	 44 => "silo",

	106 => "spy_tech",
	108 => "computer_tech",
	109 => "military_tech",
	110 => "defence_tech",
	111 => "shield_tech",
	113 => "energy_tech",
	114 => "hyperspace_tech",
	115 => "combustion_tech",
	117 => "impulse_motor_tech",
	118 => "hyperspace_motor_tech",
	120 => "laser_tech",
	121 => "ionic_tech",
	122 => "buster_tech",
	123 => "intergalactic_tech",
	124 => "expedition_tech",
	194 => "tach_extract_tech",
	195 => "tach_compress_tech",
	196 => "genetic_tech",
	197 => "quantum_tech",
	198 => "quantum_drive_tech",
	199 => "graviton_tech",
	200 => "tach_tech",

	202 => "small_ship_cargo",
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

	502 => "interceptor_misil",
	503 => "interplanetary_misil",

	601 => "rpg_indy",
	602 => "rpg_bunker",
	603 => "rpg_acad",
	604 => "rpg_conq",
	605 => "rpg_raideur",
	606 => "rpg_empereur",
	607 => "rpg_geologue",
	608 => "rpg_amiral",
	609 => "rpg_ingenieur",
	610 => "rpg_technocrate",
	611 => "rpg_constructeur",
	612 => "rpg_scientifique",
	613 => "rpg_stockeur",
	614 => "rpg_defenseur",
	615 => "rpg_espion",
	616 => "rpg_commandant",
	617 => "rpg_destructeur",
	618 => "rpg_general",
	619 => "rpg_quantum",
	);
	
	$requeriments = array(
		  4 => array( 194 =>   1),
		 12 => array(   3 =>   5, 113 =>   3),
		 15 => array(  14 =>  10, 108 =>  10),
		 21 => array(  14 =>   2),
		 25 => array( 194 =>   1),
		 33 => array(  15 =>   1, 113 =>  12),
		 35 => array(  15 =>   3,  21 =>  20, 108 => 20, 111 => 20, 113 => 20, 200 => 1),

		 42 => array(  41 =>   1),
		 43 => array(  41 =>   1, 114 =>   7),

		106 => array(  31 =>   3),
		108 => array(  31 =>   1),
		109 => array(  31 =>   4),
		110 => array( 113 =>   3,  31 =>   6),
		111 => array(  31 =>   2),
		113 => array(  31 =>   1),
		114 => array( 113 =>   5, 110 =>   5,  31 =>   7),
		115 => array( 113 =>   1,  31 =>   1),
		117 => array( 113 =>   1,  31 =>   2),
		118 => array( 114 =>   3,  31 =>   7),
		120 => array(  31 =>   1, 113 =>   2),
		121 => array(  31 =>   4, 120 =>   5, 113 =>   4),
		122 => array(  31 =>   5, 113 =>   8, 120 =>  10, 121 =>   5),
		123 => array(  31 =>  10, 108 =>   8, 114 =>   8),
		124 => array(  31 =>   3, 108 =>   4, 117 =>   3),
		194 => array( 108 =>  20, 113 =>  20, 114 =>  10),
		195 => array( 194 =>   5),
		196 => array( 108 =>  20, 113 =>  20, 114 =>  10),
		197 => array( 108 =>  20, 113 =>  20, 114 =>  10),
		198 => array( 197 =>   5),
		199 => array(  31 =>  12),
		200 => array( 194 =>   1),

		202 => array(  21 =>   2, 115 =>   2),
		203 => array(  21 =>   4, 115 =>   6),
		204 => array(  21 =>   1, 115 =>   1),
		205 => array(  21 =>   3, 111 =>   2, 117 =>   2),
		206 => array(  21 =>   5, 117 =>   4, 121 =>   2),
		207 => array(  21 =>   7, 118 =>   4),
		208 => array(  21 =>   4, 117 =>   3),
		209 => array(  21 =>   4, 115 =>   6, 110 =>   2),
		210 => array(  21 =>   3, 115 =>   3, 106 =>   2),
		211 => array( 117 =>   6,  21 =>   8, 122 =>   5),
		212 => array(  21 =>   1),
		213 => array(  21 =>   9, 118 =>   6, 114 =>   5),
		214 => array(  21 =>  12, 118 =>   7, 114 =>   6, 199 =>   1),
		215 => array( 114 =>   5, 120 =>  12, 118 =>   5,  21 =>   8),
		216 => array(  21 =>  12,  35 =>   1, 110 =>  10, 111 =>   8, 118 =>   7),
		217 => array(  21 =>  16,  35 =>   2, 198 =>   1, 200 =>   1),
		218 => array(  21 =>  20,  35 =>   5, 195 =>   1, 198 =>   3, 200 =>  1), 

		401 => array(  21 =>   1),
		402 => array(  21 =>   1, 113 =>   1,  21 =>   2, 120 =>   3),
		403 => array(  21 =>   1, 113 =>   3,  21 =>   4, 120 =>   6),
		404 => array(  21 =>   6, 113 =>   6, 109 =>   3, 110 =>   1),
		405 => array(  21 =>   4, 121 =>   4),
		406 => array(  21 =>   8, 122 =>   7),
		407 => array(  21 =>  10, 110 =>   2,  21 =>   1),
		408 => array(  21 =>  12, 110 =>   6,  21 =>   6),
		409 => array(  21 =>  20,  35 =>   5, 195 =>   1, 197 =>   3, 198 => 1),

		502 => array(  44 =>   2),
		503 => array(  44 =>   4),

		601 => array( 607 =>   1, 611 =>   1, 613 =>   1),
		602 => array( 608 =>   1, 610 =>   1, 108 =>   1, 109 =>   1, 110 =>   1),
		603 => array( 607 =>   1, 609 =>   1, 612 =>   1, 108 =>   1, 113 =>   1),
		604 => array( 602 =>   1, 614 =>   1, 615 =>   1, 109 =>   5, 110 =>   5, 111 =>   5, 121 =>   1),
		605 => array( 603 =>   1, 616 =>   1, 618 =>   1, 109 =>  10, 110 =>  10, 111 =>  10, 122 =>   1),
		606 => array( 601 =>   1, 602 =>   1, 603 =>   1, 604 =>   1, 605 =>   1),
		609 => array( 607 =>   1),
		610 => array( 608 =>   1),
		611 => array( 607 =>   1),
		612 => array( 609 =>   1),
		613 => array( 609 =>   1),
		614 => array( 608 =>   1),
		615 => array( 602 =>   1, 614 =>   1, 106 =>   5),
		616 => array( 601 =>   1, 602 =>   1, 614 =>   1, 108 =>   5),
		617 => array( 601 =>   1, 602 =>   1, 603 =>   1, 109 =>   5),
		618 => array( 604 =>   1, 616 =>   1, 617 =>   1)
	);

	$pricelist = array(
		  1 => array ( 'metal' =>        60, 'crystal' =>        15, 'deuterium' =>         0, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>       75),
		  2 => array ( 'metal' =>        48, 'crystal' =>        24, 'deuterium' =>         0, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>       75),
		  3 => array ( 'metal' =>       225, 'crystal' =>        75, 'deuterium' =>         0, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>      300),
		  4 => array ( 'metal' =>    750000, 'crystal' =>    750000, 'deuterium' =>     75000, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>     2500),
		  5 => array ( 'metal' =>        75, 'crystal' =>        30, 'deuterium' =>         0, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>      105),
		 12 => array ( 'metal' =>       900, 'crystal' =>       360, 'deuterium' =>       180, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>     1250),
		 14 => array ( 'metal' =>       400, 'crystal' =>       120, 'deuterium' =>       200, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>      750),
		 15 => array ( 'metal' =>    100000, 'crystal' =>     50000, 'deuterium' =>     10000, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>  1500000),
		 21 => array ( 'metal' =>       400, 'crystal' =>       200, 'deuterium' =>       100, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>      750),
		 22 => array ( 'metal' =>      2000, 'crystal' =>         0, 'deuterium' =>         0, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>     2000),
		 23 => array ( 'metal' =>      2000, 'crystal' =>      1000, 'deuterium' =>         0, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>     3000),
		 24 => array ( 'metal' =>      2000, 'crystal' =>      2000, 'deuterium' =>         0, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>     4000),
		 25 => array ( 'metal' =>    750000, 'crystal' =>    750000, 'deuterium' =>     75000, 'tachyon' =>   50000, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>    12500),
		 31 => array ( 'metal' =>       200, 'crystal' =>       400, 'deuterium' =>       200, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>      750),
		 33 => array ( 'metal' =>         0, 'crystal' =>     50000, 'deuterium' =>    100000, 'tachyon' =>       0, 'energy' => 1000, 'factor' =>   3/2, 'mass' =>    75000),
		 34 => array ( 'metal' =>     20000, 'crystal' =>     40000, 'deuterium' =>         0, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>    60000),
		 35 => array ( 'metal' =>    500000, 'crystal' =>    100000, 'deuterium' =>    250000, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>  1500000),
		 41 => array ( 'metal' =>     20000, 'crystal' =>     40000, 'deuterium' =>     20000, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>    75000),
		 42 => array ( 'metal' =>     20000, 'crystal' =>     40000, 'deuterium' =>     20000, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>    75000),
		 43 => array ( 'metal' =>    200000, 'crystal' =>    400000, 'deuterium' =>    200000, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>  5000000),
		 44 => array ( 'metal' =>     20000, 'crystal' =>     20000, 'deuterium' =>      1000, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>      250),

		106 => array ( 'metal' =>       200, 'crystal' =>      1000, 'deuterium' =>       200, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>     1400),
		108 => array ( 'metal' =>         0, 'crystal' =>       400, 'deuterium' =>       600, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>     1000),
		109 => array ( 'metal' =>       800, 'crystal' =>       200, 'deuterium' =>         0, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>     1000),
		110 => array ( 'metal' =>       200, 'crystal' =>       600, 'deuterium' =>         0, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>      800),
		111 => array ( 'metal' =>      1000, 'crystal' =>         0, 'deuterium' =>         0, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>     1000),
		113 => array ( 'metal' =>         0, 'crystal' =>       800, 'deuterium' =>       400, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>     1200),
		114 => array ( 'metal' =>         0, 'crystal' =>      4000, 'deuterium' =>      2000, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>     6000),
		115 => array ( 'metal' =>       400, 'crystal' =>         0, 'deuterium' =>       600, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>     1000),
		117 => array ( 'metal' =>      2000, 'crystal' =>      4000, 'deuterium' =>      6000, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>    12000),
		118 => array ( 'metal' =>     10000, 'crystal' =>     20000, 'deuterium' =>      6000, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>    36000),
		120 => array ( 'metal' =>       200, 'crystal' =>       100, 'deuterium' =>         0, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>      300),
		121 => array ( 'metal' =>      1000, 'crystal' =>       300, 'deuterium' =>       100, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>     1400),
		122 => array ( 'metal' =>      2000, 'crystal' =>      4000, 'deuterium' =>      1000, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>     7000),
		123 => array ( 'metal' =>    240000, 'crystal' =>    400000, 'deuterium' =>    160000, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>   500000),
		124 => array ( 'metal' =>      4000, 'crystal' =>      8000, 'deuterium' =>      4000, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>    16000),
		194 => array ( 'metal' =>    500000, 'crystal' =>    500000, 'deuterium' =>    100000, 'tachyon' =>       0, 'energy' =>    0, 'factor' =>   3/2, 'mass' => 10000000),
		195 => array ( 'metal' =>     50000, 'crystal' =>     50000, 'deuterium' =>     50000, 'tachyon' =>  125000, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>  1750000),
		196 => array ( 'metal' =>     50000, 'crystal' =>     50000, 'deuterium' =>     50000, 'tachyon' =>   50000, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>  1500000),
		197 => array ( 'metal' =>     50000, 'crystal' =>     50000, 'deuterium' =>     50000, 'tachyon' =>   50000, 'energy' =>    0, 'factor' =>   3/2, 'mass' =>  1500000),
		198 => array ( 'metal' =>    750000, 'crystal' =>    750000, 'deuterium' =>    500000, 'tachyon' =>  125000, 'energy' =>    0, 'factor' =>   3/2, 'mass' => 12000000),
		199 => array ( 'metal' =>         0, 'crystal' =>         0, 'deuterium' =>         0, 'tachyon' =>       0, 'energy_max' => 300000,  'factor' =>   3/2, 'mass' =>  500000),
		200 => array ( 'metal' =>    750000, 'crystal' =>    750000, 'deuterium' =>    750000, 'tachyon' =>       0, 'energy_max' => 1000000, 'factor' =>  3/2, 'mass' => 12000000),

		202 => array ( 'metal' =>      2500, 'crystal' =>      1500, 'deuterium' =>         0, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 20  , 'consumption2' => 40  , 'speed' =>      5000, 'speed2' =>     10000, 'capacity' =>    5000, 'mass' =>     3500 ),
		203 => array ( 'metal' =>      7500, 'crystal' =>      7500, 'deuterium' =>         0, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 50  , 'consumption2' => 50  , 'speed' =>      7500, 'speed2' =>      7500, 'capacity' =>   25000, 'mass' =>    12500 ),
		204 => array ( 'metal' =>      1500, 'crystal' =>      1500, 'deuterium' =>         0, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 20  , 'consumption2' => 20  , 'speed' =>     12500, 'speed2' =>     12500, 'capacity' =>      50, 'mass' =>     3500 ),
		205 => array ( 'metal' =>     10000, 'crystal' =>      2500, 'deuterium' =>         0, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 75  , 'consumption2' => 75  , 'speed' =>     10000, 'speed2' =>     15000, 'capacity' =>     100, 'mass' =>    12500 ),
		206 => array ( 'metal' =>     25000, 'crystal' =>      7500, 'deuterium' =>      2500, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 300 , 'consumption2' => 300 , 'speed' =>     15000, 'speed2' =>     15000, 'capacity' =>     800, 'mass' =>   100000 ),
		207 => array ( 'metal' =>     50000, 'crystal' =>     10000, 'deuterium' =>         0, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 500 , 'consumption2' => 500 , 'speed' =>     10000, 'speed2' =>     10000, 'capacity' =>    1500, 'mass' =>   250000 ),
		208 => array ( 'metal' =>     10000, 'crystal' =>     10000, 'deuterium' =>      5000, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 1000, 'consumption2' => 1000, 'speed' =>      2500, 'speed2' =>      2500, 'capacity' =>    7500, 'mass' =>    25000 ),
		209 => array ( 'metal' =>     10000, 'crystal' =>      5000, 'deuterium' =>      1500, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 300 , 'consumption2' => 300 , 'speed' =>      2000, 'speed2' =>      2000, 'capacity' => 2000000, 'mass' =>    15000 ),
		210 => array ( 'metal' =>       100, 'crystal' =>       750, 'deuterium' =>        50, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 1   , 'consumption2' => 1   , 'speed' => 100000000, 'speed2' => 100000000, 'capacity' =>       5, 'mass' =>      500 ),
		211 => array ( 'metal' =>     50000, 'crystal' =>     25000, 'deuterium' =>      2500, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 1000, 'consumption2' => 1000, 'speed' =>      4000, 'speed2' =>      5000, 'capacity' =>     500, 'mass' =>   500000 ),
		212 => array ( 'metal' =>        50, 'crystal' =>       500, 'deuterium' =>       250, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 0   , 'consumption2' => 0   , 'speed' =>         0, 'speed2' =>         0, 'capacity' =>       0, 'mass' =>      500 ),
		213 => array ( 'metal' =>     60000, 'crystal' =>     50000, 'deuterium' =>     15000, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 1000, 'consumption2' => 1000, 'speed' =>      5000, 'speed2' =>      5000, 'capacity' =>    2000, 'mass' =>  2500000 ),
		214 => array ( 'metal' =>   1000000, 'crystal' =>   2500000, 'deuterium' =>    100000, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 1   , 'consumption2' => 1   , 'speed' =>       100, 'speed2' =>       100, 'capacity' => 1000000, 'mass' =>  7500000 ),
		215 => array ( 'metal' =>     30000, 'crystal' =>     40000, 'deuterium' =>     15000, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 250 , 'consumption2' => 250 , 'speed' =>     10000, 'speed2' =>     10000, 'capacity' =>     750, 'mass' =>  5000000 ),
		216 => array ( 'metal' =>    250000, 'crystal' =>    150000, 'deuterium' =>     75000, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'consumption' => 1000, 'consumption2' => 1000, 'speed' =>        50, 'speed2' =>        50, 'capacity' => 7500000, 'mass' =>  5000000 ),
		217 => array ( 'metal' =>    500000, 'crystal' =>    125000, 'deuterium' =>     75000, 'tachyon' =>   0, 'energy' => 0, 'factor' => 1, 'consumption' => 125 , 'consumption2' => 125 , 'speed' =>    100000, 'speed2' =>    100000, 'capacity' =>     250, 'mass' =>    10250 ),
		218 => array ( 'metal' =>  25000000, 'crystal' =>   2500000, 'deuterium' =>   1000000, 'tachyon' =>  0, 'energy' => 0, 'factor' => 1, 'consumption' => 1000, 'consumption2' => 1000, 'speed' =>        50, 'speed2' =>        50, 'capacity' =>  500000, 'mass' => 25000000 ),

		401 => array ( 'metal' =>      2500, 'crystal' =>         0, 'deuterium' =>         0, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'mass' =>     2500 ),
		402 => array ( 'metal' =>       750, 'crystal' =>       250, 'deuterium' =>        50, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'mass' =>     3750 ),
		403 => array ( 'metal' =>      5000, 'crystal' =>      1500, 'deuterium' =>       100, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'mass' =>     5000 ),
		404 => array ( 'metal' =>     10000, 'crystal' =>     10000, 'deuterium' =>      2500, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'mass' =>     7500 ),
		405 => array ( 'metal' =>     25000, 'crystal' =>     25000, 'deuterium' =>       500, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'mass' =>    12500 ),
		406 => array ( 'metal' =>     50000, 'crystal' =>     50000, 'deuterium' =>     20000, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'mass' =>   250000 ),
		407 => array ( 'metal' =>     10000, 'crystal' =>     10000, 'deuterium' =>       250, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'mass' =>      500 ),
		408 => array ( 'metal' =>     50000, 'crystal' =>     50000, 'deuterium' =>       750, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'mass' =>      500 ),
		409 => array ( 'metal' =>  25000000, 'crystal' =>    250000, 'deuterium' =>    750000, 'tachyon' =>   25000, 'energy' => 0, 'factor' => 1, 'mass' => 25000000 ),

		502 => array ( 'metal' =>      8000, 'crystal' =>      2000, 'deuterium' =>       0, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'mass' =>        250 ),
		503 => array ( 'metal' =>     12500, 'crystal' =>      2500, 'deuterium' =>   10000, 'tachyon' =>       0, 'energy' => 0, 'factor' => 1, 'mass' =>        250 ),

    // Officer Max Levels
		601 => array ( 'max' =>   1),
		602 => array ( 'max' =>   1),
		603 => array ( 'max' =>   1),
		604 => array ( 'max' =>   1),
		605 => array ( 'max' =>   1),
		606 => array ( 'max' =>   1),
		607 => array ( 'max' =>  20),
		608 => array ( 'max' =>  20),
		609 => array ( 'max' =>  10),
		610 => array ( 'max' =>  10),
		611 => array ( 'max' =>   7),
		612 => array ( 'max' =>   7),
		613 => array ( 'max' =>   5),
		614 => array ( 'max' =>   5),
		615 => array ( 'max' =>   5),
		616 => array ( 'max' =>   3),
		617 => array ( 'max' =>   3),
		618 => array ( 'max' =>   2),
		619 => array ( 'max' =>   2),
		
	);

	$CombatCaps = array(
		202 => array ( 'shield' =>     10, 'attack' =>      1, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    1, 211 =>   1, 212 =>    1, 213 =>   1, 214 =>   1, 215 =>   1, 216 =>   1, 217 =>   1, 218 =>   1, 401 =>   1, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1, 409 =>   1 )),
		203 => array ( 'shield' =>     25, 'attack' =>      1, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    1, 211 =>   1, 212 =>    1, 213 =>   1, 214 =>   1, 215 =>   1, 216 =>   1, 217 =>   1, 218 =>   1, 401 =>   1, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1, 409 =>   1 )),
		204 => array ( 'shield' =>     10, 'attack' =>     50, 'sd' => array (202 =>   2, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   2, 209 =>   2, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   1, 216 =>   1, 217 =>   1, 218 =>   1, 401 =>   2, 402 =>   2, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   5, 408 =>   1, 409 =>   1 )),
		205 => array ( 'shield' =>     25, 'attack' =>    150, 'sd' => array (202 =>   2, 203 =>   3, 204 =>   5, 205 =>   1, 206 =>   1, 207 =>   3, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    2, 213 =>   1, 214 =>   1, 215 =>   1, 216 =>   1, 217 =>   1, 218 =>   1, 401 =>   1, 402 =>   2, 403 =>   3, 404 =>   2, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   5, 409 =>   1 )),
		206 => array ( 'shield' =>     75, 'attack' =>    400, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   2, 208 =>   1, 209 =>   1, 210 =>    1, 211 =>   3, 212 =>    1, 213 =>   4, 214 =>   1, 215 =>   1, 216 =>   5, 217 =>   1, 218 =>   1, 401 =>  10, 402 =>   5, 403 =>   3, 404 =>   1, 405 =>   2, 406 =>   1, 407 =>   1, 408 =>   3, 409 =>   1 )),
		207 => array ( 'shield' =>    200, 'attack' =>   1000, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   1, 216 =>   1, 217 =>   1, 218 =>   1, 401 =>   8, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1, 409 =>   1 )),
		208 => array ( 'shield' =>    150, 'attack' =>      5, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   1, 216 =>   1, 217 =>   1, 218 =>   1, 401 =>   1, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1, 409 =>   1 )),
		209 => array ( 'shield' =>     25, 'attack' =>      1, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   1, 216 =>   1, 217 =>   1, 218 =>   1, 401 =>   1, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1, 409 =>   1 )),
		210 => array ( 'shield' =>      0, 'attack' =>      5, 'sd' => array (202 =>   0, 203 =>   0, 204 =>   0, 205 =>   0, 206 =>   0, 207 =>   0, 208 =>   0, 209 =>   0, 210 =>    0, 211 =>   0, 212 =>    0, 213 =>   0, 214 =>   0, 215 =>   0, 216 =>   1, 217 =>   1, 218 =>   1, 401 =>   0, 402 =>   0, 403 =>   0, 404 =>   0, 405 =>   0, 406 =>   0, 407 =>   0, 408 =>   0, 409 =>   1 )),
		211 => array ( 'shield' =>    500, 'attack' =>   1000, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   1, 216 =>   1, 217 =>   1, 218 =>   1, 401 =>  20, 402 =>  20, 403 =>  10, 404 =>   1, 405 =>  10, 406 =>   1, 407 =>   1, 408 =>   1, 409 =>   1 )),
		212 => array ( 'shield' =>     15, 'attack' =>      1, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    1, 211 =>   1, 212 =>    0, 213 =>   1, 214 =>   1, 215 =>   1, 216 =>   1, 217 =>   1, 218 =>   1, 401 =>   1, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1, 409 =>   1 )),
		213 => array ( 'shield' =>    500, 'attack' =>   2000, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   2, 216 =>   1, 217 =>   1, 218 =>   1, 401 =>   1, 402 =>  10, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1, 409 =>   1 )),
		214 => array ( 'shield' =>  50000, 'attack' => 200000, 'sd' => array (202 => 250, 203 => 250, 204 => 200, 205 => 100, 206 =>  33, 207 =>  30, 208 => 250, 209 => 250, 210 => 1250, 211 =>  25, 212 => 1250, 213 =>   5, 214 =>  15, 215 =>  15, 216 =>   1, 217 =>   1, 218 =>   1, 401 => 200, 402 => 200, 403 => 100, 404 =>  50, 405 => 100, 406 =>   1, 407 =>   1, 408 =>   1, 409 =>   1 )),
		215 => array ( 'shield' =>    400, 'attack' =>    750, 'sd' => array (202 =>   3, 203 =>   3, 204 =>   1, 205 =>   4, 206 =>   4, 207 =>   7, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    5, 213 =>   1, 214 =>   1, 215 =>   1, 216 =>   3, 217 =>   1, 218 =>   1, 401 =>   1, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1, 409 =>   1 )),
		216 => array ( 'shield' =>  75000, 'attack' =>      1, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    1, 211 =>   1, 212 =>    1, 213 =>   1, 214 =>   1, 215 =>   1, 216 =>   1, 217 =>   1, 218 =>   1, 401 =>   1, 402 =>   1, 403 =>   1, 404 =>   1, 405 =>   1, 406 =>   1, 407 =>   1, 408 =>   1, 409 =>   1 )),
		217 => array ( 'shield' =>     55, 'attack' =>    150, 'sd' => array (202 =>   3, 203 =>   3, 204 =>  10, 205 =>  10, 206 =>  10, 207 =>   2, 208 =>   2, 209 =>   2, 210 =>   25, 211 =>   3, 212 =>    2, 213 =>   1, 214 => 250, 215 =>   1, 216 =>   1, 217 =>   1, 218 =>   1, 401 =>  50, 402 =>  50, 403 =>  75, 404 =>  20, 405 =>  10, 406 =>   5, 407 =>   3, 408 =>   2, 409 =>   1 )),
		218 => array ( 'shield' =>  75000, 'attack' => 500000, 'sd' => array (202 =>   5, 203 =>   5, 204 =>  25, 205 =>  25, 206 =>   5, 207 =>   5, 208 =>   2, 209 =>   1, 210 =>    1, 211 =>   1, 212 =>    1, 213 =>  20, 214 =>  50, 215 =>  50, 216 =>  50, 217 =>   1, 218 =>  10, 401 => 250, 402 => 250, 403 => 250, 404 => 150, 405 => 150, 406 =>  50, 407 =>  50, 408 => 150, 409 =>  75 )),

		401 => array ( 'shield' =>    25, 'attack' =>     75, 'sd' => array (202 =>   3, 203 =>   2, 204 =>   5, 205 =>   3, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>   25, 211 =>   1, 212 =>    0, 213 =>   1, 214 =>   1, 215 =>   1, 216 =>   1, 217 =>   1, 218 =>   1) ),
		402 => array ( 'shield' =>    25, 'attack' =>    125, 'sd' => array (202 =>   3, 203 =>   2, 204 =>   3, 205 =>   2, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>   25, 211 =>   1, 212 =>    0, 213 =>   1, 214 =>   1, 215 =>   1, 216 =>   1, 217 =>   2, 218 =>   1) ),
		403 => array ( 'shield' =>    75, 'attack' =>    250, 'sd' => array (202 =>   1, 203 =>   2, 204 =>   2, 205 =>   5, 206 =>   4, 207 =>   2, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    0, 213 =>   1, 214 =>   1, 215 =>   1, 216 =>   1, 217 =>   3, 218 =>   1) ),
		404 => array ( 'shield' =>   250, 'attack' =>    500, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   3, 206 =>   4, 207 =>   5, 208 =>   2, 209 =>   2, 210 =>    5, 211 =>   1, 212 =>    0, 213 =>   3, 214 =>   2, 215 =>   2, 216 =>   1, 217 =>   1, 218 =>   1) ),
		405 => array ( 'shield' =>   500, 'attack' =>   1100, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   2, 210 =>    5, 211 =>   2, 212 =>    0, 213 =>   4, 214 =>   3, 215 =>   3, 216 =>   1, 217 =>   1, 218 =>   5) ),
		406 => array ( 'shield' =>  1250, 'attack' =>   5000, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   2, 210 =>    5, 211 =>   2, 212 =>    0, 213 =>   3, 214 =>   2, 215 =>   4, 216 =>   1, 217 =>   1, 218 =>   2) ),
		407 => array ( 'shield' =>  1500, 'attack' =>      1, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    0, 213 =>   1, 214 =>   1, 215 =>   1, 216 =>   1, 217 =>   1, 218 =>   3) ),
		408 => array ( 'shield' =>  3750, 'attack' =>      1, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>   1, 212 =>    0, 213 =>   1, 214 =>   1, 215 =>   1, 216 =>   1, 217 =>   1, 218 =>   2) ),
		409 => array ( 'shield' => 50000, 'attack' => 250000, 'sd' => array (202 =>   1, 203 =>   1, 204 =>   1, 205 =>   1, 206 =>   1, 207 =>   1, 208 =>   1, 209 =>   1, 210 =>    5, 211 =>  15, 212 =>    0, 213 =>   1, 214 =>   1, 215 =>  15, 216 =>   1, 217 =>   1, 218 =>   3) ),

		502 => array ( 'shield' =>     1, 'attack' =>  1200000 ),
		503 => array ( 'shield' =>     1, 'attack' =>  1200000 )
	);

	$ProdGrid = array(
		// Metal Mine Production
		1   => array( 'metal' =>   40, 'crystal' =>   10, 'deuterium' =>    0, 'energy' => 0, 'factor' => 3/2,
			'formule' => array(
				'metal'     => 'return   (30 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);',
				'crystal'   => 'return   "0";',
				'deuterium' => 'return   "0";',
				'tachyon'   => 'return   "0";',
				'energy'    => 'return - (10 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);')
		),
		// Crystal Mine Production
		2   => array( 'metal' =>   30, 'crystal' =>   15, 'deuterium' =>    0, 'energy' => 0, 'factor' => 1.6,
			'formule' => array(
				'metal'     => 'return   "0";',
				'crystal'   => 'return   (20 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);',
				'deuterium' => 'return   "0";',
				'tachyon'   => 'return   "0";',
				'energy'    => 'return - (10 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);')
		),
		// Deuterium Synthetsizer Production
		3   => array( 'metal' =>  150, 'crystal' =>   50, 'deuterium' =>    0, 'energy' => 0, 'factor' => 3/2,
			'formule' => array(
				'metal'     => 'return   "0";',
				'crystal'   => 'return   "0";',
				'deuterium' => 'return  ((10 * $BuildLevel * pow((1.1), $BuildLevel)) * (-0.002 * $BuildTemp + 1.28)) * (0.1 * $BuildLevelFactor);',
				'tachyon'   => 'return   "0";',
				'energy'    => 'return - (30 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);')
		),
		// Tachyon Particle Accelerator Production
		4   => array( 'metal' =>  150, 'crystal' =>   50, 'deuterium' =>    0, 'energy' => 0, 'factor' => 3/2,
			'formule' => array(
				'metal'     => 'return   "0";',
				'crystal'   => 'return   "0";',
				'deuterium' => 'return - ((2 * $BuildLevel * pow((1.1), $BuildLevel)) * (-0.002 * $BuildTemp + 1.28)) * (0.1 * $BuildLevelFactor);',
				'tachyon'   => 'return   ((5 * $BuildLevel * pow((1.1), $BuildLevel)) * (-0.002 * $BuildTemp + 1.28)) * (0.1 * $BuildLevelFactor);',
				'energy'    => 'return - (10 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);')
		
		),
		// Solar Plant Production
		5   => array( 'metal' =>   50, 'crystal' =>   20, 'deuterium' =>    0, 'energy' => 0, 'factor' => 3/2,
			'formule' => array(
				'metal'     => 'return   "0";',
				'crystal'   => 'return   "0";',
				'deuterium' => 'return   "0";',
				'tachyon'   => 'return   "0";',
				'energy'    => 'return   (20 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);')
		),
		// Fusion Reactor Production
		12  => array( 'metal' =>  500, 'crystal' =>  200, 'deuterium' =>  100, 'energy' => 0, 'factor' => 1.8,
			'formule' => array(
				'metal'     => 'return   "0";',
				'crystal'   => 'return   "0";',
				'deuterium' => 'return - (10 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);',
				'tachyon'   => 'return   "0";',
				'energy'    => 'return   (50 * $BuildLevel * pow((1.1), $BuildLevel)) * (0.1 * $BuildLevelFactor);')
		),
		// Solar Satellite Production
		212 => array( 'metal' =>    0, 'crystal' => 2000, 'deuterium' =>  500, 'energy' => 0, 'factor' => 0.5,
			'formule' => array(
				'metal'     => 'return   "0";',
				'crystal'   => 'return   "0";',
				'deuterium' => 'return   "0";',
				'tachyon'   => 'return   "0";',
				'energy'    => 'return  (($BuildTemp / 4) + 20) * $BuildLevel * (0.1 * $BuildLevelFactor);')
		)
	);

	$reslist['build']    = array (   1,   2,   3,   4,   5,  12,  14,  15,  21,  22,  23,  24,  25,  31,  33,  34,  35,  44,  41,  42,  43 );
	$reslist['tech']     = array ( 106, 108, 109, 110, 111, 113, 114, 115, 117, 118, 120, 121, 122, 123, 124, 194, 195, 196, 197, 198, 199, 200 );
	$reslist['fleet']    = array ( 202, 203, 204, 205, 206, 207, 208, 209, 210, 211, 212, 213, 214, 215, 216, 217, 218 );
	$reslist['defense']  = array ( 401, 402, 403, 404, 405, 406, 407, 408, 409, 502, 503 );
	$reslist['officier'] = array ( 607, 608, 609, 610, 611, 612, 613, 614, 615, 616, 617, 618, 619);
	$reslist['titles']   = array ( 601, 602, 603, 604, 605, 606);
	$reslist['prod']     = array (   1,   2,   3,   4,   5,  12, 212 );
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>