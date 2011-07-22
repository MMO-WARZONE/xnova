<?php

/**
 * reg.php
 *
 * @version 1.1
 * @copyright 2008 by Chlorel for XNova
 */

define('INSIDE' , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);
define('ADMINEMAIL',"Willkommen@");
define('GAMEURL',"http://".$_SERVER['HTTP_HOST']."/");
includeLang('reg');



if ($_POST) {
    $errors = 0;
    $errorlist = "";

    $_POST['email'] = strip_tags($_POST['email']);
    if (!is_email($_POST['email'])) {
        $errorlist .= "\"" . $_POST['email'] . "\" " . $lang['error_mail'];
        $errors++;
    }

    if (!$_POST['planet']) {
        $errorlist .= $lang['error_planet'];
        $errors++;
    }

    if (preg_match("/[^A-z0-9_\-]/", $_POST['hplanet']) == 1) {
        $errorlist .= $lang['error_planetnum'];
        $errors++;
    }

    if (!$_POST['character']) {
        $errorlist .= $lang['error_character'];
        $errors++;
    }

    if (strlen($_POST['passwrd']) < 4) {
        $errorlist .= $lang['error_password'];
        $errors++;
    }

    if (preg_match("/[^A-z0-9_\-]/", $_POST['character']) == 1) {
        $errorlist .= $lang['error_charalpha'];
        $errors++;
    }

    if ($_POST['rgt'] != 'on') {
        $errorlist .= $lang['error_rgt'];
        $errors++;
    }
    // Le meilleur moyen de voir si un nom d'utilisateur est pris c'est d'essayer de l'appeler !!
    $ExistUser = doquery("SELECT `username` FROM {{table}} WHERE `username` = '" . mysql_escape_string($_POST['character']) . "' LIMIT 1;", 'users', true);
    if ($ExistUser) {
        $errorlist .= $lang['error_userexist'];
        $errors++;
    }
    // Si l'on verifiait que l'adresse email n'existe pas encore ???
    $ExistMail = doquery("SELECT `email` FROM {{table}} WHERE `email` = '" . mysql_escape_string($_POST['email']) . "' LIMIT 1;", 'users', true);
    if ($ExistMail) {
        $errorlist .= $lang['error_emailexist'];
        $errors++;
    }

    if ($_POST['sex'] != '' && $_POST['sex'] != 'F' && $_POST['sex'] != 'M') {
        $errorlist .= $lang['error_sex'];
        $errors++;
    }

    if ($errors != 0) {
        message ($errorlist, $lang['Register']);
    } else {
        $newpass = $_POST['passwrd'];
        $UserName = CheckInputStrings ($_POST['character']);
        $UserEmail = CheckInputStrings ($_POST['email']);
       // $UserPlanet = CheckInputStrings (addslashes($_POST['planet']));
		$UserPlanet     = CheckInputStrings ( $_POST['planet'] );

        $md5newpass = md5($newpass);
		
        // Creation de l'utilisateur
		
		// générer une clé
  // Initialisation des caractères utilisables
 $characters = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
$size=15;
 for($i=0;$i<$size;$i++)
 {
 $clef .= ($i%2) ? strtoupper($characters[array_rand($characters)]) : $characters[array_rand($characters)];
 }
//mise en forme du mail a envoyer
    $Name     = 'XNova';
	
   
	
	
	$headers  .= "From: $Name \n";
	
	
	
  	

	

	$subject = "Abschliessen der Registrierung";

	// Mail au format texte.
	$message_txt .= "Um ihren Account frei zu schalten benutzen sie fogenden link.
	                 Nachdem sie sich frei geschaltet haben bitte neu einloggen.
                     ".GAMEURL."XNova/reg.php?mode=valid&pseudo=$UserName&clef=$clef 
                     Ihr Spielername lautet :$UserName
                     Ihr Passwort lautet :$newpass
                     Viel Spass beim Spiel zum einloggen folgenden link benutzen.
					 ".GAMEURL."XNova/login.php ";
	

//envoyer le mail
   // ini_set ('sendmail_from', 'me@domain.com');
	mail($UserEmail, $subject, $message_txt, $headers);
	
	
//update compte provisoir
        $QryInsertUser = "INSERT INTO {{table}} SET ";
        $QryInsertUser .= "`username` = '" . mysql_escape_string(strip_tags($UserName)) . "', ";
        $QryInsertUser .= "`email` = '" . mysql_escape_string($UserEmail) . "', ";
		$QryInsertUser .= "`sex` = '" . mysql_escape_string($_POST['sex']) . "', ";
		$QryInsertUser .= "`date` = '" . time() . "', ";
	    $QryInsertUser .= "`cle` = '" . mysql_escape_string($clef) . "', ";
        $QryInsertUser .= "`password`='" . $md5newpass . "';";
        doquery($QryInsertUser, 'users_valid');
        // On cherche le numero d'enregistrement de l'utilisateur fraichement créé
        $NewUser = doquery("SELECT `id` FROM {{table}} WHERE `username` = '" . mysql_escape_string($_POST['character']) . "' LIMIT 1;", 'users_valid', true);
        $iduser = $NewUser['id'];

        $Message = $lang['thanksforregistry'];
       

        message( $Message, $lang['a_valider'], "login.".$phpEx );
    }
} else {
if($_GET['mode'] == valid){

//pseudo du mail
$pseudo=$_GET['pseudo'];
//clé du mail
$clef=$_GET['clef'];

//select de la table users_valid

            $QrySelectvalid = "SELECT * ";
            $QrySelectvalid .= "FROM {{table}} ";
            $QrySelectvalid .= "WHERE ";
            $QrySelectvalid .= "`username` = '" . $pseudo . "'";
            $A_Valider = doquery($QrySelectvalid, 'users_valid', true);
			
//on test le pseudo

// Le meilleur moyen de voir si un nom d'utilisateur est pris c'est d'essayer de l'appeler !!
    $ExistPseudo = doquery("SELECT `username` FROM {{table}} WHERE `username` = '" . mysql_escape_string($_GET['pseudo']) . "' LIMIT 1;", 'users', true);
//si tout est ok	
if($A_Valider['clef']=$_GET['clef'] && $A_Valider['username']=$_GET['pseudo'] && $A_Valider['username'] != $ExistPseudo['username']){
		$UserName = $_GET['pseudo'];
        $UserPass = CheckInputStrings ($A_Valider['password']);
        $UserMail = CheckInputStrings ($A_Valider['email']);
		$UserSex = CheckInputStrings ($A_Valider['sex']);
		
		
// Creation de l'utilisateur
        $QryInsertUser = "INSERT INTO {{table}} SET ";
        $QryInsertUser .= "`username` = '" . mysql_escape_string($UserName) . "', ";
        $QryInsertUser .= "`email` = '" . mysql_escape_string($UserMail) . "', ";
        $QryInsertUser .= "`email_2` = '" . mysql_escape_string($UserMail) . "', ";
        $QryInsertUser .= "`sex` = '" . mysql_escape_string($UserSex) . "', ";
        $QryInsertUser .= "`id_planet` = '0', ";
        $QryInsertUser .= "`register_time` = '" . time() . "', ";
        $QryInsertUser .= "`password`='" . mysql_escape_string($UserPass) . "';";
        doquery($QryInsertUser, 'users');
		
		doquery("DELETE FROM {{table}} WHERE username='$UserName' LIMIT 1;", 'users_valid');
		}else{
		message($lang['Erreur_inscription']);}
		
		// On cherche le numero d'enregistrement de l'utilisateur fraichement créé
        $Pseudo_Creer = doquery("SELECT `id` FROM {{table}} WHERE `username` = '" . mysql_escape_string($UserName) . "' LIMIT 1;", 'users', true);
        $idpseudo = $Pseudo_Creer['id'];
		
		// Recherche d'une place libre !
        $LastSettedGalaxyPos = $game_config['LastSettedGalaxyPos'];
        $LastSettedSystemPos = $game_config['LastSettedSystemPos'];
        $LastSettedPlanetPos = $game_config['LastSettedPlanetPos'];
        while (!isset($newpos_checked)) {
            for ($Galaxy = $LastSettedGalaxyPos; $Galaxy <= MAX_GALAXY_IN_WORLD; $Galaxy++) {
                for ($System = $LastSettedSystemPos; $System <= MAX_SYSTEM_IN_GALAXY; $System++) {
                    for ($Posit = $LastSettedPlanetPos; $Posit <= 4; $Posit++) {
                        $Planet = round (rand (4, 12));

                        switch ($LastSettedPlanetPos) {
                            case 1:
                                $LastSettedPlanetPos += 1;
                                break;
                            case 2:
                                $LastSettedPlanetPos += 1;
                                break;
                            case 3:
                                if ($LastSettedSystemPos == MAX_SYSTEM_IN_GALAXY) {
                                    $LastSettedGalaxyPos += 1;
                                    $LastSettedSystemPos = 1;
                                    $LastSettedPlanetPos = 1;
                                    break;
                                } else {
                                    $LastSettedPlanetPos = 1;
                                }
                                $LastSettedSystemPos += 1;
                                break;
                        }
                        break;
                    }
                    break;
                }
                break;
            }

            $QrySelectGalaxy = "SELECT * ";
            $QrySelectGalaxy .= "FROM {{table}} ";
            $QrySelectGalaxy .= "WHERE ";
            $QrySelectGalaxy .= "`galaxy` = '" . $Galaxy . "' AND ";
            $QrySelectGalaxy .= "`system` = '" . $System . "' AND ";
            $QrySelectGalaxy .= "`planet` = '" . $Planet . "' ";
            $QrySelectGalaxy .= "LIMIT 1;";
            $GalaxyRow = doquery($QrySelectGalaxy, 'galaxy', true);

            if ($GalaxyRow["id_planet"] == "0") {
                $newpos_checked = true;
            }

            if (!$GalaxyRow) {
                CreateOnePlanetRecord ($Galaxy, $System, $Planet, $Pseudo_Creer['id'], $UserPlanet, true);
                $newpos_checked = true;
            }
            if ($newpos_checked) {
                doquery("UPDATE {{table}} SET `config_value` = '" . $LastSettedGalaxyPos . "' WHERE `config_name` = 'LastSettedGalaxyPos';", 'config');
                doquery("UPDATE {{table}} SET `config_value` = '" . $LastSettedSystemPos . "' WHERE `config_name` = 'LastSettedSystemPos';", 'config');
                doquery("UPDATE {{table}} SET `config_value` = '" . $LastSettedPlanetPos . "' WHERE `config_name` = 'LastSettedPlanetPos';", 'config');
            }
        }
		
		
        // Recherche de la reference de la nouvelle planete (qui est unique normalement !
        $PlanetID = doquery("SELECT `id` FROM {{table}} WHERE `id_owner` = '" . $Pseudo_Creer['id'] . "' LIMIT 1;", 'planets', true);
        // Mise a jour de l'enregistrement utilisateur avec les infos de sa planete mere
        $QryUpdateUser = "UPDATE {{table}} SET ";
        $QryUpdateUser .= "`id_planet` = '" . $PlanetID['id'] . "', ";
        $QryUpdateUser .= "`current_planet` = '" . $PlanetID['id'] . "', ";
        $QryUpdateUser .= "`galaxy` = '" . $Galaxy . "', ";
        $QryUpdateUser .= "`system` = '" . $System . "', ";
        $QryUpdateUser .= "`planet` = '" . $Planet . "' ";
        $QryUpdateUser .= "WHERE ";
        $QryUpdateUser .= "`id` = '" . $Pseudo_Creer['id'] . "' ";
        $QryUpdateUser .= "LIMIT 1;";
        doquery($QryUpdateUser, 'users');
        // Envois d'un message in-game sympa ^^
        $from = $lang['sender_message_ig'];
        $sender = "Admin";
        $Subject = $lang['subject_message_ig'];
        $message = $lang['text_message_ig'];
        SendSimpleMessage($idpseudo, $sender, $Time, 1, $from, $Subject, $message);

        // Mise a jour du nombre de joueurs inscripts
        doquery("UPDATE {{table}} SET `config_value` = `config_value` + '1' WHERE `config_name` = 'users_amount' LIMIT 1;", 'config');
         
//message pour dire que tt c bien passé
		 message( $Message, $lang['inscription_fini'], "login.".$phpEx );
		}
    // Afficher le formulaire d'enregistrement
    $parse = $lang;
    $parse['servername'] = $game_config['game_name'];
    $page = parsetemplate(gettemplate('registry_form'), $parse);

    display ($page, $lang['registry'], false);
}
// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Version originelle
// 1.1 - Menage + rangement + utilisation fonction de creation planete nouvelle generation
?>
