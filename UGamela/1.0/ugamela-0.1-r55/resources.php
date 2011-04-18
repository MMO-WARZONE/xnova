<?php

define('INSIDE', true);
$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.'.$phpEx);

if(!check_user()){ header("Location: login.$phpEx"); }

includeLang('resources');
includeLang('tech');

include($ugamela_root_path . 'includes/planet_toggle.'.$phpEx);//Esta funcion permite cambiar el planeta actual.

$planetrow = doquery("SELECT * FROM {{table}} WHERE id={$user['current_planet']}",'planets',true);
//$galaxyrow = doquery("SELECT * FROM {{table}} WHERE id_planet={$planetrow['id']}",'galaxy',true);
$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
check_field_current($planetrow);


/*
  Pequeña comprovacion para los almacenes `metal_max`,`crystal_max`,`deuterium_max`
*/
$u = 100000;//Balor basico
$planetrow['metal_max'] = floor($u* pow(1.5,$planetrow[$resource[22]]));
$planetrow['crystal_max'] = floor($u* pow(1.5,$planetrow[$resource[23]]));
$planetrow['deuterium_max'] = floor($u* pow(1.5,$planetrow[$resource[24]]));

$query = '';
if($_POST){
	foreach($_POST as $a => $b){
		/*
		  Evitamos si se envian algunos datos innecesarios.
		*/
		if(isset($planetrow["{$a}_porcent"])){
			$b = $b/10;
			$planetrow["{$a}_porcent"] = $b;
			$query .= ",`{$a}_porcent`='$b'";
		}
	}
}

$parse = $lang;
/*
  Esta array contiene todos los que pueden generar recursos o energia.
  Servira para hacer un loop.
*/
$res_ab = array(1,2,3,4,12,212);
//la template row
$row = gettemplate('resources_row');
//looooooooop
$parse['production_level'] = 100;
//
//  A futuro, se cambiara la forma de plasmar los valores en una array. la cual se plasmara en una plantilla
//  armada previamente, segun los datos a plasmar
//
//produccion total
if($planetrow["energy_max"]==0&&$planetrow['energy_used']<0){
	$post_porcent=0;
}elseif($planetrow["energy_max"]>0&&$planetrow['energy_used']>$planetrow["energy_max"]){
	$post_porcent = floor(($planetrow["energy_max"])/$planetrow['energy_used']*100);
}else{$post_porcent=100;}
if($post_porcent>100){$post_porcent=100;}
//
// Ingresos basicos.
//
$planetrow["metal_perhour"] = $parse['metal_basic_income'] = $game_config['metal_basic_income']* $game_config['resource_multiplier'];
$planetrow["crystal_perhour"] = $parse['crystal_basic_income'] = $game_config['crystal_basic_income']* $game_config['resource_multiplier'];
$planetrow["deuterium_perhour"] = $parse['deuterium_basic_income'] = $game_config['deuterium_basic_income']* $game_config['resource_multiplier'];
$planetrow["energy_max"] = $parse['energy_basic_income'] = $game_config['energy_basic_income']* $game_config['resource_multiplier'];
//reset de algunos datos
$planetrow["energy_used"]=0;
$parse['resource_row']='';//un pequeño fix ;P
foreach($res_ab as $a){
	if($planetrow[$resource[$a]]>0&&isset($production[$a])){
		/*
		  Supuestamente, los datos de las formulas, estan en la array $production.
		  Ademas de los factores. etc.
		*/
		$r = array();
		$r['type'] = $lang['tech'][$a];
		//excluimos las naves con el numero mayor a 200 ;)
		$r['level'] =($a>200)?$lang['quantity']:$lang['level'];
		$r['level_type'] = $planetrow[$resource[$a]];
		/*
		  Los datos de las formulas se almacenan en la array $production
		  Se hubica en /includes/vars.php
		*/
		$metal = floor(eval($production[$a]["formular"]["metal"])* $game_config['resource_multiplier']);
		$crystal = floor(eval($production[$a]["formular"]["crystal"])* $game_config['resource_multiplier']);
		$deuterium = floor(eval($production[$a]["formular"]["deuterium"])* $game_config['resource_multiplier']);
		$energy = floor(eval($production[$a]["formular"]["energy"])* $game_config['resource_multiplier']);
		$planetrow["metal_perhour"] += $metal;
		$planetrow["crystal_perhour"] += $crystal;
		$planetrow["deuterium_perhour"] += $deuterium;
		if($energy>0){$planetrow["energy_max"] += $energy;}
		else{$planetrow["energy_used"] -= $energy;}
		//es una pequeña suma de porcentajes
		$metal=$metal* 0.01 * $post_porcent;
		$crystal = $crystal* 0.01 * $post_porcent;
		$deuterium = $deuterium* 0.01 * $post_porcent;
		$energy2 = $energy* 0.01 * $post_porcent;
		$r["metal_type"] = number_format($metal,0,",",".");
		$r["crystal_type"] = number_format($crystal,0,",",".");
		$r["deuterium_type"] = number_format($deuterium,0,",",".");
		$r["energy_type"] = number_format($energy,0,",",".");
		//Nombre interno
		$r['name'] = $resource[$a];
		//Se establece el porcentaje
		eval('$r["porcent"] = $planetrow["'.$resource[$a].'_porcent"];');
		//_porcent
		//Esto muestra las opciones de porcentaje.
		//
		for ( $i = 10; $i >= 0; $i-- ) {
			$e = $i*10;
			if($i == $r["porcent"]){
				$s=' selected=selected';
			}else{$s='';}
			$r['option'] .= "<option value=\"{$e}\"{$s}>{$e}%</option>";
		}
		//Esto solo colorea los valores.
		$r["metal_type"] = colorNumber($r["metal_type"]);
		$r["crystal_type"] = colorNumber($r["crystal_type"]);
		$r["deuterium_type"] = colorNumber($r["deuterium_type"]);
		$r["energy_type"] = colorNumber($r["energy_type"]);
		//template
		$parse['resource_row'] .= parsetemplate($row, $r);
	}
}

