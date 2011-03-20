<?php

if (!defined('INSIDE')) {
	die("attemp hacking");
}

// Registration form
$lang['registry']          = 'Registration';
$lang['form']              = 'Form';
$lang['Register']          = 'Registration';
$lang['Undefined']         = '- please select -';
$lang['Male']              = 'Male';
$lang['Female']            = 'Female';
$lang['Multiverse']        = 'SuperNova';
$lang['E-Mail']            = 'E-mail address';
$lang['MainPlanet']        = 'Homeplanet name';
$lang['GameName']          = 'Username(without spaces!)';
$lang['Sex']               = 'Gender';
$lang['accept']            = 'I accept license agreement';
$lang['signup']            = ' Register ';
$lang['neededpass']        = 'password';

// Send
$lang['mail_welcome']	  = '<table width="100%" height="100%" bgcolor="Black" border="1">';
$lang['mail_welcome']	 .= '<tr valign="top">';
$lang['mail_welcome']	 .= '<td valign="top">';
$lang['mail_welcome']	 .= '<center>';
$lang['mail_welcome']	 .= '<img src="http://darkevo.org/images/header.jpg" alt="my.site.com" /><br />';
$lang['mail_welcome']	 .= '<table width="532" height="220"><tr><td background="http://darkevo.org/images/box.jpg" align="center" valign="top">';
$lang['mail_welcome']	 .= '<font color="White"><br /><br /><br />';
$lang['mail_welcome']	 .= 'Thank you for signing up for Rogue Universe.<br /><br />';
$lang['mail_welcome']	 .= 'Your username is: {UserName}<br />';
$lang['mail_welcome']	 .= 'Your password is: {password}<br /><br />';
$lang['mail_welcome']	 .= 'Good luck!<br /><a href="http://your.site.com/" target="_new"><font color="White">Login</font></a>';
$lang['mail_welcome']	 .= '</font>';
$lang['mail_welcome']	 .= '</td></tr></table>';
$lang['mail_welcome']	 .= '</center>';
$lang['mail_welcome']	 .= '</td>';
$lang['mail_welcome']	 .= '</tr>';
$lang['mail_welcome']	 .= '</table>';

// Errors
$lang['error_mail']        = 'Invalid e-mail !<br />';
$lang['error_planet']      = 'Error in the name of your planet!.<br />';
$lang['error_hplanetnum']  = 'You must use alphanumeric characters for your planet name!<br />';
$lang['error_character']   = 'Error in the name of the player!<br />';
$lang['error_charalpha']   = 'Username must have alphanumeric characters (spaces not allowed)!<br />';
$lang['error_password']    = 'The password should be at least 4 characters!<br />';
$lang['error_rgt']         = 'You must accept the conditions of use.<<br />';
$lang['error_userexist']   = 'Username already exist!<br />';
$lang['error_emailexist']  = 'That e-mail was already registred in our system !<br /><BR><BR><a href="index.php">Click here to login</a>';
$lang['error_sex']         = 'You must chose sex !<br />';
$lang['error_mailsend']    = 'An error occurred when sending email! Your password is: ';
$lang['reg_welldone']      = 'Registration complete !';
?>