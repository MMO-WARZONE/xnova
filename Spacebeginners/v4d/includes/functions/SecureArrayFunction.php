<?php
/*
 * @Copyright 2007 By psykocrash from PHPCS.COM for SecureArray()
 */




function secureArray (&$item)
    {
     if (is_array($item)) array_walk ($item, 'secureArray');
     else
    {
    $item = htmlspecialchars($item);
    $item = mysql_real_escape_string($item);
    }
    }
//if (filesize('../config.php') == 0) {
secureArray($_POST);
secureArray($_GET); 
//}

?>