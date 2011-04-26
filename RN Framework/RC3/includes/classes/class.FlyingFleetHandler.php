<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

if (!defined('INSIDE'))die(header("location:../../"));

class FlyingFleetHandler
{
	private function SpyTarget ($TargetPlanet, $Mode, $TitleString)
	{
		global $lang, $resource;

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
					if ( $TargetPlanet[$resource[$Item]]> 0)
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

	private function RestoreFleetToPlanet ($FleetRow, $Start = true)
	{
		global $resource;

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
		doquery( $QryUpdatePlanet, 'planets');
	}

	private function StoreGoodsToPlanet ($FleetRow, $Start = false)
	{
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
		doquery( $QryUpdatePlanet, 'planets');
	}

	private function raketenangriff($verteidiger_panzerung, $angreifer_waffen, $iraks, $def, $primaerziel = '0')
	{
		$temp = '';
		$temp2 = '';

		$def[10] = $iraks;

		$metall     = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$kristall   = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$deut       = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$verblieben = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);

		for($temp = 0; $temp < 11; $temp++)
			$verblieben[$temp] = $def[$temp];

		$kaputt  = Array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
		$hull 	 = Array();
		$hull[0] = 200 * (1 + $verteidiger_panzerung / 10);
		$hull[1] = $hull[0];
		$hull[2] = 800 * (1 + ($verteidiger_panzerung / 10));
		$hull[3] = 3500 * (1 + ($verteidiger_panzerung / 10));
		$hull[4] = $hull[2];
		$hull[5] = 10000 * (1 + ($verteidiger_panzerung / 10));
		$hull[6] = 2000 * (1 + ($verteidiger_panzerung / 10));
		$hull[7] = $hull[5];
		$hull[8] = 1500 * (1 + ($verteidiger_panzerung / 10));

		$metall_cost_tab   = Array( 2, 1.5, 6, 20, 2, 50, 10, 50, 12.5, 8);
		$kristall_cost_tab = Array( 0, 0.5, 2, 15, 6, 50, 10, 50,  2.5, 0);
		$deut_cost_tab     = Array( 0,   0, 0,  2, 0, 30,  0,  0, 10.0, 2);

		$schaden = floor(($def[10] - $def[9]) * (12000 * (1 + ($angreifer_waffen / 10))));
		if ($schaden < 0)
			$schaden = 0;

		switch ($primaerziel)
		{
			case 0:
				$beschussreihenfolge = Array(0, 1, 2, 3, 4, 5, 6, 7, 8);
			break;
			case 1:
				$beschussreihenfolge = Array(1, 0, 2, 3, 4, 5, 6, 7, 8);
			break;
			case 2:
				$beschussreihenfolge = Array(2, 0, 1, 3, 4, 5, 6, 7, 8);
			break;
			case 3:
				$beschussreihenfolge = Array(3, 0, 1, 2, 4, 5, 6, 7, 8);
			break;
			case 4:
				$beschussreihenfolge = Array(4, 0, 1, 2, 3, 5, 6, 7, 8);
			break;
			case 5:
				$beschussreihenfolge = Array(5, 0, 1, 2, 3, 4, 6, 7, 8);
			break;
			case 6:
				$beschussreihenfolge = Array(6, 0, 1, 2, 3, 4, 5, 7, 8);
			break;
			case 7:
				$beschussreihenfolge = Array(7, 0, 1, 2, 3, 4, 5, 6, 8);
			break;
			case 8:
				$beschussreihenfolge = Array(0, 1, 2, 3, 4, 5, 6, 7, 8);
			break;
		}

		$verblieben[10] 	= 0;
		$kaputt[10] 	   += $def[10];
		$metall[10] 	   += $kaputt[10] * $metall_cost_tab[8];
		$kristall[10]      += $kaputt[10] * $kristall_cost_tab[8];
		$deut[10]          += $kaputt[10] * $deut_cost_tab[8];
		$verblieben[9]      = ($def[9] - $def[10]);

		if ($verblieben[9] < 0)
			$verblieben[9] = 0;

		$kaputt[11]    = $def[9] - $verblieben[9];
		$kaputt[9]    += ($def[9] - $verblieben[9]);
		$metall[9]    += $kaputt[9] * $metall_cost_tab[9];
		$kristall[9]  += $kaputt[9] * $kristall_cost_tab[9];
		$deut[9] 	  += $kaputt[9] * $deut_cost_tab[9];
		$metall[11]   += $metall[9];
		$kristall[11] += $kristall[9];
		$deut[11]     += $deut[9];

		for($temp = 0; $temp < 9; $temp++)
		{
			if ($schaden>= ($hull[$beschussreihenfolge[$temp]] * $def[$beschussreihenfolge[$temp]]))
			{
				$kaputt[$beschussreihenfolge[$temp]] += $def[$beschussreihenfolge[$temp]];
				$verblieben[$beschussreihenfolge[$temp]] = 0;
				$schaden -= ($hull[$beschussreihenfolge[$temp]] * $kaputt[$beschussreihenfolge[$temp]]);
			}
			else
			{
				$kaputt[$beschussreihenfolge[$temp]] += floor($schaden / $hull[$beschussreihenfolge[$temp]]);
				$schaden -= $kaputt[$beschussreihenfolge[$temp]] * $hull[$beschussreihenfolge[$temp]];
				$verblieben[$beschussreihenfolge[$temp]] = ($def[$beschussreihenfolge[$temp]] - $kaputt[$beschussreihenfolge[$temp]]);
			}

			$metall[$beschussreihenfolge[$temp]] += $kaputt[$beschussreihenfolge[$temp]] * $metall_cost_tab[$beschussreihenfolge[$temp]];
			$kristall[$beschussreihenfolge[$temp]] += $kaputt[$beschussreihenfolge[$temp]] * $kristall_cost_tab[$beschussreihenfolge[$temp]];
			$deut[$beschussreihenfolge[$temp]] += $kaputt[$beschussreihenfolge[$temp]] * $deut_cost_tab[$beschussreihenfolge[$temp]];

			$verblieben[11] += $verblieben[$beschussreihenfolge[$temp]];
			$kaputt[11] += $kaputt[$beschussreihenfolge[$temp]];
			$metall[11] += $metall[$beschussreihenfolge[$temp]];
			$kristall[11] += $kristall[$beschussreihenfolge[$temp]];
			$deut[11] += $deut[$beschussreihenfolge[$temp]];
		}

		$return = array();

		$return['verbleibt'] = $verblieben;
		$return['zerstoert'] = $kaputt;
		$return['verluste_metall'] = $metall;
		$return['verluste_kristall'] = $kristall;
		$return['verluste_deuterium'] = $deut;

		return $return;
	}

