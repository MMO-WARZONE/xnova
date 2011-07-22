<?php
/*
achat_vaisseaux.php

 version 2.0
 modificado por bonyy

 @copyright 2009 by Nain Pitoyable pour AideXnova
*/
//on select l'annonce

//on select l'annonce
$MesAnnoncesFlotte = doquery("SELECT * FROM {{table}} WHERE `id`='{$_GET['id']}'", "annonce");
while ($b = mysql_fetch_array($MesAnnoncesFlotte)) {

//petite verif que la personne possede les ressources pour acheter une flotte
if ($planetrow['metal'] >= $b['metals'] && $planetrow['crystal'] >= $b['cristals'] && $planetrow['deuterium'] >= $b['deuts']){

//on update la planete du mec avec flotte en moins et ressources en plus
doquery("UPDATE {{table}} SET {$resource[$b['vaisseau']]} = {$resource[$b['vaisseau']]} - '".$b['nombrevaisseau']."' WHERE galaxy ='".$b['galaxie']."' AND system = '".$b['systeme']."' AND planet = '".$b['planete']."'","planets");
doquery("UPDATE {{table}} SET metal = metal + '".$b['metals']."', crystal = crystal + '".$b['cristals']."', deuterium = deuterium + '".$b['deuts']."' WHERE galaxy ='".$b['galaxie']."' AND system = '".$b['systeme']."' AND planet = '".$b['planete']."'", "planets");

//on doit update les vaisseaux a l'acheteur et lui retirer les ressources
doquery("UPDATE {{table}} SET {$resource[$b['vaisseau']]} = {$resource[$b['vaisseau']]} + '".$b['nombrevaisseau']."' WHERE id_owner ='".$user['id']."' AND id = '".$planetrow['id']."'","planets");
doquery("UPDATE {{table}} SET metal = metal - '".$b['metals']."', crystal = crystal - '".$b['cristals']."', deuterium = deuterium - '".$b['deuts']."' WHERE id_owner ='".$user['id']."' AND id = '".$planetrow['id']."'","planets");
}

//on efface l'annonce
doquery("DELETE FROM {{table}} WHERE `id`='{$_GET['id']}'", "annonce");
message ('Venta realizada', 'game.php?page=annonce', 2);
}
display($page);
break;
 ?>