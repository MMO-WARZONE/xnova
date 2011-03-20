<?php
//version 1
function ShowPanelAdmin($user){
	global $lang,$_GET, $displays, $db, $resource;
if ($user['authlevel'] < 1) die($displays->message ($lang['not_enough_permissions']));

//	$parse			= $lang;
//	$bloc			= $lang;

        $displays->assignContent('adm/admin_panel_main');
//	$PanelMainTPL 	= gettemplate('adm/admin_panel_main');

	if (isset($_GET['result']))
	{
		switch ($_GET['result'])
		{

				//Buscar un jugador
				case 'usr_data':
					$Pattern = $_GET['player'];
					$SelUser = $db->query("SELECT * FROM {{table}} WHERE (`username` LIKE '%". $Pattern ."%') OR (`id` =  '". $Pattern ."') OR (`email` = '". $Pattern ."') OR (`email_2` = '". $Pattern ."') LIMIT 1;", 'users', true);
					$UsrMain = $db->query("SELECT `name` FROM {{table}} WHERE `id` = '". $SelUser['id_planet'] ."';", 'planets', true);

//					$bloc                    = $lang;
					$lang['answer1']         = $SelUser['id'];
					$lang['answer2']         = $SelUser['username'];
					$lang['answer4']         = $SelUser['email'];
					$lang['answer5']         = $SelUser['email_2'];
					$lang['answer6']         = $SelUser['user_lastip'];
					$lang['answer7']         = date('d/m/y G:i:s', $SelUser['user_lastlogin']);
					$lang['answer8']         = $SelUser['dpath'];
					$lang['answer9']         = $lang['adm_usr_level'][ $SelUser['authlevel'] ];
					$lang['answer10']         = $SelUser['id_planet'];
					$lang['answer11']         = "[".$SelUser['galaxy'].":".$SelUser['system'].":".$SelUser['planet']."] ";
					$lang['answer13']        = $UsrMain['name'];

					if ($SelUser['urlaubs_modus'] == "0") {
					$lang['answer12']        = "Desactivado";
					}
					else {
					$lang['answer12']        = "Activado hasta ".date('d/m/y G:i:s', $SelUser['urlaubs_until']);
					}
					$lang['answer14']        = $SelUser['urlaubs_until'];

				/*	for ($Lvl = 0; $Lvl < 4; $Lvl++) {
						$lang['adm_level_lst'] .= "<option value=\"". $Lvl ."\">". $lang['adm_usr_level'][ $Lvl ] ."</option>";

					}    */

                                        $displays->assignContent('adm/admin_panel_asw1');
					//$SubPanelTPL             = gettemplate('admin/admin_panel_asw1');
					//$parse['adm_sub_form1']  = parsetemplate( $SubPanelTPL, $bloc );



					$lang['adm_sub_form2']  = "<br><table width=\"100%\"><tbody>";
					$lang['adm_sub_form2'] .= "<tr><td colspan=\"4\" class=\"c\"><font color=\"lime\">".$lang['adm_technos']."</font></td></tr>";
					for ($resource = 100; $resource <= 199; $resource++) {
						if ($resource[$resource] != "") {
							$lang['adm_sub_form2'] .= "<tr><th>".$lang['tech'][$resource]."</th>";
							$lang['adm_sub_form2'] .= "<th>".$SelUser[$resource[$resource]]."</th></tr>";
						}
					}
					$lang['adm_sub_form2'] .= "</tbody></table></div>";


					

					$lang['adm_sub_form3'] .= "<div style=\"float: right; width: 288;\">";
					$lang['adm_sub_form3'] .= "<table width=\"100%\" border=\"0\" align=\"center\"><tbody>";
					$lang['adm_sub_form3'] .= "<tr><td colspan=\"4\" class=\"c\"><font color=\"lime\">".$lang['adm_colony']."</font></td></tr>";

					$UsrColo = $db->query("SELECT * FROM {{table}} WHERE (`id_owner` = '". $SelUser['id'] ."') ORDER BY `galaxy`, `system`, `planet`, `planet_type`;", 'planets');
					while ( $Colo = mysql_fetch_assoc($UsrColo) ) {

							$lang['adm_sub_form3'] .= "<tr><th>".$Colo['id']."</th>";
							$lang['adm_sub_form3'] .= "<th>[".$Colo['galaxy'].":".$Colo['system'].":".$Colo['planet']."] (". (($Colo['planet_type'] == 1) ? $lang['adm_planet'] : $lang['adm_moon'] ) .")</th>";

							if ($Colo['planet_type'] == "1") {
							$lang['adm_sub_form3'] .= "<th><a href=\"../admin/planetlist.php?action=edit&id={$Colo['id']}\">".$Colo['name']."</a></th></tr>";
							}

							else {
							$lang['adm_sub_form3'] .= "<th><a href=\"../admin/moonlist.php?action=edit&id={$Colo['id']}\">".$Colo['name']."</a></th></tr>";
							}
					}
					$lang['adm_sub_form3'] .= "</tbody></table></div><div style=\"clear: both;\"></div></div>";

				        $displays->display();

			break;

		}
	}
	if (isset($_GET['action']))
	{
		switch ($_GET['action'])
		{
			case 'resources':
				//$SubPanelTPL            = gettemplate('adm/admin_panel_frm4');
				$displays->assignContent('adm/editor2');
			break;
		}
		$parse['adm_sub_form2'] = parsetemplate($SubPanelTPL, $bloc);
	}
	
        $displays->display();
	//display(parsetemplate( $PanelMainTPL, $parse ), false, '', true, false);
}
?>