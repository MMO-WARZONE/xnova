<?php

##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from xgproyect.net      	 #
# *																			 #
# *																			 #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.									 #
# *																			 #
# *  This program is distributed in the hope that it will be useful,		 #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of			 #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the			 #
# *  GNU General Public License for more details.							 #
# *																			 #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

 
	function ShowRecordsPage($CurrentUser){
      
     global $lang, $resource;

        includeLang('INGAME');

    	$lang['rec_title'];
		$lang['rec_build'];
		$lang['rec_specb']; 
		$lang['rec_playe'];
		$lang['rec_defes']; 
		$lang['rec_fleet'];
		$lang['rec_techn'];
		$lang['rec_level'];
		$lang['rec_nbre'];
		$lang['rec_rien'];
	    $parse = $lang;

	   $bloc = array();
       $RecordTpl = gettemplate('records/records_body');
       $HeaderTpl = gettemplate('records/records_section_header');
       $TableRows = gettemplate('records/records_section_rows');
		
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

          $RecConditionP1       = "WHERE `id_owner` != '0'";
         $RecConditionP       = " `id_owner` != '0' AND";
          $RecConditionU1       = "WHERE `id` != '0'";
         $RecConditionU       = " `id` != '0' AND";
		$query            = doquery ("SELECT `id`, `username` FROM {{table}};", 'users');
		$UserRows = array();
		while($Row = mysql_fetch_array($query)){
			$UserRows[$Row['id']] = $Row;
		}
       
foreach($lang['tech'] as $Element => $ElementName) {
      if ($ElementName != "") {
         if ($resource[$Element] != "") {
            // Je sais bien qu'il n'y a aucune raison de blinder ce test ...
            // Mais avec les zozos qui vont le pomper ... Mieux vaut prevoir que guerir !!
            
               if       ($Element >=   1 && $Element <=  39 || $Element == 44) {
               // Batiment
               $PlanetRow          = doquery ("SELECT `id`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE `". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}} );", 'planets', true);$UserRow            = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '".$PlanetRow['id']."';", 'users', true);
               $Row['element']     = $ElementName;
               $Row['winner']      = ($PlanetRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
               $Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
               $parse['building'] .= parsetemplate( $TableRows, $Row);
            
               } elseif ($Element >=  41 && $Element <=  99 && $Element != 44) {
				$DATA = doquery("SELECT MAX(`". $resource[$Element] ."`) as `total` FROM {{table}} ".$RecConditionP1.";", 'planets', true );
				$PlanetRow          = doquery ("SELECT `id_owner`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE ".$RecConditionP." `". $resource[$Element]. "` = '". $DATA['total'] ."';", 'planets', false);
				$usuario = 1;
				$users = array();
			    while($PlanetRow2 =  mysql_fetch_array($PlanetRow)){
						$UserRow            = $UserRows[$PlanetRow2['id_owner']];
						if($usuario == 1){
						$usr_p = $UserRow['username'];
						$cantidad = $PlanetRow2['current'];
						$users[$UserRow['username']] = $UserRow['username'];
					}elseif(!in_array($UserRow['username'], $users)){
						$usr_p .= ', '.$UserRow['username'];
						$users[$UserRow['username']] = $UserRow['username'];
					}
					++$usuario;
				}
				$Row['element']     = $ElementName;
                $Row['winner']      = (($cantidad != 0) ? $usr_p : $lang['rec_rien']);
                   $Row['count']       = ($cantidad != 0) ? pretty_number( $cantidad ) : $lang['rec_rien'];
                   $parse['buildspe'] .= parsetemplate( $TableRows, $Row);
            } elseif ($Element >= 101 && $Element <= 199) {
               
               // Technology
               $UserRow            = doquery ("SELECT `username`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE `". $resource[$Element] ."` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}} );", 'users', true);
               $Row['element']     = $ElementName;
               $Row['winner']      = ($UserRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
               $Row['count']       = ($UserRow['current'] != 0) ? pretty_number( $UserRow['current'] ) : $lang['rec_rien'];
               $parse['research'] .= parsetemplate( $TableRows, $Row);
            } elseif ($Element >= 201 && $Element <= 399) {
              
               // Flotte
               $PlanetRow         = doquery ("SELECT `id`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE `". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}} );", 'planets', true);$UserRow            = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '".$PlanetRow['id']."';", 'users', true);
               $Row['element']     = $ElementName;
               $Row['winner']      = ($PlanetRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
               $Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
               $parse['fleet']    .= parsetemplate( $TableRows, $Row);
            } elseif ($Element >= 401 && $Element <= 599) {
               
               // Défenses
               $PlanetRow          = doquery ("SELECT `id`, `". $resource[$Element] ."` AS `current` FROM {{table}} WHERE `". $resource[$Element]. "` = (SELECT MAX(`". $resource[$Element] ."`) FROM {{table}} );", 'planets', true);$UserRow            = doquery ("SELECT `username` FROM {{table}} WHERE `id` = '".$PlanetRow['id']."';", 'users', true);
               $Row['element']     = $ElementName;
               $Row['winner']      = ($PlanetRow['current'] != 0) ? $UserRow['username'] : $lang['rec_rien'];
               $Row['count']       = ($PlanetRow['current'] != 0) ? pretty_number( $PlanetRow['current'] ) : $lang['rec_rien'];
               $parse['defenses'] .= parsetemplate( $TableRows, $Row);
                }
             }
          }
       }
      
  $page = str_replace(array($CurrentUser['username']), array('<span style="color:orange">'.$CurrentUser['username'].'</span>'), parsetemplate( $RecordTpl, $parse ));display($page);

// $page = parsetemplate( $RecordTpl, $parse ); display($page, $lang['rec_title']);

	}

?>
