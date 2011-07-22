<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

   includeLang('records');

// blocking non-users
if ($IsUserChecked == false) {
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

   $RecordTpl = gettemplate('records_body');
   $HeaderTpl = gettemplate('records_section_header');
   $TableRows = gettemplate('records_section_rows');

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

	if ( SHOW_ADMIN_IN_RECORDS == 1 ) {
		$RecConditionP       = " WHERE `id_level` = '0'";
		$RecConditionU       = " WHERE `authlevel` = '0'";
	} else {
		$RecConditionP       = "";
		$RecConditionU       = "";
	}

   
   foreach($lang['tech'] as $Element => $ElementName) {
      if ($ElementName != "") {
         if ($resource[$Element] != "") {
            if ($Element >=   1 && $Element <=  39 || $Element == 44) {
               // Edificios
               $template = "building";
               $intable = "planets";
            } elseif ($Element >=  41 && $Element <=  99 && $Element != 44) {   
               // Edificios especiales
               $template = "buildspe";
               $intable = "planets";   
            } elseif ($Element >= 101 && $Element <= 199) {   
               // Tecnos         
               $template = "research";
               $intable = "users";                        
            } elseif ($Element >= 201 && $Element <= 399) {
               // Flota                        
               $template = "fleet";
               $intable = "planets";   
            } elseif ($Element >= 401 && $Element <= 599) {                        
               // Defensa                        
               $template = "defenses";
               $intable = "planets";
            }else{
               $template = "";
            }
            
		$RecConditionP       = " WHERE `id_level` = '0'";
		$RecConditionU       = " WHERE `authlevel` = '0'";
			
            if    ($template != ""){
               if    ($intable=="planets"){
                  $QrySelect  = "SELECT {{table}}planets.".$resource[$Element]." AS `current` ,{{table}}users.username FROM {{table}}planets ";
                  $QrySelect .= "JOIN {{table}}users ON {{table}}planets.id_owner = {{table}}users.id ";
                  $QrySelect .= "WHERE ";
                  $QrySelect .= "`". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}}planets". $RecConditionP .") ";
                  $QrySelect .= $RecConditionP2." LIMIT 1;";
                  $PlanetRow = doquery( $QrySelect, '',true);
                  $Row['element']     = $ElementName;
                  $Row['winner']      = ($PlanetRow['current'] != 0) ? $PlanetRow['username'] : $lang['rec_rien'];
                  $Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
				  if($Element >= 101 && $Element <= 199) {
					$query  = doquery("SELECT ".$resource[$Element]." FROM {{table}} WHERE `id` = '". $user['id'] ."';", 'users',true);
				  } else {
				  $query  = doquery("SELECT ".$resource[$Element]." FROM {{table}} WHERE `id_owner` = '". $user['id'] ."';", 'planets',true);
				  }
				if($Row['count'] != "-") {
				if($Row['count'] == $query[0]) {
				$Row['tucount'] = "[".$query[0]."]";
				} else {
				$tus = $Row['count']-$query[0];
				$Row['tucount'] = "<font color=\"green\">+".$tus."</font> [".$query[0]."]";
				}
				} else { $Row['tucount'] = "-";
				}
					  $parse[$template]  .= parsetemplate( $TableRows, $Row);               
               }else{
                  $QrySelect  = "SELECT `username`, `". $resource[$Element] ."` AS `current` FROM {{table}} ";
                  $QrySelect .= "WHERE `". $resource[$Element] ."` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}}". $RecConditionU .")";
                  $QrySelect .= $RecConditionU2." LIMIT 1;";
                  $UserRow = doquery( $QrySelect, 'users',true);
                  $Row['element']     = $ElementName;
                  $Row['winner']      = ($UserRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
                  $Row['count']       = ($UserRow['current'] != 0) ? pretty_number( $UserRow['current'] ) : $lang['rec_rien'];
				  if($Element >= 101 && $Element <= 199) {
                $query  = doquery("SELECT ".$resource[$Element]." FROM {{table}} WHERE `id` = '". $user['id'] ."';", 'users',true);
              } else {
              $query  = doquery("SELECT ".$resource[$Element]." FROM {{table}} WHERE `id_owner` = '". $user['id'] ."';", 'planets',true);
              }
            if($Row['count'] != "-") {
            if($Row['count'] == $query[0]) {
            $Row['tucount'] = "[".$query[0]."]";
            } else {
            $tus = $Row['count']-$query[0];
            $Row['tucount'] = "<font color=\"green\">+".$tus."</font> [".$query[0]."]";
            }
            } else { $Row['tucount'] = "-";
            }
                  $parse[$template] .= parsetemplate( $TableRows, $Row);               
               
               }            
                        
            }
            
         }
      }
   }

   $page = parsetemplate( $RecordTpl, $parse );
   display($page, $lang['rec_title']);
?>
