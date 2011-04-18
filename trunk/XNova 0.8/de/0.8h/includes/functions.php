<?php
function check_urlaubmodus ($user) {
        if ($user['urlaubs_modus'] == 1) {
                message("Sie Sind in Urlaubs Modus!", $title = $user['username'], $dest = "", $time = "3");
        }
}

function check_urlaubmodus_time () {
        global $user, $game_config;
        if ($game_config['urlaubs_modus_erz'] == 1) {
                $begrenzung = 259200; // 60x60x24x3= 3 Tage
                $iduser = $user["id"];
                $urlaub_modus_time = $user['urlaubs_modus_time'];
                $urlaub_modus_time_soll = $urlaub_modus_time + $begrenzung;
                $time_jetzt = time();
                if ($user['urlaubs_modus'] == 1 && $urlaub_modus_time_soll > $time_jetzt) {
                        $soll_datum = date("d.m.Y", $urlaub_modus_time_soll);
                        $soll_uhrzeit = date("H:i:s", $urlaub_modus_time_soll);
                
                }
                elseif ($user['urlaubs_modus'] == 1 && $urlaub_modus_time_soll < $time_jetzt) {
                        doquery("UPDATE {{table}} SET
                                `urlaubs_modus` = '0',
                                `urlaubs_modus_time` = '0'
                                WHERE `id` = '$iduser' LIMIT 1", "users");
                }
        }
}

// ----------------------------------------------------------------------------------------------------------------
//
// Routine Test de validit  d'une adresse email
//
function is_email($email) {
        return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email));
}

// ----------------------------------------------------------------------------------------------------------------
//
// Routine Affichage d'un message administrateur avec saut vers une autre page si souhait 
//
function AdminMessage ($mes, $title = 'Error', $dest = "", $time = "3") {
        $parse['color'] = $color;
        $parse['title'] = $title;
        $parse['mes']   = $mes;

        $page .= parsetemplate(gettemplate('admin/message_body'), $parse);

        display ($page, $title, false, (($dest != "") ? "<meta http-equiv=\"refresh\" content=\"$time;URL=javascript:self.location='$dest';\">" : ""), true);
}

// ----------------------------------------------------------------------------------------------------------------
//
// Routine Affichage d'un message avec saut vers une autre page si souhait 
//
function message ($mes, $title = 'Error', $dest = "", $time = "3") {
        $parse['color'] = $color;
        $parse['title'] = $title;
        $parse['mes']   = $mes;

        $page .= parsetemplate(gettemplate('message_body'), $parse);

        display ($page, $title, false, (($dest != "") ? "<meta http-equiv=\"refresh\" content=\"$time;URL=javascript:self.location='$dest';\">" : ""), false);
}

// ----------------------------------------------------------------------------------------------------------------
//
// Routine Anzeige einer Seite in einem Rahmen
//
// $page      -> Die Seite
// $title     -> Der Titel der Seite
// $topnav    -> Anzeige der Ressourcen? Ja oder Nein ??
// $metatags  -> Wenn es einige besondere Aktionen zu tun hat ...
// $AdminPage -> Wenn man sich im Adminbereich befindet .. muss man es angeben ..
function display ($page, $title = '', $topnav = true, $metatags = '', $AdminPage = false) {
        global $link, $game_config, $debug, $user, $planetrow;

        if (!$AdminPage) {
                $DisplayPage  = StdUserHeader ($title, $metatags);
        } else {
                $DisplayPage  = AdminUserHeader ($title, $metatags);
        }

        if ($topnav) {

                if ($user['aktywnosc'] == 1) {
                        $urlaub_act_time = $user['time_aktyw'];
                        $act_datum = date("d.m.Y", $urlaub_act_time);
                        $act_uhrzeit = date("H:i:s", $urlaub_act_time);
                $DisplayPage .= "Le mode del dure jusque $act_datum $act_uhrzeit<br>        Ce n'est qu'apr s cette p riode que vous pouvez changer vos options.";
                }

                if ($user['db_deaktjava'] == 1) {
                        $urlaub_del_time = $user['deltime'];
                        $del_datum = date("d.m.Y", $urlaub_del_time);
                        $del_uhrzeit = date("h:i:s", $urlaub_del_time);
                $DisplayPage .= "Account L&ouml;schung aktiviert!<br>Ihr Account wird am $del_datum $del_uhrzeit gel&ouml;scht!.";
                }

                $DisplayPage .= ShowTopNavigationBar( $user, $planetrow );
        }
        $DisplayPage .= "<center>\n". $page ."\n</center>\n";
        // Affichage du Debug si necessaire
        if ($user['authlevel'] == 1 || $user['authlevel'] == 3) {
                if ($game_config['debug'] == 1) $debug->echo_log();
        }

        $DisplayPage .= StdFooter();
        if (isset($link)) {
                mysql_close();
        }

        echo $DisplayPage;

        die();
}

// ----------------------------------------------------------------------------------------------------------------
//
// Entete de page
//
function StdUserHeader ($title = '', $metatags = '') {
        global $user, $dpath, $langInfos;

        $dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

        $parse           = $langInfos;
        $parse['dpath']  = $dpath;
        $parse['title']  = $title;
        $parse['-meta-'] = ($metatags) ? $metatags : "";
        $parse['-body-'] = "<body>"; //  class=\"style\" topmargin=\"0\" leftmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">";
        return parsetemplate(gettemplate('simple_header'), $parse);
}

// ----------------------------------------------------------------------------------------------------------------
//
// Entete de page administration
//
function AdminUserHeader ($title = '', $metatags = '') {
        global $user, $dpath, $langInfos;

        $dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];

        $parse           = $langInfos;
        $parse['dpath']  = $dpath;
        $parse['title']  = $title;
        $parse['-meta-'] = ($metatags) ? $metatags : "";
        $parse['-body-'] = "<body>"; //  class=\"style\" topmargin=\"0\" leftmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">";
        return parsetemplate(gettemplate('admin/simple_header'), $parse);
}

// ----------------------------------------------------------------------------------------------------------------
//
// Pied de page
//
function StdFooter() {
        global $game_config, $lang;
        $parse['copyright']     = $game_config['copyright'];
        $parse['TranslationBy'] = $lang['TranslationBy'];
        return parsetemplate(gettemplate('overall_footer'), $parse);
}

// ----------------------------------------------------------------------------------------------------------------
//
// Calcul de la place disponible sur une planete
//
function CalculateMaxPlanetFields (&$planet) {
        global $resource;

        if($planet["planet_type"] != 3) {
        return $planet["field_max"] + ($planet[ $resource[33] ] * 5);
        }
        elseif($planet["planet_type"] == 3) {
        return $planet["field_max"] + ($planet[ $resource[41] ] * 3);
        }
}


/**
 * functions.php
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 */

// ----------------------------------------------------------------------------------------------------------------
//
// Routine pour la gestion du mode vacance
//

?>