<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** settings.php                          **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

function DisplayGameSettingsPage ( $CurrentUser ) {
	global $lang, $game_config, $_POST;

	includeLang('admin/settings');

	if ( $CurrentUser['authlevel'] >= 3 ) {
		if ($_POST['opt_save'] == "1") {
		
		// Enable/Disable Game
			if (isset($_POST['closed']) && $_POST['closed'] == 'on') {
				$game_config['game_disable']         = "1";
				$game_config['close_reason']         = addslashes( $_POST['close_reason'] );
			} else {
				$game_config['game_disable']         = "0";
				$game_config['close_reason']         = "";
			}

		// Game Name
			if (isset($_POST['game_name']) && $_POST['game_name'] != '') {
				$game_config['game_name'] = $_POST['game_name'];
			}

		// Show News Frame
			if (isset($_POST['newsframe']) && $_POST['newsframe'] == 'on') {
				$game_config['OverviewNewsFrame']     = "1";
				$game_config['OverviewNewsText']      = addslashes( $_POST['NewsText'] );
			} else {
				$game_config['OverviewNewsFrame']     = "0";
				$game_config['OverviewNewsText']      = "";
			}

		// Show External Chat
			if (isset($_POST['chatframe']) && $_POST['chatframe'] == 'on') {
				$game_config['OverviewExternChat']     = "1";
				$game_config['OverviewExternChatCmd']  = addslashes( $_POST['ExternChat'] );
			} else {
				$game_config['OverviewExternChat']     = "0";
				$game_config['OverviewExternChatCmd']  = "";
			}

		// Show Banner
			if (isset($_POST['bannerframe']) && $_POST['bannerframe'] == 'on') {
				$game_config['ForumBannerFrame']     = "1";
			} else {
				$game_config['ForumBannerFrame']     = "0";
			}

		// Debug Mode
			if (isset($_POST['debug']) && $_POST['debug'] == 'on') {
				$game_config['debug'] = "1";
			} else {
				$game_config['debug'] = "0";
			}

		// Game Name
			if (isset($_POST['game_name']) && $_POST['game_name'] != '') {
				$game_config['game_name'] = $_POST['game_name'];
			}

		// Forum Address
			if (isset($_POST['forum_url']) && $_POST['forum_url'] != '') {
				$game_config['forum_url'] = $_POST['forum_url'];
			}

		// Game Speed Multiplier
			if (isset($_POST['game_speed']) && is_numeric($_POST['game_speed'])) {
				$game_config['game_speed'] = $_POST['game_speed'];
			}

		// Fleet Speed Multiplier
			if (isset($_POST['fleet_speed']) && is_numeric($_POST['fleet_speed'])) {
				$game_config['fleet_speed'] = $_POST['fleet_speed'];
			}

		// Production Speed Multiplier
			if (isset($_POST['resource_multiplier']) && is_numeric($_POST['resource_multiplier'])) {
				$game_config['resource_multiplier'] = $_POST['resource_multiplier'];
			}

		// Fleet Debris Multiplier
			if (isset($_POST['Fleet_Cdr']) && is_numeric($_POST['Fleet_Cdr'])) {
				$game_config['Fleet_Cdr'] = $_POST['Fleet_Cdr'];
			}

		// Defense Debris Multiplier
			if (isset($_POST['Defs_Cdr']) && is_numeric($_POST['Defs_Cdr'])) {
				$game_config['Defs_Cdr'] = $_POST['Defs_Cdr'];
			}

		// Noob Protect ON/Off
			if (isset($_POST['noobprotection']) && is_numeric($_POST['noobprotection'])) {
				$game_config['noobprotection'] = $_POST['noobprotection'];
			}
		// Noob Protection Duration
			if (isset($_POST['noobprotectiontime']) && is_numeric($_POST['noobprotectiontime'])) {
				$game_config['noobprotectiontime'] = $_POST['noobprotectiontime'];
			}

		// Noob Protection Multiplier
			
		// Planet Initial Fields
			if (isset($_POST['initial_fields']) && is_numeric($_POST['initial_fields'])) {
				$game_config['initial_fields'] = $_POST['initial_fields'];
			}

		// Base Metal Production
			if (isset($_POST['metal_basic_income']) && is_numeric($_POST['metal_basic_income'])) {
				$game_config['metal_basic_income'] = $_POST['metal_basic_income'];
			}

		// Base Crystal Production
			if (isset($_POST['crystal_basic_income']) && is_numeric($_POST['crystal_basic_income'])) {
				$game_config['crystal_basic_income'] = $_POST['crystal_basic_income'];
			}

		// Base Deuterium Production
			if (isset($_POST['deuterium_basic_income']) && is_numeric($_POST['deuterium_basic_income'])) {
				$game_config['deuterium_basic_income'] = $_POST['deuterium_basic_income'];
			}

		// Base Tachyon Production
			if (isset($_POST['tachyon_basic_income']) && is_numeric($_POST['tachyon_basic_income'])) {
				$game_config['tachyon_basic_income'] = $_POST['tachyon_basic_income'];
			}

		// Base Energy Yield
			if (isset($_POST['energy_basic_income']) && is_numeric($_POST['energy_basic_income'])) {
				$game_config['energy_basic_income'] = $_POST['energy_basic_income'];
			}
			
		// Show Custom Link
			if (isset($_POST['enable_link_']) && is_numeric($_POST['enable_link_'])) {
				$game_config['link_enable'] = $_POST['enable_link_'];
			}

		// Custom Link Name
			$game_config['link_name'] = addslashes( $_POST['name_link_']);
	
		// Custom Link URL
			$game_config['link_url'] = $_POST['url_link_'];

		// Banner Image
			$game_config['banner_source_post'] = $_POST['banner_source_post'];

		// Points Settings
			if (isset($_POST['stat_settings']) && is_numeric($_POST['stat_settings'])) {
				$game_config['stat_settings'] = $_POST['stat_settings'];
			}

		// Show Classifieds Link
			if (isset($_POST['enable_announces_']) && is_numeric($_POST['enable_announces_'])) {
				$game_config['enable_announces'] = $_POST['enable_announces_'];
			}

		// Show Merchant Link
			if (isset($_POST['enable_marchand_']) && is_numeric($_POST['enable_marchand_'])) {
				$game_config['enable_marchand'] = $_POST['enable_marchand_'];
			}

		// Show Notes Link
			if (isset($_POST['enable_notes_']) && is_numeric($_POST['enable_notes_'])) {
				$game_config['enable_notes'] = $_POST['enable_notes_'];
			}

		// Show Donation Lint
			if (isset($_POST['enable_donate_']) && is_numeric($_POST['enable_donate_'])) {
				$game_config['enable_donate'] = $_POST['enable_donate_'];
			}

		// Show Source Code Link
			if (isset($_POST['enable_source_']) && is_numeric($_POST['enable_source_'])) {
				$game_config['enable_source'] = $_POST['enable_source_'];
			}

		// MCC-Bot Name
			$game_config['bot_name'] = addslashes( $_POST['name_bot']);

		// MCC-Bot Email Address
			$game_config['bot_adress'] = addslashes( $_POST['adress_bot']);

		// MCC-Bot Ban Duration
			if (isset($_POST['duration_ban']) && is_numeric($_POST['duration_ban'])) {
				$game_config['ban_duration'] = $_POST['duration_ban'];
			}
			
		// MCC-Bot Enable/Disable
			if (isset($_POST['bot_enable']) && is_numeric($_POST['bot_enable'])) {
				$game_config['enable_bot'] = $_POST['bot_enable'];
			}
			
		// Enable/Disable BBCode
			if (isset($_POST['bbcode_field']) && is_numeric($_POST['bbcode_field'])) {
				$game_config['enable_bbcode'] = $_POST['bbcode_field'];
			}


// Save Configuration
	// Enable/Disable Game
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['game_disable']           ."' WHERE `config_name` = 'game_disable';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['close_reason']           ."' WHERE `config_name` = 'close_reason';", 'config');

	// Game Name
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['game_name']              ."' WHERE `config_name` = 'game_name';", 'config');

	//Stats
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['stat_settings']              ."' WHERE `config_name` = 'stat_settings';", 'config');
			
	// Server Configuration
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['forum_url']              ."' WHERE `config_name` = 'forum_url';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['game_speed']             ."' WHERE `config_name` = 'game_speed';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['fleet_speed']            ."' WHERE `config_name` = 'fleet_speed';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['resource_multiplier']    ."' WHERE `config_name` = 'resource_multiplier';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['Fleet_Cdr']              ."' WHERE `config_name` = 'Fleet_Cdr';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['Defs_Cdr']               ."' WHERE `config_name` = 'Defs_Cdr';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['noobprotection']         ."' WHERE `config_name` = 'noobprotection';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['noobprotectiontime']     ."' WHERE `config_name` = 'noobprotectiontime';", 'config');

	// Page Generale 
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewNewsFrame']       ."' WHERE `config_name` = 'OverviewNewsFrame';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewNewsText']        ."' WHERE `config_name` = 'OverviewNewsText';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewExternChat']      ."' WHERE `config_name` = 'OverviewExternChat';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewExternChatCmd']   ."' WHERE `config_name` = 'OverviewExternChatCmd';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewBanner']          ."' WHERE `config_name` = 'OverviewBanner';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['OverviewClickBanner']     ."' WHERE `config_name` = 'OverviewClickBanner';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['ForumBannerFrame']       ."' WHERE `config_name` = 'ForumBannerFrame';", 'config');
			
	//Banner
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['banner_source_post']       ."' WHERE `config_name` = 'banner_source_post';", 'config');

	// Custom Link Options
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['link_enable']         ."' WHERE `config_name` = 'link_enable';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['link_name']         ."' WHERE `config_name` = 'link_name';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['link_url']         ."' WHERE `config_name` = 'link_url';", 'config');
			
	// Planet Options
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['initial_fields']         ."' WHERE `config_name` = 'initial_fields';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['metal_basic_income']     ."' WHERE `config_name` = 'metal_basic_income';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['crystal_basic_income']   ."' WHERE `config_name` = 'crystal_basic_income';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['deuterium_basic_income'] ."' WHERE `config_name` = 'deuterium_basic_income';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['tachyon_basic_income']   ."' WHERE `config_name` = 'tachyon_basic_income';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['energy_basic_income']    ."' WHERE `config_name` = 'energy_basic_income';", 'config');
 
	// MCC Bot 
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['bot_name']    ."' WHERE `config_name` = 'bot_name';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['bot_adress']    ."' WHERE `config_name` = 'bot_adress';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['ban_duration']    ."' WHERE `config_name` = 'ban_duration';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['enable_bot']    ."' WHERE `config_name` = 'enable_bot';", 'config');
			
	// Enable/Disable BBCode
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['enable_bbcode']    ."' WHERE `config_name` = 'enable_bbcode';", 'config');
			
	// Optional Link Settings 
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['enable_announces']    ."' WHERE `config_name` = 'enable_announces';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['enable_marchand']    ."' WHERE `config_name` = 'enable_marchand';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['enable_notes']    ."' WHERE `config_name` = 'enable_notes';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['enable_donate']    ."' WHERE `config_name` = 'enable_donate';", 'config');
		doquery("UPDATE {{table}} SET `config_value` = '". $game_config['enable_source']    ."' WHERE `config_name` = 'enable_source';", 'config');
			
	// Debug Mode
		doquery("UPDATE {{table}} SET `config_value` = '" .$game_config['debug']                  ."' WHERE `config_name` ='debug'", 'config');
		AdminMessage ('Options changed successfully !', 'Success', '?');

		} else {

		// Display Game Settings Page
			$parse                           = $lang;
			$parse['game_name']              = $game_config['game_name'];
			$parse['game_speed']             = $game_config['game_speed'];
			$parse['fleet_speed']            = $game_config['fleet_speed'];
			$parse['resource_multiplier']    = $game_config['resource_multiplier'];
			$parse['Fleet_Cdr']              = $game_config['Fleet_Cdr'];
			$parse['Defs_Cdr']               = $game_config['Defs_Cdr'];
			$parse['noobprotection']         = $game_config['noobprotection'];
			$parse['noobprotectiontime']     = $game_config['noobprotectiontime'];
			$parse['forum_url']              = $game_config['forum_url'];

			$parse['initial_fields']         = $game_config['initial_fields'];
			$parse['metal_basic_income']     = $game_config['metal_basic_income'];
			$parse['crystal_basic_income']   = $game_config['crystal_basic_income'];
			$parse['deuterium_basic_income'] = $game_config['deuterium_basic_income'];
			$parse['tachyon_basic_income']   = $game_config['tachyon_basic_income'];
			$parse['energy_basic_income']    = $game_config['energy_basic_income'];

			$parse['enable_link']            = $game_config['link_enable'];
			$parse['name_link']              = $game_config['link_name'];
			$parse['url_link']               = $game_config['link_url'];
			$parse['enable_announces']       = $game_config['enable_announces'];
			$parse['enable_marchand']        = $game_config['enable_marchand'];
			$parse['enable_notes']           = $game_config['enable_notes'];
			$parse['enable_donate']          = $game_config['enable_donate'];
			$parse['enable_source']          = $game_config['enable_source'];

			$parse['bot_name']               = stripslashes($game_config['bot_name']);
			$parse['bot_adress']             = stripslashes($game_config['bot_adress']);
			$parse['ban_duration']           = stripslashes($game_config['ban_duration']);
			$parse['enable_bot']             = stripslashes($game_config['enable_bot']);
			$parse['enable_bbcode']          = stripslashes($game_config['enable_bbcode']);
			
			$parse['banner_source_post']     = $game_config['banner_source_post'];
			$parse['stat_settings']          = stripslashes($game_config['stat_settings']);

			$parse['closed']                 = ($game_config['game_disable'] == 1) ? " checked = 'checked' ":"";
			$parse['close_reason']           = stripslashes( $game_config['close_reason'] );

			$parse['newsframe']              = ($game_config['OverviewNewsFrame'] == 1) ? " checked = 'checked' ":"";
			$parse['NewsTextVal']            = stripslashes( $game_config['OverviewNewsText'] );

			$parse['chatframe']              = ($game_config['OverviewExternChat'] == 1) ? " checked = 'checked' ":"";
			$parse['ExtTchatVal']            = stripslashes( $game_config['OverviewExternChatCmd'] );

			$parse['googlead']               = ($game_config['OverviewBanner'] == 1) ? " checked = 'checked' ":"";
			$parse['GoogleAdVal']            = stripslashes( $game_config['OverviewClickBanner'] );

			$parse['debug']                  = ($game_config['debug'] == 1)        ? " checked = 'checked' ":"";

			$parse['bannerframe']            = ($game_config['ForumBannerFrame'] == 1) ? " checked = 'checked' ":"";

			$PageTPL                         = gettemplate('admin/options_body');
			$Page                           .= parsetemplate( $PageTPL,  $parse );

			display ( $Page, $lang['adm_opt_title'], false, '', true );
		}
	} else {
		AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}
	return $Page;
}

	$Page = DisplayGameSettingsPage ( $user );

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>