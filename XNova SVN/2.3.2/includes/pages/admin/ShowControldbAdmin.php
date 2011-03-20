<?php
//version 1
function ShowControldbAdmin($user){
    global $lang,$dbsettings,$svn_root,$phpEx,$db,$displays;
    require($svn_root . 'config.' . $phpEx);
if ($user['authlevel'] < 2) die($displays->message ($lang['not_enough_permissions']));

    
    if($_POST["ejecutar"]){
	
            foreach($_POST as $key => $value){
		if(is_numeric($key)){
		    $sintaxis[]=mysql_escape_string($value);
		}
	    }
	    if($sintaxis){
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
			$ejecutado=$db->query("REPAIR TABLE $ejec",""); 
		    break;
		    case "Analizar":
			$ejecutado=$db->query("ANALYZE TABLE  $ejec",""); 
		    break;
		    case "Revisar":
			$ejecutado=$db->query("CHECK TABLE $ejec",""); 
		    break;
		    case "Optimizar":
			$ejecutado=$db->query("OPTIMIZE TABLE $ejec",""); 
		    break;
		}
		$lang["informacion"]='<table width="200"><th>Tabla</th><th>Op</th><th>Msg_type</th><th>Msg_text</th></tr>';
		if($ejecutado){
		    while($infor=mysql_fetch_assoc($ejecutado)){
		
			$lang['informacion'].='<tr class="b" align="center">';
			$infor["Table"]=explode(".",$infor["Table"]);
			$infor["Table"]=$infor["Table"][1];
			$lang['informacion'].='<th class="b">'.$infor["Table"].'</th>';
			$lang['informacion'].='<td class="b">'. $infor["Op"].'</td>';
			$lang['informacion'].='<td class="b">'.$infor["Msg_type"].'</td>';
			$lang['informacion'].='<td class="b">'.$infor["Msg_text"].'</td></tr>';
		    }
		}
	    }else{
		$lang["informacion"]='<table width="200"><th>No ha seleccionado ninguna tabla</th></tr></table>';
	    }
	
    }
    
    $prueba=$db->query("SHOW TABLE STATUS from ".$dbsettings["name"]." ","");

    $displays->assignContent("adm/optimicedb");

    while($pru=mysql_fetch_assoc($prueba)){
        
        $compprefix=explode("_",$pru["Name"]);        
        if(($compprefix[0]."_")==$dbsettings["prefix"]){
                if($pru["Data_free"]>(1048576)){
                    $color='style="background-color:#BF0000;filter: alpha(opacity=80);opacity: .8;"';
		    $pru["Data_free"]=number_format($pru["Data_free"]/1048576,2,",",".") . " MB";
		}elseif($pru["Data_free"]<(1048576) && $pru["Data_free"]>(1024)){
		    $color='style="background-color:#FFD700;filter: alpha(opacity=80);opacity: .8;"';
		    $pru["Data_free"]=number_format($pru["Data_free"]/1024,2,",",".") . " Kb";
		}elseif($pru["Data_free"]<1024 && $pru["Data_free"]!=0){
		    $color='style="background-color:#4000FF;filter: alpha(opacity=80);opacity: .8;"';
		    $pru["Data_free"] =$pru["Data_free"] ." bytes";
		}else{
		    $color='';
		}
		
		$lang['tabla'].='<tr class="b" align="center" '.$color.'>';
		$lang['tabla'].='<td class="b"><strong>'.$pru["Name"].'</strong></td>';
	
		$lang['tabla'].='<td class="b">'. $pru["Rows"].'</td>';
		$pru["Data_length"]=number_format(($pru["Data_length"] + $pru["Index_length"]) / 1024,1,",", ".");
		$lang['tabla'].='<td class="b">'.$pru["Data_length"] .' Kb </td>';
		if($pru["Data_free"]!=0){
		    $lang['tabla'].='<td class="b">'. $pru["Data_free"] .' </td>';
		}else{
		    $lang['tabla'].='<td class="b"> - </td>';
		}
		$lang['tabla'].='<td class="b"><input type="checkbox" value="'.$pru["Name"].'" name="'.$a++.'"  class="b" /></td></tr>';
	    }
	}
		$displays->display();
}
?>