<?

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;


{
	include("common.php");
	include("cookies.php");
	$userrow = checkcookies();//Identificación del usuario
	CheckUserExist($userrow);
	$dpath = (!$userrow["dpath"]) ? DEFAULT_SKINPATH : $userrow["dpath"];
}
echo_head("Recursos");
echo_topnav(); ?>
<br />
 <center>

 <!-- begin search header -->
 <form action="search.php" method="post">

 <table width="519">
  <tr>
   <td class="c">Buscar en todo Ogame</td>
  </tr>
  <tr>
   <th>
    <select name="type">
     <option value="playername"<? echo ($_POST["type"] == "playername") ? " SELECTED" : ""; ?>>Nombre del jugador</option>

     <option value="planetname"<? echo ($_POST["type"] == "planetname") ? " SELECTED" : ""; ?>>Nombre del planeta</option>
     <option value="allytag"<? echo ($_POST["type"] == "allytag") ? " SELECTED" : ""; ?>>Etiqueta de la alianza</option>
     <option value="allyname"<? echo ($_POST["type"] == "allyname") ? " SELECTED" : ""; ?>>Nombre de la alianza</option>
    </select>
    &nbsp;&nbsp;
    <input type="text" name="searchtext" value="<?echo  $searchtext; ?>"/>
    &nbsp;&nbsp;

    <input type="submit" value="Buscar!" />
   </th>
  </tr>

 <!-- end search header -->

  <!-- begin search results -->
<?

/*
  Parece que fuera ayer, que solo el juego era una fachada.
  Bueno, Here we go!
*/

switch($type){
	case "playername":
		$search = doquery("SELECT * FROM {{table}} WHERE username='$searchtext';","users");

	break;
	
	case "planetname":
		$search = doquery("SELECT * FROM {{table}} WHERE name='$searchtext'","planets");

	break;
	
	case "allytag":
		$search = doquery("SELECT * FROM {{table}} WHERE MATCH(username) AGAINST('$searchtext'IN BOOLEAN MODE);","users");

	break;
	
	case "allyname":
		$search = doquery("SELECT * FROM {{table}} WHERE MATCH(username) AGAINST('$searchtext'IN BOOLEAN MODE);","users");

	break;
	default:
		$search = doquery("SELECT * FROM {{table}} WHERE username='$searchtext';","users");
}

$i = 0;
if(isset($searchtext) && isset($type)){
	while($s = mysql_fetch_array($search)){

		if($type == "planetname"){ $p = $s; $s = doquery("SELECT * FROM {{table}} WHERE id=".$p["id_owner"],"users",true);}
		 print_r($p);
		if(($p["id"] == $s["id_planet"] && $type == "planetname") || $type == "playername" ){
			//el encabezado de los rows
			if($i == 0){
				echo '</table></form><table width="519"><tr>
			    <td class="c">Nombre</td>
			    <td class="c">&nbsp;</td>
			    <td class="c">Alianza</td>
			    <td class="c">Planeta</td>
			    <td class="c">Coordenadas</td>
			    <td class="c">Posición</td></tr>';
			}
			
			$i++;
			
			echo "<tr><th>";
			echo $s["username"];
			
			echo "</th><th>";
			echo '<a href="writemessages.php?messageziel='.$s["id"].'" alt="Escribir mensaje">';
			echo '<img src="'.$dpath.'img/m.gif" alt="Escribir mensaje" />';
			echo "</a></th><th>";
		    /*
		    <a href="ainfo.php?a=0">
		       </a>   alianza */
			echo "</th><th>";
			//query del planeta principal...
			$p = doquery("SELECT name FROM {{table}} WHERE id=".$s["id_planet"],"planets",true);
			
			echo $p["name"];
			
			echo "</th><th>";
			//query del planeta principal...
			$g = doquery("SELECT galaxy,system,planet FROM {{table}} WHERE id_planet=".$s["id_planet"],"galaxy",true);
			
			echo "<a href=\"galaxy.php?g=".$g['galaxy']."&s=".$g['system']."\">".$g['galaxy'].":".$g['system'].":".$g['planet']."</a>";
			
			echo "</th><th></th></tr>";
		
		}

	}
}
if($i == 0){echo "<tr><td class=\"c\"><a href=\"javascript:history.back(1)\">Volver</a></td></tr></table></form>";}else{echo "<tr><td class=\"c\" colspan=6><a href=\"javascript:history.back(1)\">Volver</a></td></tr></table>";}
/*
  bueno, no se pudo hacer mucho que digamos ...
*/




?>
  <!-- end search results -->
 </center>
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