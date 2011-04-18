<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

includeLang('schrotti');

if ($IsUserChecked == false) {
   includeLang('fehler');
   message($lang['check01'], $lang['check02']);
}

if ($user['urlaubs_modus'] == 1){
   includeLang('fehler');
   message($lang['Urlaub01'], $lang['Urlaub02']);
}

if (array_key_exists('shiptypeid', $_POST)) {
        $res_id = $_POST['shiptypeid'];
} else {
        $res_id = 202;
}

if (array_key_exists('number_ships_sell', $_POST)) {
        $number_ships_sell = $_POST['number_ships_sell'];
} else {
        $number_ships_sell = 0;
}

// Herstellungskosten des Schifftyps ermitteln
$price_met = $pricelist[$res_id]['metal'];  // Metal
$price_crys = $pricelist[$res_id]['crystal'];  // Crystal
$price_deut = $pricelist[$res_id]['deuterium'];  // Deuterium
$price_appol = $pricelist[$res_id]['appolonium'];  // Deuterium

    // Taux de récupération
        if ($res_id == 214) { // Antoinee
          // Si c'est une EDLM et que l'officier destructeur a été recruté
          $schrotti_rate_met = 0.50;
          $schrotti_rate_crys = 0.25;
          $schrotti_rate_deut = 0.15;
		  $schrotti_rate_appol = 0.07;
        } else {
          // Dans les autres cas

          $schrotti_rate_met = 0.75;
          $schrotti_rate_crys = 0.75;
          $schrotti_rate_deut = 0.5;
		  $schrotti_rate_appol = 0.25;
        }
// Rückgewinnungswerte pro Schiff
$schrotti_met = $price_met * $schrotti_rate_met;
$schrotti_crys = $price_crys * $schrotti_rate_crys;
$schrotti_deut = $price_deut * $schrotti_rate_deut;
$schrotti_appol = $price_appol * $schrotti_rate_appol;


if($_POST){

        if($number_ships_sell > 0 && $planetrow[$resource[$res_id]]!=0){

                if($number_ships_sell > $planetrow[$resource[$res_id]]){
                        $number_ships_sell = $planetrow[$resource[$res_id]];
                }

                $planetrow['metal'] += $number_ships_sell * $schrotti_met;
                $planetrow['crystal'] += $number_ships_sell * $schrotti_crys;
                $planetrow['deuterium'] += $number_ships_sell * $schrotti_deut;
				$planetrow['appolonium'] += $number_ships_sell * $schrotti_appol;
                $planetrow[$resource[$res_id]] -= $number_ships_sell;

                doquery("UPDATE {{table}} SET metal='{$planetrow['metal']}',crystal='{$planetrow['crystal']}',deuterium='{$planetrow['deuterium']}',appolonium='{$planetrow['appolonium']}',{$resource[$res_id]}='{$planetrow[$resource[$res_id]]}' WHERE id='{$user['current_planet']}'",'planets');

        }
}

$parse = $lang;

$parse['shiplist'] = '';
foreach ($reslist['fleet'] as $value) {
        $parse['shiplist'] .= "\n<option ";
        if ($res_id == $value) {
                $parse['shiplist'] .= "selected=\"selected\" ";
        }
        $parse['shiplist'] .= "value=\"".$value."\">";
        $parse['shiplist'] .= $lang['tech'][$value];
        $parse['shiplist'] .= "</option>";
}

$parse['image'] = $res_id;
$parse['dpath'] = $dpath;
$parse['schrotti_met'] = $schrotti_met;
$parse['schrotti_crys'] = $schrotti_crys;
$parse['schrotti_deut'] = $schrotti_deut;
$parse['schrotti_appol'] = $schrotti_appol;
$parse['shiptype_id'] = $res_id;
$parse['max_ships_to_sell'] = $planetrow[$resource[$res_id]];
$parse['Merchant_give_Metall'] = str_replace('%met',gettemplate('schrotti_met'),$lang['Merchant_give_Metall']);
$parse['Merchant_give_Kristall'] = str_replace('%crys',gettemplate('schrotti_crys'),$lang['Merchant_give_Kristall']);
$parse['Merchant_give_Deuterium'] = str_replace('%deut',gettemplate('schrotti_deut'),$lang['Merchant_give_Deuterium']);
$parse['Merchant_give_Appolonium'] = str_replace('%appol',gettemplate('schrotti_appol'),$lang['Merchant_give_Appolonium']);
$page = parsetemplate(gettemplate('schrotti'), $parse);

display($page,$lang['Intergalactic_merchant']);


?>