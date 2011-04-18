<?php

/**
  * ShowGalaxyMISelector.php
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

function ShowGalaxyMISelector ( $Galaxy, $System, $Planet, $Current, $MICount ) {
    global $lang, $dpath;

    $Result  = "

<script type='text/javascript'>

function verif_nombre(champ){
    var chiffres = new RegExp(\"[0-9\.]\");
    var verif;
    for(x = 0; x < champ.value.length; x++){
        verif = chiffres.test(champ.value.charAt(x));

        if(verif == false){
            champ.value = champ.value.substr(0,x) + champ.value.substr(x+1,champ.value.length-x+1); x--;
        }
    }
}
</script>

<form action='raketenangriff.php?c=".$Current."&amp;mode=2&amp;galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=".$Planet."' method='POST'>

<table cellspacing='0'>
    <tr><td align='center'><img style='width:17px; height:17px;' src='". $dpath ."striche/03.png' alt='03.png'></td>
        <td align='center' style='font-size:100%;'><b><u>".$lang['gala']['1101']."</u></b></td>
        <td align='center'><img style='width:17px; height:17px;' src='". $dpath ."striche/06.png' alt='06.png'></td>
        <td align='center'>&nbsp;</td>
        <td align='center'>&nbsp;</td>
        <td align='center'>&nbsp;</td>
        <td align='center'>&nbsp;</td>
        <td align='center'>&nbsp;</td>
        <td align='center'>&nbsp;</td></tr>

    <tr><td align='center'><img style='height:17px; width:17px;'  src='". $dpath ."striche/07.png' alt='07.png'></td>
        <td align='center'><img style='height:17px; width:100px;'  src='". $dpath ."striche/09.png' alt='09.png'></td>
        <td align='center'><img style='height:17px; width:17px;'  src='". $dpath ."striche/11.png' alt='11.png'></td>
        <td align='center'><img style='height:17px; width:90px;'  src='". $dpath ."striche/09.png' alt='09.png'></td>
        <td align='center'><img style='height:17px; width:17px;'  src='". $dpath ."striche/02.png' alt='02.png'></td>
        <td align='center'><img style='height:17px; width:200px;' src='". $dpath ."striche/09.png' alt='09.png'></td>
        <td align='center'><img style='height:17px; width:17px;'  src='". $dpath ."striche/02.png' alt='02.png'></td>
        <td align='center'><img style='height:17px; width:140px;' src='". $dpath ."striche/09.png' alt='09.png'></td>
        <td align='center'><img style='height:17px; width:17px;'  src='". $dpath ."striche/06.png' alt='06.png'></td></tr>

    <tr><td align='center'><img style='width:17px; height:17px;' src='". $dpath ."striche/04.png' alt='04.png'></td>
        <td align='left' valign='middle' style='font-size:100%;'><b> ".$lang['gala']['1102']."".$lang['gala']['5002']." ".$lang['gala']['5000']."".$Galaxy."".$lang['gala']['5002']."".$System."".$lang['gala']['5002']."".$Planet."".$lang['gala']['5001']."</b></td>
        <td align='center'><img style='width:17px; height:17px;' src='". $dpath ."striche/04.png' alt='04.png'></td>
        <td align='left' valign='middle' style='font-size:100%;'><b> ".$lang['gala']['1103']."".$lang['gala']['5002']." </b><input type='text' name='SendMI' size='2' maxlength='7' onkeyup='verif_nombre(this);' /></td>
        <td align='center'><img style='width:17px; height:17px;' src='". $dpath ."striche/04.png' alt='04.png'></td>
        <td align='left' valign='middle' style='font-size:100%;'><b> ".$lang['gala']['1104']."".$lang['gala']['5002']." </b>

        <select name='Target'>
         <option value='all' selected>".$lang['gala']['1106']."</option>
         <option value='0'>".$lang['tech'][401]."</option>
         <option value='1'>".$lang['tech'][402]."</option>
         <option value='2'>".$lang['tech'][403]."</option>
         <option value='3'>".$lang['tech'][404]."</option>
         <option value='4'>".$lang['tech'][405]."</option>
         <option value='5'>".$lang['tech'][406]."</option>
         <option value='6'>".$lang['tech'][407]."</option>
         <option value='7'>".$lang['tech'][408]."</option>
         <option value='8'>".$lang['tech'][409]."</option>
         <option value='9'>".$lang['tech'][410]."</option>
        </select></td>

        <td align=\"center\"><img style='width:17px; height:17px;' src='". $dpath ."striche/04.png' alt='04.png'></td>
        <td align=\"center\" style='font-size:100%'><input type=\"submit\" name=\"aktion\" value=\"".$lang['gala']['1105']."\"></td>
        <td align=\"center\"><img style='width:17px; height:17px;' src='". $dpath ."striche/05.png' alt='05.png'></td> </tr>
</table>
</form>";

    return $Result;
}

?>