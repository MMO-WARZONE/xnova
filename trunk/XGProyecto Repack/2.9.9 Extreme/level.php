<?php

/*
_   \ /\ / /\ ´¯|¯` |_¯ |¯¯) |_¯ |_¯| /\  |¯¯ |_¯    _
¯   \/ \/ /--\  |   |__ |¯¯\ __| |   /--\ |__ |__    ¯

 @copyright:
Copyright (C) 2008 - 2010 By 5aMu and Think.-

- Proyect based in XRV, which is based in XGProyect -
*/

if(!defined('INSIDE')){ die(header("location:../../"));}

    $showmsg = 0;
$qrylevel = doquery("SELECT dmlevel FROM {{table}} WHERE `id` = '{$user['id']}'", 'users', true);
$parse['dmlevel'] = $qrylevel ['dmlevel'];

display(parsetemplate(gettemplate('level'), $parse));

?>
