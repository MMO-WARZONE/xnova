<?php

/******************************************
**            Oasis Rage 2.0             **
**             by darkOasis              **
**                                       **
**  special thanks to the developers of  **
**    XNova, Ugamela and RageOnline      **
**                                       **
** chat_msg.php                          **
******************************************/

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

$timemoment=time();
$time_1h=$timemoment - 3600;

$query = doquery("SELECT * FROM {{table}} ORDER BY messageid ASC", "chat");
while($v=mysql_fetch_object($query)){
	$nick=htmlentities($v->user);
	$msg=htmlentities($v->message);

	$msg=preg_replace("#\[a=(ft|https?://)(.+)\](.+)\[/a\]#isU", "<a href=\"$1$2\" target=\"_blank\">$3</a>", $msg);
	$msg=preg_replace("#\[b\](.+)\[/b\]#isU","<b>$1</b>",$msg);
	$msg=preg_replace("#\[i\](.+)\[/i\]#isU","<i>$1</i>",$msg);
	$msg=preg_replace("#\[u\](.+)\[/u\]#isU","<u>$1</u>",$msg);
	$msg=preg_replace("#\[c=(blue|yellow|green|pink|red|orange)\](.+)\[/c\]#isU","<font color=\"$1\">$2</font>",$msg);
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
	$msg=preg_replace("#:s#isU","<img src=\"images/smileys/shit.png\" align=\"absmiddle\" title=\":s\" alt=\":s\">",$msg);
	$msg=preg_replace("#xnova#","<a href=\"http://www.xnova.fr\">XNova</a>",$msg);
	$msg="<div align=\"left\">".$nick." > ".$msg."<br></div>";
	print stripslashes($msg);
}

/******************************************************************************************
**                                    Revision Notes                                     **
**  @ Official OasisRage 2.0 release - May 2009 - darkOasis                              **
**  @ (please note any changes you make to the source code)                              **
**  @                                                                                    **
**                                                                                       **
******************************************************************************************/

?>