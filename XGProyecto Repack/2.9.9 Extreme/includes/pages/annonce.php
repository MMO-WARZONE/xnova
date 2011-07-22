<?php
/*
 annonce.php
 
 version 2.0
 modificado por bonyy

 @copyright 2009 by Nain Pitoyable pour AideXnova
*/

if(!defined('INSIDE')){ die(header("location:../../"));}

function annonce ($user, $planetrow)
{

 global $xgp_root, $phpEx, $game_config, $dpath, $lang, $_POST, $_GET, $planetrow, $user, $resource;

$parse['dpath']        	= $dpath;
// petit select pour affichage
$users = doquery("SELECT `username`,`galaxy`,`system`,`planet` FROM {{table}} WHERE id='".$user['id']."';", 'users',true);

/////////////////////Le menu :)

include('./includes/pages/annonce/menu.php');

/////////////////////Fin Menu

switch($action){

case 1:////////////////////////////////////////on veut vendre des vaisseaux

include('./includes/pages/annonce/vente_vaisseaux.php');

case 2://////////////////////////////////////// voir toutes mes ventes de flottes

include('./includes/pages/annonce/voir_vente_vaisseaux.php');

case 3:////////////////////////////////////////commerce de ressources

include('./includes/pages/annonce/vente_ressources.php');

case 4:////////////////////////////////////////voir toutes mes ventes de ressources

include('./includes/pages/annonce/voir_vente_ressources.php');

case 5:////////////////////////////////////////on veut vendre des defs

include('./includes/pages/annonce/vente_defense.php');

case 6://////////////////////////////////////// voir ses ventes de defenses

include('./includes/pages/annonce/voir_vente_defense.php');

case 7://////////////////////////////////////// mettre une flotte au encheres

include('./includes/pages/annonce/vente_enchere.php');

case 8://////////////////////////////////////// pour pouvoir encherir ou voir les options de l'annonce
 
//select de l'enchere en question:

$Enchere = doquery("SELECT * FROM {{table}}", "annonce");

$Qui = mysql_fetch_array($Enchere);

if($Qui['user'] != $user['username']){ //si le mec qui vois l'enchere n'est pas celui qui l'a posté, on lui donne possibilitée d'encherir

include('./includes/pages/annonce/encherir.php');

}elseif($Qui['user'] == $user['username']){//sinon on affiche les options de l'enchere

include('./includes/pages/annonce/options_encheres.php');

}

display($page2);

break;

case 11://////////////////////////////////////// Validation annonce vaisseau

include('./includes/pages/annonce/verif_vente_vaisseaux.php');

case 12:////////////////////////////////////////Suppression d'annonce

//rien de bien dur^^
doquery("DELETE FROM {{table}} WHERE `id` = {$_GET[id]}" , "annonce");
message ('Tu anuncio ha sido eliminado!', 'game.php?page=annonce', 2);
break;

case 13:////////////////////////////////////////validation ajout d'une annonce ressource

include('./includes/pages/annonce/verif_vente_ressources.php');

case 14:////////////////////////////////////////acheter les ressources d'une annonce

include('./includes/pages/annonce/achat_ressources.php');

case 15:////////////////////////////////////////acheter les vaisseaux d'une annonce

include('./includes/pages/annonce/achat_vaisseaux.php');

case 16 :////////////////////////////////////////annonce encheres

include('./includes/pages/annonce/annonce_encheres.php');

case 17:// Validation annonce def

include('./includes/pages/annonce/valid_annonce_defense.php');

case 18://vide

case 20 :////////////////////////////////////////pouvoir encherir verif code php ......

//je creer une table pour les encheres c'est plus simple
$PrixEnchereMetal = mysql_escape_string(intval(abs($_POST['enchmetal'])));
$PrixEnchereCristal = mysql_escape_string(intval(abs($_POST['enchcristal'])));
$PrixEnchereDeuter = mysql_escape_string(intval(abs($_POST['enchdeut'])));
$GetId = mysql_escape_string(intval(abs($_GET['id'])));

//il faut update l'enchere du joueur seulement s'il y a deja une entree sinon il faut la creer

$EntreeEnchere = doquery("SELECT id FROM {{table}} WHERE `id`='{$_GetId}' AND `user` = '{$user['username']}'","annonce");
if (mysql_num_rows($EntreeEnchere) == 0){

doquery("UPDATE {{table}} SET encheremetal = {$PrixEnchereMetal}, encherecristal = {$PrixEnchereCristal}, encheredeut = {$PrixEnchereDeuter} WHERE id = '".$GetId."' AND user= '".$user['username']."'" ,"annonce");

}else{//on creer l'entree

doquery("INSERT INTO {{table}} SET encheremetal = {$PrixEnchereMetal}, encherecristal = {$PrixEnchereCristal}, encheredeut = {$PrixEnchereDeuter}, id = '".$GetId."' , user= '".$user['username']."'" ,"annonce");

}

//on affiche la page
display($page2);

break;

//////////////////////////////////////
//                                                                    //
//      Affichage de la page par defaut       //
//        On y vois tout ce qui se vend           //
//                                                                    //
//////////////////////////////////////

default://Sinon on affiche la liste des annonces

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
$Annonce1 = doquery("SELECT * FROM {{table}} WHERE `type`='0' ORDER BY `id` DESC ", "annonce");
while ($b = mysql_fetch_assoc($Annonce1)) {
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
if ($b['user'] == $user['username']){
$page2 .="<th><a href=\"game.php?page=annonce&action=12&id={$b[id]}\">Eliminar</a></th>";}
else{

//il faud select la planete du vendeur savoir si la vente est possible
$AnnoncePossible = doquery("SELECT * FROM {{table}} WHERE galaxy = '".$b['galaxie']."' AND  system = '".$b['systeme']."' AND  planet ='".$b['planete']."'", "planets");
$Cpossible = mysql_fetch_array($AnnoncePossible);

//on affiche quoi?
if($Cpossible['metal']>= $b['metala'] && $Cpossible['crystal']>= $b['cristala'] && $Cpossible['deuterium']>= $b['deuta']){

//si les ressource a quai est suffisante pour honnorer l'annonce
$Action ="<a href=\"game.php?page=annonce&action=14&id={$b[id]}\"><font color='green'>Intercambiar</font></a>";}
else{
$Action ="<font color='red'>No disponible</font>";}


$page2 .= '<th>'.$Action.'</th>';
}
}

$page2 .= "<tr><th colspan=\"10\" align=\"center\"><a href=\"game.php?page=annonce&action=3\">Añadir un anuncio de Recursos</a></th></tr>
</td>
</table>
<br><br>
";



$page2 .= "
<table width=\"600\">
<td class=\"c\" colspan=\"11\"><font color=\"#FFFFFF\">Anuncios de Naves</font></td></tr>
<tr><th colspan=\"3\">Infos de entrega</th><th colspan=\"2\">Naves en venta</th><th colspan=\"3\">Recursos deseados</th><th colspan=\"2\">Info tasas</th><th>Acción</th></tr>
<tr><th>Vendedor</th><th>Galaxia</th><th>Sistema</th><th>Naves</th><th>Cantidad</th><th>Metal</th><th>Cristal</th><th>Deuterio</th><th>Precio nuevo</th><th>Precio venta</th><th>-</th></tr>";
$Annonce0 = doquery("SELECT * FROM {{table}} WHERE `type`='1' ORDER BY `id` DESC ", "annonce");
while ( $b= mysql_fetch_assoc($Annonce0)) {

//pour l'image
$Image = $b['vaisseau'];

//prix neuf
$PrixNeuf = $b['nombrevaisseau'] * ($pricelist[$b['vaisseau']]['metal']+$pricelist[$b['vaisseau']]['crystal']+$pricelist[$b['vaisseau']]['deuterium']);

$page2 .= '<tr>';

$page2 .= '<th>'.$b['user'].'</th>';
$page2 .= '<th>'.$b['galaxie'].'</th>';
$page2 .= '<th>'.$b['systeme'].'</th>';
$page2 .= '<th><img src="'.$dpath.'gebaeude/'.$Image.'.gif" style="width: 50px; height: 50px;" title="'.$lang['tech'][$b['vaisseau']].'" /></th>';
$page2 .= '<th>'.number_format($b['nombrevaisseau']).'</th>';
$page2 .= '<th>'.number_format($b['metals']).'</th>';
$page2 .= '<th>'.number_format($b['cristals']).'</th>';
$page2 .= '<th>'.number_format($b['deuts']).'</th>';
$page2 .= '<th>'.number_format($PrixNeuf).'</th>';
$page2 .= '<th>'.number_format($b['deuts']+$b['cristals']+$b['metals']).'</th>';
if ($b['user'] == $user['username']){
$Action ="<a href=\"game.php?page=annonce&action=12&id={$b[id]}\">Eliminar</a>";}
else{

//il faud select la planete du vendeur savoir si la vente est possible
$AnnoncePossible = doquery("SELECT * FROM {{table}} WHERE galaxy = '".$b['galaxie']."' AND  system = '".$b['systeme']."' AND  planet ='".$b['planete']."'", "planets");
$Cpossible = mysql_fetch_array($AnnoncePossible);

//on affiche quoi?
if($Cpossible[$resource[$b['vaisseau']]]>= $b['nombrevaisseau']){

//si la flotte a quai est suffisante pour honnorer l'annonce
$Action ="<a href=\"game.php?page=annonce&action=15&id={$b[id]}\"><font color='green'>Comprar</font></a>";}
else{
$Action ="<font color='red'>No disponible</font>";}

}
$page2 .= '<th>'.$Action.'</th>';
}



$page2 .= "<tr><th colspan=\"10\" align=\"center\"><a href=\"game.php?page=annonce&action=1\">Añadir un anuncio de Naves</a></th></tr>
</td>
</table>";

///////////annonces defenses

$page2 .= "<br><br>
<table width=\"600\">
<td class=\"c\" colspan=\"11\"><font color=\"#FFFFFF\">Anuncios de Defensas</font></td></tr>
<tr><th colspan=\"3\">Infos de entrega</th><th colspan=\"2\">Defensas en venta</th><th colspan=\"3\">Recursos deseados</th><th colspan=\"2\">Info tasas</th><th>Acción</th></tr>
<tr><th>Vendedor</th><th>Galaxia</th><th>Sistema</th><th>Naves</th><th>Cantidad</th><th>Metal</th><th>Cristal</th><th>Deuterio</th><th>Precio nuevo</th><th>Precio venta</th><th>-</th></tr>";
$Annonce0 = doquery("SELECT * FROM {{table}} WHERE `type`='4' ORDER BY `id` DESC ", "annonce");
while ( $b= mysql_fetch_assoc($Annonce0)) {

//pour l'image
$Image = $b['defense'];

//prix neuf
$PrixNeuf = $b['nombredefense'] * ($pricelist[$b['defense']]['metal']+$pricelist[$b['defense']]['crystal']+$pricelist[$b['defense']]['deuterium']);

$page2 .= '<tr>';

$page2 .= '<th>'.$b['user'].'</th>';
$page2 .= '<th>'.$b['galaxie'].'</th>';
$page2 .= '<th>'.$b['systeme'].'</th>';
$page2 .= '<th><img src="'.$dpath.'/gebaeude/'.$Image.'.gif" style="width: 50px; height: 50px;" title="'.$lang['tech'][$b['defense']].'" /></th>';
$page2 .= '<th>'.number_format($b['nombredefense']).'</th>';
$page2 .= '<th>'.number_format($b['metals']).'</th>';
$page2 .= '<th>'.number_format($b['cristals']).'</th>';
$page2 .= '<th>'.number_format($b['deuts']).'</th>';
$page2 .= '<th>'.number_format($PrixNeuf).'</th>';
$page2 .= '<th>'.number_format($b['deuts']+$b['cristals']+$b['metals']).'</th>';
if ($b['user'] == $user['username']){
$Action ="<a href=\"game.php?page=annonce&action=12&id={$b[id]}\">Eliminar</a>";}
else{

//il faud select la planete du vendeur savoir si la vente est possible
$AnnoncePossible = doquery("SELECT * FROM {{table}} WHERE galaxy = '".$b['galaxie']."' AND  system = '".$b['systeme']."' AND  planet ='".$b['planete']."'", "planets");
$Cpossible = mysql_fetch_array($AnnoncePossible);

//on affiche quoi?
if($Cpossible[$resource[$b['defense']]]>= $b['nombredefense']){

//si la flotte a quai est suffisante pour honnorer l'annonce
$Action ="<a href=\"game.php?page=annonce&action=19&id={$b[id]}\"><font color='green'>Comprar</font></a>";}
else{
$Action ="<font color='red'>No disponible</font>";}

}
$page2 .= '<th>'.$Action.'</th>';
}



$page2 .= "<tr><th colspan=\"10\" align=\"center\"><a href=\"game.php?page=annonce&action=5\">Añadir un anuncio de Defensas</a></th></tr>
</td>
</table>";

//////afficher les encheres(pas fini de coder...
/*

$page2 .= "<br>
<table width=\"600\">
<td class=\"c\" colspan=\"11\"><font color=\"#FFFFFF\">Subastas en curso</font></td></tr>
<tr><th colspan=\"3\">Lugar de subasta</th><th colspan=\"2\">Naves en subasta</th><th colspan=\"3\">Subasta actual</th><th colspan=\"2\">Fecha fin</th><th>Acción</th></tr>
<tr><th>Vendedor</th><th>Galaxia</th><th>Sistema</th><th>Naves</th><th>Cantidad</th><th>Metal</th><th>Cristal</th><th>Deuterio</th><th>Fecha fin</th><th>Precio reserva</th><th>-</th></tr>";

$Annonce0 = doquery("SELECT * FROM {{table}} WHERE `type`='2' ORDER BY `id` DESC ", "annonce");

while ( $b = mysql_fetch_assoc($Annonce0)) {

//il faut les encheres en cours:
$Ench = doquery("SELECT * FROM {{table}}", "annonce");
$Enchere = mysql_fetch_assoc($Ench);

//pour l'image
$Image = $b['vaisseau'];

//date de fin

$Quand = $b['datefin'];
$page2 .= '<tr>';
$page2 .= '<th>'.$b['user'].'</th>';
$page2 .= '<th>'.$b['galaxie'].'</th>';
$page2 .= '<th>'.$b['systeme'].'</th>';
$page2 .= '<th><img src="'.$dpath.'/gebaeude/'.$Image.'.gif" style="width: 50px; height: 50px;" title="'.$lang['tech'][$b['vaisseau']].'" /></th>';
$page2 .= '<th>'.number_format($b['nombrevaisseau']).'</th>';
$page2 .= '<th>'.number_format($b['metals']).'</th>';
$page2 .= '<th>'.number_format($b['cristals']).'</th>';
$page2 .= '<th>'.number_format($b['deuts']).'</th>';
$page2 .= '<th>'.date("d/m/y <br> H:i:s",$Quand).'</th>';

if ($b['deuts']+$b['cristals']+$b['metals'] > $b['reserve'] && $b['reserve'] !='' && $b['reserve'] != 0){
$page2 .= '<th><font color="green">Alcanzado</font></th>';
}elseif ($b['reserve'] =='' || $b['reserve'] == 0){
$page2 .= '<th><font color="orange">Ninguno</font></th>';
}else{
$page2 .= '<th><font color="red">No alcanzado</font></th>';
}
//on affiche quoi?
if($b['user'] != $user['username']){

$Action ="<a href=\"game.php?page=annonce&action=8&id={$b[id]}\"><font color='yellow'>Pujar</font></a>";}
else{
$Action ="<a href=\"game.php?page=annonce&action=12&id={$b[id]}\"><font color='red'>Eliminar</font></a>";}

$page2 .= '<th>'.$Action.'</th>';

}



$page2 .= "<tr><th colspan=\"10\" align=\"center\"><a href=\"game.php?page=annonce&action=7\">Añadir una puja</a></th></tr>

</table></div>";
*/
display($page2);
break;

}
}
?>