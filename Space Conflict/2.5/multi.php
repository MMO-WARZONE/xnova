<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** multi.php                             **
******************************************/

define('INSIDE' , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

includeLang('messages');
includeLang('system');

$Mode = $_GET['mode'];

if ($Mode != 'add') {
    $parse['Declaration']     = $lang['Declaration'];
    $parse['DeclarationText'] = $lang['DeclarationText'];
    $page = parsetemplate(gettemplate('multi'), $parse);
    display($page, $lang['messages']);
}

if ($mode == 'add') {
    $Texte = $_POST['texte'];
    $Joueur = $user['username'];
    $SQLAjoutDeclaration = "INSERT INTO {{table}} SET ";
    $SQLAjoutDeclaration .= "`player` = '". $Joueur ."', ";
	$SQLAjoutDeclaration .= "`text` = '". $Texte ."';";
    doquery($SQLAjoutDeclaration, 'multi');

    message($lang['sys_request_ok'],$lang['sys_ok']);
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>