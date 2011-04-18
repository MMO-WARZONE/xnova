<?php

/*
 * index.php (Installer)
 *
 * @version Xnova-Reloaded 0.1
 * @copyright 2009 by Steggi for Xnova-Reloaded
 * 
 */

define('INSIDE'  , true);
define('INSTALL' , true);
define('USER_MUSS_REGISTRIERT_SEIN', false); // User muss nicht Registriert sein, um diese Seite aufzurufen
define('LEFTMENU_NICHT_ANZEIGEN', true); // Linkes Menü nicht anzeigen!

define('XNOVA_ROOT_PATH', './../');

include(XNOVA_ROOT_PATH . 'pages/common.php');
require_once("./installer_functions.class.php");

$installer = new installer();

//.htacces darf nicht vorhanden sein, sonst geht die Installation nicht.
if(file_exists("./.htaccess"))
{
	die("Setup nicht m&ouml;glich. Entferne erst die .htaccess.");
}


$Mode     = $_GET['mode'];
$Page     = $_GET['page'];
$phpself  = $_SERVER['PHP_SELF'];
$nextpage = $Page + 1;

	if (empty($Page)) { $Page = 1;       }

	$MainTPL = gettemplate('install/ins_body');
	includeLang('install/install');
	if ($_GET['error'] == 1) {
				InstallerMessage ($lang['ins_error1'], $lang['ins_error']);
				}
				elseif ($_GET['error'] == 2) {
				InstallerMessage ($lang['ins_error2'], $lang['ins_error']);
				}
	
	switch ($Mode) {
		case 'ins':
		
			if ($Page == 1) {
			
				//Variablen setzen
				$ok = true;
				
				if(!function_exists('version_compare') || version_compare(phpversion(),$installer->_requirePHPversion) < 0)
				{
					$phpvers = "<span style=\"color:red\">Error</span>";
					$ok = false;
				}
				else
				{
					$phpvers = "<span style=\"color:green\">OK</span>";
				}
				if(!function_exists('version_compare') || version_compare(mysql_get_client_info(),$installer->_requireMySQLversion) < 0)
				{
					$mysqlvers = "<span style=\"color:red\">Error</span>";
					$ok = false;
				}
				else
				{
					$mysqlvers = "<span style=\"color:green\">OK</span>";
				}
				if(!is_writable("./../pages/config.php"))
				{
					$configphp = "<span style=\"color:red\">Error</span>";
					$ok = false;
				}
				else
				{
					$configphp = "<span style=\"color:green\">OK</span>";
				}
				if(!is_writable("./"))
				{
					$setup = "<span style=\"color:red\">Error</span>";
					$ok = false;
				}
				else
				{
					$setup = "<span style=\"color:green\">OK</span>";
				}
				if(!ini_get('safe_mode'))
				{
					$safe_mode = "<span style=\"color:green\">OK</span>";
				}
				else
				{
					$safe_mode = "<span style=\"color:red\">Error</span>";
					$ok = false;
				}
				
				$content  = "".$lang['check_server']."<br><br>";
				$content .= $lang['check_php'].phpversion()." &lt; &gt; ".$installer->_requirePHPversion." (".$phpvers.")<br>";
				$content .= $lang['check_mysql'].mysql_get_client_info()." &lt; &gt; ".$installer->_requireMySQLversion." (".$mysqlvers.")<br>";
				$content .= $lang['check_config']."(".$configphp.")<br>";
				$content .= $lang['check_installer_dir']."(".$setup.")<br>";
				$content .= $lang['check_savemode']."(".$safe_mode.")<br>";
				$content .= "<br><p><input type=\"button\" name=\"back\" onclick=\"self.location.href='index.php'\" value=\"&lt; ".$lang['ins_btn_back']."\" >";
				if($ok)
				{
					$content .= "&nbsp;<input type=\"button\" name=\"next\" onclick=\"self.location.href='index.php?mode=ins&amp;page=2'\" value=\"".$lang['ins_btn_next']." &gt;\" ></p>";
					$content .= "<br><p><span>".$lang['check_ok']."</span></p><br>";
				}
				else
				{
					$content .= "&nbsp;<input type=\"button\" name=\"next\" onclick=\"self.location.href='index.php?mode=ins&amp;page=1'\" value=\"".$lang['ins_btn_retry']."\" ></p>";
					$content .= "<br><p><span>".$lang['check_error']."</span></p><br>";
				}
			
				$SubTPL = gettemplate ('install/ins_check');
				$bloc   = $lang;
				$bloc['content'] = $content;
				$frame  = parsetemplate ( $SubTPL, $bloc );
			}
		
			elseif ($Page == 2) {
				
				
				$SubTPL = gettemplate ('install/ins_form');
				$bloc   = $lang;
				
				$frame  = parsetemplate ( $SubTPL, $bloc );
			}
			elseif ($Page == 3) {
				
				$host   = $_POST['host'];
				$user   = $_POST['user'];
				$pass   = $_POST['passwort'];
				$prefix = $_POST['prefix'];
				$db     = $_POST['db'];

				
				$installer->ConnectToDatabase($host, $user, $pass);
				$installer->SelectDatabase($db);
				$installer->CreateDatabase("xnova_database.sql", $prefix);
				$installer->WriteConfig($host, $user, $pass, $db, $prefix);

				$SubTPL = gettemplate ('install/ins_form_done');
				$bloc   = $lang;
				
				$frame  = parsetemplate ( $SubTPL, $bloc );
			}
			elseif ($Page == 4){
			echo $Page;
			//Datenbankverbindung herstellen
			include(XNOVA_ROOT_PATH.'pages/config.php');
			$db_host   = $dbsettings['server'];
			$db_user   = $dbsettings['user'];
			$db_pass   = $dbsettings['pass'];
			$db_prefix = $dbsettings['prefix'];
			$db_db     = $dbsettings['name'];
			
			$installer->ConnectToDatabase($db_host, $db_user, $db_pass);
			$installer->SelectDatabase($db_db);
			$conf = $installer->ReadUniverseConfiguration($db_prefix);
			
			$SubTPL = gettemplate ('install/ins_conf_universe');
			$bloc   = array_merge($lang, $conf);
			$frame  = parsetemplate ( $SubTPL, $bloc );
			}
			elseif ($Page == 5) {
			echo $Page;
				if ($_GET['error'] == 3) {
				InstallerMessage ($lang['ins_error3'], $lang['ins_error']);
				}
				//Datenbankverbindung herstellen
			include(XNOVA_ROOT_PATH.'pages/config.php');
			$db_host   = $dbsettings['server'];
			$db_user   = $dbsettings['user'];
			$db_pass   = $dbsettings['pass'];
			$db_prefix = $dbsettings['prefix'];
			$db_db     = $dbsettings['name'];
			
			$installer->ConnectToDatabase($db_host, $db_user, $db_pass);
			$installer->SelectDatabase($db_db);
			$installer->configureUniverse($db_prefix, $_POST);
				
				$SubTPL = gettemplate ('install/ins_acc');
				$bloc   = $lang;
				$frame  = parsetemplate ( $SubTPL, $bloc );
			}
			elseif ($Page == 6) {
				$adm_user   = $_POST['adm_user'];
				$adm_pass   = $_POST['adm_pass'];
				$adm_email  = $_POST['adm_email'];
				$adm_planet = $_POST['adm_planet'];
				$adm_sex    = $_POST['adm_sex'];
				$md5pass    = md5($adm_pass);

				if (!$_POST['adm_user']) {
					header("Location: ?mode=ins&amp;page=4&amp;error=3");
					exit();
				}
				if (!$_POST['adm_pass']) {
					header("Location: ?mode=ins&amp;page=4&amp;error=3");
					exit();
				}
				if (!$_POST['adm_email']) {
					header("Location: ?mode=ins&amp;page=4&amp;error=3");
					exit();
				}
				if (!$_POST['adm_planet']) {
					header("Location: ?mode=ins&page=4&amp;error=3");
					exit();
				}

				include(XNOVA_ROOT_PATH.'pages/config.php');
				$db_host   = $dbsettings['server'];
				$db_user   = $dbsettings['user'];
				$db_pass   = $dbsettings['pass'];
				$db_prefix = $dbsettings['prefix'];
				$db_db     = $dbsettings['name'];
				
				
				$installer->ConnectToDatabase($db_host, $db_user, $db_pass);
				$installer->SelectDatabase($db_db);
				$installer->InsertAdminAccount($db_prefix, $adm_user, $adm_email, $md5pass, $adm_planet);

				$SubTPL = gettemplate ('install/ins_acc_done');
				$bloc   = $lang;
				
				$frame  = parsetemplate ( $SubTPL, $bloc );
				
				
				//Install Verzeichniss mit .htaccess schützen.
				$handle = fopen("./.htaccess", "w");
				fwrite($handle, "Deny from all");
				fclose($handle);
				
			}
			break;
		default:
				$SubTPL = gettemplate ('install/ins_intro');
				$lang['ins_tx_state'] = "Einleitung";
				$bloc   = $lang;
				$Page = "";
				$frame  = parsetemplate ( $SubTPL, $bloc );
	}

	$parse                 = $lang;
	$parse['ins_state']    = $Page;
	$parse['ins_page']     = $frame;
	$parse['dis_ins_btn']  = "?mode=$Mode&amp;page=$nextpage";
	$Displ                 = parsetemplate ($MainTPL, $parse);

	display ($Displ, "Xnova-Reloaded Installer", false, '', true, true);
?>