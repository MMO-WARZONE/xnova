<?php

/**
  * functions.php
  * @Licence GNU (GPL)
  * @version 3.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

function check_urlaubmodus ($user) {

    if ($user['urlaubs_modus'] == 1) {
        message("Sie Sind in Urlaubs Modus!", $title = $user['username'], $dest = "", $time = "3");
    }
}

function check_urlaubmodus_time () {
    global $user, $game_config;

    if ($game_config['urlaubs_modus_erz'] == 1) {
        $begrenzung             = 86400; //24x60x60= 24h
        $urlaub_modus_time      = $user['urlaubs_modus_time'];
        $urlaub_modus_time_soll = $urlaub_modus_time + $begrenzung;
        $time_jetzt             = time();

        if ($user['urlaubs_modus'] == 1 && $urlaub_modus_time_soll > $time_jetzt) {
            $soll_datum = date("d.m.Y", $urlaub_modus_time_soll);
            $soll_uhrzeit = date("H:i:s", $urlaub_modus_time_soll);
            message("Vous &ecirc;tes en mode vacances!<br>Le mode vacance dure jusque $soll_datum $soll_uhrzeit<br>        Ce n'est qu'apr&egrave;s cette p&eacute;riode que vous pouvez changer vos options.", "Mode vacance");
        }
    }
}

function is_email($email) {
    return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email));
}

function AdminMessage ($mes, $title = 'Error', $dest = "", $time = "3") {
    $parse['color'] = $color;
    $parse['title'] = $title;
    $parse['mes']   = $mes;

    $page .= parsetemplate(gettemplate('admin/message_body'), $parse);
    display ($page, $title, false, (($dest != "") ? "<meta http-equiv=\"refresh\" content=\"$time;URL=javascript:self.location='$dest';\">" : ""), true);
}

function message ($mes, $title = 'Fehler', $dest = "", $time = "3") {
    $parse['color'] = $color;
    $parse['title'] = $title;
    $parse['mes']   = $mes;

    $page .= parsetemplate(gettemplate('message_body'), $parse);
    display ($page, $title, false, (($dest != "") ? "<meta http-equiv=\"refresh\" content=\"$time;URL=javascript:self.location='$dest';\">" : ""), false);
}

function display ($page, $title = '', $topnav = true, $metatags = '', $AdminPage = false) {
    global $link, $game_config, $debug, $user, $planetrow, $Adminerlaubt;

    if (!$AdminPage) {
        $DisplayPage  = StdUserHeader ($title, $metatags);
    } else {
        $DisplayPage  = AdminUserHeader ($title, $metatags);
    }

    if ($topnav) {
        $DisplayPage .= ShowTopNavigationBar( $user, $planetrow );

        if ($user['db_deaktjava'] == 1) {
            $urlaub_del_time = $user['deltime'];
            $del_datum = date("d.m.Y", $urlaub_del_time);
            $del_uhrzeit = date("h:i:s", $urlaub_del_time);
            $DisplayPage .= "<center><table><tr><td align=\"center\" class=\"c\">Account L&ouml;schung aktiviert!<br>Ihr Account wird am $del_datum $del_uhrzeit gel&ouml;scht!.</td></tr></table></center>.";
        }
    }

    $DisplayPage .= "<center>\n". $page ."\n</center>\n";
    $DisplayPage .= StdFooter();

    if ($link) {
        mysql_close($link);
    }

    echo $DisplayPage;

    if ($user['authlevel'] == 1 || $user['authlevel'] == 3 and in_array($user['id'],$Adminerlaubt)) {

        if ($game_config['debug'] == 1) $debug->echo_log();
    }
    die();
}

function StdUserHeader ($title = '', $metatags = '') {
    global $user, $dpath, $langInfos;

    $parse             = $langInfos;
    $parse['title']    = $title;

    if ( defined('LOGIN') ) {
        $parse['dpath']    = "skins/xnova/";
        $parse['-style-']  = "<link rel=\"stylesheet\" type=\"text/css\" href=\"styl/css/login/styles.css\">";
    } else {
        $parse['dpath']    = $dpath;
        $parse['-style-']  = "<link rel=\"stylesheet\" type=\"text/css\" href=\"". $dpath ."default.css\">";
        $parse['-style-'] .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"". $dpath ."formate.css\">";
    }

    $parse['-meta-']  = ($metatags) ? $metatags : "";
    $parse['-body-']  = "<body>"; //  class=\"style\" topmargin=\"0\" leftmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">";
    return parsetemplate(gettemplate('simple_header'), $parse);
}

function AdminUserHeader ($title = '', $metatags = '') {
    global $user, $dpath, $langInfos;

    $parse           = $langInfos;
    $parse['dpath']  = $dpath;
    $parse['title']  = $title;
    $parse['-meta-'] = ($metatags) ? $metatags : "";
    $parse['-body-'] = "<body>"; //  class=\"style\" topmargin=\"0\" leftmargin=\"0\" marginwidth=\"0\" marginheight=\"0\">";
    return parsetemplate(gettemplate('admin/simple_header'), $parse);
}

function StdFooter() {
    global $game_config, $lang;
    $parse['copyright']     = $game_config['copyright'];
    $parse['TranslationBy'] = $lang['TranslationBy'];
    return parsetemplate(gettemplate('overall_footer'), $parse);
}

function CalculateMaxPlanetFields (&$planet) {
    global $resource;

    if($planet["planet_type"] != 3) {

        return $planet["field_max"] + ($planet[ $resource[33] ] * 5);
    } elseif($planet["planet_type"] == 3) {
        return $planet["field_max"];
    }
}
function CreateOneDebrisField ($idplanet,$metall,$crystal,$appolonium){

         mysql_query ("UPDATE game_galaxy SET `metal` = `metal` + '". $metall ."',`crystal` = `crystal` + '". $crystal ."',`appolonium` = `appolonium` + '". $appolonium ."'  WHERE id_planet='" . $idplanet  . "'");


}
function umlaute($text)
{
$search  = array ('©', '®', '¼', '½', '¾', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î' ,'ï', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
$replace = array ('&copy;', '&reg;', '&frac14;', '&frac12;', '&frac34;', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;', '&Auml;', '&Aring;', '&AElig;', '&Ccedil;', '&Egrave;', '&Eacute;', '&Ecirc;', '&Euml;', '&Igrave;', '&Iacute;', '&Icirc;', '&Iuml;', '&agrave;', '&aacute;', '&acirc;', '&atilde;', '&auml;', '&aring;', '&aelig;', '&ccedil;', '&egrave;', '&eacute;', '&ecirc;', '&euml;', '&igrave;', '&iacute;', '&icirc;', '&iuml;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&ouml;', '&ugrave;', '&uacute;', '&ucirc;', '&uuml;', '&yacute;', '&yuml;');
$str  = str_replace($search, $replace, $text);
return $str;
}
?>