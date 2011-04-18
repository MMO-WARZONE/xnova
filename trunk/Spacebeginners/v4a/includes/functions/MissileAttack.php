<?php

/**
 * MissileAttack.php
 *
 * @version 1
 * @copyright 2008 By MadnessRed for XNova Redesigned
 */

//ALTER TABLE  `game_fleets` ADD  `fleet_targetdef` INT( 3 ) NOT NULL DEFAULT  '0' AFTER  `fleet_group` ;
function shuffle_array($array){
	$keys=array_keys($array);
	$s=sizeof($array);

	$return=array();

	while($s > 0) {
		$i=array_rand($keys);
		$return[$keys[$i]] = $array[$keys[$i]];
		unset($keys[$i]);
		$s--;
	}
	return $return;
}

function MissileAttack($FleetRow,$CurrentPlanet,$db = true){
	global $resource, $reslist, $pricelist, $CombatCaps;

	$return = array();

	//Get the missiles, as there is on 1 type of ship...
	$m = explode(",",$FleetRow['fleet_array']);
	$missiles = idstring($m[1]);

	//Get the armour
	foreach($reslist['defense'] as $i){ $hull[$i] = (($pricelist[$i]['metal'] + $pricelist[$i]['crystal']) / 10); }

	//Now ipms will destroy some of the missiles
	//First get the defending power.
	if($db){
		$weapons = doquery("SELECT `".$resource[109]."` FROM {{table}} WHERE `id` = '".$FleetRow['fleet_owner']."' LIMIT 1 ;",'users',true); $weapons = ($weapons[0] / 10);
		$armour = doquery("SELECT `".$resource[110]."` FROM {{table}} WHERE `id` = '".$FleetRow['fleet_taget_owner']."' LIMIT 1 ;",'users',true); $armour = ($armour[0] / 10);
	}else{
		$weapons = $FleetRow['weap']; $armour = $FleetRow['arm'];
	}

	if($missiles >= $CurrentPlanet[$resource[502]]){
		$missiles -= $CurrentPlanet[$resource[502]];
		$return['abm_cost'] = $CurrentPlanet[$resource[502]];
	}else{
		$return['abm_cost'] = $missiles;
		$missiles = 0;
	}
	$CurrentPlanet[$resource[502]] -= $return['abm_cost'];

	//If there are no missiles left, battle over, lets go home
	if($missiles <= 0){
		//there was no battle
		$return['battle'] = 'X';
	}else{
		$attack = ($missiles * $weapons * $CombatCaps[idstring($m[0])]['attack']);
		//Do we have a target
		if(idstring($FleetRow['fleet_targetdef']) < 500 && in_array($FleetRow['fleet_targetdef'],$reslist['defense'])){
			//Get target
			$target = idstring($FleetRow['fleet_targetdef']);
			$return['battle'][1]['target'] = $target;
			$return['battle'][1]['target_count'] = $CurrentPlanet[$resource[$target]];
			//Get defense from target
			$curdefense = $CurrentPlanet[$resource[$target]] * $armour * $hull[$target];
			$return['battle'][1]['target_defense'] = $curdefense;
			$return['battle'][1]['current_ipm_strength'] = $CombatCaps[idstring($m[0])]['attack'];
			$return['battle'][1]['current_attack'] = $attack;
			//Do we destroy is and take damage, or is it only partially destroyed?
			if($attack >= $curdefense){
				$attack -= $curdefense;
				$CurrentPlanet[$resource[$target]] = 0;
				$curdefense = 0;
			}else{
				$CurrentPlanet[$resource[$target]] = ceil(($curdefense - $attack) / $armour);
				$attack = 0;
			}
			$return['battle'][1]['target_new_count'] = $CurrentPlanet[$resource[$target]];
		}
		//Do we still have missiles?
		if($attack > 0){
			//attack left
			$return['battle'][2]['remaining_attack'] = $attack;
			//get total defense
			$d = array();
			foreach($reslist['defense'] as $item){
				if($item < 500 && $CurrentPlanet[$resource[$item]]){
					$d[$item] = $CurrentPlanet[$resource[$item]] * $armour * $hull[$item];
				}
			}
			//Work out current defense
			$curdefense = array_sum($d);
			//return stuff
			$return['battle'][2]['defense'] = $d;
			$return['battle'][2]['defense_total'] = $curdefense;
			//lol it is going to be easy for us?
			if($curdefense <= $attack){
				//yes, lets just kill everything
				foreach($d as $i => $a){
					$CurrentPlanet[$resource[$i]] = 0;
					$d[$i] = 0;
				}
				//Now remove $a and $i from memory
				unset($a,$i);

				//Some info for the return
				$return['battle'][2]['short'] = true;
				$return['battle'][2]['final_defense'] = $d;
			}else{
				//now we need to work out how much is destroyed.
				$percent = ($attack / $curdefense);
				$return['battle'][2]['damage'] = round($percent * 100,2)."%";
				$percent = (1 - $percent);

				//Pick random defenses (or shuffle the array)
				$d = shuffle_array($d); $spare = 0;
				foreach($d as $i => $a){
					// Do the damage
					$d[$i] *= $percent;

					//And also any fire power left from the last target.
					if($d[$i] <= $spare){
						$spare -= $d[$i];
						$d[$i] = 0;
					}else{
						$d[$i] -= $spare;
						$spare = 0;
					}

					// Work out the spare after all the whole destroyed ones are removes
					$spare += $d[$i] % ($armour * $hull[$i]);

					//Now put back the rest... not finished
					$CurrentPlanet[$resource[$i]] = ceil($d[$i] / ($armour * $hull[$i]));
				}
				//Now remove $a and $i from memory
				unset($a,$i);

				//Some info for the return
				$return['battle'][2]['short'] = false;
				$return['battle'][2]['new_defense'] = $d;
				$return['battle'][2]['remaining'] = $spare;

				//Great now we have fired in a random order but we may still have a small bit of firepower left which can be used.
				//We should sort the defense by armour, with the highest elvel first,t hat way all the remaining firepower will be used.
				arsort($hull);
				foreach($hull as $id => $val){
					$remain = ($d[$id] % $val);
					if($remain < $spare){
						$spare -= $remain;
						$d[$id] -= $remain;
						$CurrentPlanet[$resource[$id]]--;
					}
				}
				//Now remove $id and $val from memory
				unset($id,$val);

				//Some info for the return
				$return['battle'][2]['cleaned_defense'] = $d;
				$return['battle'][2]['still_remaining'] = $spare;

				foreach($hull as $id => $val){
					$candestroy = floor($spare / ($armour * $val));
					if($CurrentPlanet[$resource[$id]] < $candestroy){
						$candestroy = $CurrentPlanet[$resource[$id]];
					}
					$CurrentPlanet[$resource[$id]] -= $candestroy;
					$spare -= ($armour * $val * $candestroy);
					//now set $d to the remaining defenses
					if($CurrentPlanet[$resource[$id]]){ $d[$id] = $CurrentPlanet[$resource[$id]]; }else{ unset($d[$id]); }
				}
				//Now remove $id and $val from memory
				unset($id,$val);

				//Some info for the return
				$return['battle'][2]['final_defense'] = $d;
				$return['battle'][2]['wasted_power'] = $spare;
			}
		}
	}
	if($db){
		//Now lets do the changes.
		$qry = "UPDATE {{table}} SET ";
		foreach($reslist['defense'] as $i){
			if($resource[$i]){
				$qry .= "`".$resource[$i]."` = '".$CurrentPlanet[$resource[$i]]."', ";
			}
		}
		$qry = substr_replace($qry,'',-2,-1)."WHERE `id` = '".$CurrentPlanet['id']."' LIMIT 1 ;";
		doquery($qry,'planets');
		doquery("DELETE FROM {{table}} WHERE `fleet_id` = '".$FleetRow['fleet_id']."' LIMIT 1 ;",'fleets',false,true,true);
		return $return;
	}else{
		//Return planet state for the sim.
		//echo "<pre>";
		//print_r($return);
		//echo "</pre>";
		return $CurrentPlanet;
	}
}

/*
function idstring($n){
	return intval($n);
}
define("INSIDE",true);
require("../vars.php");
$FleetRow = array(
	'fleet_array' => '503,'.idstring($_GET['ipms']),
	'fleet_targetdef' => 402,
	'weap' => 1,
	'arm' => 1,
);
$CurrentPlanet = array(
	$resource[401] => 50,
	$resource[402] => 50,
	$resource[403] => 50,
	$resource[404] => 50,
	$resource[405] => 50,
	$resource[406] => 50,
	$resource[407] => 1,
	$resource[408] => 1,
	$resource[502] => 5,
);

$NewPlanet = MissileAttack($FleetRow,$CurrentPlanet,false);

echo "<pre>";
print_r($CurrentPlanet);
echo "\n";
print_r($NewPlanet);
echo "</pre>";

foreach($CurrentPlanet as $res => $id){
	
}
*/
?>