//ahora se actualiza la
/*
  Datos iniciales y porcentaje de produccion
*/
{//Nombre del planeta
//el nombre del planeta
$parse['Production_of_resources_in_the_planet'] = 
	str_replace('%s',$planetrow['name'],$lang['Production_of_resources_in_the_planet']);
//produccion total
if($planetrow["energy_max"]==0&&$planetrow['energy_used']<0){
	$parse['production_level']=0;
}elseif($planetrow["energy_max"]>0&&$planetrow['energy_used']>$planetrow["energy_max"]){
	$parse['production_level'] = floor(($planetrow["energy_max"])/$planetrow['energy_used']*100);
	
}else{$parse['production_level']=100;}
if($parse['production_level']>100){$parse['production_level']=100;}

$parse['production_level_bar'] = $parse['production_level']*2.5;
$parse['production_level'] = "{$parse['production_level']}%";
$parse['production_level_barcolor'] = '#00ff00';
//Datos basicos.
$parse['metal_basic_income'] = $game_config['metal_basic_income']* $game_config['resource_multiplier'];
$parse['crystal_basic_income'] = $game_config['crystal_basic_income']* $game_config['resource_multiplier'];
$parse['deuterium_basic_income'] = $game_config['deuterium_basic_income']* $game_config['resource_multiplier'];
$parse['energy_basic_income'] = $game_config['energy_basic_income']* $game_config['resource_multiplier'];
}

//Metal maximo
if($planetrow["metal_max"]<$planetrow["metal"]){
	$parse['metal_max'] = '<font color="#ff0000">';
}else{
	$parse['metal_max'] = '<font color="#00ff00">';
}
$parse['metal_max'] .= number_format(floor($planetrow["metal_max"]/1000),0,",",".")." {$lang['k']}</font>";
//Cristal maximo
if($planetrow["crystal_max"]<$planetrow["crystal"]){
	$parse['crystal_max'] = '<font color="#ff0000">';
}else{
	$parse['crystal_max'] = '<font color="#00ff00">';
}
$parse['crystal_max'] .= number_format(floor($planetrow["crystal_max"]/1000),0,",",".")." {$lang['k']}";
//Deuterio maximo
if($planetrow["deuterium_max"]<$planetrow["deuterium"]){
	$parse['deuterium_max'] = '<font color="#ff0000">';
}else{
	$parse['deuterium_max'] = '<font color="#00ff00">';
}
$parse['deuterium_max'] .= number_format(floor($planetrow["deuterium_max"]/1000),0,",",".")." {$lang['k']}";
//Total de los recursos
$parse['metal_total'] = colorNumber(floor($planetrow['metal_perhour']* 0.01 * $parse['production_level']));
$parse['crystal_total'] = colorNumber(floor($planetrow['crystal_perhour']* 0.01 * $parse['production_level']));
$parse['deuterium_total'] = colorNumber(floor($planetrow['deuterium_perhour']* 0.01 * $parse['production_level']));
$parse['energy_total'] = colorNumber(floor($planetrow['energy_max']-$planetrow["energy_used"]));
//------------------->//$planetrow['energy_used']= $planetrow['energy_used']+$planetrow["energy_max"]; 

