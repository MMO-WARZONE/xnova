<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** ShowBuildingQueue.php                 **
******************************************/

function ShowBuildingQueue ( $CurrentPlanet, $CurrentUser ) {
	global $lang;

	$CurrentQueue  = $CurrentPlanet['b_building_id'];
	$QueueID       = 0;
	if ($CurrentQueue != 0) {
		$QueueArray    = explode ( ";", $CurrentQueue );
		$ActualCount   = count ( $QueueArray );
	} else {
		$QueueArray    = "0";
		$ActualCount   = 0;
	}

	$ListIDRow    = "";
	if ($ActualCount != 0) {
		$PlanetID     = $CurrentPlanet['id'];
		for ($QueueID = 0; $QueueID < $ActualCount; $QueueID++) {
			$BuildArray   = explode (",", $QueueArray[$QueueID]);
			$BuildEndTime = floor($BuildArray[3]);
			$CurrentTime  = floor(time());
			if ($BuildEndTime >= $CurrentTime) {
				$ListID       = $QueueID + 1;
				$Element      = $BuildArray[0];
				$BuildLevel   = $BuildArray[1];
				$BuildMode    = $BuildArray[4];
				$BuildTime    = $BuildEndTime - time();
				$ElementTitle = $lang['tech'][$Element];

				if ($ListID > 0) {
					$ListIDRow .= "<tr>";
					if ($BuildMode == 'build') {
						$ListIDRow .= "	<td class=\"k\" colspan=\"2\">". $ListID .".: ". $ElementTitle ." ". $BuildLevel ."</td>";
					} else {
						$ListIDRow .= "	<td class=\"k\" colspan=\"2\">". $ListID .".: ". $ElementTitle ." ". $BuildLevel ." ". $lang['destroy'] ."</td>";
					}
					$ListIDRow .= "	<td class=\"k\">";
					if ($ListID == 1) {
						$ListIDRow .= "		<div id=\"blc\" class=\"z\">". $BuildTime ."<br>";
						$ListIDRow .= "		<a href=\"buildings.php?listid=". $ListID ."&amp;cmd=cancel&amp;planet=". $PlanetID ."\">". $lang['DelFirstQueue'] ."</a></div>";
						$ListIDRow .= "		<script language=\"JavaScript\">";
						$ListIDRow .= "			pp = \"". $BuildTime ."\";\n";      
						$ListIDRow .= "			pk = \"". $ListID ."\";\n";         
						$ListIDRow .= "			pm = \"cancel\";\n";                
						$ListIDRow .= "			pl = \"". $PlanetID ."\";\n";       
						$ListIDRow .= "			t();\n";
						$ListIDRow .= "		</script>";
						$ListIDRow .= "		<strong color=\"lime\"><br><font color=\"lime\">". date("j/m H:i:s" ,$BuildEndTime) ."</font></strong>";
					} else {
						$ListIDRow .= "		<font color=\"red\">";
						$ListIDRow .= "		<a href=\"buildings.php?listid=". $ListID ."&amp;cmd=remove&amp;planet=". $PlanetID ."\">". $lang['DelFromQueue'] ."</a></font>";
					}
					$ListIDRow .= "	</td>";
					$ListIDRow .= "</tr>";
				}
			}
		}
	}

	$RetValue['lenght']    = $ActualCount;
	$RetValue['buildlist'] = $ListIDRow;

	return $RetValue;
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/ 

?>