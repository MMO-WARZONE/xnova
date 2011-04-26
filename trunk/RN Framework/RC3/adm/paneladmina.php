<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);

if ($user['authlevel'] < 1) die(message ($lang['not_enough_permissions']));

	$parse			= $lang;
	$bloc			= $lang;

	$PanelMainTPL 	= gettemplate('adm/admin_panel_main');

	if (isset($_GET['result']))
	{
		switch ($_GET['result'])
		{
			case 'usr_search':
				$Pattern = $_GET['player'];
				$SelUser = doquery("SELECT * FROM {{table}} WHERE `username` LIKE '%". $Pattern ."%' LIMIT 1;", 'users', true);
				$UsrMain = doquery("SELECT `name` FROM {{table}} WHERE `id` = '". $SelUser['id_planet'] ."';", 'planets', true);

				$bloc['answer1']        = $SelUser['id'];
				$bloc['answer2']        = $SelUser['username'];
				$bloc['answer3']        = $SelUser['user_lastip'];
				$bloc['answer4']        = $SelUser['email'];
				$bloc['answer5']        = $lang['user_level'][ $SelUser['authlevel'] ];
				$bloc['answer6']        = "[".$SelUser['id_planet']."] ".$UsrMain['name'];
				$bloc['answer7']        = "[".$SelUser['galaxy'].":".$SelUser['system'].":".$SelUser['planet']."] ";
				$parse['adm_sub_form2'] = parsetemplate( gettemplate('adm/admin_panel_asw1'), $bloc );
			break;
			case 'usr_data':
				$Pattern = $_GET['player'];
				$SelUser = doquery("SELECT * FROM {{table}} WHERE `username` LIKE '%". $Pattern ."%' LIMIT 1;", 'users', true);
				$UsrMain = doquery("SELECT `name` FROM {{table}} WHERE `id` = '". $SelUser['id_planet'] ."';", 'planets', true);

				$bloc['answer1']         = $SelUser['id'];
				$bloc['answer2']         = $SelUser['username'];
				$bloc['answer3']         = $SelUser['user_lastip'];
				$bloc['answer4']         = $SelUser['email'];
				$bloc['answer5']         = $lang['user_level'][ $SelUser['authlevel'] ];
				$bloc['answer6']         = "[".$SelUser['id_planet']."] ".$UsrMain['name'];
				$bloc['answer7']         = "[".$SelUser['galaxy'].":".$SelUser['system'].":".$SelUser['planet']."] ";
				$parse['adm_sub_form1']  = parsetemplate( gettemplate('adm/admin_panel_asw1'), $bloc );
				$parse['adm_sub_form2']  = "<table><tbody>";
				$parse['adm_sub_form2'] .= "<tr><td colspan=\"4\" class=\"c\">".$lang['pa_colonies']."</td></tr>";
				$UsrColo = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '". $SelUser['id'] ." ORDER BY `galaxy` ASC, `planet` ASC, `system` ASC, `planet_type` ASC';", 'planets');

				while ( $Colo = mysql_fetch_assoc($UsrColo) )
				{
					if ($Colo['id'] != $SelUser['id_planet'])
					{
						$parse['adm_sub_form2'] .= "<tr><th>".$Colo['id']."</th>";
						$parse['adm_sub_form2'] .= "<th>". (($Colo['planet_type'] == 1) ? $lang['pa_planet'] : $lang['pa_moon'] ) ."</th>";
						$parse['adm_sub_form2'] .= "<th>[".$Colo['galaxy'].":".$Colo['system'].":".$Colo['planet']."]</th>";
						$parse['adm_sub_form2'] .= "<th>".$Colo['name']."</th></tr>";
					}
				}

				$parse['adm_sub_form2'] .= "</tbody></table>";
				$parse['adm_sub_form3']  = "<table><tbody>";
				$parse['adm_sub_form3'] .= "<tr><td colspan=\"4\" class=\"c\">".$lang['pa_research']."</td></tr>";

				for ($Item = 100; $Item <= 199; $Item++)
				{
					if ($resource[$Item] != "")
					{
						$parse['adm_sub_form3'] .= "<tr><th>".$lang['tech'][$Item]."</th>";
						$parse['adm_sub_form3'] .= "<th>".$SelUser[$resource[$Item]]."</th></tr>";
					}
				}
				$parse['adm_sub_form3'] .= "</tbody></table>";
			break;
			case 'usr_level':
				if ($user['authlevel'] != 3) die(message ($lang['not_enough_permissions']));

				$Player     = $_GET['player'];
				$NewLvl     = $_GET['authlvl'];

				$QryUpdate  	= doquery("UPDATE {{table}} SET `authlevel` = '".$NewLvl."' WHERE `username` = '".$Player."';", 'users');
				$QryUpdate21 	= doquery("Select * From {{table}} WHERE `username` = '".$Player."';", 'users',true );

				doquery("UPDATE {{table}} SET `id_level` = '".$NewLvl."' WHERE `id_owner` = '".$QryUpdate21["id"]."';", 'planets');

				$Message    = $lang['pa_the_access_level_of'] . $Player . $lang['pa_is_now'];
				$Message   .= "<font color=\"red\">".$lang['user_level'][ $NewLvl ]."</font>";

				message ($Message, "paneladmina.php", 2);
			break;
			case 'ip_search':
				$Pattern    			= $_GET['ip'];
				$SelUser    			= doquery("SELECT * FROM {{table}} WHERE `user_lastip` = '". $ip ."' LIMIT 10;", 'users');
				$bloc['adm_this_ip']    = $Pattern;
				while ( $Usr = mysql_fetch_assoc($SelUser) )
				{
					$UsrMain = doquery("SELECT `name` FROM {{table}} WHERE `id` = '". $Usr['id_planet'] ."';", 'planets', true);
					$bloc['adm_plyer_lst'] .= "<tr><th>".$Usr['username']."</th><th>[".$Usr['galaxy'].":".$Usr['system'].":".$Usr['planet']."] ".$UsrMain['name']."</th></tr>";
				}
				$parse['adm_sub_form2'] = parsetemplate(gettemplate('adm/admin_panel_asw2'), $bloc );
			break;
		}
	}
	if (isset($_GET['action']))
	{
		switch ($_GET['action'])
		{
			case 'usr_search':
				$SubPanelTPL            = gettemplate('adm/admin_panel_frm1');
			break;
			case 'usr_data':
				$SubPanelTPL            = gettemplate('adm/admin_panel_frm4');
			break;
			case 'usr_level':
				for ($Lvl = 0; $Lvl < 4; $Lvl++)
				{
					$bloc['adm_level_lst'] .= "<option value=\"". $Lvl ."\">". $lang['user_level'][ $Lvl ] ."</option>";
				}
				$SubPanelTPL            = gettemplate('adm/admin_panel_frm3');
			break;
			case 'ip_search':
				$SubPanelTPL            = gettemplate('adm/admin_panel_frm2');
			break;
		}
		$parse['adm_sub_form2'] = parsetemplate($SubPanelTPL, $bloc);
	}
	display(parsetemplate( $PanelMainTPL, $parse ), false, '', true, false);

?>