<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** messall.php                           **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= 1) {
          $mode = $_GET['mode'];
		if ($mode == "change") {
			if (isset($_POST["tresc"]) && $_POST["tresc"] != '') {
				$game_config['tresc'] = $_POST['tresc'];
			}
			if (isset($_POST["temat"]) && $_POST["temat"] != '') {
				$game_config['temat'] = $_POST['temat'];
			}
			if ($user['authlevel'] == 3) {
				$kolor = 'red';
				$ranga = 'Administrator';
			} elseif ($user['authlevel'] == 4) {
				$kolor = 'skyblue';
				$ranga = 'GameOperator';
			} elseif ($user['authlevel'] == 5) {
				$kolor = 'yellow';
				$ranga = 'SuperGameOperator';
			}
			if ($game_config['tresc'] != '' and $game_config['temat']) {
                          echo "IN HERE";
				$sq      = doquery("SELECT `id` FROM {{table}}", "users");
				$Time    = time();
				$From    = "<font color=\"". $kolor ."\">". $ranga ." ".$user['username']."</font>";
				$Subject = "<font color=\"". $kolor ."\">". $game_config['temat'] ."</font>";
				$Message = "<font color=\"". $kolor ."\"><b>". $game_config['tresc'] ."</b></font>";
				while ($u = mysql_fetch_array($sq)) {
					SendSimpleMessage ( $u['id'], $user['id'], $Time, 97, $From, $Subject, $Message);
				}
				message("<font color=\"lime\">Sent the message to all players</font>", "Complete", "../overview.php", 3);
			}
		} else {
			$parse = $game_config;
			$parse['dpath'] = $dpath;
			$parse['debug'] = ($game_config['debug'] == 1) ? " checked='checked'/":'';
			$page .= parsetemplate(gettemplate('admin/messall_body'), $parse);
			display($page, '', false,'', true);
		}
	} else {
		message($lang['sys_noalloaw'], $lang['sys_noaccess']);
	}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/
	
?>