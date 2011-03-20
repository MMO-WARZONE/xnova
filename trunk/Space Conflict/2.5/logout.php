<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** logout.php                            **
******************************************/
header('Location:http://www.spaceconflict.200gigs.com');
    $f = fopen('demo.txt','w+');
    fwrite($f,'Test');
    fclose($f);

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

	includeLang('logout');

	setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);

	message ( $lang['see_you'], $lang['session_closed'], "<u><a href=index.php>back to login page</a></u>");

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>