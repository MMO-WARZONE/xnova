<?

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;

	
include("common.php");
include("cookies.php");


function infos(){




}

$userrow = checkcookies(); // Login (or verify) if not logged in.

	CheckUserExist($userrow);

$planetrow = doquery("SELECT * FROM {{table}} WHERE id = '".$userrow["current_planet"]."'","planets",true);

echo_head("Flota"); ?>
<script language=JavaScript> //if (parent.frames.length == 0) { top.location.href = "http://es.ogame.org/"; } </script> <script language="JavaScript">
function haha(z1) {
  eval("location='"+z1.options[z1.selectedIndex].value+"'");
}

</script>
  <script language="JavaScript" src="js/flotten.js"></script>
  <script language="JavaScript" src="js/ocnt.js"></script>
 <body onload="javascript: shortInfo();">
<center>
<? echo_topnav(); ?>
  </center>
<br />
<center>
<table width="519" border="0" cellpadding="0" cellspacing="1">
<form action="flottenversand.php?session=ffd582c9e901" method="POST">
<input name="thisgalaxy" type="hidden" value="7" />
<input name="thissystem" type="hidden" value="327" />
<input name="thisplanet" type="hidden" value="5" />
<input name="thisplanettype" type="hidden" value="1" />

<input name="speedfactor" type="hidden" value="1" />
<input name="thisresource1" type="hidden" value="1779594" />
<input name="thisresource2" type="hidden" value="989186" />
<input name="thisresource3" type="hidden" value="2403456" />
<input name="galaxy" type="hidden" value="7" />
<input name="system" type="hidden" value="327" />
<input name="planet" type="hidden" value="12" />
<input name="planettype" type="hidden" value="1" />

   <input type="hidden" name="ship202" value="58" />
  <input type="hidden" name="consumption202" value="20"/>
  <input type="hidden" name="speed202" value="28000" />
  <input type="hidden" name="capacity202" value="5000" /> 
     <input type="hidden" name="ship203" value="140" />

  <input type="hidden" name="consumption203" value="50"/>
  <input type="hidden" name="speed203" value="17250" />
  <input type="hidden" name="capacity203" value="25000" /> 
     <input type="hidden" name="ship204" value="1655" />
  <input type="hidden" name="consumption204" value="20"/>
  <input type="hidden" name="speed204" value="28750" />
  <input type="hidden" name="capacity204" value="50" /> 
     <input type="hidden" name="ship205" value="27" />
  <input type="hidden" name="consumption205" value="75"/>
  <input type="hidden" name="speed205" value="28000" />

  <input type="hidden" name="capacity205" value="100" /> 
     <input type="hidden" name="ship206" value="128" />
  <input type="hidden" name="consumption206" value="300"/>
  <input type="hidden" name="speed206" value="42000" />
  <input type="hidden" name="capacity206" value="800" /> 
     <input type="hidden" name="ship207" value="49" />
  <input type="hidden" name="consumption207" value="500"/>
  <input type="hidden" name="speed207" value="31000" />
  <input type="hidden" name="capacity207" value="1500" /> 
     <input type="hidden" name="ship209" value="69" />

  <input type="hidden" name="consumption209" value="300"/>
  <input type="hidden" name="speed209" value="4600" />
  <input type="hidden" name="capacity209" value="20000" /> 
     <input type="hidden" name="ship210" value="1117" />
  <input type="hidden" name="consumption210" value="1"/>
  <input type="hidden" name="speed210" value="230000000" />
  <input type="hidden" name="capacity210" value="5" /> 
     <input type="hidden" name="ship211" value="11" />
  <input type="hidden" name="consumption211" value="1000"/>
  <input type="hidden" name="speed211" value="11200" />

  <input type="hidden" name="capacity211" value="500" /> 
     <input type="hidden" name="ship213" value="53" />
  <input type="hidden" name="consumption213" value="1000"/>
  <input type="hidden" name="speed213" value="15500" />
  <input type="hidden" name="capacity213" value="2000" /> 
     <input type="hidden" name="speed" value="10" />

<tr height="20" align="left">
<td class="c" colspan="2">7:327:12 - Planeta</td>
</tr>
<tr valign="top" align="left">
<th width="50%">

  <table width="259" border="0"  cellpadding="0" cellspacing="0" >
  <tr height="20">
  <td class="c" colspan="2">Misión</td>
  </tr>
    <tr height="20">
<th>
  <input type="radio" name="order" value="3" >Transportar<br />
   </th>

  </tr>
  <tr height="20">
<th>
  <input type="radio" name="order" value="4" >Desplegar<br />
   </th>
  </tr>
   </table>
</th>
<th>
     <table  width="259" border="0" cellpadding="0" cellspacing="0">

     <tr height="20">
  <td colspan="3" class="c">Recursos</td>
     </tr>
       <tr height="20">
      <th>Metal</th>
      <th><a href="javascript:maxResource('1');">max</a></th>
      <th><input name="resource1" type="text" alt="Metal 1779126" size="10" onChange="calculateTransportCapacity();" /></th>

     </tr>
       <tr height="20">
      <th>Cristal</th>
      <th><a href="javascript:maxResource('2');">max</a></th>
      <th><input name="resource2" type="text" alt="Cristal 989002" size="10" onChange="calculateTransportCapacity();" /></th>
     </tr>
       <tr height="20">
      <th>Deuterio</th>

      <th><a href="javascript:maxResource('3');">max</a></th>
      <th><input name="resource3" type="text" alt="Deuterio 2403387" size="10" onChange="calculateTransportCapacity();" /></th>
     </tr>
       <tr height="20">
  <th>Resto</th>
      <th colspan="2"><div id="remainingresources">-</div></th>
     </tr>      
     <tr height="20">

  <th colspan="3"><a href="javascript:maxResources()">Todos los recursos</a></th>
     </tr>

  <tr height="20"> 
  <th>&nbsp; </th>
  </tr>

  
      </table>
</th>
</tr>

<tr height="20" >
 <th colspan="2"><input type="submit" value="Continuar" /></th>
</tr>
 </form>
</table></body>
</html>
<?

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