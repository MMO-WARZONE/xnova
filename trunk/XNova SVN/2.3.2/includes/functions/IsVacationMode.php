<?php
//version 1
function IsVacationMode($CurrentUser)
{
	global $db;

	if($CurrentUser['urlaubs_modus'] == 1)
	{
		$db->query("UPDATE {{table}} SET
			metal_perhour = '".$db->game_config['metal_basic_income']."',
			crystal_perhour = '".$db->game_config['crystal_basic_income']."',
			deuterium_perhour = '".$db->game_config['deuterium_basic_income']."',
			metal_mine_porcent = '0',
			crystal_mine_porcent = '0',
			deuterium_sintetizer_porcent = '0',
			solar_plant_porcent = '0',
			fusion_plant_porcent = '0',
			solar_satelit_porcent = '0'
			WHERE id_owner = '".$CurrentUser['id']."' AND `planet_type` = '1' ", 'planets' );
		
		return true;
	}
	return false;
}
?>