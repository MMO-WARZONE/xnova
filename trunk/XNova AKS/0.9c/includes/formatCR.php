<?php
function formatCR (&$result_array,&$steal_array,&$moon_int,&$moon_string,&$time_float) {
        global $phpEx, $xnova_root_path, $pricelist, $lang, $resource, $CombatCaps, $game_config;    

        includeLang('fleet');
        includeLang('tech');

        $html = "";
        $bbc = "";
        
        $html .= $lang['title_rc']." ".date("d-m-Y H:i:s").".<br /><br />";
        
        
        //Pour chaque tour de combat (max specifie dans la variable defini dans CalculateAttack.php
        $round_no = 1;
        foreach( $result_array['rw'] as $round => $data1){
            //Numéro du tour est $round + 1 puisque le compte commence à $round = 0, et pas 1.
    
            $html .= $lang['round']." ".$round_no." :<br /><br />";
            
            //preparation des donnes des combatants
            $attackers1 = $data1['attackers'];
            $attackers2 = $data1['infoA'];
            $attackers3 = $data1['attackA'];
            $defenders1 = $data1['defenders'];
            $defenders2 = $data1['infoD'];
            $defenders3 = $data1['defenseA'];
            $coord4 = 0;
            $coord5 = 0;
            $coord6 = 0;
 
         //ATTAQUANT(S)           
            foreach( $attackers1 as $fleet_id1 => $data2){ 
                //Infos joueurs
                $name = $data2['user']['username'];
                $coord1 = $data2['fleet']['fleet_start_galaxy'];
                $coord2 = $data2['fleet']['fleet_start_system'];
                $coord3 = $data2['fleet']['fleet_start_planet'];
                $weap = ($data2['user']['military_tech'] * 10);
                $shie = ($data2['user']['defence_tech'] * 10);
                $armr = ($data2['user']['shield_tech'] * 10);
                
                if($coord4 == 0){$coord4 += $data2['fleet']['fleet_end_galaxy'];}
                if($coord5 == 0){$coord5 += $data2['fleet']['fleet_end_system'];}
                if($coord6 == 0){$coord6 += $data2['fleet']['fleet_end_planet'];}
                
                //Construction html des infos joueurs
                $fl_info1  = "<table><tr><th>";
                $fl_info1 .= $lang['attacker']." ".$name." ([".$coord1.":".$coord2.":".$coord3."])<br />";
                $fl_info1 .= $lang['weapon']." ".$weap."% - ".$lang['shield']." ".$shie."% - ".$lang['armour']." ".$armr."%";
                
                //On commence le tableau
                $table1  = "<table border=1 align=\"center\">";
                
                if (number_format($data1['attack']['total']) > 0) {
                    //Construction des lignes
                    $ships1  = "<tr><th>".$lang['fl_fleet_typ']."</th>";
                    $count1  = "<tr><th>".$lang['fl_count']."</th>";
                    
                    //Une ligne pour chaque type de vaisseaux
                    foreach( $data2['detail'] as $ship_id1 => $ship_count1){
                        if ($ship_count1 > 0){
                            $ships1 .= "<th>[ship[".$ship_id1."]]</th>";
                            $count1 .= "<th>".number_format($ship_count1)."</th>";
                        }
                    }
                    
                    //Fin des lignes
                    $ships1 .= "</tr>";
                    $count1 .= "</tr>";
                } else {
                    $ships1 = "<tr><br /><br />". $lang['sys_destroyed']."<br /></tr>";
                    $count1 = "";
                }
                
                //Compilons la première moitie du tour de combat attaquant(s)
                $info_part1[$fleet_id1] = $fl_info1.$table1.$ships1.$count1;
            }
            
            foreach( $attackers2 as $fleet_id2 => $data3){
                //Entete de colonne
                $weap1  = "<tr><th>".$lang['weapon']."</th>";
                $shields1  = "<tr><th>".$lang['shield']."</th>";
                $armour1  = "<tr><th>".$lang['armour']."</th>";
                
                //Une ligne pour chaque type de vaisseaux
                foreach( $data3 as $ship_id2 => $ship_points1){
                    if ($ship_points1['shield'] > 0){
                        $weap1 .= "<th>".number_format($ship_points1['att'])."</th>";
                        $shields1 .= "<th>".number_format($ship_points1['def'])."</th>";
                        $armour1 .= "<th>".number_format($ship_points1['shield'])."</th>";
                    }
                }
                
                //Fin de la table d'un tour
                $weap1 .= "</tr>";
                $shields1 .= "</tr>";
                $armour1 .= "</tr>";
                $endtable1 .= "</table></th></tr></table>";
                
                //Compilons la seconde moitié du tour
                $info_part2[$fleet_id2] = $weap1.$shields1.$armour1.$endtable1;
                
                if (number_format($data1['attack']['total']) > 0) { //Est-ce un desastre ?
                    //Maintenant qu'on a tout, on groupe et on ferme le bloc attaquant(s).
                    $html .= $info_part1[$fleet_id2].$info_part2[$fleet_id2];
                    $html .= "<br /><br />";
                } else { //OUI ...
                    $html .= $info_part1[$fleet_id2];
                    $html .= "</table></th></tr></table><br /><br />";    
                }
            }    
            
        //DEFENSEUR(S)    
            foreach( $defenders1 as $fleet_id1 => $data2){
                //Infos joueurs
                $name = $data2['user']['username'];
                $weap = ($data2['user']['military_tech'] * 10);
                $shie = ($data2['user']['defence_tech'] * 10);
                $armr = ($data2['user']['shield_tech'] * 10);
                
                //Construction html des infos joueurs
                $fl_info1  = "<table><tr><th>";
                $fl_info1 .= $lang['defender']." ".$name." ([".$coord4.":".$coord5.":".$coord6."])<br />";
                $fl_info1 .= $lang['weapon']." ".$weap."% - ".$lang['shield']." ".$shie."% - ".$lang['armour']." ".$armr."%";
                
                
                //On commence le tableau
                $table1  = "<table border=1 align=\"center\">"; 
                                   
                if (number_format($data1['defense']['total']) > 0) {    
                    //Construction des lignes
                    $ships1  = "<tr><th>".$lang['fl_fleet_typ']."</th>";
                    $count1  = "<tr><th>".$lang['fl_count']."</th>";
                    
                    //Une ligne pour chaque type d'unites
                    foreach( $data2['def'] as $ship_id1 => $ship_count1){
                        if ($ship_count1 > 0){
                            $ships1 .= "<th>[ship[".$ship_id1."]]</th>";
                            $count1 .= "<th>".number_format($ship_count1)."</th>";
                        }
                    }
                    
                    //Fin des lignes
                    $ships1 .= "</tr>";
                      $count1 .= "</tr>";
                } else {
                    $ships1 = "<tr><br /><br />". $lang['sys_destroyed']."<br /></tr>";
                    $count1 = "";
                }
                    
                
                //Compilons la première moitie du tour de combat defenseur(s)
                $info_part1[$fleet_id1] = $fl_info1.$table1.$ships1.$count1;
            }
            
            foreach( $defenders2 as $fleet_id2 => $data3){
                //Entete de colonne
                $weap1  = "<tr><th>".$lang['weapon']."</th>";
                $shields1  = "<tr><th>".$lang['shield']."</th>";
                $armour1  = "<tr><th>".$lang['armour']."</th>";
                
                //Une ligne pour chaque type d'unites
                foreach( $data3 as $ship_id2 => $ship_points1){
                    if ($ship_points1['shield'] > 0){
                        $weap1 .= "<th>".number_format($ship_points1['att'])."</th>";
                        $shields1 .= "<th>".number_format($ship_points1['def'])."</th>";
                        $armour1 .= "<th>".number_format($ship_points1['shield'])."</th>";
                    }
                }
                
                //Fin de la table d'un tour
                $weap1 .= "</tr>";
                $shields1 .= "</tr>";
                $armour1 .= "</tr>";
                $endtable1 .= "</table></th></tr></table>";
                
                //Compilons la seconde moitié du tour
                $info_part2[$fleet_id2] = $weap1.$shields1.$armour1.$endtable1;

                if (number_format($data1['defense']['total']) > 0) { //Est-ce un desatre ?                
                    //Maintenant qu'on a tout, on groupe et on ferme le bloc defenseur(s).
                    $html .= $info_part1[$fleet_id2].$info_part2[$fleet_id2];
                    $html .= "<br /><br />";
                } else { //OUI
                    $html .= $info_part1[$fleet_id2];
                    $html .= "</table></th></tr></table><br /><br />";    
                }
            }                

            //Mais que ce passe-t'il ? mais que se passe-t'il ? .... Mais qu'est-ce qui se passe ? (les inconnus)      
            $html .=  $lang['fleet_attack_1']." ".number_format($data1['attack']['total'])." ".$lang['fleet_attack_2']." ".number_format($data1['defShield'], 0, ' ', ' ')." ".$lang['damage']."<br />";
            $html .= $lang['fleet_defs_1']." ".number_format($data1['defense']['total'])." ".$lang['fleet_defs_2']." ".number_format($data1['attackShield'], 0, ' ', ' ')." ".$lang['damage']."<br /><br />";
            $round_no++;
            
        }
        
        //OK, Fin du tour
        
        //Affichons le résultat
        //Qui gagne ?
        if ($result_array['won'] == "r"){
            //Le(s) Defenseur(s) ?
            $result1  = $lang['defs_win']."<br />";
        }elseif ($result_array['won'] == "a"){
            //Le(s) Attaquant(s) ?
            $result1  = $lang['attack_win']."<br />";
            $result1 .= $lang['resource_take']." ".$steal_array['metal']." ".$lang['Metal'].", ".$steal_array['crystal']." ".$lang['Crystal']." ".$lang['and']." ".$steal_array['deuterium']." ".$lang['Deuterium']."<br />";
        }else{
            //Et pourquoi pas un match nul ?
            $result1  = $lang['draw'].".<br />";
        }
        
        // Fin du RC        
        $html .= "<br /><br />";
        $html .= $result1;
        $html .= "<br />";
        
        $debirs_meta = ($result_array['debree']['att'][0] + $result_array['debree']['def'][0]);
        $debirs_crys = ($result_array['debree']['att'][1] + $result_array['debree']['def'][1]);
        $html .= $lang['attack_loose_units']." ".$result_array['lost']['att']." ".$lang['units']."<br />";
        $html .= $lang['defs_loose_units']." ".$result_array['lost']['def']." ".$lang['units']."<br />";
        $html .= $lang['debree_field_1']." ".$debirs_meta." ".$lang['Metal']." ".$lang['and']." ".$debirs_crys." ".$lang['debree_field_2']."<br /><br />";
        
        $html .= $lang['moon_chance']." ".$moon_int." ".$lang['percent_moon']."<br />";
        $html .= $moon_string."<br /><br />";

        $html .= $lang['calculate_rc']." ".$time_float." ".$lang['seconds']."<br />";
        
        //return array('html' => $html, 'bbc' => $bbc, 'extra' => $extra);
        return array('html' => $html, 'bbc' => $bbc);
    }
?>