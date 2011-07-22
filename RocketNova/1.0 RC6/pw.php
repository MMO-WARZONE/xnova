<?php

define('INSIDE'  , true);
define('INSTALL' , false);

$InLogin = true;

$rocketnova_root_path = './';
include($rocketnova_root_path . 'extension.inc');
include($rocketnova_root_path . 'common.' . $phpEx);


includeLang('lostpassword');
$parse = $lang;

// Generate a random password
function generatePW($length=8)
{

	$dummy = array_merge(range('0', '9'), range('a', 'z'), range('A', 'Z'), array('#','&','@','$','_','%','?','+'));
	// shuffle array

	for ($i = 1; $i <= (count($dummy)*2); $i++)
	{
		$swap = mt_rand(0,count($dummy)-1);
		$tmp = $dummy[$swap];
		$dummy[$swap] = $dummy[0];
		$dummy[0] = $tmp;
	}

	// get password
	return substr(implode('',$dummy),0,$length);

}

if(isset($_POST['submit'])) {

	$nick	= (isset($_POST['nick'])) ? mysql_real_escape_string($_POST['nick']) : '';
	$email	= (isset($_POST['email'])) ? mysql_real_escape_string($_POST['email']) : '';

	$exist	= doquery("SELECT `email_2` FROM {{table}} WHERE `email_2` = '".$email."' AND `username` = '".$nick."' LIMIT 1","users",true);

	if($exist) {

		$new_pass = generatePW(8);
		$change = doquery("UPDATE {{table}} SET `password` = '".md5($new_pass)."' WHERE `email_2` = '".$email."' AND `username` = '".$nick."' LIMIT 1","users");
		
		$to			= $email;
		$subject	= 'Setzen ihres Passworts ( '.$game_config['game_name'].' )';
		$message	= "Soeben wurde unser System dazu verwendet, ihr Passwort neu zu setzen.\r\nSollten sie eine solche Aktion nicht ausgelöst haben, wenden sie sich bitte umgehend an den Support.\r\nIhr neues Passwort lautet: ".$new_pass; 
		$From		= 'From: '.ADMINEMAIL;
		$mail		= mail($to,$subject,$message,$From);
		
		if($mail) {
			
			message($lang['mail_sent'],$lang['complete']);
			
		}else{
			
			message($lang['send_failed'],$lang['failed']);
		}
	}else{

		message($lang['not_exist'],$lang['failed']);

	}
}else{

	$parse['servername'] = $game_config['game_name'];
	$page                = parsetemplate(gettemplate('lostpassword'), $parse);

	display ($page, $lang['Title'], false);
}