<?php

/**
  * changelog.php
  * @Licence GNU (GPL)
  * @version 1.0
  * @copyright 2009
  * @Team Space Beginner
  *
  **/

includeLang('changelog');

$template = gettemplate('changelog/changelog_02');

foreach($lang['changelog'] as $a => $b) {
    $parse['version_number'] = $a;
    $parse['dpath'] = $dpath;
    $parse['name'] = $game_config['game_name'];
    $parse['description'] =($b);
    $body .= parsetemplate($template, $parse);
}

$parse = $lang;
$parse['dpath'] = $dpath;
$parse['body'] = $body;
$parse['name'] = $game_config['game_name'];

$page .= parsetemplate(gettemplate('changelog/changelog_01'), $parse);

display($page,$lang['tab']);

?>