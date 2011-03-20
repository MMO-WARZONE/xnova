<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xnova_root_path = './../';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);
global $Adminerlaubt, $lang;


if ( $user['authlevel'] >= 1 and in_array ($user['id'],$Adminerlaubt) ) {

            $page  = "

    <!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Frameset//EN' 'http://www.w3.org/TR/html4/frameset.dtd'>

    <html>
    <head>

    <link rel='shortcut icon' href='favicon.ico'>

    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

    <title>". $game_config['game_name'] ."</title>

    </head>
        <frameset cols=\"180,*\" frameborder=\"no\" border=\"0\" framespacing=\"0\">
        <frame src=\"menu.php\" name=\"rightFrame\" id=\"rightFrame\"/>
        <frameset rows=\"61,*\" frameborder=\"no\" border=\"0\" framespacing=\"0\">
        <frame src=\"topnav.php\" name=\"topFrame\" scrolling=\"No\" noresize=\"noresize\" id=\"topFrame\"/>
        <frame src=\"overview.php\" name=\"Hauptframe\" scrolling=\"yes\" noresize=\"noresize\" id=\"mainFrame\"/>
        </frameset>

        <noframes>
           <body>
           <p>". $lang['NoFrames']."</p>
           </body>
        </noframes>

    </frameset>

    </html>

    ";
    echo $page;


 }else{

print $lang['not_enough_permissions'];
}
?>