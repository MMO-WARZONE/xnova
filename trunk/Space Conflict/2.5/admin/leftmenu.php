<?PHP

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** leftmenu.php                          **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

includeLang('leftmenu');

	if ($user['authlevel'] >= "1") {
		$parse                 = $lang;
		$parse['mf']           = "Hauptframe";
		$parse['dpath']        = $dpath;
		$parse['XNovaRelease'] = VERSION;
		$parse['servername']   = XNova;
		$Page                  = parsetemplate(gettemplate('admin/left_menu'), $parse);
		display( $Page, "", false, '', true);
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