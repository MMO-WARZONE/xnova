<?php
/*
achat_ressources.php

 version 2.0
 modificado por bonyy

 @copyright 2009 by Nain Pitoyable pour AideXnova
*/
//on select l'annonce

$MesAnnoncesRessources = doquery("SELECT * FROM {{table}} WHERE `id`='{$_GET['id']}'", "annonce");

while ($b = mysql_fetch_array($MesAnnoncesRessources)) {

//on select la planete du vendeur pour verif qu'il possede ce qu'il vend
$MAR = doquery("SELECT * FROM {{table}} WHERE `galaxy`='".$b['galaxie']."' AND `system`='{$b['systeme']}' AND `planet`='{$b['planete']}'", "planets");
$c = mysql_fetch_array($MAR);

//petite verif pas tres utile pour etre sur que le mec a bien les ressources dispo, on achete pas a un mec si c'est pour qu'il se retrouve en négatif
if ( $c['metal'] >= $b['metala'] && $c['crystal'] >= $b['cristala'] && $c['deuterium'] >= $b['deuta']){

//on verif que nous meme on a de quoi honnorer l'offre
if ( $planetrow['metal'] >= $b['metals'] && $planetrow['crystal'] >= $b['cristals'] && $planetrow['deuterium'] >= $b['deuts']){

//on update la planete du mec avec ressources proposes en moins et ressources demandes en plus
doquery("UPDATE {{table}} SET metal = metal + '".$b['metala']."', crystal = crystal + '".$b['cristala']."', deuterium = deuterium + '".$b['deuta']."' WHERE id = '".$planetrow['id']."'","planets");
doquery("UPDATE {{table}} SET metal = metal - '".$b['metals']."', crystal = crystal - '".$b['cristals']."', deuterium = deuterium - '".$b['deuts']."' WHERE id = '".$planetrow['id']."'","planets");

//on update la planete du mec avec ressources proposes en plus et ressources demandes en moins
doquery("UPDATE {{table}} SET metal = metal + '".$b['metals']."', crystal = crystal + '".$b['cristals']."', deuterium = deuterium + '".$b['deuts']."' WHERE galaxy ='".$b['galaxie']."' AND system = '".$b['systeme']."' AND planet = '".$b['planete']."'", "planets");
doquery("UPDATE {{table}} SET metal = metal - '".$b['metala']."', crystal = crystal - '".$b['cristala']."', deuterium = deuterium - '".$b['deuta']."' WHERE galaxy ='".$b['galaxie']."' AND system = '".$b['systeme']."' AND planet = '".$b['planete']."'", "planets");

//puis on efface l'annonce
doquery("DELETE FROM {{table}} WHERE `id`='{$_GET['id']}'", "annonce");

message ('Venta realizada', 'game.php?page=annonce', 2);

}else{//sinon

message ('Venta imposible', 'game.php?page=annonce', 2);
}

}else{//sinon
message ('Venta imposible', 'game.php?page=annonce', 2);
}
}

display($page);
break;
 ?>