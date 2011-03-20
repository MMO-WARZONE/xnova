<?php
                        
        $targetPlanet = doquery("SELECT * FROM {{table}} WHERE `galaxy` = ". $FleetRow['fleet_end_galaxy'] ." AND `system` = ". $FleetRow['fleet_end_system'] ." AND `planet_type` = ". $FleetRow['fleet_end_type'] ." AND `planet` = ". $FleetRow['fleet_end_planet'] .";",'planets', true);
//            if (!isset($targetPlanet['id'])) {
                if ($FleetRow['fleet_group'] > 0) {
                    //MadnessRed Code
                    doquery("DELETE FROM {{table}} WHERE id =".$FleetRow['fleet_group'],'aks');
                    doquery("UPDATE {{table}} SET fleet_mess=1 WHERE fleet_group=".$FleetRow['fleet_group'],'fleets');
                } else {
                    doquery("UPDATE {{table}} SET fleet_mess=1 WHERE fleet_id=".$FleetRow['fleet_id'],'fleets');
                }
//                return;
//            }
        $targetGalaxy = doquery('SELECT * FROM {{table}} WHERE `galaxy` = '. $FleetRow['fleet_end_galaxy'] .' AND `system` = '. $FleetRow['fleet_end_system'] .' AND `planet` = '. $FleetRow['fleet_end_planet'] .';','galaxy', true);
        $targetUser   = doquery('SELECT * FROM {{table}} WHERE id='.$targetPlanet['id_owner'],'users', true);
        // Mise à jour de la cible ...
        PlanetResourceUpdate ( $targetUser, $targetPlanet, time() );
        // On recharge les infos qui viennent d'être mises à jour
        $targetGalaxy = doquery('SELECT * FROM {{table}} WHERE `galaxy` = '. $FleetRow['fleet_end_galaxy'] .' AND `system` = '. $FleetRow['fleet_end_system'] .' AND `planet` = '. $FleetRow['fleet_end_planet'] .';','galaxy', true);
        $targetUser   = doquery('SELECT * FROM {{table}} WHERE id='.$targetPlanet['id_owner'],'users', true);
        $TargetUserID = $targetUser['id'];        
        // AG : Mettre toutes les flottes dans un tableau
        $attackFleets = array();
        // De forme : attackFleets[id] = array('fleet' => $FleetRow, 'user' => $user);
        
        if ($FleetRow['fleet_group'] != 0) { // Si c'est une AG
            $fleets = doquery('SELECT * FROM {{table}} WHERE fleet_group='.$FleetRow['fleet_group'],'fleets'); // Selection de toute les flottes composant l'AG
            while ($fleet = mysql_fetch_assoc($fleets)) {
                $attackFleets[$fleet['fleet_id']]['fleet'] = $fleet;
                $attackFleets[$fleet['fleet_id']]['user'] = doquery('SELECT * FROM {{table}} WHERE id ='.$fleet['fleet_owner'],'users', true);
                $attackFleets[$fleet['fleet_id']]['detail'] = array();
                $temp = explode(';', $fleet['fleet_array']);
                foreach ($temp as $temp2) {
                    $temp2 = explode(',', $temp2);
                    
                    if ($temp2[0] < 100) continue;
                    
                    if (!isset($attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]])) $attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]] = 0;
                    $attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
                }
            }
    
        } else { // Si ça n'en est pas une
            $attackFleets[$FleetRow['fleet_id']]['fleet'] = $FleetRow;
            $attackFleets[$FleetRow['fleet_id']]['user'] = doquery('SELECT * FROM {{table}} WHERE id='.$FleetRow['fleet_owner'],'users', true);
            $attackFleets[$FleetRow['fleet_id']]['detail'] = array();
            $temp = explode(';', $FleetRow['fleet_array']);
            foreach ($temp as $temp2) {
                $temp2 = explode(',', $temp2);
                
                if ($temp2[0] < 100) continue;
                
                if (!isset($attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]])) $attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]] = 0;
                $attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
            }
        }
        // AG : Mettre toutes les flottes et défenses dans un tableau
        $defense = array();
        // De forme : defense[id] = array('def' => $defRow); (id 0 = planet)
        
        $def = doquery('SELECT * FROM {{table}} WHERE `fleet_end_galaxy` = '. $FleetRow['fleet_end_galaxy'] .' AND `fleet_end_system` = '. $FleetRow['fleet_end_system'] .' AND `fleet_end_type` = '. $FleetRow['fleet_end_type'] .' AND `fleet_end_planet` = '. $FleetRow['fleet_end_planet'] .' AND fleet_start_time<'.time().' AND fleet_end_stay>='.time(),'fleets');
        while ($defRow = mysql_fetch_assoc($def)) { // Groupons les flottes en stationnement s'il y a, et la défense de la planète
            $defRowDef = explode(';', $defRow['fleet_array']);
            foreach ($defRowDef as $Element) {
                $Element = explode(',', $Element);
                
                if ($Element[0] < 100) continue;
                
                if (!isset($defense[$defRow['fleet_id']]['def'][$Element[0]])) $defense[$defRow['fleet_id']][$Element[0]] = 0;
                $defense[$defRow['fleet_id']]['def'][$Element[0]] += $Element[1];
                $defense[$defRow['fleet_id']]['user'] = doquery('SELECT * FROM {{table}} WHERE id='.$defRow['fleet_owner'],'users', true);
            }
        }
        // Pas de défense groupée ? dommage
        $defense[0]['def'] = array();
        $defense[0]['user'] = $targetUser;
        for ($i = 200; $i < 500; $i++) {
            if (isset($resource[$i]) && isset($targetPlanet[$resource[$i]])) {
                $defense[0]['def'][$i] = $targetPlanet[$resource[$i]];
            }
        }

        // Initialisation du calcul du temps de traitement            
        $start = microtime(true);
        //Debug
        //echo "<font color=\"red\">A combat report has been generated. Please post any errors below on the forums. Thanks</font><br />";
        // Booooooooommmm.... le combat !!
        $result = calculateAttack ($attackFleets, $defense);
        // Fin du calcul du temps e traitement
        $totaltime = microtime(true) - $start;
        
        // Mise a jour du champ de ruine devant la planete attaquée
            $QryUpdateGalaxy = "UPDATE {{table}} SET ";
            $QryUpdateGalaxy .= "`metal` = `metal` +'".($result['debree']['att'][0]+$result['debree']['def'][0]) . "', ";
            $QryUpdateGalaxy .= "`crystal` = `crystal` + '" .($result['debree']['att'][1]+$result['debree']['def'][1]). "', ";
			$QryUpdateGalaxy .= "`appolonium` = `appolonium` + '" .($result['debree']['att'][2]+$result['debree']['def'][2]). "' ";
            $QryUpdateGalaxy .= "WHERE ";
            $QryUpdateGalaxy .= "`galaxy` = '" . $FleetRow['fleet_end_galaxy'] . "' AND ";
            $QryUpdateGalaxy .= "`system` = '" . $FleetRow['fleet_end_system'] . "' AND ";
            $QryUpdateGalaxy .= "`planet` = '" . $FleetRow['fleet_end_planet'] . "' ";
            $QryUpdateGalaxy .= "LIMIT 1;";
            doquery($QryUpdateGalaxy , 'galaxy');
            
