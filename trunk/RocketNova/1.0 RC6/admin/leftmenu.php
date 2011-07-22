<?PHP

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = './../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.'.$phpEx);

includeLang('leftmenu');

	if ($user['authlevel'] == "1") {
      $parse                 = $lang;
      $parse['mf']           = "Hauptframe";
      $parse['dpath']        = $dpath;
      $parse['XNovaRelease'] = VERSION;
      $parse['servername']   = RocketNova;
      $Page                  = parsetemplate(gettemplate('admin/left_menu_mod'), $parse);
      display( $Page, "", false, '', true);
   }
	elseif ($user['authlevel'] == "2") {
      $parse                 = $lang;
      $parse['mf']           = "Hauptframe";
      $parse['dpath']        = $dpath;
      $parse['XNovaRelease'] = VERSION;
      $parse['servername']   = RocketNova;
      $Page                  = parsetemplate(gettemplate('admin/left_menu_go'), $parse);
      display( $Page, "", false, '', true);
   }
	elseif ($user['authlevel'] == "3") {
      $parse                 = $lang;
      $parse['mf']           = "Hauptframe";
      $parse['dpath']        = $dpath;
      $parse['XNovaRelease'] = VERSION;
      $parse['servername']   = RocketNova;
      $Page                  = parsetemplate(gettemplate('admin/left_menu_sgo'), $parse);
      display( $Page, "", false, '', true);
   }
	elseif ($user['authlevel'] == "4") {
      $parse                 = $lang;
      $parse['mf']           = "Hauptframe";
      $parse['dpath']        = $dpath;
      $parse['XNovaRelease'] = VERSION;
      $parse['servername']   = RocketNova;
      $Page                  = parsetemplate(gettemplate('admin/left_menu'), $parse);
      display( $Page, "", false, '', true);

	} else {
		message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
	}
?>