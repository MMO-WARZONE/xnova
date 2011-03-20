<?php
//version 1
function ShowLogAdmin( $CurrentUser )
{
	global $db, $lang,$displays;

	if ($CurrentUser['authlevel'] < 3) die($displays->message ($lang['not_enough_permissions']));

        echo file_get_contents("includes/log.txt");
}
?>
