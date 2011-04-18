<?php

/**
* MissionCaseDestruction.php
* @Licence GNU (GPL)
* @version 2.2
* @copyright 2009 
* @Team Space Beginner
*/

      function MissionCaseDestruction($FleetRow){ 
      global $phpEx, $xnova_root_path, $pricelist, $lang, $resource, $CombatCaps, $game_config, $user;
	            includeLang('system');
	
	           	if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_start_time'] <= time()) {
		        if (!isset($CombatCaps[202]['sd'])) {
                message('<font color=red>'. $lang['sys_no_vars'] .'</font><br />(Error: <font color=red>(!isset($pricelist[202][\'sd\']))</font>. Please report this to an admin.)', $lang['sys_error'], 'fleet.php', 15);
                }
		       
				  $targetPlanet = doquery("SELECT * FROM {{table}} WHERE `galaxy` = ". $FleetRow['fleet_end_galaxy'] ." AND `system` = ". $FleetRow['fleet_end_system'] ." AND `planet_type` = ". $FleetRow['fleet_end_type'] ." AND `planet` = ". $FleetRow['fleet_end_planet'] .";",'planets', true);
                // if (!isset($targetPlanet['id'])) {
                if ($FleetRow['fleet_group'] > 0) {
                    //MadnessRed Code
                    doquery("DELETE FROM {{table}} WHERE id =".$FleetRow['fleet_group'],'aks');
                    doquery("UPDATE {{table}} SET fleet_mess=1 WHERE fleet_group=".$FleetRow['fleet_group'],'fleets');
                } else {
                    doquery("UPDATE {{table}} SET fleet_mess=1 WHERE fleet_id=".$FleetRow['fleet_id'],'fleets');
                }
               // return;
               //}
                
                // Mise à jour de la cible ...
				
                // On recharge les infos qui viennent d'être mises à jour
                $targetGalaxy = doquery('SELECT * FROM {{table}} WHERE `galaxy` = '. $FleetRow['fleet_end_galaxy'] .' AND `system` = '. $FleetRow['fleet_end_system'] .' AND `planet` = '. $FleetRow['fleet_end_planet'] .';','galaxy', true);
                $targetUser   = doquery('SELECT * FROM {{table}} WHERE id='.$targetPlanet['id_owner'],'users', true);
                $TargetUserID = $targetUser['id'];
                
                PlanetResourceUpdate ( $targetUser, $targetPlanet, time() );				
                // AG : Mettre toutes les flottes dans un tableau
                $attackFleets = array();
                // De forme : attackFleets[id] = array('fleet' => $FleetRow, 'user' => $user);
				if ($FleetRow['fleet_group'] != 0)
				{
					$fleets = doquery('SELECT * FROM {{table}} WHERE fleet_group='.$FleetRow['fleet_group'],'fleets');
					while ($fleet = mysql_fetch_assoc($fleets))
					{
						$attackFleets[$fleet['fleet_id']]['fleet'] = $fleet;
						$attackFleets[$fleet['fleet_id']]['user'] = doquery('SELECT * FROM {{table}} WHERE id ='.$fleet['fleet_owner'],'users', true);
						$attackFleets[$fleet['fleet_id']]['detail'] = array();
						$temp = explode(';', $fleet['fleet_array']);
						foreach ($temp as $temp2)
						{
							$temp2 = explode(',', $temp2);
							if ($temp2[0] < 100) continue;

							if (!isset($attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]]))
								$attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]] = 0;
							$attackFleets[$fleet['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
						}
					}

				}
				else
				{
					$attackFleets[$FleetRow['fleet_id']]['fleet'] = $FleetRow;
					$attackFleets[$FleetRow['fleet_id']]['user'] = doquery('SELECT * FROM {{table}} WHERE id='.$FleetRow['fleet_owner'],'users', true);
					$attackFleets[$FleetRow['fleet_id']]['detail'] = array();
					$temp = explode(';', $FleetRow['fleet_array']);
					foreach ($temp as $temp2)
					{
						$temp2 = explode(',', $temp2);

						if ($temp2[0] < 100) continue;

						if (!isset($attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]]))
							$attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]] = 0;

						$attackFleets[$FleetRow['fleet_id']]['detail'][$temp2[0]] += $temp2[1];
					}
				}
				$defense = array();

				$def = doquery('SELECT * FROM {{table}} WHERE `fleet_end_galaxy` = '. $FleetRow['fleet_end_galaxy'] .' AND `fleet_end_system` = '. $FleetRow['fleet_end_system'] .' AND `fleet_end_type` = '. $FleetRow['fleet_end_type'] .' AND `fleet_end_planet` = '. $FleetRow['fleet_end_planet'] .' AND fleet_start_time<'.time().' AND fleet_end_stay>='.time(),'fleets');
				while ($defRow = mysql_fetch_assoc($def)) // Haltende Flotten kommen dazu!.
				{
					$defRowDef = explode(';', $defRow['fleet_array']);
					foreach ($defRowDef as $Element)
					{
						$Element = explode(',', $Element);

						if ($Element[0] < 100) continue;

						if (!isset($defense[$defRow['fleet_id']]['def'][$Element[0]]))
							$defense[$defRow['fleet_id']][$Element[0]] = 0;

						$defense[$defRow['fleet_id']]['def'][$Element[0]] += $Element[1];
						$defense[$defRow['fleet_id']]['user'] = doquery('SELECT * FROM {{table}} WHERE id='.$defRow['fleet_owner'],'users', true);
					}
				}

				$defense[0]['def'] = array();
				$defense[0]['user'] = $targetUser;
				for ($i = 200; $i < 500; $i++)
				{
					if (isset($resource[$i]) && isset($targetPlanet[$resource[$i]]))
					{
						$defense[0]['def'][$i] = $targetPlanet[$resource[$i]];
					}
				}
				$start 		= microtime(true);
				$result 	= calculateAttack($attackFleets, $defense);
				$totaltime 	= microtime(true) - $start;
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
        switch ($result['won']) {
					case "a": {
         
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
										
          //Mondzerstörungswarscheinlichkeitsberechnung gemäß Owiki
            $destructionl1 = 100-sqrt($targetPlanet['diameter']);
			if ($attackFleets[$FleetRow['fleet_id']]['detail'][218] > 0 ){
            $destructionl21 = $destructionl1 * round(sqrt(($attackFleets[$FleetRow['fleet_id']]['detail'][218])/MAX_ST));
            $destructionl2 = $destructionl21/1;
			}else{
            $destructionl21 = $destructionl1 * round(sqrt(($attackFleets[$FleetRow['fleet_id']]['detail'][214])/MAX_RIP));
            $destructionl2 = $destructionl21/1;
			}
         
      
       
		   if ($destructionl2 > 100) {
			$chance = '100';
          } elseif ($destructionl2 < 0) {
			$chance = '0';
         } else { 
			$chance = round($destructionl2); // En pourcentage
          }
          $tirage = mt_rand(0, 100);
          $probalune       = sprintf ($lang['sys_destruc_lune'], $chance);
              if($tirage <= $chance)   {
			   
 
                 //destruction de la lune dabord dans la liste des planetes puis dans la liste des lunes et enfin dans la galaxie
                   doquery("DELETE FROM {{table}} WHERE `id` = '". $targetPlanet['id'] ."';", 'planets');
				   
				 //$Qrydestructionlune .= ";";  
                   $Qrydestructionlune  = "DELETE FROM {{table}} ";
                   $Qrydestructionlune .= "WHERE ";
                   $Qrydestructionlune .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
                   $Qrydestructionlune .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
                   $Qrydestructionlune .= "`lunapos` = '". $FleetRow['fleet_end_planet'] ."' ";
                   $Qrydestructionlune .= "LIMIT 1 ;";
                   doquery( $Qrydestructionlune , 'lunas');
               //$Qrydestructionlune2 .= ";";
                   $Qrydestructionlune2  = "UPDATE {{table}} SET ";
                   $Qrydestructionlune2 .= "`id_luna` = '0' ";
                   $Qrydestructionlune2 .= "WHERE ";
                   $Qrydestructionlune2 .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
                   $Qrydestructionlune2 .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
                   $Qrydestructionlune2 .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' ";
                   $Qrydestructionlune2 .= "LIMIT 1 ;";
                   doquery( $Qrydestructionlune2 , 'galaxy');
				   
                //la lune est detruite, alors on redirige les flottes sur la planete
			     $QryFleetsFrom = doquery("SELECT * FROM {{table}} WHERE   
				`fleet_start_galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND
				`fleet_start_system` = '".$FleetRow['fleet_end_system']."' AND
				`fleet_start_planet` = '".$FleetRow['fleet_end_planet']."' AND
				`fleet_start_type` = '3';",'fleets');
				
			     while($FromMoonFleets = mysql_fetch_array($QryFleetsFrom)){
			     doquery("UPDATE {{table}} SET `fleet_start_type` = '1' WHERE `fleet_id` = '".$FromMoonFleets['fleet_id']."';",'fleets');
			    }
			
			     $QryFleetsTo = doquery("SELECT * FROM {{table}} WHERE   
				`fleet_end_galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND
				`fleet_end_system` = '".$FleetRow['fleet_end_system']."' AND
				`fleet_end_planet` = '".$FleetRow['fleet_end_planet']."' AND
				`fleet_end_type` = '3';",'fleets');
				
			     while($ToMoonFleets = mysql_fetch_array($QryFleetsTo)){
			    doquery("UPDATE {{table}} SET `fleet_end_type` = '1' WHERE `fleet_id` = '".$ToMoonFleets['fleet_id']."';",'fleets');
			     }
				   
				   // Mond Explodiert!?Wo bleiben die Trümmer vom Mond
					   $metallmond = 0;
					   $kristallmond = 0;
					   $appolonium = 0 ;
                   // Berechnung des Trümmerfeldes
				   $metallmond = round($targetPlanet['diameter'] * 625) ;
				   $kristallmond = round($targetPlanet['diameter'] * 625) ;
				   // Berechnung Appollonium
				   $zuwert = mt_rand(100, 300);
				   $appolonium = round($targetPlanet['diameter'] * $zuwert) ;
				   // Trümmerfeld go's Galaxy
				    $QryUpdateGalaxy = "UPDATE {{table}} SET ";
                    $QryUpdateGalaxy .= "`metal` = `metal` + '" . $metallmond  . "', ";
                    $QryUpdateGalaxy .= "`crystal` = `crystal` + '" . $kristallmond . "', ";
					$QryUpdateGalaxy .= "`appolonium` = `appolonium` + '" . $appolonium . "' ";
                    $QryUpdateGalaxy .= "WHERE ";
                    $QryUpdateGalaxy .= "`galaxy` = '" . $FleetRow['fleet_end_galaxy'] . "' AND ";
                    $QryUpdateGalaxy .= "`system` = '" . $FleetRow['fleet_end_system'] . "' AND ";
                    $QryUpdateGalaxy .= "`planet` = '" . $FleetRow['fleet_end_planet'] . "' ";
                    $QryUpdateGalaxy .= "LIMIT 1;";
                    doquery($QryUpdateGalaxy , 'galaxy');
                     //maintenant on va verifier si la vue du joueur n est pas calee sur la lune qui est detruite  
                  if ($targetUser['current_planet'] == $targetPlanet['id']){
                     $QryPlanet  = "SELECT * FROM {{table}} ";
                     $QryPlanet .= "WHERE ";
                     $QryPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
                     $QryPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
                     $QryPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
                     $QryPlanet .= "`planet_type` = '1';";
                     $Planet     = doquery( $QryPlanet, 'planets', true);
                     $IDPlanet     = $Planet['id'];
                     $Qryvue  = "UPDATE {{table}} SET ";
                     $Qryvue .= "`current_planet` = '". $IDPlanet ."' ";
                     $Qryvue .= "WHERE ";
                     $Qryvue .= "`id` = '". $targetUserID ."' ";
                     $Qryvue .= ";";
                     doquery( $Qryvue , 'users');
                      }
					 
                 

			 	     $destext .= sprintf ($lang['sys_destruc_mess'], $DepName , $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'])."<br />";
				     $destext .= sprintf ($lang['sys_destruc_lune'], $chance) ."<br />";
					 $destext .= $lang['sys_debris'] ." ". $lang['Metal'] .":<font color=\"#adaead\">". ($result['debree']['att'][0]+$result['debree']['def'][0] + $metallmond) ."</font>   ". $lang['Crystal'] .":<font color=\"#ef51ef\">".( $result['debree']['att'][1]+$result['debree']['def'][1] + $kristallmond ) ."</font>". $lang['Appolonium'] .":<font color=\"#40e0d0\">".( $result['debree']['att'][2]+$result['debree']['def'][2] + $appolonium) ."</font><br />";
				     $destext .= $lang['sys_destruc_mess1']."<br />";
					 $destext .= $lang['sys_destruc_reussi']."<br />";
					 $destructionrip = sqrt($targetPlanet['diameter'])/2;
					 $chance2  = round($destructionrip);                 
					 $tirage2  = mt_rand(0, 100);
					 $destext .= sprintf ($lang['sys_destruc_rip'], $chance2)."<br />";
				         if($tirage2 <= $chance2) {
						     //Rips gehen in das Tf
					         $tftsmet = 0 ;
					         $tftscrist = 0 ;
					         if ($attackFleets[$FleetRow['fleet_id']]['detail'][218] > 0 and $attackFleets[$FleetRow['fleet_id']]['detail'][214] = 0){
					         $tftsmet = 	 round($attackFleets[$FleetRow['fleet_id']]['detail'][218] * $pricelist['218']['metal']) * ($game_config['Fleet_Cdr'] / 100);
				             $tftscrist =   round($attackFleets[$FleetRow['fleet_id']]['detail'][218] * $pricelist['218']['crystal']) *($game_config['Fleet_Cdr'] / 100);
							 $tftsappo =   round($attackFleets[$FleetRow['fleet_id']]['detail'][218] * $pricelist['218']['appolonium']) *($game_config['Fleet_Cdr'] / 100);
					        }else{
					         $tftsmet = 	 round($attackFleets[$FleetRow['fleet_id']]['detail'][214] * $pricelist['214']['metal']) * ($game_config['Fleet_Cdr'] / 100);
				             $tftscrist =   round($attackFleets[$FleetRow['fleet_id']]['detail'][214] * $pricelist['214']['crystal']) *($game_config['Fleet_Cdr'] / 100);
					         }
							 	 // Trümmerfeld go's Galaxy
                                $QryUpdateGalaxy = "UPDATE {{table}} SET ";
                                $QryUpdateGalaxy .= "`metal` = `metal` +'". $tftsmet. "', ";
                                $QryUpdateGalaxy .= "`crystal` = `crystal` + '" .$tftscrist. "', ";
								$QryUpdateGalaxy .= "`appolonium` = `appolonium` + '" .$tftsappo. "' ";
                                $QryUpdateGalaxy .= "WHERE ";
                                $QryUpdateGalaxy .= "`galaxy` = '" . $FleetRow['fleet_end_galaxy'] . "' AND ";
                                $QryUpdateGalaxy .= "`system` = '" . $FleetRow['fleet_end_system'] . "' AND ";
                                $QryUpdateGalaxy .= "`planet` = '" . $FleetRow['fleet_end_planet'] . "' ";
                                $QryUpdateGalaxy .= "LIMIT 1;";
                                doquery($QryUpdateGalaxy , 'galaxy');
					            //Rips in das Tf Ende
							 
								
								$destext .= $lang['sys_destruc_echec']." <br />";

								$destext .= $lang['sys_debris'] ." ". $lang['Metal'] .":<font color=\"#adaead\">". ($result['debree']['att'][0]+$result['debree']['def'][0] + $tftsmet) ."</font>   ". $lang['Crystal'] .":<font color=\"#ef51ef\">".( $result['debree']['att'][1]+$result['debree']['def'][1] + $tftscrist) ."</font>". $lang['Appolonium'] .":<font color=\"#40e0d0\">".( $result['debree']['att'][2]+$result['debree']['def'][2] + $tftsappo) ."</font><br />";
								doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
							}
							// Falls Mondzerstörung Abgeblockt wird
            				} else {
					        $destructionrip = sqrt($targetPlanet['diameter'])/2;
							$chance2  = round($destructionrip);                 
							$tirage2  = mt_rand(0, 100);
							$destext .= sprintf ($lang['sys_destruc_mess'], $DepName , $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'])."<br />";
							$destext .= $lang['sys_destruc_mess1']."<br />";
							$destext .= sprintf ($lang['sys_destruc_lune'], $chance) ."<br />";
							$destext .= sprintf ($lang['sys_destruc_rip'], $chance2)."<br />";
					      if($tirage2 <= $chance2) {
								
							 //Rips gehen in das Tf
					         $tftsmet = 0 ;
					         $tftscrist = 0 ;
					         if ($attackFleets[$FleetRow['fleet_id']]['detail'][218] > 0 and $attackFleets[$FleetRow['fleet_id']]['detail'][214] = 0){
					         $tftsmet = 	 round($attackFleets[$FleetRow['fleet_id']]['detail'][218] * $pricelist['218']['metal']) * ($game_config['Fleet_Cdr'] / 100);
				             $tftscrist =   round($attackFleets[$FleetRow['fleet_id']]['detail'][218] * $pricelist['218']['crystal']) *($game_config['Fleet_Cdr'] / 100);
							 $tftsappo =   round($attackFleets[$FleetRow['fleet_id']]['detail'][218] * $pricelist['218']['appolonium']) *($game_config['Fleet_Cdr'] / 100);
					        }else{
					         $tftsmet = 	 round($attackFleets[$FleetRow['fleet_id']]['detail'][214] * $pricelist['214']['metal']) * ($game_config['Fleet_Cdr'] / 100);
				             $tftscrist =   round($attackFleets[$FleetRow['fleet_id']]['detail'][214] * $pricelist['214']['crystal']) *($game_config['Fleet_Cdr'] / 100);
					         }
							 	 // Trümmerfeld go's Galaxy
                                $QryUpdateGalaxy = "UPDATE {{table}} SET ";
                                $QryUpdateGalaxy .= "`metal` = `metal` +'". $tftsmet . "', ";
                                $QryUpdateGalaxy .= "`crystal` = `crystal` + '" . $tftscrist . "', ";
								$QryUpdateGalaxy .= "`appolonium` = `appolonium` + '" .$tftsappo. "' ";
                                $QryUpdateGalaxy .= "WHERE ";
                                $QryUpdateGalaxy .= "`galaxy` = '" . $FleetRow['fleet_end_galaxy'] . "' AND ";
                                $QryUpdateGalaxy .= "`system` = '" . $FleetRow['fleet_end_system'] . "' AND ";
                                $QryUpdateGalaxy .= "`planet` = '" . $FleetRow['fleet_end_planet'] . "' ";
                                $QryUpdateGalaxy .= "LIMIT 1;";
                                doquery($QryUpdateGalaxy , 'galaxy');
					            //Rips in das Tf Ende
							 
								
								$destext .= $lang['sys_destruc_echec']." <br />";
								$destext .= $lang['sys_debris'] ." ". $lang['Metal'] .":<font color=\"#adaead\">". ($result['debree']['att'][0]+$result['debree']['def'][0] + $tftsmet) ."</font>   ". $lang['Crystal'] .":<font color=\"#ef51ef\">".( $result['debree']['att'][1]+$result['debree']['def'][1] + $tftscrist) ."</font>". $lang['Appolonium'] .":<font color=\"#ef51ef\">".( $result['debree']['att'][2]+$result['debree']['def'][2] + $tftsappo) ."</font><br />";
								doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
							} else {
								$destext .= $lang['sys_destruc_stop']."<br />";							
							}
						}
					break;
				case "r":
					$destext 		  .= sprintf ($lang['sys_destruc_mess'], $DepName , $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'])."<br />";
					$destext 		  .= $lang['sys_destruc_stop'] ."<br />";
					doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
					break;
				case "w":
					$destext 		  .= sprintf ($lang['sys_destruc_mess'], $DepName , $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'])."<br />";
					$destext 		  .= $lang['sys_destruc_stop'] ."<br />";
					break;
				default:
					break;
               }
					

			    //Ende Mondzerstörung

					 $strunitsgesamt      = $result['lost']['att'] + $result['lost']['def'];
                     $user1lostunits      = $result['lost']['att'];
                     $user1shotunits      = $result['lost']['def'];
                     $user2lostunits      = $result['lost']['def'];
                     $user2shotunits      = $result['lost']['att'];
                     $strtruemmerfeld     = $result['debree']['att'][0]+$result['debree']['def'][0]+$result['debree']['att'][1]+$result['debree']['def'][1]+$result['debree']['att'][2]+$result['debree']['def'][2];
                     $strtruemmermetal    = $result['debree']['att'][0]+$result['debree']['def'][0];
                     $strtruemmercrystal  = $result['debree']['att'][1]+$result['debree']['def'][1];
                     $strtruemmerappolonium  = $result['debree']['att'][2]+$result['debree']['def'][2];
                     $FleetDebris      = $result['debree']['att'][0] + $result['debree']['def'][0] + $result['debree']['att'][1] + $result['debree']['def'][1]+ $result['debree']['att'][2] + $result['debree']['def'][2];
                     $StrAttackerUnits = sprintf ($lang['sys_attacker_lostunits'], $result['lost']['att']);
                     $StrDefenderUnits = sprintf ($lang['sys_defender_lostunits'], $result['lost']['def']);
                     $StrRuins         = sprintf ($lang['sys_gcdrunits'], $result['debree']['def'][0] + $result['debree']['att'][0], $lang['Metal'], $result['debree']['def'][1] + $result['debree']['att'][1], $lang['Crystal'], $result['debree']['def'][2] + $result['debree']['att'][2], $lang['Appolonium']);
                     $DebrisField      = $StrAttackerUnits ."<br />". $StrDefenderUnits ."<br />". $StrRuins;

             // Monderstellung
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
           // Mond ja
        if (($UserChance > 0) && ($UserChance <= $MoonChance) && ($targetGalaxy['id_luna'] == 0)) {
          $TargetPlanetName = CreateOneMoonRecord ( $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'], $TargetUserID, $FleetRow['fleet_start_time'], '', $MoonChance );
          $GottenMoon       = sprintf ($lang['sys_moonbuilt'], $TargetPlanetName, $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
          $GottenMoon .= "<br />";
		  //Warum gibt es ein Trümmerfeld wenn der Mond doch daraus ensteht???
	      //Abfrage der Größe des Trümmerfeldes?  
	      $QrySelectGalaxy  = "SELECT * FROM {{table}} ";
	      $QrySelectGalaxy .= "WHERE ";
	      $QrySelectGalaxy .= "`galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND ";
	      $QrySelectGalaxy .= "`system` = '".$FleetRow['fleet_end_system']."' AND ";
	      $QrySelectGalaxy .= "`planet` = '".$FleetRow['fleet_end_planet']."' ";
	      $QrySelectGalaxy .= "LIMIT 1;";
	      $TargetGalaxy     = doquery( $QrySelectGalaxy, 'galaxy', true);
	      // Trümmerfeld wird gelöscht da der Mond aus den Trümmern entstanden ist!.  
         $QryUpdateGalaxy  = "UPDATE {{table}} SET ";
         $QryUpdateGalaxy .= "`metal` = `metal` - '".$TargetGalaxy["metal"]."', ";
	     $QryUpdateGalaxy .= "`crystal` = `crystal` - '".$TargetGalaxy["crystal"]."', ";
		 $QryUpdateGalaxy .= "`appolonium` = `appolonium` - '".$TargetGalaxy["appolonium"]."' ";
	     $QryUpdateGalaxy .= "WHERE ";
	     $QryUpdateGalaxy .= "`galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND ";
	     $QryUpdateGalaxy .= "`system` = '".$FleetRow['fleet_end_system']."' AND ";
	     $QryUpdateGalaxy .= "`planet` = '".$FleetRow['fleet_end_planet']."' ";
	     $QryUpdateGalaxy .= "LIMIT 1;";
	     doquery( $QryUpdateGalaxy, 'galaxy');
		   // Mond nein
       } elseif ($UserChance = 0 or $UserChance > $MoonChance) {
           $GottenMoon = "";
   		  }

         $OwnedUser = doquery('SELECT * FROM {{table}} WHERE id='.$FleetRow['fleet_owner'],'users', true);

         $formatted_cr = formatCRM($result,$steal,$MoonChance,$GottenMoon,$totaltime,$destext);
         $raport = $formatted_cr['html'];
         $rid   = md5($raport);
         $QryInsertRapport  = 'INSERT INTO {{table}} SET ';
         $QryInsertRapport .= '`time` = UNIX_TIMESTAMP(), ';
		 
         foreach ($attackFleets as $fleetID => $attacker) {
         $users2[$attacker['user']['id']] = $attacker['user']['id'];
       }
         foreach ($defense as $fleetID => $defender) {
         $users2[$defender['user']['id']] = $defender['user']['id'];
      }
          $QryInsertRapport .= '`owners` = "'.implode(',', $users2).'", ';
          $QryInsertRapport .= '`rid` = "'. $rid .'", ';
          $QryInsertRapport .= '`raport` = "'. mysql_real_escape_string( $raport ) .'"';
          doquery($QryInsertRapport,'rw') or die("Error inserting CR to database".mysql_error()."<br /><br />Trying to execute:".mysql_query());
          $angreifer = $formatted_cr['angreifer'];
          $dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
          $rid   = md5($raport);
          $QryInserttopkb  = "INSERT INTO {{table}} SET ";
          $QryInserttopkb .= "`time` = UNIX_TIMESTAMP(), ";
          $QryInserttopkb .= "`id_owner1` = '". $FleetRow['fleet_owner'] ."', ";
          $QryInserttopkb .= "`angreifer` = '". $angreifer ."', ";
          $QryInserttopkb .= "`id_owner2` = '". $targetUser['id'] ."', ";
          $QryInserttopkb .= "`defender` = '". $targetUser['username'] ."', ";
          $QryInserttopkb .= "`gesamtunits` = '". $strunitsgesamt ."', ";
          $QryInserttopkb .= "`gesamttruemmer` = '". $strtruemmerfeld ."', ";
          $QryInserttopkb .= "`rid` = '". $rid ."', ";
          $QryInserttopkb .= "`a_zestrzelona` = '". $a_zestrzelona ."', ";
          $QryInserttopkb .= "`raport` = '". mysql_real_escape_string( $raport ) ."',";
          $QryInserttopkb .= "`fleetresult` = '". $result['won'] ."';";
          doquery("LOCK TABLE {{table}} WRITE", 'topkb');
          doquery( $QryInserttopkb , 'topkb');
          doquery("UNLOCK TABLES", '');
          $user1stat = $FleetRow['fleet_owner'];
          $user2stat = $TargetUserID;

	           $raport  = '<a href # OnClick=\'f( "rw.php?raport='. $rid .'", "");\' >';
	           $raport .= '<center>';
				if     ($result['won'] == "a")
				{
					$raport .= '<font color=\'green\'>';
				}
				elseif ($result['won'] == "w")
				{
					$raport .= '<font color=\'orange\'>';
				}
				elseif ($result['won'] == "r")
				{
					$raport .= '<font color=\'red\'>';
				}
				$raport .= $lang['sys_mess_destruc_report'] ." [". $FleetRow['fleet_end_galaxy'] .":". $FleetRow['fleet_end_system'] .":". $FleetRow['fleet_end_planet'] ."] </font></a><br /><br />";
				$raport .= "<font color=\"red\">". $lang['sys_perte_attaquant'] .": ". $result['lost']['att'] ."</font>";
				$raport .= "<font color=\"green\">   ". $lang['sys_perte_defenseur'] .": ". $result['lost']['def'] ."</font><br />" ;
				$raport .= $lang['sys_debris'] ." ". $lang['Metal'] .":<font color=\"#adaead\">". ($result['debree']['att'][0]+$result['debree']['def'][0] + $metallmond) ."</font>   ". $lang['Crystal'] .":<font color=\"#ef51ef\">".( $result['debree']['att'][1]+$result['debree']['def'][1] + $kristallmond ) ."</font>". $lang['Appolonium'] .":<font color=\"#40e0d0\">".( $result['debree']['att'][2]+$result['debree']['def'][2] + $appolonium) ."</font><br />";				
				SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_destruc_report'], $raport );

				$raport2  = "<a href # OnClick=\"f( 'rw.php?raport=". $rid ."', '');\" >";
				$raport2 .= "<center>";
				if	   ($result['won'] == "a")
				{
					$raport2 .= '<font color=\'red\'>';
				}
				elseif ($result['won'] == "w")
				{
					$raport2 .= '<font color=\'orange\'>';
				}
				elseif ($result['won'] == "r")
				{
					$raport2 .= '<font color=\'green\'>';
				}

				$raport2 .= $lang['sys_mess_destruc_report'] ." [". $FleetRow['fleet_end_galaxy'] .":". $FleetRow['fleet_end_system'] .":". $FleetRow['fleet_end_planet'] ."] </font></a><br /><br />";


                foreach ($users2 as $id) {
                if ($id != $FleetRow['fleet_owner'] && $id != 0) {
                SendSimpleMessage ( $id, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $raport2 );
             }
           }
       
$user1   = doquery("SELECT * FROM {{table}} WHERE `id` = '". $user1stat ."';", 'users');
while($user1data = mysql_fetch_assoc($user1))
{
$strtruemmermetaluser1       = $strtruemmermetal + $user1data['kbmetal'];
$strtruemmercrystaluser1     = $strtruemmercrystal + $user1data['kbcrystal'];
$strtruemmerappoloniumuser1  = $strtruemmerappolonium + $user1data['kbappolonium'];
$user1lostunits              = $user1lostunits + $user1data['lostunits'];
$user1shotunits              = $user1shotunits + $user1data['desunits'];
$user1wons                   = $user1data['wons'];
$user1loos                   = $user1data['loos'];
$user1draws                  = $user1data['draws'];
}
$user2   = doquery("SELECT * FROM {{table}} WHERE `id` = '". $user2stat ."';", 'users');
while($user2data = mysql_fetch_assoc($user2))
{
$strtruemmermetaluser2       = $strtruemmermetal + $user2data['kbmetal'];
$strtruemmercrystaluser2     = $strtruemmercrystal + $user2data['kbcrystal'];
$strtruemmerappoloniumuser2  = $strtruemmerappolonium + $user2data['kbappolonium'];
$user2lostunits              = $user2lostunits + $user2data['lostunits'];
$user2shotunits              = $user2shotunits + $user2data['desunits'];
$user2wons                   = $user2data['wons'];
$user2loos                   = $user2data['loos'];
$user2draws                  = $user2data['draws'];
}

if   ($result['won'] == "a") {
$user1wons  = $user1wons + 1;
$user2loos  = $user2loos + 1;
} elseif ($result['won'] == "w") {
$user1draws = $user1draws + 1;
$user2draws = $user2draws + 1;
} elseif ($result['won'] == "r") {
$user1loos = $user1loos + 1;
$user2wons = $user2wons + 1;
}
$QryUpdateuserstat  = "UPDATE {{table}} SET ";
$QryUpdateuserstat .= "`wons` = '". $user1wons ."', ";
$QryUpdateuserstat .= "`loos` = '". $user1loos ."', ";
$QryUpdateuserstat .= "`draws` = '". $user1draws  ."', ";
$QryUpdateuserstat .= "`kbmetal` = '". $strtruemmermetaluser1 ."', ";
$QryUpdateuserstat .= "`kbcrystal` = '". $strtruemmercrystaluser1 ."', ";
$QryUpdateuserstat .= "`kbappolonium` = '". $strtruemmerappoloniumuser1 ."', ";
$QryUpdateuserstat .= "`lostunits` = '". $user1lostunits ."', ";
$QryUpdateuserstat .= "`desunits` = '". $user1shotunits ."' ";
$QryUpdateuserstat .= "WHERE ";
$QryUpdateuserstat .= "`id` = '". $FleetRow['fleet_owner'] ."';";
doquery ( $QryUpdateuserstat , 'users');
$QryUpdateuser2stat  = "UPDATE {{table}} SET ";
$QryUpdateuser2stat .= "`wons` = '". $user2wons ."', ";
$QryUpdateuser2stat .= "`loos` = '". $user2loos ."', ";
$QryUpdateuser2stat .= "`draws` = '". $user2draws  ."', ";
$QryUpdateuser2stat .= "`kbmetal` = '". $strtruemmermetaluser2 ."', ";
$QryUpdateuser2stat .= "`kbcrystal` = '". $strtruemmercrystaluser2 ."', ";
$QryUpdateuser2stat .= "`kbappolonium` = '". $strtruemmerappoloniumuser2 ."', ";
$QryUpdateuser2stat .= "`lostunits` = '". $user2lostunits ."', ";
$QryUpdateuser2stat .= "`desunits` = '". $user2shotunits ."' ";
$QryUpdateuser2stat .= "WHERE ";
$QryUpdateuser2stat .= "`id` = '". $targetUser['id'] ."';";
doquery ( $QryUpdateuser2stat , 'users');

      $CurrentUser = doquery("SELECT * FROM {{table}} WHERE id = ". $FleetRow['fleet_owner'], 'users', true);
      $CurrentUserID    = $CurrentUser['id'];
      $AddPoint = $CurrentUser['xpraid'] + 1;

      $QryUpdateOfficier = "UPDATE {{table}} SET ";
      $QryUpdateOfficier .= "`xpraid` = '" . $AddPoint . "' ";
      $QryUpdateOfficier .= "WHERE id = '" . $CurrentUserID . "' ";
      $QryUpdateOfficier .= "LIMIT 1 ;";
      doquery($QryUpdateOfficier, 'users');

      $RaidsTotal = $CurrentUser['raids'] + 1;
    if ($result['won'] == "a") {
      $RaidsWin = $CurrentUser['raidswin'] + 1;
      $QryUpdateRaidsCompteur = "UPDATE {{table}} SET ";
      $QryUpdateRaidsCompteur .= "`raidswin` ='" . $RaidsWin . "', ";
      $QryUpdateRaidsCompteur .= "`raids` ='" . $RaidsTotal . "' ";
      $QryUpdateRaidsCompteur .= "WHERE id = '" . $CurrentUserID . "' ";
      $QryUpdateRaidsCompteur .= "LIMIT 1 ;";
      doquery($QryUpdateRaidsCompteur, 'users');
  } elseif ($result['won'] == "r" || $result['won'] == "w") {
      $RaidsLoose = $CurrentUser['raidsloose'] + 1;
      $QryUpdateRaidsCompteur = "UPDATE {{table}} SET ";
      $QryUpdateRaidsCompteur .= "`raidsloose` ='" . $RaidsLoose . "', ";
      $QryUpdateRaidsCompteur .= "`raids` ='" . $RaidsTotal . "' ";
      $QryUpdateRaidsCompteur .= "WHERE id = '" . $CurrentUserID . "' ";
      $QryUpdateRaidsCompteur .= "LIMIT 1 ;";
      doquery($QryUpdateRaidsCompteur, 'users');
      }


   } elseif ($FleetRow['fleet_end_time'] <= time()) {
     $Message         = sprintf( $lang['sys_tran_mess_angriffback'],
     $TargetName, GetTargetAdressLink($FleetRow, ''),
     pretty_number($FleetRow['fleet_resource_metal']), $lang['Metal'],
     pretty_number($FleetRow['fleet_resource_crystal']), $lang['Crystal'],
	 pretty_number($FleetRow['fleet_resource_deuterium']), $lang['Deuterium'],
     pretty_number($FleetRow['fleet_resource_appolonium']), $lang['Appolonium'] );
     SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
     RestoreFleetToPlanet($FleetRow);
     doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.$FleetRow['fleet_id'],'fleets');
     } 
     }
    function formatCRM (&$result_array,&$steal_array,&$moon_int,&$moon_string,&$time_float,&$destext) {
        global $phpEx, $xnova_root_path, $pricelist, $lang, $resource, $CombatCaps, $game_config;

        includeLang('fleet');
        includeLang('tech');


        $html = "";
        $bbc = "";

        $html .= $lang['title_mrc']."".date("D j M Y H:i:s", time()).".<br /><br />";	
      


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
                $weap = ($data2['user']['military_tech'] *10) + ($data2['user']['rpg_amiral'] * 5);
                $shie = ($data2['user']['shield_tech'] * 10) + ($data2['user']['rpg_amiral'] * 5);
                $armr = ($data2['user']['defence_tech'] * 10) + ($data2['user']['rpg_amiral'] * 5);


               if($round_no == 1) {
               if(!$angreifer) {
                 $angreifer = $name;
                 $ang = $name;
                 $angnr++;
                 } else {
                $angreifer = $angreifer." & ".$name;
                $angnr++;
                 } }

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
                        $shields1 .= "<th>".number_format($ship_points1['shield'])."</th>";
                        $armour1 .= "<th>".number_format($ship_points1['def'])."</th>";
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
                $weap = ($data2['user']['military_tech'] * 10) + ($data2['user']['rpg_amiral'] * 5);
                $shie = ($data2['user']['shield_tech'] * 10) + ($data2['user']['rpg_amiral'] * 5);
                $armr = ($data2['user']['defence_tech'] * 10) + ($data2['user']['rpg_amiral'] * 5);

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
                        $shields1 .= "<th>".number_format($ship_points1['shield'])."</th>";
                        $armour1 .= "<th>".number_format($ship_points1['def'])."</th>";
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
			$result1 .= $lang['resource_take']." ".pretty_number($steal_array['metal'])." ".$lang['Metal'].", ".pretty_number($steal_array['crystal'])." ".$lang['Crystal'].", ".pretty_number($steal_array['deuterium'])." ".$lang['Deuterium']." ".$lang['and']." ".pretty_number($steal_array['appolonium'])." ".$lang['Appolonium']."<br />";
        //Et pourquoi pas un match nul ?
         }elseif ($result_array['won'] == "w"){
            $won = array('attackers' => $attackers, 'defenders' => $defenders, 'attack' => $attackDamage, 'defense' => $defenseDamage, 'attackA' => $attackAmount, 'defenseA' => $defenseAmount);
            $result1  = $lang['draw'].".<br />";
        }

        // Fin du RC
        $html .= "<br /><br />";
        $html .= $result1;
        $html .= "<br />";

        $debirs_meta = ($result_array['debree']['att'][0] + $result_array['debree']['def'][0]);
        $debirs_crys = ($result_array['debree']['att'][1] + $result_array['debree']['def'][1]);
		$debirs_appo = ($result_array['debree']['att'][2] + $result_array['debree']['def'][2]);
        $html .= $lang['attack_loose_units']." ".pretty_number($result_array['lost']['att'])." ".$lang['units']."<br />";
        $html .= $lang['defs_loose_units']." ".pretty_number($result_array['lost']['def'])." ".$lang['units']."<br />";
        $html .= $lang['debree_field_1']." ".pretty_number($debirs_meta)." ".$lang['debree_field_2']." ".pretty_number($debirs_crys)." ".$lang['debree_field_3']."".pretty_number($debirs_appo)." ".$lang['debree_field_4']."<br /><br />";
        $html .= $lang['moon_chance']." ".$moon_int." ".$lang['percent_moon']."<br />";
        $html .= $moon_string."<br />";
		$html .= $destext."<br />";
        $html .= $lang['calculate_rc']." ".$time_float." ".$lang['seconds']."<br />";

        //return array('html' => $html, 'bbc' => $bbc, 'extra' => $extra);
    return array('html' => $html, 'bbc' => $bbc, 'angreifer' => $angreifer);
      }
?>
