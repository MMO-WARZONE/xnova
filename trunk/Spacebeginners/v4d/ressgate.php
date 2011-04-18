<?php

/**
  * ressgate.php
  * @Licence GNU (GPL)
  * @version 1.0
  * @copyright 2010
  * @Team Space Beginner
  *
  **/

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

function DoRessBeam ( $CurrentUser, $CurrentPlanet ) {
	global $lang, $resource;

	includeLang ('infos');

	if ($_POST) {
		$RestString   = GetNextJumpWaitTimePlanet ( $CurrentPlanet );
		$NextJumpTime = $RestString['value'];
		$JumpTime     = time();
		// Dit monsieur, j'ai le droit de sauter ???
		if ( $NextJumpTime == 0 ) {
			// Dit monsieur, ou je veux aller ca existe ???
			$TargetPlanet = $_POST['jmpto'];
			$TargetGate   = doquery ( "SELECT `id`, `ressgate`, `last_beam_time` FROM {{table}} WHERE `id` = '". $TargetPlanet ."';", 'planets', true);
			// Dit monsieur, ou je veux aller y a une porte de saut ???
			if ($TargetGate['ressgate'] > 0) {
				$RestString   = GetNextJumpWaitTimePlanet ( $TargetGate );
				$NextDestTime = $RestString['value'];
				// Dit monsieur, chez toi aussi peut y avoir un saut ???
			    if ( $NextDestTime == 0 ) {
                //Recourcenüberprüfung ob nur ganze Zahl
	               $metal   = 0;
	               $crystal = 0;
	               $deut  = 0;
		           $appol = 0;
				
	               $metal    = $_POST['res1'];

	               $crystal  = $_POST['res2'];

	               $deut     = $_POST['res3'];

      	           $appol    = $_POST['res4'];
				   

		
                   if  (!ctype_digit ($metal)){
                   message ($lang['no_er_ress'] );		
	               }else{
	                round($_POST['res1']);
	               }
   	               if  (!ctype_digit ($crystal)){
                   message ($lang['no_er_ress'] );
	               }else{
	               round($_POST['res2']);
	               }
                   if  (!ctype_digit ($deut)){
                   message ($lang['no_er_ress'] );
	               }else{
	               round($_POST['res3']);
                   }
	               if  (!ctype_digit ($appol)){
                   message ($lang['no_er_ress'] );
	               }else{
	               round($_POST['res4']);
                   }
                   //Überprüfung Ende
				   		// Planeten aktualisieren und erneut auslesen

		               If ($_POST['res1'] > $CurrentPlanet['metal']){
					       message ($lang['nfo_ress_emty_m'] );
						   }
		               If ($_POST['res2'] > $CurrentPlanet['crystal']){
					       message ($lang['nfo_ress_emty_c'] );
						   }			            
		               If ($_POST['res3'] > $CurrentPlanet['deuterium']){
					       message ($lang['nfo_ress_emty_d'] );
						   }						
		               If ($_POST['res4'] > $CurrentPlanet['appolonium']){
					       message ($lang['nfo_ress_emty_a'] );
						   }					
					 // Dit monsieur, y avait quelque chose a envoyer ???
					if ($_POST['res1'] != 0 or $_POST['res2'] != 0  or $_POST['res3'] != 0  or $_POST['res4'] != 0 ) {
						// Abziehen vom Ausgangsplaneten !
						$QryUpdateOri  = "UPDATE {{table}} SET ";
						$QryUpdateOri .= "`metal` = `metal` - '". $metal ."', ";
						$QryUpdateOri .= "`crystal` = `crystal` - '". $crystal ."', ";
						$QryUpdateOri .= "`deuterium` = `deuterium` - '". $deut ."', ";
						$QryUpdateOri .= "`appolonium` = `appolonium` - '". $appol ."', ";
						$QryUpdateOri .= "`last_beam_time` = '". $JumpTime ."' ";
						$QryUpdateOri .= "WHERE ";
						$QryUpdateOri .= "`id` = '". $CurrentPlanet['id'] ."';";
						doquery ( $QryUpdateOri, 'planets');

						// Hinzurechnen zum anderen Planeten !
						$QryUpdateDes  =  "UPDATE {{table}} SET ";
						$QryUpdateDes .= "`metal` = `metal` + '". $metal ."', ";
						$QryUpdateDes .= "`crystal` = `crystal` + '". $crystal ."', ";
						$QryUpdateDes .= "`deuterium` = `deuterium` + '". $deut ."', ";
						$QryUpdateDes .= "`appolonium` = `appolonium` + '". $appol ."', ";
						$QryUpdateDes .=  "`last_beam_time` = '". $JumpTime ."' ";
						$QryUpdateDes .=  "WHERE ";
						$QryUpdateDes .=  "`id` = '". $TargetGate['id'] ."';";
						doquery ( $QryUpdateDes, 'planets');

						// Deplacement vers la lune d'arrivée
						$QryUpdateUsr  = "UPDATE {{table}} SET ";
						$QryUpdateUsr .= "`current_planet` = '". $TargetGate['id'] ."' ";
						$QryUpdateUsr .= "WHERE ";
						$QryUpdateUsr .= "`id` = '". $CurrentUser['id'] ."';";
						doquery ( $QryUpdateUsr, 'users');

						$CurrentPlanet['last_beam_time'] = $JumpTime;
						$RestString    = GetNextJumpWaitTimePlanet ( $CurrentPlanet );
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

	$Message = DoRessBeam($user, $planetrow);
	message ($Message, $lang['tech'][46], "infos.php?gid=46", 4);

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Version from scrap .. y avait pas ... bin maintenant y a !!

?>