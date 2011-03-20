<?php

/**
 * credit.php
 *
 * @version 1.0
 * @copyright 2008 by e-Zobar for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$xnova_root_path = './';
include($xnova_root_path . 'extension.inc');
include($xnova_root_path . 'common.' . $phpEx);

        includeLang('credit');

if ($user['urlaubs_modus'] == 1){
includeLang('fehler');
message($lang['Urlaub01'], $lang['Urlaub02']);
}

        $parse = $lang;

        if ($game_config['ExtCopyFrame'] == '1') {
                $parse['ExtCopyFrame'] = "<tr><td colspan=\"2\" class=\"c\">". $lang['cred_ext'] ."</td></tr><tr><th>". nl2br($game_config['ExtCopyOwner']) ."</th><th>". nl2br($game_config['ExtCopyFunct']) ."</th></tr>";
        }

        $BodyTPL = gettemplate('credit_body');

        $page = parsetemplate($BodyTPL, $parse);
        display($page, $lang['cred_credit']);

?>