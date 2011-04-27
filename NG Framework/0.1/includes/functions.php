<?php
/**
 * @author Perberos perberos@gmail.com
 * @author Chlorel
 * 
 * @package XNova
 * @version 0.8
 * @copyright (c) 2008 XNova Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

if (!defined('INSIDE'))
{
	die();
}

function makeMessageSmilies($msg){
	global $smilies_array;
	
	foreach($smilies_array as $image => $smilie){
		$msg = str_replace($smilie, '<img src="images/smilies/' . $image . '" border="0" />', $msg);
	}
	
	return $msg;
}

function getSmilies(){
	global $smilies_array;
	
	foreach($smilies_array as $image => $smilie){
		$counter++;
		$return .= '<td><a href="javascript:void(0);" onclick="putSmilie(\'' . $smilie . ' \')"><img src="images/smilies/' . $image . '" border="0" /></a></td>';
		
		if($counter == 8){
			unset($counter);
			$return .= "</tr><tr>";
		}
	}	
	return $return;
}

function makeSmiliesArray(){
	global $smilies_array;
	
	$smilies_array = array( 'icon_arrow.gif' => '[arrow]',
							'icon_cool.gif' => '[H]',
							'icon_cry.gif' => '[T_T]',
							'icon_e_biggrin.gif' => '[:D]',
							'icon_e_confused.gif' => '[:S]',
							'icon_e_geek.gif' => '[8)]',
							'icon_e_sad.gif' => '[sad]',
							'icon_e_surprised.gif' => '[:O]',
							'icon_e_ugeek.gif' => '[(8>]',
							'icon_e_wink.gif' => '[;)]',
							'icon_eek.gif' => '[eek]',
							'icon_evil.gif' => '[(6)]',
							'icon_exclaim.gif' => '[!]',
							'icon_idea.gif' => '[idea]',
							'icon_lol.gif' => '[^^]',
							'icon_mad.gif' => '[mad]',
							'icon_mrgreen.gif' => '[green]',
							'icon_neutral.gif' => '[wtf]',
							'icon_question.gif' => '[?]',
							'icon_razz.gif' => '[hehe]',
							'icon_redface.gif' => '[:(]',
							'icon_rolleyes.gif' => '[roll]',
							'icon_twisted.gif' => '[twisted]');
	
	return;
}

// ----------------------------------------------------------------------------------------------------------------
//
// Routine pour la gestion du mode vacance
//
function check_urlaubmodus ($user) {
	if ($user['urlaubs_modus'] == 1) {
		message("Vous êtes en mode vacances!", $title = $user['username'], $dest = "", $time = "3");
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
	global $user, $game_config;
	if ($game_config['urlaubs_modus_erz'] == 1) {
		$begrenzung = 86400; //24x60x60= 24h
		$urlaub_modus_time = $user['urlaubs_modus_time'];
		$urlaub_modus_time_soll = $urlaub_modus_time + $begrenzung;
		$time_jetzt = time();
		if ($user['urlaubs_modus'] == 1 && $urlaub_modus_time_soll > $time_jetzt) {
			$soll_datum = date("d.m.Y", $urlaub_modus_time_soll);
			$soll_uhrzeit = date("H:i:s", $urlaub_modus_time_soll);
			message("Vous êtes en mode vacances!<br>Le mode vacance dure jusque $soll_datum $soll_uhrzeit<br>	Ce n'est qu'après cette période que vous pouvez changer vos options.", "Mode vacance");
		}
	}
}

// ----------------------------------------------------------------------------------------------------------------
//
// Routine Test de validité d'une adresse email
//
function is_email($email) {
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i", $email));
}

// ----------------------------------------------------------------------------------------------------------------
//
// Routine Affichage d'un message administrateur avec saut vers une autre page si souhaité
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
// Routine Affichage d'un message avec saut vers une autre page si souhaité
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
// Routine d'affichage d'une page dans un cadre donné
//
// $page      -> la page
// $title     -> le titre de la page
// $topnav    -> Affichage des ressources ? oui ou non ??
// $metatags  -> S'il y a quelques actions particulieres a faire ...
// $AdminPage -> Si on est dans la section admin ... faut le dire ...
function display ($page, $title = '', $topnav = true, $metatags = '', $AdminPage = false) {
   global $link, $game_config, $debug, $user, $planetrow;

   if (!$AdminPage) {
      $DisplayPage  = StdUserHeader ($title, $metatags);
   } else {
      $DisplayPage  = AdminUserHeader ($title, $metatags);
   }

   if ($topnav) {
      $DisplayPage .= ShowTopNavigationBar( $user, $planetrow );
   }
   $DisplayPage .= "<center>\n". $page ."\n</center>\n";

   $DisplayPage .= StdFooter();
	if ($link)
	{
		mysql_close($link);
	}

   echo $DisplayPage;

   // Añadir debug si es admin y tiene el modo debug activado
   if ($user['authlevel'] == 1 || $user['authlevel'] == 3) {
      if ($game_config['debug'] == 1) $debug->echo_log();
   }

   die();
}

// ----------------------------------------------------------------------------------------------------------------
//
// Entete de page
//
function StdUserHeader ($title = '', $metatags = '') {
	global $user, $dpath, $langInfos;

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

	return $planet["field_max"] + ($planet[ $resource[33] ] * 5);
}

?>
