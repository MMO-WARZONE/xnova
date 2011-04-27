<?php
    // -----------------------------------------------------------------------------------------------------------
    // Loteria creado por SainT
    // loteria.php
    // 
    // http://www.xnova.saint-rc.es
	// Formato de Hora por DnLx
	// Comentado por saint
    // -----------------------------------------------------------------------------------------------------------

	define('INSIDE'  , true); //Definimos inside como verdadero
	define('INSTALL' , false); //Definimos install como falso. 

	$ugamela_root_path = './'; //Definimos la variable $ugamela_root_path como un la ruta principal
	include($ugamela_root_path . 'extension.inc'); //incluimos el archivo extension.inc
	include($ugamela_root_path . 'common.' . $phpEx); //incluimos el archivo common ($phpEx es la extension dada en extenxsion.inc)
	
	//comprobación ESTADO modulo
	$query = doquery("SELECT estado FROM {{table}} where modulo='Loteria'", 'modulos', true); //Sacamos el estado.
	if($query[0] == "0") { message("Modulo Inactivo.","Modulo Inactivo"); }
	//Fin comprobación
	
	$Consulta = doquery("SELECT * FROM {{table}} WHERE config_name = 'configloteria'", 'config', true); //Sacamos el config.
	$Cloteria = explode("|" ,$Consulta[1]); //metemos en un array los datos separados por |
	
    $Tiempo = time(); //Definimos el tiempo
    $loteria = gettemplate('loteria_off'); //cargamos el templante off
    if($Tiempo < $game_config['Loteria']) {  //Si la loteria no es aun.
    $Falta1 =  ($game_config['Loteria']-$Tiempo); //ponemos cuanto tiempo falta
	
	//Funcion para ver cuanto tiempo falta.
   function segundos_tiempo($segundos){
      $minutos=$segundos/60; 
      $horas=floor($minutos/60);
      $minutos2=$minutos%60;
      $segundos_2=$segundos%60%60%60;
      if($minutos2<10)$minutos2='0'.$minutos2;
      if($segundos_2<10)$segundos_2='0'.$segundos_2;
      
      if($segundos<60){ /* segundos */
      $resultado= round($segundos).' Segundos';
      }elseif($segundos>60 && $segundos<3600){/* minutos */
      $resultado= $minutos2.' Minutos y '.$segundos_2;
      }else{/* horas */
      $resultado= $horas.' Horas, '.$minutos2.' Minutos y '.$segundos_2.' Segundos';
      }
      return $resultado;
      }
      $segundos=date('h')*60*60+(date('i')*60)+date('s');
      //echo 'Segundos: '.$tiempolote.' Resultado: '.segundos_tiempo($Falta1); 
		//parseamos con loteria off
		$parse['usuarios'] = "Aun faltan [".segundos_tiempo($Falta1)."] para la proxima Loteria"; 
       
       $lote = parsetemplate( $loteria, $parse);
       display ($lote, "Loteria", false, '', true);
       
    } else { //Si esta ON

    $resto = $Tiempo - $game_config['Actualizacion'];      //calculamos cuanto fue la anterior loto
	
    $loteria = gettemplate('loteria_body'); //cargamos el tpl
	
		$tiempolote = $Cloteria[0];  // Tiempo que ahi entre loteria y loteria
		$maxtickets = $Cloteria[1]; // maximos de tickets a vender
		$canxticketm = $Cloteria[2]; // premio de metal
		$canxticketc = $Cloteria[3]; //  premio de cristal
		$canxticketd = $Cloteria[4]; // premio de deuterio
		$ticketsporpersona = $Cloteria[5];
	
	
    $CantidadTickets  = doquery("SELECT sum(tickets) as total_tickets FROM {{table}} ",'loteria',true); //Vemos la cantidad de tickets vendidos
    $parse['Cantidad'] = $CantidadTickets['total_tickets']; //Sacamos los tickets totales
    $parse['Cantidadf'] = $maxtickets-$CantidadTickets['total_tickets'];  //vemos cuantos tickets kedan
    $parse['Cantidadt'] = $maxtickets; //tickets maximos
    $parse['Cantidadm'] = $canxticketm; //lo que dan al ganar en metal
    $parse['Cantidadc'] = $canxticketc; //lo que dan al ganar en cristal
    $parse['Cantidadd'] = $canxticketd; //lo que dan al ganar en deuterio
	
    $Consulta  = doquery("SELECT * FROM {{table}} WHERE `user` = '".$user['username']."' ",'loteria',true); //Consulta para sacar tus tickets
    $TusTickets=$Consulta['tickets'];  //lo guardamos en una variable
	
    if($TusTickets != NULL) { //Si tienes tickets
    $parse['tustickets'] = $TusTickets; //lo parseamos
    }  else { //y si no
    $parse['tustickets'] = 0; //Tus tickets son 0.
    }
	
	if($_GET['cp'] == "compra") { //Si existe la var cp en la url, con respuesta compra
    $metal = $_POST['Tickets']*$canxticketm; //Miramos cuanto le costara de metal
    $cristal = $_POST['Tickets']*$canxticketc; //Miramos cuanto le costara de cristal
    $Deuterio = $_POST['Tickets']*$canxticketd; //Miramos cuanto le costara de deuterio
	
    $DatosPlaneta = doquery("SELECT * FROM {{table}} WHERE `id` = '".$planetrow['id']."' ",'planets',true); //Sacamos el id de tu planeta  
    if ($DatosPlaneta['metal'] >= $metal && $DatosPlaneta['crystal'] >= $cristal && $DatosPlaneta['deuterium'] >= $Deuterio)  { //Si tienes los recursos necesarios
    if ($parse['Cantidadf'] < $_POST['Tickets']) { //Si no ahi tantos tickets como se desea comprar
	$parse['MensajeCompra'] = "<font color='#FF0000'>No quedan tantos tickets para comprar</font>";  //mensaje de error
	} else { //y si no
    $smetal = $DatosPlaneta['metal']-$metal; //Vemos cuanto metal te queda en el planeta
    $scristal = $DatosPlaneta['crystal']-$cristal; //Cuanto cristal
    $sdeuterio = $DatosPlaneta['deuterium']-$Deuterio; //Cuanto deuterio
    doquery("UPDATE {{table}} SET `metal`='".$smetal."', `crystal`='".$scristal."', `deuterium`='".$sdeuterio."' WHERE `id`='".$planetrow['id']."' limit 1", "planets"); //Actualizamos el planeta

	$Suma = $TusTickets+$_POST['Tickets']; //Sumamos la cantidad de tus tickets comprados y los que tenias
	
	 if($Suma > $ticketsporpersona){ //Si supera con la compra el maximo de tickets por persona
        message("Lo Sentimos, el maximo de tickets por persona es {$ticketsporpersona}","Loteria" ,'overview.'. $phpEx); //mensaje de error
	}
	
    if($TusTickets > 0) { //Si tus tickets es mayor que 0
       doquery("UPDATE {{table}} SET `tickets`='".$Suma."' WHERE `user`='{$user['username']}' limit 1", "loteria"); //Actualizamos
    } else { //y si no tenias
	doquery("INSERT INTO {{table}} SET `ID`='".$user['id']."', `user`='".$user['username']."', `tickets`='".$_POST['Tickets']."' ", "loteria"); //te ponemos los que comprastes
	}

   $parse['MensajeCompra'] = "<font color='#00FF00'>Acabas de Comprar ".$_POST['Tickets']." Tickets</font>"; //parseamos el mensaje de compra
	header("Location: ./loteria.php"); //reidirigimos a loteria.php
   }
                 
    if(($_POST['Tickets']+$CantidadTickets['total_tickets']) == $maxtickets) { //Si la cantidad de tickets es igual que la que se compro.
    $elganador = doquery("SELECT * FROM {{table}} order by rand()", "loteria",true); //Sacamos el ganador.
    $ganad = $elganador['ID'];//guardamos su id.
    $Datoswiner = doquery("SELECT * FROM {{table}} WHERE `id` = '".$ganad."' limit 1",'users',true); //Sacamos los datos del ganador.
    $ganadp = $Datoswiner['id_planet']; //guardamos el id del planeta del ganador.
	$DatosPlaneta = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '".$ganad."' limit 1",'planets',true); //Sacamos los datos del planeta del ganador.
    $emetal = $DatosPlaneta['metal']+($canxticketm*$maxtickets); //cantidad de metal a darle (actual, sumada con los de su planeta)
    $ecristal = $DatosPlaneta['crystal']+($canxticketc*$maxtickets); //cantidad de cristal a darle (actual, sumada con los de su planeta)
    $edeuterio = $DatosPlaneta['deuterium']+($canxticketd*$maxtickets); //cantidad de deuterio a darle (actual, sumada con los de su planeta)
	doquery("UPDATE {{table}} SET `metal`='".$emetal."', `crystal`='".$ecristal."', `deuterium`='".$edeuterio."' WHERE `id`='".$ganadp."' limit 1", "planets"); //Actualizamos los puntos
          
  $Time    = time();  //Fijamos la hora que es
  $From    = "<font color=\"". $kolor ."\">Loterias</font>"; //guardamos el remitente del mensaje
  $Subject = "<font color=\"". $kolor ."\">Resultado loteria</font>";  //guardamos el titulo del mensaje
   
   $consulta = doquery("SELECT * FROM {{table}}", "loteria"); //Consulta de loteria
    while ($uzer = mysql_fetch_array($consulta)) {   //While para enviar mensaje usuario por usuario
             if($ganad == $uzer['ID']) { //Si el id del usuario es el que gano, enviamos mensaje de ganador
			 $Message = "<font color='#00ff00'>Felicidades!¡!¡<br>Tu tenias el Ticket Ganador de la loteria, <br>Esperamos verte pronto por alli.</font>"; 
			 }  else {   //y si no mensaje de perdedor
			 $Message = "<font color='#FF0000'>OHHHH!¡!¡<br>Tu No tenias el Ticket Ganador de la loteria, <br>Esperamos verte pronto por alli.</font>"; 
			 }
             SendSimpleMessage ( $uzer['ID'], $uzer['ID'], $Time, 1, $From, $Subject, $Message); //Enviamos el mensaje
    }    //Fin while
        
	doquery ("DELETE FROM {{table}} ",'loteria'); //borramos todo de loteria.
    
	$sigueintelore = $tiempolote + time(); //Fijamos la proxima loteria 
    
	doquery("UPDATE {{table}} SET `config_value`='".$sigueintelore."' WHERE `config_name`='Loteria' limit 1", "config"); //lo ponemos en db
     
	} //Fin cantidad de tickets igual
    } else { //Si no tienes suficientes recursos mensaje de error
	$parse['MensajeCompra'] = "<font color='#FF0000'>No Tienes Suficientes Recursos</font>"; 
	} 
    } //fin si estamos comprando
    $pase['usuarios'] = "Otros Jugadores"; //parseamos 
	
    if($CantidadTickets == $maxtickets) {  
	$parse['color'] = "red";
	} else {
	$parse['color'] = "green";
	}
	$usuarios   = doquery("SELECT * FROM {{table}} order by tickets", "loteria");
    while ($listad = mysql_fetch_array($usuarios)) {   
     $parse['usuarios'] .= "".$listad['user']." con ".$listad['tickets']." tickets<br/>";
     }

		//parseamos
       $lote = parsetemplate( $loteria, $parse);
       display ($lote, "Loteria", false, '', true);
    }

    ?>
