<?PHP

/**
 * leftmenu.php
 *
 * @version 1.1
 * @copyright 2008 By Chlorel for XNova
 */


function ShowLeftMenu ( $Level , $Template = 'left_menu') {
	global $lang, $dpath, $game_config, $user, $DB;

	includeLang('leftmenu'); //sprachfile includieren

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
	
	$Query = $DB->query("SELECT total_rank FROM ".PREFIX."statpoints WHERE `stat_code` = '1' AND `stat_type` = '1' AND `id_owner` = '". $user['id'] ."'");
	$rank = $Query->fetch();
	           
	$parse['user_rank']       = $rank['total_rank'];
	//wenn authlevel > 0 --> Adminlink einbinden
	if ($Level > 0) {
		$parse['ADMIN_LINK']  = "
		<tr>
			<td colspan=\"2\"><div><a href=\"?action=administrativeHome\"><font color=\"lime\">".$lang['user_level'][$Level]."</font></a></div></td>
		</tr>";
	} else { //und sonst halt nicht
		$parse['ADMIN_LINK']  = "";
	}
	$parse['servername']   = $game_config['game_name'];
	
	//Erweitertes Leftmenü
	
	//Spielerübersicht
	$parse['user_username']        = $user['username'];
	$parse['user_id']              = $user['id'];
	$parse['user_az']			   = $user['angriffszone'];
	$parse['avatar'] 			   = $user['avatar'];
	
	//Punkte auslesen...
	$Query = $DB->query("SELECT * FROM ".PREFIX."statpoints WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $user['id'] ."'");
	$StatRecord = $Query->fetch();
	
			//...und einbinden
			$parse['user_builds']          = pretty_number( $StatRecord['build_points'] );
			$parse['user_tech']   		   = pretty_number( $StatRecord['tech_points'] );
			$parse['user_fleet']           = pretty_number( $StatRecord['fleet_points'] );
			$parse['user_def']			   = pretty_number( $StatRecord['defs_points'] );
			$parse['total_points']         = pretty_number( $StatRecord['total_points'] );
			$parse['user_rang']            = $StatRecord['total_rank'];
			$parse['date']                  = date("d.m.Y ");
			
			$tag=array("So","Mo","Di","Mi","Do","Fr","Sa");
			$tagnummer=date("w"); // Tag ermitteln
			$parse['tag']	= $tag[$tagnummer];
			
			//Allianztag auslesen
			$Query = $DB->query("SELECT ally_tag FROM ".PREFIX."alliance WHERE `id` = '". $user['ally_id'] ."'");
			$Ally_Tag = $Query->fetch();
			$parse['ally_tag']     = $Ally_Tag['ally_tag'];

			//Daten auslesen, die in der Gala benötigt werden
				$Query = $DB->query("SELECT * FROM ".PREFIX."planets WHERE `id` = '".$user['current_planet']."';");
				$CurrentPlanet = $Query->fetch();
				$CurrentPlID  		= $CurrentPlanet['id'];
				$CurrentRC    		= $CurrentPlanet['recycler'];
				$CurrentSP     		= $CurrentPlanet['spy_sonde'];
				$parse['system']	= $CurrentPlanet['system'];
				$parse['gala']		= $CurrentPlanet['galaxy'];
					
	
	$Menu                  = parsetemplate( $MenuTPL, $parse);

	return $Menu;
}



?>