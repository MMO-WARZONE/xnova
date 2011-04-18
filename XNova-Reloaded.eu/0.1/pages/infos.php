<?php

/**
 * infos.php
 *
 * @version 1.1
 * @copyright 2008 By Chlorel for XNova
 */

// ----------------------------------------------------------------------------------------------------------
// Appel de la page ...
// Tout le reste ne sert qu'a la calculer :)
//

	$gid  = $_GET['gid'];
	$page = ShowTechs ($user, $planetrow, $gid);

	display ($page, $lang['nfo_page_title']);

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Réécriture (réinventation de l'eau tiède)
// 1.1 - Ajout JumpGate pour la porte de saut comme la présente OGame ... Enfin un peu mieux quand meme !
?>