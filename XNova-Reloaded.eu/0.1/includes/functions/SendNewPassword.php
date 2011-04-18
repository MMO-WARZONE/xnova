<?php

/**
 * SendNewPassword.php
 *
 * @version 1.1
 */



  function sendnewpassword($mail){
	global $DB, $game_config, $lang;
	$Query = $DB->prepare("SELECT `username`, `email` FROM ".PREFIX."users WHERE `email` = :email;");
	$Query->bindParam(":email", $mail);
	$Query->execute();
	$ExistMail = $Query->fetch();

    if (!$ExistMail['email'])	{
	   message('Es exisitiert kein User mit dieser E-Mail Adresse','Error');
	}

	else{
	//Caractere qui seront contenus dans le nouveau mot de passe
	$length	= "6";
	$strength = "4";
    $vowels = 'aeuy';
	$consonants = 'bdghjmnpqrstvz';
	if ($strength & 1) {
		$consonants .= 'BDGHJLMNPQRSTVWXZ';
	}
	if ($strength & 2) {
		$vowels .= "AEUY";
	}
	if ($strength & 4) {
		$consonants .= '23456789';
	}
	if ($strength & 8) {
		$consonants .= '@#$%';
	}
 
	$password = '';
	$alt = time() % 2;
	for ($i = 0; $i < $length; $i++) {
		if ($alt == 1) {
			$password .= $consonants[(rand() % strlen($consonants))];
			$alt = 0;
		} else {
			$password .= $vowels[(rand() % strlen($vowels))];
			$alt = 1;
		}
	}
	
	$from = trim($from);

	if(!$from) {
		$from = ADMINEMAIL;
	}


    //Et un nouveau mot de passe tout chaud ^^

    //On va maintenant l'envoyer au destinataire
    	$header  = 'MIME-Version: 1.0' . "\r\n";
		$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

		$header .= 'From: '.$game_config['game_name'].' <'.$from.'>' . "\r\n";
		$body = "Hallo <b>".$ExistMail['username']."!</b><br>
		Du hast ein neues Passwort f&uuml;r das Spiel <b>".$game_config['game_name']."</b> angefordert.<br />
		Dein neues Passwort lautet: <b>".$password."</b><br>
		Es ist jetzt g&uuml;ltig!<br />
		Viel Spa&szlig; w&uuml;nscht dir<br />
		Dein ".$game_config['game_name']."-Team";

    mail($mail,$lang['lostpw_email_title'],$body, $header);

    //Email envoyé, maintenant place au changement dans la BDD

    $NewPassSql = md5($password);
	$Query2 = $DB->prepare("UPDATE ".PREFIX."users SET `password` = '".$NewPassSql."' WHERE `email` = :email;");
	$Query2->bindParam(":email", $mail);
	$Query2->execute();
    }
}
?>