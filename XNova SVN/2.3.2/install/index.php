<?php

define('INSIDE'  , true);
define('INSTALL' , true);

$svn_root = './../';
include($svn_root . 'extension.inc.php');
include($svn_root . 'common.'.$phpEx);
include_once('databaseinfos.'.$phpEx);


$Mode     = $_GET['mode'];
$Page     = intval($_GET['page']);
$phpself  = $_SERVER['PHP_SELF'];
$nextpage = $Page + 1;

   
$parse["version"]=version_compare(PHP_VERSION, "5.1", ">")?"Yes" : "No";
$parse["version_color"]=($parse["version"]=="Yes")?"Green" : "Red";

$archivo = is_writable("../config.php");
$parse["config"] = $archivo?"Se puede escribir": "No se puede escribir";
$parse["config_color"] = $archivo?"Green": "Red";
$archivo2 = is_file("../config.php");
$parse["config_dir"] = $archivo2? "Hallado": "No Hallado";
$parse["config_dir_color"] =  $archivo2?"Green": "Red";
$parse["captcha"]=function_exists("gd_info")?"Yes":"No";
$parse["captcha_color"]=($parse["captcha"]=="Yes")?"Green":"Red";
$parse["mysql"]=extension_loaded("mysql")==1?"Disponibles":"No Disponible";
$parse["disabled"]=(!version_compare(PHP_VERSION, "5.1", ">") || $parse["mysql"]=="Fail" )?"disabled":"";


$displays->assignContent("install/install",false,false);
if (empty($Mode)) { $Mode = 'intro'; }
if (empty($Page)) { $Page = 1;       }

