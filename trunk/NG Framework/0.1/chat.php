<?php
/**
 * Shoutbox
 * @author e-Zobar
 * 
 * @package XNova
 * @version 1.0
 * @copyright (c) 2008 XNova Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	//comprobación ESTADO modulo
	$query = doquery("SELECT estado FROM {{table}} where modulo='Chat'", 'modulos', true); //Sacamos el estado.
	if($query[0] == "0") { message("Modulo Inactivo.","Modulo Inactivo"); }
	//Fin comprobación
	
// blocking non-users
if ($IsUserChecked == false)
{
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

includeLang('chat');
$body = gettemplate('chat_body');

$nick  = $user['username'];
$parse = $lang;

$page = parsetemplate($body, $parse);
display($page, $lang['Chat'], false);

?>

