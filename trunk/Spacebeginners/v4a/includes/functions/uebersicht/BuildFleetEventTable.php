<?php

/**
  * BuildFleetEventTaple.php
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

function BuildFleetEventTable ( $FleetRow, $Status, $Owner, $Label, $Record ) {
    global $lang;

    $FleetStyle  = array (
        1 => 'attack',
        2 => 'federation',
        3 => 'transport',
        4 => 'deploy',
        5 => 'hold',
        6 => 'espionage',
        7 => 'colony',
        8 => 'harvest',
        9 => 'destroy',
        10 => 'missile',
        15 => 'transport',
    );

    $FleetStatus = array ( 0 => 'flight', 1 => 'holding', 2 => 'return' );

    if ($Owner == true ) {
        $FleetPrefix = 'own';
    } else {
        $FleetPrefix = '';
    }

    $RowsTPL        = gettemplate ('ubersicht/ubersicht_02');
    $MissionType    = $FleetRow['fleet_mission'];
    $FleetContent   = CreateFleetPopupedFleetLink ( $FleetRow, $lang['over']['1022'], $FleetPrefix . $FleetStyle[ $MissionType ] );
    $FleetCapacity  = CreateFleetPopupedMissionLink ( $FleetRow, $lang['type_mission'][ $MissionType ], $FleetPrefix . $FleetStyle[ $MissionType ] );

    $StartPlanet    = doquery("SELECT `name` FROM {{table}} WHERE `galaxy` = '".$FleetRow['fleet_start_galaxy']."' AND `system` = '".$FleetRow['fleet_start_system']."' AND `planet` = '".$FleetRow['fleet_start_planet']."' AND `planet_type` = '".$FleetRow['fleet_start_type']."';", 'planets', true);
    $StartType      = $FleetRow['fleet_start_type'];
    $TargetPlanet   = doquery("SELECT `name` FROM {{table}} WHERE `galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND `system` = '".$FleetRow['fleet_end_system']."' AND `planet` = '".$FleetRow['fleet_end_planet']."' AND `planet_type` = '".$FleetRow['fleet_end_type']."';", 'planets', true);
    $TargetType     = $FleetRow['fleet_end_type'];

    if ($Status != 2) {

        if ($StartType == 1) {
            $StartID  = $lang['over']['1001'];
        } elseif ($StartType == 3) {
            $StartID  = $lang['over']['1002'];
        }

        $StartID .= $StartPlanet['name'] ." ";
        $StartID .= GetStartAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );

        if ($MissionType != 15 ) {

            if ($TargetType == 1) {
                $TargetID = $lang['over']['1003'];
            } elseif ($TargetType == 2) {
                $TargetID = $lang['over']['1004'];
            } elseif ($TargetType == 3) {
                $TargetID = $lang['over']['1005'];
            }
        } else {
            $TargetID  = $lang['over']['1006'];
        }

        $TargetID .= $TargetPlanet['name'] ." ";
        $TargetID .= GetTargetAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );
    } else {

        if ($StartType == 1) {
            $StartID = $lang['over']['1007'];
        } elseif ($StartType == 3) {
            $StartID = $lang['over']['1007'];
        }

        $StartID .= $StartPlanet['name'] ." ";
        $StartID .= GetStartAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );

        if ($MissionType != 15 ) {

            if ($TargetType == 1) {
                $TargetID = $lang['over']['1009'];
            } elseif ($TargetType == 2) {
                $TargetID = $lang['over']['1010'];
            } elseif ($TargetType == 3) {
                $TargetID = $lang['over']['1011'];
            }
        } else {
            $TargetID  = $lang['over']['1012'];
        }

        $TargetID .= $TargetPlanet['name'] ." ";
        $TargetID .= GetTargetAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );
    }


    if ($Owner == true) {
        $EventString  = $lang['over']['1013'];
        $EventString .= $FleetContent;
    }elseif ($Owner == false and $MissionType == 5){
        $EventString  = $lang['ov_one_stranger'];
        $EventString .= $FleetContent;
        $EventString .= $lang['over']['1014'];
        $EventString .= BuildHostileFleetPlayerLink ( $FleetRow );
	 }elseif ($Owner == false and $MissionType == 2){
        $EventString  = $lang['ov_one_stranger'];
        $EventString .= $FleetContent;
        $EventString .= $lang['over']['1014'];
        $EventString .= BuildHostileFleetPlayerLink ( $FleetRow );
    } else {
        $EventString  = $lang['over']['1015'];
        $EventString .= $FleetContent;
        $EventString .= $lang['ov_hostile'];
        $EventString .= BuildHostileFleetPlayerLink ( $FleetRow );
    }

    if ($Status == 0) {
        $Time         = $FleetRow['fleet_start_time'];
        $Rest         = $Time - time();
        $EventString .= $lang['over']['1016']; // ' venant '
        $EventString .= $StartID;
        $EventString .= $lang['over']['1017']; // ' atteint '
        $EventString .= $TargetID;
        $EventString .= $lang['over']['1021']; // '. Elle avait pour mission: '
    } elseif ($Status == 1) {
        $Time         = $FleetRow['fleet_end_stay'];
        $Rest         = $Time - time();
        $EventString .= $lang['over']['1016']; // ' venant '
        $EventString .= $StartID;
        $EventString .= $lang['over']['1018']; // ' explore '
        $EventString .= $TargetID;
        $EventString .= $lang['over']['1019']; // '. Elle a pour mission: '
    } elseif ($Status == 2) {
        $Time         = $FleetRow['fleet_end_time'];
        $Rest         = $Time - time();
        $EventString .= $lang['over']['1020'];// ' rentrant '
        $EventString .= $TargetID;
        $EventString .= $StartID;
        $EventString .= $lang['over']['1021']; // '. Elle avait pour mission: '
    }

    $EventString .= $FleetCapacity;

    $bloc['fleet_status'] = $FleetStatus[ $Status ];
    $bloc['fleet_prefix'] = $FleetPrefix;
    $bloc['fleet_style']  = $FleetStyle[ $MissionType ];
    $bloc['fleet_javai']  = InsertJavaScriptChronoApplet ( $Label, $Record, $Rest, true );
    $bloc['fleet_order']  = $Label . $Record;
    $bloc['fleet_time']   = date("H:i:s", $Time);
    $bloc['fleet_descr']  = $EventString;
    $bloc['fleet_javas']  = InsertJavaScriptChronoApplet ( $Label, $Record, $Rest, false );

    return parsetemplate($RowsTPL, $bloc);
}

?>