/*
  Valores estadisticos.
*/
{//tabla de valores extendidos
//colores de la tabla... no muy necesario creo yo...
$parse['daily_metal'] = colorNumber(number_format(floor($planetrow["metal_perhour"]*24),0,",","."));
$parse['weekly_metal'] = colorNumber(number_format(floor($planetrow["metal_perhour"]*24*7),0,",","."));
$parse['monthly_metal'] = colorNumber(number_format(floor($planetrow["metal_perhour"]*24*30),0,",","."));
$parse['daily_crystal'] = colorNumber(number_format(floor($planetrow["crystal_perhour"]*24),0,",","."));
$parse['weekly_crystal'] = colorNumber(number_format(floor($planetrow["crystal_perhour"]*24*7),0,",","."));
$parse['monthly_crystal'] = colorNumber(number_format(floor($planetrow["crystal_perhour"]*24*30),0,",","."));
$parse['daily_deuterium'] = colorNumber(number_format(floor($planetrow["deuterium_perhour"]*24),0,",","."));
$parse['weekly_deuterium'] = colorNumber(number_format(floor($planetrow["deuterium_perhour"]*24*7),0,",","."));
$parse['monthly_deuterium'] = colorNumber(number_format(floor($planetrow["deuterium_perhour"]*24*30),0,",","."));

//Porcentajes de minerias llenas
$parse['metal_storage'] = floor($planetrow["metal"] / $planetrow["metal_max"] * 100).$lang['o/o'];
$parse['crystal_storage'] = floor($planetrow["crystal"] / $planetrow["crystal_max"] * 100).$lang['o/o'];
$parse['deuterium_storage'] = floor($planetrow["deuterium"] / $planetrow["deuterium_max"] * 100).$lang['o/o'];
//Las barras de porcentaje
$parse['metal_storage_bar'] = floor($planetrow["metal"] / $planetrow["metal_max"] * 100)*2.5;
$parse['crystal_storage_bar'] = floor($planetrow["crystal"] / $planetrow["crystal_max"] * 100)*2.5;
$parse['deuterium_storage_bar'] = floor($planetrow["deuterium"] / $planetrow["deuterium_max"] * 100)*2.5;
//Color de la barra de metal
if($parse['metal_storage_bar'] > (100*2.5)){
	$parse['metal_storage_bar'] = 250;
	$parse['metal_storage_barcolor'] = '#C00000';
}elseif($parse['metal_storage_bar'] > (80*2.5)){
	$parse['metal_storage_barcolor'] = '#C0C000';
}else{
	$parse['metal_storage_barcolor'] = '#00C000';
}
//color de la barra de cristal
if($parse['crystal_storage_bar'] > (100*2.5)){
	$parse['crystal_storage_bar'] = 250;
	$parse['crystal_storage_barcolor'] = '#C00000';
}elseif($parse['crystal_storage_bar'] > (80*2.5)){
	$parse['crystal_storage_barcolor'] = '#C0C000';
}else{
	$parse['crystal_storage_barcolor'] = '#00C000';
}
//color de la barra de deutero
if($parse['deuterium_storage_bar'] > (100*2.5)){
	$parse['deuterium_storage_bar'] = 250;
	$parse['deuterium_storage_barcolor'] = '#C00000';
}elseif($parse['deuterium_storage_bar'] > (80*2.5)){
	$parse['deuterium_storage_barcolor'] = '#C0C000';
}else{
	$parse['deuterium_storage_barcolor'] = '#00C000';
}
}

//Ahora realizamos la quieri :0
doquery("UPDATE {{table}} SET
	metal_perhour = '{$planetrow['metal_perhour']}',
	crystal_perhour = '{$planetrow['crystal_perhour']}',
	deuterium_perhour = '{$planetrow['deuterium_perhour']}',
	metal_max = '{$planetrow['metal_max']}',
	crystal_max = '{$planetrow['crystal_max']}',
	deuterium_max = '{$planetrow['deuterium_max']}',
	energy_used = '{$planetrow['energy_used']}',
	energy_max = '{$planetrow['energy_max']}'
	{$query}
	WHERE `id`='{$planetrow['id']}'",'planets');

$page = parsetemplate(gettemplate('resources'), $parse);
display($page,$lang['Resources']);

// Created by Perberos. All rights reversed (C) 2006
?>
