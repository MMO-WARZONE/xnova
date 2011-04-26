<?php //galaxy.php

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;



function echo_galaxy($g,$s){

	global $planetcount,$dpath,$userrow;
  
	for($i = 1; $i < 16; $i++){//mega loop para listar los jugadores y las alianzas
		unset($planetrow);
		unset($playerrow);
		unset($allyrrow);
		
		//$planet = doquery( ,"galaxy",true);
		$galaxyrow = doquery("SELECT * FROM {{table}} WHERE galaxy = '$g' AND system='$s' AND planet = $i","galaxy",true);
		
	if($galaxyrow){
		$planetrow = doquery("SELECT * FROM {{table}} WHERE id = '".$galaxyrow["id_planet"]."'","planets",true);
		
		/*
		  Pequeña conprovacion para verificar que un planeta esta destruido
		  En caso de que sea cierto, este se quita de la base de datos si cumplio el maximo
		  de tiempo establecido en el campo destruyed
		*/
		
		if($planetrow["destruyed"] != 0){
			check_abandon_planet($planetrow);
		}else{
		$planetcount++;
		$playerrow = doquery("SELECT * FROM {{table}} WHERE id = '".$planetrow["id_owner"]."'","users",true);
		}
	}
		echo '
    <tr>
    <th width="30">
      <a href="#"';
	  
		$tabindex = $i + 1;
		$tab = ($galaxyrow["id_planet"] != 0) ? " tabindex=\"$tabindex\">": ">";
		
		echo $tab.$i;
		echo'</a>
    </th>
    <th width="30">
     ';
  if($galaxyrow && $planetrow["destruyed"] == 0 && $galaxyrow["id_planet"] != 0){
  ?>
<a style="cursor: pointer;" onmouseover="this.T_WIDTH=250;this.T_OFFSETX=-110;this.T_OFFSETY=-30;this.T_STICKY=true;this.T_TEMP=<? $T_TEMP = $userrow["settings_tooltiptime"]*1000; echo $T_TEMP; ; ?>;this.T_STATIC=true;return escape('<table width=\'240\'><tr><td class=\'c\' colspan=\'2\'>Planeta <? echo $planetrow["name"]." [$g:$s:$i]"; ?></td></tr><tr><th width=\'80\'><img src=\'<? echo $dpath."planeten/small/s_".$planetrow["image"].".jpg"; ?>\' height=\'75\' width=\'75\'/></th><th style=\'text-align: left\'><a href=\'#\' onclick=\'doit(6, 2, 288, 5, 1, 1)\'>Espiar</a><br /><br /><a href=\'flotten1.php?galaxy=2&system=288&planet=5&planettype=1&target_mission=1\'>Atacar</a><br /><a href=\'flotten1.php?galaxy=2&system=288&planet=5&planettype=1&target_mission=3\'>Transportar</a></th></tr></table>');">
      <img src="<? echo $dpath."planeten/small/s_".$planetrow["image"].".jpg"; ?>" height="30" width="30"></a><?
  }
?>
</th>
<th style="white-space: nowrap;" width="130">
<? if($galaxyrow && $planetrow["destruyed"] == 0){ echo $planetrow{"name"} ;}elseif($planetrow["destruyed"] != 0){echo "Planeta destruido";} ?></th>
<th style="white-space: nowrap;" width="30">
 

<? //Para mostrar escombros


	if($galaxyrow){
		
		if($galaxyrow["metal"] != 0 || $galaxyrow["crystal"] != 0 )
		{
			echo "\n	    <th style=\""; 
			//muestra de color rojo el fondo cuando hay muchos recursos
			if ($galaxyrow["metal"] >= 5000 || $galaxyrow["crystal"] >= 5000 )
				echo "background-color: rgb(51, 0, 0);";

?>background-image: none;" width="30">

	<a href="flotten1.php?galaxy=7&amp;system=325&amp;planet=6&amp;planettype=2&amp;target_mission=8" style="cursor: pointer;" onmouseover="this.T_WIDTH=250;this.T_OFFSETX=-110;this.T_OFFSETY=-110;this.T_STICKY=true;this.T_TEMP=<? $T_TEMP = $userrow["settings_tooltiptime"]*1000; echo $T_TEMP; ; ?>;return escape('<table width=\'240\'><tr><td class=\'c\' colspan=\'2\'>Escombros [7:325:6]</td></tr><tr><th width=\'80\'><img src=\'<? echo $dpath; ?>planeten/debris.jpg\' height=\'75\' width=\'75\' alt=\'T\'/></th><th><table><tr><td class=\'c\' colspan=\'2\'>Recursos:</td></tr><tr><th>Metal:</th><th><? echo number_format($galaxyrow["metal"],0, '', '.'); ?></th></tr><tr><th>Cristal:</th><th><? echo number_format($galaxyrow["crystal"],0, '', '.'); ?></th></tr><tr><td class=\'c\' colspan=\'2\'>Acciones:</tr><tr><th colspan=\'2\' style=\'text-align: left\'><font color=\'#808080\'>Recolectar</font></tr></table></th></tr></table>');">
<img src="<? echo $dpath; ?>planeten/debris.jpg" alt="Escombros" height="16" width="16"></a>

	  <?}else{
		echo "	      </th> \n    <th width=\"30\">";
	}//Fin escombros
	}else{
		echo "	      </th> \n    <th width=\"30\">";
	}//Fin escombros
		
echo "\n\n   </th>\n    <th width=\"150\"> \n\n     ";

  if($playerrow  && $planetrow["destruyed"] == 0){
  ?>
<a style="cursor: pointer;" onmouseover="this.T_WIDTH=200;this.T_OFFSETX=-20;this.T_OFFSETY=-30;this.T_STICKY=true;this.T_TEMP=<? $T_TEMP = $userrow["settings_tooltiptime"]*1000; echo $T_TEMP; ; ?>;return escape('<table width=\'190\'><tr><td class=\'c\' colspan=\'2\'>Jugador <? echo $playerrow["username"];?></td></tr><tr><td><a href=\'writemessages.php?messageziel=<? echo $playerrow["id"];?>\'>Escribir mensaje</a></td></tr><tr><td><a href=\'buddy.php?a=2&u=<? echo $playerrow["id"];?>\'>Solicitud de compañeros</a></td></tr></table>');"><span class="noob"><? echo $playerrow["username"];?></span></a>

<?
}//(<span class="noob">d</span>)
?>

</th>
<th width="80">
<?//Alianzas!

if($playerrow['ally_id'] &&$playerrow['ally_id'] !=0){
	
	$allyquery = doquery("SELECT * FROM {{table}} WHERE id=".$playerrow['ally_id'],"alliance",true);

	if($allyquery){
		$members_count = doquery("SELECT COUNT(DISTINCT(id)) FROM {{table}} WHERE ally_id=".$allyquery['id'].";","users",true);
		echo "<a style=\"cursor:pointer\" onmouseover=\"this.T_WIDTH=250;this.T_OFFSETX=-30;this.T_OFFSETY=-30;this.T_STICKY=true;this.T_TEMP=5000;return escape('&lt;table width=\'240\'&gt;&lt;tr&gt;&lt;td class=\'c\'&gt;Alianza ".$allyquery['ally_name']." en la posición 111 con ".$members_count[0]." Miembro(s)&lt;/td&gt;&lt;/tr&gt;&lt;th&gt;&lt;table&gt;&lt;tr&gt;&lt;td&gt;&lt;a href=\'ainfo.php?a=".$allyquery['id']."\'&gt;Ver página de alianza&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;&lt;a href=\'stat.php?start=101&who=ally\'&gt;Ver en estadísticas&lt;/a&gt;&lt;/td&gt;&lt;/tr&gt;&lt;tr&gt;&lt;td&gt;&lt;a href=\'".$allyquery["ally_web"]."\' target=\'_new\'&gt;Página principal de la alianza&lt;/td&gt;&lt;/tr&gt;&lt;/table&gt;&lt;/th&gt;&lt;/table&gt;');\">";
		echo $allyquery['ally_tag']."</a>";
	}
}

?>
</th>
<th style="white-space: nowrap;" width="125">
<?
  if($playerrow && $planetrow["destruyed"] == 0){
	if($userrow["settings_esp"] == "1"){
	
		?><a style="cursor: pointer;" onclick="<?
		echo "javascript:doit(6, $g, $s, $i, 1, 1);";
		?>"><img src="<? echo $dpath; ?>img/e.gif" alt="Espiar" title="Espiar" border="0"></a>
		<?
	}
	if($userrow["settings_wri"] == "1"){
		?>
<a href="writemessages.php?messageziel=<? echo $playerrow["id"];?>"><img src="<? echo $dpath; ?>img/m.gif" alt="Escribir mensaje" title="Escribir mensaje" border="0"></a>
		<?
	}
	if($userrow["settings_bud"] == "1"){
		?>
<a href="buddy.php?a=2&amp;u=<? echo $playerrow["id"];?>"><img src="<? echo $dpath; ?>img/b.gif" alt="Solicitud de compañeros" title="Solicitud de compañeros" border="0"></a>
<?	}
  }
?></th>
</tr>
<?
	}

}

