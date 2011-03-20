<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** add_def.php                           **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = '../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= 1) {
		includeLang('admin');

		$mode      = $_POST['mode'];

		$PageTpl   = gettemplate("admin/add_def");
		$parse     = $lang;

		if ($mode == 'addit') {
			$id         		= $_POST['id'];
			$misil_launcher	    = $_POST['misil_launcher'];
			$small_laser		= $_POST['small_laser'];
			$big_laser			= $_POST['big_laser'];
			$gauss_canyon		= $_POST['gauss_canyon'];
			$ionic_canyon		= $_POST['ionic_canyon'];
			$buster_canyon		= $_POST['buster_canyon'];
			$small_protection_shield	= $_POST['small_protection_shield'];
			$big_protection_shield		= $_POST['big_protection_shield'];
			$orb_def_plat		= $_POST['orb_def_plat'];
			$interceptor_misil	= $_POST['interceptor_misil'];
			$interplanetary_misil		= $_POST['interplanetary_misil'];
			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`misil_launcher` = `misil_launcher` + '". $misil_launcher ."', ";
			$QryUpdatePlanet .= "`small_laser` = `small_laser` + '". $small_laser ."', ";
			$QryUpdatePlanet .= "`big_laser` = `big_laser` + '". $big_laser ."', ";
			$QryUpdatePlanet .= "`gauss_canyon` = `gauss_canyon` + '". $gauss_canyon ."', ";
			$QryUpdatePlanet .= "`ionic_canyon` = `ionic_canyon` + '". $ionic_canyon ."', ";
			$QryUpdatePlanet .= "`buster_canyon` = `buster_canyon` + '". $buster_canyon ."', ";
			$QryUpdatePlanet .= "`small_protection_shield` = `small_protection_shield` + '". $small_protection_shield ."', ";
			$QryUpdatePlanet .= "`big_protection_shield` = `big_protection_shield` + '". $big_protection_shield ."', ";
			$QryUpdatePlanet .= "`orb_def_plat` = `orb_def_plat` + '". $orb_def_plat ."', ";
			$QryUpdatePlanet .= "`interceptor_misil` = `interceptor_misil` + '". $interceptor_misil ."', ";
			$QryUpdatePlanet .= "`interplanetary_misil` = `interplanetary_misil` + '". $interplanetary_misil ."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '". $id ."' ";
			doquery( $QryUpdatePlanet, "planets");

			AdminMessage ( $lang['adm_adddef2'], $lang['adm_adddef1'] );
		}
		$Page = parsetemplate($PageTpl, $parse);

		display ($Page, $lang['adm_am_ttle'], false, '', true);
	} else {
		AdminMessage ( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>