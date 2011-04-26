<?
{//init

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;
	
	include("common.php");
	include("cookies.php");
	$userrow = checkcookies();//Identificación del usuario
	CheckUserExist($userrow);
	include(INCLUDES_PATH."planet_toggle.php");//Cambia de planeta
	$planetrow = doquery("SELECT * FROM {{table}} WHERE id = {$userrow[current_planet]}","planets",true);
	//$galaxyrow = doquery("SELECT * FROM {{table}} WHERE id_planet = '".$planetrow["id"]."'","galaxy",true);

	/*
	  Pequeña comprovacion para los almacenes `metal_max`,`crystal_max`,`deuterium_max`
	*/
	$u = 100000;//Balor basico
	$planetrow['metal_max'] = floor($u* pow(1.5,$planetrow[$resource[22]]));
	$planetrow['crystal_max'] = floor($u* pow(1.5,$planetrow[$resource[23]]));
	$planetrow['deuterium_max'] = floor($u* pow(1.5,$planetrow[$resource[24]]));
	
}

function r($i,$m,$c,$d,$e,$l){
	global $tech,$planetrow,$resource,$lang;
$p = <<<HTML
    <tr>
      <th>{$tech[$i]} ({$lang[level]} {$planetrow[$resource[$i]]})</th>
      <th><font color="#FFFFFF">$m</font>
	  <th><font color="#FFFFFF">$c</font>
      <th><font color="#FFFFFF">$d</font>
      <th><font color="#00FF00">$e</font>
      </th>  
      <th>
	  <select name="last$i" size="1">
HTML;

for($k=0;$k<11;$k++){
$y=$k*10;
$p .= " <option value=\"{$k}\"".(($l==$k)?" selected":"").">{$y}%</option>";

}

$p .= <<<HTML
      </select>
      </th> 
    </tr>
HTML;
return $p;

}

if($_POST){
	if(is_numeric($_POST['last1'])&&$_POST['last1']<=10){$planetrow['metalmine_porcent'] = $_POST['last1'];}
	if(is_numeric($_POST['last2'])&&$_POST['last1']<=10){$planetrow['crystalmine_porcent'] = $_POST['last2'];}
	if(is_numeric($_POST['last3'])&&$_POST['last1']<=10){$planetrow['deuterium_porcent'] = $_POST['last3'];}
	if(is_numeric($_POST['last4'])&&$_POST['last1']<=10){$planetrow['solarplant_porcent'] = $_POST['last4'];}
	if(is_numeric($_POST['last12'])&&$_POST['last1']<=10){$planetrow['fusion_porcent'] = $_POST['last12'];}
	if(is_numeric($_POST['last212'])&&$_POST['last1']<=10){$planetrow['satelite_porcent'] = $_POST['last212'];}
	doquery("UPDATE {{table}} SET `metalmine_porcent`={$planetrow[metalmine_porcent]}, `crystalmine_porcent`={$planetrow[crystalmine_porcent]}, `deuterium_porcent`={$planetrow[deuterium_porcent]}, `solarplant_porcent`={$planetrow[solarplant_porcent]}, `fusion_porcent`={$planetrow[fusion_porcent]}, `satelite_porcent`={$planetrow[satelite_porcent]}	WHERE `id`={$planetrow[id]};",'planets');
}

$page = "<br><br>";

{//Para sumar los totales
$mmax=20;
$cmax=10;
$dmax=0;
$emax=0;
$efree=0;
$emax=0;
$page .= <<<HTML
<center>
Factor de producción:1
<form action="" method="post">
<table width="500">
  <tr>
    <td class="c" colspan="5">
    Producción de recursos en el planeta &quot;{$planetrow[name]}&quot;
    </td>
  </tr>
  <tr>
   <th></th>
   <th>{$lang[Metal]}</th>
   <th>{$lang[Crystal]}</th>
   <th>{$lang[Deuterium]}</th>
   <th>{$lang[Energy]}</th>
  </tr>
  <tr>
   <th>Ingresos básicos</th>
   <td class="k">$mmax</td>
   <td class="k">$cmax</td>
   <td class="k">$dmax</td>
   <td class="k">$emax</td>
  </tr>
HTML;
}

