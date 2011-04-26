<?php //index.php :: Pagina inicial

{//init
include("common.php");
include("cookies.php");
$userrow = checkcookies();//Identificacion del usuario
if(!$userrow){ header("Location: login.php"); }
}

echo <<<HTML
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset={$lang['ENCODING']}">
<link rel="SHORTCUT ICON" href="favicon.ico">
<title>{$lang['TITLE_GAME']}</title>
</head>
<frameset framespacing="0" border="0" cols="190,*" frameborder="0">
	<frame name="LeftMenu" target="Mainframe" src="leftmenu.php" noresize scrolling="no" marginwidth="0" marginheight="0">
	<frame name="Mainframe" src="overview.php">
	<noframes>
	<body>
	<p>{$lang['NoFrames']}</p>
	</noframes>
</frameset>
</body>
</html>
HTML;

// Created by Perberos. All rights reversed (C) 2006
?>
