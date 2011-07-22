<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

// Schutz vor unregestrierten Usern
if ($IsUserChecked == false) {
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

function ModuleMarchand ( $CurrentUser, &$CurrentPlanet ) {
	global $lang, $_POST;

	includeLang('marchand');

	$parse   = $lang;

	if ($_POST['ress'] != '') {
		$PageTPL = gettemplate('message_body');
		$Error   = false;
		$CheatTry  = false;
		$Metal     = $_POST['metal'];
		$Crystal   = $_POST['cristal'];
		$Deuterium = $_POST['deut'];
		if ($Metal < 0) {
			$Metal     *= -1;
			$CheatTry   = true;
		}
		if ($Crystal < 0) {
			$Crystal   *= -1;
			$CheatTry   = true;
		}
		if ($Deuterium < 0) {
			$Deuterium *= -1;
			$CheatTry   = true;
		}
		if ($CheatTry  == false) {
		switch ($_POST['ress']) {
			case 'metal':
				$Necessaire   = (($_POST['cristal'] * 2) + ($_POST['deut'] * 4));
				if (($_POST['cristal'] < 0) || ($_POST['deut'] < 0)){
					$Message = $lang['MARCHAND_ERROR_MESSAGE'];
					$Error   = true;
				} elseif ($CurrentPlanet['metal'] > $Necessaire) {
					$CurrentPlanet['metal'] -= $Necessaire;
				} else {
					$Message = $lang['mod_ma_noten'] ." ". $lang['Metal'] ."! ";
					$Error   = true;
				}
				break;

			case 'cristal':
				$Necessaire   = (($_POST['metal'] * 0.5) + ($_POST['deut'] * 2));
				if(($_POST['metal'] < 0) || ($_POST['deut'] < 0)){
					$Message = $lang['MARCHAND_ERROR_MESSAGE'];
					$Error   = true;
				} elseif ($CurrentPlanet['crystal'] > $Necessaire) {
					$CurrentPlanet['crystal'] -= $Necessaire;
				} else {
					$Message = $lang['mod_ma_noten'] ." ". $lang['Crystal'] ."! ";
					$Error   = true;
				}
				break;

			case 'deuterium':
				$Necessaire   = (($_POST['metal'] * 0.25) + ($_POST['cristal'] * 0.5));
				if(($_POST['metal'] < 0) || ($_POST['cristal'] < 0)){
					$Message = $lang['MARCHAND_ERROR_MESSAGE'];
					$Error   = true;
				} elseif ($CurrentPlanet['deuterium'] > $Necessaire) {
					$CurrentPlanet['deuterium'] -= $Necessaire;
				} else {
					$Message = $lang['mod_ma_noten'] ." ". $lang['Deuterium'] ."! ";
					$Error   = true;
				}
				break;
		}
}
		if ($Error == false) {
			if ($CheatTry == true) {
				$CurrentPlanet['metal']      = 0;
				$CurrentPlanet['crystal']    = 0;
				$CurrentPlanet['deuterium']  = 0;
			} else {
				$CurrentPlanet['metal']     += $Metal;
				$CurrentPlanet['crystal']   += $Crystal;
				$CurrentPlanet['deuterium'] += $Deuterium;
			}

			$QryUpdatePlanet  = "UPDATE {{table}} SET ";
			$QryUpdatePlanet .= "`metal` = '".     $CurrentPlanet['metal']     ."', ";
			$QryUpdatePlanet .= "`crystal` = '".   $CurrentPlanet['crystal']   ."', ";
			$QryUpdatePlanet .= "`deuterium` = '". $CurrentPlanet['deuterium'] ."' ";
			$QryUpdatePlanet .= "WHERE ";
			$QryUpdatePlanet .= "`id` = '".        $CurrentPlanet['id']        ."';";
			doquery ( $QryUpdatePlanet , 'planets');
			$Message = $lang['mod_ma_done'];
		}
		if ($Error == true) {
			$parse['title'] = $lang['mod_ma_error'];
		} else {
			$parse['title'] = $lang['mod_ma_donet'];
		}
		$parse['mes']   = $Message;
	} else {
		if ($_POST['action'] != 2) {
			$PageTPL = gettemplate('marchand_main');
		} else {
			$parse['mod_ma_res']   = "1";
			switch ($_POST['choix']) {
				case 'metal':
					$PageTPL = gettemplate('marchand_metal');
					$parse['mod_ma_res_a'] = "2";
					$parse['mod_ma_res_b'] = "4";
					break;
				case 'cristal':
					$PageTPL = gettemplate('marchand_cristal');
					$parse['mod_ma_res_a'] = "0.5";
					$parse['mod_ma_res_b'] = "2";
					break;
				case 'deut':
					$PageTPL = gettemplate('marchand_deuterium');
					$parse['mod_ma_res_a'] = "0.25";
					$parse['mod_ma_res_b'] = "0.5";
					break;
			}
		}
	}

	$Page    = parsetemplate ( $PageTPL, $parse );
	return  $Page;
}
	//Urlaubsmodus Check
	if($user['urlaubs_modus'] == 0) {
		$Page = ModuleMarchand ( $user, $planetrow );
		display ( $Page, $lang['mod_marchand'], true, '', false );
	}else{
		display ( $Page, $lang['mod_marchand'], true, '', false );
	}
	
?>