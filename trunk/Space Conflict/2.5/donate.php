<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** donate.php                            **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	includeLang('credit');
	$parse = $lang;

	if ($game_config['ExtCopyFrame'] == '1') {
		$parse['ExtCopyFrame'] = "<tr><td colspan=\"2\" class=\"c\">". $lang['cred_ext'] ."</td></tr><tr><th>". nl2br($game_config['ExtCopyOwner']) ."</th><th>". nl2br($game_config['ExtCopyFunct']) ."</th></tr>";
	}

// Show Adsense Ad
	if ($adsense_config['donate_on'] == 1) {
		$parse['overview_script']  = "<div>".$adsense_config['overview_script']."</div>";
	} else {
		$parse['overview_script']  = "";
	}

	$BodyTPL = gettemplate('donate_body');

	$page = parsetemplate($BodyTPL, $parse);
	display($page, $lang['cred_credit'], true, '', false);

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>