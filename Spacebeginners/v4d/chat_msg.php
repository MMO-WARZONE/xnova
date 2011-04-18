<?php

/**
 * chat_msg.php
 *
 * @version 1.1
 * @copyright 2009 by Slaver & Sycrog & Team Space Beginners for XNova-Reloaded
 */

define('INSIDE'  , true);
define('INSTALL' , false);


require_once('common.php');

// On efface les anciens messages
$timemoment = time();
$time_1h = $timemoment - 3600;

// A verifier si ca marche
$countMax = doquery("SELECT count(messageid) as num FROM {{table}}", "chat", true); 
$countMin = ($countMax['num'] - 26);

if($countMax['num'] >= 26)
  $query = doquery("SELECT a.messageid, a.user, a.message, a.timestamp, b.authlevel FROM {{table}}chat as a, {{table}}users as b WHERE b.username = a.user ORDER BY messageid ASC LIMIT ".$countMin." ,".$countMax['num'].";", "");
else
  $query = doquery("SELECT a.messageid, a.user, a.message, a.timestamp, b.authlevel FROM {{table}}chat as a, {{table}}users as b WHERE b.username = a.user ORDER BY messageid ASC;", "");

    //Fix  jeattrno1  
    while($v=mysql_fetch_object($query)){ 
    $nick=htmlentities(utf8_decode($v->user)); 
    $msg=htmlentities(utf8_decode($v->message));
    $timestamp = htmlentities(utf8_decode($v->timestamp));
    //Fix Ende
    
    // Schimpfwortfilter
    $badwords  =  array( 'ficken', 'fick dich', 'penner','arsch' ,'Arsch','hurrensohn', 'arschloch', '', 'wixxer', 'wichser', 'schlampe', 'nutte', 'hure', 'hurre', 'verpiss dich', 'fuck', 'asshole', 'slut', 'bitch', 'bastard', 'fotze', 'anal', 'arschgeige', 'vollidiot', 'pimmel', 'penis', 'hackfresse', 'arschgeburt', 'fickschlitz', 'dönergesicht', 'scheiß', 'hodenkobolt', 'evolutionsbremse', 'fettgondel', 'fettsack', 'puff', 'fickfehler', 'mistgeburt', 'pimmelbär', 'schamhaarschdel', 'telefongesicht', 'kack', 'spaßt', 'spasst', 'kotnascher', 'gesichtsbaracke', 'pimpf', 'spermarutsche', 'steckdosenbefruchter', 'homo-fürst', 'affenschädel', 'sieg heil', 'heil hitler', 'hodenknecht', 'fotzenhobler', 'flaschenficker', 'badehaubenduscher', 'analkugel', 'pissfotze', 'pimmelpony', 'analgeneral', 'koksnutte', 'pissnelke', 'laternenficker', 'penisgarage', 'bumsbrötchen', 'penisgarage', 'bumbsbrötchen', 'omificker', 'omaficker', 'wichspfosten', 'vollpfosten', 'spermagurgler', 'wichsfresse', 'hackfresse', 'berufsnutte', 'umsbalken','schei&szlig;' , 'fickstück', 'scheiss','ogame', 'ogame-klon', 'ogame-clon');
    $msg       =  str_replace($badwords, "*zensiert*", $msg);
    
    // Schriftarten
    $msg=preg_replace("#\[a=(ft|https?://)(.+)\](.+)\[/a\]#isU", "<a href=\"$1$2\" target=\"_blank\">$3</a>", $msg);
    $msg=preg_replace("#\[b\](.+)\[/b\]#isU","<b>$1</b>",$msg);
    $msg=preg_replace("#\[i\](.+)\[/i\]#isU","<i>$1</i>",$msg);
    $msg=preg_replace("#\[u\](.+)\[/u\]#isU","<u>$1</u>",$msg);
    $msg=preg_replace("#\[c=(blue|yellow|green|pink|red|orange)\](.+)\[/c\]#isU","<font color=\"$1\">$2</font>",$msg);

    // Smileys
    $msg=preg_replace("#:c#isU","<img src=\"images/smileys/cry.gif\" align=\"absmiddle\" title=\":c\" alt=\":c\">",$msg);
    //Link-Fix
    $msg=preg_replace("#:/#isU","<img src=\"images/smileys/confused.gif\" align=\"absmiddle\" title=\":/\" alt=\":/\">",$msg);
    $msg=preg_replace("#o0#isU","<img src=\"images/smileys/dizzy.gif\" align=\"absmiddle\" title=\"o0\" alt=\"o0\">",$msg);
    $msg=preg_replace("#\^\^#isU","<img src=\"images/smileys/happy.gif\" align=\"absmiddle\" title=\"^^\" alt=\"^^\">",$msg);
    $msg=preg_replace("#:D#isU","<img src=\"images/smileys/lol.gif\" align=\"absmiddle\" title=\":D\" alt=\":D\">",$msg);
    $msg=preg_replace("#:\|#isU","<img src=\"images/smileys/neutral.gif\" align=\"absmiddle\" title=\":|\" alt=\":|\">",$msg);
    $msg=preg_replace("#:\)#isU","<img src=\"images/smileys/smile.gif\" align=\"absmiddle\" title=\":)\" alt=\":)\">",$msg);
    $msg=preg_replace("#:o#isU","<img src=\"images/smileys/omg.gif\" align=\"absmiddle\" title=\":o\" alt=\":o\">",$msg);
    $msg=preg_replace("#:p#isU","<img src=\"images/smileys/tongue.gif\" align=\"absmiddle\" title=\":p\" alt=\":p\">",$msg);
    $msg=preg_replace("#:\(#isU","<img src=\"images/smileys/sad.gif\" align=\"absmiddle\" title=\":(\" alt=\":(\">",$msg);
    $msg=preg_replace("#;\)#isU","<img src=\"images/smileys/wink.gif\" align=\"absmiddle\" title=\";)\" alt=\";)\">",$msg);
    $msg=preg_replace("#:\T#isU","<img src=\"images/smileys/dance.gif\" align=\"absmiddle\" title=\":T\" alt=\":T\">",$msg);
    $msg=preg_replace("#:s#isU","<img src=\"images/smileys/shit.gif\" align=\"absmiddle\" title=\":s\" alt=\":s\">",$msg);
    $msg=preg_replace("#xnova#","<a href=\"http://spacebeginner.de/forum/index.php\">Spacebeginner</a>",$msg);
    
    #-  Datum & Uhrzeit  -#
    $time = date("[d/m H:i:s]" ,$timestamp);
    
    switch($v->authlevel){
        case 3:
            $Color = red;
            $rank = "Admin ";
        break;
        case 2:
            $Color = orange;
            $rank = "SGO ";
        break;
        case 1:
            $Color = yellow;
            $rank = "GO ";
        break;
        default:
            $Color = white;
            $rank = "";
        break;
    }

                                                                                                                                                                                                                                                      
    $msg = "<div align=\"left\" style='color:white;'><span style='font:menu;'>".$time."</span> <span style='width:50px;font:menu;'><b><a href='#' onmousedown=\"addSmiley('[ ".$nick." ]')\" style='color:".$Color."'>".$rank.$nick."</a></b></span> : <font face=\"Georgia\" size=\"2\"font color=\"white\">&nbsp;".$msg."</font><br></div>\n";
    print stripslashes($msg);
}

// Shoutbox by e-Zobar - Copyright XNova Team 2008
// Überarbeitet by Sycrog
// Fixed by Slaver 14.11.09 01:38 +02

?>