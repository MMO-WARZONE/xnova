<?php
$dbguests = "visitors.db";  // path to data file
$offline = 100; // average time in seconds to consider someone online before removing from the list

if(!file_exists($dbguests)) {
	die("Error: Data file " . $dbguests . " NOT FOUND!");
}

if(!is_writable($dbguests)) {
	die("Error: Data file " . $dbguests . " is NOT writable! CHMOD it to 666!");
}

function CountGuests() {
	global $dbguests, $offline;
	$currentIP = guestIP();
	$current_time = time();
	$dbarray_new = array();
	
	$dbarray = unserialize(file_get_contents($dbguests));
	if(is_array($dbarray)) {
		while(list($user_ip, $user_time) = each($dbarray)) {
			if(($user_ip != $currentIP) && (($user_time + $offline) > $current_time)) {
				$dbarray_new[$user_ip] = $user_time;
			}
		}
	}
	$dbarray_new[$currentIP] = $current_time; // add record for current user
	
	$fp = fopen($dbguests, "w");
	fputs($fp, serialize($dbarray_new));
	fclose($fp);
	
	$out = sprintf("%01d", count($dbarray_new)); // format the result to display 3 digits with leading 0's
	return $out;
}

function guestIP() {
	if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
	elseif(isset($_SERVER['REMOTE_ADDR'])) $ip = $_SERVER['REMOTE_ADDR'];
	else $ip = "0";
	return $ip;
	
}

$visitors_online = CountGuests();
?>

