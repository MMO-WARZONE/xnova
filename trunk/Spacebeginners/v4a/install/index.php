<?php

/**
 * index.php (Installeur)
 *
 * @version 1
 * @copyright 2008 By e-Zobar for XNova
 * Based on first Chlorel's code
 */

define('INSIDE'  , true);
define('INSTALL' , true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);
include($xnova_root_path . 'includes/databaseinfos.'.$phpEx);
include($xnova_root_path . 'includes/migrateinfo.'.$phpEx);


$Mode     = $_GET['mode'];
$Page     = $_GET['page'];
$phpself  = $_SERVER['PHP_SELF'];
$nextpage = $Page + 1;

	if (empty($Mode)) { $Mode = 'intro'; }
	if (empty($Page)) { $Page = 1;       }

	$MainTPL = gettemplate('install/ins_body');
	includeLang('install/install');
	switch ($Mode) {
		case 'intro':
				$SubTPL = gettemplate ('install/ins_intro');
				$bloc   = $lang;
				$frame  = parsetemplate ( $SubTPL, $bloc );
		 	break;
		case 'ins':
			if ($Page == 1) {
				if ($_GET['error'] == 1) {
				adminMessage ($lang['ins_error1'], $lang['ins_error']);
				}
				elseif ($_GET['error'] == 2) {
				adminMessage ($lang['ins_error2'], $lang['ins_error']);
				}

				$SubTPL = gettemplate ('install/ins_form');
				$bloc   = $lang;
				$frame  = parsetemplate ( $SubTPL, $bloc );
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
					if (!$dz) {
					header("Location: ?mode=ins&page=1&error=2");
					exit();
					}

				fwrite($dz, "<?php\n");
				fwrite($dz, "if(!defined(\"INSIDE\")){ die(\"attemp hacking\"); }\n");
				fwrite($dz, "\$dbsettings = Array(\n");
				fwrite($dz, "\"server\"     => \"".$host."\", // MySQL server name.\n");
				fwrite($dz, "\"user\"       => \"".$user."\", // MySQL username.\n");
				fwrite($dz, "\"pass\"       => \"".$pass."\", // MySQL password.\n");
				fwrite($dz, "\"name\"       => \"".$db."\", // MySQL database name.\n");
				fwrite($dz, "\"prefix\"     => \"".$prefix."\", // Tables prefix.\n");
				fwrite($dz, "\"secretword\" => \"SPACEBEGINNER".$numcookie."\"); // Cookies.\n");
				fwrite($dz, "?>");
				fclose($dz);

				function doquery ($InQry, $TblName) {
					global $prefix;
					$Table  = $prefix.$TblName;
					$DoQry  = str_replace("{{table}}", $Table, $InQry);
					$return = mysql_query($DoQry) or die("MySQL Error: <b>".mysql_error()."</b>");
				return $return;
				}

				doquery ( $QryTableAks        , 'aks'        );
				$parse['aks_created'] == $lang['create_aks'];
				doquery ( $QryTableAnnonce    , 'annonce'    );
				$parse['aks_created'] == $lang['create_annonce'];				
				doquery ( $QryTableAlliance   , 'alliance'   );
				$parse['aks_created'] == $lang['create_alliance'];
				doquery ( $QryTableBanned     , 'banned'     );
				$parse['aks_created'] == $lang['create_banned'];
				doquery ( $QryTableBuddy      , 'buddy'      );
				$parse['aks_created'] == $lang['create_buddy'];
				doquery ( $QryTableChat       , 'chat'       );
				$parse['aks_created'] == $lang['create_chat'];
				doquery ( $QryTableConfig     , 'config'     );
				$parse['aks_created'] == $lang['create_config'];
				doquery ( $QryInsertConfig    , 'config'     );
				$parse['aks_created'] == $lang['populate_config'];
				doquery ( $QryTabledeclared        , 'declared'        );
				$parse['aks_created'] == $lang['create_declared'];
				doquery ( $QryTableErrors     , 'errors'     );
				$parse['aks_created'] == $lang['create_errors'];
				doquery ( $QryTableFleets     , 'fleets'     );
				$parse['aks_created'] == $lang['create_fleets'];
				doquery ( $QryTableGalaxy     , 'galaxy'     );
				$parse['aks_created'] == $lang['create_galaxy'];
				doquery ( $QryTableIraks      , 'iraks'      );
				$parse['aks_created'] == $lang['create_iraks'];
				doquery ( $QryTableLunas      , 'lunas'      );
				$parse['aks_created'] == $lang['create_lunas'];
				doquery ( $QryTableMessages   , 'messages'   );
				$parse['aks_created'] == $lang['create_messages'];
				doquery ( $QryTableNotes      , 'notes'      );
				$parse['aks_created'] == $lang['create_messages'];
				doquery ( $QryTableSupp      , 'supp'      );
				$parse['aks_created'] == $lang['create_supp'];
				doquery ( $QryTablePlanets    , 'planets'    );
				$parse['aks_created'] == $lang['create_planets'];
				doquery ( $QryTableRw         , 'rw'         );
				$parse['aks_created'] == $lang['create_rw'];
				doquery ( $QryTableStatPoints , 'statpoints' );
				$parse['aks_created'] == $lang['create_statpoints'];
				doquery ( $QryTableTopkb      , 'topkb' );
				$parse['aks_created'] == $lang['create_topkb'];
				doquery ( $QryTableUsers      , 'users'      );
				$parse['aks_created'] == $lang['create_users'];
				doquery ( $QryTableMulti      , 'multi'      );
				$parse['aks_created'] == $lang['create_multi'];
				doquery ( $QryTablevacation   , 'vacation'      );
				$parse['aks_created'] == $lang['create_vacation'];
				doquery ( $QryTableuservalid  , 'users_valid'      );
				$parse['ask_created'] == $lang['create_users_valid'];
				doquery ( $QryTableGalaxypirat  , 'galaxy'      );
				$parse['ask_created'] == $lang['create_galaxy_pirat'];
				doquery ( $QryTablePlanetspirat , 'planets'     );
				$parse['aks_created'] == $lang['create_planets_pirat'];
				doquery ( $QryTableUserspirat      , 'users'      );
				$parse['aks_created'] == $lang['create_users_pirat'];

				

				$SubTPL = gettemplate ('install/ins_form_done');
				$bloc   = $lang;
				$frame  = parsetemplate ( $SubTPL, $bloc );
			}
			elseif ($Page == 3) {
				if ($_GET['error'] == 3) {
				adminMessage ($lang['ins_error3'], $lang['ins_error']);
				}

				$SubTPL = gettemplate ('install/ins_acc');
				$bloc   = $lang;
				$frame  = parsetemplate ( $SubTPL, $bloc );
			}
			elseif ($Page == 4) {
				$adm_user   = $_POST['adm_user'];
				$adm_pass   = $_POST['adm_pass'];
				$adm_email  = $_POST['adm_email'];
				$adm_planet = $_POST['adm_planet'];
				$adm_sex    = $_POST['adm_sex'];
				$md5pass    = md5($adm_pass);

				if (!$_POST['adm_user']) {
					header("Location: ?mode=ins&page=3&error=3");
					exit();
				}
				if (!$_POST['adm_pass']) {
					header("Location: ?mode=ins&page=3&error=3");
					exit();
				}
				if (!$_POST['adm_email']) {
					header("Location: ?mode=ins&page=3&error=3");
					exit();
				}
				if (!$_POST['adm_planet']) {
					header("Location: ?mode=ins&page=3&error=3");
					exit();
				}

				include($xnova_root_path.'config.php');
				$db_host   = $dbsettings['server'];
				$db_user   = $dbsettings['user'];
				$db_pass   = $dbsettings['pass'];
				$db_prefix = $dbsettings['prefix'];
				$db_db     = $dbsettings['name'];

				$connection = @mysql_connect($db_host, $db_user, $db_pass);
					if (!$connection) {
					header("Location: ?mode=ins&page=1&error=1");
					exit();
					}

				$dbselect = @mysql_select_db($db_db);
					if (!$dbselect) {
					header("Location: ?mode=ins&page=1&error=1");
					exit();
					}

				function doquery ($InQry, $TblName) {
					global $db_prefix;
					$Table  = $db_prefix.$TblName;
					$DoQry  = str_replace("{{table}}", $Table, $InQry);
					$return = mysql_query($DoQry) or die("MySQL Error: <b>".mysql_error()."</b>");
				return $return;
				}

				$QryInsertAdm  = "INSERT INTO {{table}} SET ";
				$QryInsertAdm .= "`id`                = '1', ";
				$QryInsertAdm .= "`username`          = '". $adm_user ."', ";
				$QryInsertAdm .= "`email`             = '". $adm_email ."', ";
				$QryInsertAdm .= "`email_2`           = '". $adm_email ."', ";
				$QryInsertAdm .= "`authlevel`         = '3', ";
				$QryInsertAdm .= "`volk`              = 'A', ";
				$QryInsertAdm .= "`sex`               = '". $adm_sex ."', ";
				$QryInsertAdm .= "`avatar`            = 'A', ";
				$QryInsertAdm .= "`id_planet`         = '5', ";
				$QryInsertAdm .= "`galaxy`            = '1', ";
				$QryInsertAdm .= "`system`            = '1', ";
				$QryInsertAdm .= "`planet`            = '5', ";
				$QryInsertAdm .= "`current_planet`    = '5', ";
				$QryInsertAdm .= "`register_time`     = '". time() ."', ";
				$QryInsertAdm .= "`password`          = '". $md5pass ."';";
				doquery($QryInsertAdm, 'users');

				$QryAddAdmPlt  = "INSERT INTO {{table}} SET ";
				$QryAddAdmPlt .= "`name`               = '". $adm_planet ."', ";
				$QryAddAdmPlt .= "`id_owner`           = '1', ";
				$QryAddAdmPlt .= "`galaxy`             = '1', ";
				$QryAddAdmPlt .= "`system`             = '1', ";
				$QryAddAdmPlt .= "`planet`             = '5', ";
				$QryAddAdmPlt .= "`last_update`        = '". time() ."', ";
				$QryAddAdmPlt .= "`planet_type`        = '1', ";
				$QryAddAdmPlt .= "`image`              = 'normaltempplanet02', ";
				$QryAddAdmPlt .= "`diameter`           = '12750', ";
				$QryAddAdmPlt .= "`field_max`          = '1000', ";
				$QryAddAdmPlt .= "`temp_min`           = '47', ";
				$QryAddAdmPlt .= "`temp_max`           = '87', ";
				$QryAddAdmPlt .= "`metal`              = '500', ";
				$QryAddAdmPlt .= "`metal_perhour`      = '0', ";
				$QryAddAdmPlt .= "`metal_max`          = '1000000', ";
				$QryAddAdmPlt .= "`crystal`            = '500', ";
				$QryAddAdmPlt .= "`crystal_perhour`    = '0', ";
				$QryAddAdmPlt .= "`crystal_max`        = '1000000', ";
				$QryAddAdmPlt .= "`deuterium`          = '500', ";
				$QryAddAdmPlt .= "`deuterium_perhour`  = '0', ";
				$QryAddAdmPlt .= "`deuterium_max`      = '1000000',";
				$QryAddAdmPlt .= "`appolonium`         = '500', ";
				$QryAddAdmPlt .= "`appolonium_perhour` = '0', ";
				$QryAddAdmPlt .= "`appolonium_max`     = '1000000';";
				doquery($QryAddAdmPlt, 'planets');

				$QryAddAdmGlx  = "INSERT INTO {{table}} SET ";
				$QryAddAdmGlx .= "`galaxy`            = '1', ";
				$QryAddAdmGlx .= "`system`            = '1', ";
				$QryAddAdmGlx .= "`planet`            = '5', ";
				$QryAddAdmGlx .= "`id_planet`         = '5'; ";
				doquery($QryAddAdmGlx, 'galaxy');

				doquery("UPDATE {{table}} SET `config_value` = '1' WHERE `config_name` = 'LastSettedGalaxyPos';", 'config');
				doquery("UPDATE {{table}} SET `config_value` = '1' WHERE `config_name` = 'LastSettedSystemPos';", 'config');
				doquery("UPDATE {{table}} SET `config_value` = '1' WHERE `config_name` = 'LastSettedPlanetPos';", 'config');
				doquery("UPDATE {{table}} SET `config_value` = `config_value` + '1' WHERE `config_name` = 'users_amount' LIMIT 1;", 'config');

				$SubTPL = gettemplate ('install/ins_acc_done');
				$bloc   = $lang;
				$frame  = parsetemplate ( $SubTPL, $bloc );
			}
			break;
		case 'goto':
			if ($Page == 1) {
				$SubTPL = gettemplate ('install/ins_goto_intro');
				$bloc   = $lang;
				$frame  = parsetemplate ( $SubTPL, $bloc );
			}
			elseif ($Page == 2) {
				if ($_GET['error'] == 1) {
				adminMessage ($lang['ins_error1'], $lang['ins_error']);
				}
				elseif ($_GET['error'] == 2) {
				adminMessage ($lang['ins_error2'], $lang['ins_error']);
				}

				$SubTPL = gettemplate ('install/ins_goto_form');
				$bloc   = $lang;
				$frame  = parsetemplate ( $SubTPL, $bloc );
			}
			elseif ($Page == 3) {
				$host   = $_POST['host'];
				$user   = $_POST['user'];
				$pass   = $_POST['passwort'];
				$prefix = $_POST['prefix'];
				$db     = $_POST['db'];

				$connection = @mysql_connect($host, $user, $pass);
					if (!$connection) {
					header("Location: ?mode=goto&page=2&error=1");
					exit();
					}

				$dbselect = @mysql_select_db($db);
					if (!$dbselect) {
					header("Location: ?mode=goto&page=2&error=1");
					exit();
					}

				$numcookie = mt_rand(1000, 1234567890);
				$dz = fopen("../config.php", "w");
					if (!$dz) {
					header("Location: ?mode=ins&page=1&error=2");
					exit();
					}

				fwrite($dz, "<?php\n");
				fwrite($dz, "if(!defined(\"INSIDE\")){ die(\"attemp hacking\"); }\n");
				fwrite($dz, "\$dbsettings = Array(\n");
				fwrite($dz, "\"server\"     => \"".$host."\", // MySQL server name.\n");
				fwrite($dz, "\"user\"       => \"".$user."\", // MySQL username.\n");
				fwrite($dz, "\"pass\"       => \"".$pass."\", // MySQL password.\n");
				fwrite($dz, "\"name\"       => \"".$db."\", // MySQL database name.\n");
				fwrite($dz, "\"prefix\"     => \"".$prefix."\", // Tables prefix.\n");
				fwrite($dz, "\"secretword\" => \"SPACEBEGINNER".$numcookie."\"); // Cookies.\n");
				fwrite($dz, "?>");
				fclose($dz);

				function doquery($query, $p) {
					$query = str_replace("{{prefix}}", $p, $query);
					$return = mysql_query($query) or die("MySQL Error: <b>".mysql_error()."</b>");
				return $return;
				}
				foreach ($QryMigrate as $query) {
					doquery($query, $prefix);
				}

				$SubTPL = gettemplate ('install/ins_goto_done');
				$bloc   = $lang;
				$frame  = parsetemplate ( $SubTPL, $bloc );
			}
		 	break;
		case 'upg':
		 	break;
		case 'bye':
				header("Location: ../");
		 	break;
		default:
	}

	$parse                 = $lang;
	$parse['ins_state']    = $Page;
	$parse['ins_page']     = $frame;
	$parse['dis_ins_btn']  = "?mode=$Mode&page=$nextpage";
	$Displ                 = parsetemplate ($MainTPL, $parse);

	display ($Displ, "Installieren", false, '', true);

?>