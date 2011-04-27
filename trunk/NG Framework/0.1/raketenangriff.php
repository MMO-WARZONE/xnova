<?php
/****************************************/
/* raketenangriff.php                */
/* Envio de MIP                     */
/*                               */
/* @version 1.1                     */
/* @copyright 2008 By Minguez for XNova */
/*                              */
/****************************************/

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamella_root_path = './';
include($ugamella_root_path . 'extension.inc');
include($ugamella_root_path . 'common.'.$phpEx);

// blocking non-users
if ($IsUserChecked == false) {
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

//$planet    = doquery("SELECT * FROM {{table}} WHERE `id` = '".$user['current_planet']."';", 'planets', true);


$g = intval($_GET['galaxy']);
$s = intval($_GET['system']);
$i = intval($_GET['planet']);
$anz = intval($_POST['SendMI']);
$pziel = $_POST['Target'];


$currentplanet = doquery("SELECT * FROM {{table}} WHERE id={$user['current_planet']}",'planets',true);
$iraks = $currentplanet['interplanetary_misil'];

$tempvar1 = abs($s-$currentplanet['system']);
$tempvar2 = ($user['impulse_motor_tech'] * 2) - 1;
$tempvar3 = doquery("SELECT * FROM {{table}} WHERE galaxy = ".$g." AND
         system = ".$s." AND
         planet = ".$i." AND
         planet_type = 1 limit 1", 'planets',true);

if ($currentplanet['silo'] < 4) {
   $error = "Debes tener al menos silo al nivel 4.";
}elseif ($user['impulse_motor_tech'] == 0) {
   $error = "Debes investigar Motor de Impulso.";
}elseif ($tempvar1 >= $tempvar2 || $g != $currentplanet['galaxy']) {
   $error = "No puedes enviar misiles a otra galaxia.";
}elseif (!$tempvar3) {
   $error = "El planeta objetivo no existe.";
}elseif ($anz > $iraks) {
   $error = "No puedes enviar $anz misiles, solo dispones de $iraks.";
}elseif ((!is_numeric($pziel) && $pziel != "all") OR ($pziel < 0 && $pziel > 7 && $pziel != "all")) {
   $error = "Objetivo Incorrecto";
}elseif ($iraks==0){
   $error = "No hay misiles interplanetarios disponibles";
}elseif ($anz==0){
   $error = "Ingresar el n&uacute;mero de misiles que deseas enviar";
}


if ($error != "") {
   message($error, 'Error');
   exit();
}

$ziel_id = $tempvar3["id_owner"];

$flugzeit = round(((30 + (60 * $tempvar1)) * 2500) / $game_config['fleet_speed']);

$DefenseLabel =
   array(
      '0' => 'Lanzamisiles',
      '1' => 'L&aacute;ser peque&ntilde;o',
      '2' => 'L&aacute;ser grande',
      '3' => 'Ca&ntilde;&oacute;n Gauss',
      '4' => 'Ca&ntilde;&oacute;n i&oacute;nico',
      '5' => 'Ca&ntilde;&oacute;n de plasma',
      '6' => 'C&uacute;pula pequea&ntilde;a de protecci&oacute;n',
      '7' => 'C&uacute;pula grande de protecci&oacute;n',
      'all' => 'Todo');
      
      
doquery("INSERT INTO {{table}} SET
      fleet_owner = ".$user['id'].",
      fleet_mission = 10,
      fleet_amount = ".$anz.",
      fleet_array = '503,".$anz."',
      fleet_start_time = '".(time() + $flugzeit)."',
      fleet_start_galaxy = '".$currentplanet['galaxy']."',
      fleet_start_system = '".$currentplanet['system']."',
      fleet_start_planet ='".$currentplanet['planet']."',
      fleet_start_type = 1,
      fleet_end_time = '".(time() + $flugzeit+1)."',
      fleet_end_stay = 0,
      fleet_end_galaxy = '".$g."',
      fleet_end_system = '".$s."',
      fleet_end_planet = '".$i."',
      fleet_end_type = 1,
      fleet_target_obj = '".$pziel."',
      fleet_resource_metal = 0,
      fleet_resource_crystal = 0,
      fleet_resource_deuterium = 0,
      fleet_target_owner = '".$ziel_id."',
      fleet_group = 0,
      fleet_mess = 0,
      start_time = ".time().";", 'fleets');


doquery("UPDATE {{table}} SET interplanetary_misil = (interplanetary_misil - ".$anz.") WHERE id = '".$user['current_planet']."'", 'planets');

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];



$title = "Ataque con misiles interplanetarios";
$text = "<b>".$anz."</b> misiles interplanetarios se enviaron. objetivo principal: ".$DefenseLabel[$pziel];
message($text,$title,"overview.php",3);

?>
