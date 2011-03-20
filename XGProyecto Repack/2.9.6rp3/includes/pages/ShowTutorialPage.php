<?php


	function ShowTutorialPage(&$user, &$planetrow){
		global $lang, $dpath, $game_config, $resource;
	$parse = $lang;     
	$parse['dpath'] = $dpath;

	$requer = 0;

	switch ($_GET['pp']){
		case 'exit':
			message('Puedes volver a acceder al Tutorial en el menu. Buena suerte', 'game.php?page=overview');
			break;
			
		case 'finish':
			message('Has terminado el Tutorial correctamente. Buena suerte', 'game.php?page=overview');
			break;	
			
		case 1:
			if($planetrow[$resource[1]] >= 4){
				$parse['met_4'] = 'check';
				++$requer;
			}else{
				$parse['met_4'] = 'none';
			}
			if($planetrow[$resource[2]] >= 2){
				$parse['cris_2'] = 'check';
				++$requer;
			}else{
				$parse['cris_2'] = 'none';
			}
			if($planetrow[$resource[4]] >= 4){
				$parse['sol_4'] = 'check';
				++$requer;
			}else{
				$parse['sol_4'] = 'none';
			}
			if($_GET['continue'] == 1 and $requer == 3 and $user['tut_1'] == 0){
				$planetrow['metal'] += 1500;
				$planetrow['crystal'] += 750;
				doquery("UPDATE {{table}} SET `tut_1` = '1' WHERE `id` = '".$user['id']."';", 'users');
				PlanetResourceUpdate ( $user, $planetrow, time());
				$user['tut_1'] = 1;
				message('        <p style="color:lime;">¡Felicitaciones! Con la construcción exitosa de tus primeras minas has asegurado la base de abastecimiento de tu planeta.</p>
	<ul><li>Asegúrate de que tus minas tengan a su disposición suficiente energía. Si no lo haces, tus minas no podrán seguir trabajando efectivamente. </li>
	<li>Al principio del juego, la planta de energía solar es la fuente de energía más económica.</li>
	<li>Al comienzo del juego, es muy importante que tengas los recursos base metal y cristal para la expansión de otras minas. Más tarde necesitarás también el recurso deuterio. Y mucho más tarde el hidrógeno.   </li></ul>', 'game.php?page=tutorial&pp=2', 3);
			}
			if($requer == 3 and $user['tut_1'] == 0){
				$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&pp=1&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
			}elseif($user['tut_1'] == 1){
				$parse['button'] = '<input type="button" value="Completado" style="width:150px;height:30px;color:green;" disabled="true" />';
			}else{
				$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
			}
			$page = parsetemplate(gettemplate('tutorial/tutorial_1'), $parse);
			break;

		case 2:
			if($planetrow[$resource[3]] >= 2){
				$parse['deu_4'] = 'check';
				++$requer;
			}else{
				$parse['deu_4'] = 'none';
			}
			if($planetrow[$resource[14]] >= 2){
				$parse['robot_2'] = 'check';
				++$requer;
			}else{
				$parse['robot_2'] = 'none';
			}
			if($planetrow[$resource[21]] >= 1){
				$parse['han_1'] = 'check';
				++$requer;
			}else{
				$parse['han_1'] = 'none';
			}
			if($planetrow[$resource[401]] >= 1){
				$parse['lanz_1'] = 'check';
				++$requer;
			}else{
				$parse['lanz_1'] = 'none';
			}
			if($_GET['continue'] == 1 and $requer == 4 and $user['tut_2'] == 0){
				doquery("UPDATE {{table}} SET `".$resource[401]."` = `".$resource[401]."` + 20 WHERE `id` = '".$planetrow['id']."';", 'planets');
				doquery("UPDATE {{table}} SET `tut_2` = '1' WHERE `id` = '".$user['id']."';", 'users');
				$user['tut_2'] = 1;
				if($user['tut_1'] == 1 and $user['tut_2'] == 1 and $user['tut_3'] == 1 and $user['tut_4'] == 1 and $user['tut_5'] == 1 and $user['tut_6'] == 1 and $user['tut_7'] == 1 and $user['tut_8'] == 1 and $user['tut_9'] == 1 and $user['tut_10'] == 1){
					header('Location: game.php?page=tutorial&pp=finish');
					die();
				}
				header('Location: game.php?page=tutorial&pp=3');
			}
			if($requer == 4 and $user['tut_2'] == 0){
				$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&pp=2&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
			}elseif($user['tut_2'] == 1){
				$parse['button'] = '<input type="button" value="Completado" style="width:150px;height:30px;color:green;" disabled="true" />';
			}else{
				$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
			}
			$page = parsetemplate(gettemplate('tutorial/tutorial_2'), $parse);
			break;

		case 3:
			if($planetrow[$resource[1]] >= 10){
				$parse['met_10'] = 'check';
				++$requer;
			}else{
				$parse['met_10'] = 'none';
			}
			if($planetrow[$resource[2]] >= 7){
				$parse['cris_7'] = 'check';
				++$requer;
			}else{
				$parse['cris_7'] = 'none';
			}
			if($planetrow[$resource[3]] >= 5){
				$parse['deut_5'] = 'check';
				++$requer;
			}else{
				$parse['deut_5'] = 'none';
			}
			if($_GET['continue'] == 1 and $requer == 3 and $user['tut_3'] == 0){
				$planetrow['metal'] += 20000;
				$planetrow['crystal'] += 5000;
				doquery("UPDATE {{table}} SET `tut_3` = '1' WHERE `id` = '".$user['id']."';", 'users');
				PlanetResourceUpdate ( $user, $planetrow, time());
				$user['tut_3'] = 1;
				if($user['tut_1'] == 1 and $user['tut_2'] == 1 and $user['tut_3'] == 1 and $user['tut_4'] == 1 and $user['tut_5'] == 1 and $user['tut_6'] == 1 and $user['tut_7'] == 1 and $user['tut_8'] == 1 and $user['tut_9'] == 1 and $user['tut_10'] == 1){
					header('Location: game.php?page=tutorial&pp=finish');
					die();
				}
				header('Location: game.php?page=tutorial&pp=4');
			}
			if($requer == 3 and $user['tut_3'] == 0){
				$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&pp=3&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
			}elseif($user['tut_3'] == 1){
				$parse['button'] = '<input type="button" value="Completado" style="width:150px;height:30px;color:green;" disabled="true" />';
			}else{
				$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
			}
			$page = parsetemplate(gettemplate('tutorial/tutorial_3'), $parse);
			break;
			
		case 4:
			if($planetrow[$resource[31]] >= 1){
				$parse['inv_1'] = 'check';
				++$requer;
			}else{
				$parse['inv_1'] = 'none';
			}
			if($user[$resource[115]] >= 2){
				$parse['comb_2'] = 'check';
				++$requer;
			}else{
				$parse['comb_2'] = 'none';
			}
			if($planetrow[$resource[202]] >= 1){
				$parse['navp_1'] = 'check';
				++$requer;
			}else{
				$parse['navp_1'] = 'none';
			}
			if($_GET['continue'] == 1 and $requer == 3 and $user['tut_4'] == 0){
				$planetrow['deuterium'] += 7000;
				$planetrow['tritium'] += 1500;
				doquery("UPDATE {{table}} SET `tut_4` = '1' WHERE `id` = '".$user['id']."';", 'users');
				PlanetResourceUpdate ( $user, $planetrow, time());
				$user['tut_4'] = 1;
				if($user['tut_1'] == 1 and $user['tut_2'] == 1 and $user['tut_3'] == 1 and $user['tut_4'] == 1 and $user['tut_5'] == 1 and $user['tut_6'] == 1 and $user['tut_7'] == 1 and $user['tut_8'] == 1 and $user['tut_9'] == 1 and $user['tut_10'] == 1){
					header('Location: game.php?page=tutorial&pp=finish');
					die();
				}
				header('Location: game.php?page=tutorial&pp=5');
			}
			if($requer == 3 and $user['tut_4'] == 0){
				$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&pp=4&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
			}elseif($user['tut_4'] == 1){
				$parse['button'] = '<input type="button" value="Completado" style="width:150px;height:30px;color:green;" disabled="true" />';
			}else{
				$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
			}
			$page = parsetemplate(gettemplate('tutorial/tutorial_4'), $parse);
			break;

		case 5:
			if(isset($_POST['forum_content']) and strpos($_POST['forum_content'], $game_config['forum_url']) !== false){
				doquery("UPDATE {{table}} SET `tut_5_forum` = '1' WHERE `id` = '".$user['id']."';", 'users');
				$user['tut_5_forum'] = 1;
			}
			if($planetrow['name'] != $lang['sys_pp_defaultname'] and $planetrow['name'] != $lang['sys_colo_defaultname']){
				$parse['planet'] = 'check';
				++$requer;
			}else{
				$parse['planet'] = 'none';
			}
			if($user['tut_5_forum'] == 1){
				$parse['forum'] = 'check';
				++$requer;
			}else{
				$parse['forum'] = 'none';
			}
			$buddyrow = doquery( "SELECT count(*) AS `total` FROM {{table}} WHERE `sender` = '" . $user["id"]."' OR `owner` = '" . $user["id"]."';", 'buddy', true );
			if($buddyrow['total'] >= 1){
				$parse['buddy'] = 'check';
				++$requer;
			}else{
				$parse['buddy'] = 'none';
			}
			$allyrow = doquery( "SELECT count(*) AS `total` FROM {{table}} WHERE `ally_id` = '" . $user["ally_id"]."';", 'users', true );
			if($user['ally_id'] != 0 and $allyrow['total'] >= 4){
				$parse['ally'] = 'check';
				++$requer;
			}else{
				$parse['ally'] = 'none';
			}
			if($_GET['continue'] == 1 and $requer == 4 and $user['tut_5'] == 0){
				$user['darkmatter'] += TR_DARK_MATTER;
				doquery("UPDATE {{table}} SET `tut_5` = '1', `darkmatter` = '".$user['darkmatter']."' WHERE `id` = '".$user['id']."';", 'users');
				$user['tut_5'] = 1;
				if($user['tut_1'] == 1 and $user['tut_2'] == 1 and $user['tut_3'] == 1 and $user['tut_4'] == 1 and $user['tut_5'] == 1 and $user['tut_6'] == 1 and $user['tut_7'] == 1 and $user['tut_8'] == 1 and $user['tut_9'] == 1 and $user['tut_10'] == 1){
					header('Location: game.php?page=tutorial&pp=finish');
					die();
				}
				header('Location: game.php?page=tutorial&pp=6');
			}
			if($requer == 4 and $user['tut_5'] == 0){
				$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&pp=5&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
			}elseif($user['tut_5'] == 1){
				$parse['button'] = '<input type="button" value="Completado" style="width:150px;height:30px;color:green;" disabled="true" />';
			}else{
				$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
			}
			$page = parsetemplate(gettemplate('tutorial/tutorial_5'), $parse);
			break;		

		case 6:
			if($planetrow[$resource[22]] >= 1 or $planetrow[$resource[23]] >= 1 or $planetrow[$resource[24]] >= 1){
				$parse['alm'] = 'check';
				++$requer;
			}else{
				$parse['alm'] = 'none';
			}
			if($user['tut_6_mer'] >= 1){
				$parse['mer'] = 'check';
				++$requer;
			}else{
				$parse['mer'] = 'none';
			}
			if($_GET['continue'] == 1 and $requer == 2 and $user['tut_6'] == 0){
				$rand = mt_rand(22, 24);
				$planetrow[$resource[$rand]] += 1;
				doquery("UPDATE {{table}} SET `".$resource[$rand]."` = '".$planetrow[$resource[$rand]]."' WHERE `id` = '".$planetrow['id']."';", 'planets');
				doquery("UPDATE {{table}} SET `tut_6` = '1' WHERE `id` = '".$user['id']."';", 'users');
				$user['tut_6'] = 1;
				if($user['tut_1'] == 1 and $user['tut_2'] == 1 and $user['tut_3'] == 1 and $user['tut_4'] == 1 and $user['tut_5'] == 1 and $user['tut_6'] == 1 and $user['tut_7'] == 1 and $user['tut_8'] == 1 and $user['tut_9'] == 1 and $user['tut_10'] == 1){
					header('Location: game.php?page=tutorial&pp=finish');
					die();
				}
				header('Location: game.php?page=tutorial&pp=7');
			}
			if($requer == 2 and $user['tut_6'] == 0){
				$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&pp=6&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
			}elseif($user['tut_6'] == 1){
				$parse['button'] = '<input type="button" value="Completado" style="width:150px;height:30px;color:green;" disabled="true" />';
			}else{
				$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
			}
			$page = parsetemplate(gettemplate('tutorial/tutorial_6'), $parse);
			break;

		case 7:
			if($planetrow[$resource[210]] >= 1){
				$parse['sond'] = 'check';
				++$requer;
			}else{
				$parse['sond'] = 'none';
			}
			if($user['tut_7_esp'] >= 1){
				$parse['esp'] = 'check';
				++$requer;
			}else{
				$parse['esp'] = 'none';
			}
			if($_GET['continue'] == 1 and $requer == 2 and $user['tut_7'] == 0){
				doquery("UPDATE {{table}} SET `".$resource[210]."` = `".$resource[210]."` + 20 WHERE `id` = '".$planetrow['id']."';", 'planets');
				doquery("UPDATE {{table}} SET `tut_7` = '1' WHERE `id` = '".$user['id']."';", 'users');
				$user['tut_7'] = 1;
				if($user['tut_1'] == 1 and $user['tut_2'] == 1 and $user['tut_3'] == 1 and $user['tut_4'] == 1 and $user['tut_5'] == 1 and $user['tut_6'] == 1 and $user['tut_7'] == 1 and $user['tut_8'] == 1 and $user['tut_9'] == 1 and $user['tut_10'] == 1){
					header('Location: game.php?page=tutorial&pp=finish');
					die();
				}
				header('Location: game.php?page=tutorial&pp=8');
			}
			if($requer == 2 and $user['tut_7'] == 0){
				$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&pp=7&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
			}elseif($user['tut_7'] == 1){
				$parse['button'] = '<input type="button" value="Completado" style="width:150px;height:30px;color:green;" disabled="true" />';
			}else{
				$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
			}
			$page = parsetemplate(gettemplate('tutorial/tutorial_7'), $parse);
			break;
		
		case 8:
			$parse['exp_pln'] = ( MAX_PLANET_IN_SYSTEM + 1 );
			if($user['tut_8_exp'] >= 1){
				$parse['exp'] = 'check';
				++$requer;
			}else{
				$parse['exp'] = 'none';
			}
			if($_GET['continue'] == 1 and $requer == 1 and $user['tut_8'] == 0){
				doquery("UPDATE {{table}} SET `".$resource[202]."` = `".$resource[202]."` + 50 , `".$resource[205]."` = `".$resource[205]."` + 20 WHERE `id` = '".$planetrow['id']."';", 'planets');
				doquery("UPDATE {{table}} SET `tut_8` = '1' WHERE `id` = '".$user['id']."';", 'users');
				$user['tut_8'] = 1;
				if($user['tut_1'] == 1 and $user['tut_2'] == 1 and $user['tut_3'] == 1 and $user['tut_4'] == 1 and $user['tut_5'] == 1 and $user['tut_6'] == 1 and $user['tut_7'] == 1 and $user['tut_8'] == 1 and $user['tut_9'] == 1 and $user['tut_10'] == 1){
					header('Location: game.php?page=tutorial&pp=finish');
					die();
				}
				header('Location: game.php?page=tutorial&pp=9');
			}
			if($requer == 1 and $user['tut_8'] == 0){
				$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&pp=8&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
			}elseif($user['tut_8'] == 1){
				$parse['button'] = '<input type="button" value="Completado" style="width:150px;height:30px;color:green;" disabled="true" />';
			}else{
				$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
			}
			$page = parsetemplate(gettemplate('tutorial/tutorial_8'), $parse);
			break;

		case 9:
			$planets = doquery( "SELECT count(*) AS `total` FROM {{table}} WHERE `id_owner` = '" . $user["id"]."';", 'planets', true );
			if($planets['total'] >= 2){
				$parse['colonia'] = 'check';
				++$requer;
			}else{
				$parse['colonia'] = 'none';
			}
			if($_GET['continue'] == 1 and $requer == 1 and $user['tut_9'] == 0){
				doquery("UPDATE {{table}} SET `tut_9` = '1' WHERE `id` = '".$user['id']."';", 'users');
				$user['tut_9'] = 1;
				if($user['tut_1'] == 1 and $user['tut_2'] == 1 and $user['tut_3'] == 1 and $user['tut_4'] == 1 and $user['tut_5'] == 1 and $user['tut_6'] == 1 and $user['tut_7'] == 1 and $user['tut_8'] == 1 and $user['tut_9'] == 1 and $user['tut_10'] == 1){
					header('Location: game.php?page=tutorial&pp=finish');
					die();
				}
				header('Location: game.php?page=tutorial&pp=10');
			}
			if($requer == 1 and $user['tut_9'] == 0){
				$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&pp=9&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
			}elseif($user['tut_9'] == 1){
				$parse['button'] = '<input type="button" value="Completado" style="width:150px;height:30px;color:green;" disabled="true" />';
			}else{
				$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
			}
			$page = parsetemplate(gettemplate('tutorial/tutorial_9'), $parse);
			break;


		case 10:
			if($user['tut_10_rec'] >= 1){
				$parse['rec'] = 'check';
				++$requer;
			}else{
				$parse['rec'] = 'none';
			}
			if($_GET['continue'] == 1 and $requer == 1 and $user['tut_10'] == 0){
				doquery("UPDATE {{table}} SET `".$resource[209]."` = `".$resource[209]."` + 100 WHERE `id` = '".$planetrow['id']."';", 'planets');
				$user['tut_10'] = 1;
				doquery("UPDATE {{table}} SET `tut_10` = '1' WHERE `id` = '".$user['id']."';", 'users');
				$user['tut_10'] = 1;
				if($user['tut_1'] == 1 and $user['tut_2'] == 1 and $user['tut_3'] == 1 and $user['tut_4'] == 1 and $user['tut_5'] == 1 and $user['tut_6'] == 1 and $user['tut_7'] == 1 and $user['tut_8'] == 1 and $user['tut_9'] == 1 and $user['tut_10'] == 1){
					header('Location: game.php?page=tutorial&pp=finish');
					die();
				}
				header('Location: game.php?page=tutorial');

			}
			if($requer == 1 and $user['tut_10'] == 0){
				$parse['button'] = '<input type="button" onclick="window.location = \'game.php?page=tutorial&pp=10&continue=1\'" value="Recompensa" style="width:150px;height:30px;color:orange;"/></th>';
			}elseif($user['tut_10'] == 1){
				$parse['button'] = '<input type="button" value="Completado" style="width:150px;height:30px;color:green;" disabled="true" />';
			}else{
				$parse['button'] = '<input type="button" onclick="document.getElementById(\'tutorial_solution\').style.display = \'block\';this.disabled = true;" value="Solución" style="width:130px;"/>';
			}
			$page = parsetemplate(gettemplate('tutorial/tutorial_10'), $parse);
			break;		
		
		default:
			 for($e = 1; $e <= 10; ++$e ){
				if($user['tut_'.$e ] == 1){
					$parse['tut_'.$e ] = 'check';
				}elseif($user['tut_'.$e ] == 0){
					$parse['tut_'.$e ] = 'none';
				}
			}
			$parse['db_game_name'] = $game_config['game_name'];
			$page = parsetemplate(gettemplate('tutorial/tutorial'), $parse);
			break;
	}

	display("<div id='content'>".$page."</div>");
}
?>
