<?php
/*
voir_vente_ressources.php

 version 2.0
 modificado por bonyy

 @copyright 2009 by Nain Pitoyable pour AideXnova
*/
//mise en page
$page2 = "<HTML><div id=\"content\">
<center>
<table width='600'>
<td class='c'>Menú Comercial</td></table>
<br>
{$pageHeader}
<br><br>";

$page2 .= "
<table width=\"600\">
<td class=\"c\" colspan=\"10\"><font color=\"#FFFFFF\">Anuncios de Recursos</font></td></tr>
<tr><th colspan=\"3\">Infos de entrega</th><th colspan=\"3\">Recursos en venta</th><th colspan=\"3\">Recursos deseados</th><th>Acción</th></tr>
<tr><th>Vendedor</th><th>Galaxia</th><th>Sistema</th><th>Metal</th><th>Cristal</th><th>Deuterio</th><th>Metal</th><th>Cristal</th><th>Deuterio</th><th>Eliminar</th></tr>";

//select des annonces ressources

$Annonce1 = doquery("SELECT * FROM {{table}} WHERE `type`='0' ORDER BY `id` DESC ", "annonce");

while ($b = mysql_fetch_assoc($Annonce1)) {

//petit tableau

$page2 .= '<tr>';
$page2 .= '<th>'.$b['user'].'</th>';
$page2 .= '<th>'.$b['galaxie'].'</th>';
$page2 .= '<th>'.$b['systeme'].'</th>';
$page2 .= '<th>'.number_format($b['metala']).'</th>';
$page2 .= '<th>'.number_format($b['cristala']).'</th>';
$page2 .= '<th>'.number_format($b['deuta']).'</th>';
$page2 .= '<th>'.number_format($b['metals']).'</th>';
$page2 .= '<th>'.number_format($b['cristals']).'</th>';
$page2 .= '<th>'.number_format($b['deuts']).'</th>';

//si le joueur a des annonces a lui, on lui met un lien pour effacer

if ($b['user'] == $user['username']){
$page2 .='<th><a href="game.php?page=annonce&action=12&id='.$b['id'].'">Eliminar</a></th>';}
}
display($page2);

break;

 ?>