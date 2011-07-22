<?php

/**
 * verband.php
 *
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

    includeLang('fleet');

    $fleetid = $_POST['fleetid'];

    if (!is_numeric($fleetid) || empty($fleetid)) {
        header("Location: fleet.php");
        exit();
    }

    // Ajout d'un joueur dans la liste des invités (MadnessRed code)
 if(isset($_POST['add_member_to_aks']) && !empty($_POST['add_member_to_aks'])){
    $added_user_id_mr = 0;
    $member_qry_mr = doquery("SELECT `id` FROM {{table}} WHERE `username` ='".$_POST['addtogroup']."' ;",'users');
    while($row = mysql_fetch_array($member_qry_mr)){
        $added_user_id_mr .= $row['id'];
    }
    if($added_user_id_mr > 0){
        $new_eingeladen_mr = $_POST['aks_invited_mr'].','.$added_user_id_mr;
 doquery("UPDATE {{table}} SET `eingeladen` = '".$new_eingeladen_mr."' ;",'aks') or die($lang['fl_Add_member_to_fleet'].": <br />".mysql_error());
 $add_user_message_mr = "<font color=\"lime\">".$lang['fl_player']." ".$_POST['addtogroup']." ". $lang['fl_Add_to_attack'];
    }else{
 $add_user_message_mr = "<font color=\"red\">".$lang['fl_error']." ".$lang['fl_player']." ".$_POST['addtogroup']." ".$lang['fl_dont_exist'].".";
    }
        // Envois du message
        $invite_message = $lang['fl_player']." ".$user['username']." ".$lang['fl_aks_invitation'];
        SendSimpleMessage ( $added_user_id_mr, $user['id'], time(), 1, $user['username'], "AG Invitation", $invite_message);
    }

    // Liste des flottes
    $query = doquery("SELECT * FROM {{table}} WHERE fleet_id = '" . $fleetid . "'", 'fleets');

    if (mysql_num_rows($query) != 1) {
        message($lang['fl_fleet_not_exist'], $lang['fl_error']);
    }

    $daten = mysql_fetch_array($query);

    if ($daten['fleet_start_time'] <= time() || $daten['fleet_end_time'] < time() || $daten['fleet_mess'] == 1) {
        message($lang['fl_isback'], $lang['fl_error']);
    }

    // Création d'une AG
    if (!isset($_POST['send'])) {
        SetSelectedPlanet ( $user );

        $planetrow = doquery("SELECT * FROM {{table}} WHERE `id` = '".$user['current_planet']."';", 'planets', true);
        $galaxyrow = doquery("SELECT * FROM {{table}} WHERE `id_planet` = '".$planetrow['id']."';", 'galaxy', true);
        $dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
        $maxfleet = doquery("SELECT COUNT(fleet_owner) as ilosc FROM {{table}} WHERE fleet_owner='{$user['id']}'", 'fleets', true);
        $maxfleet_count = $maxfleet["ilosc"];
        
        CheckPlanetUsedFields($planetrow);

        $fleet = doquery("SELECT * FROM {{table}} WHERE fleet_id = '" . $fleetid . "'", 'fleets', true);

        if (empty($fleet['fleet_group'])) {
            $rand = mt_rand(100000, 999999999);
            $aks_code_mr = "AG".$rand;
            $aks_invited_mr = $user['id'];

        doquery(
        "INSERT INTO {{table}} SET
        `name` = '" . $aks_code_mr . "',
        `teilnehmer` = '" . $user['id'] . "',
        `flotten` = '" . $fleetid . "',
        `ankunft` = '" . $fleet['fleet_start_time'] . "',
        `galaxy` = '" . $fleet['fleet_end_galaxy'] . "',
        `system` = '" . $fleet['fleet_end_system'] . "',
        `planet` = '" . $fleet['fleet_end_planet'] . "',
        `planet_type` = '" . $fleet['fleet_end_type'] . "',
        `eingeladen` = '" . $aks_invited_mr . "'
        ",
        'aks');

        $aks = doquery(
        "SELECT * FROM {{table}} WHERE
        `name` = '" . $aks_code_mr . "' AND
        `teilnehmer` = '" . $user['id'] . "' AND
        `flotten` = '" . $fleetid . "' AND
        `ankunft` = '" . $fleet['fleet_start_time'] . "' AND
        `galaxy` = '" . $fleet['fleet_end_galaxy'] . "' AND
        `system` = '" . $fleet['fleet_end_system'] . "' AND
        `planet` = '" . $fleet['fleet_end_planet'] . "' AND
        `eingeladen` = '" . $user['id'] . "'
        ", 'aks', true);

        $aks_madnessred = doquery(
        "SELECT * FROM {{table}} WHERE
        `name` = '" . $aks_code_mr . "' AND
        `teilnehmer` = '" . $user['id'] . "' AND
        `flotten` = '" . $fleetid . "' AND
        `ankunft` = '" . $fleet['fleet_start_time'] . "' AND
        `galaxy` = '" . $fleet['fleet_end_galaxy'] . "' AND
        `system` = '" . $fleet['fleet_end_system'] . "' AND
        `planet` = '" . $fleet['fleet_end_planet'] . "' AND
        `eingeladen` = '" . $user['id'] . "'
        ", 'aks', true);

        doquery(
        "UPDATE {{table}} SET
        fleet_group = '" . $aks['id'] . "'
        WHERE
        fleet_id = '" . $fleetid . "'", 'fleets');
    } else {
        $aks = doquery(
        "SELECT * FROM {{table}} WHERE
        id = '" . $fleet['fleet_group'] . "'"
        , 'aks');

        $aks_madnessred = doquery(
        "SELECT * FROM {{table}} WHERE
        id = '" . $fleet['fleet_group'] . "'"
        , 'aks');

        if (mysql_num_rows($aks) != 1) {
            message('AKS nicht gefunden!', 'Fehler');
        }
        $aks = mysql_num_rows($aks);
    }

    $missiontype = array(
        1 => $lang['type_mission'][1],
        2 => $lang['type_mission'][2],
        3 => $lang['type_mission'][3],
        4 => $lang['type_mission'][4],
        5 => $lang['type_mission'][5],
        6 => $lang['type_mission'][6],
        7 => $lang['type_mission'][7],
        8 => $lang['type_mission'][8],
        9 => $lang['type_mission'][9],
        15 => $lang['type_mission'][15],
        16 => $lang['type_mission'][16],
        17 => $lang['type_mission'][17],
        );

    $speed = array(
        10 => 100,
        9 => 90,
        8 => 80,
        7 => 70,
        6 => 60,
        5 => 50,
        4 => 40,
        3 => 30,
        2 => 20,
        1 => 10,
        );

    if (!$galaxy) {
        $galaxy = $planetrow['galaxy'];
    }
    if (!$system) {
        $system = $planetrow['system'];
    }
    if (!$planet) {
        $planet = $planetrow['planet'];
    }
    if (!$planettype) {
        $planettype = $planetrow['planet_type'];
    }
    $ile = '' . ++$user[$resource[108]] . '';
    $page = '<script language="JavaScript" src="scripts/flotten.js"></script>
<script language="JavaScript" src="scripts/ocnt.js"></script>
  <center>
    <table width="519" border="0" cellpadding="0" cellspacing="1">
      <tr height="20">
        <td colspan="9" class="c">'.$lang['fl_title'].' ('.$lang['fl_selmax'].'. ' . $ile . ')</td>
      </tr>
      <tr height="20">
        <th>'.$lang['fl_id'].'</th>
        <th>'.$lang['fl_mission'].'</th>
        <th>'.$lang['fl_count'].'</th>
    <!--<th>Absendezeit</th>-->
        <th>'.$lang['fl_from'].'</th>
        <th>'.$lang['fl_dest_t'].'</th>
        <th>'.$lang['fl_dest'].'</th>
        <th>'.$lang['fl_back_t'].'</th>
        <th>'.$lang['fl_back_in'].'</th>
        <th>'.$lang['fl_order'].'</th>
      </tr>';
    /*
      Here must show the fleet movings of owner player.
    */

    $fq = doquery("SELECT * FROM {{table}} WHERE fleet_owner={$user[id]}", 'fleets');

    $i = 0;
    while ($f = mysql_fetch_array($fq)) {
        $i++;

        $page .= "<tr height=20><th>$i</th><th>";

        $page .= "<a title=\"\">{$missiontype[$f[fleet_mission]]}</a>";
        if (($f['fleet_start_time'] + 1) == $f['fleet_end_time'])
            $page .= " <a title=\"R&uuml;ckweg\">(F)</a>";
        $page .= "</th><th><a title=\"";
        /*
          Se debe hacer una lista de las tropas
        */
        $fleet = explode(";", $f['fleet_array']);
        $e = 0;
        foreach($fleet as $a => $b) {
            if ($b != '') {
                $e++;
                $a = explode(",", $b);
                $page .= "{$lang['tech']{$a[0]}}: {$a[1]}\n";
                if ($e > 1) {
                    $page .= "\t";
                }
            }
        }
        $page .= "\">" . pretty_number($f[fleet_amount]) . "</a></th>";
        // $page .= "<th>".date("d. M Y H:i:s",$f['fleet_start_time'])."</th>";
        $page .= "<th>[{$f[fleet_start_galaxy]}:{$f[fleet_start_system]}:{$f[fleet_start_planet]}]</th>";
        $page .= "<th>" . date("d. M Y H:i:s", $f['fleet_start_time']) . "</th>";
        $page .= "<th>[{$f[fleet_end_galaxy]}:{$f[fleet_end_system]}:{$f[fleet_end_planet]}]</th>";
        $page .= "<th>" . date("d. M Y H:i:s", $f['fleet_end_time']) . "</th>";
        $page .= " </form>";

        $page .= "<th><font color=\"lime\"><div id=\"time_0\"><font>" . pretty_time(floor($f['fleet_end_time'] + 1 - time())) . "</font></th><th>";

        if ($f['fleet_mess'] == 0) {
            $page .= "     <form action=\"fleetback.php\" method=\"post\">
      <input name=\"zawracanie\" value=" . $f['fleet_id'] . " type=hidden>
         <input value=\" Retour \" type=\"submit\">
       </form></th>";
        } else $page .= "&nbsp;</th>";

        $page .= "</div></font>
            </tr>";
    }

    if ($i == 0) {
        $page .= "<th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th>";
    }
    if ($ile == $maxfleet_count) {
        $maxflot = '<tr height="20"><th colspan="9"><font color="red">'.$lang['fl_noslotfree'].'</font></th></tr>';
    }
    
    while($row = mysql_fetch_array($aks_madnessred))
    {
        $aks_code_mr .= $row['name'];
        $aks_invited_mr .= $row['eingeladen'];
    }

    $page .= '
        ' . $maxflot . '</table>
      </center>
    <table width="519" border="0" cellpadding="0" cellspacing="1">
   <tr height="20">
     <td class="c" colspan="2">'.$lang['fl_assoc_fleet'].' '.$aks_code_mr.'</td>
   </tr>

   <tr height="20">

  <td class="c" colspan="2">'.$lang['fl_aks_change_name'].'</td>
   </tr>
   <tr>
    <th colspan="2">'.$aks_code_mr.' <br /> </th>
   </tr>

   <tr>
    <th>
     <table width="100%" border="0" cellpadding="0" cellspacing="1">
      <tr height="20">
       <td class="c">'.$lang['fl_aks_member'].'</td>
       <td class="c">'.$lang['fl_aks_invit'].'</td>
      </tr>
      <tr>

       <th width="50%">
        <select size="5">';

    $members = explode(",", $aks_invited_mr);
    foreach($members as $a => $b) {
        if ($b != '') {
            $member_qry_mr = doquery("SELECT `username` FROM {{table}} WHERE `id` ='".$b."' ;",'users');
            while($row = mysql_fetch_array($member_qry_mr)){
                $page .= "<option>".$row['username']."</option>";
            }
        }
    }

        $page .= '</select>
       </th>

        <form action="verband.php" method="POST">
    <input type="hidden" name="add_member_to_aks" value="madnessred" />
    <input name="fleetid" value="'.$_POST[fleetid].'" type="hidden">
    <input name="aks_invited_mr" value="'.$aks_invited_mr.'" type="hidden">
       <td><input name="addtogroup" type="text" /> <br /><input type="submit" value="OK" /></td>
    </form><br />'.$add_user_message_mr.'
             </tr>
     </table>
    </th>
   </tr>
   <tr>

   </tr>

  </table>
      <center>
        <form action="floten1.php" method="post">
        <table width="519" border="0" cellpadding="0" cellspacing="1">
          <tr height="20">
            <td colspan="4" class="c">'.$lang['fl_new_miss'].'</td>
          </tr>
          <tr height="20">
            <th>'.$lang['fl_fleet_typ'].'</th>
            <th>'.$lang['fl_fleet_disp'].'</th>';
    // <!--    <th>Gesch.</th> -->
    $page .= '
            <th>-</th>
            <th>-</th>
          </tr>';
    if (!$planetrow) {
        message('WTF! FEHLER!', 'ERROR');
    } //uno nunca sabe xD
    $galaxy = intval($_GET['galaxy']);
    $system = intval($_GET['system']);
    $planet = intval($_GET['planet']);
    $planettype = intval($_GET['planettype']);
    $target_mission = intval($_GET['target_mission']);

    foreach($reslist['fleet'] as $n => $i) {
        if ($planetrow[$resource[$i]] > 0) {
            if ($i == 202 or $i == 203 or $i == 204 or $i == 209 or $i == 210) {
                $pricelist[$i]['speed'] = $pricelist[$i]['speed'] + (($pricelist[$i]['speed'] * $user['combustion_tech']) * 0.1);
            }
            if ($i == 205 or $i == 206 or $i == 208 or $i == 211) {
                $pricelist[$i]['speed'] = $pricelist[$i]['speed'] + (($pricelist[$i]['speed'] * $user['impulse_motor_tech']) * 0.2);
            }
            if ($i == 207 or $i == 213 or $i == 214 or $i == 215 or $i == 216 or $i == 217 or $i == 218 or $i == 219 or $i == 220) {
                $pricelist[$i]['speed'] = $pricelist[$i]['speed'] + (($pricelist[$i]['speed'] * $user['hyperspace_motor_tech']) * 0.3);
            }
            $page .= '<tr height="20">
            <th><a title="Geschwindigkeit: ' . $pricelist[$i]['speed'] . '">' . $lang['tech'][$i] . '</a></th>
            <th>' . pretty_number($planetrow[$resource[$i]]) . '
              <input type="hidden" name="maxship' . $i . '" value="' . $planetrow[$resource[$i]] . '"/></th>

            <input type="hidden" name="consumption' . $i . '" value="' . $pricelist[$i]['consumption'] . '"/>

            <input type="hidden" name="speed' . $i . '" value="' . $pricelist[$i]['speed'] . '" />
            <input type="hidden" name="galaxy" value="' . $galaxy . '"/>

            <input type="hidden" name="system" value="' . $system . '"/>
            <input type="hidden" name="planet" value="' . $planet . '"/>
            <input type="hidden" name="planet_type" value="' . $planettype . '"/>
            <input type="hidden" name="mission" value="' . $target_mission . '"/>
            </th>
            <input type="hidden" name="capacity' . $i . '" value="' . $pricelist[$i]['capacity'] . '" />
            </th>';
            if ($i == 212) {
                $page .= '<th></th><th></th></tr>';
            } else {
                $page .= '<th><a href="javascript:maxShip(\'ship' . $i . '\'); shortInfo();">max</a> </th>
                <th><input name="ship' . $i . '" size="10" value="0" onfocus="javascript:if(this.value == \'0\') this.value=\'\';" onblur="javascript:if(this.value == \'\') this.value=\'0\';" alt="' . $lang['tech'][$i] . $planetrow[$resource[$i]] . '"  onChange="shortInfo()" onKeyUp="shortInfo()"/></th>
                </tr>';
                $aaaaaaa = $pricelist[$i]['consumption'];
            }
            $have_ships = true;
        }
    }

    if (!$have_ships) {
        $page .= '<tr height="20">
        <th colspan="4">'.$lang['fl_unselectall'].'</th>
        </tr>
        <tr height="20">
        <th colspan="4">
        <input type="button" value="OK" enabled/></th>
        </tr>
        </table>
        </center>
        </form>';
    } else {
        $page .= '
          <tr height="20">
            <th colspan="2"><a href="javascript:noShips();shortInfo();noResources();" >'.$lang['fl_unselectall'].'</a></th>
            <th colspan="2"><a href="javascript:maxShips();shortInfo();" >'.$lang['fl_selectall'].'</a></th>
          </tr>';

        $przydalej = '<tr height="20"><th colspan="4"><input type="submit" value="OK" /></th></tr>';
        if ($ile == $maxfleet_count) {
            $przydalej = '';
        }
        $page .= '
        ' . $przydalej . '
        <tr><th colspan="4">
        <br><center></center><br>
        </th></tr>
        </table>
      </center>
    </form>';
    }
} else {
}

display($page, "Flotten");

?>