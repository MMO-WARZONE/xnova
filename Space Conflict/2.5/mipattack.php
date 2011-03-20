<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** mipattack.php                         **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

$Attaquant = $_GET['current'];
$NbreMip   = $_POST['SendMI'];

$Galaxy    = $_GET['galaxy'];
$System    = $_GET['system'];
$Planet    = $_GET['planet'];

$PlaneteAttaquant = doquery("SELECT * FROM {{table}} WHERE `id`='" . $Attaquant . "'", "planets", true);
$PlaneteAdverse   = doquery("SELECT * FROM {{table}} WHERE galaxy = " . $Galaxy . " AND system = " . $System . " AND planet = " . $Planet . "", "planets", true);

$MipAttaquant = $PlaneteAttaquant['interplanetary_misil'];
if ($MipAttaquant < $NbreMip) {
    message('You do not have enough missiles !', 'Error');
}

$AntiMipAdverse = $PlaneteAdverse['interceptor_misil'];
$MipRestant     = $NbreMip - $AntiMipAdverse;
$AntiMipRestant = $$AntiMipAdverse - $NbreMip;

echo $MipRestant;
echo $AntiMipRestant;

if ($MipRestant <= 0) {
    doquery("UPDATE {{table}} SET `interplanetary_misil`='0' WHERE `id`='" . $Attaquant . "'", "planets");
    doquery("UPDATE {{table}} SET `interceptor_misil`='" . $AntiMipRestant . "' WHERE `id`='" . $PlaneteAdverse['id_owner'] . "'", "planets");

    $Owner    = $user['id'];
    $Sender   = "0";
    $Time     = time();
    $Type     = 3;
    $From     = "Headquarters";
    $Subject  = "Missile Attack Report";
    $Message  = "Unfortunately all your interplanetary missiles were destroyed by the opposing defense system.";
    SendSimpleMessage($Owner, $Sender, $Time, $Type, $From, $Subject, $Message);

    $Owner2   = $PlaneteAdverse['id_owner'];
    $Message2 = "You have destroyed " . $NbreMip . " enemy missiles. <br>You still have " . $AntiMipRestant . " Interceptor Missiles";
    SendSimpleMessage($Owner2, $Sender, $Time, $Type, $From, $Subject, $Message2);
}

if($MipRestant > 0){
	$Id = $PlaneteAdverse['id'];
	MipAttack($NbreMip, $Id);
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>