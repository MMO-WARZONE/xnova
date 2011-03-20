<?php

//version 2.3
/*
 * TENGO QUE REESCRIBIR LA PARTE DE COGER LA FLOTA, Y LA PARTE DE SACARLA
 */


if (!defined('INSIDE'))die(header("location:../../"));
include($svn_root."includes/functions/classes/class.sacs.php");

class FlyingFleetHandlers extends SAC
{

	private function MissionCaseSac($FleetData) {
        global $db, $users,$phpEx,$displays, $svn_root, $pricelist, $lang, $resource, $CombatCaps;
        $DISABLE=true;
        if($FleetData['fleet_mess'] == '0' && $FleetData['fleet_start_time'] < time() && $FleetData['fleet_group'] && !$DISABLE){
            $Fleets = $db->query("SELECT `fleet_id` FROM {{table}} WHERE fleet_group = '".$FleetData['fleet_group']."';", 'fleets');
            //echo "ATACANTES<br>";
            $a=1;
            while($Fleet = mysql_fetch_assoc($Fleets)){
                //for($i = 0; $i < count($Fleets['fleet_id']); $i++){
                    //foreach($Fleet['fleet_id'] as $a){
                        $fleet[$a] = $db->query("SELECT * FROM {{table}} WHERE fleet_id = '".$Fleet['fleet_id']."';", 'fleets',true);
                   // }
                        
               // }

                //for($i = 0; $i < count($Fleets['fleet_id']); $i++){
                    $FleetArray[$a] = $fleet[$a]['fleet_array'];
                //}
                $AttackFleets[$a]['user'] = $db->query("SELECT id,username,rpg_amiral,defence_tech,military_tech,shield_tech
                    FROM {{table}} WHERE id = ".$fleet[$a]['fleet_owner'].";", 'users',true);

                //print_r($FleetArray[$a]);
                //for($i = 0; $i < count($Fleet['id']); $i++){
                    $FExp[$a] = explode(";", $FleetArray[$a]);
                    //for($k = 0; $k <= $FExp[$a][0]; $k++){
                    //print_r($FExp[$a]);
                    foreach($FExp[$a] as $key => $value){
                        if(!$value){continue;}
                        //$Atack = explode(",", $FExp[$a]);
                        $Atack = explode(",", $value);
                        if(!isset($Atack[0])){
                            $AttackFleets[$a][$Atack[0]] = 0;
                        }
                        $AttackFleets[$a]['fleet'][$Atack[0]] += $Atack[1];
                    }

                    //$attacker[$a] = $db->query("SELECT * FROM {{table}} WHERE id = ".$fleet[$a]['fleet_owner'].";", 'users',true);
                    //$AttackFleets[$a] = $attacker[$a];
                    //$AttackFleets[$a] = $db->query("SELECT * FROM {{table}} WHERE id = ".$fleet[$a]['fleet_owner'].";", 'users',true);
                    ;

               // }
                $a++;
            }
            //print_r($AttackFleets);
            //echo "<br><br>";
            $TargetPlanet = $db->query("SELECT * FROM {{table}}
                                        WHERE galaxy = ".$FleetData['fleet_end_galaxy']."
                                        AND system = ".$FleetData['fleet_end_system']."
                                        AND planet = ".$FleetData['fleet_end_planet']."
                                        AND planet_type = ".$FleetData['fleet_end_type'].";", 'planets',true);

            $TargetDefense[1]['user'] = $db->query("SELECT id,username,rpg_amiral,defence_tech,military_tech,shield_tech
                FROM {{table}} WHERE id = ".$TargetPlanet['id_owner'].";", 'users',true);

            for($j = 202; $j < 500; $j++){
                if(isset($resource[$j]) && isset($TargetPlanet[$resource[$j]]) && $TargetPlanet[$resource[$j]]>0 ){
                    $TargetDefense[1]['fleet'][$j] = $TargetPlanet[$resource[$j]];
                }
            }

            $start = microtime(true);
            //echo "DEFENSA<br>";
            //print_r($TargetDefense);
            $result = $this->CalculateAttack($AttackFleets, $TargetDefense);
            $totaltime = microtime(true) - $start;

            if($result['won'] == '1'){
                $capacity = array();
                for($i = 0; $i < count($Fleets['id']); $i++){
                    foreach($AttackFleets[$i] as $Element => $cantidad){
                        $capacity[$i] += $pricelist[$Element]['capacity'] * $cantidad;
                    }
                }

                if(isset($capacity)){
                    $metalrobado = abs($TargetPlanet['metal']/2);
                    $cristalrobado = abs($TargetPlanet['crystal']/2);
                    $deutrobado = abs($TargetPlanet['deuterium']/2);

                    foreach($Fleets['fleet_id'] as $i => $id){
                        $capacity[$i] = abs($capacity[$i]/3);
                        if($capacity[$i] > $metalrobado){
                            $robado[$i]['metal'] = $metalrobado;
                        } else {
                            $robado[$i]['metal'] = abs($metalrobado/3);
                        }
                        if($capacity[$i] > $crystalrobado){
                            $robado[$i]['crystal'] = $crystalrobado;
                        } else {
                            $robado[$i]['crystal'] = abs($crystalrobado/2);
                        }
                        if($capacity[$i] > $deutrobado){
                            $robado[$i]['deut'] = $deutrobado;
                        } else {
                            $robado[$i]['crystal'] = abs($deutrobado/2);
                        }
                    }
                }
                $robado = array_map('round', $robado);

                foreach($Fleets['fleet_id'] as $i => $id){
                    $UpdateFleet  = 'UPDATE {{table}} SET ';
                    $UpdateFleet .= '`fleet_resource_metal` = `fleet_resource_metal` + '. $robado[$i]['metal'] .', ';
                    $UpdateFleet .= '`fleet_resource_crystal` = `fleet_resource_crystal` + '. $robado[$i]['crystal'] .', ';
                    $UpdateFleet .= '`fleet_resource_deuterium` = `fleet_resource_deuterium` + '. $robado[$i]['deuterium'] .' ';
                    $UpdateFleet .= 'WHERE fleet_id = '. $id .' ';
                    $UpdateFleet .= 'LIMIT 1 ;';
                    $db->query( $UpdateFleet, 'fleets');
                }
            }

            if($TargetUser['authlevel'] == 0){
                $db->query("UPDATE {{table}} SET metal = metal + ".($result['debree']['att'][0] + $result['debree']['def'][0])." , crystal = crystal + ".($result['debree']['att'][1] + $result['debree']['def'][1])." WHERE `galaxy` = ". $FleetData['fleet_end_galaxy'] ." AND `system` = ". $FleetData['fleet_end_system'] ." AND `planet` = ". $FleetData['fleet_end_planet'].";",'galaxy');
            }

            $totalescombros = $result['debree']['def'][0] + $result['debree']['def'][1] + $result['debree']['att'][0] + $result['debree']['att'][1];

            for($i = 0; $i < count($Fleets['fleet_id']); $i++){
                $totalCount = 0;
                $Farray = '';
                foreach($AttackFleets[$i] as $Element => $Count){
                    if($Count) $Farray .= $Element.','.$Count;
                    $totalCount += $Count;
                }
                if($totalCount <= 0){
                    $db->query("DELETE * FROM {{table}} WHERE fleet_id =  '".$AttackFleets[$i]."';", 'fleets');
                } else {
                    $db->query('UPDATE {{table}} SET fleet_array = "'.substr($Farray, 0, -1).'", fleet_amount = '.$totalCount.', fleet_mess = 1 WHERE fleet_id='.$AttackFleets[$i],'fleets');
                }
            }
            echo "exit";//print_r($TargetDefense);
            exit();
            if(is_array($TargetDefense)){
                $UpdateDefense = "UPDATE {{table}} SET ";
                foreach($TargetDefense as $id => $Def){
                    foreach($Def['fleet'] as $Element => $Count){
                        if($resource[$Element]){
                            $UpdateDefense .= "".$resource[$Element]." = ".$Count.",";
                        }
                    }
                }
                $UpdateDefense .= "WHERE id_owner = ".$TargetDefense['user']["id"]." AND galaxy = ".$TargetPlanet['galaxy']." AND system = ".$TargetPlanet['system']." AND planet = ".$TargetPlanet['planet']." AND planet_type = ".$Target_Planet['planet_type'].";";
                $db->query($UpdateDefense, 'planets');
            }
            $FleetEscombros = $result['debree']['att'][0] + $result['debree']['def'][0] + $result['debree']['att'][1] + $result['debree']['def'][1];
            $StrAttackerUnits = sprintf ($lang['sys_attacker_lostunits'], $result['lost']['att']);
            $StrDefenderUnits = sprintf ($lang['sys_defender_lostunits'], $result['lost']['def']);
            $StrRuins         = sprintf ($lang['sys_gcdrunits'], $result['debree']['def'][0] + $result['debree']['att'][0], $lang['Metal'], $result['debree']['def'][1] + $result['debree']['att'][1], $lang['Crystal']);
            $DebrisField      = $StrAttackerUnits ."<br />". $StrDefenderUnits ."<br />". $StrRuins;
            $MoonChance = $FleetEscombros * 0.000001;
            if($MoonChance > 20){
                $MoonChance = 20;
            } elseif ($MoonChance < 1) {
                $MoonChance = 0;
            }
            $UserChance = mt_rand(1,100);
            $ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);

            if(($UserChance > 0) && ($UserChance < $MoonChance) && ($TargetPlanet['id_luna'] == 0)){
                $TargetMoon = CreateOneMoonRecord ( $FleetData['fleet_end_galaxy'], $FleetData['fleet_end_system'], $FleetData['fleet_end_planet'], $TargetUser['id'], '', $MoonChance );
                $GottenMoon       = sprintf ($lang['sys_moonbuilt'], $TargetPlanetName, $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
                $GottenMoon .= "<br />";
            } elseif ($UserChance = 0 or $UserChance > $MoonChance) {
                $GottenMoon = "";
            }

            $formatted = $this->formatCR2($result,$robado,$MoonChance,$GottenMoon,$totaltime);
            $reporte = $formatted['html'];

            $hash = md5($reporte);

            $InsertRapport  = 'INSERT INTO {{table}} SET ';
            $InsertRapport .= '`time` = UNIX_TIMESTAMP(), ';
            $users = '';
            for($i = 0; $i < count($Fleets['fleet_id']); $i++){
                $users .= $fleet[$i]['fleet_owner'].",";
            }
            $users .= $TargetUser['id'];
            $InsertRapport .= '`owners` = "'.$users.'", ';
            $InsertRapport .= '`rid` = "'. $hash .'", ';
            $InsertRapport .= '`raport` = "'. mysql_real_escape_string( $reporte ) .'"';
            $db->query($InsertRapport, 'rw') or die("Error insertando el reporte a la base de datos".mysql_error()."<br /><br />Prueba a ejecutar:".mysql_query());

            $reporte  = '<a href # OnClick=\'f( "CombatReport.php?raport='. $hash .'", "");\' >';
            $reporte .= '<center>';
            if       ($result['won'] == "a") {
                $reporte .= '<font color=\'green\'>';
            } elseif ($result['won'] == "w") {
                $reporte .= '<font color=\'orange\'>';
            } elseif ($result['won'] == "r") {
                $reporte .= '<font color=\'red\'>';
            }
            $reporte .= $lang['sys_mess_attack_report'] .' ['. $FleetRow['fleet_end_galaxy'] .':'. $FleetRow['fleet_end_system'] .':'. $FleetRow['fleet_end_planet'] .'] </font></a><br /><br />';
            $reporte .= '<font color=\'red\'>'. $lang['sys_perte_attaquant'] .': '. $result['lost']['att'] .'</font>';
            $reporte .= '<font color=\'green\'>   '. $lang['sys_perte_defenseur'] .': '. $result['lost']['def'] .'</font><br />' ;
            $reporte .= $lang['sys_gain'] .' '. $lang['Metal'] .':<font color=\'#adaead\'>'. $steal['metal'] .'</font>   '. $lang['Crystal'] .':<font color=\'#ef51ef\'>'. $steal['crystal'] .'</font>   '. $lang['Deuterium'] .':<font color=\'#f77542\'>'. $steal['deuterium'] .'</font><br />';
            $reporte .= $lang['sys_debris'] .' '. $lang['Metal'] .': <font color=\'#adaead\'>'. ($result['debree']['att'][0]+$result['debree']['def'][0]) .'</font>   '. $lang['Crystal'] .': <font color=\'#ef51ef\'>'. ($result['debree']['att'][1]+$result['debree']['def'][1]) .'</font><br /></center>';

            for($i = 0; $i < count($Fleets['fleet_id']); $i++){
                $users2[$i] = $fleet[$i]['fleet_owner'];
                $users->SendSimpleMessage ($users2[$i], '', $FleetData['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $reporte);
            }
            
            $users->SendSimpleMessage($TargetUser['id'], '', $FleetData['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $reporte);
        } else {
            $Fleets2 = $db->query("SELECT * FROM {{table}} WHERE fleet_group = '".$FleetData['fleet_group']."';", 'fleets');
            while($Fleets = mysql_fetch_array($Fleets2)){
                if ($Fleets['fleet_end_time'] < time()) {
                    $db->query('DELETE FROM {{table}} WHERE id="'.$Fleets['fleet_group'].'"', 'sac');
                    $this->RestoreFleetToPlanet($Fleets);
                    $db->query ('DELETE FROM {{table}} WHERE `fleet_id`='.$Fleets['fleet_id'].'', 'fleets');
                }
            }
        }
    }


    private function formatCR2(&$result_array, &$robado_array, &$moont_int, &$moon_string, &$time_float){
        global $lang, $db;
        $html = '';
        $bbc = '';

        $Date = date("r");
        $Title = sprintf($lang['sys_attack_title'], $Date);
        $html .= "<center>".$title."<br />";

        $round_no = 1;
        foreach($result_array['rw'] as $round => $data){
            $attackers = $data['attackers'];
            $attackers2 = $data['infoA'];
            $defenders = $data['defenders'];
            $defenders2 = $data['infoD'];

            foreach($attackers as $fleet_id => $data2){
                $name = $data2['user']['username'];
                $coordg = $data2['fleet']['fleet_start_galaxy'];
                $coords = $data2['fleet']['fleet_start_system'];
                $coordp = $data2['fleet']['fleet_start_planet'];
                $armas = $data2['user']['military_tech'] * 10;
                $escudo = $data2['user']['shield_tech'] * 10;
                $armadura = $data2['user']['defence_tech'] * 10;

                $coordg2 = $data2['fleet']['fleet_end_galaxy'];
                $coords2 = $data2['fleet']['fleet_end_system'];
                $coordp2 = $data2['fleet']['fleet_end_planet'];

                $pl_info = "<table><tr><th>";
                $pl_info .= sprintf($lang['sys_attack_attacker_pos'], $name, $coordg, $coords, $coordp);
                $pl_info .= "<br />";
                $pl_info .= sprintf($lang['sys_attack_technologies'], $armas, $escudo, $armadura);

                $table = "<table align=\"center\">";
                $naves = "<tr><th>".$lang['sys_ship_type']."</th>";
                $count = "<tr><th>".$lang['sys_ship_count']."</th>";

                foreach($data2 as $ship_id => $count){
                    if(isset($ship_id) && $ship_id > 0){
                        $ships .= "<th>".$lang['tech_rc'][$ship_id1]."</th>";
                        $count .= "<th>".$ship_count1."</th>";
                    }
                }

                $ships .= "</tr>";
                $count .= "</tr>";

                $info_part1[$fleet_id] = $pl_info.$table.$ships.$count;
            }
            foreach($attackers2 as $fleet_id2 => $data3){
                $armas1 = "<tr><th>".$lang['sys_ship_weapon']."</th>";
                $escudo1 = "<tr><th>".$lang['sys_ship_shield']."</th>";
                $armadura1 = "<tr><th>".$lang['sys_ship_armour']."</th>";

                foreach($data3 as $ship_id2 => $ship_points){
                    if($ship_points['def'] > 0){
                        $armas1 .= "<th>".$ship_points['att']."</th>";
                        $escudo1 .= "<th>".$ship_points['shield']."</th>";
                        $armadura1 .= "<th>".$ship_points['def']."</th>";
                    }
                }

                $armas1 .= "</tr>";
                $escudo1 .= "</tr>";
                $armadura1 .= "</tr>";
                $endtable = "</table></th></tr></table>";

                $info_part2[$fleet_id2] = $armas1.$escudo1.$armadura1.$endtable;

                $html .= $info_part1[$fleet_id2].$info_part2[$fleet_id2];
                $html .= "<br /><br />";
            }

            foreach($defenders as $fleet_id => $data){
                $name = $data['user']['username'];
                $armas = ($data['user']['military_tech'] * 10);
                $escudo = ($data['user']['shield_tech'] * 10);
                $armadura = ($data['user']['defence_tech'] * 10);

                $pl_info  = "<table><tr><th>";
                $pl_info .= sprintf ($lang['sys_attack_attacker_pos'], $name, $coordg2, $coords2, $coordp2 );
                $pl_info .= "<br>";
                $pl_info .= sprintf ($lang['sys_attack_techologies'], $armas, $escudo, $armadura);

                $table  = "<table border=1 align=\"center\">";

                $naves  = "<tr><th>".$lang['sys_ship_type']."</th>";
                $count  = "<tr><th>".$lang['sys_ship_count']."</th>";

                foreach( $data as $nave_id => $nave_count){
                    if ($ship_count1 > 1){
                        $naves .= "<th>".$lang['tech_rc'][$nave_id]."</th>";
                        $count .= "<th>".$nave_count."</th>";
                    }
                }

                $ships1 .= "</tr>";
                $count1 .= "</tr>";

                $info_part1[$fleet_id] = $pl_info.$table.$naves.$count;
            }
            foreach( $defenders2 as $fleet_id2 => $data3){
                $armas1 = "<tr><th>".$lang['sys_ship_weapon']."</th>";
                $escudo1 = "<tr><th>".$lang['sys_ship_shield']."</th>";
                $armadura1 = "<tr><th>".$lang['sys_ship_armour']."</th>";

                foreach( $data3 as $nave_id2 => $nave_points){
                    if ($ship_points1['def'] > 0){
                        $armas1 .= "<th>".$nave_points['att']."</th>";
                        $escudos1 .= "<th>".$nave_points['shield']."</th>";
                        $armadura1 .= "<th>".$nave_points['def']."</th>";
                    }
                }

                $armas1 .= "</tr>";
                $escudo1 .= "</tr>";
                $armadura1 .= "</tr>";
                $endtable .= "</table></th></tr></table>";

                $info_part2[$fleet_id2] = $armas1.$escudo1.$armadura1.$endtable;

                $html .= $info_part1[$fleet_id2].$info_part2[$fleet_id2];
                $html .= "<br /><br />";
            }

                $AttackWaveStat    = sprintf ($lang['sys_attack_attack_wave'], floor($data['attack']['total']), floor($data['defShield']));
                $DefendWavaStat    = sprintf ($lang['sys_attack_defend_wave'], floor($data['defense']['total']), floor($data['attackShield']));
                $html           .= "<br /><center>".$AttackWaveStat."<br />".$DefendWavaStat."</center>";
                $round_no++;
            }

            if ($result_array['won'] == 2){
                $result  = "Los defensores ganan la batalla<br />";
            }elseif ($result_array['won'] == 1){
                $result  = "Los atacantes ganan la batalla<br />";
                $result .= "He captured ".$robado_array['metal']." Metal, ".$robado_array['crystal']." Crystal, and ".$robado_array['deuterium']." Deuterium<br />";
            }else{
                $result  = "La batalla termina en empate.<br />";
            }

            $html .= "<br /><br />";
            $html .= $result;
            $html .= "<br />";

            $debirs_meta = ($result_array['debree']['att'][0] + $result_array['debree']['def'][0]);
            $debirs_crys = ($result_array['debree']['att'][1] + $result_array['debree']['def'][1]);
            $html .= "El atacante ha perdido un total de ".$result_array['lost']['att']." unidades.<br />";
            $html .= "El defensor ha perdido un total de ".$result_array['lost']['def']." unidades.<br />";
            $html .= "En estas coordenadas ahora flotan ".$debirs_meta." Metal y ".$debirs_crys." Cristal.<br /><br />";

            $html .= "El porcentaje para crear una luna es ".$moon_int."%<br />";
            $html .= $moon_string."<br /><br />";

            $html .= "Reporte generado en ".$time_float." segundos<br />";
            //print_r($data);

            return array('html' => $html, 'bbc' => $bbc);
    }

    function CalculateAttack(&$attackers, &$defenders){
        global $db, $pricelist, $CombatCaps, $resource;

        $ResourcePoints = array('attackers' => 0, 'defenders' => 0);
        $PointsAttackers = array('metal' => 0, 'crystal' => 0);

        foreach($attackers as $id => $attacker){
            foreach($attacker['fleet'] as $Element => $amount){
                $PointsAttackers['metal'] += $pricelist[$Element]['metal'] * $amount;
                $PointsAttackers['crystal'] += $pricelist[$Element]['crystal'] * $amount;

                $ResourcePoints['attackers'] += $pricelist[$Element]['metal'] * $amount;
                $ResourcePoints['attackers'] += $pricelist[$Element]['crystal'] * $amount;
            }
        }
        
        $PointsDefenders = array('metal' => 0, 'crystal' => 0);

        foreach($defenders as $id => $defender){
            foreach($defender['fleet'] as $Element => $amount){
                $PointsDefenders['metal'] += $pricelist[$Element]['metal'] * $amount;
                $PointsDefenders['crystal'] += $pricelist[$Element]['crystal'] * $amount;

                $ResourcePoints['defenders'] += $pricelist[$Element]['metal'] * $amount;
                $ResourcePoints['defenders'] += $pricelist[$Element]['crystal'] * $amount;
            }
        }
        $max_rounds = 7;

        for($round = 0; $round < $max_rounds; $round++){
            $attDamage = array('total' => 0);
            $attShield = array('total' => 0);
            $attAmount = array('total' => 0);
            $defDamage = array('total' => 0);
            $defShield = array('total' => 0);
            $defAmount = array('total' => 0);

            $att = array();
            $def = array();
            echo "Ronda ".$round."<br>";
            print_r($attackers);
            print_r($defenders);
             echo "<br>";
            foreach($attackers as $id => $attacker){
                

                foreach($attacker['fleet'] as $Element => $amount){
                    $attDamage[$Element] = 0;
                    $attShield[$Element] = 0;
                    $attAmount[$Element] = 0;
                    
                    $defTech = (1+ (0.1 * $attacker['user']['defence_tech'] + (0.05 * $attacker['user']['rpg_amiral'])));
                    $shieldTech = (1+ (0.1 * $attacker['user']['shield_tech'] + (0.05 * $attacker['user']['rpg_amiral'])));
                    $attTech = (1+(0.1 * $attacker['user']['military_tech'] + (0.05 * $attacker['user']['rpg_amiral'])));

                    $attackers[$id]['techs'] = array($defTech, $shieldTech, $attTech);
                    
                    if($Element > 200 && $Element < 500){
                        $thisDef = $CombatCaps[$Element]['shield'] * $amount;
                        $thisShield = ($pricelist[$Element]['metal'] + $pricelist[$Element]['crystal']) * $amount;
                        $thisAtt = $CombatCaps[$Element]['attack'] * $amount;
                    }

                    $attArray[$id][$Element] = array('def' => $thisDef, 'shield' => $thisShield, 'att' => $thisAtt);
                    $attDamage[$Element] += $thisAtt;
                    $attDamage['total'] += $thisAtt;
                    $attShield[$Element] += $thisDef;
                    $attShield['total'] += $thisDef;
                    $attAmount[$Element] += $amount;
                    $attAmount['total'] += $amount;
                }
            }
            foreach($defenders as $id => $defender){
                
                foreach($defender['fleet'] as $Element => $amount){
                    $defDamage[$Element] = 0;
                    $defShield[$Element] = 0;
                    $defAmount[$Element] = 0;
                    
                    $defTech    = (1 + (0.1 * ($defender['user']['defence_tech']) + (0.05 * $defender['user']['rpg_amiral'])));
                    $shieldTech = (1 + (0.1 * ($defender['user']['shield_tech']) + (0.05 * $defender['user']['rpg_amiral'])));
                    $attTech	= (1 + (0.1 * ($defender['user']['military_tech']) + (0.05 * $defender['user']['rpg_amiral'])));

                    $defenders[$id]['techs'] = array($defTech, $shieldTech, $attTech);
                    
                    $thisDef = $CombatCaps[$Element]['shield'] * $amount;
                    $thisShield = ($pricelist[$Element]['metal'] + $pricelist[$Element]['crystal']) * $amount;
                    $thisAtt = $CombatCaps[$Element]['attack'] * $amount;

                    if($Element == 407 or $Element == 408) $thisAtt = 0;

                    $defArray[$id][$Element] = array('def' => $thisDef, 'shield' => $thisShield, 'att' => $thisAtt);

                    $defDamage[$Element] += $thisAtt;
                    $defDamage['total'] += $thisAtt;
                    $defShield[$Element] += $thisDef;
                    $defShield['total'] += $thisDef;
                    $defAmount[$Element] += $amount;
                    $defAmount['total'] += $amount;
                }
            }
            
            $rounds[$round] = array('attacker' => $attackers, 'defenders' => $defenders, 'attack' => $attDamage, 'defense' => $defDamage, 'attackA' => $attAmount, 'defA' => $defAmount, 'infoA' => $attArray, 'infoD' => $defArray);

            if($defAmount['total'] <= 0 || $attAmount['total'] <= 0){
                break;
            }

           /* $attackPct = array();
            foreach ($attAmount as $id => $amount) {
                if (!is_numeric($id)) continue;
                $attackPct[$id] = $amount / $attAmount['total'];
            }

            $defensePct = array();
            foreach ($defAmount as $id => $amount) {
                if (!is_numeric($id)) continue;
                $defensePct[$id] = $amount / $defAmount['total'];
            }*/

            print_r($attackPct);
            $attacker_n = array();
            $attacker_shield = 0;
            foreach($attackers as $id => $attacker){
                $attacker_n[$id] = array();
                foreach($attacker['fleet'] as $Element => $amount){
                    $attacker_n[$id][$Element]['shield'] = $amount * $CombatCaps[$Element]['shield'];
                    $attacker_n[$id]['total']['shield'] += $attacker_n[$Element]['shield'];
                    $attacker_n[$id][$Element]['att'] = $amount * $CombatCaps[$Element]['attack'];
                    $attacker_n[$id]['total']['att'] += $attacker_n[$Element]['att'];
                    $attacker_n[$id][$Element]['sd'] = $CombatCaps[$Element]['sd'];
                    $attacker_shield += $attacker_n[$id]['total']['shield'];
                }
            }
            
            $defender_n = array();
            $defender_shield = 0;

            foreach($defenders as $id => $defender){
                $defender_n[$id] = array();
                foreach($defender['fleet'] as $Element => $amount){
                    //$defender[$Element] = $defArray[$id][$Element];
                    $defender_n[$id][$Element]['shield'] = $amount * $CombatCaps[$Element]['shield'];
                    $defender_n[$id]['total']['shield'] += $defender_n[$Element]['shield'];
                    $defender_n[$id][$Element]['att'] = $amount * $CombatCaps[$Element]['attack'];
                    $defender_n[$id]['total']['att'] += $defender_n[$Element]['att'];
                    $defender_n[$id][$Element]['sd'] = $CombatCaps[$Element]['sd'];
                    $defender_shield += $defender_n[$id]['total']['shield'];
                }
            }
            if($round == 0){

                foreach($attackers as $id => $attacker){
                    foreach($attacker['fleet'] as $Element => $amount){
                        foreach($attacker_n[$id][$Element]['sd'] as $SDVictim => $Count){
                            foreach($defenders as $idd => $defender){
                                //echo $defArray[$idd][$SDVictim];
                                if(isset($defArray[$idd][$SDVictim])){
                                    //$defArray[$idd][$SDVictim] -= abs($Count * $amount * 85 / 100);
                                    //$defAmount[$SDVictim] -= abs($Count * $amount * .85);
                                    $delete = abs($Count * $amount * .85);
                                    $defShield[$SDVictim] -=$delete;
                                    echo $defShield[$SDVictim]."=({$SDVictim})==".$Count." * ".$amount." .85 ==$delete<br>";
                                    $defShield['total'] -= $delete;
                                }
                            }
                        }
                    }
                }
                

                foreach($defenders as $id => $defender){
                    foreach($defender['fleet'] as $Element => $amount){
                        foreach($defender_n[$id][$Element]['sd'] as $SDVictim => $Count){
                            foreach($attackers as $idd => $attacker){
                                if(isset($attArray[$idd][$SDVictim])){
                                    $attArray[$idd][$SDVictim]["count"] -= abs($Count * $amount * 85 / 100);
                                    $delete = abs($Count * $amount * 0.85);
                                    $attAmount[$SDVictim] -= $delete;

                                    $attAmount['total'] -= $delete;
                                }
                            }
                        }
                    }
                }
                
                foreach($attackers as $id => $attacker){
                    foreach($attacker as $Element => $amount){
                        $attackers[$id]['fleet'][$Element] = $attArray[$id][$Element];
                    }
                }
                echo "<br><br>";
                echo "HOLA";
            }else{
            $MayorCount = 0;
            //while($round > 0){
                echo "HOLA2";
                $PotenciaRestante = -1;
                while($PotenciaRestante != 0){
                    $DefType = array();
                    $PotenciaAtt = 0;

                    foreach($attackers as $id => $attacker){
                        foreach($attacker['fleet'] as $Element => $Amount){
                            if($PotenciaRestante == -1){
                                $PotenciaAtt += $CombatCaps[$Element]['attack'];
                            } else {
                                $PotenciaAtt = $PotenciaRestante;
                            }

                            foreach($defenders as $idd => $defender){
                                foreach($defender["fleet"] as $Type => $Count){
                                    if($PotenciaAtt > ($CombatCaps[$Type]['shield'] * $Count)){
                                        $PotenciaTotalAtt[$id] = $PotenciaAtt - ($CombatCaps[$Type]['shield'] * $Count);
                                    } else {
                                        $PotenciaTotalAtt[$id] = 0;
                                    }
                                    $j = 0;
                                    $amount[$Type] = $Count;
                                    $DefType[$j] = $Type;
                                    $j++;
                                    for($i = 0; $i < count($DefType); $i++){
                                        $MayorCount += $amount[$DefType[$i]];
                                        $aux = $amount[$DefType[$i]];
                                        if(($aux - $MayorCount) > $aux){ continue; }
                                        elseif(($MayorCount-$aux) < $aux){ $MayorCount = $aux; }
                                        else { $MayorCount = $aux; }
                                    }
                                    $EnemiesDestroyed[$Type] = $PotenciaTotalAtt[$id] / $MayorCount;
                                    
                                    if($EnemiesDestroyed[$Type] >= $MayorCount){
                                        $defender["fleet"][$Type] = 0;
                                        $defAmount[$Type] = 0;
                                        $defAmount['total'] -= $MayorCount;
                                    }
                                    if($defender['fleet'][$Type] <= 0){
                                        $PotenciaRestante = $PotenciaTotalAtt[$id] - ($CombatCaps[$Type]['shield'] * $Count);
                                    }
                                }
                            }
                        }
                    }
                }

                $PotenciaRestante = -1;
                while($PotenciaRestante != 0){
                    $AttType = array();
                    $PotenciaDef = 0;
                    foreach($defenders as $id => $defender){
                        foreach($defender['fleet'] as $Element => $Amount){
                            if($PotenciaRestante == -1){
                                $PotenciaDef += $CombatCaps[$Element]['attack'];
                            } else {
                                $PotenciaDef = $PotenciaRestante;
                            }
                            foreach($attackers as $idd => $attacker){
                                foreach($attacker["fleet"] as $Type => $Count){
                                    if($PotenciaDef > ($CombatCaps[$Type]['shield'] * $Count)){
                                        $PotenciaTotalDef[$id] = $PotenciaDef - ($CombatCaps[$Type]['shield'] * $Count);
                                    } else {
                                        $PotenciaTotalDef[$id] = 0;
                                    }
                                    $j = 0;
                                    $amount[$Type] = $Count;
                                    $DefType[$j] = $Type;
                                    $j++;
                                    for($i = 0; $i < count($DefType); $i++){
                                        $MayorCount += $amount[$DefType[$i]];
                                        $aux = $amount[$DefType[$i]];
                                        if(($aux - $MayorCount) > $aux){ continue; }
                                        elseif(($MayorCount-$aux) < $aux){ $MayorCount = $aux; }
                                        else { $MayorCount = $aux; }
                                    }
                                    $EnemiesDestroyed[$Type] = $PotenciaTotalDef[$id] / $MayorCount;
                                   
                                    if($EnemiesDestroyed[$Type] >= $MayorCount){
                                        echo "HOLA";
                                        $attacker["fleet"][$Type] = 0;
                                        $attAmount[$Type] = 0;
                                        $attAmount['total'] -= $MayorCount;
                                       
                                    }
                                    if($attacker['fleet'][$Type] <= 0){
                                        $PotenciaRestante = $PotenciaTotalDef[$id] - ($CombatCaps[$Type]['shield'] * $Count);
                                    }
                                }
                            }
                        }
                    }
                }

                $round++;
            }
            $rounds[$round]['attShield'] = $attacker_shield;
            $rounds[$round]['defShield'] = $defender_shield;

            foreach ($attackers as $id => $attacker) {
                $attackers[$id]['fleet'] = array_map('round', $attacker_n[$id]);
            }

            foreach ($defenders as $id => $defender) {
                $defenders[$id]['fleet'] = array_map('round', $defender_n[$id]);
            }
        }

        if($attAmount['total'] <= 0){ $won = 2; }
        elseif($defAmount['total'] <= 0){ $won = 1; }
        else { $won = 0; }

        foreach($attackers as $id => $attacker){
            foreach($attacker['fleet'] as $Element => $amount){
                $ResourcePoints['attacker'] -= $pricelist[$Element]['metal'] * $amount;
                $ResourcePoints['attacker'] -= $pricelist[$Element]['crystal'] * $amount;

                $PointsAttackers['metal'] -= $pricelist[$Element]['metal'] * $amount;
                $PointsAttackers['crystal'] -= $pricelist[$Element]['crystal'] * $amount;
            }
        }

        foreach ($defenders as $id => $defender) {
            foreach ($defender['fleet'] as $Element => $amount) {								//Line271
                if ($Element < 300) {
                    $PointsDefenders['metal'] -= $pricelist[$Element]['metal'] * $amount;
                    $PointsDefenders['crystal'] -= $pricelist[$Element]['crystal'] * $amount;

                    $ResourcePoints['defenders'] -= $pricelist[$Element]['metal'] * $amount;
                    $ResourcePoints['defenders'] -= $pricelist[$Element]['crystal'] * $amount;

                    $PointsDefenders['flota']['metal'] = $PointsDefenders['metal'];
                    $PointsDefenders['flota']['crystal'] = $PointsDefenders['metal'];
                } else {
                    $PointsDefenders['metal']   -= $pricelist[$Element]['metal'] * $amount;
                    $PointsDefenders['crystal'] -= $pricelist[$Element]['crystal'] * $amount;

                    $ResourcePoints['defenders'] -= $pricelist[$Element]['metal'] * $amount;
                    $ResourcePoints['defenders'] -= $pricelist[$Element]['crystal'] * $amount;

                    $PointsDefenders['def']['metal'] = $PointsDefenders['metal'];
                    $PointsDefenders['def']['crystal'] = $PointsDefenders['crystal'];
                }
            }
        }

        $TotalLost = array('att' => $ResourcePoints['attacker'], 'def' => $ResourcePoints['defenders']);
        $debAttMet = ($PointsAttackers['metal'] * 0.8);
        $debAttCry = ($PointsAttackers['crystal'] * 0.8);
        $debDefMet = ($PointsDefenders['flota']['metal'] * 0.8)+($PointsDefenders['def']['metal'] * 0.08);
        $debDefCry = ($PointsDefenders['flota']['crystal'] * 0.8)+($PointsDefenders['def']['crystal'] * 0.08);

        return array('won' => $won, 'debree' => array('att' => array($debAttMet, $debAttCry), 'def' => array($debDefMet, $debDefCry)), 'rw' => $rounds, 'lost' => $TotalLost);
    }


	private function SpyTarget ($TargetPlanet, $Mode, $TitleString)
	{
		global $db,$lang, $resource;

		$LookAtLoop = true;
		if ($Mode == 0)
		{
			$String  = "<table width=\"440\"><tr><td class=\"c\" colspan=\"5\">";
			$String .= $TitleString ." ". $TargetPlanet['name'];
			$String .= " <a href=\"game.php?page=galaxy&mode=3&galaxy=". $TargetPlanet["galaxy"] ."&system=". $TargetPlanet["system"]. "\">";
			$String .= "[". $TargetPlanet["galaxy"] .":". $TargetPlanet["system"] .":". $TargetPlanet["planet"] ."]</a>";
			$String .= " le ". gmdate("d-m-Y H:i:s", time() + 2 * 60 * 60) ."</td>";
			$String .= "</tr><tr>";
			$String .= "<td width=220>". $lang['Metal']     ."</td><td width=220 align=right>". pretty_number($TargetPlanet['metal'])      ."</td><td>&nbsp;</td>";
			$String .= "<td width=220>". $lang['Crystal']   ."</td></td><td width=220 align=right>". pretty_number($TargetPlanet['crystal'])    ."</td>";
			$String .= "</tr><tr>";
			$String .= "<td width=220>". $lang['Deuterium'] ."</td><td width=220 align=right>". pretty_number($TargetPlanet['deuterium'])  ."</td><td>&nbsp;</td>";
			$String .= "<td width=220>". $lang['Energy']    ."</td><td width=220 align=right>". pretty_number($TargetPlanet['energy_max']) ."</td>";
			$String .= "</tr>";
			$LookAtLoop = false;
		}
		elseif ($Mode == 1)
		{
			$ResFrom[0] = 200;
			$ResTo[0]   = 299;
			$Loops      = 1;
		}
		elseif ($Mode == 2)
		{
			$ResFrom[0] = 400;
			$ResTo[0]   = 499;
			$ResFrom[1] = 500;
			$ResTo[1]   = 599;
			$Loops      = 2;
		}
		elseif ($Mode == 3)
		{
			$ResFrom[0] = 1;
			$ResTo[0]   = 99;
			$Loops      = 1;
		}
		elseif ($Mode == 4)
		{
			$ResFrom[0] = 100;
			$ResTo[0]   = 199;
			$Loops      = 1;
		}

		if ($LookAtLoop == true)
		{
			$String  = "<table width=\"440\" cellspacing=\"1\"><tr><td class=\"c\" colspan=\"". ((2 * SPY_REPORT_ROW) + (SPY_REPORT_ROW - 1))."\">". $TitleString ."</td></tr>";
			$Count       = 0;
			$CurrentLook = 0;
			while ($CurrentLook < $Loops)
			{
				$row     = 0;
				for ($Item = $ResFrom[$CurrentLook]; $Item <= $ResTo[$CurrentLook]; $Item++)
				{
					if ( $TargetPlanet[$resource[$Item]] > 0)
					{
						if ($row == 0)
							$String  .= "<tr>";

						$String  .= "<td align=left>".$lang['tech'][$Item]."</td><td align=right>".$TargetPlanet[$resource[$Item]]."</td>";
						if ($row < SPY_REPORT_ROW - 1)
							$String  .= "<td>&nbsp;</td>";

						$Count   += $TargetPlanet[$resource[$Item]];
						$row++;
						if ($row == SPY_REPORT_ROW)
						{
							$String  .= "</tr>";
							$row      = 0;
						}
					}
				}

				while ($row != 0)
				{
					$String  .= "<td>&nbsp;</td><td>&nbsp;</td>";
					$row++;
					if ($row == SPY_REPORT_ROW)
					{
						$String  .= "</tr>";
						$row      = 0;
					}
				}
				$CurrentLook++;
			}
		}
		$String .= "</table>";

		$return['String'] = $String;
		$return['Count']  = $Count;

		return $return;
	}

	private function walka ($CurrentSet, $TargetSet, $CurrentTechno, $TargetTechno)
	{
		global $db,$pricelist, $CombatCaps, $users;

		$runda       = array();
		$atakujacy_n = array();
		$wrog_n      = array();

		if (!is_null($CurrentSet))
		{
			$atakujacy_zlom_poczatek['metal']   = 0;
			$atakujacy_zlom_poczatek['crystal'] = 0;
			foreach($CurrentSet as $a => $b)
			{
				$atakujacy_zlom_poczatek['metal']   = $atakujacy_zlom_poczatek['metal']   + $CurrentSet[$a]['count'] * $pricelist[$a]['metal'];
				$atakujacy_zlom_poczatek['crystal'] = $atakujacy_zlom_poczatek['crystal'] + $CurrentSet[$a]['count'] * $pricelist[$a]['crystal'];
			}
		}

		$wrog_zlom_poczatek['metal']   	= 0;
		$wrog_zlom_poczatek['crystal'] 	= 0;
		$wrog_poczatek 			= $TargetSet;

		if (!is_null($TargetSet))
		{
			foreach($TargetSet as $a => $b)
			{
				if ($a < 300)
				{
					$wrog_zlom_poczatek['metal']   = $wrog_zlom_poczatek['metal']   + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
					$wrog_zlom_poczatek['crystal'] = $wrog_zlom_poczatek['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
				}
				else
				{
					$wrog_zlom_poczatek_obrona['metal']   = $wrog_zlom_poczatek_obrona['metal']   + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
					$wrog_zlom_poczatek_obrona['crystal'] = $wrog_zlom_poczatek_obrona['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
				}
			}
		}

		for ($i = 1; $i <= 6; $i++)
		{
			$atakujacy_atak   = 0;
			$wrog_atak        = 0;
			$atakujacy_obrona = 0;
			$wrog_obrona      = 0;
			$atakujacy_ilosc  = 0;
			$wrog_ilosc       = 0;
			$wrog_tarcza      = 0;
			$atakujacy_tarcza = 0;

			if (!is_null($CurrentSet))
			{
				foreach($CurrentSet as $a => $b)
				{
					$CurrentSet[$a]["obrona"] 	= $CurrentSet[$a]['count'] * ($pricelist[$a]['metal'] + $pricelist[$a]['crystal']) / 10 * (1 + (0.1 * ($CurrentTechno["defence_tech"]) + (0.05 * $users->user['rpg_amiral'])));
					$rand 						= rand(80, 120) / 100;
					$CurrentSet[$a]["tarcza"] 	= $CurrentSet[$a]['count'] * $CombatCaps[$a]['shield'] * (1 + (0.1 * $CurrentTechno["shield_tech"]) + (0.05 * $users->user['rpg_amiral'])) * $rand;
					$atak_statku 				= $CombatCaps[$a]['attack'];
					$technologie 				= (1 + (0.1 * $CurrentTechno["military_tech"]+(0.05 * $users->user['rpg_amiral'])));
					$rand 						= rand(80, 120) / 100;
					$ilosc 						= $CurrentSet[$a]['count'];
					$CurrentSet[$a]["atak"] 	= $ilosc * $atak_statku * $technologie * $rand;
					$atakujacy_atak			 	= $atakujacy_atak + $CurrentSet[$a]["atak"];
					$atakujacy_obrona 			= $atakujacy_obrona + $CurrentSet[$a]["obrona"];
					$atakujacy_ilosc 			= $atakujacy_ilosc + $CurrentSet[$a]['count'];
				}
			}
			else
			{
				$atakujacy_ilosc = 0;
				break;
			}

			if (!is_null($TargetSet))
			{
				foreach($TargetSet as $a => $b)
				{
					$TargetSet[$a]["obrona"] 	= $TargetSet[$a]['count'] * ($pricelist[$a]['metal'] + $pricelist[$a]['crystal']) / 10 * (1 + (0.1 * ($TargetTechno["defence_tech"]) + (0.05 * $users->user['rpg_amiral'])));
					$rand 						= rand(80, 120) / 100;
					$TargetSet[$a]["tarcza"] 	= $TargetSet[$a]['count'] * $CombatCaps[$a]['shield'] * (1 + (0.1 * $TargetTechno["shield_tech"])+ (0.05 * $users->user['rpg_amiral'])) * $rand;
					$atak_statku 				= $CombatCaps[$a]['attack'];
					$technologie 				= (1 + (0.1 * $TargetTechno["military_tech"]) + (0.05 * $users->user['rpg_amiral']));
					$rand 						= rand(80, 120) / 100;
					$ilosc 						= $TargetSet[$a]['count'];
					$TargetSet[$a]["atak"] 		= $ilosc * $atak_statku * $technologie * $rand;
					$wrog_atak 					= $wrog_atak + $TargetSet[$a]["atak"];
					$wrog_obrona 				= $wrog_obrona + $TargetSet[$a]["obrona"];
					$wrog_ilosc 				= $wrog_ilosc + $TargetSet[$a]['count'];
				}
			}
			else
			{
				$wrog_ilosc 						= 0;
				$runda[$i]["atakujacy"] 			= $CurrentSet;
				$runda[$i]["wrog"] 					= $TargetSet;
				$runda[$i]["atakujacy"]["atak"] 	= $atakujacy_atak;
				$runda[$i]["wrog"]["atak"] 			= $wrog_atak;
				$runda[$i]["atakujacy"]['count'] 	= $atakujacy_ilosc;
				$runda[$i]["wrog"]['count'] 		= $wrog_ilosc;
				break;
			}

			$runda[$i]["atakujacy"] 			= $CurrentSet;
			$runda[$i]["wrog"] 					= $TargetSet;
			$runda[$i]["atakujacy"]["atak"] 	= $atakujacy_atak;
			$runda[$i]["wrog"]["atak"] 			= $wrog_atak;
			$runda[$i]["atakujacy"]['count']	= $atakujacy_ilosc;
			$runda[$i]["wrog"]['count'] 		= $wrog_ilosc;

			if (($atakujacy_ilosc == 0) or ($wrog_ilosc == 0)) {
				break;
			}
			foreach($CurrentSet as $a => $b)
			{
				if ($atakujacy_ilosc > 0)
				{
					$wrog_moc = $CurrentSet[$a]['count'] * $wrog_atak / $atakujacy_ilosc;
					if ($CurrentSet[$a]["tarcza"] < $wrog_moc)
					{
						$max_zdjac = floor($CurrentSet[$a]['count'] * $wrog_ilosc / $atakujacy_ilosc);
						$wrog_moc = $wrog_moc - $CurrentSet[$a]["tarcza"];
						$atakujacy_tarcza = $atakujacy_tarcza + $CurrentSet[$a]["tarcza"];
						$ile_zdjac = floor(($wrog_moc / (($pricelist[$a]['metal'] + $pricelist[$a]['crystal']) / 10)));

						if ($ile_zdjac > $max_zdjac)
							$ile_zdjac = $max_zdjac;
						$atakujacy_n[$a]['count'] = ceil($CurrentSet[$a]['count'] - $ile_zdjac);

						if ($atakujacy_n[$a]['count'] <= 0)
							$atakujacy_n[$a]['count'] = 0;
					}
					else
					{
						$atakujacy_n[$a]['count'] = $CurrentSet[$a]['count'];
						$atakujacy_tarcza = $atakujacy_tarcza + $wrog_moc;
					}
				}
				else
				{
					$atakujacy_n[$a]['count'] = $CurrentSet[$a]['count'];
					$atakujacy_tarcza = $atakujacy_tarcza + $wrog_moc;
				}
			}

			foreach($TargetSet as $a => $b)
			{
				if ($wrog_ilosc > 0)
				{
					$atakujacy_moc = $TargetSet[$a]['count'] * $atakujacy_atak / $wrog_ilosc;
					if ($TargetSet[$a]["tarcza"] < $atakujacy_moc)
					{
						$max_zdjac = floor($TargetSet[$a]['count'] * $atakujacy_ilosc / $wrog_ilosc);
						$atakujacy_moc = $atakujacy_moc - $TargetSet[$a]["tarcza"];
						$wrog_tarcza = $wrog_tarcza + $TargetSet[$a]["tarcza"];

						$ile_zdjac = floor(($atakujacy_moc / (($pricelist[$a]['metal'] + $pricelist[$a]['crystal']) / 10)));

						if ($ile_zdjac > $max_zdjac)
							$ile_zdjac = $max_zdjac;

						$wrog_n[$a]['count'] = ceil($TargetSet[$a]['count'] - $ile_zdjac);

						if ($wrog_n[$a]['count'] <= 0)
							$wrog_n[$a]['count'] = 0;
					}
					else
					{
						$wrog_n[$a]['count'] = $TargetSet[$a]['count'];
						$wrog_tarcza = $wrog_tarcza + $atakujacy_moc;
					}
				}
				else
				{
					$wrog_n[$a]['count'] = $TargetSet[$a]['count'];
					$wrog_tarcza = $wrog_tarcza + $atakujacy_moc;
				}
			}

			foreach($CurrentSet as $a => $b)
			{
				foreach ($CombatCaps[$a]['sd'] as $c => $d)
				{
					if (isset($TargetSet[$c]))
					{
						$wrog_n[$c]['count'] = $wrog_n[$c]['count'] - floor($d * rand(50, 100) / 100);
						if ($wrog_n[$c]['count'] <= 0)
							$wrog_n[$c]['count'] = 0;
					}
				}
			}

			foreach($TargetSet as $a => $b)
			{
				foreach ($CombatCaps[$a]['sd'] as $c => $d)
				{
					if (isset($CurrentSet[$c]))
					{
						$atakujacy_n[$c]['count'] = $atakujacy_n[$c]['count'] - floor($d * rand(50, 100) / 100);
						if ($atakujacy_n[$c]['count'] <= 0)
							$atakujacy_n[$c]['count'] = 0;
					}
				}
			}

			$runda[$i]["atakujacy"]["tarcza"] 	= $atakujacy_tarcza;
			$runda[$i]["wrog"]["tarcza"] 		= $wrog_tarcza;
			$TargetSet 							= $wrog_n;
			$CurrentSet 						= $atakujacy_n;
		}

		if (($atakujacy_ilosc == 0) or ($wrog_ilosc == 0))
		{
			if (($atakujacy_ilosc == 0) and ($wrog_ilosc == 0)) {
				$wygrana = "r";
			} else {
				if ($atakujacy_ilosc == 0) {
					$wygrana = "w";
				} else {
					$wygrana = "a";
				}
			}
		}else
		{
			$i = sizeof($runda);
			$runda[$i]["atakujacy"] = $CurrentSet;
			$runda[$i]["wrog"] = $TargetSet;
			$runda[$i]["atakujacy"]["atak"] = $atakujacy_atak;
			$runda[$i]["wrog"]["atak"] = $wrog_atak;
			$runda[$i]["atakujacy"]['count'] = $atakujacy_ilosc;
			$runda[$i]["wrog"]['count'] = $wrog_ilosc;
			$wygrana = "r";
		}

		$atakujacy_zlom_koniec['metal'] = 0;
		$atakujacy_zlom_koniec['crystal'] = 0;
		if (!is_null($CurrentSet))
		{
			foreach($CurrentSet as $a => $b)
			{
				$atakujacy_zlom_koniec['metal']   = $atakujacy_zlom_koniec['metal'] + $CurrentSet[$a]['count'] * $pricelist[$a]['metal'];
				$atakujacy_zlom_koniec['crystal'] = $atakujacy_zlom_koniec['crystal'] + $CurrentSet[$a]['count'] * $pricelist[$a]['crystal'];
			}
		}

		$wrog_zlom_koniec['metal'] = 0;
		$wrog_zlom_koniec['crystal'] = 0;
		if (!is_null($TargetSet))
		{
			foreach($TargetSet as $a => $b)
			{
				if ($a < 300)
				{
					$wrog_zlom_koniec['metal'] = $wrog_zlom_koniec['metal'] + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
					$wrog_zlom_koniec['crystal'] = $wrog_zlom_koniec['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
				}
				else
				{
					$wrog_zlom_koniec_obrona['metal'] = $wrog_zlom_koniec_obrona['metal'] + $TargetSet[$a]['count'] * $pricelist[$a]['metal'];
					$wrog_zlom_koniec_obrona['crystal'] = $wrog_zlom_koniec_obrona['crystal'] + $TargetSet[$a]['count'] * $pricelist[$a]['crystal'];
				}
			}
		}
		$ilosc_wrog = 0;
		$straty_obrona_wrog = 0;

		if (!is_null($TargetSet))
		{
			foreach($TargetSet as $a => $b)
			{
				if ($a > 300)
				{
					$straty_obrona_wrog = $straty_obrona_wrog + (($wrog_poczatek[$a]['count'] - $TargetSet[$a]['count']) * ($pricelist[$a]['metal'] + $pricelist[$a]['crystal']));
					$TargetSet[$a]['count'] = $TargetSet[$a]['count'] + (($wrog_poczatek[$a]['count'] - $TargetSet[$a]['count']) * rand(60, 80) / 100);
					$ilosc_wrog = $ilosc_wrog + $TargetSet[$a]['count'];
				}
			}
		}

		if (($ilosc_wrog > 0) && ($atakujacy_ilosc == 0)){
			$wygrana = "w";
		}

		$zlom['metal']    = ((($atakujacy_zlom_poczatek['metal']   - $atakujacy_zlom_koniec['metal'])   + ($wrog_zlom_poczatek['metal']   - $wrog_zlom_koniec['metal']))   * ($db->game_config['Fleet_Cdr'] / 100));
		$zlom['crystal']  = ((($atakujacy_zlom_poczatek['crystal'] - $atakujacy_zlom_koniec['crystal']) + ($wrog_zlom_poczatek['crystal'] - $wrog_zlom_koniec['crystal'])) * ($db->game_config['Fleet_Cdr'] / 100));

		$zlom['metal']   += ((($atakujacy_zlom_poczatek['metal']   - $atakujacy_zlom_koniec['metal'])   + ($wrog_zlom_poczatek['metal']   - $wrog_zlom_koniec['metal']))   * ($db->game_config['Defs_Cdr'] / 100));
		$zlom['crystal'] += ((($atakujacy_zlom_poczatek['crystal'] - $atakujacy_zlom_koniec['crystal']) + ($wrog_zlom_poczatek['crystal'] - $wrog_zlom_koniec['crystal'])) * ($db->game_config['Defs_Cdr'] / 100));

		$zlom["atakujacy"] = (($atakujacy_zlom_poczatek['metal'] - $atakujacy_zlom_koniec['metal']) + ($atakujacy_zlom_poczatek['crystal'] - $atakujacy_zlom_koniec['crystal']));
		$zlom["wrog"]      = (($wrog_zlom_poczatek['metal']      - $wrog_zlom_koniec['metal'])      + ($wrog_zlom_poczatek['crystal']      - $wrog_zlom_koniec['crystal']) + $straty_obrona_wrog);

		return array("atakujacy" => $CurrentSet, "wrog" => $TargetSet, "wygrana" => $wygrana, "dane_do_rw" => $runda, "zlom" => $zlom);
	}

        protected  function RestoreFleetToPlanet ($FleetRow, $Start = true)
	{
		global $db,$resource;

		$FleetRecord         = explode(";", $FleetRow['fleet_array']);
		$QryUpdFleet         = "";
		foreach ($FleetRecord as $Item => $Group)
		{
			if ($Group != '')
			{
				$Class        = explode (",", $Group);
				$QryUpdFleet .= "`". $resource[$Class[0]] ."` = `".$resource[$Class[0]]."` + '".$Class[1]."', \n";
			}
		}

		$QryUpdatePlanet   = "UPDATE {{table}} SET ";
		if ($QryUpdFleet != "")
			$QryUpdatePlanet  .= $QryUpdFleet;

		$QryUpdatePlanet  .= "`metal` = `metal` + '". $FleetRow['fleet_resource_metal'] ."', ";
		$QryUpdatePlanet  .= "`crystal` = `crystal` + '". $FleetRow['fleet_resource_crystal'] ."', ";
		$QryUpdatePlanet  .= "`deuterium` = `deuterium` + '". $FleetRow['fleet_resource_deuterium'] ."' ";
		$QryUpdatePlanet  .= "WHERE ";

		if ($Start == true)
		{
			$QryUpdatePlanet  .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
			$QryUpdatePlanet  .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
			$QryUpdatePlanet  .= "`planet` = '". $FleetRow['fleet_start_planet'] ."' AND ";
			$QryUpdatePlanet  .= "`planet_type` = '". $FleetRow['fleet_start_type'] ."' ";
		}
		else
		{
			$QryUpdatePlanet  .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
			$QryUpdatePlanet  .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
			$QryUpdatePlanet  .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
			$QryUpdatePlanet  .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."' ";
		}
		$QryUpdatePlanet  .= "LIMIT 1;";
		$db->query( $QryUpdatePlanet, 'planets');
	}

	private function StoreGoodsToPlanet ($FleetRow, $Start = false)
	{
                global $db;
		$QryUpdatePlanet   = "UPDATE {{table}} SET ";
		$QryUpdatePlanet  .= "`metal` = `metal` + '". $FleetRow['fleet_resource_metal'] ."', ";
		$QryUpdatePlanet  .= "`crystal` = `crystal` + '". $FleetRow['fleet_resource_crystal'] ."', ";
		$QryUpdatePlanet  .= "`deuterium` = `deuterium` + '". $FleetRow['fleet_resource_deuterium'] ."' ";
		$QryUpdatePlanet  .= "WHERE ";

		if ($Start == true)
		{
			$QryUpdatePlanet  .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
			$QryUpdatePlanet  .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
			$QryUpdatePlanet  .= "`planet` = '". $FleetRow['fleet_start_planet'] ."' AND ";
			$QryUpdatePlanet  .= "`planet_type` = '". $FleetRow['fleet_start_type'] ."' ";
		}
		else
		{
			$QryUpdatePlanet  .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
			$QryUpdatePlanet  .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
			$QryUpdatePlanet  .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
			$QryUpdatePlanet  .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."' ";
		}

		$QryUpdatePlanet  .= "LIMIT 1;";
		$db->query( $QryUpdatePlanet, 'planets');
	}

	private function sistema_mip($defensa, $militar, $mip, $def,$objetivo = '0')
	{
                global $CombatCaps;
    

                $destruido  = Array();
		$hull 	 = Array();
		$hull[0] = $CombatCaps[401]['shield']  * (1 + $defensa / 10)*10;
		$hull[1] = $CombatCaps[402]['shield']  * (1 + $defensa / 10)*10;
		$hull[2] = $CombatCaps[403]['shield']  * (1 + $defensa / 10)*10;
		$hull[3] = $CombatCaps[404]['shield']  * (1 + $defensa / 10)*10;
		$hull[4] = $CombatCaps[405]['shield']  * (1 + $defensa / 10)*10;
		$hull[5] = $CombatCaps[406]['shield']  * (1 + $defensa / 10)*10;
		$hull[6] = $CombatCaps[407]['shield']  * (1 + $defensa / 10)*10;
		$hull[7] = $CombatCaps[408]['shield']  * (1 + $defensa / 10)*10;
		$hull[8] = $CombatCaps[409]['shield']  * (1 + $defensa / 10)*10;

		$ataque = floor(($mip) * ($CombatCaps[503]['attack'] * (1 + ($militar / 10))));
                echo $ataque."<br>";
		if ($ataque < 0)$ataque = 0;

		switch ($objetivo)
		{
			case 0:
				$array_objetivos = Array(0, 1, 2, 3, 4, 5, 6, 7, 8);
			break;
			case 1:
				$array_objetivos = Array(1, 0, 2, 3, 4, 5, 6, 7, 8);
			break;
			case 2:
				$array_objetivos = Array(2, 0, 1, 3, 4, 5, 6, 7, 8);
			break;
			case 3:
				$array_objetivos = Array(3, 0, 1, 2, 4, 5, 6, 7, 8);
			break;
			case 4:
				$array_objetivos = Array(4, 0, 1, 2, 3, 5, 6, 7, 8);
			break;
			case 5:
				$array_objetivos = Array(5, 0, 1, 2, 3, 4, 6, 7, 8);
			break;
			case 6:
				$array_objetivos = Array(6, 0, 1, 2, 3, 4, 5, 7, 8);
			break;
			case 7:
				$array_objetivos = Array(7, 0, 1, 2, 3, 4, 5, 6, 8);
			break;
			case 8:
				$array_objetivos = Array(8, 0, 1, 2, 3, 4, 5, 6, 7);
			break;
		}

                foreach($def as $temp => $temp2)
		{
                        if ($ataque >= ($hull[$array_objetivos[$temp]] * $def[$array_objetivos[$temp]]))
			{

				$destruido[$array_objetivos[$temp]] += $def[$array_objetivos[$temp]];
                                $ataque -= ($hull[$array_objetivos[$temp]] * $def[$array_objetivos[$temp]]);
			}
			else
			{

                            if($ataque>0){
				$destruido[$array_objetivos[$temp]] += floor($ataque / $hull[$array_objetivos[$temp]]);
                                $ataque -= $hull[$array_objetivos[$temp]] * $hull[$array_objetivos[$temp]];
				if($ataque<0){
                                    $ataque=0;
                                }
                            }else{
                                $ataque=0;
                                $destruido[$array_objetivos[$temp]]+=0;
                            }
                        }

		}

		return $destruido;
	}



	private function MissionCaseTransport ( $FleetRow )
	{
		global $db,$lang,$users;
	$QryPlanet   = "SELECT p1.name as name1, p1.id_owner as id_owner1,p2.name as name2,p2.id_owner as id_owner2 FROM {{table}}planets as p1, {{table}}planets as p2 ";
	$QryPlanet  .= "WHERE (";
	$QryPlanet  .= "p1.galaxy = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
	$QryPlanet  .= "p1.system = '". $FleetRow['fleet_start_system'] ."' AND ";
	$QryPlanet  .= "p1.planet = '". $FleetRow['fleet_start_planet'] ."' AND ";
	$QryPlanet  .= "p1.planet_type = '". $FleetRow['fleet_start_type'] ."') AND (";
	$QryPlanet  .= "p2.galaxy = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
	$QryPlanet  .= "p2.system = '". $FleetRow['fleet_end_system'] ."' AND ";
	$QryPlanet  .= "p2.planet = '". $FleetRow['fleet_end_planet'] ."' AND ";
	$QryPlanet  .= "p2.planet_type = '". $FleetRow['fleet_end_type'] ."')";

	$Planet      = $db->query( $QryPlanet, '', true);
	$StartName        = $Planet['name1'];
	$StartOwner       = $Planet['id_owner1'];
	$TargetName       = $Planet['name2'];
	$TargetOwner      = $Planet['id_owner2'];

		if ($FleetRow['fleet_mess'] == 0)
		{
			if ($FleetRow['fleet_start_time'] < time())
			{
				$this->StoreGoodsToPlanet ($FleetRow, false);
				$Message         = sprintf( $lang['sys_tran_mess_owner'],
							$TargetName, GetTargetAdressLink($FleetRow, ''),
							$FleetRow['fleet_resource_metal'], $lang['Metal'],
							$FleetRow['fleet_resource_crystal'], $lang['Crystal'],
							$FleetRow['fleet_resource_deuterium'], $lang['Deuterium'] );

				$users->SendSimpleMessage ( $StartOwner, '', $FleetRow['fleet_start_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);
				if ($TargetOwner <> $StartOwner)
				{
					$Message         = sprintf( $lang['sys_tran_mess_user'],
									$StartName, GetStartAdressLink($FleetRow, ''),
									$TargetName, GetTargetAdressLink($FleetRow, ''),
									$FleetRow['fleet_resource_metal'], $lang['Metal'],
									$FleetRow['fleet_resource_crystal'], $lang['Crystal'],
									$FleetRow['fleet_resource_deuterium'], $lang['Deuterium'] );
					$users->SendSimpleMessage ( $TargetOwner, '', $FleetRow['fleet_start_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);
				}

				$QryUpdateFleet  = "UPDATE {{table}} SET ";
				$QryUpdateFleet .= "`fleet_resource_metal` = '0' , ";
				$QryUpdateFleet .= "`fleet_resource_crystal` = '0' , ";
				$QryUpdateFleet .= "`fleet_resource_deuterium` = '0' , ";
				$QryUpdateFleet .= "`fleet_mess` = '1' ";
				$QryUpdateFleet .= "WHERE `fleet_id` = '". $FleetRow['fleet_id'] ."' ";
				$QryUpdateFleet .= "LIMIT 1 ;";
				$db->query( $QryUpdateFleet, 'fleets');
			}
		}
		else
		{
			if ($FleetRow['fleet_end_time'] < time())
			{
				$Message             = sprintf ($lang['sys_tran_mess_back'], $StartName, GetStartAdressLink($FleetRow, ''));
				$users->SendSimpleMessage ( $StartOwner, '', $FleetRow['fleet_end_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
				$this->RestoreFleetToPlanet ( $FleetRow, true );
				$db->query("DELETE FROM {{table}} WHERE fleet_id=" . $FleetRow["fleet_id"], 'fleets');
			}
		}
	}

	private function MissionCaseStay($FleetRow)
	{
		global $db,$lang, $resource,$users;

		if ($FleetRow['fleet_mess'] == 0)
		{
			if ($FleetRow['fleet_start_time'] < time())
			{
				$QryGetTargetPlanet   = "SELECT * FROM {{table}} ";
				$QryGetTargetPlanet  .= "WHERE ";
				$QryGetTargetPlanet  .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
				$QryGetTargetPlanet  .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
				$QryGetTargetPlanet  .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
				$QryGetTargetPlanet  .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."';";
				$TargetPlanet         = $db->query( $QryGetTargetPlanet, 'planets', true);
				$TargetUserID         = $TargetPlanet['id_owner'];

				$TargetAdress         = sprintf ($lang['sys_adress_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
				$TargetAddedGoods     = sprintf ($lang['sys_stay_mess_goods'],
				$lang['Metal'], pretty_number($FleetRow['fleet_resource_metal']),
				$lang['Crystal'], pretty_number($FleetRow['fleet_resource_crystal']),
				$lang['Deuterium'], pretty_number($FleetRow['fleet_resource_deuterium']));

				$TargetMessage        = $lang['sys_stay_mess_start'] ."<a href=\"game.php?page=galaxy&mode=3&galaxy=". $FleetRow['fleet_end_galaxy'] ."&system=". $FleetRow['fleet_end_system'] ."\">";
				$TargetMessage       .= $TargetAdress. "</a>". $lang['sys_stay_mess_end'] ."<br />". $TargetAddedGoods;

				$users->SendSimpleMessage ( $TargetUserID, '', $FleetRow['fleet_start_time'], 5, $lang['sys_mess_qg'], $lang['sys_stay_mess_stay'], $TargetMessage);
				$this->RestoreFleetToPlanet ( $FleetRow, false );
				$db->query("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
			}
		}
		else
		{
			if ($FleetRow['fleet_end_time'] < time())
			{
				$TargetAdress         = sprintf ($lang['sys_adress_planet'], $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet']);
				$TargetAddedGoods     = sprintf ($lang['sys_stay_mess_goods'],
				$lang['Metal'], pretty_number($FleetRow['fleet_resource_metal']),
				$lang['Crystal'], pretty_number($FleetRow['fleet_resource_crystal']),
				$lang['Deuterium'], pretty_number($FleetRow['fleet_resource_deuterium']));

				$TargetMessage        = $lang['sys_stay_mess_back'] ."<a href=\"game.php?page=galaxy&mode=3&galaxy=". $FleetRow['fleet_start_galaxy'] ."&system=". $FleetRow['fleet_start_system'] ."\">";
				$TargetMessage       .= $TargetAdress. "</a>". $lang['sys_stay_mess_bend'] ."<br />". $TargetAddedGoods;

				$users->SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 5, $lang['sys_mess_qg'], $lang['sys_mess_fleetback'], $TargetMessage);
				$this->RestoreFleetToPlanet ( $FleetRow, true );
				$db->query("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
			}
		}
	}

	private function MissionCaseStayAlly($FleetRow)
	{
		global $db,$lang, $svn_root,$users;

		$QryStartPlanet   = "SELECT * FROM {{table}} ";
		$QryStartPlanet  .= "WHERE ";
		$QryStartPlanet  .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
		$QryStartPlanet  .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
		$QryStartPlanet  .= "`planet` = '". $FleetRow['fleet_start_planet'] ."';";
		$StartPlanet      = $db->query( $QryStartPlanet, 'planets', true);
		$StartName        = $StartPlanet['name'];
		$StartOwner       = $StartPlanet['id_owner'];

		$QryTargetPlanet  = "SELECT * FROM {{table}} ";
		$QryTargetPlanet .= "WHERE ";
		$QryTargetPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
		$QryTargetPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
		$QryTargetPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."';";
		$TargetPlanet     = $db->query( $QryTargetPlanet, 'planets', true);
		$TargetName       = $TargetPlanet['name'];
		$TargetOwner      = $TargetPlanet['id_owner'];

		if ($FleetRow['fleet_mess'] == 0)
		{
			if ($FleetRow['fleet_start_time'] < time())
			{
				$Message = sprintf($lang['sys_tran_mess_owner'], $TargetName, GetTargetAdressLink($FleetRow, ''),
					$FleetRow['fleet_resource_metal'], $lang['Metal'],
					$FleetRow['fleet_resource_crystal'], $lang['Crystal'],
					$FleetRow['fleet_resource_deuterium'], $lang['Deuterium'] );

				$users->SendSimpleMessage ($StartOwner, '',$FleetRow['fleet_start_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);

				$Message = sprintf( $lang['sys_tran_mess_user'], $StartName, GetStartAdressLink($FleetRow, ''),
					$TargetName, GetTargetAdressLink($FleetRow, ''),
					$FleetRow['fleet_resource_metal'], $lang['Metal'],
					$FleetRow['fleet_resource_crystal'], $lang['Crystal'],
					$FleetRow['fleet_resource_deuterium'], $lang['Deuterium'] );

				$users->SendSimpleMessage ($TargetOwner, '',$FleetRow['fleet_start_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);

				$QryUpdateFleet  = "UPDATE {{table}} SET ";
				$QryUpdateFleet .= "`fleet_mess` = 2 ";
				$QryUpdateFleet .= "WHERE `fleet_id` = '". $FleetRow['fleet_id'] ."' ";
				$QryUpdateFleet .= "LIMIT 1 ;";
				$db->query( $QryUpdateFleet, 'fleets');

			}
			elseif($FleetRow['fleet_end_stay'] < time())
			{
				$QryUpdateFleet  = "UPDATE {{table}} SET ";
				$QryUpdateFleet .= "`fleet_mess` = 1 ";
				$QryUpdateFleet .= "WHERE `fleet_id` = '". $FleetRow['fleet_id'] ."' ";
				$QryUpdateFleet .= "LIMIT 1 ;";
				$db->query( $QryUpdateFleet, 'fleets');
			}
		}
		else
		{
			if ($FleetRow['fleet_end_time'] < time())
			{
				$Message         = sprintf ($lang['sys_tran_mess_back'], $StartName, GetStartAdressLink($FleetRow, ''));
				$users->SendSimpleMessage ( $StartOwner, '', $FleetRow['fleet_end_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
				$this->RestoreFleetToPlanet ( $FleetRow, true );
				$db->query("DELETE FROM {{table}} WHERE fleet_id=" . $FleetRow["fleet_id"], 'fleets');
			}
		}
	}

	private function MissionCaseSpy($FleetRow)
	{
		global $db,$lang, $resource,$users;

		if ($FleetRow['fleet_start_time'] < time())
		{
			$CurrentUser         = $db->query("SELECT * FROM {{table}} WHERE `id` = '".$FleetRow['fleet_owner']."';", 'users', true);
			$CurrentUserID       = $FleetRow['fleet_owner'];
			$QryGetTargetPlanet  = "SELECT * FROM {{table}} ";
			$QryGetTargetPlanet .= "WHERE ";
			$QryGetTargetPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
			$QryGetTargetPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
			$QryGetTargetPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
			$QryGetTargetPlanet .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."';";
			$TargetPlanet        = $db->query( $QryGetTargetPlanet, 'planets', true);
			$TargetUserID        = $TargetPlanet['id_owner'];
			$CurrentPlanet       = $db->query("SELECT * FROM {{table}} WHERE `galaxy` = '".$FleetRow['fleet_start_galaxy']."' AND `system` = '".$FleetRow['fleet_start_system']."' AND `planet` = '".$FleetRow['fleet_start_planet']."';", 'planets', true);
			$CurrentSpyLvl       = $CurrentUser['spy_tech'] + ($CurrentUser['rpg_espion'] * 5);
			$TargetUser          = $db->query("SELECT * FROM {{table}} WHERE `id` = '".$TargetUserID."';", 'users', true);
			$TargetSpyLvl        = $TargetUser['spy_tech'] + ($TargetUser['rpg_espion'] * 5);
			$fleet               = explode(";", $FleetRow['fleet_array']);
			$fquery              = "";

			//UpdatePlanetBatimentQueueList($TargetPlanet, $TargetUser);
			//PlanetResourceUpdate($TargetUser, $TargetPlanet, time());

			foreach ($fleet as $a => $b)
			{
				if ($b != '')
				{
					$a = explode(",", $b);
					$fquery .= "{$resource[$a[0]]}={$resource[$a[0]]} + {$a[1]}, \n";
					if ($FleetRow["fleet_mess"] != "1")
					{
						if ($a[0] == "210")
						{
							$LS    = $a[1];
							$QryTargetGalaxy  = "SELECT * FROM {{table}} WHERE ";
							$QryTargetGalaxy .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
							$QryTargetGalaxy .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
							$QryTargetGalaxy .= "`planet` = '". $FleetRow['fleet_end_planet'] ."';";
							$TargetGalaxy     = $db->query( $QryTargetGalaxy, 'galaxy', true);
							$CristalDebris    = $TargetGalaxy['crystal'];
							$SpyToolDebris    = $LS * 300;

							$MaterialsInfo    = $this->SpyTarget ( $TargetPlanet, 0, $lang['sys_spy_maretials'] );
							$Materials        = $MaterialsInfo['String'];

							$PlanetFleetInfo  = $this->SpyTarget ( $TargetPlanet, 1, $lang['sys_spy_fleet'] );
							$PlanetFleet      = $Materials;
							$PlanetFleet     .= $PlanetFleetInfo['String'];

							$PlanetDefenInfo  = $this->SpyTarget ( $TargetPlanet, 2, $lang['sys_spy_defenses'] );
							$PlanetDefense    = $PlanetFleet;
							$PlanetDefense   .= $PlanetDefenInfo['String'];

							$PlanetBuildInfo  = $this->SpyTarget ( $TargetPlanet, 3, $lang['tech'][0] );
							$PlanetBuildings  = $PlanetDefense;
							$PlanetBuildings .= $PlanetBuildInfo['String'];

							$TargetTechnInfo  = $this->SpyTarget ( $TargetUser, 4, $lang['tech'][100] );
							$TargetTechnos    = $PlanetBuildings;
							$TargetTechnos   .= $TargetTechnInfo['String'];

							$TargetForce      = ($PlanetFleetInfo['Count'] * $LS) / 4;

							if ($TargetForce > 100){
								$TargetForce = 100;
							}

							$TargetChances = rand(0, $TargetForce);
							$SpyerChances  = rand(0, 100);

							if ($TargetChances >= $SpyerChances){
								$DestProba = "<font color=\"red\">".$lang['sys_mess_spy_destroyed']."</font>";
								$db->query("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
							}
							elseif ($TargetChances < $SpyerChances){
								$DestProba = sprintf( $lang['sys_mess_spy_lostproba'], $TargetChances);
							}

							$AttackLink = "<center>";
							$AttackLink .= "<a href=\"game.php?page=fleet&galaxy=". $FleetRow['fleet_end_galaxy'] ."&system=". $FleetRow['fleet_end_system'] ."";
							$AttackLink .= "&planet=".$FleetRow['fleet_end_planet']."";
							$AttackLink .= "&target_mission=1";
							$AttackLink .= " \">". $lang['type_mission'][1] ."";
							$AttackLink .= "</a></center>";
							$MessageEnd  = "<center>".$DestProba."</center>";

							$pT = ($TargetSpyLvl - $CurrentSpyLvl);
							$pW = ($CurrentSpyLvl - $TargetSpyLvl);
							if ($TargetSpyLvl > $CurrentSpyLvl)
								$ST = ($LS - pow($pT, 2));
							if ($CurrentSpyLvl > $TargetSpyLvl)
								$ST = ($LS + pow($pW, 2));
							if ($TargetSpyLvl == $CurrentSpyLvl)
								$ST = $CurrentSpyLvl;
							if ($ST <= "1")
								$SpyMessage = $Materials."<br />".$AttackLink.$MessageEnd;
							if ($ST == "2")
								$SpyMessage = $PlanetFleet."<br />".$AttackLink.$MessageEnd;
							if ($ST == "4" or $ST == "3")
								$SpyMessage = $PlanetDefense."<br />".$AttackLink.$MessageEnd;
							if ($ST == "5" or $ST == "6")
								$SpyMessage = $PlanetBuildings."<br />".$AttackLink.$MessageEnd;
							if ($ST >= "7")
								$SpyMessage = $TargetTechnos."<br />".$AttackLink.$MessageEnd;

							$users->SendSimpleMessage ( $CurrentUserID, '', $FleetRow['fleet_start_time'], 0, $lang['sys_mess_qg'], $lang['sys_mess_spy_report'], $SpyMessage);

							$TargetMessage  = $lang['sys_mess_spy_ennemyfleet'] ." ". $CurrentPlanet['name'];
							$TargetMessage .= "<a href=\"game.php?page=galaxy&mode=3&galaxy=". $CurrentPlanet["galaxy"] ."&system=". $CurrentPlanet["system"] ."\">";
							$TargetMessage .= "[". $CurrentPlanet["galaxy"] .":". $CurrentPlanet["system"] .":". $CurrentPlanet["planet"] ."]</a> ";
							$TargetMessage .= $lang['sys_mess_spy_seen_at'] ." ". $TargetPlanet['name'];
							$TargetMessage .= " [". $TargetPlanet["galaxy"] .":". $TargetPlanet["system"] .":". $TargetPlanet["planet"] ."].";

							$users->SendSimpleMessage ( $TargetUserID, '', $FleetRow['fleet_start_time'], 0, $lang['sys_mess_spy_control'], $lang['sys_mess_spy_activity'], $TargetMessage);

						}
						if ($TargetChances >= $SpyerChances)
						{
							$QryUpdateGalaxy  = "UPDATE {{table}} SET ";
							$QryUpdateGalaxy .= "`crystal` = `crystal` + '". (0 + $SpyToolDebris) ."' ";
							$QryUpdateGalaxy .= "WHERE `id_planet` = '". $TargetPlanet['id'] ."';";
							$db->query( $QryUpdateGalaxy, 'galaxy');
							$db->query("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
						}
						else{
							$db->query("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
						}
					}
				}
				else
				{
					if ($FleetRow['fleet_end_time'] < time())
					{
						$this->RestoreFleetToPlanet ( $FleetRow, true );
						$db->query("DELETE FROM {{table}} WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
					}
				}
			}
		}
	}

	private function MissionCaseRecycling ($FleetRow)
	{
		global $db,$pricelist, $lang,$users;

		if ($FleetRow["fleet_mess"] == "0")
		{
			if ($FleetRow['fleet_start_time'] < time())
			{
				$QrySelectGalaxy  = "SELECT * FROM {{table}} ";
				$QrySelectGalaxy .= "WHERE ";
				$QrySelectGalaxy .= "`galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND ";
				$QrySelectGalaxy .= "`system` = '".$FleetRow['fleet_end_system']."' AND ";
				$QrySelectGalaxy .= "`planet` = '".$FleetRow['fleet_end_planet']."' ";
				$QrySelectGalaxy .= "LIMIT 1;";
				$TargetGalaxy     = $db->query( $QrySelectGalaxy, 'galaxy', true);

				$FleetRecord         = explode(";", $FleetRow['fleet_array']);
				$RecyclerCapacity    = 0;
				$OtherFleetCapacity  = 0;
				foreach ($FleetRecord as $Item => $Group)
				{
					if ($Group != '')
					{
						$Class        = explode (",", $Group);
						if ($Class[0] == 209){
							$RecyclerCapacity   += $pricelist[$Class[0]]["capacity"] * $Class[1];
						}
					}
				}

				$IncomingFleetGoods = $FleetRow["fleet_resource_metal"] + $FleetRow["fleet_resource_crystal"] + $FleetRow["fleet_resource_deuterium"];
				if ($IncomingFleetGoods > $RecyclerCapacity){
					$RecyclerCapacity -= $IncomingFleetGoods ;
				}

				if (($TargetGalaxy["metal"] + $TargetGalaxy["crystal"]) <= $RecyclerCapacity)
				{
					$RecycledGoods["metal"]   = $TargetGalaxy["metal"];
					$RecycledGoods["crystal"] = $TargetGalaxy["crystal"];
				}
				else
				{
					if (($TargetGalaxy["metal"]   > $RecyclerCapacity / 2) && ($TargetGalaxy["crystal"] > $RecyclerCapacity / 2))
					{
						$RecycledGoods["metal"]   = $RecyclerCapacity / 2;
						$RecycledGoods["crystal"] = $RecyclerCapacity / 2;
					}
					else
					{
						if ($TargetGalaxy["metal"] > $TargetGalaxy["crystal"])
						{
							$RecycledGoods["crystal"] = $TargetGalaxy["crystal"];
							if ($TargetGalaxy["metal"] > ($RecyclerCapacity - $RecycledGoods["crystal"])){
								$RecycledGoods["metal"] = $RecyclerCapacity - $RecycledGoods["crystal"];
							}else{
								$RecycledGoods["metal"] = $TargetGalaxy["metal"];
                                                        }
						}
						else
						{
							$RecycledGoods["metal"] = $TargetGalaxy["metal"];
							if ($TargetGalaxy["crystal"] > ($RecyclerCapacity - $RecycledGoods["metal"])){
								$RecycledGoods["crystal"] = $RecyclerCapacity - $RecycledGoods["metal"];
                                                        }else{
								$RecycledGoods["crystal"] = $TargetGalaxy["crystal"];
                                                        }

                                                }
					}
				}

				$QryUpdateGalaxy  = "UPDATE {{table}} SET ";
				//$QryUpdateGalaxy .= "`metal` = `metal` - '".$RecycledGoods["metal"]."', ";
				//$QryUpdateGalaxy .= "`crystal` = `crystal` - '".$RecycledGoods["crystal"]."' ";
                                $QryUpdateGalaxy .= "`metal` = '".($TargetGalaxy["metal"]-$RecycledGoods["metal"])."', ";
				$QryUpdateGalaxy .= "`crystal` = '".($TargetGalaxy["crystal"]-$RecycledGoods["crystal"])."' ";

				$QryUpdateGalaxy .= "WHERE ";
				$QryUpdateGalaxy .= "`galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND ";
				$QryUpdateGalaxy .= "`system` = '".$FleetRow['fleet_end_system']."' AND ";
				$QryUpdateGalaxy .= "`planet` = '".$FleetRow['fleet_end_planet']."' ";
				$QryUpdateGalaxy .= "LIMIT 1;";
				$db->query( $QryUpdateGalaxy, 'galaxy');

				$Message = sprintf($lang['sys_recy_gotten'], pretty_number($RecycledGoods["metal"]), $lang['Metal'], pretty_number($RecycledGoods["crystal"]), $lang['Crystal']);
				$users->SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 4, $lang['sys_mess_spy_control'], $lang['sys_recy_report'], $Message);

				$QryUpdateFleet  = "UPDATE {{table}} SET ";
				$QryUpdateFleet .= "`fleet_resource_metal` = `fleet_resource_metal` + '".$RecycledGoods["metal"]."', ";
				$QryUpdateFleet .= "`fleet_resource_crystal` = `fleet_resource_crystal` + '".$RecycledGoods["crystal"]."', ";
				$QryUpdateFleet .= "`fleet_mess` = '1' ";
				$QryUpdateFleet .= "WHERE ";
				$QryUpdateFleet .= "`fleet_id` = '".$FleetRow['fleet_id']."' ";
				$QryUpdateFleet .= "LIMIT 1;";
				$db->query( $QryUpdateFleet, 'fleets');
			}
		}
		else
		{
			if ($FleetRow['fleet_end_time'] < time())
			{
				$Message         = sprintf( $lang['sys_tran_mess_owner'],
				$TargetName, GetTargetAdressLink($FleetRow, ''),
				pretty_number($FleetRow['fleet_resource_metal']), $lang['Metal'],
				pretty_number($FleetRow['fleet_resource_crystal']), $lang['Crystal'],
				pretty_number($FleetRow['fleet_resource_deuterium']), $lang['Deuterium'] );
				$users->SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 4, $lang['sys_mess_spy_control'], $lang['sys_mess_fleetback'], $Message);
				$this->RestoreFleetToPlanet ( $FleetRow, true );
				$db->query("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
			}
		}
	}

	private function MissionCaseColonisation($FleetRow)
	{
		global $db,$lang, $resource,$users;

		$iPlanetCount = mysql_result($db->query ("SELECT count(*) FROM {{table}} WHERE `id_owner` = '". $FleetRow['fleet_owner'] ."' AND `planet_type` = '1'", 'planets'), 0);

		if ($FleetRow['fleet_mess'] == 0)
		{
			$iGalaxyPlace = mysql_result($db->query ("SELECT count(*) FROM {{table}} WHERE `galaxy` = '". $FleetRow['fleet_end_galaxy']."' AND `system` = '". $FleetRow['fleet_end_system']."' AND `planet` = '". $FleetRow['fleet_end_planet']."';", 'planets'), 0);
			$TargetAdress = sprintf ($lang['sys_adress_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
			if ($iGalaxyPlace == 0)
			{
				if ($iPlanetCount >= MAX_PLAYER_PLANETS)
				{
					$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_maxcolo'] . MAX_PLAYER_PLANETS . $lang['sys_colo_planet'];
					$users->SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
					$db->query("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
				}
				else
				{
					$NewOwnerPlanet = CreateOnePlanetRecord($FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'], $FleetRow['fleet_owner'], $lang['sys_colo_defaultname'],	$FleetRow['fleet_resource_metal'], $FleetRow['fleet_resource_crystal'], $FleetRow['fleet_resource_deuterium'], false);
					if ( $NewOwnerPlanet == true )
					{
						$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_allisok'];
						$users->SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
						if ($FleetRow['fleet_amount'] == 1){
							$db->query("DELETE FROM {{table}} WHERE fleet_id=" . $FleetRow["fleet_id"], 'fleets');
                                                }else{
							$CurrentFleet = explode(";", $FleetRow['fleet_array']);
							$NewFleet     = "";
							foreach ($CurrentFleet as $Item => $Group)
							{
								if ($Group != '')
								{
									$Class = explode (",", $Group);
									if ($Class[0] == 208){
										if ($Class[1] > 1){
											$NewFleet  .= $Class[0].",".($Class[1] - 1).";";
										}
									}else{
										if ($Class[1] <> 0){

											$NewFleet  .= $Class[0].",".$Class[1].";";
										}
									}
								}
							}
							$QryUpdateFleet  = "UPDATE {{table}} SET ";
							$QryUpdateFleet .= "`fleet_array` = '". $NewFleet ."', ";
							$QryUpdateFleet .= "`fleet_amount` = `fleet_amount` - 1, ";
							$QryUpdateFleet .= "`fleet_mess` = '1' ";
							$QryUpdateFleet .= "WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';";
							$db->query( $QryUpdateFleet, 'fleets');
						}
					}
					else
					{
						$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_badpos'];
						$users->SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
						$db->query("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
					}
				}
			}
			else
			{
				$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_notfree'];
				$users->SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
				$db->query("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
			}
		}
		elseif ($FleetRow['fleet_end_time'] < time())
		{
			$this->RestoreFleetToPlanet ($FleetRow, true);
			$db->query("DELETE FROM {{table}} WHERE fleet_id=" . $FleetRow["fleet_id"], 'fleets');
		}
	}
private function MissionCaseMIP ($FleetRow)
	{
		global $db,$users, $phpEx, $svn_root, $pricelist, $lang, $resource, $CombatCaps,$reslist;

		if ($FleetRow['fleet_start_time'] < time())
		{
			if ($FleetRow['fleet_mess'] == 0)
			{

                                $QryTargetPlanet = "SELECT * FROM {{table}} ";
                                $QryTargetPlanet .= "WHERE ";
                                $QryTargetPlanet .= "`galaxy` = '" . $FleetRow['fleet_end_galaxy'] . "' AND ";
                                $QryTargetPlanet .= "`system` = '" . $FleetRow['fleet_end_system'] . "' AND ";
                                $QryTargetPlanet .= "`planet` = '" . $FleetRow['fleet_end_planet'] . "' AND ";
                                $QryTargetPlanet .= "`planet_type` = '" . $FleetRow['fleet_end_type'] . "';";
                                $planets = $db->query($QryTargetPlanet, 'planets', true);

                                $QrySelect  = "SELECT defence_tech FROM {{table}} ";
                                $QrySelect .= "WHERE ";
                                $QrySelect .= "`id` = '".$FleetRow['fleet_target_owner']."';";
                                $UserFleet = $db->query( $QrySelect, 'users',true);

                                $timeini = microtime(true);
                                $defensa = $UserFleet["defence_tech"];
                                $militar = $users->user["military_tech"];

                                foreach($reslist['defense'] as $a => $b){
                                        if($b==502 || $b==503)continue;
                                        $DefenseLabel[$a]=$lang['tech'][$b];
                                        $def[$a]=$planets[$resource[$b]];
                                }

                                $message = "";

                                if($planets["interceptor_misil"] >= $FleetRow['fleet_amount']) //($planet['interceptor_misil'] >= $FleetRow['fleet_amount'])
                                {
                                        $message = 'Los misiles de intercepci�n destruyeron todos loe misiles interplanetarios enviados<br>';
                                }else{
                                        $message = "<br>".($FleetRow['fleet_amount'] - $planets["interceptor_misil"]) . " misiles interplanetarios no fueron destruidos por misiles interceptores.<br>";
                                        $message .= "Los interplanetarios destruyeron: <br>";
                                        $destruido = $this->sistema_mip($defensa, $militar, $FleetRow['fleet_amount']-$planets['interceptor_misil'], $def,$FleetRow["fleet_target_obj"]);
                                }
                                if($destruido){
                                    $x = $resource[502];
                                    $xv="`".$x."` = '0',";
                                    foreach ($destruido as $id => $anzahl)
                                    {
                                            $message .= $DefenseLabel[$id] . " (- " . $anzahl . ")<br>";//$DefenseLabel[$id] . " (- " . $anzahl . ")<br>";
                                            $x = $resource[$reslist['defense'][$id]];
                                            $x1 = $planets[$x]-$anzahl;
                                            $xv.="`".$x."` = '".$x1."',";

                                    }
                                }else{
                                    $x = $resource[502];
                                    $xv="`".$x."` = '0',";
                                }
                                $xv=substr_replace($xv , '', -1);
                                $db->query("UPDATE {{table}} SET " . $xv . "  WHERE id = '" . $planet['id']."';", 'planets');

                                $UserPlanet 		= $db->query("SELECT name FROM {{table}} WHERE id = '" . $FleetRow['fleet_owner'] . "'", 'planets',true);
                                $name 			= $UserPlanet['name'];
                                $name_deffer 		= $planets['name'];
                                $message_vorlage  	= 'Un ataque con misiles (' .$FleetRow['fleet_amount']. ') de ' .$name. ' ';
                                $message_vorlage       .= 'al planeta ' .$name_deffer.'<br><br>';

                                if (empty($message)){
                                        $message 	= "Tu planeta no tenia defensa!";
                                }
                                $timefin = microtime(true);
                                $message.= "<br>Tiempo del Script : ".($timefin-$timeini);

                                $users->SendSimpleMessage($FleetRow['fleet_target_owner'],$users->user['id'],time(),3,
                                "Torre de Control",'Ataque con misiles',$message_vorlage . $message);
                                $users->SendSimpleMessage($users->user['id'],$FleetRow['fleet_target_owner'],time(),3,
                                "Torre de Control",'Ataque con misiles',$message_vorlage . $message);
                                $db->query("DELETE FROM {{table}} WHERE fleet_id = '" . $FleetRow['fleet_id'] . "'", 'fleets');
			}
		}
		$FleetRow['fleet_start_time'] < time();
	}
	private function MissionCaseDestruction($FleetRow) {
		global $db,$users,$displays, $phpEx, $svn_root, $pricelist, $lang, $resource, $CombatCaps;


		if ($FleetRow['fleet_start_time'] <= time()) {
		   if ($FleetRow['fleet_mess'] == 0) {
			if (!isset($CombatCaps[202]['sd'])) {
			   $displays->message("<font color=\"red\">". $lang['sys_no_vars'] ."</font>", $lang['sys_error'], "fleet." . $phpEx, 2);
			}

			$QryTargetMoon  = "SELECT * FROM {{table}} ";
			$QryTargetMoon .= "WHERE ";
			$QryTargetMoon .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
			$QryTargetMoon .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
			$QryTargetMoon .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
			$QryTargetMoon .= "`planet_type` = '3';";
			$TargetMoon     = $db->query( $QryTargetMoon, 'planets', true);

			$TargetUserID   = $TargetMoon['id_owner'];
			$TargerMoonID   = $TargetMoon['id'];


			$MoonSize = $TargetMoon['diameter'];
			$MoonID   = $TargetMoon['id'];
			$MoonName = $TargetMoon['name'];


			$QryCurrentUser   = "SELECT * FROM {{table}} ";
			$QryCurrentUser  .= "WHERE ";
			$QryCurrentUser  .= "`id` = '". $FleetRow['fleet_owner'] ."';";
			$CurrentUser      = $db->query($QryCurrentUser , 'users', true);
			$CurrentUserID    = $CurrentUser['id'];

			$QryTargetUser    = "SELECT * FROM {{table}} ";
			$QryTargetUser   .= "WHERE ";
			$QryTargetUser   .= "`id` = '". $TargetUserID ."';";
			$TargetUser       = $db->query($QryTargetUser, 'users', true);

			$TargetTechno =array('military_tech'	=> $TargetUser['military_tech'],
					     'defence_tech'	=> $TargetUser['defence_tech'],
					     'shield_tech'	=> $TargetUser['shield_tech']);

			$CurrentTechno	=array('military_tech'	=> $CurrentUser['military_tech'],
					     'defence_tech'	=> $CurrentUser['defence_tech'],
					     'shield_tech'	=> $CurrentUser['shield_tech']);





			for ($SetItem = 200; $SetItem < 500; $SetItem++) {
				if ($TargetMoon[$resource[$SetItem]] > 0) {

					$TargetSet[$SetItem]['count'] = $TargetMoon[$resource[$SetItem]];
				}
			}

			$TheFleet = explode(";", $FleetRow['fleet_array']);
			foreach($TheFleet as $a => $b) {
				if ($b != '') {
					$a = explode(",", $b);
					$CurrentSet[$a[0]]['count'] = $a[1];
				}
			}


		      //UpdatePlanetBatimentQueueList($TargetMoon, $TargetUser);
		      //PlanetResourceUpdate($TargetUser, $TargetMoon, time());

		      $mtime        = microtime();
		      $mtime        = explode(" ", $mtime);
		      $mtime        = $mtime[1] + $mtime[0];
		      $starttime    = $mtime;

		      $walka        = $this->walka($CurrentSet, $TargetSet, $CurrentTechno, $TargetTechno);

		      // Calcul de la duree de traitement (calcul)
		      $mtime        = microtime();
		      $mtime        = explode(" ", $mtime);
		      $mtime        = $mtime[1] + $mtime[0];
		      $endtime      = $mtime;
		      $totaltime    = ($endtime - $starttime);

		      // Ce qu'il reste de l'attaquant
		      $CurrentSet   = $walka["atakujacy"];
		      // Ce qu'il reste de l'attaquï¿½
		      $TargetSet    = $walka["wrog"];
		      // Le resultat de la bataille
		      $FleetResult  = $walka["wygrana"];
		      // Rapport long (rapport de bataille detaillï¿½)
		      $dane_do_rw   = $walka["dane_do_rw"];
		      // Rapport court (cdr + unitï¿½es perdues)
		      $zlom         = $walka["zlom"];

		      $FleetArray   = "";
		      $FleetAmount  = 0;
		      $FleetStorage = 0;
		      $Rips = 0;
			foreach ($CurrentSet as $Ship => $Count) {
				if ($Ship == '214'){
				   $Rips += $Count['count'];
				}
				if ($Ship == '210'){
				   $FleetStorage += 0;
				}else{
				   $FleetStorage += $pricelist[$Ship]["capacity"] * $Count['count'];
				}
				$FleetArray   .= $Ship.",".$Count['count'].";";
				$FleetAmount  += $Count['count'];
			}
		      // Au cas ou le p'tit rigolo qu'a envoyï¿½ la flotte y avait mis des ressources ...
		      $FleetStorage -= $FleetRow["fleet_resource_metal"];
		      $FleetStorage -= $FleetRow["fleet_resource_crystal"];
		      $FleetStorage -= $FleetRow["fleet_resource_deuterium"];

		      $TargetMoonUpd = "";
			if (!is_null($TargetSet)) {
				foreach($TargetSet as $Ship => $Count) {
				   $TargetMoonUpd .= "`". $resource[$Ship] ."` = '". $Count['count'] ."', ";
				}
			}

		      // Determination des ressources pillï¿½es
		      $Mining['metal']   = 0;
		      $Mining['crystal'] = 0;
		      $Mining['deuter']  = 0;
		      if ($FleetResult == "a") {
			 if ($FleetStorage > 0) {
				$metal   = abs($TargetMoon['metal']) / 2;
				$crystal = abs($TargetMoon['crystal']) / 2;
				$deuter  = abs($TargetMoon["deuterium"]) / 2;
				$FleetStorage= abs($FleetStorage) / 3;
				if (($metal + $crystal + $deuter) > $FleetStorage){
					if ($metal > ($FleetStorage)) {
					   $Mining['metal']   = abs($FleetStorage);
					} else {
					   $Mining['metal']   = abs($metal);
					}

					if (($crystal) > $FleetStorage) {
					   $Mining['crystal'] = abs($FleetStorage);
					} else {
					   $Mining['crystal'] = abs($crystal);
					}

					if (($deuter) > $FleetStorage) {
					   $Mining['deuter']  = abs($FleetStorage);
					} else {
					   $Mining['deuter']  = abs($deuter);
					}
				} else {
					$Mining['metal']   = abs($metal);
					$Mining['crystal'] = abs($crystal);
					$Mining['deuter']  = abs($deuter);
					$FleetStorage      = $FleetStorage - $Mining['metal'] - $Mining['crystal'] - $Mining['deuter'];
				}
			 }
		      }
		      $Mining['metal']   = round($Mining['metal']);
		      $Mining['crystal'] = round($Mining['crystal']);
		      $Mining['deuter']  = round($Mining['deuter']);

		      // Mise a jour de l'enregistrement de la planete attaquï¿½e
		      $QryUpdateTarget  = "UPDATE {{table}} SET ";
		      $QryUpdateTarget .= $TargetMoonUpd;
		      $QryUpdateTarget .= "`metal` = `metal` - '". $Mining['metal'] ."', ";
		      $QryUpdateTarget .= "`crystal` = `crystal` - '". $Mining['crystal'] ."', ";
		      $QryUpdateTarget .= "`deuterium` = `deuterium` - '". $Mining['deuter'] ."' ";
		      $QryUpdateTarget .= "WHERE ";
		      $QryUpdateTarget .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
		      $QryUpdateTarget .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
		      $QryUpdateTarget .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
		      $QryUpdateTarget .= "`planet_type` = '3' ";
		      $QryUpdateTarget .= "LIMIT 1;";
		      $db->query( $QryUpdateTarget , 'planets');

		      // Mise a jour du champ de ruine devant la planete attaquï¿½e
		      $QryUpdateGalaxy  = "UPDATE {{table}} SET ";
		      $QryUpdateGalaxy .= "`metal` = `metal` + '". $zlom['metal'] ."', ";
		      $QryUpdateGalaxy .= "`crystal` = `crystal` + '". $zlom['crystal'] ."' ";
		      $QryUpdateGalaxy .= "WHERE ";
		      $QryUpdateGalaxy .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
		      $QryUpdateGalaxy .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
		      $QryUpdateGalaxy .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' ";
		      $QryUpdateGalaxy .= "LIMIT 1;";
		      $db->query( $QryUpdateGalaxy , 'galaxy');

		      // Lï¿½ on va discuter le bout de gras pour voir s'il y a moyen d'avoir une Lune !
		      $FleetDebris      = $zlom['metal'] + $zlom['crystal'];
		      $StrAttackerUnits = sprintf ($lang['sys_attacker_lostunits'], $zlom["atakujacy"]);
		      $StrDefenderUnits = sprintf ($lang['sys_defender_lostunits'], $zlom["wrog"]);
		      $StrRuins         = sprintf ($lang['sys_gcdrunits'], $zlom["metal"], $lang['metal'], $zlom['crystal'], $lang['crystal']);
		      $DebrisField      = $StrAttackerUnits ."<br />". $StrDefenderUnits ."<br />". $StrRuins;
		      $MoonChance       = $FleetDebris / 100000;
		      if ($FleetDebris > 2000000) {
			 $MoonChance = 20;
		      }
		      if ($FleetDebris < 100000) {
			 $UserChance = 0;
			 $ChanceMoon = "";
		      } elseif ($FleetDebris >= 100000) {
			 $UserChance = mt_rand(1, 100);
			 $ChanceMoon       = sprintf ($lang['sys_moonproba'], $MoonChance);
		      }

		      $GottenMoon = "";

		      $AttackDate        = date("m-d H:i:s", $FleetRow["fleet_start_time"]);
		      $title             = sprintf ($lang['sys_attack_title'], $AttackDate);
		      $raport            = "<center><table><tr><td>". $title ."<br />";
		      $zniszczony        = false;
		      $a_zestrzelona     = 0;
		      $AttackTechon['A'] = $CurrentTechno["military_tech"] * 10;
		      $AttackTechon['B'] = $CurrentTechno["defence_tech"] * 10;
		      $AttackTechon['C'] = $CurrentTechno["shield_tech"] * 10;
		      $AttackerData      = sprintf ($lang['sys_attack_attacker_pos'], $CurrentUser["username"], $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet'] );
		      $AttackerTech      = sprintf ($lang['sys_attack_techologies'], $AttackTechon['A'], $AttackTechon['B'], $AttackTechon['C']);

		      $DefendTechon['A'] = $TargetTechno["military_tech"] * 10;
		      $DefendTechon['B'] = $TargetTechno["defence_tech"] * 10;
		      $DefendTechon['C'] = $TargetTechno["shield_tech"] * 10;
		      $DefenderData      = sprintf ($lang['sys_attack_defender_pos'], $TargetUser["username"], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'] );
		      $DefenderTech      = sprintf ($lang['sys_attack_techologies'], $DefendTechon['A'], $DefendTechon['B'], $DefendTechon['C']);

		      foreach ($dane_do_rw as $a => $b) {
			 $raport .= "<table border=1 width=100%><tr><th><br /><center>".$AttackerData."<br />".$AttackerTech."<table border=1>";
			 if ($b["atakujacy"]['count'] > 0) {
			    $raport1 = "<tr><th>".$lang['sys_ship_type']."</th>";
			    $raport2 = "<tr><th>".$lang['sys_ship_count']."</th>";
			    $raport3 = "<tr><th>".$lang['sys_ship_weapon']."</th>";
			    $raport4 = "<tr><th>".$lang['sys_ship_shield']."</th>";
			    $raport5 = "<tr><th>".$lang['sys_ship_armour']."</th>";
			    foreach ($b["atakujacy"] as $Ship => $Data) {
			       if (is_numeric($Ship)) {
				  if ($Data['count'] > 0) {
				     $raport1 .= "<th>". $lang["tech_rc"][$Ship] ."</th>";
				     $raport2 .= "<th>". $Data['count'] ."</th>";
				     $raport3 .= "<th>". round($Data["atak"]   / $Data['count']) ."</th>";
				     $raport4 .= "<th>". round($Data["tarcza"] / $Data['count']) ."</th>";
				     $raport5 .= "<th>". round($Data["obrona"] / $Data['count']) ."</th>";
				  }
			       }
			    }
			    $raport1 .= "</tr>";
			    $raport2 .= "</tr>";
			    $raport3 .= "</tr>";
			    $raport4 .= "</tr>";
			    $raport5 .= "</tr>";
			    $raport .= $raport1 . $raport2 . $raport3 . $raport4 . $raport5;
			 } else {
			    if ($a == 2) {
			       $a_zestrzelona = 1;
			    }
			    $zniszczony = true;
			    $raport .= "<br />". $lang['sys_destroyed'];
			 }

			 $raport .= "</table></center></th></tr></table>";
			 $raport .= "<table border=1 width=100%><tr><th><br /><center>".$DefenderData."<br />".$DefenderTech."<table border=1>";
			 if ($b["wrog"]['count'] > 0) {
			    $raport1 = "<tr><th>".$lang['sys_ship_type']."</th>";
			    $raport2 = "<tr><th>".$lang['sys_ship_count']."</th>";
			    $raport3 = "<tr><th>".$lang['sys_ship_weapon']."</th>";
			    $raport4 = "<tr><th>".$lang['sys_ship_shield']."</th>";
			    $raport5 = "<tr><th>".$lang['sys_ship_armour']."</th>";
			    foreach ($b["wrog"] as $Ship => $Data) {
			       if (is_numeric($Ship)) {
				  if ($Data['count'] > 0) {
				     $raport1 .= "<th>". $lang["tech_rc"][$Ship] ."</th>";
				     $raport2 .= "<th>". $Data['count'] ."</th>";
				     $raport3 .= "<th>". round($Data["atak"]   / $Data['count']) ."</th>";
				     $raport4 .= "<th>". round($Data["tarcza"] / $Data['count']) ."</th>";
				     $raport5 .= "<th>". round($Data["obrona"] / $Data['count']) ."</th>";
				  }
			       }
			    }
			    $raport1 .= "</tr>";
			    $raport2 .= "</tr>";
			    $raport3 .= "</tr>";
			    $raport4 .= "</tr>";
			    $raport5 .= "</tr>";
			    $raport .= $raport1 . $raport2 . $raport3 . $raport4 . $raport5;
			 } else {
			    $zniszczony = true;
			    $raport .= "<br />". $lang['sys_destroyed'];
			 }
			 $raport .= "</table></center></th></tr></table>";

			 if (($zniszczony == false) and ($a < 6)) {
	     //            if($zniszczony == false){
			    $AttackWaveStat    = sprintf ($lang['sys_attack_attack_wave'], floor($b["atakujacy"]["count"]), floor($b["atakujacy"]["atak"]), floor($b["wrog"]["tarcza"]));
			    $DefendWavaStat    = sprintf ($lang['sys_attack_defend_wave'], floor($b["wrog"]["count"]), floor($b["wrog"]["atak"]), floor($b["atakujacy"]["tarcza"]));
			    $raport           .= "<br /><center>".$AttackWaveStat."<br />".$DefendWavaStat."</center>";
			 }
		      }
		      switch ($FleetResult) {
			 case "a":
			    $Pillage           = sprintf ($lang['sys_stealed_ressources'], $Mining['metal'], $lang['metal'], $Mining['crystal'], $lang['Crystal'], $Mining['deuter'], $lang['deuterium']);
			    $raport           .= $lang['sys_attacker_won'] ."<br />". $Pillage ."<br />";
			    $raport           .= $DebrisField ."<br />";
			    $raport           .= $ChanceMoon ."<br />";
			    $raport           .= $GottenMoon ."<br />";
			    break;
			 case "r":
			    $raport           .= $lang['sys_both_won'] ."<br />";
			    $raport           .= $DebrisField ."<br />";
			    $raport           .= $ChanceMoon ."<br />";
			    $raport           .= $GottenMoon ."<br />";
			    break;
			 case "w":
			    $raport           .= $lang['sys_defender_won'] ."<br />";
			    $raport           .= $DebrisField ."<br />";
			    $raport           .= $ChanceMoon ."<br />";
			    $raport           .= $GottenMoon ."<br />";
			    $db->query("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
			    break;
			 default:
			    break;
		      }
		      $SimMessage        = sprintf ($lang['sys_rapport_build_time'], $totaltime);
		      $raport           .= $SimMessage ."</table>";

		      $dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
		      $rid   = md5($raport);
		      $RidMessage            = "<br><br><center> reportID= ".$rid."</center>";
		      $raport   .= $RidMessage;
		      $QryInsertRapport  = "INSERT INTO {{table}} SET ";
		      $QryInsertRapport .= "`time` = UNIX_TIMESTAMP(), ";
		      $QryInsertRapport .= "`id_owner1` = '". $FleetRow['fleet_owner'] ."', ";
		      $QryInsertRapport .= "`id_owner2` = '". $TargetUserID ."', ";
		      $QryInsertRapport .= "`rid` = '". $rid ."', ";
		      $QryInsertRapport .= "`a_zestrzelona` = '". $a_zestrzelona ."', ";
		      $QryInsertRapport .= "`raport` = '". addslashes ( $raport ) ."';";
		      $db->query( $QryInsertRapport , 'rw');

		      // Colorisation du rï¿½sumï¿½ de rapport pour l'attaquant
		      $raport  = "<a href # OnClick=\"f( 'CombatReport.php?raport=". $rid ."', '');\" >";
		      $raport .= "<center>";
		      if       ($FleetResult == "a") {
			 $raport .= "<font color=\"green\">";
		      } elseif ($FleetResult == "r") {
			 $raport .= "<font color=\"orange\">";
		      } elseif ($FleetResult == "w") {
			 $raport .= "<font color=\"red\">";
		      }
		      $raport .= $lang['sys_mess_destruc_report'] ." [". $FleetRow['fleet_end_galaxy'] .":". $FleetRow['fleet_end_system'] .":". $FleetRow['fleet_end_planet'] ."] </font></a><br /><br />";
		      $raport .= "<font color=\"red\">". $lang['sys_perte_attaquant'] .": ". $zlom["atakujacy"] ."</font>";
		      $raport .= "<font color=\"green\">   ". $lang['sys_perte_defenseur'] .":". $zlom["wrog"] ."</font><br />" ;
		      $raport .= $lang['sys_gain'] ." ". $lang['metal'] .":<font color=\"#adaead\">". $Mining['metal'] ."</font>   ". $lang['crystal'] .":<font color=\"#ef51ef\">". $Mining['crystal'] ."</font>   ". $lang['deuterium'] .":<font color=\"#f77542\">". $Mining['deuter'] ."</font><br />";
		      $raport .= $lang['sys_debris'] ." ". $lang['metal'] .":<font color=\"#adaead\">". $zlom['metal'] ."</font>   ". $lang['crystal'] .":<font color=\"#ef51ef\">". $zlom['crystal'] ."</font><br /></center>";

		      $Mining['metal']   = $Mining['metal']   + $FleetRow["fleet_resource_metal"];
		      $Mining['crystal'] = $Mining['crystal'] + $FleetRow["fleet_resource_crystal"];
		      $Mining['deuter']  = $Mining['deuter']  + $FleetRow["fleet_resource_deuterium"];

		      $QryUpdateFleet  = "UPDATE {{table}} SET ";
		      $QryUpdateFleet .= "`fleet_amount` = '". $FleetAmount ."', ";
		      $QryUpdateFleet .= "`fleet_array` = '". $FleetArray ."', ";
		      $QryUpdateFleet .= "`fleet_mess` = '1', ";
		      $QryUpdateFleet .= "`fleet_resource_metal` = '". $Mining['metal'] ."', ";
		      $QryUpdateFleet .= "`fleet_resource_crystal` = '". $Mining['crystal'] ."', ";
		      $QryUpdateFleet .= "`fleet_resource_deuterium` = '". $Mining['deuter'] ."' ";
		      $QryUpdateFleet .= "WHERE fleet_id = '". $FleetRow['fleet_id'] ."' ";
		      $QryUpdateFleet .= "LIMIT 1 ;";
		      $db->query( $QryUpdateFleet , 'fleets');

			$users->SendSimpleMessage ( $CurrentUserID, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_destruc_report'], $raport );

		      // Colorisation du rï¿½sumï¿½ de rapport pour l'attaquant
		      $raport2  = "<a href # OnClick=\"f( 'CombatReport.php?raport=". $rid ."', '');\" >";
		      $raport2 .= "<center>";
		      if       ($FleetResult == "a") {
			 $raport2 .= "<font color=\"red\">";
		      } elseif ($FleetResult == "r") {
			 $raport2 .= "<font color=\"orange\">";
		      } elseif ($FleetResult == "w") {
			 $raport2 .= "<font color=\"green\">";
		      }
					     $raport2 .= $lang['sys_mess_destruc_report'] ." [". $FleetRow['fleet_end_galaxy'] .":". $FleetRow['fleet_end_system'] .":". $FleetRow['fleet_end_planet'] ."] </font></a><br /><br />";

		      $users->SendSimpleMessage ( $TargetUserID, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $raport2 );

		      $RipsKilled = 0;
		      $MoonDestroyed = 0;

		      if ($FleetResult == "a" AND $Rips > '0'){
			 $MoonDestChance = round((100 - sqrt($MoonSize)) * (sqrt($Rips)));
			 if ($MoonDestChance > 99){
			    $MoonDestChance = 99;
			 }
			 $RipDestChance = round((sqrt($MoonSize)) / 2);
			 $UserChance = mt_rand(1, 100);
			 if (($UserChance > 0) AND ($UserChance <= $MoonDestChance) AND ($RipDestChance <= $MoonDestChance)){
			    $RipsKilled = 0;
			    $MoonDestroyed = 1;
			 }elseif (($UserChance > 0) AND ($UserChance <= $RipDestChance)){
			    $RipsKilled = 1;
			    $MoonDestroyed = 0;
			 }
		      }
		      if ($MoonDestroyed == 1){
			 $DeleteMoonQry2  = "DELETE FROM {{table}} WHERE `id` ='".$TargerMoonID."';";
			 $db->query($DeleteMoonQry2, 'planets');

			 $QryUpdateGalaxy  = "UPDATE {{table}} SET ";
			 $QryUpdateGalaxy .= "`id_luna` = '0' ";
			 $QryUpdateGalaxy .= "WHERE ";
			 $QryUpdateGalaxy .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
			 $QryUpdateGalaxy .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
			 $QryUpdateGalaxy .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' ";
			 $QryUpdateGalaxy .= "LIMIT 1;";
			 $db->query( $QryUpdateGalaxy , 'galaxy');
				     //change return path for fleets sent from destroyed moon
			 $QryFleetsFrom = $db->query("SELECT * FROM {{table}} WHERE
			 `fleet_start_galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND
			 `fleet_start_system` = '".$FleetRow['fleet_end_system']."' AND
			 `fleet_start_planet` = '".$FleetRow['fleet_end_planet']."' AND
			 `fleet_start_type` = '3';",'fleets');
			 while($FromMoonFleets = mysql_fetch_array($QryFleetsFrom)){
			    $db->query("UPDATE {{table}} SET `fleet_start_type` = '1' WHERE `fleet_id` = '".$FromMoonFleets['fleet_id']."';",'fleets');
			 }
			 $message  = $lang['sys_moon_destroyed'];
			 $message .= "<br><br>";
			 $message .= $lang['sys_chance_moon_destroy'].$MoonDestChance."%. <br>".$lang['sys_chance_rips_destroy'].$RipDestChance."%";

			 $users->SendSimpleMessage ( $CurrentUserID, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_moon_destruction_report'], $message );
			 $users->SendSimpleMessage ( $TargetUserID, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_moon_destruction_report'], $message );
		      }elseif($RipsKilled == 1){
			 $db->query("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
			 $FleetResult = "w";
			 $message  = $lang['sys_rips_destroyed'];
			 $message .= "<br><br>";
			 $message .= $lang['sys_chance_moon_destroy'].$MoonDestChance."%. <br>".$lang['sys_chance_rips_destroy'].$RipDestChance."%";

			 $users->SendSimpleMessage ( $CurrentUserID, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_moon_destruction_report'], $message );
			 $users->SendSimpleMessage ( $TargetUserID, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_moon_destruction_report'], $message );
		      }else{
			 $message  = $lang['sys_rips_come_back'];
			 $message .= "<br>";
			 $message .= $lang['sys_chance_moon_destroy'].$MoonDestChance."%. <br>".$lang['sys_chance_rips_destroy'].$RipDestChance;

			 $users->SendSimpleMessage ( $CurrentUserID, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_moon_destruction_report'], $message );
			 $users->SendSimpleMessage ( $TargetUserID, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_moon_destruction_report'], $message );
		      }
		   }
		   // Retour de flotte (s'il en reste)
		   $fquery = "";
		   if ($FleetRow['fleet_end_time'] <= time()) {
		      if (!is_null($CurrentSet)) {
			 foreach($CurrentSet as $Ship => $Count) {
			    $fquery .= "`". $resource[$Ship] ."` = `". $resource[$Ship] ."` + '". $Count['count'] ."', ";
			 }
			} else {
				$fleet = explode(";", $FleetRow['fleet_array']);
				foreach($fleet as $a => $b) {
					if ($b != '') {
						$a = explode(",", $b);
						$fquery .= "{$resource[$a[0]]}={$resource[$a[0]]} + {$a[1]}, \n";
					}
				}
			}
			if (!($FleetResult == "w")) {
			   $QryUpdatePlanet  = "UPDATE {{table}} SET ";
			   $QryUpdatePlanet .= $fquery;
			   $QryUpdatePlanet .= "`metal` = `metal` + ". $FleetRow['fleet_resource_metal'] .", ";
			   $QryUpdatePlanet .= "`crystal` = `crystal` + ". $FleetRow['fleet_resource_crystal'] .", ";
			   $QryUpdatePlanet .= "`deuterium` = `deuterium` + ". $FleetRow['fleet_resource_deuterium'] ." ";
			   $QryUpdatePlanet .= "WHERE ";
			   $QryUpdatePlanet .= "`galaxy` = ".$FleetRow['fleet_start_galaxy']." AND ";
			   $QryUpdatePlanet .= "`system` = ".$FleetRow['fleet_start_system']." AND ";
			   $QryUpdatePlanet .= "`planet` = ".$FleetRow['fleet_start_planet']." AND ";
			   $QryUpdatePlanet .= "`planet_type` = ".$FleetRow['fleet_start_type']." LIMIT 1 ;";
			   $db->query( $QryUpdatePlanet, 'planets' );
			   $db->query ("DELETE FROM {{table}} WHERE `fleet_id` = " . $FleetRow["fleet_id"], 'fleets');
			}
			$db->query ("DELETE FROM {{table}} WHERE `fleet_id` = " . $FleetRow["fleet_id"], 'fleets');
			}
		}
	}


	private function MissionCaseExpedition($FleetRow)
	{
		global $db,$lang,$users, $resource, $pricelist;

		$FleetOwner = $FleetRow['fleet_owner'];
		$MessSender = $lang['sys_mess_qg'];
		$MessTitle  = $lang['sys_expe_report'];

		if ($FleetRow['fleet_mess'] == 0)
		{
			if ($FleetRow['fleet_end_stay'] < time())
			{
				$PointsFlotte = array(
				202 => 1.0,
				203 => 1.5,
				204 => 0.5,
				205 => 1.5,
				206 => 2.0,
				207 => 2.5,
				208 => 0.5,
				209 => 1.0,
				210 => 0.01,
				211 => 3.0,
				212 => 0.0,
				213 => 3.5,
				214 => 5.0,
				215 => 3.2,
				);

				$RatioGain = array (
				202 => 0.1,
				203 => 0.1,
				204 => 0.1,
				205 => 0.5,
				206 => 0.25,
				207 => 0.125,
				208 => 0.5,
				209 => 0.1,
				210 => 0.1,
				211 => 0.0625,
				212 => 0.0,
				213 => 0.0625,
				214 => 0.03125,
				215 => 0.0625,
				);

				$FleetStayDuration 	= ($FleetRow['fleet_end_stay'] - $FleetRow['fleet_start_time']) / 3600;
				$farray 		= explode(";", $FleetRow['fleet_array']);

				foreach ($farray as $Item => $Group)
				{
					if ($Group != '')
					{
						$Class 						= explode (",", $Group);
						$TypeVaisseau 				= $Class[0];
						$NbreVaisseau 				= $Class[1];
						$LaFlotte[$TypeVaisseau]		= $NbreVaisseau;
						$FleetCapacity 			   += $pricelist[$TypeVaisseau]['capacity'];
						$FleetPoints   			   += ($NbreVaisseau * $PointsFlotte[$TypeVaisseau]);
					}
				}

				$FleetUsedCapacity  	= $FleetRow['fleet_resource_metal'] + $FleetRow['fleet_resource_crystal'] + $FleetRow['fleet_resource_deuterium'] + $FleetRow['fleet_resource_darkmatter'];
				$FleetCapacity  	-= $FleetUsedCapacity;
				$FleetCount 		= $FleetRow['fleet_amount'];
				$Hasard 		= rand(0, 10);
				$MessSender 		= $lang['sys_mess_qg']. "(".$Hasard.")";

				if ($Hasard < 3)
				{
					$Hasard     += 1;
					$LostAmount  = (($Hasard * 33) + 1) / 100;

					if ($LostAmount == 100)
					{
						$users->SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_blackholl_2'] );
						$db->query ("DELETE FROM {{table}} WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
					}
					else
					{
						foreach ($LaFlotte as $Ship => $Count)
						{
							$LostShips[$Ship] = intval($Count * $LostAmount);
							$NewFleetArray   .= $Ship.",". ($Count - $LostShips[$Ship]) .";";
						}
						$QryUpdateFleet  = "UPDATE {{table}} SET ";
						$QryUpdateFleet .= "`fleet_array` = '". $NewFleetArray ."', ";
						$QryUpdateFleet .= "`fleet_mess` = '1'  ";
						$QryUpdateFleet .= "WHERE ";
						$QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
						$db->query( $QryUpdateFleet, 'fleets');
						$users->SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_blackholl_1'] );
					}
				}
				elseif ($Hasard == 3)
				{
					$db->query("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
					$users->SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_nothing_1'] );
				}
				elseif ($Hasard >= 4 && $Hasard < 7)
				{
					if ($FleetCapacity > 5000)
					{
						$MinCapacity = $FleetCapacity - 5000;
						$MaxCapacity = $FleetCapacity;
						$FoundGoods  = rand($MinCapacity, $MaxCapacity);
						$FoundMetal  = intval($FoundGoods / 2);
						$FoundCrist  = intval($FoundGoods / 4);
						$FoundDeute  = intval($FoundGoods / 6);
						$FoundDark   = intval($FoundGoods / 20);

						$QryUpdateFleet  = "UPDATE {{table}} SET ";
						$QryUpdateFleet .= "`fleet_resource_metal` = `fleet_resource_metal` + '". $FoundMetal ."', ";
						$QryUpdateFleet .= "`fleet_resource_crystal` = `fleet_resource_crystal` + '". $FoundCrist."', ";
						$QryUpdateFleet .= "`fleet_resource_deuterium` = `fleet_resource_deuterium` + '". $FoundDeute ."', ";
						$QryUpdateFleet .= "`fleet_resource_darkmatter` = `fleet_resource_darkmatter` + '". $FoundDark ."', ";
						$QryUpdateFleet .= "`fleet_mess` = '1'  ";
						$QryUpdateFleet .= "WHERE ";
						$QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
						$db->query( $QryUpdateFleet, 'fleets');

						$Message = sprintf($lang['sys_expe_found_goods'],
						pretty_number($FoundMetal), $lang['Metal'],
						pretty_number($FoundCrist), $lang['Crystal'],
						pretty_number($FoundDeute), $lang['Deuterium'],
						pretty_number($FoundDark), $lang['Darkmatter']);

						$users->SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $Message );
					}
				}
				elseif ($Hasard == 7)
				{
					$db->query("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
					$users->SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_nothing_2'] );
				}
				elseif ($Hasard >= 8 && $Hasard < 11)
				{
					$FoundChance = $FleetPoints / $FleetCount;
					for ($Ship = 202; $Ship < 216; $Ship++)
					{
						if ($LaFlotte[$Ship] != 0)
						{
							$FoundShip[$Ship] = round($LaFlotte[$Ship] * $RatioGain[$Ship]);
							if ($FoundShip[$Ship] > 0)
								$LaFlotte[$Ship] += $FoundShip[$Ship];
						}
					}
					$NewFleetArray = "";
					$FoundShipMess = "";

					foreach ($LaFlotte as $Ship => $Count)
					{
						if ($Count > 0)
							$NewFleetArray   .= $Ship.",". $Count .";";
					}

					foreach ($FoundShip as $Ship => $Count)
					{
						if ($Count != 0)
							$FoundShipMess   .= $Count." ".$lang['tech'][$Ship].",";
					}

					$QryUpdateFleet  = "UPDATE {{table}} SET ";
					$QryUpdateFleet .= "`fleet_array` = '". $NewFleetArray ."', ";
					$QryUpdateFleet .= "`fleet_mess` = '1'  ";
					$QryUpdateFleet .= "WHERE ";
					$QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
					$db->query( $QryUpdateFleet, 'fleets');

					$Message = $lang['sys_expe_found_ships']. $FoundShipMess . "";
					$users->SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $Message);
				}
			}
		}
		else
		{
			if ($FleetRow['fleet_end_time'] < time())
			{
				$farray = explode(";", $FleetRow['fleet_array']);
				foreach ($farray as $Item => $Group)
				{
					if ($Group != '')
					{
						$Class = explode (",", $Group);
						$FleetAutoQuery .= "`". $resource[$Class[0]]. "` = `". $resource[$Class[0]] ."` + ". $Class[1] .", ";
					}
				}
				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= $FleetAutoQuery;
				$QryUpdatePlanet .= "`metal` = `metal` + ". $FleetRow['fleet_resource_metal'] .", ";
				$QryUpdatePlanet .= "`crystal` = `crystal` + ". $FleetRow['fleet_resource_crystal'] .", ";
				$QryUpdatePlanet .= "`deuterium` = `deuterium` + ". $FleetRow['fleet_resource_deuterium'] ." ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
				$QryUpdatePlanet .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
				$QryUpdatePlanet .= "`planet` = '". $FleetRow['fleet_start_planet'] ."' AND ";
				$QryUpdatePlanet .= "`planet_type` = '". $FleetRow['fleet_start_type'] ."' ";
				$QryUpdatePlanet .= "LIMIT 1 ;";
				$db->query( $QryUpdatePlanet, 'planets');

				$db->query("UPDATE `{{table}}` SET `darkmatter` = `darkmatter` + '".$FleetRow['fleet_resource_darkmatter']."' WHERE `id` =".$FleetRow['fleet_owner']." LIMIT 1 ;", 'users');
				$db->query ("DELETE FROM {{table}} WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');

				$users->SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_time'], 15, $MessSender, $MessTitle, $lang['sys_expe_back_home'] );
			}
		}
	}
	private function MissionCaseAttack ($FleetRow)
	{
		global $db,$users,$users, $phpEx, $svn_root, $pricelist, $lang, $resource, $CombatCaps;

		if ($FleetRow['fleet_start_time'] < time())
		{
			if ($FleetRow['fleet_mess'] == 0)
			{
				if (!isset($CombatCaps[202]['sd'])){
					header("location:game." . $phpEx . "?page=fleet");
				}

                                $CurrentUserID   =$FleetRow['fleet_owner'];
                                $TargetUserID    =$FleetRow['fleet_target_owner'];

                                $CurrentTechnoquery="ua.military_tech as militaryCurrent, ua.defence_tech as defenceCurrent, ua.shield_tech as shieldCurrent, ua.username as usernameCurrent";
                                $TargetTechnoquery="ud.military_tech as militaryTarget, ud.defence_tech as defenceTarget, ud.shield_tech as shieldTarget, ud.username as usernameTarget";
                                $TargetPlanetquery="p1.*, p1.id_owner as id_ownerTarget";

                                $from="{{table}}planets as p1,{{table}}users as ua, {{table}}users as ud ";
                                $superquery   = "SELECT ". $CurrentTechnoquery. "," .$TargetTechnoquery .",".$TargetPlanetquery." FROM ".$from;
                                $superquery  .= "WHERE ";
                                $superquery  .= "p1.galaxy = '".$FleetRow['fleet_end_galaxy']."' AND p1.system = '".$FleetRow['fleet_end_system'] ."' AND p1.planet = '".$FleetRow['fleet_end_planet']."' AND p1.planet_type = '".$FleetRow['fleet_end_type']."' AND ";
                                $superquery  .= "ua.id = '".$CurrentUserID."' AND ";
                                $superquery  .= "ud.id = '".$TargetUserID."'";
                                $queryss      = $db->query($superquery , '', true);

                                $CurrentTechno=array();
                                $CurrentTechno['military_tech'] = $queryss['militaryCurrent'];
                                $CurrentTechno['defence_tech']  = $queryss['defenceCurrent'];
                                $CurrentTechno['shield_tech']   = $queryss['shieldCurrent'];

                                $TargetTechno=array();
                                $TargetTechno['military_tech']  = $queryss['militaryTarget'];
                                $TargetTechno['defence_tech']   = $queryss['defenceTarget'];
                                $TargetTechno['shield_tech']    = $queryss['shieldTarget'];

				for ($SetItem = 200; $SetItem < 500; $SetItem++)
				{
				if ($queryss[$resource[$SetItem]] > 0) {
					$TargetSet[$SetItem]['count'] = $queryss[$resource[$SetItem]];
					}
				}

				$TheFleet = explode(";", $FleetRow['fleet_array']);
				foreach($TheFleet as $a => $b)
				{
					if ($b != '')
					{
						$a = explode(",", $b);
						$CurrentSet[$a[0]]['count'] = $a[1];
					}
				}

				$walka 		= $this->walka($CurrentSet, $TargetSet, $CurrentTechno,  $TargetTechno);
				$CurrentSet 	= $walka["atakujacy"];
				$TargetSet 	= $walka["wrog"];
				$FleetResult 	= $walka["wygrana"];
				$dane_do_rw 	= $walka["dane_do_rw"];
				$zlom 		= $walka["zlom"];
				$FleetArray 	= "";
				$FleetAmount 	= 0;
				$FleetStorage 	= 0;

				foreach ($CurrentSet as $Ship => $Count)
				{
					$FleetStorage 	+= $pricelist[$Ship]["capacity"] * $Count['count'];
					$FleetArray 	.= $Ship . "," . $Count['count'] . ";";
					$FleetAmount 	+= $Count['count'];
				}

				$FleetStorage -= $FleetRow["fleet_resource_metal"];
				$FleetStorage -= $FleetRow["fleet_resource_crystal"];
				$FleetStorage -= $FleetRow["fleet_resource_deuterium"];

				$TargetPlanetUpd = "";

				if (!is_null($TargetSet))
				{
					foreach($TargetSet as $Ship => $Count)
					{
						$TargetPlanetUpd .= "`" . $resource[$Ship] . "` = '" . $Count['count'] . "', ";
					}
				}

				$Mining['metal'] 	= 0;
				$Mining['crystal'] 	= 0;
				$Mining['deuter'] 	= 0;

				if ($FleetResult == "a"){
				   if ($FleetStorage > 0){

                                                $metal   = abs($queryss['metal']) / 2;
                                                $crystal = abs($queryss['crystal']) / 2;
                                                $deuter  = abs($queryss["deuterium"]) / 2;
						$FleetStorage= abs($FleetStorage) / 3;
					if (($metal) > $FleetStorage) {
						$Mining['metal']   = abs($FleetStorage);
					} else {
						$Mining['metal']   = abs($metal);
					}

					if (($crystal) > $FleetStorage) {
						$Mining['crystal'] = abs($FleetStorage);
					} else {
						$Mining['crystal'] = abs($crystal);
					}

					if (($deuter) > $FleetStorage) {
						$Mining['deuter']  = abs($FleetStorage);
					} else {
						$Mining['deuter']  =abs($deuter);
					}
				    }
				}
				$Mining['metal'] 	= round($Mining['metal']);
				$Mining['crystal'] 	= round($Mining['crystal']);
				$Mining['deuter'] 	= round($Mining['deuter']);

				$QryUpdateTarget = "UPDATE {{table}} SET ";
				$QryUpdateTarget .= $TargetPlanetUpd;
				$QryUpdateTarget .= "`metal` = `metal` - '" . $Mining['metal'] . "', ";
				$QryUpdateTarget .= "`crystal` = `crystal` - '" . $Mining['crystal'] . "', ";
				$QryUpdateTarget .= "`deuterium` = `deuterium` - '" . $Mining['deuter'] . "' ";
				$QryUpdateTarget .= "WHERE ";
				$QryUpdateTarget .= "`galaxy` = '" . $FleetRow['fleet_end_galaxy'] . "' AND ";
				$QryUpdateTarget .= "`system` = '" . $FleetRow['fleet_end_system'] . "' AND ";
				$QryUpdateTarget .= "`planet` = '" . $FleetRow['fleet_end_planet'] . "' AND ";
				$QryUpdateTarget .= "`planet_type` = '" . $FleetRow['fleet_end_type'] . "' ";
				$QryUpdateTarget .= "LIMIT 1;";
				$db->query($QryUpdateTarget , 'planets');

				$QryUpdateGalaxy = "UPDATE {{table}} SET ";
				$QryUpdateGalaxy .= "`metal` = `metal` + '" . $zlom['metal'] . "', ";
				$QryUpdateGalaxy .= "`crystal` = `crystal` + '" . $zlom['crystal'] . "' ";
				$QryUpdateGalaxy .= "WHERE ";
				$QryUpdateGalaxy .= "`galaxy` = '" . $FleetRow['fleet_end_galaxy'] . "' AND ";
				$QryUpdateGalaxy .= "`system` = '" . $FleetRow['fleet_end_system'] . "' AND ";
				$QryUpdateGalaxy .= "`planet` = '" . $FleetRow['fleet_end_planet'] . "' ";
				$QryUpdateGalaxy .= "LIMIT 1;";
				$db->query($QryUpdateGalaxy , 'galaxy');

				$FleetDebris 		= $zlom['metal'] + $zlom['crystal'];
				$StrAttackerUnits 	= sprintf ($lang['sys_attacker_lostunits'], pretty_number ($zlom["atakujacy"]));
				$StrDefenderUnits 	= sprintf ($lang['sys_defender_lostunits'], pretty_number ($zlom["wrog"]));
				$StrRuins 		= sprintf ($lang['sys_gcdrunits'], pretty_number ($zlom["metal"]), $lang['Metal'], pretty_number ($zlom['crystal']), $lang['Crystal']);
				$DebrisField 		= $StrAttackerUnits . "<br />" . $StrDefenderUnits . "<br />" . $StrRuins;
				$MoonChance 		= $FleetDebris / 100000;

				if($FleetDebris > 2000000){
					$MoonChance = 20;
					$ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);
				}elseif($FleetDebris < 100000){
					$UserChance = 0;
					$ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);
				}elseif($FleetDebris >= 100000){
					$UserChance = mt_rand(1, 100);
					$ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);
				}

				if (($UserChance > 0) && ($UserChance <= $MoonChance) && $galenemyrow['id_luna'] == 0){
					$TargetPlanetName = CreateOneMoonRecord ($FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'], $TargetUserID, '', $MoonChance);
					$GottenMoon = sprintf ($lang['sys_moonbuilt'], $TargetPlanetName, $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
				}elseif ($UserChance = 0 or $UserChance > $MoonChance){
					$GottenMoon = "";
				}

				$AttackDate 		= date("r", $FleetRow["fleet_start_time"]);
				$title 			= sprintf ($lang['sys_attack_title'], $AttackDate);
				$raport 		= "<center><table><tr><td>" . $title . "<br />";
				$zniszczony 		= false;
				$a_zestrzelona 		= 0;

                                $AttackTechon['A'] = $CurrentTechno["military_tech"] * 10;
                                $AttackTechon['B'] = $CurrentTechno["defence_tech"] * 10;
                                $AttackTechon['C'] = $CurrentTechno["shield_tech"] * 10;
                                $AttackerData      = sprintf ($lang['sys_attack_attacker_pos'], $queryss["usernameCurrent"], $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet'] );
                                $AttackerTech      = sprintf ($lang['sys_attack_techologies'], $AttackTechon['A'], $AttackTechon['B'], $AttackTechon['C']);

                                $DefendTechon['A'] = $TargetTechno["military_tech"] * 10;
                                $DefendTechon['B'] = $TargetTechno["defence_tech"] * 10;
                                $DefendTechon['C'] = $TargetTechno["shield_tech"] * 10;
                                $DefenderData      = sprintf ($lang['sys_attack_defender_pos'], $queryss["usernameTarget"], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'] );
                                $DefenderTech      = sprintf ($lang['sys_attack_techologies'], $DefendTechon['A'], $DefendTechon['B'], $DefendTechon['C']);
				$ronda=0;
				foreach ($dane_do_rw as $a => $b)
				{
					$ronda++;
					$raport .= "<table border=1 width=100%><tr><th><br />Ronda".$ronda."<center>" . $AttackerData . "<br />" . $AttackerTech . "<table border=1>";
					if ($b["atakujacy"]['count'] > 0)
					{
						$raport1 = "<tr><th>" . $lang['sys_ship_type'] . "</th>";
						$raport2 = "<tr><th>" . $lang['sys_ship_count'] . "</th>";
						$raport3 = "<tr><th>" . $lang['sys_ship_weapon'] . "</th>";
						$raport4 = "<tr><th>" . $lang['sys_ship_shield'] . "</th>";
						$raport5 = "<tr><th>" . $lang['sys_ship_armour'] . "</th>";
						foreach ($b["atakujacy"] as $Ship => $Data)
						{
							if (is_numeric($Ship))
							{
								if ($Data['count'] > 0)
								{
									$raport1 .= "<th>" . $lang["tech_rc"][$Ship] . "</th>";
									$raport2 .= "<th>" . pretty_number ($Data['count']) . "</th>";
									$raport3 .= "<th>" . pretty_number (round($Data["atak"] / $Data['count'])) . "</th>";
									$raport4 .= "<th>" . pretty_number (round($Data["tarcza"] / $Data['count'])) . "</th>";
									$raport5 .= "<th>" . pretty_number (round($Data["obrona"] / $Data['count'])) . "</th>";
								}
							}
						}
						$raport1 .= "</tr>";
						$raport2 .= "</tr>";
						$raport3 .= "</tr>";
						$raport4 .= "</tr>";
						$raport5 .= "</tr>";
						$raport  .= $raport1 . $raport2 . $raport3 . $raport4 . $raport5;
					}
					else
					{
						if ($a == 2)
							$a_zestrzelona = 1;

						$zniszczony = true;
						$raport .= "<br />" . $lang['sys_destroyed'];
					}

					$raport .= "</table></center></th></tr></table>";
					$raport .= "<table border=1 width=100%><tr><th><br /><center>" . $DefenderData . "<br />" . $DefenderTech . "<table border=1>";

					if ($b["wrog"]['count'] > 0)
					{
						$raport1 = "<tr><th>" . $lang['sys_ship_type'] . "</th>";
						$raport2 = "<tr><th>" . $lang['sys_ship_count'] . "</th>";
						$raport3 = "<tr><th>" . $lang['sys_ship_weapon'] . "</th>";
						$raport4 = "<tr><th>" . $lang['sys_ship_shield'] . "</th>";
						$raport5 = "<tr><th>" . $lang['sys_ship_armour'] . "</th>";
						foreach ($b["wrog"] as $Ship => $Data)
						{
							if (is_numeric($Ship))
							{
								if ($Data['count'] > 0)
								{
									$raport1 .= "<th>" . $lang["tech_rc"][$Ship] . "</th>";
									$raport2 .= "<th>" . pretty_number ($Data['count']) . "</th>";
									$raport3 .= "<th>" . pretty_number (round($Data["atak"] / $Data['count'])) . "</th>";
									$raport4 .= "<th>" . pretty_number (round($Data["tarcza"] / $Data['count'])) . "</th>";
									$raport5 .= "<th>" . pretty_number (round($Data["obrona"] / $Data['count'])) . "</th>";
								}
							}
						}
						$raport1 .= "</tr>";
						$raport2 .= "</tr>";
						$raport3 .= "</tr>";
						$raport4 .= "</tr>";
						$raport5 .= "</tr>";
						$raport .= $raport1 . $raport2 . $raport3 . $raport4 . $raport5;
					}
					else
					{
						$zniszczony = true;
						$raport .= "<br />" . $lang['sys_destroyed'];
					}
					$raport .= "</table></center></th></tr></table>";

					if (($zniszczony == false) and !($a == 8))
					{
						$AttackWaveStat = sprintf ($lang['sys_attack_attack_wave'], pretty_number (floor($b["atakujacy"]["atak"])), pretty_number (floor($b["wrog"]["tarcza"])));
						$DefendWavaStat = sprintf ($lang['sys_attack_defend_wave'], pretty_number (floor($b["wrog"]["atak"])), pretty_number (floor($b["atakujacy"]["tarcza"])));
						$raport .= "<br /><center>" . $AttackWaveStat . "<br />" . $DefendWavaStat . "</center>";
					}
				}
				switch ($FleetResult)
				{
					case "a":
						$Pillage = sprintf ($lang['sys_stealed_ressources'], pretty_number ($Mining['metal']), "metal", pretty_number ($Mining['crystal']), "cristal", pretty_number ($Mining['deuter']), "deuterio");
						$raport .= $lang['sys_attacker_won'] . $Pillage . "<br />";
						$raport .= $DebrisField . "<br />";
						$raport .= $ChanceMoon . "<br />";
						$raport .= $GottenMoon . "<br />";
					break;
					case "r":
						$raport .= $lang['sys_both_won'] . "<br />";
						$raport .= $DebrisField . "<br />";
						$raport .= $ChanceMoon . "<br />";
						$raport .= $GottenMoon . "<br />";
					break;
					case "w":
						$raport .= $lang['sys_defender_won'] . "<br />";
						$raport .= $DebrisField . "<br />";
						$raport .= $ChanceMoon . "<br />";
						$raport .= $GottenMoon . "<br />";
						$db->query("DELETE FROM {{table}} WHERE `fleet_id` = '" . $FleetRow["fleet_id"] . "';", 'fleets');
					break;
				}

				$raport 	.= "</table>";
				$rid 		 = md5($raport);

				$QryInsertRapport = "INSERT INTO {{table}} SET ";
				$QryInsertRapport .= "`time` = UNIX_TIMESTAMP(), ";
				$QryInsertRapport .= "`id_owner1` = '" . $FleetRow['fleet_owner'] . "', ";
				$QryInsertRapport .= "`id_owner2` = '" . $TargetUserID . "', ";
				$QryInsertRapport .= "`rid` = '" . $rid . "', ";
				$QryInsertRapport .= "`a_zestrzelona` = '" . $a_zestrzelona . "', ";
				$QryInsertRapport .= "`raport` = '" . addslashes ($raport) . "';";
				$db->query($QryInsertRapport , 'rw');

				$raport = "<a href # OnClick=\"f( 'CombatReport.php?raport=" . $rid . "', '');\" >";
				$raport .= "<center>";

				if ($FleetResult == "a")
					$raport .= "<font color=\"green\">";
				elseif ($FleetResult == "r")
					$raport .= "<font color=\"orange\">";
				elseif ($FleetResult == "w")
					$raport .= "<font color=\"red\">";

				$raport .= $lang['sys_mess_attack_report'] . " [" . $FleetRow['fleet_end_galaxy'] . ":" . $FleetRow['fleet_end_system'] . ":" . $FleetRow['fleet_end_planet'] . "] </font></a><br /><br />";
				$raport .= "<font color=\"red\">" . $lang['sys_perte_attaquant'] . ": " . pretty_number ($zlom["atakujacy"]) . "</font>";
				$raport .= "<font color=\"green\">   " . $lang['sys_perte_defenseur'] . ":" . pretty_number ($zlom["wrog"]) . "</font><br />" ;
				$raport .= $lang['sys_gain'] . " " . $lang['Metal'] . ":<font color=\"#adaead\">" . pretty_number ($Mining['metal']) . "</font>   " . $lang['Crystal'] . ":<font color=\"#ef51ef\">" . pretty_number ($Mining['crystal']) . "</font>   " . $lang['Deuterium'] . ":<font color=\"#f77542\">" . pretty_number ($Mining['deuter']) . "</font><br />";
				$raport .= $lang['sys_debris'] . " " . $lang['Metal'] . ":<font color=\"#adaead\">" . pretty_number ($zlom['metal']) . "</font>   " . $lang['Crystal'] . ":<font color=\"#ef51ef\">" . pretty_number ($zlom['crystal']) . "</font><br /></center>";

				$Mining['metal']   = $Mining['metal']   + $FleetRow["fleet_resource_metal"];
				$Mining['crystal'] = $Mining['crystal'] + $FleetRow["fleet_resource_crystal"];
				$Mining['deuter']  = $Mining['deuter']  + $FleetRow["fleet_resource_deuterium"];
				$QryUpdateFleet  = "UPDATE {{table}} SET ";
				$QryUpdateFleet .= "`fleet_amount` = '". $FleetAmount ."', ";
				$QryUpdateFleet .= "`fleet_array` = '". $FleetArray ."', ";
				$QryUpdateFleet .= "`fleet_mess` = '1', ";
				$QryUpdateFleet .= "`fleet_resource_metal` = '". $Mining['metal'] ."', ";
				$QryUpdateFleet .= "`fleet_resource_crystal` = '". $Mining['crystal'] ."', ";
				$QryUpdateFleet .= "`fleet_resource_deuterium` = '". $Mining['deuter'] ."' ";
				$QryUpdateFleet .= "WHERE fleet_id = '". $FleetRow['fleet_id'] ."' ";
				$QryUpdateFleet .= "LIMIT 1 ;";
				$db->query( $QryUpdateFleet , 'fleets');


				$users->SendSimpleMessage ($CurrentUserID, $TargetUserID, $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $raport);

				$raport2 = "<a href # OnClick=\"f( 'CombatReport.php?raport=" . $rid . "', '');\" >";
				$raport2 .= "<center>";

				if ($FleetResult == "a")
					$raport2 .= "<font color=\"green\">";
				elseif ($FleetResult == "r")
					$raport2 .= "<font color=\"orange\">";
				elseif ($FleetResult == "w")
					$raport2 .= "<font color=\"red\">";

				$raport2 .= $lang['sys_mess_attack_report'] . " [" . $FleetRow['fleet_end_galaxy'] . ":" . $FleetRow['fleet_end_system'] . ":" . $FleetRow['fleet_end_planet'] . "] </font></a><br /><br />";

				$users->SendSimpleMessage ($TargetUserID, $CurrentUserID, $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $raport2);
			}

			$fquery = "";
			if ($FleetRow['fleet_end_time'] < time())
			{
				if (!is_null($CurrentSet))
				{
					foreach($CurrentSet as $Ship => $Count)
					{
						$fquery .= "`" . $resource[$Ship] . "` = `" . $resource[$Ship] . "` + '" . $Count['count'] . "', ";
					}
				}
				else
				{
					$fleet = explode(";", $FleetRow['fleet_array']);
					foreach($fleet as $a => $b)
					{
						if ($b != '')
						{
							$a = explode(",", $b);
							$fquery .= "{$resource[$a[0]]}={$resource[$a[0]]} + {$a[1]}, \n";
						}
					}
				}

				$db->query ("DELETE FROM {{table}} WHERE `fleet_id` = " . $FleetRow["fleet_id"], 'fleets');

				if (!($FleetResult == "w"))
				{
					$QryUpdatePlanet = "UPDATE {{table}} SET ";
					$QryUpdatePlanet .= $fquery;
					$QryUpdatePlanet .= "`metal` = `metal` + " . $FleetRow['fleet_resource_metal'] . ", ";
					$QryUpdatePlanet .= "`crystal` = `crystal` + " . $FleetRow['fleet_resource_crystal'] . ", ";
					$QryUpdatePlanet .= "`deuterium` = `deuterium` + " . $FleetRow['fleet_resource_deuterium'] . " ";
					$QryUpdatePlanet .= "WHERE ";
					$QryUpdatePlanet .= "`galaxy` = " . $FleetRow['fleet_start_galaxy'] . " AND ";
					$QryUpdatePlanet .= "`system` = " . $FleetRow['fleet_start_system'] . " AND ";
					$QryUpdatePlanet .= "`planet` = " . $FleetRow['fleet_start_planet'] . " AND ";
					$QryUpdatePlanet .= "`planet_type` = " . $FleetRow['fleet_start_type'] . " LIMIT 1 ;";
					$db->query($QryUpdatePlanet, 'planets');
				}
			}
		}
	}
	public function FlyingFleetHandler (&$planet)
	{
            global $db;
		$QryFleet   = "SELECT * FROM {{table}} ";
		$QryFleet  .= "WHERE (";
		$QryFleet  .= "( ";
		$QryFleet  .= "`fleet_start_galaxy` = ". $planet['galaxy']      ." AND ";
		$QryFleet  .= "`fleet_start_system` = ". $planet['system']      ." AND ";
		$QryFleet  .= "`fleet_start_planet` = ". $planet['planet']      ." AND ";
		$QryFleet  .= "`fleet_start_type` = ".   $planet['planet_type'] ." ";
		$QryFleet  .= ") OR ( ";
		$QryFleet  .= "`fleet_end_galaxy` = ".   $planet['galaxy']      ." AND ";
		$QryFleet  .= "`fleet_end_system` = ".   $planet['system']      ." AND ";
		$QryFleet  .= "`fleet_end_planet` = ".   $planet['planet']      ." ) AND ";
		$QryFleet  .= "`fleet_end_type`= ".      $planet['planet_type'] ." )";// AND ";
		//$QryFleet  .= "( `fleet_start_time` < '". time() ."' OR `fleet_end_time` < '". time() ."' );";
		$fleetquery = $db->query( $QryFleet, 'fleets' );

		while ($CurrentFleet = mysql_fetch_array($fleetquery))
		{
			switch ($CurrentFleet["fleet_mission"])
			{
				case 1:
					//$this->MissionCaseAttack($CurrentFleet);
                                        $this->MissionCaseSac2($CurrentFleet);
				break;

				case 2:
					//$this->MissionCaseSac($CurrentFleet);
                                        $this->MissionCaseSac2($CurrentFleet);
				break;

				case 3:
					$this->MissionCaseTransport($CurrentFleet);
				break;

				case 4:
					$this->MissionCaseStay($CurrentFleet);
				break;

				case 5:
					$this->MissionCaseStayAlly($CurrentFleet);
				break;

				case 6:
					$this->MissionCaseSpy($CurrentFleet);
				break;

				case 7:
					$this->MissionCaseColonisation($CurrentFleet);
				break;

				case 8:
					$this->MissionCaseRecycling($CurrentFleet);
				break;

				case 9:
					$this->MissionCaseDestruction($CurrentFleet);
				break;

				case 10:
					$this->MissionCaseMIP($CurrentFleet);
				break;

				case 15:
					$this->MissionCaseExpedition($CurrentFleet);
				break;

				default:
					$db->query("DELETE FROM {{table}} WHERE `fleet_id` = '". $CurrentFleet['fleet_id'] ."';", 'fleets');

			}
		}
	}
}
?>
