<?php
/*
voir_vente_defense.php

 version 2.0
 modificado por bonyy

 @copyright 2009 by Nain Pitoyable pour AideXnova
*/
//mise ne page
$page2 .="<HTML><div id=\"content\">
<center>
<table width='600'>
<td class='c'>Menú Comercial</td></table>
<br>
{$pageHeader}
<br><br>

<table width=\"600\">
<td class=\"c\" colspan=\"11\"><font color=\"#FFFFFF\">Mis Anuncios</font></td></tr>
<tr><th colspan=\"3\">Infos de entrega</th><th colspan=\"2\">Defensa a vender</th><th colspan=\"3\">Recursos deseados</th><th colspan=\"2\">Info tasas</th><th>Acción</th></tr>
<tr><th>Vendedor</th><th>Galaxia</th><th>Sistema</th><th>Defensas</th><th>Cantidad</th><th>Metal</th><th>Cristal</th><th>Deuterio</th><th>Precio nuevo</th><th>Precio venta</th><th>-</th></tr>";

//on select les annonces a voir (defense)

$MesAnnoncesFlotte = doquery("SELECT * FROM {{table}} WHERE `user`='{$user['username']}' AND type ='4' ORDER BY `id` DESC ", "annonce");
while ($b = mysql_fetch_array($MesAnnoncesFlotte)) {

//pour l'image

$Image = $b['defense'];

//prix neuf

$PrixNeuf = $b['nombredefense'] * ($pricelist[$b['defense']]['metal']+$pricelist[$b['defense']]['crystal']+$pricelist[$b['defense']]['deuterium']);

//mise en forme du tableau

$page2 .= '<tr>';
$page2 .= '<th>'.$b['user'].'</th>';
$page2 .= '<th>'.$b['galaxie'].'</th>';
$page2 .= '<th>'.$b['systeme'].'</th>';
$page2 .= '<th><img src="'.$dpath.'gebaeude/'.$Image.'.gif" style="width: 50px; height: 50px;" title="'.$lang['tech'][$b['defense']].'" /></th>';
$page2 .= '<th>'.number_format($b['nombredefense']).'</th>';
$page2 .= '<th>'.number_format($b['metals']).'</th>';
$page2 .= '<th>'.number_format($b['cristals']).'</th>';
$page2 .= '<th>'.number_format($b['deuts']).'</th>';
$page2 .= '<th>'.number_format($PrixNeuf).'</th>';
$page2 .= '<th>'.number_format($b['deuts']+$b['cristals']+$b['metals']).'</th>';

//si le mec qui regarde la page a des annonces a lui, on lui permet de les effacer

if ($b['user'] == $user['username']){

$Action ="<a href=\"game.php?page=annonce&action=12&id={$b[id]}\">Eliminar</a>";}

$page2 .="<th>".$Action."</th>";
}
//fin de tableau avec lien ajouter une annonce

$page2 .= "<tr><th colspan=\"10\" align=\"center\"><a href=\"game.php?page=annonce&action=5\">Añadir un anuncio de defensas</a></th></tr>
</td>
</table></div>
</HTML>";

display($page2);
break;

 ?>