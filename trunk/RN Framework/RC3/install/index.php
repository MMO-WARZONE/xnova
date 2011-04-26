<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
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

if(version_compare(PHP_VERSION, "5.2.5", "<"))
	die("Error! Diese Version benötigt min. PHP Version 5.2.5");

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
				message ("Keiner Verbindung der Datenbank","?mode=ins&page=1", 3, false, false);
			}
			elseif ($_GET['error'] == 2) {
				message ("config.php wurde nicht auf CHMOD 777 eingestellt!","?mode=ins&page=1", 3, false, false);
			}

			$frame  = parsetemplate ( gettemplate ('install/ins_form'), false);
		}
		elseif ($Page == 2) {
			$host   = $_POST['host'];
			$port   = $_POST['port'];
			$user   = $_POST['user'];
			$pass   = $_POST['passwort'];
			$prefix = $_POST['prefix'];
			$db     = $_POST['db'];

			$connection = @mysql_connect($host.":".$port, $user, $pass);
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

			$parse[first]	= "Verbindung er Datenbank erfolgreich...";

			fwrite($dz, "<?php\n");
			fwrite($dz, "if(!defined(\"INSIDE\")){ header(\"location:".$xgp_root."\"); }\n");
			fwrite($dz, "\$dbsettings = Array(\n");
			fwrite($dz, "\"server\"     => \"".$host."\", // MySQL server name.\n");
			fwrite($dz, "\"port\" 	    => \"".$port."\", // MySQL server port.\n");
			fwrite($dz, "\"user\"       => \"".$user."\", // MySQL username.\n");
			fwrite($dz, "\"pass\"       => \"".$pass."\", // MySQL password.\n");
			fwrite($dz, "\"name\"       => \"".$db."\", // MySQL database name.\n");
			fwrite($dz, "\"prefix\"     => \"".$prefix."\", // Tables prefix.\n");
			fwrite($dz, "\"secretword\" => \"RNFramework".$numcookie."\"); // Cookies.\n");
			fwrite($dz, "?>");
			fclose($dz);

			$parse[second]	= "config.php erfolgreich erstellt...";

			doquery ($QryTableAks        , 'aks'    	) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableAlliance   , 'alliance'   ) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableBanned     , 'banned'     ) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableBuddy      , 'buddy'      ) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableChat       , 'chat'       ) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableConfig     , 'config'     ) or die(mysql_errno().': '.mysql_error());
			doquery ($QryInsertConfig    , 'config'     ) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableErrors     , 'errors'     ) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableFleets     , 'fleets'     ) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableGalaxy     , 'galaxy'     ) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableLoteria    , 'loteria'    ) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableLunas      , 'lunas'      ) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableMessages   , 'messages'   ) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableModulos    , 'modulos'    ) or die(mysql_errno().': '.mysql_error());
			doquery ($QryInsertModulos   , 'modulos'    ) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableNews       , 'news'       ) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableNotes      , 'notes'      ) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTablePlanets    , 'planets'    ) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableRw         , 'rw'         ) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableStatPoints , 'statpoints'	) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableSupp       , 'supp'  		) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableTopKB      , 'topkb'  	) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableUsers      , 'users'  	) or die(mysql_errno().': '.mysql_error());
			doquery ($QryTableUsersTemp  , 'users_valid') or die(mysql_errno().': '.mysql_error());
			$parse[third]	= "Datenbank Tabellen erfolgreich erstellt....";

			$frame  = parsetemplate(gettemplate('install/ins_form_done'), $parse);
		}
		elseif ($Page == 3)
		{
			if ($_GET['error'] == 3)
				message ("Sie müssen alle Felder ausfüllen!","?mode=ins&page=3", 2, false, false);

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
			$QryAddAdmPlt .= "`name`              = 'Hauptplanet', "; 
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
	default:
}
$parse['ins_state']    = $Page;
$parse['ins_page']     = $frame;
$parse['dis_ins_btn']  = "?mode=$Mode&page=$nextpage";
display (parsetemplate (gettemplate('install/ins_body'), $parse), false, '', true, false);
?>