<?php
//version 1
if (!defined('INSIDE')){die("Intento de hackeo");}

class ShowDojump
{
    
    private function GetNextJumpWaitTime($CurMoon)
	{
		global $resource;

		$JumpGateLevel  = $CurMoon[$resource[43]];
		$LastJumpTime   = $CurMoon['last_jump_time'];
		if ($JumpGateLevel > 0)
		{
			$WaitBetweenJmp = (60 * 60) * (1 / $JumpGateLevel);
			$NextJumpTime   = $LastJumpTime + $WaitBetweenJmp;
			if ($NextJumpTime >= time())
			{
				$RestWait   = $NextJumpTime - time();
				$RestString = " ". pretty_time($RestWait);
			}
			else
			{
				$RestWait   = 0;
				$RestString = "";
			}
		}
		else
		{
			$RestWait   = 0;
			$RestString = "";
		}
		$RetValue['string'] = $RestString;
		$RetValue['value']  = $RestWait;

		return $RetValue;
	}

	private function DoFleetJump ($CurrentUser, $CurrentPlanet)
	{
		global $resource, $lang,$reslist,$db;

		if ($_POST)
		{
			$RestString   = $this->GetNextJumpWaitTime ($CurrentPlanet);
			$NextJumpTime = $RestString['value'];
			$JumpTime     = time();

			if ( $NextJumpTime == 0 )
			{
				$TargetPlanet = mysql_escape_string($_POST['jmpto']);
				$TargetGate   = $db->query ( "SELECT `id`, `sprungtor`, `last_jump_time` FROM {{table}} WHERE `id` = '". $TargetPlanet ."';", 'planets', true);

				if ($TargetGate['sprungtor'] > 0)
				{
					$RestString   = $this->GetNextJumpWaitTime ( $TargetGate );
					$NextDestTime = $RestString['value'];

					if ( $NextDestTime == 0 )
					{
						$ShipArray   = array();
						$SubQueryOri = "";
						$SubQueryDes = "";
	
                                                foreach ($resource as $ship)
                                                {
							$ShipLabel = "c". $Ship;

							if ( $_POST[ $ShipLabel ] > $CurrentPlanet[ $resource[ $Ship ] ] )
							{
								$ShipArray[ $Ship ] = $CurrentPlanet[ $resource[ $Ship ] ];
							}
							else
							{
								$ShipArray[ $Ship ] = intval($_POST[ $ShipLabel ]);
							}

							if ($ShipArray[ $Ship ] <> 0)
							{
								$SubQueryOri .= "`". $resource[ $Ship ] ."` = `". $resource[ $Ship ] ."` - '". $ShipArray[ $Ship ] ."', ";
								$SubQueryDes .= "`". $resource[ $Ship ] ."` = `". $resource[ $Ship ] ."` + '". $ShipArray[ $Ship ] ."', ";
							}
						}

						if ($SubQueryOri != "")
						{
							$QryUpdateOri  = "UPDATE {{table}} SET ";
							$QryUpdateOri .= $SubQueryOri;
							$QryUpdateOri .= "`last_jump_time` = '". $JumpTime ."' ";
							$QryUpdateOri .= "WHERE ";
							$QryUpdateOri .= "`id` = '". $CurrentPlanet['id'] ."';";
							$db->query ( $QryUpdateOri, 'planets');

							$QryUpdateDes  = "UPDATE {{table}} SET ";
							$QryUpdateDes .= $SubQueryDes;
							$QryUpdateDes .= "`last_jump_time` = '". $JumpTime ."' ";
							$QryUpdateDes .= "WHERE ";
							$QryUpdateDes .= "`id` = '". $TargetGate['id'] ."';";
							$db->query ( $QryUpdateDes, 'planets');

							$QryUpdateUsr  = "UPDATE {{table}} SET ";
							$QryUpdateUsr .= "`current_planet` = '". $TargetGate['id'] ."' ";
							$QryUpdateUsr .= "WHERE ";
							$QryUpdateUsr .= "`id` = '". $CurrentUser['id'] ."';";
							$db->query ( $QryUpdateUsr, 'users');

							$CurrentPlanet['last_jump_time'] = $JumpTime;
							$RestString    = $this->GetNextJumpWaitTime ( $CurrentPlanet );
							$RetMessage    = $lang['in_jump_gate_done'] . $RestString['string'];
						}
						else
						{
							$RetMessage = $lang['in_jump_gate_error_data'];
						}
					}
					else
					{
						$RetMessage = $lang['in_jump_gate_not_ready_target'] . $RestString['string'];
					}
				}
				else
				{
					$RetMessage = $lang['in_jump_gate_doesnt_have_one'];
				}
			}
			else
			{
				$RetMessage = $lang['in_jump_gate_already_used'] . $RestString['string'];
			}
		}
		else
		{
			$RetMessage = $lang['in_jump_gate_error_data'];
		}

		return $RetMessage;
            
	}
        
        public function ShowDoJumpgate($CurrentUser,$CurrentPlanet){
            global $displays;
            $displays->message($this->DoFleetJump($CurrentUser, $CurrentPlanet), "game.php?page=infos&gid=43", 2);
        }
    
}



?>