<?php

function ShowPanelAdmin($user){
	global $lang, $_GET, $db, $displays;

	if ($user['authlevel'] >= "1") {

		$PanelMainTPL = gettemplate('admin/admin_panel_main');

		$parse                  = $lang;
		$parse['adm_sub_form1'] = "";
		$parse['adm_sub_form2'] = "";
		$parse['adm_sub_form3'] = "";

		// Afficher les templates
		if (isset($_GET['result'])) {
			switch ($_GET['result']){

				//Buscar un jugador
				case 'usr_data':
					$Pattern = $_GET['player'];
					$SelUser = $db->query("SELECT * FROM {{table}} WHERE (`username` LIKE '%". $Pattern ."%') OR (`id` =  '". $Pattern ."') OR (`email` = '". $Pattern ."') OR (`email_2` = '". $Pattern ."') LIMIT 1;", 'users', true);
					$UsrMain = $db->query("SELECT `name` FROM {{table}} WHERE `id` = '". $SelUser['id_planet'] ."';", 'planets', true);

					$bloc                    = $lang;
					$bloc['answer1']         = $SelUser['id'];
					$bloc['answer2']         = $SelUser['username'];
					$bloc['answer3']         = $lang['adm_usr_genre'][ $SelUser['sex'] ];
					$bloc['answer4']         = $SelUser['email'];
					$bloc['answer5']         = $SelUser['email_2'];
					$bloc['answer6']         = $SelUser['user_lastip'];
					$bloc['answer7']         = date('d/m/y G:i:s', $SelUser['user_lastlogin']);
					$bloc['answer8']         = $SelUser['dpath'];
					$bloc['answer9']         = $lang['adm_usr_level'][ $SelUser['authlevel'] ];
					$bloc['answer10']         = $SelUser['id_planet'];
					$bloc['answer11']         = "[".$SelUser['galaxy'].":".$SelUser['system'].":".$SelUser['planet']."] ";
					$bloc['answer13']        = $UsrMain['name'];

					if ($SelUser['urlaubs_modus'] == "0") {
					$bloc['answer12']        = "Desactivado";
					}
					else {
					$bloc['answer12']        = "Activado hasta ".date('d/m/y G:i:s', $SelUser['urlaubs_until']);
					}
					$bloc['answer14']        = $Seluser['urlaubs_until'];

					for ($Lvl = 0; $Lvl < 4; $Lvl++) {
						$bloc['adm_level_lst'] .= "<option value=\"". $Lvl ."\">". $lang['adm_usr_level'][ $Lvl ] ."</option>";

					}


					$SubPanelTPL             = gettemplate('admin/admin_panel_asw1');
					$parse['adm_sub_form1']  = parsetemplate( $SubPanelTPL, $bloc );



					$parse['adm_sub_form2']  = "<br><table width=\"100%\"><tbody>";
					$parse['adm_sub_form2'] .= "<tr><td colspan=\"4\" class=\"c\"><font color=\"lime\">".$lang['adm_technos']."</font></td></tr>";
					for ($Item = 100; $Item <= 199; $Item++) {
						if ($resource[$Item] != "") {
							$parse['adm_sub_form2'] .= "<tr><th>".$lang['tech'][$Item]."</th>";
							$parse['adm_sub_form2'] .= "<th>".$SelUser[$resource[$Item]]."</th></tr>";
						}
					}
					$parse['adm_sub_form2'] .= "</tbody></table></div>";


					

					$parse['adm_sub_form3'] .= "<div style=\"float: right; width: 288;\">";
					$parse['adm_sub_form3'] .= "<table width=\"100%\" border=\"0\" align=\"center\"><tbody>";
					$parse['adm_sub_form3'] .= "<tr><td colspan=\"4\" class=\"c\"><font color=\"lime\">".$lang['adm_colony']."</font></td></tr>";

					$UsrColo = $db->query("SELECT * FROM {{table}} WHERE (`id_owner` = '". $SelUser['id'] ."') ORDER BY `galaxy`, `system`, `planet`, `planet_type`;", 'planets');
					while ( $Colo = mysql_fetch_assoc($UsrColo) ) {

							$parse['adm_sub_form3'] .= "<tr><th>".$Colo['id']."</th>";
							$parse['adm_sub_form3'] .= "<th>[".$Colo['galaxy'].":".$Colo['system'].":".$Colo['planet']."] (". (($Colo['planet_type'] == 1) ? $lang['adm_planet'] : $lang['adm_moon'] ) .")</th>";

							if ($Colo['planet_type'] == "1") {
							$parse['adm_sub_form3'] .= "<th><a href=\"../admin/planetlist.php?action=edit&id={$Colo['id']}\">".$Colo['name']."</a></th></tr>";
							}

							else {
							$parse['adm_sub_form3'] .= "<th><a href=\"../admin/moonlist.php?action=edit&id={$Colo['id']}\">".$Colo['name']."</a></th></tr>";
							}
					}
					$parse['adm_sub_form3'] .= "</tbody></table></div><div style=\"clear: both;\"></div></div>";

					break;

				//Buscar una alianza
				case 'alliance_data':

					$Pattern = $_GET['alliance'];
					$SelAlly = $db->query("SELECT * FROM {{table}} WHERE (`ally_name` LIKE '%". $Pattern ."%') OR (`id` =  '". $Pattern ."') LIMIT 1;", 'alliance', true);
					$AllyFounder = $db->query("SELECT `username` FROM {{table}} WHERE `id` = '". $SelAlly['ally_owner'] ."';", 'users', true);

					$bloc                    = $lang;
					$bloc['answer1']         = $SelAlly['id'];
					$bloc['answer2']         = $SelAlly['ally_name'];
					$bloc['answer3']         = $SelAlly['ally_tag'];
					$bloc['answer4']         = $AllyFounder[username];
					$bloc['answer5']         = $SelAlly['ally_members'];
					$bloc['answer6']         = date('d/m/y G:i:s', $SelAlly['ally_register_time']);
					$bloc['answer7']         = $SelAlly['ally_image'];
					$bloc['answer8']         = $SelAlly['ally_web'];
					$bloc['answer9']         = nl2br($SelAlly['ally_description']);
					$bloc['answer10']        = $SelAlly['ally_text'];
					$bloc['answer11']        = $SelAlly['ally_request'];
					$bloc['answer12']        = $SelAlly[''];
					$bloc['answer13']        = $SelAlly[''];
					$bloc['answer14']        = $SelAlly['ally_web'];

					$SubPanelTPL             = gettemplate('admin/admin_panel_asw2');
					$parse['adm_sub_form1']  = parsetemplate( $SubPanelTPL, $bloc );



					$parse['adm_sub_form3'] .= "<div style=\"float: right; width: 288;\">";
					$parse['adm_sub_form3'] .= "<table width=\"100%\" border=\"0\" align=\"center\"><tbody>";
					$parse['adm_sub_form3'] .= "<tr><td class=\"c\" colspan=\"4\"><font color=\"lime\">".$lang['adm_frm2_mlist']."</td></tr>";
					$parse['adm_sub_form3'] .= "<tr><th>".$lang['adm_frm2_usr']."</th><th>".$lang['adm_frm2_gpos']."</th><th>".$lang['adm_frm2_udate']."</th></tr>";


					$AllyMembers = $db->query("SELECT * FROM {{table}} WHERE (`ally_id` = '". $SelAlly['id'] ."') ORDER BY `ally_register_time`;", 'users');
					while ( $Member = mysql_fetch_assoc($AllyMembers) ) {

							$parse['adm_sub_form3'] .= "<tr><th>".$Member['username']."</th>";
							$parse['adm_sub_form3'] .= "<th>[".$Member['galaxy'].":".$Member['system'].":".$Member['planet']."]</th>";
							$parse['adm_sub_form3'] .= "<th>".date('d/m/y G:i:s', $Member['ally_register_time'])."</th></tr>";



				}
					$parse['adm_sub_form3'] .= "</tbody></table></div><div style=\"clear: both;\"></div></div>";

									
					break;


				// Buscar un planeta
				case 'inf_planet':
					$Pattern = $_GET['planet'];
					$SelPlanet = $db->query("SELECT * FROM {{table}} WHERE (`id` = '". $Pattern ."') OR (`name` = '". $Pattern ."');", 'planets', true);

					$bloc                    = $lang;
					$bloc['answer1']         = $SelPlanet['name'];
					$bloc['answer2']         = "[".$SelPlanet['galaxy'].":".$SelPlanet['system'].":".$SelPlanet['planet']."] ";
					$bloc['answer3']         = pretty_number($SelPlanet['metal']);
					$bloc['answer4']         = pretty_number($SelPlanet['crystal']);
					$bloc['answer5']         = pretty_number($SelPlanet['deuterium']);
					$bloc['answer6']         = pretty_number($SelPlanet['energy_max']);
					$bloc['answer7']         = $SelPlanet['metal_mine'];
					$bloc['answer8']         = $SelPlanet['crystal_mine'];
					$bloc['answer9']         = $SelPlanet['deuterium_sintetizer'];
					$bloc['answer10']         = $SelPlanet['solar_plant'];
					$bloc['answer11']         = $SelPlanet['fusion_plant'];
					$bloc['answer12']         = $SelPlanet['robot_factory'];
					$bloc['answer13']         = $SelPlanet['nano_factory'];
					$bloc['answer14']         = $SelPlanet['hangar'];
					$bloc['answer15']         = $SelPlanet['metal_store'];
					$bloc['answer16']         = $SelPlanet['crystal_store'];
					$bloc['answer17']         = $SelPlanet['deuterium_store'];
					$bloc['answer18']         = $SelPlanet['laboratory'];
					$bloc['answer19']         = $SelPlanet['terraformer'];
					$bloc['answer20']         = $SelPlanet['ally_deposit'];
					$bloc['answer21']         = $SelPlanet['silo'];
					$bloc['answer22']         = pretty_number($SelPlanet['small_ship_cargo']);
					$bloc['answer23']         = pretty_number($SelPlanet['big_ship_cargo']);
					$bloc['answer24']         = pretty_number($SelPlanet['light_hunter']);
					$bloc['answer25']         = pretty_number($SelPlanet['heavy_hunter']);
					$bloc['answer26']         = pretty_number($SelPlanet['crusher']);
					$bloc['answer27']         = pretty_number($SelPlanet['battle_ship']);
					$bloc['answer28']         = pretty_number($SelPlanet['colonizer']);
					$bloc['answer29']         = pretty_number($SelPlanet['recycler']);
					$bloc['answer30']         = pretty_number($SelPlanet['spy_sonde']);
					$bloc['answer31']         = pretty_number($SelPlanet['bomber_ship']);
					$bloc['answer32']         = pretty_number($SelPlanet['solar_satelit']);
					$bloc['answer33']         = pretty_number($SelPlanet['destructor']);
					$bloc['answer34']         = pretty_number($SelPlanet['dearth_star']);
					$bloc['answer35']         = pretty_number($SelPlanet['battleship']);
					$bloc['answer36']         = pretty_number($SelPlanet['misil_launcher']);
					$bloc['answer37']         = pretty_number($SelPlanet['small_laser']);
					$bloc['answer38']         = pretty_number($SelPlanet['big_laser']);
					$bloc['answer39']         = pretty_number($SelPlanet['gauss_canyon']);
					$bloc['answer40']         = pretty_number($SelPlanet['ionic_canyon']);
					$bloc['answer41']         = pretty_number($SelPlanet['buster_canyon']);
					$bloc['answer42']         = pretty_number($SelPlanet['small_protection_shield']);
					$bloc['answer43']         = pretty_number($SelPlanet['big_protection_shield']);
					$bloc['answer44']         = pretty_number($SelPlanet['interceptor_misil']);
					$bloc['answer45']         = pretty_number($SelPlanet['interplanetary_misil']);
					$bloc['answer46']         = $SelPlanet['mondbasis'];
					$bloc['answer47']         = $SelPlanet['phalanx'];
					$bloc['answer48']         = $SelPlanet['sprungtor'];
					$bloc['answer49']         = $UsrPlanet['username'];



				if ($SelPlanet['planet_type']==1) {
					$SubPanelTPL             = gettemplate('admin/admin_panel_asw3');
					$parse['adm_sub_form1']  = parsetemplate( $SubPanelTPL, $bloc );
					}
				else {
					$SubPanelTPL             = gettemplate('admin/admin_panel_asw4');
					$parse['adm_sub_form1']  = parsetemplate( $SubPanelTPL, $bloc );
					}
									
					break;

				// Log de IPs
				case 'usr_iplog':
					$Pattern = $_GET['player'];

					$parse['adm_sub_form1']  = "<br><table width=\"400\"><tbody>";
					$parse['adm_sub_form1'] .= "<tr><td colspan=\"4\" class=\"c\"><font color=\"lime\">".$lang['adm_log_log']."[".$Pattern."]</font></td></tr>";
					$parse['adm_sub_form1'] .= "<tr><th>".$lang['adm_log_Id']."</th><th>".$lang['adm_log_usr']."</th><th>".$lang['adm_log_ip']."</th><th>".$lang['adm_log_date']."</th>";


					$UsrLog = $db->query("SELECT * FROM {{table}} WHERE (`userid` = '".$Pattern."') OR (`username` = '".$Pattern."') OR (`user_ip` = '".$Pattern."') ORDER BY `Id`;", 'iplog');
					while ( $log = mysql_fetch_assoc($UsrLog) ) {
							$parse['adm_sub_form1'] .= "<tr><th>".$log['id']."";
							$parse['adm_sub_form1'] .= "<th>".$log['username']." (".$log['userid'].")";
							$parse['adm_sub_form1'] .= "<th>".$log['user_ip']."";
							$parse['adm_sub_form1'] .= "<th>".date('d/m/y G:i:s', $log['date'])."</th>";
					}
					$parse['adm_sub_form1'] .= "</tbody></table>";

					break;

				//Buscar jugador con ip
				case 'ip_search':
					$Pattern    = $_GET['ip'];
					$SelUser    = $db->query("SELECT * FROM {{table}} WHERE `user_lastip` = '". $Pattern ."' LIMIT 10;", 'users');
					$bloc                   = $lang;
					$bloc['adm_this_ip']    = $Pattern;
					while ( $Usr = mysql_fetch_assoc($SelUser) ) {
						$UsrMain = $db->query("SELECT `name` FROM {{table}} WHERE `id` = '". $Usr['id_planet'] ."';", 'planets', true);
						$bloc['adm_plyer_lst'] .= "<tr><th>".$Usr['username']."</th><th>[".$Usr['galaxy'].":".$Usr['system'].":".$Usr['planet']."] ".$UsrMain['name']."</th><th>".date('d/m/y G:i:s', $Usr['user_lastlogin'])."</th></tr>";
					}
					$SubPanelTPL            = gettemplate('admin/admin_panel_asw6');
					$parse['adm_sub_form2'] = parsetemplate( $SubPanelTPL, $bloc );
					break;
				default:
					break;

				//Modificar nivel de usuario
				case 'usr_level':
					
					# only for admins
					if ($user['authlevel'] < 3)
					{
						message($lang['sys_noalloaw'], $lang['sys_noaccess']);
						die();
					}
					
					$Player     = $_GET['player'];
					$NewLvl     = $_GET['authlvl'];

					$QryUpdate  = $db->query("UPDATE {{table}} SET `authlevel` = '".$NewLvl."' WHERE `username` = '".$Player."';", 'users');
					$QryUpdate21 = $db->query("Select * From {{table}} WHERE `username` = '".$Player."';", 'users',true );
                    		doquery("UPDATE {{table}} SET `id_level` = '".$NewLvl."' WHERE `id_owner` = '".$QryUpdate21["id"]."';", 'planets');
					$Message    = $lang['adm_mess_lvl1']. " ". $Player ." ".$lang['adm_mess_lvl2'];
					$Message   .= "<font color=\"red\">".$lang['adm_usr_level'][ $NewLvl ]."</font>!";

					AdminMessage ( $Message, $lang['adm_mod_level'] );
					break;


			}
		}

		// Traiter les reponses aux formulaires
		if (isset($_GET['action'])) {
			$bloc                   = $lang;
			switch ($_GET['action']){

				case 'usr_data':
					$SubPanelTPL            = gettemplate('admin/admin_panel_frm1');
					break;

				case 'alliance_data':
					$SubPanelTPL            = gettemplate('admin/admin_panel_frm2');
					break;

				case 'inf_planet':
					$SubPanelTPL            = gettemplate('admin/admin_panel_frm3');
					break;

				case 'usr_iplog':
					$SubPanelTPL            = gettemplate('admin/admin_panel_frm4');
					break;


				case 'usr_level':
					# only for admins
					if ($user['authlevel'] != 3)
					{
						message($lang['sys_noalloaw'], $lang['sys_noaccess']);
						die();
					}
					
					
					for ($Lvl = 0; $Lvl < 4; $Lvl++) {
						$bloc['adm_level_lst'] .= "<option value=\"". $Lvl ."\">". $lang['adm_usr_level'][ $Lvl ] ."</option>";
					}
					$SubPanelTPL            = gettemplate('admin/admin_panel_frm5');
					break;

				case 'ip_search':
					$SubPanelTPL            = gettemplate('admin/admin_panel_frm6');
					break;

				default:
					break;
			}
			$parse['adm_sub_form2'] = parsetemplate( $SubPanelTPL, $bloc );
		}

		$page = parsetemplate( $PanelMainTPL, $parse );
		display( $page, $lang['panel_mainttl'], false, '', true );
	} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}
 }
?>
