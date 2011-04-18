<?php

/**
* messages.php
*
* @version 1.3
* @copyright 2008 by Chlorel for XNova
*/

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
global $messfields;
   includeLang('messages');

if ($IsUserChecked == false) {
   includeLang('fehler');
   message($lang['check01'], $lang['check02']);
}

if ($user['urlaubs_modus'] == 1){
   includeLang('fehler');
   message($lang['Urlaub01'], $lang['Urlaub02']);
}


   $OwnerID       = $_GET['id'];
   $MessCategory  = $_GET['messcat'];
   $MessPageMode  = $_GET["mode"];
   $DeleteWhat    = $_POST['deletemessages'];
   if (isset ($DeleteWhat)) {
      $MessPageMode = "delete";
   }

   $UsrMess       = doquery("SELECT 'leido' FROM {{table}} WHERE `message_owner` = '".$user['id']."' ORDER BY `message_time` DESC;", 'messages');

   $MessageType   = array ( 0, 1, 2, 3, 4, 5, 15, 99, 100 );
   $TitleColor    = array ( 0 => '#FFFF00', 1 => '#FF6699', 2 => '#FF3300', 3 => '#FF9900', 4 => '#773399', 5 => '#009933', 15 => '#030070', 99 => '#007070', 100 => '#ABABAB'  );
   $BackGndColor  = array ( 0 => '#663366', 1 => '#336666', 2 => '#000099', 3 => '#666666', 4 => '#999999', 5 => '#999999', 15 => '#999999', 99 => '#999999', 100 => '#999999'  );



    $page .= "<center><table width=\"569\">";
    $page .= "<tr><td class=\"c\" colspan=\"9\">". $lang['title'] ."</td></tr>";
         for ($MessType = 0; $MessType < 100; $MessType++) {
                if ( in_array($MessType, $MessageType) ) {
                   $page .= "<th width=\"100\"><a href=\"messages.php?mode=show&amp;messcat=". $MessType ."&amp;lista_id=1 \"><font color=\"". $TitleColor[$MessType] ."\">". $lang['type'][$MessType] ."</a></th>";}}
                   $page .= "</tr><tr>";
          for ($MessType = 0; $MessType < 100; $MessType++) {
                if ( in_array($MessType, $MessageType) ) {

    $pruebas      = doquery("SELECT * FROM {{table}} WHERE `message_owner` = '".$user['id']."' AND `message_type`='".$MessType."' AND `leido`='1' ORDER BY `message_time` DESC ;", 'messages');
    $pruebas2      = doquery("SELECT * FROM {{table}} WHERE `message_owner` = '".$user['id']."' AND `message_type`='".$MessType."' ORDER BY `message_time` DESC ;", 'messages');

                       $page .= "<th width=\"100\" >
          <font color=\"". $TitleColor[$MessType] ."\">". mysql_num_rows($pruebas) ."</font>/<font color=\"". $TitleColor[$MessType] ."\">". mysql_num_rows($pruebas2) ."</font></th>";
                }
             }
             $page .= "</tr></table>";
             $page .= "</center>";
   switch ($MessPageMode) {
      case 'write':
         // -------------------------------------------------------------------------------------------------------
         // Envoi d'un messages
         if ( !is_numeric( $OwnerID ) ) {
            message ($lang['mess_no_ownerid'], $lang['mess_error']);
         }

         $OwnerRecord = doquery("SELECT * FROM {{table}} WHERE `id` = '".$OwnerID."';", 'users', true);

         if (!$OwnerRecord) {
            message ($lang['mess_no_owner']  , $lang['mess_error']);
         }

         $OwnerHome   = doquery("SELECT * FROM {{table}} WHERE `id_planet` = '". $OwnerRecord["id_planet"] ."';", 'galaxy', true);
         if (!$OwnerHome) {
            message ($lang['mess_no_ownerpl'], $lang['mess_error']);
         }

         if ($_POST) {
            $error = 0;
            if (!$_POST["subject"]) {
               $error++;
               $page .= "<center><br><font color=#FF0000>".$lang['mess_no_subject']."<br></font></center>";
            }
            if (!$_POST["text"]) {
               $error++;
               $page .= "<center><br><font color=#FF0000>".$lang['mess_no_text']."<br></font></center>";
            }
            if ($error == 0) {
               $page .= "<center><font color=#00FF00>".$lang['mess_sended']."<br></font></center>";

               $_POST['text'] = str_replace("'", '&#39;', $_POST['text']);
//               $_POST['text'] = str_replace('\r\n', '<br />', $_POST['text']);

               $Owner   = $OwnerID;
               $Sender  = $user['id'];
               $From    = $user['username'] ." [".$user['galaxy'].":".$user['system'].":".$user['planet']."]";
               $Subject = $_POST['subject'];
               $Message = trim ( nl2br ( strip_tags ( $_POST['text'], '<br>' ) ) );
               SendSimpleMessage ( $Owner, $Sender, '', 1, $From, $Subject, $Message);
               $subject = "";
               $text    = "";
            }
         }
         $parse['Send_message'] = $lang['mess_pagetitle'];
         $parse['Recipient']    = $lang['mess_recipient'];
         $parse['Subject']      = $lang['mess_subject'];
         $parse['Message']      = $lang['mess_message'];
         $parse['characters']   = $lang['mess_characters'];
         $parse['Envoyer']      = $lang['mess_envoyer'];

         $parse['id']           = $OwnerID;
         $parse['to']           = $OwnerRecord['username'] ." [".$OwnerHome['galaxy'].":".$OwnerHome['system'].":".$OwnerHome['planet']."]";
         $parse['subject']      = (!isset($subject)) ? $lang['mess_no_subject'] : $subject ;
         $parse['text']         = $text;

         $page                 .= parsetemplate(gettemplate('messages_pm_form'), $parse);
         break;

      case 'delete':
         // -------------------------------------------------------------------------------------------------------
         // Suppression des messages selectionnés
         $DeleteWhat = $_POST['deletemessages'];
         if       ($DeleteWhat == 'deleteall') {
            doquery("DELETE FROM {{table}} WHERE `message_owner` = '". $user['id'] ."';", 'messages');
            doquery("UPDATE {{table}} SET `new_message` ='0' WHERE `id` = '".$user['id']."'","users");
			
			$QryUpdateUser  = "UPDATE {{table}} SET ";
	        $QryUpdateUser .= "`".$messfields[0]."` = '0', ";
			$QryUpdateUser .= "`".$messfields[1]."` = '0', ";
			$QryUpdateUser .= "`".$messfields[2]."` = '0', ";
			$QryUpdateUser .= "`".$messfields[3]."` = '0', ";
			$QryUpdateUser .= "`".$messfields[4]."` = '0', ";
			$QryUpdateUser .= "`".$messfields[5]."` = '0', ";
			$QryUpdateUser .= "`".$messfields[15]."` = '0', ";
			$QryUpdateUser .= "`".$messfields[99]."` = '0', ";
	        $QryUpdateUser .= "`".$messfields[100]."` = '0' ";
	        $QryUpdateUser .= "WHERE ";
	        $QryUpdateUser .= "`id` = '". $user['id'] ."';";
	        doquery( $QryUpdateUser, 'users');
			   
         } elseif ($DeleteWhat == 'deletemarked') {
            foreach($_POST as $Message => $Answer) {
               if (preg_match("/delmes/i", $Message) && $Answer == 'on') {
                  $MessId   = str_replace("delmes", "", $Message);
                  $MessHere = doquery("SELECT * FROM {{table}} WHERE `message_id` = '". $MessId ."' AND `message_owner` = '". $user['id'] ."';", 'messages',true);
                  if ($MessHere) {
                     doquery("DELETE FROM {{table}} WHERE `message_id` = '".$MessId."';", 'messages');
					     $QryUpdateUser  = "UPDATE {{table}} SET ";
	                     $QryUpdateUser .= "`".$messfields[0]."` = '0', ";
			             $QryUpdateUser .= "`".$messfields[1]."` = '0', ";
			             $QryUpdateUser .= "`".$messfields[2]."` = '0', ";
			             $QryUpdateUser .= "`".$messfields[3]."` = '0', ";
			             $QryUpdateUser .= "`".$messfields[4]."` = '0', ";
			             $QryUpdateUser .= "`".$messfields[5]."` = '0', ";
			             $QryUpdateUser .= "`".$messfields[15]."` = '0', ";
			             $QryUpdateUser .= "`".$messfields[99]."` = '0', ";
	                     $QryUpdateUser .= "`".$messfields[100]."` = '0' ";
	                     $QryUpdateUser .= "WHERE ";
	                     $QryUpdateUser .= "`id` = '". $user['id'] ."';";
	                    doquery( $QryUpdateUser, 'users');
                       if($MessHere["leido"]=="1"){
                       doquery("UPDATE {{table}} SET `new_message` =`new_message`-1 WHERE `id` = '".$user['id']."'","users");}
                  }
               }
            }
         } elseif ($DeleteWhat == 'deleteunmarked') {
            foreach($_POST as $Message => $Answer) {
               $CurMess    = preg_match("/showmes/i", $Message);
               $MessId     = str_replace("showmes", "", $Message);
               $Selected   = "delmes".$MessId;
               $IsSelected = $_POST[ $Selected ];
               if (preg_match("/showmes/i", $Message) && !isset($IsSelected)) {
                  $MessHere = doquery("SELECT * FROM {{table}} WHERE `message_id` = '". $MessId ."' AND `message_owner` = '". $user['id'] ."';", 'messages');
                  if ($MessHere) {
                     doquery("DELETE FROM {{table}} WHERE `message_id` = '".$MessId."';", 'messages');
					$QryUpdateUser  = "UPDATE {{table}} SET ";
	                $QryUpdateUser .= "`".$messfields[0]."` = '0', ";
			        $QryUpdateUser .= "`".$messfields[1]."` = '0', ";
			        $QryUpdateUser .= "`".$messfields[2]."` = '0', ";
			        $QryUpdateUser .= "`".$messfields[3]."` = '0', ";
			        $QryUpdateUser .= "`".$messfields[4]."` = '0', ";
			        $QryUpdateUser .= "`".$messfields[5]."` = '0', ";
			        $QryUpdateUser .= "`".$messfields[15]."` = '0', ";
			        $QryUpdateUser .= "`".$messfields[99]."` = '0', ";
	                $QryUpdateUser .= "`".$messfields[100]."` = '0' ";
	                $QryUpdateUser .= "WHERE ";
	                $QryUpdateUser .= "`id` = '". $user['id'] ."';";
	                doquery( $QryUpdateUser, 'users');
	                
                    if($MessHere["leido"]=="1"){
                       doquery("UPDATE {{table}} SET `new_message` =`new_message`-1 WHERE `id` = '".$user['id']."'","users");}
                  }
               }
            }
         }
         $MessCategory = $_POST['category'];
case 'show':
        // -------------------------------------------------------------------------------------------------------
$sql=doquery("SELECT * FROM {{table}} WHERE `message_owner` = '".$user['id']."' AND  `message_type`='".$MessCategory."';", 'messages');




$cant=mysql_num_rows($sql);
$final=$cant/10;

$array_cant=explode(".",$final);

$array_cant[0];
$array_cant[1];
if(!$array_cant[1]){
$fnl=$array_cant[0];
}else{
$fnl=$array_cant[0]+1;
}
if($_GET['lista_id']<>1){
$lista_pagina.="<a href='messages.php?mode=".$MessPageMode."&lista_id=1&messcat=".$MessCategory."'>&lt;&lt;</a> ";
}
if($_GET['lista_id']>1){
$lista_pagina.="<a href='messages.php?mode=".$MessPageMode."&lista_id=".($_GET['lista_id']-1)."&messcat=".$MessCategory."'>&lt;</a> ";
for ($i=1;$i<=$fnl;$i++){
if($i==$_GET['lista_id']){
$lista_pagina.="<strong><a style='color:#FF0000' href='messages.php?mode=".$MessPageMode."&&lista_id=".$i."&messcat=".$MessCategory."'>".$i."</a></strong> ";
}else{
$lista_pagina.="<a href='messages.php?mode=".$MessPageMode."&lista_id=".$i."&messcat=".$MessCategory."'>".$i."</a> ";
}
}
}
if($_GET['lista_id']<floor($fnl)){
$lista_pagina.="<a href='messages.php?mode=".$MessPageMode."&lista_id=".($_GET['lista_id']+1)."&messcat=".$MessCategory."'>&gt;</a> ";}
if($_GET['lista_id']<>floor($fnl)){
$lista_pagina.="<a href='messages.php?mode=".$MessPageMode."&lista_id=".floor($fnl)."&messcat=".$MessCategory."'>&gt;&gt;</a> ";}

if(isset($_GET['lista_id'])){
if ($_GET['lista_id']==1){
$com=0;
$limit="LIMIT ".$com.", 10";
}else{
if($_GET['lista_id']!=0){
$com=10*($_GET['lista_id']-'1');
$limit="LIMIT ".$com.", 10";
}
}
}else{
}


         // Affichage de la page des messages
         $page  .= "<script language=\"JavaScript\">\n";
         $page .= "function f(target_url, win_name) {\n";
         $page .= "var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');\n";
         $page .= "new_win.focus();\n";
         $page .= "}\n";
         $page .= "</script>\n";
         $page .= "<center>";
         $page .= "<table>";
         $page .= "<tr>";
         $page .= "<td></td>";
         $page .= "<td>\n";
         $page .= "<table width=\"519\">";
         $page .= "<form action=\"messages.php\" method=\"post\"><table>";
         $page .= "<tr>";
         $page .= "<td></td>";
         $page .= "<td>\n<input name=\"messages\" value=\"1\" type=\"hidden\">";
         $page .= "<table width=\"519\">";
         $page .= "<tr>";
         $page .= "<th colspan=\"9\">";
         $page .= "<select onchange=\"document.getElementById('deletemessages').options[this.selectedIndex].selected='true'\" id=\"deletemessages2\" name=\"deletemessages2\">";
         $page .= "<option value=\"deletemarked\">".$lang['mess_deletemarked']."</option>";
         $page .= "<option value=\"deleteunmarked\">".$lang['mess_deleteunmarked']."</option>";
         $page .= "<option value=\"deleteall\">".$lang['mess_deleteall']."</option>";
         $page .= "</select>";
         $page .= "<input value=\"".$lang['mess_its_ok']."\" type=\"submit\">";
         $page .= "</th>";
         $page .= "</tr><tr>";
         $page .= "<th style=\"color: rgb(242, 204, 74);\" colspan=\"9\">";
         $page .= "<input name=\"category\" value=\"".$MessCategory."\" type=\"hidden\">";
         $page .= "<input onchange=\"document.getElementById('fullreports').checked=this.checked\" id=\"fullreports2\" name=\"fullreports2\" type=\"checkbox\">".$lang['mess_partialreport']." ".$lista_pagina."</th>";
         $page .= "</tr><tr>";

         $page .= "<th>".$lang['mess_action']."</th>";
         $page .= "<th>".$lang['mess_date']."</th>";
         $page .= "<th>".$lang['mess_from']."</th>";
         $page .= "<th>".$lang['mess_subject']."</th>";
         $page .= "</tr>";


            $UsrMess  = doquery("SELECT * FROM {{table}} WHERE `message_owner` = '".$user['id']."' AND `message_type` = '".$MessCategory."' ORDER BY `message_time` DESC ".$limit, 'messages');

         while ($CurMess = mysql_fetch_array($UsrMess)) {
               if ($CurMess['message_type'] == $MessCategory) {
               if($CurMess['leido']==1){
             doquery("UPDATE {{table}} SET `new_message` =`new_message`-1 WHERE `id` = '".$user['id']."'","users");
               $color_style=" style='background-color:#FF0000'";
               }else{
               $color_style="";

               }

               $page .= "\n<tr ".$color_style.">";
               $page .= "<input name=\"showmes". $CurMess['message_id'] . "\" type=\"hidden\" value=\"1\">";
               $page .= "<th><input name=\"delmes". $CurMess['message_id'] ."\" type=\"checkbox\"></th>";

               $page .= "<th>". date("m-d H:i:s O", $CurMess['message_time']) ."</th>";
               $page .= "<th>". stripslashes( $CurMess['message_from'] ) ."</th>";
               $page .= "<th> <a href='messages.php?mode=".$MessPageMode."&&lista_id=".$_GET['lista_id']."&messcat=".$MessCategory."&ver=".$CurMess['message_id']."'>". stripslashes( $CurMess['message_subject'] ) ."</a> ";
                  if ($CurMess['message_type'] == 1) {
                     $page .= "<a href=\"messages.php?mode=write&amp;id=". $CurMess['message_sender'] ."&amp;subject=".$lang['mess_answer_prefix'] . htmlspecialchars( $CurMess['message_subject']) ."\">";
                     $page .= "<img src=\"". $dpath ."img/m.gif\" alt=\"".$lang['mess_answer']."\" border=\"0\"></a></th>";
                  } else {
                     $page .= "</th>";
                  }

                  $page .= "</tr>";
              $page .= "<tr></tr><tr><th></th>";
               $page .= "<tr>";
               $page .= "<td style=\"background-color: ".$BackGndColor[$CurMess['message_type']]."; background-image: none;\"; class=\"b\"> </td>";
               $page .= "<td style=\"background-color: ".$BackGndColor[$CurMess['message_type']]."; background-image: none;\"; colspan=\"4\" class=\"b\">". stripslashes( nl2br( $CurMess['message_text'] ) ) ."</td></tr>";
         $QryUpdatemen  = "UPDATE {{table}} SET ";
            $QryUpdatemen .= "`leido` = '0' ";
            $QryUpdatemen .= "WHERE ";
            $QryUpdatemen .= "`message_id` = '".$CurMess['message_id']."';";
            doquery ( $QryUpdatemen, 'messages' );
               }
            }

         echo $attoffi;
         $page .= "<tr>";
         $page .= "<th style=\"color: rgb(242, 204, 74);\" colspan=\"4\">";
         $page .= "<input onchange=\"document.getElementById('fullreports2').checked=this.checked\" id=\"fullreports\" name=\"fullreports\" type=\"checkbox\">".$lang['mess_partialreport']."</th>";
         $page .= "</tr><tr>";
         $page .= "<th colspan=\"4\">";
         $page .= "<select onchange=\"document.getElementById('deletemessages2').options[this.selectedIndex].selected='true'\" id=\"deletemessages\" name=\"deletemessages\">";
         $page .= "<option value=\"deletemarked\">".$lang['mess_deletemarked']."</option>";
         $page .= "<option value=\"deleteunmarked\">".$lang['mess_deleteunmarked']."</option>";
         $page .= "<option value=\"deleteall\">".$lang['mess_deleteall']."</option>";
         $page .= "</select>";
         $page .= "<input value=\"".$lang['mess_its_ok']."\" type=\"submit\">";
         $page .= "</th>";
         $page .= "</tr><tr>";
         $page .= "<td colspan=\"4\"></td>";
         $page .= "</tr>";
         $page .= "</table>\n";
         $page .= "</td>";
         $page .= "</tr>";
         $page .= "</table>\n";
         $page .= "</form>";
         $page .= "</td>";
         $page .= "</table>\n";
         $page .= "</center>";
         break;



   }

   display($page, $lang['mess_pagetitle']);

// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Version originelle (Tom1991)
// 1.1 - Mise a plat, linearisation, suppression des doublons / triplons / 'n'gnions dans le code (Chlorel)
// 1.2 - Regroupage des 2 fichiers vers 1 seul plus simple a mettre en oeuvre et a gerer !
// 1.3 - Correcion Bug mensajes (jtsamper)
?>