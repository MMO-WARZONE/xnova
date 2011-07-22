<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$rocketnova_root_path = './../';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.'.$phpEx);

	$raportrow = doquery("SELECT * FROM {{table}} WHERE `rid` = '". $_GET["raport"] ."';",'rw', true);
	$Page  = "<html>";
	$Page .= "<head>";
	$Page .= "<link rel=\"stylesheet\" type=\"text/css\" href=\"". $dpath ."formate.css\">";
	$Page .= "<meta http-equiv=\"content-type\" content=\"text/html; charset=iso-8859-2\" />";
	$Page .= "</head>";
	$Page .= "<body>";
	$Page .= "<center>";
	$Page .= "<table width=\"99%\">";
	$Page .= "<tr>";
	$Page .= "<td>". stripslashes( $raportrow["raport"] ) ."</td>";
	$Page .= "</tr>";
	$Page .= "</table>";
	$Page .= "</center>";
	$Page .= "</body>";
	$Page .= "</html>";
	echo $Page;

?>