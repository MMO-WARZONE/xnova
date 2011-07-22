<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$InLogin = false;

$XNova_Host    = $_SERVER['HTTP_HOST'];
$XNova_Script  = $_SERVER['SCRIPT_NAME'];
$Uri_Array     = explode('/', $XNova_Script);

array_pop($Uri_Array);
$XNova_URI     = implode('/', $Uri_Array);

$XNovaRootURL  = "http://". $XNova_Host ."/". $XNova_URI ."/";

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.'.$phpEx);

if (!$IsUserChecked)
{ 
    header('Location: index.php'); 
    die();
}

$parse = $lang;
$parse['ENCODING']  = $langInfos['ENCODING'];
$parse['game_name'] = $game_config['game_name'];

$template = gettemplate('frames');
$html = parsetemplate($template, $parse);
echo $html;

?>