	private function MissionCaseAttack ($FleetRow)
	{
		global $pricelist, $lang, $resource, $CombatCaps, $game_config, $user;

		if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_start_time'] <= time())
		{
			$targetPlanet = doquery("SELECT * FROM {{table}} WHERE `galaxy` = ". $FleetRow['fleet_end_galaxy'] ." AND `system` = ". $FleetRow['fleet_end_system'] ." AND `planet_type` = ". $FleetRow['fleet_end_type'] ." AND `planet` = ". $FleetRow['fleet_end_planet'] .";",'planets', true);

			if ($FleetRow['fleet_group']> 0)
			{
				doquery("DELETE FROM {{table}} WHERE id =".$FleetRow['fleet_group'],'aks');
				doquery("UPDATE {{table}} SET fleet_mess=1 WHERE fleet_group=".$FleetRow['fleet_group'],'fleets');
			}
			else
			{
				doquery("UPDATE {{table}} SET fleet_mess=1 WHERE fleet_id=".$FleetRow['fleet_id'],'fleets');
			}

			$targetGalaxy = doquery('SELECT * FROM {{table}} WHERE `galaxy` = '. $FleetRow['fleet_end_galaxy'] .' AND `system` = '. $FleetRow['fleet_end_system'] .' AND `planet` = '. $FleetRow['fleet_end_planet'] .';','galaxy', true);
			$targetUser   = doquery('SELECT * FROM {{table}} WHERE id='.$targetPlanet['id_owner'],'users', true);
			$TargetUserID = $targetUser['id'];
			$attackFleets = array();

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
			while ($defRow = mysql_fetch_assoc($def))
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

			$QryUpdateGalaxy = "UPDATE {{table}} SET ";
			$QryUpdateGalaxy .= "`metal` = `metal` +'".($result['debree']['att'][0]+$result['debree']['def'][0]) . "', ";
			$QryUpdateGalaxy .= "`crystal` = `crystal` + '" .($result['debree']['att'][1]+$result['debree']['def'][1]). "' ";
			$QryUpdateGalaxy .= "WHERE ";
			$QryUpdateGalaxy .= "`galaxy` = '" . $FleetRow['fleet_end_galaxy'] . "' AND ";
			$QryUpdateGalaxy .= "`system` = '" . $FleetRow['fleet_end_system'] . "' AND ";
			$QryUpdateGalaxy .= "`planet` = '" . $FleetRow['fleet_end_planet'] . "' ";
			$QryUpdateGalaxy .= "LIMIT 1;";
			doquery($QryUpdateGalaxy , 'galaxy');

			$totalDebree = $result['debree']['def'][0] + $result['debree']['def'][1] + $result['debree']['att'][0] + $result['debree']['att'][1];
			// mod TOP KB
			$strunitsgesamt      = $result['lost']['att'] + $result['lost']['def'];
			$user1lostunits      = $result['lost']['att'];
			$user1shotunits      = $result['lost']['def'];
			$user2lostunits      = $result['lost']['def'];
			$user2shotunits      = $result['lost']['att'];
			$strtruemmerfeld     = $result['debree']['att'][0] + $result['debree']['def'][0] + $result['debree']['att'][1] + $result['debree']['def'][1];
			$strtruemmermetal    = $result['debree']['att'][0] + $result['debree']['def'][0];
			$strtruemmercrystal  = $result['debree']['att'][1] + $result['debree']['def'][1];
            // mod TOP KB

			$steal = array('metal' => 0, 'crystal' => 0, 'deuterium' => 0);

			if ($result['won'] == "a")
			{
				$max_resources = 0;

				foreach ($attackFleets[$FleetRow['fleet_id']]['detail'] as $Element => $amount)
				{
					$max_resources += $pricelist[$Element]['capacity'] * $amount;
				}

				if ($max_resources> 0)
				{
					$metal   = $targetPlanet['metal'] / 2;
					$crystal = $targetPlanet['crystal'] / 2;
					$deuter  = $targetPlanet['deuterium'] / 2;

					if ($deuter> $max_resources / 3)
					{
						$steal['deuterium']     = $max_resources / 3;
						$max_resources        -= $steal['deuterium'];
					}
					else
					{
						$steal['deuterium']     = $deuter;
						$max_resources        -= $steal['deuterium'];
					}

					if ($crystal> $max_resources / 2)
					{
						$steal['crystal'] = $max_resources / 2;
						$max_resources   -= $steal['crystal'];
					}
					else
					{
						$steal['crystal'] = $crystal;
						$max_resources   -= $steal['crystal'];
					}

					if ($metal> $max_resources)
					{
						$steal['metal']         = $max_resources;
						$max_resources         = $max_resources - $steal['metal'];
					}
					else
					{
						$steal['metal']         = $metal;
						$max_resources        -= $steal['metal'];
					}
				}

				$steal = array_map('round', $steal);

				$QryUpdateFleet  = 'UPDATE {{table}} SET ';
				$QryUpdateFleet .= '`fleet_resource_metal` = `fleet_resource_metal` + '. $steal['metal'] .', ';
				$QryUpdateFleet .= '`fleet_resource_crystal` = `fleet_resource_crystal` +'. $steal['crystal'] .', ';
				$QryUpdateFleet .= '`fleet_resource_deuterium` = `fleet_resource_deuterium` +'. $steal['deuterium'] .' ';
				$QryUpdateFleet .= 'WHERE fleet_id = '. $FleetRow['fleet_id'] .' ';
				$QryUpdateFleet .= 'LIMIT 1 ;';
				doquery( $QryUpdateFleet,'fleets');
			}

			foreach ($attackFleets as $fleetID => $attacker)
			{
				$fleetArray = '';
				$totalCount = 0;
				foreach ($attacker['detail'] as $element => $amount)
				{
					if ($amount)
						$fleetArray .= $element.','.$amount.';';

					$totalCount += $amount;
				}

				if ($totalCount <= 0)
				{
					doquery('DELETE FROM {{table}} WHERE `fleet_id`='.$fleetID,'fleets');
				}
				else
				{
					doquery('UPDATE {{table}} SET fleet_array="'.substr($fleetArray, 0, -1).'", fleet_amount='.$totalCount.', fleet_mess=1 WHERE fleet_id='.$fleetID,'fleets');
				}
			}

			foreach ($defense as $fleetID => $defender)
			{
				if ($fleetID != 0)
				{
					$fleetArray = '';
					$totalCount = 0;

					foreach ($defender['def'] as $element => $amount)
					{
						if ($amount) $fleetArray .= $element.','.$amount.';';
							$totalCount += $amount;
					}

					if ($totalCount <= 0)
					{
						doquery('DELETE FROM {{table}} WHERE `fleet_id`='.$fleetID,'fleets');

					}
					else
					{
						doquery('UPDATE {{table}} SET fleet_array="'.$fleetArray.'", fleet_amount='.$totalCount.', fleet_mess=1 WHERE fleet_id='.$fleetID,'fleets');
					}

				}
				else
				{
					$fleetArray = '';
					$totalCount = 0;

					foreach ($defender['def'] as $element => $amount)
					{
						$fleetArray .= '`'.$resource[$element].'`='.$amount.', ';
					}

					$QryUpdateTarget  = "UPDATE {{table}} SET ";
					$QryUpdateTarget .= $fleetArray;
					$QryUpdateTarget .= "`metal` = `metal` - '". $steal['metal'] ."', ";
					$QryUpdateTarget .= "`crystal` = `crystal` - '". $steal['crystal'] ."', ";
					$QryUpdateTarget .= "`deuterium` = `deuterium` - '". $steal['deuterium'] ."' ";
					$QryUpdateTarget .= "WHERE ";
					$QryUpdateTarget .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
					$QryUpdateTarget .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
					$QryUpdateTarget .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
					$QryUpdateTarget .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."' ";
					$QryUpdateTarget .= "LIMIT 1;";
					doquery( $QryUpdateTarget , 'planets');
				}
			}

			$FleetDebris      = $result['debree']['att'][0] + $result['debree']['def'][0] + $result['debree']['att'][1] + $result['debree']['def'][1];
			$StrAttackerUnits = sprintf ($lang['sys_attacker_lostunits'], $result['lost']['att']);
			$StrDefenderUnits = sprintf ($lang['sys_defender_lostunits'], $result['lost']['def']);
			$StrRuins         = sprintf ($lang['sys_gcdrunits'], $result['debree']['def'][0] + $result['debree']['att'][0], $lang['Metal'], $result['debree']['def'][1] + $result['debree']['att'][1], $lang['Crystal']);
			$DebrisField      = $StrAttackerUnits ."<br>". $StrDefenderUnits ."<br>". $StrRuins;
			$MoonChance       = $FleetDebris / 100000;

			if($FleetDebris> 2000000)
			{
				$MoonChance = 20;
				$UserChance = mt_rand(1, 100);
				$ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);
			}
			elseif($FleetDebris < 100000)
			{
				$UserChance = 0;
				$ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);
			}
			elseif($FleetDebris>= 100000)
			{
				$UserChance = mt_rand(1, 100);
				$ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);
			}

			if (($UserChance> 0) && ($UserChance <= $MoonChance) && ($targetGalaxy['id_luna'] == 0))
			{
				$TargetPlanetName = CreateOneMoonRecord ( $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'], $TargetUserID, $FleetRow['fleet_start_time'], '', $MoonChance );
				$GottenMoon       = sprintf ($lang['sys_moonbuilt'], $TargetPlanetName, $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
				$GottenMoon .= "<br>";
			}
			elseif ($UserChance = 0 or $UserChance> $MoonChance)
			{
				$GottenMoon = "";
			}

			$formatted_cr 	= formatCR($result,$steal,$MoonChance,$GottenMoon,$totaltime);
			$raport 		= $formatted_cr['html'];


			$rid   = md5($raport);
			$QryInsertRapport  = 'INSERT INTO {{table}} SET ';
			$QryInsertRapport .= '`time` = UNIX_TIMESTAMP(), ';
			foreach ($attackFleets as $fleetID => $attacker)
			{
				$users2[$attacker['user']['id']] = $attacker['user']['id'];
			}

			foreach ($defense as $fleetID => $defender)
			{
				$users2[$defender['user']['id']] = $defender['user']['id'];
			}
			// mod TOP KB
			$angreifer     = $attackFleets;
			$defender      = $defense;
			$QryInsertRapport .= '`owners` = "'.implode(',', $users2).'", ';
			$QryInsertRapport .= '`rid` = "'. $rid .'", ';
			$QryInsertRapport .= '`raport` = "'. mysql_real_escape_string( $raport ) .'"';
			doquery($QryInsertRapport,'rw') or die("Error inserting CR to database".mysql_error()."<br><br>Trying to execute:".mysql_query());
			$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
			$rid   = md5($raport);
			$QryInserttopkb  = "INSERT INTO {{table}} SET ";
			$QryInserttopkb .= "`time` = UNIX_TIMESTAMP(), ";
			$QryInserttopkb .= "`id_owner1` = '". $FleetRow['fleet_owner'] ."', ";
			$QryInserttopkb .= "`angreifer` = '". $attacker['user']['username'] ."', ";
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

			$raport  = '<a href="#" OnClick=\'f( "CombatReport.php?raport='. $rid .'", "");\'>';
			$raport .= '<center>';

			if       ($result['won'] == "a")
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

			$raport .= $lang['sys_mess_attack_report'] .' ['. $FleetRow['fleet_end_galaxy'] .':'. $FleetRow['fleet_end_system'] .':'. $FleetRow['fleet_end_planet'] .'] </font></a><br><br>';
			$raport .= '<font color=\'red\'>'. $lang['sys_perte_attaquant'] .': '. number_format($result['lost']['att'], 0, ',', '.') .'</font>';
			$raport .= '<font color=\'green\'>   '. $lang['sys_perte_defenseur'] .': '. number_format($result['lost']['def'], 0, ',', '.') .'</font><br>' ;
			$raport .= $lang['sys_gain'] .' '. $lang['Metal'] .':<font color=\'#adaead\'>'. number_format($steal['metal'], 0, ',', '.') .'</font>   '. $lang['Crystal'] .':<font color=\'#ef51ef\'>'. number_format($steal['crystal'], 0, ',', '.') .'</font>   '. $lang['Deuterium'] .':<font color=\'#f77542\'>'. number_format($steal['deuterium'], 0, ',', '.') .'</font><br>';
			$raport .= $lang['sys_debris'] .' '. $lang['Metal'] .': <font color=\'#adaead\'>'. number_format($result['debree']['att'][0]+$result['debree']['def'][0], 0, ',', '.') .'</font>   '. $lang['Crystal'] .': <font color=\'#ef51ef\'>'. number_format($result['debree']['att'][1]+$result['debree']['def'][1], 0, ',', '.') .'</font><br></center>';

			SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $raport );
// Updaten Spieler Datenbank
      $user1   = doquery("SELECT * FROM {{table}} WHERE `id` = '". $user1stat ."';", 'users');
      while($user1data = mysql_fetch_assoc($user1))
       {
             $strtruemmermetaluser1    = $strtruemmermetal + $user1data['kbmetal'];
             $strtruemmercrystaluser1  = $strtruemmercrystal + $user1data['kbcrystal'];
             $user1lostunits           = $user1lostunits + $user1data['lostunits'];
             $user1shotunits           = $user1shotunits + $user1data['desunits'];
             $user1wons                = $user1data['wons'];
             $user1loos                = $user1data['loos'];
             $user1draws               = $user1data['draws'];
             }
      $user2   = doquery("SELECT * FROM {{table}} WHERE `id` = '". $user2stat ."';", 'users');
      while($user2data = mysql_fetch_assoc($user2))
       {
             $strtruemmermetaluser2    = $strtruemmermetal + $user2data['kbmetal'];
             $strtruemmercrystaluser2  = $strtruemmercrystal + $user2data['kbcrystal'];
             $user2lostunits           = $user2lostunits + $user2data['lostunits'];
             $user2shotunits           = $user2shotunits + $user2data['desunits'];
             $user2wons                = $user2data['wons'];
             $user2loos                = $user2data['loos'];
             $user2draws               = $user2data['draws'];
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

//Update Angreifer Truemerfeld, Kampfergebniss und Units
   $userstat   = doquery("SELECT * FROM {{table}} WHERE `id` = '". $user1stat ."';", 'users');
   while($userwrite = mysql_fetch_assoc($userstat))
{
                    $QryUpdateuserstat  = "UPDATE {{table}} SET ";
                    $QryUpdateuserstat .= "`wons` = '". $user1wons ."', ";
                    $QryUpdateuserstat .= "`loos` = '". $user1loos ."', ";
                    $QryUpdateuserstat .= "`draws` = '". $user1draws  ."', ";
                    $QryUpdateuserstat .= "`kbmetal` = '". $strtruemmermetaluser1 ."', ";
                    $QryUpdateuserstat .= "`kbcrystal` = '". $strtruemmercrystaluser1 ."', ";
                    $QryUpdateuserstat .= "`lostunits` = '". $user1lostunits ."', ";
                    $QryUpdateuserstat .= "`desunits` = '". $user1shotunits ."' ";
                    $QryUpdateuserstat .= "WHERE ";
                    $QryUpdateuserstat .= "`id` = '". $user1stat ."';";
                    doquery ( $QryUpdateuserstat , 'users');
			//Update Verteidiger Truemerfeld, Kampfergebniss und Units
                    $QryUpdateuserstat  = "UPDATE {{table}} SET ";
                    $QryUpdateuserstat .= "`wons` = '". $user2wons ."', ";
                    $QryUpdateuserstat .= "`loos` = '". $user2loos ."', ";
                    $QryUpdateuserstat .= "`draws` = '". $user2draws  ."', ";
                    $QryUpdateuserstat .= "`kbmetal` = '". $strtruemmermetaluser2 ."', ";
                    $QryUpdateuserstat .= "`kbcrystal` = '". $strtruemmercrystaluser2 ."', ";
                    $QryUpdateuserstat .= "`lostunits` = '". $user2lostunits ."', ";
                    $QryUpdateuserstat .= "`desunits` = '". $user2shotunits ."' ";
                    $QryUpdateuserstat .= "WHERE ";
                    $QryUpdateuserstat .= "`id` = '". $user2stat ."';";
                    doquery ( $QryUpdateuserstat , 'users');
			}
			// Ende schreiben in datenbank
			$raport2  = '<a href # OnClick=\'f( "CombatReport.php?raport='. $rid .'", "");\'>';
			$raport2 .= '<center>';
			if       ($result['won'] == "a")
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

			$raport2 .= $lang['sys_mess_attack_report'] .' ['. $FleetRow['fleet_end_galaxy'] .':'. $FleetRow['fleet_end_system'] .':'. $FleetRow['fleet_end_planet'] .'] </font></a><br><br>';

			foreach ($users2 as $id)
			{
				if ($id != $FleetRow['fleet_owner'] && $id != 0)
				{
					SendSimpleMessage ( $id, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $raport2 );
				}
			}
		}
		elseif ($FleetRow['fleet_end_time'] <= time())
		{
			$Message         = sprintf( $lang['sys_fleet_won'],
						$TargetName, GetTargetAdressLink($FleetRow, ''),
						pretty_number($FleetRow['fleet_resource_metal']), $lang['Metal'],
						pretty_number($FleetRow['fleet_resource_crystal']), $lang['Crystal'],
						pretty_number($FleetRow['fleet_resource_deuterium']), $lang['Deuterium'] );
			SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
			$this->RestoreFleetToPlanet($FleetRow);
			doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.$FleetRow['fleet_id'],'fleets');
		}
	}

	private function MissionCaseACS($FleetRow)
	{
		global $pricelist, $lang, $resource, $CombatCaps, $game_config;

		if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_start_time']> time())
		{
			$QryUpdateFleet  = "UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = '". $FleetRow['fleet_id'] ."' LIMIT 1 ;";
			doquery( $QryUpdateFleet, 'fleets');
		}
		elseif ($FleetRow['fleet_end_time'] <= time())
		{
			$this->RestoreFleetToPlanet($FleetRow);
			doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.$FleetRow['fleet_id'],'fleets');
		}
	}

	private function MissionCaseTransport ( $FleetRow )
	{
		global $lang;

		$QryStartPlanet   = "SELECT * FROM {{table}} ";
		$QryStartPlanet  .= "WHERE ";
		$QryStartPlanet  .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
		$QryStartPlanet  .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
		$QryStartPlanet  .= "`planet` = '". $FleetRow['fleet_start_planet'] ."' AND ";
		$QryStartPlanet  .= "`planet_type` = '". $FleetRow['fleet_start_type'] ."';";
		$StartPlanet      = doquery( $QryStartPlanet, 'planets', true);
		$StartName        = $StartPlanet['name'];
		$StartOwner       = $StartPlanet['id_owner'];

		$QryTargetPlanet  = "SELECT * FROM {{table}} ";
		$QryTargetPlanet .= "WHERE ";
		$QryTargetPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
		$QryTargetPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
		$QryTargetPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
		$QryTargetPlanet .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."';";
		$TargetPlanet     = doquery( $QryTargetPlanet, 'planets', true);
		$TargetName       = $TargetPlanet['name'];
		$TargetOwner      = $TargetPlanet['id_owner'];

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

				SendSimpleMessage ( $StartOwner, '', $FleetRow['fleet_start_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);
				if ($TargetOwner <> $StartOwner)
				{
					$Message         = sprintf( $lang['sys_tran_mess_user'],
									$StartName, GetStartAdressLink($FleetRow, ''),
									$TargetName, GetTargetAdressLink($FleetRow, ''),
									$FleetRow['fleet_resource_metal'], $lang['Metal'],
									$FleetRow['fleet_resource_crystal'], $lang['Crystal'],
									$FleetRow['fleet_resource_deuterium'], $lang['Deuterium'] );
					SendSimpleMessage ( $TargetOwner, '', $FleetRow['fleet_start_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);
				}

				$QryUpdateFleet  = "UPDATE {{table}} SET ";
				$QryUpdateFleet .= "`fleet_resource_metal` = '0' , ";
				$QryUpdateFleet .= "`fleet_resource_crystal` = '0' , ";
				$QryUpdateFleet .= "`fleet_resource_deuterium` = '0' , ";
				$QryUpdateFleet .= "`fleet_mess` = '1' ";
				$QryUpdateFleet .= "WHERE `fleet_id` = '". $FleetRow['fleet_id'] ."' ";
				$QryUpdateFleet .= "LIMIT 1 ;";
				doquery( $QryUpdateFleet, 'fleets');
			}
		}
		else
		{
			if ($FleetRow['fleet_end_time'] < time())
			{
				$Message             = sprintf ($lang['sys_tran_mess_back'], $StartName, GetStartAdressLink($FleetRow, ''));
				SendSimpleMessage ( $StartOwner, '', $FleetRow['fleet_end_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
				$this->RestoreFleetToPlanet ( $FleetRow, true );
				doquery("DELETE FROM {{table}} WHERE fleet_id=" . $FleetRow["fleet_id"], 'fleets');
			}
		}
	}

	private function MissionCaseStay($FleetRow)
	{
		global $lang, $resource;

		if ($FleetRow['fleet_mess'] == 0)
		{
			if ($FleetRow['fleet_start_time'] <= time())
			{
				$QryGetTargetPlanet   = "SELECT * FROM {{table}} ";
				$QryGetTargetPlanet  .= "WHERE ";
				$QryGetTargetPlanet  .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
				$QryGetTargetPlanet  .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
				$QryGetTargetPlanet  .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
				$QryGetTargetPlanet  .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."';";
				$TargetPlanet         = doquery( $QryGetTargetPlanet, 'planets', true);
				$TargetUserID         = $TargetPlanet['id_owner'];

				$TargetAdress         = sprintf ($lang['sys_adress_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
				$TargetAddedGoods     = sprintf ($lang['sys_stay_mess_goods'],
				$lang['Metal'], pretty_number($FleetRow['fleet_resource_metal']),
				$lang['Crystal'], pretty_number($FleetRow['fleet_resource_crystal']),
				$lang['Deuterium'], pretty_number($FleetRow['fleet_resource_deuterium']));

				$TargetMessage        = $lang['sys_stay_mess_start'] ."<a href=\"game.php?page=galaxy&mode=3&galaxy=". $FleetRow['fleet_end_galaxy'] ."&system=". $FleetRow['fleet_end_system'] ."\">";
				$TargetMessage       .= $TargetAdress. "</a>". $lang['sys_stay_mess_end'] ."<br>". $TargetAddedGoods;

				SendSimpleMessage ( $TargetUserID, '', $FleetRow['fleet_start_time'], 5, $lang['sys_mess_qg'], $lang['sys_stay_mess_stay'], $TargetMessage);
				$this->RestoreFleetToPlanet ( $FleetRow, false );
				doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
			}
		}
		else
		{
			if ($FleetRow['fleet_end_time'] <= time())
			{
				$TargetAdress         = sprintf ($lang['sys_adress_planet'], $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet']);
				$TargetAddedGoods     = sprintf ($lang['sys_stay_mess_goods'],
				$lang['Metal'], pretty_number($FleetRow['fleet_resource_metal']),
				$lang['Crystal'], pretty_number($FleetRow['fleet_resource_crystal']),
				$lang['Deuterium'], pretty_number($FleetRow['fleet_resource_deuterium']));

				$TargetMessage        = $lang['sys_stay_mess_back'] ."<a href=\"game.php?page=galaxy&mode=3&galaxy=". $FleetRow['fleet_start_galaxy'] ."&system=". $FleetRow['fleet_start_system'] ."\">";
				$TargetMessage       .= $TargetAdress. "</a>". $lang['sys_stay_mess_bend'] ."<br>". $TargetAddedGoods;

				SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 5, $lang['sys_mess_qg'], $lang['sys_mess_fleetback'], $TargetMessage);
				$this->RestoreFleetToPlanet ( $FleetRow, true );
				doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
			}
		}
	}

	private function MissionCaseStayAlly($FleetRow)
	{
		global $lang;

		$QryStartPlanet   = "SELECT * FROM {{table}} ";
		$QryStartPlanet  .= "WHERE ";
		$QryStartPlanet  .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
		$QryStartPlanet  .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
		$QryStartPlanet  .= "`planet` = '". $FleetRow['fleet_start_planet'] ."';";
		$StartPlanet      = doquery( $QryStartPlanet, 'planets', true);
		$StartName        = $StartPlanet['name'];
		$StartOwner       = $StartPlanet['id_owner'];

		$QryTargetPlanet  = "SELECT * FROM {{table}} ";
		$QryTargetPlanet .= "WHERE ";
		$QryTargetPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
		$QryTargetPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
		$QryTargetPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."';";
		$TargetPlanet     = doquery( $QryTargetPlanet, 'planets', true);
		$TargetName       = $TargetPlanet['name'];
		$TargetOwner      = $TargetPlanet['id_owner'];

		if ($FleetRow['fleet_mess'] == 0)
		{
			if ($FleetRow['fleet_start_time'] <= time())
			{
				$Message = sprintf($lang['sys_tran_mess_owner'], $TargetName, GetTargetAdressLink($FleetRow, ''),
					$FleetRow['fleet_resource_metal'], $lang['Metal'],
					$FleetRow['fleet_resource_crystal'], $lang['Crystal'],
					$FleetRow['fleet_resource_deuterium'], $lang['Deuterium'] );

				SendSimpleMessage ($StartOwner, '',$FleetRow['fleet_start_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);

				$Message = sprintf( $lang['sys_tran_mess_user'], $StartName, GetStartAdressLink($FleetRow, ''),
					$TargetName, GetTargetAdressLink($FleetRow, ''),
					$FleetRow['fleet_resource_metal'], $lang['Metal'],
					$FleetRow['fleet_resource_crystal'], $lang['Crystal'],
					$FleetRow['fleet_resource_deuterium'], $lang['Deuterium'] );

				SendSimpleMessage ($TargetOwner, '',$FleetRow['fleet_start_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_transport'], $Message);

				$QryUpdateFleet  = "UPDATE {{table}} SET ";
				$QryUpdateFleet .= "`fleet_mess` = 2 ";
				$QryUpdateFleet .= "WHERE `fleet_id` = '". $FleetRow['fleet_id'] ."' ";
				$QryUpdateFleet .= "LIMIT 1 ;";
				doquery( $QryUpdateFleet, 'fleets');

			}
			elseif($FleetRow['fleet_end_stay'] <= time())
			{
				$QryUpdateFleet  = "UPDATE {{table}} SET ";
				$QryUpdateFleet .= "`fleet_mess` = 1 ";
				$QryUpdateFleet .= "WHERE `fleet_id` = '". $FleetRow['fleet_id'] ."' ";
				$QryUpdateFleet .= "LIMIT 1 ;";
				doquery( $QryUpdateFleet, 'fleets');
			}
		}
		else
		{
			if ($FleetRow['fleet_end_time'] < time())
			{
				$Message         = sprintf ($lang['sys_tran_mess_back'], $StartName, GetStartAdressLink($FleetRow, ''));
				SendSimpleMessage ( $StartOwner, '', $FleetRow['fleet_end_time'], 5, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
				$this->RestoreFleetToPlanet ( $FleetRow, true );
				doquery("DELETE FROM {{table}} WHERE fleet_id=" . $FleetRow["fleet_id"], 'fleets');
			}
		}
	}

	private function MissionCaseSpy($FleetRow)
	{
		global $lang, $resource;

		if ($FleetRow['fleet_start_time'] <= time())
		{
			$CurrentUser         = doquery("SELECT * FROM {{table}} WHERE `id` = '".$FleetRow['fleet_owner']."';", 'users', true);
			$CurrentUserID       = $FleetRow['fleet_owner'];
			$QryGetTargetPlanet  = "SELECT * FROM {{table}} ";
			$QryGetTargetPlanet .= "WHERE ";
			$QryGetTargetPlanet .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
			$QryGetTargetPlanet .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
			$QryGetTargetPlanet .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
			$QryGetTargetPlanet .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."';";
			$TargetPlanet        = doquery( $QryGetTargetPlanet, 'planets', true);
			$TargetUserID        = $TargetPlanet['id_owner'];
			$CurrentPlanet       = doquery("SELECT * FROM {{table}} WHERE `galaxy` = '".$FleetRow['fleet_start_galaxy']."' AND `system` = '".$FleetRow['fleet_start_system']."' AND `planet` = '".$FleetRow['fleet_start_planet']."';", 'planets', true);
			$CurrentSpyLvl       = $CurrentUser['spy_tech'] + ($CurrentUser['rpg_espion'] * ESPION);
			$TargetUser          = doquery("SELECT * FROM {{table}} WHERE `id` = '".$TargetUserID."';", 'users', true);
			$TargetSpyLvl        = $TargetUser['spy_tech'] + ($TargetUser['rpg_espion'] * ESPION);
			$fleet               = explode(";", $FleetRow['fleet_array']);
			$fquery              = "";
			//include('../functions/PlanetResourceUpdate.php');
			//PlanetResourceUpdate ( $TargetUser, $TargetPlanet, time() );

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
							$TargetGalaxy     = doquery( $QryTargetGalaxy, 'galaxy', true);
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

							if ($TargetForce> 100)
								$TargetForce = 100;

							$TargetChances = rand(0, $TargetForce);
							$SpyerChances  = rand(0, 100);

							if ($TargetChances>= $SpyerChances)
								$DestProba = "<font color=\"red\">".$lang['sys_mess_spy_destroyed']."</font>";
							elseif ($TargetChances < $SpyerChances)
								$DestProba = sprintf( $lang['sys_mess_spy_lostproba'], $TargetChances);

							$AttackLink = "<center>";
							$AttackLink .= "<a href=\"game.php?page=fleet&galaxy=". $FleetRow['fleet_end_galaxy'] ."&system=". $FleetRow['fleet_end_system'] ."";
							$AttackLink .= "&planet=".$FleetRow['fleet_end_planet']."";
							$AttackLink .= "&target_mission=1";
							$AttackLink .= " \">". $lang['type_mission'][1] ."";
							$AttackLink .= "</a></center>";
							$MessageEnd  = "<center>".$DestProba."</center>";

							$pT = ($TargetSpyLvl - $CurrentSpyLvl);
							$pW = ($CurrentSpyLvl - $TargetSpyLvl);
							if ($TargetSpyLvl> $CurrentSpyLvl)
								$ST = ($LS - pow($pT, 2));
							if ($CurrentSpyLvl> $TargetSpyLvl)
								$ST = ($LS + pow($pW, 2));
							if ($TargetSpyLvl == $CurrentSpyLvl)
								$ST = $CurrentSpyLvl;
							if ($ST <= "1")
								$SpyMessage = $Materials."<br>".$AttackLink.$MessageEnd;
							if ($ST == "2")
								$SpyMessage = $PlanetFleet."<br>".$AttackLink.$MessageEnd;
							if ($ST == "4" or $ST == "3")
								$SpyMessage = $PlanetDefense."<br>".$AttackLink.$MessageEnd;
							if ($ST == "5" or $ST == "6")
								$SpyMessage = $PlanetBuildings."<br>".$AttackLink.$MessageEnd;
							if ($ST>= "7")
								$SpyMessage = $TargetTechnos."<br>".$AttackLink.$MessageEnd;

							SendSimpleMessage ( $CurrentUserID, '', $FleetRow['fleet_start_time'], 0, $lang['sys_mess_qg'], $lang['sys_mess_spy_report'], $SpyMessage);

							$TargetMessage  = $lang['sys_mess_spy_ennemyfleet'] ." ". $CurrentPlanet['name'];
							$TargetMessage .= "<a href=\"game.php?page=galaxy&mode=3&galaxy=". $CurrentPlanet["galaxy"] ."&system=". $CurrentPlanet["system"] ."\">";
							$TargetMessage .= "[". $CurrentPlanet["galaxy"] .":". $CurrentPlanet["system"] .":". $CurrentPlanet["planet"] ."]</a> ";
							$TargetMessage .= $lang['sys_mess_spy_seen_at'] ." ". $TargetPlanet['name'];
							$TargetMessage .= " [". $TargetPlanet["galaxy"] .":". $TargetPlanet["system"] .":". $TargetPlanet["planet"] ."].";

							SendSimpleMessage ( $TargetUserID, '', $FleetRow['fleet_start_time'], 0, $lang['sys_mess_spy_control'], $lang['sys_mess_spy_activity'], $TargetMessage);

						}
						if ($TargetChances>= $SpyerChances)
						{
							$QryUpdateGalaxy  = "UPDATE {{table}} SET ";
							$QryUpdateGalaxy .= "`crystal` = `crystal` + '". (0 + $SpyToolDebris) ."' ";
							$QryUpdateGalaxy .= "WHERE `id_planet` = '". $TargetPlanet['id'] ."';";
							doquery( $QryUpdateGalaxy, 'galaxy');
							doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
						}
						else
							doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
					}
				}
				else
				{
					if ($FleetRow['fleet_end_time'] <= time())
					{
						$this->RestoreFleetToPlanet ( $FleetRow, true );
						doquery("DELETE FROM {{table}} WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
					}
				}
			}
		}
	}

	private function MissionCaseRecycling ($FleetRow)
	{
		global $pricelist, $lang;

		if ($FleetRow["fleet_mess"] == "0")
		{
			if ($FleetRow['fleet_start_time'] <= time())
			{
				$QrySelectGalaxy  = "SELECT * FROM {{table}} ";
				$QrySelectGalaxy .= "WHERE ";
				$QrySelectGalaxy .= "`galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND ";
				$QrySelectGalaxy .= "`system` = '".$FleetRow['fleet_end_system']."' AND ";
				$QrySelectGalaxy .= "`planet` = '".$FleetRow['fleet_end_planet']."' ";
				$QrySelectGalaxy .= "LIMIT 1;";
				$TargetGalaxy     = doquery( $QrySelectGalaxy, 'galaxy', true);

				$FleetRecord         = explode(";", $FleetRow['fleet_array']);
				$RecyclerCapacity    = 0;
				$OtherFleetCapacity  = 0;
				foreach ($FleetRecord as $Item => $Group)
				{
					if ($Group != '')
					{
						$Class        = explode (",", $Group);
						if ($Class[0] == 209)
							$RecyclerCapacity   += $pricelist[$Class[0]]["capacity"] * $Class[1];
						else
							$OtherFleetCapacity += $pricelist[$Class[0]]["capacity"] * $Class[1];
					}
				}

				$IncomingFleetGoods = $FleetRow["fleet_resource_metal"] + $FleetRow["fleet_resource_crystal"] + $FleetRow["fleet_resource_deuterium"];
				if ($IncomingFleetGoods> $OtherFleetCapacity)
					$RecyclerCapacity -= ($IncomingFleetGoods - $OtherFleetCapacity);

				if (($TargetGalaxy["metal"] + $TargetGalaxy["crystal"]) <= $RecyclerCapacity)
				{
					$RecycledGoods["metal"]   = $TargetGalaxy["metal"];
					$RecycledGoods["crystal"] = $TargetGalaxy["crystal"];
				}
				else
				{
					if (($TargetGalaxy["metal"]  > $RecyclerCapacity / 2) && ($TargetGalaxy["crystal"]> $RecyclerCapacity / 2))
					{
						$RecycledGoods["metal"]   = $RecyclerCapacity / 2;
						$RecycledGoods["crystal"] = $RecyclerCapacity / 2;
					}
					else
					{
						if ($TargetGalaxy["metal"]> $TargetGalaxy["crystal"])
						{
							$RecycledGoods["crystal"] = $TargetGalaxy["crystal"];
							if ($TargetGalaxy["metal"]> ($RecyclerCapacity - $RecycledGoods["crystal"]))
								$RecycledGoods["metal"] = $RecyclerCapacity - $RecycledGoods["crystal"];
							else
								$RecycledGoods["metal"] = $TargetGalaxy["metal"];
						}
						else
						{
							$RecycledGoods["metal"] = $TargetGalaxy["metal"];
							if ($TargetGalaxy["crystal"]> ($RecyclerCapacity - $RecycledGoods["metal"]))
								$RecycledGoods["crystal"] = $RecyclerCapacity - $RecycledGoods["metal"];
							else
								$RecycledGoods["crystal"] = $TargetGalaxy["crystal"];
						}
					}
				}

				$QryUpdateGalaxy  = "UPDATE {{table}} SET ";
				$QryUpdateGalaxy .= "`metal` = `metal` - '".$RecycledGoods["metal"]."', ";
				$QryUpdateGalaxy .= "`crystal` = `crystal` - '".$RecycledGoods["crystal"]."' ";
				$QryUpdateGalaxy .= "WHERE ";
				$QryUpdateGalaxy .= "`galaxy` = '".$FleetRow['fleet_end_galaxy']."' AND ";
				$QryUpdateGalaxy .= "`system` = '".$FleetRow['fleet_end_system']."' AND ";
				$QryUpdateGalaxy .= "`planet` = '".$FleetRow['fleet_end_planet']."' ";
				$QryUpdateGalaxy .= "LIMIT 1;";
				doquery( $QryUpdateGalaxy, 'galaxy');

				$Message = sprintf($lang['sys_recy_gotten'], pretty_number($RecycledGoods["metal"]), $lang['Metal'], pretty_number($RecycledGoods["crystal"]), $lang['Crystal']);
				SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 4, $lang['sys_mess_spy_control'], $lang['sys_recy_report'], $Message);

				$QryUpdateFleet  = "UPDATE {{table}} SET ";
				$QryUpdateFleet .= "`fleet_resource_metal` = `fleet_resource_metal` + '".$RecycledGoods["metal"]."', ";
				$QryUpdateFleet .= "`fleet_resource_crystal` = `fleet_resource_crystal` + '".$RecycledGoods["crystal"]."', ";
				$QryUpdateFleet .= "`fleet_mess` = '1' ";
				$QryUpdateFleet .= "WHERE ";
				$QryUpdateFleet .= "`fleet_id` = '".$FleetRow['fleet_id']."' ";
				$QryUpdateFleet .= "LIMIT 1;";
				doquery( $QryUpdateFleet, 'fleets');
			}
		}
		else
		{
			if ($FleetRow['fleet_end_time'] <= time())
			{
				$Message         = sprintf( $lang['sys_tran_mess_owner'],
				$TargetName, GetTargetAdressLink($FleetRow, ''),
				pretty_number($FleetRow['fleet_resource_metal']), $lang['Metal'],
				pretty_number($FleetRow['fleet_resource_crystal']), $lang['Crystal'],
				pretty_number($FleetRow['fleet_resource_deuterium']), $lang['Deuterium'] );
				SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 4, $lang['sys_mess_spy_control'], $lang['sys_mess_fleetback'], $Message);
				$this->RestoreFleetToPlanet ( $FleetRow, true );
				doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
			}
		}
	}

	private function MissionCaseColonisation($FleetRow)
	{
		global $lang, $resource;

		$iPlanetCount = mysql_result(doquery ("SELECT count(*) FROM {{table}} WHERE `id_owner` = '". $FleetRow['fleet_owner'] ."' AND `planet_type` = '1' AND `destruyed` = '0'", 'planets'), 0);

		if ($FleetRow['fleet_mess'] == 0)
		{
			$iGalaxyPlace = mysql_result(doquery ("SELECT count(*) FROM {{table}} WHERE `galaxy` = '". $FleetRow['fleet_end_galaxy']."' AND `system` = '". $FleetRow['fleet_end_system']."' AND `planet` = '". $FleetRow['fleet_end_planet']."';", 'galaxy'), 0);
			$TargetAdress = sprintf ($lang['sys_adress_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
			if ($iGalaxyPlace == 0)
			{
				if ($iPlanetCount>= MAX_PLAYER_PLANETS)
				{
					$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_maxcolo'] . MAX_PLAYER_PLANETS . $lang['sys_colo_planet'];
					SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
					doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
				}
				else
				{
					$NewOwnerPlanet = CreateOnePlanetRecord($FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'], $FleetRow['fleet_owner'], $lang['sys_colo_defaultname'], false);
					if ( $NewOwnerPlanet == true )
					{
						$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_allisok'];
						SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
						if ($FleetRow['fleet_amount'] == 1)
							doquery("DELETE FROM {{table}} WHERE fleet_id=" . $FleetRow["fleet_id"], 'fleets');
						else
						{
							$CurrentFleet = explode(";", $FleetRow['fleet_array']);
							$NewFleet     = "";
							foreach ($CurrentFleet as $Item => $Group)
							{
								if ($Group != '')
								{
									$Class = explode (",", $Group);
									if ($Class[0] == 208)
									{
										if ($Class[1]> 1)
										{
											$NewFleet  .= $Class[0].",".($Class[1] - 1).";";
										}
									}
									else
									{
										if ($Class[1] <> 0)
										{
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
							doquery( $QryUpdateFleet, 'fleets');
						}
					}
					else
					{
						$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_badpos'];
						SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
						doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
					}
				}
			}
			else
			{
				$TheMessage = $lang['sys_colo_arrival'] . $TargetAdress . $lang['sys_colo_notfree'];
				SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 0, $lang['sys_colo_mess_from'], $lang['sys_colo_mess_report'], $TheMessage);
				doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
			}
		}
		elseif ($FleetRow['fleet_end_time'] < time())
		{
			$this->RestoreFleetToPlanet ( $FleetRow, true );
			doquery("DELETE FROM {{table}} WHERE fleet_id=" . $FleetRow["fleet_id"], 'fleets');
		}
	}
	
	private function MissionCaseDestruction($FleetRow)
	{
		global $user, $phpEx, $pricelist, $lang, $resource, $CombatCaps;

	    includeLang('INGAME');
		if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_start_time'] <= time())
		{
				$targetPlanet = doquery("SELECT * FROM {{table}} WHERE `galaxy` = ". $FleetRow['fleet_end_galaxy'] ." AND `system` = ". $FleetRow['fleet_end_system'] ." AND `planet_type` = ". $FleetRow['fleet_end_type'] ." AND `planet` = ". $FleetRow['fleet_end_planet'] .";",'planets', true);
				$targetGalaxy = doquery('SELECT * FROM {{table}} WHERE `galaxy` = '. $FleetRow['fleet_end_galaxy'] .' AND `system` = '. $FleetRow['fleet_end_system'] .' AND `planet` = '. $FleetRow['fleet_end_planet'] .';','galaxy', true);
				$targetUser   = doquery('SELECT * FROM {{table}} WHERE id='.$targetPlanet['id_owner'],'users', true);
				$TargetUserID = $targetUser['id'];
				$attackFleets = array();

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
				while ($defRow = mysql_fetch_assoc($def))
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

				$QryUpdateGalaxy = "UPDATE {{table}} SET ";
				$QryUpdateGalaxy .= "`metal` = `metal` +'".($result['debree']['att'][0]+$result['debree']['def'][0]) . "', ";
				$QryUpdateGalaxy .= "`crystal` = `crystal` + '" .($result['debree']['att'][1]+$result['debree']['def'][1]). "' ";
				$QryUpdateGalaxy .= "WHERE ";
				$QryUpdateGalaxy .= "`galaxy` = '" . $FleetRow['fleet_end_galaxy'] . "' AND ";
				$QryUpdateGalaxy .= "`system` = '" . $FleetRow['fleet_end_system'] . "' AND ";
				$QryUpdateGalaxy .= "`planet` = '" . $FleetRow['fleet_end_planet'] . "' ";
				$QryUpdateGalaxy .= "LIMIT 1;";
				doquery($QryUpdateGalaxy , 'galaxy');

				foreach ($attackFleets as $fleetID => $attacker)
				{
					$fleetArray = '';
					$totalCount = 0;
					foreach ($attacker['detail'] as $element => $amount)
					{
						if ($amount)
							$fleetArray .= $element.','.$amount.';';

						$totalCount += $amount;
					}

					if ($totalCount <= 0)
					{
						doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.$fleetID,'fleets');
					}
					else
					{
						doquery ('UPDATE {{table}} SET fleet_array="'.substr($fleetArray, 0, -1).'", fleet_amount='.$totalCount.', fleet_mess=1 WHERE fleet_id='.$fleetID,'fleets');
					}
				}

				foreach ($defense as $fleetID => $defender)
				{
					if ($fleetID != 0)
					{
						$fleetArray = '';
						$totalCount = 0;

						foreach ($defender['def'] as $element => $amount)
						{
							if ($amount) $fleetArray .= $element.','.$amount.';';
								$totalCount += $amount;
						}

						if ($totalCount <= 0)
						{
							doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.$fleetID,'fleets');

						}
						else
						{
							doquery('UPDATE {{table}} SET fleet_array="'.$fleetArray.'", fleet_amount='.$totalCount.', fleet_mess=1 WHERE fleet_id='.$fleetID,'fleets');
						}

					}
					else
					{
						$fleetArray = '';
						$totalCount = 0;

						foreach ($defender['def'] as $element => $amount)
						{
							$fleetArray .= '`'.$resource[$element].'`='.$amount.', ';
						}

						$QryUpdateTarget  = "UPDATE {{table}} SET ";
						$QryUpdateTarget .= $fleetArray;
						$QryUpdateTarget .= "`metal` = `metal` - '". $steal['metal'] ."', ";
						$QryUpdateTarget .= "`crystal` = `crystal` - '". $steal['crystal'] ."', ";
						$QryUpdateTarget .= "`deuterium` = `deuterium` - '". $steal['deuterium'] ."' ";
						$QryUpdateTarget .= "WHERE ";
						$QryUpdateTarget .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
						$QryUpdateTarget .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
						$QryUpdateTarget .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
						$QryUpdateTarget .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."' ";
						$QryUpdateTarget .= "LIMIT 1;";
						doquery( $QryUpdateTarget , 'planets');
					}
				}

				$FleetDebris      = $result['debree']['att'][0] + $result['debree']['def'][0] + $result['debree']['att'][1] + $result['debree']['def'][1];
				$StrAttackerUnits = sprintf ($lang['sys_attacker_lostunits'], $result['lost']['att']);
				$StrDefenderUnits = sprintf ($lang['sys_defender_lostunits'], $result['lost']['def']);
				$StrRuins         = sprintf ($lang['sys_gcdrunits'], $result['debree']['def'][0] + $result['debree']['att'][0], $lang['Metal'], $result['debree']['def'][1] + $result['debree']['att'][1], $lang['Crystal']);
				$DebrisField      = $StrAttackerUnits ."<br>". $StrDefenderUnits ."<br>". $StrRuins;
				$steal 			  = array('metal' => 0, 'crystal' => 0, 'deuterium' => 0);
				switch ($result['won']) {
					case "a":
						$max_resources = 0;
						foreach ($attackFleets[$FleetRow['fleet_id']]['detail'] as $Element => $amount) {
							$max_resources += $pricelist[$Element]['capacity'] * $amount;
						}
						
						if ($max_resources> 0) {
							$metal   = $targetPlanet['metal'] / 2;
							$crystal = $targetPlanet['crystal'] / 2;
							$deuter  = $targetPlanet['deuterium'] / 2;
							if ($deuter> $max_resources / 3) {
								$steal['deuterium']     = $max_resources / 3;
								$max_resources        -= $steal['deuterium'];
							} else {
								$steal['deuterium']     = $deuter;
								$max_resources        -= $steal['deuterium'];
							}
							
							if ($crystal> $max_resources / 2) {
								$steal['crystal'] = $max_resources / 2;
								$max_resources   -= $steal['crystal'];
							} else {
								$steal['crystal'] = $crystal;
								$max_resources   -= $steal['crystal'];
							}
							
							if ($metal> $max_resources) {
								$steal['metal']         = $max_resources;
								$max_resources         = $max_resources - $steal['metal'];
							} else {
								$steal['metal']         = $metal;
								$max_resources        -= $steal['metal'];
							}            
						}
						
						$steal = array_map('round', $steal);

						$QryUpdateFleet  = 'UPDATE {{table}} SET ';
						$QryUpdateFleet .= '`fleet_resource_metal` = `fleet_resource_metal` + '. $steal['metal'] .', ';
						$QryUpdateFleet .= '`fleet_resource_crystal` = `fleet_resource_crystal` +'. $steal['crystal'] .', ';
						$QryUpdateFleet .= '`fleet_resource_deuterium` = `fleet_resource_deuterium` +'. $steal['deuterium'] .' ';
						$QryUpdateFleet .= 'WHERE fleet_id = '. $FleetRow['fleet_id'] .' ';
						$QryUpdateFleet .= 'LIMIT 1 ;';
						doquery( $QryUpdateFleet,'fleets' );

						$QryUpdateTarget  = "UPDATE {{table}} SET ";
						$QryUpdateTarget .= $fleetArray;
						$QryUpdateTarget .= "`metal` = `metal` - '". $steal['metal'] ."', ";
						$QryUpdateTarget .= "`crystal` = `crystal` - '". $steal['crystal'] ."', ";
						$QryUpdateTarget .= "`deuterium` = `deuterium` - '". $steal['deuterium'] ."' ";
						$QryUpdateTarget .= "WHERE ";
						$QryUpdateTarget .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
						$QryUpdateTarget .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
						$QryUpdateTarget .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
						$QryUpdateTarget .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."' ";
						$QryUpdateTarget .= "LIMIT 1;";
						doquery( $QryUpdateTarget , 'planets');
						$destructionl2 = (100-sqrt($targetPlanet['diameter']))*sqrt($attackFleets[$FleetRow['fleet_id']]['detail'][214]);
						// Formel für min. Anzahl an Todessternen. Hat jmd. ne gute Formel? :D
						// $mints = (pow((1 / (1-sqrt($targetPlanet['diameter']) / 100)),2))*10;
						// $destructionl2 = max($destructionl1,$mints);
						if ($destructionl2> 100) {
							$chance = '100';
						} elseif ($destructionl2 < 0) {
							$chance = '0';
						}
						$tirage = mt_rand(0, 100);
						if($tirage <= $chance)   {
							doquery("DELETE FROM {{table}} WHERE `id` = '". $targetPlanet['id'] ."';", 'planets');
							$Qrydestructionlune  = "UPDATE {{table}} SET ";
							$Qrydestructionlune .= "`destruyed` = '1' ";
							$Qrydestructionlune .= "WHERE ";
							$Qrydestructionlune .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
							$Qrydestructionlune .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
							$Qrydestructionlune .= "`lunapos` = '". $FleetRow['fleet_end_planet'] ."' ";
							$Qrydestructionlune .= "LIMIT 1 ;";
							doquery( $Qrydestructionlune , 'lunas');
							$Qrydestructionlune2  = "UPDATE {{table}} SET ";
							$Qrydestructionlune2 .= "`id_luna` = '0' ";
							$Qrydestructionlune2 .= "WHERE ";
							$Qrydestructionlune2 .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
							$Qrydestructionlune2 .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
							$Qrydestructionlune2 .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' ";
							$Qrydestructionlune2 .= "LIMIT 1 ;";
							doquery( $Qrydestructionlune2 , 'galaxy');
							$destext .= sprintf ($lang['sys_destruc_mess'], $DepName , $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'])."<br>";
							$destext .= sprintf ($lang['sys_destruc_lune'], $chance) ."<br>";
							$destext .= $lang['sys_destruc_mess1'];
							$destext .= $lang['sys_destruc_reussi'];
					        $destructionrip = sqrt($TargetPlanet['diameter'])/2;
							$chance2  = round($destructionrip);                 
							$tirage2  = mt_rand(0, 100);
							$probarip = sprintf ($lang['sys_destruc_rip'], $chance2);
							if($tirage2 <= $chance2) {
								$destext .= $lang['sys_destruc_echec'];
								doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
							}
						} else {
					        $destructionrip = sqrt($TargetPlanet['diameter'])/2;
							$chance2  = round($destructionrip);                 
							$tirage2  = mt_rand(0, 100);
							$probarip = sprintf ($lang['sys_destruc_rip'], $chance2);
							$destext .= sprintf ($lang['sys_destruc_mess'], $DepName , $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'])."<br>";
							$destext .= $lang['sys_destruc_mess1'];
							$destext .= sprintf ($lang['sys_destruc_lune'], $chance) ."<br>";
							if($tirage2 <= $chance2) {
								$destext .= $lang['sys_destruc_echec'];
								doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
							} else {
								$destext .= $lang['sys_destruc_stop'];							
							}
						}
					break;
				case "r":
					$destext 		  .= sprintf ($lang['sys_destruc_mess'], $DepName , $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'])."<br>";
					$destext 		  .= $lang['sys_destruc_stop'] ."<br>";
					doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $FleetRow["fleet_id"] ."';", 'fleets');
					break;
				case "w":
					$destext 		  .= sprintf ($lang['sys_destruc_mess'], $DepName , $FleetRow['fleet_start_galaxy'], $FleetRow['fleet_start_system'], $FleetRow['fleet_start_planet'], $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet'])."<br>";
					$destext 		  .= $lang['sys_destruc_stop'] ."<br>";
					break;
				default:
					break;
				}

				$QryUpdateTarget  = "UPDATE {{table}} SET ";
				$QryUpdateTarget .= $TargetPlanetUpd;
				$QryUpdateTarget .= "`metal` = `metal` - '". $steal['metal'] ."', ";
				$QryUpdateTarget .= "`crystal` = `crystal` - '". $steal['crystal'] ."', ";
				$QryUpdateTarget .= "`deuterium` = `deuterium` - '". $steal['deuter'] ."' ";
				$QryUpdateTarget .= "WHERE ";
				$QryUpdateTarget .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
				$QryUpdateTarget .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
				$QryUpdateTarget .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' AND ";
				$QryUpdateTarget .= "`planet_type` = '". $FleetRow['fleet_end_type'] ."' ";
				$QryUpdateTarget .= "LIMIT 1;";
				doquery( $QryUpdateTarget , 'planets');

				$QryUpdateGalaxy  = "UPDATE {{table}} SET ";
				$QryUpdateGalaxy .= "`metal` = `metal` + '". $zlom['metal'] ."', ";
				$QryUpdateGalaxy .= "`crystal` = `crystal` + '". $zlom['crystal'] ."' ";
				$QryUpdateGalaxy .= "WHERE ";
				$QryUpdateGalaxy .= "`galaxy` = '". $FleetRow['fleet_end_galaxy'] ."' AND ";
				$QryUpdateGalaxy .= "`system` = '". $FleetRow['fleet_end_system'] ."' AND ";
				$QryUpdateGalaxy .= "`planet` = '". $FleetRow['fleet_end_planet'] ."' ";
				$QryUpdateGalaxy .= "LIMIT 1;";
				doquery( $QryUpdateGalaxy , 'galaxy');

				$MoonChance       = 0;
				$GottenMoon 	  = "";
				$formatted_cr 	  = formatCR($result,$steal,$MoonChance,$GottenMoon,$totaltime,$destext);
				$raport 		  = $formatted_cr['html'];
				$rid   = md5($raport);
				$QryInsertRapport  = 'INSERT INTO {{table}} SET ';
				$QryInsertRapport .= '`time` = UNIX_TIMESTAMP(), ';
				foreach ($attackFleets as $fleetID => $attacker)
				{
					$users2[$attacker['user']['id']] = $attacker['user']['id'];
				}

				foreach ($defense as $fleetID => $defender)
				{
					$users2[$defender['user']['id']] = $defender['user']['id'];
				}
				$QryInsertRapport .= '`owners` = "'.implode(',', $users2).'", ';
				$QryInsertRapport .= '`rid` = "'. $rid .'", ';
				$QryInsertRapport .= '`raport` = "'. mysql_real_escape_string( $raport ) .'"';
				doquery($QryInsertRapport,'rw') or die("Error inserting CR to database".mysql_error()."<br><br>Trying to execute:".mysql_query());

				$raport  = '<a href # OnClick=\'f( "CombatReport.php?raport='. $rid .'", "");\'>';
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

				$raport .= $lang['sys_mess_destruc_report'] ." [". $FleetRow['fleet_end_galaxy'] .":". $FleetRow['fleet_end_system'] .":". $FleetRow['fleet_end_planet'] ."] </font></a><br><br>";
				$raport .= "<font color=\"red\">". $lang['sys_perte_attaquant'] .": ". $result['lost']['att'] ."</font>";
				$raport .= "<font color=\"green\">   ". $lang['sys_perte_defenseur'] .": ". $result['lost']['def'] ."</font><br>" ;
				$raport .= $lang['sys_debris'] ." ". $lang['Metal'] .":<font color=\"#adaead\">". ($result['debree']['att'][0]+$result['debree']['def'][0]) ."</font>   ". $lang['Crystal'] .":<font color=\"#ef51ef\">".( $result['debree']['att'][1]+$result['debree']['def'][1]) ."</font><br></center>";
				SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_attack_report'], $raport );


				$raport2  = "<a href # OnClick=\"f( 'CombatReport.php?raport=". $rid ."', '');\">";
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

				$raport2 .= $lang['sys_mess_destruc_report'] ." [". $FleetRow['fleet_end_galaxy'] .":". $FleetRow['fleet_end_system'] .":". $FleetRow['fleet_end_planet'] ."] </font></a><br><br>";

				SendSimpleMessage ( $TargetUserID, '', $FleetRow['fleet_start_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_destruc_report'], $raport2 );
	    } elseif ($FleetRow['fleet_end_time'] <= time()) {
			$fquery 		= "";
			$Message		= sprintf( $lang['sys_fleet_won'], $TargetName, GetTargetAdressLink($FleetRow, ''),pretty_number($FleetRow['fleet_resource_metal']), $lang['Metal'],pretty_number($FleetRow['fleet_resource_crystal']), $lang['Crystal'],pretty_number($FleetRow['fleet_resource_deuterium']), $lang['Deuterium'] );
			SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 3, $lang['sys_mess_tower'], $lang['sys_mess_fleetback'], $Message);
			$this->RestoreFleetToPlanet($FleetRow);
			doquery ('DELETE FROM {{table}} WHERE `fleet_id`='.$FleetRow['fleet_id'],'fleets');
		}

	}

	private function MissionCaseMIP ($FleetRow)
	{
		global $user, $phpEx, $pricelist, $lang, $resource, $CombatCaps;

		if ($FleetRow['fleet_start_time'] <= time())
		{
			if ($FleetRow['fleet_mess'] == 0)
			{
				if (!isset($CombatCaps[202]['sd']))
					header("location:game." . $phpEx . "?page=fleet");

				$QryTargetPlanet = "SELECT * FROM {{table}} ";
				$QryTargetPlanet .= "WHERE ";
				$QryTargetPlanet .= "`galaxy` = '" . $FleetRow['fleet_end_galaxy'] . "' AND ";
				$QryTargetPlanet .= "`system` = '" . $FleetRow['fleet_end_system'] . "' AND ";
				$QryTargetPlanet .= "`planet` = '" . $FleetRow['fleet_end_planet'] . "' AND ";
				$QryTargetPlanet .= "`planet_type` = '" . $FleetRow['fleet_end_type'] . "';";
				$planet = doquery($QryTargetPlanet, 'planets', true);

				$QrySelect  = "SELECT defence_tech,military_tech FROM {{table}} ";
				$QrySelect .= "WHERE ";
				$QrySelect .= "`id` = '".$FleetRow['fleet_owner']."';";
				$UserFleet = doquery( $QrySelect, 'users',true);

				$verteidiger = $UserFleet["defence_tech"];
				$angreifer 	 = $UserFleet["military_tech"];

				$ids = array(
				0 => 401,
				1 => 402,
				2 => 403,
				3 => 404,
				4 => 405,
				5 => 406,
				6 => 407,
				7 => 408,
				8 => 502,
				9 => 503,
				10 => 409);

				$def =   array(
				0 => $planet['misil_launcher'],
				1 => $planet['small_laser'],
				2 => $planet['big_laser'],
				3 => $planet['gauss_canyon'],
				4 => $planet['ionic_canyon'],
				5 => $planet['buster_canyon'],
				6 => $planet['small_protection_shield'],
				7 => $planet['big_protection_shield'],
				8 => $planet['interceptor_misil'],
				9 => $planet['interplanetary_misil'],
				10 => $planet['planet_protector']);

				$DefenseLabel =   array(0 => $lang['tech'][401],
				1 => $lang['tech'][402],
				2 => $lang['tech'][403],
				3 => $lang['tech'][404],
				4 => $lang['tech'][405],
				5 => $lang['tech'][406],
				6 => $lang['tech'][407],
				7 => $lang['tech'][408],
				8 => $lang['tech'][502],
				9 => $lang['tech'][503],
				10 => $lang['tech'][409]);

				$message = '';

				if ($planet['interceptor_misil']>= $FleetRow['fleet_amount'])
				{
					$message = 'Tus misiles de intersepci&oacute;n destruyeron los misiles interplanetarios<br>';
					$x = $resource[$ids[8]];
					doquery("UPDATE {{table}} SET " . $x . " = " . $x . "-" . $FleetRow['fleet_amount'] . " WHERE id = " . $planet['id'], 'planets');
				}
				else
				{
					if ($planet['interceptor_misil']> 0)
					{
						$x = $resource[$ids[8]];
						doquery("UPDATE {{table}} SET " . $x . " = '0'  WHERE id = " . $planet['id'], 'planets');
						$message = $planet['interceptor_misil'] . "interplanetario misiles fueron destruidos por misiles interceptores.<br>";
						$irak = $this->raketenangriff($verteidiger, $angreifer, $FleetRow['fleet_amount']-$planet['interceptor_misil'], $def, $FleetRow['fleet_target_obj']);
					}

					$irak = $this->raketenangriff($verteidiger, $angreifer, $FleetRow['fleet_amount'], $def, $FleetRow['fleet_target_obj']);

					foreach ($irak['zerstoert'] as $id => $anzahl)
					{
						if ($id < 10)
						{
							if ($id != 8)
								$message .= $DefenseLabel[$id] . " (- " . $anzahl . ")<br>";

							$x = $resource[$ids[$id]];
							$x1 = $x ."-". $anzahl;
							doquery("UPDATE {{table}} SET " . $x . " = " . $x1 . " WHERE id = " . $planet['id'], 'planets');
						}
					}
				}
				$UserPlanet 		= doquery("SELECT name FROM {{table}} WHERE id = '" . $FleetRow['fleet_owner'] . "'", 'planets',true);
				$name 				= $UserPlanet['name'];
				$name_deffer 		= $QryTargetPlanet['name'];
				$message_vorlage  	= 'Un ataque con misiles (' .$FleetRow['fleet_amount']. ') de ' .$name. ' ';
				$message_vorlage   .= 'al planeta ' .$name_deffer.'<br><br>';

				if (empty($message))
					$message = "Tu planeta no tenia defensa!";

				doquery("INSERT INTO {{table}} SET
				`message_owner`='" . $FleetRow['fleet_target_owner'] . "',
				`message_sender`='".$UserPlanet['id']."',
				`message_time`=UNIX_TIMESTAMP(),
				`message_type`='3',
				`message_from`='Torre de Control',
				`message_subject`='Ataque con misiles',
				`message_text`='" . $message_vorlage . $message . "'" , 'messages');
				doquery("INSERT INTO {{table}} SET
				`message_owner`='" . $UserPlanet['id'] . "',
				`message_sender`='".$FleetRow['fleet_target_owner']."',
				`message_time`=UNIX_TIMESTAMP(),
				`message_type`='3',
				`message_from`='Torre de Control',
				`message_subject`='Ataque con misiles',
				`message_text`='" . $message_vorlage . $message . "'" , 'messages');

				doquery("DELETE FROM {{table}} WHERE fleet_id = '" . $FleetRow['fleet_id'] . "'", 'fleets');
			}
		}
		$FleetRow['fleet_start_time'] <= time();
	}

	private function MissionCaseExpedition($FleetRow)
	{
		global $lang, $resource, $pricelist;

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
				216 => 6.0,				
				217 => 1.7,
				218 => 7.0,				
				219 => 1.3,
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
				216 => 0.03125,				
				217 => 0.09,				
				218 => 0.01025,				
				219 => 0.09,			
				);

				$FleetStayDuration 	= ($FleetRow['fleet_end_stay'] - $FleetRow['fleet_start_time']) / 3600;
				$farray 			= explode(";", $FleetRow['fleet_array']);

				foreach ($farray as $Item => $Group)
				{
					if ($Group != '')
					{
						$Class 						= explode (",", $Group);
						$TypeVaisseau 				= $Class[0];
						$NbreVaisseau 				= $Class[1];
						$LaFlotte[$TypeVaisseau]	= $NbreVaisseau;
						$FleetCapacity 			   += $pricelist[$TypeVaisseau]['capacity'];
						$FleetPoints   			   += ($NbreVaisseau * $PointsFlotte[$TypeVaisseau]);
					}
				}

				$FleetUsedCapacity  = $FleetRow['fleet_resource_metal'] + $FleetRow['fleet_resource_crystal'] + $FleetRow['fleet_resource_deuterium'] + $FleetRow['fleet_resource_darkmatter'];
				$FleetCapacity     -= $FleetUsedCapacity;
				$FleetCount 		= $FleetRow['fleet_amount'];
				$Hasard 			= rand(0, 10);
				$MessSender 		= $lang['sys_mess_qg']. "(".$Hasard.")";

				if ($Hasard < 3)
				{
					$Hasard     += 1;
					$LostAmount  = (($Hasard * 33) + 1) / 100;

					if ($LostAmount == 100)
					{
						SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_blackholl_2'] );
						doquery ("DELETE FROM {{table}} WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
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
						doquery( $QryUpdateFleet, 'fleets');
						SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_blackholl_1'] );
					}
				}
				elseif ($Hasard == 3)
				{
					doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
					SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_nothing_1'] );
				}
				elseif ($Hasard>= 4 && $Hasard < 7)
				{
					if ($FleetCapacity> 5000)
					{
						$MinCapacity = $FleetCapacity - 5000;
						$MaxCapacity = $FleetCapacity;
						$FoundGoods  = rand($MinCapacity, $MaxCapacity);
						$FoundMetal  = intval($FoundGoods / 2);
						$FoundCrist  = intval($FoundGoods / 4);
						$FoundDeute  = intval($FoundGoods / 6);
						$FoundDark   = rand(1, 486);

						$QryUpdateFleet  = "UPDATE {{table}} SET ";
						$QryUpdateFleet .= "`fleet_resource_metal` = `fleet_resource_metal` + '". $FoundMetal ."', ";
						$QryUpdateFleet .= "`fleet_resource_crystal` = `fleet_resource_crystal` + '". $FoundCrist."', ";
						$QryUpdateFleet .= "`fleet_resource_deuterium` = `fleet_resource_deuterium` + '". $FoundDeute ."', ";
						$QryUpdateFleet .= "`fleet_resource_darkmatter` = `fleet_resource_darkmatter` + '". $FoundDark ."', ";
						$QryUpdateFleet .= "`fleet_mess` = '1'  ";
						$QryUpdateFleet .= "WHERE ";
						$QryUpdateFleet .= "`fleet_id` = '". $FleetRow["fleet_id"] ."';";
						doquery( $QryUpdateFleet, 'fleets');

						$Message = sprintf($lang['sys_expe_found_goods'],
						pretty_number($FoundMetal), $lang['Metal'],
						pretty_number($FoundCrist), $lang['Crystal'],
						pretty_number($FoundDeute), $lang['Deuterium'],
						pretty_number($FoundDark), $lang['Darkmatter']);

						SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $Message );
					}
				}
				elseif ($Hasard == 7)
				{
					doquery("UPDATE {{table}} SET `fleet_mess` = '1' WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
					SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_nothing_2'] );
				}
				elseif ($Hasard>= 8 && $Hasard < 11)
				{
					$FoundChance = $FleetPoints / $FleetCount;
					for ($Ship = 202; $Ship < 220; $Ship++)
					{
						if ($LaFlotte[$Ship] != 0)
						{
							$FoundShip[$Ship] = round($LaFlotte[$Ship] * $RatioGain[$Ship]);
							if ($FoundShip[$Ship]> 0)
								$LaFlotte[$Ship] += $FoundShip[$Ship];
						}
					}
					$NewFleetArray = "";
					$FoundShipMess = "";

					foreach ($LaFlotte as $Ship => $Count)
					{
						if ($Count> 0)
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
					doquery( $QryUpdateFleet, 'fleets');

					$Message = $lang['sys_expe_found_ships']. $FoundShipMess . "";
					SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $Message);
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
				doquery( $QryUpdatePlanet, 'planets');

				doquery("UPDATE `{{table}}` SET `darkmatter` = `darkmatter` + '".$FleetRow['fleet_resource_darkmatter']."' WHERE `id` =".$FleetRow['fleet_owner']." LIMIT 1 ;", 'users');
				doquery ("DELETE FROM {{table}} WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');

				SendSimpleMessage ( $FleetOwner, '', $FleetRow['fleet_end_time'], 15, $MessSender, $MessTitle, $lang['sys_expe_back_home'] );
			}
		}
	}

	private function MissionFoundDM($FleetRow)
	{
		if ($FleetRow['fleet_mess'] == 0 && $FleetRow['fleet_end_stay'] < time())
		{
			$chance 		 = rand(1, 100);
			if($chance> 30)
			{
				$FoundDark 		 = rand(52, 523);
				$QryUpdatePlanet  = "UPDATE {{table}} SET ";
				$QryUpdatePlanet .= "`metal` = `metal` + ". $FleetRow['fleet_resource_metal'] .", ";
				$QryUpdatePlanet .= "`crystal` = `crystal` + ". $FleetRow['fleet_resource_crystal'] .", ";
				$QryUpdatePlanet .= "`deuterium` = `deuterium` + ". $FleetRow['fleet_resource_deuterium'] ." ";
				$QryUpdatePlanet .= "WHERE ";
				$QryUpdatePlanet .= "`galaxy` = '". $FleetRow['fleet_start_galaxy'] ."' AND ";
				$QryUpdatePlanet .= "`system` = '". $FleetRow['fleet_start_system'] ."' AND ";
				$QryUpdatePlanet .= "`planet` = '". $FleetRow['fleet_start_planet'] ."' AND ";
				$QryUpdatePlanet .= "`planet_type` = '3' ";
				$QryUpdatePlanet .= "LIMIT 1 ;";
				doquery($QryUpdatePlanet, 'planets');
				doquery("UPDATE `{{table}}` SET `darkmatter` = `darkmatter` + '".$FoundDark ."' WHERE `id` =".$FleetRow['fleet_owner']." LIMIT 1 ;", 'users');
				doquery("DELETE FROM {{table}} WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');
				$Message = sprintf($lang['sys_expe_found_goods'], 0, $lang['Metal'], 0, $lang['Crystal'], 0, $lang['Deuterium'], pretty_number($FoundDark), $lang['Darkmatter']);
				SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $Message );
			}else{
				SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_stay'], 15, $MessSender, $MessTitle, $lang['sys_expe_nothing_1'] );
			}
		}
		else
		{
			if ($FleetRow['fleet_end_time'] < time())
			{
				$this->RestoreFleetToPlanet ( $FleetRow, true );

				doquery("UPDATE `{{table}}` SET `darkmatter` = `darkmatter` + '".$FleetRow['fleet_resource_darkmatter']."' WHERE `id` =".$FleetRow['fleet_owner']." LIMIT 1 ;", 'users');
				doquery ("DELETE FROM {{table}} WHERE `fleet_id` = ". $FleetRow["fleet_id"], 'fleets');

				SendSimpleMessage ( $FleetRow['fleet_owner'], '', $FleetRow['fleet_end_time'], 15, $MessSender, $MessTitle, $lang['sys_expe_back_home'] );
			}
		}		
	}
    public function FlyingFleetHandler (&$planet)
    {

    global $resource;

    doquery("LOCK TABLE {{table}}aks WRITE, {{table}}lunas WRITE, {{table}}rw WRITE, {{table}}errors WRITE, {{table}}messages WRITE, {{table}}fleets WRITE,  {{table}}planets WRITE, {{table}}galaxy WRITE ,{{table}}users WRITE", "");

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
    $QryFleet  .= "`fleet_end_type`= ".      $planet['planet_type'] ." ) AND ";
    $QryFleet  .= "( `fleet_start_time` < '". time() ."' OR `fleet_end_time` < '". time() ."' );";
    $fleetquery = doquery( $QryFleet, 'fleets' );
        while ($CurrentFleet = mysql_fetch_array($fleetquery))
        {
            switch ($CurrentFleet["fleet_mission"])
            {
                case 1:
                    $this->MissionCaseAttack($CurrentFleet);
                break;

                case 2:
                    $this->MissionCaseACS($CurrentFleet);
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
				
				case 11:
					$this->MissionFoundDM($CurrentFleet);
				break;
				
                case 15:
                    $this->MissionCaseExpedition($CurrentFleet);
                break;

                default: 
                    doquery("DELETE FROM {{table}} WHERE `fleet_id` = '". $CurrentFleet['fleet_id'] ."';", 'fleets');
                break;
				
			}
		}
	
    doquery("UNLOCK TABLES", "");  
	
	}
}
?>