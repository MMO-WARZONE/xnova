<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** jumpgate.php                          **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

function DoFleetJump ( $CurrentUser, $CurrentPlanet ) {
	global $lang, $resource;

	includeLang ('infos');

	if ($_POST) {
		$RestString   = GetNextJumpWaitTime ( $CurrentPlanet );
		$NextJumpTime = $RestString['value'];
		$JumpTime     = time();
		if ( $NextJumpTime == 0 ) {
			$TargetPlanet = $_POST['jmpto'];
			$TargetGate   = doquery ( "SELECT `id`, `sprungtor`, `last_jump_time` FROM {{table}} WHERE `id` = '". $TargetPlanet ."';", 'planets', true);
			if ($TargetGate['sprungtor'] > 0) {
				$RestString   = GetNextJumpWaitTime ( $TargetGate );
				$NextDestTime = $RestString['value'];

				if ( $NextDestTime == 0 ) {
					$ShipArray   = array();
					$SubQueryOri = "";
					$SubQueryDes = "";
					for ( $Ship = 200; $Ship < 300; $Ship++ ) {
						$ShipLabel = "c". $Ship;
						if ( $_POST[ $ShipLabel ] > $CurrentPlanet[ $resource[ $Ship ] ] ) {
							$ShipArray[ $Ship ] = $CurrentPlanet[ $resource[ $Ship ] ];
						} else {
							$ShipArray[ $Ship ] = $_POST[ $ShipLabel ];
						}
						if ($ShipArray[ $Ship ] <> 0) {
							$SubQueryOri .= "`". $resource[ $Ship ] ."` = `". $resource[ $Ship ] ."` - '". $ShipArray[ $Ship ] ."', ";
							$SubQueryDes .= "`". $resource[ $Ship ] ."` = `". $resource[ $Ship ] ."` + '". $ShipArray[ $Ship ] ."', ";
						}
					}

					if ($SubQueryOri != "") {
						$QryUpdateOri  = "UPDATE {{table}} SET ";
						$QryUpdateOri .= $SubQueryOri;
						$QryUpdateOri .= "`last_jump_time` = '". $JumpTime ."' ";
						$QryUpdateOri .= "WHERE ";
						$QryUpdateOri .= "`id` = '". $CurrentPlanet['id'] ."';";
						doquery ( $QryUpdateOri, 'planets');

						$QryUpdateDes  = "UPDATE {{table}} SET ";
						$QryUpdateDes .= $SubQueryDes;
						$QryUpdateDes .= "`last_jump_time` = '". $JumpTime ."' ";
						$QryUpdateDes .= "WHERE ";
						$QryUpdateDes .= "`id` = '". $TargetGate['id'] ."';";
						doquery ( $QryUpdateDes, 'planets');

						$QryUpdateUsr  = "UPDATE {{table}} SET ";
						$QryUpdateUsr .= "`current_planet` = '". $TargetGate['id'] ."' ";
						$QryUpdateUsr .= "WHERE ";
						$QryUpdateUsr .= "`id` = '". $CurrentUser['id'] ."';";
						doquery ( $QryUpdateUsr, 'users');

						$CurrentPlanet['last_jump_time'] = $JumpTime;
						$RestString    = GetNextJumpWaitTime ( $CurrentPlanet );
						$RetMessage    = $lang['gate_jump_done'] ." - ". $RestString['string'];
					} else {
						$RetMessage = $lang['gate_wait_data'];
					}
				} else {
					$RetMessage = $lang['gate_wait_dest'] ." - ". $RestString['string'];
				}
			} else {
				$RetMessage = $lang['gate_no_dest_g'];
			}
		} else {
			$RetMessage = $lang['gate_wait_star'] ." - ". $RestString['string'];
		}
	} else {
		$RetMessage = $lang['gate_wait_data'];
	}

	return $RetMessage;
}

	$Message = DoFleetJump($user, $planetrow);
	message ($Message, $lang['tech'][43], "infos.php?gid=43", 4);

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>