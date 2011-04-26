<?

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;
 

include("common.php");
include("cookies.php");

{//info
	$userrow = checkcookies();//Identificación del usuario
	CheckUserExist($userrow);
	include(INCLUDES_PATH."planet_toggle.php");//Cambia de planeta
	$planetrow = doquery("SELECT * FROM {{table}} WHERE id = '".$userrow["current_planet"]."'","planets",true);

	$missiontype = array(
		1 => 'Atacar',
		3 => 'Transportar',
		4 => 'Desplazar',
		5 => 'Destruir',
		6 => 'Espiar',
		7 => 'Posicionar flota',
		8 => 'Reciclar',
		9 => 'Colonizar',
		);
		
	$speed = array(
		1 => 10,
		2 => 20,
		3 => 30,
		4 => 40,
		5 => 50,
		6 => 60,
		7 => 70,
		8 => 80,
		9 => 90,
		10 => 100,
		);
}

if($_POST){
	/*
	  UUURRRRGGGGGG!!!!
	*/
	//en caso de que no exista el tipo de planeta destino
	if(!$_POST['planettype']){error('Debes elegir el tipo de destino.');}

	//para las coordenadas del planeta destino
	if(!$_POST['galaxy']){$error++;$errorlist .= 'Debes elegir la galaxia destino.';}
	if(!$_POST['system']){$error++;$errorlist .= 'Debes elegir el sistema destino.';}
	if(!$_POST['planet']){$error++;$errorlist .= 'Debes elegir la posicion destino.';}

	//Para comprobar de que la flota que se envia, sea la misma del planeta
    if($_POST['thisgalaxy'] != $planetrow['galaxy']|$_POST['thissystem'] != $planetrow['system']|$_POST['thisplanet'] != $planetrow['planet']|$_POST['thisplanettype'] != $planetrow['planet_type']){error('...');}
	//Se comprueba de que se tengan los recursos.
	if($_POST['resource1'] > $planetrow['metal']|$_POST['resource2'] > $planetrow['crystal']|$_POST['resource3'] > $planetrow['deuterium']){error("No tienes suficientes recursos.");}
	
	/*
	  Ahora se debe obtener la lista de naves, para agregarlas a la array
	  Solo un megaloop comprobando si esta la nave, y cuantas.
	*/
	$fleet='';

	foreach($tech as $i => $n){
		
		if($i > 200&&$i < 300 && $_POST["ship$i"] != 0){
			
			if($_POST["ship$i"] <= $planetrow[$resource[$i]]){
				$fleet['fleetarray'][$i] = $_POST["ship$i"];
				$fleet['fleetlist'] .= $i.",".$_POST["ship$i"]."\r\n";
				$fleet['amount'] += $_POST["ship$i"];
			}
		}
	}
	
	if(!$fleet['fleetlist']){error("Debes seleccionar al menos una nave.");}

	$fleet['start_time'] = 30 + time();
	$fleet['end_time'] = 60 + time();

	//$fleetlist contiene la lista de flotas, Esta se colocara en una row
	//dentro de la sql
	doquery("INSERT INTO {{table}} SET
	`fleet_mission`={$_POST[mission]},
	`fleet_amont`={$fleet[amount]},
	`fleet_array`='{$fleet[fleetlist]}',
	`fleet_start_time`= {$fleet[start_time]},
	`fleet_start_galaxy`={$_POST[galaxy]},
	`fleet_start_system`={$_POST[system]},
	`fleet_start_planet`={$_POST[planet]},
	`fleet_start_type`={$_POST[planettype]},
	`fleet_end_time`={$fleet[end_time]},
	`fleet_end_galaxy`={$_POST[thisgalaxy]},
	`fleet_end_system`={$_POST[thissystem]},
	`fleet_end_planet`={$_POST[thisplanet]},
	`fleet_end_type`={$_POST[thisplanettype]},
	`fleet_resource_metal` = {$_POST[resource1]},
	`fleet_resource_crystal` = {$_POST[resource2]},
	`fleet_resource_deuterium` = {$_POST[resource3]}",'fleets');
	
	//$missiontype corresponde al tipo de accion a tomar.

	$page = '<table border="0" cellpadding="0" cellspacing="1" width="519">';
	$page .= '<tr height="20"><td class="c" colspan="2">';
	$page .= '<span class="success">La flota ha sido enviada:</span>';
	$page .= '</td></tr>';
	$page .= "<tr height=20><th>Misión</th><th>Transportar</th></tr>";
	$page .= "<tr height=20><th>Distancia</th><th>{$fleet[distance]}</th></tr>";
	$page .= "<tr height=20><th>Velocidad</th><th>{$fleet[speed]}</th></tr>";
	$page .= "<tr height=20><th>Consumo</th><th>{$fleet[speed]}</th></tr>";
	$page .= "<tr height=20><th>Comienzo</th><th>{$fleet[start]}</th></tr>";
	$page .= "<tr height=20><th>Objetivo</th><th>{$fleet[objetivo]}</th></tr>";
	$page .= "<tr height=20><th>Hora de llegada</th><th>";
	//hora de lleada
	$page .= date("M D d H:m:s",$fleet['start_time']).'</th></tr>';
	$page .= '<tr height="20"><th>Hora de vuelta</th><th>';
	//Hora de vuelta
	$page .= date("M D d H:m:s",$fleet['end_time']).'</th></tr>';
	$page .= '<tr height="20"><td class="c" colspan="2">Naves</td></tr>';
	//Naves
	foreach($fleet['fleetarray'] as $a => $b){
		$a = $pricelist[$a]['name'];
		$page .= "<tr height=\"20\"><th width=\"50%\">$a</th><th>$b</th></tr>";
	}
	
	$page .= '</table>';
	display($page,'Flotas');
}
else{

if(!$g){$g = $planetrow['galaxy'];}
if(!$s){$s = $planetrow['system'];}
if(!$p){$p = $planetrow['planet'];}
if(!$t){$t = $planetrow['planet_type'];}

$page = '<script language="JavaScript" src="scripts/flotten.js"></script>
<script language="JavaScript" src="scripts/ocnt.js"></script>
<form action="" method="post">
  <center>
    <table width="519" border="0" cellpadding="0" cellspacing="1">
      <tr height="20">
        <td colspan="8" class="c">Flotas (max. '.++$userrow[$resource[108]].')</td>
      </tr>
      <tr height="20">
        <th>Num.</th>
        <th>Misión</th>
        <th>Cantidad</th>
        <th>Comienzo</th>
        <th>Salida</th>
        <th>Objetivo</th>
        <th>Llegada</th>
        <th>Orden</th>
      </tr>';
/*
  Aqui se debe de mostrar los movimientos de flotas, propios del jugador
*/

$fq = doquery("SELECT * FROM {{table}} WHERE fleet_owner={$userrow[id]}",'fleets');
$i=0;
while($f = mysql_fetch_array($fq)){
	$i++;
	
	$page .= "<tr height=20><th>$i</th><th>";
	$page .= "<a title=\"\">{$missiontype[$f[fleet_mission]]}</a>";
	$page .= "<a title=\"Volver al planeta\">(V)</a>";
	$page .= "</th><th><a title=\"";
	/*
	  Se debe hacer una lista de las tropas
	*/
	$fleet = explode("\r\n",$f['fleet_array']);
	$e=0;
	foreach($fleet as $a =>$b){
		if($b != ''){
			$e++;
			$a = explode(",",$b);
			$page .= "{$tech{$a[0]}}: {$a[1]}\n";
			if($e>1){$page .= "\t";}
		}
	}
	$page .= "\">{$f[fleet_amount]}</a></th>";
	$page .= "<th>[{$f[fleet_start_galaxy]}:{$f[fleet_start_system]}:{$f[fleet_start_planet]}]</th>";
	$page .= "<th>".gmdate("D M d H:i:s",$f['fleet_start_time']-3*60*60)."</th>";
	$page .= "<th>[{$f[fleet_end_galaxy]}:{$f[fleet_end_system]}:{$f[fleet_end_planet]}]</th>";
	$page .= "<th>".gmdate("D M d H:i:s",$f['fleet_end_time']-3*60*60)."</th>";
	
	$page .= "    <th>
         <form action=\"fleet\" method=\"post\">

	<input name=\"order_return\" value=23680670 type=hidden>
        <input value=\"Enviar de regreso\" type=\"submit\">
     </form>
            <font color=\"lime\"><div id=\"time_0\"><font>9:02:22</font></div></font></th>
			</tr>";
}
if($i==0){$page .= "<th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th><th>-</th>";}
     /*      <tr height="20">
        <th>2</th>
        <th> <a title="">Recolectar</a> <a title="Volver al planeta">(V)</a> </th>
        <th> <a title="Reciclador: 1">1</a></th>
        <th>[5:328:12]</th>
        <th>Thu Jun 29 1:52:13</th>
        <th>[5:328:13]</th>
        <th>Thu Jun 29 4:44:59</th>
        <th> </th>
      </tr> */
$page .= '
    </table>
  </center>
  <center>
    <table width="519" border="0" cellpadding="0" cellspacing="1">
      <tr height="20">
        <td colspan="4" class="c">Nueva misión: elegir naves</td>
      </tr>
      <tr height="20">
        <th>Naves</th>
        <th>Disponibles</th>';
        //<!--    <th>Gesch.</th> -->
		$page .= '
        <th>-</th>
        <th>-</th>
      </tr>';
if(!$planetrow){error('WTF! ERROR!','ERROR');}//uno nunca sabe xD
/*
  Pequeñño loop para mostrar las naves que se encuentran en el planeta.
*/
foreach($tech as $i => $n){
	  
	if($i > 200&&$i < 300 && $planetrow[$resource[$i]] > 0){
		
		$page .= '<tr height="20">
        <th><a title="Velocidad: '.$pricelist[$i]['speed'].'">'.$pricelist[$i]['name'].'</a></th>
        <th>'.$planetrow[$resource[$i]].'
          <input type="hidden" name="maxship'.$i.'" value="'.$planetrow[$resource[$i]].'"/></th>
        <!--    <th>28000 -->
        <input type="hidden" name="consumption'.$i.'" value="'.$pricelist[$i]['consumption'].'"/>
        <input type="hidden" name="speed'.$i.'" value="'.$pricelist[$i]['speed'].'" />
        </th>
        <input type="hidden" name="capacity'.$i.'" value="'.$pricelist[$i]['capacity'].'" />
        </th>
        <th><a href="javascript:maxShip(\'ship'.$i.'\');shortInfo();">m&aacute;x</a> </th>
        <th><input name="ship'.$i.'" size="10" value="0" alt="'.$pricelist[$i]['name'].$planetrow[$resource[$i]].'"  onChange="shortInfo()" onKeyUp="shortInfo()"/></th>
        </tr>';
		$have_ships = true;
	}

}

if(!$have_ships){
	/*
	  En caso de que no se tenga nunguna nave, solo se cambia el boton
	  por uno que no tenga submit, y la propiedad disabled
	*/
	$page .= "<tr height=\"20\">\n";
	$page .= "<th colspan=\"4\">No hay ninguna nave</th>\n</tr>\n";
	$page .= "<tr height=\"20\">\n<th colspan=\"4\">\n";
	$page .= "<input type=\"button\" value=\"Continuar\" disabled/></th>\n";
	/* Chivo xD
	$page .= '<tr><th colspan=4>
	<iframe id="a44fb522" name="a44fb522" src="/adframe.php" framespacing="0" frameborder="no" scrolling="no" width="468" height="60"></iframe>
	<br><center></center></br>
	</th></tr>';*/
	$page .= "</tr>\n</table>\n</center>\n</form>\n";
}
else{
	$page .= '
      <tr height="20">
        <th colspan="2"><a href="javascript:noShips();shortInfo();noResources();" >Ninguna nave</a></th>
        <th colspan="2"><a href="javascript:maxShips();shortInfo();" >Todas las naves</a></th>
      </tr>';
	  

	$page .= '
    </table>
  </center>
  <div id="xform" style="display:none;"><center>
    <table width="519" border="0" cellpadding="0" cellspacing="1">';
	  
	  
	$page .= '
      <input name="thisgalaxy" type="hidden" value="'.$planetrow["galaxy"].'" />
      <input name="thissystem" type="hidden" value="'.$planetrow["system"].'" />
      <input name="thisplanet" type="hidden" value="'.$planetrow["planet"].'" />
	  <input name="speedfactor" type="hidden" value="1" />
	  <input name="thisplanettype" type="hidden" value="1" />
      <input name="thisresource1" type="hidden" value="'.floor($planetrow["metal"]).'" />
      <input name="thisresource2" type="hidden" value="'.floor($planetrow["crystal"]).'" />
      <input name="thisresource3" type="hidden" value="'.floor($planetrow["deuterium"]).'" />';
	  
	  
	  
	  
	$page .= '
      <tr height="20">
        <td colspan="2" class="c">Enviar flota</td>
      </tr>
      <tr height="20">
        <th width="50%">Objetivo</th>
        <th> <input name="galaxy" size="3" maxlength="2" onChange="shortInfo()" onKeyUp="shortInfo()" value="'.$g.'" />
          <input name="system" size="3" maxlength="3" onChange="shortInfo()" onKeyUp="shortInfo()" value="'.$s.'" />
          <input name="planet" size="3" maxlength="2" onChange="shortInfo()" onKeyUp="shortInfo()" value="'.$p.'" />
          <select name="planettype" onChange="shortInfo()" onKeyUp="shortInfo()">';
			
	$page .= '<option value="1"'.(($t==1)?" SELECTED":"").">Planeta</option>";
	$page .= '<option value="2"'.(($t==2)?" SELECTED":"").">Escombros</option>";
	$page .= '<option value="3"'.(($t==3)?" SELECTED":"").">Luna</option>";
	
	
	$page .= '
          </select>
      </tr>
      <tr height="20">
        <th>Velocidad</th>
        <th> <select name="speed" onChange="shortInfo()" onKeyUp="shortInfo()">';
		
		foreach($speed as $a => $b){
			$page .= "<option value=\"$a\">$b</option>";
		}

	$page .= '</select>
          % </th>
      </tr>
      <tr height="20">
        <th>Misión</th>
        <th> <select name="mission" onChange="shortInfo()" onKeyUp="shortInfo()">';
		
		foreach($missiontype as $a => $b){
			$page .= "<option value=\"$a\">$b</option>";
		}

	$page .= '
          </select>
          % </th>
      </tr>
      <tr height="20">
        <th>Distancia</th>
        <th><div id="distance">-</div></th>
      </tr>
      <tr height="20">
        <th>Duración (de un recorrido)</th>
        <th><div id="duration">-</div></th>
      </tr>
      <tr height="20">
        <th>Consumo de combustible</th>
        <th><div id="consumption">-</div></th>
      </tr>
      <tr height="20">
        <th>Velocidad máx.</th>
        <th><div id="maxspeed">-</div></th>
      </tr>
      <tr height="20">
        <th>Capacidad de carga</th>
        <th><div id="storage">-</div></th>
      </tr>
	  
	  </table>
	  <table width="519" border="0" cellpadding="0" cellspacing="1">
	  
	  
      <tr height="20">
        <td colspan="3" class="c">Recursos</td>
      </tr>
       <tr height="20">
      <th>Metal</th>
      <th><a href="javascript:maxResource(\'1\');">m&aacute;x</a></th>
      <th width="50%"><input name="resource1" type="text" alt="Metal '.floor($planetrow["metal"]).'" size="21" onChange="calculateTransportCapacity();" /></th>

     </tr>
       <tr height="20">
      <th>Cristal</th>
      <th><a href="javascript:maxResource(\'2\');">m&aacute;x</a></th>
      <th width="50%"><input name="resource2" type="text" alt="Cristal '.floor($planetrow["crystal"]).'" size="21" onChange="calculateTransportCapacity();" /></th>
     </tr>
       <tr height="20">
      <th>Deuterio</th>

      <th><a href="javascript:maxResource(\'3\');">m&aacute;x</a></th>
      <th width="50%"><input name="resource3" type="text" alt="Deuterio '.floor($planetrow["deuterium"]).'" size="21" onChange="calculateTransportCapacity();" /></th>
     </tr>
       <tr height="20">
  <th>Resto</th>
      <th colspan="2"><div id="remainingresources">-</div></th>
     </tr>      
     <tr height="20">
  <th colspan="2"><a href="javascript:noResources()">Ning&uacute;n recurso</a></th>
  <th><a href="javascript:maxResources()">Todos los recursos</a></th>
     </tr>

      </table>
	  <table width="519" border="0" cellpadding="0" cellspacing="1">
      <tr height="20">
        <td colspan="2" class="c">Acceso rápido <a href="fleetshortcut">(Editar)</a></td>
      </tr>';
	  
	if($userrow['fleet_shortcut']){
		/*
		  Dentro de fleet_shortcut, se pueden almacenar las diferentes direcciones
		  de acceso directo, el formato es el siguiente.
		  Nombre, Galaxia,Sistema,Planeta,Tipo
		*/
		$scarray = explode("\r\n",$userrow['fleet_shortcut']);
		$i=0;
		
		foreach($scarray as $a => $b){
			if($b!=""){
			$c = explode(',',$b);
			if($i==0){$page .= "<tr height=\"20\">";}
			$page .= "<th><a href=\"javascript:setTarget";
			$page .= "({$c[1]},{$c[2]},{$c[3]},{$c[4]}); shortInfo();\">";
			$page .= "{$c[0]} {$c[1]}:{$c[2]}:{$c[3]}";
			//Muestra un (L) si el destino pertenece a luna, lo mismo para escombros
			if($c[4]==2){$page .= " (E)";}elseif($c[4]==3){$page .= " (L)";}
			$page .= "</a></th>";
			if($i==1){$page .= "</tr>";}
			if($i==1){$i=0;}else{$i=1;}
			}
		}
		if($i==1){$page .= "<th></th></tr>";}
	
	}else{$page .= "<th colspan=\"2\">No hay ning&uacute;n acceso directo</th>";}

	$page .= '	  
      </th>
      
      </tr>
      
      <tr height="20">
        <td colspan="2" class="c">Batallas de confederación 
      </tr>
      <tr height="20">
        <th colspan="2">-</th>
      </tr>
      <tr height="20" >
        <th colspan="2"><input type="submit" value="Continuar" /></th>
      </tr>
    </table>
	  </center>
	</div>
</form>';
}
display($page,"Flota");
}
//Timer, para comprobar la velocidad del script
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