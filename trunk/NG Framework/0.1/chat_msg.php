<?php
/**
 * Shoutbox
 * @author e-Zobar
 * 
 * @package XNova
 * @version 1.0
 * @copyright (c) 2008 XNova Group
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

// blocking non-users
if ($IsUserChecked == false)
{
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

// The old messages are erased
$timemoment = time();
$time_1h = $timemoment - 3600;

// One selects the messages present in the base of data
$query = doquery("SELECT * FROM {{table}} ORDER BY messageid ASC", 'chat');

while ($v = mysql_fetch_object($query))
{
	$nick = htmlentities(utf8_decode($v->user));
	$msg  = htmlentities(utf8_decode($v->message));

	$pattern = array();
	$replace = array();

	// The different fonts (bold, italics, colors, etc ...)
	$pattern[] = "#\[a=(https?|ftp|news)(.+)\](.+)\[/a\]#isU";
	$replace[] = "<a href=\"$1$2\" target=\"_blank\">$3</a>";
	
	$pattern[] = "#\[b\](.+)\[/b\]#isU";
	$replace[] = "<b>$1</b>";
	
	$pattern[] = "#\[i\](.+)\[/i\]#isU";
	$replace[] = "<i>$1</i>";
	
	$pattern[] = "#\[u\](.+)\[/u\]#isU";
	$replace[] = "<u>$1</u>";
	
	$pattern[] = "#\[c=(blue|yellow|green|pink|red|orange)\](.+)\[/c\]#isU";
	$replace[] = "<font color=\"$1\">$2</font>";

	// Smileys with their shortcuts
	$pattern[] = "#:c#isU";
	$replace[] = "<img src=\"images/smileys/cry.png\" align=\"absmiddle\" title=\":c\" alt=\":c\">";
	
	$pattern[] = "#(?!http):/(?!/)#isU";
	$replace[] = "<img src=\"images/smileys/confused.png\" align=\"absmiddle\" title=\":/\" alt=\":/\">";
	
	$pattern[] = "#o0#isU";
	$replace[] = "<img src=\"images/smileys/dizzy.png\" align=\"absmiddle\" title=\"o0\" alt=\"o0\">";
	
	$pattern[] = "#\^\^#isU";
	$replace[] = "<img src=\"images/smileys/happy.png\" align=\"absmiddle\" title=\"^^\" alt=\"^^\">";
	
	$pattern[] = "#:D#isU";
	$replace[] = "<img src=\"images/smileys/lol.png\" align=\"absmiddle\" title=\":D\" alt=\":D\">";
	
	$pattern[] = "#:\|#isU";
	$replace[] = "<img src=\"images/smileys/neutral.png\" align=\"absmiddle\" title=\":|\" alt=\":|\">";
	
	$pattern[] = "#:\)#isU";
	$replace[] = "<img src=\"images/smileys/smile.png\" align=\"absmiddle\" title=\":)\" alt=\":)\">";
	
	$pattern[] = "#:o#isU";
	$replace[] = "<img src=\"images/smileys/omg.png\" align=\"absmiddle\" title=\":o\" alt=\":o\">";
	
	$pattern[] = "#:p#isU";
	$replace[] = "<img src=\"images/smileys/tongue.png\" align=\"absmiddle\" title=\":p\" alt=\":p\">";
	
	$pattern[] = "#:\(#isU";
	$replace[] = "<img src=\"images/smileys/sad.png\" align=\"absmiddle\" title=\":(\" alt=\":(\">";
	
	$pattern[] = "#;\)#isU";
	$replace[] = "<img src=\"images/smileys/wink.png\" align=\"absmiddle\" title=\";)\" alt=\";)\">";
	
	$pattern[] = "#:s#isU";
	$replace[] = "<img src=\"images/smileys/shit.png\" align=\"absmiddle\" title=\":s\" alt=\":s\">";
	
	$pattern[] = "#xnova#";
	$replace[] = "<a href=\"http://project.xnova.es/\">XNova</a>"; // xnova.fr dont work

	$msg = preg_replace($pattern, $replace, $msg);

	// Message
	$msg = "<div align=left>{$nick}&#62;{$msg}<br></div>";
	echo stripslashes($msg);
}

?>
