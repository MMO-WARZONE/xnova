<?php
//version 1.4
class users{
    
    var     $user       = array();
    private $usercheck  = false;
    
    private function CheckCookies()
    {
        global $svn_root, $phpEx, $lang, $db,$displays;

        $this->usercheck=(isset($_COOKIE[$db->game_config['COOKIE_NAME']])) ? true : false;
        if($this->usercheck){
            include($svn_root . 'config.' . $phpEx);

            $TheCookie  = explode("/%/", encrypt($_COOKIE[$db->game_config['COOKIE_NAME']],true));

            $UserResult = $db->query("SELECT u.*, s.* FROM {{table}}users as u
                LEFT JOIN {{table}}statpoints as s ON u.id=s.id_owner AND s.stat_code='1' AND s.stat_type='1'
                WHERE u.username = '".mysql_escape_string($TheCookie[1]) . "' LIMIT 1;", '');

            if (mysql_num_rows($UserResult) != 1)
            {
                   $displays->message($lang['ccs_multiple_users'], false, 0 , false, false);
            }

            $this->user    = mysql_fetch_array($UserResult);
            if ($this->user["id"] != $TheCookie[0])
            {
                    $displays->message($lang['ccs_other_user'], false, 0 , false, false,false);
            }

            if (md5($this->user["password"] . "--" . $dbsettings["secretword"]) !== $TheCookie[2])
            {
                    $displays->message($lang['css_different_password'], false, 0 , false, false);
                    //($mes,$page = false,$time = 3,$topnav = false, $menu = true, $admin = false)
            }

            $QryUpdateUser  = "UPDATE {{table}} SET ";
            $QryUpdateUser .= "`onlinetime` = '". time() ."', ";
            $QryUpdateUser .= "`current_page` = '". addslashes($_SERVER['REQUEST_URI']) ."', ";
            $QryUpdateUser .= "`user_lastip` = '". $_SERVER['REMOTE_ADDR'] ."', ";
            $QryUpdateUser .= "`user_agent` = '". addslashes($_SERVER['HTTP_USER_AGENT']) ."' ";
            $QryUpdateUser .= "WHERE ";
            $QryUpdateUser .= "`id` = '". mysql_escape_string($TheCookie[0]) ."' LIMIT 1;";
            $db->query( $QryUpdateUser, 'users');
            unset($dbsettings);
        }
    }


    public function CheckUser()
    {
            global $svn_root,$db, $lang , $displays;
            $this->CheckCookies();
            if (isset($this->user) && !empty($this->user))
            {
                if (is_array($this->user)){
                   foreach($this->user as $a => $b){
                       if (is_numeric($a)){unset($this->user[$a]);}
                   }
                }
                if ($this->user['bana'] == 1){
                    $banned=$db->query("SELECT * FROM {{table}} WHERE who = '".$this->user['username']. "' LIMIT 1;",'banned',true);
                    $message_ban="<h2  style='color:red'>".$lang['css_account_banned_message']."</h2>";
                    $message_ban.="\n<br />\n";
                    $message_ban.="<strong style='color:red'>Fue baneado el :</strong> ".date("d-m-y H:i", $banned["time"]);
                    $message_ban.="\n<br>\n";
                    $message_ban.="<strong style='color:red'>El baneo expira el :</strong> ".date("d-m-y H:i", $banned["longer"]);
                    $message_ban.="\n<br>\n";
                    $message_ban.="<strong style='color:red'>�Activado el modo vacaciones? </strong>".(($this->user["urlaubs_modus"]==1)?"Si":"No");
                    $message_ban.="\n<br>\n";
                    $message_ban.="<strong style='color:red'>Baneado por : </strong>".($banned["author"]);
                    $message_ban.="\n<br>\n";
                    $message_ban.="<strong style='color:red'>Razon del baneo : </strong>\n<br>\n<textarea readonly>".($banned["theme"])."</textarea>";
                    unset($this->user,$banned);
                    $displays->message($message_ban,false,false,false,false);

                }
            }else{
                   header("location:".$svn_root);
                   exit;
            }

    }

    /**
     * Funcion SendSimpleMessage
     * $Owner = Origen
     * $Sender = Destino
     * $Time = tiempo
     * $Type = tipo
     * $From = Nombre Origen
     * $Subject = Asunto
     * $Message = Mensaje
     *
     */

    public function SendSimpleMessage($Owner , $Sender, $Time, $Type, $From, $Subject, $Message) {
        global $db,$lang;

        $Time       = (!$Time)   ? time()                : $Time    ;
        $Owner      = (!$Owner)  ? FALSE                 : $Owner   ;
        $Sender     = (!$Sender) ? "0"                   : $Sender  ;
        $From       = (!$From)   ? FALSE                 : $From    ;
        $Subject    = (!$Subject)? $lang['mg_no_subject']: $Subject ;
        $Message    = (!$Message)? FALSE                 : $Message ;
        if($Message==FALSE || $From==FALSE || $Owner==FALSE){
            return false;
        }else{

            $QryInsertMessage  = "INSERT INTO {{table}} SET
                    `message_owner` = '". $Owner ."',
                    `message_sender` = '". $Sender ."',
                    `message_time` = '" . $Time . "',
                    `message_type` = '". $Type ."',
                    `message_from` = '". $From ."',
                    `message_subject` = '".  $Subject  ."',
                    `message_text` = '". $Message  ."';";
            $db->query( $QryInsertMessage, 'messages');
            return true;
        }

        /**
         * Comprueba SI SE HA ENVIADO o NO
         * $mensaje=$users->SendSimpleMessage( "1" , "2", '',"1", "From", "", "Estoy haciendo pruebas de envioss xD");
         * $mensaje ? $displays->message("Enviado") :$displays->message("No enviado");
         *
         */
    }
     
 
    
}
?>