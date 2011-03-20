<?php
//version 1


if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowImperiumPage($CurrentUser)
{
	global $lang, $resource,$db, $reslist, $dpath,$displays;

        $displays->assignContent("empire/imperium");
	$planetsrow = $db->query("	SELECT * FROM {{table}} WHERE
			      `id_owner` = '" . $CurrentUser['id'] . "'
			      AND `destruyed` = 0;", 'planets');
        $planet = array();


            while ($p = mysql_fetch_array($planetsrow)) {
                    $planet[] = $p;
            }

            $displays->assignGlobal("mount",count($planet) + 1);

            foreach ($planet as $p) {

                $data['text'] = '<a href="game.php?page=overview&cp=' . $p['id'] . '&amp;re=0"><img src="' . $dpath . 'planeten/small/s_' . $p['image'] . '.jpg" border="0" height="71" width="75"></a>';
                $parse['file_images'] .= '<th width="75">'. $data['text'].'</th>';

                $data['text'] = $p['name'];
                $parse['file_names'] .= '<th width="75">'. $data['text'].'</th>';

                $data['text'] = "[<a href=\"game.php?page=galaxy&mode=3&galaxy={$p['galaxy']}&system={$p['system']}\">{$p['galaxy']}:{$p['system']}:{$p['planet']}</a>]";
                $parse['file_coordinates'] .= '<th width="75">'. $data['text'].'</th>';

                $data['text'] = $p['field_current'] . '/' . $p['field_max'];
                $parse['file_fields'] .= '<th width="75">'. $data['text'].'</th>';

                $data['text'] = '<a href="game.php?page=resources&cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">'. pretty_number($p['metal']) .'</a> / '. pretty_number($p['metal_perhour']);
                $parse['file_metal'] .= '<th width="75">'. $data['text'].'</th>';

                $data['text'] = '<a href="game.php?page=resources&cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">'. pretty_number($p['crystal']) .'</a> / '. pretty_number($p['crystal_perhour']);
                $parse['file_crystal'] .= '<th width="75">'. $data['text'].'</th>';

                $data['text'] = '<a href="game.php?page=resources&cp=' . $p['id'] . '&amp;re=0&amp;planettype=' . $p['planet_type'] . '">'. pretty_number($p['deuterium']) .'</a> / '. pretty_number($p['deuterium_perhour']);
                $parse['file_deuterium'] .= '<th width="75">'. $data['text'].'</th>';

                $data['text'] = pretty_number($p['energy_max'] - abs($p['energy_used'])) . ' / ' . pretty_number($p['energy_max']);
                $parse['file_energy'] .= '<th width="75">'. $data['text'].'</th>';

                foreach ($resource as $i => $res) {
                        if (in_array($i, $reslist['build'])){
                                $data['text'] = ($p[$resource[$i]]    == 0) ? '-' : "<a href=\"game.php?page=buildings&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>";
                        }
                        elseif (in_array($i, $reslist['tech'])){
                                $data['text'] = ($CurrentUser[$resource[$i]] == 0) ? '-' : "<a href=\"game.php?page=buildings&mode=research&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$CurrentUser[$resource[$i]]}</a>";
                        }
                        elseif (in_array($i, $reslist['fleet'])){
                                $data['text'] = ($p[$resource[$i]]    == 0) ? '-' : "<a href=\"game.php?page=buildings&mode=fleet&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>";
                        }
                        elseif (in_array($i, $reslist['defense'])){
                                $data['text'] = ($p[$resource[$i]]    == 0) ? '-' : "<a href=\"game.php?page=buildings&mode=defense&cp={$p['id']}&amp;re=0&amp;planettype={$p['planet_type']}\">{$p[$resource[$i]]}</a>";
                        }

                        $r[$i] .= '<th width="75">'. $data['text'].'</th>';
                }
                foreach($parse as $name => $trans){
                    $displays->assign($name, $trans);
                }
        }

        $array=array(   "build"=>'buildings',
                        "tech"=>'technology',
                        'defense'=>'defenses',
                        'fleet'=>'ships');

        foreach($array as $ab => $ac ){
                $displays->newBlock("name");
                $displays->assign("name",$lang['iv_'.$ac]);
                foreach ($reslist[$ab] as $a => $i) {
                        $displays->newBlock("list");
                        $displays->assign("text",$lang['tech'][$i]);
                        $displays->assign("text2", $r[$i]);
                }

        }

	$displays->display("Imperium");
}
?>