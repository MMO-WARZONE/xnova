<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = '../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= 1) {
		includeLang('admin');

		if ($_GET['cmd'] == 'sort') {
			$TypeSort = $_GET['type'];
		} else {
			$TypeSort = "id";
		}

		$PageTPL  = gettemplate('admin/overview_body');
		$RowsTPL  = gettemplate('admin/overview_rows');

		$parse                      = $lang;
		$parse['dpath']             = $dpath;
		$parse['mf']                = $mf;
		$parse['adm_ov_data_yourv'] = colorRed(VERSION);

		//Registrierte Benutzer
		$Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}}","users")); //Guarda en la variable los usuarios online
		$parse['Usersregs']  = $Consulta[0]; //Guarda para pasarlo al tpl los usuariosregistrados

		//Anzahl der Fehler
		$Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}}","errors")); //Guarda en la variable los Errores
		$parse['canterrores']  = $Consulta[0]; //Guarda para pasarlo al tpl los errores

		//Anzahl der Gebannten
		$Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}}","banned")); //Guarda en la variable los banned
		$parse['cantban']  = $Consulta[0]; //Guarda para pasarlo al tpl los banned

		//Anzahl der Allianzen
		$Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}}","alliance")); //Guarda en la variable las Alianzas
		$parse['cantalis']  = $Consulta[0]; //Guarda para pasarlo al tpl las Alianzas

		//Anzahl der Planeten
		$Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}} where planet_type='1'","planets")); //Guarda en la variable los planetas
		$parse['cantplan']  = $Consulta[0]; //Guarda para pasarlo al tpl los planetas

		//Anzahl der Monde
		$Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}} where planet_type='3'","planets")); //Guarda en la variable las Lunas
		$parse['cantlunas']  = $Consulta[0]; //Guarda para pasarlo al tpl las lunas

		//Anzahl der Flotten
		$Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}} ","fleets")); //Guarda en la variable las flotas en vuelo
		$parse['cantfleets']  = $Consulta[0]; //Guarda para pasarlo al tpl las flotas en vuelo

		//Anzahl der Nachrichten
		$Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}} ","messages")); //Guarda en la variable 
		$parse['cantmessa']  = $Consulta[0]; //Guarda para pasarlo al tpl

		//Anzahl der Kampfberichte
		$Consulta = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}} ","rw")); //Guarda en la variable 
		$parse['cantbata']  = $Consulta[0]; //Guarda para pasarlo al tpl
		
		$Last15Mins = doquery("SELECT * FROM {{table}} WHERE `onlinetime` >= '". (time() - 15 * 60) ."' ORDER BY `". $TypeSort ."` ASC;", 'users');
		$Count      = 0;
		$Color      = "lime";
		while ( $TheUser = mysql_fetch_array($Last15Mins) ) {
			if ($PrevIP != "") {
				if ($PrevIP == $TheUser['user_lastip']) {
					$Color = "red";
				} else {
					$Color = "lime";
				}
			}

			$UserPoints = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '" . $TheUser['id'] . "';", 'statpoints', true);
			$Bloc['dpath']               = $dpath;
			$Bloc['adm_ov_altpm']        = $lang['adm_ov_altpm'];
			$Bloc['adm_ov_wrtpm']        = $lang['adm_ov_wrtpm'];
			$Bloc['adm_ov_data_id']      = $TheUser['id'];
			$Bloc['adm_ov_data_name']    = $TheUser['username'];
			$Bloc['adm_ov_data_agen']    = $TheUser['user_agent'];
			$Bloc['adm_ov_data_clip']    = $Color;
			$Bloc['adm_ov_data_adip']    = $TheUser['user_lastip'];
			$Bloc['adm_ov_data_ally']    = $TheUser['ally_name'];
			$Bloc['adm_ov_data_point']   = pretty_number ( $UserPoints['total_points'] );
			$Bloc['adm_ov_data_activ']   = pretty_time ( time() - $TheUser['onlinetime'] );
			$Bloc['adm_ov_data_pict']    = "m.gif";
			$PrevIP                      = $TheUser['user_lastip'];

			$parse['adm_ov_data_table'] .= parsetemplate( $RowsTPL, $Bloc );
			$Count++;
		}

		$parse['adm_ov_data_count']  = $Count;
		$Page = parsetemplate($PageTPL, $parse);

if ($user['authlevel'] >=4) {
$version[0] = 0;
$version[1] = 8;
$version[2] = "g";


if ($fsock = @fsockopen('xorbit.de', 80, $errno, $errstr, 10))
	{
		@fputs($fsock, "GET /releases/info.txt HTTP/1.1\r\n");
		@fputs($fsock, "HOST: rocketnova.teamrocket.info\r\n");
		@fputs($fsock, "Connection: close\r\n\r\n");

		$get_info = false;
		while (!@feof($fsock))
		{
			if ($get_info)
			{
				$version_info .= @fread($fsock, 1024);
			}else{
				if (@fgets($fsock, 1024) == "\r\n")
				{
					$get_info = true;
				}
			}
		}
		@fclose($fsock);

		$version_info = explode("\n", $version_info);
		$latest_head_revision = (int) $version_info[0];
		$latest_minor_revision = (int) $version_info[2];
		$latest_version = (int) $version_info[0] . '.' . (int) $version_info[1] . $version_info[2];

		if($version_info[0] != $version[0] || $version_info[1] != $version[1] || $version_info[2] != $version[2])
		{
			$Page .= "<br><p style='color:red'>Es gibt eine neue Version von Rocket Nova</p><br>";
		}else{
			$Page .= "<br><p style='color:lime'>Sie haben die aktuelle Version von Rocket Nova</p><br>";
		}
	}else{
		if ($errstr)
		{
		      $Page .= '<p style="color:red">'. $errstr . '</p>';
		}else{
			$Page .= '<p>Socket Functions disabled! Bitte aktvieren sie diese Funktion um das Versions &uuml;berpr&uuml;fungsscripct ausf&uuml;hren zu k&ouml;nnen.</p>';
		}
	}
}


		display ( $Page, $lang['sys_overview'], false, '', true);
	} else {
		AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}
?>