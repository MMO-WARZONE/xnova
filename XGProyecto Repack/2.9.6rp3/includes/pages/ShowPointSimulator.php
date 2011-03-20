<?php

/*
--------------------------------------------- Informacion ---------------------------------------------
  _    _                                      _                   _                 
 | |  | |                                    | |                 | |                
 | |  | |   __ _    __ _   _ __ ___     ___  | |   __ _   _ __   | |   __ _   _   _  ©
 | |  | |  / _` |  / _` | | '_ ` _ \   / _ \ | |  / _` | | '_ \  | |  / _` | | | | |
 | |__| | | (_| | | (_| | | | | | | | |  __/ | | | (_| | | |_) | | | | (_| | | |_| |
  \____/   \__, |  \__,_| |_| |_| |_|  \___| |_|  \__,_| | .__/  |_|  \__,_|  \__, |
            __/ |                                        | |                   __/ |
           |___/                                         |_|                  |___/ 
 
 *
 * ShowPointSimulator.php
 *
 * @copyright 2008-2010 Ugamelaplay
 * @package Ugamelaplay
 * @author shoghicp@gmail.com
 *
 *    UGamelaPlay.net es propietario de la parte propia de este archivo. Partes de este archivo son parte de XG Proyect. Su uso esta restringido a UGaSpace y XG Proyect por el momento. Para cualquier otra plataforma, contacte con shoghicp@gmail.com
 *    UGamelaPlay.net se reserva todos los derechos sobre la parte propia de este archivo.
 *
 
--------------------------------------------- Descripcion ------------------------------------------------------

Este archivo calcula los puntos y recursos de la suma de los niveles puestos. Vamos, calcular puntos/ recursos

--------------------------------------------- Historial de cambios ---------------------------------------------

0.1 - Adaptado a XGP
0.2 - Incluido en el Repack de XGP y con tritio

*/

