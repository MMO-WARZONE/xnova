<?php

if (!defined('INSIDE'))
{
 	    die();
}

includeLang('functions');

function check_urlaubmodus ($user) {
	global $lang;

	if ($user['urlaubs_modus'] == 1) {
		message($lang['VACATION'], $title = $user['username'], $dest = "", $time = "3");
	}
}

function cleanHTML($text){
   
    $search = array('/<\?((?!\?>).)*\?>/s');
    $new = strip_tags(preg_replace($search, '', $text));
    $new = str_replace("\\", "\\\\", $value);
    $new = str_replace("'", "\'", $value);
    
    return $new;
}

function cleanNumeric($var) {
   $newvar = preg_replace('/[^0-9]/', '', $var);
   return $newvar;
}

function check_urlaubmodus_time () {
        global $user, $game_config, $lang;
        if ($game_config['urlaubs_modus_erz'] == 1) {
                $begrenzung = 259200; // 60x60x24x3= 3 Tage
                $iduser = $user["id"];
                $urlaub_modus_time = $user['urlaubs_modus_time'];
                $urlaub_modus_time_soll = $urlaub_modus_time + $begrenzung;
                $time_jetzt = time();
                if ($user['urlaubs_modus'] == 1 && $urlaub_modus_time_soll > $time_jetzt) {
                        $soll_datum = date("d.m.Y", $urlaub_modus_time_soll);
                        $soll_uhrzeit = date("H:i:s", $urlaub_modus_time_soll);
						message(str_replace('##date##', $soll_datum.' '.$soll_uhrzeit, $lang['VACATION_UNTIL']), $lang['VACATION_TITLE']);
		}
                }
                elseif ($user['urlaubs_modus'] == 1 && $urlaub_modus_time_soll < $time_jetzt) {
                        doquery("UPDATE {{table}} SET
                                `urlaubs_modus` = '0',
                                `urlaubs_modus_time` = '0'
                                WHERE `id` = '$iduser' LIMIT 1", "users");
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

//----------------------------------------------------------------------------------------------------------------
//
// Kolonisation -> CreateOnePlanetRecord.php
//
function chance ($percent) {
    $chance = mt_rand(0,100);
    if($percent <= $chance){
        return true;
    }else{
        return false;        
    }
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
        global $link, $game_config, $debug, $user, $planetrow, $lang;

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
                $DisplayPage .= str_replace('##date##', $act_datum.' '.$act_uhrzeit, $lang['VACATION_UNTIL']);
                }

                if ($user['db_deaktjava'] == 1) {
                        $urlaub_del_time = $user['deltime'];
                        $del_datum = date("d.m.Y", $urlaub_del_time);
                        $del_uhrzeit = date("h:i:s", $urlaub_del_time);
                $DisplayPage .= str_replace('##date##', $del_datum.' '.$del_uhrzeit, $lang['ACCOUNT_DELETION']);
                }

                $DisplayPage .= ShowTopNavigationBar( $user, $planetrow );
        }
        $DisplayPage .= "<center>\n". $page ."\n</center>\n";
        // Affichage du Debug si necessaire
        if ($user['authlevel'] == 1 || $user['authlevel'] == 3) {
                if ($game_config['debug'] == 1) $debug->echo_log();
        }

        $DisplayPage .= StdFooter();
        if ($link) 
		{
                mysql_close($link);
        }

        echo $DisplayPage;

        die();
}

   // Añadir debug si es admin y tiene el modo debug activado
   if ($user['authlevel'] == 1 || $user['authlevel'] == 3) {
      if ($game_config['debug'] == 1) $debug->echo_log();
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
// ----------------------------------------------------------------------------------------------------------------
//
// Umlaute
//
function umlaute($text)
{
$search  = array ('©', '®', '¼', '½', '¾', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Æ', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'à', 'á', 'â', 'ã', 'ä', 'å', 'æ', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î' ,'ï', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ú', 'û', 'ü', 'ý', 'ÿ');
$replace = array ('&copy;', '&reg;', '&frac14;', '&frac12;', '&frac34;', '&Agrave;', '&Aacute;', '&Acirc;', '&Atilde;', '&Auml;', '&Aring;', '&AElig;', '&Ccedil;', '&Egrave;', '&Eacute;', '&Ecirc;', '&Euml;', '&Igrave;', '&Iacute;', '&Icirc;', '&Iuml;', '&agrave;', '&aacute;', '&acirc;', '&atilde;', '&auml;', '&aring;', '&aelig;', '&ccedil;', '&egrave;', '&eacute;', '&ecirc;', '&euml;', '&igrave;', '&iacute;', '&icirc;', '&iuml;', '&ograve;', '&oacute;', '&ocirc;', '&otilde;', '&ouml;', '&ugrave;', '&uacute;', '&ucirc;', '&uuml;', '&yacute;', '&yuml;');
$str  = str_replace($search, $replace, $text);
return $str;
}


/**
 * Nr2Str
 * converts a number in to a string using localised separators
 * @author Col_Burton
 *
 * @param nr any number
 * @param precision defines number of digits after decimal point
 * @param fixed defines the fix number of digits if greater 0
 * @return the number as string
 */
function Nr2Str ( $nr, $precision = 0, $fixed = 0 ) {
	global $lang;

	if ( ! isset($lang['DECIMAL_POINT']) ) { $lang['DECIMAL_POINT'] = '.'; }
	if ( ! isset($lang['THOUSAND_SEP']) ) { $lang['THOUSAND_SEP'] = ','; }

	// add leading 0s if fixed number of digits is given
	if ( $fixed > 0 ) {
		return sprintf("%0{$fixed}u", $nr);
	}

	// str_replace is needed to prevent word wrapping
	return str_replace(' ', '&nbsp;', number_format($nr, $precision, $lang['DECIMAL_POINT'], $lang['THOUSAND_SEP']));
}


/**
 * str_makerand
 * generates a random string with specified length
 * @author Col_Burton
 *
 * @param minlength minimal string length
 * @param maxlength maximal string length
 * @param useupper boolean use uppercase letters
 * @param usespecial boolean use special characters
 * @param usenumbers boolean use numbers
 * @return random string with the specifications set with the parameters
 */
function str_makerand ($minlength=6, $maxlength=10, $useupper=true, $usespecial=false, $usenumbers=false) {
	$key = "";
	$charset = "abcdefghijklmnopqrstuvwxyz";
	if ($useupper) $charset .= "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	if ($usenumbers) $charset .= "0123456789";
	if ($usespecial) $charset .= "~@#$%^*()_+-={}|]["; // omitted some to avoid conflicts "~!@#$%^&*()_+`-={}|\\]?[\":;'><,./";
	if ($minlength > $maxlength) $length = mt_rand ($maxlength, $minlength);
	else $length = mt_rand ($minlength, $maxlength);
	for ($i=0; $i<$length; $i++) $key .= $charset[(mt_rand(0,(strlen($charset)-1)))];
	return $key;
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