{//init
	include("common.php");
	include("cookies.php");
	$userrow = checkcookies();//Identificación del usuario
	CheckUserExist($userrow);
}

$planetcount = 0;

if(isset($g) && isset($s)){
	$galaxy =  $g;
	$system =  $s;
}elseif(!$_POST){

	$planetrow = doquery("SELECT * FROM {{table}} WHERE id = '".$userrow["current_planet"]."'","planets",true);


	$galaxyrow = doquery("SELECT * FROM {{table}} WHERE id_planet = '".$planetrow["id"]."'","galaxy",true);
	//la posicion actual donde se encuentra el planeta activo.
	$galaxy =  (!$galaxy) ? $galaxyrow["galaxy"] : $galaxy;
	$system =  (!$system) ? $galaxyrow["system"] : $system;
  
}else{
	//Agrega o quita +1 en $galaxy
	if($_POST["galaxyLeft"]){
		$galaxy = $_POST["galaxy"] -1;
	}elseif($_POST["galaxyRight"]){
		$galaxy =  $_POST["galaxy"] +1;
	}else{
		$galaxy = (!$galaxy) ? $_POST["galaxy"] : $galaxy;//default
	}
	//Agrega o quita +1 en $system
	if($_POST["systemLeft"]){
		$system =  $_POST["system"] -1;
	}elseif($_POST["systemRight"]){
		$system =  $_POST["system"] +1;
	}else{
		$system = (!$system) ? $_POST["system"] : $system;//default
	}

}

	$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];





