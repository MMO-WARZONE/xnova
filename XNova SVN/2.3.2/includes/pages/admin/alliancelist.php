<?php

/**
########################################################
Allianzlist.php by RedFighter

Funktion:
Auflistung aller vorhandenen Allianzen welche gleichzeitig via Adminpanel editierbar sind!

Fehler und Verbesserungsvorschläge bitte im entsprechende Thread posten!
Support auch nur über diesen Thread!

(c) Copyright by RedFighter
########################################################
**/

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

   if ($user['authlevel'] >= 2) {


$query = doquery("SELECT `id`, `ally_name`, `ally_tag`,  `ally_owner`, `ally_register_time`, `ally_description`, `ally_text`, `ally_members` FROM {{table}}", "alliance");

            $i = 0;
         while ($u = mysql_fetch_assoc($query)) {
         
         $users = doquery("SELECT `username` FROM {{table}} WHERE id='". $u['ally_owner'] ."'", "users");
            $a = mysql_fetch_array($users);
            $leader = $a['username'];

            $ally_register_time = gmdate ( "d/m/y G:i:s", $u['ally_register_time']);
         
         $parse['alliance'] .= "<tr>"
         . "<td class=b><center><b>" . $u['id'] . "</center></b></td>"
         . "<td class=b><center><b><a href=alliancelist.php?allyname=" . $u['id'] . ">" . $u['ally_name'] . "</a></center></b></td>"
         . "<td class=b><center><b><a href=alliancelist.php?allyname=" . $u['id'] . ">" . $u['ally_tag'] . "</a></center></b></td>"
         . "<td class=b><center><b><a href=alliancelist.php?leader=" . $u['id'] . "><b>" . $leader . "</center></b></a></td>"
         . "<td class=b><center><b>" . $ally_register_time . "</center></b></td>"
         . "<td class=b><center><b><a href=alliancelist.php?desc=" . $u['id'] . ">Ver</a>/<a href=alliancelist.php?edit=" . $u['id'] . ">Editar</a></center></b></td>"
         . "<td class=b><center><b><a href=alliancelist.php?mitglieder=". $u['id'] .">" . $u['ally_members'] . "</a></center></b></td>"
         . "<td class=b><center><b><a href=alliancelist.php?mail=" . $u['id'] . "><img src=../images/r5.png></a></center></b></td>"
         . "<td class=b><center><b><a href=alliancelist.php?del=" . $u['id'] . ">X</a></center></b></td>"
         . "</tr>";
         $i++;
         }
      if ($i == "1")
         $parse['allianz'] .= "<tr><th class=b colspan=9>Hay una alianza fundada</th></tr>";
      else
         $parse['allianz'] .= "<tr><th class=b colspan=9>Hay {$i} alianzas fundadas</th></tr>";

        if(isset($_GET['desc'])) {
     
      $ally_id = intval($_GET['desc']);
      $info = doquery("SELECT `ally_description` FROM {{table}} WHERE id='". $ally_id ."'", "alliance");
        $ally_text = mysql_fetch_assoc($info);
     
      $parse['desc'] .= "<tr>"
          . "<td class=c colspan=9><font color=lime>Texto externo<font></td></tr>"
          . "<tr>"
         . "<td class=b colspan=9><center><b>" . $ally_text['ally_description'] . "</center></b></td>"
         . "</tr>";
      }
     
      if(isset($_GET['edit'])) {
           
      $ally_id = intval($_GET['edit']);
      $info = doquery("SELECT `ally_description` FROM {{table}} WHERE id='". $ally_id ."'", "alliance");
        $ally_text = mysql_fetch_assoc($info);
         
            $parse['desc'] .= "<tr>"
          . "<td class=c colspan=9><font color=lime>Texto externo<font></td></tr>"
          . "<tr>"
          . "<form action=alliancelist.php?edit=" . $ally_id  . " method=POST>"
         . "<td class=b colspan=9><center><b><textarea name=desc cols=50 rows=10 >" . $ally_text['ally_description'] . "</textarea></center></b></td>"
         . "</tr>"         
         . "<tr>"
         . "<td class=b colspan=9><center><b><input type=submit value=Guardar></center></b></td>"
          . "</form></tr>";
     
      if(isset($_POST['desc'])) {
      $query = doquery("UPDATE {{table}} SET `ally_description` = '". $_POST['desc'] ."' WHERE `id` = '" . $_GET['edit'] . "'",'alliance');
      AdminMessage ('<meta http-equiv="refresh" content="2; url=alliancelist.php">La pagina ha sido actualizada', 'Pagina externa');
}
}
     

      ## Ally name und tag##

      if(isset($_GET['allyname'])) {
      $ally_id = $_GET['allyname'];
      $query = doquery("SELECT `ally_image`, `ally_web`, `ally_name`, `ally_tag` FROM {{table}} WHERE id='". $ally_id ."'", "alliance");
        $u = mysql_fetch_assoc($query);
     
         $parse['name'] .= "<tr>"
          . "<td colspan=7 class=c><font color=lime>Datos generales</font></td></tr>"
          . "<form action=alliancelist.php?allyname=" . $ally_id  . " method=POST>"
          . "<tr>"
         . "<th colspan=4><center><b>Nombre</center></b></th>   <th colspan=3><b><input type=text size=50 name=name value=".$u['ally_name']."></b></th>"
         . "</tr>"
          . "<tr>"
         . "<th colspan=4><center><b>Etiqueta</center></b></th>   <th colspan=3><b><input type=text size=50 name=tag value=".$u['ally_tag']."></b></th>"
         . "</tr>"
          . "<tr>"
         . "<th colspan=4><center><b>Logo</center></b></th>   <th colspan=3><center><b><input type=text size=50 name=image value=".$u['ally_image']."></center></b></th>  <th colspan=1><center><b><a href=". $u['ally_image'] .">Ver</a></center></b></th>"
         . "</tr>"
          . "<tr>"
         . "<th colspan=4><center><b>Pagina web</center></b></th>   <th colspan=3><center><b><input type=text size=50 name=web value=".$u['ally_web']."></center></b></th>  <th colspan=1><center><b><a href=". $u['ally_web'] ." target=>Ver</a></center></b></th>"
         . "</tr>"
         . "<tr>"
         . "<th colspan=8><center><b><input type=submit value=Cambiar></center></b></th>"
          . "</form></tr>";

      if(isset($_POST['name'])) {
      $query = doquery("UPDATE {{table}} SET `ally_name` = '". $_POST['name'] ."', `ally_tag` = '". $_POST['tag'] ."', `ally_image` = '". $_POST['image'] ."', `ally_web` = '". $_POST['web'] ."' WHERE `id` = '" . $_GET['allyname'] . "'",'alliance');
      AdminMessage ('<meta http-equiv="refresh" content="2; url=alliancelist.php">La alianza ha sido actualizada', 'Editar alianza');
      }
         
      }

      if(isset($_GET['del'])) {
      $ally_id = $_GET['del'];
               
         $parse['name'] .= "<tr>"
          . "<td class=c colspan=9><font color=lime>Borrar alianza</font></th></tr>"
          . "<form action=alliancelist.php?del=" . $ally_id  . " method=POST>"
          . "<tr>"
         . "<th colspan=9><center><b>Estas seguro de que quieres eliminar esta alianza?<br>Una vez borrada, sera irrevocable! </center></b></th>"
         . "</tr>"   
         . "<td class=b colspan=9><center><b><input type=submit value=Borrar name=del></center></b></td>"
          . "</form></tr>";
     
      if(isset($_POST['del'])) {
      $query = doquery("DELETE FROM {{table}} WHERE id = '" . $_GET['del'] . "'",'alliance');
      AdminMessage ('<meta http-equiv="refresh" content="2; url=alliancelist.php">La alianza ha sido borrada', 'Borrar alianza');
        }
      }
   
/**
########################################################
Allianzlist.php by RedFighter

Version 2!

Funktion:
Man kann absofort eine Liste der Mitglieder der Allianz sehen!
########################################################
**/
     if(isset($_GET['mitglieder'])) {
    $ally_id = $_GET['mitglieder'];

     $users = doquery("SELECT `id`, `username`, `email` FROM {{table}} WHERE ally_id='". $ally_id ."'", "users");

    $parse['member'] .= "<tr><td class=c colspan=9><font color=lime>Lista de miembros</font></td></tr><tr>"
         . "<th colspan=1><center><b>ID</center></b></td>"
         . "<th colspan=3><center><b>Nombre</center></b></td>"
         . "<th colspan=3><center><b>Email</center></b></td>"
         . "<th colspan=2><center><b>Borrar</center></b></td>"
         . "</tr>";
   
           $i = 0;
         while ($u = mysql_fetch_assoc($users)) {     
         $query = doquery("SELECT `ally_owner` FROM {{table}}", "alliance");
         $a = mysql_fetch_assoc($query);
         
         $parse['member_row'] .= "<tr>"
         . "<td class=b colspan=1><center><b>" . $u['id'] . "</center></b></td>"
         . "<td class=b  colspan=3><center><b><a href=../messages.php?mode=write&id=" . $u['id'] . ">". $u['username'] ."</a></center></b></td>"
         . "<td class=b  colspan=3><center><b>". $u['email'] ."</center></b></td>"
         . "<td class=b  colspan=2><center><b><a href=alliancelist.php?ent=". $u['id'] ."> X </a></center></b></td>"
         . "</tr>";
         $i++;
         }
    }

    if(isset($_GET['ent'])) {
    $user_id = $_GET['ent'];
   
            $parse['name'] .= "<tr>"
          . "<th colspan=9>Expulsar miembro</th></tr>"
          . "<form action=alliancelist.php?ent=" . $user_id  . " method=POST>"
          . "<tr>"
         . "<th colspan=9><center><b>Despues de la confirmacion del boton, el jugador es expulsado de esta alianza.<br>Esta seguro de querer expulsarlo?</center></b></th>"
         . "</tr>"   
         . "<td class=b colspan=9><center><b><input type=submit value=Expulsar name=ent></center></b></td>"
          . "</form></tr>";
     
      if(isset($_POST['ent'])) {
      $user_id = $_GET['ent'];
        doquery("UPDATE {{table}} SET `ally_id`=0, `ally_name` = '' WHERE `id`='".$user_id."'", "users");
      AdminMessage ('<meta http-equiv="refresh" content="2; url=alliancelist.php">El jugador ha sido expulsado de la alianza', 'Expulsar miembro');
        }
   
    }
   
    /**
########################################################
Allianzlist.php by RedFighter

Version 3!

Funktion:
Rundmails können vom Admin geschrieben werden
Leader kann vom Admin geändert werden
########################################################
**/
        if(isset($_GET['mail'])) {
            $ally_id = $_GET['mail'];
     
                  $parse['mail'] .= "<tr>"
          . "<td class=c colspan=9><font color=lime>Enviar correo circular a la alianza</font></td></tr>"
          . "<tr>"
          . "<form action=alliancelist.php?mail=" . $ally_id  . " method=POST>"
         . "<th colspan=3>Asunto:</th><td class=b colspan=6><center><b><input type=text name=subject size=50</center></b></td>"
         . "</tr><tr>"     
         . "<td class=b colspan=9><center><b><textarea name=text cols=50 rows=10 ></textarea></center></b></td>"
         . "</tr>"         
         . "<tr>"
         . "<td class=b colspan=9><center><b><input type=submit value=Enviar></center></b></td>"
          . "</form></tr>";
     
        if(isset($_POST['text'])) {


      if ($user['authlevel'] == 3) //  administrator
      {             
       $kolor = 'yellow';             
       $ranga = 'Administrador';         
      }
     
     elseif ($user['authlevel'] == 2) // operador
     {             
      $kolor = 'skyblue';             
      $ranga = 'Opérador';         
     }   
   
     elseif ($user['authlevel'] == 1) // moderador
     {             
      $kolor = 'yellow';             
      $ranga = 'Modérador';   
      } 
      $ally_id = $_GET['mail'];
        $sq = doquery("SELECT id FROM {{table}} WHERE ally_id='". $ally_id ."'", "users");
                        while ($u = mysql_fetch_array($sq)) {
                                doquery("INSERT INTO {{table}} SET
                                `message_owner`='{$u['id']}',
                                `message_sender`='Administrator' ,
                                `message_time`='" . time() . "',
                                `message_type`='2',
                                `message_from`='<font color=\"". $kolor ."\">". $ranga ." ".$user['username']."</font>',
                                `message_subject`='<font color=\"". $kolor ."\">". $_POST['subject'] ."</font>',
                                `message_text`='<font color=\"". $kolor ."\"><b>". $_POST['text'] ."</b></font>'
                                ", "messages");
                        }                 AdminMessage ('<meta http-equiv="refresh" content="1; url=alliancelist.php">Rundmail wurde verschickt!', 'Versendet');
                  }     
                  }
                 
      if(isset($_GET['leader'])) {
      $ally_id = $_GET['leader'];

      $query = doquery("SELECT `ally_owner` FROM {{table}}", "alliance");
      $u = mysql_fetch_array($query);
      $users = doquery("SELECT `username` FROM {{table}} WHERE id='". $u['ally_owner'] ."'", "users");
        $a = mysql_fetch_array($users);
        $leader = $a['username'];
     
      $parse['leader'] .= "<tr>"
          . "<td colspan=9 class=c><font color=lime>Cambiar fundador</font></td></tr>"
          . "<form action=alliancelist.php?leader=" . $ally_id  . " method=POST>"
          . "<tr>"
         . "<th colspan=4><center><b>Fundador actual:</center></b></th>   <th colspan=5><center><b>$leader</center></b></th>"
         . "</tr>"
          . "<tr>"
         . "<th colspan=4><center><b><u>ID</u> del nuevo fundador</center></b></th>   <th colspan=5><center><b><input type=text size=8 name=leader></center></b></th>"
         . "</tr>"
           
         . "<tr>"
         . "<td class=b colspan=9><center><b><input type=submit value=Cambiar></center></b></td>"
          . "</form></tr>";
     
      if(isset($_POST['leader'])) {
      $sq = doquery("SELECT ally_id FROM {{table}} WHERE id='". $_POST['leader'] ."'", "users");
      $a = mysql_fetch_array($sq);

      if($a['ally_id'] == $_GET['leader']) {
        $query = doquery("UPDATE {{table}} SET `ally_owner` = '". $_POST['leader'] ."' WHERE `id` = '" . $_GET['leader'] . "'",'alliance');
      AdminMessage ('<meta http-equiv="refresh" content="5; url=alliancelist.php">El fundadorr de la Alianza ha sido cambiado!', 'Cambio de fundador');
      } else {
      AdminMessage ('<meta http-equiv="refresh" content="1; url=alliancelist.php">El usuario no es miembro de esta alianza!', 'Error');
        }
    }
    }
   

         display(parsetemplate(gettemplate('admin/alliance_body'), $parse), 'Allianceubersicht', false, '', true);

      } else {
      message( $lang['sys_noalloaw'], $lang['sys_noaccess'] );
   }
?>