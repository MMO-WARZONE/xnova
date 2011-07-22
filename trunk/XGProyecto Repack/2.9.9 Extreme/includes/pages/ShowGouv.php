
<?php

##############################################################################
# *                                                                             #
# * XG PROYECT                                                                 #
# *                                                                           #
# * @copyright Copyright (C) 2008 - 2009 By lucky from Xtreme-gameZ.com.ar     #
# *                                                                             #
# *                                                                             #
# *  This program is free software: you can redistribute it and/or modify    #
# *  it under the terms of the GNU General Public License as published by    #
# *  the Free Software Foundation, either version 3 of the License, or       #
# *  (at your option) any later version.                                     #
# *                                                                             #
# *  This program is distributed in the hope that it will be useful,         #
# *  but WITHOUT ANY WARRANTY; without even the implied warranty of             #
# *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the             #
# *  GNU General Public License for more details.                             #
# *                                                                             #
##############################################################################

if(!defined('INSIDE')){ die(header("location:../../"));}

function ShowGouv($user)
{
    global $dpath, $lang;  

    includeLang('INGAME');
    
    $mode = $_GET['mode'];

    if ($_POST && $mode == "change") {
        $iduser = $user["id"];
        $SetSort  = intval($_POST['settings_sort']);
    
        if ($user['staatsform'] < 1) {
            doquery("UPDATE {{table}} SET `staatsform` = '.$SetSort.'    WHERE `id` = '.$iduser.' LIMIT 1", 'users');
            message($lang['erfolgreichestaatsformwahl'], $lang['Staatsform']);
            dispay(gettemplate('staatsform_confirm'), 'Confirmation', false);
        } else {

        message ($lang['badstaatsformwahl'], $lang['Staatsform']);
    }
    } else {
        $parse = $lang;
        $parse['dpath'] = $dpath;

        $parse['staatsformeins']   = "<option value =\"1\"". (($user['staatsform'] == 1) ? " selected": "") .">". $lang['barbarisch'] ."</option>";
        $parse['staatsformeins']  .= "<option value =\"2\"". (($user['staatsform'] == 2) ? " selected": "") .">". $lang['demokratie'] ."</option>";
        $parse['staatsformeins']  .= "<option value =\"3\"". (($user['staatsform'] == 3) ? " selected": "") .">". $lang['monarchie'] ."</option>";
        $parse['staatsformeins']  .= "<option value =\"4\"". (($user['staatsform'] == 4) ? " selected": "") .">". $lang['diktatur'] ."</option>";
        $parse['staatsformeins']  .= "<option value =\"5\"". (($user['staatsform'] == 5) ? " selected": "") .">". $lang['imperialisme'] ."</option>";
        $parse['staatsformeins']  .= "<option value =\"6\"". (($user['staatsform'] == 6) ? " selected": "") .">". $lang['aristocratie'] ."</option>";

        display(parsetemplate(gettemplate('staatsform_body'), $parse), 'Gouvernement', false);
    }
}
?> 
