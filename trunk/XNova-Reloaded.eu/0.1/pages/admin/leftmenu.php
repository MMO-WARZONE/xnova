<?PHP

/**
 * leftmenu.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);


function ShowAdminMenu ($Level) {
	global $lang, $dpath;
includeLang('leftmenu');

	if ($Level == "1") {
      $parse                 = $lang;
      $parse['dpath']        = $dpath;
      $parse['XNovaRelease'] = VERSION;
      $parse['servername']   = XNova;
      $Page                  = parsetemplate(gettemplate('admin/left_menu_go'), $parse);
      
   }
	elseif ($Level == "2") {
      $parse                 = $lang;
      $parse['mf']           = "Hauptframe";
      $parse['dpath']        = $dpath;
      $parse['XNovaRelease'] = VERSION;
      $parse['servername']   = XNova;
      $Page                  = parsetemplate(gettemplate('admin/left_menu_sgo'), $parse);
     
   }
	elseif ($Level >= "3") {
      $parse                 = $lang;
      $parse['mf']           = "Hauptframe";
      $parse['dpath']        = $dpath;
      $parse['XNovaRelease'] = VERSION;
      $parse['servername']   = XNova;
      $Page                  = parsetemplate(gettemplate('admin/left_menu_admin'), $parse);
      
	} else {
		header('Location: indexGame.php'); 
	}
	return $Page;
}
?>