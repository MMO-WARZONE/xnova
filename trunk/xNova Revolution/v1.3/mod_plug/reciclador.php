<?php

/*
 _  \_/ |\ | /¯¯\ \  / /\    |¯¯) |_¯ \  / /¯¯\ |  |   |´¯|¯` | /¯¯\ |\ |
 ¯  /¯\ | \| \__/  \/ /--\   |¯¯\ |__  \/  \__/ |__ \_/   |   | \__/ | \|
 @copyright:
Copyright (C) 2010 por Brayan Narvaez (principe negro)
Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar

@support:
Web http://www.xnovarevolution.com.ar/
Forum http://www.xnovarevolution.com.ar/foros/

@plugin:
mod_plug system by green
adapted mod_plgu by green

Proyect based in xg proyect for xtreme gamez.
*/

class reciclador_mod extends modPl implements mod_pl{
    public function install(){
        parent::install_basic('reciclador');
             
    }
    public function exec(){
        global $planetrow, $lang, $reslist, $dpath, $res_id, $resource, $pricelist;
        parent::call_default();
        includeLang('INGAME');
        
        $parse = $lang;
        $ChatarreroTpl = gettemplate('chatarrero/chatarrero_body');
        $VentaFinalTpl = gettemplate('chatarrero/chatarrero_venta');
    
        if (array_key_exists('ship_type_id',$_POST)) {
            // tipo de nave seleccionada por el usuario
            $res_id = $_POST['ship_type_id'];
        } else {
            // nave por defecto como valor inicial en la selección (si el usuario no lo cambia manual)
            $res_id = 202;
        }
    
        if (array_key_exists('number_ships_sell',$_POST)) {
            // cantidad de naves a vender
            $number_ship_sell = $_POST['number_ships_sell'];
        } else {
            // por defecto es ninguna
            $number_ship_sell = 0;
        }
    
        // obtenemos el costo de producción por unidad, segun la nave seleccionada a vender.
        $price_metal     = $pricelist[$res_id]['metal'];
        $price_cristal   = $pricelist[$res_id]['crystal'];
        $price_deuterium = $pricelist[$res_id]['deuterium'];
    
        // porcentaje de recuperación
        $scrap_rate_metal     = 0.75;
        $scrap_rate_cristal   = 0.75;
        $scrap_rate_deuterium = 0.50;
    
        // importe real de recuperacion por unidad
        $scrap_metal     = $price_metal * $scrap_rate_metal;
        $scrap_cristal   = $price_cristal * $scrap_rate_cristal;
        $scrap_deuterium = $price_deuterium * $scrap_rate_deuterium;
    
        // verificamos que no estemos una luna
        if ($CurrentPlanet['planet_type'] == 3) {
            message($lang['ch_luna_no'],"<font color\"red\"><b>". $lang['ch_err_ferr'] ."</b></font>");
        }
    
        if ($_POST) {
        if ($number_ship_sell > 0 && $planetrow[$resource[$res_id]] != 0) {
            // si el número a vender es mayor a que se tiene se cambia por el maximo que se tiene
            if ($number_ship_sell > $planetrow[$resource[$res_id]]) {
                $number_ship_sell = $planetrow[$resource[$res_id]];
            }
            
            // calculamos el nuevo saldo de materiales por la venta de naves
            $recuperar_metal     = $number_ship_sell * $scrap_metal;
            $recuperar_cristal   = $number_ship_sell * $scrap_cristal;
            $recuperar_deuterium = $number_ship_sell * $scrap_deuterium;
            
            // actualizamos el saldo de recursos y naves del planeta
            $QryUpdatePlanet  = "UPDATE {{table}} SET ";
            $QryUpdatePlanet .= "`metal` = `metal` + '".  $recuperar_metal ."', ";
            $QryUpdatePlanet .= "`crystal` = `crystal` + '". $recuperar_cristal ."', ";
            $QryUpdatePlanet .= "`deuterium` = `deuterium` + '". $recuperar_deuterium ."', ";
            $QryUpdatePlanet .= "`". $resource[$res_id] ."` = `". $resource[$res_id] ."` - '". $number_ship_sell."' ";
            $QryUpdatePlanet .= "WHERE ";
            $QryUpdatePlanet .= "`id`='{$planetrow['id']}'";
            doquery($QryUpdatePlanet,"planets");
            
            display(parsetemplate( $VentaFinalTpl, $parse ),false);
        }
    }
    
    $parse['shiplist'] = '';
    foreach ($reslist['fleet'] as $value) {
        if ($value != 212) {
            $parse['shiplist'] .= "\n<option ";
            if ($res_id == $value) {
                $parse['shiplist'] .= "selected=\"selected\" ";
            }
            $parse['shiplist'] .= "value=\"".$value."\">";
            $parse['shiplist'] .= $lang['tech'][$value];
            $parse['shiplist'] .= "</option>";
        }
    }
    
    $parse['image']             = $res_id;
    $parse['dpath']             = $dpath;
    $parse['scrap_metal']       = $scrap_metal;
    $parse['scrap_cristal']     = $scrap_cristal;
    $parse['scrap_deuterium']   = $scrap_deuterium;
    $parse['shiptype_id']       = $res_id;
    $parse['max_ships_to_sell'] = $planetrow[$resource[$res_id]];
    $parse['ch_merchant_give_metal'] = str_replace('%met',gettemplate('chatarrero/chatarrero_metal'),$lang['ch_merchant_give_metal']);
    $parse['ch_merchant_give_crystal'] = str_replace('%crys',gettemplate('chatarrero/chatarrero_cristal'),$lang['ch_merchant_give_crystal']);
    $parse['ch_merchant_give_deutetium'] = str_replace('%deut',gettemplate('chatarrero/chatarrero_deuterium'),$lang['ch_merchant_give_deutetium']);
    
    $page = parsetemplate( $ChatarreroTpl, $parse );
    display( $page, $lang['ch_chatarrero']);       
        
    }
    public function end(){ 
               
    }
    public function pre_exec(){
        global $lang, $game_config;
        parent::lang_txt('reciclador');

    }    
    
}

?>
