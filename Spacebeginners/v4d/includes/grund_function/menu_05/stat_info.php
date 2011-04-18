<?php

includeLang('menu_05/stat');
$parse = $lang;

$dpath = (!$user["dpath"]) ? DEFAULT_SKINPATH : $user["dpath"];
$parse['dpath'] = $dpath;

$page = parsetemplate( gettemplate('stat/stat_info'), $parse );
display($page, $lang['Stat']);

?>