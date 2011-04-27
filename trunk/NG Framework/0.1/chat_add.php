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

// blocking non-users
if ($IsUserChecked == false)
{
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

// One recovers information of the message and the sender
if (isset($_POST['msg']) && isset($user['username']))
{
	$nick = trim(str_replace('+', 'plus', $user['username']));
	$msg  = trim(str_replace('+', 'plus', $_POST['msg']));
	//$msg  = addslashes($_POST['msg']);
	//$nick = addslashes($user['username']);
}
else
{
	$msg = '';
	$nick = '';
}

// Addition of the message in the database
if ($msg != '' && $nick != '')
{
	$query = doquery("INSERT INTO {{table}} (user, message, timestamp) VALUES ('".mysql_escape_string($nick)."', '".mysql_escape_string($msg)."', '".time()."')", "chat");
}

?>
