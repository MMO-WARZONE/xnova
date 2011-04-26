<?php
##############################################################################
# *																			 #
# * XG PROYECT																 #
# *  																		 #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar	 #
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

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$xgp_root = './../';
include($xgp_root . 'extension.inc.php');
include($xgp_root . 'common.' . $phpEx);
require($xgp_root . 'config.' . $phpEx);
    $parse = $lang;  //cargamos el idioma en el parse 
    
if ($user['authlevel'] != 3) die(message ($lang['not_enough_permissions']));    
    //Si no tiene permiso no entra
    if ($IsUserChecked == false || $user['authlevel'] < 2) {
        message($lang['sys_noalloaw'], $lang['sys_noaccess']);
    }
    
    
    if($_POST["ejecutar"]){
     
    for($i=0;$i<=19;$i++){
        if($_POST[$i]!=""){
            $sintaxis[]=$_POST[$i];
        }
    }
  	if($sintaxis == ''){header("location:db.check.php");}  
    $countsint=count($sintaxis);
    foreach ($sintaxis as $z) {
        $a++;
        if($a<$countsint){
            $ejec.=$z.",";
        }
        if($a==$countsint){
            $ejec.=$z;
        }
        
    }

    switch($_POST["accion"]){
    case "Reparar":
    $ejecutado=doquery(" REPAIR TABLE $ejec",""); 
    break;
    case "Analizar":
    $ejecutado=doquery(" ANALYZE TABLE  $ejec",""); 
    break;
    case "Revisar":
    $ejecutado=doquery("CHECK TABLE $ejec",""); 
    break;
    case "Optimizar":
    $ejecutado=doquery("OPTIMIZE TABLE $ejec",""); 
    break;
    }
    $parse["informacion"]='<table width="200">
<th>Tabla</th>
   <th>Op</th>
     <th colspan="2">Msg_type</th>
   <th colspan="3">Msg_text</th>
  </tr>';

    while($infor=mysql_fetch_assoc($ejecutado)){

        $parse['informacion'].='<tr class="b" align="center">';
        $infor["Table"]=explode(".",$infor["Table"]);
        $infor["Table"]=$infor["Table"][1];
        $parse['informacion'].='<td class="b">'.$infor["Table"].'</td>';
    
           $parse['informacion'].='<td class="b">'. $infor["Op"].'</td>';

        $parse['informacion'].='<td class="b" colspan="2">'.$infor["Msg_type"].'</td>';
        $parse['informacion'].='<td class="b" colspan="3"><nobr>'.$infor["Msg_text"].'</nobr></td></tr>';
    
    
    }




    }
    $prueba=doquery("SHOW TABLE STATUS from ".$dbsettings["name"]." ","");

    while($pru=mysql_fetch_assoc($prueba)){
        
        $compprefix=explode("_",$pru["Name"]);        
        if(($compprefix[0]."_")==$dbsettings["prefix"]){
        
        
        $parse['tabla'].='<tr class="b" align="center">';
        $parse['tabla'].='<td class="b">'.$pru["Name"].'</td>';
    
           $parse['tabla'].='<td class="b">'. $pru["Rows"].'</td>';

		 $parse['tabla'].='<td class="b">'.$pru["Engine"].'</td>';
		  $parse['tabla'].='<td class="b">'.$pru["Collation"].'</td>';
         $pru["Data_length"]=number_format(($pru["Data_length"] + $pru["Index_length"]) / 1024,1,",", ".");
           $parse['tabla'].='<td class="b"><nobr>'.$pru["Data_length"] .' KB</nobr></td>';
        if($pru["Data_free"]>1024){
            $pru["Data_free"]=number_format($pru["Data_free"]/1024,2,",",".") . " Kb";
        }else{
            $pru["Data_free"] =$pru["Data_free"] ." bytes";
        }
    
    
        if($pru["Data_free"]!=0){
            $parse['tabla'].='<td class="b">'. $pru["Data_free"] .' </td>';
        }else{
            $parse['tabla'].='<td class="b"> - </td>';
        }
        $parse['tabla'].='<td class="b"><input type="checkbox" value="'.$pru["Name"].'" name="'.$a++.'"  class="b" /></td></tr>';
        }
    }
    

    
    //Finalizamos el Parsing
    $tpl_menu = gettemplate('adm/check'); //Definimos el tpl a usar
    $menu = parsetemplate($tpl_menu, $parse); 
    display($menu, false, '', true, false);

?> 