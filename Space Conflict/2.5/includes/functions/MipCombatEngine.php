<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** MIPCombatEngine.php                   **
******************************************/

function MipAttack ($NbreMip, $IDAversaire) {
    $TechnoArme = doquery("SELECT * FROM {{table}} WHERE `id`='" . $user['id'] . "'", "users");
    $InfoAdversaire = doquery("SELECT * FROM {{table}} WHERE `id`='" . $IDAversaire . "'", "planets", true);

    $PuissanceAttaque = ($NbreMip * 12000) * (1.05 * $TechnoArme['military_tech']);

    $TableauDeDefense = array(
		401 => array ('shield' => 20),
        402 => array ('shield' => 25),
        403 => array ('shield' => 100),
        404 => array ('shield' => 200),
        405 => array ('shield' => 500),
        406 => array ('shield' => 300),
        407 => array ('shield' => 2000),
        408 => array ('shield' => 2000)
    );

    $DefenseAdversaire = array(
		401 => ($InfoAdversaire['misil_launcher']),
        402 => ($InfoAdversaire['small_laser']),
        403 => ($InfoAdversaire['big_laser']),
        404 => ($InfoAdversaire['gauss_canyon']),
        405 => ($InfoAdversaire['ionic_canyon']),
        406 => ($InfoAdversaire['buster_canyon']),
        407 => ($InfoAdversaire['small_protection_shield']),
        408 => ($InfoAdversaire['big_protection_shield'])
	);

    while ($PuissanceAttaque > 20) {
        $RandomDefense = rand(401, 408);

        $SelectionDefense = $DefenseAdversaire[$RandomDefense];
        if ($SelectionDefense > 0) {
            if ($PuissanceAttaque > ($SelectionDefense * $TableauDeDefense[$RandomDefense])) {
                $PuissanceAttaque = $PuissanceAttaque - ($SelectionDefense * $TableauDeDefense[$RandomDefense]);
                $DefenseAdversaire[$RandomDefense] = $DefenseAdversaire[$RandomDefense] - 1;
            }
        }
    }

    $SqlDefenseur = "UPDATE {{table}} SET ";
    $SqlDefenseur .= "`small_laser`='".$DefenseAdversaire[402]."', ";
    $SqlDefenseur .= "`big_laser`='".$DefenseAdversaire[403]."', ";
    $SqlDefenseur .= "`gauss_canyon`='".$DefenseAdversaire[404]."', ";
    $SqlDefenseur .= "`ionic_canyon`='".$DefenseAdversaire[405]."', ";
    $SqlDefenseur .= "`buster_canyon`='".$DefenseAdversaire[406]."', ";
    $SqlDefenseur .= "`small_protection_shield`='".$DefenseAdversaire[407]."', ";
    $SqlDefenseur .= "`big_protection_shield`='".$DefenseAdversaire[408]."' ";
    $SqlDefenseur .= " WHERE `id`='".$IDAversaire."'";

    doquery($SqlDefenseur, 'planets');

}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/ 

?>