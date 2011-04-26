<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from xgproyect.net      	 #
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
define('INSTALL' , true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.'.$phpEx);
include_once('databaseinfos.'.$phpEx);

$Mode     = $_GET['mode'];
$Page     = $_GET['page'];
$phpself  = $_SERVER['PHP_SELF'];
$nextpage = $Page + 1;

if(version_compare(PHP_VERSION, "5.1.0", "<"))
	die("Error! Tu servidor debe tener al menos php 5.1.0");

if (empty($Mode)) { $Mode = 'intro'; }
if (empty($Page)) { $Page = 1;       }

switch ($Mode) {
	case'license':
		$frame  = parsetemplate(gettemplate('install/ins_license'), false);
		break;
	case 'intro':
		$frame  = parsetemplate(gettemplate('install/ins_intro'), false);
		break;
	case 'ins':
		if ($Page == 1) {
			if ($_GET['error'] == 1) {
				message ("La conexi&oacute;n a la base de datos a fallado","?mode=ins&page=1", 3, false, false);
			}
			elseif ($_GET['error'] == 2) {
				message ("El fichero config.php no puede ser sustituido, no tenia acceso chmod 777","?mode=ins&page=1", 3, false, false);
			}

			$frame  = parsetemplate ( gettemplate ('install/ins_form'), false);
		}
		elseif ($Page == 2) {
			$host   = $_POST['host'];
			$user   = $_POST['user'];
			$pass   = $_POST['passwort'];
			$prefix = $_POST['prefix'];
			$db     = $_POST['db'];

			$connection = @mysql_connect($host, $user, $pass);
			if (!$connection) {
				header("Location: ?mode=ins&page=1&error=1");
				exit();
			}

			$dbselect = @mysql_select_db($db);
			if (!$dbselect) {
				header("Location: ?mode=ins&page=1&error=1");
				exit();
			}

			$numcookie = mt_rand(1000, 1234567890);
			$dz = fopen("../config.php", "w");
			if (!$dz)
			{
				header("Location: ?mode=ins&page=1&error=2");
				exit();
			}

			$parse[first]	= "Conexión establecida con éxito...";

			fwrite($dz, "<?php\n");
			fwrite($dz, "if(!defined(\"INSIDE\")){ header(\"location:".$xgp_root."\"); }\n");
			fwrite($dz, "\$dbsettings = Array(\n");
			fwrite($dz, "\"server\"     => \"".$host."\", // MySQL server name.\n");
			fwrite($dz, "\"user\"       => \"".$user."\", // MySQL username.\n");
			fwrite($dz, "\"pass\"       => \"".$pass."\", // MySQL password.\n");
			fwrite($dz, "\"name\"       => \"".$db."\", // MySQL database name.\n");
			fwrite($dz, "\"prefix\"     => \"".$prefix."\", // Tables prefix.\n");
			fwrite($dz, "\"secretword\" => \"XGProyect".$numcookie."\"); // Cookies.\n");
			fwrite($dz, "?>");
			fclose($dz);

			$parse[second]	= "Archivo config.php creado con éxito...";

			doquery ($QryTableAks        , 'aks'    	);
			doquery ($QryTableAlliance   , 'alliance'   );
			doquery ($QryTableBanned     , 'banned'     );
			doquery ($QryTableBuddy      , 'buddy'      );
			doquery ($QryTableConfig     , 'config'     );
			doquery ($QryInsertConfig    , 'config'     );
			doquery ($QryTableErrors     , 'errors'     );
			doquery ($QryTableFleets     , 'fleets'     );
			doquery ($QryTableGalaxy     , 'galaxy'     );
			doquery ($QryTableMessages   , 'messages'   );
			doquery ($QryTableNotes      , 'notes'      );
			doquery ($QryTablePlanets    , 'planets'    );
			doquery ($QryTablePlugins    , 'plugins'    );
			doquery ($QryTableRw         , 'rw'         );
			doquery ($QryTableStatPoints , 'statpoints'	);
			doquery ($QryTableUsers      , 'users'  	);

			$parse[third]	= "Tablas creadas con éxito...";

			$frame  = parsetemplate(gettemplate('install/ins_form_done'), $parse);
		}
		elseif ($Page == 3)
		{
			if ($_GET['error'] == 3)
				message ("¡Debes completar todos los campos!","?mode=ins&page=3", 2, false, false);

			$frame  = parsetemplate(gettemplate('install/ins_acc'), false);
		}
		elseif ($Page == 4)
		{
			$adm_user   = $_POST['adm_user'];
			$adm_pass   = $_POST['adm_pass'];
			$adm_email  = $_POST['adm_email'];
			$md5pass    = md5($adm_pass);

			if (!$_POST['adm_user'])
			{
				header("Location: ?mode=ins&page=3&error=3");
				exit();
			}
			if (!$_POST['adm_pass'])
			{
				header("Location: ?mode=ins&page=3&error=3");
				exit();
			}
			if (!$_POST['adm_email'])
			{
				header("Location: ?mode=ins&page=3&error=3");
				exit();
			}

			$QryInsertAdm  = "INSERT INTO {{table}} SET ";
			$QryInsertAdm .= "`id`                = '1', ";
			$QryInsertAdm .= "`username`          = '". $adm_user ."', ";
			$QryInsertAdm .= "`email`             = '". $adm_email ."', ";
			$QryInsertAdm .= "`email_2`           = '". $adm_email ."', ";
			$QryInsertAdm .= "`ip_at_reg` 		  = '". $_SERVER["REMOTE_ADDR"] . "', ";
			$QryInsertAdm .= "`user_agent`        = '', ";
			$QryInsertAdm .= "`authlevel`         = '3', ";
			$QryInsertAdm .= "`id_planet`         = '1', ";
			$QryInsertAdm .= "`galaxy`            = '1', ";
			$QryInsertAdm .= "`system`            = '1', ";
			$QryInsertAdm .= "`planet`            = '1', ";
			$QryInsertAdm .= "`current_planet`    = '1', ";
			$QryInsertAdm .= "`register_time`     = '". time() ."', ";
			$QryInsertAdm .= "`password`          = '". $md5pass ."';";
			doquery($QryInsertAdm, 'users');

			$QryAddAdmPlt  = "INSERT INTO {{table}} SET ";
			$QryAddAdmPlt .= "`id_owner`          = '1', ";
			$QryAddAdmPlt .= "`galaxy`            = '1', ";
			$QryAddAdmPlt .= "`system`            = '1', ";
			$QryAddAdmPlt .= "`planet`            = '1', ";
			$QryAddAdmPlt .= "`last_update`       = '". time() ."', ";
			$QryAddAdmPlt .= "`planet_type`       = '1', ";
			$QryAddAdmPlt .= "`image`             = 'normaltempplanet02', ";
			$QryAddAdmPlt .= "`diameter`          = '12750', ";
			$QryAddAdmPlt .= "`field_max`         = '163', ";
			$QryAddAdmPlt .= "`temp_min`          = '47', ";
			$QryAddAdmPlt .= "`temp_max`          = '87', ";
			$QryAddAdmPlt .= "`metal`             = '500', ";
			$QryAddAdmPlt .= "`metal_perhour`     = '0', ";
			$QryAddAdmPlt .= "`metal_max`         = '1000000', ";
			$QryAddAdmPlt .= "`crystal`           = '500', ";
			$QryAddAdmPlt .= "`crystal_perhour`   = '0', ";
			$QryAddAdmPlt .= "`crystal_max`       = '1000000', ";
			$QryAddAdmPlt .= "`deuterium`         = '500', ";
			$QryAddAdmPlt .= "`deuterium_perhour` = '0', ";
			$QryAddAdmPlt .= "`deuterium_max`     = '1000000';";
			doquery($QryAddAdmPlt, 'planets');

			$QryAddAdmGlx  = "INSERT INTO {{table}} SET ";
			$QryAddAdmGlx .= "`galaxy`            = '1', ";
			$QryAddAdmGlx .= "`system`            = '1', ";
			$QryAddAdmGlx .= "`planet`            = '1', ";
			$QryAddAdmGlx .= "`id_planet`         = '1'; ";
			doquery($QryAddAdmGlx, 'galaxy');

			doquery("UPDATE {{table}} SET `config_value` = '1' WHERE `config_name` = 'LastSettedGalaxyPos';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '1' WHERE `config_name` = 'LastSettedSystemPos';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = '1' WHERE `config_name` = 'LastSettedPlanetPos';", 'config');
			doquery("UPDATE {{table}} SET `config_value` = `config_value` + '1' WHERE `config_name` = 'users_amount' LIMIT 1;", 'config');

			$frame  = parsetemplate(gettemplate('install/ins_acc_done'), $parse);
		}
		break;
	case'upgrade':
		if ($_POST)
		{
			$conexion = mysql_connect($_POST[servidor], $_POST[usuario], $_POST[clave])
			or die ('<font color=red><strong>Problemas en la conexión con el servidor, es probable que el <u>nombre del servidor, usuario o clave sean incorrectas o que mysql no esta funcionando.</u></strong></font>');
			@mysql_select_db($_POST[base],$conexion)
			or die ('<font color=red><strong>Problemas en la conexión con la base de datos. Este error puede deberse a que <u>la base de datos no existe o escribiste mal el nombre de la misma.</u></strong></font>');

			if ($_POST[continuar] && (empty($_POST[modo]) or empty($_POST[servidor]) or empty($_POST[usuario]) or empty($_POST[clave]) or empty($_POST[base]) or empty($_POST[prefix])))
			{
				message("Error!, debes rellenar todos los campos<br><a href=\"./index.php\">Volver</a>","", "", false, false);
			}
			else
			{
				if(filesize('../config.php') == 0)
				{
					die(message("Error!, tu archivo config.php se encuentra vació o no configurado. En caso de no ser así verifica que su chmod sea de 777","", "", false, false));
				}
				else
				{
					include_once("../config.php");

					if($_POST[prefix] != $dbsettings["prefix"])
					{
						die(message("Error!, el prefix seleccionado (<font color=\"red\"><strong>".$_POST[prefix]."</strong></font>) no coincide con el de la base de datos.","", "", false, false));
					}
				}

				// ALL QUERYS NEEDED
				$Qry1 = "DELETE FROM `$_POST[prefix]config` WHERE `config_name` = 'VERSION'";
				$Qry2 = "INSERT INTO `$_POST[prefix]config` (`config_name`, `config_value`) VALUES ('VERSION', '2.9.9');";
				$Qry3 = "INSERT INTO `$_POST[prefix]config` (`config_name`, `config_value`) VALUES ('moderation', '1,0,0,1;1,1,0,1;');";
				$Qry4 = " ALTER TABLE `$_POST[prefix]banned` CHANGE `who` `who` VARCHAR( 64 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
							CHANGE `who2` `who2` VARCHAR( 64 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
							CHANGE `author` `author` VARCHAR( 64 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ,
							CHANGE `email` `email` VARCHAR( 64 ) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL ";
				$Qry5 = "UPDATE `$_POST[prefix]config` SET `config_value` = '1,0,0,1,1;1,1,0,1,1;1;' WHERE `xgp_config`.`config_name` = 'moderation';";
				$Qry6 = "ALTER TABLE `$_POST[prefix]planets` CHANGE `small_protection_shield` `small_protection_shield` TINYINT( 1 ) NOT NULL DEFAULT '0', CHANGE `planet_protector` `planet_protector` TINYINT( 1 ) NOT NULL DEFAULT '0', CHANGE `big_protection_shield` `big_protection_shield` TINYINT( 1 ) NOT NULL DEFAULT '0'";
				$Qry7 = "UPDATE `xgp_rw` SET `xgp_rw`.`owners` = CONCAT(id_owner1,\",\",id_owner2)";
				$Qry8 = "ALTER TABLE `xgp_rw`
  							DROP `id_owner1`,
  							DROP `id_owner2`;";

				switch($_POST[modo])
				{
					case( ( $_POST[modo] == '2.9.1' ) or ( $_POST[modo] == '2.9.2' ) or ( $_POST[modo] == '2.9.3' ) ):
						$QrysArray	= array($Qry1, $Qry2, $Qry3, $Qry4, $Qry5, $Qry6, $Qry7, $Qry8);
					break;
					case'2.9.4':
						$QrysArray	= array($Qry1, $Qry2, $Qry6, $Qry7, $Qry8);
					break;
					case( ( $_POST[modo] == '2.9.5' ) or ( $_POST[modo] == '2.9.6' ) or ( $_POST[modo] == '2.9.7' ) or ( $_POST[modo] == '2.9.8' ) or ( $_POST[modo] == '2.9.9' ) ):
						$QrysArray	= array($Qry1, $Qry2, $Qry7, $Qry8);
					break;
				}

				foreach ( $QrysArray as $DoQuery)
				{
					mysql_query($DoQuery);
				}

				message("XG Proyect finalizó la actualización con éxito, para finalizar borra el directorio install y luego haz <a href=\"./../\">click aqui</a>", "", "", false, false);
			}
		}
		else
			$frame  = parsetemplate(gettemplate('install/ins_update'), false);
		break;
	default:
}
$parse['ins_state']    = $Page;
$parse['ins_page']     = $frame;
$parse['dis_ins_btn']  = "?mode=$Mode&page=$nextpage";
display (parsetemplate (gettemplate('install/ins_body'), $parse), false, '', true, false);
?>