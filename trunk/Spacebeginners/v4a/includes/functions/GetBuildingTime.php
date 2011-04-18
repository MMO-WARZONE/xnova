<?php

/**
  * GetBuildingTime.php
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

function GetBuildingTime ($user, $planet, $Element, $destroy = false) {
    global $pricelist, $resource, $reslist, $game_config ,$user;

    // Baukosten = Bauzeit
    $cost = GetBuildingPrice ($user,$planet,$Element,true,$destroy,false);
    $cost = $cost['metal'] + $cost['crystal'];

    // Standart
    $bonusgeb    = 60; // Gebaude
    $bonusfleet  = 60; // Flotten
    $bonusforsch = 60; // Forschungen
    $bonusdeff   = 60; // Verteidigung

    // Rasse Vorteile / Nachteile

    switch ($user['volk']) {
        case "A":
        $bonusgeb    = 57;  // + 5%
        $bonusfleet  = 66;  // -10%
        $bonusforsch = 57;  // + 5%
        $bonusdeff   = 60;
        break;

        case "B":
        $bonusgeb    = 57;  // + 5%
        $bonusfleet  = 57;  // + 5%
        $bonusforsch = 66;  // -10%
        $bonusdeff   = 60;
        break;

        case "C":
        $bonusgeb    = 66;  // -10%
        $bonusfleet  = 57;  // + 5%
        $bonusforsch = 57;  // + 5%
        $bonusdeff   = 60;
        break;
    }

    if(in_array($Element, $reslist['build'])){

        // Gebäude + Rassen Bonus
        $time = ($cost / $game_config['game_speed']) * (1 / ($planet[$resource['14']] + 1)) * pow(0.5, $planet[$resource['15']]) ;
        $time = floor($time * 60 *  $bonusgeb);

    }elseif(in_array($Element, $reslist['tech'])) {

        // Forschung + Rassen Bonus + Forschungsbeschleunigung
        $lablevel = $planet[$resource['31']];
		$technodrom = $planet[$resource['27']];

        if($user[$resource[123]] > 0){
            $empire = doquery("SELECT `".$resource['31']."` FROM {{table}} WHERE `id_owner` ='". $user['id'] ."' AND `id` <>'". $user['current_planet'] ."' ORDER BY `".$resource['31']."` DESC LIMIT 0 , ". $user[$resource[123]] ." ;", 'planets');
            while ($colonie = mysql_fetch_array($empire)) {
                $lablevel += $colonie[$resource['31']];
            }
        }

        $time = ($cost / $game_config['game_speed']) / (($lablevel + 1) * 2) * pow(1 / 2, $planet[$resource['27']]);
        $time = floor($time * 60 * $bonusforsch);

    } elseif (in_array($Element, $reslist['defense']) ) {

        // Verteidigung + Rassen Bonus
        $time = ($cost / $game_config['game_speed']) * (1 / ($planet[$resource['21']] + 1)) * pow(1 / 2, $planet[$resource['15']]);
        $time = floor($time * 60 * $bonusdeff);

    }elseif ( in_array($Element, $reslist['fleet'])) {

        // Schiffe
        $time = ($cost / $game_config['game_speed']) * (1 / ($planet[$resource['21']] + 1)) * pow(1 / 2, $planet[$resource['15']]);
        $time = floor($time * 60 * $bonusfleet);
    }
    return $time;
}

?>