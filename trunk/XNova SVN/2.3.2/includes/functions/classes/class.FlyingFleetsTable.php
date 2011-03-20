<?php
//version 1


if(!defined('INSIDE')){ die(header("location:../../"));}

class FlyingFleetsTable
{
	private function CreateFleetPopupedMissionLink($FleetRow, $Texte, $FleetType)
	{
		global $lang;

		$FleetTotalC  = $FleetRow['fleet_resource_metal'] + $FleetRow['fleet_resource_crystal'] + $FleetRow['fleet_resource_deuterium'];
		if ($FleetTotalC >= 0)
		{
			$FRessource   = "<table width=200>";
			$FRessource  .= "<tr><td width=50% align=left><font color=white>".$lang['Metal']."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_metal']) ."<font></td></tr>";
			$FRessource  .= "<tr><td width=50% align=left><font color=white>".$lang['Crystal']."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_crystal']) ."<font></td></tr>";
			$FRessource  .= "<tr><td width=50% align=left><font color=white>".$lang['Deuterium']."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_deuterium']) ."<font></td></tr>";
			if($FleetRow['fleet_resource_darkmatter'] > 0){
				$FRessource  .= "<tr><td width=50% align=left><font color=white>".$lang['Darkmatter']."<font></td><td width=50% align=right><font color=white>". pretty_number($FleetRow['fleet_resource_darkmatter']) ."<font></td></tr>";
			}
			$FRessource  .= "</table>";
		}
		else
		{
			$FRessource   = "";
		}

		if ($FRessource <> "")
		{
			$MissionPopup  = "<a href='#' onmouseover=\"return overlib('". $FRessource ."');";
			$MissionPopup .= "\" onmouseout=\"return nd();\" class=\"". $FleetType ."\">" . $Texte ."</a>";
		}
		else{
			$MissionPopup  = $Texte ."";
		}

		return $MissionPopup;
	}

	private function CreateFleetPopupedFleetLink($FleetRow, $Texte, $FleetType)
	{
		global $lang;

		
		$FleetRec     = explode(";", $FleetRow['fleet_array']);
		$FleetPopup   = "<a href='#' onmouseover=\"return overlib('";
		$FleetPopup  .= "<table width=200>";
		foreach($FleetRec as $Item => $Group) {
			if ($Group  != '') {
				$Ship    = explode(",", $Group);
				$FleetPopup .= "<tr><td width=50% align=left><font color=white>". $lang['tech'][$Ship[0]] .":<font></td><td width=50% align=right><font color=white>". pretty_number($Ship[1]) ."<font></td></tr>";
			}
		}
		$FleetPopup  .= "</table>";
		$FleetPopup  .= "');\" onmouseout=\"return nd();\" class=\"". $FleetType ."\">". $Texte ."</a>";
	
		return $FleetPopup;
	}

	private function BuildHostileFleetPlayerLink($FleetRow)
	{
		global $lang, $dpath,$db;

		$PlayerName  = $db->query ("SELECT `username` FROM {{table}} WHERE `id` = '". $FleetRow['fleet_owner']."';", 'users', true);
		$Link  		 = $PlayerName['username']. " ";
		$Link 		.= "<a href='#' onclick=\"new_mensaje('".$PlayerName['username']."','".$FleetRow['fleet_owner']."','Sin Asunto','')\" >";
		$Link 		.= "<img src=\"".$dpath."/img/m.gif\" title=\"".$lang['write_message']."\" border=\"0\"></a>";

		return $Link;
	}

