<?php
/*
verif_vente_ressources.php

 version 2.0
 modificado por bonyy

 @copyright 2009 by Nain Pitoyable pour AideXnova
*/
//petite secu
$MetalO = mysql_escape_string(abs($_POST['metalvendre']));
$CristalO = mysql_escape_string(intval(abs($_POST['cristalvendre'])));
$DeuterO = mysql_escape_string(intval(abs($_POST['deutvendre'])));
$MetalD = mysql_escape_string(intval(abs($_POST['metalsouhait'])));
$CristalD = mysql_escape_string(intval(abs($_POST['cristalsouhait'])));
$DeuterD = mysql_escape_string(intval(abs($_POST['deutsouhait'])));

//on ne peux pas vendre des ressources qu'on demande^^ genre je peux pas vendre 1 metal meme contre 1 metal....
if(($MetalO!=0 && $MetalD==0) ||($CristalO!=0 && $CristalD==0) || ($DeuterO!=0 && $DeuterD==0)){

//on verif que la personne a bien ce qu'elle veux vendre
if ($planetrow['metal']>=$MetalO && $planetrow['crystal']>=$CristalO && $planetrow['deuterium']>=$DeuterO){

//puis on update dans annonce
doquery("INSERT INTO {{table}} SET user='{$users['username']}', galaxie='{$planetrow['galaxy']}', systeme='{$planetrow['system']}', planete='{$planetrow['planet']}', metala='{$MetalO}', cristala='{$CristalO}', deuta='{$DeuterO}', metals='{$MetalD}', cristals='{$CristalD}', deuts='{$DeuterD}'" , "annonce");

message ('Tu anuncio ha sido publicado. Gracias!', 'game.php?page=annonce', 2);

}else{//sinon
message ('No dispones de esos recursos!', 'game.php?page=annonce', 2);
}

}else{//si on rentre pas de ressources a vendre ou qu'on met la meme ressources a vendre qu'on demande
message ('Tu anuncio no es válido!', 'game.php?page=annonce&action=1', 2);
}
break;
 ?>