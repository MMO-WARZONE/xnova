<?php
/**
 * @author Chlorel
 * @author e-Zobar
 * @author Perberos perberos@gmail.com
 * 
 * @package XNova
 * @version 1.1
 * @copyright (c) 2008 XNova Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

define('INSIDE'  , true);
define('INSTALL' , true);

$ugamela_root_path = '../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);
include($ugamela_root_path . 'includes/databaseinfos.'.$phpEx);
include($ugamela_root_path . 'includes/migrateinfo.'.$phpEx);


$Mode     = $_GET['mode'];
$Page     = $_GET['page'];
$phpself  = $_SERVER['PHP_SELF'];
$nextpage = $Page + 1;

if (empty($Mode))
{
	$Mode = 'intro';
}

if (empty($Page))
{
	$Page = 1;
}

$MainTPL = gettemplate('install/ins_body');
includeLang('install/install');

//TODO: put this into /install/install.mo
$lang['download_config'] = 'Descargar config.php';
$lang['continue'] = 'Continuar';

switch ($Mode)
{
	case 'intro':
		// just show an intro screen
		$SubTPL = gettemplate('install/ins_intro');
		$frame  = parsetemplate($SubTPL, $lang);
	break;
	
	case 'ins':
		
		if ($Page == 1)
		{
			if ($_GET['error'] == 1)
			{
				adminMessage($lang['ins_error1'], $lang['ins_error']);
			}
			elseif ($_GET['error'] == 2)
			{
				adminMessage($lang['ins_error2'], $lang['ins_error']);
			}

			$SubTPL = gettemplate('install/ins_form');
			$frame  = parsetemplate($SubTPL, $lang);
		}
		elseif ($Page == 2)
		{
			$host   = $_POST['host'];
			$user   = $_POST['user'];
			$pass   = $_POST['passwort'];
			$prefix = $_POST['prefix'];
			$db     = $_POST['db'];

			$connection = @mysql_connect($host, $user, $pass);
			if (!$connection)
			{
				header("Location: ?mode=ins&page=1&error=1");
				exit();
			}

			$dbselect = @mysql_select_db($db);
			if (!$dbselect)
			{
				header("Location: ?mode=ins&page=1&error=1");
				exit();
			}

			$numcookie = mt_rand(1000, 1234567890);
			$dz = fopen($ugamela_root_path."config.php", "w");
			
			if (!$dz && !isset($_POST['skip']))
			{
				if (isset($_POST['download']))
				{
					// raw data for config.php
					$content  = "<?php\n";
					$content .= "if(!defined(\"INSIDE\")){ die(\"attemp hacking\"); }\n";
					$content .= "\$dbsettings = Array(\n";
					$content .= "\"server\"     => \"".$host."\", // MySQL server name.\n";
					$content .= "\"user\"       => \"".$user."\", // MySQL username.\n";
					$content .= "\"pass\"       => \"".$pass."\", // MySQL password.\n";
					$content .= "\"name\"       => \"".$db."\", // MySQL database name.\n";
					$content .= "\"prefix\"     => \"".$prefix."\", // Tables prefix.\n";
					$content .= "\"secretword\" => \"XNova".$numcookie."\"); // Cookies.\n";
					$content .= "?>";
					
					// headers to download the file
					header('Content-Type: application/octet-stream');
					header('Content-Disposition: attachment; filename=config.php');
					header('Content-Length: '.strlen($content));
					
					die($content);
				}
				
				// we show a message with a form to download the config.php in a
				// file
				$page  = $lang['ins_error2'].'<br><br><form action="" method="post">';
				$page .= '<input type="hidden" name="host" value="'.$host.'">';
				$page .= '<input type="hidden" name="user" value="'.$user.'">';
				$page .= '<input type="hidden" name="passwort" value="'.$pass.'">';
				$page .= '<input type="hidden" name="prefix" value="'.$prefix.'">';
				$page .= '<input type="hidden" name="db" value="'.$db.'">';
				$page .= '<input type="submit" name="download" value="'.$lang['download_config'].'"> ';
				$page .= '<input type="submit" name="skip" value="'.$lang['continue'].'">';
				$page .= '</form>';
				
				adminMessage($page, $lang['ins_error']);
			}

			// when we has been uploaded the file.
			if (!isset($_POST['skip']))
			{
				fwrite($dz, "<?php\n");
				fwrite($dz, "if(!defined(\"INSIDE\")){ die(\"attemp hacking\"); }\n");
				fwrite($dz, "\$dbsettings = Array(\n");
				fwrite($dz, "\"server\"     => \"".$host."\", // MySQL server name.\n");
				fwrite($dz, "\"user\"       => \"".$user."\", // MySQL username.\n");
				fwrite($dz, "\"pass\"       => \"".$pass."\", // MySQL password.\n");
				fwrite($dz, "\"name\"       => \"".$db."\", // MySQL database name.\n");
				fwrite($dz, "\"prefix\"     => \"".$prefix."\", // Tables prefix.\n");
				fwrite($dz, "\"secretword\" => \"XNova".$numcookie."\"); // Cookies.\n");				
				fwrite($dz, "?>");
				fclose($dz);
			}
			elseif (filesize($ugamela_root_path.'config.php') == 0) // if (!file_exists('config.php'))
			{
				header("Location: ?mode=ins&page=1&error=2");
				exit();
			}

			function doquery ($InQry, $TblName)
			{
				global $prefix;
				$Table  = $prefix.$TblName;
				$DoQry  = str_replace("{{table}}", $Table, $InQry);
				$return = mysql_query($DoQry) or die("MySQL Error: <b>".mysql_error()."</b>");
				return $return;
			}
			
			// inserting the banning control table by IP
			doquery($QryTableAks        , 'aks'        );
			doquery($QryTableAnnonce    , 'annonce'    );
			doquery($QryTableAlliance   , 'alliance'   );
			doquery($QryTableBanned     , 'banned'     );
			doquery($QryTableBuddy      , 'buddy'      );
			doquery($QryTableChat       , 'chat'       );
			doquery($QryTableConfig     , 'config'     );
			doquery($QryInsertConfig    , 'config'     );
			doquery($QryTableErrors     , 'errors'     );
			doquery($QryTableFleets     , 'fleets'     );
			doquery($QryTableGalaxy     , 'galaxy'     );
			doquery($QryTableIraks      , 'iraks'      );
			doquery($QryTableMessages   , 'messages'   );
			doquery($QryTableNotes      , 'notes'      );
			doquery($QryTablePlanets    , 'planets'    );
			doquery($QryTableRw         , 'rw'         );
			doquery($QryTableStatPoints , 'statpoints' );
			doquery($QryTableUsers      , 'users'      );
			doquery($QryTableBannedip   , 'bannedip'   );
			doquery($QryTableSupp       , 'supp'       );
			doquery($QryTableMenu       , 'menu'       );
			doquery($QryInsertMenu       , 'menu'       );
			doquery($QryTableModulos       , 'modulos'       );
			doquery($QryInsertModulos       , 'modulos'       );
			doquery($QryTableLoteria       , 'loteria'       );
			doquery($QryTabletopkb       , 'topkb'       );
			doquery($QryTableips       , 'ips'       );
			doquery($QryTablevisitas       , 'visitas'       );
			
			$SubTPL = gettemplate('install/ins_form_done');
			$frame  = parsetemplate($SubTPL, $lang);
		}
		elseif ($Page == 3) 
		{
			if ($_GET['error'] == 3)
			{
				adminMessage($lang['ins_error3'], $lang['ins_error']);
			}

			$SubTPL = gettemplate('install/ins_acc');
			$frame  = parsetemplate($SubTPL, $lang);
		}
		elseif ($Page == 4)
		{
			$adm_user   = $_POST['adm_user'];
			$adm_pass   = $_POST['adm_pass'];
			$adm_email  = $_POST['adm_email'];
			$adm_planet = $_POST['adm_planet'];
			$adm_sex    = $_POST['adm_sex'];
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
			if (!$_POST['adm_planet'])
			{
				header("Location: ?mode=ins&page=3&error=3");
				exit();
			}

			include($ugamela_root_path.'config.php');
			$db_host   = $dbsettings['server'];
			$db_user   = $dbsettings['user'];
			$db_pass   = $dbsettings['pass'];
			$db_prefix = $dbsettings['prefix'];
			$db_db     = $dbsettings['name'];

			$connection = @mysql_connect($db_host, $db_user, $db_pass);
			if (!$connection)
			{
				header("Location: ?mode=ins&page=1&error=1");
				exit();
			}

			$dbselect = @mysql_select_db($db_db);
			if (!$dbselect)
			{
				header("Location: ?mode=ins&page=1&error=1");
				exit();
			}

			function doquery($InQry, $TblName)
			{
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
			$QryInsertAdm .= "`sex`               = '". $adm_sex ."', ";
			$QryInsertAdm .= "`id_planet`         = '1', ";
			$QryInsertAdm .= "`galaxy`            = '1', ";
			$QryInsertAdm .= "`system`            = '1', ";
			$QryInsertAdm .= "`planet`            = '1', ";
			$QryInsertAdm .= "`current_planet`    = '1', ";
			$QryInsertAdm .= "`register_time`     = '". time() ."', ";
			$QryInsertAdm .= "`password`          = '". $md5pass ."';";
			doquery($QryInsertAdm, 'users');

			$QryAddAdmPlt  = "INSERT INTO {{table}} SET ";
			$QryAddAdmPlt .= "`name`              = '". $adm_planet ."', ";
			$QryAddAdmPlt .= "`id_owner`          = '1', ";
			$QryAddAdmPlt .= "`galaxy`            = '1', ";
			$QryAddAdmPlt .= "`system`            = '1', ";
			$QryAddAdmPlt .= "`planet`            = '1', ";
			$QryAddAdmPlt .= "`last_update`       = '". time() ."', ";
			$QryAddAdmPlt .= "`planet_type`       = '1', ";
			$QryAddAdmPlt .= "`image`             = 'normaltempplanet02', ";
			$QryAddAdmPlt .= "`diameter`          = '12750', ";
			$QryAddAdmPlt .= "`field_max`         = '500', ";
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

			$SubTPL = gettemplate('install/ins_acc_done');
			$frame  = parsetemplate($SubTPL, $lang);
		}
	break;
	
	case 'goto':
		
		if ($Page == 1)
		{
			$SubTPL = gettemplate('install/ins_goto_intro');
			$frame  = parsetemplate($SubTPL, $lang);
		}
		elseif ($Page == 2)
		{
			if ($_GET['error'] == 1)
			{
				adminMessage($lang['ins_error1'], $lang['ins_error']);
			}
			elseif ($_GET['error'] == 2)
			{
				adminMessage($lang['ins_error2'], $lang['ins_error']);
			}

			$SubTPL = gettemplate('install/ins_goto_form');
			$frame  = parsetemplate( $SubTPL, $lang);
		}
		elseif ($Page == 3)
		{
			$host   = $_POST['host'];
			$user   = $_POST['user'];
			$pass   = $_POST['passwort'];
			$prefix = $_POST['prefix'];
			$db     = $_POST['db'];

			$connection = @mysql_connect($host, $user, $pass);
			if (!$connection)
			{
				header("Location: ?mode=goto&page=2&error=1");
				exit();
			}

			$dbselect = @mysql_select_db($db);
			if (!$dbselect)
			{
				header("Location: ?mode=goto&page=2&error=1");
				exit();
			}

			$numcookie = mt_rand(1000, 1234567890);
			$dz = fopen("../config.php", "w");
			if (!$dz)
			{
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
			fwrite($dz, "\"secretword\" => \"XNova".$numcookie."\"); // Cookies.\n");
			fwrite($dz, "?>");
			fclose($dz);

			function doquery($query, $p)
			{
				$query = str_replace("{{prefix}}", $p, $query);
				$return = mysql_query($query) or die("MySQL Error: <b>".mysql_error()."</b>");
				return $return;
			}
			
			foreach ($QryMigrate as $query)
			{
				doquery($query, $prefix);
			}

			$SubTPL = gettemplate('install/ins_goto_done');
			$frame  = parsetemplate($SubTPL, $lang);
		}
	break;
	
	case 'upg':
		// uh? must be update here?
	break;
	
	case 'bye':
		// redirect to game screen
		header("Location: ../");
		exit();
	break;
	
	default:
		// do nothing
	break;

}

$parse                = $lang;
$parse['ins_state']   = $Page;
$parse['ins_page']    = $frame;
$parse['dis_ins_btn'] = "?mode=$Mode&page=$nextpage";
$Displ                = parsetemplate($MainTPL, $parse);
display($Displ, $lang['title'], false, '', true);

?>
