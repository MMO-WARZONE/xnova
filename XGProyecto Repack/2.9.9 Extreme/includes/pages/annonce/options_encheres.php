<?php
/*
Options_encheres.php

 version 2.0
 modificado por bonyy

 @copyright 2009 by Nain Pitoyable pour AideXnova
*/


//grand if qui dit que le mec qui vois l'annonce est celui qui l'a posté:

if($Qui['user'] == $user['username']){

$page2 .= '<table border="0" width="700">
    <tr>
        <td class="a" width="232">
           <b>Panel de Subastas</b>
        </td></tr></table>';

$page2 .= "<br><br>";
$page2 .= '<table border="0" width="700">
    <tr>
        <td class="a" width="232">
           <b>Subasta</b>
        </td>
        <td class="a" width="125">
            <b>Precio Actual:</b>
        </td>
        <td class="a" width="125">
            <b>Nombre de Pujador:</b>
        </td>
        <td class="a" width="125">
            <b>Metal:</b>
        </td>
        <td class="a" width="125">
            <b>Cristal:</b>
        </td>
        <td class="a" width="125">
            <b>Deuterio:</b>
        </td>
        <td class="a" width="125">
            <b>Precio de Reserva:</b>
        </td>
        <td class="a" width="125">
            <b>Fecha Fin:</b>
        </td>
    </tr>';

$Enchere1 = doquery("SELECT * FROM {{table}} WHERE user ='".$user['username']."' AND type='2'", "annonce");

While($Option = mysql_fetch_array($Enchere1)){;

$Prix_Total = $Option['metals']+$Option['cristals']+$Option['deuts'];

$Encheres = doquery("SELECT * FROM {{table}} WHERE id ='".$Option['id']."'", "annonce");

While($Encheres_Joueurs = mysql_fetch_array($Encheres)){

$Encherisseur = $Encheres_Joueurs['user'];


//on affiche l'annonces et les details :)

$page2 .='<tr>
        <td class="a" width="232">
            '.$Option['nom'].'
        </td>
        <td class="a" width="125">
            '.number_format($Prix_Total).'
        </td>
        <td class="a" width="125">
           '.$Encherisseur.'
        </td>
        <td class="a" width="125">
            '.number_format($Option['metals']).'
        </td>
        <td class="a" width="125">
            '.number_format($Option['cristals']).'
        </td>
        <td class="a" width="125">
            '.number_format($Option['deuts']).'
        </td>
        <td class="a" width="125">
            <p align="center">&nbsp;</p>
        </td>
        <td class="a" width="125">
            <p align="center">&nbsp;</p>
        </td>
    </tr>';
	}
}
$page2 .='
</table>';


}

?>