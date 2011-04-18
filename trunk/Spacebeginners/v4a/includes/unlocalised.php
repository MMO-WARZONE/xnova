<?php

function GetTargetDistance ($OrigGalaxy, $DestGalaxy, $OrigSystem, $DestSystem, $OrigPlanet, $DestPlanet) {
    $distance = 0;

    if (($OrigGalaxy - $DestGalaxy) != 0) {
        $distance = abs($OrigGalaxy - $DestGalaxy) * 20000;
    } elseif (($OrigSystem - $DestSystem) != 0) {
        $distance = abs($OrigSystem - $DestSystem) * 5 * 19 + 2700;
    } elseif (($OrigPlanet - $DestPlanet) != 0) {
        $distance = abs($OrigPlanet - $DestPlanet) * 5 + 1000;
    } else {
        $distance = 5;
    }
    return $distance;
}

function GetMissionDuration ($GameSpeed, $MaxFleetSpeed, $distance, $SpeedFactor) {
    $duration = 0;
    $duration = round(((35000 / $GameSpeed * sqrt($distance * 10 / $MaxFleetSpeed) + 10) / $SpeedFactor));
    return $duration;
}

function GetGameSpeedFactor () {
    global $game_config;
    return $game_config['fleet_speed'] / 2500;
}

function GetFleetMaxSpeed ($FleetArray, $Fleet, $Player) {
    global $reslist, $pricelist;

    if ($Fleet != 0) {
        $FleetArray[$Fleet] =  1;
    }

    foreach ($FleetArray as $Ship => $Count) {

        if ($Ship == 202) {

            if ($Player['impulse_motor_tech'] >= 5) {
                $speedalls[$Ship] = $pricelist[$Ship]['speed2'] + (($pricelist[$Ship]['speed'] * $Player['impulse_motor_tech']) * 0.2);
            } else {
                $speedalls[$Ship] = $pricelist[$Ship]['speed']  + (($pricelist[$Ship]['speed'] * $Player['combustion_tech']) * 0.1);
            }
        }

        if ($Ship == 203 or $Ship == 204 or $Ship == 209 or $Ship == 210  ) {
            $speedalls[$Ship] = $pricelist[$Ship]['speed'] + (($pricelist[$Ship]['speed'] * $Player['combustion_tech']) * 0.1);
        }

        if ($Ship == 205 or $Ship == 206 or $Ship == 208 or $Ship == 219 ) {
            $speedalls[$Ship] = $pricelist[$Ship]['speed'] + (($pricelist[$Ship]['speed'] * $Player['impulse_motor_tech']) * 0.2);
        }

        if ($Ship == 211) {

            if ($Player['hyperspace_motor_tech'] >= 8) {
                $speedalls[$Ship] = $pricelist[$Ship]['speed2'] + (($pricelist[$Ship]['speed'] * $Player['hyperspace_motor_tech']) * 0.3);
            } else {
                $speedalls[$Ship] = $pricelist[$Ship]['speed']  + (($pricelist[$Ship]['speed'] * $Player['impulse_motor_tech']) * 0.2);
            }
        }

        if ($Ship == 207 or $Ship == 213 or $Ship == 214 or $Ship == 215 or $Ship == 216 or $Ship == 217 or $Ship == 218 ) {
            $speedalls[$Ship] = $pricelist[$Ship]['speed'] + (($pricelist[$Ship]['speed'] * $Player['hyperspace_motor_tech']) * 0.3);
        }
    }

    if ($Fleet != 0) {
        $ShipSpeed = $speedalls[$Ship];
        $speedalls = $ShipSpeed;
    }
    return $speedalls;
}

function GetShipConsumption ( $Ship, $Player ) {
    global $pricelist;

    if ($Player['impulse_motor_tech'] >= 5) {
        $Consumption  = $pricelist[$Ship]['consumption2'];
    } else {
        $Consumption  = $pricelist[$Ship]['consumption'];
    }
    return $Consumption;
}

