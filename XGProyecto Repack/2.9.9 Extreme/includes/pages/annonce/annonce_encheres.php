<?php
/*
annonce_encheres.php

 version 2.0
 modificado por bonyy

 @copyright 2009 by Nain Pitoyable pour AideXnova
*/

//secu
$Vaisseau = mysql_escape_string(intval(abs($_POST['vaisseau'])));
$VaisseauVendre = mysql_escape_string(intval(abs($_POST['vaisseauvendre'])));
$PrixDepartMetal = mysql_escape_string(intval(abs($_POST['departmetal'])));
$PrixDepartCristal = mysql_escape_string(intval(abs($_POST['departcristal'])));
$PrixDepartDeuter = mysql_escape_string(intval(abs($_POST['departdeuter'])));
$PrixReserve = mysql_escape_string(intval(abs($_POST['reserve'])));
$Duree = mysql_escape_string(intval(abs($_POST['duree'])));
//on verif quelques infos tt de meme
if ($VaisseauVendre <= $planetrow[$resource[$Vaisseau]] && $Vaisseau >= 201 && $Vaisseau <= 299 && $VaisseauVendre != 0){

if($PrixReserve != 0){

//on update le deut moins 500 000 (c'est le prix a payer pour bien vendre xD)
doquery("UPDATE {{table}} SET deuterium=deuterium-500000 WHERE id = '".$planetrow['id']."'" ,"planets");

$message ='Debes pagar 500.000 de Deuterio como reserva';
}

//si le prix de depard est inferieur a 1000 unites de chaque
if ( $PrixDepartMetal <= 1000 && $PrixDepartCristal <= 1000 && $PrixDepartDeuter <= 1000){

$TaxeMetal = 0;
$TaxeCristal = 0;
$TaxeDeuter = 0;}
else{
//il nous faut les 10% de la mise a prix
$TaxeMetal = $PrixDepartMetal /100 * 10;
$TaxeCristal = $PrixDepartCristal / 100 * 10;
$TaxeDeuter = $PrixDepartDeuter / 100 * 10;

$message .= '<br> Coste de la venta : '.$TaxeMetal.' Metal, '.$TaxeMetal.' Cristal  y '.$TaxeDeuter.' Deuterio';

//on update les ressources de la mise en vente en moins sur la colo
doquery("UPDATE {{table}} SET metal = metal - {$TaxeMetal}, crystal = crystal - {$TaxeCristal}, deuterium = deuterium - {$TaxeDeuter} WHERE id = '".$planetrow['id']."'" ,"planets");
}

$PrixReserve = mysql_escape_string(intval(abs($_POST['reserve'])));
$Duree = mysql_escape_string(intval(abs($_POST['duree'])))+time();

//apres ca, on valide et update l'annonce
doquery("INSERT INTO {{table}} SET type='2', user='{$users['username']}',planete='{$planetrow['planet']}', galaxie='{$planetrow['galaxy']}', systeme='{$planetrow['system']}',  vaisseau='{$Vaisseau}', nombrevaisseau='{$VaisseauVendre}', metals='{$PrixDepartMetal}', cristals='{$PrixDepartCristal}', deuts='{$PrixDepartDeuter}', datefin='{$Duree}', reserve = '{$PrixReserve}'" , "annonce");

//on add aussi l'enchere dans la table enchere pour la voir :)

message($message, 'game.php?page=annonce', 2);

}else{

$message ='Error en la venta';}

message($message, 'game.php?page=annonce', 2);

//on affiche la page
display($page2);

break;
 ?>