	// For ShowFlyingFleets.php in admin panel.
	public function BuildFlyingFleetTable () {
	global $lang,$db;


	
	$FlyingFleets = $db->query ("SELECT f.*,
                    uc.username as username1 ,
                    ut.username as username2 
	FROM 
	{{table}}fleets as f
	INNER JOIN {{table}}users as uc	ON uc.id=f.fleet_owner
	INNER JOIN {{table}}users as ut	ON ut.id=f.fleet_owner
	ORDER BY f.fleet_end_time ASC;", '');
$i=0;
	while ($CurrentFleet = mysql_fetch_assoc($FlyingFleets) ) {
		
		$Bloc['Id']       = $CurrentFleet['fleet_id'];
		$Bloc['Fleet']    = $this->CreateFleetPopupedFleetLink ( $CurrentFleet, $lang['tech'][200], '' );
		
		$materiales=array('fleet_resource_metal'=>$CurrentFleet['fleet_resource_metal'],
				  'fleet_resource_crystal'=>$CurrentFleet['fleet_resource_crystal'],
				  'fleet_resource_deuterium'=>$CurrentFleet['fleet_resource_deuterium'],
				  'fleet_resource_darkmatter'=>$CurrentFleet['fleet_resource_darkmatter']);
		
		$Bloc['Mission']  = $this->CreateFleetPopupedMissionLink ($materiales, $lang['type_mission'][ $CurrentFleet['fleet_mission'] ], '' );
		
		$Bloc['Mission'] .= "<br>". (($CurrentFleet['fleet_mess'] == 1) ? "R" : "A" );
		$Bloc['St_Owner'] = "[". $CurrentFleet['fleet_owner'] ."]<br>". $CurrentFleet['username1'];
		$Bloc['St_Posit'] = "[".$CurrentFleet['fleet_start_galaxy'] .":". $CurrentFleet['fleet_start_system'] .":". $CurrentFleet['fleet_start_planet'] ."]<br>". ( ($CurrentFleet['fleet_start_type'] == 1) ? "[P]": (($CurrentFleet['fleet_start_type'] == 2) ? "D" : "L"  )) ."";
		$Bloc['St_Time']  = date('G:i:s d/n/Y', $CurrentFleet['fleet_start_time']);
		if (is_array($CurrentFleet) && $CurrentFleet['fleet_mission'] != 15) {
			$Bloc['En_Owner'] = "[". $CurrentFleet['fleet_target_owner'] ."]<br>". $CurrentFleet['username2'];
		} else {
			$Bloc['En_Owner'] = "Expedición";
		}
		$Bloc['En_Posit'] = "[".$CurrentFleet['fleet_end_galaxy'] .":". $CurrentFleet['fleet_end_system'] .":". $CurrentFleet['fleet_end_planet'] ."]<br>". ( ($CurrentFleet['fleet_end_type'] == 1) ? "[P]": (($CurrentFleet['fleet_end_type'] == 2) ? "D" : "L"  )) ."";
		if ($CurrentFleet['fleet_mission'] == 15) {
			$Bloc['Wa_Time']  = date('G:i:s d/n/Y', $CurrentFleet['fleet_stay_time']);
		} else {
			$Bloc['Wa_Time']  = "";
		}
		$Bloc['En_Time']  = date('G:i:s d/n/Y', $CurrentFleet['fleet_end_time']);

	$i++;
		$table['flt_table'] .= parsetemplate(gettemplate('adm/fleet_rows'), $Bloc );
	}
        
		$table['num']=$i;
	return $table;
	}

	//For overview and phalanx
	public function BuildFleetEventTable($FleetRow, $Status, $Owner, $Label, $Record)
	{
		global $lang,$db;

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

		if ( $Owner == true )
			$FleetPrefix = 'own';
		else
			$FleetPrefix = '';


                $RowsTPL        = gettemplate ('overview/overview_fleet_event');
		$MissionType    = $FleetRow['fleet_mission'];
		$FleetContent   = $this->CreateFleetPopupedFleetLink ( $FleetRow, "flotas", $FleetPrefix . $FleetStyle[ $MissionType ] );
		$FleetCapacity  = $this->CreateFleetPopupedMissionLink ( $FleetRow, $lang['type_mission'][ $MissionType ], $FleetPrefix . $FleetStyle[ $MissionType ] );
		$query=$db->query("SELECT p.name as startplanet, p1.name as endplanet FROM
                    {{table}}planets as p,{{table}}planets as p1 WHERE (
                        p1.galaxy = '".$FleetRow['fleet_end_galaxy']."' 
                        AND p1.system = '".$FleetRow['fleet_end_system']."' 
                        AND p1.planet = '".$FleetRow['fleet_end_planet']."' 
                        AND p1.planet_type = '".$FleetRow['fleet_end_type']."'
                    
                    ) AND ( p.galaxy = '".$FleetRow['fleet_start_galaxy']."'
                        AND p.system = '".$FleetRow['fleet_start_system']."' 
                        AND p.planet = '".$FleetRow['fleet_start_planet']."' 
                        AND p.planet_type = '".$FleetRow['fleet_start_type']."');", '', true);

		$StartPlanet    = $query["startplanet"];

		$StartType      = $FleetRow['fleet_start_type'];
		$TargetPlanet   = $query["endplanet"];
		$TargetType     = $FleetRow['fleet_end_type'];

		if ($Status != 2)
		{
			if ($StartType == 1)
				$StartID  = $lang['cff_from_the_planet'];
			elseif ($StartType == 3)
				$StartID  = $lang['cff_from_the_moon'];

			$StartID .= $StartPlanet ." ";
			$StartID .= GetStartAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );

			if ($MissionType != 15)
			{
				if ($TargetType == 1)
					$TargetID  = $lang['cff_the_planet'];
				elseif ($TargetType == 2)
					$TargetID  = $lang['cff_debris_field'];
				elseif ($TargetType == 3)
					$TargetID  = $lang['cff_to_the_moon'];
			}
			else
				$TargetID  = $lang['cff_the_position'];

			$TargetID .= $TargetPlanet ." ";
			$TargetID .= GetTargetAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );
		}
		else
		{
			if($StartType == 1)
				$StartID  = $lang['cff_to_the_planet'];
			elseif ($StartType == 3)
				$StartID  = $lang['cff_the_moon'];

			$StartID .= $StartPlanet ." ";
			$StartID .= GetStartAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );

			if ( $MissionType != 15 )
			{
				if($TargetType == 1)
					$TargetID  = $lang['cff_from_planet'];
				elseif ($TargetType == 2)
					$TargetID  = $lang['cff_from_debris_field'];
				elseif ($TargetType == 3)
					$TargetID  = $lang['cff_from_the_moon'];
			}
			else
				$TargetID  = $lang['cff_from_position'];

			$TargetID .= $TargetPlanet ." ";
			$TargetID .= GetTargetAdressLink ( $FleetRow, $FleetPrefix . $FleetStyle[ $MissionType ] );
		}

