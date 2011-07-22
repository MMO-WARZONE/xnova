<?php

/**
 * Inactivos.php
 *
 * www.waterspace.info
 * Desarrollado por 5aMu para XGProyect
 */


if(!defined('INSIDE')){ die(header("location:../../"));}

            $mtime        = microtime();
            $mtime        = explode(" ", $mtime);
            $mtime        = $mtime[1] + $mtime[0];
            $starttime    = $mtime;

$fecha_actual = time();
$fecha_tope   = time();
  $i = 0;
  $Tope=30;
  $Page ='<div id="content">'.MuestraFormulario().'';

  if (isset($_POST['dias'])==true ) { $Tope =$_POST['dias']; }

  $Page .= '<br /><table><tr><th>Jugadores Inactivos</th><th> Tiempo desde su Ingreso(d&iacute;as) </th><th> Fecha de Ingreso </th><th> Último Acceso </th><th>En Vacaciones</th><th> Baneado </th></tr>';
for ($dia=$Tope;$dia>2;$dia--) {

    $fecha1=$fecha_actual-(24*60*60*$dia);
    $fecha2 = $fecha_actual-(24*60*60*($dia+1));


      $query = doquery("SELECT * FROM {{table}} WHERE onlinetime <= ".$fecha1." and onlinetime >".$fecha2." ", "users");



while ($u = mysql_fetch_array($query)) {
$Vacaciones = "No";
$Baneado= "No";
if ($u[urlaubs_modus]==1) {


 $Dias =date("d",time()-($u[urlaubs_modus_time]-172800));
 $Vacas++;
 $Vacaciones = "<a href='#' onmouseover=\"return overlib('<table border=1 width=200><tr><td align=left><font color=white>Inicio Vacaciones: <font></td><td  align=right><font color=white>".date("d/m/Y",($u[urlaubs_modus_time]-172800))."<font></td></tr><tr><td>Tiempo en vacaciones</td><td align=right>".$Dias."</td></tr></table>');\" onmouseout=\"return nd();\" ><b>Si</b></a>";



}
if ($u[bana]==1) {$Baneado="<b>Si</b>";$Ban++;}


$DesdeIngreso=date("d",time()-$u[register_time]);
$Page .="<tr><td style='text-align:center;'>".$u[username]."</td><td style='text-align:center;'>".$DesdeIngreso."</td><td style='text-align:center;'>".date("d/m/Y",$u[register_time])."</td><td style='text-align:center;'>".date("d/m/Y",$u[onlinetime])."</td><td align='center'>".$Vacaciones."</td><td align='center'>".$Baneado."</td></tr>";
$i++;
}


}

$Page .="<tr><th class='b' colspan='6' align='center'><table><tr><td align='right'>Inactivos </td><td align='right'>".($i-$Vacas-$Ban)."</td></tr><tr><td align='right'>Vacaciones </td><td align='right'>".$Vacas."</td></tr><tr><td align='right'> Baneados </td><td align='right'>".$Ban."</td></tr><tr><td align='right'>Total </td><td align='right'>".$i."</tr></td></th></tr></table><br />";

            $mtime        = microtime();
            $mtime        = explode(" ", $mtime);
            $mtime        = $mtime[1] + $mtime[0];
            $endtime      = $mtime;
            $totaltime    = ($endtime - $starttime);
    $Page .= "<br /><center>Generado en: ".$totaltime."</center></div>";


return display( $Page, true);

return $formulario;
function MuestraFormulario() {
$formulario =  '<form name"Inactivos" method="POST" action="Inactivos.php">';
}
?> 
