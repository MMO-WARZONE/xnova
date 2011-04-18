<?php

/**
 * logout.php
 * 
 * @version 1.0 
 * @copyright 2008 by Dr.Isaacs für XNova-Germany
 */ 

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

$InLogin == false;

    includeLang('logout');

    setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);

    header("location: index.php"); 

    message ( $lang['see_you']."<br><a href='index.php'>Zur&uuml;ck zum Login</a>", $lang['session_closed'], "index.".$phpEx );



?>