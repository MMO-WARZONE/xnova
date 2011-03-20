<?php

if (!defined('INSIDE')) {
	die("attemp hacking");
}

// Registration form
$lang['registry']          = 'Rejestracja';
$lang['form']              = 'Formularz';
$lang['Register']          = 'XNova Rejestracja';
$lang['Undefined']         = 'Wybierz';
$lang['Male']              = 'Mężczyzna';
$lang['Female']            = 'Kobieta';
$lang['Multiverse']        = 'XNova';
$lang['E-Mail']            = 'Adres e-Mail';
$lang['MainPlanet']        = 'Nazwa Planety';
$lang['GameName']          = 'Nick';
$lang['Sex']               = 'Płeć';
$lang['accept']            = 'Akceptuje REGULAMIN';
$lang['signup']            = ' Rejestracja ';
$lang['neededpass']        = 'Hasło';

// Send
$lang['mail_welcome']      = 'Dziekujemy za rejestracje w naszej grze!!!
Aby się zalogować wejdź tu: ({gameurl})
Twoje hasło : {password}
Kod Aktywacyjny : {gameurl}active.php?user={kod}
Zapraszamy!! {gameurl}';

$lang['mail_title']        = 'Rejestracja';
$lang['thanksforregistry'] = 'Dziękujemy za rejestracje!! Na podany mail zostało podesłane hasło :) Pozdro.';

// Errors
$lang['error_mail']        = 'Niepoprawny E-mail!<br />';
$lang['error_planet']      = 'Błędna nazwa planety !.<br />';
$lang['error_hplanetnum']  = 'Musisz używać alfanumerycznych znaków do rejestracji !<br />';
$lang['error_character']   = 'Niepoprawna nazwa gracza !<br />';
$lang['error_charalpha']   = 'Musisz używać alfanumerycznych znaków dla nazwy gracza !<br />';
$lang['error_password']    = 'Hasło misi mieć co najmniej 4 znaki !<br />';
$lang['error_rgt']         = 'Musisz zaakceptowac regulamin.<<br />';
$lang['error_userexist']   = 'Ta nazwa gracza już istnieje !<br />';
$lang['error_emailexist']  = 'Taki email jest już zarejestrowany !<br />';
$lang['error_sex']         = 'Błąd z płcią!<br />';
$lang['error_mailsend']    = 'Mail nie został wysłany!! twoje hasło to : ';
$lang['reg_welldone']      = 'Rejestracja zakończona poprawnie!!!';

?>