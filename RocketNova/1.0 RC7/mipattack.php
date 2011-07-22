<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

includeLang('mipattack');

// Recup des variables
$Attaquant = $_GET['current'];
$NbreMip   = $_POST['SendMI'];

$Galaxy    = $_GET['galaxy'];
$System    = $_GET['system'];
$Planet    = $_GET['planet'];

$PlaneteAttaquant = doquery("SELECT * FROM {{table}} WHERE `id`='" . $Attaquant . "'", "planets", true);
$PlaneteAdverse   = doquery("SELECT * FROM {{table}} WHERE galaxy = " . $Galaxy . " AND system = " . $System . " AND planet = " . $Planet . "", "planets", true);

$MipAttaquant = $PlaneteAttaquant['interplanetary_misil'];
if ($MipAttaquant < $NbreMip) {
	message($lang['MIPATTACK_NOT_ENOUGH_MIPS'], $lang['MIPATTACK_ERROR_TITLE']);
}

$AntiMipAdverse = $PlaneteAdverse['interceptor_misil'];
$MipRestant     = $NbreMip - $AntiMipAdverse;
$AntiMipRestant = $$AntiMipAdverse - $NbreMip;

echo $MipRestant;
echo $AntiMipRestant;
// L'attaquant se fait exploser tout ses MIP
if ($MipRestant <= 0) {
	doquery("UPDATE {{table}} SET `interplanetary_misil`='0' WHERE `id`='" . $Attaquant . "'", "planets");
	doquery("UPDATE {{table}} SET `interceptor_misil`='" . $AntiMipRestant . "' WHERE `id`='" . $PlaneteAdverse['id_owner'] . "'", "planets");
	// Message à l'attaquant
	$Owner    = $user['id'];
	$Sender   = "0";
	$Time     = time();
	$Type     = 3;
	$From     = $lang['MIPATTACK_MESSAGE_FROM'];
	$Subject  = $lang['MIPATTACK_MESSAGE_SUBJECT'];
	$Message  = $lang['MIPATTACK_MESSAGE_TEXT'];
	SendSimpleMessage($Owner, $Sender, $Time, $Type, $From, $Subject, $Message);

	// Message a l'attaqué
	$Owner2   = $PlaneteAdverse['id_owner'];
	$Message2 = str_replace('##mips##', $NbreMip, str_replace('##def##', $AntiMipRestant, $lang['MIPATTACK_DEFENDER_MESSAGE_TEXT']));
	SendSimpleMessage($Owner2, $Sender, $Time, $Type, $From, $Subject, $Message2);
}

if($MipRestant > 0){
	$Id = $PlaneteAdverse['id'];
	MipAttack($NbreMip, $Id);
}
?>