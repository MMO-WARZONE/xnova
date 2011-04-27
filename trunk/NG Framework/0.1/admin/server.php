<?php
/**
 * @author gianluca311
 * 
 * @package XNova
 * @version 1.0
 * @copyright (c) 2008 XNova Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

// blocking non-users
if ($IsUserChecked == false) {
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

if ($user['authlevel'] == 3)
{
		includeLang('admin/server');
		
		$pagetpl = gettemplate("admin/server");
		$parse   = $lang;
		
		$parse['server_ip']   = $_SERVER['SERVER_ADDR'];
		$parse['serversoft']  = $_SERVER['SERVER_SOFTWARE'];
		$parse['server_os']   = $_ENV['OS'];
		$parse['php']         = phpversion();
		
		$page = parsetemplate($pagetpl, $parse);
		
		display($page, $lang['server_information'], false, '', true);
}
else
{
		AdminMessage($lang['sys_noalloaw'], $lang['sys_noaccess']);
}

?>