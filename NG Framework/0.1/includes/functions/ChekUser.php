<?php

/**
 * CheckUser.php
 *
 * @version 1.0
 * @copyright 2008 By Chlorel for XNova
 */

function CheckTheUser ( $IsUserChecked ) {
	global $user;

	$Result        = CheckCookies( $IsUserChecked );
	$IsUserChecked = $Result['state'];

	if ($Result['record'] != false) {
		$user = $Result['record'];
		if ($user['bana'] == "1") {
			die (
			'Vous avez &eacute;t&eacute; bannis. Plus D\'infos <a href="banned.php">ici</a>.'
			);
		}
		$RetValue['record'] = $user;
		$RetValue['state']  = $IsUserChecked;
	} else {
		$RetValue['record'] = array();
		$RetValue['state']  = false;
	}

	return $RetValue;
}


?>