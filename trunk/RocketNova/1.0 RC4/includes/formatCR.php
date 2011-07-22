<?php

/**
 * formartcr.php
 *
 * @version 1.0
 * @copyright 2009 by Dr.Isaacs für XNova-Germany
 * http://www.xnova-germany.org
 */
	
	
	function formatCR (&$result_array,&$steal_array,&$moon_int,&$moon_string,&$time_float) {
		$html = "";
		$bbc = "";
		
		//And lets start the CR. And admin message like asking them to give the cr. Nope, well moving on give the time and date ect.
		//$html .= "<font color=\"red\">HI THIS IS AN ADMIN MESSAGE. WE WOULD BE REALLY GREATFUL FOR YOU TO POST THE REPORT ID ON THE SHOUTBOX. THANKS</font><br /><br />";
		$html .= "Folgende Schiffe standen sich heute gegen&uuml;ber ".date("d-m-Y H:i:s")." , und es kam zu einem Kampf::<br /><br />";
		
		
		//For-each round (Up to 10 rounds (depending on the ammount specified in calcualteAttack.php
		$round_no = 1;
		foreach( $result_array['rw'] as $round => $data1){
			//Round number is $round + 1 as $round starts at 0, not 1.
	
			$html .= "Runde ".$round_no.":<br /><br />";
			
			//Now whats that attackers and defenders data
			$attackers1 = $data1['attackers'];
			$attackers2 = $data1['infoA'];
			$defenders1 = $data1['defenders'];
			$defenders2 = $data1['infoD'];
			$coord4 = 0;
			$coord5 = 0;
			$coord6 = 0;
			
			foreach( $attackers1 as $fleet_id1 => $data2){ //25
				//Player Info
				$name = $data2['user']['username'];
				$coord1 = $data2['fleet']['fleet_start_galaxy'];
				$coord2 = $data2['fleet']['fleet_start_system'];
				$coord3 = $data2['fleet']['fleet_start_planet'];
				$weap = ($data2['user']['military_tech'] * 10);
				$shie = ($data2['user']['shield_tech'] * 10);
				$armr = ($data2['user']['defence_tech'] * 10);
				
				if($coord4 == 0){$coord4 += $data2['fleet']['fleet_end_galaxy'];}
				if($coord5 == 0){$coord5 += $data2['fleet']['fleet_end_system'];}
				if($coord6 == 0){$coord6 += $data2['fleet']['fleet_end_planet'];}
				
				//And html output player info
				$fl_info1  = "<table><tr><th>";
				$fl_info1 .= "Angreifer ".$name." ([".$coord1.":".$coord2.":".$coord3."])<br />";
				$fl_info1 .= "Waffen: ".$weap."% Tarnung: ".$shie."% Panzerung: ".$armr."%";
				
				//Start the table (Part 1)
				$table1  = "<table border=1 align=\"center\">";
				//Start the table rows.
				$ships1  = "<tr><th>Schiffsart</th>";
				$count1  = "<tr><th>Anzahl</th>";
				
				//And now the data columns "foreach" ship
				foreach( $data2['detail'] as $ship_id1 => $ship_count1){
					if ($ship_count1 > 0){
						$ships1 .= "<th>[ship[".$ship_id1."]]</th>";
						$count1 .= "<th>".$ship_count1."</th>";
					}
				}
				
				//End the table Rows
				$ships1 .= "</tr>";
				$count1 .= "</tr>";
				
				//now compile what we have, ok its the first half but the rest comes later.
				$info_part1[$fleet_id1] = $fl_info1.$table1.$ships1.$count1;
			}
			
			foreach( $attackers2 as $fleet_id2 => $data3){
				//Start the table rows.
				$weap1  = "<tr><th>Waffen</th>";
				$shields1  = "<tr><th>Tarnung</th>";
				$armour1  = "<tr><th>Panzerung</th>";
				
				//And now the data columns "foreach" ship
				foreach( $data3 as $ship_id2 => $ship_points1){
					if ($ship_points1['def'] > 0){
						$weap1 .= "<th>".$ship_points1['att']."</th>";
						$shields1 .= "<th>".$ship_points1['shield']."</th>";
						$armour1 .= "<th>".$ship_points1['def']."</th>";
					}
				}
				
				//End the table Rows
				$weap1 .= "</tr>";
				$shields1 .= "</tr>";
				$armour1 .= "</tr>";
				$endtable1 .= "</table></th></tr></table>";
				
				//now compile what we have, this is the second half.
				$info_part2[$fleet_id2] = $weap1.$shields1.$armour1.$endtable1;
				
				//ok, good good, now we have both parts, lets make the html bit.
				$html .= $info_part1[$fleet_id2].$info_part2[$fleet_id2];
				$html .= "<br /><br />";
			}	
			
			
			foreach( $defenders1 as $fleet_id1 => $data2){
				//Player Info
				$name = $data2['user']['username'];
				$weap = ($data2['user']['military_tech'] * 10);
				$shie = ($data2['user']['shield_tech'] * 10);
				$armr = ($data2['user']['defence_tech'] * 10);
				
				//And html output player info
				$fl_info1  = "<table><tr><th>";
				$fl_info1 .= "Verteidiger ".$name." ([".$coord4.":".$coord5.":".$coord6."])<br />";
				$fl_info1 .= "Waffen: ".$weap."% Tarnung: ".$shie."% Panzerung: ".$armr."%";
				
				//Start the table (Part 1)
				$table1  = "<table border=1 align=\"center\">";
				//Start the table rows.
				$ships1  = "<tr><th>Schiffsart</th>";
				$count1  = "<tr><th>Anzahl</th>";
				
				//And now the data columns "foreach" ship
				foreach( $data2['def'] as $ship_id1 => $ship_count1){
					if ($ship_count1 > 1){
						$ships1 .= "<th>[ship[".$ship_id1."]]</th>";
						$count1 .= "<th>".$ship_count1."</th>";
					}
				}
				
				//End the table Rows
				$ships1 .= "</tr>";
				$count1 .= "</tr>";
				
				//now compile what we have, ok its the first half but the rest comes later.
				$info_part1[$fleet_id1] = $fl_info1.$table1.$ships1.$count1;
			}
			
			foreach( $defenders2 as $fleet_id2 => $data3){
				//Start the table rows.
				$weap1  = "<tr><th>Waffen</th>";
				$shields1  = "<tr><th>Tarnung</th>";
				$armour1  = "<tr><th>Panzerung</th>";
				
				//And now the data columns "foreach" ship
				foreach( $data3 as $ship_id2 => $ship_points1){
					if ($ship_points1['def'] > 0){
						$weap1 .= "<th>".$ship_points1['att']."</th>";
						$shields1 .= "<th>".$ship_points1['shield']."</th>";
						$armour1 .= "<th>".$ship_points1['def']."</th>";
					}
				}
				
				//End the table Rows
				$weap1 .= "</tr>";
				$shields1 .= "</tr>";
				$armour1 .= "</tr>";
				$endtable1 .= "</table></th></tr></table>";
				
				//now compile what we have, this is the second half.
				$info_part2[$fleet_id2] = $weap1.$shields1.$armour1.$endtable1;
				
				//ok, good good, now we have both parts, lets make the html bit.
				$html .= $info_part1[$fleet_id2].$info_part2[$fleet_id2];
				$html .= "<br /><br />";
			}		

			//HTML What happens?
			$html .= "Die Angreifende Flotte schiesst insgesamt ".$data1['attack']['total']." auf den Verteidiger. Die Panzerung des Verteidigers absorbiert".$data1['defShield']." Treffer.<br />";
			$html .= "Die verteidigende Flotte schiesst insgesamt ".$data1['defense']['total']." auf die Angreifende Flotte.Die panzerung des Angreifers absorbiert ".$data1['attackShield']." Treffer.<br /><br />";
			$round_no++;
		}
		
		//ok, end of rounds, battle results now.
		
		//Who won?
		if ($result_array['won'] == 2){
			//Defender wins
			$result1  = "Der Verteidiger gewinnt diesen Kampf!<br />";
		}elseif ($result_array['won'] == 1){
			//Attacker wins
			$result1  = "Der Angreifer hat den Kampf gewonnen!<br />";
			$result1 .= "Er erbeutet ".$steal_array['metal']." Stahl, ".$steal_array['crystal']." Kupfer und ".$steal_array['deuterium']." &Öuml;l<br />";
		}else{
			//Battle was a draw
			$result1  = "Der Kampf endet in einem Unentschieden.<br />";
		}
		

		
		$html .= "<br /><br />";
		$html .= $result1;
		$html .= "<br />";
		
		$debirs_meta = ($result_array['debree']['att'][0] + $result_array['debree']['def'][0]);
		$debirs_crys = ($result_array['debree']['att'][1] + $result_array['debree']['def'][1]);
		$html .= "Der Angreifer verliert ".$result_array['lost']['att']." Einheiten.<br />";
		$html .= "Der Verteidiger verliert".$result_array['lost']['def']." Einheiten.<br />";
		$html .= "Auf diesen Koordinaten liegen nun ".$debirs_meta." Stahl und ".$debirs_crys." Kupfer.<br /><br />";
		
		$html .= "Die Chance das der verteidiger aus den resten eine Plattform bauen kann, liegen bei ".$moon_int."%<br />";
		$html .= $moon_string."<br /><br />";

		$html .= "Kampfbericht erstellt in ".$time_float." Sekunden<br />";
		
		//return array('html' => $html, 'bbc' => $bbc, 'extra' => $extra);
		return array('html' => $html, 'bbc' => $bbc);
	}
?>
