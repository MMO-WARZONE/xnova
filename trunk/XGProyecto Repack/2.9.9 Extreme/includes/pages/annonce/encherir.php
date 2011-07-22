<?php
/*
encherir.php

 version 2.0
 modificado por bonyy

 @copyright 2009 by Nain Pitoyable pour AideXnova
*/
//mise en page

while ($EnchereEnCours = mysql_fetch_array($Enchere)) {

$page2 .="<HTML><div id='content'>
<center>
<br><br>
<table width='400'>
<tr><td class='c' colspan='2'>Subasta de:<font color='yellow'> ".$EnchereEnCours['user']."</font></td></tr>
<tr><td class='c'>Naves:<font color='yellow'>  ".$lang['tech'][$EnchereEnCours['vaisseau']]."</font></td>
<td class='c'>Cantidad: <font color='green'> ".$EnchereEnCours['nombrevaisseau']."</font></td>
</tr>
<tr><td class='c' colspan='2'>Subastas en curso:</td></tr>
<tr><td class='c'><font color='yellow'>Metal:</font></td><td class='c'><font color='green'>".number_format($EnchereEnCours['metals'])."</font></td></tr>
<tr><td class='c'><font color='yellow'>Cristal:</font></td><td class='c'><font color='green'>".number_format($EnchereEnCours['cristals'])."</font></td></tr>
<tr><td class='c'><font color='yellow'>Deuterio:</font></td><td class='c'><font color='green'>".number_format($EnchereEnCours['deuts'])."</font></td></tr>
<tr><br><td class='c' colspan='2'>Pujar</td></tr>
<tr><form action='game.php?page=annonce&action=20&id=".$EnchereEnCours['id']."&enchmetal=".$encheremetal."&enchcristal=".$encherecristal."&enchdeut=".$encheredeut."' method='post'>
        <td width='200' class='c' align='center' rowspan='3'>
            <h2>Tu puja máxima</h2> <br><br>
			Ganarás la subasta cuando tu puja sea la más alta.
        </td>
        <td width='250' class='a'>
            Metal: <input type='text' value='0' name='encheremetal' />
        </td>
    </tr>
    <tr>
        <td width='250' class='a'>
            Cristal: <input type='text' value='0' name='encherecristal' />
        </td>
    </tr>
    <tr>
        <td width='250' class='a'>
            Deuterio: <input type='text' value='0' name='encheredeut' />
        </td>
    </tr>
	</tr><td><tr><th colspan='2'><input type='submit' value='Enviar' /></th></tr></td></tr>
</table>";

//les annonces encheres
$Annonce0 = doquery("SELECT * FROM {{table}} WHERE `type`='2'", "annonce");
while($b= mysql_fetch_array($Annonce0)){

$id = $b['id'];
//l'enchere max enregistré pour l'annonce : 
$PrixEnchereAnnonce = $b['metals']+$b['cristals']+$b['deuts'];
}

//il faut les encheres en cours:
$Ench = doquery("SELECT * FROM {{table}} WHERE id ='".$id."'", "annonce");
while($Encheres= mysql_fetch_assoc($Ench)){;

//les encheres des joueurs
$PrixEnchereJoueur = $Encheres['encheremetal'] + $Encheres['encherecristal'] + $Encheres['encheredeut'];
$EMet = $Encheres['encheremetal'];
$ECri = $Encheres['encherecristal'];
$EDeut = $Encheres['encheredeut'];
}

echo "<br>".$PrixEnchereJoueur;
echo "<br>".$PrixEnchereAnnonce;
if($PrixEnchereJoueur > $PrixEnchereAnnonce){

doquery("UPDATE {{table}} SET metals = {$EMet}, cristals = {$ECri}, deuts = {$EDeut} WHERE id = '".$id."'" ,"annonce");

}

}

?>