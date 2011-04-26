<?  //banned.php

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;


{//init
	include("common.php");
	include("cookies.php");

	$userrow = checkcookies();//Identificación del usuario
	//if(!$userrow){ error('Por favor, <a href="login.php" target="_main">identificate...</a>',"Error"); }
	$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];
}


$i = (is_numeric($from)&&isset($from)) ? $from : 0;

echo_head("Suspensiones en Ugamela");
if($userrow){echo_topnav();}
echo "<center>\n";

echo '   <b>Suspensiones en Ugamela</b>

   <p>Este listado muestra qué jugadores han sido bloqueados, por qué motivo y durante cuánto tiempo. </p>

   <table border="0" cellpadding="2" cellspacing="1">
    <tr height="20">
     <td class="c">Cuando</td>
     <td class="c">Administrador</td>
     <td class="c">Jugador</td>

     <td class="c">Suspendido hasta</td>
     <td class="c">Motivo</td>
    </tr>';
// aqui realizamos el query
$count = 0;
$banned = doquery("SELECT * FROM {{table}} LIMIT $i,50","banned");
//un while
while($b = mysql_fetch_array($banned)){
	echo "<tr height=20>";
	echo "<th>".gmdate("D M d Y H:i:s",$b["time"]-3*60*60)."</th>";
	echo "<th>";
	echo '<a href="mailto:'.$b["author"].'@ugamela.com?subject=banned:'.$b["id"].'">'.$b["author"]."</a>";
	echo "</th>";
	echo "<th>".$b["who"]."</th>";
	echo "<th>".gmdate("D M d Y H:i:s",$b["longer"]-3*60*60)."</th>";
	echo "<th>".$b["theme"]."</th>";
	echo "</tr>";
	$count++;
}

if($count == 0){echo "<tr height=20><th colspan=\"5\">No hay ninguna entrada</th></tr>";}
//fin del while

$ia=$i-50;
$i+=50;
echo "<tr>";
echo '<th colspan="5">';
if($i >50){echo "<a href=\"?from=$ia\">&lt;&lt; Anterior 50</a>&nbsp;&nbsp;&nbsp;&nbsp;";}
echo "<a href=\"?from=$i\">Siguiente 50 >></a>";
echo "</th>";
echo "</tr>";

echo "</table></center></body></html>";


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