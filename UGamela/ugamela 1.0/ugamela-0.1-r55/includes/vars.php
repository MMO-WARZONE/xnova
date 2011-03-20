<?php

if ( !defined('INSIDE') )
{
	die("Hacking attempt");
}

// Lista de recursos
{$resource = array(

1 => "metal_mine",
2 => "crystal_mine",
3 => "deuterium_sintetizer",
4 => "solar_plant",
12 => "fusion_plant",
14 => "robot_factory",
15 => "nano_factory",
21 => "hangar",
22 => "metal_store",
23 => "crystal_store",
24 => "deuterium_store",
31 => "laboratory",
33 => "terraformer",
34 => "ally_deposit",
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
199 => "graviton_tech",

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

401 => "misil_launcher",
402 => "small_laser",
403 => "big_laser",
404 => "gauss_canyon",
405 => "ionic_canyon",
406 => "buster_canyon",
407 => "small_protection_shield",
408 => "big_protection_shield",
502 => "interceptor_misil",
503 => "interplanetary_misil",
41 => "lunar_base",
42 => "sensor_phalax",
43 => "quantic_jump"
);}

// Requerimientos
{$requeriments = array(
//Edificios
12 => array(3=>5,113=>3),
15 => array(14=>10,108=>10),
21 => array(14=>2),
33 => array(15=>1,113=>12),
//Tecnologias
106 => array(31=>3),
108 => array(31=>1),
109 => array(31=>4),
110 => array(113=>3,31=>6),
111 => array(31=>2),
113 => array(31=>1),
114 => array(113=>5,110=>5,31=>7),
115 => array(113=>1,31=>1),
117 => array(113=>1,31=>2),
118 => array(114=>3,31=>7),
120 => array(31=>1,113=>2),
121 => array(31=>4,120=>5,113=>4),
122 => array(31=>5,113=>8,120=>10,121=>5),
123 => array(31=>10,108=>8,114=>8),
199 => array(31=>12),
//Naves espaciales
202 => array(21=>2,115=>2),
203 => array(21=>4,115=>6),
204 => array(21=>1,115=>1),
205 => array(21=>3,111=>2,117=>2),
206 => array(21=>5,117=>4,121=>2),
207 => array(21=>7,118=>4),
208 => array(21=>4,117=>3),
209 => array(21=>4,115=>6,110=>2),
210 => array(21=>3,115=>3,106=>2),
211 => array(117=>6,21=>8,122=>5),
212 => array(21=>1),
213 => array(21=>9,118=>6,114=>5),
214 => array(21=>12,118=>7,114=>6,199=>1),
215 => array(114=>5,120=>12,118=>5,21=>8),
//Sistemas de defensa
401 => array(21=>1),
402 => array(113=>1,21=>2,120=>3),
403 => array(113=>3,21=>4,120=>6),
404 => array(21=>6,113=>6,109=>3,110=>1),
405 => array(21=>4,121=>4),
406 => array(21=>8,122=>7),
407 => array(110=>2,21=>1),
408 => array(110=>6,21=>6),
502 => array(44=>2),
503 => array(44=>4),
//Construcciones especiales
42 => array(41=>1),
43 => array(41=>1,114=>7)
);}

