<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

includeLang('tech');

    $HeadTpl = gettemplate('techtree_head');
    $RowTpl  = gettemplate('techtree_row');
    $id = 0;
    foreach($lang['tech'] as $Element => $ElementName) {
        $verif = 1;
        $parse            = array();
        $parse['tt_name'] = $ElementName;
        if ($Element >= 601 && $Element <= 615) {
            $parse['dpath']        = $dpath.'officiers/';
            $parse['ext'] = 'jpg';
        }
        else
        {
            $parse['dpath']        = $dpath.'gebaeude/';
            $parse['ext'] = 'gif';
        }
        if (!isset($resource[$Element])) {
            $parse['Requirements']  = $lang['Requirements'];
            $parse['Batiments'] = $lang['Batiments'];
            $parse['BatimentsSpeciaux'] = $lang['BatimentsSpeciaux'];
            $parse['Recherches']= $lang['Recherches'];
            $parse['Vaisseaux'] = $lang['Vaisseaux'];
            $parse['Defenses'] = $lang['Defenses'];
            $parse['Officiers'] = $lang['Officiers'];
            $parse['id'] = 'id='.$id;
            $id++;
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
                        $verif = 0;
                    }
                    $parse['required_list'] .= $lang['tech'][$ResClass] ." ( ". $lang['level'] ." ". $user[$resource[$ResClass]] ." ". $planetrow[$resource[$ResClass]] ." / ". $Level ." )";
                    $parse['required_list'] .= "</font><br>";
                }
                $parse['tt_detail']      = "<a href=\"techdetails.php?techid=". $Element ."\">" .$lang['treeinfo'] ."</a>";
            } else {
                $parse['required_list'] = "";
                $parse['tt_detail']     = "";
            }
            if ($verif == 1) {
                $parse['dispo'] = "<font color=green>Verf&uuml;gbar</font>";
            }
            else
            {
                $parse['dispo'] = "<font color=red>Nicht baubar</font>";
            }
            $parse['tt_info']   = $Element;
            $page              .= parsetemplate($RowTpl, $parse); 
		}
	}

	$parse['techtree_list'] = $page;

	display(parsetemplate(gettemplate('techtree_body'), $parse), $lang['Tech']);


?>