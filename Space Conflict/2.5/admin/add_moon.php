<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** add_moon.php                          **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

	if ($user['authlevel'] >= 2) {
		includeLang('admin/addmoon');

		$mode      = $_POST['mode'];

		$PageTpl   = gettemplate("admin/add_moon");
		$parse     = $lang;

		if ($mode == 'addit') {
			$PlanetID  = $_POST['user'];
			$MoonName  = $_POST['name'];

			$QrySelectPlanet  = "SELECT * FROM {{table}} ";
			$QrySelectPlanet .= "WHERE ";
			$QrySelectPlanet .= "`id` = '". $PlanetID ."';";
			$PlanetSelected = doquery ( $QrySelectPlanet, 'planets', true);

			$Galaxy    = $PlanetSelected['galaxy'];
			$System    = $PlanetSelected['system'];
			$Planet    = $PlanetSelected['planet'];
            $Owner     = $PlanetSelected['id_owner'];
			$MoonID    = time();

			CreateOneMoonRecord ( $Galaxy, $System, $Planet, $Owner, $MoonID, $MoonName, 20 );

			AdminMessage ( $lang['addm_done'], $lang['addm_title'] );
		}
		$Page = parsetemplate($PageTpl, $parse);

		display ($Page, $lang['addm_title'], false, '', true);
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