if(!defined('INSIDE')){ die(header("location:../../"));}
    $totalpoints = 0;
    $planeta = array();
    $parse['build_rows'] = '<tr><td class="c" colspan="2">Edificios</td><td class="c" colspan="1">Metal</td><td class="c" colspan="1">Cristal</td><td class="c" colspan="1">Deuterio</td><td class="c" colspan="1">Tritio</td><td class="c" colspan="1">Puntos</td></tr>';
    
    foreach($reslist['build'] as $Building) {
            $CurrPOST = intval($_POST['element'.$Building]);
            $metal = 0;
            $crystal = 0;
            $deuterium = 0;
			$tritium = 0;            
            $points = 0;
            $value = 0;
            if ( $CurrPOST > 0 ) {
                for ( $Level = 1; $Level <= $CurrPOST; $Level++ ) {
                    $Units        = $pricelist[ $Building ]['metal'] + $pricelist[ $Building ]['crystal'] + $pricelist[ $Building ]['deuterium'] + $pricelist[ $Building ]['tritium'];
                    $LevelMul     = pow( $pricelist[ $Building ]['factor'], $Level );
                    $points += ($Units * $LevelMul);
                }
                    $metal = $pricelist[ $Building ]['metal'] * pow( $pricelist[ $Building ]['factor'], $CurrPOST - 1 );
                    $crystal = $pricelist[ $Building ]['crystal'] * pow( $pricelist[ $Building ]['factor'], $CurrPOST - 1 );
                    $deuterium = $pricelist[ $Building ]['deuterium'] * pow( $pricelist[ $Building ]['factor'], $CurrPOST - 1 );
					$tritium = $pricelist[ $Building ]['tritium'] * pow( $pricelist[ $Building ]['factor'], $CurrPOST - 1 );
                $value = $CurrPOST;
                $points = $points / $game_config['stat_settings'];
            }
            $totalpoints += $points;
        
        $parse['build_rows'] .= '<tr><th>'.$lang['tech'][$Building].'</th><th><input type="text" name="element'.$Building.'" size="14" value="'.$value.'"/></th><th>'.pretty_number(floor($metal)).'</th><th>'.pretty_number(floor($crystal)).'</th><th>'.pretty_number(floor($deuterium)).'</th><th>'.pretty_number(floor($tritium)).'</th><th>'.pretty_number(floor($points)).'</th>';
    }
    
    $parse['tech_rows'] = '<tr><td class="c" colspan="2">Investigaciones</td><td class="c" colspan="1">Metal</td><td class="c" colspan="1">Cristal</td><td class="c" colspan="1">Deuterio</td><td class="c" colspan="1">Tritio</td><td class="c" colspan="1">Puntos</td></tr>';
    foreach($reslist['tech'] as $Building) {
            $CurrPOST = intval($_POST['element'.$Building]);
            $metal = 0;
            $crystal = 0;
            $deuterium = 0;
            $tritium = 0;
            $points = 0;
            $value = 0;
            if ( $CurrPOST > 0 ) {
                for ( $Level = 1; $Level <= $CurrPOST; $Level++ ) {
                    $Units        = $pricelist[ $Building ]['metal'] + $pricelist[ $Building ]['crystal'] + $pricelist[ $Building ]['deuterium'] + $pricelist[ $Building ]['tritium'];
                    $LevelMul     = pow( $pricelist[ $Building ]['factor'], $Level );
                    $points += ($Units * $LevelMul);
                    
                }
                    $metal = $pricelist[ $Building ]['metal'] * pow( $pricelist[ $Building ]['factor'], $CurrPOST - 1 );
                    $crystal = $pricelist[ $Building ]['crystal'] * pow( $pricelist[ $Building ]['factor'], $CurrPOST - 1 );
                    $deuterium = $pricelist[ $Building ]['deuterium'] * pow( $pricelist[ $Building ]['factor'], $CurrPOST - 1 );
					$tritium = $pricelist[ $Building ]['tritium'] * pow( $pricelist[ $Building ]['factor'], $CurrPOST - 1 );
                $value = $CurrPOST;
                $points = $points / $game_config['stat_settings'];
            }
            $totalpoints += $points;
        
        $parse['tech_rows'] .= '<tr><th>'.$lang['tech'][$Building].'</th><th><input type="text" name="element'.$Building.'" size="14" value="'.$value.'"/></th><th>'.pretty_number(floor($metal)).'</th><th>'.pretty_number(floor($crystal)).'</th><th>'.pretty_number(floor($deuterium)).'</th><th>'.pretty_number(floor($tritium)).'</th><th>'.pretty_number(floor($points)).'</th>';
    }
    $parse['fleet_rows'] = '<tr><td class="c" colspan="2">Flota</td><td class="c" colspan="1">Metal</td><td class="c" colspan="1">Cristal</td><td class="c" colspan="1">Deuterio</td><td class="c" colspan="1">Tritio</td><td class="c" colspan="1">Puntos</td></tr>';
    foreach($reslist['fleet'] as $Building) {
            $CurrPOST = intval($_POST['element'.$Building]);
            $metal = 0;
            $crystal = 0;
            $deuterium = 0;
            $tritium = 0;
            $points = 0;
            $value = 0;
            if ( $CurrPOST > 0 ) {
                for ( $Level = 1; $Level <= $CurrPOST; $Level++ ) {
                    $Units        = $pricelist[ $Building ]['metal'] + $pricelist[ $Building ]['crystal'] + $pricelist[ $Building ]['deuterium'] + $pricelist[ $Building ]['tritium'];
                    $LevelMul     = pow( $pricelist[ $Building ]['factor'], $Level );
                    $points += ($Units * $LevelMul);
                    
                }
                    $metal = $pricelist[ $Building ]['metal'] * pow( $pricelist[ $Building ]['factor'], $CurrPOST - 1 );
                    $crystal = $pricelist[ $Building ]['crystal'] * pow( $pricelist[ $Building ]['factor'], $CurrPOST - 1 );
                    $deuterium = $pricelist[ $Building ]['deuterium'] * pow( $pricelist[ $Building ]['factor'], $CurrPOST - 1 );
					$tritium = $pricelist[ $Building ]['tritium'] * pow( $pricelist[ $Building ]['factor'], $CurrPOST - 1 );
                $value = $CurrPOST;
                $points = $points / $game_config['stat_settings'];
            }
            $totalpoints += $points;
        
        $parse['fleet_rows'] .= '<tr><th>'.$lang['tech'][$Building].'</th><th><input type="text" name="element'.$Building.'" size="14" value="'.$value.'"/></th><th>'.pretty_number(floor($metal)).'</th><th>'.pretty_number(floor($crystal)).'</th><th>'.pretty_number(floor($deuterium)).'</th><th>'.pretty_number(floor($tritium)).'</th><th>'.pretty_number(floor($points)).'</th>';
    }
    $parse['defense_rows'] = '<tr><td class="c" colspan="2">Defensas</td><td class="c" colspan="1">Metal</td><td class="c" colspan="1">Cristal</td><td class="c" colspan="1">Deuterio</td><td class="c" colspan="1">Tritio</td><td class="c" colspan="1">Puntos</td></tr>';
    foreach($reslist['defense'] as $Building) {
            $CurrPOST = intval($_POST['element'.$Building]);
            $metal = 0;
            $crystal = 0;
            $deuterium = 0;
            $tritium = 0;
            $points = 0;
            $value = 0;
            if ( $CurrPOST > 0 ) {
                for ( $Level = 1; $Level <= $CurrPOST; $Level++ ) {
                    $Units        = $pricelist[ $Building ]['metal'] + $pricelist[ $Building ]['crystal'] + $pricelist[ $Building ]['deuterium'] + $pricelist[ $Building ]['tritium'];
                    $LevelMul     = pow( $pricelist[ $Building ]['factor'], $Level );
                    $points += ($Units * $LevelMul);
                    
                }
                    $metal = $pricelist[ $Building ]['metal'] * pow( $pricelist[ $Building ]['factor'], $CurrPOST - 1 );
                    $crystal = $pricelist[ $Building ]['crystal'] * pow( $pricelist[ $Building ]['factor'], $CurrPOST - 1 );
                    $deuterium = $pricelist[ $Building ]['deuterium'] * pow( $pricelist[ $Building ]['factor'], $CurrPOST - 1 );
					$tritium = $pricelist[ $Building ]['tritium'] * pow( $pricelist[ $Building ]['factor'], $CurrPOST - 1 );
                $value = $CurrPOST;
                $points = $points / $game_config['stat_settings'];
            }
            $totalpoints += $points;
        
        $parse['defense_rows'] .= '<tr><th>'.$lang['tech'][$Building].'</th><th><input type="text" name="element'.$Building.'" size="14" value="'.$value.'"/></th><th>'.pretty_number(floor($metal)).'</th><th>'.pretty_number(floor($crystal)).'</th><th>'.pretty_number(floor($deuterium)).'</th><th>'.pretty_number(floor($tritium)).'</th><th>'.pretty_number(floor($points)).'</th>';
    }
    $parse['total_points'] = pretty_number($totalpoints);
    $Template = '<br />
<div id="content">
<form action="game.php?page=pointsimulator" method="post">
<table width="750">
<tr><th class="c" colspan="7">Calculadora de puntos</th></tr>
{build_rows}
{tech_rows}
{fleet_rows}
{defense_rows}
<tr><th colspan="5"><input type="submit" value="Calcular" /></th><td class="c" colspan="1">Total</td><th colspan="1">{total_points}</th></tr>
</table>
</form>
</div>';
    display ( parsetemplate($Template, $parse), '', false );
?>
