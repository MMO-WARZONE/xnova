<? //renameplanet.php

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;


include("common.php");
include("cookies.php");

{//init
	$userrow = checkcookies();//Identificación del usuario
	CheckUserExist($userrow);
	include(INCLUDES_PATH."planet_toggle.php");//Cambia de planeta
}

if($_POST['aktion'] == "Nombrar"){
	$newname = trim($_POST['newname']);
	if(!preg_match("/[^A-z0-9\ _\-]/", $newname) == 1 && $newname != ""){
		/*
		  Realmente no lo encuentro muy necesario. e incluso es esguro, porque si o si, se nombra en base al
		  planeta actual
		*/
		//$planet_query = doquery("SELECT * FROM {{table}} WHERE id_owner=".$userrow["id"]." AND id=".$userrow["current_planet"],"planets");
		//if($planet_query){
			doquery("UPDATE {{table}} SET `name` = '$newname' WHERE `id` = '".$userrow["current_planet"]."' LIMIT 1","planets");
		//}
	}
}elseif($_POST['aktion'] == 'Abandonar colonia'){

	$planetrow = doquery("SELECT * FROM {{table}} WHERE id = '".$userrow["current_planet"]."'","planets",true);
	$galaxyrow = doquery("SELECT * FROM {{table}} WHERE id_planet = '".$planetrow["id"]."'","galaxy",true);

	echo_head("Renombrar/Abandonar Planeta");
	echo_topnav();
	echo "
 <center>
 <h1>Renombrar y abandonar planetas</h1>
 <form action=\"renameplanet.php?pl=".$planetrow["id"]."\" method=POST>
      <table width=519>
     <tr>
      <td class=c colspan=3>Petición de seguridad</td>
     </tr>
     <tr>
      <th colspan=3>Confirmar borrado de planeta ".$galaxyrow["galaxy"].":".$galaxyrow["system"].":".$galaxyrow["planet"]." Confirmado con contraseña</th>
     </tr>
     <tr>
      <input type=hidden name=deleteid value =".$planetrow["id"].">
      <th>Contraseña</th>
      <th><input type=password name=pw></th>
      <th><input type=submit name=aktion value=\"Borrar Planeta!\" alt=\"Abandonar la colonia\"></th>
     </tr>
    </table>
   </form>
  </center>
 </body>
</html>";

	die();

}elseif($_POST['aktion'] == 'Borrar Planeta!' && $_POST['deleteid'] == $userrow["current_planet"]){

	//comprobamos la contraseña y comprobamos que el planeta actual no sea el planeta principal
	if(md5($_POST['pw']) == $userrow["password"] && $userrow['id_planet'] != $userrow["current_planet"]){
		//actualizamos el el planeta para que este modo destruido
		
		//tiempo cuando se destruira, y quedara el espacio libre
		$destruyed = time() + 60*60*24;
		doquery("UPDATE {{table}} SET `destruyed` = '$destruyed' WHERE `id` = '".$userrow["current_planet"]."' LIMIT 1","planets");
		doquery("UPDATE {{table}} SET `current_planet` = '".$userrow['id_planet']."' WHERE `id` = '".$userrow["current_planet"]."' LIMIT 1","users");
		message("La colonia ha sido abandonada.","Abandonar colonia");
	}elseif($userrow['id_planet'] == $userrow["current_planet"]){ 
		error("El planeta principal no se puede abandonar.","Abandonar colonia");
	}else{error("La contraseña es incorrecta.","Abandonar colonia");}

}

$planetrow = doquery("SELECT * FROM {{table}} WHERE id = '".$userrow["current_planet"]."'","planets",true);

$galaxyrow = doquery("SELECT * FROM {{table}} WHERE id_planet = '".$planetrow["id"]."'","galaxy",true);

echo_head("Renombrar/Abandonar Planeta");
echo_topnav();
echo "<br />
<center>
  <h1>Renombrar y abandonar planetas</h1>
  <form action=\"renameplanet.php?pl=".$planetrow["id"]."\" method=POST>
    <table width=519>
	  <tr>
	    <td class=c colspan=3>Tu planeta</td>
	  </tr>
	  <tr>
	    <th>Coordenadas</th><th>Nombre</th><th>Funciones</th>
	  </tr>
	  <tr>
	    <th>".$galaxyrow["galaxy"].":".$galaxyrow["system"].":".$galaxyrow["planet"]."</th>
	    <th>".$planetrow["name"]."</th>
	    <th><input type=submit name=aktion value=\"Abandonar colonia\" alt=\"Abandonar la colonia\"></th>
	  </tr>
	  <tr>
	    <th>Nombrar</th>
	    <th><input type=text name=newname size=25 maxlength=20></th>
	    <th><input type=submit name=aktion value=Nombrar></th>
	  </tr>
	</table>
  </form>
</center>
</body>
</html>";


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