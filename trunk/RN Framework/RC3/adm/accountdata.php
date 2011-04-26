<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By Neko from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################


define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);


if ($user['authlevel'] < 2) die(message($lang['not_enough_permissions']));

$parse	= 	$lang;
$id_u	=	$_POST['id_u'];	//$_POST para sacar el ID del Usuario
$modo	=	$_POST['modo'];

$info_u		=	doquery("SELECT * FROM {{table}} WHERE `id` = '".$id_u."'", "users");	//Consulta para sacar datos de la tabla de usuarios
$info_p		=	doquery("SELECT * FROM {{table}} WHERE `id_owner` = '".$id_u."'", "planets");	//Consulta para sacar datos de la tabla de planetas


	if ($modo == "datos")
	{
		if ($id_u <= 0)
		{
			$parse['error']	=	$lang['ac_user_id_required'];
		}
		elseif ($id_u > 0)
		{
			//Despliegue de todos los datos de la cuenta
			while ($b = mysql_fetch_array($info_u))
			{
				$nivel						=	$b['authlevel'];
				$vacas						=	$b['urlaubs_modus'];
				$alianza					=	$b['ally_name'];
				$id_ali						=	$b['ally_id'];
				$suspen						=	$b['bana'];
				$error						=	$b['id'];
				$parse['id']				=	$b['id'];
				$parse['nombre']			=	$b['username'];
				$parse['contra']			=	$b['password'];
				$parse['email_1']			=	$b['email'];
				$parse['email_2']			=	$b['email_2'];
				$parse['ip']				=	$b['ip_at_reg'];
				$parse['ip2']				=	$b['user_lastip'];
				$parse['id_p']				=	$b['id_planet'];
				$parse['g']					=	$b['galaxy'];
				$parse['s']					=	$b['system'];
				$parse['p']					=	$b['planet'];
				$parse['info']				=	$b['user_agent'];

				//Materia Oscura
				$parse['mo']	.=	round($b['darkmatter']);


				//Investigaciones y Oficiales
				$informacion_u	.=	"<tr><th>".$lang['ad_spy_tech'].": ".$b['spy_tech']."</th>";
				$informacion_u	.=	"<th>".$lang['ac_geologist'].": ".$b['rpg_geologue']."</th></tr>";

				$informacion_u	.=	"<tr><th>".$lang['ad_computer_tech'].": ".$b['computer_tech']."</th>";
				$informacion_u	.=	"<th>".$lang['ac_admiral'].": ".$b['rpg_amiral']."</th></tr>";

				$informacion_u	.=	"<tr><th>".$lang['ad_military_tech'].": ".$b['military_tech']."</th>";
				$informacion_u	.=	"<th>".$lang['ac_engineer'].": ".$b['rpg_ingenieur']."</th></tr>";

				$informacion_u	.=	"<tr><th>".$lang['ad_defence_tech'].": ".$b['defence_tech']."</th>";
				$informacion_u	.=	"<th>".$lang['ac_technocrat'].": ".$b['rpg_technocrate']."</th></tr>";

				$informacion_u	.=	"<tr><th>".$lang['ad_shield_tech'].": ".$b['shield_tech']."</th>";
				$informacion_u	.=	"<th>".$lang['ac_spy'].": ".$b['rpg_espion']."</th></tr>";

				$informacion_u	.=	"<tr><th>".$lang['ad_energy_tech'].": ".$b['energy_tech']."</th>";
				$informacion_u	.=	"<th>".$lang['ac_constructor'].": ".$b['rpg_constructeur']."</th></tr>";

				$informacion_u	.=	"<tr><th>".$lang['ad_hyperspace_tech'].": ".$b['hyperspace_tech']."</th>";
				$informacion_u	.=	"<th>".$lang['ac_scientific'].": ".$b['rpg_scientifique']."</th></tr>";

				$informacion_u	.=	"<tr><th>".$lang['ad_combustion_tech'].": ".$b['combustion_tech']."</th>";
				$informacion_u	.=	"<th>".$lang['ac_commander'].": ".$b['rpg_commandant']."</th></tr>";

				$informacion_u	.=	"<tr><th>".$lang['ad_impulse_motor_tech'].": ".$b['impulse_motor_tech']."</th>";
				$informacion_u	.=	"<th>".$lang['ac_storer'].": ".$b['rpg_stockeur']."</th></tr>";

				$informacion_u	.=	"<tr><th>".$lang['ad_hyperspace_motor_tech'].": ".$b['hyperspace_motor_tech']."</th>";
				$informacion_u	.=	"<th>".$lang['ac_defender'].": ".$b['rpg_defenseur']."</th></tr>";

				$informacion_u	.=	"<tr><th>".$lang['ad_laser_tech'].": ".$b['laser_tech']."</th>";
				$informacion_u	.=	"<th>".$lang['ac_destroyer'].": ".$b['rpg_destructeur']."</th></tr>";

				$informacion_u	.=	"<tr><th>".$lang['ad_ionic_tech'].": ".$b['ionic_tech']."</th>";
				$informacion_u	.=	"<th>".$lang['ac_general'].": ".$b['rpg_general']."</th></tr>";

				$informacion_u	.=	"<tr><th>".$lang['ad_buster_tech'].": ".$b['buster_tech']."</th>";
				$informacion_u	.=	"<th>".$lang['ac_protector'].": ".$b['rpg_bunker']."</th></tr>";

				$informacion_u	.=	"<tr><th>".$lang['ad_intergalactic_tech'].": ".$b['intergalactic_tech']."</th>";
				$informacion_u	.=	"<th>".$lang['ac_conqueror'].": ".$b['rpg_raideur']."</th></tr>";

				$informacion_u	.=	"<tr><th>".$lang['ad_expedition_tech'].": ".$b['expedition_tech']."</th>";
				$informacion_u	.=	"<th>".$lang['ac_emperor'].": ".$b['rpg_empereur']."</th></tr>";

				$informacion_u	.=	"<tr><th>".$lang['ad_graviton_tech'].": ".$b['graviton_tech']."</th></tr>";

				$parse['investi']	.=	$informacion_u;
			}



			if ($vacas == 0)
			{
				$parse['vacas']	=	$lang['ac_no'];
			}
			elseif ($vacas == 1)
			{
				$parse['vacas']	=	$lang['ac_yes'];
			}


			if ($suspen == NULL)
			{
				$parse['suspen']	=	$lang['ac_no'];
			}
			elseif ($suspen == 1)
			{
				$parse['suspen']	=	$lang['ac_yes'];
			}


			if ($alianza == NULL && $id_ali == 0)
			{
				$parse['alianza']	=	$lang['ac_no_ally'];
			}
			elseif ($alianza != NULL && $id_ali != 0)
			{
				$parse['alianza']	=	$alianza;
				$parse['id_ali']	=	" (ID: ".$id_ali.")";
			}


			if ($nivel == 3)
			{
				$parse['nivel']	=	$lang['user_level'][3];
			}
			elseif ($nivel == 2)
			{
				$parse['nivel']	=	$lang['user_level'][2];
			}
			elseif ($nivel == 1)
			{
				$parse['nivel']	=	$lang['user_level'][1];
			}
			elseif ($nivel == 0)
			{
				$parse['nivel']	=	$lang['user_level'][0];
			}


			//Despliegue de todos los datos de los planetas
			while ($a = mysql_fetch_array($info_p))
			{
				if ($a["destruyed"] == 0) {
				//Recursos
				$parse['metal']		.=	"<th>".pretty_number($a['metal'])."</th>";
				$parse['cristal']	.=	"<th>".pretty_number($a['crystal'])."</th>";
				$parse['deute']		.=	"<th>".pretty_number($a['deuterium'])."</th>";
				$parse['energia']	.=	"<th>".pretty_number($a['energy_max'])."</th>";

				//Edificios
				$parse['mina_metal']	.=	"<th>".pretty_number($a['metal_mine'])."</th>";
				$parse['mina_cristal']	.=	"<th>".pretty_number($a['crystal_mine'])."</th>";
				$parse['mina_deu']		.=	"<th>".pretty_number($a['deuterium_sintetizer'])."</th>";
				$parse['planta_s']		.=	"<th>".pretty_number($a['solar_plant'])."</th>";
				$parse['planta_f']		.=	"<th>".pretty_number($a['fusion_plant'])."</th>";
				$parse['fabrica']		.=	"<th>".pretty_number($a['robot_factory'])."</th>";
				$parse['nanos']			.=	"<th>".pretty_number($a['nano_factory'])."</th>";
				$parse['hangar']		.=	"<th>".pretty_number($a['hangar'])."</th>";
				$parse['almacen_m']		.=	"<th>".pretty_number($a['metal_store'])."</th>";
				$parse['almacen_c']		.=	"<th>".pretty_number($a['crystal_store'])."</th>";
				$parse['almacen_d']		.=	"<th>".pretty_number($a['deuterium_store'])."</th>";
				$parse['labo']			.=	"<th>".pretty_number($a['laboratory'])."</th>";
				$parse['terra']			.=	"<th>".pretty_number($a['terraformer'])."</th>";
				$parse['ali']			.=	"<th>".pretty_number($a['ally_deposit'])."</th>";
				$parse['silo']			.=	"<th>".pretty_number($a['silo'])."</th>";

				if ($a['planet_type'] == 3){
				//Edificios de la luna
				$parse['base']		.=	"<th>".pretty_number($a['mondbasis'])."</th>";
				$parse['phalanx']	.=	"<th>".pretty_number($a['phalanx'])."</th>";
				$parse['salto']		.=	"<th>".pretty_number($a['sprungtor'])."</th>";
				}

				//Naves
				$parse['peque']		.=	"<th>".pretty_number($a['small_ship_cargo'])."</th>";
				$parse['grande']	.=	"<th>".pretty_number($a['big_ship_cargo'])."</th>";
				$parse['ligero']	.=	"<th>".pretty_number($a['light_hunter'])."</th>";
				$parse['pesado']	.=	"<th>".pretty_number($a['heavy_hunter'])."</th>";
				$parse['cru']		.=	"<th>".pretty_number($a['crusher'])."</th>";
				$parse['nave']		.=	"<th>".pretty_number($a['battle_ship'])."</th>";
				$parse['colo']		.=	"<th>".pretty_number($a['colonizer'])."</th>";
				$parse['reci']		.=	"<th>".pretty_number($a['recycler'])."</th>";
				$parse['sondas']	.=	"<th>".pretty_number($a['spy_sonde'])."</th>";
				$parse['bomba']		.=	"<th>".pretty_number($a['bomber_ship'])."</th>";
				$parse['satelite']	.=	"<th>".pretty_number($a['solar_satelit'])."</th>";
				$parse['destru']	.=	"<th>".pretty_number($a['destructor'])."</th>";
				$parse['edlm']		.=	"<th>".pretty_number($a['dearth_star'])."</th>";
				$parse['aco']		.=	"<th>".pretty_number($a['battleship'])."</th>";
				$parse['supernova']	.=	"<th>".pretty_number($a['supernova'])."</th>";

				//Defensas
				$parse['lanza']		.=	"<th>".pretty_number($a['misil_launcher'])."</th>";
				$parse['laser_p']	.=	"<th>".pretty_number($a['small_laser'])."</th>";
				$parse['laser_g']	.=	"<th>".pretty_number($a['big_laser'])."</th>";
				$parse['gauss']		.=	"<th>".pretty_number($a['gauss_canyon'])."</th>";
				$parse['ionico']	.=	"<th>".pretty_number($a['ionic_canyon'])."</th>";
				$parse['plasma']	.=	"<th>".pretty_number($a['buster_canyon'])."</th>";
				$parse['c_peque']	.=	"<th>".pretty_number($a['small_protection_shield'])."</th>";
				$parse['c_grande']	.=	"<th>".pretty_number($a['big_protection_shield'])."</th>";
				$parse['protector']	.=	"<th>".pretty_number($a['planet_protector'])."</th>";
				$parse['misil_i']	.=	"<th>".pretty_number($a['interceptor_misil'])."</th>";
				$parse['misil_in']	.=	"<th>".pretty_number($a['interplanetary_misil'])."</th>";
				}


				if ($a["destruyed"] == 0)
				{
					if ($a['planet_type'] == 3)
					{
						$parse['planetas'] .= "<tr><th>".$a['id']."</th><th>".$a['name']."&nbsp;(".$lang['ac_moon'].")</th>";
						$parse['planetas'] .= "<th>[".$a['galaxy'].":".$a['system'].":".$a['planet']."]</th>";
						$parse['planetas'] .= "<th>".pretty_number($a['diameter'])."</th>";
						$parse['planetas'] .= "<th>".pretty_number($a['field_current'])."/".pretty_number($a['field_max'])."</th>";
						$parse['planetas'] .= "<th>".$a['temp_min']."/".$a['temp_max']."</th></tr>";
						$parse['lunas']    .= "<th><center><font color=Navy>".$a['name']."&nbsp;(".$lang['ac_moon'].")<br>[".$a['galaxy'].":".$a['system'].":".$a['planet']."]</th>";
						$parse['planetas2'] .= "<th><center><font color=Navy>".$a['name']."&nbsp;(".$lang['ac_moon'].")
											<br>[".$a['galaxy'].":".$a['system'].":".$a['planet']."]</font><center></th>";
					}
					elseif ($a['planet_type'] == 1)
					{
						$parse['planetas'] .= "<tr><th>".$a['id']."</th><th>".$a['name']."</th>";
						$parse['planetas'] .= "<th>[".$a['galaxy'].":".$a['system'].":".$a['planet']."]</th>";
						$parse['planetas'] .= "<th>".pretty_number($a['diameter'])."</th>";
						$parse['planetas'] .= "<th>".pretty_number($a['field_current'])."/".pretty_number($a['field_max'])."</th>";
						$parse['planetas'] .= "<th>".$a['temp_min']."/".$a['temp_max']."</th></tr>";
						$parse['planetas2'] .= "<th><center><font color=Navy>".$a['name']."
												<br>[".$a['galaxy'].":".$a['system'].":".$a['planet']."]</font><center></th>";
					}
				}
				if ($a["destruyed"] > 0)
				{
					$parse['planetas_d'] .= "<tr><th>".$a['id']."</th><th>".$a['name']."</th>";
					$parse['planetas_d'] .= "<th>[".$a['galaxy'].":".$a['system'].":".$a['planet']."]</th></tr>";
				}
			}
			display (parsetemplate(gettemplate("adm/accountdata_result"), $parse), false, '', true, false);
		}
	}




display (parsetemplate(gettemplate("adm/accountdata_body"), $parse), false, '', true, false);
?>