function GetFleetConsumption ($FleetArray, $SpeedFactor, $MissionDuration, $MissionDistance, $FleetMaxSpeed, $Player) {
    $consumption = 0;
    $basicConsumption = 0;

    foreach ($FleetArray as $Ship => $Count) {

        if ($Ship > 0) {
            $ShipSpeed         = GetFleetMaxSpeed ( "", $Ship, $Player );
            $ShipConsumption   = GetShipConsumption ( $Ship, $Player );
            $spd               = 35000 / ($MissionDuration * $SpeedFactor - 10) * sqrt( $MissionDistance * 10 / $ShipSpeed );
            $basicConsumption  = $ShipConsumption * $Count;
            $consumption      += $basicConsumption * $MissionDistance / 35000 * (($spd / 10) + 1) * (($spd / 10) + 1);
        }
    }
    $consumption = round($consumption) + 1;
    return $consumption;
}

function pretty_time ($seconds) {
    $day = floor($seconds / (24 * 3600));
    $hs = floor($seconds / 3600 % 24);
    $ms = floor($seconds / 60 % 60);
    $sr = floor($seconds / 1 % 60);

    if ($hs < 10) {
        $hh = "0" . $hs;
    } else {
        $hh = $hs;
    }

    if ($ms < 10) {
        $mm = "0" . $ms;
    } else {
        $mm = $ms;
    }

    if ($sr < 10) {
        $ss = "0" . $sr;
    } else {
        $ss = $sr;
    }

    $time = '';

    if ($day != 0) {
        $time .= $day . 'd ';
    }

    if ($hs  != 0) {
        $time .= $hh . 'h ';
    } else {
        $time .= '00h ';
    }

    if ($ms  != 0) {
        $time .= $mm . 'm ';
    } else {
        $time .= '00m ';
    }

    $time .= $ss . 's';
    return $time;
}

function pretty_time_hour ($seconds) {
    $min = floor($seconds / 60 % 60);
    $time = '';

    if ($min != 0) {
        $time .= $min . 'min ';
    }
    return $time;
}

function ShowBuildTime ($time) {
    global $lang;
    return "<br>". $lang['ConstructionTime'] .": " . pretty_time($time);
}

function add_points ($resources, $userid) {
    return false;
}

function remove_points ($resources, $userid) {
    return false;
}

function get_userdata () {
    return '';
}

function ReadFromFile($filename) {
    $content = @file_get_contents ($filename);
    return $content;
}

function SaveToFile ($filename, $content) {
    $content = @file_put_contents ($filename, $content);
}

function parsetemplate ($template, $array) {
    return preg_replace('#\{([a-z0-9\-_]*?)\}#Ssie', '( ( isset($array[\'\1\']) ) ? $array[\'\1\'] : \'\' );', $template);
}

function gettemplate ($templatename) {
    global $xnova_root_path;
    $filename = $xnova_root_path . TEMPLATE_DIR . TEMPLATE_NAME . '/' . $templatename . ".tpl";
    return ReadFromFile($filename);
}

function includeLang ($filename, $ext = '.mo') {
     global $xnova_root_path, $lang, $user;

     if ($user['lang'] != '') {
         $SelLanguage = $user['lang'];
     } else {
         $SelLanguage = DEFAULT_LANG;
     }
     include ($xnova_root_path . "styl/sprache/". $SelLanguage ."/". $filename.$ext);
}

function GetStartAdressLink ( $FleetRow) {
    $Link  = "<a href=\"galaxy.php?mode=3&amp;galaxy=".$FleetRow['fleet_start_galaxy']."&amp;system=".$FleetRow['fleet_start_system']."\">";
    $Link .= "[".$FleetRow['fleet_start_galaxy'].":".$FleetRow['fleet_start_system'].":".$FleetRow['fleet_start_planet']."]</a>";
    return $Link;
}

function GetTargetAdressLink ( $FleetRow, $FleetType ) {
    $Link  = "<a href=\"galaxy.php?mode=3&amp;galaxy=".$FleetRow['fleet_end_galaxy']."&amp;system=".$FleetRow['fleet_end_system']."\">";
    $Link .= "[".$FleetRow['fleet_end_galaxy'].":".$FleetRow['fleet_end_system'].":".$FleetRow['fleet_end_planet']."]</a>";
    return $Link;
}

function BuildPlanetAdressLink ( $CurrentPlanet ) {
    $Link  = "<a href=\"galaxy.php?mode=3&amp;galaxy=".$CurrentPlanet['galaxy']."&amp;system=".$CurrentPlanet['system']."\">";
    $Link .= "[".$CurrentPlanet['galaxy'].":".$CurrentPlanet['system'].":".$CurrentPlanet['planet']."]</a>";
    return $Link;
}

