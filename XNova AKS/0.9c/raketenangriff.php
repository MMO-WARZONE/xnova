<?php
/*
#############################################################################
#  Filename: raketenangriff.php
#  Create date: Friday, May 30, 2008    22:19:17
#  #  Description: RPG web based game
#
#  Copyright © 2008 Aleksandar Spasojevic <spalekg@gmail.com>
#  Copyright © 2005 - 2008 KGsystem
#############################################################################
*/

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.'.$phpEx);

$planet    = doquery("SELECT * FROM {{table}} WHERE `id` = '".$user['current_planet']."';", 'planets', true);
$iraks = $planet['interplanetary_misil'];

$g = intval($_GET['galaxy']);
$s = intval($_GET['system']);
$i = intval($_GET['planet']);
$anz = abs(intval($_POST['SendMI']));
$pziel = $_POST['Target'];

$currentplanet = doquery("SELECT * FROM {{table}} WHERE id={$user['current_planet']}",'planets',true);

$tempvar1 = abs($s - $currentplanet['system']);
$tempvar2 = ($user['impulse_motor_tech'] * 2) - 1;
$tempvar3 = doquery("SELECT * FROM {{table}} WHERE galaxy = ".$g." AND
         system = ".$s." AND
         planet = ".$i." AND
         planet_type = '1'", 'planets');

if ($planet['silo'] < 4) {
   $error = 1;

}elseif ($user['impulse_motor_tech'] == 0) {;
   $error = 1;

}elseif ($tempvar1 >= $tempvar2 || $g != $currentplanet['galaxy']) {
   $error = 1;
}elseif (mysql_num_rows($tempvar3) != 1) {
   $error = 1;
}elseif ($anz > $iraks) {
   $error = 1;
}elseif ((!is_numeric($pziel) && $pziel != "all") OR ($pziel < 0 && $pziel > 7 && $pziel != "all")) {
   $error = 1;
}

if ($error == 1) {
   message('Vous n\'avez pas assez de missiles, la planete que vous visez n\'existe pas ou il vous manque une technologie (impulsion)', 'Erreur');
   exit();
}

$iraks_anzahl = $iraks;

if ($pziel == "all"){
   $pziel = 0;
}else{
   $pziel = intval($pziel);
}

$planet = doquery("SELECT * FROM {{table}} WHERE galaxy = ".$g." AND
         system = ".$s." AND
         planet = ".$i." AND
         planet_type = '1'", 'planets', true);

$ziel_id = $planet['id_owner'];

$select = doquery("SELECT * FROM {{table}} WHERE id = ".$ziel_id, 'users', true);

$verteidiger_panzerung = $select['defence_tech'];
$angreifer_waffen = $user['military_tech'];

$primaerziel = $pziel;

$iraks = $anz;

$def = array(
         0 => $planet['misil_launcher'], // Raketenwerfer
         1 => $planet['small_laser'], // Leichtes Lasergeschütz
         2 => $planet['big_laser'], // Schweres Lasergeschütz
         3 => $planet['gauss_canyon'], // Gaußkanone
         4 => $planet['ionic_canyon'], // Ionengeschütz
         5 => $planet['buster_canyon'], // Plasmawerfer
         6 => $planet['small_protection_shield'], // Kleine Schildkuppel
         7 => $planet['big_protection_shield'], // Große Schildkuppel
         8 => $planet['interplanetary_misil'], // Interplanetarrakete
         9 => $planet['interceptor_misil'], // Abfangrakete
      );

$lang = array(
         0 => $lang['tech'][401],
         1 => $lang['tech'][402],
         2 => $lang['tech'][403],
         3 => $lang['tech'][404],
         4 => $lang['tech'][405],
         5 => $lang['tech'][406],
         6 => $lang['tech'][407],
         7 => $lang['tech'][408],
         8 => $lang['tech'][502],
         9 => $lang['tech'][503],
       );

$flugzeit = round(((30 + (60 * $tempvar1)) * 2500) / $game_config['game_speed']);

doquery("INSERT INTO {{table}} SET
      `zeit` = '".(time() + $flugzeit)."',
      `galaxy` = '".$g."',
      `system` = '".$s."',
      `planet` = '".$i."',
      `galaxy_angreifer` = '".$currentplanet['galaxy']."',
      `system_angreifer` = '".$currentplanet['system']."',
      `planet_angreifer` = '".$currentplanet['planet']."',
      `owner` = '".$user['id']."',
      `zielid` = '".$ziel_id."',
      `anzahl` = '".$anz."',
      `primaer` = '".$primaerziel."'", 'iraks');

doquery("UPDATE {{table}} SET interplanetary_misil = '".($iraks_anzahl - $anz)."' WHERE id = '".$user['current_planet']."'", 'planets');

   $dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

if ($anz == 1){
   $n = "";
}else{
   $n = "n";
}

?>
<html>
<head>
<title>Attaque MIP</title>
<link rel="SHORTCUT ICON" href="favicon.ico">
<link rel="stylesheet" type="text/css" href="<?php echo $dpath; ?>formate.css" />
<meta http-equiv="refresh" content="3; URL=galaxy.php?mode=3&galaxy=<?php echo $g; ?>&system=<?php echo $s; ?>&target=<?php echo $i; ?>">


</head>
<body>
<br><br><br>
  <center>

<table border="0">
  <tbody><tr>
    <td>
      <table>
        <tbody>
        <tr>
         <td class="c" colspan="1">Attaque MIP</td>
   </tr>
        <tr>
   <td class="l"><?php echo "<b>".$anz."</b> missiles interplanetaire ".$n." sont".$n." partit !"; ?>
        </tr>
       </tbody></table>
      </td>
      </tr>
     </tbody></table>

</form>


</body></html>
<?php
?>