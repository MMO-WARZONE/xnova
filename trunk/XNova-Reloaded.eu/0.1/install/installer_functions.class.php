<?php

/*
 * installer_functions.class.php
 * @Copyright 2009 by Steggi for Xnova-Reloaded
 * @Version: Xnova-Reloaded 0.1
 */
  
 class installer {
 
	var $_requirePHPversion = "5.2.0"; //minimal benötigte php Version
	var $_requireMySQLversion = "5.0.0"; // minimal benötigte Mysql Version
	var $_dbpointer;
	
	
	function ConnectToDatabase($host, $user, $pw)
	{
		$this->_dbpointer = mysql_connect($host, $user, $pw);
		if($this->_dbpointer === false) { return false; }
		else { return true; }
	}
	
	function SelectDatabase($db)
	{
		$dbselect = mysql_select_db($db, $this->_dbpointer);
		if($dbselect === false) { return false; }
		else { return true; }
	}
	
	function getSQLFromFile($file, $prefix)
	{
		$sql = file_get_contents($file);
		$sql = str_replace("PREFIX_", $prefix, $sql);
		$sql = preg_replace("/(\n|^)--[^\n]*(\n|$)/", "\\1", trim($sql));
		$sql = str_replace("\r" , '', $sql);
		$data = explode(";\n", $sql);
		return $data;
	}
	
	function CreateDatabase($database, $prefix)
	{
		$sql = $this->getSQLFromFile($database, $prefix);
		foreach($sql as $q)
		{
			mysql_unbuffered_query($q, $this->_dbpointer);
		}
		return $this;
	}
	function WriteConfig($host, $user, $pass, $db, $prefix)
	{		
			$numcookie = mt_rand(1000, 1234567890);
			$dz = fopen("../pages/config.php", "w");
			if (!$dz) {
				header("Location: ?error=2");
				exit();
			}
			fwrite($dz, "<?php\n");
			fwrite($dz, "/**\n");
			fwrite($dz, " * Datenbank Zugangsdaten.\n");
			fwrite($dz, " * Diese Datei wurde vom Installer generiert. Du solltest hier nichts verändern.\n");
			fwrite($dz, " * config.php\n");
			fwrite($dz, " * @version: Xnova-Reloaded 0.1\n");
			fwrite($dz, " * @license <http://www.gnu.org/licenses/gpl.txt> GNU/GPL\n");
			fwrite($dz, " */\n\n");
			fwrite($dz, "if(!defined(\"INSIDE\")){ die(\"attemp hacking\"); }\n");
			fwrite($dz, "\$dbsettings = Array(\n");
			fwrite($dz, "\"typ\"		=> \"mysql\",\n");
			fwrite($dz, "\"server\"     => \"".$host."\", // MySQL server name.\n");
			fwrite($dz, "\"user\"       => \"".$user."\", // MySQL username.\n");
			fwrite($dz, "\"pass\"       => \"".$pass."\", // MySQL password.\n");
			fwrite($dz, "\"name\"       => \"".$db."\", // MySQL database name.\n");
			fwrite($dz, "\"prefix\"     => \"".$prefix."\", // Tables prefix.\n");
			fwrite($dz, "\"secretword\" => \"XNova".$numcookie."\"); // Cookies.\n");
			fwrite($dz, "?>");
			fclose($dz);
	}
	
	function ReadUniverseConfiguration($prefix)
	{	
		$query = mysql_query("SELECT * FROM ".$prefix."config");
		while ( $row = mysql_fetch_assoc($query) ) {
	    $game_config[$row['config_name']] = $row['config_value'];
		}
		return $game_config;
	}
	
	function configureUniverse($prefix, $post)
	{
		mysql_query("Update ".$prefix."config SET config_value = '".$post['adminmail']."' WHERE config_name = 'adminmail'");
		mysql_query("Update ".$prefix."config SET config_value = '".$post['max_galaxy_in_world']."' WHERE config_name = 'max_galaxy_in_world'");
		mysql_query("Update ".$prefix."config SET config_value = '".$post['max_system_in_galaxy']."' WHERE config_name = 'max_system_in_galaxy'");
		mysql_query("Update ".$prefix."config SET config_value = '".$post['max_planet_in_system']."' WHERE config_name = 'max_planet_in_system'");
		mysql_query("Update ".$prefix."config SET config_value = '".$post['spy_report_row']."' WHERE config_name = 'spy_report_row'");
		mysql_query("Update ".$prefix."config SET config_value = '".$post['fields_by_moonbasis_level']."' WHERE config_name = 'fields_by_moonbasis_level'");
		mysql_query("Update ".$prefix."config SET config_value = '".$post['max_player_planets']."' WHERE config_name = 'max_player_planets'");
		mysql_query("Update ".$prefix."config SET config_value = '".$post['max_building_queue_size']."' WHERE config_name = 'max_building_queue_size'");
		mysql_query("Update ".$prefix."config SET config_value = '".$post['max_fleet_or_defs_per_row']."' WHERE config_name = 'max_fleet_or_defs_per_row'");
		mysql_query("Update ".$prefix."config SET config_value = '".$post['max_overflow']."' WHERE config_name = 'max_overflow'");
		mysql_query("Update ".$prefix."config SET config_value = '".$post['base_storage_size']."' WHERE config_name = 'base_storage_size'");
		mysql_query("Update ".$prefix."config SET config_value = '".$post['build_metal']."' WHERE config_name = 'build_metal'");
		mysql_query("Update ".$prefix."config SET config_value = '".$post['build_cristal']."' WHERE config_name = 'build_cristal'");
		mysql_query("Update ".$prefix."config SET config_value = '".$post['build_deuterium']."' WHERE config_name = 'build_deuterium'");
	}
	
	
	function InsertAdminAccount($prefix, $adm_user, $adm_email, $md5pass, $adm_planet)
	{

		$QryInsertAdm  = "INSERT INTO ".$prefix."users SET ";
		$QryInsertAdm .= "`id`                = '1', ";
		$QryInsertAdm .= "`username`          = '". $adm_user ."', ";
		$QryInsertAdm .= "`password`          = '". $md5pass ."', ";
		$QryInsertAdm .= "`email`             = '". $adm_email ."', ";
		$QryInsertAdm .= "`email_2`           = '". $adm_email ."', ";
		$QryInsertAdm .= "`authlevel`         = '3', ";
		$QryInsertAdm .= "`id_planet`         = '1', ";
		$QryInsertAdm .= "`galaxy`            = '1', ";
		$QryInsertAdm .= "`system`            = '1', ";
		$QryInsertAdm .= "`planet`            = '1', ";
		$QryInsertAdm .= "`current_planet`    = '1', ";
		$QryInsertAdm .= "`register_time`     = '". time() ."'; ";

		$QryAddAdmPlt  = "INSERT INTO ".$prefix."planets SET ";
		$QryAddAdmPlt .= "`name`              = '". $adm_planet ."', ";
		$QryAddAdmPlt .= "`id_owner`          = '1', ";
		$QryAddAdmPlt .= "`id_level`          = '1', ";
		$QryAddAdmPlt .= "`galaxy`            = '1', ";
		$QryAddAdmPlt .= "`system`            = '1', ";
		$QryAddAdmPlt .= "`planet`            = '1', ";
		$QryAddAdmPlt .= "`last_update`       = '". time() ."', ";
		$QryAddAdmPlt .= "`planet_type`       = '1', ";
		$QryAddAdmPlt .= "`image`             = 'planet_10', ";
		$QryAddAdmPlt .= "`diameter`          = '12750', ";
		$QryAddAdmPlt .= "`field_max`         = '230', ";
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
		

		$QryAddAdmGlx  = "INSERT INTO ".$prefix."galaxy SET ";
		$QryAddAdmGlx .= "`galaxy`            = '1', ";
		$QryAddAdmGlx .= "`system`            = '1', ";
		$QryAddAdmGlx .= "`planet`            = '1', ";
		$QryAddAdmGlx .= "`id_planet`         = '1'; ";
		
		mysql_query($QryInsertAdm) or die("MySQL Error: <b>".mysql_error()."</b>");
		mysql_query($QryAddAdmPlt) or die("MySQL Error: <b>".mysql_error()."</b>");
		mysql_query($QryAddAdmGlx) or die("MySQL Error: <b>".mysql_error()."</b>");
		
	}

	

}
?>