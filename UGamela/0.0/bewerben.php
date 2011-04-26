<?php // alliance.php ::  Adminitrador de Alianzas.

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;

{//init
	define('IN_RBO', true);
	include('common.php');
	include('cookies.php');
	$userrow = checkcookies();
	CheckUserExist($userrow);
	include(INCLUDES_PATH."planet_toggle.php");//Cambia de planeta
}

if(!is_numeric($allyid) || !$allyid || $userrow['ally_request'] != 0 || $userrow['ally_id'] != 0){ message("No se puede hacer de esta manera","Escribir solicitud a la alianza");}

$allyrow = doquery("SELECT ally_tag,ally_request FROM {{table}} WHERE id=$allyid","alliance",true);


if(!$allyrow){ message("No se puede hacer de esta manera","Escribir solicitud a la alianza");}

extract($allyrow);

if($_POST['weiter'] == 'Enviar'){//esta parte es igual que el buscador de search.php...
	doquery("UPDATE {{table}} SET `ally_request`=$allyid WHERE `id`=".$userrow['id'],"users");
	//mensaje de cuando se envia correctamente el mensaje
	message('Solicitud registrada. Recibirás un mensaje cuando tu solicitud sea aceptada / rechazada.<br><br><a href=allianzen.php>Volver</a>','Tu solicitud');
	//mensaje de cuando falla el envio
	message('La solicitud no pudo ser asignada. Por favor intentalo de nuevo.', 'Tu solicitud');
	//$text = $_POST['text'];
}else{
	$text = ($ally_request) ? $ally_request : 'Los líderes de la alianza no han creado una muestra de solicitud';

}
	$page = '<h1>Enviar solicitud</h1> 
<table width=519><form action="bewerben.php?allyid='.$allyid.'" method=POST><tr><td class=c colspan=2>Escribir solicitud a la alianza ['.$ally_tag.'] </td></tr><tr><th>Mensaje (<span id="cntChars">604</span> / 6000 Caracteres)</th><th>
<textarea name="text" cols=40 rows=10 onkeyup="javascript:cntchar(6000)">'.$text.'</textarea></th></tr><tr><th>Ayuda</th><th><input type=submit name="weiter" value="Recargar"></th></tr><tr><th colspan=2><input type=submit name="weiter" value="Enviar"></th></tr></table></form></center>  </center>
  <script language="JavaScript" src="js/wz_tooltip.js"></script>';
  display($page,"Solicitud a la alianza $ally_tag");




//  Timer, para comprobar la velocidad del scriptd
if($userrow['authlevel'] == 3){
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoFin = $tiempo;
	$tiempoReal = ($tiempoFin - $tiempoInicio);
	echo $depurerwrote001.$tiempoReal.$depurerwrote002.$numqueries.$depurerwrote003;
}
// Created by Perberos. All rights reversed (C) 2006
?>