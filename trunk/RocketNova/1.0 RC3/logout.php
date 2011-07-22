<?php

/**
 * logout.php
 * 
 * @version 1.0 
 */ 

$_SESSION = array();
session_write_close();
$uri = 'http://' . $_SERVER['SERVER_NAME'] . dirname($_SERVER['SCRIPT_NAME']);
header('Location: ' . $uri);
exit;

?>