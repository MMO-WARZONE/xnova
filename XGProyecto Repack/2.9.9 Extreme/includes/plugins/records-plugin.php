<?php

/**
 * @name Records Plugin
 * @author adri93 (plugin)
 * @author Algun frances de Xnova Project y diversas personas en la mejora del codigo
 * @category Plugin
 * @version 0.3
 * @uses Plugin system 0.3
 * @copyright (c) 2010 Adri93 for the plugin conversion and other some people for the records page code.
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
*/

 $rec_name="Records";
 $rec_desc="Qui&aecute;n a conseguido m&aacute;s de algo?";
 $config_line .= AdmPlugin($rec_name, $rec_desc);
 if(PluginAct($rec_name) == 1){

$lang['lm_statistics']	.='</a></font></div></td></tr><tr><td><div align="center"><font color="#FFFFFF"><a href="game.php?page=records">Records';

    $page=$_GET['page'];
    
if(is_phpself('game') && $page=='records'){ 

//funciones básicas
    include($game_root . 'includes/functions/SortUserPlanets.' . $phpEx);
    
    $dpath     = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
    include($game_root . 'includes/functions/SetSelectedPlanet.' . $phpEx);
    SetSelectedPlanet ($user);

    $planetrow = doquery("SELECT * FROM `{{table}}` WHERE `id` = '".$user['current_planet']."';", "planets", true);

    include($game_root . 'includes/functions/CheckPlanetUsedFields.' . $phpEx);
    CheckPlanetUsedFields($planetrow);
    //fin funciones basicas


   $RecordTpl = gettemplate('plugins/record/record_body');
   $HeaderTpl = gettemplate('plugins/record/record_section_header');
   $TableRows = gettemplate('plugins/record/record_section_rows');

   $lang['rec_rien'] = "Vacio";

  $parse['rec_title'] = $lang['rec_title'];

   $bloc['section']    = $lang['rec_build'];
   $bloc['player']     = $lang['rec_playe'];
   $bloc['level']      = $lang['rec_level'];
   $parse['building']  = parsetemplate( $HeaderTpl, $bloc);

   $bloc['section']    = $lang['rec_specb'];
   $bloc['player']     = $lang['rec_playe'];
   $bloc['level']      = $lang['rec_level'];
   $parse['buildspe']  = parsetemplate( $HeaderTpl, $bloc);

   $bloc['section']    = $lang['rec_techn'];
   $bloc['player']     = $lang['rec_playe'];
   $bloc['level']      = $lang['rec_level'];
   $parse['research']  = parsetemplate( $HeaderTpl, $bloc);

   $bloc['section']    = $lang['rec_fleet'];
   $bloc['player']     = $lang['rec_playe'];
   $bloc['level']      = $lang['rec_nbre'];
   $parse['fleet']     = parsetemplate( $HeaderTpl, $bloc);

   $bloc['section']    = $lang['rec_defes'];
   $bloc['player']     = $lang['rec_playe'];
   $bloc['level']      = $lang['rec_nbre'];
   $parse['defenses']  = parsetemplate( $HeaderTpl, $bloc);

   if ( SHOW_ADMIN_IN_RECORDS == 0 ) {
      $RecConditionP       = " WHERE `id_level` = '0'";
      $RecConditionU       = " WHERE `authlevel` = '0'";
   } else {
      $RecConditionP       = "";
      $RecConditionU       = "";
   }

   foreach($lang['tech'] as $Element => $ElementName) {
      if ($ElementName != "") {
         if ($resource[$Element] != "") {
            // Je sais bien qu'il n'y a aucune raison de blinder ce test ...
            // Mais avec les zozos qui vont le pomper ... Mieux vaut prevoir que guerir !!
            if       ($Element >=   1 && $Element <=  39 || $Element == 44) {
               // Edificios
               $PlanetRow          = doquery ("SELECT `id_owner`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE `". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}} );", 'planets', true);$UserRow            = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '".$PlanetRow['id_owner']."';", 'users', true);
               $Row['element']     = $ElementName;
               $Row['winner']      = ($PlanetRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
               $Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
               $parse['building'] .= parsetemplate( $TableRows, $Row);
            } elseif ($Element >=  41 && $Element <=  99 && $Element != 44) {
               // Edificiones de la luna
               $PlanetRow          = doquery ("SELECT `id_owner`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE `". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}} );", 'planets', true);$UserRow            = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '".$PlanetRow['id_owner']."';", 'users', true);
               $Row['element']     = $ElementName;
               $Row['winner']      = ($PlanetRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
               $Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
               $parse['buildspe'] .= parsetemplate( $TableRows, $Row);
            } elseif ($Element >= 101 && $Element <= 199) {
               // Tecnologias
    $UserRow            = doquery ("SELECT `username`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE `". $resource[$Element] ."` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}} );", 'users', true);
               $Row['element']     = $ElementName;
               $Row['winner']      = ($UserRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
               $Row['count']       = ($UserRow['current'] != 0) ? pretty_number( $UserRow['current'] ) : $lang['rec_rien'];
               $parse['research'] .= parsetemplate( $TableRows, $Row);
            } elseif ($Element >= 201 && $Element <= 399) {
               // Flotas
               $PlanetRow          = doquery ("SELECT `id_owner`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE `". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}} );", 'planets', true);$UserRow            = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '".$PlanetRow['id_owner']."';", 'users', true);
               $Row['element']     = $ElementName;
               $Row['winner']      = ($PlanetRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
               $Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
               $parse['fleet']    .= parsetemplate( $TableRows, $Row);
            } elseif ($Element >= 401 && $Element <= 599) {
               // Defensas
               $PlanetRow          = doquery ("SELECT `id_owner`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE `". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}} );", 'planets', true);$UserRow            = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '".$PlanetRow['id_owner']."';", 'users', true);
               $Row['element']     = $ElementName;
               $Row['winner']      = ($PlanetRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
               $Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
               $parse['defenses'] .= parsetemplate( $TableRows, $Row);
            }
         }
      }
   }


   $page = parsetemplate( $RecordTpl, $parse );
   display($page, $lang['rec_title']);
    //Terminamos la carga
    break;

}
}
?>