<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$InLogin = false;

$XNova_Host    = $_SERVER['HTTP_HOST'];
$XNova_Script  = $_SERVER['SCRIPT_NAME'];
$Uri_Array     = explode ('/', $XNova_Script);
// The script
array_pop($Uri_Array);
$XNova_URI     = implode ('/', $Uri_Array);

$XNovaRootURL  = "http://". $XNova_Host ."/". $XNova_URI ."/";

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

	$page  = "<html>";
	$page .= "<head>";
	$page .= "<meta http-equiv=\"Content-Type\" content=\"text/html;charset=". $langInfos['ENCODING']."\">";
	$page .= "<meta name=\"description\" content=\"Rogue Universe browsergame\">";
	$page .= "<meta name=\"keywords\" content=\"free web game,gratis webbspel,webbspel,web game,free game,gratis spel,gratis,free,rogue,universe,rogue universe,webbrowser game,web browser game,rymdspel,spacegame,rymd spel,space game,webbased game,webbaserat spel,webbläsarspel,webbrowser,webbläsare\">";
	$page .= "<link rel=\"shortcut icon\" href=\"favicon.ico\" >";
      $page .= "<link rel=\"icon\" href=\"favicon.gif\" type=\"image/gif\" >";
	$page .= "<title>". $game_config['game_name'] ."</title>";
	$page .= "</head>";
	$page .= "<frameset framespacing=\"0\" border=\"0\" cols=\"190,*\" frameborder=\"0\">";
	$page .= "<body>";
	$page .= "<frame name=\"LeftMenu\" target=\"Mainframe\" src=\"leftmenu.php\" noresize scrolling=\"no\" marginwidth=\"0\" marginheight=\"0\">";
	$page .= "<frame name=\"Hauptframe\" src=\"overview.php\" noresize scrolling=\"auto\">";
	$page .= "<noframes>";
	$page .= "<p>". $lang['NoFrames']."</p>";
	$page .= "</noframes>";
	$page .= "</frameset>";

	$page .= "</body>";
	$page .= "</html>";

	echo $page;
/*
header("Location: ./overview.php");
*/
?>