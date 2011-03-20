<?php
    // -----------------------------------------------------------------------------------------------------------
    // Loteria creado por SainT
    // loteria.php
    // http://www.ogame.ciberpaxi.es
    // http://project.xnova.es/
    // -----------------------------------------------------------------------------------------------------------

    define('INSIDE'  , true);
    define('INSTALL' , false);

    $ugamela_root_path = './';
    include($ugamela_root_path . 'extension.inc');
    include($ugamela_root_path . 'common.' . $phpEx);

    $Tiempo = time();
    $loteria = gettemplate('loteria_off');
    if($Tiempo < $game_config['Loteria']) {
    $Falta =  $game_config['Loteria']-$Tiempo;
    $parse['usuarios'] = "It is [".$Falta."]Seconds until Lottery starts.";
       
       $lote = parsetemplate( $loteria, $parse);
       display ($lote, "Loteria", false, '', true);
       
    } else {

                $resto = $Tiempo - $game_config['Actualizacion'];
               
             
       $loteria = gettemplate('loteria_body');
    $tiempolote = 63600;
    $maxtickets = 100;
    $canxticketm = 100000;
    $canxticketc = 100000;
    $canxticketd = 100000;



    $totaltickets  = doquery ("SELECT sum(tickets) as total_tickets FROM {{table}} ",'loteria');
      $CantidadTickets = mysql_fetch_array($totaltickets);
    $parse['Cantidad'] = $CantidadTickets['total_tickets'];
    $parse['Cantidadf'] = $maxtickets-$CantidadTickets['total_tickets'];
    $parse['Cantidadt'] = $maxtickets;
    $parse['Cantidadm'] = $canxticketm;
    $parse['Cantidadc'] = $canxticketc;
    $parse['Cantidadd'] = $canxticketd;

    $TusTickets2  = doquery ("SELECT * FROM {{table}} WHERE `user` = '".$user['username']."' ",'loteria');
    $TusTicket3 = mysql_fetch_array($TusTickets2);
    $TusTickets=$TusTicket3['tickets'];
    if($TusTickets != NULL) {
    $parse['tustickets'] = $TusTickets;
    }
      else {
    $parse['tustickets'] = 0;
    }
    if($_GET['cp'] == "compra") {
    $metal = $_POST['Tickets']*$canxticketm;
    $cristal = $_POST['Tickets']*$canxticketc;
    $Deuterio = $_POST['Tickets']*$canxticketd;
    $complant = doquery("SELECT * FROM {{table}} WHERE `id` = '".$planetrow['id']."' ",'planets');
    $DatosPlaneta = mysql_fetch_array($complant);
    if ($DatosPlaneta['metal'] >= $metal && $DatosPlaneta['crystal'] >= $cristal && $DatosPlaneta['deuterium'] >= $Deuterio)
    {


    if ($parse['Cantidadf'] < $_POST['Tickets']) { $parse['MensajeCompra'] = "<font color='#FF0000'>There are no more tickets</font>"; } else {
    $smetal = $DatosPlaneta['metal']-$metal;
    $scristal = $DatosPlaneta['crystal']-$cristal;
    $sdeuterio = $DatosPlaneta['deuterium']-$Deuterio;
    doquery("UPDATE {{table}} SET `metal`='".$smetal."', `crystal`='".$scristal."', `deuterium`='".$sdeuterio."' WHERE `id`='".$planetrow['id']."' limit 1", "planets");

    if($TusTickets > 0) {
    $Suma = $TusTickets+$_POST['Tickets'];
    doquery("UPDATE {{table}} SET `tickets`='".$Suma."' WHERE `user`='{$user['username']}' limit 1", "loteria");
    } else { doquery("INSERT INTO {{table}} SET `ID`='".$user['id']."', `user`='".$user['username']."', `tickets`='".$_POST['Tickets']."' ", "loteria"); }

    $parse['MensajeCompra'] = "<font color='#00FF00'>Complete Purchase ".$_POST['Tickets']." Tickets</font>";
    ?> <META HTTP-EQUIV='Refresh' CONTENT="0; URL='overview.php'> <?php
    }
                 

    if(($_POST['Tickets']+$CantidadTickets['total_tickets']) == $maxtickets) {


                 $ganador = doquery("SELECT * FROM {{table}} order by rand()", "loteria");
                $elganador = mysql_fetch_array($ganador);
                $ganad = $elganador['ID'];
                
                $userio = doquery("SELECT * FROM {{table}} WHERE `id` = '".$ganad."' limit 1",'users');
       $Datoswiner = mysql_fetch_array($userio);
          $ganadp = $Datoswiner['id_planet'];
                  $complant = doquery("SELECT * FROM {{table}} WHERE `id_owner` = '".$ganad."' limit 1",'planets');
       $DatosPlaneta = mysql_fetch_array($complant);
       
       $emetal = $DatosPlaneta['metal']+($canxticketm*$maxtickets);
       $ecristal = $DatosPlaneta['crystal']+($canxticketc*$maxtickets);
       $edeuterio = $DatosPlaneta['deuterium']+($canxticketd*$maxtickets);
       doquery("UPDATE {{table}} SET `metal`='".$emetal."', `crystal`='".$ecristal."', `deuterium`='".$edeuterio."' WHERE `id`='".$ganadp."' limit 1", "planets");
             
            $dando = doquery("SELECT * FROM {{table}}", "loteria");
                 $Time    = time();             
                 $From    = "<font color=\"". $kolor ."\">Lottery</font>";             
                 $Subject = "<font color=\"". $kolor ."\">Lotter Results</font>";   
                 $summery=0;   
                 
               while ($uzer = mysql_fetch_array($dando)) {         
             if($ganad == $uzer['ID']) { $Message = "<font color='#00ff00'>Congratulations!¡!¡<br>You bought the winning ticket in the lottery, <br>You are most welcome to try your luck again.</font>"; }
             else { $Message = "<font color='#FF0000'>Too Bad!¡!¡<br>Your ticket wasnt the winning one. <br>You are most welcome to try again .</font>"; }
                  SendSimpleMessage ( $uzer['ID'], $uzer['ID'], $Time, 1, $From, $Subject, $Message);
               
                 }   
              doquery ("DELETE FROM {{table}} ",'loteria');
              $sigueintelore = $tiempolote + time();
              doquery("UPDATE {{table}} SET `config_value`='".$sigueintelore."' WHERE `config_name`='Loteria' limit 1", "config");
              }
    } else { $parse['MensajeCompra'] = "<font color='#FF0000'>Not enough resources</font>"; }
    }
    $pase['usuarios'] = "Otros Jugadores";
    if($CantidadTickets == $maxtickets) { $parse['color'] = "red"; } else { $parse['color'] = "green"; }
           $usuarios   = doquery("SELECT * FROM {{table}} order by tickets", "loteria");
               while ($listad = mysql_fetch_array($usuarios)) {   
             $parse['usuarios'] .= "".$listad['user']." con ".$listad['tickets']." tickets<br/>";
           
             }


       $lote = parsetemplate( $loteria, $parse);
       display ($lote, "Loteria", false, '', true);
    }
    // -----------------------------------------------------------------------------------------------------------
    // Loteria creado por SainT
    // http://www.ogame.ciberpaxi.es
    // -----------------------------------------------------------------------------------------------------------

    ?>