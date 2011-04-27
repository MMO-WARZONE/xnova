<?php
/**
 * @author Perberos perberos@gmail.com
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
include($ugamela_root_path . 'common.'.$phpEx);

includeLang('logout');

unset($_SESSION[USER_SESSION]);

message($lang['see_you'], $lang['session_closed'], "login.".$phpEx);

?>