//         Mise à jour du CDR en table galaxy
//        doquery('UPDATE {{table}} SET metal=metal+'.($result['debree']['att'][0]+$result['debree']['def'][0]).' , crystal=crystal+'.($result['debree']['att'][1]+$result['debree']['def'][1]).' WHERE `galaxy` = '. $FleetRow['fleet_end_galaxy'] .' AND `system` = '. $FleetRow['fleet_end_system'] .' AND `planet` = '. $FleetRow['fleet_end_planet'],'galaxy');        
        
        $totalDebree = $result['debree']['def'][0] + $result['debree']['def'][1] + $result['debree']['att'][0] + $result['debree']['att'][1];
        
        $steal = array('metal' => 0, 'crystal' => 0, 'deuterium' => 0, 'appolonium' => 0);
        if ($result['won'] == "a") {
         
            // Calculons la capacité de transpor du restant de flotte après combat
            $max_resources = 0;
            foreach ($attackFleets[$FleetRow['fleet_id']]['detail'] as $Element => $amount) {
                $max_resources += $pricelist[$Element]['capacity'] * $amount;
            }
            
            if ($max_resources > 0) {
                $metal   = $targetPlanet['metal'] / 2;
                $crystal = $targetPlanet['crystal'] / 2;
                $deuter  = $targetPlanet['deuterium'] / 2;
				$appolonium  = $targetPlanet['appolonium'] / 2;
				 if ($appolonium > $max_resources / 4) {
                    $steal['appolonium']     = $max_resources / 4;
                    $max_resources        -= $steal['appolonium'];
                } else {
                    $steal['appolonium']     = $appolonium;
                    $max_resources        -= $steal['appolonium'];
                }
                if ($deuter > $max_resources / 3) {
                    $steal['deuterium']     = $max_resources / 3;
                    $max_resources        -= $steal['deuterium'];
                } else {
                    $steal['deuterium']     = $deuter;
                    $max_resources        -= $steal['deuterium'];
                }
                
                if ($crystal > $max_resources / 2) {
                    $steal['crystal'] = $max_resources / 2;
                    $max_resources   -= $steal['crystal'];
                } else {
                    $steal['crystal'] = $crystal;
                    $max_resources   -= $steal['crystal'];
                }
                
                if ($metal > $max_resources) {
                    $steal['metal']         = $max_resources;
                    $max_resources         = $max_resources - $steal['metal'];
                } else {
                    $steal['metal']         = $metal;
                    $max_resources        -= $steal['metal'];
                }            
            }
            
            $steal = array_map('round', $steal);

            // Mise à jour de la flotte après pillage
            $QryUpdateFleet  = 'UPDATE {{table}} SET ';
            $QryUpdateFleet .= '`fleet_resource_metal` = `fleet_resource_metal` + '. $steal['metal'] .', ';
            $QryUpdateFleet .= '`fleet_resource_crystal` = `fleet_resource_crystal` +'. $steal['crystal'] .', ';
			$QryUpdateFleet .= '`fleet_resource_deuterium` = `fleet_resource_deuterium` +'. $steal['deuterium'] .', ';
            $QryUpdateFleet .= '`fleet_resource_appolonium` = `fleet_resource_appolonium` +'. $steal['appolonium'] .' ';
            $QryUpdateFleet .= 'WHERE fleet_id = '. $FleetRow['fleet_id'] .' ';
            $QryUpdateFleet .= 'LIMIT 1 ;';
            doquery( $QryUpdateFleet,'fleets' );
        }
        
        // Mise à jour flotte et planètes
        foreach ($attackFleets as $fleetID => $attacker) { // Flottes attaquantes
            $fleetArray = '';
            $totalCount = 0;
            foreach ($attacker['detail'] as $element => $amount) {
                if ($amount) $fleetArray .= $element.','.$amount.';';
                $totalCount += $amount;
            }
            
            if ($totalCount <= 0) {
                doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.$fleetID,'fleets');
            
            } else {
                doquery ('UPDATE {{table}} SET fleet_array="'.substr($fleetArray, 0, -1).'", fleet_amount='.$totalCount.', fleet_mess=1 WHERE fleet_id='.$fleetID,'fleets');
            }
        }
        
        foreach ($defense as $fleetID => $defender) { // Flottes et Défenses de la cible
            if ($fleetID != 0) {
                $fleetArray = '';
                $totalCount = 0;
                foreach ($defender['def'] as $element => $amount) {
                    if ($amount) $fleetArray .= $element.','.$amount.';';
                    $totalCount += $amount;
                }
                
                if ($totalCount <= 0) {
                    doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.$fleetID,'fleets');
                
                } else {
                    doquery('UPDATE {{table}} SET fleet_array="'.$fleetArray.'", fleet_amount='.$totalCount.', fleet_mess=1 WHERE fleet_id='.$fleetID,'fleets');
                }
            
            } else {
                $fleetArray = '';
                $totalCount = 0;
                foreach ($defender['def'] as $element => $amount) {
                    $fleetArray .= '`'.$resource[$element].'`='.$amount.', ';
                }
                
            // Mise a jour de l'enregistrement de la planete attaquée
            $QryUpdateTarget  = "UPDATE {{table}} SET ";
            $QryUpdateTarget .= $fleetArray;
            $QryUpdateTarget .= "`metal` = `metal` - '". $steal['metal'] ."', ";
            $QryUpdateTarget .= "`crystal` = `crystal` - '". $steal['crystal'] ."', ";
			$QryUpdateTarget .= "`deuterium` = `deuterium` - '". $steal['deuterium'] ."', ";
            $QryUpdateTarget .= "`appolonium` = `appolonium` - '". $steal['appolonium'] ."' ";
            $QryUpdateTarget .= "WHERE ";
            $QryUpdateTarget .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
            $QryUpdateTarget .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
            $QryUpdateTarget .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
            $QryUpdateTarget .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."' ";
            $QryUpdateTarget .= "LIMIT 1;";
            doquery( $QryUpdateTarget , 'planets');
            }
        }
?>
