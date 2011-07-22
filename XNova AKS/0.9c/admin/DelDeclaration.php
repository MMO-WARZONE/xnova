<?php

    /**
    * DelDeclaration.php
    *
    * @version 1.0
    * @copyright 2008 By IGalaxy for XNova
    */

    define('INSIDE'  , true);
    define('INSTALL' , false);

    $xnova_root_path = './../';
    include($xnova_root_path . 'extension.inc');
    include($xnova_root_path . 'common.' . $phpEx);

    includeLang('overview');



    extract($_GET);
    if (isset($delete)) {


    doquery("DELETE FROM {{table}} WHERE `declarator_name` = '".$delete."';", 'declared');
       
                Message("Les d&eacute;clarations de ".$delete." ont &eacute;t&eacute; supprim&eacute;es avec succ&egrave;.<br><a href=\"declare_list.php\">Retour</a>.");


    } elseif ($deleteall == 'yes') {
            doquery("TRUNCATE TABLE {{table}}", 'declared');
        }


    ?>