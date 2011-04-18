<?php

/**
 * banned.php
 *
 * @version 1.0
 * @copyright 2008 by ??????? for XNova
 */
 
includeLang('banned');

$parse = $lang;
$parse['dpath'] = $dpath;
$parse['mf'] = $mf;


$i=0;
foreach($DB->query("SELECT * FROM ".PREFIX."banned ORDER BY `id`") as $u){
	$parse['banned'] .=
        "<tr><td class=b><center><b>".$u[1]."</center></td></b>".
	"<td class=b><center><b>".gmdate("d/m/Y G:i:s",$u[4])."</center></b></td>".
	"<td class=b><center><b>".gmdate("d/m/Y G:i:s",$u[5])."</center></b></td>".
	"<td class=b><center><b>".$u[2]."</center></b></td>".
	"<td class=b><center><b>".$u[6]."</center></b></td></tr>";
	$i++;
}

if ($i=="0")
 $parse['banned'] .= "<tr><th class=b colspan=6>Noch kein Spieler Gesperrt</th></tr>";
else
  $parse['banned'] .= "<tr><th class=b colspan=6>Es sind {$i} Spieler Gesperrt</th></tr>";

display(parsetemplate(gettemplate('banned_body'), $parse), 'Banned');

// Created by e-Zobar (XNova Team). All rights reversed (C) 2008
?>