{$pricelist = array(

1 => array('metal'=>40,'crystal'=>10,'deuterium'=>0,'energy'=>0,'factor'=>3/2),
2 => array('metal'=>30,'crystal'=>15,'deuterium'=>0,'energy'=>0,'factor'=>1.6,),
3 => array('metal'=>150,'crystal'=>50,'deuterium'=>0,'energy'=>0,'factor'=>3/2),
4 => array('metal'=>50,'crystal'=>20,'deuterium'=>0,'energy'=>0,'factor'=>3/2),
12 => array('metal'=>500,'crystal'=>200,'deuterium'=>100,'energy'=>0,'factor'=>1.8),
14 => array('metal'=>200,'crystal'=>60,'deuterium'=>100,'energy'=>0,'factor'=>2),
15 => array('metal'=>500000,'crystal'=>250000,'deuterium'=>50000,'energy'=>0),
21 => array('metal'=>200,'crystal'=>100,'deuterium'=>50,'energy'=>0,'factor'=>2),
22 => array('metal'=>1000,'crystal'=>0,'deuterium'=>0,'energy'=>0,'factor'=>2),
23 => array('metal'=>1000,'crystal'=>500,'deuterium'=>0,'energy'=>0,'factor'=>2),
24 => array('metal'=>1000,'crystal'=>1000,'deuterium'=>0,'energy'=>0,'factor'=>2),
31 => array('metal'=>100,'crystal'=>200,'deuterium'=>100,'energy'=>0,'factor'=>2),
33 => array('metal'=>0,'crystal'=>25000,'deuterium'=>5000,'energy'=>500,'factor'=>2),
34 => array('metal'=>10000,'crystal'=>20000,'deuterium'=>0,'energy'=>0,'factor'=>2),
44 => array('metal'=>10000,'crystal'=>10000,'deuterium'=>500,'energy'=>0,'factor'=>2),
//Tecnologias
106 => array('metal'=>200,'crystal'=>1000,'deuterium'=>200,'energy'=>0,'factor'=>2),
108 => array('metal'=>0,'crystal'=>400,'deuterium'=>600,'energy'=>0,'factor'=>2),
109 => array('metal'=>800,'crystal'=>200,'deuterium'=>0,'energy'=>0,'factor'=>2),
110 => array('metal'=>200,'crystal'=>600,'deuterium'=>0,'energy'=>0,'factor'=>2),
111 => array('metal'=>1000,'crystal'=>0,'deuterium'=>0,'energy'=>0,'factor'=>2),
113 => array('metal'=>0,'crystal'=>800,'deuterium'=>400,'energy'=>0,'factor'=>2),
114 => array('metal'=>0,'crystal'=>4000,'deuterium'=>2000,'energy'=>0,'factor'=>2),
115 => array('metal'=>400,'crystal'=>0,'deuterium'=>600,'energy'=>0,'factor'=>2),
117 => array('metal'=>2000,'crystal'=>4000,'deuterium'=>6000,'energy'=>0,'factor'=>2),
118 => array('metal'=>10000,'crystal'=>20000,'deuterium'=>6000,'energy'=>0,'factor'=>2),
120 => array('metal'=>200,'crystal'=>100,'deuterium'=>0,'energy'=>0,'factor'=>2),
121 => array('metal'=>1000,'crystal'=>300,'deuterium'=>100,'energy'=>0,'factor'=>2),
122 => array('metal'=>2000,'crystal'=>4000,'deuterium'=>1000,'energy'=>0,'factor'=>2),
123 => array('metal'=>240000,'crystal'=>400000,'deuterium'=>160000,'energy'=>0,'factor'=>2),
199 => array('metal'=>0,'crystal'=>0,'deuterium'=>0,'energy'=>300000,'factor'=>3),
//Naves espaciales
202 => array('metal'=>2000,'crystal'=>2000,'deuterium'=>0,'energy'=>0,'factor'=>1,'consumption'=>20,'speed'=>28000,'capacity'=>5000),
203 => array('metal'=>6000,'crystal'=>6000,'deuterium'=>0,'energy'=>0,'factor'=>1,'consumption'=>50,'speed'=>17250,'capacity'=>25000),
204 => array('metal'=>3000,'crystal'=>1000,'deuterium'=>0,'energy'=>0,'factor'=>1,'consumption'=>20,'speed'=>28750,'capacity'=>50),
205 => array('metal'=>6000,'crystal'=>4000,'deuterium'=>0,'energy'=>0,'factor'=>1,'consumption'=>75,'speed'=>28000,'capacity'=>100),
206 => array('metal'=>20000,'crystal'=>7000,'deuterium'=>2000,'energy'=>0,'factor'=>1,'consumption'=>300,'speed'=>42000,'capacity'=>800),
207 => array('metal'=>40000,'crystal'=>20000,'deuterium'=>0,'energy'=>0,'factor'=>1,'consumption'=>500,'speed'=>31000,'capacity'=>1500),
208 => array('metal'=>10000,'crystal'=>20000,'deuterium'=>10000,'energy'=>0,'factor'=>1),
209 => array('metal'=>10000,'crystal'=>6000,'deuterium'=>2000,'energy'=>0,'factor'=>1,'consumption'=>300,'speed'=>4600,'capacity'=>20000),
210 => array('metal'=>0,'crystal'=>1000,'deuterium'=>0,'energy'=>0,'factor'=>1,'consumption'=>1,'speed'=>230000000,'capacity'=>5),
211 => array('metal'=>50000,'crystal'=>25000,'deuterium'=>15000,'energy'=>0,'factor'=>1,'consumption'=>1000,'speed'=>11200,'capacity'=>500),
212 => array('metal'=>0,'crystal'=>2000,'deuterium'=>500,'energy'=>0,'factor'=>1),
213 => array('metal'=>60000,'crystal'=>50000,'deuterium'=>15000,'energy'=>0,'factor'=>1,'consumption'=>1000,'speed'=>15500,'capacity'=>2000),
214 => array('metal'=>5000000,'crystal'=>4000000,'deuterium'=>1000000,'energy'=>0,'factor'=>1),
215 => array('metal'=>5000000,'crystal'=>4000000,'deuterium'=>1000000,'energy'=>0,'factor'=>1),
//Sistemas de defensa
401 => array('metal'=>2000,'crystal'=>0,'deuterium'=>0,'energy'=>0,'factor'=>1),
402 => array('metal'=>1500,'crystal'=>500,'deuterium'=>0,'energy'=>0,'factor'=>1),
403 => array('metal'=>6000,'crystal'=>2000,'deuterium'=>0,'energy'=>0,'factor'=>1),
404 => array('metal'=>20000,'crystal'=>15000,'deuterium'=>2000,'energy'=>0,'factor'=>1),
405 => array('metal'=>2000,'crystal'=>6000,'deuterium'=>0,'energy'=>0,'factor'=>1),
406 => array('metal'=>50000,'crystal'=>50000,'deuterium'=>30000,'energy'=>0,'factor'=>1),
407 => array('metal'=>10000,'crystal'=>10000,'deuterium'=>0,'energy'=>0,'factor'=>1),
408 => array('metal'=>50000,'crystal'=>50000,'deuterium'=>0,'energy'=>0,'factor'=>1),
502 => array('metal'=>8000,'crystal'=>2000,'deuterium'=>0,'energy'=>0,'factor'=>1),
503 => array('metal'=>12500,'crystal'=>2500,'deuterium'=>10000,'energy'=>0,'factor'=>1),
//Construcciones especiales
41 => array('metal'=>10000,'crystal'=>20000,'deuterium'=>10000,'energy'=>0,'factor'=>1),
42 => array('metal'=>10000,'crystal'=>20000,'deuterium'=>10000,'energy'=>0,'factor'=>1),
43 => array('metal'=>1000000,'crystal'=>2000000,'deuterium'=>1000000,'energy'=>0,'factor'=>1)

);}
/*
  Acá se almacenan las formulas correspondientes a cada edificio.
  $production[numero_ id] correspondientemente
*/
{$production = array(
1 => array('metal'=>40,'crystal'=>10,'deuterium'=>0,'energy'=>0,'factor'=>3/2,
	'formular' => array(
		//Produccion = 30 * Nivel * 1,1^Nivel
		'metal'=>'return (30 * $planetrow[$resource[1]] *  pow((1.1),$planetrow[$resource[1]])) *(0.1*$planetrow["{$resource[1]}_porcent"]);',
		'crystal'=>'return "0";',
		'deuterium'=>'return "0";',
		//10 * Nivel * 1,1^Nivel
		'energy'=>'return - (10 * $planetrow[$resource[1]] *  pow((1.1),$planetrow[$resource[1]]))*( 0.1*$planetrow["{$resource[1]}_porcent"]);')
),
2 => array('metal'=>30,'crystal'=>15,'deuterium'=>0,'energy'=>0,'factor'=>1.6,
	'formular' => array(
		'metal'=>'return "0";',
		//Produccion = 20 * Nivel * 1,1^Nivel
		'crystal'=>'return ( 20*$planetrow[$resource[2]]*  pow((1.1),$planetrow[$resource[2]]))* (0.1*$planetrow["{$resource[2]}_porcent"]);',
		'deuterium'=>'return "0";',
		//10 * Nivel * 1,1^Nivel
		'energy'=>'return - (10*$planetrow[$resource[2]]*  pow((1.1),$planetrow[$resource[2]])) * (0.1*$planetrow["{$resource[2]}_porcent"]);')
),
3 => array('metal'=>150,'crystal'=>50,'deuterium'=>0,'energy'=>0,'factor'=>3/2,
	'formular' => array(
		'metal'=>'return "0";',
		'crystal'=>'return "0";',
		//Produccion = 10 * Nivel * 1,1^Nivel * ( − 0,002 * Temp.maxima + 1,28)
		'deuterium'=>'return ((10 *$planetrow[$resource[3]]*  pow((1.1),$planetrow[$resource[3]]))*(-0.002*$planetrow["max_tem"]+1.28))* 0.1 * $planetrow["{$resource[3]}_porcent"];',
		'energy'=>'return -(30 * $planetrow[$resource[3]] * pow((1.1),$planetrow[$resource[3]])) * 0.1*$planetrow["{$resource[3]}_porcent"];')
),
4 => array('metal'=>50,'crystal'=>20,'deuterium'=>0,'energy'=>0,'factor'=>3/2,
	'formular' => array(
		'metal'=>'return "0";',
		'crystal'=>'return "0";',
		'deuterium'=>'return "0";',
		//Produccion = 20 * Nivel * 1,1^Nivel
		'energy'=>'return (20 * $planetrow[$resource[4]] * pow((1.1),$planetrow[$resource[4]]))* (0.1*$planetrow["{$resource[4]}_porcent"]);')
),
12 => array('metal'=>500,'crystal'=>200,'deuterium'=>100,'energy'=>0,'factor'=>1.8,
	'formular' => array(
		'metal'=>'return 0;',
		'crystal'=>'return 0;',
		//10 * Nivel * 1,1Nivel
		'deuterium'=>'return - (10*$planetrow[$resource[12]]*(1.1^$planetrow[$resource[12]]))* (0.1*$planetrow["{$resource[12]}_porcent"]);',//
		//Produccion = 50 * Nivel * 1,1^Nivel
		'energy'=>'return ((50 * $planetrow[$resource[12]]*(1.1^$planetrow[$resource[12]]))*(-0.002*$planetrow["max_temp"]+1.28))* (0.1*$planetrow["{$resource[12]}_porcent"]);')
),
//This work perfectly :)
212 => array('metal'=>0,'crystal'=>2000,'deuterium'=>500,'energy'=>0,'factor'=>0.5,
	'formular' => array(
		'metal'=>'return 0;',
		'crystal'=>'return 0;',
		'deuterium'=>'return 0;',
		'energy'=>'return (($planetrow["temp_max"]/4)+20)*$planetrow[$resource[212]]* 0.1*$planetrow["{$resource[212]}_porcent"];')
),
);}

$reslist['build'] = array(1,2,3,4,12,14,15,21,22,23,24,31,33,34,44);
$reslist['tech'] = array(106,108,109,110,111,113,114,115,117,118,120,121,122,123,199);
$reslist['fleet'] = array(202,203,204,205,206,207,208,209,210,211,212,213,214);
$reslist['defense'] = array(401,402,403,404,405,406,407,408,502,503);

// Created by Perberos. All rights reversed (C) 2006
?>