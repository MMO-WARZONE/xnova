<?php

/**
 * index.php
 *
 * @version 1.0
 * @copyright 2008 by e-Zobar for XNova
 */


if (filesize('config.php') == 0) {
	header('location: install/');
	exit();
}
			elseif (file_exists('install/')){
		header('location: login.php');
	    exit();
		
		} else { 
		header('location: login.php');
	    exit();
	   }
		


// -----------------------------------------------------------------------------------------------------------
// History version
// 1.0 - Creation avec redirection vers l'installeur si pas de config.php
// 1.1 - D&eacute;t&eacute;ction du dossier install, si pr&eacute;sent, peut pas continuer
?>