{

echo_head("Galaxia"); ?>
  <script language="JavaScript">
    function galaxy_submit(value) {
      document.getElementById('auto').name = value;
      document.getElementById('galaxy_form').submit();
    }

    function fenster(target_url,win_name) {
      var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=640,height=480,top=0,left=0');
new_win.focus();
    }
  </script><script language="JavaScript" src="scripts/tw-sack.js"></script><script type="text/javascript">
var ajax = new sack();
var strInfo = "";
      
function whenLoading(){
  //var e = document.getElementById('fleetstatus'); 
  //e.innerHTML = "Enviando flota...";
}
      
function whenLoaded(){
  //    var e = document.getElementById('fleetstatus'); 
  // e.innerHTML = "Flota enviada...";
}
      
function whenInteractive(){
  //var e = document.getElementById('fleetstatus'); 
  // e.innerHTML = "obteniendo datos...";
}

/* 
   We can overwrite functions of the sack object easily. :-)
   This function will replace the sack internal function runResponse(), 
   which normally evaluates the xml return value via eval(this.response).
*/

function whenResponse(){

 /*
 *
 *  600   OK
 *  601   no planet exists there
 *  602   no moon exists there
 *  603   player is in noob protection
 *  604   player is too strong
 *  605   player is in u-mode 
 *  610   not enough espionage probes, sending x (parameter is the second return value)
 *  611   no espionage probes, nothing send
 *  612   no fleet slots free, nothing send
 *  613   not enough deuterium to send a probe
 *
 */
  
  // the first three digit long return value
  retVals = this.response.split(" ");
  // and the other content of the response
  // but since we only got it if we can send some but not all probes 
  // theres no need to complicate things with better parsing

  // each case gets a different table entry, no language file used :P
  switch(retVals[0]) {
  case "600":
    addToTable("done", "success");
        changeSlots(retVals[1]);
    setShips("probes", retVals[2]);
    setShips("recyclers", retVals[3]);
    setShips("missiles", retVals[4]);
        break;
  case "601":
    addToTable("ha ocurrido un error mientras se enviaba", "error");
    break;
  case "602":
    addToTable("error, no hay luna", "error");
    break;
  case "603":
    addToTable("error, el jugador está bajo la protección de novatos", "error");
    break;
  case "604":
    addToTable("error, el jugador es demasiado fuerte", "error");
    break;
  case "605":
    addToTable("error, el jugador está en modo vacaciones", "vacation");
    break;
  case "610":
    addToTable("error, solo "+retVals[1]+" sondas disponibles, enviando", "notice");
    break;
  case "611":
    addToTable("error, no hay sondas de espionaje disponibles", "error");
    break;
  case "612":
    addToTable("error, no puedes enviar más flotas", "error");
    break;
  case "613":
    addToTable("error, no tienes suficiente deuterio", "error");
    break;
  case "614":
    addToTable("No hay planeta", "error");
    break;
  case "615":
    addToTable("error, no hay suficiente combustible", "error");
    break;
  case "616":
    addToTable("multialarma", "error");
    break;
  }
}

function doit(order, galaxy, system, planet, planettype, shipcount){
  strInfo = "Enviando "+shipcount+" sonda"+(shipcount>1?"s":"")+" a "+galaxy+":"+system+":"+planet+"...";
    
    ajax.requestFile = "flottenversand.php";

    // no longer needed, since we don't want to write the cryptic
    // response somewhere into the output html
    //ajax.element = 'fleetstatus';
    //ajax.onLoading = whenLoading;
    //ajax.onLoaded = whenLoaded; 
    //ajax.onInteractive = whenInteractive;

    // added, overwrite the function runResponse with our own and
    // turn on its execute flag
    ajax.runResponse = whenResponse;
    ajax.execute = true;

    //ajax.setVar("session", "820ef31ee76e");
    ajax.setVar("order", order);
    ajax.setVar("galaxy", galaxy);
    ajax.setVar("system", system);
    ajax.setVar("planet", planet);
    ajax.setVar("planettype", planettype);
    ajax.setVar("shipcount", shipcount);
    ajax.setVar("speed", 10);
    ajax.setVar("reply", "short");
    ajax.runAJAX();
}

/*
 * This function will manage the table we use to output up to three lines of
 * actions the user did. If there is no action, the tr with id 'fleetstatusrow'
 * will be hidden (display: none;) - if we want to output a line, its display 
 * value is cleaned and therefore its visible. If there are more than 2 lines 
 * we want to remove the first row to restrict the history to not more than 
 * 3 entries. After using the object function of the table we fill the newly
 * created row with text. Let the browser do the parsing work. :D
 */
function addToTable(strDataResult, strClass) {
  var e = document.getElementById('fleetstatusrow');
  var e2 = document.getElementById('fleetstatustable');

  // make the table row visible
  e.style.display = '';
  
  if(e2.rows.length > 2) {
    e2.deleteRow(2);
  }
  
  var row = e2.insertRow('test');

  var td1 = document.createElement("td");
  var td1text = document.createTextNode(strInfo);
  td1.appendChild(td1text);

  var td2 = document.createElement("td");

  var span = document.createElement("span");
  var spantext = document.createTextNode(strDataResult);

  var spanclass = document.createAttribute("class");
  spanclass.nodeValue = strClass;
  span.setAttributeNode(spanclass);

  span.appendChild(spantext);
  td2.appendChild(span);
  
  row.appendChild(td1);
  row.appendChild(td2);
}

function changeSlots(slotsInUse) {
  var e = document.getElementById('slots');
  e.innerHTML = slotsInUse;
}

function setShips(ship, count) {
  var e = document.getElementById(ship);
  e.innerHTML = count;
}

</script>
  
  
  
  
 <body onmousemove="tt_Mousemove(event);">
  <center>
<form action="galaxy.php" method="post" id="galaxy_form">
<input id="auto" value="dr" type="hidden">
<table border="0"> 
  <tbody><tr>
    <td>
      <table>
        <tbody><tr>
         <td class="c" colspan="3">Galaxia</td>
        </tr>
        <tr>
          <td class="l"><input name="galaxyLeft" value="&lt;-" onclick="galaxy_submit('galaxyLeft')" type="button"></td>
          <td class="l"><input name="galaxy" value="<? echo $galaxy; ?>" size="5" maxlength="3" tabindex="1" type="text">
          </td><td class="l"><input name="galaxyRight" value="-&gt;" onclick="galaxy_submit('galaxyRight')" type="button"></td>
        </tr>
       </tbody></table>
      </td>
      <td>
       <table>
        <tbody><tr>
         <td class="c" colspan="3">Sistema solar</td>
        </tr>
         <tr>
          <td class="l"><input name="systemLeft" value="&lt;-" onclick="galaxy_submit('systemLeft')" type="button"></td>
          <td class="l"><input name="system" value="<? echo $system; ?>" size="5" maxlength="3" tabindex="2" type="text">
          </td><td class="l"><input name="systemRight" value="-&gt;" onclick="galaxy_submit('systemRight')" type="button"></td>
         </tr>
        </tbody></table>
       </td>
      </tr>
      <tr>
        <td colspan="2" align="center"> <input value="Mostrar" type="submit"></td>
      </tr>
     </tbody></table>
</form>
   <table width="569">
<tbody><tr>
  <td class="c" colspan="8">Sistema solar <? echo "$galaxy:$system"; ?></td>
</tr>
   <tr>
    <td class="c">Pos</td>
    <td class="c">Planeta</td>
    <td class="c">Nombre</td>
    <td class="c">Luna</td>
    <td class="c">Escombros</td>
    <td class="c">Jugador (Estado)</td>
    <td class="c">Alianza</td>
 <td class="c">Acciones</td>   </tr>
    <? echo_galaxy($galaxy,$system); ?>
<tr>
<td class="c" colspan="6">( <?
  if($planetcount==1){
    echo "$planetcount Planeta habitado";
  }elseif($planetcount==0){
    echo "Sistema deshabitado";
  }else{
    echo "$planetcount Planetas habitados";
  }
?> )</td>
<td class="c" colspan="2"><a href="#" onmouseover="this.T_WIDTH=150;return escape('<table><tr><td class=\'c\' colspan=\'2\'>Leyenda</td></tr><tr><td width=\'125\'>Jugador fuerte</td><td><span class=\'strong\'>f</span></td></tr><tr><td>Jugador débil</td><td><span class=\'noob\'>d</span></td></tr><tr><td>Modo vacaciones</td><td><span class=\'vacation\'>v</span></td></tr><tr><td>Usuario suspendido</td><td><span class=\'banned\'>s</span></td></tr><tr><td>Inactivo 7 días</td><td><span class=\'inactive\'>i</span></td></tr><tr><td>Inactivo 28 días</td><td><span class=\'longinactive\'>I</span></td></tr></table>')">Leyenda</a></td>
</tr>
<tr>
<td class="c" colspan="8">
&nbsp;&nbsp;&nbsp;&nbsp;<span id="slots">0</span> de 9 hueco(s) in use</td>
</tr>
<tr style="display: none;" id="fleetstatusrow"><th colspan="8"><!--<div id="fleetstatus"></div>-->
<table style="font-weight: bold;" id="fleetstatustable" width="100%">
<!-- will be filled with content later on while processing ajax replys -->
</table>
</th>
</tr>
</tbody></table>
<!--(*) Movimiento de flotas o actividad en el planeta &nbsp;&nbsp;&nbsp;&nbsp;(g) Usuario suspendido<br>(i) Jugador 2 semanas inactivo&nbsp;&nbsp;&nbsp;    (I) Jugador 4 semanas inactivo<br>
<font color="#ffa0a0">Jugador fuerte </font> &nbsp;&nbsp;&nbsp; <font color="#a0ffa0">Jugador débil</font><font color="#ffffff">&nbsp;&nbsp;&nbsp; <font color="#0000ff">Modo de vacaciones</font>-->
  </center> <!-- OH MY GOD! --->
  <script language="JavaScript" src="scripts/wz_tooltip.js"></script>
	<!-- tablita  con informacion sobre algunas abreviaciones---><?/*
  <div id="tOoLtIp070" style="position: absolute; z-index: 1010; left: 0px; top: 0px; width: 150px; visibility: hidden; opacity: 1;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="150"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table><tbody><tr><td class="c" colspan="2">Leyenda</td></tr><tr><td width="125">Jugador fuerte</td><td><span class="strong">f</span></td></tr><tr><td>Jugador débil</td><td><span class="noob">d</span></td></tr><tr><td>Modo vacaciones</td><td><span class="vacation">v</span></td></tr><tr><td>Usuario suspendido</td><td><span class="banned">s</span></td></tr><tr><td>Inactivo 7 días</td><td><span class="inactive">i</span></td></tr><tr><td>Inactivo 28 días</td><td><span class="longinactive">I</span></td></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div>
  <div id="tOoLtIp063" style="position: absolute; z-index: 1010; width: 250px; opacity: 1; visibility: hidden; left: -250px; top: -122px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="250"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="240"><tbody><tr><td class="c">Alianza W.G. en la posición 31 con 51 Miembro(s)</td></tr><tr><th><table><tbody><tr><td><a href="http://ogame353.de/game/ainfo.php?session=820ef31ee76e&amp;a=3198">Ver página de alianza</a></td></tr><tr><td><a href="http://ogame353.de/game/bewerben.php?session=820ef31ee76e&amp;allyid=3198">Enviar solicitud</a></td></tr><tr><td><a href="http://ogame353.de/game/stat.php?session=820ef31ee76e&amp;start=1&amp;who=ally">Ver en estadísticas</a></td></tr><tr><td><a href="http://ogame353.de/game/redir.php?url=http://wg.superforos.com/" target="_new">Página principal de la alianza</a></td></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div>
  <div id="tOoLtIp062" style="position: absolute; z-index: 1010; left: 0px; top: 0px; width: 200px; visibility: hidden; opacity: 1;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="200"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="190"><tbody><tr><td class="c" colspan="2">Jugador DarK ZoRRo</td></tr><tr><td><a href="http://ogame353.de/game/writemessages.php?session=820ef31ee76e&amp;messageziel=132538">Escribir mensaje</a></td></tr><tr><td><a href="http://ogame353.de/game/buddy.php?session=820ef31ee76e&amp;a=2&amp;u=132538">Solicitud de compañeros</a></td></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div>
  <div id="tOoLtIp061" style="position: absolute; z-index: 1010; width: 250px; opacity: 1; visibility: hidden; left: -250px; top: -115px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="250"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="240"><tbody><tr><td class="c" colspan="2">Planeta Asuranceturix [2:288:12]</td></tr><tr><th width="80"><img src="galaxy_files/s_wasserplanet03.jpg" height="75" width="75"></th><th style="text-align: left;"><a href="#" onclick="doit(6, 2, 288, 12, 1, 1)">Espiar</a><br><br><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=12&amp;planettype=1&amp;target_mission=1">Atacar</a><br><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=12&amp;planettype=1&amp;target_mission=3">Transportar</a></th></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div>
  <div id="tOoLtIp056" style="position: absolute; z-index: 1010; width: 250px; opacity: 1; visibility: hidden; left: -250px; top: -105px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="250"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="240"><tbody><tr><td class="c">Alianza SHA en la posición 124 con 20 Miembro(s)</td></tr><tr><th><table><tbody><tr><td><a href="http://ogame353.de/game/ainfo.php?session=820ef31ee76e&amp;a=1334">Ver página de alianza</a></td></tr><tr><td><a href="http://ogame353.de/game/bewerben.php?session=820ef31ee76e&amp;allyid=1334">Enviar solicitud</a></td></tr><tr><td><a href="http://ogame353.de/game/stat.php?session=820ef31ee76e&amp;start=101&amp;who=ally">Ver en estadísticas</a></td></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div>
  <div id="tOoLtIp055" style="position: absolute; z-index: 1010; left: 0px; top: 0px; width: 200px; visibility: hidden; opacity: 1;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="200"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="190"><tbody><tr><td class="c" colspan="2">Jugador nigerio maister</td></tr><tr><td><a href="http://ogame353.de/game/writemessages.php?session=820ef31ee76e&amp;messageziel=135923">Escribir mensaje</a></td></tr><tr><td><a href="http://ogame353.de/game/buddy.php?session=820ef31ee76e&amp;a=2&amp;u=135923">Solicitud de compañeros</a></td></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp054" style="position: absolute; z-index: 1010; width: 250px; opacity: 1; visibility: hidden; left: -250px; top: -115px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="250"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="240"><tbody><tr><td class="c" colspan="2">Planeta morenosworld [2:288:11]</td></tr><tr><th width="80"><img src="galaxy_files/s_wasserplanet02.jpg" height="75" width="75"></th><th style="text-align: left;"><a href="#" onclick="doit(6, 2, 288, 11, 1, 1)">Espiar</a><br><br><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=11&amp;planettype=1&amp;target_mission=1">Atacar</a><br><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=11&amp;planettype=1&amp;target_mission=3">Transportar</a></th></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div>
  <div id="tOoLtIp052" style="position: absolute; z-index: 1010; width: 200px; opacity: 1; visibility: hidden; left: -200px; top: -33px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="200"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="190"><tbody><tr><td class="c" colspan="2">Jugador Perberos</td></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp051" style="position: absolute; z-index: 1010; width: 250px; opacity: 1; visibility: hidden; left: -250px; top: -154px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="250"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="240"><tbody><tr><td class="c" colspan="2">Escombros [2:288:10]</td></tr><tr><th width="80"><img src="galaxy_files/debris.jpg" alt="T" height="75" width="75"></th><th><table><tbody><tr><td class="c" colspan="2">Recursos:</td></tr><tr><th>Metal:</th><th>0</th></tr><tr><th>Cristal:</th><th>3.000</th></tr><tr><td class="c" colspan="2">Acciones:</td></tr><tr><th colspan="2" style="text-align: left;"><a href="#" onclick="doit(8, 2, 288, 10, 2, )">Recolectar</a></th></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp050" style="position: absolute; z-index: 1010; width: 250px; opacity: 1; visibility: hidden; left: -250px; top: -114px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="250"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="240"><tbody><tr><td class="c" colspan="2">Planeta Hollow [2:288:10]</td></tr><tr><th width="80"><img src="galaxy_files/s_wasserplanet02.jpg" height="75" width="75"></th><th style="text-align: left;"><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=10&amp;planettype=1&amp;target_mission=4">Desplegar</a><br><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=10&amp;planettype=1&amp;target_mission=3">Transportar</a></th></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp044" style="position: absolute; z-index: 1010; width: 250px; opacity: 1; visibility: hidden; left: -250px; top: -122px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="250"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="240"><tbody><tr><td class="c">Alianza UFO en la posición 4 con 60 Miembro(s)</td></tr><tr><th><table><tbody><tr><td><a href="http://ogame353.de/game/ainfo.php?session=820ef31ee76e&amp;a=81">Ver página de alianza</a></td></tr><tr><td><a href="http://ogame353.de/game/bewerben.php?session=820ef31ee76e&amp;allyid=81">Enviar solicitud</a></td></tr><tr><td><a href="http://ogame353.de/game/stat.php?session=820ef31ee76e&amp;start=1&amp;who=ally">Ver en estadísticas</a></td></tr><tr><td><a href="http://ogame353.de/game/redir.php?url=http://www.homar.org/ufo" target="_new">Página principal de la alianza</a></td></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp043" style="position: absolute; z-index: 1010; width: 200px; opacity: 1; visibility: hidden; left: -200px; top: -84px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="200"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="190"><tbody><tr><td class="c" colspan="2">Jugador capi en el ranking 449</td></tr><tr><td><a href="http://ogame353.de/game/writemessages.php?session=820ef31ee76e&amp;messageziel=113258">Escribir mensaje</a></td></tr><tr><td><a href="http://ogame353.de/game/buddy.php?session=820ef31ee76e&amp;a=2&amp;u=113258">Solicitud de compañeros</a></td></tr><tr><td><a href="http://ogame353.de/game/stat.php?session=820ef31ee76e&amp;start=401">Ver en estadísticas</a></td></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp042" style="position: absolute; z-index: 1010; width: 250px; opacity: 1; visibility: hidden; left: -250px; top: -115px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="250"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="240"><tbody><tr><td class="c" colspan="2">Planeta supreme [2:288:9]</td></tr><tr><th width="80"><img src="galaxy_files/s_normaltempplanet06.jpg" height="75" width="75"></th><th style="text-align: left;"><a href="#" onclick="doit(6, 2, 288, 9, 1, 1)">Espiar</a><br><br><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=9&amp;planettype=1&amp;target_mission=1">Atacar</a><br><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=9&amp;planettype=1&amp;target_mission=3">Transportar</a></th></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp037" style="position: absolute; z-index: 1010; left: 0px; top: 0px; width: 250px; visibility: hidden; opacity: 1;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="250"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="240"><tbody><tr><td class="c">Alianza carnica en la posición 125 con 11 Miembro(s)</td></tr><tr><th><table><tbody><tr><td><a href="http://ogame353.de/game/ainfo.php?session=820ef31ee76e&amp;a=4845">Ver página de alianza</a></td></tr><tr><td><a href="http://ogame353.de/game/bewerben.php?session=820ef31ee76e&amp;allyid=4845">Enviar solicitud</a></td></tr><tr><td><a href="http://ogame353.de/game/stat.php?session=820ef31ee76e&amp;start=101&amp;who=ally">Ver en estadísticas</a></td></tr><tr><td><a href="http://ogame353.de/game/redir.php?url=WWW.MARCA.ES" target="_new">Página principal de la alianza</a></td></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp036" style="position: absolute; z-index: 1010; width: 200px; opacity: 1; visibility: hidden; left: -200px; top: -67px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="200"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="190"><tbody><tr><td class="c" colspan="2">Jugador xircovic</td></tr><tr><td><a href="http://ogame353.de/game/writemessages.php?session=820ef31ee76e&amp;messageziel=136017">Escribir mensaje</a></td></tr><tr><td><a href="http://ogame353.de/game/buddy.php?session=820ef31ee76e&amp;a=2&amp;u=136017">Solicitud de compañeros</a></td></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp035" style="position: absolute; z-index: 1010; width: 250px; opacity: 1; visibility: hidden; left: -250px; top: -115px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="250"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="240"><tbody><tr><td class="c" colspan="2">Planeta Descapotable [2:288:8]</td></tr><tr><th width="80"><img src="galaxy_files/s_normaltempplanet01.jpg" height="75" width="75"></th><th style="text-align: left;"><a href="#" onclick="doit(6, 2, 288, 8, 1, 1)">Espiar</a><br><br><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=8&amp;planettype=1&amp;target_mission=1">Atacar</a><br><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=8&amp;planettype=1&amp;target_mission=3">Transportar</a></th></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp030" style="position: absolute; z-index: 1010; width: 250px; opacity: 1; visibility: hidden; left: -250px; top: -122px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="250"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="240"><tbody><tr><td class="c">Alianza CA.Lents en la posición 48 con 108 Miembro(s)</td></tr><tr><th><table><tbody><tr><td><a href="http://ogame353.de/game/ainfo.php?session=820ef31ee76e&amp;a=28">Ver página de alianza</a></td></tr><tr><td><a href="http://ogame353.de/game/bewerben.php?session=820ef31ee76e&amp;allyid=28">Enviar solicitud</a></td></tr><tr><td><a href="http://ogame353.de/game/stat.php?session=820ef31ee76e&amp;start=1&amp;who=ally">Ver en estadísticas</a></td></tr><tr><td><a href="http://ogame353.de/game/redir.php?url=http://usuarios.lycos.es/golemkerensky/" target="_new">Página principal de la alianza</a></td></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp029" style="position: absolute; z-index: 1010; width: 200px; opacity: 1; visibility: hidden; left: -200px; top: -67px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="200"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="190"><tbody><tr><td class="c" colspan="2">Jugador vairon</td></tr><tr><td><a href="http://ogame353.de/game/writemessages.php?session=820ef31ee76e&amp;messageziel=104557">Escribir mensaje</a></td></tr><tr><td><a href="http://ogame353.de/game/buddy.php?session=820ef31ee76e&amp;a=2&amp;u=104557">Solicitud de compañeros</a></td></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp028" style="position: absolute; z-index: 1010; width: 250px; opacity: 1; visibility: hidden; left: -250px; top: -115px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="250"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="240"><tbody><tr><td class="c" colspan="2">Planeta Zentraedis [2:288:7]</td></tr><tr><th width="80"><img src="galaxy_files/s_normaltempplanet01.jpg" height="75" width="75"></th><th style="text-align: left;"><a href="#" onclick="doit(6, 2, 288, 7, 1, 1)">Espiar</a><br><br><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=7&amp;planettype=1&amp;target_mission=1">Atacar</a><br><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=7&amp;planettype=1&amp;target_mission=3">Transportar</a></th></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp023" style="position: absolute; z-index: 1010; left: 0px; top: 0px; width: 250px; visibility: hidden; opacity: 1;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="250"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="240"><tbody><tr><td class="c">Alianza H.A.F en la posición 205 con 19 Miembro(s)</td></tr><tr><th><table><tbody><tr><td><a href="http://ogame353.de/game/ainfo.php?session=820ef31ee76e&amp;a=5280">Ver página de alianza</a></td></tr><tr><td><a href="http://ogame353.de/game/bewerben.php?session=820ef31ee76e&amp;allyid=5280">Enviar solicitud</a></td></tr><tr><td><a href="http://ogame353.de/game/stat.php?session=820ef31ee76e&amp;start=201&amp;who=ally">Ver en estadísticas</a></td></tr><tr><td><a href="http://ogame353.de/game/redir.php?url=http://3kteam.foro.st" target="_new">Página principal de la alianza</a></td></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp022" style="position: absolute; z-index: 1010; width: 200px; opacity: 1; visibility: hidden; left: -200px; top: -67px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="200"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="190"><tbody><tr><td class="c" colspan="2">Jugador Vega Nova</td></tr><tr><td><a href="http://ogame353.de/game/writemessages.php?session=820ef31ee76e&amp;messageziel=135459">Escribir mensaje</a></td></tr><tr><td><a href="http://ogame353.de/game/buddy.php?session=820ef31ee76e&amp;a=2&amp;u=135459">Solicitud de compañeros</a></td></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp021" style="position: absolute; z-index: 1010; width: 250px; opacity: 1; visibility: hidden; left: -250px; top: -115px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="250"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="240"><tbody><tr><td class="c" colspan="2">Planeta Xkandalo [2:288:6]</td></tr><tr><th width="80"><img src="galaxy_files/s_dschjungelplanet02.jpg" height="75" width="75"></th><th style="text-align: left;"><a href="#" onclick="doit(6, 2, 288, 6, 1, 1)">Espiar</a><br><br><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=6&amp;planettype=1&amp;target_mission=1">Atacar</a><br><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=6&amp;planettype=1&amp;target_mission=3">Transportar</a></th></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp016" style="position: absolute; z-index: 1010; width: 200px; opacity: 1; visibility: hidden; left: -200px; top: -67px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="200"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="190"><tbody><tr><td class="c" colspan="2">Jugador elwe</td></tr><tr><td><a href="http://ogame353.de/game/writemessages.php?session=820ef31ee76e&amp;messageziel=151334">Escribir mensaje</a></td></tr><tr><td><a href="http://ogame353.de/game/buddy.php?session=820ef31ee76e&amp;a=2&amp;u=151334">Solicitud de compañeros</a></td></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp015" style="position: absolute; z-index: 1010; width: 250px; opacity: 1; visibility: hidden; left: -250px; top: -115px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="250"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="240"><tbody><tr><td class="c" colspan="2">Planeta Dinduil [2:288:5]</td></tr><tr><th width="80"><img src="galaxy_files/s_dschjungelplanet01.jpg" height="75" width="75"></th><th style="text-align: left;"><a href="#" onclick="doit(6, 2, 288, 5, 1, 1)">Espiar</a><br><br><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=5&amp;planettype=1&amp;target_mission=1">Atacar</a><br><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=5&amp;planettype=1&amp;target_mission=3">Transportar</a></th></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp010" style="position: absolute; z-index: 1010; width: 200px; opacity: 1; visibility: hidden; left: -200px; top: -67px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="200"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="190"><tbody><tr><td class="c" colspan="2">Jugador chepi</td></tr><tr><td><a href="http://ogame353.de/game/writemessages.php?session=820ef31ee76e&amp;messageziel=151650">Escribir mensaje</a></td></tr><tr><td><a href="http://ogame353.de/game/buddy.php?session=820ef31ee76e&amp;a=2&amp;u=151650">Solicitud de compañeros</a></td></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp09" style="position: absolute; z-index: 1010; width: 250px; opacity: 1; visibility: hidden; left: -250px; top: -115px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="250"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="240"><tbody><tr><td class="c" colspan="2">Planeta moronlandia [2:288:4]</td></tr><tr><th width="80"><img src="galaxy_files/s_dschjungelplanet01.jpg" height="75" width="75"></th><th style="text-align: left;"><a href="#" onclick="doit(6, 2, 288, 4, 1, 1)">Espiar</a><br><br><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=4&amp;planettype=1&amp;target_mission=1">Atacar</a><br><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=4&amp;planettype=1&amp;target_mission=3">Transportar</a></th></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp03" style="position: absolute; z-index: 1010; width: 200px; opacity: 1; visibility: hidden; left: -200px; top: -67px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="200"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="190"><tbody><tr><td class="c" colspan="2">Jugador Falken</td></tr><tr><td><a href="http://ogame353.de/game/writemessages.php?session=820ef31ee76e&amp;messageziel=139777">Escribir mensaje</a></td></tr><tr><td><a href="http://ogame353.de/game/buddy.php?session=820ef31ee76e&amp;a=2&amp;u=139777">Solicitud de compañeros</a></td></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table></div><div id="tOoLtIp02" style="position: absolute; z-index: 1010; width: 250px; opacity: 1; visibility: hidden; left: -250px; top: -115px;"><table bgcolor="#003399" border="0" cellpadding="0" cellspacing="0" width="250"><tbody><tr><th style="padding: 0px;" class="tooltip_border"><table border="0" cellpadding="3" cellspacing="1" width="100%"><tbody><tr><th style="padding: 3px; text-align: left;" align="left" bgcolor="#344566"><table width="240"><tbody><tr><td class="c" colspan="2">Planeta Colonia [2:288:2]</td></tr><tr><th width="80"><img src="galaxy_files/s_trockenplanet05.jpg" height="75" width="75"></th><th style="text-align: left;"><a href="#" onclick="doit(6, 2, 288, 2, 1, 1)">Espiar</a><br><br><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=2&amp;planettype=1&amp;target_mission=1">Atacar</a><br><a href="http://ogame353.de/game/flotten1.php?session=820ef31ee76e&amp;galaxy=2&amp;system=288&amp;planet=2&amp;planettype=1&amp;target_mission=3">Transportar</a></th></tr></tbody></table></th></tr></tbody></table></th></tr></tbody></table>
  </div>*/?>

 </body></html>
<?}


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