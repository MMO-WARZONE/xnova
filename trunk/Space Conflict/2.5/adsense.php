<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** adsense.php                           **
******************************************/

    define('INSIDE'  , true);
    define('INSTALL' , false);

    $xnova_root_path = './';
    include($xnova_root_path . 'extension.inc');
    include($xnova_root_path . 'common.' . $phpEx);

    includeLang('options');

	$lang['PHP_SELF'] = 'adsense.' . $phpEx;

	$mode = $_GET['mode'];

// Change Adsense Settings
 
if ($_POST && $mode == "change") {
	if ($user['authlevel'] >= 2) {
	// Left Menu Page
		if (isset($_POST['leftmenu_on']) && $_POST['leftmenu_on'] == 'on') {
			$adsense_config['leftmenu_on']		= "1";
			$adsense_config['leftmenu_script']		= $_POST['leftmenu_script'];
		} else {
			$adsense_config['leftmenu_on']		= "0";
			$adsense_config['leftmenu_script']		= "";
		}

	// Overview Page
		if (isset($_POST['overview_on']) && $_POST['overview_on'] == 'on') {
			$adsense_config['overview_on']		= "1";
			$adsense_config['overview_script']		= $_POST['overview_script'];
		} else {
			$adsense_config['overview_on']		= "0";
			$adsense_config['overview_script']		= "";
		}

	// Galaxy Page
		if (isset($_POST['galaxy_on']) && $_POST['galaxy_on'] == 'on') {
			$adsense_config['galaxy_on']		= "1";
		} else {
			$adsense_config['galaxy_on']		= "0";
		}

	// Options Page
		if (isset($_POST['options_on']) && $_POST['options_on'] == 'on') {
			$adsense_config['options_on']		= "1";
		} else {
			$adsense_config['options_on']		= "0";
		}
		
	// Donor Store Page
		if (isset($_POST['donorstore_on']) && $_POST['donorstore_on'] == 'on') {
			$adsense_config['donorstore_on']		= "1";
		} else {
			$adsense_config['donorstore_on']		= "0";
		}
		
	// Fleet Scrapyard Page
		if (isset($_POST['scrapyard_on']) && $_POST['scrapyard_on'] == 'on') {
			$adsense_config['scrapyard_on']		= "1";
		} else {
			$adsense_config['scrapyard_on']		= "0";
		}
		
	// Donate Page
		if (isset($_POST['donate_on']) && $_POST['donate_on'] == 'on') {
			$adsense_config['donate_on']		= "1";
		} else {
			$adsense_config['donate_on']		= "0";
		}
						
	doquery("UPDATE {{table}} SET `adsense_value` = '". $adsense_config['leftmenu_on']		 ."' WHERE `adsense_name` = 'leftmenu_on';", 'adsense');
	doquery("UPDATE {{table}} SET `adsense_value` = '". $adsense_config['leftmenu_script']	 ."' WHERE `adsense_name` = 'leftmenu_script';", 'adsense');
	doquery("UPDATE {{table}} SET `adsense_value` = '". $adsense_config['overview_on']		 ."' WHERE `adsense_name` = 'overview_on';", 'adsense');
	doquery("UPDATE {{table}} SET `adsense_value` = '". $adsense_config['galaxy_on']		 ."' WHERE `adsense_name` = 'galaxy_on';", 'adsense');
	doquery("UPDATE {{table}} SET `adsense_value` = '". $adsense_config['options_on']		 ."' WHERE `adsense_name` = 'options_on';", 'adsense');
	doquery("UPDATE {{table}} SET `adsense_value` = '". $adsense_config['donorstore_on']		 ."' WHERE `adsense_name` = 'donorstore_on';", 'adsense');
	doquery("UPDATE {{table}} SET `adsense_value` = '". $adsense_config['scrapyard_on']		 ."' WHERE `adsense_name` = 'scrapyard_on';", 'adsense');
	doquery("UPDATE {{table}} SET `adsense_value` = '". $adsense_config['donate_on']		 ."' WHERE `adsense_name` = 'donate_on';", 'adsense');
	doquery("UPDATE {{table}} SET `adsense_value` = '". $adsense_config['overview_script']	 ."' WHERE `adsense_name` = 'overview_script';", 'adsense');


	AdminMessage ( "Adsense Settings Saved", "Save Adsense Settings" );

	} else {
		AdminMessage ( "You do not have appropriate rights", "No Rights" );
	}
} else {

//Display Adsense Settings Page
	$parse = $lang;

	$parse['leftmenu_on']		= ($adsense_config['leftmenu_on'] == 1) ? " checked = 'checked' ":"";
	$parse['leftmenu_script']	= $adsense_config['leftmenu_script'];
	$parse['overview_on']		= ($adsense_config['overview_on'] == 1) ? " checked = 'checked' ":"";
	$parse['galaxy_on']			= ($adsense_config['galaxy_on'] == 1) ? " checked = 'checked' ":"";
	$parse['options_on']		= ($adsense_config['options_on'] == 1) ? " checked = 'checked' ":"";
	$parse['donorstore_on']		= ($adsense_config['donorstore_on'] == 1) ? " checked = 'checked' ":"";
	$parse['scrapyard_on']		= ($adsense_config['scrapyard_on'] == 1) ? " checked = 'checked' ":"";
	$parse['donate_on']			= ($adsense_config['donate_on'] == 1) ? " checked = 'checked' ":"";
	$parse['overview_script']	= $adsense_config['overview_script'];

	$PageTPL                         = gettemplate('adsense_body');
	$Page                           .= parsetemplate( $PageTPL,  $parse );

	}

	display ( $Page, $lang['adm_opt_title'], false, '', true );

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>