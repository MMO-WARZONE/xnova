<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** SendSimpleMessage.php                 **
******************************************/

function SendSimpleMessage ( $Owner, $Sender, $Time, $Type, $From, $Subject, $Message) {
    $messfields = array (
    0 => "mnl_spy",
    1 => "mnl_joueur",
    2 => "mnl_alliance",
    3 => "mnl_attaque",
    4 => "mnl_exploit",
    5 => "mnl_transport",
    15 => "mnl_expedition",
    97 => "mnl_general",
    99 => "mnl_buildlist",
    100 => "new_message"
    );

    if ($Time == '') {
        $Time = time();
    }

    $QryInsertMessage  = "INSERT INTO {{table}} SET ";
    $QryInsertMessage .= "`message_owner` = '". $Owner ."', ";
    $QryInsertMessage .= "`message_sender` = '". $Sender ."', ";
    $QryInsertMessage .= "`message_time` = '" . $Time . "', ";
    $QryInsertMessage .= "`message_type` = '". $Type ."', ";
    $QryInsertMessage .= "`message_from` = '". addslashes( $From ) ."', ";
    $QryInsertMessage .= "`message_subject` = '". addslashes( $Subject ) ."', ";
    $QryInsertMessage .= "`message_text` = '". addslashes( $Message ) ."';";
    doquery( $QryInsertMessage, 'messages');

    $QryUpdateUser  = "UPDATE {{table}} SET ";
    $QryUpdateUser .= "`".$messfields[$Type]."` = ".$messfields[$Type]." + 1, ";
    $QryUpdateUser .= "`".$messfields[100]."` = ".$messfields[100]." + 1 ";
    $QryUpdateUser .= "WHERE ";
    $QryUpdateUser .= "`id` = '". $Owner ."';";
    doquery( $QryUpdateUser, 'users');

}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/ 

?>