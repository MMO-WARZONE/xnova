<?php
//version 1

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);
$InLogin = false;
$svn_root = './';
include($svn_root . 'extension.inc.php');
include($svn_root . 'common.' . $phpEx);

$user=$users->user;
$game_config=$db->game_config;

if($user['authlevel']>=1){
switch($_GET[page])
{
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'activeplanet':
		include_once($svn_root . 'includes/pages/admin/ShowActivePlanetAdmin.' . $phpEx);
		ShowActivePlanetAdmin($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'search':
		include_once($svn_root . 'includes/pages/admin/ShowSearchAdmin.' . $phpEx);
		ShowSearchAdmin($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'createuser':
		include_once($svn_root . 'includes/pages/admin/ShowCreateUserAdmin.' . $phpEx);
		ShowCreateUserAdmin($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'configemail':
		include_once($svn_root . 'includes/pages/admin/ShowConfigEmailAdmin.' . $phpEx);
		ShowConfigEmailAdmin($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'banned':
		include_once($svn_root . 'includes/pages/admin/ShowBannedAdmin.' . $phpEx);
		ShowBannedAdmin($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'changepass':
		include_once($svn_root . 'includes/pages/admin/ShowChangePassAdmin.' . $phpEx);
		ShowChangePassAdmin($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'errors':
		include_once($svn_root . 'includes/pages/admin/ShowErrorsAdmin.' . $phpEx);
		ShowErrorsAdmin($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'support':
		include_once($svn_root . 'includes/pages/admin/ShowSupportAdmin.' . $phpEx);
		ShowSupportAdmin($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'statbuilder':
		include_once($svn_root . 'includes/pages/admin/ShowStatbuilderAdmin.' . $phpEx);
		ShowStatbuilderAdmin($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'userlist':
		include_once($svn_root . 'includes/pages/admin/ShowUserlistAdmin.' . $phpEx);
		ShowUserlistAdmin($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'overview':
		include_once($svn_root . 'includes/pages/admin/ShowOverviewAdmin.' . $phpEx);
		ShowOverviewAdmin($user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'settings':
		include_once($svn_root . 'includes/pages/admin/ShowSettingAdmin.' . $phpEx);
		ShowSettingAdmin($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'encripter':
		include_once($svn_root . 'includes/pages/admin/ShowEncripterAdmin.' . $phpEx);
		ShowEncripterAdmin($users->user);
	break;

// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'flyingfleets':
		include_once($svn_root . 'includes/pages/admin/ShowFleetAdmin.' . $phpEx);
		ShowFleetAdmin($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'onlineusers':
		include_once($svn_root . 'includes/pages/admin/ShowOnlineUsersAdmin.' . $phpEx);
		 ShowOnlineUsersAdmin($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'moonopt':
		include_once($svn_root . 'includes/pages/admin/ShowMoonOptAdmin.' . $phpEx);
		ShowMoonOptAdmin($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'moonopt':
		include_once($svn_root . 'includes/pages/admin/ShowMoonOptAdmin.' . $phpEx);
		ShowMoonOptAdmin($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'planetlist':
		include_once($svn_root . 'includes/pages/admin/ShowPlanetlistAdmin.' . $phpEx);
		ShowPlanetlistAdmin($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'configstat':
		include_once($svn_root . 'includes/pages/admin/ShowConfigstatAdmin.' . $phpEx);
		ShowConfigstatAdmin($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'messagelist':
		include_once($svn_root . 'includes/pages/admin/ShowMessagelistAdmin.' . $phpEx);
		ShowMessagelistAdmin($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'messall':
		include_once($svn_root . 'includes/pages/admin/ShowMessallAdmin.' . $phpEx);
		ShowMessallAdmin($users->user);
        break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'moonlist':
		include_once($svn_root . 'includes/pages/admin/ShowMoonlistAdmin.' . $phpEx);
		ShowMoonlistAdmin($users->user);
	break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'optimicedb':
		include_once($svn_root . 'includes/pages/admin/ShowControldbAdmin.' . $phpEx);
		ShowControldbAdmin($users->user);
        break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'resetuni':
		include_once($svn_root . 'includes/pages/admin/ShowResetAdmin.' . $phpEx);
		ShowResetAdmin($users->user);
        break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'plugins':
		include_once($svn_root . 'includes/functions/classes/class.plugins.' . $phpEx);
                $plugin->admin_page_plugin();
        break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
	case'log':
		include_once($svn_root . 'includes/pages/admin/ShowLogAdmin.' . $phpEx);
		ShowLogAdmin($users->user);
        break;


// ------------------EN FASE DE PRUEBAS---------------------------------------------------------------------------//
	case'news':
		include_once($svn_root . 'includes/pages/admin/ShowNewsAdmin.' . $phpEx);
		ShowNewsAdmin($users->user);
        break;


// ----------------------------------------------------------------------------------------------------------------------------------------------//
	default:
                $plugin->is_plugins($_GET["page"]) ? '':$displays->message($lang['page_doesnt_exist']);
        break;
// ----------------------------------------------------------------------------------------------------------------------------------------------//
}
}else{
    $_SERVER["PHP_SELF"]="BLOQUEADO";
    die("<div id='contentadmin'>".$displays->message($lang['not_enough_permissions'],"game.php?page=overview",3,false,false)."</div>");
}

?>