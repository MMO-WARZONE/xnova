<?php // login2.php :: Permite identificar al usuario, crear la cookie. Y lo redirige a index.php

// Timer, para comprobar la velocidad del script
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoInicio = $tiempo;

include("common.php");

if($_POST){ //si no se establecio un post manda al login.php

$COOKIE_NAME = "ugamela";

//Se realiza una quiery buscando el nombre de usuario
$login = doquery("SELECT * FROM {{table}} WHERE `username` = '".$_POST['username']."' LIMIT 1","users",true);

if($login) //Si se encuentra un usuario, $login es una array
{ //Se identifica la contraseña
	
    if($login['password'] == md5($_POST['password'])){
	//Se da un mensaje de aprovacion, y se redirecciona.
	//Se puede optar por no utilizar, y solo hacer un header location
		
		if (isset($_POST["rememberme"])){//Para mantener mas tiempo la expiracion de la cookie
			$expiretime = time()+31536000; $rememberme = 1;
		} else { $expiretime = 0; $rememberme = 0; }
		include "config.php";
		$cookie = $login["id"] . " " . $login["username"] . " " . md5($login["password"] . "--" . $dbsettings["secretword"]) . " " . $rememberme;
		setcookie($COOKIE_NAME, $cookie, $expiretime, "/", "", 0);
		unset($dbsettings);
	//	  echo '<META HTTP-EQUIV="refresh" content="3;URL=javascript:self.location=\'index.php\';">'."\n";
	  message('Identificación confirmada, <a href="./"><blink>redireccionando...</blink></a><br><center><img src="img/progressbar.gif"></center>',"Espere por favor","./","3");
    }
	else
	{//Muestra un mensaje de error.
		
		error('Contrase&ntilde;a incorrecta<br /><a href="login.php" target="Mainframe">Volver</a>',"Error al identificarse");
		
	}

}
else
{ //Cuando $login no contiene datos de jugadores

  error("El jugador no existe.","Error al identificarse");

}
}
else{//Vista normal

echo "<!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">\n";
echo "<html xmlns=\"http://www.w3.org/1999/xhtml\" lang=\"es\" xml:lang=\"es\" id=\"ogame\">";
echo_head("Login");
echo "<style type=\"text/css\">
<!--
body {
background-color: #061229;
background-position:center bottom;
background-repeat:no-repeat;
background-image: url(img/border/mainback.gif);
margin:0px 10px 0px 10px;
font-family:Arial, Helvetica, sans-serif; 
font-size:9px; 
color:#54718D; 
}

form{margin:0px;}
table{border:0px;}
tr, td{font-size:12px;}

a{color:#9EBDE4; text-decoration:none;}
a:hover{color:#CADFFA; text-decoration:underline;}
a.footer_link{font-size:10px; color:#AABFDA; text-decoration:none;}
a.footer_link:hover{font-size:10px; color:#ffffff; text-decoration:underline;}


.button, .eingabe{ 
border:1px double #000000;
background:#ffffff url(img/main/eingabe_back.gif) repeat-x;
color: #000000;
font-size:10px;
}
.text{font-size:11px; color:#649CD3; letter-spacing: 2px; }

-->

</style>
<body>
<br><br><hr size=1><br><br><center>
 <form name=\"formular\" action=\"\" method=\"post\">
  <input name=\"username\" type=\"text\" value=\"\" />
  <input name=\"password\" type=\"password\" value=\"\" />
  <input name=\"submit\" type=\"submit\" value=\"{$lang['Login']}\" /><br />
  <label><input name=\"rememberme\" type=\"checkbox\">{$lang['Remember_me']}</label>
</form>
<a href=\"reg.php\">{$lang['Register']}</a>
</center><br><br><hr size=1>
</body>
</html>";

}
//  Timer, para comprobar la velocidad del script
if ( isset($userrow['authlevel']) && $userrow['authlevel']== 3 ) {
	$tiempo = microtime();
	$tiempo = explode(" ",$tiempo);
	$tiempo = $tiempo[1] + $tiempo[0];
	$tiempoFin = $tiempo;
	$tiempoReal = ($tiempoFin - $tiempoInicio);
	echo $depurerwrote001.$tiempoReal.$depurerwrote002.$numqueries.$depurerwrote003;
}
// Created by Perberos. All rights reversed (C) 2006
?>