if($planetrow[$resource[1]]>0){
	/*
	  Produccion por hora de la mina de metal
	  Produccion = 30*Nivel*1,1^Nivel 
	*/
	$m = floor(30*$planetrow[$resource[1]]*pow((1.1),$planetrow[$resource[1]]) * 0.1*$planetrow['metalmine_porcent']);
	$mmax += $m;
	// energia 10*Nivel*1,1^Nivel
	$e2 = floor(10 * $planetrow[$resource[1]] * pow((1.1),$planetrow[$resource[1]]));
	$e1 = floor($e2 * 0.1*$planetrow['metalmine_porcent']) ;
	$efree+=$e1;
	//funcion r();
	$e = "$e1 / $e2";
	
	$page .= r(1,$m,0,0,$e,$planetrow['metalmine_porcent']);

}
if($planetrow[$resource[2]]>0){
	/*
	  Produccion por hora de la mina de crystal
	  Produccion = 30*Nivel*1,1^Nivel 
	*/
	$c = floor(20*$planetrow[$resource[2]]*pow((1.1),$planetrow[$resource[2]]));
	$cmax+=$c;
	/*
	  energia
	  10*Nivel*1,1^Nivel 
	*/
	$e2 = floor(10 * $planetrow[$resource[2]] * pow((1.1),$planetrow[$resource[2]]));
	
	$e1 = floor($e2 * 0.1*$planetrow['crystalmine_porcent']) ;
	$efree+=$e1;
	//funcion r();
	$e = "$e1 / $e2";
	$page .= r(2,0,$c,0,$e,$planetrow['crystalmine_porcent']);
}
if($planetrow[$resource[3]]>0){
	/*
	  Produccion por hora de la mina de crystal
	  Produccion = 10*Nivel*1,1^Nivel*(-0,002*Temp.maxima+1,28 )
	*/
	$d = floor(30 * $planetrow[$resource[3]] * pow((1.1),$planetrow[$resource[3]]* (-0.002)*$planetrow['temp_max']+(1.28)) );
	$dmax+=$d;
	/*
	  energia
	  10*Nivel*1,1^Nivel 
	*/
	$e = floor(30 * $planetrow[$resource[3]] * pow((1.1),$planetrow[$resource[3]]));
	$emax+=$e;	$c = floor(20*$planetrow[$resource[2]]*pow((1.1),$planetrow[$resource[2]]));
	/*
	  energia
	  10*Nivel*1,1^Nivel 
	*/
	$e2 = floor(30 * $planetrow[$resource[3]] * pow((1.1),$planetrow[$resource[3]]));
	//$emax+=$e;
	$e1 = floor($e2 * 0.1*$planetrow['deuterium_porcent']) ;
	//funcion r();
	$e = "$e1 / $e2";
	//funcion r();
	$page .= r(3,0,0,$d,$e,0);
}
if($planetrow[$resource[4]]>0){
	/*
	  Produccion por hora de la mina de crystal
	  Produccion = 20*Nivel*1,1^Nivel 
	*/
	$e = floor(30 * $planetrow[$resource[4]] * pow((1.1),$planetrow[$resource[4]]));
	$emax+=$e;

	$page .= r(4,0,0,0,$e,$planetrow['solarplant_porcent']);
}
if($planetrow[$resource[12]]>0){
	/*
	  Produccion por hora de la mina de crystal
	  Produccion = 50*Nivel*1,1^Nivel 
	*/
	$e = floor(50 * $planetrow[$resource[12]] * pow((1.1),$planetrow[$resource[12]]));
	$emax+=$e;

	$page .= r(12,0,0,0,$e,$planetrow['fusion_porcent']);

}
if($planetrow[$resource[212]]>0){
	
	$page .= r(212,0,0,0,0,$planetrow['satelite_porcent']);
}

{//Los totales
$planetrow['metal_perhour'] = $mmax;
$planetrow['crystal_perhour'] = $cmax;
$planetrow['deuterium_perhour'] = $dmax;
$planetrow['energy_free'] = $emax - $efree;
$planetrow['energy_max'] = $emax;

$page .= "
    <tr>
  <tr>
    <th>Capacidad de los almacenes</th>
    <td class=k><font color=#00ff00>".floor($planetrow['metal_max']/1000)."k</font></td>
    <td class=k><font color=#00ff00>".floor($planetrow['crystal_max']/1000)."k</font></td>
    <td class=k><font color=#00ff00>".floor($planetrow['deuterium_max']/1000)."k</font></td>
    <td class=k><font color=#00ff00>-</font></td>
    <td class=k><input type=submit name=action value=Calcular></td>
  </tr>
  <tr>
    <th colspan=5 height=4></th>
  </tr>
  <tr> 
    <th>Suma:</th>
    <td class=k><font color=#00ff00>{$planetrow[metal_perhour]}</font></td>
    <td class=k><font color=#00ff00>{$planetrow[crystal_perhour]}</font></td>
    <td class=k><font color=#00ff00>{$planetrow[deuterium_perhour]}</font></td>
    <td class=k><font color=".(($planetrow["energy_free"]<0)?"#ff0000":"#00ff00").">{$planetrow[energy_free]}</font></td>
      <tr>
  <tr>
   <td colspan=5>
   <center>
   </center>
   </td>
  </tr> 
 
</table>
</center>";

doquery("UPDATE {{table}} SET metal_perhour=$mmax, crystal_perhour=$cmax, deuterium_perhour=$dmax, energy_free={$planetrow[energy_free]}, energy_max=$emax, metal_max={$planetrow[metal_max]},crystal_max={$planetrow[crystal_max]},deuterium_max={$planetrow[deuterium_max]}  WHERE `id`={$planetrow[id]};",'planets');

display($page,"recursos");
}
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