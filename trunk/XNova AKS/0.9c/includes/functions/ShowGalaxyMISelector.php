<?php

/**
 * ShowGalaxyMISelector.php
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

function ShowGalaxyMISelector ( $Galaxy, $System, $Planet, $Current, $MICount ) {
    global $lang;
    $Result  = "<script language=\"Javascript\">";
    $Result .= "function verif_nombre(champ)";
    $Result .= "{";
    $Result .= "var chiffres = new RegExp(\"[0-9\.]\");";
    $Result .= "var verif;";
    $Result .= "for(x = 0; x < champ.value.length; x++)";
    $Result .= "{";
    $Result .= "verif = chiffres.test(champ.value.charAt(x));";
    $Result .= "if(verif == false){champ.value = champ.value.substr(0,x) + champ.value.substr(x+1,champ.value.length-x+1); x--;}";
    $Result .= "}";
    $Result .= "}";
    $Result .= "</script>";
    $Result .= "<form action=\"raketenangriff.php?c=".$Current."&mode=2&galaxy=".$Galaxy."&system=".$System."&planet=".$Planet."\" method=\"POST\">";
    $Result .= "<tr>";
    $Result .= "<table border=\"0\">";
    $Result .= "<tr>";
    $Result .= "<td class=\"c\" colspan=\"2\">";
    $Result .= $lang['gm_launch'] ." [".$Galaxy.":".$System.":".$Planet."]";
    $Result .= "</td>";
    $Result .= "</tr>";
    $Result .= "<tr>";
    $String  = sprintf($lang['gm_restmi'], $MICount);
    $Result .= "<td class=\"c\">".$String." <input type=\"text\" name=\"SendMI\" size=\"2\" maxlength=\"7\" onkeyup=\"verif_nombre(this);\" /></td>";
    $Result .= "<td class=\"c\">".$lang['gm_target']." <select name=\"Target\">";
    $Result .= "<option value=\"all\" selected>".$lang['gm_all']."</option>";
    $Result .= "<option value=\"0\">".$lang['tech'][401]."</option>";
    $Result .= "<option value=\"1\">".$lang['tech'][402]."</option>";
    $Result .= "<option value=\"2\">".$lang['tech'][403]."</option>";
    $Result .= "<option value=\"3\">".$lang['tech'][404]."</option>";
    $Result .= "<option value=\"4\">".$lang['tech'][405]."</option>";
    $Result .= "<option value=\"5\">".$lang['tech'][406]."</option>";
    $Result .= "<option value=\"6\">".$lang['tech'][407]."</option>";
    $Result .= "<option value=\"7\">".$lang['tech'][408]."</option>";
    $Result .= "</select>";
    $Result .= "</td>";
    $Result .= "</tr>";
    $Result .= "<tr>";
    $Result .= "<td class=\"c\" colspan=\"2\"><input type=\"submit\" name=\"aktion\" value=\"".$lang['gm_send']."\"></td>";
    $Result .= "</tr>";
    $Result .= "</table>";
    $Result .= "</form>";

    return $Result;
}

?>