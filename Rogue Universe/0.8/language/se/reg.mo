<?php

if (!defined('INSIDE')) {
	die("attemp hacking");
}

// Registration form
$lang['registry']          = 'Registrering';
$lang['form']              = 'Formulär';
$lang['Register']          = 'Registrering';
$lang['Undefined']         = '- Välj -';
$lang['Male']              = 'Man';
$lang['Female']            = 'Kvinna';
$lang['Multiverse']        = 'SuperNova';
$lang['E-Mail']            = 'E-postadress';
$lang['MainPlanet']        = 'Namn på Hemplanet';
$lang['GameName']          = 'Användarnamn(Utan mellanslag!)';
$lang['Sex']               = 'Kön';
$lang['accept']            = 'Jag accepterar reglerna';
$lang['signup']            = ' Registrera ';
$lang['neededpass']        = 'Lösenord';

// Send
$lang['mail_welcome']	  = '<table width="100%" height="100%" bgcolor="Black" border="1">';
$lang['mail_welcome']	 .= '<tr valign="top">';
$lang['mail_welcome']	 .= '<td valign="top">';
$lang['mail_welcome']	 .= '<center>';
$lang['mail_welcome']	 .= '<img src="http://ru.syndiga.com/images/header.png" alt="Rogue Universe" /><br />';
$lang['mail_welcome']	 .= '<table width="532" height="220"><tr><td background="http://ru.syndiga.com/images/box.png" align="center" valign="top">';
$lang['mail_welcome']	 .= '<font color="White"><br /><br /><br />';
$lang['mail_welcome']	 .= 'Tack för att du registrerade dig hos Rogue Universe.<br /><br />';
$lang['mail_welcome']	 .= 'Ditt användarnamn är: {UserName}<br />';
$lang['mail_welcome']	 .= 'Ditt lösenord är:	   {password}<br /><br />';
$lang['mail_welcome']	 .= 'Lycka till och ha det trevligt!<br /><a href="http://ru.syndiga.com/" target="_new"><font color="White">Logga in</font></a>';
$lang['mail_welcome']	 .= '</font>';
$lang['mail_welcome']	 .= '</td></tr></table>';
$lang['mail_welcome']	 .= '</center>';
$lang['mail_welcome']	 .= '</td>';
$lang['mail_welcome']	 .= '</tr>';
$lang['mail_welcome']	 .= '</table>';

// Errors
$lang['error_mail']        = 'Ogiltig e-post !<br />';
$lang['error_planet']      = 'Fel i planetnamnet!.<br />';
$lang['error_hplanetnum']  = 'Du kan enbart använda alfanumeriska tecken i planetnamnet!<br />';
$lang['error_character']   = 'Fel i användarnamnet!<br />';
$lang['error_charalpha']   = 'Du kan enbart använda alfanumeriska tecken (mellanslag tillåts ej)!<br />';
$lang['error_password']    = 'Lösenordet måste innehålla minst 4 tecken!<br />';
$lang['error_rgt']         = 'Du måste acceptera reglerna.<<br />';
$lang['error_userexist']   = 'Användarnamnet finns redan!<br />';
$lang['error_emailexist']  = 'E-postadressen finns redan registrerad i databasen!<br /><BR><BR><a href="index.php">Klicka för att logga in</a>';
$lang['error_sex']         = 'Du måste välja kön!<br />';
$lang['error_mailsend']    = 'Ett fel inträffade när lösenordet skickades! Ditt lösenord är: ';
$lang['reg_welldone']      = 'Du har registrerats!';
$lang['error_captcha']     = 'Du har fyllt i captcha felaktigt! ';
?>