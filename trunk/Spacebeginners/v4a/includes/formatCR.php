<?php

function formatCR (&$result_array,&$steal_array,&$moon_int,&$moon_string,&$time_float) {
    global $phpEx, $xnova_root_path, $pricelist, $lang, $resource, $CombatCaps, $game_config, $dpath;

    includeLang('fleet');
    includeLang('tech');

    $dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
    $parse['dpath'] = $dpath;

    $html  = "<table cellspacing=\"0\" cellpadding=\"0\" style=\"width:510px;\">
                  <tr><td align=\"center\" style=\"width:510px;\"><img style=\"width:100%; height:12px;\" src=\"./".$dpath."balken/menu_56.png\" alt=\"\"></td></tr>
                  <tr><td align=\"center\" style=\"width:510px;\" class=\"sb\">".$lang['title_rc']." ".date("D j M Y H:i:s", time()).". </td></tr>
                  <tr><td align=\"center\" style=\"width:510px;\"><img style=\"width:100%; height:12px;\" src=\"./".$dpath."balken/menu_57.png\" alt=\"\"></td></tr>
              </table>

              <table cellspacing=\"0\" cellpadding=\"0\">
                  <tr><td>";

    $round_no = 1;
    foreach( $result_array['rw'] as $round => $data1){

        $html .= "        </td></tr>
                  </table>

                  <br><br>

                  <table cellpadding=\"0\" cellspacing=\"0\">
                      <tr><td align=\"center\" style=\"width:200px;\"><img style=\"width:100%; height:12px;\" src=\"./".$dpath."balken/menu_52.png\" alt=\"\"></td></tr>
                      <tr><td align=\"center\" style=\"width:200px;\" class=\"sb\">".$lang['round']." ".$round_no."</td></tr>
                      <tr><td align=\"center\" style=\"width:200px;\"><img style=\"width:100%; height:12px;\" src=\"./".$dpath."balken/menu_53.png\" alt=\"\"></td></tr>
                  </table>

                  <table>
                      <tr><td style=\"height:3px;\"></td></tr>
                  </table>

                  <table cellspacing=\"0\" cellpadding=\"0\">
                      <tr><td>";

        $attackers1 = $data1['attackers'];
        $attackers2 = $data1['infoA'];
        $attackers3 = $data1['attackA'];
        $defenders1 = $data1['defenders'];
        $defenders2 = $data1['infoD'];
        $defenders3 = $data1['defenseA'];
        $coord4 = 0;
        $coord5 = 0;
        $coord6 = 0;

        foreach( $attackers1 as $fleet_id1 => $data2){

            $name = $data2['user']['username'];
            $coord1 = $data2['fleet']['fleet_start_galaxy'];
            $coord2 = $data2['fleet']['fleet_start_system'];
            $coord3 = $data2['fleet']['fleet_start_planet'];
            $weap = ($data2['user']['military_tech'] *10) + ($data2['user']['rpg_amiral'] * 5);
            $shie = ($data2['user']['shield_tech'] * 10) + ($data2['user']['rpg_amiral'] * 5);
            $armr = ($data2['user']['defence_tech'] * 10) + ($data2['user']['rpg_amiral'] * 5);

            if($round_no == 1) {

                if(!$angreifer) {
                    $angreifer = $name;
                    $ang = $name;
                    $angnr++;
                } else {
                    $angreifer = $angreifer." &amp; ".$name;
                    $angnr++;
                }
            }

            if($coord4 == 0){$coord4 += $data2['fleet']['fleet_end_galaxy'];}
            if($coord5 == 0){$coord5 += $data2['fleet']['fleet_end_system'];}
            if($coord6 == 0){$coord6 += $data2['fleet']['fleet_end_planet'];}

            $fl_info1  = "<table cellpadding=\"0\" cellspacing=\"0\">
                              <tr><td align=\"center\" style=\"width:773px;\"><img style=\"width:100%; height:12px;\" src=\"./".$dpath."balken/menu_56.png\" alt=\"\"></td></tr>
                              <tr><td class=\"sb\" align=\"center\" style=\"width:100%;\">".$lang['attacker']." ".$name." ([".$coord1.":".$coord2.":".$coord3."])<br>
                                                                                          ".$lang['weapon']." ".$weap."% - ".$lang['shield']." ".$shie."% - ".$lang['armour']." ".$armr."%</td></tr>
                           </table>";

            if (number_format($data1['attack']['total']) > 0) {
                $ships1  = "<table cellpadding=\"0\" cellspacing=\"0\" style=\"width:773px;\">
                                <tr><td style=\"width:100%;\">

                                    <table cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%;\">
                                        <tr><td class=\"sb\" style=\"height:5px;\" colspan=\"5\">&nbsp;</td></tr>
                                        <tr><td style=\"width:20%;\">

                                            <table cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%;\">
                                                <tr><td align=\"center\" style=\"width:100%;\" class=\"sb\"><u>".$lang['fl_fleet_typ']."</u></td></tr>";

                $count1  = "<table cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%;\">
                                <tr><td align=\"center\" style=\"width:100%;\" class=\"sb\"><u>".$lang['fl_count']."</u></td></tr>";

                foreach( $data2['detail'] as $ship_id1 => $ship_count1){
                    if ($ship_count1 > 0){
                        $ships1 .= "<tr><td align=\"left\" style=\"width:100%;\" class=\"sb\">- [ship[".$ship_id1."]]:</td></tr>";
                        $count1 .= "<tr><td align=\"center\" style=\"width:100%;\" class=\"sb\">".number_format($ship_count1, 0, ',', '.')."</td></tr>";
                    }
                }

                $ships1 .= "</table></td><td style=\"width:20%;\">";
                $count1 .= "</table></td><td style=\"width:20%;\">";
            } else {
                $ships1 = "<table cellspacing=\"0\" cellpadding=\"0\" style=\"width:773px;\">
                               <tr><td align=\"center\" style=\"width:773px;\" class=\"sb\">". $lang['sys_destroyed']."</td></tr>
                               <tr><td align=\"center\" style=\"width:100%;\" colspan=\"5\" ><img style=\"width:100%; height:12px;\" src=\"./".$dpath."balken/menu_57.png\" alt=\"\"></td></tr>
                           </table>";
                $count1 = "";
            }

            $info_part1[$fleet_id1] = $fl_info1.$ships1.$count1;
        }

        foreach( $attackers2 as $fleet_id2 => $data3){
            $weap1    = "<table cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%;\">
                             <tr><td align=\"center\" style=\"width:100%;\" class=\"sb\"><u>".$lang['weapon']."</u></td></tr>";

            $shields1 = "<table cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%;\">
                             <tr><td align=\"center\" style=\"width:100%;\" class=\"sb\"><u>".$lang['shield']."</u></td></tr>";

            $armour1  = "<table cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%;\">
                             <tr><td align=\"center\" style=\"width:100%;\" class=\"sb\"><u>".$lang['armour']."</u></td></tr>";

            foreach( $data3 as $ship_id2 => $ship_points1){

                if ($ship_points1['shield'] > 0){
                    $weap1    .= "<tr><td align=\"center\" style=\"width:100%;\" class=\"sb\">".number_format($ship_points1['att'], 0, ',', '.')."</td></tr>";
                    $shields1 .= "<tr><td align=\"center\" style=\"width:100%;\" class=\"sb\">".number_format($ship_points1['shield'], 0, ',', '.')."</td></tr>";
                    $armour1  .= "<tr><td align=\"center\" style=\"width:100%;\" class=\"sb\">".number_format($ship_points1['def'], 0, ',', '.')."</td></tr>";
                }
            }

            $weap1    .= "</table>

                              </td>
                         <td style=\"width:20%;\">";

            $shields1 .= "</table>

                              </td>
                         <td style=\"width:20%;\">";

            $armour1  .= "</table>

                              </td></tr>
                     <tr><td align=\"center\" style=\"width:100%;\" colspan=\"5\"><img style=\"width:100%; height:12px;\" src=\"./".$dpath."balken/menu_57.png\" alt=\"\"></td></tr>
                 </table>
                     </td></tr>
            </table>";

            $info_part2[$fleet_id2] = $weap1.$shields1.$armour1;

            if (number_format($data1['attack']['total']) > 0) { //Est-ce un desastre ?
                $html .= "".$info_part1[$fleet_id2].$info_part2[$fleet_id2]."";
                $html .= "    </td>
                          <td style=\"width:2px;\">&nbsp;</td>
                          <td>";
            } else {
                $html .= $info_part1[$fleet_id2]."";
                $html .= "";
            }

        }
        $html .= "         </td></tr>
                  </table>

                  <br>

                  <table cellspacing=\"0\" cellpadding=\"0\">
                      <tr><td>";

        foreach( $defenders1 as $fleet_id1 => $data2){
            $name = $data2['user']['username'];
            $weap = ($data2['user']['military_tech'] * 10) + ($data2['user']['rpg_amiral'] * 5);
            $shie = ($data2['user']['shield_tech'] * 10) + ($data2['user']['rpg_amiral'] * 5);
            $armr = ($data2['user']['defence_tech'] * 10) + ($data2['user']['rpg_amiral'] * 5);

            $fl_info2  = "<table cellpadding=\"0\" cellspacing=\"0\">
                              <tr><td align=\"center\" style=\"width:773px;\"><img style=\"width:100%; height:12px;\" src=\"./".$dpath."balken/menu_56.png\" alt=\"\"></td></tr>
                              <tr><td class=\"sb\" align=\"center\" style=\"width:100%;\">".$lang['defender']." ".$name." ([".$coord1.":".$coord2.":".$coord3."])<br>
                                                                                          ".$lang['weapon']." ".$weap."% - ".$lang['shield']." ".$shie."% - ".$lang['armour']." ".$armr."%</td></tr>
                          </table>";

            if (number_format($data1['defense']['total']) > 0) {
                $ships2  = "<table cellpadding=\"0\" cellspacing=\"0\" style=\"width:773px;\">
                                <tr><td style=\"width:100%;\">

                                    <table cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%;\">
                                        <tr><td class=\"sb\" style=\"height:5px;\" colspan=\"5\">&nbsp;</td></tr>
                                        <tr><td style=\"width:20%;\">

                                            <table cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%;\">
                                                <tr><td align=\"center\" style=\"width:100%;\" class=\"sb\"><u>".$lang['fl_fleet_typ']."</u></td></tr>";

                $count2  = "<table cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%;\">
                                <tr><td align=\"center\" style=\"width:100%;\" class=\"sb\"><u>".$lang['fl_count']."</u></td></tr>";

                foreach( $data2['def'] as $ship_id1 => $ship_count1){

                    if ($ship_count1 > 0){
                        $ships2 .= "<tr><td align=\"left\" style=\"width:100%;\" class=\"sb\">- [ship[".$ship_id1."]]:</td></tr>";
                        $count2 .= "<tr><td align=\"center\" style=\"width:100%;\" class=\"sb\">".number_format($ship_count1, 0, ',', '.')."</td></tr>";
                    }
                }
                $ships2 .= "</table></td><td style=\"width:20%;\">";
                $count2 .= "</table></td><td style=\"width:20%;\">";
            } else {
                $ships2 = "<table cellspacing=\"0\" cellpadding=\"0\" style=\"width:773px;\">
                               <tr><td align=\"center\" style=\"width:773px;\" class=\"sb\">". $lang['sys_destroyed']."</td></tr>
                               <tr><td align=\"center\" style=\"width:100%;\" colspan=\"5\"><img style=\"width:100%; height:12px;\" src=\"./".$dpath."balken/menu_57.png\" alt=\"\"></td></tr>
                           </table></td><td>";
                $count2 = "";
            }

            $info_part1[$fleet_id1] = $fl_info2.$table2.$ships2.$count2;
        }

        foreach( $defenders2 as $fleet_id2 => $data3){
            $weap2    = "<table cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%;\">
                             <tr><td align=\"center\" style=\"width:100%;\" class=\"sb\"><u>".$lang['weapon']."</u></td></tr>";

            $shields2 = "<table cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%;\">
                             <tr><td align=\"center\" style=\"width:100%;\" class=\"sb\"><u>".$lang['shield']."</u></td></tr>";

            $armour2  = "<table cellspacing=\"0\" cellpadding=\"0\" style=\"width:100%;\">
                             <tr><td align=\"center\" style=\"width:100%;\" class=\"sb\"><u>".$lang['armour']."</u></td></tr>";

            foreach( $data3 as $ship_id2 => $ship_points1){

                if ($ship_points1['shield'] > 0){
                    $weap2    .= "<tr><td align=\"center\" style=\"width:100%;\" class=\"sb\">".number_format($ship_points1['att'], 0, ',', '.')."</td></tr>";
                    $shields2 .= "<tr><td align=\"center\" style=\"width:100%;\" class=\"sb\">".number_format($ship_points1['shield'], 0, ',', '.')."</td></tr>";
                    $armour2  .= "<tr><td align=\"center\" style=\"width:100%;\" class=\"sb\">".number_format($ship_points1['def'], 0, ',', '.')."</td></tr>";
                }
            }

            $weap2    .= "</table>

                              </td>
                         <td style=\"width:20%;\">";

            $shields2 .= "</table>

                              </td>
                         <td style=\"width:20%;\">";

            $armour2  .= "</table>

                              </td></tr>
                     <tr><td align=\"center\" style=\"width:100%;\" colspan=\"5\"><img style=\"width:100%; height:12px;\" src=\"./".$dpath."balken/menu_57.png\" alt=\"\"></td></tr>
                 </table>
                     </td></tr>
            </table>";
            $info_part2[$fleet_id2] = $weap2.$shields2.$armour2.$endtable2;

            if (number_format($data1['defense']['total']) > 0) { //Est-ce un desatre ?
                $html .= $info_part1[$fleet_id2].$info_part2[$fleet_id2];
                $html .= "</td><td style=\"width:2px;\"></td> <td>";
            } else {
                $html .= $info_part1[$fleet_id2];
                $html .= "";
            }
        }

        $html .= "         </td></tr>
                  </table>

                  <br><br>

                  <table cellspacing=\"0\" cellpadding=\"0\">
                      <tr><td>

                          <table cellspacing=\"0\" cellpadding=\"0\">
                              <tr><td align=\"center\" style=\"width:773px;\"><img style=\"width:100%; height:12px;\" src=\"./".$dpath."balken/menu_56.png\" alt=\"\"></td></tr>
                              <tr><td class=\"sb\" align=\"center\" style=\"width:100%;\">".$lang['fleet_attack_1']." ".number_format($data1['attack']['total'], 0, ',', '.')." <br>
                                                                                          ".$lang['fleet_attack_2']." ".number_format($data1['defShield'], 0, ',', '.')." ".$lang['damage']."<br><br>
                                                                                          ".$lang['fleet_defs_1']." ".number_format($data1['defense']['total'], 0, ',', '.')."<br>
                                                                                          ".$lang['fleet_defs_2']." ".number_format($data1['attackShield'], 0, ',', '.')." ".$lang['damage']."</td></tr>
                              <tr><td align=\"center\" style=\"width:773px;\"><img style=\"width:100%; height:12px;\" src=\"./".$dpath."balken/menu_57.png\" alt=\"\"></td></tr>
                          </table>";
        $round_no++;

    }

    $html .= "         </td></tr>
              </table>

              <br><br><br>";

    $html .= "<table cellspacing=\"0\" cellpadding=\"0\">
                  <tr><td align=\"center\" style=\"width:773px;\"><img style=\"width:100%; height:12px;\" src=\"./".$dpath."balken/menu_56.png\" alt=\"\"></td></tr>
                  <tr><td class=\"sb\" align=\"center\" style=\"width:100%;\">";

    if ($result_array['won'] == "r"){
        $result1  = $lang['defs_win']."<br>";
    }elseif ($result_array['won'] == "a"){
        $result1  = $lang['attack_win']."<br>";
        $result1 .= $lang['resource_take']." ".pretty_number($steal_array['metal'])." ".$lang['Metal'].", ".pretty_number($steal_array['crystal'])." ".$lang['Crystal'].", ".pretty_number($steal_array['deuterium'])." ".$lang['Deuterium']." ".$lang['and']." ".pretty_number($steal_array['appolonium'])." ".$lang['Appolonium']."<br>";
    }elseif ($result_array['won'] == "w"){
        $won = array('attackers' => $attackers, 'defenders' => $defenders, 'attack' => $attackDamage, 'defense' => $defenseDamage, 'attackA' => $attackAmount, 'defenseA' => $defenseAmount);
        $result1  = $lang['draw'].".<br>";
    }

    $html .= $result1;
    $html .= "<br>";

    $debirs_meta = ($result_array['debree']['att'][0] + $result_array['debree']['def'][0]);
    $debirs_crys = ($result_array['debree']['att'][1] + $result_array['debree']['def'][1]);
    $debirs_appo = ($result_array['debree']['att'][2] + $result_array['debree']['def'][2]);

    $html .= $lang['attack_loose_units']." ".pretty_number(round($result_array['lost']['att']))." ".$lang['units']."<br>";
    $html .= $lang['defs_loose_units']." ".pretty_number(round($result_array['lost']['def']))." ".$lang['units']."<br>";
    $html .= $lang['debree_field_1']." ".pretty_number($debirs_meta)." ".$lang['debree_field_2']." ".pretty_number($debirs_crys)." ".$lang['debree_field_3']."".pretty_number($debirs_appo)." ".$lang['debree_field_4']."<br><br>";
    $html .= $moondes."<br><br>";
    $html .= $lang['moon_chance']." ".$moon_int." ".$lang['percent_moon']."<br>";
    $html .= $moon_string."<br><br>";
    $html .= $lang['calculate_rc']." ".$time_float." ".$lang['seconds']."<br ></td></tr>";
    $html .= "<tr><td align=\"center\" style=\"width:773px;\"><img style=\"width:100%; height:12px;\" src=\"./".$dpath."balken/menu_57.png\" alt=\"\"></td></tr>
          </table>";

    return array('html' => $html, 'bbc' => $bbc, 'angreifer' => $angreifer);
}

?>