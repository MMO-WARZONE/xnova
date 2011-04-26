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

?>
<html>
<? echo_head("Flota"); ?>
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
<form action="flotten3.php?session=ffd582c9e901" method="POST">
<input name="thisgalaxy" type="hidden" value="7" />
<input name="thissystem" type="hidden" value="327" />
<input name="thisplanet" type="hidden" value="5" />
<input name="thisplanettype" type="hidden" value="1" />

<input name="speedfactor" type="hidden" value="1" />
<input name="thisresource1" type="hidden" value="1779126" />
<input name="thisresource2" type="hidden" value="989002" />
<input name="thisresource3" type="hidden" value="2403387" />
   <input type="hidden" name="ship202" value="58" />
  <input type="hidden" name="consumption202" value="20" />
  <input type="hidden" name="speed202" value="28000" />
  <input type="hidden" name="capacity202" value="5000" /> 
     <input type="hidden" name="ship203" value="140" />
  <input type="hidden" name="consumption203" value="50" />
  <input type="hidden" name="speed203" value="17250" />

  <input type="hidden" name="capacity203" value="25000" /> 
     <input type="hidden" name="ship204" value="1655" />
  <input type="hidden" name="consumption204" value="20" />
  <input type="hidden" name="speed204" value="28750" />
  <input type="hidden" name="capacity204" value="50" /> 
     <input type="hidden" name="ship205" value="27" />
  <input type="hidden" name="consumption205" value="75" />
  <input type="hidden" name="speed205" value="28000" />
  <input type="hidden" name="capacity205" value="100" /> 
     <input type="hidden" name="ship206" value="128" />

  <input type="hidden" name="consumption206" value="300" />
  <input type="hidden" name="speed206" value="42000" />
  <input type="hidden" name="capacity206" value="800" /> 
     <input type="hidden" name="ship207" value="49" />
  <input type="hidden" name="consumption207" value="500" />
  <input type="hidden" name="speed207" value="31000" />
  <input type="hidden" name="capacity207" value="1500" /> 
     <input type="hidden" name="ship209" value="69" />
  <input type="hidden" name="consumption209" value="300" />
  <input type="hidden" name="speed209" value="4600" />

  <input type="hidden" name="capacity209" value="20000" /> 
     <input type="hidden" name="ship210" value="1117" />
  <input type="hidden" name="consumption210" value="1" />
  <input type="hidden" name="speed210" value="230000000" />
  <input type="hidden" name="capacity210" value="5" /> 
     <input type="hidden" name="ship211" value="11" />
  <input type="hidden" name="consumption211" value="1000" />
  <input type="hidden" name="speed211" value="11200" />
  <input type="hidden" name="capacity211" value="500" /> 
     <input type="hidden" name="ship213" value="53" />

  <input type="hidden" name="consumption213" value="1000" />
  <input type="hidden" name="speed213" value="15500" />
  <input type="hidden" name="capacity213" value="2000" /> 
    <tr height="20">
  <td colspan="2" class="c">Enviar flota</td>
 </tr>
 <tr height="20">
  <th width="50%">Objetivo</th>

  <th>
   <input name="galaxy" size="3" maxlength="2" onChange="shortInfo()" onKeyUp="shortInfo()" value="7" />
   <input name="system" size="3" maxlength="3" onChange="shortInfo()" onKeyUp="shortInfo()" value="327" />
   <input name="planet" size="3" maxlength="2" onChange="shortInfo()" onKeyUp="shortInfo()" value="5" />
   <select name="planettype" onChange="shortInfo()" onKeyUp="shortInfo()">
     <option value="1" >Planeta </option>
  <option value="2" >Escombros </option>
  <option value="3" >Luna </option>

   </select>
 </tr>
 <tr height="20">
  <th>Velocidad</th>
  <th>
   <select name="speed" onChange="shortInfo()" onKeyUp="shortInfo()">
         <option value="10">100</option>
         <option value="9">90</option>

         <option value="8">80</option>
         <option value="7">70</option>
         <option value="6">60</option>
         <option value="5">50</option>
         <option value="4">40</option>
         <option value="3">30</option>

         <option value="2">20</option>
         <option value="1">10</option>
      
   </select> %
  </th>
 </tr>
 <tr height="20">
  <th>Distancia</th><th><div id="distance">-</div></th>

 </tr>
 <tr height="20">
  <th>Duración (de un recorrido)</th><th><div id="duration">-</div></th>
 </tr>
 <tr height="20">
  <th>Consumo de combustible</th><th><div id="consumption">-</div></th>
 </tr>

 <tr height="20">
  <th>Velocidad máx.</th><th><div id="maxspeed">-</div></th>
 </tr>
 <tr height="20">
  <th>Capacidad de carga</th><th><div id="storage">5548435</div></th>
 </tr>

  <tr height="20">
  <td colspan="2" class="c">Acceso rápido</td>
  </tr>
   
  <tr height="20">
   
   <th>
   <a href="javascript:setTarget(5,328,12,1); shortInfo()">
   Nuettad 5:328:12</a>
    </th>


   <th>
   <a href="javascript:setTarget(7,327,7,1); shortInfo()">
   Ammuk 7:327:7</a>
    </th>

   </tr>
 
  <tr height="20">
   
   <th>

   <a href="javascript:setTarget(7,327,4,1); shortInfo()">
   Zhaga 7:327:4</a>
    </th>


   <th>
   <a href="javascript:setTarget(7,327,15,1); shortInfo()">
   Nafeq 7:327:15</a>
    </th>

   </tr>
 
  <tr height="20">
   
   <th>
   <a href="javascript:setTarget(7,327,12,1); shortInfo()">
   Summok 7:327:12</a>
    </th>


   <th>

   <a href="javascript:setTarget(7,327,10,1); shortInfo()">
   Nuekumo 7:327:10</a>
    </th>

   </tr>
 
  <tr height="20">
   
   <th>
   <a href="javascript:setTarget(7,327,6,1); shortInfo()">
   Naknue 7:327:6</a>

    </th>


   <th>
   <a href="javascript:setTarget(7,327,14,1); shortInfo()">
   lol 7:327:14</a>
    </th>

   </tr>

   </th>
  </tr>

  <tr height="20">
     <td colspan="2" class="c">Batallas de confederación  
  </tr>
 <tr height="20"><th colspan="2">-</th></tr>
<tr height="20">
 <th colspan="2">
  <input type="submit" value="Continuar" />

 </th>
</tr>  
</form>

</table>

<br><center></center></br>

</body>
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