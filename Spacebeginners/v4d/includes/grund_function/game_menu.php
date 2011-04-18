<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$InLogin = false;

$XNova_Host    = $_SERVER['HTTP_HOST'];
$XNova_Script  = $_SERVER['SCRIPT_NAME'];
$Uri_Array     = explode ('/', $XNova_Script);

array_pop($Uri_Array);
$XNova_URI     = implode ('/', $Uri_Array);

$XNovaRootURL  = "http://". $XNova_Host ."/". $XNova_URI ."/";

global  $game_config, $user;

if ($game_config['game_disable'] == 1){
    echo $game_config['close_reason'];
}else{
    $page  = "

    <!DOCTYPE HTML PUBLIC '-//W3C//DTD HTML 4.01 Frameset//EN' 'http://www.w3.org/TR/html4/frameset.dtd'>

    <html>
    <head>

    <link rel='shortcut icon' href='favicon.ico'>

    <meta http-equiv='Content-Type' content='text/html; charset=utf-8'>

    <title>". $game_config['game_name'] ."</title>

    </head>

    <frameset>
        <frame name='Hauptframe' src='overview.php' scrolling='auto' marginwidth='0' marginheight='0' >

        <noframes>
           <body>
           <p>&nbsp;". $lang['NoFrames']."</p>
           </body>
        </noframes>

    </frameset>

    </html>

    "; echo $page;
}

?>