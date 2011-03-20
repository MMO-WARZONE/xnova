<?php
$lang['adm_clean_title']		= "Bereinigung von Fehlern in den Datenbanktabellen User, Planeten und Galaxy";
$lang['adm_clean_explain']		= "Dieses Script &uuml;berpr&uuml;ft die Datenbanktabellen und abh&auml;ngig vom Ergebnis der &Uuml;berpr&uuml;fung w&auml;hlt es die Art der Bereinigung aus.<br> Die m&ouml;glichen Arten sind:<br>-1 Intelligente Bereinigung<br>-2 Vollst&auml;ndige Bereinigung<br> Bei der intelligenten Bereinigung sind Speicherbedarf und Laufzeit niedrig, bei der vollst&auml;ndigen Bereinigung sind Speicherbedarf und Laufzeit h&ouml;her und es ist m&ouml;glich, dass der Server das Script wegen Timeout abbricht. Das kann im schlimmsten Fall zur Zerst&ouml;rung der Datenbank f&uuml;hren!<br>Vor der Ausf&uuml;hrung des Scripts ist es deshalb zu empfehlen, ein Backup der Datenbank durchzuf&uuml;hren.<br><br>Soll das Script ausgef&uuml;hrt werden?"; 
$lang['adm_clean']				= "Bereinigung";
$lang['adm_deleted_users']		= "Gel&ouml;schte User: %u <br> User-ID der gel&ouml;schten User sind:<br> %iu<br>";
$lang['adm_deleted_planets']	= "Gel&ouml;schte Planeten: %p <br>PLaneten-ID der gel&ouml;schten Planeten sind:<br> %ip<br>";
$lang['adm_deleted_galaxy']		= "Gel&ouml;schte Galaxy-Eintr&auml;ge: %g <br> Gel&ouml;schte Galaxie-Eintr&auml;ge sind:<br> %ig<br>";
$lang['adm_time']               = "Laufzeit des Scripts: %ti<br>";
$lang['adm_i_mem']              = "Speicher vor Ausf&uuml;hrung des Scripts: %mi/%mti<br>";
$lang['adm_e_mem']              = "Speicher nach Ausf&uuml;hrung des Scripts: %me/%mte<br>";
$lang['adm_succes']             = "Ausf&uuml;hrung erfolgreich!<br>";
$lang['adm_del_title']          = "Entfernung von ungenutzten ID's";
?>