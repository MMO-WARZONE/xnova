<?php

/**
 * annonce.php
 *
 * @version 1.4
 * Neue Version
 * @copyright 2008 by Mwieners for XNova-Germany
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

$users   = doquery("SELECT * FROM {{table}} WHERE id='".$user['id']."';", 'users');
$annonce = doquery("SELECT * FROM {{table}} ", 'annonce');
$action  = $_GET['action'];

if ($action == 5) {
    $metalvendre = intval($_POST['metalvendre']);
    $cristalvendre = intval($_POST['cristalvendre']);
    $deutvendre = intval($_POST['deutvendre']);

    $metalsouhait = intval($_POST['metalsouhait']);
    $cristalsouhait = intval($_POST['cristalsouhait']);
    $deutsouhait = intval($_POST['deutsouhait']);

    while ($v_annonce = mysql_fetch_array($users)) {
        $user = mysql_real_escape_string($v_annonce['username']);
        $iduser = intval($v_annonce['id']);
        $galaxie = intval($v_annonce['galaxy']);
        $systeme = intval($v_annonce['system']);
    }

    doquery("INSERT INTO {{table}} SET
user='{$user}',
iduser='{$iduser}',
galaxie='{$galaxie}',
systeme='{$systeme}',
metala='{$metalvendre}',
cristala='{$cristalvendre}',
deuta='{$deutvendre}',
metals='{$metalsouhait}',
cristals='{$cristalsouhait}',
deuts='{$deutsouhait}'" , "annonce");

    $page2 .="<center>
<br>
<p>Ihre Anzeige wurde gespeichert !</p>
<br><p><a href=\"annonce.php\">Zur&uuml;ck zur Anzeigen</a></p>";

    display($page2);
}elseif (!$action) {
    $annonce = doquery("SELECT * FROM {{table}} ORDER BY `id` DESC ", "annonce");

    $page2 = "<center>
<br>
<table width=\"600\">
<td class=\"c\" colspan=\"11\"><font color=\"#FFFFFF\">Kleinanzeigen f&uuml;r Rohstoff Handel</font></td></tr>
<tr><th colspan=\"3\">Infos Lieferungen</th><th colspan=\"3\">Rohstoffe zu Bieten</th><th colspan=\"3\">Rohstoffe Ben&ouml;tigt</th><th>Aktion</th></tr>
<tr><th>Spieler</th><th>Galaxie</th><th>System</th><th>Metall</th><th>Kristall</th><th>Deuterium</th><th>Metall</th><th>Kristall</th><th>Deuterium</th><th>&nbsp;</th></tr>


";
    while ($b = mysql_fetch_array($annonce)) {
        $page2 .= '<tr><th> ';
        $page2 .= $b["user"] ;
        $page2 .= '</th><th>';
        $page2 .= $b["galaxie"];
        $page2 .= '</th><th>';
        $page2 .= $b["systeme"];
        $page2 .= '</th><th>';
        $page2 .= $b["metala"];
        $page2 .= '</th><th>';
        $page2 .= $b["cristala"];
        $page2 .= '</th><th>';
        $page2 .= $b["deuta"];
        $page2 .= '</th><th>';
        $page2 .= $b["metals"];
        $page2 .= '</th><th>';
        $page2 .= $b["cristals"];
        $page2 .= '</th><th>';
        $page2 .= $b["deuts"];
        $page2 .= '</th><th>';
        if($b['user'] == $user['username']){
        $page2 .= "<a href=\"annonce.php?action=del&id=".$b['id']."\">L&ouml;schen</a>";
        }else{
        $page2 .= "<a href=\"messages.php?mode=write&id=".$b['iduser']."\">Kontakt</a>";
        }
        $page2 .= "</th></tr>";
    }

    $page2 .= "
<tr><th colspan=\"10\" align=\"center\"><a href=\"annonce2.php?action=2\">Anzeige erstellen</a></th></tr>
</td>
</table>";

    display($page2);
}elseif($action == 'del'){
    $page2 = "<center><br><table width=\"600\"><td class=\"c\" colspan=\"10\"><font color=\"#FFFFFF\">Anzeige l&ouml;schen?</font></td></tr><tr><th colspan=\"3\">Bist du sicher?</th></tr><tr><th colspan=\"10\" align=\"center\"><a href=\"annonce.php?action=delja&id=". $_GET['id'] ."\">Ja</a> -- <a href=\"annonce.php\">Nein</a></th></tr></td></table>";
display($page2);
}elseif($action == 'delja'){
doquery("DELETE FROM `{{table}}` WHERE `id` = ". intval($_GET['id']) ." AND `user` = '". $user['username'] ."' LIMIT 1", 'annonce');
message("Nachricht gel&ouml;scht", "Ok");
}

// Créer par Tom1991 Copyright 2008
// Merci au site Spacon pour m'avoir donner l'inspiration
?>