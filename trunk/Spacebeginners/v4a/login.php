<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('LOGIN'   , true);

$InLogin = true;

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
global  $game_config, $user;

if  ($game_config['game_disable'] == 1){
    echo $game_config['close_reason'];
}else{
    switch($_GET[page]){
        case "kontakt":

        includeLang('login/login_kontakt');

        $BodyTPL = gettemplate('login/login_kontakt_01');
        $RowsTPL = gettemplate('login/login_kontakt_02');
        $parse   = $lang;
        $parse['dpath']        = $dpath;
        $parse['servername']   = $game_config['game_name'];
        $parse['forum_url']    = $game_config['forum_url'];

        $QrySelectUser  = "SELECT `username`, `email`, `authlevel` ";
        $QrySelectUser .= "FROM {{table}} ";
        $QrySelectUser .= "WHERE `authlevel` != '0' ORDER BY `authlevel` DESC;";
        $GameOps = doquery ( $QrySelectUser, 'users');

        while( $Ops = mysql_fetch_assoc($GameOps) ) {
                $bloc['ctc_data_name']    = $Ops['username'];
                $bloc['ctc_data_auth']    = $lang['user_level'][$Ops['authlevel']];
                $bloc['ctc_data_mail']    = "<a href=\"mailto:".$Ops['email']."\">".$Ops['email']."</a>";
                $parse['ctc_admin_list'] .= parsetemplate($RowsTPL, $bloc);
        }

        $page = parsetemplate($BodyTPL, $parse);
        display($page, $lang['Kontakt'], false);

        break;
        case "credit":

        includeLang('login/login_credit');

        $parse                 = $lang;
        $parse['dpath']        = $dpath;
        $parse['servername']   = $game_config['game_name'];
        $parse['forum_url']    = $game_config['forum_url'];

        $page = parsetemplate(gettemplate('login/login_credit'), $parse);
        display ($page, $lang['Credit'], false);

        break;
        case "volk_01":

        includeLang('login/login_volk_01');

        $parse                 = $lang;
        $parse['dpath']        = $dpath;
        $parse['servername']   = $game_config['game_name'];
        $parse['forum_url']    = $game_config['forum_url'];

        $page = parsetemplate(gettemplate('login/login_volk_01'), $parse);
        display ($page, $lang['Volk_01'], false);

        break;
        case "volk_02":

        includeLang('login/login_volk_02');

        $parse                 = $lang;
        $parse['dpath']        = $dpath;
        $parse['servername']   = $game_config['game_name'];
        $parse['forum_url']    = $game_config['forum_url'];

        $page = parsetemplate(gettemplate('login/login_volk_02'), $parse);
        display ($page, $lang['Volk_02'], false);

        break;
        case "volk_03":

        includeLang('login/login_volk_03');

        $parse                 = $lang;
        $parse['dpath']        = $dpath;
        $parse['servername']   = $game_config['game_name'];
        $parse['forum_url']    = $game_config['forum_url'];

        $page = parsetemplate(gettemplate('login/login_volk_03'), $parse);
        display ($page, $lang['Volk_03'], false);

        break;
        case "wartezeit":

        includeLang('login/login_wartezeit');
        $dpath          = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
        $parse                 = $lang;
        $parse['dpath']        = $dpath;
        $parse['servername']   = $game_config['game_name'];
        $parse['forum_url']    = $game_config['forum_url'];

        $page = parsetemplate(gettemplate('login/login_wartezeit'), $parse);
        echo $page;

        break;
        case "logout":

        includeLang('login/login_logout');

        $parse                 = $lang;
        $parse['dpath']        = $dpath;
        $parse['servername']   = $game_config['game_name'];
        $parse['forum_url']    = $game_config['forum_url'];

        $second = 40;
        $parse['tps_seconds'] = $second;

        setcookie($game_config['COOKIE_NAME'], "", time()-100000, "/", "", 0);

        $QryUpdateUser    = "UPDATE {{table}} SET ";
        $QryUpdateUser   .= "`current_planet` = `id_planet` ";
        $QryUpdateUser   .= "WHERE ";
        $QryUpdateUser   .= "`id` = '". $user['id'] ."' LIMIT 1";
            doquery( $QryUpdateUser, "users");

        $page = parsetemplate(gettemplate('login/login_logout'), $parse);
        header("Refresh: ".$second."; Url = login.php");
        echo $page;

        break;
        case "reg":

        includeLang('login/login_anmelden');

        function sendpassemail($emailaddress, $password) {
            global $lang;

            $parse['gameurl']  = GAMEURL;
            $parse['password'] = $password;
            $email             = parsetemplate($lang['anmelden']['0001'], $parse);
            $status            = mymail($emailaddress, $lang['anmelden']['0002'], $email);
            return $status;
        }

        function mymail($to, $title, $body, $from = '') {
            $from = trim($from);

            if (!$from) {
                $from = ADMINEMAIL;
            }

            $rp     = ADMINEMAIL;
            $head   = '';
            $head  .= "Content-Type: text/plain \r\n";
            $head  .= "Date: " . date('r') . " \r\n";
            $head  .= "Return-Path: $rp \r\n";
            $head  .= "From: $from \r\n";
            $head  .= "Sender: $from \r\n";
            $head  .= "Reply-To: $from \r\n";
            $head  .= "Organization: $org \r\n";
            $head  .= "X-Sender: $from \r\n";
            $head  .= "X-Priority: 3 \r\n";
            $body   = str_replace("\r\n", "\n", $body);
            $body   = str_replace("\n", "\r\n", $body);

            return mail($to, $title, $body, $head);
        }

        if ($_POST) {
            $errors    = 0;
            $errorlist = "";

            if (!ctype_alnum($_POST['character'])) {
                $errorlist .= $lang['anmelden']['2000'];
                $errors++;
            }

            if (preg_match("/[^A-z0-9_\-]/", $_POST['character'])) {
                $errorlist .= $lang['anmelden']['2001'];
                $errors++;
            }

            if (strlen($_POST['passwrd']) < 6 and !ctype_alnum($_POST['passwrd']) ) {
                $errorlist .= $lang['anmelden']['2002'];
                $errors++;
            }
            $_POST['email'] = strip_tags($_POST['email']);

            if (!is_email($_POST['email'])) {
                $errorlist .= "" . $_POST['email'] . " " . $lang['anmelden']['2003']."";
                $errors++;
            }


            if (!ctype_alnum($_POST['planet'])) {
                $errorlist .= $lang['anmelden']['2004'];
                $errors++;
            }
            session_start();

            if ($_SESSION['captcha'] != $_POST['captcha']) {
                $errorlist .= $lang['anmelden']['2005'];
                $errors++;
            }

            if ($_POST['rgt'] != 'on') {
                $errorlist .= $lang['anmelden']['2006'];
                $errors++;
            }
            $ExistUser = doquery("SELECT `username` FROM {{table}} WHERE `username` = '". mysql_escape_string($_POST['character']) ."' LIMIT 1;", 'users', true);

            if ($ExistUser) {
                $errorlist .= $lang['anmelden']['2007'];
                $errors++;
            }
            $ExistMail = doquery("SELECT `email` FROM {{table}} WHERE `email` = '". mysql_escape_string($_POST['email']) ."' LIMIT 1;", 'users', true);

            if ($ExistMail) {
                $errorlist .= $lang['anmelden']['2008'];
                $errors++;
            }

            if ($_POST['sex'] != ''  &&
                $_POST['sex'] != 'F' &&
                $_POST['sex'] != 'M') {
                $errorlist .= $lang['anmelden']['2009'];
                $errors++;
            }

                          if ($_POST['volk'] != 'A' &&
                                  $_POST['volk'] != 'B' &&
                  $_POST['volk'] != 'C') {
                  $errorlist .= $lang['anmelden']['2011'];
                  $errors++;
                 }

            if ($errors != 0) {
                message ($errorlist, $lang['anmelden']['3000'], $_POST['volk']);
            } else {
                $newpass        = $_POST['passwrd'];
                $UserName       = CheckInputStrings ( $_POST['character'] );
                $UserEmail      = CheckInputStrings ( $_POST['email'] );
                $UserPlanet     = CheckInputStrings ( $_POST['planet'] );
                $md5newpass     = md5($newpass);

                $QryInsertUser  = "INSERT INTO {{table}} SET ";
                $QryInsertUser .= "`username` = '". mysql_escape_string(strip_tags( $UserName )) ."', ";
                $QryInsertUser .= "`email` = '".    mysql_escape_string( $UserEmail )            ."', ";
                $QryInsertUser .= "`email_2` = '".  mysql_escape_string( $UserEmail )            ."', ";
                $QryInsertUser .= "`sex` = '".      mysql_escape_string( $_POST['sex'] )         ."', ";
                $QryInsertUser .= "`volk` = '".                        ( $_POST['volk'] )         ."', ";
                $QryInsertUser .= "`avatar` = '".                      ( $_POST['volk'] )         ."', ";
                $QryInsertUser .= "`id_planet` = '0', ";
                $QryInsertUser .= "`register_time` = '". time() ."', ";
                $QryInsertUser .= "`password`='". $md5newpass ."';";
                doquery( $QryInsertUser, 'users');
                $NewUser        = doquery("SELECT `id` FROM {{table}} WHERE `username` = '". mysql_escape_string($_POST['character']) ."' LIMIT 1;", 'users', true);
                $iduser         = $NewUser['id'];


                $LastSettedGalaxyPos  = $game_config['LastSettedGalaxyPos'];
                $LastSettedSystemPos  = $game_config['LastSettedSystemPos'];
                $LastSettedPlanetPos  = $game_config['LastSettedPlanetPos'];
                while (!isset($newpos_checked)) {
                    for ($Galaxy = $LastSettedGalaxyPos; $Galaxy <= MAX_GALAXY_IN_WORLD; $Galaxy++) {
                        for ($System = $LastSettedSystemPos; $System <= MAX_SYSTEM_IN_GALAXY; $System++) {
                            for ($Posit = $LastSettedPlanetPos; $Posit <= 4; $Posit++) {
                                $Planet = round (rand ( 4, 12) );

                                switch ($LastSettedPlanetPos) {
                                    case 1:
                                    $LastSettedPlanetPos += 1;
                                    break;

                                    case 2:
                                    $LastSettedPlanetPos += 1;
                                    break;

                                    case 3:
                                    if ($LastSettedSystemPos == MAX_SYSTEM_IN_GALAXY) {
                                        $LastSettedGalaxyPos += 1;
                                        $LastSettedSystemPos  = 1;
                                        $LastSettedPlanetPos  = 1;
                                        break;
                                    } else {
                                        $LastSettedPlanetPos  = 1;
                                    }
                                    $LastSettedSystemPos += 1;
                                    break;
                                }
                                break;
                            }
                            break;
                        }
                        break;
                    }
                    $QrySelectGalaxy  =        "SELECT * ";
                    $QrySelectGalaxy .= "FROM {{table}} ";
                    $QrySelectGalaxy .= "WHERE ";
                    $QrySelectGalaxy .= "`galaxy` = '". $Galaxy ."' AND ";
                    $QrySelectGalaxy .= "`system` = '". $System ."' AND ";
                    $QrySelectGalaxy .= "`planet` = '". $Planet ."' ";
                    $QrySelectGalaxy .= "LIMIT 1;";
                    $GalaxyRow = doquery( $QrySelectGalaxy, 'galaxy', true);

                    if ($GalaxyRow["id_planet"] == "0") {
                        $newpos_checked = true;
                    }

                    if (!$GalaxyRow) {
                        CreateOnePlanetRecord ($Galaxy, $System, $Planet, $NewUser['id'], $UserPlanet, true);
                        $newpos_checked = true;
                    }

                    if ($newpos_checked) {
                        doquery("UPDATE {{table}} SET `config_value` = '". $LastSettedGalaxyPos ."' WHERE `config_name` = 'LastSettedGalaxyPos';", 'config');
                        doquery("UPDATE {{table}} SET `config_value` = '". $LastSettedSystemPos ."' WHERE `config_name` = 'LastSettedSystemPos';", 'config');
                        doquery("UPDATE {{table}} SET `config_value` = '". $LastSettedPlanetPos ."' WHERE `config_name` = 'LastSettedPlanetPos';", 'config');
                    }
                }

                $PlanetID = doquery("SELECT `id` FROM {{table}} WHERE `id_owner` = '". $NewUser['id'] ."' LIMIT 1;", 'planets', true);
                $QryUpdateUser  = "UPDATE {{table}} SET ";
                $QryUpdateUser .= "`id_planet` = '". $PlanetID['id'] ."', ";
                $QryUpdateUser .= "`current_planet` = '". $PlanetID['id'] ."', ";
                $QryUpdateUser .= "`galaxy` = '". $Galaxy ."', ";
                $QryUpdateUser .= "`system` = '". $System ."', ";
                $QryUpdateUser .= "`planet` = '". $Planet ."' ";
                $QryUpdateUser .= "WHERE ";
                $QryUpdateUser .= "`id` = '". $NewUser['id'] ."' ";
                $QryUpdateUser .= "LIMIT 1;";
                doquery( $QryUpdateUser, 'users');
                doquery("UPDATE {{table}} SET `config_value` = `config_value` + '1' WHERE `config_name` = 'users_amount' LIMIT 1;", 'config');
                $Message  = $lang['anmelden']['4000'];

                if (sendpassemail($_POST['email'], "$newpass")) {
                    $Message .= " (" . htmlentities($_POST["email"]) . ")";
                } else {
                    $Message .= " (" . htmlentities($_POST["email"]) . ")";
                    $Message .= "<br><br>". $lang['anmelden']['2010'] ." <b>" . $newpass . "</b>";
                }
                message( $Message, $lang['anmelden']['3001']);
            }
        } else {
            $parse               = $lang;
            $parse['servername'] = $game_config['game_name'];
            $parse['forum_url']   = $game_config['forum_url'];
            $page                = parsetemplate(gettemplate('login/login_anmelden'), $parse);

            display ($page, $lang['Anmelden'], false);
        }

        break;
        default:

        includeLang('login/login_body');

        if ($_POST) {
            $login = doquery("SELECT * FROM {{table}} WHERE `username` = '" . mysql_escape_string($_POST['username']) . "' LIMIT 1", "users", true);

            if($login['banaday'] <= time() & $login['banaday'] !='0' ){
                doquery("UPDATE {{table}} SET `banaday` = '0', `bana` = '0', `urlaubs_modus` ='0'  WHERE `username` = '".$login['username']."' LIMIT 1;", 'users');
                doquery("DELETE FROM {{table}} WHERE `who` = '".$login['username']."'",'banned');
            }

            //Captcha anfang
            session_start();

            if ($_SESSION['captcha'] != $_POST['captcha']) {
                message ( $lang['login']['0001'], $lang['login']['1000']);
            }
            //Captcha  ende

            if ($login) {

                if ($login['password'] == md5($_POST['password'])) {
                    session_start();

                    if ($_SESSION['captcha'] != $_POST['captcha']) {
                        message ( $lang['login']['0001'], $lang['login']['1000']);
                    }


                    if (isset($_POST["rememberme"])) {
                        $expiretime = time() + 31536000;
                        $rememberme = 1;
                    } else {
                        $expiretime = 0;
                        $rememberme = 0;
                    }

                    @include('config.php');
                    $cookie = $login["id"] . "/%/" . $login["username"] . "/%/" . md5($login["password"] . "--" . $dbsettings["secretword"]) . "/%/" . $rememberme;
                    setcookie($game_config['COOKIE_NAME'], $cookie, $expiretime, "/", "", 0);

                    unset($dbsettings);
                    header("Location: ./login.php?page=wartezeit");
                    exit;
                } else {
                    message($lang['login']['0002'], $lang['login']['1000']);
                }
            } else {
                message($lang['login']['0003'], $lang['login']['1000']);
            }
        } else {
            $parse                 = $lang;
            $Count                 = doquery('SELECT COUNT(*) as `players` FROM {{table}} WHERE 1', 'users', true);
            $LastPlayer            = doquery('SELECT `username` FROM {{table}} ORDER BY `register_time` DESC', 'users', true);
            $parse['last_user']    = $LastPlayer['username'];
            $PlayersOnline         = doquery("SELECT COUNT(DISTINCT(id)) as `onlinenow` FROM {{table}} WHERE `onlinetime` > '" . (time()-900) ."';", 'users', true);
            $parse['online_users'] = $PlayersOnline['onlinenow'];
            $parse['users_amount'] = $Count['players'];
            $parse['servername']   = $game_config['game_name'];
            $parse['forum_url']    = $game_config['forum_url'];
            $parse['PasswordLost'] = $lang['PasswordLost'];
            $page = parsetemplate(gettemplate('login/login_body'), $parse);

            if ($_GET['ucount'] == 1) {
                $page = $PlayersOnline['onlinenow']."/".$Count['players'];
                die ( $page );
            } else {
                display($page, $lang['Login'], false);
            }
        }
    }
}
?>