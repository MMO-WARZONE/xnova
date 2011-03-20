<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** techtree.php                          **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

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

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>