<?php
/*
    -> Simulator Page 
    1.1 & 1.2 @copyright 2011 by Moon for Moon-XNova http://www.moon-xnova.org
    1.0       @copyright 2008 by Anthony for Darkness fo Evolution
    
    CHANGELOG 
    1.0 Simulator by Anthony
    1.1 Compatibility with generated links
    1.2 Compatibility with AKS / Possibility to add players

*/
if(!defined('INSIDE')){ die(header("location:../../"));}


if(isset($_POST['submit'])) 
{

    // !---------------------------------------------------------------------------------------------------------! //

    // Lets get fleet.
    // ACS function: put all fleet into an array
    $attackFleets = array();

    //Generic
    $attackFleets_fleet_mr['fleet_id'] = 0;
    $attackFleets_fleet_mr['fleet_owner'] = 0;
    $attackFleets_fleet_mr['fleet_mission'] = 0;
    $attackFleets_fleet_mr['fleet_amount'] = 0;
    $attackFleets_fleet_mr['fleet_array'] = 0;
    $attackFleets_fleet_mr['fleet_start_time'] = time();
    $attackFleets_fleet_mr['fleet_start_galaxy'] = 0;
    $attackFleets_fleet_mr['fleet_start_system'] = 0;
    $attackFleets_fleet_mr['fleet_start_planet'] = 0;
    $attackFleets_fleet_mr['fleet_start_type'] = 0;
    $attackFleets_fleet_mr['fleet_end_time'] = (time() + 10);
    $attackFleets_fleet_mr['fleet_end_stay'] = 0;
    $attackFleets_fleet_mr['fleet_end_galaxy'] = 0;
    $attackFleets_fleet_mr['fleet_end_system'] = 0;
    $attackFleets_fleet_mr['fleet_end_plane'] = 0;
    $attackFleets_fleet_mr['fleet_end_type'] = 0;
    $attackFleets_fleet_mr['fleet_taget_owner'] = 0;
    $attackFleets_fleet_mr['fleet_resource_metal'] = 0;
    $attackFleets_fleet_mr['fleet_resource_crystal'] = 0;
    $attackFleets_fleet_mr['fleet_resource_deuterium'] = 0;
    $attackFleets_fleet_mr['fleet_target_owner'] = 0;
    $attackFleets_fleet_mr['fleet_group'] = 0;
    $attackFleets_fleet_mr['fleet_mess'] = 0;
    $attackFleets_fleet_mr['start_time'] = (time() - 10);

    for ($fleet_id_mr = 0; $fleet_id_mr <= 2; $fleet_id_mr++) { //3 max players
        $fleet_code[$fleet_id_mr] = '';
        $fleet_count[$fleet_id_mr] = '';
        for ($i = 200; $i < 400; $i++) {
            $fleet_us_mr = $_POST['attacker_fleet'];
            if($fleet_us_mr[$fleet_id_mr][$i] > 0){
                $fleet_code[$fleet_id_mr] .= $i.",".$fleet_us_mr[$fleet_id_mr][$i].";";
                $fleet_count[$fleet_id_mr] += $fleet_us_mr[$fleet_id_mr][$i];
            }
        }

        $attackFleets[$fleet_id_mr]['fleet'] = $attackFleets_fleet_mr;
        $attackFleets[$fleet_id_mr]['fleet']['fleet_id'] = $fleet_id_mr;
        $attackFleets[$fleet_id_mr]['fleet']['fleet_owner'] = $fleet_id_mr;
        $attackFleets[$fleet_id_mr]['fleet']['fleet_amount'] = $fleet_count[$fleet_id_mr];
        $attackFleets[$fleet_id_mr]['fleet']['fleet_array'] = $fleet_code[$fleet_id_mr];

        $rpg_amiral_us_mr = $_POST['rpg_amiral_us'];
        $defence_tech_us_mr = $_POST['defence_tech_att'];
        $shield_tech_us_mr = $_POST['shield_tech_att'];
        $military_tech_us_mr = $_POST['military_tech_att'];

        $attackFleets[$fleet_id_mr]['user']['rpg_amiral'] = $rpg_amiral_us_mr[$fleet_id_mr];
        $attackFleets[$fleet_id_mr]['user']['defence_tech'] = $defence_tech_us_mr[$fleet_id_mr];
        $attackFleets[$fleet_id_mr]['user']['shield_tech'] = $shield_tech_us_mr[$fleet_id_mr];
        $attackFleets[$fleet_id_mr]['user']['military_tech'] = $military_tech_us_mr[$fleet_id_mr];

        $attackFleets[$fleet_id_mr]['detail'] = array();
        $temp = explode(';', $attackFleets[$fleet_id_mr]['fleet']['fleet_array']);
        foreach ($temp as $temp2) {
        //!! check line below!!
            $temp2 = explode(',', $temp2);
            if ($temp2[0] < 100) continue;
            if (!isset($attackFleets[$fleet_id_mr]['detail'][$temp2[0]])) $attackFleets[$fleet_id_mr]['detail'][$temp2[0]] = 0;
            $attackFleets[$fleet_id_mr]['detail'][$temp2[0]] += $temp2[1];
        }
    }

    // !---------------------------------------------------------------------------------------------------------------------------!//

    //Lets get Defense
    $defense = array();

    // Get ACS Defend fleets. (stationed on the planet)
    

    $defence_tech_them_mr = $_POST['defence_tech_def'];
    $shield_tech_them_mr = $_POST['shield_tech_def'];
    $military_tech_them_mr = $_POST['military_tech_def'];
    for ($fleet_id_mr = 0; $fleet_id_mr <= 2; $fleet_id_mr++) { //3 max players
        $defense[$fleet_id_mr]['user']['defence_tech'] = $defence_tech_them_mr[$fleet_id_mr];
        $defense[$fleet_id_mr]['user']['shield_tech'] = $shield_tech_them_mr[$fleet_id_mr];
        $defense[$fleet_id_mr]['user']['military_tech'] = $military_tech_them_mr[$fleet_id_mr];
        $defense[$fleet_id_mr]['def'] = array();
        for ($i = 200; $i < 500; $i++) {
            $fleet_them_mr = $_POST['defender_fleet'];
            if($fleet_them_mr[$fleet_id_mr][$i] > 0){
                $defense[$fleet_id_mr]['def'][$i] = $fleet_them_mr[$fleet_id_mr][$i];
            }
        }
    }

    // Lets calcualte attack...

    $start = microtime(true);
    $result = calculateAttack($attackFleets, $defense);
    $totaltime = microtime(true) - $start;


    // moon chance

    $FleetDebris = $result['debree']['att'][0] + $result['debree']['def'][0] + $result['debree']['att'][1] + $result['debree']['def'][1];
    $Recycleur = ceil($FleetDebris/500000);
    $MoonChance = $FleetDebris / 10000000;
    if ($FleetDebris > 35000000) {
        $UserChance = mt_rand(1, 100);
        $MoonChance = 20;
    } elseif ($FleetDebris < 10000000) {
        $UserChance = 0;
        $ChanceMoon = "";
    } elseif ($FleetDebris >= 10000000) {
        $UserChance = mt_rand(1, 100);
        $ChanceMoon = sprintf ($lang['sys_moonproba'], $MoonChance);
    }

    if (($UserChance > 0) && ($UserChance <= $MoonChance) ) {
        
        $GottenMoon = sprintf ($lang['sys_moonbuilt'], $TargetPlanetName, $FleetRow['fleet_end_galaxy'], $FleetRow['fleet_end_system'], $FleetRow['fleet_end_planet']);
        $GottenMoon .= "<br />";
    } else {
        $GottenMoon = "";
    }
    // Add by moon, combien de recycleur necessaire a la collecte
    $GottenMoon .= "<p>Recicladores necesarios para recoger : <font color='lime'>".$Recycleur."</font>.</p>";

    // Resources stolen...

    $steal = array('metal' => 0, 'crystal' => 0, 'deuterium' => 0);
    if ($result['won'] == 1) {
        // Calculate new fleet maximum resources for base attacker
        $max_resources = 0;
        foreach ($attackFleets[1]['detail'] as $Element => $amount) {
            $max_resources += $pricelist[$Element]['capacity'] * $amount;
        }

        if ($max_resources > 0) {
            $metal = $targetPlanet['metal'] / 2;
            $crystal = $targetPlanet['crystal'] / 2;
            $deuter = $targetPlanet['deuterium'] / 2;
            if ($metal > $max_resources / 3) {
                $steal['metal'] = $max_resources / 3;
                $max_resources = $max_resources - $steal['metal'];
            } else {
                $steal['metal'] = $metal;
                $max_resources -= $steal['metal'];
            }

            if ($crystal > $max_resources / 2) {
                $steal['crystal'] = $max_resources / 2;
                $max_resources -= $steal['crystal'];
            } else {
                $steal['crystal'] = $crystal;
                $max_resources -= $steal['crystal'];
            }

            if ($deuter > $max_resources) {
                $steal['deuterium'] = $max_resources;
                $max_resources -= $steal['deuterium'];
            } else {
                $steal['deuterium'] = $deuter;
                $max_resources -= $steal['deuterium'];
            }
        }

        $steal = array_map('round', $steal);

    }

    // !------------------------------------------------------------------------------------------------------------------------! //

    //Code checkpoint 1 (for finding this point again
    $formatted_cr = formatCR($result,$steal,$MoonChance,$GottenMoon,$totaltime);

    // Well lets just copy rw.php code. If I am showing a cr why re-inent the wheel???
    $Page = "<html>";
    $Page .= "<head>";
    $Page .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"".$dpath."/formate.css\">";
    $Page .= "<meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-2\" />";
    $Page .= "</head>";
    $Page .= "<body>";
    $Page .= "<center>";
    $Page .= "</div>";
    //OK, one change, we won't be getting cr from datbase, instead we will be generating it directly, lets skip the database stage, this is what get generated and put in the database.
    $report = stripslashes($formatted_cr['html']);
    foreach ($lang['tech_rc'] as $id => $s_name) {
        $str_replace1 = array("[ship[".$id."]]");
        $str_replace2 = array($s_name);
        $report = str_replace($str_replace1, $str_replace2, $report);
    }
    $no_fleet = "<table border=1 align=\"center\"><tr><th>Type</th></tr><tr><th>Total</th></tr><tr><th>Armes</th></tr><tr><th>Bouclier</th></tr><tr><th>Coque</th></tr></table>";
    $destroyed = "<table border=1 align=\"center\"><tr><th><font color=\"red\"><strong>Destroyed!</strong></font></th></tr></table>";
    $str_replace1 = array($no_fleet);
    $str_replace2 = array($destroyed);
    $report = str_replace($str_replace1, $str_replace2, $report);
    $Page .= $report;

    $Page .= "<br /><br />";
    //We we aren't gonna chare this reoprt because we cheated so it acutally doesn't exist.
    $Page .= "I am sorry, but you cannot copy this report.";
    $Page .= "<br /><br />";
    $Page .= "</center>";
    $Page .= "</body>";
    $Page .= "</html>";

    echo $Page;

    // Now its Sonyedorlys input form. Many thanks for allowing me to use it. (Slightly edited)
} 
else 
{

    $parse['military'] = 0;
    $parse['defence'] = 0;
    $parse['shield'] = 0;
    if($user['military_tech'] != '') $parse['military'] = $user['military_tech'];
    if($user['defence_tech'] != '') $parse['defence'] = $user['defence_tech'];
    if($user['shield_tech'] != '') $parse['shield'] = $user['shield_tech'];
    $parse['metal'] = 0;
    $parse['crystal'] = 0;
    $parse['deuterium'] = 0;

    for ($SetItem = 109; $SetItem <= 111; $SetItem++) {
        if($lang["tech"][$SetItem] != "") 
            $parse[$resource[$SetItem]] = 0;
         else 
            $parse[$resource[$SetItem]] = 0;
    }
    for ($SetItem = 200; $SetItem < 500; $SetItem++) {
        if($lang["tech"][$SetItem] != "") 
            $parse[$resource[$SetItem]] = 0;
         else
            $parse[$resource[$SetItem]] = 0;
    }

    if($_GET['raport'] != '') {

        $parse['metal'] = $_GET['metal'];
        $parse['crystal'] = $_GET['crystal'];
        $parse['deuterium'] = $_GET['deuterium'];

        for ($SetItem = 109; $SetItem <= 111; $SetItem++) {
            if($lang["tech"][$SetItem] != "" ) {
                if($_GET[$SetItem]!='') 
                    $parse[$resource[$SetItem]] = intval($_GET[$SetItem]);
                else 
                    $parse[$resource[$SetItem]] = 0;
            } else 
                $parse[$resource[$SetItem]] = 0;
        }
        foreach ($reslist['fleet'] as $SetItem) {
            if($lang["tech"][$SetItem] != "" ) {
                if($_GET[$SetItem]!='')
                    $parse[$resource[$SetItem]] = $_GET[$SetItem];
                else 
                    $parse[$resource[$SetItem]] = 0;
            } else
                 $parse[$resource[$SetItem]] = 0;
        }
        foreach ($reslist['defense'] as $SetItem) {
            if($lang["tech"][$SetItem] != "" ) {
                if($_GET[$SetItem]!='')
                    $parse[$resource[$SetItem]] = $_GET[$SetItem];
                else 
                    $parse[$resource[$SetItem]] = 0;
            } else
                 $parse[$resource[$SetItem]] = 0;
        }
    }

    $nbAtt = ($_POST['att'] != '') ? intval($_POST['att']) : 0;
    $nbDef = ($_POST['def'] != '') ? intval($_POST['def']) : 0;
    $nbAtt = ($nbAtt > 3) ? 2 : $nbAtt;    // Limitation a 3 de chaque sinon ça devient nawak
    $nbDef = ($nbDef > 3) ? 2 : $nbDef;
    $colspan = 3+$nbAtt+$nbDef; // +3 because we have one attacker and one defender minimum
    $page = "<div id='content'>";
    if($_GET['aks'] == true)
    {
            $page .= "<br />";
            $page .= "<form action=\"game.php?page=simulateur\" method=\"post\">";
            $page .= "<table><tbody><tr><td class=\"c\" colspan=2>Agregar participantes</td></tr>";
            $page .= "<tr><th>";
            $page .= "<INPUT type=radio name=att value=1>Anadir 1 atacante<br>";
            $page .= "<INPUT type=radio name=att value=2>Anadir 2 atacantes</th>";
            $page .= "<th>";
            $page .= "<INPUT type=radio name=def value=1>Anadir 1 defensor<br>";
            $page .= "<INPUT type=radio name=def value=2>Anadir 2 defensors</th></tr>";
            $page .= "<tr><th colspan=2><INPUT type=submit value='Aceptar'></th></tr>";
            $page .= "</tbody></table>";
        
    }
    $page .= "<form action='game.php?page=simulateur' method='post'><center><table><tr><td><br />";
    $page .= "<table border=1 width=100%><tr><td class=\"c\" colspan=\"$colspan\">Simulador de Combate</td></tr><tr><td class=\"c\"><a href=\"game.php?page=simulateur&aks=true\"><u>Agregar participantes</u></a></td>";
    for($i = 0; $i <= $nbAtt; $i++)
        $page .= "<td class=\"c\">Atacante ". ($i+1) ."</td>";
    for($i = 0; $i <= $nbDef; $i++)
        $page .= "<td class=\"c\">Defensor ". ($i+1) ."</td>";
    $page .= "</tr>";
    $page .= "<tr><td class=\"c\" colspan=\"$colspan\">Techs</td></tr>";
    $page .= "<tr><th>Armas</th><th><input type='text' name='military_tech_att[0]' value='".$parse['military']."'></th>";
    for($i = 1; $i <= ($nbAtt); $i++)
        $page .= "<th><input type='text' name='military_tech_att[$i]' value='0'></th>";
    for($i = 0; $i <= ($nbDef); $i++)
        $page .= "<th><input type='text' name='military_tech_def[$i]' value='".$parse[$resource[109]]."'></th>";
    $page .= "</tr><tr><th>Armadura</th><th><input type='text' name='defence_tech_att[0]' value='".$parse['defence']."'></th>";
    for($i = 1; $i <= ($nbAtt); $i++)
        $page .= "<th><input type='text' name='defence_tech_att[$i]' value='0'></th>";
    for($i = 0; $i <= ($nbDef); $i++)
        $page .= "<th><input type='text' name='defence_tech_def[$i]' value='".$parse[$resource[110]]."'></th>";
    $page .= "</tr><tr><th>Escudo</th><th><input type='text' name='shield_tech_att[0]' value='".$parse['shield']."'></th>";
    for($i = 1; $i <= ($nbAtt); $i++)
        $page .= "<th><input type='text' name='shield_tech_att[$i]' value='0'></th>";
    for($i = 0; $i <= ($nbDef); $i++)
        $page .= "<th><input type='text' name='shield_tech_def[$i]' value='".$parse[$resource[111]]."'></th>";
    $page .= "</tr>";
    for ($SetItem = 200; $SetItem < 500; $SetItem++) {
        if($lang["tech"][$SetItem] != "") {
            if(floor($SetItem/100)*100 == $SetItem) 
                $page .= "<tr><td class=\"c\" colspan=\"".$colspan."\">".$lang["tech"][$SetItem]."</td></tr>";
            else {
                $page .= "<tr><th>".$lang["tech"][$SetItem]."</th>";
                for($i=0; $i <= $nbAtt ; $i++){
                    if($SetItem < 400)
                        $page .= "<th><input type='text' name='attacker_fleet[$i][".$SetItem."]' value='0'></th>";
                    else
                        $page .= "<th>&nbsp;</th>";
                }
                for($i=0; $i <= $nbDef-1 ; $i++){
                    if($SetItem < 400)
                        $page .= "<th><input type='text' name='defender_fleet[$i][".$SetItem."]' value='0'></th>";
                    else
                        $page .= "<th>&nbsp;</th>";
                }
                $page .= "<th><input type='text' name='defender_fleet[$nbDef][".$SetItem."]' value='".$parse[$resource[$SetItem]]."'></th>";
            }
        }
    }
    $page .= "<tr><td class=\"c\" colspan=\"".$colspan."\">Recursos</td></tr>";
    $page .= "<tr><th>Metal</th>";
    for($i = 0; $i <= ($nbAtt+$nbDef); $i++)
        $page .= "<th>&nbsp;</th>";
    $page .= "<th><input type='text' name='metal' value='".$parse['metal']."'></th></tr>";
    $page .= "<tr><th>Cristal</th>";
    for($i = 0; $i <= ($nbAtt+$nbDef); $i++)
        $page .= "<th>&nbsp;</th>";
    $page .= "<th><input type='text' name='crystal' value='".$parse['crystal']."'></th></tr>";
    $page .= "<tr><th>Deuterio</th>";
    for($i = 0; $i <= ($nbAtt+$nbDef); $i++)
        $page .= "<th>&nbsp;</th>";
    $page .= "<th><input type='text' name='deuterium' value='".$parse['deuterium']."'></th></tr>";
    $page .= "<tr><th colspan=\"".$colspan."\"><input type='submit' name='submit' value='Simuler'></th></tr>";
    $page .= "</table></center></form></div>";


    display($page, "Combat Simulator", false);
}
?> 
