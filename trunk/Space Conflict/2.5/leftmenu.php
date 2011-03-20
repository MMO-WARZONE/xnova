<?PHP

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** leftmenu.php                          **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

function ShowLeftMenu ( $Level , $Template = 'left_menu') {
	global $lang, $dpath, $game_config, $adsense_config;

	includeLang('leftmenu');

	$MenuTPL                  = gettemplate( $Template );
	$InfoTPL                  = gettemplate( 'serv_infos' );
	$parse                    = $lang;
	$parse['lm_tx_serv']      = $game_config['resource_multiplier'];
	$parse['lm_tx_game']      = $game_config['game_speed'] / 2500;
	$parse['lm_tx_fleet']     = $game_config['fleet_speed'] / 2500;
	$parse['lm_tx_queue']     = MAX_FLEET_OR_DEFS_PER_ROW;
	$SubFrame                 = parsetemplate( $InfoTPL, $parse );
	$parse['server_info']     = $SubFrame;
	$parse['XNovaRelease']    = VERSION;
	$parse['dpath']           = $dpath;
	$parse['forum_url']       = $game_config['forum_url'];
	$parse['mf']              = "Hauptframe";
	$rank                     = doquery("SELECT `total_rank` FROM {{table}} WHERE `stat_code` = '1' AND `stat_type` = '1' AND `id_owner` = '". $user['id'] ."';",'statpoints',true);
	$parse['user_rank']       = $rank['total_rank'];

// Show Administrator Link
	if ($Level > 0) {
		$parse['ADMIN_LINK']  = "
		
			<div><a href=\"admin/leftmenu.php\"><font color=\"lime\">".$lang['user_level'][$Level]."</font></a></div>
		";
	} else {
		$parse['ADMIN_LINK']  = "";
	}

// Show Forum Link
	$parse['forum_link'] = "
		<br><div><a href=\"".$game_config['forum_url']."\" target=\"_blank\">Forum</a></div>";

// Show Custom Link
	if ($game_config['link_enable'] == 1) {
		$parse['added_link']  = "
		
			<div align=\"center\"><a href=\"".$game_config['link_url']."\" target=\"_blank\">".stripslashes($game_config['link_name'])."</a></div>
		";
	} else {
		$parse['added_link']  = "";
	}

// Show Source Code Link
	if ($game_config['enable_source'] == 1 && $game_config['enable_donate'] != 1) {
		$parse['source_link']  = "
		<tr>
			<td colspan=\"2\"><div align=\"center\"><a href=\"source.php\" target=\"Hauptframe\">Source Code</a></div></td>
		</tr>";
	} elseif ($game_config['enable_source'] == 1 && $game_config['enable_donate'] == 1) { 
		$parse['source_link']  = "
		<tr>
			<th width=\"51%\"><a href=\"source.php\" target=\"Hauptframe\">Source Code</a></th>";
	} else {
		$parse['source_link']  = "";
	}

// Show Donations Link
	if ($game_config['enable_donate'] == 1 && $game_config['enable_source'] != 1) {
		$parse['donate_link']  = "
		<tr>
			<td colspan=\"2\"><div align=\"center\"><a href=\"donate.php\" target=\"Hauptframe\">Donate</a></div></td>
		</tr>";
	} elseif ($game_config['enable_donate'] == 1 && $game_config['enable_source'] == 1) {
		$parse['donate_link']  = "
			<th width=\"49%\"><a href=\"donate.php\" target=\"Hauptframe\">Donate</a></th>
		</tr>";
	} else {
		$parse['donate_link']  = "";
	}

// Show Adsense Ad
	if ($adsense_config['leftmenu_on'] == 1) {
		$parse['leftmenu_script']  = "<div>".$adsense_config['leftmenu_script']."</div>";
	} else {
		$parse['leftmenu_script']  = "";
	}

	$parse['servername']   = $game_config['game_name'];
	$Menu                  = parsetemplate( $MenuTPL, $parse);
   	return $Menu;
}
	$Menu = ShowLeftMenu ( $user['authlevel'] );
	display ( $Menu, "Menu", '', false );

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>	