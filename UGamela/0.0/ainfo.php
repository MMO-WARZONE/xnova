<?php // ainfo.php ::  Información de las alianzas.

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;
/*
  Esta pagina solo muestra una pagina sin mucho contenido.
  El topnav fue deshabilitado por que el $a no se acarria al cambiar
  de planetas.
*/
{
include("common.php");
include("cookies.php");
$userrow = checkcookies();//Identificación del usuario
//if(!$userrow){ error('Por favor, <a href="login.php" target="_main">identificate...</a>',"Error"); }
$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];
}

if(!is_numeric($a) || !$a ){ message("No se puede hacer de esta manera","Informacion de las alianzas");}

$allyrow = doquery("SELECT ally_name,ally_tag,ally_description,ally_web,ally_image FROM {{table}} WHERE id=$a","alliance",true);

if(!$allyrow){ message("No se puede hacer de esta manera","Informacion de las alianzas");}

extract($allyrow);

$count = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE ally_id=$a;","users",true);
$ally_member_scount = $count[0];

$page .="<table width=519><tr><td class=c colspan=2>Informacion de la alianza</td></tr>";

	if($ally_image != ""){
		$page .= "<tr><th colspan=2><img src=\"$ally_image\"></td></tr>";
	}
	
	$page .= "<tr><th>Etiqueta</th><th>$ally_tag</th></tr><tr><th>Nombre</th><th>$ally_name</th></tr><tr><th>Miembros</th><th>$ally_member_scount</th></tr>";

	if($ally_description != ""){
		$page .= "<tr><th colspan=2 height=100>$ally_description</th></tr>";
	}


	if($ally_web != ""){
		$page .="<tr>
		<th>Página de inicio</th>
		<th><a href=\"$ally_web\">$ally_web</a></th>
		</tr>";
	}
	$page .= "</table>";
	
	display($page,"Información de la alianza $ally_name",false);

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