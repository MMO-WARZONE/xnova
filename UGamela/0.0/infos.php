<?php //infos.php v1.0


// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;

include("common.php");
include("cookies.php");

function infos($gid){
	/*
	  Dentro de la carpeta "info" se almacenan los archivos donde se guardan por separado
	  los archivos. Dentro contiene un array el cual consiste en dos variables String.
	  array[title] y array[description].
	*/
	if(!file_exists("info/$gid.php")){error("La información que solicitaste, no existe.","Información");}
	@include("info/$gid.php"); //Incluimos el @ para evitar mostrar error

	//Para hacer:
	//Falta llenar los archivos gid de la carpeta info
	return $info;
}

$userrow = checkcookies(); //Identificación del usuario

if(!isset($userrow)){ error('Por favor, <a href="login.php" target="_main">identificate...</a>',"Error"); }


include(INCLUDES_PATH."planet_toggle.php");//Cambia de planeta

	//$planetrow = doquery("SELECT * FROM {{table}} WHERE id = '".$userrow["current_planet"]."'","planets",true);

	$info = @infos($gid);

	$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];

	if($gid>=1 &&$gid<=44){$TitleClass = str_replace('%n',$tech[0],$lang['Information_on']);}
	elseif($gid>=106 &&$gid<=199){$TitleClass = str_replace('%n',$tech[100],$lang['Information_on']);}
	elseif($gid>=202 &&$gid<=214){$TitleClass = str_replace('%n',$tech[200],$lang['Information_on']);}
	elseif($gid>=401 &&$gid<=503){$TitleClass = str_replace('%n',$tech[400],$lang['Information_on']);}

	$page = <<<HTML
<br />
<center>
<table width=519>
  <tr>
	<td class=c colspan=2>$TitleClass</td>
  </tr>
  <tr>
	<th>{$lang['Name']}</th>
	<th>{$tech[$gid]}</th>
  </tr>
  <tr>
	<th colspan=2>
	 <table>
	  <tr>
	   <td><img border=0 src="{$dpath}gebaeude/{$gid}.gif" align=top width=120 height=120></td>
	   <td>{$info['description']}</td>
	  </tr>
	 </table>
	</th>
  </tr>
</table>
HTML;


display($page,"Información");

//  Timer, para comprobar la velocidad del scriptd
if ( isset($userrow['authlevel']) && $userrow['authlevel']== 3 ) {
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoFin = $tiempo;
	$tiempoReal = ($tiempoFin - $tiempoInicio);
	echo $depurerwrote001.$tiempoReal.$depurerwrote002.$numqueries.$depurerwrote003;
}
// Created by Perberos. All rights reversed (C) 2006
?>
