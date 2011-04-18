<?PHP

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);
global $Adminerlaubt;

includeLang('admin/ubersicht');

       if ( $user['authlevel'] >= 1 and in_array ($user['id'],$Adminerlaubt) ) {
                $parse                 = $lang;
                $parse['mf']           = "Hauptframe";
                $parse['dpath']        = $dpath;
                $parse['Version'] = $game_config['VERSION'];
                $parse['Name']   = $game_config['game_name'];
                $Page                  = parsetemplate(gettemplate('admin/menu'), $parse);
                display( $Page, "", false, '', true);
        } else {
                message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
        }

?>