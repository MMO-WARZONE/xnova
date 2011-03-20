<?php

if (filesize('config.php') == 0) {
	header('location: install/');
	exit();
}

header('location: login.php');

// -----------------------------------------------------------------------------------------------------------

?>