		if ($MissionType == 10)
		{
                    //REVISAR SIGUIENTE LINEA
			$EventString  = $lang['cff_missile_attack']." ( ".preg_replace("(503,)","",$FleetRow["fleet_array"])." ) ";
			$Time         = $FleetRow['fleet_start_time'];
			$Rest         = $Time - time();
			$EventString .= $lang['cff_from'];
			$EventString .= $StartID;
			$EventString .= $lang['cff_to'];
			$EventString .= $TargetID;
			$EventString .= ".";
		}
		else
		{
			if ($Owner == true)
			{
				$EventString  = $lang['cff_one_of_your'];
				$EventString .= $FleetContent;
			}
			else
			{
				$EventString  = $lang['cff_a'];
				$EventString .= $FleetContent;
				$EventString .= $lang['cff_of'];
				$EventString .= $this->BuildHostileFleetPlayerLink ( $FleetRow );
			}

			if ($Status == 0)
			{
				$Time         = $FleetRow['fleet_start_time'];
				$Rest         = $Time - time();
				$EventString .= $lang['cff_goes'];
				$EventString .= $StartID;
				$EventString .= $lang['cff_toward'];
				$EventString .= $TargetID;
				$EventString .= $lang['cff_with_the_mission_of'];
			}
			elseif ($Status == 1)
			{
				$Time         = $FleetRow['fleet_end_stay'];
				$Rest         = $Time - time();
				$EventString .= $lang['cff_goes'];
				$EventString .= $StartID;
				$EventString .= $lang['cff_to_explore'];
				$EventString .= $TargetID;
				$EventString .= $lang['cff_with_the_mission_of'];
			}
			elseif ($Status == 2)
			{
				$Time         = $FleetRow['fleet_end_time'];
				$Rest         = $Time - time();
				$EventString .= $lang['cff_comming_back'];
				$EventString .= $TargetID;
				$EventString .= $StartID;
				$EventString .= $lang['cff_with_the_mission_of'];
			}
			$EventString .= $FleetCapacity;
		}

		$bloc['fleet_status'] = $FleetStatus[ $Status ];
		$bloc['fleet_prefix'] = $FleetPrefix;
		$bloc['fleet_style']  = $FleetStyle[ $MissionType ];
		$bloc['fleet_javai']  = InsertJavaScriptChronoApplet ( $Label, $Record, $Rest, true );
		$bloc['fleet_order']  = $Label . $Record;
		$bloc['fleet_descr']  = $EventString;
		$bloc['fleet_javas']  = InsertJavaScriptChronoApplet ( $Label, $Record, $Rest, false );

		return parsetemplate($RowsTPL, $bloc);
	}
}
?>