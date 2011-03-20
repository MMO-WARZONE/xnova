<?php

/*******************************
   * ResetThisFuckingC. .php   *
   * @Licence GNU (GPL)        *
   * @version 1.0              *
   * @copyright 2010/2011      *
   * @Team Space beginners     *
   *******************************/

// + Neu wird auch noch fur 3 Tage gesperrt
// + Jeder Bekommt eine Nachricht das der User gecheatet hat
// + Volk wurde mit eingefugt
// + Planeten Id von 0 auf id_planet geandert

function ResetThisFuckingCheater ( $UserID ) {
    global $lang, $user;

    includeLang('error/cheat');

    $page = $lang;

    $TheUser        = doquery ("SELECT * FROM {{table}} WHERE `id` = '". $UserID ."';", 'users', true);
    $UserPlanet     = doquery ("SELECT `name` FROM {{table}} WHERE `id` = '". $TheUser['id_planet']."';", 'planets', true);

    DeleteSelectedUser ( $UserID );

    if ($UserPlanet['name'] != "") {

        $Now = time();                  // Aktuelles Datum
        $BanTime = 259200;              // Sperrzeit 60(Sekunden) mal 60(Minuten) mal 24(Stunden) mal 3(Tage) = 259200
        $BannedUntil = $Now + $BanTime; // Aktuelles Datum mal Sperrzeit

        $QryInsertUser  = "INSERT INTO {{table}} SET ";
        $QryInsertUser .= "`id`            = '".$TheUser['id']            ."', ";
        $QryInsertUser .= "`username`      = '".$TheUser['username']      ."', ";
        $QryInsertUser .= "`email`         = '".$TheUser['email']         ."', ";
        $QryInsertUser .= "`email_2`       = '".$TheUser['email_2']       ."', ";
        $QryInsertUser .= "`sex`           = '".$TheUser['sex']           ."', ";
        $QryInsertUser .= "`volk`          = '".$TheUser['volk']          ."', ";
		$QryInsertUser .= "`avatar`        = '".$TheUser['avatar']        ."', ";
        $QryInsertUser .= "`id_planet`     = '".$TheUser['id_planet']     ."', ";
        $QryInsertUser .= "`authlevel`     = '".$TheUser['authlevel']     ."', ";
        $QryInsertUser .= "`dpath`         = '".$TheUser['dpath']         ."', ";
        $QryInsertUser .= "`galaxy`        = '".$TheUser['galaxy']        ."', ";
        $QryInsertUser .= "`system`        = '".$TheUser['system']        ."', ";
        $QryInsertUser .= "`planet`        = '".$TheUser['planet']        ."', ";
        $QryInsertUser .= "`register_time` = '".$TheUser['register_time'] ."', ";
        $QryInsertUser .= "`password`      = '".$TheUser['password']      ."'; ";
        doquery( $QryInsertUser, 'users');

        $QryInsertBan  = "INSERT INTO {{table}} SET ";
        $QryInsertBan .= "`id`     = '".$TheUser['id']       ."', ";
        $QryInsertBan .= "`who`    = '".$TheUser['username'] ."', ";
        $QryInsertBan .= "`theme`  = '".$lang['cheat_001']."',";
        $QryInsertBan .= "`who2`   = '',";
        $QryInsertBan .= "`time`   = '".$Now ."',";
        $QryInsertBan .= "`longer` = '".$BannedUntil."',";
        $QryInsertBan .= "`author` = '".$lang['cheat_002']."',";
        $QryInsertBan .= "`email`  = '';";
        doquery( $QryInsertBan, 'banned');

        $NewUser        = doquery("SELECT `id` FROM {{table}} WHERE `username` = '". $TheUser['username'] ."' LIMIT 1;", 'users', true);

        CreateOnePlanetRecord ($TheUser['galaxy'], $TheUser['system'], $TheUser['planet'], $NewUser['id'], $UserPlanet['name'], true);
        $PlanetID       = doquery("SELECT `id` FROM {{table}} WHERE `id_owner` = '". $NewUser['id'] ."' LIMIT 1;", 'planets', true);

        $QryUpdateUser  = "UPDATE {{table}} SET ";
        $QryUpdateUser .= "`id_planet` = '".      $PlanetID['id'] ."', ";
        $QryUpdateUser .= "`current_planet` = '". $PlanetID['id'] ."' ";
        $QryUpdateUser .= "WHERE ";
        $QryUpdateUser .= "`id` = '".             $NewUser['id']  ."';";
        doquery( $QryUpdateUser, 'users');
    }

    $QryUpdateUser     = "UPDATE {{table}} SET ";
    $QryUpdateUser    .= "`bana` = '1', ";
    $QryUpdateUser    .= "`banaday` = '". $BannedUntil ."' ";
    $QryUpdateUser    .= "WHERE ";
    $QryUpdateUser    .= "`username` = \"". $TheUser['username'] ."\";";
    doquery( $QryUpdateUser, 'users');

    if ($TheUser) {
        $sq      = doquery("SELECT * FROM {{table}}", "users");
        $Time    = time();
        $From    = "<font color='#FF0000'><b>".$lang['cheat_002']."</b></font>";
        $Subject = "<font color='#FF0000'><b>".$lang['cheat_001']."</b></font>";
        $Message = "<font color='#FF0000'><b>".$lang['cheat_003']."".$TheUser['username']."".$lang['cheat_004']."".$lang['cheat_005']."".$lang['cheat_006']."".$lang['cheat_007']."".$lang['cheat_008']."".$lang['cheat_009']."".$lang['cheat_010']."".$lang['cheat_011']."".$lang['cheat_012']."".$lang['cheat_013']."</b></font>";
        $summery=0;

        while ($u = mysql_fetch_array($sq)) {
            SendSimpleMessage ( $u['id'], $user['id'], $Time, 1, $From, $Subject, $Message);
        }
    }
    echo $page;
}

?>