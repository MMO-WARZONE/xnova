<?php
//version 1.2


function ShowSettingAdmin( $CurrentUser )
{
	global $db, $lang,$displays;

	if ($CurrentUser['authlevel'] < 3) die($displays->message ($lang['not_enough_permissions']));

	if ($_POST['opt_save'] == "1")
	{
		if (isset($_POST['closed']) && $_POST['closed'] == 'on') {
		$game_config['game_disable']         = 1;
		$game_config['close_reason']         = addslashes( $_POST['close_reason'] );
		} else {
		$game_config['game_disable']         = 0;
		$game_config['close_reason']         = "";
		}

                if (isset($_POST['captcha']) && $_POST['captcha'] == 'on' && function_exists("gd_info")) {
                    $game_config['captcha'] = intval($_POST['captcha_valor']);
		} else {
                    $game_config['captcha'] = 0;
		}


		if (isset($_POST['debug']) && $_POST['debug'] == 'on') {
		$game_config['debug'] = 1;
		} else {
		$game_config['debug'] = 0;
		}

		if (isset($_POST['game_name']) && $_POST['game_name'] != '') {
		$game_config['game_name'] = $_POST['game_name'];
		}

		if (isset($_POST['forum_url']) && $_POST['forum_url'] != '') {
		$game_config['forum_url'] = $_POST['forum_url'];
		}

		if (isset($_POST['game_speed']) && is_numeric($_POST['game_speed'])) {
		$game_config['game_speed'] = $_POST['game_speed'] * 2500;
		}

		if (isset($_POST['fleet_speed']) && is_numeric($_POST['fleet_speed'])) {
		$game_config['fleet_speed'] = $_POST['fleet_speed'] * 2500;
		}

		if (isset($_POST['resource_multiplier']) && is_numeric($_POST['resource_multiplier'])) {
		$game_config['resource_multiplier'] = $_POST['resource_multiplier'];
		}

		if (isset($_POST['initial_fields']) && is_numeric($_POST['initial_fields'])) {
		$game_config['initial_fields'] = $_POST['initial_fields'];
		}

		if (isset($_POST['metal_basic_income']) && is_numeric($_POST['metal_basic_income'])) {
		$game_config['metal_basic_income'] = $_POST['metal_basic_income'];
		}

		if (isset($_POST['crystal_basic_income']) && is_numeric($_POST['crystal_basic_income'])) {
		$game_config['crystal_basic_income'] = $_POST['crystal_basic_income'];
		}

		if (isset($_POST['deuterium_basic_income']) && is_numeric($_POST['deuterium_basic_income'])) {
		$game_config['deuterium_basic_income'] = $_POST['deuterium_basic_income'];
		}

		if (isset($_POST['energy_basic_income']) && is_numeric($_POST['energy_basic_income'])) {
		$game_config['energy_basic_income'] = $_POST['energy_basic_income'];
		}

		if (isset($_POST['adm_attack']) && $_POST['adm_attack'] == 'on') {
			$game_config['adm_attack'] = 1;
		} else {
			$game_config['adm_attack'] = 0;
		}

		if (isset($_POST['language'])) {
			$game_config['lang'] = $_POST['language'];
		} else {
			$game_config['lang'];
		}

		if (isset($_POST['newsframe']) && $_POST['newsframe'] == 'on') {
			$game_config['information1']    = "1";
			$game_config['information2']    = strip_tags($_POST['NewsText']);
			$game_config['informations']    = $game_config['information1'].";;". $game_config['information2'];
		} else {
			$game_config['information1']    = "0";
			$game_config['information2']    = "";
			$game_config['informations']    = $game_config['information1'].";;". $game_config['information2'];
		}

                if (isset($_POST['act_publicidad']) && $_POST['act_publicidad'] == 'on') {
			$game_config['publicidad1']    = "1";
			$game_config['publicidad2']    = strip_tags($_POST['Publicidad']) ;
			$game_config['publicidads']    = $game_config['publicidad1'].";;". $game_config['publicidad2'];
		} else {
			$game_config['publicidad1']    = "0";
			$game_config['publicidad2']    = "";
			$game_config['publicidad']    = $game_config['publicidad1'].";;". $game_config['publicidad2'];
		}

                $db->query("UPDATE {{table}} SET `config_value` = '". $game_config['captcha']           ."' WHERE `config_name` = 'captcha';", 'config');
                $db->query("UPDATE {{table}} SET `config_value` = '". $game_config['publicidads']           ."' WHERE `config_name` = 'publicidad';", 'config');

		$db->query("UPDATE {{table}} SET `config_value` = '". $game_config['informations']           ."' WHERE `config_name` = 'information';", 'config');
		$db->query("UPDATE {{table}} SET `config_value` = '". $game_config['game_disable']           ."' WHERE `config_name` = 'game_disable';", 'config');
		$db->query("UPDATE {{table}} SET `config_value` = '". $game_config['close_reason']           ."' WHERE `config_name` = 'close_reason';", 'config');
		$db->query("UPDATE {{table}} SET `config_value` = '". $game_config['game_name']              ."' WHERE `config_name` = 'game_name';", 'config');
		$db->query("UPDATE {{table}} SET `config_value` = '". $game_config['forum_url']              ."' WHERE `config_name` = 'forum_url';", 'config');
		$db->query("UPDATE {{table}} SET `config_value` = '". $game_config['game_speed']             ."' WHERE `config_name` = 'game_speed';", 'config');
		$db->query("UPDATE {{table}} SET `config_value` = '". $game_config['fleet_speed']            ."' WHERE `config_name` = 'fleet_speed';", 'config');
		$db->query("UPDATE {{table}} SET `config_value` = '". $game_config['resource_multiplier']    ."' WHERE `config_name` = 'resource_multiplier';", 'config');
		$db->query("UPDATE {{table}} SET `config_value` = '". $game_config['initial_fields']         ."' WHERE `config_name` = 'initial_fields';", 'config');
		$db->query("UPDATE {{table}} SET `config_value` = '". $game_config['metal_basic_income']     ."' WHERE `config_name` = 'metal_basic_income';", 'config');
		$db->query("UPDATE {{table}} SET `config_value` = '". $game_config['crystal_basic_income']   ."' WHERE `config_name` = 'crystal_basic_income';", 'config');
		$db->query("UPDATE {{table}} SET `config_value` = '". $game_config['deuterium_basic_income'] ."' WHERE `config_name` = 'deuterium_basic_income';", 'config');
		$db->query("UPDATE {{table}} SET `config_value` = '". $game_config['energy_basic_income']    ."' WHERE `config_name` = 'energy_basic_income';", 'config');
		$db->query("UPDATE {{table}} SET `config_value` = '" .$game_config['debug']                  ."' WHERE `config_name` = 'debug'", 'config');
		$db->query("UPDATE {{table}} SET `config_value` = '" .$game_config['adm_attack']             ."' WHERE `config_name` = 'adm_attack'", 'config');
		$db->query("UPDATE {{table}} SET `config_value` = '" .$game_config['lang']             	  ."' WHERE `config_name` = 'lang'", 'config');
		header('refresh:3; url=./admin.php?page=settings');
                $displays->message("Configuracion Guardada");
 	}
	else
	{
		$displays->assignContent('adm/settings_body');

		$parse['game_name']              	= $db->game_config['game_name'];
		$parse['game_speed']             	= $db->game_config['game_speed']/2500;
		$parse['fleet_speed']            	= $db->game_config['fleet_speed']/2500;
		$parse['resource_multiplier']    	= $db->game_config['resource_multiplier'];
		$parse['forum_url']              	= $db->game_config['forum_url'];
		$parse['initial_fields']         	= $db->game_config['initial_fields'];
		$parse['metal_basic_income']     	= $db->game_config['metal_basic_income'];
		$parse['crystal_basic_income']   	= $db->game_config['crystal_basic_income'];
		$parse['deuterium_basic_income'] 	= $db->game_config['deuterium_basic_income'];
		$parse['energy_basic_income']    	= $db->game_config['energy_basic_income'];
		$parse['closed']                 	= ($db->game_config['game_disable'] == 1) ? " checked = 'checked' ":"";
		$parse['close_reason']           	= stripslashes($db->game_config['close_reason']);
		$parse['adm_debug']                  	= ($db->game_config['debug'] == 1)        ? " checked = 'checked' ":"";
		$parse['adm_attack']             	= ($db->game_config['adm_attack'] == 1)   ? " checked = 'checked' ":"";
		$parse['captcha']                       = ($db->game_config['captcha'] != 0)   ? " checked = 'checked' ":"";
                $parse['captcha_val']             	= ($db->game_config['captcha'] != 0)   ? $db->game_config['captcha']:"0";
                
                $parse["disabled"]=(!function_exists("gd_info"))?"disabled":"";
                $parse["disabled_info"]=(!function_exists("gd_info"))?"Necesitas la libreria GD para usar este sistema":"";
		$noticias=explode(";;",$db->game_config["information"]);
		$parse['newsframe']      = ($noticias[0] == 1)   ? " checked = 'checked' ":"";
		$parse['NewsTextVal']    = (stripslashes($noticias[1]));

                $publicidad=explode(";;",$db->game_config["publicidad"]);
		$parse['frame_publi']      = ($publicidad[0] == 1) ? " checked = 'checked' ":"";
		$parse['Publi']    = stripslashes($publicidad[1]);

		$LangFolder = opendir('./language/');
		while (($LangSubFolder = readdir($LangFolder)) !== false)
		{
			if($LangSubFolder != '.' && $LangSubFolder != '..' && $LangSubFolder != '.htaccess')
			{
				$parse['language_settings'] .= "<option ";
				if($db->game_config['lang'] == $LangSubFolder){
					$parse['language_settings'] .= "selected = selected";
                                }

                                $parse['language_settings'] .= " value=\"".$LangSubFolder."\">".$LangSubFolder."</option>";
			}
		}

                foreach($parse as $key => $value){
                    $displays->assign($key,$value);
                }

                $displays->display();
	}
}


?>
