<?php

/**
 * banned.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);


includeLang('banned');


if ($IsUserChecked == false) {
   includeLang('fehler');
   message($lang['check01'], $lang['check02']);
}

if ($user['urlaubs_modus'] == 1){
   includeLang('fehler');
   message($lang['Urlaub01'], $lang['Urlaub02']);
}

$parse = $lang;
$parse['dpath'] = $dpath;
$parse['mf'] = $mf;


$query = doquery("SELECT * FROM {{table}} ORDER BY `id`;",'banned');
$i=0;
while($u = mysql_fetch_array($query)){
        $parse['banned'] .=
        "<tr><td class=b><center><b>".$u[1]."</center></td></b>".
        "<td class=b><center><b>".$u[2]."</center></b></td>".
        "<td class=b><center><b>".date("d/m/Y G:i:s",$u[4])."</center></b></td>".
        "<td class=b><center><b>".date("d/m/Y G:i:s",$u[5])."</center></b></td>".
        "<td class=b><center><b>".$u[6]."</center></b></td></tr>";
        $i++;
}

if ($i=="0")
 $parse['banned'] .= "<th class\=b\" colspan=\"6\">". $lang['ban_no_user'] ."</tr>"; 
else
  $parse['banned'] .= "<th class\=b\" colspan=\"6\">". $lang['ban_a'] ." ". $i ." ". $lang['ban_players'] ."</tr>";

display(parsetemplate(gettemplate('banned_body'), $parse),'Banned',true);


// Created by e-Zobar (XNova Team). All rights reversed (C) 2008
?>