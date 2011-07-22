<?php

/**
 _  \_/ |\ | /¯¯\ \  / /\    |¯¯) |_¯ \  / /¯¯\ |  |   |´¯|¯` | /¯¯\ |\ |5
 ¯  /¯\ | \| \__/  \/ /--\   |¯¯\ |__  \/  \__/ |__ \_/   |   | \__/ | \|Core.
 * @author: Copyright (C) 2011 by Brayan Narvaez (Prinick) developer of xNova Revolution
 * @link: http://www.xnovarevolution.con.ar

 * @package 2Moons
 * @author Slaver <slaver7@gmail.com>
 * @copyright 2009 Lucky <douglas@crockford.com> (XGProyecto)
 * @copyright 2011 Slaver <slaver7@gmail.com> (Fork/2Moons)
 * @license http://www.gnu.org/licenses/gpl.html GNU GPLv3 License
 * @version 1.3 (2011-01-21)
 * @link http://code.google.com/p/2moons/

 * Please do not remove the credits
*/

class MissionCaseRecycling extends MissionFunctions
{
	function __construct($Fleet)
	{
		$this->_fleet	= $Fleet;
	}
	
	function TargetEvent()
	{	
		global $db, $pricelist, $LANG;
		$Target				 = $db->uniquequery("SELECT der_metal, der_crystal, der_norio, (der_metal + der_crystal + der_norio) as der_total FROM ".PLANETS." WHERE `id` = '".$this->_fleet['fleet_end_id']."';");
		$FleetRecord         = explode(";", $this->_fleet['fleet_array']);
		$RecyclerCapacity    = 0;
		$OtherFleetCapacity  = 0;
		foreach ($FleetRecord as $Item => $Group)
		{
			if (empty($Group))
				continue;
				
			$Class        = explode (",", $Group);
			if ($Class[0] == 209 || $Class[0] == 219)
				$RecyclerCapacity   += $pricelist[$Class[0]]['capacity'] * $Class[1];
			else
				$OtherFleetCapacity += $pricelist[$Class[0]]['capacity'] * $Class[1];
		}
		$RecycledGoods	= array('metal' => 0, 'crystal' => 0, 'norio' => 0);
		$IncomingFleetGoods = $FleetRow['fleet_resource_metal'] + $FleetRow['fleet_resource_crystal'] + $FleetRow['fleet_resource_deuterium'] + $FleetRow['fleet_resource_norio'];
		if ($IncomingFleetGoods > $OtherFleetCapacity)
			$RecyclerCapacity -= ($IncomingFleetGoods - $OtherFleetCapacity);

		if ($Target['der_total'] <= $RecyclerCapacity) {
			$RecycledGoods['metal']   = $Target['der_metal'];
			$RecycledGoods['crystal'] = $Target['der_crystal'];
			$RecycledGoods['norio'] = $Target['der_norio'];
		} elseif (($Target['der_metal'] > $RecyclerCapacity / 2) && ($Target['der_crystal'] > $RecyclerCapacity / 2) && ($Target['der_norio'] > $RecyclerCapacity / 2)) {
			$RecycledGoods['metal']   = $RecyclerCapacity / 2;
			$RecycledGoods['crystal'] = $RecyclerCapacity / 2;
			$RecycledGoods['norio'] = $RecyclerCapacity / 2;
		} elseif (($Target['der_metal'] > $Target['der_crystal']) or ($Target['der_metal'] > $Target['der_norio'])) {
			$RecycledGoods['crystal'] = $Target['der_crystal'];
			$RecycledGoods['norio'] = $Target['der_norio'];
			if ($Target['der_metal'] > ($RecyclerCapacity - $RecycledGoods['crystal']) or ($RecyclerCapacity - $RecycledGoods['norio']))
				$RecycledGoods['metal'] = $RecyclerCapacity - $RecycledGoods['crystal'];
				$RecycledGoods['metal'] = $RecyclerCapacity - $RecycledGoods['norio'];
			else
				$RecycledGoods['metal'] = $Target['der_metal'];
		}  elseif (($Target['der_crystal'] > $Target['der_metal']) or ($Target['der_crystal'] > $Target['der_norio'])) {
			$RecycledGoods['metal'] = $Target['der_metal'];
			$RecycledGoods['norio'] = $Target['der_norio'];
			if ($Target['der_crystal'] > ($RecyclerCapacity - $RecycledGoods['metal']) or ($RecyclerCapacity - $RecycledGoods['norio']))
				$RecycledGoods['crystal'] = $RecyclerCapacity - $RecycledGoods['metal'];
				$RecycledGoods['crystal'] = $RecyclerCapacity - $RecycledGoods['norio'];
			else
				$RecycledGoods['crystal'] = $Target['der_crystal'];
		}  elseif (($Target['der_norio'] > $Target['der_metal']) or ($Target['der_norio'] > $Target['der_crystal'])) {
			$RecycledGoods['metal'] = $Target['der_metal'];
			$RecycledGoods['crystal'] = $Target['der_crystal'];
			if ($Target['der_norio'] > ($RecyclerCapacity - $RecycledGoods['metal']) or ($RecyclerCapacity - $RecycledGoods['crystal']))
				$RecycledGoods['norio'] = $RecyclerCapacity - $RecycledGoods['metal'];
				$RecycledGoods['norio'] = $RecyclerCapacity - $RecycledGoods['crystal'];
			else
				$RecycledGoods['norio'] = $Target['der_norio'];
		} 
		
		$db->query("UPDATE ".PLANETS." SET `der_metal` = `der_metal` - ".$RecycledGoods['metal'].", `der_crystal` = `der_crystal` - ".$RecycledGoods['crystal'].", `der_norio` = `der_norio` - ".$RecycledGoods['norio']." WHERE `id` = '".$this->_fleet['fleet_end_id']."';");

		$LNG			= $LANG->GetUserLang($this->_fleet['fleet_owner']);
		$Message 		= sprintf($LNG['sys_recy_gotten'], pretty_number($RecycledGoods['metal']), $LNG['Metal'], pretty_number($RecycledGoods['crystal']), $LNG['Crystal'], pretty_number($RecycledGoods['norio']), $LNG['Norio']);
		SendSimpleMessage($this->_fleet['fleet_owner'], '', $this->_fleet['fleet_start_time'], 4, $LNG['sys_mess_tower'], $LNG['sys_recy_report'], $Message);
		
		$this->UpdateFleet('fleet_resource_metal', bcadd($this->_fleet['fleet_resource_metal'], $RecycledGoods['metal']));
		$this->UpdateFleet('fleet_resource_crystal', bcadd($this->_fleet['fleet_resource_crystal'], $RecycledGoods['crystal']));
		$this->UpdateFleet('fleet_resource_norio', bcadd($this->_fleet['fleet_resource_norio'], $RecycledGoods['norio']));
		$this->UpdateFleet('fleet_mess', 1);
		$this->SaveFleet();
	}
	
	function EndStayEvent()
	{
		return;
	}
	
	function ReturnEvent()
	{
		global $LANG;
		$LNG				= $LANG->GetUserLang($this->_fleet['fleet_owner']);
	
		$Message         = sprintf( $LNG['sys_tran_mess_owner'], $TargetName, GetStartAdressLink($this->_fleet, ''), pretty_number($this->_fleet['fleet_resource_metal']), $LNG['Metal'], pretty_number($this->_fleet['fleet_resource_crystal']), $LNG['Crystal'], pretty_number($this->_fleet['fleet_resource_deuterium']), $LNG['Deuterium'], pretty_number($this->_fleet['fleet_resource_norio']), $LNG['Norio'] );
		SendSimpleMessage($this->_fleet['fleet_owner'], '', $this->_fleet['fleet_end_time'], 4, $LNG['sys_mess_tower'], $LNG['sys_mess_fleetback'], $Message);

		$this->RestoreFleet();
	}
}
?>