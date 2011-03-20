<?php

/**
  * Galaxy.php
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

includeLang('menu_01/gala');

$CurrentPlanet  = doquery("SELECT * FROM {{table}} WHERE `id` = '". $user['current_planet'] ."';", 'planets', true);
$lunarow        = doquery("SELECT * FROM {{table}} WHERE `id` = '". $user['current_luna'] ."';", 'lunas', true);
$galaxyrow      = doquery("SELECT * FROM {{table}} WHERE `id_planet` = '". $CurrentPlanet['id'] ."';", 'galaxy', true);
$dpath          = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
$fleetmax       = (1 + ($user['computer_tech']) + ( $user['rpg_commandant'] * 3));
$CurrentPlID    = $CurrentPlanet['id'];
$CurrentMIP     = $CurrentPlanet['interplanetary_misil'];
$CurrentRC      = $CurrentPlanet['recycler'];
$CurrentGRC     = $CurrentPlanet['giga_recykler'];
$CurrentSP      = $CurrentPlanet['spy_sonde'];
$HavePhalanx    = $CurrentPlanet['phalanx'];
$CurrentSystem  = $CurrentPlanet['system'];
$CurrentGalaxy  = $CurrentPlanet['galaxy'];
$CanDestroy     = $CurrentPlanet[$resource[214]] + $CurrentPlanet[$resource[218]];
$UserDeuterium  = $CurrentPlanet['deuterium'] - 10;
$maxfleet       = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '". $user['id'] ."';", 'fleets');
$maxfleet_count = mysql_num_rows($maxfleet);

CheckPlanetUsedFields($CurrentPlanet);
CheckPlanetUsedFields($lunarow);

if ($UserDeuterium < 20)
die (message($lang['gala']['0011'], $lang['gala']['0012'], 2));

$QryGalaxyDeuterium   = "UPDATE {{table}} SET ";
$QryGalaxyDeuterium  .= "`deuterium` = '". $UserDeuterium ."' ";
$QryGalaxyDeuterium  .= "WHERE ";
$QryGalaxyDeuterium  .= "`id` = '". $CurrentPlanet['id'] ."' ";
$QryGalaxyDeuterium  .= "LIMIT 1;";
doquery($QryGalaxyDeuterium, 'planets');

if (!isset($mode)) {
    if (isset($_GET['mode'])) {
        $mode = intval($_GET['mode']);
    } else {
        $mode = 0;
    }
}

if ($mode == 0) {
    $galaxy = $CurrentPlanet['galaxy'];
    $system = $CurrentPlanet['system'];
    $planet = $CurrentPlanet['planet'];
} elseif ($mode == 1) {

    if ($_POST["galaxyLeft"]) {

        if ($_POST["galaxy"] < 1) {
            $_POST["galaxy"] = 1;
            $galaxy          = 1;
        } elseif ($_POST["galaxy"] == 1) {
            $_POST["galaxy"] = 1;
            $galaxy          = 1;
        } else {
            $galaxy = $_POST["galaxy"] - 1;
        }
    } elseif ($_POST["galaxyRight"]) {

        if ($_POST["galaxy"] > MAX_GALAXY_IN_WORLD OR
            $_POST["galaxyRight"] > MAX_GALAXY_IN_WORLD) {
            $_POST["galaxy"]      = MAX_GALAXY_IN_WORLD;
            $_POST["galaxyRight"] = MAX_GALAXY_IN_WORLD;
            $galaxy               = MAX_GALAXY_IN_WORLD;
        } elseif ($_POST["galaxy"] == MAX_GALAXY_IN_WORLD) {
            $_POST["galaxy"]      = MAX_GALAXY_IN_WORLD;
            $galaxy               = MAX_GALAXY_IN_WORLD;
        } else {
            $galaxy = $_POST["galaxy"] + 1;
        }
    } else {
        $galaxy = $_POST["galaxy"];
    }

    if ($_POST["systemLeft"]) {

        if ($_POST["system"] < 1) {
            $_POST["system"] = 1;
            $system          = 1;
        } elseif ($_POST["system"] == 1) {
            $_POST["system"] = 1;
            $system          = 1;
        } else {
            $system = $_POST["system"] - 1;
        }
    } elseif ($_POST["systemRight"]) {

        if ($_POST["system"] > MAX_SYSTEM_IN_GALAXY OR
            $_POST["systemRight"] > MAX_SYSTEM_IN_GALAXY) {
            $_POST["system"]      = MAX_SYSTEM_IN_GALAXY;
            $system               = MAX_SYSTEM_IN_GALAXY;
        } elseif ($_POST["system"] == MAX_SYSTEM_IN_GALAXY) {
            $_POST["system"]      = MAX_SYSTEM_IN_GALAXY;
            $system               = MAX_SYSTEM_IN_GALAXY;
        } else {
            $system = $_POST["system"] + 1;
        }
    } else {
        $system = $_POST["system"];
    }
} elseif ($mode == 2) {
    $galaxy        = $_GET['galaxy'];
    $system        = $_GET['system'];
    $planet        = $_GET['planet'];
} elseif ($mode == 3) {
    $galaxy        = $_GET['galaxy'];
    $system        = $_GET['system'];
} else {
    $galaxy        = 1;
    $system        = 1;
}

$planetcount = 0;
$lunacount   = 0;

$page  = InsertGalaxyScripts ( $CurrentPlanet);

$page .= "
<table style=\"width:100%;\" cellspacing=\"0\" >
    <tr><td style=\"width:10%;\" valign=\"top\" >
         ";

$page .= ShowGalaxySelector ( $galaxy, $system, $CurrentMIP, $CurrentRC, $CurrentGRC, $CurrentSP );

$page .= "
        </td><td style=\"width:90%;\" valign=\"top\" >

             <table cellspacing=\"0\" style=\"width:800px;\">
                 <tr><td>
         ";

$bild = array('Bild1.png','Bild2.png','Bild3.png','Bild4.png','Bild5.png','Bild6.png', 'Bild7.png','Bild8.png','Bild9.png','Bild10.png','Bild11.png','Bild12.png','Bild13.png','Bild14.png',);
        shuffle($bild);


$page .= "<a href=\"fleet.php?galaxy=".$Galaxy."&amp;system=".$System."&amp;planet=16;planettype=1&amp;target_mission=15\"><img src=\"./styl/image/gala/".$bild[0]."\" alt=\"\"></a>";

$page .= "
                     </td><td>

                          <table cellspacing=\"0\">
         ";

$page .= ShowGalaxyRows   ( $galaxy, $system );

$page .= "
                          </table>
                     </td></tr>
             </table>
        </td></tr>
</table>
         ";

if ($mode == 2) {
    $CurrentPlanetID = $_GET['current'];
    $page .= ShowGalaxyMISelector ( $galaxy, $system, $planet, $CurrentPlanetID, $CurrentMIP );
}

$page .= ShowGalaxyFooter ( $galaxy, $system,  $CurrentMIP, $CurrentRC, $CurrentGRC, $CurrentSP);

$page .= "
<div style='position:absolute; bottom:20px; right:0%; width:150px;' ><a href=\"galaxy.php?mode=0\"><b><u>".$lang['gala']['0013']."</u></b></a></div>
         ";

display ($page, $lang['Galaxy'], true);

?>