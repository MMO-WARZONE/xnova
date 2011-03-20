<?php

function CheckTheUser ( $IsUserChecked ) {
	global $user;

	$Result        = CheckCookies( $IsUserChecked );
	$IsUserChecked = $Result['state'];

	if ($Result['record'] != false) {
		$user = $Result['record'];
		if ($user['bana'] == "1") {
			die (
			'Du är bannlyst på servern. <a href="login.php">Återgå</a>.'
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