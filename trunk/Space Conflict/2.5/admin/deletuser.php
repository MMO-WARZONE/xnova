<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** deletuser.php                         **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc' );
include($xnova_root_path . 'common.' . $phpEx );

	if ( $CurrentUser['authlevel'] >= 1 ) {
		$PageTpl = gettemplate( "admin/deletuser" );

		if ( $mode != "delet" ) {
			$parse['adm_bt_delet'] = $lang['adm_bt_delet'];
		}

		$Page = parsetemplate( $PageTpl, $parse );
		display ( $Page, $lang['adminpanel'], false, '', true );

	} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>