switch ($Mode) {
        case'license':
		$displays->newblock("licencia");
                break;
	case 'intro':
		$displays->newblock("intro");
                break;
	case 'ins':
                if($Page!=1 && $parse["disabled"]=="disabled"){
                    exit(header("Location: ?mode=ins&page=1")); 
                }
                if($Page == 1){
                    $displays->newblock("requisitos");
                    
                    foreach($parse as $key => $value){
                        $displays->assign($key,$value);
                    }
                }elseif ($Page == 2) {
			if ($_GET['error'] == 1) {
				$displays->message ("La conexi&oacute;n a la base de datos a fallado","?mode=ins&page=1");
			}
			elseif ($_GET['error'] == 2) {
				$displays->message ("El fichero config.php no puede ser sustituido, no tenia acceso chmod 777","?mode=ins&page=1");
			}
                        $displays->newblock("form");
                }elseif ($Page == 3) {
                        $displays->newblock("form_2");
			$host   = $_POST['host'];
			$user   = $_POST['user'];
			$pass   = $_POST['passwort'];
			$prefix = $_POST['prefix'];
			$dbs    = $_POST['db'];

                        $db->conn = mysql_connect($host, $user, $pass);

			if (!$db->conn) {
				exit(header("Location: ?mode=ins&page=2&error=1"));
			}
                        
                        $db->query ("CREATE DATABASE IF NOT EXISTS `{$dbs}` ;", "");

                        $dbselect = $db->changeDatabase($dbs);
			if (!$dbselect) {
				header("Location: ?mode=ins&page=2&error=1");
				exit();
			}
                        
			$numcookie = mt_rand(1, 9999999999);
			$dz = fopen("../config.php", "w");
			$parses[first]	= "Conexión establecida con éxito...";

			fwrite($dz, "<?php\n");
			fwrite($dz, "if(!defined(\"INSIDE\")){ header(\"location:".$svn_root."\"); }\n");
			fwrite($dz, "\$dbsettings = Array(\n");
			fwrite($dz, "\"server\"     => \"".$host."\", // MySQL server name.\n");
			fwrite($dz, "\"user\"       => \"".$user."\", // MySQL username.\n");
			fwrite($dz, "\"pass\"       => \"".$pass."\", // MySQL password.\n");
			fwrite($dz, "\"name\"       => \"".$dbs."\", // MySQL database name.\n");
			fwrite($dz, "\"prefix\"     => \"".$prefix."\", // Tables prefix.\n");
			fwrite($dz, "\"secretword\" => \"XnovaSVN".$numcookie."\"); // Cookies.\n");
			fwrite($dz, "?>");
			fclose($dz);

			$parses[second]	= "Archivo config.php creado con éxito...";
			
			@chmod("../config.php", 0440);
			
			$db->query ($QryTableSac        , $prefix.'sac'        );
			$db->query ($QryTableAlliance   , $prefix.'alliance'   );
			$db->query ($QryTableBanned     , $prefix. 'banned'    );
			$db->query ($QryTableBuddy      , $prefix.'buddy'      );
			$db->query ($QryTableConfig     , $prefix.'config'     );
			$db->query ($QryInsertConfig    , $prefix.'config'     );
			$db->query ($QryTableErrors     , $prefix.'errors'     );
			$db->query ($QryTableFleets     , $prefix.'fleets'     );
			$db->query ($QryTableGalaxy     , $prefix.'galaxy'     );
			$db->query ($QryTableMessages   , $prefix.'messages'   );
			$db->query ($QryTableNotes      , $prefix.'notes'      );
			$db->query ($QryTablePlanets    , $prefix.'planets'    );
			$db->query ($QryTableRw         , $prefix.'rw'         );
			$db->query ($QryTableDiplo      , $prefix.'diplo'      );
			$db->query ($QryTableSupp       , $prefix.'supp'       );
			$db->query ($QryTableStatPoints , $prefix.'statpoints' );
			$db->query ($QryTableUsers      , $prefix.'users'      );
                        $db->query ($QryTablePlugins    , $prefix.'plugins'    );
			$db->query ($QryTableIpLog      , $prefix.'iplog'      );
                        $db->query ($QryTableNews       , $prefix.'news'       );
			$parses[third]	= "Tablas creadas con éxito...";

			foreach($parses as $key => $value){
                             $displays->assign($key,$value);
                        }      
		}
		elseif ($Page == 4)
		{
			if ($_GET['error'] == 3){
				$displays->message ("¡Debes completar todos los campos!","?mode=ins&page=3", 2);
                        }
			$displays->newblock("admin");
		}
		elseif ($Page == 5)
		{
                        $displays->newblock("config");

                        foreach($_POST as $key => $value){
                            $displays->assign($key,$value);
                        }
                }elseif($Page==6){


                        $displays->newblock("end");
                        extract($_POST);
                        
			$adm_user   = mysql_escape_string($adm_user);
			$adm_pass   = mysql_escape_string($adm_pass);
			$adm_email  = mysql_escape_string($adm_email);
			$md5pass    = md5($adm_pass);

			if (!$_POST['adm_user'] || !$_POST['adm_pass']||!$_POST['adm_email'])
			{
				exit(header("Location: ?mode=ins&page=4&error=3"));
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
                        $QryInsertAdm .= "`activate_status`     = '1', ";
			$QryInsertAdm .= "`password`          = '". $md5pass ."';";
			$db->query($QryInsertAdm, 'users');

			$QryAddAdmPlt  = "INSERT INTO {{table}} SET ";
			$QryAddAdmPlt .= "`id_owner`          = '1', ";
			$QryAddAdmPlt .= "`galaxy`            = '1', ";
			$QryAddAdmPlt .= "`system`            = '1', ";
			$QryAddAdmPlt .= "`planet`            = '1', ";
			$QryAddAdmPlt .= "`last_update`       = '". time() ."', ";
			$QryAddAdmPlt .= "`planet_type`       = '1', ";
			$QryAddAdmPlt .= "`image`             = 'normaltempplanet', ";
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
			$db->query($QryAddAdmPlt, 'planets');

			$QryAddAdmGlx  = "INSERT INTO {{table}} SET ";
			$QryAddAdmGlx .= "`galaxy`            = '1', ";
			$QryAddAdmGlx .= "`system`            = '1', ";
			$QryAddAdmGlx .= "`planet`            = '1', ";
			$QryAddAdmGlx .= "`id_planet`         = '1'; ";
			$db->query($QryAddAdmGlx, 'galaxy');

			$db->query("UPDATE {{table}} SET `config_value` = '1' WHERE `config_name` = 'LastSettedGalaxyPos';", 'config');
			$db->query("UPDATE {{table}} SET `config_value` = '1' WHERE `config_name` = 'LastSettedSystemPos';", 'config');
			$db->query("UPDATE {{table}} SET `config_value` = '1' WHERE `config_name` = 'LastSettedPlanetPos';", 'config');
			$db->query("UPDATE {{table}} SET `config_value` = `config_value` + '1' WHERE `config_name` = 'users_amount' LIMIT 1;", 'config');
                        if($smtp_delivery){
                            $db->query("UPDATE {{table}} SET `config_value` = '".mysql_escape_string($smtp_host)."' WHERE `config_name` = 'smtp_mail';", 'config');
                            $db->query("UPDATE {{table}} SET `config_value` = '".mysql_escape_string($smtp_user)."' WHERE `config_name` = 'user_mail';", 'config');
                            $db->query("UPDATE {{table}} SET `config_value` = '".mysql_escape_string($smtp_pass)."' WHERE `config_name` = 'pass_mail';", 'config');
                            $db->query("UPDATE {{table}} SET `config_value` = '".mysql_escape_string($smtp_auth)."' WHERE `config_name` = 'sec_mail'", 'config');
                            $db->query("UPDATE {{table}} SET `config_value` = '".mysql_escape_string($smtp_port)."' WHERE `config_name` = 'port_mail';", 'config');
                        }
                        $db->query("UPDATE {{table}} SET `config_value` = '".mysql_escape_string($server_name)."' WHERE `config_name` = 'game_name';", 'config');
                        $db->query("UPDATE {{table}} SET `config_value` = '".mysql_escape_string($script_path)."' WHERE `config_name` = 'forum_url';", 'config');
                            
                }
                                       
		break;
	case'upgrade':
                if($archivo2!="1" ){
                    exit(header("Location: ?mode=ins&page=1"));
                }
                $displays->newblock("update");
                if ($_POST)
		{
                        include_once("../config.php");
                        $error =0;
			$error +=($_POST["servidor"]!=$dbsettings["server"])?1:0;
                        $error +=($_POST["usuario"]!=$dbsettings["user"])?1:0;
                        $error +=($_POST["clave"]!=$dbsettings["pass"])?1:0;
                        $error +=($_POST["base"]!=$dbsettings["name"])?1:0;
                        $error +=($_POST["prefix"]!=$dbsettings["prefix"])?1:0;

                        if($error!=0){
                                $displays->message("Error!,Los datos metidos no concuerdan con los metidos en el archivo config.php");
                        }

                        if(filesize('../config.php') == 0)
                        {
                                die($displays->message("Error!, tu archivo config.php se encuentra vació o no configurado. En caso de no ser as� verifica que su chmod sea de 777","", "", false, false));
                        }

$users = "ALTER TABLE `".$dbsettings["prefix"]."users`
  DROP `activate_status`,
  MODIFY `ally_name` varchar(32) DEFAULT '',
  MODIFY `ally_request_text` text,
  DROP `avatar`,
  MODIFY `banaday` int(11) NOT NULL,
  ADD `current_page` text NOT NULL,
  ADD `darkmatter` int(11) NOT NULL,
  MODIFY `dpath` varchar(255) NOT NULL,
  MODIFY `email_2` varchar(64) NOT NULL,
  MODIFY `email` varchar(64) NOT NULL,
  MODIFY `fleet_shortcut` text,
  ADD `ip_at_reg` varchar(16) NOT NULL,
  ADD `db_time` INT( 33 ) NOT NULL  ,
  DROP `kolorminus`,
  DROP `kolorplus`,
  DROP `kolorpoziom`,
  DROP `lang`,
  DROP `lvl_minier`,
  DROP `lvl_raid`,
  DROP `mnl_alliance`,
  DROP `mnl_attaque`,
  DROP `mnl_buildlist`,
  DROP `mnl_expedition`,
  DROP `mnl_exploit`,
  DROP `mnl_joueur`,
  DROP `mnl_spy`,
  DROP `mnl_transport`,
  MODIFY `password` varchar(64) NOT NULL,
  DROP `raids`,
  DROP `rpg_points`,
  DROP `sex`,
  DROP `sign`,
  MODIFY `user_agent` text NOT NULL,
  MODIFY `user_lastip` varchar(16) NOT NULL,
  MODIFY `username` varchar(64) NOT NULL,
  DROP `xpminier`,
  DROP `xpraid`;";
  
$alliance = "ALTER TABLE `".$dbsettings["prefix"]."alliance`
  MODIFY `ally_description` text,
  MODIFY `ally_image` varchar(255) DEFAULT '',
  MODIFY `ally_name` varchar(32) DEFAULT '',
  MODIFY `ally_owner_range` varchar(32) DEFAULT '',
  MODIFY `ally_ranks` text,
  MODIFY `ally_request_waiting` text,
  MODIFY `ally_request` text,
  MODIFY `ally_tag` varchar(8) DEFAULT '',
  MODIFY `ally_text` text,
  MODIFY `ally_web` varchar(255) DEFAULT '';";
  
$tablas = "
DROP TABLE `".$dbsettings["prefix"]."aks`;
DROP TABLE `".$dbsettings["prefix"]."annonce`;
DROP TABLE `".$dbsettings["prefix"]."bannedip`;
DROP TABLE `".$dbsettings["prefix"]."chat`;
DROP TABLE `".$dbsettings["prefix"]."iraks`;";

$sac ="CREATE TABLE IF NOT EXISTS `".$dbsettings["prefix"]."sac` ( `id` bigint(20) unsigned NOT NULL AUTO_INCREMENT, `name` varchar(50) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL, `fleet_id` text CHARACTER SET latin1 COLLATE latin1_general_ci, `origen_id` text NOT NULL, `galaxy` int(2) DEFAULT NULL, `system` int(4) DEFAULT NULL, `planet` int(2) DEFAULT NULL, `type` int(1) NOT NULL, `invited` mediumtext NOT NULL, `accept` mediumtext NOT NULL, `deny` mediumtext NOT NULL, `time` varchar(11) NOT NULL, PRIMARY KEY (`id`) ) ENGINE=MyISAM DEFAULT CHARSET=latin1;";

$banned ="ALTER TABLE `".$dbsettings["prefix"]."banned`
MODIFY `author` varchar(11) NOT NULL,
MODIFY `email` varchar(20) NOT NULL,
MODIFY `theme` text NOT NULL,
MODIFY `who2` varchar(11) NOT NULL,
MODIFY `who` varchar(11) NOT NULL;";

$buddy ="ALTER TABLE `".$dbsettings["prefix"]."buddy` MODIFY `text` TEXT;";

$config ="ALTER TABLE `".$dbsettings["prefix"]."config`
MODIFY `config_name` varchar(64) NOT NULL,
MODIFY `config_value` text NOT NULL;";

$error="ALTER TABLE `".$dbsettings["prefix"]."errors`
MODIFY `error_sender` varchar(32) NOT NULL DEFAULT '0',
MODIFY `error_text` text,
MODIFY `error_type` varchar(32),
ADD `error_page` text;";

$fleets="ALTER TABLE `".$dbsettings["prefix"]."fleets`
MODIFY `fleet_array` text,
ADD `fleet_resource_darkmatter` bigint(11) NOT NULL,
MODIFY `fleet_target_obj` int(2) NOT NULL;";

$messages="ALTER TABLE `".$dbsettings["prefix"]."messages` DROP `leido`,
MODIFY `message_from` varchar(48) DEFAULT NULL,
MODIFY `message_subject` varchar(48) DEFAULT NULL,
MODIFY `message_text` text;";

$notes="ALTER TABLE `".$dbsettings["prefix"]."notes` MODIFY `text` text,
MODIFY `title` varchar(32) DEFAULT NULL;";

$planets="ALTER TABLE `".$dbsettings["prefix"]."planets` MODIFY `b_building_id` text NOT NULL,
MODIFY `b_hangar_id` text NOT NULL,
MODIFY `big_protection_shield` int(11) NOT NULL,
MODIFY `energy_max` bigint(20) NOT NULL,
MODIFY `image` varchar(32) NOT NULL DEFAULT 'normaltempplanet01',
MODIFY `name` varchar(255) DEFAULT 'Planeta Principal',
ADD `planet_protector` int(11) NOT NULL,
MODIFY `small_protection_shield` int(11) NOT NULL,
ADD `supernova` bigint(11) NOT NULL;";

$rw="ALTER TABLE `".$dbsettings["prefix"]."rw` ADD `owners` varchar(255) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '0,
MODIFY `raport` text NOT NULL,
MODIFY `rid` varchar(72) NOT NULL;";

$supp="ALTER TABLE `".$dbsettings["prefix"]."supp` MODIFY `subject` varchar(255) COLLATE latin1_bin NOT NULL,
MODIFY `text` longtext COLLATE latin1_bin NOT NULL;";

$insert = "INSERT INTO `".$dbsettings["prefix"]."config`
(`config_name`           , `config_value`) VALUES
('VERSION'          	 , '2.3.2'),
('lang'                  , 'es'),
('stat'                  , '1'),
('stat_level'            , '2'),
('stat_last_update'      , '1'),
('stat_settings'         , '1000'),
('stat_amount'           , '100'),
('stat_update_time'      , '30'),
('stat_flying'           , '1'),
('information'           , ''),

('server_mail'           , ''),
('pass_mail'             , ''),
('port_mail'             , ''),
('sec_mail'              , ''),
('captcha'               , '0');";

$delete ="Delete `".$dbsettings["prefix"]."config`
WHERE `config_name`='OverviewNewsFrame'
or `config_name`='OverviewNewsText'
or `config_name`='OverviewExternChat'
or `config_name`='OverviewExternChatCmd'
or `config_name`='OverviewBanner'
or `config_name`='OverviewClickBanner'";

$update="UPDATE `".$dbsettings["prefix"]."users` SET `dpath` = '';";
$update2="Update `".$dbsettings["prefix"]."config` SET `config_value`='2.3.2' where `config_name`='VERSION'";
$update3="INSERT INTO `".$dbsettings["prefix"]."config`
(`config_name`           , `config_value`) VALUES
('user_mail'           , ''),
('pass_mail'             , ''),
('port_mail'             , ''),
('sec_mail'              , ''),
('act_mail'              , ''),
('smtp_mail'              , ''),
('captcha'               , '0');";
$update4="CREATE TABLE IF NOT EXISTS `".$dbsettings["prefix"]."plugins` (
  `id_plugins` int(12) NOT NULL AUTO_INCREMENT,
  `name_plugins` varchar(40) NOT NULL,
  `menu_plugins` varchar(32) NOT NULL,
  `activate_plugins` int(1) NOT NULL DEFAULT '0',
  `page_plugins` int(1) NOT NULL,
  `pos_plugins` int(2) NOT NULL,
  PRIMARY KEY (`id_plugins`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
$update5="ALTER TABLE `".$dbsettings["prefix"]."messages` ADD `message_read` INT( 1 ) NOT NULL ;";
$update6="ALTER TABLE `".$dbsettings["prefix"]."errors` ADD `error_line` INT( 32 ) NOT NULL,
ADD `error_page` text NOT NULL    ;";
$update7="CREATE TABLE IF NOT EXISTS `".$dbsettings["prefix"]."iplog` (
  `id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `userid` bigint(11) NOT NULL,
  `username` varchar(64) NOT NULL,
  `user_ip` varchar(16) NOT NULL,
  `date` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";
$update8="ALTER TABLE `".$dbsettings["prefix"]."users` ADD `user_lastlogin` INT( 11 ) NOT NULL AFTER `user_lastip` ;";

$update9="Update `".$dbsettings["prefix"]."config` SET `config_value`='2.3.2' where `config_name`='VERSION'";
//APARTIR VERSION 2.1
$update10="INSERT INTO `".$dbsettings["prefix"]."config`
(`config_name`           , `config_value`) VALUES
('publicidad'               , '0');";
$update11="CREATE TABLE IF NOT EXISTS `".$dbsettings["prefix"]."news` (
  `news_id` bigint(133) NOT NULL AUTO_INCREMENT,
  `news_titulo` varchar(64) NOT NULL,
  `news_news` text NOT NULL,
  `news_date` varchar(42) NOT NULL,
  PRIMARY KEY (`news_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;";



				switch($_POST["modo"])
				{
					case'0.8':
					$Querys	= array("sac","banned","users","planets","supp","rw","notes","messages","fleets","error","config","tablas","alliance","update","insert","delete","update2","update3","update4","update5","update6","update7","update8","update9","update10","update11");
					
					foreach($Querys as $a){
						$db->query($$a,'');
					}
					break;
					case'1.1';
					$Querys	= array("update2","update3","update4","update5","update6","update7","update8","update9","update10","update11");
					
					foreach($Querys as $a){
						$db->query($$a,'');
					}
                                        case'1.2';
                                            $Querys	= array("update2","update3","update4","update5","update6","update7","update8","update9","update10","update11");
                                            foreach($Querys as $a){
                                                    $db->query($$a,'');
                                            }
					break;
                                         case'2.0';
                                            $Querys	= array("update9","update10","update11");
                                            foreach($Querys as $a){
                                                    $db->query($$a,'');
                                            }
					break;
                                        case'2.1';
                                            $Querys	= array("update9");
                                            foreach($Querys as $a){
                                                    $db->query($$a,'');
                                            }
					break;
                                        case'2.2';
                                            $Querys	= array("update9");
                                            foreach($Querys as $a){
                                                    $db->query($$a,'');
                                            }
					break;
                                        case'2.3';
                                            $Querys	= array("update9");
                                            foreach($Querys as $a){
                                                    $db->query($$a,'');
                                            }
					break;
                                        default:
                                            header("Location: ?mode=upgrade");
                                            break;
				}
				$displays->message("Xnova SVN finalizó la actualización con éxito, para finalizar borra el directorio install y luego haz <a href=\"./../\">click aqui</a>", "", "", false, false);
			
		}
		else
			$frame  = parsetemplate(gettemplate('install/ins_update'), false);
		break;
	default:
}
$parse['ins_state']    = $Page;
$parse['ins_page']     = $frame;
$lang['dis_ins_btn']  = "?mode=$Mode&page=$nextpage";
$displays->display ("");
?>