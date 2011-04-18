<?php
    function calculateAttack (&$attackers, &$defenders) {
        global $pricelist, $CombatCaps, $game_config, $resource;

        // generate new table for rapid fire
        $rf[target] = array ( shooter1 => shots1, shooter2 => shots2 );
        foreach ( $CombatCaps as $e => $arr ) {
            foreach ( $arr['sd'] as $t => $sd ) {
                // skip no rf here
                if ( $sd == 1  ||  $sd == 0 ) { continue; }
                $rf[$t][$e] = $sd;
            }
        }

        $totalResourcePoints = array('attacker' => 0, 'defender' => 0);
        $resourcePointsAttacker = array('metal' => 0, 'crystal' => 0, 'appolonium' => 0);

        foreach ($attackers as $fleetID => $attacker) {
            foreach ($attacker['detail'] as $element => $amount) {
                $resourcePointsAttacker['metal'] += $pricelist[$element]['metal'] * $amount;
                $resourcePointsAttacker['crystal'] += $pricelist[$element]['crystal'] * $amount ;
				$resourcePointsAttacker['appolonium'] += $pricelist[$element]['appolonium'] * $amount ;

                $totalResourcePoints['attacker'] += $pricelist[$element]['metal'] * $amount ;
                $totalResourcePoints['attacker'] += $pricelist[$element]['crystal'] * $amount ;
				$totalResourcePoints['attacker'] += $pricelist[$element]['appolonium'] * $amount ;
            }
        }

        $resourcePointsDefender = array('metal' => 0, 'crystal' => 0, 'appolonium' => 0);
        foreach ($defenders as $fleetID => $defender) {
            foreach ($defender['def'] as $element => $amount) {                                //Line20
                if ($element <= 300) {
                    $resourcePointsDefender['metal'] += $pricelist[$element]['metal'] * $amount ;
                    $resourcePointsDefender['crystal'] += $pricelist[$element]['crystal'] * $amount ;
					$resourcePointsDefender['appolonium'] += $pricelist[$element]['appolonium'] * $amount ;

                    $totalResourcePoints['defender'] += $pricelist[$element]['metal'] * $amount ;
                    $totalResourcePoints['defender'] += $pricelist[$element]['crystal'] * $amount ;
					$totalResourcePoints['defender'] += $pricelist[$element]['appolonium'] * $amount ;
                   }
				    if ($element >= 300) { 
                    if (!isset($originalDef[$element])) {
					$originalDef[$element] = 0;
					}
                    $originalDef[$element] += $amount;
                    $totalResourcePoints['defender'] += $pricelist[$element]['metal'] * $amount ;
                    $totalResourcePoints['defender'] += $pricelist[$element]['crystal'] * $amount ;
					$totalResourcePoints['defender'] += $pricelist[$element]['appolonium'] * $amount ;
                }
            }
        }

        //$max_rounds = MAX_ATTACK_ROUNDS;
        $max_rounds = 6;
		


        for ($round = 1, $rounds = array(); $round <= $max_rounds; $round++) {
            $attackDamage  = array('total' => 0);
            $attackShield  = array('total' => 0);
            $attackAmount  = array('total' => 0);
            $defenseDamage = array('total' => 0);
            $defenseShield = array('total' => 0);
            $defenseAmount = array('total' => 0);
            $attArray = array();
            $defArray = array();

            foreach ($attackers as $fleetID => $attacker) {
                $attackDamage[$fleetID] = 0;
                $attackShield[$fleetID] = 0;
                $attackAmount[$fleetID] = 0;

                foreach ($attacker['detail'] as $element => $amount) {
				    
                    $attTech    = (1 + (0.1 * $attacker['user']['military_tech']) + (0.05 * $attacker['user']['rpg_amiral'])); //Waffentechnik
					$shieldTech = (1 + (0.1 * $attacker['user']['shield_tech']) + (0.05 * $attacker['user']['rpg_amiral'])); //Schildtechnik
                    $defTech    = (1 + (0.1 * $attacker['user']['defence_tech']) + (0.05 * $attacker['user']['rpg_amiral'])); //Raumschiffpanzer
                    

                    $attackers[$fleetID]['techs'] = array($shieldTech, $defTech, $attTech);

                    $thisAtt    = $amount * ($CombatCaps[$element]['attack']) * $attTech; //Waffentechnik
                    $thisShield = $amount * ($CombatCaps[$element]['shield']) * $shieldTech ; //Schidtechnik
                    $thisDef    = $amount * ($CombatCaps[$element]['struktur']) * $defTech; //Raumschiffpanzerung

                    $attArray[$fleetID][$element] = array('def' => $thisDef, 'shield' => $thisShield, 'att' => $thisAtt);

                    $attackDamage[$fleetID] += $thisAtt;
                    $attackDamage['total'] += $thisAtt;
                    $attackShield[$fleetID] += $thisShield;
                    $attackShield['total'] += $thisShield;
                    $attackAmount[$fleetID] += $amount;
                    $attackAmount['total'] += $amount;
                }
            }
         
            foreach ($defenders as $fleetID => $defender) {
                $defenseDamage[$fleetID] = 0;
                $defenseShield[$fleetID] = 0;
                $defenseAmount[$fleetID] = 0;

                foreach ($defender['def'] as $element => $amount) {
                    $attTech    = (1 + (0.1 * $defender['user']['military_tech']) + (0.05 * $defender['user']['rpg_amiral'])); //Waffentechnik
					$shieldTech = (1 + (0.1 * $defender['user']['shield_tech']) + (0.05 * $defender['user']['rpg_amiral'])); //Schildtechnik
                    $defTech    = (1 + (0.1 * $defender['user']['defence_tech']) + (0.05 * $defender['user']['rpg_amiral'])); //Raumschiffpanzer
                    
					

                    $defenders[$fleetID]['techs'] = array($shieldTech, $defTech, $attTech);

                    $thisAtt    = $amount * ($CombatCaps[$element]['attack']) * $attTech; //Waffentechnik
                    $thisShield = $amount * ($CombatCaps[$element]['shield']) * $shieldTech ; //Schidtechnik
                    $thisDef    = $amount * ($CombatCaps[$element]['struktur']) * $defTech; //Raumschiffpanzerung

//                    if ($element == 407 || $element == 408 || $element == 409) $thisAtt = 0;

                    $defArray[$fleetID][$element] = array('def' => $thisDef, 'shield' => $thisShield, 'att' => $thisAtt);

                    $defenseDamage[$fleetID] += $thisAtt;
                    $defenseDamage['total'] += $thisAtt;
                    $defenseShield[$fleetID] += $thisShield;
                    $defenseShield['total'] += $thisShield;
                    $defenseAmount[$fleetID] += $amount;
                    $defenseAmount['total'] += $amount;
                }
            }

            $rounds[$round] = array('attackers' => $attackers, 'defenders' => $defenders, 'attack' => $attackDamage, 'defense' => $defenseDamage, 'attackA' => $attackAmount, 'defenseA' => $defenseAmount, 'infoA' => $attArray, 'infoD' => $defArray);

            if ($defenseAmount['total'] <= 0 || $attackAmount['total'] <= 0) {
                break;
            }

            // Calculate hit percentages (ACS only but ok)
            $attackPct = array();
            foreach ($attackAmount as $fleetID => $amount) {
                if (!is_numeric($fleetID)) continue;
                $attackPct[$fleetID] = $amount / $attackAmount['total'];
            }

            $defensePct = array();
            foreach ($defenseAmount as $fleetID => $amount) {
                if (!is_numeric($fleetID)) continue;
                $defensePct[$fleetID] = $amount / $defenseAmount['total'];
            }

            // CALCUL DES PERTES !!!
            $attacker_n = array();
            $attacker_shield = 0;
            foreach ($attackers as $fleetID => $attacker) {
                $attacker_n[$fleetID] = array();

                foreach($attacker['detail'] as $element => $amount) {
                    $defender_moc = $amount * ($defenseDamage['total'] * $attackPct[$fleetID]) / $attackAmount[$fleetID];
                    // rapid fire against this element
                    if ( is_array($rf[$element])  &&  $amount > 0 ) {
                        foreach ( $rf[$element] as $shooter => $shots ) {
                            foreach ( $defArray as $fID => $rfdef ) {
                                if ( $rfdef[$shooter]['att'] > 0  &&  $attackAmount[$fleetID] > 0 ) {
                                    // add damage
                                    $defender_moc += $rfdef[$shooter]['att'] * $shots / ( $amount/$attackAmount[$fleetID]*$attackPct[$fleetID] );
                                    // increase total amount of hits
                                    $defenseAmount['total'] += $defenders[$fID]['def'][$shooter] * $shots;
                                }
                            }
                        }
                    }

                    if ($amount > 0) {
                        if ($attArray[$fleetID][$element]['shield']/$amount < $defender_moc) {
                            $max_removePoints = floor($amount * $defenseAmount['total'] / $attackAmount[$fleetID] * $attackPct[$fleetID]);

                            $defender_moc -= $attArray[$fleetID][$element]['shield'];
                            $attacker_shield += $attArray[$fleetID][$element]['shield'];
                            $ile_removePoints = floor( $defender_moc / ($attArray[$fleetID][$element]['def']/$amount) );

                            if ($max_removePoints < 0) $max_removePoints = 0;
                            if ($ile_removePoints < 0) $ile_removePoints = 0;

                            if ($ile_removePoints > $max_removePoints) {
                                $ile_removePoints = $max_removePoints;
                            }

                            $attacker_n[$fleetID][$element] = ceil($amount - $ile_removePoints);
                            if ($attacker_n[$fleetID][$element] <= 0) {
                                $attacker_n[$fleetID][$element] = 0;
                            }
                        } else {
                            $attacker_n[$fleetID][$element] = round($amount);
                            $attacker_shield += $defender_moc;
                        }
                    } else {
                        $attacker_n[$fleetID][$element] = round($amount);
                        $attacker_shield += $defender_moc;
                    }
                }
            }

            $defender_n = array();
            $defender_shield = 0;

            foreach ($defenders as $fleetID => $defender) {
                $defender_n[$fleetID] = array();

                foreach($defender['def'] as $element => $amount) {
                    $attacker_moc = $amount * ($attackDamage['total'] * $defensePct[$fleetID]) / $defenseAmount[$fleetID];
                    // rapid fire against this element
                    if ( is_array($rf[$element])  &&  $amount > 0 ) {
                        foreach ( $rf[$element] as $shooter => $shots ) {
                            foreach ( $attArray as $fID => $rfatt ) {
                                if ( $rfatt[$shooter]['att'] > 0  &&  $defenseAmount[$fleetID] > 0 ) {
                                    // add damage
                                    $attacker_moc += $rfatt[$shooter]['att'] * $shots / ( $amount/$defenseAmount[$fleetID]*$defensePct[$fleetID] );
                                    // increase total amount of hits
                                    $attackAmount['total'] += $attackers[$fID]['detail'][$shooter] * $shots;
                                }
                            }
                        }
                    }

                    if ($amount > 0) {
                        if ($defArray[$fleetID][$element]['shield']/$amount < $attacker_moc) {
                            $max_removePoints = floor($amount * $attackAmount['total'] / $defenseAmount[$fleetID] * $defensePct[$fleetID]);
                            $attacker_moc -= $defArray[$fleetID][$element]['shield'];
                            $defender_shield += $defArray[$fleetID][$element]['shield'];
                            $ile_removePoints = floor( $attacker_moc / ($defArray[$fleetID][$element]['def']/$amount) );

                            if ($max_removePoints < 0) $max_removePoints = 0;
                            if ($ile_removePoints < 0) $ile_removePoints = 0;

                            if ($ile_removePoints > $max_removePoints) {
                                $ile_removePoints = $max_removePoints;
                            }

                            $defender_n[$fleetID][$element] = ceil($amount - $ile_removePoints);
                            if ($defender_n[$fleetID][$element] <= 0) {
                                $defender_n[$fleetID][$element] = 0;
                            }

                        } else {
                            $defender_n[$fleetID][$element] = round($amount);
                            $defender_shield += $attacker_moc;
                        }
                    } else {
                        $defender_n[$fleetID][$element] = round($amount);
                        $defender_shield += $attacker_moc;
                    }
                }
            }

            // "Rapidfire"
            /*foreach ($attackers as $fleetID => $attacker) {
                foreach ($defenders as $fleetID2 => $defender) {
                    foreach($attacker['detail'] as $element => $amount) {
                        if ($amount > 0) {
                            foreach ($CombatCaps[$element]['sd'] as $c => $d) {
                                if (isset($defender['def'][$c])) {
                                    if ($d > 0) {
                                        $e = ($d / $defender['techs'][0]) / ($defender['techs'][1] * $attacker['techs'][2]);
                                        $defender_n[$fleetID2][$c] -= ceil(($amount * $e * (rand(50,120)/ 100)/ 2) * $defensePct[$fleetID2] * ($amount / $attackAmount[$fleetID]));
                                        if ($defender_n[$fleetID2][$c] <= 0) {
                                            $defender_n[$fleetID2][$c] = 0;
                                        }
                                    }
                                }
                            }
                        }
                    }

                    foreach($defender['def'] as $element => $amount) {
                        if ($amount > 0) {
                            foreach ($CombatCaps[$element]['sd'] as $c => $d) {
                                if (isset($attacker['detail'][$c])) {
                                    if ($d > 0) {
                                        $e = ($d / $defender['techs'][0]) / ($defender['techs'][1] * $attacker['techs'][2]);
                                        $attacker_n[$fleetID][$c] -= ceil(($amount * $e * (rand(50,120)/ 100)/ 2) * $attackPct[$fleetID] * ($amount / $defenseAmount[$fleetID2]));
                                        if ($attacker_n[$fleetID][$c] <= 0) {
                                            $attacker_n[$fleetID][$c] = 0;
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }*/

            $rounds[$round]['attackShield'] = $attacker_shield;
            $rounds[$round]['defShield'] = $defender_shield;

            foreach ($attackers as $fleetID => $attacker) {
                $attackers[$fleetID]['detail'] = array_map('round', $attacker_n[$fleetID]);
            }

            foreach ($defenders as $fleetID => $defender) {
                $defenders[$fleetID]['def'] = array_map('round', $defender_n[$fleetID]);
            }
        }

        if ($attackAmount['total'] <= 0) {
            $won = "r"; // defender

        } elseif ($defenseAmount['total'] <= 0) {
            $won = "a"; // attacker

        } else {
            $won = "w"; // draw
            //$won = array('attackers' => $attackers, 'defenders' => $defenders, 'attack' => $attackDamage, 'defense' => $defenseDamage, 'attackA' => $attackAmount, 'defenseA' => $defenseAmount);
        }

        // CDR
        foreach ($attackers as $fleetID => $attacker) {                                       // flotte attaquant en CDR
            foreach ($attacker['detail'] as $element => $amount) {
                $totalResourcePoints['attacker'] -= $pricelist[$element]['metal'] * $amount ;
                $totalResourcePoints['attacker'] -= $pricelist[$element]['crystal'] * $amount ;
				$totalResourcePoints['attacker'] -= $pricelist[$element]['appolonium'] * $amount ;

                $resourcePointsAttacker['metal'] -= $pricelist[$element]['metal'] * $amount ;
                $resourcePointsAttacker['crystal'] -= $pricelist[$element]['crystal'] * $amount ;
				$resourcePointsAttacker['appolonium'] -= $pricelist[$element]['appolonium'] * $amount ;
            }
        }

        $resourcePointsDefenderDefs = array('metal' => 0, 'crystal' => 0,'appolonium' => 0);
        foreach ($defenders as $fleetID => $defender) {
            foreach ($defender['def'] as $element => $amount) {
                if ($element <= 300) {                                                        // flotte defenseur en CDR
                    $resourcePointsDefender['metal'] -= $pricelist[$element]['metal'] * $amount ;
                    $resourcePointsDefender['crystal'] -= $pricelist[$element]['crystal'] * $amount ;
					$resourcePointsDefender['appolonium'] -= $pricelist[$element]['appolonium'] * $amount ;

                    $totalResourcePoints['defender'] -= $pricelist[$element]['metal'] * $amount ;
                    $totalResourcePoints['defender'] -= $pricelist[$element]['crystal'] * $amount ;
					$totalResourcePoints['defender'] -= $pricelist[$element]['appolonium'] * $amount ;
                }
				if ($element >= 300) {                                                                  // defs defenseur en CDR + reconstruction
                    $totalResourcePoints['defender'] -= $pricelist[$element]['metal'] * $amount ;
                    $totalResourcePoints['defender'] -= $pricelist[$element]['crystal'] * $amount ;
					$totalResourcePoints['defender'] -= $pricelist[$element]['appolonium'] * $amount ;

                    $lost = $originalDef[$element] - $amount;
                    $giveback = round($lost * (rand(70*0.8, 70*1.2) / 100));
                    $defenders[$fleetID]['def'][$element] += $giveback;
                    $resourcePointsDefenderDefs['metal'] += $pricelist[$element]['metal'] * ($lost - $giveback) ;
                    $resourcePointsDefenderDefs['crystal'] += $pricelist[$element]['crystal'] * ($lost - $giveback) ;
					$resourcePointsDefenderDefs['appolonium'] += $pricelist[$element]['appolonium'] * ($lost - $giveback) ;

                }
            }
        }


        $totalLost = array('att' => $totalResourcePoints['attacker'], 'def' => $totalResourcePoints['defender']);
        $debAttMet = round($resourcePointsAttacker['metal'] * ($game_config['Fleet_Cdr'] / 100));
        $debAttCry = round($resourcePointsAttacker['crystal'] * ($game_config['Fleet_Cdr'] / 100));
		$debAttAppo = round($resourcePointsAttacker['appolonium'] * ($game_config['Fleet_Cdr'] / 100));
        $debDefMet = round($resourcePointsDefender['metal'] * ($game_config['Fleet_Cdr'] / 100)) + ($resourcePointsDefenderDefs['metal'] * ($game_config['Defs_Cdr'] / 100));
        $debDefCry = round($resourcePointsDefender['crystal'] * ($game_config['Fleet_Cdr'] / 100)) + ($resourcePointsDefenderDefs['crystal'] * ($game_config['Defs_Cdr'] / 100));
		$debDefAppo = round($resourcePointsDefender['appolonium'] * ($game_config['Fleet_Cdr'] / 100)) + ($resourcePointsDefenderDefs['appolonium'] * ($game_config['Defs_Cdr'] / 100));

        return array('won' => $won, 'debree' => array('att' => array($debAttMet, $debAttCry, $debAttAppo), 'def' => array($debDefMet, $debDefCry, $debDefAppo)), 'rw' => $rounds, 'lost' => $totalLost);
    }
?>