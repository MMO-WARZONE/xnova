<?php

/**
 * chat_msg.php
 *
 * @version 1.0
 * @copyright 2008 by e-Zobar for XNova
 * �berarbeitet by kleinerzwerg
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);

// On efface les anciens messages
$timemoment=time();
$time_1h=$timemoment - 3600;

// On selectionne les messages présents dans la base de donnée
$query = doquery("SELECT * FROM {{table}} ORDER BY messageid ASC", "chat");
while($v=mysql_fetch_object($query)){
	$nick=htmlentities(utf8_decode($v->user));
	$msg=htmlentities(utf8_decode($v->message));
	$time=($v->timestamp);

	// Les différentes polices (gras, italique, couleurs, etc...)
	$msg=preg_replace("#\[a=(ft|https?://)(.+)\](.+)\[/a\]#isU", "<a href=\"$1$2\" target=\"_blank\">$3</a>", $msg);
	$msg=preg_replace("#\[b\](.+)\[/b\]#isU","<b>$1</b>",$msg);
	$msg=preg_replace("#\[i\](.+)\[/i\]#isU","<i>$1</i>",$msg);
	$msg=preg_replace("#\[u\](.+)\[/u\]#isU","<u>$1</u>",$msg);
	$msg=preg_replace("#\[c=(blue|yellow|green|pink|red|orange|lime)\](.+)\[/c\]#isU","<font color=\"$1\">$2</font>",$msg);

	// Les smileys avec leurs raccourcis
	$msg=preg_replace("#:c#isU","<img src=\"images/smileys/cry.png\" align=\"absmiddle\" title=\":c\" alt=\":c\">",$msg);
	$msg=preg_replace("#:/#isU","<img src=\"images/smileys/confused.png\" align=\"absmiddle\" title=\":/\" alt=\":/\">",$msg);
	$msg=preg_replace("#o0#isU","<img src=\"images/smileys/dizzy.png\" align=\"absmiddle\" title=\"o0\" alt=\"o0\">",$msg);
	$msg=preg_replace("#\^\^#isU","<img src=\"images/smileys/happy.png\" align=\"absmiddle\" title=\"^^\" alt=\"^^\">",$msg);
	$msg=preg_replace("#:D#isU","<img src=\"images/smileys/lol.png\" align=\"absmiddle\" title=\":D\" alt=\":D\">",$msg);
	$msg=preg_replace("#:\|#isU","<img src=\"images/smileys/neutral.png\" align=\"absmiddle\" title=\":|\" alt=\":|\">",$msg);
	$msg=preg_replace("#:\)#isU","<img src=\"images/smileys/smile.png\" align=\"absmiddle\" title=\":)\" alt=\":)\">",$msg);
	$msg=preg_replace("#:o#isU","<img src=\"images/smileys/omg.png\" align=\"absmiddle\" title=\":o\" alt=\":o\">",$msg);
	$msg=preg_replace("#:p#isU","<img src=\"images/smileys/tongue.png\" align=\"absmiddle\" title=\":p\" alt=\":p\">",$msg);
	$msg=preg_replace("#:\(#isU","<img src=\"images/smileys/sad.png\" align=\"absmiddle\" title=\":(\" alt=\":(\">",$msg);
	$msg=preg_replace("#;\)#isU","<img src=\"images/smileys/wink.png\" align=\"absmiddle\" title=\";)\" alt=\";)\">",$msg);
	$msg=preg_replace("#wow#isU","<img src=\"images/smileys/wow.png\" align=\"absmiddle\" title=\"wow\" alt=\"wow\">",$msg);
	$msg=preg_replace("#cool#isU","<img src=\"images/smileys/cool.png\" align=\"absmiddle\" title=\"cool\" alt=\"cool\">",$msg);
	$msg=preg_replace("#grrr#isU","<img src=\"images/smileys/grrr.png\" align=\"absmiddle\" title=\"grrr\" alt=\"grrr\">",$msg);
	$msg=preg_replace("#:s#isU","<img src=\"images/smileys/shit.png\" align=\"absmiddle\" title=\":s\" alt=\":s\">",$msg);
	$msg=preg_replace("#xnova#","<a href=\"http://www.xorbit.de\">XOrbit</a>",$msg);
	$msg=preg_replace("#forum#","<a href=\"http://forum.xorbit.de\">Forum</a>",$msg);

	// Affichage du message
	$msg="<div align=\"left\"> ".date('d.m', $time).", ".date('H\:i', $time)."|".$nick." > ".$msg."<br></div>";
	print stripslashes($msg);
}

// Shoutbox by e-Zobar - Copyright XNova Team 2008
?>