function BuildHostileFleetPlayerLink ( $FleetRow ) {
    global $lang, $dpath;
    $PlayerName = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '". $FleetRow['fleet_owner']."';", 'users', true);
    $Link  = "<a href=\"messages.php?mode=write&amp;id=".$FleetRow['fleet_owner']."\">".$PlayerName['username']. "</a> ";
    return $Link;
}

function GetNextJumpWaitTime ( $CurMoon ) {
    global $resource;
    $JumpGateLevel  = $CurMoon[$resource[43]];
    $LastJumpTime   = $CurMoon['last_jump_time'];

    if ($JumpGateLevel > 0) {
        $WaitBetweenJmp = (60 * 60) * (1 / $JumpGateLevel);
        $NextJumpTime   = $LastJumpTime + $WaitBetweenJmp;

        if ($NextJumpTime >= time()) {
            $RestWait   = $NextJumpTime - time();
            $RestString = " ". pretty_time($RestWait);
        } else {
            $RestWait   = 0;
            $RestString = "";
        }
    } else {
        $RestWait   = 0;
        $RestString = "";
    }
    $RetValue['string'] = $RestString;
    $RetValue['value']  = $RestWait;
    return $RetValue;
}

function GetNextJumpWaitTimePlanet ( $CurPlanete ) {
    global $resource;

    $JumpGateLevel  = $CurPlanete[$resource[46]];
    $LastJumpTime   = $CurPlanete['last_beam_time'];

    if ($JumpGateLevel > 0) {
        $WaitBetweenJmp = (60 * 60) * (1 / $JumpGateLevel);
        $NextJumpTime   = $LastJumpTime + $WaitBetweenJmp;

        if ($NextJumpTime >= time()) {
            $RestWait   = $NextJumpTime - time();
            $RestString = " ". pretty_time($RestWait);
        } else {
            $RestWait   = 0;
            $RestString = "";
        }
    } else {
        $RestWait   = 0;
        $RestString = "";
    }
    $RetValue['string'] = $RestString;
    $RetValue['value']  = $RestWait;
    return $RetValue;
}

function CreateFleetPopupedFleetLink ( $FleetRow, $Texte, $FleetType ) {
    global $lang;

    $FleetRec     = explode(";", $FleetRow['fleet_array']);
    $FleetPopup   = "<a href='#' onmouseover=\"return overlib('";
    $FleetPopup  .= "<table width=200>";

    foreach($FleetRec as $Item => $Group) {

        if ($Group  != '') {
            $Ship    = explode(",", $Group);
            $FleetPopup .= "<tr><td width=50% align=left><font color=white>". $lang['tech'][$Ship[0]] .":<font></td><td width=50% align=right><font color=white>". pretty_number($Ship[1]) ."<font></td></tr>";
        }
    }
    $FleetPopup  .= "</table>";
    $FleetPopup  .= "');\" onmouseout=\"return nd();\" class=\"". $FleetType ."\">". $Texte ."</a>";
    return $FleetPopup;
}

function CreateFleetPopupedMissionLink ( $FleetRow, $Texte, $FleetType ) {
    global $lang;

    $FleetTotalC  = $FleetRow['fleet_resource_metal'] + $FleetRow['fleet_resource_crystal'] + $FleetRow['fleet_resource_deuterium']+ $FleetRow['fleet_resource_appolonium'];

    if ($FleetTotalC <> 0) {
        $FRessource   = "<table width=200>";
        $FRessource  .= "<tr><td width=50% align=left><font color=white>". $lang['Metal'] ."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_metal']) ."<font></td></tr>";
        $FRessource  .= "<tr><td width=50% align=left><font color=white>". $lang['Crystal'] ."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_crystal']) ."<font></td></tr>";
        $FRessource  .= "<tr><td width=50% align=left><font color=white>". $lang['Deuterium'] ."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_deuterium']) ."<font></td></tr>";
        $FRessource  .= "<tr><td width=50% align=left><font color=white>". $lang['Appolonium'] ."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_appolonium']) ."<font></td></tr>";
        $FRessource  .= "</table>";
    } else {
        $FRessource   = "";
    }

    if ($FRessource <> "") {
        $MissionPopup  = "<a href='#' onmouseover=\"return overlib('". $FRessource ."');";
        $MissionPopup .= "\" onmouseout=\"return nd();\" class=\"". $FleetType ."\">" . $Texte ."</a>";
    } else {
        $MissionPopup  = $Texte ."";
    }
    return $MissionPopup;
}

?>