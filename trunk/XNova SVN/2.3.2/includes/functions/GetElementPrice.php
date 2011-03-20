<?php
//version 1


function GetElementPrice ($user, $planet, $Element, $userfactor = true)
{
    global $pricelist, $resource, $lang,$dpath;

    if ($userfactor){
            $level = ($planet[$resource[$Element]]) ? $planet[$resource[$Element]] : $user[$resource[$Element]];
    }
    $is_buyeable = true;
    $array = array(
        'metal'      => $lang["Metal"],
        'crystal'    => $lang["Crystal"],
        'deuterium'  => $lang["Deuterium"],
        'energy_max' => $lang["Energy"]
    );
    $array2 = array(
        'metal'      => "metall",
        'crystal'    => "kristall",
        'deuterium'  => "deuterium",
        'energy_max' => "energie"
    );
    $text = "<div><fieldset style='border-width:thin; border-style:solid; background-color: #040e1e;-moz-opacity: 0.9;-khtml-opacity: 0.7;opacity: 0.9;'><legend>".$lang['fgp_require'] . "</legend>";
    $text .= "<table align='center' width='90%' border='0' cellspacing='3' style='opacity:1;'>";

    // Colocamos los Iconos de los Requisitos
    $text .= "<tr>";
    foreach ($array as $ResType => $ResTitle) {
        if ($pricelist[$Element][$ResType] != 0) {
            $text .= "<th align='center'><img src='".$dpath."images/".$array2[$ResType].".gif' width='40' alt='".$ResTitle."' title='".$ResTitle."'></th> ";
        }
    }
    $text .= "</tr>";

    // Colocamos los textos de los requisitos
    $text .= "<tr>";
    foreach ($array as $ResType => $ResTitle) {
        if ($pricelist[$Element][$ResType] != 0) {
            $text .= "<th align='center'>";
            if ($userfactor) {
                $cost = floor($pricelist[$Element][$ResType] * pow($pricelist[$Element]['factor'], $level));
            } else {
                $cost = floor($pricelist[$Element][$ResType]);
            }
            if ($cost > $planet[$ResType])
            {
                $text .= "<b style=\"color:red;\"> <t title=\"-" . pretty_number ($cost - $planet[$ResType]) . "\">";
                $text .= "<span class=\"noresources\">" . pretty_number($cost) . "</span></t></b> ";
                $is_buyeable = false;
            }				else
            $text .= "<b style=\"color:lime;\">" . pretty_number($cost) . "</b> ";
            $text .= "</th>";
        }
    }
    $text .= "</tr></table></fieldset></div>";
    return $text;
 }
?>