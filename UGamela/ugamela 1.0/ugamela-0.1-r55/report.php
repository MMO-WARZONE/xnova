<?

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;
$id=1;
include("common.php");
include("cookies.php");

$userrow = checkcookies();//Identificación del usuario
	CheckUserExist($userrow);
if(!is_numeric($id)){error('El reporte no existe o fue borrado recientemente.','Reporte');}

$m = doquery("SELECT * FROM {{table}} WHERE message_id=$id AND message_owner=".$userrow['id'],'messages',true);

if(!$m){error('El reporte no existe o fue borrado recientemente.','Reporte');}

$page = "<table width=\"99%\"><tr><td>";
$page .= $m["message_text"];
$page .= "</td></tr></table>";

display($page,"Reporte",false);

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