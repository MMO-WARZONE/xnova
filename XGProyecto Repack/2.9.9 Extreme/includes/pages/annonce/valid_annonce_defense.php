<?php
/*
valid_annonce_defense.php

 version 2.0
 modificado por bonyy

 @copyright 2009 by Nain Pitoyable pour AideXnova
*/

//petite secu
$DefNombre = mysql_escape_string(abs($_POST['defvendre']));
$DefNom = mysql_escape_string(intval(abs($_POST['def'])));
$MetalD = mysql_escape_string(intval(abs($_POST['metalsouhait'])));
$CristalD = mysql_escape_string(intval(abs($_POST['cristalsouhait'])));
$DeuterD = mysql_escape_string(intval(abs($_POST['deutsouhait'])));

//si on post une annonce sans mettre de prix
if ($MetalD ==0 && $CristalD ==0 && $DeuterD ==0){

message ('No has puesto el precio de venta.','game.php?page=annonce', 2);}

//on verif qu'on a bien les vaisseaux
if ($DefNombre <= $planetrow[$resource[$DefNom]]){

//et on update
doquery("INSERT INTO {{table}} SET type='4', user='{$users['username']}',planete='{$planetrow['planet']}', galaxie='{$planetrow['galaxy']}', systeme='{$planetrow['system']}', defense='{$DefNom}', nombredefense='{$DefNombre}', metals='{$MetalD}', cristals='{$CristalD}', deuts='{$DeuterD}'" , "annonce");

message ('Tu anuncio ha sido publicado. Gracias.','game.php?page=annonce', 2);}

else{//sinon

message ('Tu anuncio no es válido.!', 'game.php?page=annonce', 2);
}
break;
 ?>