<?php

/**
 * techtree.php
 *
 * @version 1.1
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

	//comprobación ESTADO modulo
	$query = doquery("SELECT estado FROM {{table}} where modulo='Tecnologia'", 'modulos', true); //Sacamos el estado.
	if($query[0] == "0") { message("Modulo Inactivo.","Modulo Inactivo"); }
	//Fin comprobación
	
	
// blocking non-users
if ($IsUserChecked == false) {
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

	$HeadTpl = gettemplate('techtree_head');
	$RowTpl  = gettemplate('techtree_row');
	foreach($lang['tech'] as $Element => $ElementName) {
		$parse            = array();
		$parse['tt_name'] = $ElementName;
		if (!isset($resource[$Element])) {
			$parse['Requirements']  = $lang['Requirements'];
			$page                  .= parsetemplate($HeadTpl, $parse);
		} else {
			if (isset($requeriments[$Element])) {
				$parse['required_list'] = "";
				foreach($requeriments[$Element] as $ResClass => $Level) {
					if       ( isset( $user[$resource[$ResClass]] ) &&
						 $user[$resource[$ResClass]] >= $Level) {
						$parse['required_list'] .= "<font color=\"#00ff00\">";
					} elseif ( isset($planetrow[$resource[$ResClass]] ) &&
						$planetrow[$resource[$ResClass]] >= $Level) {
						$parse['required_list'] .= "<font color=\"#00ff00\">";
					} else {
						$parse['required_list'] .= "<font color=\"#ff0000\">";
					}
					$parse['required_list'] .= $lang['tech'][$ResClass] ." (". $lang['level'] ." ". $Level .")";
					$parse['required_list'] .= "</font><br>";
				}
				$parse['tt_detail']      = "<a href=\"techdetails.php?techid=". $Element ."\">" .$lang['treeinfo'] ."</a>";
			} else {
				$parse['required_list'] = "";
				$parse['tt_detail']     = "";
			}
			$parse['tt_info']   = $Element;
			$page              .= parsetemplate($RowTpl, $parse);
		}
	}

	$parse['techtree_list'] = $page;
	$page                   = parsetemplate(gettemplate('techtree_body'), $parse);

	display($page, $lang['Tech']);

// -----------------------------------------------------------------------------------------------------------
// History version
// - 1.0 mise en conformité code avec skin XNova
// - 1.1 ajout lien pour les details des technos
// - 1.2 suppression du lien details ou il n'est pas necessaire
?>
